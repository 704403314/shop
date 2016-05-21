<?php

return [
    'mimes'        => array('image/jpeg', 'image/png', 'image/gif'), //允许上传的文件MiMe类型
    'maxSize'      => 3145728, //上传的文件大小限制 (0-不做限制)
    'exts'         => array('jpg', 'png', 'gif', 'jpeg'), //允许上传的文件后缀
    'autoSub'      => true, //自动子目录保存文件
    'subName'      => array('date', 'Ymd'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
    'rootPath'     => SITE_ROOT . '/Uploads/', //保存根路径
    'savePath'     => '', //保存路径
    'saveName'     => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
    'saveExt'      => '', //文件保存后缀，空则使用原后缀
    'replace'      => false, //存在同名是否覆盖
    'hash'         => true, //是否生成hash编码
    'callback'     => false, //检测文件是否存在回调，如果存在返回文件信息数组
//    'driver'       => 'Qiniu', // 文件上传驱动
//    'driverConfig' => array(
////        CqXJunbz6x89fBspFlrsYCC05Edjp0cQZCKlSmAq
////        dbtq8SzFBLMDQl1ljG5Xe2k-S9JevQPMg0Dh9TrS
//        'secretKey' => 'dbtq8SzFBLMDQl1ljG5Xe2k-S9JevQPMg0Dh9TrS', //sk
//        'accessKey'  => 'CqXJunbz6x89fBspFlrsYCC05Edjp0cQZCKlSmAq', //ak
//        'domain'     => 'o7076k0kj.bkt.clouddn.com', //域名
//        'bucket'     => 'tp1229', //空间名称
//        'timeout'    => 300, //超时时间
//    ),
];
