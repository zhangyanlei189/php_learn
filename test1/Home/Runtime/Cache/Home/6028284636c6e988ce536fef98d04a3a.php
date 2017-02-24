<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>图片上传</title>
</head>
<body>
<form action="/Index/upload" enctype="multipart/form-data" method="post">
    <input type="file">
    <input type="submit" value="提交">
</form>
</body>
</html>