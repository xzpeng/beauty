<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:wb="http://open.weibo.com/wb" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>美人网--<?php echo ($pageTitle); ?></title>
<link href="__PUBLIC__/Home/Css/public.css" rel="stylesheet" type="text/css" />
<link href="__PUBLIC__/Home/Css/public2.css" rel="stylesheet" type="text/css" />
<link href="__PUBLIC__/Home/Css/Article_index.css" rel="stylesheet" type="text/css" />
<script src="__PUBLIC__/Js/jquery-1.9.1.min.js"></script>
<script src="__PUBLIC__/Home/Js/public.js"></script>
<script src="__PUBLIC__/Home/Js/Article_index.js"></script>

<script language="javascript">
var loadUrl='__URL__/loadList';
var imgUrl='__PUBLIC__/Uploads/';
var keywords='<?php echo ($keywords); ?>';
var typeId='<?php echo ($type); ?>';
var URL='__URL__';
var typePid='<?php echo ($typePid); ?>';
</script>
</head>

<body>
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
<div id="top">

    <div id="loginDiv">
        <div id="top_list"></div>
        <form action="__APP__/Article/index" method="get">
            <input name="keywords" type="text" id="search_text" value="<?php echo ($keywords); ?>" />
            <input name="" type="submit" value="" id="search_btn" />
        </form>
        <div style="display:<?php echo ($isLogin); ?>;">
            <div id="login_btn" class="top_login">登录</div>
            <a href="__APP__/User/regis" target="_blank" class="top_reg">注册</a>
        </div>
        <div style="display:<?php echo ($myInfo); ?>;">
            <a href="__APP__/Center/index"><img src="__PUBLIC__/Uploads/<?php echo ($picture); ?>" height="30" width="30" class="top_picture"/></a>
            <a href="__APP__/Center/index" class="top_reg"><?php echo ($userName); ?>
                <?php if($rna == 1 ): ?>&nbsp;&nbsp;<img  src="__PUBLIC__/Home/Images/v1.png" width="14" height="14" style="vertical-align:middle;" title="已通过实名认证" /><?php endif; ?>
            </a>
            <span class="top_reg">等级</span><a class="top_reg" href="#">签到</a>
            <a href="__APP__/User/loginout" class="top_reg">退出</a>
        </div>
        <a href="__APP__/Index/index" class="top_reg">首页</a>
        <a href="__APP__/Index/type/id/1" class="top_reg">美人</a>
        <a href="__APP__/Index/type/id/2" class="top_reg">模特</a>
        <a href="__APP__/Index/type/id/3" class="top_reg">美课</a>
        <a href="__APP__/Index/type/id/4" class="top_reg">时尚</a>
        <a href="javascript:history.back()" style="display:[back];" class="top_reg" id="back_btn">返回</a>
    </div>

    <div id="bdshareDiv">
        <!-- Baidu Button BEGIN -->
        <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
            <a class="bds_qzone"></a>
            <a class="bds_tsina"></a>
            <a class="bds_tqq"></a>
            <a class="bds_renren"></a>
            <a class="bds_t163"></a>
            <span class="bds_more"></span>
            <a class="shareCount"></a>
        </div>
        <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=768886" ></script>
        <script type="text/javascript" id="bdshell_js"></script>
        <script type="text/javascript">
            document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
        </script>
        <!-- Baidu Button END -->
    </div>

</div>

<div class="clear"></div>

<div id="banner2" style="background-color:<?php echo ($banner["bgcolor"]); ?>;">
<a href="<?php echo ($banner["href"]); ?>" target="<?php echo ($banner["window"]); ?>">
<?php if($banner["swf"] == 1 ): ?><!--支持swf动画-->
<object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"  >
  <param name="movie" value="__PUBLIC__/Uploads/<?php echo ($banner["img"]); ?>">
  <param name="quality" value="high">
  <param name="wmode" value="opaque">
  <param name="swfversion" value="15.0.0.0">
  <!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 -->
  <param name="expressinstall" value="__PUBLIC__/Home/Images/expressInstall.swf">
  <!-- 下一个对象标签用于非 IE 浏览器。所以使用 IECC 将其从 IE 隐藏。 -->
  <!--[if !IE]>-->
  <object type="application/x-shockwave-flash" data="__PUBLIC__/Uploads/<?php echo ($banner["img"]); ?>">
    <!--<![endif]-->
    <param name="quality" value="high">
    <param name="wmode" value="opaque">
    <param name="swfversion" value="15.0.0.0">
    <param name="expressinstall" value="__PUBLIC__/Home/Images/expressInstall.swf">
    <!-- 浏览器将以下替代内容显示给使用 Flash Player 6.0 和更低版本的用户。 -->
    <div>
      <h4>此页面上的内容需要较新版本的 Adobe Flash Player。</h4>
      <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="获取 Adobe Flash Player" width="112" height="33" /></a></p>
    </div>
    <!--[if !IE]>-->
  </object>
  <!--<![endif]-->
</object>
<!--支持swf动画-->
<?php else: ?>
<img src="__PUBLIC__/Uploads/<?php echo ($banner["img"]); ?>"   /><?php endif; ?>
</a>
</div>

<div id="main">

<div id="row0" class="rows">
<?php if($typeList == ""): else: ?>
<div class="items" style="opacity:1;">
<div id="typeList">
<div id="listTop">分类筛选</div>
<div id="listContent">
<a href="__URL__/index/pid/<?php echo ($pid); ?>">全部</a>
<?php if(is_array($typeList)): $i = 0; $__LIST__ = $typeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="__URL__/index/id/<?php echo ($vo["id"]); ?>/keywords/<?php echo ($keywords); ?>"><?php echo ($vo["title"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
<div class="clear"></div>
</div>
</div>
</div><?php endif; ?>


</div>
</div>
<div id="mesg"></div>
<div class="clear"></div>
<span style="display:none;">
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fe6cd86014e276f6360060c7904dec030' type='text/javascript'%3E%3C/script%3E"));
</script>
</span>
</body>
</html>