<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16-5-25
 * Time: 下午4:02
 */

namespace Home\Controller;


use Think\Controller;

/**
 * Class OrderController
 * @package Home\Controller
 */
class OrderController extends Controller{

    protected $_model = null;
    protected function _initialize(){
        $this->_model = D('OrderInfo');
    }
    /**
     * 添加订单
     */
    public function add(){
        // 保存数据
        if($this->_model->create() === false){

            $this->error('添加数据失败');
        }
        // 添加数据
        if($this->_model->addOrder() === false){

            $this->error('添加数据失败');
        }
        redirect(U('Cart/flow3',['aaa'=>NOW_TIME]));
    }

}