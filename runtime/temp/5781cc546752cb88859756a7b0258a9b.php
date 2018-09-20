<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:76:"D:\project\www.shop.com\public/../application/home\view\order\orderlist.html";i:1535470591;s:64:"D:\project\www.shop.com\application\home\view\public\topnav.html";i:1535510672;s:64:"D:\project\www.shop.com\application\home\view\public\footer.html";i:1535245889;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>填写核对订单信息</title>
	<link rel="stylesheet" href="<?php echo config('static_home'); ?>/style/base.css" type="text/css">
	<link rel="stylesheet" href="<?php echo config('static_home'); ?>/style/global.css" type="text/css">
	<link rel="stylesheet" href="<?php echo config('static_home'); ?>/style/header.css" type="text/css">
	<link rel="stylesheet" href="<?php echo config('static_home'); ?>/style/fillin.css" type="text/css">
	<link rel="stylesheet" href="<?php echo config('static_home'); ?>/style/footer.css" type="text/css">

	<script type="text/javascript" src="<?php echo config('static_home'); ?>/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="<?php echo config('static_home'); ?>/js/cart2.js"></script>
	<script language="JavaScript" src="/plugins/PoPlayer/layer.js"></script>
</head>
<body>
	<!-- 顶部导航 start -->
	<div class="topnav">
		<div class="topnav_bd w1210 bc">
			<div class="topnav_left">
				
			</div>
			<div class="topnav_right fr">
				<ul id='nav_login'>
				<!-- >
					<li>
						您好，<?php echo session('username'); ?>欢迎来到Ori！
						[<a href="<?php echo url('/home/public/loginout'); ?>">退出</a>] 
						[<a href="<?php echo url('/home/public/register'); ?>">免费注册</a>]
						<li class="line">|</li>
						<li>我的订单</li>
						<li class="line">|</li>
						<li>客户服务</li>
					</li> -->
					<?php if(!session('username')){ ?>
					<li>
						您好，欢迎来到Ori！
						[<a href="<?php echo url('/home/public/login'); ?>">登录</a>]
						[<a href="javascript:;" class='login'>登录(弹框)</a>]
						[<a href="<?php echo url('/home/public/register'); ?>">免费注册</a>]
					</li>
					<li class="line">|</li>
					<li>我的订单</li>
					<li class="line">|</li>
					<li>客户服务</li>
					<?php }else{ ?>
					<li>
						您好，<?php echo session('username'); ?>欢迎来到Ori！
						[<a href='javascript:;' id='loginout'>退出</a>]
						<li class='line'>|</li><a href='<?php echo url("/home/order/selforder"); ?>' ><li>我的订单</li></a>
						<li class='line'>|</li><li>客户服务</li>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>
	
	<!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="index.html"><img src="<?php echo config('static_home'); ?>/images/logo.png" alt="京西商城"></a></h2>
			<div class="flow fr flow2">
				<ul>
					<li>1.我的购物车</li>
					<li class="cur">2.填写核对订单信息</li>
					<li>3.成功提交订单</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<div style="clear:both;"></div>

	<!-- 主体部分 start -->
	<div class="fillin w990 bc mt15">
		<div class="fillin_hd">
			<h2>填写并核对订单信息</h2>
		</div>

		<div class="fillin_bd">
			<!-- 收货人信息  start-->
			<div class="address">
				<div class="address_select">
					<form action="<?php echo url('home/order/orderPay'); ?>" method="post"  name="address_form">
						<ul>
							<li>
								<label for=""><span>*</span>收 货 人：</label>
								<input type="text" name="receiver" class="txt" />
							</li>
							<li>
								<label for=""><span>*</span>收货地址：</label>
								<input type="text" name="address" class="txt" />
							<li>
								<label for=""><span>*</span>电话：</label>
								<input type="text" name="phone" class="txt"  />
							</li>
							<li>
								<label for=""><span>*</span>邮编：</label>
								<input type="text" name="zcode" class="txt" />
							</li>
						</ul>
					</form>
					
				</div>
			</div>
			<!-- 收货人信息  end-->

			

			<!-- 商品清单 start -->
			<div class="goods">
				<h3>商品清单</h3>
				<table>
					<thead>
						<tr>
							<th class="col1">商品</th>
							<th class="col2">规格</th>
							<th class="col3">价格</th>
							<th class="col4">数量</th>
							<th class="col5">小计</th>
						</tr>	
					</thead>
					<tbody>
					<?php $totalnum=0;$total=0;foreach($cartdata as $v){  $totalprice=$v['goodsInfo']['goods_price']+$v['attr']['attrTotalPrice'];  $xiaoji=$totalprice*$v['goods_number'];$total+=$xiaoji;  $totalnum+=$v['goods_number'] ?>
						<tr>
							<td class="col1"><a href="<?php echo url('/home/goods/detail',['goods_id'=>$v['goods_id'],'goods_attr_ids'=>$v['goods_attr_ids'],'goods_number'=>$v['goods_number']]); ?>"><img src="/uploads/<?php echo json_decode($v['goodsInfo']['goods_middle'])[0]; ?>" alt="" /></a>  <strong><a href=""><?php echo $v['goodsInfo']['goods_name'] ?></a></strong></td>
							<td class="col2"> <p><?php  echo $v['attr']['attrInfo']  ?></p></td>
							<td class="col3">￥<span><?php echo $totalprice; ?></span></td>
							<td class="col4" goods_id="<?php echo $v['goods_id']; ?>" goods_attr_ids="<?php echo $v['goods_attr_ids']; ?>" > 
											<!-- 数量文本框 -->
								<?php echo $v['goods_number'] ?>			
							</td>
							<td class="col5">￥<span><?php echo $xiaoji; ?></span></td>
							<input type='hidden' name='goods_id' value="<?php echo $v[goods_id]; ?>">
							<input type='hidden' name='goods_attr_ids' value="<?php echo $v[goods_attr_ids]; ?>">
						</tr>
					<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">
								<ul>
									<li>
										<span><?php echo $totalnum; ?> 件商品，总商品金额：</span>
										<em>￥<?php echo $total; ?></em>
									</li>
								</ul>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<!-- 商品清单 end -->
		
		</div>

		<div class="fillin_ft">
			<a href="javascript:;" id='submitOrder'><span>提交订单</span></a>
			<p>应付总额：<strong>￥<?php echo $total; ?>元</strong></p>
			
		</div>
	</div>
	<!-- 主体部分 end -->

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
			<a href=""><img src="<?php echo config('static_home'); ?>/images/xin.png" alt="" /></a>
			<a href=""><img src="<?php echo config('static_home'); ?>/images/kexin.jpg" alt="" /></a>
			<a href=""><img src="<?php echo config('static_home'); ?>/images/police.jpg" alt="" /></a>
			<a href=""><img src="<?php echo config('static_home'); ?>/images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->
</body>
<script type="text/javascript">
	//点击提交表单
	$('#submitOrder').click(function(){
		$('form[name=address_form]').submit();
	});

	//点击事件，退出确认
	$(document).on('click','#loginout',function(){
		layer.confirm('确定要退出吗?',{icon: 1,title:'退出'},function(index){
		 	location.href="<?php echo url('/home/public/loginout'); ?>";
		  layer.close(index);
		});
	});
</script>
</html>
