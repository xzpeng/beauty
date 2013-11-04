var editor=null;
var edw=0;
$(window).ready(function(e) {
   edw=$('#content_center').width();
	setType(typeInfo,0);
	ueditorInit();
	$('#sub').click(function(e){
		editor.sync('form1');
		$('#form1').submit();
	});
	$('#href').focus(function(){
		$('#contentArea').hide();
	});
	$('#href').blur(function(e){
		if(!$(e.currentTarget).val())
		{
			$('#contentArea').show();
		}
	});
});

//编辑器初始化
function ueditorInit()
{
	window.UEDITOR_HOME_URL=_PUBLIC+"/Ueditor/";
	var options = {
		initialFrameWidth:(edw-100),        //初化宽度
		initialFrameHeight:400,        //初化高度
		focus:false,                        //初始化时，是否让编辑器获得焦点true或false
		maximumWords:10000,        //允许的最大字符数
	};
	editor = new UE.ui.Editor(options);
	editor.render("contentedit");
	editor.ready(function(){
		//编辑器初始化完成
	})
	$('#hideArea').css({width:edw-100});
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