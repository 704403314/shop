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
        $this->display();
    }

    /**
     * 添加商品分类
     *
     */
    public function add(){
        if(IS_POST){
            if($this->_model->create()){

            }
        }else{
            // 获取商品分类列表
            $goods_categories=$this->_model->getList();
//            dump($goods_categories);exit;
            $this->assign('goods_categories',json_encode($goods_categories));
            $this->display();
        }

    }
}