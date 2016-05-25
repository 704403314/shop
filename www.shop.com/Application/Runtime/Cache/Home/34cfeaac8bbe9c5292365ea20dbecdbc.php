<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <title>京西商城</title>
        
    <link rel="stylesheet" href="http://www.shop.com/Public/css/goods.css" type="text/css">
    <link rel="stylesheet" href="http://www.shop.com/Public/css/common.css" type="text/css">
    <link rel="stylesheet" href="http://www.shop.com/Public/css/bottomnav.css" type="text/css">
    <!--引入jqzoom css -->
    <link rel="stylesheet" href="http://www.shop.com/Public/css/jqzoom.css" type="text/css">

        <link rel="stylesheet" href="http://www.shop.com/Public/css/base.css" type="text/css"/>
        <link rel="stylesheet" href="http://www.shop.com/Public/css/global.css" type="text/css"/>
        <link rel="stylesheet" href="http://www.shop.com/Public/css/header.css" type="text/css"/>
        <link rel="stylesheet" href="http://www.shop.com/Public/css/footer.css" type="text/css"/>
    </head>
    <body>
        <!-- 顶部导航 start -->
        <div class="topnav">
            <div class="topnav_bd w1210 bc">
                <div class="topnav_left">

                </div>
                <div class="topnav_right fr">
                    <ul>
                        <li id="userinfo">
                            
                        </li>
                        <li class="line">|</li>
                        <li>我的订单</li>
                        <li class="line">|</li>
                        <li>客户服务</li>

                    </ul>
                </div>
            </div>
        </div>
        <!-- 顶部导航 end -->

        <div style="clear:both;"></div>

        <!-- 头部 start -->
        <div class="header w1210 bc mt15">
            <!-- 头部上半部分 start 包括 logo、搜索、用户中心和购物车结算 -->
            <div class="logo w1210">
                <h1 class="fl"><a href="<?php echo U('Index/index');?>"><img src="http://www.shop.com/Public/images/logo.png" alt="京西商城"></a></h1>
                <!-- 头部搜索 start -->
                <div class="search fl">
                    <div class="search_form">
                        <div class="form_left fl"></div>
                        <form action="" name="serarch" method="get" class="fl">
                            <input type="text" class="txt" value="请输入商品关键字" /><input type="submit" class="btn" value="搜索" />
                        </form>
                        <div class="form_right fl"></div>
                    </div>

                    <div style="clear:both;"></div>

                    <div class="hot_search">
                        <strong>热门搜索:</strong>
                        <a href="">D-Link无线路由</a>
                        <a href="">休闲男鞋</a>
                        <a href="">TCL空调</a>
                        <a href="">耐克篮球鞋</a>
                    </div>
                </div>
                <!-- 头部搜索 end -->

                <!-- 用户中心 start-->
                <div class="user fl">
                    <dl>
                        <dt>
                            <em></em>
                            <a href="">用户中心</a>
                            <b></b>
                        </dt>
                        <dd>
                            <div class="prompt">
                                您好，请<a href="<?php echo U('Member/login');?>">登录</a>
                            </div>
                            <div class="uclist mt10">
                                <ul class="list1 fl">
                                    <li><a href="">用户信息></a></li>
                                    <li><a href="">我的订单></a></li>
                                    <li><a href="">收货地址></a></li>
                                    <li><a href="">我的收藏></a></li>
                                </ul>

                                <ul class="fl">
                                    <li><a href="">我的留言></a></li>
                                    <li><a href="">我的红包></a></li>
                                    <li><a href="">我的评论></a></li>
                                    <li><a href="">资金管理></a></li>
                                </ul>

                            </div>
                            <div style="clear:both;"></div>
                            <div class="viewlist mt10">
                                <h3>最近浏览的商品：</h3>
                                <ul>
                                    <li><a href=""><img src="http://www.shop.com/Public/images/view_list1.jpg" alt="" /></a></li>
                                    <li><a href=""><img src="http://www.shop.com/Public/images/view_list2.jpg" alt="" /></a></li>
                                    <li><a href=""><img src="http://www.shop.com/Public/images/view_list3.jpg" alt="" /></a></li>
                                </ul>
                            </div>
                        </dd>
                    </dl>
                </div>
                <!-- 用户中心 end-->

                <!-- 购物车 start -->
                <div class="cart fl">
                    <dl>
                        <dt>
                            <a href="">去购物车结算</a>
                            <b></b>
                        </dt>
                        <dd>
                            <div class="prompt">
                                购物车中还没有商品，赶紧选购吧！
                            </div>
                        </dd>
                    </dl>
                </div>
                <!-- 购物车 end -->
            </div>
            <!-- 头部上半部分 end -->

            <div style="clear:both;"></div>

            <!-- 导航条部分 start -->
            <div class="nav w1210 bc mt10">
                <!--  商品分类部分 start-->
                <div class="category fl <?php if(!$is_show_cat): ?>cat1<?php endif; ?>"> <!-- 非首页，需要添加cat1类 -->
                    <div class="cat_hd <?php if(!$is_show_cat): ?>off<?php endif; ?>">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
                        <h2>全部商品分类</h2>
                        <em></em>
                    </div>

                    <div class="cat_bd <?php if(!$is_show_cat): ?>none<?php endif; ?>">
                        <?php if(is_array($goods_categories)): foreach($goods_categories as $key=>$top_category): if(($top_category["parent_id"]) == "0"): ?><div class="cat item1">
                                    <h3><a href=""><?php echo ($top_category["name"]); ?></a> <b></b></h3>
                                    <div class="cat_detail">
                                        <?php if(is_array($goods_categories)): foreach($goods_categories as $key=>$second_category): if(($second_category["parent_id"]) == $top_category["id"]): ?><dl class="dl_1st">
                                                    <dt><a href=""><?php echo ($second_category["name"]); ?></a></dt>
                                                    <dd>
                                                        <?php if(is_array($goods_categories)): foreach($goods_categories as $key=>$third_category): if(($third_category["parent_id"]) == $second_category["id"]): ?><a href="<?php echo U('Goods/List',['id'=>$third_category['id']]);?>"><?php echo ($third_category["name"]); ?></a><?php endif; endforeach; endif; ?>						
                                                    </dd>
                                                </dl><?php endif; endforeach; endif; ?>
                                    </div>
                                </div><?php endif; endforeach; endif; ?>
                    </div>

                </div>
                <!--  商品分类部分 end--> 

                <div class="navitems fl">
                    <ul class="fl">
                        <li class="current"><a href="">首页</a></li>
                        <li><a href="">电脑频道</a></li>
                        <li><a href="">家用电器</a></li>
                        <li><a href="">品牌大全</a></li>
                        <li><a href="">团购</a></li>
                        <li><a href="">积分商城</a></li>
                        <li><a href="">夺宝奇兵</a></li>
                    </ul>
                    <div class="right_corner fl"></div>
                </div>
            </div>
            <!-- 导航条部分 end -->
        </div>
        <!-- 头部 end-->

        <div style="clear:both;"></div>
        

    <!-- 商品页面主体 start -->
    <div class="main w1210 mt10 bc">
        <!-- 面包屑导航 start -->
        <div class="breadcrumb">
            <h2>当前位置：<a href="">首页</a> > <a href="">电脑、办公</a> > <a href="">笔记本</a> > ThinkPad X230(23063T4）12.5英寸笔记本</h2>
        </div>
        <!-- 面包屑导航 end -->

        <!-- 主体页面左侧内容 start -->
        <div class="goods_left fl">
            <!-- 相关分类 start -->
            <div class="related_cat leftbar mt10">
                <h2><strong>相关分类</strong></h2>
                <div class="leftbar_wrap">
                    <ul>
                        <li><a href="">笔记本</a></li>
                        <li><a href="">超极本</a></li>
                        <li><a href="">平板电脑</a></li>
                    </ul>
                </div>
            </div>
            <!-- 相关分类 end -->

            <!-- 热销排行 start -->
            <div class="hotgoods leftbar mt10">
                <h2><strong>热销排行榜</strong></h2>
                <div class="leftbar_wrap">
                    <ul>
                        <li></li>
                    </ul>
                </div>
            </div>
            <!-- 热销排行 end -->


            <!-- 浏览过该商品的人还浏览了  start 注：因为和list页面newgoods样式相同，故加入了该class -->
            <div class="related_view newgoods leftbar mt10">
                <h2><strong>浏览了该商品的用户还浏览了</strong></h2>
                <div class="leftbar_wrap">
                    <ul>
                        <li>
                            <dl>
                                <dt><a href=""><img src="http://www.shop.com/Public/images/relate_view1.jpg" alt="" /></a></dt>
                                <dd><a href="">ThinkPad E431(62771A7) 14英寸笔记本电脑 (i5-3230 4G 1TB 2G独显 蓝牙 win8)</a></dd>
                                <dd><strong>￥5199.00</strong></dd>
                            </dl>
                        </li>

                        <li>
                            <dl>
                                <dt><a href=""><img src="http://www.shop.com/Public/images/relate_view2.jpg" alt="" /></a></dt>
                                <dd><a href="">ThinkPad X230i(2306-3V9） 12.5英寸笔记本电脑 （i3-3120M 4GB 500GB 7200转 蓝牙 摄像头 Win8）</a></dd>
                                <dd><strong>￥5199.00</strong></dd>
                            </dl>
                        </li>

                        <li>
                            <dl>
                                <dt><a href=""><img src="http://www.shop.com/Public/images/relate_view3.jpg" alt="" /></a></dt>
                                <dd><a href="">T联想（Lenovo） Yoga13 II-Pro 13.3英寸超极本 （i5-4200U 4G 128G固态硬盘 摄像头 蓝牙 Win8）晧月银</a></dd>
                                <dd><strong>￥7999.00</strong></dd>
                            </dl>
                        </li>

                        <li>
                            <dl>
                                <dt><a href=""><img src="http://www.shop.com/Public/images/relate_view4.jpg" alt="" /></a></dt>
                                <dd><a href="">联想（Lenovo） Y510p 15.6英寸笔记本电脑（i5-4200M 4G 1T 2G独显 摄像头 DVD刻录 Win8）黑色</a></dd>
                                <dd><strong>￥6199.00</strong></dd>
                            </dl>
                        </li>

                        <li class="last">
                            <dl>
                                <dt><a href=""><img src="http://www.shop.com/Public/images/relate_view5.jpg" alt="" /></a></dt>
                                <dd><a href="">ThinkPad E530c(33662D0) 15.6英寸笔记本电脑 （i5-3210M 4G 500G NV610M 1G独显 摄像头 Win8）</a></dd>
                                <dd><strong>￥4399.00</strong></dd>
                            </dl>
                        </li>					
                    </ul>
                </div>
            </div>
            <!-- 浏览过该商品的人还浏览了  end -->

            <!-- 最近浏览 start -->
            <div class="viewd leftbar mt10">
                <h2><a href="">清空</a><strong>最近浏览过的商品</strong></h2>
                <div class="leftbar_wrap">
                    <dl>
                        <dt><a href=""><img src="http://www.shop.com/Public/images/hpG4.jpg" alt="" /></a></dt>
                        <dd><a href="">惠普G4-1332TX 14英寸笔记...</a></dd>
                    </dl>

                    <dl class="last">
                        <dt><a href=""><img src="http://www.shop.com/Public/images/crazy4.jpg" alt="" /></a></dt>
                        <dd><a href="">直降200元！TCL正1.5匹空调</a></dd>
                    </dl>
                </div>
            </div>
            <!-- 最近浏览 end -->

        </div>
        <!-- 主体页面左侧内容 end -->

        <!-- 商品信息内容 start -->
        <div class="goods_content fl mt10 ml10">
            <!-- 商品概要信息 start -->
            <div class="summary">
                <h3><strong><?php echo ($row["name"]); ?></strong></h3>

                <!-- 图片预览区域 start -->
                <div class="preview fl">
                    <div class="midpic">
                        <a href="<?php echo ($row['paths'][0]); ?>-350" class="jqzoom" rel="gal1">   <!-- 第一幅图片的大图 class 和 rel属性不能更改 -->
                            <img src="<?php echo ($row['paths'][0]); ?>-350"  alt="" />               <!-- 第一幅图片的中图 -->
                        </a>
                    </div>

                    <!--使用说明：此处的预览图效果有三种类型的图片，大图，中图，和小图，取得图片之后，分配到模板的时候，把第一幅图片分配到 上面的midpic 中，其中大图分配到 a 标签的href属性，中图分配到 img 的src上。 下面的smallpic 则表示小图区域，格式固定，在 a 标签的 rel属性中，分别指定了中图（smallimage）和大图（largeimage），img标签则显示小图，按此格式循环生成即可，但在第一个li上，要加上cur类，同时在第一个li 的a标签中，添加类 zoomThumbActive  -->

                    <div class="smallpic">
                        <a href="javascript:;" id="backward" class="off"></a>
                        <a href="javascript:;" id="forward" class="on"></a>
                        <div class="smallpic_wrap">
                            <ul>
                                <?php if(is_array($row["paths"])): foreach($row["paths"] as $key=>$path): ?><li <?php if(($key) == "0"): ?>class="cur"<?php endif; ?>>
                                    <a <?php if(($key) == "0"): ?>class="zoomThumbActive"<?php endif; ?> href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?php echo ($path); ?>-350',largeimage: '<?php echo ($path); ?>-80'}"><img src="<?php echo ($path); ?>-55"></a>
                                </li>
                                    <!--<li <?php if(($key) == "0"): ?>class="cur"<?php endif; ?>>-->
                                    <!--<a <?php if(($key) == "0"): ?>class="zoomThumbActive"<?php endif; ?> href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?php echo ($path); ?>-m',largeimage: '<?php echo ($path); ?>-l'}"><img src="<?php echo ($path); ?>-s"></a>-->
                                    <!--</li>--><?php endforeach; endif; ?>

                            </ul>
                        </div>

                    </div>
                </div>
                <!-- 图片预览区域 end -->

                <!-- 商品基本信息区域 start -->
                <div class="goodsinfo fl ml10">
                    <ul>
                        <li><span>商品编号： </span><?php echo ($row["sn"]); ?></li>
                        <li class="market_price"><span>定价：</span><em>￥<?php echo ($row["market_price"]); ?></em></li>
                        <li class="shop_price"><span>本店价：</span> <strong>￥<?php echo ($row["shop_price"]); ?></strong> <a href="">(降价通知)</a></li>
                        <li>
                            <span>会员价：</span>
                            <?php if(is_array($row["member_price_list"])): foreach($row["member_price_list"] as $key=>$member_price): echo ($member_price["name"]); ?>:￥<?php echo ($member_price["price"]); ?>&nbsp;&nbsp;<?php endforeach; endif; ?>
                        </li>
                        <li><span>上架时间：</span><?php echo (date("Y-m-d H:i:s",$row["inputtime"])); ?></li>
                        <li><span>浏览量：</span><label id='goods-click'></label></li>
                    </ul>
                    <form action="<?php echo U('Cart/addCart');?>" method="post" class="choose">
                        <ul>

                            <li>
                                <dl>
                                    <dt>购买数量：</dt>
                                    <dd>
                                        <a href="javascript:;" id="reduce_num"></a>
                                        <input type="text" name="amount" value="1" class="amount"/>
                                        <input type="hidden" name="id" value="<?php echo ($row['id']); ?>"/>
                                        <a href="javascript:;" id="add_num"></a>
                                    </dd>
                                </dl>
                            </li>

                            <li>
                                <dl>
                                    <dt>&nbsp;</dt>
                                    <dd>
                                        <input type="submit" value="" class="add_btn" />
                                    </dd>
                                </dl>
                            </li>

                        </ul>
                    </form>
                </div>
                <!-- 商品基本信息区域 end -->
            </div>
            <!-- 商品概要信息 end -->

            <div style="clear:both;"></div>

            <!-- 商品详情 start -->
            <div class="detail">
                <div class="detail_hd">
                    <ul>
                        <li class="first on"><span>商品介绍</span></li>
                        <li class=""><span>商品评价</span></li>
                        <li><span>售后保障</span></li>
                    </ul>
                </div>
                <div class="detail_bd">
                    <!-- 商品介绍 start -->
                    <div class="introduce detail_div">
                        <div class="attr mt15">
                            <ul>
                                <li><span>商品名称：</span><?php echo ($row["name"]); ?></li>
                                <li><span>商品编号：</span><?php echo ($row["sn"]); ?></li>
                                <li><span>品牌：</span><?php echo ($row["bname"]); ?></li>
                                <li><span>上架时间：</span><?php echo (date("Y-m-d H:i:s",$row["inputtime"])); ?></li>
                                <li><span>浏览量：</span><label id='goods-click'></label></li>
                            </ul>
                        </div>

                        <div class="desc mt10">
                            <!-- 此处的内容 一般是通过在线编辑器添加保存到数据库，然后直接从数据库中读出 -->
                            <?php echo ($row["content"]); ?>
                        </div>
                    </div>
                    <!-- 商品介绍 end -->

                    <!-- 商品评论 start -->
                    <div class="comment detail_div mt10 none">
                        <div class="comment_summary">
                            <div class="rate fl">
                                <strong><em>90</em>%</strong> <br />
                                <span>好评度</span>
                            </div>
                            <div class="percent fl">
                                <dl>
                                    <dt>好评（90%）</dt>
                                    <dd><div style="width:90px;"></div></dd>
                                </dl>
                                <dl>
                                    <dt>中评（5%）</dt>
                                    <dd><div style="width:5px;"></div></dd>
                                </dl>
                                <dl>
                                    <dt>差评（5%）</dt>
                                    <dd><div style="width:5px;" ></div></dd>
                                </dl>
                            </div>
                            <div class="buyer fl">
                                <dl>
                                    <dt>买家印象：</dt>
                                    <dd><span>屏幕大</span><em>(1953)</em></dd>
                                    <dd><span>外观漂亮</span><em>(786)</em></dd>
                                    <dd><span>系统流畅</span><em>(1091)</em></dd>
                                    <dd><span>功能齐全</span><em>(1109)</em></dd>
                                    <dd><span>反应快</span><em>(659)</em></dd>
                                    <dd><span>分辨率高</span><em>(824)</em></dd>
                                </dl>
                            </div>
                        </div>

                        <div class="comment_items mt10">
                            <div class="user_pic">
                                <dl>
                                    <dt><a href=""><img src="http://www.shop.com/Public/images/user1.gif" alt="" /></a></dt>
                                    <dd><a href="">乖乖</a></dd>
                                </dl>
                            </div>
                            <div class="item">
                                <div class="title">
                                    <span>2013-03-11 22:18</span>
                                    <strong class="star star5"></strong> <!-- star5表示5星级 start4表示4星级，以此类推 -->
                                </div>
                                <div class="comment_content">
                                    <dl>
                                        <dt>心得：</dt>
                                        <dd>东西挺好，挺满意的！</dd>
                                    </dl>
                                    <dl>
                                        <dt>优点：</dt>
                                        <dd>反应速度开，散热性能好</dd>
                                    </dl>
                                    <dl>
                                        <dt>不足：</dt>
                                        <dd>暂时还没发现缺点哦！</dd>
                                    </dl>
                                    <dl>
                                        <dt>购买日期：</dt>
                                        <dd>2013-11-24</dd>
                                    </dl>
                                </div>
                                <div class="btns">
                                    <a href="" class="reply">回复(0)</a>
                                    <a href="" class="useful">有用(0)</a>
                                </div>
                            </div>
                            <div class="cornor"></div>
                        </div>

                        <div class="comment_items mt10">
                            <div class="user_pic">
                                <dl>
                                    <dt><a href=""><img src="http://www.shop.com/Public/images/user2.jpg" alt="" /></a></dt>
                                    <dd><a href="">小宝贝</a></dd>
                                </dl>
                            </div>
                            <div class="item">
                                <div class="title">
                                    <span>2013-10-01 14:10</span>
                                    <strong class="star star4"></strong> <!-- star5表示5星级 start4表示4星级，以此类推 -->
                                </div>
                                <div class="comment_content">
                                    <dl>
                                        <dt>心得：</dt>
                                        <dd>外观漂亮同，还在使用过程中。</dd>
                                    </dl>
                                    <dl>
                                        <dt>型号：</dt>
                                        <dd>i5 8G内存版</dd>
                                    </dl>
                                    <dl>
                                        <dt>购买日期：</dt>
                                        <dd>2013-11-20</dd>
                                    </dl>
                                </div>
                                <div class="btns">
                                    <a href="" class="reply">回复(0)</a>
                                    <a href="" class="useful">有用(0)</a>
                                </div>
                            </div>
                            <div class="cornor"></div>
                        </div>

                        <div class="comment_items mt10">
                            <div class="user_pic">
                                <dl>
                                    <dt><a href=""><img src="http://www.shop.com/Public/images/user3.jpg" alt="" /></a></dt>
                                    <dd><a href="">天使</a></dd>
                                </dl>
                            </div>
                            <div class="item">
                                <div class="title">
                                    <span>2013-03-11 22:18</span>
                                    <strong class="star star5"></strong> <!-- star5表示5星级 start4表示4星级，以此类推 -->
                                </div>
                                <div class="comment_content">
                                    <dl>
                                        <dt>心得：</dt>
                                        <dd>挺好的，物超所值，速度挺好，WIN8用起来也不错。</dd>
                                    </dl>
                                    <dl>
                                        <dt>优点：</dt>
                                        <dd>散热很好，配置不错</dd>
                                    </dl>
                                    <dl>
                                        <dt>不足：</dt>
                                        <dd>暂时还没发现缺点哦！</dd>
                                    </dl>
                                    <dl>
                                        <dt>购买日期：</dt>
                                        <dd>2013-11-24</dd>
                                    </dl>
                                </div>
                                <div class="btns">
                                    <a href="" class="reply">回复(0)</a>
                                    <a href="" class="useful">有用(0)</a>
                                </div>
                            </div>
                            <div class="cornor"></div>
                        </div>

                        <!-- 分页信息 start -->
                        <div class="page mt20">
                            <a href="">首页</a>
                            <a href="">上一页</a>
                            <a href="">1</a>
                            <a href="">2</a>
                            <a href="" class="cur">3</a>
                            <a href="">4</a>
                            <a href="">5</a>
                            <a href="">下一页</a>
                            <a href="">尾页</a>
                        </div>
                        <!-- 分页信息 end -->

                        <!--  评论表单 start-->
                        <div class="comment_form mt20">
                            <form action="">
                                <ul>
                                    <li>
                                        <label for=""> 评分：</label>
                                        <input type="radio" name="grade"/> <strong class="star star5"></strong>
                                        <input type="radio" name="grade"/> <strong class="star star4"></strong>
                                        <input type="radio" name="grade"/> <strong class="star star3"></strong>
                                        <input type="radio" name="grade"/> <strong class="star star2"></strong>
                                        <input type="radio" name="grade"/> <strong class="star star1"></strong>
                                    </li>

                                    <li>
                                        <label for="">评价内容：</label>
                                        <textarea name="" id="" cols="" rows=""></textarea>
                                    </li>
                                    <li>
                                        <label for="">&nbsp;</label>
                                        <input type="submit" value="提交评论"  class="comment_btn"/>										
                                    </li>
                                </ul>
                            </form>
                        </div>
                        <!--  评论表单 end-->

                    </div>
                    <!-- 商品评论 end -->

                    <!-- 售后保障 start -->
                    <div class="after_sale mt15 none detail_div">
                        <div>
                            <p>本产品全国联保，享受三包服务，质保期为：一年质保 <br />如因质量问题或故障，凭厂商维修中心或特约维修点的质量检测证明，享受7日内退货，15日内换货，15日以上在质保期内享受免费保修等三包服务！</p>
                            <p>售后服务电话：800-898-9006 <br />品牌官方网站：http://www.lenovo.com.cn/</p>

                        </div>

                        <div>
                            <h3>服务承诺：</h3>
                            <p>本商城向您保证所售商品均为正品行货，京东自营商品自带机打发票，与商品一起寄送。凭质保证书及京东商城发票，可享受全国联保服务（奢侈品、钟表除外；奢侈品、钟表由本商城联系保修，享受法定三包售后服务），与您亲临商场选购的商品享受相同的质量保证。本商城还为您提供具有竞争力的商品价格和运费政策，请您放心购买！</p> 

                            <p>注：因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本司不能确保客户收到的货物与商城图片、产地、附件说明完全一致。只能确保为原厂正货！并且保证与当时市场上同样主流新品一致。若本商城没有及时更新，请大家谅解！</p>

                        </div>

                        <div>
                            <h3>权利声明：</h3>
                            <p>本商城上的所有商品信息、客户评价、商品咨询、网友讨论等内容，是京东商城重要的经营资源，未经许可，禁止非法转载使用。</p>
                            <p>注：本站商品信息均来自于厂商，其真实性、准确性和合法性由信息拥有者（厂商）负责。本站不提供任何保证，并不承担任何法律责任。</p>

                        </div>
                    </div>
                    <!-- 售后保障 end -->

                </div>
            </div>
            <!-- 商品详情 end -->


        </div>
        <!-- 商品信息内容 end -->


    </div>
    <!-- 商品页面主体 end -->


        <div style="clear:both;"></div>

        <!-- 底部导航 start -->
        <div class="bottomnav w1210 bc mt10">
            <?php if(is_array($article_categories)): foreach($article_categories as $key=>$article_cat): ?><div class="bnav<?php echo ($key); ?>">
                <h3><b></b> <em><?php echo ($article_cat); ?></em></h3>
                <ul>
                    <?php if(is_array($article_list[$key])): foreach($article_list[$key] as $key=>$article): ?><li><a href="<?php echo U('Article/show',['id'=>$article['id']]);?>"><?php echo ($article["name"]); ?></a></li><?php endforeach; endif; ?>
                </ul>
            </div><?php endforeach; endif; ?>
        </div>
        <!-- 底部导航 end -->

        <div style="clear:both;"></div>
        <!-- 底部版权 start -->
        <div class="footer w1210 bc mt10">
            <p class="links">
                <a href="">关于我们</a> |
                <a href="">联系我们</a> |
                <a href="">人才招聘</a> |
                <a href="">商家入驻</a> |
                <a href="">千寻网</a> |
                <a href="">奢侈品网</a> |
                <a href="">广告服务</a> |
                <a href="">移动终端</a> |
                <a href="">友情链接</a> |
                <a href="">销售联盟</a> |
                <a href="">京西论坛</a>
            </p>
            <p class="copyright">
                © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
            </p>
            <p class="auth">
                <a href=""><img src="http://www.shop.com/Public/images/xin.png" alt="" /></a>
                <a href=""><img src="http://www.shop.com/Public/images/kexin.jpg" alt="" /></a>
                <a href=""><img src="http://www.shop.com/Public/images/police.jpg" alt="" /></a>
                <a href=""><img src="http://www.shop.com/Public/images/beian.gif" alt="" /></a>
            </p>
        </div>
        <!-- 底部版权 end -->
        <script type="text/javascript" src="http://www.shop.com/Public/js/jquery.min.js"></script>
        <script type="text/javascript" src="http://www.shop.com/Public/js/header.js"> </script>
        <script type="text/javascript">
            $(function(){

                var url = "<?php echo U('Member/getUserInfo');?>";

                $.getJSON(url,function(response){
//                    alert(1);
                    if(response){
                        var html = '您好'+response+'，欢迎来到京西！[<a href="<?php echo U('Member/logout');?>">退出</a>]';
                    }else{
                        var html = '您好,欢迎来到京西![<a href="<?php echo U('Member/login');?>">登录</a>] [<a href="<?php echo U('Member/register');?>">免费注册</a>]';
                    }
                    $('#userinfo').html(html);
                });
            })
        </script>
        
    <script type="text/javascript" src="http://www.shop.com/Public/js/goods.js"></script>
    <script type="text/javascript" src="http://www.shop.com/Public/js/jqzoom-core.js"></script>
    <!-- jqzoom 效果 -->
    <script type="text/javascript">
        $(function () {
//            alert(1);
            // 商品每浏览一次 浏览次数加1
            var url = "<?php echo U('Goods/incTimes');?>";
            var data = {
                "goods_id":<?php echo ($row["id"]); ?>
        }
        $.getJSON(url,data,function(response){

            $('#goods-click').text(response);
        });


        $('.jqzoom').jqzoom({

            zoomType: 'standard',
            lens: true,
            preloadImages: false,
            alwaysOn: false,
            title: false,
            zoomWidth: 400,
            zoomHeight: 400
        });




        })
    </script>

    </body>
</html>