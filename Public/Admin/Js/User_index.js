window.parent.initCloud(window);
function init()
{
	$c.switcher('v',vHandler);
	$c.highLight();
	$('.tab_list tr').click($c.checkboxClickHandler);
	$c.selectAllHandler();
	$c.selectInvertHandler();
	$c.deleteHandler(_delete);
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
}
function vHandler(data)
{
	if(data.id)
	{
		var newData={id:data.id,rna:data.val};
		$.post(_URL+'/update',newData,switcherHandler);
	}
}


function switcherHandler(data)
{
	if(!data['status'])
	{
		$c.error(data['info']);
	}
	location.reload();
}

function _onAndOff(type)
{
	var arr=$c.getCheckedIds();
	if(arr.length<=0)
	{
		$c.error('没有选中的记录');
		return;
	}
	var data=new Object();
	data['list']=new Array();
	for(var i=0;i<arr.length;i++)
	{
		data['list'].push({id:arr[i],audit:type});
	}
	$.post(_URL+'/update',data,switcherHandler);
}

//删除
function _delete()
{
	var arr=$c.getCheckedIds();
	if(arr.length<=0)
	{
		$c.error('没有选中的记录');
		return;
	}
	var data=new Object();
	data['ids']=arr;
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