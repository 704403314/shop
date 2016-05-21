<?php 
include "TopSdk.php"; 
date_default_timezone_set('Asia/Shanghai'); 
$c = new TopClient;
$c->appkey = '23368733';
$c->secretKey = '260d2fbb9cb7108421d096e6a6201853';
$req = new AlibabaAliqinFcSmsNumSendRequest;
$req->setSmsType("normal");
$req->setSmsFreeSignName("四哥测试");
$req->setSmsParam("{code:'6666',product:'啊咿呀哟'}");
$req->setRecNum("13880139130");
$req->setSmsTemplateCode("SMS_5590023");
$resp = $c->execute($req);
var_dump($resp);