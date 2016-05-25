<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16-5-23
 * Time: 下午3:53
 */

namespace Home\Model;


use Think\Model;

class AddressModel extends Model{

    /**
     * 添加地址
     */
    public function addAddress(){
        // 删除主键
        unset($this->data[$this->pk]);
//        dump($this->data);exit;
        // 获取当前用户信息
        $user_info = login();
        if($this->data['is_default']){
            $this->where(['member_id'=>$user_info['id']])->setField('is_default',0);
        }
        $this->data['member_id'] = $user_info['id'];

        return $this->add();

    }

    /**
     * 修改地址
     */
    public function editAddress(){

//
        // 获取当前用户信息

        $user_info = login();
        if(isset($this->data['is_default'])){
            // 先删除之前所有的不设置默认
            $this->where(['member_id'=>$user_info['id']])->setField('is_default',0);
        }
        $this->data['member_id'] = $user_info['id'];
        $data = $this->data;

//        dump($this->data);exit;
         $row = $this->save($this->data);

        return $row;

    }

    /**
     * 获取省级数据
     */
    public function getAddress($pid=0){
        return M('Locations')->where(['parent_id'=>$pid])->select();
    }

    /**
     * 获取所有地址
     */
    public function getList(){
        $user_info = login();
        $rows = $this->where(['member_id'=>$user_info['id']])->select();
//        dump($this->getLastSql());exit;
        return $rows;
    }

    /**
     * 获取当前id 对应的 地址信息
     */
    public function getAddressInfo($id){
        // 获取用户信息
        $user_info = login();
        $row = $this->where(['member_id'=>$user_info['id']])->find($id);
//        dump($row);exit;
        return $row;
    }

}