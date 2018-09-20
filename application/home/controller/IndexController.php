<?php
namespace app\home\controller;
use app\admin\model\Category;
use app\admin\model\Goods;
class IndexController extends \think\Controller{
	
	public function index(){
		$goodsModel=new Goods();

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
		/*---------------------推荐栏位-------------------------------*/
		$creaz=$goodsModel->getTypeGoods('creaz',5);
		$new_data=$goodsModel->getTypeGoods('is_new',5);
		$hot_data=$goodsModel->getTypeGoods('is_hot',5);
		$best_data=$goodsModel->getTypeGoods('is_best',5);
		/*---------------------轮播图---------------------------------*/
		$luobo_img=$goodsModel->field('goods_img')->limit(5)->select();
		/*---------------------输出模板-------------------------------*/
		return $this->fetch('',[
			'nav'=>$nav_data,
			'cats'=>$cats,
			'pid'=>$pid,
			'creaz'=>$creaz,
			'new_data'=>$new_data,
			'best_data'=>$best_data,
			'hot_data'=>$hot_data,
			'luobo_img'=>$luobo_img,
			]);	
	}
}