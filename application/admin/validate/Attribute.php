<?php
namespace app\admin\validate;
class Attribute extends \think\Validate{
	#验证规则
	protected $rule=[
		'attr_name'=>'require|unique:attribute',
		'type_id'=>'require',
		'attr_type'=>'require',
		'attr_input_type'=>'require',
		'attr_values'=>'requireIf:attr_input_type,1',
		'attr_id'=>'require',
	];

	#错误信息
	protected $message=[
		'attr_name.require'=>'请填写属性名称',
		'attr_name.unique'=>'属性名称重复',
		'type_id.require'=>'请选择商品类型',
		'attr_type.require'=>'请选择属性类型',
		'attr_values.requireIf'=>'请填写属性值',
		'attr_id'=>'删除出错!',
	];

	#验证场景
	protected $scene=[
		'add'=>['attr_name','type_id','attr_type','attr_input_type','attr_values'],
		'upd'=>['attr_name','type_id','attr_type','attr_input_type','attr_values'],
		'del'=>['attr_id'],
	];
}