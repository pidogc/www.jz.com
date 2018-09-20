<?php
namespace app\home\controller;
use app\home\model\Category;
use app\home\model\Goods;
class CategoryController extends \think\Controller{

	public function list(){
		$catModel=new Category();
		$goodsModel=new Goods();
		//---接收cat_id
		$cat_id=input('cat_id');
		//分类原始数据
		$cat_data=Category::select()->toArray();
		/*---------------------导航模块----------------------*/
		$nav_data=Category::field('cat_id,cat_name')->where(['pid'=>0,'is_show'=>1])->select();
		/*---------------------侧边三级导航模块----------------------*/
		$leftnav_data=Category::select()->toArray();
		foreach ($leftnav_data as $k => $v) {
			$cats[$v['cat_id']]=$v;
		}
		foreach ($leftnav_data as $k => $v) {
			$pid[$v['pid']][]=$v['cat_id'];
		}
		/*------------------面包屑导航栏------------------*/
		//处理成子类书
		$parent_tree=$catModel->getTree($cat_data);
		//子类树
		$parent=$catModel->getformatTree([$parent_tree[$cat_id]]);
		/*------------------左侧分类列表-------------------*/
		$l_nav_children=$catModel->getTreeO($cat_data,true);
		foreach ($cat_data as $k => $v) {
			$l_nav_pid[$v['pid']][]=$v['cat_id'];
		}
		/*-----------------商品列表-------------------------*/
		#获取其cat_id和子类cat_id
		$goods_tree=$catModel->getTreeO($cat_data);
		$goods=$catModel->getformatTreeO([$goods_tree[$cat_id]]);
		foreach ($goods as $v) {
			$cat_ids[]=$v['cat_id'];
		}
		$goods_data=$goodsModel->field('goods_id,goods_middle,goods_price,goods_name')->where('cat_id','in',$cat_ids)->select()->toArray();
		/*-----------------------回显浏览记录-------------------*/
		$history=cookie('history');
		$history_str=implode(',', $history);
		$history_data=$goodsModel->field('goods_id,goods_name,goods_price,goods_middle')->where('goods_id','in',$history)->order("field(goods_id,{$history_str})")->select()->toArray();

		return $this->fetch('',['parent_data'=>$parent,'l_nav_children'=>$l_nav_children,'l_nav_pid'=>$l_nav_pid,'goods_data'=>$goods_data,'nav'=>$nav_data,'cats'=>$cats,'pid'=>$pid,'history_data'=>$history_data]);
	}
}