window.parent.initCloud(window);
function init()
{
	$c.switcher('display',displayHandler);
	$c.deleteHandler(_delete);
	$c.selectAllHandler();
	$c.selectInvertHandler();
	$c.onOffHandler(function(type){
		if(type=='on')
		{
			_onAndOff('1');
		}
		if(type=='off')
		{
			_onAndOff('0');
		}
		
	});
	$c.highLight();
	$('.tab_list tr').click($c.checkboxClickHandler);
	$c.enterHandler(null,function()
	{
		$('form1').submit();
	});
	$('#title').focus();
	$c.overflowAlt('#pathLink a',4);
	$c.overflowAlt('.index5',30);
}

function displayHandler(data)
{
	if(data.id)
	{
		var newDate={id:data.id,display:data.val};
		$.post(_URL+'/update',newDate,switcherHandler);
	}
	else
	{
		$('#display').val(data.val);
	}
}


function switcherHandler(data)
{
	if(!data['status'])
	{
		public.error(data['info']);
	}
	location.reload();
}

function _onAndOff(type)
{
	if($c.getCheckedIds().length<=0)
	{
		$c.error('没有选中的记录');
		return;
	}
	var arr=$c.getCheckedIds();
	var data=new Object();
	data['list']=new Array();
	for(var i=0;i<arr.length;i++)
	{
		data['list'].push({id:arr[i],display:type});
	}
	$.post(_URL+'/update',data,switcherHandler);
}

//删除
function _delete()
{
	if($c.getCheckedIds().length<=0)
	{
		$c.error('没有选中的记录');
		return;
	}
	var data=new Object();
	data['ids']=$c.getCheckedIds();
	$.post(_URL+'/delete',data,deleteHandler);
}

function deleteHandler(data)
{
	if(data['status'])
	{
		$c.success(data['info']);
	}
	else
	{
		$c.error(data['info']);
	}
	location.reload();
}