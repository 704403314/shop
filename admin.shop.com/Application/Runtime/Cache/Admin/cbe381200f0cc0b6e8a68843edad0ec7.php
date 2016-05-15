<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>啊咿呀哟 管理中心 - <?php echo ($meta_title); ?> </title>
        <meta name="robots" content="noindex, nofollow" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="http://admin.shop.com/Public/css/general.css" rel="stylesheet" type="text/css" />
        <link href="http://admin.shop.com/Public/css/main.css" rel="stylesheet" type="text/css" />
        
    <link rel="stylesheet" type="text/css" href="http://admin.shop.com/Public/ext/treegrid/css/jquery.treegrid.css" />

    </head>
    <body>
        
    <h1>
        <span class="action-span"><a href="<?php echo U('add');?>">添加权限</a></span>
        <span class="action-span1"><a href="__GROUP__">啊咿呀哟 管理中心</a></span>
        <span id="search_id" class="action-span1"> - 商品权限 </span>
        <div style="clear:both"></div>
    </h1>
    <form method="post" action="" name="listForm">
        <div class="list-div" id="listDiv">
            <table width="100%" cellspacing="1" cellpadding="2" id="list-table" class='tree'>
                <tr>
                    <th>权限名称</th>
                    <th>权限路径</th>
                    <th>描述</th>
                    <th>操作</th>
                </tr>
                <?php if(is_array($rows)): foreach($rows as $key=>$row): ?><tr align="center" class='treegrid-<?php echo ($row["id"]); ?> <?php if(($row["level"]) != "1"): ?>treegrid-parent-<?php echo ($row["parent_id"]); endif; ?>'>
                        <td align="left" class="first-cell" ><?php echo ($row["name"]); ?></td>
                        <td width="30%" align="center"><?php echo ($row["path"]); ?></td>
                        <td width="30%" align="center"><?php echo ($row["intro"]); ?></td>
                        <td width="10%" align="center">
                            <a href="<?php echo U('edit',['id'=>$row['id']]);?>">编辑</a> |
                            <a href="<?php echo U('delete',['id'=>$row['id']]);?>" title="移除" onclick="">移除</a>
                        </td>
                    </tr><?php endforeach; endif; ?>
            </table>
        </div>
    </form>

        <div id="footer">
            共执行 <?php echo N('db_query');?> 个查询，用时  <?php echo G('viewStartTime','viewEndTime');?>s，内存占用 <?php echo number_format((memory_get_usage() - $GLOBALS['_startUseMems'])/1024,2);?> KB<br />
            版权所有 &copy; 1988-<?php echo date('Y');?> 啊咿呀哟母婴用品有限公司，并保留所有权利。
        </div>
        
    <script type="text/javascript" src="http://admin.shop.com/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="http://admin.shop.com/Public/ext/treegrid/js/jquery.treegrid.js"></script>
    <script type='text/javascript'>
        $(function(){
            $('.tree').treegrid();
        });
    </script>

    </body>
</html>