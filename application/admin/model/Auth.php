<?php
namespace app\admin\model;

class Auth extends \think\Model{
	protected $pk = 'auth_id';
	protected $autoWriteTimestamp = true;

	public function Tree($data){
		foreach ($data as $k => $v) {
			$arr_trmp[$v['auth_id']]=$v;
		}
		
		foreach ($arr_trmp as $k => $v) {
			if(isset($arr_trmp[$v['pid']])){
				$arr_trmp[$v['pid']]['son'][]=&$arr_trmp[$v['auth_id']];
			}else{
				$tree[$v['auth_id']]=&$arr_trmp[$v['auth_id']];
			}
		}
		return $tree;
	}

	public function formatTree($arr,$l=0){
		$formatTree=[];
		foreach ($arr as $k => $v) {
			$v['auth_name']=str_repeat('--',$l).$v['auth_name'];
			$formatTree[$v['auth_id']]=['auth_id'=>$v['auth_id'],'auth_name'=>$v['auth_name'],'pid_name'=>$v['pid_name'],'auth_c'=>$v['auth_c'],'auth_a'=>$v['auth_a'],'create_time'=>$v['create_time'],'update_time'=>$v['update_time'],'pid'=>$v['pid']];
			if(isset($v['son'])){
				$formatTree_temp=$this->formatTree($v['son'],$l+1);
			}

			if(!empty($formatTree_temp)){
				$formatTree=$formatTree+$formatTree_temp;
			}
		}

		return $formatTree;
	}

	public static function init(){
		#当选择顶级时去除auth_a,auth_c 的值
		Auth::event('before_update',function($data){
			if($data['pid']=='0'){
				$data['auth_a']='';
				$data['auth_c']='';
			}
		});
	}

	public function checkDel($auth_id){
		if($this->where('pid',$auth_id)->find($auth_id)){
			return true;
		}
	}
}