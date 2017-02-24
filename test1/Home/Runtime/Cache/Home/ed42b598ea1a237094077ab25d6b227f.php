<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/public/css/style.css">
	<link rel="stylesheet" href="/public/css/main.css">
	<script src="/public/js/jquery.js"></script>
	<script src="/public/js/main.js"></script>
</head>
<body>
	<form action="/Index/add" method="post" id="add_form">
	<input type="text" name="name" placeholder="请输入用户名" id="inner">
	<input type="button" value="添加">
	</form>
</body>
<script>
	var form = $("#add_form");
	$("input[type='button']",form).on("click",function () {
	    if (vali_name()){
            var url = form.attr("action");
            $.post(url,form.serialize(),function (res) {
                $("#inner").val("");
                /*if(res.flag){
                    Mask.alert(res.mess,function () {
						location.href="/Index/index";
                    });
				}else {
                    Mask.alet(res.mess);
				}*/
            },"json");
		}
		return false;

    });

	function vali_name() {
		var obj = $("input[name='name']");
		if(!obj.val()){
		    obj.css("border","2px solid red");
		    return false;
		}else {
		    obj.css("border","2px solid #555");
		    return true;
		}
    }
</script>
</html>