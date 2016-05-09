<?php
/**
 * 文章控制器
 */
namespace Admin\Controller;
use Think\Controller;

/**
 * Class ArticleController
 * @package Admin\Controller
 */
class ArticleController extends Controller{
    private $_model=null;
    /**
     * 初始化控制器数据
     */
    public function _initialize(){
        $this->_model=D('Article');
        $titles=[
            'index'=>'管理文章',
            'add'=>'添加文章',
            'edit'=>'修改文章',
        ];

        $meta_title=isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'文章管理';

        $this->assign('meta_title',$meta_title);
    }

    /**
     *展示首页
     */
    public function index(){
        // 获取文章分类名称
        $category_names=D('ArticleCategory')->field('id,name')->select();

        $this->assign('category_names',$category_names);

        // 接收搜索条件
        $name=I('get.name');
        $condition=array();
        if($name){
            $condition['name']=['like','%'.$name.'%'];
        }
        // 调用模型
//        dump($this->_model);exit;
        $rows = $this->_model->getPage($condition);
        // 分发数据
        $this->assign($rows);
        $this->display();
    }

    /**
     * 添加品牌
     */
    public function add(){
        if(IS_POST){
            // 自动验证
            if($this->_model->create() === false){
                $this->error($this->_model->getError());
            }
            // 判断插入
            if($this->_model->add_article() === false){
                $this->error($this->_model->getError());
            }

            $this->success('添加数据成功',U('index',['nocache'=>NOW_TIME]));

        }else{
            // 获取文章分类名称
            $category_names=D('ArticleCategory')->select();
            $this->assign('category_names',$category_names);
            $this->display();
        }
    }

    /**
     * 修改品牌
     */
    public function edit($id){
        if(IS_POST){
            // 自动验证
            if($this->_model->create() === false){
                $this->error($this->_model->getError());
            }
            // 判断插入
            if($this->_model->update_article($id) === false){
                $this->error($this->_model->getError());
            }

            $this->success('修改数据成功',U('index',['nocache'=>NOW_TIME]));

        }else{
            // 获取文章信息
            $row=$this->_model->getArticleInfo(intval($id));
            if($row === false){
                $this->error($this->_model->getError());
            }
            // 分发数据
            $this->assign('row',$row);
            // 获取分类数据
            $category_names=D('ArticleCategory')->getList();
            $this->assign('category_names',$category_names);
//            dump($category_names);exit;
            $this->display('add');
        }
    }

    /**
     * 删除品牌
     */
    public function delete($id){
        $data=array(
            'id'=>$id,
            'status'=>0,
            'name'=>array('exp','CONCAT(`name`,"_del")'),
        );
        $this->_model->setField($data);
        $this->success('删除成功',U('index',['nocache'=>NOW_TIME]));
    }


}