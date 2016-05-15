<?php
/**
 * 商品分类控制器
 */
namespace Admin\Controller;
use Think\Controller;


class GoodsCategoryController extends Controller{
    /**
     * @var Admin\Controller\GoodsCategoryController
     */
    private $_model=null;
    /**
     * 初始化控制器参数
     */
    public function _initialize(){
        $this->_model=D('GoodsCategory');
        // 定义标题信息
        $titles=array(
            'index'=>'管理商品分类',
            'add'=>'添加商品分类',
            'edit'=>'修改商品分类',
        );
        $meta_title=isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'管理商品分类';
        $this->assign('meta_title',$meta_title);

    }

    /**
     *展示首页
     */
    public function index(){
        $rows=$this->getList();
        $this->assign($rows);
        $this->display();
    }

    /**
     * 添加商品分类
     *
     */
    public function add(){
        if(IS_POST){

            if($this->_model->create() === false){
                // 自动验证失败
                 $this->error($this->_model->getError());
            }
            if($this->_model->addCategory() === false){
                // 插入数据失败
                $this->error($this->_model->getError());
            }
             // 添加数据成功
            $this->success('添加数据成功',U('index',['nocache'=>NOW_TIME]));
        }else{
            $this->_before_view();
            $this->display();
        }

    }

    /**
     * 修改商品分类
     *
     */
    public function edit($id){
        if(IS_POST){

            if($this->_model->create() === false){
                // 自动验证失败
                $this->error($this->_model->getError());
            }
            if($this->_model->updateCategory() === false){
                // 插入数据失败
                $this->error($this->_model->getError());
            }
            // 添加数据成功
            $this->success('修改数据成功',U('index',['nocache'=>NOW_TIME]));
        }else{
            // 获取列表数据
            $this->_before_view();
            // 获取当前数据
            $row = $this->_model->find($id);
            $this->assign('row',$row);
            $this->display('add');
        }

    }

    /**
     * 删除数据
     */
    public function delete($id){
        $res = $this->_model->deleteCategory($id);
        if($res){
            $this->success('删除成功',U('index',['nocache'=>NOW_TIME]));
        }else{
            $this->error($this->_model->getError(),U('index',['nocache'=>NOW_TIME]));
        }
    }
    /**
     * 获取分类列表
     */
    public function _before_view(){
        // 获取商品分类列表
        $goods_categories=$this->_model->getList();
//            dump($goods_categories);exit;
        array_unshift($goods_categories,['id'=>0,'parent_id'=>null,'name'=>"顶级分类"]);
        $this->assign('goods_categories',json_encode($goods_categories));
    }
}