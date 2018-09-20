<?php
namespace app\home\model;

class Member extends \think\Model{
	protected $pk='member_id';
	protected $autoWriteTimestamp = true;

	#检查账号密码是否正确
	public function check($postdata){
		
		//判断账号是否存在
		$data=$this->field('member_id,username,password')->where('username',$postdata['username'])->find();

		if($data){		
			//判断密码是否匹配
			if($data['password']==md5($postdata['password'].config('password_salt'))){
				session('username',$data['username']);
				session('member_id',$data['member_id']);
				return true;
			}
		}
		return false;
	}

	#检查账号邮箱是否关联
	public function emailCheck($postdata){
		$data=$this->field('member_id,email')->where('username',$postdata['username'])->find();

		//判断账号是否存在
		if($data){
			//若存在，email是否有关联
			if($postdata['email']==$data['email']){
				return true;
			}
		}
		return $data['member_id'];
	}

	#模型事件
	public static function init(){
		#前钩子，添加前加密密码
		Member::event('before_insert',function($data){
			$data['password']=md5($data['password'].config('password_salt'));
		});

		#前钩子，更新密码加密
		Member::event('before_update',function($data){
			$data['password']=md5($data['password'].config('password_salt'));
		});
	}
}