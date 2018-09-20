<?php
namespace app\home\model;

class Goods extends \think\Model{
	protected $pk='cat_id';
	protected $autoWriteTimestamp = true;

	public function addHistoryCookie($goods_id){
		/*
			三个要求：
			①最新访问的商品应该放置在浏览历史的第一个位置
			②当访问相同商品的时候，只保留最后访问的商品，即浏览历史需要删除重复的商品。
			③当浏览历史存储量到达最大值（如超过5），应把最先（早）访问的商品id给移除
		 */
		
		#判断是否有浏览记录
		$history=cookie('history')?cookie('history'):[];
		#更新记录
		array_unshift($history, $goods_id);
		#去除相同id
		$history=array_unique($history);
		#限制存储记录数5个
		if(count($history)>5){
			array_pop($history);
		}
		#存入cookie
		cookie('history',$history,60*60*24*7);

		return $history;
	}
}