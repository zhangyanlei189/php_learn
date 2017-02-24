<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="/public/css/style.css">
<link rel="stylesheet" href="/public/css/main.css">
<script src="/public/js/jquery.js"></script>
<script src="/public/js/main.js"></script>
<head>
    <meta charset="UTF-8">
    <title>登陆</title>
</head>
<body style="height:800px;">
<div id="login_page">
    <div class="tit">登陆</div>
    <form id="login_form" action="/Login/index" class="login_form" method="post">
        <div><span>用户名:</span><input type="text" name="username"></div>
        <div><span>密码:</span><input type="password" name="password"></div>
        <div class="clearfix"><span class="fr" style="width: auto;">还没有账号？<a href="/Login/register">去注册</a></span></div>
        <div><input type="submit" class="btn" value="提交" id="submit_btn"></div>
    </form>
</div>
<script>
    var form = $("#login_form");
    $("#submit_btn").click(function(){
        $.post("/login/index",form.serialize(),function (r) {
            var r = $.parseJSON(r);
            if(!r.flag){
                Mask.alert(r.mess);
            }else {
                Mask.alert(r.mess,function () {
                    location.href="/Index/index";
                });
            }
        });
        return false;
    });
</script>
</body>
</html>