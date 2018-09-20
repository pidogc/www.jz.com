<?php
namespace app\home\controller;
use app\home\model\Member;
class PublicController extends \think\Controller{

	#发送短信
	public function sendMsg(){
		if(Request()->isAjax()){
			//设置时区
			date_default_timezone_set('Asia/Chongqing');
			$phone=input('phone');
			//判断表单是否有重复号码
			$data=Member::where('phone',$phone)->find();
			if($data){
				return json(['code'=>-1,'msg'=>'该号码已注册,请重新填写']);
			}
			//发送短信
			$checkNum=mt_rand(1000,9999);
			if(sendTSMS($phone,array($checkNum,1))->statusCode=='000000'){
				cookie('SendMsg',md5($checkNum.$phone.config('sendMsg_salt')),60);
				return json(['code'=>200,'msg'=>'短信已发送，请注意查看，该验证码有效期为1分钟']);
			}else{
				return json(['code'=>-2,'msg'=>'请稍后再试']);
			}
		}
	}

	#注册
	public function register(){
		//短信测试，通过  发送的手机号，array(验证码，有效期以分钟计算)
		//halt(sendTSMS('13610094138',array('1000',1)));
		if(Request()->isAjax()){
			$MemberModel=new Member();
				//接收数据
				$postdata=input('post.');

				//验证器
				$validate=$this->validate($postdata,'Member.register',[]);
				if($validate!==true){
					return json(['code'=>-1,'msg'=>$validate]);
				}

			#验证短信验证码
				//加密获取的验证码和手机号
				$hash=md5($postdata['checkNum'].$postdata['phone'].config('sendMsg_salt'));
				
				//判断验证码是否失效
				if(!cookie('SendMsg')){
					return json(['code'=>-4,'msg'=>'短信验证码已失效,请重新获取']);
				}
				//防止参数被篡改并且判断验证码是否一致
				if($hash!=cookie('SendMsg')){
					return json(['code'=>-3,'msg'=>'参数已被篡改,请检查网络环境防止数据被盗']);
				}

				//操作数据
				if($MemberModel->allowField(true)->save($postdata)){
					cookie('SendMsg',null);
					return json(['code'=>200,'msg'=>'更新成功']);
				}else{
					return json(['code'=>-1,'msg'=>'更新失败']);
					}
				}

		return $this->fetch();
	}

	#登录
	public function login(){
		if(Request()->isAjax()){
				$MemberModel=new Member();
				//接收数据
				$postdata=input('post.');
				//验证器
				$validate=$this->validate($postdata,'Member.login',[]);
				if($validate!==true){
					return json(['code'=>-1,'msg'=>$validate]);
				}
				//检查账号
				if(!$MemberModel->check($postdata)){
					return json(['code'=>1,'msg'=>'账号或密码错误']);
				}
				//跳转
				return json(['code'=>200,'username'=>session('username')]);
			}

		return $this->fetch();
	}

	#发送邮件
	public function gbpwd(){
		if(Request()->isAjax()){
			$MemberModel=new Member();
		
			$postdata=input('post.');
			#验证器
			$validate=$this->validate($postdata,'Member.gbpwd',[]);
			if($validate!==true){
				return json(['code'=>-1,'msg'=>$validate]);
			}
			#根据账号和邮箱判断表是否有联系
			$member_id=$MemberModel->emailCheck($postdata);
			if($member_id!==true){
				return json(['code'=>-2,'msg'=>'账号不存在或该邮箱没有关联此账号']);
			}
			#发送前加密
			$time=time();
			$email=$postdata['email'];
			$adress=[$postdata['email']];
			$hash=md5($member_id.$time.$email.config('sendEmail_salt'));	
			$title='Ori商城找回密码';
			$content="<a href='".Request()->domain()."/index.php/home/public/change/".$member_id.'/'.$hash.'/'.$time.'/'.$email."'>该链接地址5分钟内有效，请注意！链接地址</a>";
			#发送邮箱
			if(sendEmail($adress,$title,$content)){
				if($MemberModel->isUpdate(true)->save(['member_id'=>$member_id,'is_active'=>1])){
					return json(['code'=>200,'msg'=>'发送成功,请注意接收']);
				}else{
					return json(['code'=>-1,'msg'=>'发送失败，该链接失效']);
				}	
			}else{
				return json(['code'=>-1,'msg'=>'发送失败请稍后再试']);
			}		
		}
		return $this->fetch();
	}

	#更改密码
	public function change($member_id,$hash,$time,$email){
		#判断参数是否遭到篡改
		if(md5($member_id.$time.$email.config('sendEmail_salt'))!=$hash){
			$this->error('数据遭到篡改，请检查您的网络环境');
		}
		#判断链接有效期
		if(time()>$time+300){
			$MemberModel->isUpdate(true)->save(['member_id'=>$member_id,'is_active'=>0]);
			$this->error('该链接已超过有效期,请重新发送邮件');
		}
		#判断链接状态
		$is_active=$MemberModel->field('is_active')->find($member_id);
		if($is_active!=1){
			return $this->error('该链接已超过有效期或未激活,请重新发送邮件');
		}
		//update数据
		if(Request()->isPost()){
			$MemberModel=new Member();
				//接收数据
				$postdata=input('post.');
				$postdata['member_id']=$member_id;
				//验证器
				$validate=$this->validate($postdata,'Member.change',[]);
				if($validate!==true){
					return json(['code'=>-1,'msg'=>$validate]);
				}
				//操作数据
				if($MemberModel->allowField(true)->isUpdate(true)->save($postdata)){
					/*return json(['code'=>200,'msg'=>'更新成功']);*/
					$MemberModel->isUpdate(true)->save(['member_id'=>$member_id,'is_active'=>0]);
					$this->success('更改成功，请妥善保存你的密码',url('/home/public/login'));
				}else{
					/*return json(['code'=>-1,'msg'=>'更新失败']);*/
					$this->error('更改失败,请稍后再试!');
				}
		}

		return $this->fetch();
	}
	
	#判断用户名是否存在
	public function checkuser(){
		if(Request()->isAjax()){
			$username=input('username');
			if(Member::where('username',$username)->find()){
				return json(['code'=>200]);
			}
			return json(['code'=>-1]);
		}
	}

	#退出
	public function loginout(){
		session('username',null);
		session('member_id',null);
		$this->success('安全注销成功',url('/home/index/index'));
	}

	#实验弹框登录
	public function login1(){
		
		return $this->fetch();
	}

}