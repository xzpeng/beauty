<?php
class PublicAction extends Action
{
	public function verify()
	{
		//系统自带类
		import('ORG.Util.Image');
		Image::buildImageVerify(4,1,'png',90,28,'verify');
		//import('ORG.Xly.VCode');
		//$vcode=new VCode(array("width"=>90,"height"=>28));
		//$vcode->getImg();
	}
}