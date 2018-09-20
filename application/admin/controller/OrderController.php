<?php
namespace app\admin\controller;
use app\admin\model\Order;
class OrderController extends CommonController{

	public function list(){
		$data=Order::field('id,order_id,total_price,receiver,address,pay_status,send_status,create_time,update_time,number,company')->select();
		
		return $this->fetch('',['data'=>$data]);
	}

	#设置物流公司
	public function setlogistics(){
			if(Request()->isAjax()){
					//接收数据
					$postdata=input('post.');
					//halt($postdata);
					//验证器
					$validate=$this->validate($postdata,'Order.setlogistics',[]);

					if($validate!==true){
						return json(['code'=>-1,'msg'=>$validate]);
					}
					//设置发货状态
					$postdata['send_status']=1;
					//操作数据
					if(Order::where('order_id',$postdata['order_id'])->update($postdata)){
						return json(['code'=>200,'msg'=>'更新成功','order_id'=>$postdata['order_id'],'pay_status'=>1]);
					}else{
						return json(['code'=>-1,'msg'=>'更新失败']);
					}

	    	}

		$order_id=input('order_id');
		return $this->fetch('',['order_id'=>$order_id]);
	}

	#查看物流状态
	public function looklogistics(){
		$key="9d37bc6b0a41e6fe";
		$com=input('com');//公司名称
		$nu=input('nu');//运单号
		$url="http://www.kuaidi100.com/applyurl?key={$key}&com={$com}&nu={$nu}&show=0";
		echo  file_get_contents($url);
	}

	#vue测试
	public function test(){
		return $this->fetch();
	}
}