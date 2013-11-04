$(window).ready(function(e) {
    $('.wjx').mouseover(wjxoverHandler);
	$('.wjx').mouseout(wjxoutHandler);
	$('.wjx').click(wjxclickHandler);
	var sl=$('#scoreDiv').offset().left;
	var st=$('#scoreDiv').offset().top;
	var sw=$('#scoreDiv').width();
	var sh=$('#scoreDiv').height();
	$('.scoreMask').css({'left':sl,'top':st,'height':sh});
	$('#login_btn2').click(loginHandler);
	light('stature',clickObj['stature']);
	light('face',clickObj['face']);
	light('liked',clickObj['liked']);
});

function wjxclickHandler(e)
{
	var tmp=$(e.currentTarget);
	var id=tmp.prop('id');
	var last=id.indexOf('_');
	var str=id.substr(0,last);
	var num=id.substr(last+1,id.length-1);
	var title=getStr(str);
	if(num!=clickObj[str])
	{
		var index=layer.confirm('是否确认'+title+'打'+num+'分？',function(){
			var data=new Object();
			data[str]=num;
			data['uid']=_UID;
			$.post(_URL+'/score',data,scoreHandler);
			layer.close(index);
		},'确认打分');
	}
}

function scoreHandler(data)
{
	if(!data['status'])
	{
		$.layer
		({
			area : ['auto','auto'],
			dialog : {msg:data['info'],type : 8},
			shadeClose : true,
			title:'错误提示'
		})
	}
	else
	{
		var tmp=data['data'];
		$('#stature_ave').text(tmp['stature_ave']);
		$('#face_ave').text(tmp['face_ave']);
		$('#liked_ave').text(tmp['liked_ave']);
		clickObj[tmp['str']]=tmp['num'];
		light(tmp['str'],tmp['num']);
	}
}

function wjxoverHandler(e)
{
	var tmp=$(e.currentTarget);
	var id=tmp.prop('id');
	var last=id.indexOf('_');
	var str=id.substr(0,last);
	var num=id.substr(last+1,id.length-1);
	light(str,num);
}

function wjxoutHandler(e)
{
	var tmp=$(e.currentTarget);
	var id=tmp.prop('id');
	var last=id.indexOf('_');
	var str=id.substr(0,last);
	light(str,clickObj[str]);
}

function light(str,num)
{
	for(var i=1;i<6;i++)
	{
		if(i<=num)
		{
			$('#'+str+'_'+i).addClass('wjxLight');
		}
		else
		{
			$('#'+str+'_'+i).removeClass('wjxLight');
		}
	}
}

function getStr(str)
{
	switch(str)
	{
		case 'stature':return '身材';break;
		case 'face':return '面容';break;
		case 'liked':return '喜欢程度';break;
	}
}