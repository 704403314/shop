<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16-5-15
 * Time: 下午8:40
 */

namespace Admin\Model;

use Think\Model;

class RoleModel extends Model{
    /**
     * @var \Admin\Model\RoleModel
     */
    protected $_validate=[
        ['name', 'require','角色名称不能为空', self::EXISTS_VALIDATE,'',self::MODEL_BOTH],
        ['name', '','角色名称已存在', self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT],
    ];
    /**
     * 获取角色结果集
     */
    public function getList(){
        return D('Permission')->where(['status'=>1])->select();
    }

    /**
     * 添加权限
     */
    public function addRole(){
        unset($this->data[$this->pk]);

        // 开启事务
        $this->startTrans();
        $id = $this->add();
        if($id === false){
            // 添加基本信息失败
            $this->rollback();
            return false;
        }
        $permission_ids = I('post.permission_ids');
        // 判断是否选择了权限
        if(!empty($permission_ids)) {
            // 保存角色权限
            $res = $this->_save_role_permission($permission_ids, $id);
            if ($res === false) {
                // 添加失败
                $this->error = M('RolePermission')->getError();
                $this->rollback();
                return false;
            }
        }
        // 提交
        $this->commit();
        return true;
//        dump($permission_ids==false);exit;
    }

    /**
     * 修改 角色信息
     */
    public function updateRole(){
        $_data = $this->data;
        // 开启事务
        $this->startTrans();
        if($this->save() === false){
            // 添加基本信息失败
            $this->rollback();
            return false;
        }
        $permission_ids = I('post.permission_ids');
        // 判断是否选择了权限
        if(!empty($permission_ids)){
            // 先删除原有角色权限
            $result = M('RolePermission')->where(['role_id'=>$_data['id']])->delete();
            if($result === false){
                $this->error = '删除原有角色权限失败';
                $this->rollback();
                return false;
            }
            // 调用添加角色权限方法
            $res = $this->_save_role_permission($permission_ids,$_data['id']);
            if($res === false){
                // 添加失败
                $this->error = M('RolePermission')->getError();
                $this->rollback();
                return false;
            }
        }
        // 提交
        $this->commit();
        return true;
    }

    /**
     * 保存角色权限信息
     */
    public function _save_role_permission($permission_ids,$id){
        $data = [];
        foreach($permission_ids as $v){
            $data[] = [
                'role_id'=>  $id,
                'permission_id'=>$v,
            ];
        }
        // 添加角色权限表
        $res = M('RolePermission')->addAll($data);
    }

    /**
     * 获取角色信息
     */
    public function getRoleInfo($id){
        $row = $this->where(['status'=>1])->find($id);
        $row['permission_ids'] = json_encode(M('RolePermission')->where(['role_id'=>$id])->getField('permission_id',true));
//        dump($row);exit;
        return $row;
    }

    /**
     * 删除角色
     */
    public function deleteRole($id){
        $this->startTrans();
        // 删除角色信息
        if($this->where(['id'=>$id])->delete() === false){
            $this->error = "删除角色信息失败";
            $this->rollback();
            return false;
        }

        // 删除权限信息
        if(M('RolePermission')->where(['role_id'=>$id])->delete() === false){
            $this->error = "删除权限信息失败";
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }
}