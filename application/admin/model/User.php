<?php
namespace app\admin\model;
use app\admin\model\Auth;
use app\admin\model\Role;
class User extends \think\Model{
	protected $pk = 'user_id';
	protected $autoWriteTimestamp = true;

		#模型事件
		public static function init(){
			//更新数据(密码加密)&(判断是否为希望更改)，前钩子
			User::event('before_update',function($data){
				if($data['password']==''){
					unset($data['password']);
				}else{
					$data['password']=md5($data['password'].config('password_salt'));
					return $data;
				}
			});

			//更新数据加密
			User::event('before_insert',function($data){
		    	$data['password']=md5($data['password'].config('password_salt'));
			});
	}

	#登录检查
	public function checkLogin($postData){
		$data=$this->field('user_id,username,password,role_id')->where('username',$postData['username'])->find();
		
		if($data){
			if($data['password']==md5($postData['password'].config('password_salt'))){
				session('user_id',$data['user_id']);
				session('username',$data['username']);
				//session('role_id',$data['role_id']);
				//调用检查权限函数，获取当前用户的权限信息
				$this->_checkRole($data['role_id']);
				return true;
			}else{
				return false;
			}
		}
	}

	#权限检查
	private function _checkRole($role_id){
		$roleModel=new Role();
		//查询账号角色权限列
		$auth_ids_list=Role::field('auth_ids_list')->find($role_id)->toArray();
		//判断是否是最高权限
		if($auth_ids_list['auth_ids_list']==='*'){//最高权限
			//查出所有权限
			$authAll=Auth::select()->toArray();
			//权限信息存储到session,字符串形式('1,2,3,4,5')
			session('vis',$auth_ids_list['auth_ids_list']);
		}else{//非最高权限
			//根据权限列查询具体权限
			$authAll=Auth::where('auth_id','in',$auth_ids_list['auth_ids_list'])->select()->toArray();
		}
		
		#处理数据
		//奇淫技巧，处理数组
		$auth_list=$roleModel->auth_filter($authAll);
		//分别存入session
		session('auth',$auth_list['auth']);
		session('pid',$auth_list['pid']);
		
		#判断是否已标记最大权限，有则结束
		if(session('vis')){
			return;
		}

		#非最大权限者，给与访问权限限制
		foreach ($authAll as $k => $v) {
			$vis[]=strtolower($v['auth_c'].'/'.$v['auth_a']);
		}
		//存入session
		session('vis',$vis);
	}
}
