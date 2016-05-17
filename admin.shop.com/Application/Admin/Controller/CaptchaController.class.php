<?php
namespace Admin\Controller;
use Think\Controller;


class CaptchaController extends Controller{
    /**
     * 生成验证码
     */
    public function captcha(){
//        dump(123);exit;
        $options = [
            'length'    =>  4,
        ];
        // 实例化生成验证码对象
        $verify = new \Think\Verify($options);
        // 生产验证码
        $verify->entry();
         exit;
    }
}