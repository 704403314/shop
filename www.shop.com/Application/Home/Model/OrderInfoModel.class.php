<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16-5-25
 * Time: 下午4:08
 */

namespace Home\Model;


use Think\Model;

/**
 * Class OrderModel
 * @package Home\Model
 */
class OrderInfoModel extends Model{
    public $statuses = [
        '0'=>'已取消',
        '1'=>'待付款',
        '2'=>'待发货',
        '3'=>'待收货',
        '4'=>'完成',
    ];

    /**
     * 获取订单信息
     */
    public function getOrderInfo(){
        $user_info = login();
        $rows = $this->where(['member_id'=>$user_info['id']])->order('id DESC')->select();

        $model = M('OrderInfoItem');

        //
        foreach($rows as &$row){

            // 获取订单详细信息
            $goods_list = $model->field('goods_id,goods_name,logo')->where(['order_info_id'=>$row['id']])->select();

            $row['goods_list'] = $goods_list;


        }

        //dump($rows);exit;
        return $rows;

    }

    /**
     * 添加订单
     */
    public function addOrder(){
        $user_info = login();
//        dump(I('post.'));exit;
        $this->data['member_id']=$user_info['id'];
        // 获取地址信息
        $address_info = D('Address')->getAddressInfo(I('post.address_id'));
//        dump(I('post.'));exit;
        // 保存地址信息
        $this->data['name'] = $address_info['name'];
        $this->data['province_name'] = $address_info['province_name'];
        $this->data['city_name'] = $address_info['city_name'];
        $this->data['area_name'] = $address_info['area_name'];
        $this->data['detail_address'] = $address_info['detail_address'];
        $this->data['tel'] = $address_info['tel'];

        // 获取送货方式信息
        $delivery_info = M('Delivery')->field('name,price')->where(['id'=>$this->data['delivery_id']])->find();
        // 保存送货方式信息
        $this->data['delivery_name'] = $delivery_info['name'];
        $this->data['delivery_price'] = $delivery_info['price'];

        // 获取支付信息
        $payment_info = M('Payment')->field('name')->where(['id'=>$this->data['pay_type_id']])->find();
        $this->data['payment_name'] = $payment_info['name'];

        // 获取购物车信息
        $cart_list = D('Cart')->getCartList();
        $this->data['price'] = $cart_list['total_price'];
        $this->data['status'] = 1;
        $this->data['inputtime'] = NOW_TIME;
        //dump($this->data);exit;
        // 开启事务
        $this->startTrans();
        // 添加订单基本信息
        if(($order_id=$this->add()) === false){
            $this->error = '添加订单基本信息失败';
            $this->rollback();
            return false;
        }


        // 2.添加订单详细信息
          $order_list = [];
        foreach($cart_list['goods_list'] as $goods){
            $goods['order_info_id'] = $order_id;
            $goods['goods_id'] = $goods['id'];
            unset($goods['id']);
            $goods['goods_name'] = $goods['name'];
            unset($goods['name']);
            $goods['price'] = $goods['shop_price'];
            unset($goods['shop_price']);
            $goods['total_price'] = $goods['sub_total'];
            unset($goods['sub_total']);
            $order_list[] = $goods;
        }

        if(M('OrderInfoItem')->addAll($order_list) === false){
            $this->error = '添加订单详细信息失败';
            $this->rollback();
            return false;
        }
        // 3.添加发票信息

        // 获取发票抬头信息
        $invoice_info = [];
        if(I('post.invoice_type') == 2){
             $invoice_info['name'] = I('post.invoice_name');
        }else{
            $invoice_info['name'] = $address_info['name'];
        }
        // 获取发票内容类型
        $invoice_content_type = I('post.invoice_content');
        $invoice_info['content'] = '';
        switch($invoice_content_type){
            case 1:

                foreach($cart_list['goods_list'] as $goods){
                    $invoice_info['content'] .= $goods['name'] ."\t". $goods['shop_price'] ."\tx\t".
                        $goods['amount'] ."\t". $goods['sub_total'] ."\r\n";
                }
                break;
            case 2:
                $invoice_info['content'] .=  "办公用品\r\n";
                break;
            case 3:
                $invoice_info['content'] .=  "体育用品\r\n";
                break;
            case 4:
                $invoice_info['content'] .=  "耗材\r\n";
                break;
        }

        $invoice_info['content'] = $invoice_info['name'] ."\r\n".  $invoice_info['content']."总计".$cart_list['total_price'];
        $invoice_info['price'] = $cart_list['total_price'];
        $invoice_info['inputtime'] = NOW_TIME;
        //dump(I('post.'));exit;
        $invoice_info['member_id'] = $user_info['id'];
        $invoice_info['order_info_id'] = $order_id;

        if(M('Invoice')->add($invoice_info) === false){
            $this->error = '添加发票信息失败';
            $this->rollback();
            return false;
        }


        // 扣库存
        foreach($cart_list['goods_list'] as $goods){
            $res = M('Goods')->where(['id'=>$goods['id'],'stock'=>['egt',$goods['amount']]])->count();
            //dump($cart_list['goods_list']);exit;
            if(!$res){
                $this->error = '库存不足';
                $this->rollback();
                return false;
            }
            // 扣库存
            M('Goods')->where(['id'=>$goods['id']])->setDec('stock',$goods['amount']);
        }


        // 删除购物车信息
        D('Cart')->clear();
        $this->commit();


        return true;

    }
}