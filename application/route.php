<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

#网站根域名路由
//Route::any('/','admin/index/index');
Route::any('/','home/Index/index');
Route::group('admin',function(){
	#后台首页路由
	Route::get('/index','admin/index/index');
	Route::get('/left','admin/index/left');
	Route::get('/top','admin/index/top');
	Route::get('/main','admin/index/main');

	#用户管理模块路由
	Route::any('/user/add','admin/user/add');
	Route::any('/user/upd','admin/user/upd');
	Route::get('/user/list','admin/user/list');
	Route::get('/user/del','admin/user/del');

	#后台登录模块路由
	Route::any('/login','admin/public/login');
	Route::any('/loginout','admin/public/loginout');

	#权限模块路由
	Route::any('/auth/add','admin/auth/add');
	Route::any('/auth/list','admin/auth/list');
	Route::any('/auth/upd','admin/auth/upd');
	Route::any('/auth/del','admin/auth/del');

	#角色模块路由
	Route::any('/role/add','admin/role/add');
	Route::any('/role/list','admin/role/list');
	Route::any('/role/upd','admin/role/upd');
	Route::get('/role/del','admin/role/del');

	#商品类型模块
	Route::any('/type/add','admin/type/add');
	Route::any('/type/list','admin/type/list');
	Route::any('/type/upd','admin/type/upd');
	Route::get('/type/del','admin/type/del');
	Route::get('/type/attrshow','admin/type/attrshow');

	#商品属性模块
	Route::any('/Attribute/add','admin/Attribute/add');
	Route::any('/Attribute/list','admin/Attribute/list');
	Route::any('/Attribute/upd','admin/Attribute/upd');
	Route::get('/Attribute/del','admin/Attribute/del');

	#商品分类管理模块
	Route::any('/category/add','admin/category/add');
	Route::any('/category/list','admin/category/list');
	Route::any('/category/upd','admin/category/upd');
	Route::get('/category/del','admin/category/del');
	Route::get('/category/callback','admin/category/callback');

	#商品管理模块
	Route::any('/goods/add','admin/goods/add');
	Route::any('/goods/list','admin/goods/list');
	Route::any('/goods/upd','admin/goods/upd');
	Route::get('/goods/del','admin/goods/del');
	Route::get('/goods/change','admin/goods/change');
	Route::get('/goods/showcontent','admin/goods/showcontent');
	Route::any('/goods/excel','admin/goods/excel');

	#订单管理模块
	Route::any('/order/list','admin/order/list');
	Route::any('/order/setlogistics','admin/order/setlogistics');
	Route::any('/order/looklogistics','admin/order/looklogistics');

	#vue测试
	Route::any('/order/test','admin/order/test');

	Route::any('/order/kaoshi1','admin/order/kaoshi1');
});

Route::group('home',function(){
	#首页模块
	Route::get('/index/index','home/index/index');

	#登录，注册
	Route::any('/public/register','home/public/register');
	Route::any('/public/login','home/public/login');
	Route::any('/public/gbpwd','home/public/gbpwd');
	Route::any('/public/sendMsg','home/public/sendMsg');
	Route::any('/public/checkuser','home/public/checkuser');
	Route::get('/public/loginout','home/public/loginout');
	Route::any('/public/change/:member_id/:hash/:time/:email','home/public/change');

	#商品列表(模块)
	Route::any('/category/list','home/category/list');

	#商品单页(具体商品页面)
	Route::any('/goods/detail','home/goods/detail');
	Route::any('/goods/clearlookgoods','home/goods/clearlookgoods');

	#购物车模块
	Route::any('/cart/addgoodscart','home/cart/addgoodscart');
	Route::any('/cart/list','home/cart/list');
	Route::any('/cart/delgoodscart','home/cart/delgoodscart');
	Route::any('/cart/clear','home/cart/clear');
	Route::any('/cart/change','home/cart/change');

	#购物结算模块
	Route::any('order/orderlist','home/order/orderlist');
	Route::any('order/orderPay','home/order/orderPay');
	Route::any('order/paycomplete','home/order/paycomplete');
	Route::any('order/selforder','home/order/selforder');
	Route::any('order/selfpay','home/order/selfpay');
	#唤醒支付宝
	Route::any('order/callAlipay','home/order/callAlipay');

	#支付宝支付页面
	Route::any('order/paymoneny','home/order/paymoneny');

	#支付宝回调函数
	Route::any('order/paycomplete','home/order/paycomplete');

	#实验弹框登录
	Route::any('/public/login1','home/public/login1');
});
