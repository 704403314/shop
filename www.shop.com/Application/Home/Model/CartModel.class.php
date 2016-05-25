<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16-5-22
 * Time: 下午10:00
 */

namespace Home\Model;


use Think\Model;

/**
 * Class CartModel
 * @package Home\Model
 */
class CartModel extends Model{
    protected $tableName = 'shopping_car';

    /**
     * 添加商品到购物车
     */
    public function addCart($id,$amount){
        // 获取session中的用户信息
        $user_info = login();
        if($user_info){
            // 准备查询条件
           $cond = [
             'goods_id'=>$id,
               'member_id'=>$user_info['id'],
           ];
            if($this->where($cond)->getField('amount')){
                // 数据库中有对应商品的数量 则再加上传过来的数量
                 $this->where($cond)->setInc('amount',$amount);
            }else{
                // 准备添加数据
                $data = [
                    'goods_id'=>$id,
                    'amount'=>$amount,
                    'member_id'=>$user_info['id'],
                ];
                // 添加当前商品购买信息到购物车
                $this->add($data);
            }
        }else{
            $key = 'CART';
            // 从cookie中获取保存的购物车信息
            $cart_list = cookie($key);
            if(isset($car_list[$id])){
                // cookie中有数据 在原来基础上加上新的数量
                $cart_list[$id] += $amount;
            }else{
                // 没有 商品数量为当前数量
                $cart_list[$id] = $amount;
            }
            cookie($key,$cart_list,604800);
        }
    }

    /**
     * 添加订单
     */
    public function addOrder(){

    }


    /**
     * 展示购物车信息
     */
    public function getCartList(){
        $user_info = login();
        if($user_info){
            // 用户已登录
            $cond = ['member_id'=>$user_info['id']];
            $cart_list = $this->where($cond)->getField('goods_id,amount');
         }else{

            // 用户未登录 从cookie中获取
            $cart_list = cookie('CART');
         }
           $total_price = 0;
           $total_amount = 0;
           $goods_list = [];
        if($cart_list){
            // 由于$cart_list 是一个关联数组 键为商品id 所以可以获取购物车中所有的商品id
            $goods_ids = array_keys($cart_list);
            // 获取所有购物车中的商品信息
            $goods_infos = D('Goods')->where(['id'=>['in',$goods_ids]])->select();
            $data = [];
            foreach($goods_infos as $goods_info){
                $goods_info['shop_price'] = money_format($goods_info['shop_price']);
               // 获取当前被遍历的商品数量
                $goods_info['amount'] = $cart_list[$goods_info['id']];
                // 获取当前商品总价
                $goods_info['sub_total'] = money_format($goods_info['amount']*$goods_info['shop_price']);
               // 获取到当前遍历为止 商品总价
                $total_price += $goods_info['sub_total'];
                $total_amount+=$goods_info['amount'];
                $goods_list[] = $goods_info;
            }
        }
        return ['total_amount'=>$total_amount,'total_price'=>money_format($total_price),'goods_list'=>$goods_list];

    }

    /**
     * 将cookie数据保存到数据库
     */
    public function cookie2Db(){
        $user_info = login();
        // 取出保存在cookie中购物车数据
        $cart_list = cookie('CART');
        if($cart_list){
            // 获取保存在购物车中的商品id
            $goods_ids = array_keys($cart_list);
            // 先删除数据库中的购物车信息
            $cond = [
                'goods_id'=>['in',$goods_ids],
                'member_id'=>$user_info['id'],
            ] ;
            $this->where($cond)->delete();

            $data = [];
            // 遍历所有保存在cookie中的购物车信息
            foreach($cart_list as $goods_id=>$amount){
                $data[] =[
                   'member_id'=> $user_info['id'],
                    'amount'=>$amount,
                    'goods_id'=>$goods_id
                ] ;
            }
            // 向数据库添加数据
            return $this->addAll($data);
            // 将cookie 中数据销毁
            cookie('CART',null);
        }else{
            return true;
        }
    }
}