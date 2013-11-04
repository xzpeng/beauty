var verifySrc=null;

$(window).ready(function(e) {
	if($('#login_btn'))
	{
		$('#login_btn').click(loginHandler);
		$('#login_close').click(loginCloseHandler);
		$('.verifyImg').click(updateVerify);
	}
	if($('#search_text'))
	{
		$('#search_text').focus(searchFocusHandler);
		$('#search_text').blur(searchBlurHandler);
		$('#search_btn').click(searchFocusHandler);
		searchBlurHandler();
	}
});

function searchFocusHandler()
{
	if($('#search_text').val()=="站内搜索")
	{
		$('#search_text').val("");
		$('#search_text').removeClass("search_text_default");
	}
}

function searchBlurHandler()
{
	if(!Boolean($('#search_text').val()))
	{
		$('#search_text').val("站内搜索");
		$('#search_text').addClass("search_text_default");
	}
}



function loginHandler()
{
	var hh=$(window).height();
	var ww=$(window).width();
	var left=(ww-$('#loginBox').width())/2;
	var top=(hh-$('#loginBox').height())/2;
	updateVerify();
	$('#loginBox').css({'display':'block'});
	$('#loginBg').css({'display':'block'});
	if(left>0)
	{
		$('#loginBox').css({'left':left});
		$('#loginBg').css({'left':left});
	}
	
	if(top>0)
	{
		$('#loginBox').css({'top':top});
		$('#loginBg').css({'top':top});
	}
	
}

function loginCloseHandler()
{
	$('#loginBox').css({'display':'none'});
	$('#loginBg').css({'display':'none'});
}

function updateVerify()
{
	if(!verifySrc)
	{
		verifySrc=$('.verifyImg').prop('src');
	}
	$('.verifyImg').prop('src',verifySrc+"?"+Math.round(Math.random()*100000));
}