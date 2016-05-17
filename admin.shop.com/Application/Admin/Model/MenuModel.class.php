<?php
namespace Admin\Model;


use Think\Model;

class MenuModel extends Model{
    /**
     * @var \Admin\model\MenuModel
     */

//    protected $_validate=[
//        ['name', 'require','商品权限名称不能为空', self::EXISTS_VALIDATE,'',self::MODEL_BOTH],
//        ['name', '','商品权限名称已存在', self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT],
//    ];

    /**
     * 获取列表
     */
    public function getList(){
        return   $this->where(['status'=>1])->order('lft')->select();
    }

    /**
     * 获取菜单信息
     */
    public function getMenuInfo($id){
        $row = $this->where(['status'=>1])->find($id);
        $row['permission_ids'] = json_encode(M('MenuPermission')->where(['menu_id'=>$id])->getField('permission_id',true));
        return $row;
    }


    /**
     * 添加数据
     */
    public function addMenu(){
        unset($this->data[$this->pk]);
        $this->startTrans();
        // 实例化nested 提供的数据库操作对象
        $orm = D('NestedSetsMysql','Logic');
        // 实例化nested对象
        $nestedSets = new \Admin\Service\NestedSets($orm,$this->trueTableName,'lft','rght','parent_id','id','level');
        if(($id=$nestedSets->insert($this->data['parent_id'],$this->data,'bottom'))===false){

            $this->error = '添加菜单表失败';
            $this->rollback();
            return false;

        }

            $permission_ids = I('post.permission_id');
//            dump($permission_ids);exit;
            // 选择了权限要添加
            if(!empty($permission_ids)){
                // 准备更新数据
                 $data = [];
                foreach($permission_ids as $v){
                    $data[]=[
                      'menu_id'=>$id,
                      'permission_id'=>$v,
                    ];
                }
                // 添加菜单-权限表
                if(M('MenuPermission')->addAll($data)===false){
                    $this->error = '添加菜单-权限表失败';
                    $this->rollback();
                    return false;
                }
            }
            $this->commit();
            return true;



    }

    /**
     * 更新权限
     */
    public function updateMenu(){
        $id = $this->data['id'];
        $this->startTrans();
        // 获取数据库中对应父节点id
        $parent_id = $this->getFieldById($id,'parent_id');
        // 判断数据库中对应父节点id和传过来是否一样
        if($parent_id != $this->data['parent_id']){
            // 实例化nested 提供的数据库操作对象
            $orm = D('NestedSetsMysql','Logic');
            // 实例化nested对象
            $nestedSets = new \Admin\Service\NestedSets($orm,$this->trueTableName,'lft','rght','parent_id','id','level');
            if($nestedSets->moveUnder($this->data['id'],$this->data['parent_id'],'bottom')===false){

                $this->error = '修改菜单表失败';
                $this->rollback();
                return false;
            }
        }
        $this->save();

            // 获取传过来的权限
            $permission_ids = I('post.permission_id');
//            dump($permission_ids);exit;
            if(!empty($permission_ids)){

                // 清空当前菜单对应的权限

                if(M('MenuPermission')->where(['menu_id'=>$id])->delete()===false){
                    $this->error = '删除原有菜单-权限失败';
                    $this->rollback();
                    return false;
                }
                // 准备更新数据
                $data = [];
                foreach($permission_ids as $v){
                    $data[]=[
                        'menu_id'=>$id,
                        'permission_id'=>$v,
                    ];
                }
//                dump($data);exit;
                // 更新菜单-权限表
                if(M('MenuPermission')->addAll($data)===false){
                    $this->error = '修改菜单-权限表失败';
                    $this->rollback();
                    return false;
                }
            }

            $this->commit();
            return true;
    }

    public function deleteMenu($id){
        $this->startTrans();
        $tp_data = $this->data;
        // 实例化nested 提供的数据库操作对象
        $orm = D('NestedSetsMysql','Logic');
        // 实例化nested对象
        $nestedSets = new \Admin\Service\NestedSets($orm,$this->trueTableName,'lft','rght','parent_id','id','level');

        // 获取当前菜单信息
        $menu_info = $this->field('lft,rght')->find($id);
        $cond = [];
        $cond = [
            'lft'=>['egt',$menu_info['lft']],
            'rght'=>['elt',$menu_info['rght']],
        ];
        // 根据左右节点范围获取需要删除的id
        $ids = $this->where($cond)->getField('id',true);
        if($nestedSets->delete($id)===false){
            $this->error = '删除菜单表失败';
            $this->rollback();
            return false;
        }

        if(M('MenuPermission')->where(['menu_id'=>['in',$ids]])->delete()===false){
            $this->error = '删除菜单-权限表失败';
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }


}