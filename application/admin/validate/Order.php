<?php
namespace app\admin\validate;
class Order extends \think\Validate{
	#验证规则
	protected $rule=[
		'company'=>'require',
		'number'=>'require',
	];

	#错误信息
	protected $message=[
		'company.require'=>'请选择物流公司',
		'number.require'=>'请输入运单号',
	];

	#验证场景
	protected $scene=[
		'setlogistics'=>['company','number'],
	];
}