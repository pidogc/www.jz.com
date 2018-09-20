<?php
namespace app\admin\controller;
use app\admin\model\Role;
use app\admin\model\Auth;
use \think\Db;
class RoleController extends CommonController{

	public  function add(){
		$roleModel=new Role();

			if(Request()->isAjax()){
				$postData=input('post.');
				//halt($postData);
				#验证器
				$validate=$this->validate($postData,'Role.add',[]);
				if($validate!==true){
					return json(['code'=>-1,'msg'=>$validate]);
				}
				#添加数据
				if($roleModel->save($postData)){
					return json(['code'=>200,'msg'=>'设定成功!']);
				}else{
					return json(['code'=>-1,'msg'=>'设定失败!']);
				}

			}

		$ori_data_auth=Auth::select()->toArray();
		#处理auth表的数据
		$auth_data=$roleModel->auth_filter($ori_data_auth);
		return $this->fetch('',['auth'=>$auth_data['auth'],'pid'=>$auth_data['pid']]);
	}

	public function list(){

		$data=Db::query('select r.*,GROUP_CONCAT(a.auth_name) as auth FROM sh_role as r LEFT JOIN  sh_auth as a on FIND_IN_SET(a.auth_id,r.auth_ids_list) GROUP BY r.role_id');
		return $this->fetch('',['data'=>$data]);
	}

	public function upd(){
		$authModel=new Auth();
		$roleModel=new Role();
		$role_id=input('role_id');

		if(Request()->isAjax()){
			$postData=input('post.');
			
			#验证器
			$validate=$this->validate($postData,'Role.upd',[]);
			if($validate!==true){
				return json(['code'=>-1,'msg'=>$validate]);
			}

			if(Role::update($postData)){
				return json(['code'=>200,'msg'=>'数据更新成功!']);
			}else{
				return json(['code'=>-1,'msg'=>'数据更新失败!']);
			}
		}

		#反显信息
		$role_data=$roleModel->field('role_id,role_name,auth_ids_list')->find($role_id);
		$data=Auth::select()->toArray();
		$auth_data=$roleModel->auth_filter($data);
		return $this->fetch('',['auth'=>$auth_data['auth'],'pid'=>$auth_data['pid'],'role'=>$role_data]);
	}

	public function del(){
		if(Request()->isAjax()){
			$role_id=input('role_id');
			if(Role::destroy($role_id)){
				return json(['code'=>200,'msg'=>'删除成功!']);
			}else{
				return json(['code'=>-1,'msg'=>'删除失败!']);
			}
		}

	}
}