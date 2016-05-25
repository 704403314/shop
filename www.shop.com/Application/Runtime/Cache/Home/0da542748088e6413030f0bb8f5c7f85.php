<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <title>购物车页面</title>
        <link rel="stylesheet" href="http://www.shop.com/Public/css/base.css" type="text/css"/>
        <link rel="stylesheet" href="http://www.shop.com/Public/css/global.css" type="text/css"/>
        <link rel="stylesheet" href="http://www.shop.com/Public/css/header.css" type="text/css"/>
        <link rel="stylesheet" href="http://www.shop.com/Public/css/footer.css" type="text/css"/>
        
    <link rel="stylesheet" href="http://www.shop.com/Public/css/fillin.css" type="text/css">

    </head>
    <body>
        <!-- 顶部导航 start -->
        <div class="topnav">
            <div class="topnav_bd w990 bc">
                <div class="topnav_left">

                </div>
                <div class="topnav_right fr">
                    <ul>
                        <li id="userinfo"></li>
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

        <!-- 页面头部 start -->
        <div class="header w990 bc mt15">
            <div class="logo w990">
                <h2 class="fl"><a href="<?php echo U('Index/index');?>"><img src="http://www.shop.com/Public/images/logo.png" alt="京西商城"></a></h2>
                <div class="flow fr <?php echo ($action_name); ?>">
                    <ul>
                        <li <?php if($action_name=="flow1"): ?>class="cur"<?php endif; ?>>1.我的购物车</li>
                        <li <?php if($action_name=="flow2"): ?>class="cur"<?php endif; ?>>2.填写核对订单信息</li>
                        <li <?php if($action_name=="flow3"): ?>class="cur"<?php endif; ?>>3.成功提交订单</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- 页面头部 end -->

        <div style="clear:both;"></div>

        <!-- 主体部分 start -->
        
    <!-- 主体部分 start -->
    <div class="fillin w990 bc mt15">
        <form action="<?php echo U('Order/add');?>" method="post">
        <div class="fillin_hd">
            <h2>填写并核对订单信息</h2>
        </div>

        <div class="fillin_bd">
            <!-- 收货人信息  start-->
            <div class="address">
                <h3>收货人信息 <a href="<?php echo U('Address/index');?>" id="address_modify">[修改]</a></h3>
                <div class="address_info">
                    <?php if(is_array($rows)): foreach($rows as $key=>$row): ?><p>
                            <input type="radio" <?php if(($row["is_default"]) == "1"): ?>checked<?php endif; ?> value="<?php echo ($row["id"]); ?>" name="address_id"/><?php echo ($row["name"]); ?>  <?php echo ($row["tel"]); ?>  <?php echo ($row["province_name"]); ?> <?php echo ($row["city_name"]); ?> <?php echo ($row["area_name"]); ?> <?php echo ($row["detail_address"]); ?>
                        </p><?php endforeach; endif; ?>

                </div>
            </div>
            <!-- 收货人信息  end-->

            <!-- 配送方式 start -->
            <div class="delivery">
                <h3>送货方式 <a href="javascript:;" id="delivery_modify">[修改]</a></h3>
                <div class="delivery_info">
                    <p>普通快递送货上门</p>
                    <p>送货时间不限</p>
                </div>

                <div class="delivery_select none">
                    <table>
                        <thead>
                            <tr>
                                <th class="col1">送货方式</th>
                                <th class="col2">运费</th>
                                <th class="col3">运费标准</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($deliveries)): foreach($deliveries as $key=>$delivery): ?><tr class="cur">
                                <td>
                                    <input class="delivery_item" type="radio" price="<?php echo ($delivery["price"]); ?>" name="delivery_id" value="<?php echo ($delivery["id"]); ?>"
                                    <?php if(($delivery["is_default"]) == "1"): ?>checked="checked"<?php endif; ?> />
                                    <?php echo ($delivery["name"]); ?>

                                </td>
                                <td>￥<?php echo ($delivery["price"]); ?></td>
                                <td><?php echo ($delivery["intro"]); ?></td>
                            </tr><?php endforeach; endif; ?>

                        </tbody>
                    </table>

                </div>
            </div> 
            <!-- 配送方式 end --> 

            <!-- 支付方式  start-->
            <div class="pay">
                <h3>支付方式 <a href="javascript:;" id="pay_modify">[修改]</a></h3>
                <div class="pay_info">
                    <p>货到付款</p>
                </div>

                <div class="pay_select none">
                    <table>
                        <?php if(is_array($payments)): foreach($payments as $key=>$payment): ?><tr class="cur">
                                <td class="col1"><input type="radio" name="pay_type_id" <?php if(($payment["is_default"]) == "1"): ?>checked="checked"<?php endif; ?> value="<?php echo ($payment["id"]); ?>"/><?php echo ($payment["name"]); ?></td>
                                <td class="col2"><?php echo ($payment["intro"]); ?></td>
                            </tr><?php endforeach; endif; ?>


                    </table>

                </div>
            </div>
            <!-- 支付方式  end-->

            <!-- 发票信息 start-->
            <div class="receipt">
                <h3>发票信息 <a href="javascript:;"  id="receipt_modify">[修改]</a></h3>
                <div class="receipt_info">
                    <p>个人发票</p>
                    <p>内容：明细</p>
                </div>

                <div class="receipt_select none">

                        <ul>
                            <li>
                                <label for="">发票抬头：</label>
                                <input type="radio" name="invoice_type" checked="checked" value="1" class="personal" />个人
                                <input type="radio" name="invoice_type" value="2" class="company"/>单位
                                <input type="text" name="invoice_name" value="" class="txt company_input" disabled="disabled" />
                            </li>
                            <li>
                                <label for="">发票内容：</label>
                                <input type="radio" name="invoice_content" value="1" checked="checked" />明细
                                <input type="radio" name="invoice_content" value="2" />办公用品
                                <input type="radio" name="invoice_content" value="3" />体育休闲
                                <input type="radio" name="invoice_content" value="4" />耗材
                            </li>
                        </ul>						

                    <a href="" class="confirm_btn"><span>确认发票信息</span></a>
                </div>
            </div>
            <!-- 发票信息 end-->

            <!-- 商品清单 start -->
            <div class="goods">
                <h3>商品清单</h3>
                <table>
                    <thead>
                        <tr>
                            <th class="col1">商品</th>
                            <th class="col3">价格</th>
                            <th class="col4">数量</th>
                            <th class="col5">小计</th>
                        </tr>	
                    </thead>
                    <tbody>
                    <?php if(is_array($goods_list)): foreach($goods_list as $key=>$goods): ?><tr>
                            <td class="col1"><a href=""><img src="<?php echo ($goods["logo"]); ?>" alt="" /></a>  <strong><a href=""><?php echo ($goods["name"]); ?></a></strong></td>
                            <td class="col3">￥<?php echo ($goods["shop_price"]); ?></td>
                            <td class="col4"> <?php echo ($goods["amount"]); ?></td>
                            <td class="col5"><span>￥<?php echo ($goods["sub_total"]); ?></span></td>
                        </tr><?php endforeach; endif; ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <ul>
                                    <li>
                                        <span><?php echo ($total_amount); ?> 件商品，总商品金额：</span>
                                        <em>￥<?php echo ($total_price); ?></em>
                                    </li>

                                    <li>
                                        <span>运费：</span>
                                        <em class="delivery_price"></em>
                                    </li>
                                    <li>
                                        <span>应付总额：</span>
                                        <em class="total_item"></em>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- 商品清单 end -->
        </form>
        </div>

        <div class="fillin_ft">
            <a href="javascript:;" onclick="$('form').submit();"><span>提交订单</span></a>
                <p>应付总额：<strong class="total_item"></strong></p>

        </div>
    </div>
    <!-- 主体部分 end -->

        <!-- 主体部分 end -->

        <div style="clear:both;"></div>
        <!-- 底部版权 start -->
        <div class="footer w1210 bc mt15">
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
        <script type='text/javascript'>
            /**
             * [
             *  username:'wanglaowu'
             * ]
             * 
             * 您好<?php echo ($user_info["username"]); ?>，欢迎来到京西！
                                    [<a href="<?php echo U('Member/login');?>">登录</a>] [<a href="<?php echo U('Member/register');?>">免费注册</a>]
             * @param {type} param1
             * @param {type} param2
             */
            $.getJSON('<?php echo U("Member/getUserInfo");?>',function(response){
                if(response){
                    var html = '您好'+response+'，欢迎来到京西！[<a href="<?php echo U('Member/logout');?>">退出</a>]';
                }else{
                    var html = '您好,欢迎来到京西![<a href="<?php echo U('Member/login');?>">登录</a>] [<a href="<?php echo U('Member/register');?>">免费注册</a>]';
                }
                $('#userinfo').html(html);
            });
        </script>
        
    <script type="text/javascript" src="http://www.shop.com/Public/js/cart2.js"></script>
    <script type="text/javascript">
        $(function(){

            // 找到被选中的送货方式节点
            var delivery_node = $('.delivery_item:checked');
            // 默认的送货方式价格
            var delivery_price = delivery_node.attr('price');
            // 找到总价格节点
            var total_item_node = $('.total_item');
            // 为运输方式节点赋值
            $('.delivery_price').text('￥'+parseFloat(delivery_price).toFixed(2));
            // 为总价格赋值
            total_item_node.text('￥'+(parseFloat(delivery_price)+<?php echo ($total_price); ?>).toFixed(2)+'元');
            $('.delivery_item').change(function(){

                // 更改后的运输方式价格
                 delivery_price = $(this).attr('price');
                // 找到总价格节点
                 total_item_node = $('.total_item');

                // 为运输方式节点赋值
                $('.delivery_price').text(parseFloat(delivery_price).toFixed(2));
                // 为总价格赋值
                total_item_node.text('￥'+(parseFloat(delivery_price)+<?php echo ($total_price); ?>).toFixed(2)+'元');
            })

        })
    </script>

    </body>
</html>