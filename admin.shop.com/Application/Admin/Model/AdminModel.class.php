<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16-5-15
 * Time: 下午8:40
 */

namespace Admin\Model;

use Think\Model;

class AdminModel extends Model{
    /**
     * @var \Admin\Model\AdminModel
     */
    protected $_validate=[
        ['username', 'require','角色名称不能为空', self::EXISTS_VALIDATE,'',self::MODEL_INSERT],
        ['username', '','角色名称已存在', self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT],
        ['password', 'require','密码不能为空', self::EXISTS_VALIDATE,'',self::MODEL_INSERT],
        ['repassword', 'password','两次密码不一致', self::EXISTS_VALIDATE,'confirm',self::MODEL_BOTH],
        ['email', 'email','邮箱不合法', self::EXISTS_VALIDATE,'',self::MODEL_INSERT],

//        ['captcha', 'check_verify','验证码不正确', self::EXISTS_VALIDATE,'callback','login'],
        ['username', 'require','用户名不能为空', self::EXISTS_VALIDATE,'login',],
        ['password', 'require','密码不能为空', self::EXISTS_VALIDATE,'','login'],
    ];


    // 自动完成
    protected $_auto = [
        ['add_time', NOW_TIME, self::MODEL_INSERT],
        ['salt','\Org\Util\String::randString',self::MODEL_BOTH,'function',6],
    ];

    /**
     * 验证验证码
     */
    public function check_verify($captcha,$id=''){
//        $captcha = md5($captcha);
//        dump($_SESSION);dump($captcha);exit;
////        dump($captcha);exit;

        $verify = new \Think\Verify();
        return $verify->check($captcha,$id);

    }

    /**
     * 验证登录
     */
    public function login(){
        $tp_data = $this->data;
        // 根据传过来的用户名取数据库查找数据
        $admin_info = $this->where(['username' => $this->data['username']])->find();
        // 找不到返回错误
        if(empty($admin_info)){

            $this->error = '用户名或密码错误';
            return false;
        }

        // 对传过来的密码加盐加密
        $password = salt_mcrypt($tp_data['password'],$admin_info['salt']);
//        dump($password);dump($admin_info['password']);exit;

        if($admin_info['password'] != $password){
            $this->error = '用户名或密码错误';
            return false;
        }else{
            // 更新最后登录时间 和最后登录ip
            $data=[];
            $data=[
                'id'=>$admin_info['id'],
                'last_login_time'=>NOW_TIME,
                'last_login_ip'=>get_client_ip(),
            ];
            $this->setField($data);
            session('ADMIN_INFO',$admin_info);
            // 获取用户可以访问的path列表
            $this->_save_permission($admin_info['id']);
//            dump(session('admin_info'));exit;
            return true;
        }
    }

    /**
     * 保存该管理员可访问的权限
     */

    public function _save_permission($id){
        // 获取管理员可以访问的sql
        $sql = 'SELECT DISTINCT path  FROM (
            SELECT permission_id FROM admin_role AS ar LEFT JOIN role_permission AS rp ON ar.role_id=rp.role_id
            WHERE ar.admin_id='.$id.'
UNION SELECT permission_id FROM admin_permission AS ap
            WHERE ap.admin_id='.$id.'
) AS res LEFT JOIN permission AS p ON res.permission_id=p.id WHERE p.path <> ""';

        $allow_paths = M()->query($sql);
//
        $paths = [];
        if($allow_paths){
            foreach($allow_paths as $v){
                $paths[]=$v['path'];
            }
        }
//        dump($paths);exit;
        // 将可访问的路径保存到session
        session('PATHS',$paths);
//        dump(session('PATHS'));exit;

    }


   /**
     * 获取管理员结果集
     */
    public function getList(){
        return $this->select();
    }

    /**
     * 获取角色信息结果集
     */
    public function getAdminInfo($id){
        // 获取管理员表信息
        $row = $this->find($id);
        // 获取角色信息表信息
        $row['role_id'] = json_encode(M('AdminRole')->where(['admin_id'=>$id])->getField('role_id',true));
        $row['permission_ids'] = json_encode(M('AdminPermission')->where(['admin_id'=>$id])->getField('permission_id',true));
//        dump($row);exit;
         return  $row;
    }


    public function addAdmin(){
        unset($this->data[$this->getPk()]);
        $this->startTrans();
        $this->data['password'] = salt_mcrypt($this->data['password'],$this->data['salt']);
        if(($id=$this->add()) === false){
            $this->error = '添加基本信息失败';
            $this->rollback();
            return false;
        }

        // 添加管理员-角色表
        if($this->_save_role_info($id,true) === false){
            $this->rollback();
            return false;
        }
        // 添加管理员-权限表
        if($this->_save_permission_info($id,true) === false){
            $this->rollback();
            return false;
        }

        $this->commit();
        return true;
    }

    public function updateAdmin(){
        // 保存一份传过来的数据
        $r_data = $this->data;
        $this->startTrans();
        if(!empty($r_data['password'])){
            $this->data['password'] = salt_mcrypt($this->data['password'],$this->data['salt']);
            if($this->save() === false){
                $this->error = '更新基本信息失败';
                $this->rollback();
                return false;
            }
        }
        // 添加管理员-角色表
        if($this->_save_role_info($r_data['id'],false) === false){
            $this->rollback();
            return false;
        }
         // 添加管理员-权限表
        if($this->_save_permission_info($r_data['id'],false) === false){
            $this->rollback();
            return false;
        }

        $this->commit();
        return true;
    }


    /**
     * 删除管理员
     */
    public function deleteAdmin($id){
        $this->startTrans();
        // 删除管理员表信息
        if($this->delete($id) === false){
            $this->error = '删除管理员表失败';
            $this->rollback();
            return false;
        }

        // 删除管理员-角色表
        if(M('AdminRole')->where(['admin_id'=>$id])->delete() === false){
            $this->error = '删除管理员-角色表失败';
            $this->rollback();
            return false;
        }
        // 删除管理员-权限表
        if(M('AdminPermission')->where(['admin_id'=>$id])->delete() === false){
            $this->error = '删除管理员-权限表失败';
            $this->rollback();
            return false;
        }
//        dump($this->getLastSql());exit;
        $this->commit();
        return true;
    }

    /**
     * 保存管理员-权限信息
     */
    protected function _save_permission_info($id,$is_new){
        // 获取传过来的关联权限数据
        $permissions = I('post.permission_ids');

        if(!empty($permissions)){
            // 删除原有管理员角色表信息
            if(!$is_new){
                if(M('AdminPermission')->where(['admin_id'=>$id])->delete()===false){
                    $this->error = '删除原有管理员权限信息失败';

                    return false;
                }
            }

            $admin_permission_data = [];
            // 准备添加管理员-权限表数据
            foreach($permissions as $permission){
                $admin_permission_data[] = [
                    'admin_id'=>$id,
                    'permission_id'=>$permission,
                ];
//                dump($admin_permission_data);exit;
                // 添加管理员-权限表

            }
            if(M('AdminPermission')->addAll($admin_permission_data) === false){
                $this->error = '添加管理员-权限关联表失败';

                return false;
            }
        }

        return true;
    }

/**
 * 添加管理员-角色信息
 */
    protected function _save_role_info($id,$is_new){

            // 获取传过来的关联角色信息
            $admin_role = I('post.role_id');

            if(!empty($admin_role)){
                if(!$is_new){
                    // 删除原有管理员角色表信息
                    if(M('AdminRole')->where(['admin_id'=>$id])->delete()===false){
                        $this->error = '删除原有管理员角色信息失败';

                        return false;
                    }
                }
                // 准备添加管理员角色表数据
                $data = [];
                foreach($admin_role as $v){
                    $data[] = [
                        'admin_id'=>  $id,
                        'role_id'=>$v,
                    ];
                }
                // 添加管理员角色表
                if(M('AdminRole')->addAll($data) === false){
                    $this->error = '添加管理员-角色关联表失败';
                    return false;
                }
        }
        return true;
    }

}