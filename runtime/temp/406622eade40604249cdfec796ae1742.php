<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"D:\project\www.shop.com\public/../application/admin\view\order\setlogistics.html";i:1535548544;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="<?php echo config('static_admin'); ?>/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="<?php echo config('static_admin'); ?>/js/jquery.js"></script>
    <script language="JavaScript" src="/plugins/PoPlayer/layer.js"></script>
    <script type="text/javascript" src="<?php echo config('static_admin'); ?>/js/vue.min.js"></script>
    <style>
        .active{
            border-bottom: solid 3px #66c9f3;
        }
    </style>
</head>

<body>
   <!--  <div class="place">
       <span>位置：</span>
       <ul class="placeul">
           <li><a href="#">首页</a></li>
           <li><a href="#">表单</a></li>
       </ul>
   </div> -->
    <div class="formbody">
        <div class="formtitle">
            <span class="active">订单物流分配</span>
           <!--  <span>商品属性信息</span>
           <span>商品相册</span>
           <span>商品描述</span> -->

        </div>
        <form action="" method="post">
            <ul class="forminfo">
               <!--  <li>
                   <label>订单号</label>
                   <input name='order_id' class='dfinput'>
               </li> -->
               <input name='order_id' type='hidden' value='<?php echo $order_id; ?>'>
                <li>
                    <label>物流公司</label>
                    <select name='company' class='dfinput'>
                       <option value=''>请选择物流公司</option>
                       <option value='yuantong'>圆通</option>
                       <option value='shentong'>伸通</option>
                       <option value='3'>信风</option>
                       <option value='4'>天天</option>
                       <option value='5'>顺丰</option>
                       <option value='6'>阿列夫</option>
                    </select>
                </li>
                <li>
                    <label>运单号</label>
                    <input name='number' class='dfinput'>
                </li>
               
         
			       <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="button" class="btn" value="确认保存" />
             </li>
        </form>
    </div>
</body>
<script>
   $('#btnSubmit').click(function(){
        var data=$('form').serialize();
        $.post("<?php echo url('/admin/order/setlogistics'); ?>",data,function(result){
            if(result.code==200){
                window.parent.tips();
                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                parent.layer.close(index);
            }
            layer.msg(result.msg);
        },'json');
   })
</script>

</html>
