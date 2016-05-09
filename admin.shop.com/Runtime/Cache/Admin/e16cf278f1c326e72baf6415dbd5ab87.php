<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>啊咿呀哟 管理中心 - <?php echo ($meta_title); ?> </title>
        <meta name="robots" content="noindex, nofollow" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="http://admin.shop.com/Public/css/general.css" rel="stylesheet" type="text/css" />
        <link href="http://admin.shop.com/Public/css/main.css" rel="stylesheet" type="text/css" />
        
    </head>
    <body>
        
    <h1>
        <span class="action-span"><a href="<?php echo U('index');?>">文章管理</a></span>
        <span class="action-span1"><a href="#">啊咿呀哟 管理中心</a></span>
        <span id="search_id" class="action-span1"> - <?php echo ($meta_title); ?> </span>
    </h1>
    <div style="clear:both"></div>
    <div class="main-div">
        <form method="post" action="<?php echo U('');?>"enctype="multipart/form-data" >
            <table cellspacing="1" cellpadding="3" width="100%">
                <tr>
                    <td class="label">文章名称</td>
                    <td>
                        <input type="text" name="name" maxlength="60" value="<?php echo ($row["name"]); ?>" />
                        <span class="require-field">*</span>
                    </td>
                </tr>

               <!-- <tr>
                    <td class="label">品牌LOGO</td>
                    <td>
                        <input type="file" value="<?php echo ($row["logo"]); ?>" name="logo" id="logo" size="45"><br/>
                        <span class="notice-span" style="display:block"  id="warn_brandlogo">请上传图片，做为品牌的LOGO！</span>
                    </td>
                </tr>-->
                <tr>
                    <td class="label">文章描述</td>
                    <td>
                        <textarea  name="intro" <?php echo ($row["intro"]); ?> cols="60" rows="4"  ><?php echo ($row["intro"]); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="label">文章分类</td>
                    <td>
                        <select class='category' name="article_category_id">
                            <option value="0">请选择...</option>
                            <?php if(is_array($category_names)): foreach($category_names as $key=>$category): ?><option  value="<?php echo ($category["id"]); ?>" >
                                <?php echo ($category['name']); ?>
                                </option><?php endforeach; endif; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="label">文章排序</td>
                    <td>
                        <input type="text" name="sort" maxlength="40" size="15" value="<?php echo ($row["sort"]); ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="label">文章内容</td>
                    <td>
                        <textarea  name="content" value="{}" cols="60" rows="4"  ><?php echo ($row["content"]); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否显示</td>
                    <td>
                        <input type="radio" class="status" name="status" value="1" /> 是
                        <input type="radio" class="status" name="status" value="0"  /> 否
                    </td>
                </tr>
                <!--<tr>-->
                    <!--<td class="label">是否帮助类</td>-->
                    <!--<td>-->
                        <!--<input type="radio" class="is_help" name="is_help" value="1" /> 是-->
                        <!--<input type="radio" class="is_help" name="is_help" value="0"  /> 否-->
                    <!--</td>-->
                <!--</tr>-->
                <tr>
                    <td colspan="2" align="center"><br />
                        <input type="hidden" name="id" value="<?php echo ($row['id']); ?>"/>
                        <input type="submit" class="button" value=" 确定 " />
                        <input type="reset" class="button" value=" 重置 " />
                    </td>
                </tr>
            </table>
        </form>
    </div>

        <div id="footer">
            共执行 <?php echo N('db_query');?> 个查询，用时  <?php echo G('viewStartTime','viewEndTime');?>s，内存占用 <?php echo number_format((memory_get_usage() - $GLOBALS['_startUseMems'])/1024,2);?> KB<br />
            版权所有 &copy; 1988-<?php echo date('Y');?> 啊咿呀哟母婴用品有限公司，并保留所有权利。
        </div>
        
    <script type="text/javascript" src="http://admin.shop.com/Public/js/jquery.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $('.status').val([<?php echo ((isset($row["status"]) && ($row["status"] !== ""))?($row["status"]):1); ?>]);
            $('.is_help').val([<?php echo ((isset($row["status"]) && ($row["status"] !== ""))?($row["status"]):1); ?>]);
        <?php if(isset($row)): ?>$('.category').val([<?php echo ($row["article_category_id"]); ?>]);
        });<?php endif; ?>
    </script>

    </body>
</html>