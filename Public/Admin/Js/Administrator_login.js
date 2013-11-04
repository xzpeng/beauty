var ww=0;
var wh=0;
var verifySrc='';

$(window).ready(function(e) {
    init();
});

function init()
{
	//非子窗口登录跳转到最后一次操作
	var name=window['name'];
	var obj=new Object();
	var parent=window["parent"]?window["parent"]:obj;
	if(parent["childHref"]&&parent["childHref"][name])
	{
		$('#redirect').val(parent["childHref"][name]);
	}
	$(window).resize(update);
	$('#verifyBox').click(updateVerify);
	update();
}

function update()
{
	ww=window.screen.width;
	wh=$(window).height();
	var main=$('#main');
	main.css({'margin-top':(wh-main.height()-80)/2});
}

function updateVerify()
{
	if(!verifySrc)
	{
		verifySrc=$('.verifyImg').prop('src');
	}
	$('.verifyImg').prop('src',verifySrc+"?"+Math.round(Math.random()*100000));
}
	
