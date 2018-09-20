<?php
namespace app\admin\validate;

class Role extends \think\validate{

	#rule
	protected $rule=[
		'role_name'=>'require|unique:role',
		'role_id'=>'require',
	];

	#message
	protected $message=[
		'role_name.require'=>'请填写角色名称!',
		'role_name.unique'=>'角色名已存在,请重新填写!',
		'role_id.require'=>'id上传有误',
	];

	#scene
	protected $scene=[
		'add'=>['role_name'],
		'upd'=>['role_name'],
		'del'=>['role_id'],
	];

}