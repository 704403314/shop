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
    // 保存商品状态数据
    public $goods_statues = [
       1=>'精品',
       2=>'新品',
       4=>'热销',
    ];
    // 保存商品是否上架信息
    public $is_on_sale = [
        1=>'上架',
        0=>'下架',
    ];


    /**
     *
     */
    public function getCond(){
        $cond = [];
        // 获取商品分类
        $goods_category_id = I('get.goods_category_id');
        if($goods_category_id){
            $cond['goods_category_id'] = $goods_category_id;
        }
        // 获取商品品牌
        $brand_id= I('get.brand_id');
        if($brand_id){
            $cond['brand_id'] = $brand_id;
        }
        // 获取商品状态
        $goods_status= I('get.goods_status');
        if($goods_status){
            $cond[] = "goods_status & $goods_status";
        }
        // 获取商品是否上架
        $is_on_sale = I('get.is_on_sale');
        if(strlen($is_on_sale)){
            $cond['is_on_sale'] = $is_on_sale;
        }
        // 获取商品关键字
        $keyword = I('get.keyword');
        if($keyword){
            $cond['name'] = array('like','%'.$keyword.'%');
        }

        return $cond;
    }

    /**
     * 生成料号
     */
    protected function createSn($sn){
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

    public function getPage(array $cond=[]){
        // 接收页数
        $p = I('post.p');
        $size = C('PAGE_SIZE');
        // 搜索条件
        $cond = array_merge(['status'=>1],$cond);
        // 获取总条数
        $count = $this->where($cond)->count();
//        dump($this->getLastSql());exit;
        // 实例化分页类
        $page = new \Think\Page($count,$size);
        // 获取分页html
        $page_html = $page->show();
        // 分页样式
        $page->setConfig('theme',C('PAGE_THEME'));
        // 判断页数
        if($p > $page->totalPages){
            $p = $page->totalPages;
        }
        // 获取分页数据结果集
        $rows = $this->where($cond)->page($p,$size)->select();
        // 处理商品状态数据
        $status = [];
        foreach($rows as &$v){
            $status['best'] = $v['goods_status'] & 1?1:0;
            $status['new'] = $v['goods_status'] & 2?1:0;
            $status['hot'] = $v['goods_status'] & 4?1:0;
            $v['goods_status'] = $status;
        }
//        dump($rows);exit;
        return array('page_html'=>$page_html,'rows'=>$rows);
    }

    /**
     * 添加商品数量数据
     */
    public function _saveNums(){
        // 先判断当天是否已经有商品录入
        $num = M('goodsNums')->getFieldByDate(date('Ymd'),'num');
        if($num == false){ //没有商品录入 添加数据
            // 准备商品数量表数据
            $goods_nums = [
                'date' =>date('Ymd'),
                'num'=>1,
            ];
            $res = M('goodsNums')->add($goods_nums);
            return $res;
        }else{ //已有商品录入 商品数量加1
            $goods_nums = [
                'date' =>date('Ymd'),
                'num'=>$num+1,
            ];
            $res = M('goodsNums')->save($goods_nums);
//            dump($res);exit;

            return $res;
        }
//

    }

    /**
     * 添加数据
     */

    public function addGoods(){
        // 删除隐藏域可能传过来的主键值
        unset($this->data[$this->pk]);
        // 开启事务
        $this->startTrans();
        // 插入数据 并获取添加的id
        if(($id = $this->add()) === false){
            $this->rollback();
            return false;
        }
        $res = $this->_saveNums();

        if($res === false){
            $this->error = M('GoodsNums')->getError();
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

        // 添加会员价格
        $data = [];
        $member_prices = I('post.member_price');
        foreach($member_prices as $key=>$goods_level_price){
            if(empty($goods_level_price)){
                continue;
            }
            $data[] = [
                'goods_id'=>$id,
                'member_level_id'=>$key,
                'price'=>$goods_level_price,
            ];
        }
        $member_goods_model = M('MemberGoodsPrice');
        if($member_goods_model->addAll($data) === false){
            $this->error = '添加会员价格失败';
            $this->rollback();
            return false;
        }

        $this->commit();
        return true;
    }

    /**
     * 修改商品信息
     */
    public function updateGoods($id){

        // 开启事务
        $this->startTrans();
        // 更新基本数据
        if($this->save() === false){
            $this->rollback();
            return false;
        }
        // 准备更新商品介绍数据
        $data = [
            'goods_id'=>$id,
            'content'=>I('post.content','',false)
        ];
        // 实例化商品介绍类 并修改数据
        $res = M('GoodsIntro')->save($data);
        if($res === false){
            $this->error = M('GoodsIntro')->getError();
            $this->rollback();
            return false;
        }

        // 获取传过来的相册图片地址
        $paths = I('post.path');
        if($paths != false){
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
        }



        // 先删除商品原有会员价格
        $member_goods_model = M('MemberGoodsPrice');
        $member_goods_model->where(['goods_id'=>$id])->delete();
        // 添加会员价格
        $data = [];
        $member_prices = I('post.member_price');
        foreach($member_prices as $key=>$goods_level_price){
            if(empty($goods_level_price)){
                continue;
            }
            $data[] = [
                'goods_id'=>$id,
                'member_level_id'=>$key,
                'price'=>$goods_level_price,
            ];
        }

        if($member_goods_model->addAll($data) === false){
            $this->error = '添加会员价格失败';
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }

    /**
     * 获取商品信息
     */
    public function getGoodsIntro($id){
        $row = $this->alias('g')
            ->join("__GOODS_INTRO__ as i on g.id = i.goods_id")
            ->find($id);
        $row['paths'] = M('GoodsGallery')->where(['goods_id'=>$id])->getField('id,path',true);
//        dump($row['paths']);exit;
        return $row;
    }
}