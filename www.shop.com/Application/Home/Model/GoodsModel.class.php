<?php
namespace Home\Model;
use Think\Model;

class GoodsModel extends Model{
    /**
     * 获取对应商品状态数据
     */
    public function get_goods_status_data($goods_status){
//        $cond[] = ' goods_status &'.$goods_status;
//        $cond['status'] = 1;
//        $cond['is_on_sale'] = 1;
        $cond = [
            'status'=>1,
            'is_on_sale'=>1,
            0=>' goods_status &'.$goods_status,
        ];
//        dump($cond);
//        $res = $this->where($cond)->select();
//        dump($res);
//        exit;
        return $res = $this->where($cond)->select();

    }

    /**
     * 获取商品信息
     */
    public function getGoodsInfo($id){
       $row = $this->alias('g')->join('__GOODS_INTRO__ as gi on gi.goods_id=g.id ')
                    ->join('__BRAND__ as b on b.id=g.brand_id ')
                    ->field('g.*,gi.content,b.name as bname')
                    ->where(['g.id'=>$id])->find();
       $row['paths'] = M('goods_gallery')->field('path')->where(['goods_id'=>$id])->getField('id,path',true);
//                dump($row);exit;
        return $row;

    }
}