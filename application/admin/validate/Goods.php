<?php
namespace app\admin\validate;
class Goods extends \think\Validate{
	#验证规则
	protected $rule=[
		'goods_name'=>'require',
		'goods_price'=>'require|regex:\d+',
		'goods_number'=>'require|egt:0',
		'cat_id'=>'require',
		'type_id'=>'require',
		'is_delete'=>'require',
		'is_new'=>'require',
		'is_hot'=>'require',
		'is_sale'=>'require',
		'is_bast'=>'require',
	];

	#错误信息
	protected $message=[
		'goods_name.require'=>'请填写商品名称',
		'goods_price.require'=>'请填写商品价格',
		'goods_price.regex'=>'商品价格不能为负数',
		'goods_number.require'=>'请输入商品库存',
		'goods_number.egt'=>'不能为负库存',
		'cat_id.require'=>'请选择分类',
		'type_id.require'=>'请选择商品分类',
		'is_sale.require'=>'请选择上架情况',
		'is_new.require'=>'请选择是否新品',
		'is_hot.require'=>'请选择是否热卖',
		'is_best'=>'请选择推荐情况',
		'goods_desc'=>'请填写商品详情',
	];

	#验证场景
	protected $scene=[
		'add'=>['goods_name','goods_price','cat_id','type_id','goods_number','is_sale','is_new','is_hot','is_best'],
		
	];
}