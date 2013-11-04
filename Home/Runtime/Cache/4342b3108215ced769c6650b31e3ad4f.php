<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>美人网--<?php echo ($pageTitle); ?></title>
<link href="__PUBLIC__/Home/Css/public.css" rel="stylesheet" type="text/css" />
<link href="__PUBLIC__/Home/Css/User_regis.css" rel="stylesheet" type="text/css" />
<script src="__PUBLIC__/Js/jquery-1.9.1.min.js"></script>
<script src="__PUBLIC__/Js/ling.chinaArea-1.0.js"></script>
<script src="__PUBLIC__/Js/dateSelect/JQSelect.js"></script>
<script src="__PUBLIC__/Js/dateSelect/SelectDate.js"></script>
<script>
var URL='__URL__';
</script>
<script src="__PUBLIC__/Home/Js/User_regis.js"></script>
</head>

<body>
<div id="main">
<div id="content">
<form action="__URL__/doRegis" method="post" name="regis" id="regis">
  <table>
    <tr>
      <td>*</td>
      <td>用户名</td>
      <td>
        <input type="text" name="userName" id="userName" />
        <span></span>
       </td>
      </tr>
       <tr>
      <td></td>
      <td>昵称</td>
      <td>
        <input type="text" name="nickName" id="nickName" />
        <span></span>
       </td>
      </tr>
      <tr>
        <td>*</td>
      <td>密码</td>
      <td>
        <input type="password" name="password" id="password" />
        <span></span>
        </td>
      </tr>
       <tr>
         <td>*</td>
      <td>确认密码</td>
      <td>
        <input type="password" name="password2" id="password2" />
         <span></span>
                </td>
      </tr>
    <tr>
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
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>身高</td>
      <td>
        <input type="text" name="height" id="height" />
        <span></span></td>
      </tr>
       <tr>
      <td>&nbsp;</td>
    <td>体重</td>
    <td><input type="text" name="weight" id="weight" />
    <span></span></td>
    </tr>
     <tr>
      <td>&nbsp;</td>
    <td>胸围</td>
    <td><input type="text" name="measure1" id="measure1" />
    <span></span></td>
    </tr>
     <tr>
      <td>&nbsp;</td>
    <td>腰围</td>
    <td><input type="text" name="measure2" id="measure2" />
    <span></span></td>
    </tr>
     <tr>
      <td>&nbsp;</td>
    <td>臀围</td>
    <td><input type="text" name="measure3" id="measure3" />
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
    <tr>
      <td>*</td>
      <td>真实姓名</td>
      <td><input type="text" name="name" id="name" />
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
      </tr>
      <tr>
        <td>&nbsp;</td>
      <td>邮编</td>
      <td><input name="zip" id="zip" type="text" />
      <span></span>
       </td>
      </tr>
    <tr>
      <td>*</td>
      <td>手机</td>
      <td><input type="text" name="mphone" id="mphone" />
      <span></span>
      </td>
      </tr>
    <tr>
      <td>*</td>
      <td>QQ</td>
      <td><input type="text" name="qq" id="qq" />
      <span></span>
      </td>
      </tr>
    <tr>
      <td>*</td>
      <td>邮箱</td>
      <td><input type="text" name="email" id="email" />
      <span></span>
      </td>
      </tr>
      <tr>
      <td>*</td>
      <td>微博地址</td>
      <td><input type="text" name="wburl" id="wburl" />
      <span></span>
      </td>
      </tr>
    <tr>
      <td>&nbsp;</td>
    <td>职业</td>
    <td><input type="text" name="job" id="job" /></td>
    </tr>
     <tr>
       <td>&nbsp;</td>
    <td>毕业院校</td>
    <td><input type="text" name="graduated" id="graduated" /></td>
    </tr>
     <tr>
       <td>&nbsp;</td>
    <td>工作经历</td>
    <td><textarea name="workRemark" id="workRemark" cols="35" rows="4"></textarea>
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
    <td><input type="text" name="address" id="address" />
    <span></span></td>
    </tr>
     <tr>
    <td colspan="3" align="center"><input name="agree" id="agree" type="checkbox" value="" />
      &nbsp;&nbsp;我已阅读并同意<a href="" onclick='openClause("clause.html")'>相关服务条款</a></td>
    </tr>
     <tr>
    <td colspan="3" align="center"><input type="button" name="sub" id="sub" value="提交审核" />      <input type="reset" name="res" id="res" value="重置" /></td>
    </tr>
    <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
  </table>
</form>
</div>
</div>
</body>
</html>