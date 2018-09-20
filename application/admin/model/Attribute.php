<?php
namespace app\admin\model;

class Attribute extends \think\Model{
	protected $pk='attr_id';
	protected $autoWriteTimestamp = true;

	public static function init(){

		#前钩子,编辑时如勾选手工输入，则把列表属性值清空
		Attribute::event('before_update',function($data){
			if($data['attr_input_type']=='0'){
				$data['attr_values']='';
			}
		});
	}
}