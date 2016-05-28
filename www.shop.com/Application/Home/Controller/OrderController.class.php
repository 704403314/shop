<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16-5-25
 * Time: 下午4:02
 */

namespace Home\Controller;


use Think\Controller;

/**
 * Class OrderController
 * @package Home\Controller
 */
class OrderController extends Controller{

    protected $_model = null;
    protected function _initialize(){
        $this->_model = D('OrderInfo');
    }

    /**
     * 展示订单首页
     */
    public function index(){
        if(!login()){
            redirect(U('Member/login'));
        }
        // 获取订单基本信息
        $this->assign('rows',$this->_model->getOrderInfo());
        $this->assign('statuses',$this->_model->statuses);
        //获取分类列表
        $this->_beforeShow();
        $this->display();
    }

    /**
     * 添加订单
     */
    public function add(){
        // 保存数据
        if($this->_model->create() === false){

            $this->error('添加数据失败');
        }
        // 添加数据
        if($this->_model->addOrder() === false){

            $this->error($this->_model->getError());
        }
        redirect(U('Cart/flow3',['aaa'=>NOW_TIME]));
    }

    /**
     * 获取分类列表
     * 获取帮助文章列表
     */
    private function _beforeShow() {
        //首页才展示分类列表.
        $this->assign('is_show_cat', false);

        //由于文章分类和帮助文章并不会经常更新,所以我们可以使用数据缓存 标识是ART_CATS
        $goods_categories = S('GOODS_CAT');
        if (!$goods_categories) {
            //取出分类
            $goods_categories = M('GoodsCategory')->where(['status' => 1])->select();
            S('GOODS_CAT', $goods_categories, 300);
        }


        $article_categories = S('ART_CATS');
        if (!$article_categories) {
            //获取帮助文章分类
            $article_categories = M('ArticleCategory')->where(['is_help' => 1, 'status' => 1])->getField('id,name');
            S('ART_CATS', $article_categories, 300);
        }
        //获取各分类的文章
        $artilce_list = S('ART_LIST');
        if (!$artilce_list) {
            foreach ($article_categories as $article_cat_id => $article_cat) {
                $artilce_list[$article_cat_id] = M('Article')->where(['article_category_id' => $article_cat_id])->limit(6)->getField('id,id,name');
            }
            S('ART_LIST', $artilce_list, 300);
        }

        //传入视图
        $this->assign('goods_categories', $goods_categories);
        $this->assign('article_categories', $article_categories);
        $this->assign('article_list', $artilce_list);
    }

    // 关闭超时订单
    public function autoClearOrder(){
        $cond = [
            'status'=>1,
            'inputtime'=>['lt',NOW_TIME-900],
        ];
        // 获取超时订单
        $order_ids = $this->_model->where($cond)->getField('id',true);

        if(empty($order_ids)){
            return true;
        }
        // 将状态设为0
        $this->_model->where($cond)->setField('status',0);
        // 获取订单对应的商品列表
        $goods_list = M('OrderInfoItem')->where(['order_info_id'=>['in',$order_ids]])
            ->field('amount,goods_id')->select();

        $list = [];
//
        foreach($goods_list as $goods){
            if(isset($list[$goods['goods_id']])){
                $list[$goods['goods_id']]+=$goods['amount'];
            }else{
            $list[$goods['goods_id']] = $goods['amount'];
            }

        }
        //dump($list);exit;
        foreach($list  as $gid=>$amount){
            // 加库存
            $res = M('Goods')->where(['id'=>$gid])->setInc('stock',$amount);

        }
    }

    /**
     *
     */
    public function shouhuo($id){
        if($this->_model->where(['id'=>$id,'status'=>3])->setField('status',4) === false){
            $this->error('收货异常');
        }else{
            $this->error('收获成功',U('Order/index'));
        }
    }

}