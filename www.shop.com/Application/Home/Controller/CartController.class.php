<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16-5-22
 * Time: 下午9:50
 */

namespace Home\Controller;


use Home\Model\PmConfigModel;
use Think\Controller;

/**
 * Class CartController
 * @package Home\Controller
 */
class CartController extends Controller{

    protected $_model = null;

    public function _initialize(){
        $this->_model = D('Cart');
        $this->assign('action_name',ACTION_NAME);
    }

    /**
     * 添加商品到购物车
     */
    public function addCart($id,$amount){
//        dump($id);exit;
        $this->_model->addCart($id,$amount);
        $this->success('添加成功',U('flow1'));
    }

    /**
     * 展示购物车信息
     */
    public function flow1(){
        $this->assign($this->_model->getCartList());
        $this->display();
    }

    /**
     * 确认购物信息
     */
    public function flow2(){
       if(!login()){
           // 保存当前访问的url 到cookie
           cookie('_self_',__SELF__);
           $this->success('请先登录',U('Member/login'));
       }else{

           if(IS_POST){
               // 保存数据
               if($this->_model->create() === false){

                   $this->error('添加数据失败');
               }
               // 添加数据
               if($this->_model->addOrder() === false){

                   $this->error('添加数据失败');
               }
               $this->success('添加订单成功',U('flow3',['aaa'=>NOW_TIME]));
           }else{
               // 获取购物车信息
               $this->assign($this->_model->getCartList());
               // 获取地址信息
               $this->assign('rows',D('Address')->getList());
               // 获取送货方式信息
               $deliver_model = new PmConfigModel();
               $this->assign('deliveries',$deliver_model->getDelivery());
               // 支付方式信息
               $this->assign('payments',$deliver_model->getPayment());

               $this->display();
           }


       }

    }

    /**
     *
     */
    public function flow3(){

           $this->display();
    }
}