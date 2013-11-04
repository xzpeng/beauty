//初始化
function cloud(window)
{
	var window=window;
	var $=window.$;
	var tipIndex=0;
	
	//切换0,1值
	this.switcher=function switcher(target,handler)
	{
		function switcherInit(target,handler)
		{
			var target=target?target:'display';
			var handler=handler;
			$('.'+target+'_0,'+'.'+target+'_1').click(displayClick);
			//点击处理
			function displayClick(e)
			{
				var data={};
				data.eve=e;
				data.target=e.currentTarget;
				data.id=$(e.currentTarget).attr('sid');
				className=$(e.currentTarget).prop('className');
				val=className.substring(className.indexOf('_')+1,className.length);
				if(val=="1")
				{
					data.val='0';
				}
				
				if(val=="0")
				{
					data.val='1';
				}
				if(!data.id)
				{
					if(val=="1")
					{
						$(e.currentTarget).prop('className',target+'_0')
					}
					else if(val=="0")
					{
						$(e.currentTarget).prop('className',target+'_1')
					}
				}
				handler(data);
			}
		}//切换0,1值
		return new switcherInit(target,handler);
	}
	
	//父级窗口
	if(window.parent)
	{
		var parent=window.parent;
	}
	else
	{
		var parent=window;
	}
	var p_$layer=parent.$.layer;
	this.p_$layer=p_$layer;
	var p_layer=parent.layer;
	this.p_layer=p_layer;
	this.setTaskTitle=parent.setTaskTitle;
	this.cancelSelect=parent.cancelSelect;
	//父级窗口
	
	//为父级绑定各种处理方法
	this.deleteHandler=function(handler)
	{
		parent.deleteHandler=handler;
	}
	this.selectAllHandler=function(handler,selecter)
	{
		var selecter=selecter?selecter:'body';
		if(handler)
		{
			parent.selectAllHandler=handler;
		}
		else
		{
			//默认的全选处理方法
			parent.selectAllHandler=function(type,e)
			{
				$('input:checkbox',$(selecter)).prop('checked',$(e.currentTarget).prop('checked'));
			}
		}
	}
	this.selectInvertHandler=function(handler,selecter)
	{
		var selecter=selecter?selecter:'body';
		if(handler)
		{
			parent.selectInvertHandler=handler;
		}
		else
		{
			//默认的反选处理方法
			parent.selectInvertHandler=function(type,e)
			{
				var arr=$('input:checkbox',$(selecter));
				for(var i=0;i<arr.length;i++)
				{
					var ch=$(arr[i]).prop('checked');
					$(arr[i]).prop('checked',!ch)
				}
			}
		}
	}
	this.recommendHandler=function(handler)
	{
		parent.recommendHandler=handler;
	}
	this.onOffHandler=function(handler)
	{
		parent.onOffHandler=handler;
	}
	
	
	//错误提示
	this.error=function(mesg)
	{
		p_$layer
		({
			area : ['auto','auto'],
			dialog : {msg:mesg,type : 8},
			shadeClose : true,
			title:'错误提示'
		});
	}//错误提示
	
	//成功提示
	this.success=function(mesg)
	{
		p_$layer
		({
			area : ['auto','auto'],
			dialog : {msg:mesg,type : 9},
			title:false,
			shade : [0.5 , '#000' , false],
			time:2
		});
	}//成功提示
	
	//删除询问提示
	this.dAsk=function(yes,no,data)
	{
		var index=p_layer.confirm("是否确认删除?删除后将不可撤销",function()
		{
			if(yes)
			{
				yes(data);
			}
			p_layer.close(index);
		},'删除提示',function()
		{
			if(no)
			{
				no(data);
			}
			p_layer.close(index);
		});
	}//询问提示
	
	//获取选中的复选框
	this.getCheckedIds=function (selecter)
	{
		var selecter=selecter?selecter:'body';
		var arr=$('input:checkbox:checked',$(selecter));
		var ids=new Array();
		for(var i=0;i<arr.length;i++)
		{
			if($(arr[i]).attr('sid'))
			{
				ids.push($(arr[i]).attr('sid'));
			}
		}
		return ids;
	}//获取选中的复选框
	
	//高亮提示
	this.highLight=function (selecter,noeven)
	{
		function highLightInit(selecter,noeven)
		{
			var selecter=selecter?selecter:'.tab_list tr';
			var noeven=noeven;
			if(!noeven)
			{
				$(selecter+":even").addClass('deepBackground');
			}
			$(selecter).mouseover(function (e)
			{
				var obj=$(e.currentTarget);
				obj.addClass('overDeepBackground');
			});
			$(selecter).mouseout(function segOver(e){
				var obj=$(e.currentTarget);
				obj.removeClass('overDeepBackground');
			});
		}//高亮提示
		return new highLightInit(selecter,noeven);
	};
	
	
	//点击选择框处理
	this.checkboxClickHandler=function(e)
	{
		if($(e.target).prop('tagName')!='TD')
		{
			return;
		}
		var t=$('input:checkbox',e.currentTarget)
		if(t)
		{
			var r=t.prop('checked');
			t.prop('checked',!r);
		}
		//取消全选和反选框
		if(parent.cancelSelect)
		{
			parent.cancelSelect();
		}
	}
	
	//更新验证码图片
	this.updateVerify=function(selecter)
	{
		var verifySrc=null;
		function updateV(selecter)
		{
			$(selecter).click(function(e){
				if(!verifySrc)
				{
					verifySrc=$(e.currentTarget).prop('src');
				}
				$(e.currentTarget).prop('src',verifySrc+"?"+Math.round(Math.random()*100000));
			});
		}
		return new updateV(selecter);
	}
	
	//回车动作
	this.enterHandler=function(selecter,handler)
	{
		var selecter=selecter?selecter:'body';
		function enter(selecter,handler)
		{
			$(selecter).keydown(function(e){
				if(e.keyCode==13)
				{
					handler(e);
				}
			})
		}
		return new enter(selecter,handler);
	}
	
	//文字超出范围提示
	this.overflowAlt=function(selecter,num)
	{
		function overflowAltInit(selecter,num)
		{
			if(!selecter)
			{
				return;
			}
			var sor=$(selecter);
			if(sor.length>0)
			{
				for(var i=0;i<sor.length;i++)
				{
					check($(sor[i]));
				}
			}
			else
			{
					check(sor);
			}
			//检查字符数
			function check(jq)
			{
				var str=jq.text();
				if(str.length>num)
				{
					jq.attr('overflowAlt',str);
					str=str.substring(0,num);
					jq.text(str+'...');
					jq.hover(
					function()
					{
						tipIndex++;
						var left=$(this).offset().left;
						var top=$(this).offset().top-20;
						var hs='<div id="tip'+tipIndex+'" style="left:'+left+'px;top:'+top+'px;opacity:0.7;color:#FFF;background:#000;padding:0px 5px;line-height:20px;position:absolute;z-index:100;font-size:14px;">'+$(this).attr('overflowAlt')+'</div>'
						$('body').append(hs);
					},
					function()
					{
						$('#tip'+tipIndex).remove();
						tipIndex--;
					}
					);
				}
			}
		}
		return new overflowAltInit(selecter,num);
	}//文字超出范围提示
	
	
}