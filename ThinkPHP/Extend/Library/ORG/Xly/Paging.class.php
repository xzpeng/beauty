<?php
class Paging{
	public $total;//总记录数
	public $displayrows;//显示数，limit的第二个参数
	public $start;//limit的第一个参数
	public $pagecount;//页面总数
	public $pagenum;//当前页编号
	public $listhome;//当前记录开始位置
	public $listend;//当前记录结束位置
	public $pg='pg';//GET标示符
	public $rollNum=10;//每栏显示链接个数
	public $config=array("first"=>"首页","prev"=>"上一页","list"=>"...","next"=>"下一页","last"=>"尾页");
	public $numstyle=1;//分页列表文字样式
	private $uri;//当前请求
	
	function __construct($total,$displayrows)
	{
		$this->total=$total;
		$this->displayrows=$displayrows;
		$this->pagenum=!empty($_GET[$this->pg]) ? $_GET[$this->pg] : 1;
		$this->uri=$this->getUri();
		$this->pagecount=ceil($total/$displayrows);
		$this->start=($this->pagenum-1)*$this->displayrows;
		$this->listhome=($this->pagenum-1)*$this->displayrows+1;
		$this->listend=min($this->pagenum*$this->displayrows,$total);
	}
	
	//获取请求地址,需要基于ThinkPHP的URL模式处理
	private function getUrl($val)
	{
		return __ACTION__.'/'.$this->pg.'/'.$val.$this->uri;
	}
	
	//获取请求附加参数
	private function getUri()
	{
		$uri=str_replace(__ACTION__,'', __SELF__);
		$uri=preg_replace('/\/'.$this->pg.'\/\d+/','', $uri);
		return $uri;
	}
	
	//返回一个显示数组
	public function show($config=null,$easy="条记录")
	{
		if($easy)
		{
			return '<span class="totalPage">'.$this->total.$easy.'</span><span class="countPage">'.$this->pagenum.'/'.$this->pagecount.'</span>'.$this->getnav($config);
		}
		$tmp['nav']=$this->getnav($config);
		$tmp['count']=$this->pagecount;
		$tmp['current']=$this->pagenum;
		$tmp['total']=$this->total;
		$tmp['home']=$this->listhome;
		$tmp['end']=$this->listend;
		return $tmp;
	}
	
	//获取分页导航
	public function getnav($navs=null)
	{
		$navs=$navs?$navs:$this->config;
		$navstr='';//导航HTML字符串
		if(is_array($navs))
		{
			//遍历导航项目
			foreach($navs as $key=>$val)
			{
				switch($key)
				{
					case "first": $navstr.=$this->linkfirst($val); break;
					case "prev": $navstr.=$this->linkprev($val); break;
					case "list": $navstr.=$this->linklist($val); break;
					case "next": $navstr.=$this->linknext($val); break;
					case "last": $navstr.=$this->linklast($val); break;
					default:$navstr.=$val; break;
				}//switch-end
			}//foreach-end
			return $navstr;
		}//if-end
	}
	
	//首页链接
	private function linkfirst($val)
	{
		if($this->pagenum==1)
		{
			return '<a href="'.$this->getUrl(1).'" class="homePage_ed" >'.$val.'</a>';
		}
		else
		{
			return '<a href="'.$this->getUrl(1).'" class="homePage" >'.$val.'</a>';
		}
	}
	
	//尾页链接
	private function linklast($val)
	{
		if($this->pagenum==$this->pagecount)
		{
			return '<a href="'.$this->getUrl($this->pagecount).'" class="endPage_ed">'.$val.'</a>';
		}
		else
		{
			return '<a href="'.$this->getUrl($this->pagecount).'" class="endPage">'.$val.'</a>';
		}
	}
	
	//上一页链接
	private function linkprev($val)
	{
		if($this->pagenum==1)
		{
			return '<a href="'.$this->getUrl($this->pagenum).'" class="prevPage_ed" >'.$val.'</a>';
		}
		else
		{
			return '<a href="'.$this->getUrl($this->pagenum-1).'" class="prevPage" >'.$val.'</a>';
		}
	}
	
	//下一页链接
	private function linknext($val)
	{
		if($this->pagenum==$this->pagecount || $this->pagecount==0)
		{
			return '<a href="'.$this->getUrl($this->pagenum).'" class="nextPage_ed" >'.$val.'</a>';
		}
		else
		{
			return '<a href="'.$this->getUrl($this->pagenum+1).'" class="nextPage" >'.$val.'</a>';
		}
	}
	
	//按钮列表
	private function linklist($val)
	{
		$liststr="";
		$this->rollNum-=1;
		$middle=ceil($this->rollNum/2);
		$first=$middle;
		$last=$this->rollNum-$middle;
		if($this->pagenum-$first<1)
		{
			$last+=1-($this->pagenum-$first);
			if($last>$this->pagecount-$this->pagenum)
			{
				$last=$this->pagecount-$this->pagenum;
			}
			$first=$this->pagenum-1;
		}
		if($this->pagenum+$last>$this->pagecount)
		{
			$first+=($this->pagenum+$last)-$this->pagecount;
			if($first>$this->pagenum-1)
			{
				$first=$this->pagenum-1;
			}
			$last=$this->pagecount-$this->pagenum;
		}
		//前排
		for($i=$first;$i>0;$i--)
		{
			$liststr.='<a href="'.$this->getUrl($this->pagenum-$i).'" class="linkPage" >'.$this->getstylenum(($this->pagenum-$i)).'</a>';
		}
		
		//当前位置
		
		$liststr.='<a href="'.$this->getUrl($this->pagenum).'" class="currentPage" >'.$this->getstylenum(($this->pagenum)).'</a>';
		
		//后排
		for($i=1;$i<$last+1;$i++)
		{
			$liststr.='<a href="'.$this->getUrl($this->pagenum+$i).'" class="linkPage" >'.$this->getstylenum(($this->pagenum+$i)).'</a>';
		}
		//更多
		if($val)
		{
			if(($this->pagenum+$last)<$this->pagecount)
			{
				$liststr.='<a href="'.$this->getUrl($this->pagenum+$last+1).'" class="linkPage" >'.$val.'</a>';
			}
		}
		return $liststr;
	}

	//0中文样式，1阿拉伯数字
	private function getstylenum($num)
	{
		$str='';
		if($this->numstyle==0)
		{
			$numstr=$num;
			$hz=array("零","一","二","三","四","五","六","七","八","九");
			$dw=array("","十","百","千","万","十万","百万","千万","亿");
			for($i=0;$i<strlen($numstr);$i++)
			{
				$char=substr($numstr,$i,1);
				if($char==0)
				{
					//零后面不为空并且不为零则保留零
					if($i+1<strlen($numstr) && substr($numstr,$i+1,1)!=0)
					{
						$str.=$hz[$char];
					}
				
				}
				else
				{
					if($char==1 && $i==0 && strlen($numstr)==2)
					{
						//
					}
					else
					{
						$str.=$hz[$char];
					}
					$str.=$dw[strlen($numstr)-$i-1];
				}
			}
		}
		
		if($this->numstyle==1)
		{
			$str=$num;
		}
		return $str;
	}
		
	
}//class-end




?>