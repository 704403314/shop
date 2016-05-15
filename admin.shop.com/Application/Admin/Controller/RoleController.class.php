<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16-5-15
 * Time: 下午8:38
 */

namespace Admin\Controller;
use Think\Controller;

class RoleController extends Controller{
    /**
     * @var \Admin\Controller\RoleController
     */

    private $_model=null;
    /**
     * 初始化控制器参数
     */
    public function _initialize(){
        $this->_model=D('Role');
        // 定义标题信息
        $titles=array(
            'index'=>'管理角色',
            'add'=>'添加角色',
            'edit'=>'修改角色',
        );
        $meta_title=isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'管理角色';
        $this->assign('meta_title',$meta_title);

    }

    /**
     *展示首页
     */
    public function index(){
        $this->assign('rows',$this->_model->where(['status'=>1])->select());
        $this->display();

    }

    /**
     * 角色添加
     */
    public function add(){
        if(IS_POST){
            // 自动验证
            if($this->_model->create() === false){
                $this->error($this->_model->getError());
            }
            // 判断插入
            if($this->_model->addRole() === false){
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
     * 修改角色
     */
    public function edit($id){
        if(IS_POST){
            // 自动验证
            if($this->_model->create() === false){
                $this->error($this->_model->getError());
            }
            // 判断插入
            if($this->_model->updateRole() === false){
                $this->error($this->_model->getError());
            }

            $this->success('修改数据成功',U('index',['nocache'=>NOW_TIME]));

        }else{
            $row=$this->_model->getRoleInfo($id);
            $this->assign('row',$row);
            // 展示列表数据
            $this->_before_view();
            $this->display('add');
        }
    }

    /**
     * 删除角色
     */
    public function delete($id){
        $res = $this->_model->deleteRole($id);
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
        $this->assign('permissions',json_encode($permissions));
    }

}