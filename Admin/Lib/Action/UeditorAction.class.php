<?php
import('ORG.Ueditor.UeditorHandler');
class UeditorAction extends CommonAction
{
	//图片上传
	public function imageUp()
	{
		$up=new UeditorHandler();
		$up->savePath=getUserDir('Images');
		$up->imageUp();
	}
	
	//在线管理
	public function imageManager()
	{
		$up=new UeditorHandler();
		$up->managerPath=array(getUserDir('Images'));
		$up->imageManager();
	}
	
	//上传涂鸦
	public function scrawlUp()
	{
		$up=new UeditorHandler();
		$up->savePath=getUserDir('Images');
		$up->scrawlUp();
	}
	
	//附件上传
	public function fileUp()
	{
		$up=new UeditorHandler();
		$up->savePath=getUserDir('Files');
		$up->allowExts=array('zip','rar','txt','pdf','mp3','wmv','jpg','jpeg','png','bmp','gif','png','doc','docx','wav','flv','xls','xlsx');
		$up->fileUp();
	}
	
	//远程图片抓取
	public function getRemoteImage()
	{
		$up=new UeditorHandler();
		$up->savePath=getUserDir('Images');
		$up->getRemoteImage();
	}
	
	//获取视频地址
	public function getMovie()
	{
		$key =htmlspecialchars($_POST["searchKey"]);
		$type = htmlspecialchars($_POST["videoType"]);
		$html = file_get_contents('http://api.tudou.com/v3/gw?method=item.search&appKey=myKey&format=json&kw='.$key.'&pageNo=1&pageSize=20&channelId='.$type.'&inDays=7&media=v&sort=s');
		echo $html;
	}
}