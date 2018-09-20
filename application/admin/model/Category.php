<?php
namespace app\admin\model;

class Category extends \think\Model{
	protected $pk = 'cat_id';
	protected $autoWriteTimestamp = true;

		public function Tree($arr,$flag=0){
				foreach ($arr as $k =>$v ) {
					$arr_temp[$v['cat_id']]=$v;
				}
				
				if($flag){
					return $arr_temp;
				}

				foreach ($arr_temp as $k =>$v ) {
					if(isset($arr_temp[$v['pid']])){
						$arr_temp[$v['pid']]['son'][]=&$arr_temp[$v['cat_id']];
					}else{
						$tree[$v['cat_id']]=&$arr_temp[$v['cat_id']];
					}
				}
				return $tree;
		}

		public function getformattree($tree,$l=0){
			$formattree=[];
			foreach ($tree as $k => $v) {
				$formattree[$v['cat_id']]=['cat_id'=>$v['cat_id'],'cat_name'=>str_repeat('--', $l).$v['cat_name']];

				if(isset($v['son'])){
					$temp=$this->getformattree($v['son'],$l+1);
				}

				if(!empty($temp)){
					$formattree=$formattree+$temp;
				}
			}

			return $formattree;
		}

		public function checkdel($cat_id){
			if($this->where('pid',$cat_id)->find()){
				return true;
			}
			return false;
		}
}