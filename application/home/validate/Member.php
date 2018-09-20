<?php
namespace app\home\validate;
class Member extends \think\Validate{
	#验证规则
	protected $rule=[
		#login页面验证
		'username'=>'require|unique:member',
		'password'=>'require|regex:\w{6,20}',
		'repassword'=>'require|confirm:password',
		'checkcode'=>'require|captcha:login_captcha',
		//邮箱验证
		'email'=>'require|regex:[0-9a-z_]{3,20}@[0-9a-zA-Z]+(?:\.[a-zA-Z0-9]{2,5})+',
		//验证码
		'captcha'=>'require|captcha:register_captcha',
		//手机验证
		'phone'=>'require|unique:member|regex:1[3-8]\d{9}',
		'checkNum'=>'require',

	];

	#错误信息
	protected $message=[
		'username.require'=>'请填写账号',
		'username.unique'=>'用户名重复',
		'password.require'=>'请填写密码',
		'password.regex'=>'6-20位字符，可使用字母、数字和符号的组合，不建议使用纯数字、纯字母、纯符号',
		'repassword.require'=>'请填写确认密码',
		'repassword.confirm'=>'密码与确认密码不匹配',
		'checkcode.require'=>'请填写验证码',
		'checkcode.captcha'=>'验证码错误，请重新填写',
		'email.require'=>'请填写邮箱',
		'email.regex'=>'邮箱由3-20位字符，可由中文、字母、数字和下划线组成',
		'phone.require'=>'请填写手机号',
		'phone.regex'=>'请填写正确的号码',
		'checkNum'=>'请填写手机短信验证码',
		'captcha.require'=>'请填写验证码',
		'captcha.captcha'=>'验证码错误，请重新填写',
	];

	#验证场景
	protected $scene=[
		'login'=>['username'=>'require','password'=>'require','checkcode'],
		'register'=>['username','password','repassword','email','phone','phonecheck','captcha'],
		'gbpwd'=>['username'=>'require','email'],
		'change'=>['password','repassword'],
	];
}