<?php
namespace Admin\Model;
use Think\Model;

class PermissionModel extends Model{
  /**
   * @var \Admin\Model\PermissionModel
   */
    protected $_validate=[
        ['name', 'require','商品权限名称不能为空', self::EXISTS_VALIDATE,'',self::MODEL_BOTH],
        ['name', '','商品权限名称已存在', self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT],
    ];

    /**
     * 获取列表
     */
    public function getList(){
      return  $permissions = $this->where(['status'=>1])->order('lft')->select();
    }

    /**
     * 添加数据
     */
    public function addPermission(){
        unset($this->data[$this->pk]);
        // 实例化nested 提供的数据库操作对象
        $orm = D('NestedSetsMysql','Logic');
        // 实例化nested对象
        $nestedSets = new \Admin\Service\NestedSets($orm,$this->trueTableName,'lft','rght','parent_id','id','level');
        if($nestedSets->insert($this->data['parent_id'],$this->data,'bottom')){
            return true;
        }else{
            $this->error = M('Permission')->getError();
            return false;
        }

    }

    /**
     * 更新权限
     */
    public function updatePermission(){
        $request_data = $this->data;
        $parent_id = $this->getFieldById($request_data['id'],'parent_id');
        if($parent_id != $request_data['parent_id']){
            // 实例化nested 提供的数据库操作对象
            $orm = D('NestedSetsMysql','Logic');
            // 实例化nested对象
            $nestedSets = new \Admin\Service\NestedSets($orm,$this->trueTableName,'lft','rght','parent_id','id','level');
            // 修改层级关系
            $res = $nestedSets->moveUnder($request_data['id'],$request_data['parent_id'],'bottom');
            if($res === false){
                $this->error = '父级权限不合法';
                return false;
            }
        }
        return $this->save();
//        dump($this->data['parent_id']);exit;
    }

    /**
     * 删除权限
     */

    public function deletePermission($id){
        // 实例化nested 提供的数据库操作对象
        $orm = D('NestedSetsMysql','Logic');
        // 实例化nested对象
        $nestedSets = new \Admin\Service\NestedSets($orm,$this->trueTableName,'lft','rght','parent_id','id','level');
        // 修改层级关系
        $res = $nestedSets->delete($id);
        if($res === false){
            $this->error = '删除失败';
            return false;
        }else{
            return true;
        }
    }

}