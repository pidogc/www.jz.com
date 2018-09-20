<?php
use \think\Db;
class kaoshi extends \think\Controller{

	public function getOrderbyName(){
		if(Request()->isAjax()){
			$key=input('key');
			Db::query("select o.order_id,user_id,GROUP_CONCAT(goods_name) as goods_name,sum(g.goods_num) as order_num,create_time from `order` as o left JOIN `user` as u on o.user_id=u.id LEFT JOIN goods as g on g.order_id = o.order_id where username like '%{$key}%'");

		}
	}

	public function getOrderbyTime(){
		if(Request()->isAjax()){
			$startTime=strtotime(input('startTime'));
			$endTime=strtotime(input('endTime'));
			Db::query("select o.order_id,user_id,GROUP_CONCAT(goods_name) as goods_name,sum(g.goods_num) as order_num,create_time from `order` as o left JOIN `user` as u on o.user_id=u.id LEFT JOIN goods as g on g.order_id = o.order_id where o.create_time >= {$startTime} and o.create_time <= {$endTime}");
		}
	}
}