<?php
namespace app\home\model;

class Category extends \think\Model{

	protected $pk='cat_id';
	protected $autoWriteTimestamp = true;


	//正树
	public function getTreeO($arr,$flag=null){
		foreach ($arr as $k => $v) {
				$tree_temp[$v['cat_id']]=$v;
			}

		if($flag){
			return $tree_temp;
		}

		foreach ($tree_temp as  $v) {
			if(isset($tree_temp[$v['pid']])){
				$tree_temp[$v['pid']]['son'][$v['cat_id']]=&$tree_temp[$v['cat_id']];
			}
				$tree[$v['cat_id']]=&$tree_temp[$v['cat_id']];	
		}
		return $tree;
	}

	//正树递归
	public function getformatTreeO($arr){
		$formattree=[];

		foreach ($arr as  $v) {
			$formattree[$v['cat_id']]=['cat_id'=>$v['cat_id'],'cat_name'=>$v['cat_name']];

			if(isset($v['son'])){
				$temp=$this->getformatTreeO($v['son']);
			}

			if(!empty($temp)){
				$formattree=$formattree+$temp;
			}
		}

		return $formattree;
	}

	//异议树
	public function getTree($arr){
			foreach ($arr as $k => $v) {
				$tree_temp[$v['cat_id']]=$v;
			}
			
			foreach ($tree_temp as $k => $v) {
				if(isset($tree_temp[$v['pid']])){//子类进入
					$tree_temp[$v['cat_id']]['parent'][]=&$tree_temp[$v['pid']];
					$tree[$v['cat_id']]=$tree_temp[$v['cat_id']];
				}
			}

			return $tree;
	}

	//递归(异议树专用)
	public function getformatTree($arr){
		$formattree=[];

		foreach ($arr as $k => $v) {
			$formattree[$v['cat_id']]=['cat_id'=>$v['cat_id'],'cat_name'=>$v['cat_name']];

			if(isset($v['parent'])){
				$temp=$this->getformatTree($v['parent']);
			}

			if(!empty($temp)){
				$formattree=$temp+$formattree;
			}
		}

		return $formattree;
	}
}