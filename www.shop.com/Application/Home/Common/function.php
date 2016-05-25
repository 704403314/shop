<?php
function salt_mcrypt($p,$salt){
    return md5(md5($p).$salt);
}

/**
 * 保存或获取session中的用户信息
 */
function login($user_info){
    if($user_info){
        session('USER_INFO',$user_info);
    }else{
        return session('USER_INFO');
    }
}

/**
 * 验证短信验证码
 */
function sendSms($telephone,$data,$sign='短信认证',$tmplate='SMS_9695883'){
      // 引入阿里大鱼自动加载机制
    vendor('Alidayu.Autoloader');
    date_default_timezone_set('Asia/Shanghai');
    $c  = new \TopClient;
    $c->format='json';
    $c->appkey    = '23369426';
    $c->secretKey = '4364567d2993b1c7223e21a49a9d2a8c';
    $req          = new \AlibabaAliqinFcSmsNumSendRequest;
    $req->setSmsType("normal");
    $req->setSmsFreeSignName($sign);
//    $code = (string)mt_rand(1000, 9999);
    $req->setSmsParam(json_encode($data));
    $req->setRecNum($telephone);
    $req->setSmsTemplateCode($tmplate);
    $resp         = $c->execute($req);
//    var_dump($resp);exit;
   if(isset($resp->result) && isset($resp->result->success)){
       $status = true;
   }else{
       $status = false;
   }
    return $status;
}


/**
 * 发送邮件
 * @param $address
 * @param $subject
 * @param $content
 * @return bool
 * @throws Exception
 * @throws phpmailerException
 */
function sendmail($address='hh704403314@126.com',$subject,$content){
    //获取配置
    $setting = C('EMAIL_SETTING');
    //加载自动载入类库
    vendor('PHPMailer.PHPMailerAutoload');
    //创建发送邮件的对象
    $mail = new \PHPMailer;
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host     = $setting['host'];  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $setting['username'];                 // SMTP username
    $mail->Password = $setting['password'];                           // SMTP password
    $mail->SMTPSecure =$setting['SMTPSecure'];                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port     = $setting['port'];                                    // TCP port to connect to

    $mail->setFrom($setting['username']);
    //如果是数组,就批量发送
    if(is_array($address)){
        foreach($address as $item){
            $mail->addAddress($item);     // Add a recipient
        }
    }else{
        $mail->addAddress($address);     // Add a recipient
    }
//    $res = $mail->addAddress($address);
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->CharSet = 'utf-8';
    $mail->Subject = $subject;
    $mail->Body    = $content;
//    echo "<pre>";
//    var_dump($mail->send());exit;
    return $mail->send();
}

/**
 * 连接redis
 */
function getRedis(){
    static $redis = null;
    if(!$redis instanceof Redis){
        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
    }


    return $redis;
}

/**
 * 对金钱处理
 */
function money_format($number){
    return number_format($number,2,'.','');
}

/**
 * // 返回所需列表数据
 * @param $data    后台传过来的数据
 * @param $field_id    控件表单值
 * @param $field_name  控件文本值
 * @param $name    下拉菜单的名字
 */
function arr2select($data,$field_id,$field_name,$name,$selected=''){
    $html = '<select class="'.$name.'" name="'.$name.'">';
    $html .= '<option value="">请选择...</option>';
    // 拼接每一个下拉菜单
    foreach($data as $row){

        if($selected == $row[$field_id]){
            $html .= '<option  value="' . $row[$field_id] . '"selected="selected">'.$row[$field_name].'</option>';

        }else{
            $html .= '<option value="' . $row[$field_id] . '">'.$row[$field_name].'</option>';

        }



    }
    return $html .= '</select>';
}
