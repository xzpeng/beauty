var ww=0;
var hh=0;
var mw=285;
var rowsHeight=[];
var rows=0;
var pg=1;
var total=1;
var geting=false;
var ll=0;
var tt=0;

$(window).ready(function(e) {
    init();
});

function init()
{
	$(window).scrollTop(0);
	ww=$(document).width();
	hh=$(document).height();
	rows=Math.floor((ww-40)/(285+20));
	$('#main').css({'width':(285+20)*rows});
	var tmp=$('#main').width()-20;
	$('#banner2').css({width:tmp});
	$(window).scroll(scrollHandler);
	createRows();
	ll=($(window).width()-$('#mesg').width())/2;
	tt=$(window).height()-$('#mesg').height()-70;
	$('#mesg').click(function(){
		location.reload();
	});
	loadList();
}

//滚动加载
function scrollHandler(e)
{
	var tmp=tt+$(window).scrollTop();
	$('#mesg').css({left:ll,top:tmp});
	if($(window).scrollTop()>=rowsHeight[getMinHeight()]-$(window).height())
	{
		send();
	}
	else
	{
		$('#mesg').css({display:"none"});
	}
}

function send()
{
	if(!geting)
	{
		if(pg<total)
		{
			pg++;
			loadList();
			$('#mesg').css({display:"none"});
		}
		else
		{
			if(rowsHeight[getMinHeight()]>$(window).height())
			{
				addMesg("已经到底了，点击刷新");
			}
		}
	}
}

function addMesg(mesg)
{
	var obj=$('#mesg');
	obj.text(mesg);
	obj.css({display:"block"});
	obj.fadeIn(400);
}

function createRows()
{
	var main=$('#main');
	for(var i=0;i<rows;i++)
	{
		if(i==0)
		{
			rowsHeight[i]=$('#row0').height();
		}
		else
		{
			rowsHeight[i]=0;
			main.append('<div id="row'+i+'" class="rows"></div>');
		}
	}
}

function loadList()
{
	if(geting)
	{
		return;
	}
	var url=loadUrl;
	if(Boolean(typeId))
	{
		url=url+'/id/'+typeId;
	}
	if(Boolean(typePid))
	{
		url=url+'/pid/'+typePid;
	}
	url=url+'/pg/'+(pg);
	if(Boolean(keywords))
	{
		url=url+'/keywords/'+keywords;
	}
	geting=true;
	$.get(url,loadHandler);
}

function loadHandler(data)
{
	if(Boolean(data['status']))
	{
		pg=data['data']['pg'];
		total=data['data']['total'];
		addItem(data['data']['list']);
		if(rowsHeight[getMinHeight()]<$(window).height())
		{
			geting=false;
			send();
		}
	}
	else
	{
	}
	geting=false;
}

function addItem(data)
{
	for(var i=0;i<data.length;i++)
	{
		var index=getMinHeight();
		var obj=$('#row'+index);
		var href=URL+'/show/id/'+data[i]['id'];
		var target='';
		if(Boolean(data[i]['href']))
		{
			target='target="_blank"';
		}
		var img=imgUrl+data[i]['model']+'/'+data[i]['promulgator']+'/Images/thumb/258_'+data[i]['img'];
		imgheight=data[i]['img_height']*285/data[i]['img_width'];
		if(imgheight>500)
		{
			imgheight=500;
		}
		var idname=Math.floor((Math.random()*100000)+i);
		obj.append('<div class="items" id="item'+idname+'"><a href="'+href+'" '+target+'" style="height:'+imgheight+'px;" class="imgDiv"><img name="a" src="'+img+'" width="285" height="'+imgheight+'" alt="" /></a><a href="'+href+'" '+target+' class="titleDiv">'+data[i]['title']+'</a><span>浏览量'+data[i]['hits']+'人次</span></div>');
		$('#item'+idname).animate({opacity:1},400);
		rowsHeight[index]=obj.height();
	}
}

function getMinHeight()
{
	var minh=0;
	var first=true;
	var index=0;
	for(var i=0;i<rows;i++)
	{
		if(first)
		{
			minh=rowsHeight[i];
			first=false;
		}
		else
		{
			if(rowsHeight[i]<minh)
			{
				minh=rowsHeight[i];
				index=i;
			}
		}
	}
	return index;
}