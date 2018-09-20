<?php
namespace app\admin\validate;
class Category extends \think\Validate{
	#验证规则
	protected $rule=[
		'cat_name'=>'require|unique:category',
		'pid'=>'require',
		'cat_id'=>'require',
		'is_show'=>'require',
	];

	#错误信息
	protected $message=[
		'cat_name.require'=>'请填写分类名称',
		'cat_name.unique'=>'该分类重复，请重填',
		'pid.require'=>'请选择父分类',
		'cat_id'=>'出错',
		'is_show'=>'请选择是否显示在导航栏',
	];

	#验证场景
	protected $scene=[
		'add'=>['cat_name','pid','is_show'],
		'upd'=>['cat_name','pid','is_show'],
		'del'=>['cat_id'],
	];
}