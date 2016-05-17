<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16-5-15
 * Time: 下午8:38
 */

namespace Admin\Controller;
use Think\Controller;

class AdminController extends Controller{
    /**
     * @var \Admin\Controller\AdminController
     */

    private $_model=null;
    /**
     * 初始化控制器参数
     */
    public function _initialize(){
        $this->_model=D('Admin');
        // 定义标题信息
        $titles=array(
            'index'=>'管理管理员',
            'add'=>'添加管理员',
            'edit'=>'修改管理员',
        );
        $meta_title=isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'管理管理员';
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
     * 管理员添加
     */
    public function add(){
        if(IS_POST){
            // 自动验证
            if($this->_model->create() === false){
                $this->error($this->_model->getError());
            }
            // 判断插入
            if($this->_model->addAdmin() === false){
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
     * 修改管理员
     */
    public function edit($id){
        if(IS_POST){
            // 自动验证
            if($this->_model->create() === false){
                $this->error($this->_model->getError());
            }
            // 判断插入
            if($this->_model->updateAdmin() === false){
                $this->error($this->_model->getError());
            }

            $this->success('修改数据成功',U('index',['nocache'=>NOW_TIME]));

        }else{
            $row=$this->_model->getAdminInfo($id);
            $this->assign('row',$row);
            // 展示列表数据
            $this->_before_view();
            $this->display('add');
        }
    }

    /**
     * 删除管理员
     */
    public function delete($id){
        $res = $this->_model->deleteAdmin($id);
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
        // 用复选框展示所有角色信息
       $this->assign('roles',D('Role')->where(['status'=>1])->select());
        // 展示所有权限
        $this->assign('permissions',json_encode(D('Permission')->getList()));

    }

    /**
     * 登录验证
     */
    public function login(){
        if(IS_POST){
            // 自动验证
            if($this->_model->create('','login') === false){
                $this->error($this->_model->getError());
            }
            // 判断插入
            if($this->_model->login() === false){
                $this->error($this->_model->getError());
            }

            $this->success('登陆成功',U('Index/index',['nocache'=>NOW_TIME]));
        }else{
//            dump(123);exit;
            $this->display();
        }
    }

    /**
     * 退出功能
     */
    public function logout(){
        session(null);
        $this->success('退出成功',U('login'));
    }
}