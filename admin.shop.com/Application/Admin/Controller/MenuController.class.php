<?php
namespace Admin\Controller;
use Think\Controller;

class MenuController extends Controller{

    /**
     * @var \Admin\Controller\MenuController
     */
    private $_model=null;
    /**
     * 初始化控制器参数
     */
    public function _initialize(){
        $this->_model=D('Menu');
        // 定义标题信息
        $titles=array(
            'index'=>'管理菜单',
            'add'=>'添加菜单',
            'edit'=>'修改菜单',
        );
        $meta_title=isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'管理菜单';
        $this->assign('meta_title',$meta_title);

    }

    /**
     *展示首页
     */
    public function index(){
        $this->assign('rows',$this->_model->getList());
        $this->display();

    }

    /**
     * 菜单添加
     */
    public function add(){
        if(IS_POST){
            // 自动验证
            if($this->_model->create() === false){
                $this->error($this->_model->getError());
            }
            // 判断插入
            if($this->_model->addMenu() === false){
                $this->error($this->_model->getError());
            }

            $this->success('添加数据成功',U('index',['nocache'=>NOW_TIME]));

        }else{
            // 展示列表数据
            $this->_before_view();
            $this->display();
        }
    }

    /**
     * 修改菜单
     */
    public function edit($id){
        if(IS_POST){
            // 自动验证
            if($this->_model->create() === false){
                $this->error($this->_model->getError());
            }
            // 判断插入
            if($this->_model->updateMenu() === false){
                $this->error($this->_model->getError());
            }

            $this->success('修改数据成功',U('index',['nocache'=>NOW_TIME]));

        }else{
            $row=$this->_model->getMenuInfo($id);
            $this->assign('row',$row);
            // 展示列表数据
            $this->_before_view();
            $this->display('add');
        }
    }

    /**
     * 删除菜单
     */
    public function delete($id){
        $res = $this->_model->deleteMenu($id);
        if($res){
            $this->success('删除数据成功',U('index',['nocache'=>NOW_TIME]));
        }else{
            $this->error($this->_model->getError());
        }
    }

    /**
     * 展示列表数据
     */
    private function _before_view(){
        // 获取所有权限列表
        $menus = $this->_model->getList();
        // 添加一个顶级权限
        array_unshift($menus,['id'=>0,'name'=>'顶级菜单','parent_id'=>null]);
        $this->assign('menus',json_encode($menus));
        $this->assign('permissions',json_encode(D('Permission')->getList()));
    }

}