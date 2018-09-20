<?php
namespace app\home\controller;

class CartController extends \think\Controller{
	
	#商品页加入购物车功能
	public function addgoodscart(){
		if(Request()->isAjax()){
			#判断是否有登录
			if(!session('member_id')){
				return json(['code'=>-1,'msg'=>'请先登录']);
			}
			#接收参数
			$goods_id=input('goods_id');
			$goods_attr_ids=input('goods_attr_ids');
			$goods_num=input('goods_num');
			#创建cart类
			$cart=new \cart\cart;
			//调用cart类方法addgoods添加数据
			$result=$cart->addgoods($goods_id,$goods_attr_ids,$goods_num);
			#返回信息
			if($result){
				return json(['code'=>200,'msg'=>'已添加到购物车']);
			}else{
				return json(['code'=>-1,'msg'=>'添加失败，请呼叫斯巴达支援!']);
			}
		}
	}

	#购物车清单页面
	public function list(){
		#判断用户登录情况
		if(!session('member_id')){
			$this->error('请先登录！',url('/home/public/login'));
		}
		#处理数据
		$cart=new \cart\cart;
		$data=$cart->getCart();
		//halt($data);
		return $this->fetch('',['carts'=>$data]);
	}

	#清除购物车(单项)
	public function delgoodscart(){
		if(Request()->isAjax()){
			#获取参数
			$goods_id=input('goods_id');
			$goods_attr_ids=input('goods_attr_ids');
			$member_id=session('member_id');
			#调用cart类，delgoodsarct方法
			$cart=new \cart\cart();
			$result=$cart->delcartgoods($goods_id,$goods_attr_ids,$member_id);
			//halt($result);
			if($result){
				return json(['code'=>200,'msg'=>'删除成功']);
			}else{
				return json(['code'=>-1,'msg'=>'删除失败']);
			}
		}
	}

	#清除购物车(清空)
	public function clear(){
		if(Request()->isAjax()){
			$cart=new \cart\cart();
			$re=$cart->clear();
			if($re){
				return json(['code'=>200,'msg'=>'清空成功']);
			}else{
				return json(['code'=>-1,'msg'=>'清空失败']);
			}
		}
	}

	#数量文本框改变同步数据库更新
	public function change(){
		if(Request()->isAjax()){
			#获取参数
			$goods_id=input('goods_id');
			$goods_attr_ids=input('goods_attr_ids');
			$goods_number=input('goods_number');
			#调用cart类，change方法
			$cart=new \cart\cart();
			$re=$cart->change($goods_id,$goods_attr_ids,$goods_number);
			if($re){
				return json(['code'=>200]);
			}else{
				return json(['code'=>-1,'msg'=>'增加失败']);
			}
		}
	}
}