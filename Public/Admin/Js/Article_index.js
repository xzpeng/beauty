window.parent.initCloud(window);
function init()
{
	setType(typeInfo,0);
	$c.switcher('display',displayHandler);
	$c.switcher('recommend',recommendHandler);
	$c.highLight();
	$c.selectAllHandler();
	$c.selectInvertHandler();
	$c.deleteHandler(_delete);
	$('.tab_list tr').click($c.checkboxClickHandler);
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

function displayHandler(data)
{
	if(data.id)
	{
		var newDate={id:data.id,display:data.val};
		$.post(_URL+'/update',newDate,switcherHandler);
	}
}

function recommendHandler(data)
{
	if(data.id)
	{
		var newDate={id:data.id,recommend:data.val};
		$.post(_URL+'/update',newDate,switcherHandler);
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

//设置分类信息
function setType(tf,typeLayer)
{
	typeLayer++;
	for(var i=0;i<tf.length;i++)
	{
		var sel='';
		if(tf[i]['selected'])
		{
			sel=' selected';
		}
		var str='<option value="'+tf[i]["id"]+'"'+sel+'>'+getPrefix(typeLayer)+"["+typeLayer+"级]"+":"+tf[i]["title"]+'</option>';
		$('#type').append(str);
		if(tf[i]['children'].length>0)
		{
			setType(tf[i]['children'],typeLayer);
		}
	}
}

function getPrefix(la)
{
	var p='';
	for(var i=1;i<la-1;i++)
	{
		p+='&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	if(la>1)
	{
		p+='|-->';
	}
	return p;
}