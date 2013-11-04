<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:wb="http://open.weibo.com/wb" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>美人网--<?php echo ($pageTitle); ?></title>
<link href="__PUBLIC__/Home/Css/public.css" rel="stylesheet" type="text/css" />
<link href="__PUBLIC__/Home/Css/public2.css" rel="stylesheet" type="text/css" />
<link href="__PUBLIC__/Home/Css/Article_show.css" rel="stylesheet" type="text/css" />
<script src="__PUBLIC__/Js/jquery-1.9.1.min.js"></script>
<script src="__PUBLIC__/Home/Js/public.js"></script>
<script src="__PUBLIC__/Home/Js/Article_show.js"></script>

<script language="javascript" src="__PUBLIC__/Js/layer-v1.6.0/layer.min.js"></script>
<script>
var _URL='__URL__';
var _UID='<?php echo ($list["uid"]); ?>';
var clickObj=new Object();
clickObj['stature']=Number('<?php echo ($list["stature"]); ?>');
clickObj['face']=Number('<?php echo ($list["face"]); ?>');
clickObj['liked']=Number('<?php echo ($list["liked"]); ?>');
</script>
<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
<script src="__PUBLIC__/Home/Js/swfobject_modified.js" type="text/javascript"></script>
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
        <a href="javascript:history.back()" style="display:block;" class="top_reg" id="back_btn">返回</a>
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
<div id="main">
<div id="banner" style="background-color:<?php echo ($banner["bgcolor"]); ?>;">
<a href="<?php echo ($banner["href"]); ?>" target="<?php echo ($banner["window"]); ?>">
<?php if($banner["swf"] == 1 ): ?><!--支持swf动画-->
<object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" >
  <param name="movie" value="__PUBLIC__/Uploads/<?php echo ($banner["img"]); ?>">
  <param name="quality" value="high">
  <param name="wmode" value="opaque">
  <param name="swfversion" value="15.0.0.0">
  <!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 -->
  <param name="expressinstall" value="__PUBLIC__/Home/Images/expressInstall.swf">
  <!-- 下一个对象标签用于非 IE 浏览器。所以使用 IECC 将其从 IE 隐藏。 -->
  <!--[if !IE]>-->
  <object type="application/x-shockwave-flash" data="__PUBLIC__/Uploads/<?php echo ($banner["img"]); ?>" >
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
<img src="__PUBLIC__/Uploads/<?php echo ($banner["img"]); ?>"  /><?php endif; ?>
</a>
</div>
<?php if($list["gfrz"] != 1 ): ?><div id="card">
<div id="card_left" style="background:url(__PUBLIC__/Uploads/<?php echo ($list["cover"]); ?>) no-repeat">
<div id="remark">
工作经历:<br>
<?php echo ($list["workRemark"]); ?>
</div>
</div>
<div id="card_right">
<div class="scoreMask maskBg" style="display:<?php echo ($list["islogin"]); ?>;"></div>
<div class="scoreMask" style="display:<?php echo ($list["islogin"]); ?>;"><span id="login_btn2">登录</span>后可以参与评分,没有账号？<a href="__APP__/User/regis" target="_blank">立即注册</a></div>
<table border="0" cellspacing="0" cellpadding="0" class="tab_card">
  <tr>
    <td><h1><?php echo ($list["name"]); ?>&nbsp;(<?php echo ($list["nickName"]); ?>)</h1>
    </td>
  </tr>
  <tr>
    <td><img src="__PUBLIC__/Uploads/<?php echo ($list["picture"]); ?>" height="120" width="120" class="picture2" />
    姓名：<?php echo ($list["name"]); ?>&nbsp;&nbsp;性别：<?php echo ($list["sex"]); ?>
    <?php if($list["rna"] == 1 ): ?>&nbsp;&nbsp;<img  src="__PUBLIC__/Home/Images/v1.png" width="20" height="20" style="vertical-align:middle;" title="已通过实名认证" /><?php endif; ?><br>
    生日：<?php echo (date("Y年m月d日",$list["birthday"])); ?><br>
	身高：<?php echo ($list["height"]); ?>&nbsp;cm<br>
    体重：<?php echo ($list["weight"]); ?>&nbsp;kg<br>
三围：<?php echo ($list["sanwei"]); ?><br>
    </td>
  </tr>
  <tr>
    <td>
    毕业院校：<?php echo ($list["graduated"]); ?><br>
学历：<?php echo ($list["edu"]); ?><br>
 <?php if($list["rna"] == 1 ): ?><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ($list["qq"]); ?>&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo ($list["qq"]); ?>:51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a><br>
 微博地址:&nbsp;&nbsp;<a href="<?php echo ($list["wburl"]); ?>" target="_blank"><?php echo ($list["wburl"]); ?></a>
 </td>
  </tr>
  <tr>
    <td>
   <table border="0" cellspacing="0" cellpadding="0" class="tab_pf" id="scoreDiv">
   <tr>
    <td colspan="6">我的评价：</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;平均统计：</td>
  </tr>
  <tr>
    <td>身材：</td>
    <td><div class="wjx" id="stature_1"></div></td>
    <td><div class="wjx" id="stature_2"></div></td>
    <td><div class="wjx" id="stature_3"></div></td>
    <td><div class="wjx" id="stature_4"></div></td>
    <td><div class="wjx" id="stature_5"></div></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;平均分：<span id="stature_ave"><?php echo ($list["stature_ave"]); ?></span></td>
  </tr>
  <tr>
    <td>面容：</td>
   	<td><div class="wjx" id="face_1"></div></td>
    <td><div class="wjx" id="face_2"></div></td>
    <td><div class="wjx" id="face_3"></div></td>
    <td><div class="wjx" id="face_4"></div></td>
    <td><div class="wjx" id="face_5"></div></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;平均分：<span id="face_ave"><?php echo ($list["face_ave"]); ?></span></td>
  </tr>
  <tr>
    <td>喜欢程度：</td>
    <td><div class="wjx" id="liked_1"></div></td>
    <td><div class="wjx" id="liked_2"></div></td>
    <td><div class="wjx" id="liked_3"></div></td>
    <td><div class="wjx" id="liked_4"></div></td>
    <td><div class="wjx" id="liked_5"></div></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;平均分：<span id="liked_ave"><?php echo ($list["liked_ave"]); ?></span></td>
  </tr>
</table>
 <div class="xlwb"><a version="1.0" class="qzOpenerDiv" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_likeurl" target="_blank">赞</a><script  src="http://qzonestyle.gtimg.cn/qzone/app/qzlike/qzopensl.js#jsdate=20110603&style=3&showcount=1&width=130&height=30" charset="utf-8" defer ></script></div>
    <div class="xlwb"><wb:like type="number"></wb:like></div>
    </td>
  </tr>
 <?php else: ?>
 <font color="#FF0000" style="font-weight:bold;">注意：该用户尚未通过实名审核,暂不能进行在线联系和在线评分</font>
 </td>
  </tr><?php endif; ?>

  <tr>
    <td><h1>职业：<?php echo ($list["job"]); ?></h1></td>
  </tr>
  <tr>
    <td style="text-align:center;background-color:<?php echo ($ill["bgcolor"]); ?>;">
    <a href="<?php echo ($ill["href"]); ?>" target="<?php echo ($ill["window"]); ?>">
<?php if($ill["swf"] == 1 ): ?><!--支持swf动画-->
<object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" >
  <param name="movie" value="__PUBLIC__/Uploads/<?php echo ($ill["img"]); ?>">
  <param name="quality" value="high">
  <param name="wmode" value="opaque">
  <param name="swfversion" value="15.0.0.0">
  <!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 -->
  <param name="expressinstall" value="__PUBLIC__/Home/Images/expressInstall.swf">
  <!-- 下一个对象标签用于非 IE 浏览器。所以使用 IECC 将其从 IE 隐藏。 -->
  <!--[if !IE]>-->
  <object type="application/x-shockwave-flash" data="__PUBLIC__/Uploads/<?php echo ($ill["img"]); ?>" >
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
<img src="__PUBLIC__/Uploads/<?php echo ($ill["img"]); ?>"/><?php endif; ?>
</a>
    </td>
  </tr>
</table>

</div>
</div><?php endif; ?>

<div id="titleBox">
<div id="title">
<?php echo ($list["title"]); ?>
</div>
<div id="info">浏览量：<?php echo ($list["hits"]); ?>人次&nbsp;&nbsp;作者：<?php echo ($list["promulgator"]); ?>
<?php if($list["gfrz"] == 1 ): ?>&nbsp;<img src="__PUBLIC__/Home/Images/gfrz.png" style="vertical-align:middle;" width="53" height="12" title="美人网官方发布"><?php endif; ?>
  <?php if($list["rna"] == 1 ): ?>&nbsp;<img  src="__PUBLIC__/Home/Images/v1.png" width="12" height="12" style="vertical-align:middle;" title="已通过实名认证" /><?php endif; ?>
&nbsp;&nbsp;编辑时间：<?php echo (date("Y-m-d  H:i",$list["edit_time"])); ?></div>
</div>
<div id="content">
<?php echo ($list["content"]); ?>
</div>
</div>
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
<script type="text/javascript">
swfobject.registerObject("FlashID");
</script>
</body>
</html>