<?php
namespace app\home\validate;

class Order extends \think\Validate{
	#rule
	protected $rule=[
		'receiver'=>'require',
		'address'=>'require',
		'phone'=>'require|regex:1[3-8]\d{9}',
		'zcode'=>'require|regex:\d{6}',
	];

	#提示信息
	protected $message=[
		'receiver.require'=>'请填写收货人',
		'address.require'=>'请填写地址',
		'phone.require'=>'请填写手机号码',
		'phone.regex'=>'请输入正确的手机号码',
		'zcode.require'=>'邮政编号必须填写',
		'zcode.regex'=>'请填写正确的邮政编码',
	];

	#验证场景
	protected $scene=[
		//提交订单
		'orderPay'=>['receiver','address','phone','zcode'],
	];
}