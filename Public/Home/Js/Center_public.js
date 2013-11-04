$(window).ready(function(e) {
    $('#uploadPic').click(uploadPicHandler);
});

function uploadPicHandler()
{
	//iframe层例二
	$.layer({
		type: 2,
		title: "上传头像",
		fix: false,
		closeBtn:[0,true],
		shadeClose: true,
		shade: [0.1,'#fff', true],
		border : [5, 0.3, '#666', true],
		offset: ['150px',''],
		area: ['700px','400px'],
		iframe: {src: _URL+"/uploadPic"},
		close:uploadPicClose
	});
}

function uploadPicClose()
{
	location.reload();
}