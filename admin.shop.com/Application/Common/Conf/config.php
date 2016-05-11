<?php
return array(
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'tp1229', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '123', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => '', // 数据库表前缀
    'DB_DEBUG'          => TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'   => false, // 关掉字段缓存
    'DB_CHARSET'=> 'utf8', // 字符集
    'SHOW_PAGE_TRACE'=>true,
    'DB_PREFIX' => '', // 数据库表前缀
    'URL_MODULE'=>2,
    'TMPL_PARSE_STRING'=>array(
        '__CSS__'=>MY_URL.'/Public/css',
        '__IMG__'=>MY_URL.'/Public/images',
        '__JS__'=>MY_URL.'/Public/js',
        '__UPLOADIFY__'=>MY_URL.'/Public/ext/uploadify',
        '__LAYER__'=>MY_URL.'/Public/ext/layer',
        '__ZTREE__'=>MY_URL.'/Public/ext/ztree',
    ),
    'SESSION_TYPE'=>'Db',
    'PAGE_SIZE'         => 2,
    'PAGE_THEME'        => '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%',
    'TMPL_CACHE_ON'         =>  false,
    'UPLOAD_SETTING' => require __DIR__."/upload.php",

);