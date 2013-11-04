<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>美人网--<?php echo ($pageTitle); ?></title>
<link href="__PUBLIC__/Home/Css/public.css" rel="stylesheet" type="text/css" />
<link href="__PUBLIC__/Home/Css/Center_index.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="__PUBLIC__/Js/jquery-1.9.1.min.js"></script>
<script language="javascript" src="__PUBLIC__/Js/layer-v1.6.0/layer.min.js"></script>
<script>
var _URL='__URL__';
</script>
<script language="javascript" src="__PUBLIC__/Home/Js/Center_public.js"></script>
<link href="__PUBLIC__/Home/Css/Center_addArticle.css" rel="stylesheet" type="text/css" />
<script>
var typeInfo=eval('<?php echo ($typeInfo); ?>');
var _URL='__URL__';
var _PUBLIC='__PUBLIC__';
var _APP='__APP__';
var session_id='<?php echo ($session_id); ?>';
</script>
<script language="javascript" src="__PUBLIC__/Ueditor/ueditor.config.js"></script>
<script language="javascript" src="__PUBLIC__/Ueditor/ueditor.all.min.js"></script>
<script language="javascript" src="__PUBLIC__/Home/Js/Center_addArticle.js"></script>
<script language="javascript" src="__PUBLIC__/Ueditor/lang/zh-cn/zh-cn.js"></script>
</head>

<body>
<div id="main">

<div id="logo"></div>
<div id="top">
<h1 id="column">个人中心</h1>
<div id="nav">
<div id="nav_left"></div>
<div id="nav_center">
<a href="__APP__/Index/index">网站首页</a>
<a href="__URL__/index">个人主页</a>
</div>
<div id="nav_right"></div>
</div>
</div>

<div id="center">
<div id="left">
<ul>
<li><img src="__PUBLIC__/Uploads/<?php echo ($picture); ?>" width="171" height="171" class="picture" id="uploadPic" title="点击编辑头像" /></li>
<li class="nameh"><?php echo ($userName); ?>
<?php if($rna == 1 ): ?>&nbsp;&nbsp;<img  src="__PUBLIC__/Home/Images/v1.png" width="25" height="25" style="vertical-align:middle;" title="已通过实名认证" /><?php endif; ?>
</li>
<li>昵称：<?php echo ($nickName); ?></li>
<li>性别：<?php echo ($sex); ?></li>
<li>生日：<?php echo (date("Y年m月d日",$birthday)); ?></li>
<li><center><a href="__URL__/editData">修改资料</a>&nbsp;&nbsp;<a href="__URL__/editPassword">修改密码</a>&nbsp;&nbsp;<a href="__APP__/User/loginout">退出</a></center></li>
<?php if($rna != 1 ): ?><li><a href="__URL__/rna" class="addArticle">实名认证</a></li><?php endif; ?>
<li><a href="__URL__/addArticle" class="addArticle">发表文章</a></li>
</ul>
</div>
<div id="content">
<div id="content_top"></div>
<div id="content_center">

<form action="__URL__/add" method="post" enctype="multipart/form-data" name="form1" id="form1">
<table cellpadding="0" cellspacing="0" class="tab_edit">
  <tr>
    <td>分类</td>
    <td>
    <select name="type" id="type" class="selectBox">
    
    </select>
    </td>
  </tr>
  <tr>
    <td>标题</td>
    <td><input type="text" name="title" id="title" class="inputBox" /></td>
  </tr>
  <tr>
    <td>略缩图</td>
    <td><input name="img" id="img" type="file" /></td>
  </tr>
  <tr>
    <td>外链</td>
    <td>
    <input type="text" name="href" id="href" class="inputBox" />
    <div id="hideArea"></div>
    </td>
  </tr>
  <tr>
    <td>关键词</td>
    <td><input type="text" name="keywords" id="keywords" class="inputBox" />&nbsp;&nbsp;&nbsp;&nbsp;多个关键词请用空格隔开</td>
  </tr>
  <tr id="contentArea">
    <td>内容</td>
    <td>
	<script type="text/plain" id="contentedit" name="content"></script>
    </td>
  </tr>
  <tr>
  <td></td>
    <td>
    <input id="sub" type="button" value="发布" class="submitMode" />
    <input type="reset" value="返回" class="submitMode" onclick="javascript:history.back()"/>
    <input type="reset" value="重置" class="submitMode" /></td>
    </tr>
</table>
</form>
<!--主体-->

</div>
<div id="content_bottom"></div>
</div>
</div>
</body>
</html>