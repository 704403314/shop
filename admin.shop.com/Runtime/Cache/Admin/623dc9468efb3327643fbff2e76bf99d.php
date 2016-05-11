<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>啊咿呀哟 管理中心 - <?php echo ($meta_title); ?> </title>
        <meta name="robots" content="noindex, nofollow" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="http://admin.shop.com/Public/css/general.css" rel="stylesheet" type="text/css" />
        <link href="http://admin.shop.com/Public/css/main.css" rel="stylesheet" type="text/css" />
        
    <link rel="stylesheet" type="text/css" href="http://admin.shop.com/Public/ext/ztree/css/zTreeStyle/zTreeStyle.css" />
    <style type='text/css'>
        .ztree{
            width:220px;
            height:auto;
            margin-top: 10px;
            border: 1px solid #617775;
            background: #f0f6e4;
            overflow-y: scroll;
            overflow-x: auto;
        }
    </style>

    </head>
    <body>
        

<h1>
    <span class="action-span"><a href="<?php echo U('index');?>">商品分类管理</a></span>
    <span class="action-span1"><a href="#">啊咿呀哟 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($meta_title); ?> </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form action="__GROUP__/Category/categoryAdd" method="post" name="theForm" enctype="multipart/form-data">
        <table width="100%" id="general-table">
            <tr>
                <td class="label">分类名称:</td>
                <td>
                    <input type='text' name='cat_name' maxlength="20" value='' size='27' /> <font color="red">*</font>
                </td>
            </tr>
            <tr>
                <td class="label">上级分类:</td>
                <td>
                    <input type="hidden" name="parent_id" id="parent_id" value=""/>
                    <input type="text" id="parent_name" value="请选择" disabled="disabled" style="padding-left:5px;"/>
                    <ul id='goods-categories-tree' class='ztree' style='height:auto;'></ul>
                </td>
            </tr>
            <tr>
                <td class="label">排序:</td>
                <td>
                    <input type="text" name='sort'  value="50" size="15" />
                </td>
            </tr>
            <tr>
                <td class="label">是否显示:</td>
                <td>
                    <input type="radio" name="status" value="1"  checked="true"/> 是
                    <input type="radio" name="status" value="0"  /> 否
                </td>
            </tr>

            <tr>
                <td class="label">介绍:</td>
                <td>
                    <textarea rows="5" cols="25" name="intro">

                    </textarea>
                </td>
            </tr>
        </table>
        <div class="button-div">
            <input type="submit" value=" 确定 " />
            <input type="reset" value=" 重置 " />
        </div>
    </form>
</div>

        <div id="footer">
            共执行 <?php echo N('db_query');?> 个查询，用时  <?php echo G('viewStartTime','viewEndTime');?>s，内存占用 <?php echo number_format((memory_get_usage() - $GLOBALS['_startUseMems'])/1024,2);?> KB<br />
            版权所有 &copy; 1988-<?php echo date('Y');?> 啊咿呀哟母婴用品有限公司，并保留所有权利。
        </div>
        
    <script type="text/javascript" src="http://admin.shop.com/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="http://admin.shop.com/Public/ext/ztree/js/jquery.ztree.core.min.js"></script>

    <script type='text/javascript'>
        var setting = {
            data: {
                simpleData: {
                    enable: true,
                    pIdKey: "parent_id",
                }
            },
            callback: {
                onClick: function(event,tree_id,tree_node){
                    var goods_category_name=tree_node.name;
                    var goods_category_id=tree_node.id;
//                    console.debug(goods_category_name,goods_category_id);
                    $('#parent_name').val(goods_category_name);
                    $('#parent_id').val(goods_category_id);
                },
            }
        };

        var zNodes=<?php echo ($goods_categories); ?>;
        $(function(){
            var goods_category_ztree = $.fn.zTree.init($("#goods-categories-tree"),setting,zNodes);
            goods_category_ztree.expandAll(true);
        });

    </script>

    </body>
</html>