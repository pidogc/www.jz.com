<?php
namespace app\admin\validate;

class User extends \think\Validate{
	#验证规则
	protected $rule=[
		'captcha'=>'require|captcha',
		'username'=>'require|min:5|unique:user',
		'password'=>'require|min:5',
		'repassword'=>'require|confirm:password',
		'role_id'=>'require',

	];

	#验证报错信息
	protected $message=[
		'captcha.require'=>'验证码必须填写',
		'captcha.captcha'=>'验证码错误，请重新填写',
		'username.require'=>'用户名不能为空',
		'username.min'=>'用户名不能少于5个字符',
		'password.require'=>'密码不能为空',
		'password.min'=>'密码少于5个字符',
		'repassword.require'=>'确认密码不能为空,请填写',
		'repassword.confirm'=>'确认密码有误',
		'role_id.require'=>'请选择角色!',
	];

	#场景
	protected $scene=[
		'add'=>['username','password','repassword','role_id'],
		'upd'=>['password','repassword','role_id'],
		'login'=>['captcha','username'=>'require|min:5','password'],
	];

}	