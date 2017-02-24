<?php if (!defined('THINK_PATH')) exit();?><html>
<head></head>
<body>
<table>
	<tr>
	<th>id</th>
	<th>name</th>
	<th>操作</th>
	</tr>
	<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr><td><?php echo ($vo["id"]); ?></td><td><?php echo ($vo["data"]); ?></td><td><a href="/Index/del?id=<?php echo ($vo["id"]); ?>">删除</a><a href="/Index/update?id=<?php echo ($vo["id"]); ?>">编辑</a></td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
<a href="/Index/add">新增</a>
</body>
</html>