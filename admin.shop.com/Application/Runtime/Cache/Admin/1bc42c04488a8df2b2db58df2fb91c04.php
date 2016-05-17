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
        <span class="action-span"><a href="<?php echo U('index');?>">管理员管理</a></span>
        <span class="action-span1"><a href="#">啊咿呀哟 管理中心</a></span>
        <span id="search_id" class="action-span1"> - <?php echo ($meta_title); ?> </span>
    </h1>
    <div style="clear:both"></div>
    <div class="main-div">
        <form method="post" action="<?php echo U('');?>" enctype="multipart/form-data" >
            <table cellspacing="1" cellpadding="3" width="100%">
                <tr>
                    <td class="label">管理员名称</td>
                    <td>
                        <?php if(isset($row)): echo ($row["username"]); ?>
                            <?php else: ?>
                            <input type="text" name="username" maxlength="60" value="<?php echo ($row["name"]); ?>" /><?php endif; ?>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">关联角色</td>
                    <td>
                        <?php if(is_array($roles)): foreach($roles as $key=>$role): ?><label><input type='checkbox' name='role_id[]' value='<?php echo ($role["id"]); ?>' class='role_id' /><?php echo ($role["name"]); ?></label><?php endforeach; endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="label">密码</td>
                    <td>
                        <?php if(isset($row)): ?><input type="password" name="password" placeholder="如需修改，请输入密码"/>
                            <?php else: ?>
                            <input type="password" name="password" placeholder='请输入密码'/><?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="label">确认密码</td>
                    <td>
                        <input type="password" name="repassword"/>
                    </td>
                </tr>
                <tr>
                    <td class="label">邮箱</td>
                    <td>
                        <?php if(isset($row)): echo ($row["email"]); ?>
                            <?php else: ?>
                            <input type="text" name="email"/><?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="label">额外权限</td>
                    <td>
                        <div id='permission-ids'></div>
                        <ul id='permission-tree' class='ztree' style='height:auto;'></ul>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="center"><br />
                        <input type="hidden" name="id" value="<?php echo ($row["id"]); ?>"/>
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
    <script type="text/javascript" src="http://admin.shop.com/Public/ext/layer/layer.js"></script>
    <script type="text/javascript" src="http://admin.shop.com/Public/ext/ztree/js/jquery.ztree.core.min.js"></script>
    <script type="text/javascript" src="http://admin.shop.com/Public/ext/ztree/js/jquery.ztree.excheck.js"></script>
    <script type='text/javascript'>
        var setting = {
            check: {
                enable: true,
                chkboxType: {"Y": "s", "N": "s"},
            },
            data :{
                simpleData:{
                    enable:true,
                    pIdKey:"parent_id",
                }
            },
            callback:{
                onCheck:function(){
//                    alert(1);
                    // 获取勾选的节点列表
                    var nodes = permission_tree.getCheckedNodes(true);
                    // 每一次勾选事件发生 先清空之前已勾选的
                    permission_ids_node.empty();
                    $(nodes).each(function(){
                        // 添加节点到div中
                        var html = '<input type="hidden" name="permission_ids[]" value="'+this.id+'" />';
                        $(html).appendTo(permission_ids_node);
                    })
                }
            }
        };

        // 获取后台传来的所有权限数据
        var zNodes = <?php echo ($permissions); ?>;
        console.debug(zNodes);
        var permission_tree=null;
        var permission_ids_node = $('#permission-ids');
        $(function(){
            // 初始化ztree
            permission_tree = $.fn.zTree.init($('#permission-tree'),setting,zNodes);
            permission_tree.expandAll(true);


            // 回显拥有的权限
            <?php if(isset($row)): ?>// 回显当前管理员拥有的角色
                $('.role_id').val([<?php echo ($row["role_id"]); ?>]);
//                        alert(1);
                            // 获取后台传过来的该管理员拥有的权限
                  var permission_ids = <?php echo ($row["permission_ids"]); ?>;
//                    alert(permission_ids);
                $(permission_ids).each(function(i,e) {
                    console.debug(e);
                    // 找到当前节点
                    var node = permission_tree.getNodeByParam('id',e);
//                    alert(node);
                    permission_tree.checkNode(node,true);

                    // 添加节点到div
                    var html = '<input type="hidden" name="permission_ids[]" value="' + e + '" />';
                    $(html).appendTo(permission_ids_node);
                });<?php endif; ?>
        });
    </script>

    </body>
</html>