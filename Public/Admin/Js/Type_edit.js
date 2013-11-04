window.parent.initCloud(window);
function init()
{
	$c.switcher('display',displayHandler);
	$c.enterHandler(null,function()
	{
		$('form1').submit();
	});
}

function displayHandler(data)
{
	$('#display').val(data.val);
}