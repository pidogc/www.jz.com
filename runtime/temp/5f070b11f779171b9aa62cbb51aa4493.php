<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\project\www.shop.com\public/../application/admin\view\index\left.html";i:1534725432;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="<?php echo config('static_admin'); ?>/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="<?php echo config('static_admin'); ?>/js/jquery.js"></script> <script type="text/javascript">
    $(function() {
        //导航切换
        $(".menuson li").click(function() {
            $(".menuson li.active").removeClass("active")
            $(this).addClass("active");
        });

        $('.title').click(function() {
            var $ul = $(this).nextAll('ul');
            $('dd').find('ul').slideUp();
            if ($ul.is(':visible')) {
                $(this).next('ul').slideUp();
            } else {
                $(this).next('ul').slideDown();
            }
        });
    })
    </script>
</head>

<body style="background:#f0f9fd;">
    <div class="lefttop"><span></span>※ 控制面板 ※</div>
    <dl class="leftmenu">
        <?php $auth=session('auth');$pid=session('pid'); foreach($pid[0] as $one){ ;?>
        <dd>
            <div class="title">
                <span><img src="<?php echo config('static_admin'); ?>/images/leftico01.png" /></span><?php echo $auth[$one]['auth_name'] ?>
            </div>
            <ul class="menuson">
            <?php foreach($pid[$one] as $two){ ?>
                <li>
                    <cite></cite><a href="<?php echo url('/admin/'.$auth[$two]['auth_c'].'/'.$auth[$two]['auth_a']); ?>" target="rightFrame"><?php echo $auth[$two]['auth_name'] ?></a><i></i>
                </li>
            <?php }; ?>
            </ul>
        </dd>       
       <?php }; ?>
    </dl>
</body>

</html>
