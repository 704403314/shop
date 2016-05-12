<?php
namespace Admin\Model;
use Think\Model;

class GoodsCategoryModel extends Model{
    /**
     * @var \Admin\Model\GoodsCategoryModel
     */

    protected $_validate=[
        ['name' ,'require' ,'商品分类名称不能为空', self::EXISTS_VALIDATE, '', self::MODEL_BOTH],
        ['name' ,'' ,'商品分类名称已存在', self::EXISTS_VALIDATE, 'unique', self::MODEL_INSERT],

    ];
    /**
     * 获取列表数据
     * @return mixed
     */
    public function getList(){
         return $this->where(['status'=>1])->order('lft')->select();
    }

    /**
     * 准备分页数据
     */
    public function getPage(){
        $size=C('PAGE_SIZE');
        $cond = ['status'=>1];
        // 获取总条数
        $count = $this->where($cond)->count();
        // 实例化分页类
        $page = new \Think\Page($count,$size);
        // 设置分页样式
        $page->setConfig('theme',C('PAGE_THEME'));
        // 准备分页html
        $page_html = $page->show();
        $p = I('get.p');
        if($p > $page->totalPages){
            $p = $page->totalPages;
        }
        // 获取分页数据集
        $rows = $this->where($cond)->page($p,$size)->order('lft')->select();
        return ['rows'=>$rows,'page_html'=>$page_html];
    }

    /**
     * 添加数据
     *
     */
    public function addCategory(){
//
        // 实例化数据库操作类的对象
        $orm = D('NestedSetsMysql','Logic');
        // 实例化nestedSets 对象
        $nestedSets = new \Admin\Service\NestedSets($orm,$this->trueTableName, 'lft' ,'rght', 'parent_id', 'id', 'level');
        $cat_id = $nestedSets->insert($this->data['parent_id'], $this->data, 'bottom');
//        exit;
        if($cat_id){ //添加数据成功
            return $cat_id;
        }else{
            $this->error = M()->getError();
            return false;
        }
    }

    /**
     * 修改数据
     */
    public function updateCategory(){
        // 先判断是否修改了父类
        $parent_id = $this->getFieldById($this->data["id"],'parent_id');
        if($parent_id != $this->data['parent_id']){
            // 实例化数据库操作对象
            $orm = D('NestedSetsMysql','Logic');
            // 实例化nestedSets 对象
            $nestedSets = new \Admin\Service\NestedSets($orm,$this->trueTableName,'lft','rght','parent_id','id','level');
            $res = $nestedSets->moveUnder($this->data['id'],$this->data['parent_id'],'bottom');
            if($res === false){
                $this->error('父级分类不正确');
                return false;
            }
        }

        return $this->save();
    }

    /**
     * 删除方法
     */
    public function deleteCategory($id){
//        // 获取左右边界值
//        $fields = array_shift($this->where(['id'=>$id])->getField('id,lft,rght'));
////        dump($fields);exit;
//        // 准备删除条件需要的参数
//        $cond=[
//
//            'lft'=>array('egt',$fields['lft']),
//            'rght'=>array('elt',$fields['rght']),
//        ];
//        // 逻辑删除
//        $config=[
//            'status'=>0,
//        ];
//        return $this->where($cond)->save($config);
        // 实例化数据库操作对象
        $orm = D('NestedSetsMysql','Logic');
        // 实例化nestedSets 对象
        $nestedSets = new \Admin\Service\NestedSets($orm,$this->trueTableName,'lft','rght','parent_id','id','level');
        return $nestedSets->delete($id);
    }

}