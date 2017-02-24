<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/public/css/style.css">
	<link rel="stylesheet" href="/public/css/main.css">
	<script src="/public/js/jquery.js"></script>
	<script src="/public/js/main.js"></script>
</head>
<body>
	<form action="/Index/update" method="post" id="edit_form">
	<input type="hidden" name="id" value="<?php echo ($d["id"]); ?>">
	<input type="text" name="name" value="<?php echo ($d["name"]); ?>">
	<input type="button" value="编辑" id="edit_btn">
	</form>
</body>
<script>
	$("#edit_btn").on("click",function () {
		var form = $("#edit_form");
		var url = form.attr("action");
		console.log(url);
		$.post(url,form.serialize(),function (r) {
			console.log(r);
        },"json");
		return false;
    });
</script>
</html>