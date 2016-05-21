<?php
return array(
    //不适用RBAC 限制地址
	'IGNORE_URL'=>[
        'Admin/Admin/login',
        'Admin/Captcha/captcha',
        'Admin/Admin/logout',
        'Admin/Admin/autoLogin',
        'Admin/Upload/upload',
        'Admin/Editor/ueditor',
    ],
    'INDEX_URL'=>[
        'Admin/Index/index',
        'Admin/Index/top',
        'Admin/Index/menu',
        'Admin/Index/main',
        'Admin/Admin/changePwd',
    ],
    'COOKIE_PREFIX'=>'admin_shop_com_',
);