<?php
namespace app\admin\controller;
use app\admin\model\Attribute;
use app\admin\model\Type;
class AttributeController extends CommonController{

	public function add(){
			$attrModel=new Attribute();
			if(Request()->isAjax()){
				//接收数据
				$postdata=input('post.');
				#调试
				//halt($postdata);
				
				//验证器
				$validate=$this->validate($postdata,'Attribute.add',[]);
				if($validate !== true){
					return json(['code'=>-1,'msg'=>$validate]);
				}
				//操作数据
				if($attrModel->save($postdata)){
					return json(['code'=>200,'msg'=>'添加成功!']);
				}else{
					return json(['code'=>-1,'msg'=>'添加失败!']);
				}
			}

			if(Request()->isGet()){
				$type_id=input('type_id');
				$data=Type::field('type_id,type_name')->select();
				return $this->fetch('',['data'=>$data,'type_id'=>$type_id]);
			}
		$data=Type::field('type_id,type_name')->select();
		return $this->fetch('',['data'=>$data]);
	}

	public function list(){

		$data=Attribute::field('a.*,b.type_name')->alias('a')->join('sh_type b','a.type_id = b.type_id','left')->select()->toArray();
		//halt($data);
		return $this->fetch('',['data'=>$data]);
	}

	public function upd(){
			if(Request()->isAjax()){
				//接收数据
				$postdata=input('post.');
				//验证器
				$validate=$this->validate($postdata,'Attribute.upd',[]);
				if($validate!==true){
					return json(['code'=>-1,'msg'=>$validate]);
				}
				//操作数据
				if(Attribute::update($postdata)){
					return json(['code'=>200,'msg'=>'更新成功']);
				}else{
					return json(['code'=>-1,'msg'=>'更新失败']);
				}
			}
		$attr_id=input('attr_id');
		$attr_data=Attribute::find($attr_id)->toArray();
		$data=Type::select();
		return $this->fetch('',['data'=>$data,'attr_data'=>$attr_data]);	
	}

	public function del(){
			if(Request()->isAjax()){
				//接收数据
				$attr_id=input('attr_id');
				//验证器
				$validate=$this->validate(['attr_id'=>$attr_id],'Attribute.del',[]);
				if($validate!==true){
					return json(['code'=>-1,'msg'=>$validate]);
				}
				//操作数据
				if(Attribute::destroy($attr_id)){
					return json(['code'=>200,'msg'=>'删除成功']);
				}else{
					return json(['code'=>-1,'msg'=>'删除失败']);
				}
			}
	}
	
}