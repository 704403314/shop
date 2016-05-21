<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

//phpinfo();exit;
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);
define('SITE_ROOT',__DIR__);
// 定义应用目录
define('APP_PATH',SITE_ROOT.'/Application/');
//绑定模块
define('BIND_MODULE','Home');
//定义域名
define('MY_URL','http://www.shop.com');

//var_dump(dirname(SITE_ROOT));exit;
//define('RUNTIME_PATH',SITE_ROOT . '/Runtime/');
// 引入ThinkPHP入口文件
require dirname(SITE_ROOT)."/ThinkPHP/ThinkPHP.php";
// 亲^_^ 后面不需要任何代码了 就是如此简单