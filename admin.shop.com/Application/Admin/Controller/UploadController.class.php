<?php
/**
 * 上传文件控制器
 */
namespace Admin\Controller;
use Think\Controller;

/**
 * Class UploadController
 * @package Admin\Controller\UploadController
 */
class UploadController extends Controller{
    /**
     * 上传文件
     */
     public function Upload(){
        $config=C('UPLOAD_SETTING');
         // 实例化上传工具类
        $upload=new \Think\Upload($config);
         // 调用上传多文件方法
        $file_infos=$upload->upload();

         if($file_infos){
             // 获取上传的第一条文件信息
             $file_info=array_shift($file_infos);
             // 拼接保存根路径
             $root_path = str_replace(SITE_ROOT, '', $config['rootPath']);
             // 判断上传驱动是否是七牛云
             if($upload->driver == 'Qiniu'){
//                 var_dump(111);exit;
                 $file_url = $file_info['url'];
             }else{
                 // 拼接保存地址
                 $file_url = MY_URL . $root_path . $file_info['savepath'] . $file_info['savename'];
             }
//             var_dump($file_info);exit;
             $return=[
                 "status"  => 1,
                 'msg'     => '',
                 'file_url'=>  $file_url,
             ];
         }else{
             $return=[
               "status"  => 0,
               'msg'     => $upload->getError(),
               'file_url'=>  '',
             ];
         }

         $this->ajaxreturn($return);
     }
}