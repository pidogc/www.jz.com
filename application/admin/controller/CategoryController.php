<?php
namespace app\admin\controller;
use app\admin\model\Category;
class CategoryController extends CommonController{

	public function add(){
		$catModel=new Category();
		if(Request()->isAjax()){
				//接收数据
				$postdata=input('post.');
				//halt($postdata);
				//验证器
				$validate=$this->validate($postdata,'Category.add',[]);
				if($validate!==true){
					return json(['code'=>-1,'msg'=>$validate]);
				}
				//操作数据
				if($catModel->save($postdata)){
					$tree=$catModel->Tree($catModel->field('cat_id,cat_name,pid')->select()->toArray());
					$data=$catModel->getformattree($tree);
					return json(['code'=>200,'msg'=>'添加成功','data'=>$data]);
				}else{
					return json(['code'=>-1,'msg'=>'添加失败']);
					}
				}	
		
		$tree=$catModel->Tree($catModel->field('cat_id,cat_name,pid')->select()->toArray());
		$data=$catModel->getformattree($tree);
		
		return $this->fetch('',['data'=>$data]);	
	}

	public function list(){
		$catModel=new Category();
		$data=$catModel->Tree($catModel->select(),true);
		return $this->fetch('',['data'=>$data]);
	}

	public function upd(){
		$catModel=new Category();
		if(Request()->isAjax()){
				//接收数据
				$postdata=input('post.');
				//验证器
				$validate=$this->validate($postdata,'Category.upd',[]);
				if($validate!==true){
					return json(['code'=>-1,'msg'=>$validate]);
				}
				//操作数据
				if(Category::update($postdata)){
					$tree=$catModel->Tree($catModel->field('cat_id,cat_name,pid')->select()->toArray());
					$data=$catModel->getformattree($tree);
					return json(['code'=>200,'msg'=>'更新成功','data'=>$data]);
				}else{
					return json(['code'=>-1,'msg'=>'更新失败']);
					}
				}
		$cat_id=input('cat_id');
		$tree=$catModel->Tree($catModel->field('cat_id,cat_name,pid')->select()->toArray());
		$data=$catModel->getformattree($tree);
		$cat_data=$catModel->find($cat_id);
		return $this->fetch('',['cat_data'=>$cat_data,'data'=>$data]);	
	}

	public function del(){
		$catModel=new Category();
		if(Request()->isAjax()){
				//接收数据
				$cat_id=input('cat_id');
				//halt($cat_id);
				//验证器
				$validate=$this->validate(['cat_id'=>$cat_id],'Category.del',[]);
				if($validate!==true){
					return json(['code'=>-1,'msg'=>$validate]);
				}

				if($catModel->checkdel($cat_id)){
					return json(['code'=>-1,'msg'=>'该分类下有子分类，不能删除']);
				}

				//操作数据
				if(Category::destroy($cat_id)){
					return json(['code'=>200,'msg'=>'删除成功']);
				}else{
					return json(['code'=>-1,'msg'=>'删除失败']);
					}
				}
	}

	//关闭弹框后无刷新回显
	public function callback(){
		if(Request()->isAjax()){
			$cat_id=input('cat_id');
			$cat_data=Category::field('t1.*,t2.cat_name as pid_name')->alias('t1')->join('sh_category t2','t1.pid=t2.cat_id','left')->find($cat_id);
			$content="<input name='cat_id' type='hidden' value='".$cat_data['cat_id']."'><td><input name='' type='checkbox' value='' /></td><td>".$cat_data['cat_id']."</td><td>".$cat_data['cat_name']."</td><td>".$cat_data['pid_name']."</td><td>".config('is_show')[$cat_data['is_show']]."</td><td>".$cat_data['create_time']."</td><td>".$cat_data['update_time']."</td><td><a href='javascript:;' class='tablelink' onclick='showupd(this)'>查看</a> <a href='javascript:;'  class='tablelink'> 删除</a></td>";
			return json(['re_data'=>$cat_data,'content'=>$content]);
		}
	}
	
}