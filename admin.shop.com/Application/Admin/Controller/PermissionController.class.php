<?php
namespace Admin\Controller;
use Think\Controller;

class PermissionController extends Controller{
    /**
     * @var \Admin\Controller\PermissionController
     */

    private $_model=null;
    /**
     * 初始化控制器参数
     */
    public function _initialize(){
        $this->_model=D('Permission');
        // 定义标题信息
        $titles=array(
            'index'=>'管理权限',
            'add'=>'添加权限',
            'edit'=>'修改权限',
        );
        $meta_title=isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'管理权限';
        $this->assign('meta_title',$meta_title);

    }

    /**
     *展示首页
     */
    public function index(){
        $this->assign('rows',$this->_model->where(['status'=>1])->order('lft')->select());
        $this->display();

    }

    /**
     * 权限添加
     */
    public function add(){
        if(IS_POST){
            // 自动验证
            if($this->_model->create() === false){
                $this->error($this->_model->getError());
            }
            // 判断插入
            if($this->_model->addPermission() === false){
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
     * 修改权限
     */
    public function edit($id){
        if(IS_POST){
            // 自动验证
            if($this->_model->create() === false){
                $this->error($this->_model->getError());
            }
            // 判断插入
            if($this->_model->updatePermission() === false){
                $this->error($this->_model->getError());
            }

            $this->success('修改数据成功',U('index',['nocache'=>NOW_TIME]));

        }else{
            $row=$this->_model->find($id);
            $this->assign('row',$row);
            // 展示列表数据
            $this->_before_view();
            $this->display('add');
        }
    }

    /**
     * 删除权限
     */
    public function delete($id){
       $res = $this->_model->deletePermission($id);
        if($res){
            $this->success('删除数据成功',U('index',['nocache'=>NOW_TIME]));
        }else{
            $this->error($this->_model->getError());
        }
    }

    /**
     * 展示列表数据
     */
    public function _before_view(){
        $permissions = $this->_model->getList();
        array_unshift($permissions,['id' => 0, 'name' => '顶级权限', 'parent_id' => null]);
        $this->assign('permissions',json_encode($permissions));
    }

}