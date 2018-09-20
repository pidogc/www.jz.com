<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"D:\project\www.shop.com\public/../application/admin\view\category\add.html";i:1534840083;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="<?php echo config('static_admin'); ?>/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="<?php echo config('static_admin'); ?>/js/jquery.js"></script>
    <script language="JavaScript" src="/plugins/PoPlayer/layer.js"></script>
    <style>
        .active{
            border-bottom: solid 3px #66c9f3;
        }
    </style>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">表单</a></li>
        </ul>
    </div>
    <div class="formbody">
        <div class="formtitle">
            <span class="active">商品分类信息</span>
           <!--  <span>商品属性信息</span>
           <span>商品相册</span>
           <span>商品描述</span> -->

        </div>
        <form action="" method="post">
            <ul class="forminfo">
                <li>
                    <label>分类名称</label>
                    <input name="cat_name" placeholder="请输入分类名称" type="text" class="dfinput" />
                </li>
                <li>
                    <label>所属父分类</label>
                    <select name='pid' class="dfinput">
                        <option value=''>请选择所属父分类</option>
                        <option value='0'>顶级分类</option>
                      <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                          <option value="<?php echo $v['cat_id']; ?>"><?php echo $v['cat_name']; ?></option>
                      <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </li>
                <li>
                    <label>是否显示在导航栏</label>
                    <label>
                        <input name='is_show' type='radio' value='0' checked="checked">不显示
                    </label>
                    <label>
                        <input name='is_show' type='radio' value='1'>显示
                    </label>
                </li>
			 <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit"  type="button" class="btn" value="确认保存" />
             </li>
        </form>
    </div>
</body>
<script>
    //回车提交
    $(document).keyup(function(e){
        if(e.which==13){
            $('#btnSubmit').click();
        }     
    });

    //点击提交
   $('#btnSubmit').click(function(){
        var data=$('form').serialize();
        $.post("<?php echo url('/admin/category/add'); ?>",data,function(result){
            if(result.code==200){
                layer.msg(result.msg);
                var str="<option value=''>请选择所属父分类</option><option value='0'>顶级权限</option>";
                $.each(result.data,function(i,val){
                    str+="<option value='"+val.cat_id+"'>"+val.cat_name+"</option>";
                });
                $("select[name=pid]").html(str);
                return;
            }
            layer.msg(result.msg);
        },'json');
   });

  
  
</script>

</html>
