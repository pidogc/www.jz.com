<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"D:\project\www.shop.com\public/../application/home\view\public\login1.html";i:1535121377;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>登录商城</title>
	<link rel="stylesheet" href="<?php echo config('static_home'); ?>/style/base.css" type="text/css">
	<link rel="stylesheet" href="<?php echo config('static_home'); ?>/style/global.css" type="text/css">
	<link rel="stylesheet" href="<?php echo config('static_home'); ?>/style/header.css" type="text/css">
	<link rel="stylesheet" href="<?php echo config('static_home'); ?>/style/login.css" type="text/css">
	<link rel="stylesheet" href="<?php echo config('static_home'); ?>/style/footer.css" type="text/css">
	<script language="JavaScript" src="<?php echo config('static_home'); ?>/js/jquery-1.8.3.min.js"></script>
	<script language="JavaScript" src="/plugins/PoPlayer/layer.js"></script>
</head>
<body>
<!-- 	顶部导航 start
<div class="topnav">
	<div class="topnav_bd w990 bc">
		<div class="topnav_left">
			
		</div>
		<div class="topnav_right fr">
			<ul>
				<li>您好，欢迎来到京西！[<a href="login.html">登录</a>] [<a href="register.html">免费注册</a>] </li>
				<li class="line">|</li>
				<li>我的订单</li>
				<li class="line">|</li>
				<li>客户服务</li>

			</ul>
		</div>
	</div>
</div>
顶部导航 end -->
	
	<div style="clear:both;"></div>

	<!-- 页面头部 start
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="index.html"><img src="<?php echo config('static_home'); ?>/images/logo.png" alt="京西商城"></a></h2>
		</div>
	</div>
	页面头部 end -->
	
	<!-- 登录主体部分start -->
	<div class="login w990 bc mt10">
		<div class="login_hd">
			<h2>用户登录</h2>
			<b></b>
		</div>
		<div class="login_bd">
			<div class="login_form fl">
				<form action="" method="post" name='form'>
					<ul>
						<li>
							<label for="">用户名：</label>
							<input type="text" class="txt" name="username" />
						</li>
						<li>
							<label for="">密码：</label>
							<input type="password" class="txt" name="password" />
							<a href="<?php echo url('/home/public/gbpwd'); ?>">忘记密码?</a>
						</li>
						<li class="checkcode">
							<label for="">验证码：</label>
							<input type="text"  name="checkcode" />
							<img src="<?php echo captcha_src('login_captcha'); ?>" alt="" />
							<span>看不清？<a href="javascript:;" id='captchachange' >换一张</a></span>
						</li>
						<li>
							<label for="">&nbsp;</label>
							<label><input type="checkbox" class="chb"  /> 保存登录信息</label>
						</li>
						<li>
							<label for="">&nbsp;</label>
							<input type="button" value="" class="login_btn" />
						</li>
					</ul>
				</form>

				<!-- <div class="coagent mt15">
					<dl>
						<dt>使用合作网站登录商城：</dt>
						<dd class="qq"><a href=""><span></span>QQ</a></dd>
						<dd class="weibo"><a href=""><span></span>新浪微博</a></dd>
						<dd class="yi"><a href=""><span></span>网易</a></dd>
						<dd class="renren"><a href=""><span></span>人人</a></dd>
						<dd class="qihu"><a href=""><span></span>奇虎360</a></dd>
						<dd class=""><a href=""><span></span>百度</a></dd>
						<dd class="douban"><a href=""><span></span>豆瓣</a></dd>
					</dl>
				</div> -->
			</div>
			
			<div class="guide fl">
				<!-- <h3>还不是商城用户</h3>-->
				<p style='margin:5px;'>赶紧加入猫猫商城，为你的爱猫购物吧!</p>
				<img src='<?php echo config("static_home"); ?>/images/cat_ico.jpg' width='300'/>
				<a href="<?php echo url('/home/public/register'); ?>" class="reg_btn" style='margin:10px' >免费注册</a>
			</div>

		</div>
	</div>
	<!-- 登录主体部分end -->

	<!-- <div style="clear:both;"></div>
	底部版权 start
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
			<a href=""><img src="<?php echo config('static_home'); ?>/images/xin.png" alt="" /></a>
			<a href=""><img src="<?php echo config('static_home'); ?>/images/kexin.jpg" alt="" /></a>
			<a href=""><img src="<?php echo config('static_home'); ?>/images/police.jpg" alt="" /></a>
			<a href=""><img src="<?php echo config('static_home'); ?>/images/beian.gif" alt="" /></a>
		</p>
	</div>
	底部版权 end -->

</body>
</html>
<script type="text/javascript">

	//点击切换验证码
	$('#captchachange').click(function(){
		$(this).parents('li').children('img').attr('src',"<?php echo captcha_src('login_captcha'); ?>?_="+Math.random());
		$(this).parents('li').children('input').val('');
	});

	//agax提交
	$('.login_btn').click(function(){
		var form=$('form').serialize();
		$.post("<?php echo url('/home/public/login'); ?>",form,function(result){
			if(result.code==200){
				//调用父窗口方法
				window.parent.loginchange(result.username);
				var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
				parent.layer.close(index);

				/*//在iframe子页面中查找父页面元素
	            alert($('#default', window.parent.document).html());
	            //在iframe中调用父页面中定义的变量
	            alert(parent.value);
	            //在iframe中调用父页面中定义的方法
	            parent.sayhello();*/
			}
			layer.msg(result.msg);
			$('#captchachange').click();
		},'json');
	});

	//回车登录
	$(document).keyup(function(e){
		if(e.which==13){
			$('.login_btn').click();
		}
	})

</script>