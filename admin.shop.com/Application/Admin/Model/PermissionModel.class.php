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
        $this->startTrans();
        // 实例化nested 提供的数据库操作对象
        $orm = D('NestedSetsMysql','Logic');
        // 实例化nested对象
        $nestedSets = new \Admin\Service\NestedSets($orm,$this->trueTableName,'lft','rght','parent_id','id','level');

        // 获取当前记录信息
        $permission_info = $this->field('lft,rght')->find($id);
        // 因为同时要删除子节点 所以保存要删除 权限的节点范围
        $cond = [
          'lft'=>['egt',$permission_info['lft']],
            'rght'=>['elt',$permission_info['rght']],
        ];


        // 根据要删除的节点范围获取所有要删除的权限id
        $range = $this->where($cond)->getField('id',true);
//        dump($permission_info);exit;
        // 删除角色-权限关联关系
        if(M('RolePermission')->where(['permission_id'=>['in',$range]])->delete() === false){
            $this->error = '删除角色-权限关联关系失败';
            $this->rollback();
            return false;
        }

        // 删除管理员-权限关联关系
        if(M('AdminPermission')->where(['permission_id'=>['in',$range]])->delete() === false){
            $this->error = '删除管理员-权限关联关系失败';
            $this->rollback();
            return false;
        }

        // 删除层级关系
        $res = $nestedSets->delete($id);
        if($res === false){
            $this->error = '删除失败';
            $this->rollback();
            return false;
        }else{
            $this->commit();
            return true;
        }
    }

}