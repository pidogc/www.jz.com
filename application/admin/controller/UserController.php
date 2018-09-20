<?php
namespace app\admin\controller;
use app\admin\model\User;
use app\admin\model\Role;
class UserController extends CommonController{

	#用户添加
	public function add(){
		$userModel=new User();
		if(Request()->isAjax()){
			$postData=input('post.');
			
			#验证器,验证数据
			$validate=$this->validate($postData,'User.add',[]);
			if($validate!==true){
				return json(['code'=>-1,'msg'=>$validate]);
			}

			#插入数据
			if($userModel->allowField(true)->save($postData)){
				return json(['code'=>200,'msg'=>'添加成功!']);
			}else{
				return json(['code'=>-2,'msg'=>'添加失败!']);
			}

		}

		$data=Role::field('role_id,role_name')->select();
		return $this->fetch('',['data'=>$data]);
	}

	#编辑用户
	public function upd(){
		$userModel=new User();
		$user_id=input('user_id');

		if(Request()->isAjax()){
			$postData=input('post.');

			#密码框和确认密码框只要有值，就进入验证器判断
			if($postData['password']!=''||$postData['repassword']!=''){
				$validate=$this->validate($postData,'user.upd',[]);
				if($validate!==true){
					return json(['code'=>-1,'msg'=>$validate]);
				}
			}

			#跟新数据
			if($userModel->allowField(true)->isUpdate(true)->save($postData)){
				return json(['code'=>200,'msg'=>'跟新成功!']);
			}else{
				return json(['code'=>-1,'msg'=>'跟新失败!']);
			}

		}

		$data=$userModel->field('user_id,username,role_id')->find($user_id);
		$role_data=Role::field('role_id,role_name')->select();
		return $this->fetch('',['data'=>$data,'role'=>$role_data]);
	}

	#用户列表
	public function list(){
		$userModel=new User();
		$data=$userModel->field('u.*,r.role_name as role')->alias('u')->join('role r','u.role_id=r.role_id','left')->paginate(10);
		$page=$data->render();
		//halt($data);
		return $this->fetch('',['data'=>$data,'page'=>$page]);
	}

	#删除用户
	public function del(){
		if(Request()->isAjax()){
			$user_id=input('user_id');
			if(User::destroy($user_id)){
				return json(['code'=>200,'msg'=>'删除成功!']);
			}else{
				return json(['code'=>-1,'msg'=>'删除失败!']);
			}
		}
	}
}