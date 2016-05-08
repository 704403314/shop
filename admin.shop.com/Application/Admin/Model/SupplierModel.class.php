<?php
namespace Admin\Model;
use Think\Model;

/**
 * Description of SupplierModel
 * Class SupplierModel
 * @package Admin\Model
 */
class SupplierModel extends Model{
    // 开启自动验证
    protected $_validate=[
        ['name', 'require', '供应商名称不能为空', self::EXISTS_VALIDATE, '', self::MODEL_BOTH],
        ['name', '', '供应商已存在', self::EXISTS_VALIDATE, 'unique', self::MODEL_INSERT],
    ];

/**
 *获取分页数据
 */
    public function getPage(array $condition=array()){
        $p=I('get.p');
        $condition=array_merge(['status'=>1],$condition);
//        dump($condition);exit;
        // 获取总条数
        $count=$this->where($condition)->count();
        // 实例化分页类
        $page=new \Think\Page($count,C('PAGE_SIZE'));
        // 获取分页html
        $page_html=$page->show();
        // 页数处理
        if($p>$page->totalPages){
            $p=$page->totalPages;
        }
        // 设置分页样式
        $page->setConfig('theme',C('PAGE_THEME'));
        // 获取分页结果集
        $rows=$this->where($condition)->page($p,C('PAGE_SIZE'))->select();
//
        return array('rows'=>$rows,'page_html'=>$page_html);
    }

    /**
     * 添加数据
     */
    public function add_data(){
//        dump($this->data['pk']);exit;
        unset($this->data['pk']);
        return $this->add();
    }
}