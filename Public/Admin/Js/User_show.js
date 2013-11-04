window.parent.initCloud(window);
function init()
{
	$c.switcher('v',vHandler);
	$c.highLight('.tab_edit tr');
	$('#noRna').click(noRnaHandler);
	$('#resetPassword').click(resetPasswordHandler);
}

function noRnaHandler(e)
{
	var id=$(e.currentTarget).attr('sid');
	var newData={id:id,lineup:0};
	$.post(_URL+'/update',newData,switcherHandler);
}

function resetPasswordHandler(e)
{
	var id=$(e.currentTarget).attr('sid');
	var newData={id:id};
	$.post(_URL+'/resetPassword',newData,function(data)
	{
		if(!data['status'])
		{
			$c.error(data['info']);
		}
		else
		{
			$('#newPassword').text('【新密码为：'+data['info']+"（区分大小写）】")
			$c.success("重置成功");
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

function openWindow(url)
{
	$c.p_$layer({
		type: 2,
		title: "查看",
		fix: false,
		closeBtn:[0,true],
		shadeClose: true,
		shade: [0.1,'#fff', true],
		border : [5, 0.3, '#666', true],
		offset: ['100px',''],
		area: ['1000px','500px'],
		iframe: {src: url}
	});
}