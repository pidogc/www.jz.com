<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\project\www.shop.com\public/../application/admin\view\goods\list.html";i:1535890668;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="<?php echo config('static_admin'); ?>/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo config('static_admin'); ?>/css/page.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo config('static_admin'); ?>/js/jquery.js"></script>
    <script language="JavaScript" src="/plugins/PoPlayer/layer.js"></script>
    <script language="JavaScript" src="/plugins/content/layer/layer/layer.js"></script>
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
                <li onclick="showadd(this)"><span><img src="<?php echo config('static_admin'); ?>/images/t01.png" /></span>添加</li>
                <li><span><img src="<?php echo config('static_admin'); ?>/images/t02.png" /></span>修改</li>
                <li><span><img src="<?php echo config('static_admin'); ?>/images/t03.png" /></span>删除</li>
                <li onclick='exec(this)'><span><img src="<?php echo config('static_admin'); ?>/images/t04.png" /></span>导表</li>
            </ul>
        </div>
        <table class="tablelist">
            <thead>
                <tr>
                    <th>
                        <input name="" type="checkbox" value="" id="checkAll" />
                    </th>
                    <th>编号</th>
                    <th>商品名称</th>
                   <!--  <th>货品号</th> -->
                    <th>商品价格</th>
                    <th>商品库存</th>
                    <th>商品类型</th>
                    <th>商品分类</th>
                    <th>商品图片</th>
                    <th>回收</th>
                    <th>上架</th>
                    <th>新品</th>
                    <th>推荐</th>
                    <th>热卖</th>
                    <th>商品详情</th>
                    <th>创建时间</th>
                    <th>更新时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <tr>
                    <input name='goods_id' type='hidden' value="<?php echo $v['goods_id']; ?>">
                    <td>
                        <input name="" type="checkbox" value="" />
                    </td>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo $v['goods_name']; ?></td>
                  <!--   <td><?php echo $v['goods_sn']; ?></td> -->
                    <td><?php echo $v['goods_price']; ?></td>
                    <td><?php echo $v['goods_number']; ?></td>
                    <td><?php echo $v['type_name']; ?></td>
                    <td><?php echo $v['cat_name']; ?></td>
                    <td><img src="/uploads/<?php echo json_decode($v['goods_thumb'])[0]; ?>"/></td>
                    <td><?php echo config('is_delete')[$v['is_delete']]; ?></td>
                    <td><?php echo config('is_sale')[$v['is_sale']]; ?></td>
                    <td><?php echo config('is_new')[$v['is_new']]; ?></td>
                    <td><?php echo config('is_best')[$v['is_best']]; ?></td>
                    <td><?php echo config('is_hot')[$v['is_hot']]; ?></td>
                    <td><a href='javascript:;' onclick='showcontent(this)'>点击查看</a></td>
                    <td><?php echo $v['create_time']; ?></td>
                    <td><?php echo $v['update_time']; ?></td>
                    <td>
                        <!-- <a href="javascript:;" class="tablelink"  onclick="showcontent(this)">查看</a> -->
                        <!-- <a href="<?php echo url('/admin/type/upd',['type_id'=>$v['type_id']]); ?>" class="tablelink">编辑</a> -->
                        <a href="javascript:;" class="tablelink" onclick="showupd(this)">编辑</a>
                        <a href="javascript:;"  class="tablelink"> 删除</a>
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

            $.get("<?php echo url('/admin/type/del'); ?>",{type_id:obj.parents('tr').children('input[name=type_id]').val()},function(result){
            if(result.code==200){
                layer.msg(result.msg);
                obj.parents('tr').remove();
                return;
            }
                layer.msg(result.msg);
            
             },'json');
        });

        //导表
        function exec(obj){
            layer.open({
                type: 2,
                title: '导表',
                //fix: false,
                //maxmin: true,
                //shadeClose: true,
                //time:0.1,
                skin:'layui-layer-lan',
                area: ['1000px', '500px'],
                content: '<?php echo url("/admin/goods/excel"); ?>',
               //content: 'www.baidu.com',
               });
        }

        //点击商品详情页，弹框显示
        function showcontent(obj){
            var obj=$(obj);
            var goods_id=obj.parents('tr').children('input[name=goods_id]').val();
            layer.open({
                type: 2,
                title: '商品详情',
                //fix: false,
                //maxmin: true,
                //shadeClose: true,
                skin:'layui-layer-lan',
                area: ['1000px', '500px'],
                content: '<?php echo url("/admin/goods/showcontent"); ?>?goods_id='+goods_id,
               //content: 'www.baidu.com',
               });
        }

         function showupd(obj){
            console.log(obj);
            var obj=$(obj);
            var type_id=obj.parents('tr').children('input[name=type_id]').val();
             layer.open({
                type: 2,
                //title: 'layer弹层组件官网',
                //fix: false,
                //maxmin: true,
                //shadeClose: true,
                skin:'layui-layer-lan',
                area: ['1000px', '500px'],
                content: '<?php echo url("/admin/type/upd"); ?>?type_id='+type_id,
               //content: 'www.baidu.com',
               });
        }

        function showadd(obj){
            layer.open({
                type: 2,
                //title: 'layer弹层组件官网',
                //fix: false,
                //maxmin: true,
                //shadeClose: true,
                skin:'layui-layer-lan',
                area: ['1000px', '500px'],
                content: '<?php echo url("/admin/goods/add"); ?>',
               //content: 'www.baidu.com',
               });
        }

    
       
    </script>
</body>

</html>
