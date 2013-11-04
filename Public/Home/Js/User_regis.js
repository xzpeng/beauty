var ww=0;
var hh=0;
var top=0;
var left=0;
var error=['userName','password','password2','sex0','ddlYear','edu','name','selProvince','mphone','qq','email','address','wburl'];
var remark='';

$(window).ready(function(e) {
	regis.reset();
    BindDateTime("ddlYear","ddlMonth","ddlDay");
	var d=new Date();
    BindDateValue(["ddlYear","ddlMonth","ddlDay"],[d.getFullYear(),d.getMonth()+1,d.getDate()]);
	$ling.chinaArea.init("selProvince", "selCity", "selDistrict");
	$(window).resize(update);
	$('#sub').click(submitClick);
	update();
	init();
});

function submitClick()
{
	if(error.length>0)
	{
		$('#'+error[0]).focus();
	}
	else
	{
		if($('#agree').prop('checked'))
		{
			$('#regis').submit();
		}
		else
		{
			if(confirm('是否已阅读并同意相关服务条款？'))
			{
				$('#regis').submit();
			}
		}
	}
}

function update()
{
	ww=$(window).width();
	hh=$(window).height();
	top=(hh-600)/2;
	left=(ww-600)/2;
	var tmp=(hh-722)/2;
	if(tmp>0)
	{
		$('#main').css({'margin-top':tmp});
	}
}

function init()
{
	//用户名
	$('#userName').focus(userNameFocus);
	$('#userName').blur(userNameBlur);
	
	//昵称
	$('#nickName').focus(function()
	{
		span('#nickName').text('60位字符以内（中文字符占3位）');
	});
	$('#nickName').blur(function()
	{
		addError('nickName');
		var val=$('#nickName').val();
		if(charNum('#nickName')>60)
		{
			setSpan('nickName','昵称不能大于60位字符','error');
			return;
		}
		removeError('nickName');
		setSpan('nickName','','');
	});
	
	//密码
	$('#password').focus(
	function ()
	{
		span('#password').text('6-16位字符，且不能由纯数字组成');
	}
	);
	$('#password').blur(
	function ()
	{
		addError('password');
		var val=$('#password').val();
		if(charNum('#password')>16)
		{
			setSpan('password','密码不能大于16位','error');
			return;
		}
		if(charNum('#password')<6)
		{
			setSpan('password','密码不能小于6位','error');
			return;
		}
		if(checkAllNum(val))
		{
			setSpan('password','密码不能由纯数字组成','error');
			return;
		}
		removeError('password');
		setSpan('password','','');
	}
	);
	//确认密码
	$('#password2').blur(
	function ()
	{
		addError('password2');
		if($('#password2').val()!=$('#password').val())
		{
			setSpan('password2','两次输入密码不一致','error');
			return;
		}
		removeError('password2');
		setSpan('password2','','');
	}
	);
	
	//身高
	$('#height').focus(
	function ()
	{
		span('#height').text('cm');
	}
	);
	$('#height').blur(function()
	{
		addError('height');
		var val=$('#height').val();
		var tmp=parseInt(val);
		if(String(tmp)=="NaN")
		{
			tmp=0;
		}
		if(tmp>400)
		{
			setSpan('height','输入值不合法','error');
			return;
		}
		removeError('height');
		$('#height').val(tmp);
		setSpan('height','','');
	}
	);
	
	//体重
	$('#weight').focus(
	function ()
	{
		span('#weight').text('kg');
	}
	);
	$('#weight').blur(function()
	{
		addError('weight');
		var val=$('#weight').val();
		var tmp=parseInt(val);
		if(String(tmp)=="NaN")
		{
			tmp=0;
		}
		if(tmp>500)
		{
			setSpan('weight','输入值不合法','error');
			return;
		}
		removeError('weight');
		$('#weight').val(tmp);
		setSpan('weight','','');
	}
	);
	
	//三围
	$('#measure1').focus(
	function ()
	{
		span('#measure1').text('cm');
	}
	);
	$('#measure1').blur(function()
	{
		setSpan('measure1','','');
	}
	);
	
	//三围
	$('#measure2').focus(
	function ()
	{
		span('#measure2').text('cm');
	}
	);
	$('#measure2').blur(function()
	{
		setSpan('measure2','','');
	}
	);
	//三围
	$('#measure3').focus(
	function ()
	{
		span('#measure3').text('cm');
	}
	);
	$('#measure3').blur(function()
	{
		setSpan('measure3','','');
	}
	);
	
	//性别
	$('#sex0,#sex1,#sex2').focus(function ()
	{
		span('#sex0').text('请选择性别');
	});
	$('#sex0,#sex1,#sex2').change(function()
	{
		setSpan('sex0','','');
		removeError('sex0');
	}
	);
	
	//出生日期
	$('#ddlYear,#ddlMonth,#ddlDay').focus(function ()
	{
		span('#ddlYear').text('请选择具体日期');
	});
	$('#ddlYear,#ddlMonth,#ddlDay').blur(function()
	{
		var tmp=getTimestamp($('#ddlMonth').val()+' '+$('#ddlDay').val()+','+$('#ddlYear').val())/1000;
		$('#birthday').val(tmp);
		setSpan('ddlYear','','');
		removeError('ddlYear');
	})
	
	//学历
	$('#edu').focus(function()
	{
		span('#edu').text('请选择学历');
	});
	$('#edu').change(function()
	{
		setSpan('edu','','');
		removeError('edu');
	});
	
	//真实姓名
	$('#name').focus(function()
	{
		span('#name').text('用于实名认证，请如实填写中文姓名');
	});
	$('#name').blur(function()
	{
		addError('name');
		var val=$('#name').val();
		if(!isAllChinese(val))
		{
			setSpan('name','请输入中文姓名','error');
			return;
		}
		if(val.length<2||val.length>6)
		{
			setSpan('name','姓名长度为2-6位汉字','error');
			return;
		}
		setSpan('name','','');
		removeError('name');
	});
	
	//地区
	$('#selProvince,#selCity,#selDistrict').focus(function()
	{
		span('#selProvince').text('请选择您的所在地区');
	});
	$('#selProvince,#selCity,#selDistrict').change(function()
	{
		var zip=$('#selDistrict').val();
		var num=zip.substring(0,zip.indexOf('|'));
		$('#zip').val(num);
		var p=getAreaName($('#selProvince').val());
		var c=getAreaName($('#selCity').val());
		var d=getAreaName($('#selDistrict').val());
		$('#area').val(p+'|'+c+'|'+d);
		setSpan('selProvince','','');
		removeError('selProvince');
	});
	
	//邮编
	$('#zip').blur(function()
	{
		addError('zip');
		var val=$('#zip').val();
		if((!isAllNumber(val)||val.length!=6)&&val)
		{
			setSpan('zip','输入值不合法','error');
			return;
		}
		
		setSpan('zip','','');
		removeError('zip');
	});
	
	$('#mphone').focus(function()
	{
		span('#mphone').text('用于唯一性认证，请如实填写');
	});
	$('#mphone').blur(function()
	{
		addError('mphone');
		var val=$('#mphone').val();
		if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(val)))
		{
			setSpan('mphone','输入值不合法','error');
			return;
		}
		setSpan('mphone','','');
		removeError('mphone');
	});
	
	//qq
	$('#qq').focus(function()
	{
		span('#qq').text('用于在线联系，请如实填写');
	});
	$('#qq').blur(function()
	{
		addError('qq');
		var val=$('#qq').val();
		if(!(/^\s*[.0-9]{5,10}\s*$/.test(val)))
		{
			setSpan('qq','输入值不合法','error');
			return;
		}
		setSpan('qq','','');
		removeError('qq');
	});
	
	//email
	$('#email').focus(function()
	{
		span('#email').text('用于唯一性认证，请如实填写');
	});
	$('#email').blur(function()
	{
		addError('email');
		var val=$('#email').val();
		if(!(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/.test(val)))
		{
			setSpan('email','输入值不合法','error');
			return;
		}
		setSpan('email','','');
		removeError('email');
	});
	
	//wb
	$('#wburl').focus(function()
	{
		span('#wburl').text('用于在线展示，请如实填写');
	});
	$('#wburl').blur(function()
	{
		addError('wburl');
		var val=$('#wburl').val();
		if(!Boolean(val))
		{
			setSpan('wburl','输入值不能为空','error');
			return;
		}
		setSpan('wburl','','');
		removeError('wburl');
	});
	
	//工作经历
	$('#workRemark').keyup(function()
	{
		var tmp=charNum('#workRemark');
		if(tmp>450)
		{
			$('#workRemark').val(remark);
			return;
		}
		span('#workRemark').text(tmp+'/450');
		remark=$('#workRemark').val();
	})
	
	//地址
	$('#address').focus(function()
	{
		span('#address').text('请详细填写乡镇街道地址');
	});
	$('#address').blur(function()
	{
		addError('address');
		var val=$('#address').val();
		if(charNum('#address')<10||isAllNumber(val))
		{
			setSpan('address','请详细描述您的地址','error');
			return;
		}
		setSpan('address','','');
		removeError('address');
	});
}

//检查格式
function checkFormat(str,arr)
{
	var gs=str.substring(str.lastIndexOf('.')+1,str.length);
	if(arr.indexOf(gs)>-1)
	{
		return true;
	}
	return false;
}

function userNameFocus()
{
	span('#userName').text('9-30位字符（中文字符占3位）');
}

function userNameBlur()
{	
	addError('userName');
	if(charNum('#userName')>30)
	{
		setSpan('userName','用户名不能大于30位','error');
		return;
	}
	if(charNum('#userName')<9)
	{
		setSpan('userName','用户名不能小于9位','error');
		return;
	}
	removeError('userName');
	setSpan('userName','正在检测可用性...','');
	if(!$('#nickName').val())
	{
		$('#nickName').val($('#userName').val());
	}
	var name=$('#userName').val();
	var data=new Object();
	data["userName"]=name;
	$.post(URL+'/checkUserName',data,checkUserName);
}

function checkUserName(data)
{
	if(data.status)
	{
		removeError('userName');
		setSpan('userName','可用','');
	}
	else
	{
		addError('userName');
		setSpan('userName','用户名已经存在，请重新更换一个用户名','');
	}
}

//全部是数字
function isAllNumber(str)
{
	if(str.length<=0)
	{
		return false;
	}
	var nums=['1','2','3','4','5','6','7','8','9','0'];
	for(var i=0;i<str.length;i++)
	{
		if(nums.indexOf(str[i])==-1)
		{
			return false;
		}
	}
	return true;
}

//获取地区名
function getAreaName(str)
{
	var index=str.lastIndexOf('|');
	var name=str.substr(index+1,str.length);
	return name;
}

function setSpan(str,mesg,css)
{
	var obj=span('#'+str);
	obj.prop('className',css);
	obj.text(mesg);
}

function charNum(str)
{
	var chars=$(str).val();
	var num=0;
	for(var i=0;i<chars.length;i++)
	{
		if(isChinese(chars[i]))
		{
			num+=3;
		}
		else
		{
			num++;
		}
	}
	return num;
}

function checkAllNum(str)
{
	return str.match(/\D/)==null;
}  

function isNull(str)
{
	if($(str).val().length==0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function isAllChinese(str)
{
	if(str.length==0)
	{
		return false;
	}
	var ts=['~','@','#','￥','%','……','&','*','（','）','——','+','	',' ','|','：','；','”','‘','《','》','，','。','\\','/','？'];
    for(var i=0;i<str.length;i++)
	{
		if(isChinese(str[i]))
		{
			if(ts.indexOf(str[i])>-1)
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	return true;
}

//是否有汉字
function isChinese(str) 
{
	if(str.length == 0)
	{
		return false;
	}
	for(var i = 0; i < str.length; i++)
	{
		if(str.charCodeAt(i) > 128)
		{
			return true;
		}
	}
	return false;
}

function span(str)
{
	return $(str).parent('td').children('span');
}

function openClause(url)
{
	window.open (url, 'newwindow', 'height=600, width=600, top='+top+', left='+left+', toolbar=no, menubar=no, scrollbars=yes, resizable=yes,location=yes, status=no');
}

function removeError(str)
{
	var tmp=error.indexOf(str);
	if(tmp>-1)
	{
		error.splice(tmp,1);
	}
}

function addError(str)
{
	var tmp=error.indexOf(str);
	if(tmp==-1)
	{
		error.push(str);
	}
}

function getTimestamp(d)
{
	var s = Date.parse(d);
	return s;
}

