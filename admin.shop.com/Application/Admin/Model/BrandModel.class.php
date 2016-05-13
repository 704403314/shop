<?php
namespace Admin\Model;
use Think\Model;

/**
 * Class BrandModel
 * @package Admin\Model
 */
class BrandModel extends Model{
    protected $_validate=[
        ['name', 'require', '品牌名称不能为空', self::EXISTS_VALIDATE, '', self::MODEL_BOTH],
        ['name', '', '品牌名称已存在', self::EXISTS_VALIDATE, 'unique', self::MODEL_INSERT],
    ];

    /**
     * 获取分页数据
     * @param array $condition
     * @return array
     */
    public function getPage(array $condition=[]){
        // 获取p参数
        $p=I('get.p');
        // 获取总条数
        $condition=array_merge(['status'=>1],$condition);
        $count=$this->where($condition)->count();
        $page = new \Think\Page($count,C('PAGE_SIZE'));
        $page->setConfig('theme',C('PAGE_THEME'));

        $page_html=$page->show();

        if($p>$page->totalPages){
            $p = $page->totalPages;
        }
        $rows=$this->where($condition)->page($p,C('PAGE_SIZE'))->select();
        return array('rows'=>$rows ,'page_html'=>$page_html);
    }

    /**
     * 添加品牌
     * @return mixed
     */

    public function add_brand(){
        // 删除隐藏域中的pk
        unset($this->data['pk']);
//        dump($_FILES['logo']);exit;
//        if($_FILES['logo']['size']>0){
//            // 上传图片的配置信息
//            $config=array(
//               'maxSize'=>1024*1024*1,
//               'exts'=>array('jpg','png','gif','zip'),
//               'rootPath'=>'./Upload/',
//            );
//             $uploader=new \Think\Upload($config);
//            if($res=$uploader->uploadOne($_FILES['logo'])){
//                //保存上传后的路径
//                $this->data['logo']=$config['rootPath'].$res['savepath'].$res['savename'];
//            }else{
//                $this->error($uploader->getError());
//            }
//
//            $image=new \Think\Image();
//            // 打开一张图片
//            $image->open($this->data['logo']);
//            // 生成图片
//            $image->thumb('100','100');
//            // 保存图片
//            $image->save($this->data['logo']);
            return $this->add();
//            dump($this->data['logo']);exit;

//        }else{
//            return false;
//        }

    }

    /**
     * 修改品牌
     */
    public function edit_brand(){

//        if($_FILES['logo']['size']>0){
//            // 上传图片的配置信息
//            $config=array(
//                'maxSize'=>1024*1024*1,
//                'exts'=>array('jpg','png','gif','zip'),
//                'rootPath'=>'./Upload/',
//            );
//            $uploader=new \Think\Upload($config);
//            if($res=$uploader->uploadOne($_FILES['logo'])){
//                //保存上传后的路径
//                $this->data['logo']=$config['rootPath'].$res['savepath'].$res['savename'];
//            }else{
//                $this->error($uploader->getError());
//            }
//
//            $image=new \Think\Image();
//            // 打开一张图片
//            $image->open($this->data['logo']);
//            // 生成图片
//            $image->thumb('100','100');
//            // 保存图片
//            $image->save($this->data['logo']);
            return $this->save();
////            dump($this->data['logo']);exit;
//        }else{
//
//            return false;
//        }
    }

    /**
     * 品牌列表数据
     */
    public function getList(){
        return $this->where(['status'=>1])->select();
    }

}