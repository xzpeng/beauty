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
<link href="__PUBLIC__/Home/Css/Center_editData.css" rel="stylesheet" type="text/css" />
<script src="__PUBLIC__/Js/ling.chinaArea-1.0.js"></script>
<script src="__PUBLIC__/Js/dateSelect/JQSelect.js"></script>
<script src="__PUBLIC__/Js/dateSelect/SelectDate.js"></script>
<script src="__PUBLIC__/Home/Js/Center_editData.js"></script>
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
<form action="__APP__/User/doEditData" method="post" name="regis" id="regis">
  <table cellpadding="0" cellspacing="0">
       <tr>
      <td></td>
      <td>昵称</td>
      <td>
        <input type="text" name="nickName" id="nickName" value="<?php echo ($list["nickName"]); ?>" />
        <input type="hidden" name="id" value="<?php echo ($list["id"]); ?>" />
        <span></span>
       </td>
      </tr>
      
       <?php if($rna != 1): ?><tr>
      <td>*</td>
      <td>性别</td>
      <td>
        <input type="radio" name="sex" id="sex0" value="0" />
        <label for="sex0">保密</label>
        <input type="radio" name="sex" id="sex1" value="1" />
        <label for="sex1">男</label>
        <input type="radio" name="sex" id="sex2" value="2" />
        <label for="sex2">女</label>
         &nbsp;&nbsp;<span></span>
      </td>
      </tr>
    <tr>
      <td>*</td>
      <td>出生日期</td>
      <td>
        <select id="ddlYear">
        </select>
        <select id="ddlMonth">
        </select>
        <select id="ddlDay">
        </select>
        <input type="hidden" name="birthday" id="birthday" value="0" />
        <span></span>
      </td>
      </tr><?php endif; ?>
    <tr>
      <td>&nbsp;</td>
      <td>身高</td>
      <td>
        <input type="text" name="height" id="height" value="<?php echo ($list["height"]); ?>" />
        <span></span></td>
      </tr>
       <tr>
      <td>&nbsp;</td>
    <td>体重</td>
    <td><input type="text" name="weight" id="weight" value="<?php echo ($list["weight"]); ?>"/>
    <span></span></td>
    </tr>
     <tr>
      <td>&nbsp;</td>
    <td>胸围</td>
    <td><input type="text" name="measure1" id="measure1" value="<?php echo ($list["measure1"]); ?>" />
    <span></span></td>
    </tr>
     <tr>
      <td>&nbsp;</td>
    <td>腰围</td>
    <td><input type="text" name="measure2" id="measure2" value="<?php echo ($list["measure2"]); ?>" />
    <span></span></td>
    </tr>
     <tr>
      <td>&nbsp;</td>
    <td>臀围</td>
    <td><input type="text" name="measure3" id="measure3" value="<?php echo ($list["measure3"]); ?>" />
    <span></span></td>
    </tr>
    <tr>
      <td>*</td>
      <td>学历</td>
      <td>
      <select id="edu" name="edu">
      <option value="0">请选择</option>
      <option value="1">初中及以下</option>
      <option value="2">高中</option>
      <option value="3">中专/技校</option>
      <option value="4">大专</option>
      <option value="5">本科</option>
      <option value="6">硕士及以上</option>
      </select>
      <span></span>
      </td>
      </tr>
      <?php if($rna != 1): ?><tr>
      <td>*</td>
      <td>真实姓名</td>
      <td><input type="text" name="name" id="name" value="<?php echo ($list["name"]); ?>" />
      <span></span>
      </td>
      </tr>
      
    <tr>
      <td>*</td>
      <td>地区</td>
      <td><select id="selProvince">
      <option>请选择</option>
      </select>
      <select id="selCity">
      <option>请选择</option>
      </select>
      <select id="selDistrict">
      <option>请选择</option>
      </select>
      <span></span>
       </td>
      <input type="hidden" name="area" id="area" value="" />
      </tr><?php endif; ?>
      <tr>
        <td>&nbsp;</td>
      <td>邮编</td>
      <td><input name="zip" id="zip" type="text" value="<?php echo ($list["zip"]); ?>" />
      <span></span>
       </td>
      </tr>
    <tr>
      <td>*</td>
      <td>手机</td>
      <td><input type="text" name="mphone" id="mphone" value="<?php echo ($list["mphone"]); ?>" />
      <span></span>
      </td>
      </tr>
    <tr>
      <td>*</td>
      <td>QQ</td>
      <td><input type="text" name="qq" id="qq" value="<?php echo ($list["qq"]); ?>" />
      <span></span>
      </td>
      </tr>
    <tr>
      <td>*</td>
      <td>邮箱</td>
      <td><input type="text" name="email" id="email" value="<?php echo ($list["email"]); ?>" />
      <span></span>
      </td>
      </tr>
      <tr>
      <td>*</td>
      <td>微博地址</td>
      <td><input type="text" name="wburl" id="wburl" value="<?php echo ($list["wburl"]); ?>" />
      <span></span>
      </td>
      </tr>
    <tr>
      <td>&nbsp;</td>
    <td>职业</td>
    <td><input type="text" name="job" id="job" value="<?php echo ($list["job"]); ?>" /></td>
    </tr>
     <tr>
       <td>&nbsp;</td>
    <td>毕业院校</td>
    <td><input type="text" name="graduated" id="graduated" value="<?php echo ($list["graduated"]); ?>" /></td>
    </tr>
     <tr>
       <td>&nbsp;</td>
    <td>工作经历</td>
    <td><textarea name="workRemark" id="workRemark" cols="35" rows="4"><?php echo ($list["workRemark"]); ?></textarea>
    <span>0/450</span></td>
    </tr>
     <tr>
       <td>&nbsp;</td>
    <td>婚姻状况</td>
    <td>
      <input type="radio" name="marital" id="marital0" value="0"/>
      <label for="marital0">保密</label>
      <input type="radio" name="marital" id="marital1" value="1" />
      <label for="marital1">已婚</label>
      <input type="radio" name="marital" id="marital2" value="2" />
      <label for="marital2">未婚</label>
    </td>
    </tr>
     <tr>
       <td>*</td>
    <td>礼物邮寄地址</td>
    <td><input type="text" name="address" id="address" value="<?php echo ($list["address"]); ?>" />
    <span></span></td>
    </tr>
     <tr>
    <td colspan="3" align="center"><input type="button" name="sub" id="sub" value="保存" />      <input type="reset" name="res" id="res" value="重置" /></td>
    </tr>
    <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    <td colspan="3">&nbsp;</td>
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