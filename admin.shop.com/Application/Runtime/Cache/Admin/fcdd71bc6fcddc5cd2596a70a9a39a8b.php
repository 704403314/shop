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
        <span class="action-span"><a href="<?php echo U('add',['nocache'=>NOW_TIME]);?>">添加管理员</a></span>
        <span class="action-span1"><a href="#">啊咿呀哟 管理中心</a></span>
        <span id="search_id" class="action-span1"> - <?php echo ($meta_title); ?> </span>
    </h1>
    <div style="clear:both"></div>
    <div class="form-div">
        <form action="<?php echo U('');?>" name="searchForm">
            <img src="http://admin.shop.com/Public/images/icon_search.gif" width="26" height="22" border="0" alt="search" />
            <input type="text" name="name" size="15" value="<?php echo I('get.name');?>"/>
            <input type="submit" value=" 搜索 " class="button" />
        </form>
    </div>
    <form method="post" action="" name="listForm">
        <div class="list-div" id="listDiv">
            <table cellpadding="3" cellspacing="1">
                <tr>
                    <th>管理员名称</th>
                    <th>管理员邮箱</th>
                    <th>注册时间</th>
                    <th>最后登录时间</th>
                    <th>最后登录IP</th>
                    <th>操作</th>
                </tr>
                <?php if(is_array($rows)): foreach($rows as $key=>$row): ?><tr>
                    <td class="first-cell" align="center"><?php echo ($row["username"]); ?></td>
                    <td align="center"><?php echo ($row["email"]); ?></td>
                    <td align="center"><?php echo (date("Y-m-d H:i:s",$row["add_time"])); ?></td>
                    <td align="center"><?php echo (date("Y-m-d H:i:s",$row["last_login_time"])); ?></td>
                    <td align="center"><?php echo long2ip($row['last_login_ip']);?></td>
                    <td align="center">
                        <a href="<?php echo U('edit',['id'=>$row['id'],'nocache'=>NOW_TIME]);?>" title="编辑">编辑</a> |
                        <a href="<?php echo U('delete',['id'=>$row['id'],'nocache'=>NOW_TIME]);?>" title="移除">移除</a> 
                    </td>
                </tr><?php endforeach; endif; ?>
                <tr>
                    <td align="right" nowrap="true" colspan="6">
                        <div class="page">
                            <?php echo ($page_html); ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </form>

        <div id="footer">
            共执行 <?php echo N('db_query');?> 个查询，用时  <?php echo G('viewStartTime','viewEndTime');?>s，内存占用 <?php echo number_format((memory_get_usage() - $GLOBALS['_startUseMems'])/1024,2);?> KB<br />
            版权所有 &copy; 1988-<?php echo date('Y');?> 啊咿呀哟母婴用品有限公司，并保留所有权利。
        </div>
        
    </body>
</html>