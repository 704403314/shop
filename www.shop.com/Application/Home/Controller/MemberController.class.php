<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16-5-19
 * Time: 下午12:54
 */

namespace Home\Controller;
use Think\Controller;

class MemberController extends Controller{
/**
 * @vra \Home\Controller\MemberController
 */
    protected $_model = null;
    protected function _initialize(){
        // 实例化member模型
        $this->_model = D('Member');
        // 配置标题信息
        $titles = [
            'register'=>'用户注册',
            'login'=>'用户登录',

        ];
        $meta_title = isset($titles['ACTION_NAME'])?:'用户注册';
        $this->assign('meta_title',$meta_title);
    }

    /**
     * 用户注册
     */
    public function register(){
        if(IS_POST){
//            dump(U('active'));exit;
            // 自动验证用户的数据
            if($this->_model->create('','reg') === false){
                $this->error($this->_model->getError());
            }
            // 数据库验证
            if($this->_model->addRegister() === false){
                $this->error($this->_model->getError());
            }

            $this->success('注册成功,请激活邮箱');
        }else{
            $this->display();
        }
    }

    /**
     * 激活邮箱
     */
    public function active(){
//        echo 1;
    }

    public function sendSms($telphone){
        $code = (string)mt_rand(1000,9999);
        // 将手机验证码保存到session中 以便验证
        session('REG_CODE',$code);
        $data = [
           'code'=>$code,
            'product'=>'这是数据',
        ];
        $res = sendSms($telphone,$data);
        $this->ajaxreturn($res);
    }

    /**
     * 用户登录
     */
    public function login(){
        if(IS_POST){
            // 自动验证用户的数据
            if($this->_model->create('','login') === false){
                $this->error($this->_model->getError());
            }
            // 数据库验证
            if($this->_model->checkLogin() === false){
                $this->error($this->_model->getError());
            }

            $url = cookie('_self_')?:U('Index/index');
            cookie('_self_',null);
            $this->success('登陆成功',$url);
        }else{
            $this->display();
        }
    }

    /**
     * 验证数据唯一性
     */

    public function checkExist(){
        $cond = I('get.');
        $res = $this->_model->where($cond)->count();
        if($res){
             $this->ajaxReturn(false);
        }else{
            $this->ajaxReturn(true);
        }
    }

    /**
     * 获取用户名
     */
    public function getUserInfo(){
        $userinfo = login();
//        var_dump($userinfo);exit;
        if($userinfo){
           $username = $userinfo['username'];
        }else{
            $username= '';
        }
        $this->ajaxReturn($username);
    }

    /**
     * 退出
     */
    public function logout(){
//        dump(login());exit;
        session(null);
//
        cookie(null);
        $this->success('退出成功',U('Index/index'));
    }
}