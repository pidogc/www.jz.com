<?php

class kaoshi1 extends \think\Model{
	protected $pk='id';
	protected $createTime='addtime';
	protected $autoWriteTimestamp = true;
	protected $insert = ['roleid' => 1];

	public function test($data){
		//验证器类
		$User = new User;
		$result = $User->validate(
		    [
		        'name'  => 'require|regex:[0-9a-zA-Z_]{6,12}',
		        'password'   => 'require',
		        'repassword'=>'require|confirm:password',
		    ],
		    [
		        'name.require' => '名称必须',
		        'name.regex'   => '必须为6-12位字母数字下划线',
		        'repassword.require'   => '请填写确认密码',
		        'repassword.confirm' =>'请再次确认密码填写',

		    ]
		)->save($data);
		if(false === $result){
		    // 验证失败 输出错误信息
		    dump($User->getError());
		}	
	}

}