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
       $row['paths'] = M('goods_gallery')->where(['goods_id'=>$id])->getField('path',true);


        // 获取自定义会员价格
        $member_price_list = M('MemberGoodsPrice')
            ->where(['goods_id'=>$row['id'],'status'=>1])->getField('member_level_id,price');
        // 获取会员级别信息
        $level_list = M('MemberLevel')->where(['status'=>1])->getField('id,name,discount');

        $list = [];
        foreach($level_list as $level_id=>$level_info){
            // 如果设置了商品折扣价格 优先使用
            if(isset($member_price_list[$level_list])){
                $list[]=[
                  'name'=>  $level_info['name'],
                    'price'=>$member_price_list[$level_id],
                ];
            }else{

                // 没有设置 按照会员级别计算
                $list[]=[
                    'name'=>  $level_info['name'],
                    'price'=>$level_info['discount']*$row['shop_price']/100,
                ];
            }
        }
        $row['member_price_list'] = $list;


//                dump($row);exit;
        return $row;

    }
}