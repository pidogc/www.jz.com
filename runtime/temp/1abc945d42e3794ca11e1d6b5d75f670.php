<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"D:\project\www.shop.com\public/../application/home\view\cart\list.html";i:1535438375;s:64:"D:\project\www.shop.com\application\home\view\public\topnav.html";i:1535510672;s:64:"D:\project\www.shop.com\application\home\view\public\footer.html";i:1535245889;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>购物车页面</title>
	<link rel="stylesheet" href="<?php echo config('static_home'); ?>/style/base.css" type="text/css">
	<link rel="stylesheet" href="<?php echo config('static_home'); ?>/style/global.css" type="text/css">
	<link rel="stylesheet" href="<?php echo config('static_home'); ?>/style/header.css" type="text/css">
	<link rel="stylesheet" href="<?php echo config('static_home'); ?>/style/cart.css" type="text/css">
	<link rel="stylesheet" href="<?php echo config('static_home'); ?>/style/footer.css" type="text/css">

	<script type="text/javascript" src="<?php echo config('static_home'); ?>/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="<?php echo config('static_home'); ?>/js/cart1.js?v=1"></script>
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
			<div class="flow fr">
				<ul>
					<li class="cur">1.我的购物车</li>
					<li>2.填写核对订单信息</li>
					<li>3.成功提交订单</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<div style="clear:both;"></div>

	<!-- 主体部分 start -->
	<div class="mycart w990 mt10 bc">
		<h2><span>我的购物车</span></h2>
		<table>
			<thead>
				<tr>
					<th class="col1">商品名称</th>
					<th class="col2">商品信息</th>
					<th class="col3">单价</th>
					<th class="col4">数量</th>	
					<th class="col5">小计</th>
					<th class="col6">操作</th>
				</tr>
			</thead>
			<tbody>
			<?php $total=0;foreach($carts as $v){  $totalprice=$v['goodsInfo']['goods_price']+$v['attr']['attrTotalPrice'];  $xiaoji=$totalprice*$v['goods_number'];$total+=$xiaoji; ?>
				<tr>
					<td class="col1"><a href="<?php echo url('/home/goods/detail',['goods_id'=>$v['goods_id'],'goods_attr_ids'=>$v['goods_attr_ids'],'goods_number'=>$v['goods_number']]); ?>"><img src="/uploads/<?php echo json_decode($v['goodsInfo']['goods_middle'])[0]; ?>" alt="" /></a>  <strong><a href=""><?php echo $v['goodsInfo']['goods_name'] ?></a></strong></td>
					<td class="col2"> <p><?php  echo $v['attr']['attrInfo']  ?></p></td>
					<td class="col3">￥<span><?php echo $totalprice; ?></span></td>
					<td class="col4" goods_id="<?php echo $v['goods_id']; ?>" goods_attr_ids="<?php echo $v['goods_attr_ids']; ?>" > 
									<!-- 点击减少 -->
						<a href="javascript:;" class="reduce_num"></a>
									<!-- 数量文本框 -->
						<input type="text" name="amount" value="<?php echo $v['goods_number'] ?>" class="amount"/>
									<!-- 点击增加 -->
						<a href="javascript:;" class="add_num"></a>
					</td>
					<td class="col5">￥<span><?php echo $xiaoji; ?></span></td>
					<td class="col6">
						<input type='hidden' name='goods_id' value="<?php echo $v[goods_id]; ?>">
						<input type='hidden' name='goods_attr_ids' value="<?php echo $v[goods_attr_ids]; ?>">
						<a href="javascript:;" class='delgoodscart'>删除</a>
					</td>
				</tr>
			<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6">购物金额总计： <strong>￥ <span id="total"><?php echo $total; ?></span></strong></td>
				</tr>
			</tfoot>
		</table>
		<div class="cart_btn w990 bc mt10">
			<a href="" class="continue">继续购物</a>
			<a href="javascript:;" class="continue clearAll" style='margin-left:10px;'>清空购物车</a>
			<a href="<?php echo url('home/order/orderlist'); ?>" class="checkout">结 算</a>
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

	//点击删除
	$('.delgoodscart').click(function(){
		var obj=$(this);
		layer.confirm('确定删除吗?', {icon: 2,}, function(index){
		 	var goods_id=obj.parent('td').children(':eq(0)').val();
		 	var goods_attr_ids=obj.parent().children(':eq(1)').val();
		 	var parm={'goods_id':goods_id,'goods_attr_ids':goods_attr_ids};
		  	$.post("<?php echo url('/home/cart/delgoodscart'); ?>",parm,function(result){
		  		if(result.code==200){
		  			layer.msg(result.msg);
		  			obj.parents('tr').remove();
		  			return;
		  		}
		  		layer.msg(result.msg);
		  	},'json');

		  //关闭弹框
		  layer.close(index);
		});
	});
	
	//点击清空购物车
	$('.clearAll').click(function(){
		$.post("<?php echo url('/home/cart/clear'); ?>",function(result){
			if(result.code==200){
				layer.msg(result.msg);
				$('tbody').remove();
				$('tfoot').remove();
				return;
			}
			layer.msg(result.msg);
		},'json');
	});

	//点击事件，弹框无刷新回显
	$('.login').click(function(){
		 layer.open({
                type: 2,
                title: '用户登录',
                //fix: false,
                //maxmin: true,
                //shadeClose: true,
                skin:'layui-layer-lan',
                shadeClose: true,
                area: ['1000px', '500px'],
                content: '<?php echo url("/home/public/login1"); ?>',
               //content: 'www.baidu.com',
               });
	});

	//点击事件，退出确认
	$(document).on('click','#loginout',function(){
		layer.confirm('确定要退出吗?',{icon: 1,title:'退出'},function(index){
		 	location.href="<?php echo url('/home/public/loginout'); ?>";
		  layer.close(index);
		});
	});

	//弹框无刷新回显
	function loginchange(username){

		var html="<li>您好，"+username+"欢迎来到Ori！"+"[<a href='javascript:;' id='loginout'>退出</a>]"+"<li class='line'>|</li>"+"<li>我的订单</li><li class='line'>|</li><li>客户服务</li></li>";

		var person_html="您好，"+username+"&nbsp;&nbsp;<a href='javascript:;'>个人中心</a>";


		$('#nav_login').html('').html(html);
		$('#person_login').html(person_html);
	}
</script>
</html>
