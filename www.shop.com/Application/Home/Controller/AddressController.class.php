<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16-5-23
 * Time: 下午3:50
 */

namespace Home\Controller;


use Think\Controller;

/**
 * Class AddressController
 * @package Home\Controller
 */
class AddressController extends Controller{

    private $_model = null;

    public function _initialize(){
        $this->_model = D('Address');

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

    /**
     * 渲染首页
     */
    public function index(){
        $this->assign('rows',$this->_model->getList());
        $this->display();
    }

    /**
     * 添加地址
     */
    public function add(){
        if(IS_POST){

            if($this->_model->create() === false){

                $this->error('添加数据失败',U('index'));
            }
            // 添加数据
            if($this->_model->addAddress() === false){

                $this->error('添加数据失败',U('index'));
            }
            $this->success('添加地址成功',U('Address/index',['aaa'=>NOW_TIME]));
        }else{
            $this->_before_view();
            $this->display();
        }
    }


    /**
     * 修改地址
     */

    public function edit($id){
        if(IS_POST){

            if($this->_model->create() === false){

                $this->error('修改数据失败',U('index'));
            }
            // 修改数据
            if($this->_model->editAddress() === false){

                $this->error('修改数据失败',U('index'));
            }
            $this->success('修改地址成功',U('Address/index',['aaa'=>NOW_TIME]));
        }else{
            $this->_before_view();
            // 获取当前地址信息
            $this->assign('row',$this->_model->getAddressInfo($id));
//            dump($this->_model->getAddressInfo($id));exit;
            $this->display('add');
        }
    }

    /**
     * 根据parent_id获取菜单
     */
    public function getAddress($id=0){
        $this->ajaxReturn($this->_model->getAddress($id));
    }

    /**
     * 渲染页面前获取需要展示的数据
     */
    public function _before_view(){
        // 分配省级数据
        $this->assign('provinces',$this->_model->getAddress(0));
    }
}