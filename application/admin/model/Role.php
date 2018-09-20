<?php
namespace app\admin\model;

class Role extends \think\Model{
	protected $pk = 'role_id';
	protected $autoWriteTimestamp = true;

	public function auth_filter($arr){
		foreach ($arr as $k => $v) {
			$arr_temp[$v['auth_id']]=$v;
		}

		foreach ($arr as $k => $v) {
			$arr_temp_pid[$v['pid']][]=$v['auth_id'];
		}

		return ['auth'=>$arr_temp,'pid'=>$arr_temp_pid];
	}

	public static function init(){
		#前钩子,新增前,处理权限
		Role::event('before_insert',function($data){
			$data['auth_ids_list']=implode(',',$data['auth_ids_list']);
		});

		#前钩子,更新前,处理权限
		Role::event('before_update',function($data){
			$data['auth_ids_list']=implode(',',$data['auth_ids_list']);
		});


	}
}