<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>图片列表</title>
</head>
<body>
<?php if(is_array($imgs)): $i = 0; $__LIST__ = $imgs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><img src="/public/uploads<?php echo ($vo["image"]); ?>"><?php endforeach; endif; else: echo "" ;endif; ?>
</body>
</html>