<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16-5-25
 * Time: 上午11:52
 */

namespace Home\Model;


use Think\Model;

/**
 * Class PmConfigModel
 * @package Home\Model
 */
class PmConfigModel{

    /**
     * 获取送货方式结果集
     */
    public function getDelivery(){
        return M('delivery')->where(['status'=>1])->select();
    }

    /**
     * 获取支付方式结果集
     */
    public function getPayment(){
        return M('Payment')->where(['status'=>1])->select();
    }
}