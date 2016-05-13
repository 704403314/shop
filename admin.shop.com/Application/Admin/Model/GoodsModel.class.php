<?php
namespace Admin\Model;
use Think\Model;

class GoodsModel extends Model{
    /**
     * @var \Admin\Model\GoodsModel
     */

    protected $_validate=[
        ['name', 'require' ,'商品名称不能为空', self::EXISTS_VALIDATE,'', self::MODEL_BOTH],
        ['goods_category_id','require','商品分类不能为空',self::EXISTS_VALIDATE,'',self::MODEL_BOTH],
        ['brand_id','require','商品品牌不能为空',self::EXISTS_VALIDATE,'',self::MODEL_BOTH],
        ['supplier_id','require','供货商不能为空',self::EXISTS_VALIDATE,'',self::MODEL_BOTH],
        ['shop_price', 'currency' ,'本店价格格式不对', self::EXISTS_VALIDATE,'', self::MODEL_BOTH],
        ['market_price', 'currency' ,'市场价格格式不对', self::EXISTS_VALIDATE,'', self::MODEL_BOTH],
//        ['path', 'require' ,'商品相册不能为空', self::MUST_VALIDATE,'', self::MODEL_BOTH],

    ];
    protected $_auto=[
        ['inputtime', NOW_TIME, self::MODEL_INSERT],
        ['goods_status', 'array_sum', self::MODEL_BOTH,'function'],
        ['sn', 'createSn', self::MODEL_INSERT,'callback'],
    ];

    /**
     * 生成料号
     */
    public function createSn($sn){
        if($sn){
            return $sn;
        }
        //获取现有商品数量
        $num = M('GoodsNums')->getFieldByDate(date('Ymd'),'num');
        //生成后缀
        if($num){ //能够获取商品数量
            $num++;
            $str = str_pad($num,6,0,STR_PAD_LEFT );
        }else{ //不能获取商品数量
            $num = 1;
            $str = str_pad($num,6,0,STR_PAD_LEFT );
        }
        //sn20160513000001
        $sn = 'sn'.date('Ymd').$str;
        return $sn;
    }

    /**
     * 添加数据
     */

    public function addGoods(){
    // 删除隐藏域可能传过来的主键值
//        dump($this->pk);exit;
        unset($this->data[$this->pk]);
//        dump($this->data['sn']);exit;
        // 开启事务
        $this->startTrans();
        // 插入数据 并获取添加的id
        if(($id = $this->add()) === false){
            $this->rollback();
            return false;
        }
        // 准备添加商品介绍数据
        $data = [
            'goods_id'=>$id,
            'content'=>I('post.content','',false)
        ];
        // 实例化商品介绍类 并添加数据
        $res = M('GoodsIntro')->add($data);
        if($res === false){
            $this->error = M('GoodsIntro')->getError();
            $this->rollback();
            return false;
        }

        // 获取传过来的相册图片地址
        $paths = I('post.path');
        if($paths == false){
            $this->error = '商品相册必选';
            $this->rollback();
            return false;
        }

        // 准备添加相册数据
        $gallery_data = '';
        foreach($paths as $v){
            $gallery_data[]=[
                 'goods_id'=>$id,
                 'path'=>$v,
            ] ;
        }

        // 添加相册数据
//        dump($gallery_data);exit;
        $res = M('GoodsGallery')->addAll($gallery_data);
        if($res === false){
            $this->error = M('GoodsGallery')->getError();
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;


    }
}