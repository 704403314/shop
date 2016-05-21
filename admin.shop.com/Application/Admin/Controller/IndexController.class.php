<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    /**
     * 展示后台首页
     */
    public function index(){
        $this->display();
    }

    /**
     * 渲染头部
     */
    public function top(){
        $this->display();
    }

    /**
     * 渲染菜单
     */
    public function menu(){
        $menus = D('Menu')->getMenus();
        $this->assign('menus',$menus);
        $this->display();

    }

    /**
     * 渲染主页面
     */
    public function main(){
        $this->display();
    }
}