<?php
namespace app\admin\controller;
use app\admin\model\Goods;
use app\admin\model\Category;
use app\admin\model\Type;
use app\admin\model\Attribute;

class GoodsController extends CommonController{
	//添加商品
	public function add(){
		$goodsModel=new Goods();
		$catModel=new Category();
		$typeModel=new Type();
		if(Request()->isAjax()){
				//接收数据
				$postdata=input('post.');
				//halt($postdata);
				//验证器
				/*$validate=$this->validate($postdata,'Goods.add',[]);
				if($validate!==true){
					return json(['code'=>-1,'msg'=>$validate]);
				}*/
				//上传图片
				$files=Request()->file();
					foreach ($files as $key => $value) {
						$temp[substr(strchr($key, '_'),1)]=$value;
					}
					foreach ($temp as $key => $value) {
						dump($value);
					}
					halt($temp);
				//判断是否上传了图片
				if($files){
					//获取原图路径
					$img_path=$goodsModel->getPath($files,$postdata['color']);
						//halt($img_path);
					//上传成功后进行缩略,存入路径
					if($img_path){
					//获取缩略图路径
					$thumb_path=$goodsModel->getThumb($img_path);
					$postdata['goods_img']=json_encode($img_path);
					$postdata['goods_middle']=json_encode($thumb_path['middle']);
					$postdata['goods_thumb']=json_encode($thumb_path['thumb']);
					}
				}
				//操作数据
				if($goodsModel->allowfield(true)->save($postdata)){
					return json(['code'=>200,'msg'=>'添加成功']);
				}else{
					return json(['code'=>-1,'msg'=>'添加失败']);
				}
		}
		$cat_data=$catModel->getformattree($catModel->Tree($catModel->select()->toArray()));
		$type_data=$typeModel->select();
		return $this->fetch('',['type_data'=>$type_data,'cat_data'=>$cat_data]);
	}

	//商品列表
	public function list(){
		echo print_r(1+'52p2.8p');
		$goodsModel=new Goods();
		$data=$goodsModel->field('g.goods_id,g.goods_name,g.goods_sn,g.goods_price,g.goods_number,t.type_name,c.cat_name,g.goods_thumb,g.is_delete,g.is_sale,g.is_new,g.is_best,g.is_hot,g.create_time,g.update_time')->alias('g')->join('sh_type t','g.type_id=t.type_id','left')->join('sh_category c','g.cat_id=c.cat_id','left')->select()->toArray();
			//halt($data);
			return $this->fetch('',['data'=>$data]);
	}

	//商品详情页
	public function showcontent(){
		$goods_id=input('goods_id');
		echo Goods::field('goods_desc')->find($goods_id)->goods_desc;
	}
	
	//导表跳转中转页
	public function excel(){
		$data=Goods::field('goods_sn,goods_name,goods_number,goods_price,type_id,cat_id,is_delete,is_sale,is_new,is_hot,is_best,create_time,update_time')->select()->toArray();
		$filename='goods_'.date('YmdHis');
		$title=[1=>'商品货号','商品名称','商品库存','商品价格','类型','商品分类','是否在回收站','上架','新品','热卖','推荐','创建时间','更新时间'];
		//处理数据
		foreach ($data as $key => $value) {
			$temp[$key+1]=$value;
		}
		//调用exec函数导出表格
		$this->exec($title,$temp,$filename);


	}
	/**
	 * $title String 数据列标题
	 * $data  Array  插入的数据
	 * $filename String excel文件名
	 */
	//数据导表
	public function exec($title,$data,$filename){
		#导入excel类
		include "../extend/PHPExcel/Classes/PHPExcel.php";
		include "../extend/PHPExcel/Classes/PHPExcel/IOFactory.php";
	
		//字段名
		$letter=[1=>'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
		//excel对象
		$obj_PHPExcel=new \PHPExcel();
		//创建表对象
		$sheet=$obj_PHPExcel->getActiveSheet();
		//构建列表头
		foreach ($title as $row => $name) {
			$sheet->setCellValue($letter[$row].'1',$name);
		}

	//插入数据
		$l=1;	
	foreach ($data as $row => $value) {
		$r=$row+1;
		foreach ($value as $k => $v) {
			$sheet->setCellValue($letter[$l].$r,$v);
			$l++;
		}
		$l=1;
	}
		//设置输出格式
		$PHPwrite= \PHPExcel_IOFactory::createWriter($obj_PHPExcel,'Excel2007');
		//设置响应头，下载文件
		header('Content-Disposition:attachment;filename='.$filename.'.xlsx');
		header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Cache-Control:max-age=0');

		$PHPwrite->save("php://output");

		
	}
}