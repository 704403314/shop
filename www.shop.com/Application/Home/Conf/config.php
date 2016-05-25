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
//    'SHOW_PAGE_TRACE'=>true,
    'DB_PREFIX' => '', // 数据库表前缀
    'URL_MODULE'=>2,

    'TMPL_PARSE_STRING'=>array(
        '__CSS__'=>MY_URL.'/Public/css',
        '__IMG__'=>MY_URL.'/Public/images',
        '__JS__'=>MY_URL.'/Public/js',
        '__UPLOADIFY__'=>MY_URL.'/Public/ext/uploadify',
        '__LAYER__'=>MY_URL.'/Public/ext/layer',
        '__ZTREE__'=>MY_URL.'/Public/ext/ztree',
        '__TREEGRID__'=>MY_URL.'/Public/ext/treegrid',
        '__UE__'=>MY_URL.'/Public/ext/ue',
        '__VALIDATION__'=>MY_URL.'/Public/ext/jquery_validation',
    ),
//    'SESSION_TYPE'=>'Db',
    'PAGE_SIZE'         => 20,
    'PAGE_THEME'        => '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%',
    'TMPL_CACHE_ON'         =>  false,
    'UPLOAD_SETTING' => require __DIR__."/upload.php",

    //session存入redis
    'SESSION_AUTO_START' => true, // 是否自动开启Session
    'SESSION_TYPE'       => 'Redis', //session类型
    'SESSION_PERSISTENT' => 1, //是否长连接(对于php来说0和1都一样)
    'SESSION_CACHE_TIME' => 1, //连接超时时间(秒)
    'SESSION_EXPIRE'     => 0, //session有效期(单位:秒) 0表示永久缓存
    'SESSION_PREFIX'     => 'sess_', //session前缀
    'SESSION_REDIS_HOST' => '127.0.0.1', //分布式Redis,默认第一个为主服务器
    'SESSION_REDIS_PORT' => '6379', //端口,如果相同只填一个,用英文逗号分隔
    'SESSION_REDIS_AUTH' => '', //Redis auth认证(密钥中不能有逗号),如果相同只填一个,用英文逗号分隔

    //页面静态化的配置
//    'HTML_CACHE_ON'      => true, // 开启静态缓存
    'HTML_CACHE_TIME'    => 3600, // 全局静态缓存有效期（秒）
    'HTML_FILE_SUFFIX'   => '.html', // 设置静态缓存文件后缀
    'HTML_CACHE_RULES'   => array(// 定义静态缓存规则     // 定义格式1 数组方式
//        'Index:index' => array('{$_SERVER.REQUEST_URI|md5}'),
        'Index:' => array('{:action}_{id}'),
//        'goods' => array('{:action}_{id}'),
    ),

    'EMAIL_SETTING'=>  require __DIR__.'/email.php',
    'COOKIE_PREFIX'         =>  'www_shop_com_',
    // 配置redis
    'DATA_CACHE_TYPE'       =>  'Redis',
    'host'          => '127.0.0.1',
    'port'          => 6379,
    'timeout'       => 3600,
);