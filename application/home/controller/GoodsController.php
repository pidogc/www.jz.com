<?php
namespace app\home\controller;
use app\home\model\Goods;
use app\home\model\Category;
use \think\Db;
class GoodsController extends \think\Controller{

	public function detail(){
	/*---------------------接收参数------------------------*/
		$goodsModel=new Goods();
		$catModel=new Category();
		$goods_id=input('goods_id');
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
	/*---------------------面包屑导航------------------------*/
		$goods_data=Db::query("select g.goods_id,g.goods_name,g.goods_sn,g.goods_price,g.goods_number,g.type_id,g.cat_id,g.goods_img,g.goods_middle,g.goods_thumb,g.goods_desc,g.create_time,ga.*,attr.attr_name,attr.attr_input_type as attr_type from sh_goods as g LEFT JOIN sh_goods_attr as ga on g.goods_id = ga.goods_id  LEFT JOIN sh_attribute as attr on ga.attr_id = attr.attr_id where g.goods_id ={$goods_id} and ga.attr_id = attr.attr_id");
		
		//$goods_data=$goodsModel->where('goods_id',$goods_id)->find()->toArray();
		$cat_data=$catModel->select()->toArray();
		$cat_tree=$catModel->getTree($cat_data);
		$parent=$catModel->getformattree([$cat_tree[$goods_data[0]['cat_id']]]);
	/*--------------------商品详情---------------------------*/
		#图片
		$goods_img['goods_img']=json_decode($goods_data[0]['goods_img']);
		$goods_img['goods_middle']=json_decode($goods_data[0]['goods_middle']);
		$goods_img['goods_thumb']=json_decode($goods_data[0]['goods_thumb']);
		#单选属性
		foreach ($goods_data as $v) {
			if($v['attr_type']==1){
				$oneChose[$v['attr_id']][]=['attr_name'=>$v['attr_name'],'attr_value'=>$v['attr_value'],'attr_id'=>$v['attr_id'],'goods_id'=>$v['goods_id'],'goods_price'=>$v['goods_price'],'type_id'=>$v['type_id'],'goods_attr_id'=>$v['goods_attr_id']];
			}
		}
		#唯一属性
		foreach ($goods_data as $v) {
			if($v['attr_type']==0){
				$onlyChose[$v['attr_id']]=['attr_name'=>$v['attr_name'],'attr_value'=>$v['attr_value'],'attr_id'=>$v['attr_id'],'goods_id'=>$v['goods_id'],'goods_price'=>$v['goods_price'],'type_id'=>$v['type_id'],'goods_attr_id'=>$v['goods_attr_id']];
			}
		}

		/*------------------记录商品浏览记录-------------------*/
		$history=$goodsModel->addHistoryCookie($goods_id);
			//halt(cookie('history'));
		/*-----------------------回显浏览记录-------------------*/
		$history_str=implode(',', $history);
		$history_data=$goodsModel->field('goods_id,goods_name,goods_price,goods_middle')->where('goods_id','in',$history)->order("field(goods_id,{$history_str})")->select()->toArray();	
		/*---------------------模板输出-------------------------*/
		//halt($goods_data);
		return $this->fetch('',[
			'parent'=>$parent,
			'goodsinfo'=>$goods_data[0],
			'goods_img'=>$goods_img,
			'goods_attr'=>$goods_data,
			'oneChose'=>$oneChose,
			'onlyChose'=>$onlyChose,
			'history_data'=>$history_data,
			'nav'=>$nav_data,
			'cats'=>$cats,
			'pid'=>$pid,
			]);	
	}

	#清除浏览记录
	public function clearlookgoods(){
		if(Request()->isAjax()){
			cookie('history',null);
			return json(['code'=>200,'msg'=>'浏览记录已清除']);				
		}
	}
}