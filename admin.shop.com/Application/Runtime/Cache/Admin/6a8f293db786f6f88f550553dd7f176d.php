<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>啊咿呀哟 管理中心 - <?php echo ($meta_title); ?> </title>
        <meta name="robots" content="noindex, nofollow" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="http://admin.shop.com/Public/css/general.css" rel="stylesheet" type="text/css" />
        <link href="http://admin.shop.com/Public/css/main.css" rel="stylesheet" type="text/css" />
        
    <link rel="stylesheet" type="text/css" href="http://admin.shop.com/Public/ext/uploadify/common.css" />
    <link rel="stylesheet" type="text/css" href="http://admin.shop.com/Public/ext/layer/layer/skin/layer.css" />
    <link rel="stylesheet" type="text/css" href="http://admin.shop.com/Public/ext/ztree/css/zTreeStyle/zTreeStyle.css" />
    <style type='text/css'>
        .myupload-pre-item img{
            width:150px;
        }

        .myupload-pre-item{
            display:inline-block;
        }

        .myupload-pre-item a{
            position:relative;
            top:5px;
            right:15px;
            float:right;
            color:red;
            font-size:16px;
            text-decoration:none;
        }
         /*商品分类 ztree样式*/
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
        <span class="action-span"><a href="<?php echo U('index');?>">商品列表</a>
        </span>
        <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心</a></span>
        <span id="search_id" class="action-span1"> - <?php echo ($meta_title); ?> </span>
        <div style="clear:both"></div>
    </h1>

    <div class="tab-div">
        <div id="tabbody-div">
            <form enctype="multipart/form-data" action="<?php echo U('');?>" method="post">
                <table width="90%" id="general-table" align="center">
                    <tr>
                        <td class="label">商品名称：</td>
                        <td><input type="text" name="name" value="<?php echo ($row["name"]); ?>" size="30" />
                            <span class="require-field">*</span></td>
                    </tr>
                    <tr>
                        <td class="label">商品货号： </td>
                        <td>
                            <input type="text" name="sn" value="<?php echo ($row["sn"]); ?>" size="20" disabled="disabled"/>
                            <span id="goods_sn_notice"></span>
                            <span class="notice-span"id="noticeGoodsSN">如果您不输入商品货号，系统将自动生成一个唯一的货号。</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">LOGO：</td>
                        <td>
                            <input type="hidden" name="logo" value="<?php echo ($row["logo"]); ?>" id="logo-data"/>
                            <input type="file"  id="logo" style="background-color: green;"><br/>
                            <img src="<?php echo ($row["logo"]); ?>" id="logo-img" style="width:80px;"/>
                            <!--<a  href="#" id="button">隐藏图片</a>-->
                        </td>
                    </tr>
                    <tr>
                        <td class="label">商品分类：</td>
                        <td>
                            <input type="hidden" name='goods_category_id' id="goods_category_id" value=""/>
                            <input type="text" id="goods_category_name" value="请选择" disabled="disabled" style="padding-left:5px;"/>
                            <ul id='goods-categories-tree' class='ztree' style='height:auto;'></ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">商品品牌：</td>
                        <td>
                            <?php echo arr2select($brands,'id','name','brand_id',$row["brand_id"]);?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">供货商：</td>
                        <td>
                            <?php echo arr2select($suppliers,'id','name','supplier_id',$row["supplier_id"]);?>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">本店售价：</td>
                        <td>
                            <input type="text" name="shop_price" value="<?php echo ($row["shop_price"]); ?>" size="20"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">市场售价：</td>
                        <td>
                            <input type="text" name="market_price" value="<?php echo ($row["market_price"]); ?>" size="20" />
                        </td>
                    </tr>
                    <tr>
                        <td class="label">商品数量：</td>
                        <td>
                            <input type="text" name="stock" size="8" value="<?php echo ((isset($row["stock"]) && ($row["stock"] !== ""))?($row["stock"]): 50); ?>"/>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">加入推荐：</td>
                        <td>
                            <label><input type="checkbox" name="goods_status[]" value="1" class="goods_status"/> 精品</label>
                            <label><input type="checkbox" name="goods_status[]" value="2" class="goods_status"/> 新品</label>
                            <label><input type="checkbox" name="goods_status[]" value="4" class="goods_status"/> 热销</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">推荐排序：</td>
                        <td>
                            <input type="text" name="sort" size="5" value="<?php echo ((isset($row["sort"]) && ($row["sort"] !== ""))?($row["sort"]): 20); ?>"/>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">是否上架：</td>
                        <td>
                            <label><input type="radio" name="is_on_sale" value="1" class='is_on_sale'/> 是</label>
                            <label><input type="radio" name="is_on_sale" value="0" class='is_on_sale'/> 否</label>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td><hr /></td>
                    </tr>

                    <tr>
                        <td class="label">商品详细描述：</td>
                        <td>
                            <textarea name="content" cols="40" rows="3" id='editor'><?php echo ($row["content"]); ?></textarea>
                        </td>
                    </tr>


                    <tr>
                        <td></td>
                        <td><hr /></td>
                    </tr>

                    <tr>
                        <td class="label">商品相册：</td>
                        <td>
                            <div class="myupload-img-box">
                               <?php if(is_array($row["paths"])): foreach($row["paths"] as $key=>$path): ?><div class="myupload-pre-item">
                                   <img src="<?php echo ($path); ?>"/>
                                   <a href="#" data="<?php echo ($key); ?>">×</a>
                                   </div><?php endforeach; endif; ?>

                            </div>

                            <div>
                                <input type="file" id="gallery"/>
                            </div>
                        </td>
                    </tr>
                </table>


                <div class="button-div">
                    <input type="hidden" name="id" value="<?php echo ($row["id"]); ?>"/>
                    <input type="submit" value=" 确定 " class="button"/>
                    <input type="reset" value=" 重置 " class="button" />
                </div>
            </form>
        </div>
    </div>

        <div id="footer">
            共执行 <?php echo N('db_query');?> 个查询，用时  <?php echo G('viewStartTime','viewEndTime');?>s，内存占用 <?php echo number_format((memory_get_usage() - $GLOBALS['_startUseMems'])/1024,2);?> KB<br />
            版权所有 &copy; 1988-<?php echo date('Y');?> 啊咿呀哟母婴用品有限公司，并保留所有权利。
        </div>
        
    <script type="text/javascript" src="http://admin.shop.com/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="http://admin.shop.com/Public/ext/uploadify/jquery.uploadify.min.js"></script>
    <script type="text/javascript" src="http://admin.shop.com/Public/ext/layer/layer/layer.js"></script>
    <script type="text/javascript" src="http://admin.shop.com/Public/ext/ue/myue.config.js"></script>
    <script type="text/javascript" src="http://admin.shop.com/Public/ext/ue/ueditor.all.min.js"></script>
    <script type="text/javascript" src="http://admin.shop.com/Public/ext/ue/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" src="http://admin.shop.com/Public/ext/ztree/js/jquery.ztree.core.min.js"></script>

    <script type='text/javascript'>


        $(function(){
            //实例化编辑器
            //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
            var ue = UE.getEditor('editor',{serverUrl: '<?php echo U('Editor/ueditor');?>'});

//            $('#button').click(function(){
//                $('#logo-img').hide();
//            });
//            $('#button').dblclick(function(){
//                $('#logo-img').show();
//            });

            // 展示商品分类数据
            show_goods_category_tree();
            // 调用上传图片方法
            upload_goods();
            // 调用上传相册方法
            upload_gallery();
//        <div class="myupload-img-box">
//                <?php if(is_array($row["paths"])): foreach($row["paths"] as $key=>$path): ?>//                <div class="myupload-pre-item">
//                <img src="<?php echo ($path); ?>"/>
//                <a href="#" data="<?php echo ($key); ?>">×</a>
//        </div>
//<?php endforeach; endif; ?>
//
//        </div>

          // 相册a标签点击事件
        $(".myupload-img-box").on('click','.myupload-pre-item a',function(){
            // 找到当前节点
            var node = $(this);
            // 获取data属性值
            var data = node.attr('data');
//            alert(data);
//            console.debug($(this).attr('data'));
            if(data){ //已有的数据 ajax删除
                var url = '<?php echo U('GoodsGallery/delete');?>';
                var  send_data = {
                    "id":data,
                }
                $.getJSON(url,send_data,function(v){
//                    console.debug(v);
                    if(v.status){
                        node.parent().remove();

                    }
                })
            }else{

                node.parent().remove();
            }
            layer.msg('删除成功',{icon:6,time:1000});
                 return false;
        });


            // 选中单选框
            $('.is_on_sale').val([<?php echo ((isset($row["is_on_sale"]) && ($row["is_on_sale"] !== ""))?($row["is_on_sale"]):1); ?>]);
            // 回显商品的市场状态
        <?php if(isset($row)): ?>var goods_status = <?php echo ($row['goods_status']); ?>;
//        alert(goods_status);
        var goods_checked_value = [];
            if(1 & goods_status){
                goods_checked_value.unshift(1);
            }

            if(2 & goods_status){
                goods_checked_value.unshift(2);
            }

            if(4 & goods_status){
                goods_checked_value.unshift(4);
            }
        $('.goods_status').val(goods_checked_value);<?php endif; ?>

        });


        function upload_gallery(){
            $('#gallery').uploadify({
                "swf"              :'http://admin.shop.com/Public/ext/uploadify/uploadify.swf',
                "uploader"         :'<?php echo U("Upload/upload");?>',
                "buttonText"       : "选择文件",
                "fileObjName"      : 'logo',
                "fileSizeLimit"    : '1024kb',
                "fileTypeExts"     : '*.gif;*.png;*.jpg',
                "removeTimeOut"    : 1,
                "buttonClass"      :'k',
//                    "height"           : 100,
//                    "width"            : 100,
                "onUploadSuccess" : function(file,data,respose){
//                        console.dubug(data);
                    data = $.parseJSON(data);
                    if(data.status){

                      var html = '<div class="myupload-pre-item">';
                        html += '<input type="hidden" name="path[]" value="'+data.file_url+'" />';
                        html += '<img src="'+data.file_url+'"/>';
                        html += '<a href="#" date="<?php echo ($key); ?>">×</a></div>';
                        $(html).appendTo($('.myupload-img-box'));
                         // 弹出信息
                        layer.msg('上传成功',{icon:6,time:1000});
                    }else{

                        layer.msg(data.msg,{icon:5,time:1000});
                    }
                }

            });
        }
//        上传图片方法
        function upload_goods(){
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
        }
//         使用ztree方式展示商品分类列表数据
        function show_goods_category_tree() {
//            alert(1);
            var setting = {
                data: {
                    simpleData: {
                        enable: true,
                        pIdKey: "parent_id",
                    }
                },
                callback: {
                    onClick: function (event, tree_id, tree_node) {
                        var goods_category_name = tree_node.name;
                        var goods_category_id = tree_node.id;

                        $('#goods_category_name').val(goods_category_name);
                        $('#goods_category_id').val(goods_category_id);
                    },
                }
            };

            var zNodes = <?php echo ($goods_categories); ?>;
            var goods_category_ztree = $.fn.zTree.init($("#goods-categories-tree"), setting, zNodes);
            goods_category_ztree.expandAll(true);
                <?php if(isset($row)): ?>// 保存当前商品分类节点
                    var goods_category_node = goods_category_ztree.getNodeByParam('id',<?php echo ($row["goods_category_id"]); ?>) ;
                    // 选择分类节点
                    goods_category_ztree.selectNode(goods_category_node);
                    // 回显分类节点值
                    $('#goods_category_id').val(goods_category_node.id);
                    $('#goods_category_name').val(goods_category_node.name);<?php endif; ?>
        }
    </script>

    </body>
</html>