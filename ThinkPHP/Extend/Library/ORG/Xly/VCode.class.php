<?php
class VCode 
{
	public  $vcode=null;//验证码
	private $img=null;//验证码图片
	private $width=130;//宽度
	private $height=35;//高度
	private $count=4;//个数
	private $bgimg=null;//背景图片
	private $type="gif";//返回的图片格式gif jpg png
	private $str=2;//字符串组合类型  0纯数字   1纯字母  2混合
	private $fontfiles=array('./Public/Font/comicbd.ttf','./Public/Font/FRAMDCN.TTF','./Public/Font/arialbd.ttf');//字体
	private $code="0123456789qwertyuipasdfghjkzxcvbnmQWERTYUIPASDFGHJKLZXCVBNM";//随机码(近似的已删除)
	private $pmarr=array("width","height","count","bgimg","type","str");
	private $rgb=array();//随机颜色

	//构造方法
	function __construct($arr=null){
		$this->setpm($arr);//设置参数
	}

	//获取验证码图片
	function getImg($arr=null){
		$this->setpm($arr);//设置参数
		$this->makeCode();//生成验证码
		$this->randColor();//随机色
		$this->createImg();//创建背景
		$this->createObstruct1();//设置干扰元素
		$this->createCode();//生成验证码
		$this->createObstruct2();//设置干扰元素
		$this->outputImg();//输出图像并销毁
	}
	

	//设置参数
	private function setpm($arr){
		if(empty($arr)){
			return false;
		}
		foreach ($arr as $key=>$val){
			$key=strtolower($key);
			if(in_array($key,$this->pmarr)){
				$this->$key=$val;
			}
		}
	}

	//step1创建图像背景
	private function createImg(){
		$bgimg=null;
		$this->img=imagecreatetruecolor($this->width, $this->height);
		$s=$this->rgb[0];//随机开始
		$e=$this->rgb[1];//随机结束
		$bgcolor=imagecolorallocate($this->img,rand($s,$e),rand($s,$e),rand($s,$e));
		imagefill($this->img, 0, 0, $bgcolor);
		//判断是否有背景图片
		if($this->bgimg){
			$bgimgname=$this->bgimg;
			$arr=getimagesize($bgimgname);
			$width=$arr[0];
			$height=$arr[1];
			$str=$arr[2];
			switch ($str){
				case 1:$bgimg=imagecreatefromgif($bgimgname);break;
				case 2:$bgimg=imagecreatefromjpeg($bgimgname);break;
				case 3:$bgimg=imagecreatefrompng($bgimgname);break;
			}
			imagecopy($this->img,$bgimg,0,0,0,0,$this->width,$this->height);//拷贝图像
			imagedestroy($bgimg);
		}
	}

	//step2,绘制干扰元素
	private function createObstruct1(){
		$a=$this->width*$this->height/15;//每15平方像素一个干扰点
		for($i=0;$i<$a;$i++){
			$color1=imagecolorclosest($this->img, rand(0,255), rand(0,255), rand(0,255));
			imagesetpixel($this->img, rand(0,$this->width), rand(0,$this->height), $color1);
		}
	}

	private function createObstruct2(){
		$b=round($this->width*$this->height/500);//每400平方像素一个干扰弧线
		for($i=0;$i<$b;$i++){
			$color2=imagecolorclosest($this->img, rand(0,255), rand(0,255), rand(0,255));
			imagearc($this->img, rand(0,$this->width),rand(0,$this->height), rand(0,$this->width),rand(0,$this->height), rand(0,360), rand(0,360), $color2);
		}
	}

	//step3生成图像码
	private function createCode(){
		$mins=round($this->height*0.65);
		$maxs=round($this->height*0.85);
		$fontsize=array();
		$sums=0;
		for($i=0;$i<strlen($this->vcode);$i++){
			$fontsize[$i]=rand($mins,$maxs);
			$sums+=$fontsize[$i];
		}
		$s=$this->rgb[2];//随机开始
		$e=$this->rgb[3];//随机结束
		$baseX=($this->width-$sums)/2;
		for($i=0;$i<strlen($this->vcode);$i++){
			$color=imagecolorallocate($this->img,rand($s,$e),rand($s,$e),rand($s,$e));
			$tf=round(rand(0,2));
			imagettftext($this->img,$fontsize[$i], rand(-20,20),$baseX,($this->height/2)+($fontsize[$i]/2), $color, $this->fontfiles[$tf],$this->vcode{$i});
			$baseX+=$fontsize[$i];
		}
	}

	//生成验证码
	private function makeCode(){
		switch ($this->str){
			case 0:$s=0;$e=9;break;
			case 1:$s=10;$e=58;break;
			case 2:$s=0;$e=58;break;
		}
		for($i=0;$i<$this->count;$i++){
			$this->vcode.=$this->code[rand($s, $e)];
		}
	}

	//随机颜色,背景为深色则字为浅色否则相反
	private function randColor(){
		$m=rand(0,1);
		if($m==0){
			$this->rgb[0]=0;
			$this->rgb[1]=100;
			$this->rgb[2]=200;
			$this->rgb[3]=255;
		}else{
			$this->rgb[0]=200;
			$this->rgb[1]=255;
			$this->rgb[2]=0;
			$this->rgb[3]=100;
		}

	}

	//输出图像
	private function outputImg(){
		session('verify',md5(strtoupper($this->vcode)));//不区分大小写
		$t=strtolower($this->type);
		switch ($t){
			case "gif":
				header("Content-Type:image/gif");
				imagegif($this->img);
				break;
			case "jpg" || "jpeg":
				header("Content-Type:image/jpeg");
				imagejpeg($this->img);
				break;
			case "png":
				header("Content-Type:image/png");
				imagepng($this->img);
				break;
		}
		imagedestroy($this->img);//销毁图像资源
	}







}//class-end