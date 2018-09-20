<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\project\www.shop.com\public/../application/admin\view\order\test.html";i:1535876948;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script type="text/javascript" src="<?php echo config('static_admin'); ?>/js/vue.min.js"></script>
	<script type="text/javascript" src="<?php echo config('static_admin'); ?>/js/jquery.js"></script>
</head>
<style type="text/css">
	.form-group{
		margin:5px;
	}
	.table-css{
		width:500px;
		border: 1px solid #ccc;
		border-collapse: collapse;
	}
	td{
		border: 1px solid #ccc;
	}
	th{
		border:1px solid #ccc;
	}
</style>
<body>
	<div id='div'>
		<fieldset>
			<legend>
				 person
			</legend>
			<div class='form-group'>
			 	<label>Name:</label>
			 	<input type='text' v-model="person.name"/>
		 	</div>
		 	<div class='form-group'>
		 		<label>Age:</label>
		 		<input type='text' v-model="person.age"/>
		 	</div>
		 	<div class='form-group'>
		 		<label>Sex:</label>
		 		<select v-model="person.sex">
		 			<option value='Male'>Male</option>
		 			<option value='Female'>Female</option>
		 		</select>
		 	</div>
		 	<div>
		 		<button @click='createPerson' />Create</button
		 	</div>
	 	</fieldset>
		<table class='table-css'>
			<thead>
				<th>Name</th>
				<th>Age</th>
				<th>Sex</th>
				<th>操作</th>
			</thead>
			<tbody>
				<tr v-for='(person,index) in people' >
					<td>{{person.name}}</td>
					<td>{{person.age}}</td>
					<td>{{person.sex}}</td>
					<td><button @click="delPerson(index)">Del</button></td>
				</tr>
			</tbody>
		</table>
		<fieldset>
			<legend>悬停测试</legend>
			<p2 v-bind:title='message'>停</p2>
		</fieldset>
	</div>
</body>
<script type="text/javascript">
	$(document).click(function(e){
		console.log(e);
	});
	//model
	/*var data={
		message:'',
	}*/

	// 创建一个 Vue 实例或 "ViewModel"
    // 它连接 View 与 Model
    // 
	new Vue({
		data:{
			person:{
				age:'',
				name:'',
				sex:'Male',
			},
			people:[
			],
			message:new Date().toLocaleString(),
		},
		'methods':{
			createPerson:function(){
				this.people.push(this.person);
				//重置元素
				this.person={name:'',age:'',sex:'male'};
			},
			delPerson:function(index){
				//移除数组中的对应元素
				console.log(this);
				this.people.splice(index,1);
			}
		}
	}).$mount('#div');
</script>
</html>