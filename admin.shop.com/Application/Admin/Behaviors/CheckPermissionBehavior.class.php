<?php
namespace Admin\Behaviors;

class CheckPermissionBehavior extends \Think\Behavior{
    /**
     * 验证权限
     * @param \Admin\Behaviors\CheckPermissionBehavior
     */

    public function run(&$params){

        // 允许访问的url
        $paths = array_merge([],C('IGNORE_URL'));

        // 获取登录用户session信息
        $admin_info = session('ADMIN_INFO');
//                dump($admin_info);exit;
        // 如果已登陆去数据库查询该用户的访问权限
        if($admin_info){
            // 超级管理员没有限制
            if($admin_info['username']=='admin'){
                return true;
            }
            // 后台首页的方法都可以访问
            $paths = array_merge($paths,C('INDEX_URL'));
            // 获取session中保存的当前管理员可访问的url
            $session_paths = session('PATHS');
            $paths = array_merge($session_paths,$paths);
        }

        $url = implode('/',[MODULE_NAME,CONTROLLER_NAME,ACTION_NAME]);
//        dump($paths);dump($url);exit;
        if(!in_array($url,$paths)){
            header('Content-Type:text/html;charset=utf-8');
            redirect(U('Admin/Admin/login'),1,'无权访问');
        }
    }
}