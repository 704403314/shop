<?php
/**
 * 文章分类控制器
 */
namespace Admin\Controller;
use Think\Controller;

/**
 * Class ArticleCategoryController
 * @package Admin\Controller
 */
class ArticleCategoryController extends Controller{
    private $_model=null;
    /**
     * 初始化控制器数据
     */
    public function _initialize(){
        $this->_model=D('ArticleCategory');
        $titles=[
            'index'=>'管理文章分类',
            'add'=>'添加文章分类',
            'edit'=>'修改文章分类',
        ];

        $meta_title=isset($titles[ACTION_NAME])?$titles[ACTION_NAME]:'文章分类管理';

        $this->assign('meta_title',$meta_title);
    }

    /**
     *展示首页
     */
    public function index(){
//        echo  11;exit;
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
            if($this->_model->add_article_category() === false){
                $this->error($this->_model->getError());
            }

            $this->success('添加数据成功',U('index',['nocache'=>NOW_TIME]));

        }else{
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
            if($this->_model->save() === false){
                $this->error($this->_model->getError());
            }

            $this->success('修改数据成功',U('index',['nocache'=>NOW_TIME]));

        }else{
            $row=$this->_model->find(intval($id));
            $this->assign('row',$row);
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
            'name'=>array('exp','concat(`name`,"_del")'),
        );
        $this->_model->setField($data);
        $this->success('删除成功',U('index',['nocache'=>NOW_TIME]));
    }
}