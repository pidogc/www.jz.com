<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"D:\project\www.shop.com\public/../application/admin\view\category\list.html";i:1534922285;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="<?php echo config('static_admin'); ?>/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo config('static_admin'); ?>/css/page.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo config('static_admin'); ?>/js/jquery.js"></script>
    <script language="JavaScript" src="/plugins/PoPlayer/layer.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(".click").click(function() {
            $(".tip").fadeIn(200);
        });

        $(".tiptop a").click(function() {
            $(".tip").fadeOut(200);
        });

        $(".sure").click(function() {
            $(".tip").fadeOut(100);
        });

        $(".cancel").click(function() {
            $(".tip").fadeOut(100);
        });

    });
    </script>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">数据表</a></li>
            <li><a href="#">基本内容</a></li>
        </ul>
    </div>
    <div class="rightinfo">
        <div class="tools">
            <ul class="toolbar">
                <li><span><img src="<?php echo config('static_admin'); ?>/images/t01.png" /></span>添加</li>
                <li><span><img src="<?php echo config('static_admin'); ?>/images/t02.png" /></span>修改</li>
                <li><span><img src="<?php echo config('static_admin'); ?>/images/t03.png" /></span>删除</li>
                <li><span><img src="<?php echo config('static_admin'); ?>/images/t04.png" /></span>统计</li>
            </ul>
        </div>
        <table class="tablelist">
            <thead>
                <tr>
                    <th>
                        <input name="" type="checkbox" value="" id="checkAll" />
                    </th>
                    <th>编号</th>
                    <th>分类名称</th>
                    <th>所属父类型</th>
                    <th>导航栏显示</th>
                    <th>发布时间</th>
                    <th>更新时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <tr>
                    <input name='cat_id' type='hidden' value="<?php echo $v['cat_id']; ?>">
                    <td>
                        <input name="" type="checkbox" value="" />
                    </td>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo $v['cat_name']; ?></td>
                    <td><?php echo $data[$v['pid']]['cat_name']; ?></td>
                    <td><?php echo config('is_show')[$v['is_show']]; ?></td>
                    <td><?php echo $v['create_time']; ?></td>
                    <td><?php echo $v['update_time']; ?></td>
                    <td>
                        <a href="javascript:;" class="tablelink" onclick="showupd(this)">查看</a> <a href="javascript:;"  class="tablelink"> 删除</a>
                    </td>
                </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div class="pagination">
            <div class="message">共<i class="blue"><?php echo count($data); ?></i>条记录，当前显示第&nbsp;<i class="blue">2&nbsp;</i>页</div>
            
        </div>
        <div class="tip">
            <div class="tiptop"><span>提示信息</span>
                <a></a>
            </div>
            <div class="tipinfo">
                <span><img src="<?php echo config('static_admin'); ?>/images/ticon.png" /></span>
                <div class="tipright">
                    <p>是否确认对信息的修改 ？</p>
                    <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
                </div>
            </div>
            <div class="tipbtn">
                <input name="" type="button" class="sure" value="确定" />&nbsp;
                <input name="" type="button" class="cancel" value="取消" />
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
            
        $("a:contains('删除')").click(function(){
            if(!confirm('确定删除?')){
                return;
            }
            var obj=$(this);

            $.get("<?php echo url('/admin/category/del'); ?>",{cat_id:obj.parents('tr').children('input[name=cat_id]').val()},function(result){
            if(result.code==200){
                layer.msg(result.msg);
                obj.parents('tr').remove();
                return;
            }
                layer.msg(result.msg);
            
             },'json');
        });

        //点击编辑弹框显示
        function showupd(obj){
            var obj=$(obj);
            var cat_id=obj.parents('tr').children('input[name=cat_id]').val();
             layer.open({
                type: 2,
                //title: 'layer弹层组件官网',
                //fix: false,
                //maxmin: true,
                //shadeClose: true,
                skin:'layui-layer-lan',
                area: ['1000px', '500px'],
                content: '<?php echo url("/admin/category/upd"); ?>?cat_id='+cat_id,
                end:function(){
                    $.get("<?php echo url('/admin/category/callback'); ?>",{cat_id:cat_id},function(result){
                        obj.parents('tr').html(result.content);
                    },'json');
                }

               });
        }


    
       
    </script>
</body>

</html>