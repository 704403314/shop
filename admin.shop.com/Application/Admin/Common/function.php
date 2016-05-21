<?php
/**
 * 设置或获取保存在session中的管理员信息
 * @param $admin_info 管理员信息
 */
function login($admin_info=''){
    if($admin_info){
        // 设置session信息
        session('ADMIN_INFO',$admin_info);
    }else{
       return session('ADMIN_INFO');
    }
}

/**
 * 保存或获取session中的路径信息
 */
function permission_paths($paths=''){
    if($paths){
        // 设置session信息
        session('PATHS',$paths);
    }else{
        return session('PATHS');
    }
}

/**
 * 保存或获取session中的permission_ids
 */
function permission_ids($permission_ids=''){
    if($permission_ids){
        // 设置session信息
        session('PERMISSION_IDS',$permission_ids);
    }else{
        return session('PERMISSION_IDS');
    }
}