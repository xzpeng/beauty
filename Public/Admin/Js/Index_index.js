var ww=0;
var wh=0;
var menuDisplay=true;
var topDisplay=true;
var leftWidth=231;
var topHeight=50;
var taskTitle=['',''];
var childPageHeigth=0;
var childWindow=null;//子窗口
var childHref=null;//子窗口地址
var onOffHandler=null;//on off处理
var selectAllHandler=null;//全选处理
var selectInvertHandler=null;//反选处理
var recommendHandler=null;//推荐处理
var deleteHandler=null;//删除处理

$(window).ready(function(e) {
    init()
});

//子页面初始化云文件
function initCloud(window)
{
	var window=window;
	cloudJquery(window);//为子窗口添加jquery库
	window.$c=new cloud(window);//为子窗口添加cloud方法
	//执行子页面初始化
	window.$(window).ready(function(e) {
        if(window.init)
		{
			initParent();
			window.init(e);
		}
    });
}

function initParent()
{
	cancelSelect();
}

//初始化
function init()
{
	childWindow=new Object();
	childHref=new Object();
	var windowList=$('iframe');
	for(var i=0;i<windowList.length;i++)
	{
		var name=$(windowList[i]).prop('name');
		childWindow[name]=document.getElementsByName(name)[0].contentWindow;
	}
	update();
	reg();
}

//注册事件
function reg()
{
	$("#menuDisplay").click(menuDisplayHandler);
	$('a[downList]').click(downListHandler);
	$('#left a').click(alinkHandler);
	$(window).resize(update);
	$('#selectAll,#selectInvert,#delete,#on,#off,#recommend').click(childHandler);
	$('#refresh').click(refreshHandler);
	$('#back').click(backHandler);
	$('#hideTop').click(hideTopHandler);
}

//更新
function update()
{
	ww=window.screen.availWidth;
	wh=$(window).height();
	setCss();
}

function setCss()
{
	var left=$('#left');
	var main=$('#main');
	left.css
	({
		"max-height":wh-35-topHeight,//窗口高度35 导航高度 5下边距 1下边框
		"height":wh-35-topHeight
	});
	
	main.css
	({
		"width":ww,//窗口宽度
	});
	
	setChildPageCss();
}

function setChildPageCss()
{
	var childPage=$('#childPage');
	var lw=childPage.offset().left;
	childPageHeigth=wh-35-topHeight;//35导航高度
	childPage.css
	({
		"max-height":childPageHeigth,
		"height":childPageHeigth,
		"max-width":ww-leftWidth,//leftWidth左距 30左右边距
		"width":ww-leftWidth
	});
}

//子窗口处理
function childHandler(e)
{
	var type=$(e.currentTarget).prop('id');
	switch(type)
	{
		case 'selectAll':
		$('#selectInvert').prop('checked',false);
		if(selectAllHandler)
		{
			selectAllHandler(type,e);
		}
		break;
		
		case 'selectInvert':
		$('#selectAll').prop('checked',false);
		if(selectInvertHandler)
		{
			selectInvertHandler(type,e);
		}
		break;
		
		case 'delete':
		if(deleteHandler)
		{
			var index=layer.confirm("是否确认删除?删除后将不可撤销",function()
			{
				deleteHandler(type,e);
				layer.close(index);
			},'删除提示');
		}
		break;
		
		case 'off':
		if(onOffHandler)
		{
			onOffHandler(type,e);
		}
		break;
		
		case 'on':
		if(onOffHandler)
		{
			onOffHandler(type,e);
		}
		break;
		
		case 'recommend':
		if(recommendHandler)
		{
			recommendHandler(type,e);
		}
		break;
	}
}

//刷新子窗口
function refreshHandler()
{
	if(childWindow['childPage'])
	{
		childWindow['childPage'].location.reload();
	}
}

//返回上一步
function backHandler()
{
	if(childWindow['childPage'])
	{
		childWindow['childPage'].history.back();
	}
}

//隐藏顶部
function hideTopHandler()
{
	$("#top").slideToggle(400,hideTopComplete);
	var obj=$("#hideTop");
	if(topDisplay)
	{
		topHeight=0;
		topDisplay=false;
		obj.text("显示顶部");
	}
	else
	{
		topHeight=50;
		setCss();
		topDisplay=true;
		obj.text("隐藏顶部");
	}
}

function hideTopComplete()
{
	setCss();
}

//菜单显示
function menuDisplayHandler()
{
	$("#left").slideToggle(400,menuDisplayComplete);
	var obj=$("#menuDisplay");
	if(menuDisplay)
	{
		leftWidth=0;
		menuDisplay=false;
		obj.text("展开菜单");
	}
	else
	{
		leftWidth=231;
		setChildPageCss();
		menuDisplay=true;
		obj.text("收起菜单");
	}
	
}

//菜单动画完成
function menuDisplayComplete()
{
	setChildPageCss();
}

//下拉菜单
function downListHandler(e)
{
	var downId=$(e.currentTarget).attr('downList');
	$('#'+downId).slideToggle();
	var className=$(e.currentTarget).prop('className');
	if(className=="to_bottom")
	{
		$(e.currentTarget).prop('className','to_top')
	}
	else
	{
		$(e.currentTarget).prop('className','to_bottom')
	}
}

//链接点击处理
function alinkHandler(e)
{
	var str=$(e.currentTarget).parents('div').prop('className');
	if(str=="downlist")
	{
		taskTitle[1]=">"+$(e.currentTarget).text();
	}
	else
	{
		taskTitle[0]=$(e.currentTarget).text();
		taskTitle[1]='';
	}
	childHref["childPage"]=$(e.currentTarget).prop('href');
	setTaskTitle();
}

//设置任务标题
function setTaskTitle(str1,str2)
{
	if(str1)
	{
		taskTitle[0]=str1;
	}
	if(str2)
	{
		taskTitle[1]=str2;
	}
	$('#taskTitle').text("当前："+taskTitle[0]+taskTitle[1]);
}

//取消选择
function cancelSelect()
{
	$('#selectAll,#selectInvert').prop('checked',false);
}