<?php
namespace Admin\Controller;


use Think\Controller;

class GoodsGalleryController extends Controller{

    /**
     * 删除相册
     */
    public function delete($id){
        $res = M('GoodsGallery')->delete($id);
        if($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
}