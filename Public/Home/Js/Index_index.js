var hh=0;
var ww=0;

$(window).ready(function(e) {
    update();
	$(window).resize(update);
});

function update()
{
	hh=$(window).height();
	ww=$(window).width();
	var tmp=(hh-$('#main').height())/2;
	if(tmp>0)
	{
		$('#main').css({'margin-top':tmp});
	}
}