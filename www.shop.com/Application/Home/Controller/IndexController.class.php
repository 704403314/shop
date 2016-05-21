<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    protected  function _initialize(){
//        dump(S('GOODS_CATS'));exit;
        $user_info = login();
        $this->assign('user_info',$user_info);
        // 根据当前操作 判断是否展示分类页面
        if(ACTION_NAME == 'index'){
            $is_show_cat = true;
        }else{
            $is_show_cat = false;
        }
        $goods_categories = S('GOODS_CATS');
        if(!$goods_categories){
            // 查找商品分类数据
            $goods_categories = M('GoodsCategory')->where(['status'=>1])->field('id,name,parent_id')->select();
             S('GOODS_CATS',$goods_categories,300);
        }
        $article_categories = S('ART_CATS');
        if(!$article_categories){
            // 查找文章分类数据
            $article_categories = M('ArticleCategory')->where(['status'=>1],['is_help'=>1])->getField('id,name');
            S('ART_CATS',$article_categories,300);
        }
        $article_list = S('ART_LIST');
        if(!$article_list){

            $article_list = [];
            // 获取每一类文章
            foreach($article_categories as $article_category_id=>$article_category){
                $cond = [['status'=>1],['article_category_id'=>$article_category_id]];
                $article_list[$article_category_id] = M('Article')->where($cond)->limit(6)->getField('id,id,name');
            }
            S('ART_LIST',$article_list,300);
        }



//        dump($article_list);exit;
        $this->assign('is_show_cat',$is_show_cat);
        $this->assign('goods_categories',$goods_categories);
        $this->assign('article_categories',$article_categories);
        $this->assign('article_list',$article_list);
    }

    /**
     * 渲染首页
     */
    public function index(){

//        dump(D('Goods'));exit;
        $data = [
            'hot_list'=>D('Goods')->get_goods_status_data(4),
            'new_list'=>D('Goods')->get_goods_status_data(2),
            'best_list'=>D('Goods')->get_goods_status_data(1),
        ];
        $this->assign($data);
        $this->display();
    }

    /**
     * 展示商品详情
     */
    public function goods($id){
        $this->assign('row',D('goods')->getGoodsInfo($id));
         $this->display('goods');
    }
}