<?php
/**
 * Class Supplier
 * @package Admin\Controller
 */
namespace Admin\Controller;
use Think\Controller;


class SupplierController extends Controller{
    private $_model=null;

    /**
     * 初始化控制器
     */
    public function _initialize(){
        $this->_model=D('Supplier');
        $titles=[
            'index'=>'管理供应商',
            'add'=>'添加供应商',
            'edit'=>'修改供应商',
        ];
        $meta_title=isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'管理供应商';
        $this->assign('meta_title',$meta_title);
    }
    /**
     * 渲染首页页面
     */
    public function index(){

        // 接收索索条件
        $name=I('get.name');
        $condition=array();
        if($name){
            $condition['name']=array('like','%'.$name.'%');
        }
        // 获取数据
        $rows=$this->_model->getPage($condition);
        $this->assign($rows);
        $this->display();
    }

    /**
     * 添加供应商
     */
    public function add(){
        if(IS_POST){
            // 自动验证
            if($this->_model->create() === false){
                $this->error($this->_model->getError());
            }
            // 插入数据不成功 错误提示
            if($this->_model->add_data() === false){
                $this->error($this->_model->getError());
            }

            $this->success('插入数据成功',U('index',['nocache' => NOW_TIME]));
        }else{
            $this->display();
        }
    }

    /**
     * 修改供应商
     * @param $id  修改的供应商的编号
     */
    public function edit($id){
        if(IS_POST){
            // 自动验证
            if($this->_model->create() === false){
                $this->error($this->_model->getError());
            }
            // 插入数据不成功 错误提示
            if($this->_model->save() === false){
                $this->error($this->_model->getError());
            }

            $this->success('修改数据成功',U('index',['nocache' => NOW_TIME]));
        }else{
            $row=$this->_model->find($id);
//            dump($row);exit;
            $this->assign('row',$row);
            $this->display('add');
        }
    }

    /**
     * 删除供应商
     * @param $id
     */
    public function delete($id){

        $data=[
            'id'=>$id,
            'status'=>0,
            'name'=>['exp','concat(name,"_del")']
        ];

        if($this->_model->setField($data)){
            $this->success('删除数据成功',U('index',['nocache'=>NOW_TIME]));
        }else{
            $this->error('删除数据失败',U('index',['nocache'=>NOW_TIME]));
        }
    }
}