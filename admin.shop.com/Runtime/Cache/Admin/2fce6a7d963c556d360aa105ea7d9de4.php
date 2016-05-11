<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>啊咿呀哟 管理中心 - <?php echo ($meta_title); ?> </title>
        <meta name="robots" content="noindex, nofollow" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="http://admin.shop.com/Public/css/general.css" rel="stylesheet" type="text/css" />
        <link href="http://admin.shop.com/Public/css/main.css" rel="stylesheet" type="text/css" />
        
    <link rel="stylesheet" type="text/css" href="http://admin.shop.com/Public/ext/uploadify/uploadify.css" />
    <link rel="stylesheet" type="text/css" href="http://admin.shop.com/Public/ext/layer/layer/skin/layer.css" />

    </head>
    <body>
        
    <h1>
        <span class="action-span"><a href="<?php echo U('index');?>">供应商管理</a></span>
        <span class="action-span1"><a href="#">啊咿呀哟 管理中心</a></span>
        <span id="search_id" class="action-span1"> - <?php echo ($meta_title); ?> </span>
    </h1>
    <div style="clear:both"></div>
    <div class="main-div">
        <form method="post" action="<?php echo U('');?>"enctype="multipart/form-data" >
            <table cellspacing="1" cellpadding="3" width="100%">
                <tr>
                    <td class="label">品牌名称</td>
                    <td>
                        <input type="text" name="name" maxlength="60" value="<?php echo ($row["name"]); ?>" />
                        <span class="require-field">*</span>
                    </td>
                </tr>

                <tr>
                    <td class="label">品牌LOGO</td>
                    <td>
                        <input type="hidden" name="logo" value="<?php echo ($row["logo"]); ?>" id="logo-data"/>
                        <input type="file"  id="logo" ><br/>
                        <img src="<?php echo ($row["logo"]); ?>" id="logo-img" style="width:80px;"/>
                    </td>
                </tr>
                <tr>
                    <td class="label">品牌描述</td>
                    <td>
                        <textarea  name="intro" value="<?php echo ($row["sort"]); ?>" cols="60" rows="4"  ></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="label">排序</td>
                    <td>
                        <input type="text" name="sort" maxlength="40" size="15" value="<?php echo ($row["sort"]); ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="label">是否显示</td>
                    <td>
                        <input type="radio" class="status" name="status" value="1" /> 是
                        <input type="radio" class="status" name="status" value="0"  /> 否(当品牌下还没有商品的时候，首页及分类页的品牌区将不会显示该品牌。)
                    </td>
                </tr>
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
    <script type="text/javascript" src="http://admin.shop.com/Public/ext/uploadify/jquery.uploadify.min.js"></script>
    <script type="text/javascript" src="http://admin.shop.com/Public/ext/layer/layer/layer.js"></script>

    <script type="text/javascript">
        $(function(){
            $('.status').val([<?php echo ((isset($row["status"]) && ($row["status"] !== ""))?($row["status"]):1); ?>]);

            $('#logo').uploadify({
                    "swf"              :'http://admin.shop.com/Public/ext/uploadify/uploadify.swf',
                    "uploader"         :'<?php echo U("Upload/upload");?>',
                    "buttonText"       : "选择文件",
                    "fileObjName"      : 'logo',
                    "fileSizeLimit"    : '1024kb',
                    "fileTypeExts"     : '*.gif;*.png;*.jpg',
                    "removeTimeOut"    : 1,
                buttonClass:'k',
//                    "height"           : 100,
//                    "width"            : 100,
                    "onUploadSuccess" : function(file,data,respose){
//                        console.dubug(data);
                     data = $.parseJSON(data);
                     if(data.status){

                         // 为logo隐藏域赋值
                         $('#logo-data').val(data.file_url);
                         // 给img标签一个路径
                         $('#logo-img').attr('src',data.file_url);

                         // 弹出信息
                         layer.msg('上传成功',{icon:6,time:1000});
                     }else{

                         layer.msg(data.msg,{icon:5,time:1000});
                     }
            }

               });
        });


    </script>

    </body>
</html>