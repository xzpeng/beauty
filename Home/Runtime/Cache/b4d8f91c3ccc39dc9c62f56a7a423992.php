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
<link href="__PUBLIC__/Home/Css/Center_index_list.css" rel="stylesheet" type="text/css" />
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
<table border="0" cellspacing="0" cellpadding="0" class="tab_list">
  <tr class="tab_top">
    <td>标题</td>
    <td>类别</td>
    <td>点击量</td>
    <td>编辑时间</td>
    <td>审核</td>
    <td>推荐</td>
    <td>操作</td>
  </tr>
  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
    <td><a href="__APP__/Article/show/id/<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></a></td>
    <td><?php echo ($vo["type"]); ?></td>
    <td><?php echo ($vo["hits"]); ?></td>
    <td><?php echo (date("y-m-d  H:i",$vo["edit_time"])); ?></td>
    <td>
    <?php if($vo["display"] == 1 ): ?>已审核
	<?php else: ?> 审核中<?php endif; ?>
    </td>
    <td>
    <?php if($vo["recommend"] == 1 ): ?>已推荐
	<?php else: ?> 未推荐<?php endif; ?>
    </td>
    <td><a href="__URL__/delete/id/<?php echo ($vo["id"]); ?>">删除</a>&nbsp;&nbsp;<a href="__URL__/editArticle/id/<?php echo ($vo["id"]); ?>">修改</a></td>
  </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
  <tr>
    <td colspan="7" class="pageshow"><?php echo ($pageshow); ?></td>
    </tr>
</table>

</div>
<div id="content_bottom"></div>
</div>
</div>
</body>
</html>