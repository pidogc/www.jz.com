<?php
namespace app\admin\controller;
use app\admin\model\Auth;
class AuthController extends CommonController{

	#权限添加
	public function add(){
		$authModel=new Auth();
		if(Request()->isAjax()){
			$postData=input('post.');
			//halt($postData);
			#验证器
			$validate=$this->validate($postData,'Auth.add',[]);
			if($validate!==true){
				return json(['code'=>-1,'msg'=>$validate]);
			}
			
			if($authModel->save($postData)){
				$data=$authModel->field('a.*,a2.auth_name as pid_name')->alias('a')->join('sh_auth a2','a.pid=a2.auth_id','left')->select()->toArray();
				$tree=$authModel->formatTree($authModel->Tree($data));
				return json(['code'=>200,'msg'=>'添加成功!','data'=>$tree]);
			}else{
				return json(['code'=>-1,'msg'=>'添加失败!']);
			}
		}

		$data=$authModel->field('a.*,a2.auth_name as pid_name')->alias('a')->join('sh_auth a2','a.pid=a2.auth_id','left')->select()->toArray();
		$tree=$authModel->formatTree($authModel->Tree($data));
		//halt($tree);
		return $this->fetch('',['data'=>$tree]);
	}

	#权限列表
	public function list(){
		$authModel=new Auth();

		$data=$authModel->field('a.*,a2.auth_name as pid_name')->alias('a')->join('sh_auth a2','a.pid=a2.auth_id','left')->select()->toArray();
		$tree=$authModel->formatTree($authModel->Tree($data));
		//halt($tree);
		return $this->fetch('',['data'=>$tree]);
	}

	#权限更改
	public function upd(){
		$authModel=new Auth();
		if(Request()->isAjax()){
			$postData=input('post.');

			#验证器
			$validate=$this->validate($postData,'Auth.upd',[]);
			if($validate!==true){
				return json(['code'=>-1,'msg'=>$validate]);
			}

			#跟新数据
			if($authModel->allowField(true)->isUpdate(true)->save($postData)){
				$data=$authModel->field('a.*,a2.auth_name as pid_name')->alias('a')->join('sh_auth a2','a.pid=a2.auth_id','left')->select()->toArray();
				$Tree=$authModel->formatTree($authModel->Tree($data));
				return json(['code'=>200,'msg'=>'更新成功!','data'=>$Tree]);
			}else{
				return json(['code'=>-1,'msg'=>'更新失败!']);
			}
		}


		$auth_id=input('auth_id');
		
		$data=$authModel->field('a.*,a2.auth_name as pid_name')->alias('a')->join('sh_auth a2','a.pid=a2.auth_id','left')->select()->toArray();
		$Tree=$authModel->formatTree($authModel->Tree($data));
		//halt($Tree);
		return $this->fetch('',['data'=>$Tree[$auth_id],'Tree'=>$Tree]);
	}

	#权限删除
	public function del(){
		if(Request()->isAjax()){
			$auth_id=input('auth_id');
			$authModel=new Auth();
			//判断改权限下,有没有子权限
			if($authModel->checkDel($auth_id)){
				return json(['code'=>-1,'msg'=>'该权限下还有子权限,请确认删除子权限后再删除!']);
			}
			//删除权限
			if(Auth::destroy($auth_id)){
				return json(['code'=>200,'msg'=>'删除成功!']);
			}else{
				return json(['code'=>-1,'msg'=>'删除失败!']);
			}
		}
	}
}