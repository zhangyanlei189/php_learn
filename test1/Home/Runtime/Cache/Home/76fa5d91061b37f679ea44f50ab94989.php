<?php if (!defined('THINK_PATH')) exit();?><html>
<head></head>
<link rel="stylesheet" href="/public/css/style.css">
<link rel="stylesheet" href="/public/css/main.css">
<script src="/public/js/jquery.js"></script>
<script src="/public/js/main.js"></script>
<style>
	table .deal{margin: 0 15px;}
	table td{padding: 3px 8px;}
</style>
<body>
<br>
<a href="/Index/add" style="margin-left: 20px;">新增</a><a href="/Index/effect" style="margin-left: 15px;">查看效果统计</a>
<a href="/Index/to_upload">上传图片</a>
<br><br><br>
<div style="background: #fff;margin: 0 auto;">
	<table style="margin: 0 auto;">
		<tr>
			<th>序号</th>
			<th>id</th>
			<th>name</th>
			<th>时间</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
				<td><?php echo ++$indx;?></td>
				<td><?php echo ($vo["id"]); ?></td>
				<td><?php echo ($vo["name"]); ?></td>
				<td><?php echo ($vo["date"]); ?></td>
				<td><a href="/Index/del?id=<?php echo ($vo["id"]); ?>" class="del deal">删除</a><a href="/Index/update?id=<?php echo ($vo["id"]); ?>" class="deal update">编辑</a></td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
</div>
<div id="page"><?php echo ($page); ?></div>

<br>
<br>
<br>
<script>

	$(".del").on("click",function() {
		var url = $(this).attr("href");
		$.get(url,function (r) {
			location.href = "/Index/index";
        },"json");
		return false;
    });
</script>

</body>
</html>