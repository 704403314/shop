<?php
/**
 * 文章模型
 */
namespace Admin\Model;
use Think\Model;

/**
 * Class ArticleModel
 * @package Admin\Model\ArticleModel
 */
class ArticleModel extends Model{
    protected $_validate=[
        ['name' ,'require' ,'文章名称不能为空', self::EXISTS_VALIDATE, '', self::MODEL_BOTH],
        ['name' ,'' ,'文章名称已存在', self::EXISTS_VALIDATE, 'unique', self::MODEL_INSERT],

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
        $page_html=$page->show();

        if($p>$page->totalPages){
            $p = $page->totalPages;
        }
//        dump(C('PAGE_THEME'));
//        dump($page->setConfig('theme',C('PAGE_THEME')));exit;
        $rows=$this->where($condition)->page($p,C('PAGE_SIZE'))->select();
////        $sql="SELECT a.name FROM article_category AS a RIGHT JOIN article AS b ON a.id=b.article_category_id ORDER BY b.id";
////        $names=$this->query($sql);
//        $names=D('ArticleCategory as a')
//            ->join("right join article as b ON a.id=b.article_category_id")
//            ->field('a.name')
//            ->order('b.id')
//            ->select();
////        dump($names);exit;
//        $i=0;
//        foreach($rows as $row){
//            $row['category_name']=$names[$i];
//            $i++;
//        }
//        dump($rows);exit;
        return array('rows'=>$rows ,'page_html'=>$page_html);
    }

    /**
     * 添加文章分类
     * @return mixed
     */

    public function add_article(){

        unset($this->data['pk']);
        $data = $_POST;
        // 不添加文章内容到文章表
        unset($data['content']);
        // 获取当前时间
        $data['inputtime']=time();
        // 获取插入id
        $id=$this->add($data);
//        dump($id);exit;
        if($id){
            $new_data=array();
            // 获取文章内容
            $new_data['content']=$_POST['content'];
            // 获取文章id
            $new_data['article_id']=$id;
            //添加文章内容
            return $res=M('ArticleContent')->add($new_data);

//            dump($res);
        }else{
            return false;
        }

    }

    /**
     *获取文章信息
     */
    public function getArticleInfo($id){
        // select * from article as a inner join article_content as b where a.id=b.article_id;
       $row=$this->alias('a')->join("article_content as b on a.id=b.article_id")->find($id);
           if(empty($row)){
               $this->error='文章信息不存在';
               return false;
           }
        return $row;
    }

    /**
     * 更新数据
     */
    public function update_article($id){
        // 获取插入id
        $res=$this->save($this->data);
//        dump($id);exit;
        if($res){
            $new_data=array();
            // 获取文章内容
            $new_data['content']=$_POST['content'];
            // 获取文章id
            $new_data['article_id']=$id;
            //添加文章内容
            $res=M('ArticleContent')->save($new_data);
            if($res){
                return $res;
            }else{
                $this->error = M('ArticleContent')->getError();
               return false;
            }

//            dump($res);
        }else{
            return false;
        }
    }
}