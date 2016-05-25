<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <title><?php echo ($meta_title); ?></title>
        <link rel="stylesheet" href="http://www.shop.com/Public/css/base.css" type="text/css"/>
        <link rel="stylesheet" href="http://www.shop.com/Public/css/global.css" type="text/css"/>
        <link rel="stylesheet" href="http://www.shop.com/Public/css/header.css" type="text/css"/>
        <link rel="stylesheet" href="http://www.shop.com/Public/css/login.css" type="text/css"/>
        <link rel="stylesheet" href="http://www.shop.com/Public/css/footer.css" type="text/css"/>
        
    <style type="text/css">
        .reg-error{
            color:red;
            padding-left:10px;
        }

    </style>

    </head>
    <body>
        <!-- 顶部导航 start -->
        <div class="topnav">
            <div class="topnav_bd w990 bc">
                <div class="topnav_left">

                </div>
                <div class="topnav_right fr">
                    <ul>
                        <li id="userinfo"></li>
                        <li class="line">|</li>
                        <li>我的订单</li>
                        <li class="line">|</li>
                        <li>客户服务</li>

                    </ul>
                </div>
            </div>
        </div>
        <!-- 顶部导航 end -->

        <div style="clear:both;"></div>

        <!-- 页面头部 start -->
        <div class="header w990 bc mt15">
            <div class="logo w990">
                <h2 class="fl"><a href="index.html"><img src="http://www.shop.com/Public/images/logo.png" alt="京西商城"></a></h2>
            </div>
        </div>
        <!-- 页面头部 end -->
        
    <!-- 登录主体部分start -->
    <div class="login w990 bc mt10 regist">
        <div class="login_hd">
            <h2>用户注册</h2>
            <b></b>
        </div>
        <div class="login_bd">
            <div class="login_form fl">
                <form action="<?php echo U('');?>" method="post" id='registerForm'>
                    <ul>
                        <li>
                            <label for="">用户名：</label>
                            <input type="text" class="txt" name="username" /><span class="reg-error"></span>
                            <p>3-20位字符，可由中文、字母、数字和下划线组成</p>
                        </li>
                        <li>
                            <label for="">密码：</label>
                            <input type="password" class="txt" name="password" id='password'/><span class="reg-error"></span>
                            <p>6-20位字符，可使用字母、数字和符号的组合，不建议使用纯数字、纯字母、纯符号</p>
                        </li>
                        <li>
                            <label for="">确认密码：</label>
                            <input type="password" class="txt" name="repassword" /><span class="reg-error"></span>
                            <p> <span>请再次输入密码</p>
                        </li>
                        <li>
                            <label for="">邮箱：</label>
                            <input type="text" class="txt" name="email" /><span class="reg-error"></span>
                            <p>邮箱必须合法</p>
                        </li>
                        <li>
                            <label for="">手机号码：</label>
                            <input type="text" class="txt" value="" name="tel" id="tel" placeholder=""/><span class="reg-error"></span>
                        </li>
                        <li>
                            <label for="">验证码：</label>
                            <input type="text" class="txt" value="" placeholder="请输入短信验证码" name="tel_code" disabled="disabled" id="captcha"/> <input type="button" onclick="bindPhoneNum(this)" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px"/><span class="reg-error"></span>

                        </li>
                        <li class="checkcode">
                            <label for="">验证码：</label>
                            <input type="text"  name="img_code" />
                            <img src="<?php echo U('Captcha/captcha',['nocache'=>NOW_TIME]);?>" alt="" class='img-code'/>
                            <span>看不清？<a href="javascript:;" onclick="change_img_code(this)">换一张</a></span>
                            <span class="reg-error"></span>
                        </li>

                        <li>
                            <label for="">&nbsp;</label>
                            <input type="checkbox" class="chb" checked="checked" name='agree'/> 我已阅读并同意《用户注册协议》<span class="reg-error"></span>
                        </li>
                        <li>
                            <label for="">&nbsp;</label>
                            <input type="submit" value="" class="login_btn" />
                        </li>
                    </ul>
                </form>


            </div>

            <div class="mobile fl">
                <h3>手机快速注册</h3>			
                <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
                <p><strong>1069099988</strong></p>
            </div>

        </div>
    </div>
    <!-- 登录主体部分end -->

        <!-- 登录主体部分end -->

        <div style="clear:both;"></div>
        <!-- 底部版权 start -->
        <div class="footer w1210 bc mt15">
            <p class="links">
                <a href="">关于我们</a> |
                <a href="">联系我们</a> |
                <a href="">人才招聘</a> |
                <a href="">商家入驻</a> |
                <a href="">千寻网</a> |
                <a href="">奢侈品网</a> |
                <a href="">广告服务</a> |
                <a href="">移动终端</a> |
                <a href="">友情链接</a> |
                <a href="">销售联盟</a> |
                <a href="">京西论坛</a>
            </p>
            <p class="copyright">
                © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
            </p>
            <p class="auth">
                <a href=""><img src="http://www.shop.com/Public/images/xin.png" alt="" /></a>
                <a href=""><img src="http://www.shop.com/Public/images/kexin.jpg" alt="" /></a>
                <a href=""><img src="http://www.shop.com/Public/images/police.jpg" alt="" /></a>
                <a href=""><img src="http://www.shop.com/Public/images/beian.gif" alt="" /></a>
            </p>
        </div>
        <script type="text/javascript" src="http://www.shop.com/Public/js/jquery.min.js"></script>
        <script type="text/javascript">
            $(function(){

                var url = "<?php echo U('Member/getUserInfo');?>";
//                    alert(1);
                $.getJSON(url,function(response){
//                        alert(response);
                    if(response){
                        var html = '您好'+response+'，欢迎来到京西！[<a href="<?php echo U('Member/logout');?>">退出</a>]';
                    }else{
                        var html = '您好,欢迎来到京西![<a href="<?php echo U('Member/login');?>">登录</a>] [<a href="<?php echo U('Member/register');?>">免费注册</a>]';
                    }
                    $('#userinfo').html(html);
                });
            })
        </script>
        
    <script type="text/javascript" src="http://www.shop.com/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.shop.com/Public/ext/jquery_validation/dist/jquery.validate.min.js"></script>
    <script type="text/javascript">
        function bindPhoneNum() {
            //启用输入框
            $('#captcha').prop('disabled', false);
            //调用短信接口,发送验证码到手机
            var url = '<?php echo U("sendSms");?>';
            var data = {
                telphone:$('#tel').val(),
            };
            $.getJSON(url,data);

            var time = 60;
            var interval = setInterval(function () {
                time--;
                if (time <= 0) {
                    clearInterval(interval);
                    var html = '获取验证码';
                    $('#get_captcha').prop('disabled', false);
                } else {
                    var html = time + ' 秒后再次获取';
                    $('#get_captcha').prop('disabled', true);
                }

                $('#get_captcha').val(html);
            }, 1000);
        }

        function change_img_code() {
            var url = '<?php echo U("Captcha/captcha");?>?nocache=' + new Date().getTime();
            $('.img-code').attr('src', url);
            return false;
        }

        $(function () {
            //配置验证规则
            $("#registerForm").validate({
                rules: {
                    username: {
                        required: true,
                        rangelength: [3,20],
                        //用户名唯一
                        remote:'<?php echo U("checkExist");?>',
                    },
                    password: {
                        required: true,
                        rangelength: [6,20],
                    },
                    repassword: {
                        equalTo: "#password",
                    },
                    email: {
                        required: true,
                        email: true,
                        //用户名唯一
                        remote:'<?php echo U("checkExist");?>',
                    },
                    tel: {
                        required: true,
                        //使用正则匹配中国的手机号码
                        check_tel:true,
                        //用户名唯一
                        remote:'<?php echo U("checkExist");?>',
                    },
                    agree: "required",
                    tel_code:'required',
                    img_code:'required',
                },
                //配置错误提示
                messages: {
                    username: {
                        required: "用户名不能为空",
                        rangelength: "用户名长度必须为3-20位",
                        remote:'用户名已存在',
                    },
                    password: {
                        required: "密码不能为空",
                        rangelength: "密码长度必须为6-20位"
                    },
                    repassword: '两次密码不一致',
                    email: {
                        required:'邮箱不能为空',
                        email:"邮箱格式不正确",
                        remote:'邮箱已存在',
                    },
                    agree: "请同意许可协议",
                    tel:{
                        required:'手机号码不能为空',
                        remote:'手机号码已存在',
                        check_tel:'手机号码不合法',
                    },
                    tel_code:'手机验证码不能为空',
                    img_code:'验证码不能为空',
                },
                errorPlacement:function(error,node){
                    //找到错误发生的节点,并且找到其后面的reg-error的span把错误信息放进去
                    var error_node = node[0];
                    var error_msg_node = $(error_node).parent().find('.reg-error');
                    var msg = $(error[0]).text();
                    error_msg_node.text(msg);
                },
                success:function(error,node){
//                    alert(1);
//                    console.debug(arguments);
//////                    var
//                    $(node[0]).parent().find('.reg-error').text('');
                }
            });

            $.validator.addMethod("check_tel",check_telphone,"手机号码不合法");

            function check_telphone(tel){
                var reg=/^(13|14|15|17|18)\d{9}$/;
                $('#tel').parent().find('.reg-error').text('');
                return reg.test(tel);
            }
        });
    </script>

    </body>
</html>