<?php
namespace app\admin\validate;

class Auth extends \think\Validate{

	#rule
	protected $rule=[
		'auth_name'=>'require|unique:auth',
		'pid'=>'require',
		'auth_c'=>'re_requireIf',
		'auth_a'=>'re_requireIf',
	];

	#messgae
	protected $message=[
		'auth_name.require'=>'模块名称必填',
		'auth_name.unique'=>'模块名称已被占用',
		'auth_c.re_requireIf'=>'类明必填',
		'auth_a.re_requireIf'=>'方法名必填',
		'pid.require'=>'请选择父类',
	];

	#scene
	protected $scene=[
		'add'=>['auth_name','auth_c','auth_a','pid'],
		'upd'=>['auth_name','auth_c','auth_a','pid'],
	];


	#重写requireIf规则
	protected function re_requireIf($value,$rule,$data){
			if($data['pid']=='0'){
				if($value==null){
					return true;
				}
			}else{
				return $flag=$value==''?false:true;			
			}
		}
}