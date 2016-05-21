<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16-5-21
 * Time: 下午7:52
 */

namespace Home\Controller;


use Think\Controller;

/**
 * Class TestController
 * @package Home\Controller
 */
class TestController extends Controller{

    public function sendMail() {


        if(sendmail('704403314@qq.com', 'test send email', '520节日快乐')){
            echo '发送成功';
        }else{
            echo '发送失败';
        }
    }

}