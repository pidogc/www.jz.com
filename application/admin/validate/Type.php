<?php
namespace app\admin\validate;
class Type extends \think\Validate{
	#验证规则
	protected $rule=[
		'type_name'=>'require|unique:type',
		'type_id'=>'require',
	];

	#错误信息
	protected $message=[
		'type_name.require' => '请填写商品类型名称',
		'type_name.unique'=>'该类型已存在，请重新填写!',
		'type_id.require'=>'删除出错!',
	];

	#验证场景
	protected $scene=[
		'add'=>['type_name'],
		'del'=>['type_id'],
		'upd'=>['type_name'],
	];
}