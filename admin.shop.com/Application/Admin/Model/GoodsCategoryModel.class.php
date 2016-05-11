<?php
/**
 * GoodsCategoryModel
 */
namespace Admin\Model;
use Think\Model;

class GoodsCategoryModel extends Model{
    /**
     * @var Admin\Model\GoodsCategoryModel
     */

//    protected $_validate=[
//        ['name', 'require' ,'商品分类名称不为空', self::EXISTS_VALIDATE, '','MODEL_BOTH'],
//        ['name', '' ,'商品分类名称已存在', self::EXISTS_VALIDATE, '','MODEL_INSERT'],
//        ['parent_id', 'require', '商品上级分类不为空', self::EXITSTS_VALIDATE, '','MODEL_BOTH'],
//    ];
    public function getList(){
         return $this->where(['status'=>1])->order('lft')->select();
    }
}