<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>啊咿呀哟 管理中心 - <?php echo ($meta_title); ?> </title>
        <meta name="robots" content="noindex, nofollow" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="http://admin.shop.com/Public/css/general.css" rel="stylesheet" type="text/css" />
        <link href="http://admin.shop.com/Public/css/main.css" rel="stylesheet" type="text/css" />
        
    <link rel="stylesheet" type="text/css" href="http://admin.shop.com/Public/css/page.css" />

    </head>
    <body>
        
    <h1>
        <span class="action-span"><a href="<?php echo U('add');?>">添加新商品</a></span>
        <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心</a></span>
        <span id="search_id" class="action-span1"> - 商品列表 </span>
        <div style="clear:both"></div>
    </h1>
    <div class="form-div">
        <form action="" name="searchForm" method="get">
            <img src="http://admin.shop.com/Public/images/icon_search.gif" width="26" height="22" border="0" alt="search" />
            <!-- 分类 -->
            分类 <?php echo arr2select($goods_categories,'id','name','goods_category_id',I('get.goods_category_id'));?>
            <!-- 品牌 -->
            品牌 <?php echo arr2select($brands,'id','name','brand_id',I('get.brand_id'));?>
            <!-- 推荐 -->
            推荐 <?php echo onearr2select($goods_statues,'goods_status',I('get.goods_status'));?>
            <!-- 上架 -->
            上架 <?php echo onearr2select($is_on_sale,'is_on_sale',I('get.is_on_sale'));?>
            <!-- 关键字 -->
            关键字 <input type="text" name="keyword" size="15" value="<?php echo I('get.keyword');?>"/>
            <input type="submit" value="搜索" class="button" />
        </form>
    </div>

    <!-- 商品列表 -->
    <form method="post" action="" name="listForm" onsubmit="">
        <div class="list-div" id="listDiv">
            <table cellpadding="3" cellspacing="1">
                <tr>
                    <th>编号</th>
                    <th>商品名称</th>
                    <th>货号</th>
                    <th>本店价格/市场价格</th>
                    <th>上架</th>
                    <th>精品</th>
                    <th>新品</th>
                    <th>热销</th>
                    <th>推荐排序</th>
                    <th>库存</th>
                    <th>操作</th>
                </tr>
                <?php if(is_array($rows)): foreach($rows as $key=>$row): ?><tr>
                        <td align="center"><?php echo ($row["id"]); ?></td>
                        <td align="center" class="first-cell"><?php echo ($row["name"]); ?></td>
                        <td align="center"><?php echo ($row["sn"]); ?></td>
                        <td align="center"><?php echo ($row["shop_price"]); ?>/<?php echo ($row["market_price"]); ?></td>
                        <td align="center"><img src="http://admin.shop.com/Public/images/<?php echo ($row["is_on_sale"]); ?>.gif"/></td>
                        <td align="center"><img src="http://admin.shop.com/Public/images/<?php echo ($row["goods_status"]["best"]); ?>.gif"/></td>
                        <td align="center"><img src="http://admin.shop.com/Public/images/<?php echo ($row["goods_status"]["new"]); ?>.gif"/></td>
                        <td align="center"><img src="http://admin.shop.com/Public/images/<?php echo ($row["goods_status"]["hot"]); ?>.gif"/></td>
                        <td align="center"><?php echo ($row["sort"]); ?></td>
                        <td align="center"><?php echo ($row["stock"]); ?></td>
                        <td align="center">
                            <a href="<?php echo U('edit',['id'=>$row['id']]);?>" title="编辑"><img src="http://admin.shop.com/Public/images/icon_edit.gif" width="16" height="16" border="0" /></a>
                            <a href="<?php echo U('delete',['id'=>$row['id']]);?>" onclick="" title="回收站"><img src="http://admin.shop.com/Public/images/icon_trash.gif" width="16" height="16" border="0" /></a></td>
                    </tr><?php endforeach; endif; ?>
            </table>

            <!-- 分页开始 -->
            <div class="page">
                        <?php echo ($page_html); ?>
            </div>
            <!-- 分页结束 -->
        </div>
    </form>

        <div id="footer">
            共执行 <?php echo N('db_query');?> 个查询，用时  <?php echo G('viewStartTime','viewEndTime');?>s，内存占用 <?php echo number_format((memory_get_usage() - $GLOBALS['_startUseMems'])/1024,2);?> KB<br />
            版权所有 &copy; 1988-<?php echo date('Y');?> 啊咿呀哟母婴用品有限公司，并保留所有权利。
        </div>
        
    </body>
</html>