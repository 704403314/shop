<?php

namespace Home\Model;
class MemberModel extends \Think\Model{
    /**
     * @var \Home\Model\MemberModel
     */
    protected $_validate = [
        ['username', 'require', '用户名不能为空', self::MUST_VALIDATE, '', 'reg'],
        ['username', '', '用户名已存在', self::MUST_VALIDATE, 'unique', 'reg'],
        ['username', '3,20', '用户名长度必须3-20位', self::MUST_VALIDATE, 'length', 'reg'],
        ['password', 'require', '密码不能为空', self::MUST_VALIDATE, '', 'reg'],
        ['repassword', 'password', '两次密码不一致', self::MUST_VALIDATE, 'confirm', 'reg'],
        ['password', '6,20', '用户名长度必须6-20位', self::MUST_VALIDATE, 'length', 'reg'],
        ['email','email','邮箱不合法', self::MUST_VALIDATE,'','reg'],
        ['tel', '/^(13|14|15|17|18)\d{9}$/', '手机格式错误', self::MUST_VALIDATE, 'regex', 'reg'],
//        ['img_code','check_captcha','验证码错误',self::MUST_VALIDATE, 'callback','reg'],
        ['tel_code','check_tel_code','手机验证码错误',self::MUST_VALIDATE,'callback','reg'],
        ['agree','require','必须同意协议',self::MUST_VALIDATE,'','reg'],

        ['username', 'require', '用户名不能为空', self::MUST_VALIDATE, '', 'login'],
        ['password', 'require', '密码不能为空', self::MUST_VALIDATE, '', 'login'],
    ];

    protected $_auto = [
      ['salt','\Org\Util\String::randString','reg','function',6],
        ['add_time',NOW_TIME,'reg'],
    ];


    /**
     * 短信验证
     */
    protected function check_tel_code($code){
        // 获取保存在session中的短信验证码
        $session_code = session('REG_CODE');
        session('REG_CODE',null);
        if($code == $session_code){
            return true;
        }else{
            return false;
        }
    }


    /**
     *验证验证码
     */
    protected function check_captcha($code,$id=''){
        $verify = new \Think\Verify();
        return $verify->check($code,$id);
    }

    /**
     * 验证手机格式
     */
    protected function check_tel($tel){
        $reg = '/^(13|14|15|17|18)\d{9}$/';
        if(preg_match($reg,$tel)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 用户注册
     */
    public function addRegister(){
        // 加盐加密
//        dump($this->data);exit;
        $this->data['password'] = salt_mcrypt($this->data['password'],$this->data['salt']);
        if($this->add() === false){
            return false;
        }else{
            $url = 'http://www.shop.com'.U('active',['email'=>I('post.email'),'token'=>\Org\Util\String::randString(30)]);
            $content = <<<EMAIL
<h1>注册成功，请激活账号</h1>
<p style="border:1px dotted blue">请点击<a href='$url'>链接</a>进行激活,如果无法点击,
请复制以下地址粘贴到浏览器访问:$url</p>
<p>低调的坚持！</p>
<p style="text-align:right;">啊咿呀呦有限公司</p>
EMAIL;
            $res = sendmail(I('post.email'), '注册成功 请激活邮箱', $content);
            if($res === false){
                $this->error = '注册失败';
                return false;
            }
            return true;
        }
    }

    /**
     * 验证登录
     */
    public function checkLogin(){
        // 保存数据
        $tp_data = $this->data;
        // 验证用户名是否存在
        if(($user_info=$this->where(['username'=>$tp_data['username']])->find()) === false){
            $this->error = '用户名不存在';
            return false;
        }

        // 对前台传过来的密码加盐加密
        $pwd = salt_mcrypt($tp_data['password'],$user_info['salt']);
        // 验证密码
//        dump($pwd);exit;
        if($pwd == $user_info['password']){
            $data = [
              'id'=>$user_info['id'],
                'last_login_time'=>NOW_TIME,
                'last_login_ip'=>get_client_ip(),

            ];
            login($user_info);
            D('Cart')->cookie2Db();
            return $this->save($data);
        }else{
            $this->error = '密码错误';
            return false;
        }
    }
}