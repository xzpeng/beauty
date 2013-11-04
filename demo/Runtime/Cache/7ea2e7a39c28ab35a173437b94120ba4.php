<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>ThinkLogin</title>
</head>
<body>
	<ul>
		<li><a href="<?php echo U('login?type=qq');?>">腾讯QQ用户登录</a></li>
		<li><a href="<?php echo U('login?type=sina');?>">新浪微博用户登录</a></li>
		<li><a href="<?php echo U('login?type=taobao');?>">淘宝网用户登录</a></li>
	</ul>
</body>
</html>