<?php
namespace app\admin\model;
use app\admin\model\goods_attr;
class Goods extends \think\Model{

	protected $pk='goods_id';
	protected $autoWriteTimestamp = true;

	public static function init(){
		#前钩子,生成唯一商品货号
		Goods::event('before_insert',function($data){
			$data['goods_sn']=date('YmdHis').time().uniqid();
		});

		#后钩子，获取商品id goods_id,然后上传goods_attr表的数据
		Goods::event('after_insert',function($data){
			$goods_attrModel=new goods_attr();
			$goods_id=$data['goods_id'];
			$postdata=input('post.');
			//halt($postdata);

			//取得goods_value的属性值
			$attr_values=$postdata['attr_value'];
			//取得goods_price的属性值
			$attr_price=$postdata['attr_price'];
			$list=[];
			foreach ($attr_values as $attr_id => $attr_value) {
				if(is_array($attr_value)){
					foreach($attr_value as $k => $v) {
						$list[]=[
							'goods_id'=>$goods_id,
							'attr_id'=>$attr_id,
							'attr_value'=>$v,
							'attr_price'=>$attr_price[$attr_id][$k],
						];												
					}
				}else{
					$list[]=[
						'goods_id'=>$goods_id,
						'attr_id'=>$attr_id,
						'attr_value'=>$attr_value,
					];						
			}					
		}
		$goods_attrModel->saveAll($list);
	});
}
	//上传原图
	public function getPath($files,$color){
		
		$path=[];
		$validate=[
			'size'=>1024*1024*3,
			'ext'=>'jpg,gif,png,jpeg,bmt',
		];
		foreach ($files as $k => $file) {
				
			$img_path=$file->validate($validate)->move('./uploads/');
			if($img_path){
				$path[$color[$k]][]=str_replace('\\', '/', $img_path->getSaveName());
			}
		}
			halt($path);
		return $path;
	}

	//处理缩略图
	public function getThumb($img_path){
		$thumb_path=[];
		$middle_path=[];
		foreach ($img_path as $k => $v) {
			$img= \think\Image::open('./uploads/'.$v);
			//0232313 / 12313232.jpg
			$arr=explode('/', $v);
			//缩略图路径
			$mp=$arr[0].'/'.'middle_'.$arr[1];
			$tp=$arr[0].'/'.'thumb_'.$arr[1];
			//缩略
			$img->thumb(350,350,2)->save('./uploads/'.$mp);
			$img->thumb(50,50,2)->save('./uploads/'.$tp);
			//存储路径
			$middle_path[]=$mp;
			$thumb_path[]=$tp;
		}

		return ['middle'=>$middle_path,'thumb'=>$thumb_path];
	}

	//获取首页不同类型的展示(热卖，推荐等)
	public function getTypeGoods($type,$num){
		if($type=='creaz'){
			$where=[
				'is_delete'=>0,
				'is_sale'=>1,
			];

			return  $this->field('goods_id,goods_price,goods_middle,cat_id,goods_name')->where($where)->order('goods_price asc')->limit($num)->select()->toArray();		
		}
			$where=[
				'is_delete'=>0,
				'is_sale'=>1,
				$type=>1,
			];
		
			return $this->field('goods_id,goods_price,goods_middle,cat_id,goods_name')->where($where)->order('goods_price asc')->limit($num)->select()->toArray();

	}
}