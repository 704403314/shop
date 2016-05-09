<?php
namespace Admin\Model;
use Think\Model;

class ArticleCategoryModel extends Model{
    protected $_validate=[
        ['name' ,'require' ,'文章分类名称不能为空', self::EXISTS_VALIDATE, '', self::MODEL_BOTH],
        ['name' ,'' ,'文章分类名称已存在', self::EXISTS_VALIDATE, 'unique', self::MODEL_INSERT],
        ['status' ,'require' ,'文章状态不能为空', self::EXISTS_VALIDATE, '', self::MODEL_BOTH],
        ['sort' ,'require' ,'文章分类排序不能为空' , self::EXISTS_VALIDATE, '', self::MODEL_BOTH],
        ['is_help' ,'require' ,'文章是否是帮助文档不能为空', self::EXISTS_VALIDATE, '', self::MODEL_BOTH],
    ];

    /**
     * 获取分页数据
     * @param array $condition
     * @return array
     */
    public function getPage(array $condition=[]){
        // 获取p参数
        $p=I('get.p');
        // 获取总条数
        $condition=array_merge(['status'=>1],$condition);
        $count=$this->where($condition)->count();
        $page = new \Think\Page($count,C('PAGE_SIZE'));
        $page_html=$page->show();

        if($p>$page->totalPages){
            $p = $page->totalPages;
        }
        $page->setConfig('theme', C('PAGE_THEME'));
        $rows=$this->where($condition)->page($p,C('PAGE_SIZE'))->select();
        return array('rows'=>$rows ,'page_html'=>$page_html);
    }

    /**
     * 添加文章分类
     * @return mixed
     */

    public function add_article_category(){
        // 删除隐藏域中的pk
        unset($this->data['pk']);
            return $this->add();
//            dump($this->data['logo']);exit;
    }

    /**
     * 获取文章分类信息
     */
    public function  getList($field='*'){
        if($field=='*'){
            return $this->where(['status'=>1])->select();
        }else{
            return $this->where(['status'=>1])->getField($field);
        }
    }
}