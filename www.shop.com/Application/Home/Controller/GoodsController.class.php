<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16-5-22
 * Time: 下午8:08
 */

namespace Home\Controller;
use Think\Controller;

/**
 * Class GoodsController
 * @package Home\Controller
 */
class GoodsController extends Controller{

    /**
     * 浏览次数加1
     */
    public function _incTimes($goods_id=''){
        $model = M('GoodsClick');
        // 获取当前商品编号的点击次数
        $click_times = $model->getFieldByGoodsId($goods_id,'click_times');
//        dump($click_times);exit;
        if($click_times){
            ++$click_times;
            $model->where(['goods_id'=>$goods_id])->setInc('click_times');
        }else{
            // 数据库中查不到商品点击次数
            $click_times = 1;
            $data = [
                'goods_id'=>$goods_id,
                'click_times'=>1
            ];
            $model->add($data);
        }
        $this->ajaxReturn($click_times);
    }

    /**
     * 使用redis保存浏览次数
     */
    public function incTimes($goods_id){
        $key = 'goods_click';
        // 获取保存在redis中的数据
        $redis = getRedis();
        $goods_click = $redis->zincrBy($key,1,$goods_id);
        $this->ajaxReturn($goods_click);

    }

    public function syncClicks(){
        // 初始化并连接redis
        $redis = getRedis();
        $click_lists = $redis->zRange('goods_click',0,-1,true);
        if($click_lists){
            $goods_ids = array_keys($click_lists);
            M('GoodsClick')->where(['goods_id'=>['in',$goods_ids]])->delete();
            $data = [];
            // 遍历获取到的所有商品点击次数
            foreach($click_lists as $goods_id=>$click_times){
                $data[]=[
                  'goods_id'=>  $goods_id,
                    'click_times'=>$click_times,
                ];
            }
            M('GoodsClick')->addAll($data);
        }
        echo "<script type='text/javascript'>window.close();</script>";
    }
}


