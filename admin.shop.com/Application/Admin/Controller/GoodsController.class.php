<?php
/**
 *商品控制器
 */
namespace Admin\Controller;

use Think\Controller;


class GoodsController extends Controller{
    /**
     * @var \Admin\Controller\GoodsController
     */
    private $_model=null;
    /**
     * 初始化控制器参数
     */
    public function _initialize(){
        $this->_model=D('Goods');
        // 定义标题信息
        $titles=array(
            'index'=>'管理商品',
            'add'=>'添加商品',
            'edit'=>'修改商品',
        );
        $meta_title=isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'管理商品';
        $this->assign('meta_title',$meta_title);

    }

    public function index(){

    }

    public function add(){
        /**
         * 添加商品
         */
        if(IS_POST){
            if($this->_model->create() === false){
                // 自动验证失败
                $this->error($this->_model->getError());
            }
            if($this->_model->addGoods() === false){
                // 插入数据失败
                $this->error($this->_model->getError());
            }
            // 添加数据成功
            $this->success('添加数据成功',U('index',['nocache'=>NOW_TIME]));
        }else{
            // 获取并展示品牌列表数据
            $brands = D('brand')->getList();
            $this->assign('brands',$brands);
            // 获取并展示商品分类列表数据
            $goods_categories = D('GoodsCategory')->getList();
            $this->assign('goods_categories',json_encode($goods_categories));
            // 获取并展示供应商分类列表数据
            $suppliers = D('supplier')->getList();
            $this->assign('suppliers',$suppliers);
//          dump($goods_categories);exit;
            $this->display();

        }
    }
}