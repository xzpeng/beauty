<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:wb="http://open.weibo.com/wb" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>美人网--<?php echo ($pageTitle); ?></title>
<link href="__PUBLIC__/Home/Css/public.css" rel="stylesheet" type="text/css" />
<link href="__PUBLIC__/Home/Css/public2.css" rel="stylesheet" type="text/css" />
<link href="__PUBLIC__/Home/Css/Index_index.css" rel="stylesheet" type="text/css" />
<script src="__PUBLIC__/Js/jquery-1.9.1.min.js"></script>
<script src="__PUBLIC__/Home/Js/public.js"></script>
<script src="__PUBLIC__/Home/Js/Index_index.js"></script>

<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
<!-- Baidu Button BEGIN -->
<script type="text/javascript" id="bdshare_js" data="type=slide&amp;img=7&amp;pos=right&amp;uid=768886" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);
</script>
<!-- Baidu Button END -->
<!--包含登录框-->
<div id="loginBox">
<div id="login_left">
<h2>用户登录</h2>
<form action="__APP__/User/doLogin" method="post">
<table>
  <tr>
    <td>用户名</td>
    <td><input type="text" name="userName" id="userName" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>密码</td>
    <td><input type="password" name="password" id="password" /></td>
    <td>&nbsp;</td>
  </tr>
 
  <tr>
    <td>验证码</td>
    <td><input type="text" name="verify" id="verify" /></td>
    <td valign="middle"><img src="__APP__/Public/verify" class="verifyImg" /></td>
  </tr> 
  <tr>
    <td colspan="3" align="center"><input name="autoLogin" id="autoLogin" type="checkbox" value="true" />30天内自动登录</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input type="submit" value="登录" id="doLogin" /><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1565816819&site=qq&menu=yes">忘记密码？联系管理员</a></td>
    </tr>
</table>
</form>
</div>
<div id="login_center"></div>
<div id="login_close"></div>
<div id="login_right">
<h2>注册</h2>
<br /><br />
还没有账号？
<a href="__APP__/User/regis" target="_blank" class="regLink">立即注册</a>
</div>
</div>
<div id="loginBg">
</div>
<div id="main">
<div id="attention">
<div id="wb">
<wb:follow-button uid="3194404213" type="red_2" width="136" height="24" ></wb:follow-button>
</div>
</div>


<ul>
<li id="item0">
<div id="logo">
<div id="login">
<div id="login_box">
<form action="__APP__/Article/index" method="get">
<input name="keywords" type="text" id="search_text" />
<input name="" type="submit" value="" id="search_btn" />
</form>
<div id="login_btn" class="index_login">登录</div>
<a href="__APP__/User/regis" id="login_reg" target="_blank">注册</a>
<a href="__APP__/User/snsLogin?type=qq">QQ</a>
<a href="__APP__/User/snsLogin?type=tencent">腾讯微博</a>
</div>
</div>
</div>
</li>
<?php if(is_array($list)): $kid = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($kid % 2 );++$kid;?><a href="__URL__/type/id/<?php echo ($vo["id"]); ?>">
<li id="item<?php echo ($kid); ?>">
<p><?php echo ($vo["remark"]); ?></p>
</li>
</a><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>

<div class="clear"></div>

<div id="bottom">
<div id="bottom_content">
<a href="__APP__/Article/show/id/1">关于美人</a>&nbsp;&nbsp;<a href="__APP__/Article/show/id/2">法律条款</a>&nbsp;&nbsp;<a href="__APP__/Article/show/id/3">诚聘英才</a>&nbsp;&nbsp;<a href="__APP__/Article/show/id/4">商务合作</a>&nbsp;&nbsp;<a href="__APP__/Article/show/id/5">线下联盟</a>&nbsp;&nbsp;<a href="__APP__/Article/show/id/6">联系我们</a><br />
Copyright 2013-2023, 版权所有WWW.MEIREN1520.COM<br />
京ICP备11048099号-1&nbsp;&nbsp;最佳分辨率1366*768，建议使用Chrome、Firefox、Safari、ie9版本浏览器
</div>
<span style="display:none;">
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fe6cd86014e276f6360060c7904dec030' type='text/javascript'%3E%3C/script%3E"));
</script>
</span>

</div>

</div>

</body>
</html>