<?php
namespace app\admin\controller;
use app\admin\model\User;
class PublicController extends \think\Controller{

	#后台登录
	public function login(){
		if(Request()->isAjax()){
			$userModel=new User();
			$postData=input('post.');

			$validate=$this->validate($postData,'User.login',[]);
			if($validate!==true){
				return json(['code'=>-1,'msg'=>$validate]);
			}
			if($userModel->checkLogin($postData)){
				return json(['code'=>200]);
			}else{
				return json(['code'=>-1,'msg'=>'用户名或密码错误']);
			}
		}
		return $this->fetch();
	}

	#后台退出
	public function loginOut(){
		session('user_id',null);
		session('username',null);
		session('vis',null);
		$this->success('安全注销成功',url('/admin/login'));
	}
}