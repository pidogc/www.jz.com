<?php
namespace app\admin\controller;
use app\admin\model\Type;
use app\admin\model\Attribute;
class TypeController extends CommonController{

	public function add(){
			if(Request()->isAjax()){
				$typeModel=new Type();
				//接收数据
				$postdata=input('post.');
				//验证器
				$validate=$this->validate($postdata,'Type.add',[]);
				if($validate!==true){
					return json(['code'=>-1,'msg'=>$validate]);
				}
				//操作数据
				if($typeModel->save($postdata)){
					return json(['code'=>200,'msg'=>'添加成功!']);
				}else{
					return json(['code'=>-1,'msg'=>'添加失败!']);
				}
			}
		return $this->fetch();
	}

	public function upd(){
		if(Request()->isAjax()){
				//接收数据
				$postdata=input('post.');
				//验证器
				$validate=$this->validate($postdata,'Type.upd',[]);
				if($validate!==true){
					return json(['code'=>-1,'msg'=>$validate]);
				}
				//操作数据
				if(Type::update($postdata)){
					return json(['code'=>200,'msg'=>'更新成功']);
				}else{
					return json(['code'=>-1,'msg'=>'更新失败']);
					}
				}
		$type_id=input('type_id');
		$data=Type::find($type_id);
		return $this->fetch('',['data'=>$data]);
	}


	public function list(){

		$data=Type::select();
		return $this->fetch('',['data'=>$data]);
	}

	public function del(){
			if(Request()->isAjax()){
					//接收数据
					$type_id=input('type_id');
					
					//验证器
					$validate=$this->validate($postdata,'Type.del',[]);
					if($valiedate){
						return json(['code'=>-1,'msg'=>$validate]);
					}
					//操作数据
					if(Type::destroy($type_id)){
						return json(['code'=>200,'msg'=>'删除成功!']);
					}else{
						return json(['code'=>-1,'msg'=>'删除失败!']);
					}
				}	
	}

	public function attrshow(){
			if(Request()->isGet()){
				$type_id=input('type_id');
				$data=Attribute::where('type_id',$type_id)->select();
				return $this->fetch('',['data'=>$data,'type_id'=>$type_id]);
			}
	}

}