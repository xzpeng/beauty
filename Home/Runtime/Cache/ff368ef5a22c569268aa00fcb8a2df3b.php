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
<!--主体-->
<br />
<br />
<br />
 <br />
<?php if($lineup == 1): ?><center>
 <h2>正在排队中...</h2><br/>
   <p>前方还有<?php echo ($linelength); ?>人在排队，请耐心等待</p>
   </center>
<?php else: ?>
    <form action="__URL__/doRna" method="post" enctype="multipart/form-data">
<table border="0" align="center" cellpadding="0" cellspacing="0" class="tab_edit">
<tr>
    <td colspan="3" align="center"><h2>实名认证</h2></td>
    </tr>
  <tr>
    <td>*</td>
    <td>身份证号码</td>
    <td><input name="IDNum" type="text"></td>
  </tr>
  <tr>
    <td>*</td>
    <td>身份证正面上传</td>
    <td><input name="IDCard_a" type="file"></td>
  </tr>
  <tr>
    <td>*</td>
    <td>身份证反面上传</td>
    <td><input name="IDCard_b" type="file"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>审核时间</td>
    <td>1-3个工作日内(提交审核后将进入排队状态，排队期间无法再次提交)</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input type="submit" name="button" id="button" value="提交"></td>
    </tr>
</table>
</form><?php endif; ?>
<br />
<br />
<p>
<b>认证必读：</b>
<br />
<br />
1、注册时填写的真实姓名、出生日期、详细地址等信息需要和身份证上的信息保持一致，如果不一致请先<a href="__APP__/Center/editData">修改</a>后再提交审核。<br />
2、头像、封面形象和个人资料完善度同样也可能会影响审核结果。<br />
3、实名认证通过后您的用户名上将会出现&nbsp;<img src="__PUBLIC__/Home/Images/v1.png" width="25" height="25" />&nbsp;认证图标，不通过将会重新返回上传提交界面。
</p>
<!--主体-->
</div>
<div id="content_bottom"></div>
</div>
</div>
</body>
</html>