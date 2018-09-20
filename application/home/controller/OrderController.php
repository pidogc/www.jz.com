<?php
namespace app\home\controller;
use app\home\model\Order;
use \think\Db;
class OrderController extends \think\Controller{

	#显示订单页面
	public function orderlist(){
		#判断是否有登录
		if(!session('member_id')){
			$this->error('请先登录',url('/home/public/login'));
		}
		#获取购物车信息
		$cart=new \cart\cart();
		$cartdata=$cart->getCart();
		#判断购物车是否为空
		if(!$cartdata){
			$this->error('请先选购商品再来吧！',url('/home/index/index'));
		}
		#购物车信息反显
		//halt($cartdata);
		return $this->fetch('',['cartdata'=>$cartdata]);
	}

	#个人订单页
	public function selforder(){
		//确认登录
		if(!session('member_id')){
			$this->error('请先登录',url('/home/public/login'));
		}

		//$time=date('Y-m-d',time()-60*60*24*30*3);
		
		$order_data=Db::name('order_goods')->field('og.order_id,o.id,receiver,total_price,o.create_time,pay_status,goods_middle')->alias('og')->join('sh_order o','og.order_id=o.order_id','left')->join('sh_goods g','og.goods_id=g.goods_id','left')->select();
		//未付款计算
		$order_num=0;
		foreach ($order_data as $v) {
			if($v['pay_status']==0){
				$order_num++;
			}		
		}

		return $this->fetch('',['order_data'=>$order_data,'order_num'=>$order_num]);
	}

	#个人订单付款
	public function selfpay(){
		$id=input('id');
		$order=Order::find($id);

		//唤起支付宝
		$this->callAlipay($order['order_id'],'曾日东的龙',$order['total_price']);
	}

	#订单页面提交后进行数据入库行为
	public function orderPay(){
		#获取用户id
		$member_id=session('member_id');
		#确认登录行为
		if(!$member_id){
			$this->error('请先登录',url('/home/pubic/login'));
		}
		#购物车为空，跳回首页
		$cart=new \cart\cart();
		$cartdata=$cart->getCart();
		if(!$cartdata){
			$this->redirect(url('/'));
		}
		///halt($cartdata);
		#验证器
		$postdata=input('post.');
		$validate=$this->validate($postdata,'Order.submitorder',[]);
		if($validate!==true){
			$this->error($validate);
		}
		//开启事务
		Db::startTrans();
		try{
			#订单入库
			//halt($cartdata);
			$total=0;
			foreach ($cartdata as $k => $v) {
				$total+=($v['goodsInfo']['goods_price']+$v['attr']['attrTotalPrice'])*$v['goods_number'];
			}
			$postdata['total_price']=$total;
			$postdata['order_id']=$order_id=date('TmdHis').time().uniqid();
			$postdata['member_id']=$member_id;
			//入库订单表
			$re=Order::create($postdata);
			if(!$re){
				throw new Exception("订单创建失败");		
			}
			//入库订单商品表
			foreach ($cartdata as $v) {
				//入库订单商品表
				$order_goods_re=Db::name('order_goods')->insert([
						'order_id'=>$order_id,
						'goods_id'=>$v['goods_id'],
						'goods_attr_ids'=>$v['goods_attr_ids'],
						'goods_number'=>$v['goods_number'],
						'goods_price'=>($v['goodsInfo']['goods_price']+$v['attr']['attrTotalPrice'])*$v['goods_number'],
					]);
				//商品表对应商品减去库存
				$where=[
					'goods_id'=>$v['goods_id'],
					//库存数必须大于等于商品售卖数
					'goods_number'=>['>=',$v['goods_number']],
				];
				//更新数据表
				$goods_re=Db::name('goods')->where($where)->setDec('goods_number',$v['goods_number']);
				//判断订单商品表和商品表库存是否都更新成功
				if(!$order_goods_re || !$goods_re){
					throw new Exception("商品库存不足，或数据更新错误");
					
				}
			}
				//若都成功，则提交
				Db::commit();
		}catch(\Exception $e){
			Db::rollback();
			$this->error($e->getMessage());
		}

		#清除购物车
		$cart->clear();
		#唤起支付宝
		$this->callAlipay($order_id,'订单名称',$total);
	}

	#把alipay支付页面所需参数带去
	public function callAlipay($order_id,$subject,$total,$body=''){
	echo <<<eof
			<form id='form' action='/home/order/paymoneny' method='post'>
				<input type='hidden' name='WIDout_trade_no' value="{$order_id}">
				<input type='hidden' name='WIDsubject' value="{$subject}">
				<input type='hidden' name='WIDtotal_amount' value="{$total}">
				<input type='hidden' name='WIDbody' value="{$body}">
			</form>
			<script>
				document.getElementById('form').submit();
			</script>
eof;
	}

	#支付页面
	public function paymoneny(){
		//引入alipay接口自带支付页面
		include '../extend/alipay/pagepay/pagepay.php';
	}

	#支付宝回调函数
	public function paycomplete(){

		require_once "../extend/alipay/config.php";
		require_once '../extend/alipay/pagepay/service/AlipayTradeService.php';

		//接收返回参数
		$alipay_data=input('get.');

		$alipaySevice = new \AlipayTradeService($config); 
		$result = $alipaySevice->check($alipay_data);
		if($result) {//验证成功
			//商户订单号
			$out_trade_no = htmlspecialchars($alipay_data['out_trade_no']);
			//支付宝交易号
			$trade_no = htmlspecialchars($alipay_data['trade_no']);	

			//构筑更新参数
			$update=[
				'pay_status'=>1,
				'ali_order_id'=>$trade_no,
			];
			//更新数据
			$order_update_re=Order::where('order_id',$out_trade_no)->update($update);
			
			//判断是否入库成功
			if(!$order_update_re){
				echo '出错';
			}
			return $this->fetch();
		}else {
		    //验证失败
		   echo '出错';
		}
	}

}