<?php
namespace app\admin\controller;

class CommonController extends \think\Controller{

	public function _initialize(){
		if(!session('user_id')){
			$this->error('请登陆!',url('/admin/login'));
		}
		#获取地址内的模块和方法名
		$auth_c=Request()->controller();
		$auth_a=Request()->action();
		#判断是否最大权限，并排除后台首页
		if(session('vis')=='*'||strtolower($auth_c)=='index'){
			return ;
		}
		#判断非最大权限用户的权限是否在规定的权限内访问，防止翻墙
		if(!in_array(strtolower($auth_c.'/'.$auth_a), session('vis'))){
			$this->redirect('/admin/login');
		}

	}
} 