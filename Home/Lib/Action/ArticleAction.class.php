<?php
class ArticleAction extends CommonAction
{
	//文章列表
	public function index()
	{
		$m=M('type');
		$field=array('title','pid');
		$result=$m->where('id='.$_GET['id'])->field($field)->find();
		$result['title']=$result['title']?$result['title']:"全部";
		$this->assign('type',$_GET['id']);
		$this->assign('keywords',$_GET['keywords']?$_GET['keywords']:'');
		$this->assign('typeList',$this->getAllType($result['pid']));
		$this->assign('pageTitle',$result['title'].'分类');
		$this->assign('pid',$result['pid']?$result['pid']:$_GET['pid']);
		if($_GET['pid'])
		{
			$this->assign('typePid',$_GET['pid']);
		}
		
		$m=M('ad');
		$field=array('model','uid','img','href','window','bgcolor');
		$b=$m->where('type=3')->field($field)->find();
		$banner=array();
		if(preg_match('/.*\.swf$/i', $b['img']))
		{
			$banner['swf']=1;
		}
		$banner['img']=$b['model'].'/'.$b['uid'].'/Images/'.$b['img'];
		$banner['href']=$b['href'];
		$banner['window']=$b['window'];
		$banner['bgcolor']=$b['bgcolor'];
		$this->assign('banner',$banner);
		$this->display();
	}
	
	//输出列表数据
	public function loadList()
	{
		$m=M('article');
		$map=array();
		if(isset($_GET['id']))
		{
			$map['type']=array('eq',$_GET['id']);
		}
		
		if(isset($_GET['keywords']))
		{
			$map['title|keywords']=array('like','%'.ltrim($_GET['keywords']).'%');
		}
		
		if(isset($_GET['pid']))
		{
			$type=M('type');
			$field=array('id');
			$typeids=$type->where('pid='.$_GET['pid'])->field($field)->select();
			$tmp=array();
			for($i=0;$i<count($typeids);$i++)
			{
				array_push($tmp, $typeids[$i]['id']);
			}
			$map['type']=array('in',$tmp);
		}
		$map['display']=array('eq','1');//只显示开启的
		$od='recommend desc,sort desc,edit_time desc';
		import('ORG.Xly.Paging');
		$total=$m->where($map)->count();
		$paging=new Paging($total, 20);
		$field=array('id','title','img','img_width','img_height','hits','promulgator','model','href','type');
		$result=$m->where($map)->order($od)->field($field)->limit($paging->start,$paging->displayrows)->select();
		if(empty($result))
		{
			$this->ajaxReturn(null,'加载失败',0);
		}
		$data['pg']=$paging->pagenum;
		$data['total']=$paging->pagecount;
		$data['list']=$result;
		$this->ajaxReturn($data,'加载成功',1);
	}
	
	public function show()
	{
		$m=M('article');
		$map['display']=array('eq','1');//只显示开启的
		$map['id']=array('eq',$_GET['id']);
		$result=$m->where($map)->find();
		$this->assign('pageTitle',$result['title']);
		if(empty($result))
		{
			$this->error('此信息已经删除或者正在审核中');
		}
		$m->where($map)->setInc('hits',1);//访问量+1
		//转向外链
		if(!empty($result['href']))
		{
			header('Content-type:text/html;charset=utf-8;');
			$com=$result['href'];
			$com=preg_replace('/(\w+\.(com|cn|net|org|co|cc|tv|org|公司|网络|中国|me|net|gob|gov|gov|biz|so|tel))/Ui', '<font style="color:#f00;">${1}</font>', $com,1);
			$mesg='<p style="font-size:18px;line-height:30px;font-family:微软雅黑;">您正在跳转到第三方网址:<br/>'.($com).'</p>';
			redirect($result['href'],1,$mesg);
			return ;
		}
		if($result['model']=="Admin")
		{
			$result['promulgator']="管理员";
			$result['gfrz']=1;
		}
		else
		{
			$user=M('user');
			$uinfo=$user->where('id='.$result['promulgator'])->find();
			$result['promulgator']=$uinfo['userName'];
			$result['rna']=$uinfo['rna'];
			$result['picture']=$uinfo['picture']?'Home/'.$uinfo['id'].'/Picture/'.$uinfo['picture']:'System/default__picture.png';
			$result['cover']=$uinfo['cover']?'Home/'.$uinfo['id'].'/Picture/'.$uinfo['cover']:'System/default__cover.png';
			$result['workRemark']=$uinfo['workRemark'];
			$result['name']=$uinfo['name'];
			$result['sex']=getSex($uinfo['sex']);
			$result['nickName']=$uinfo['nickName'];
			$result['birthday']=$uinfo['birthday'];
			$result['weight']=$uinfo['weight'];
			$result['height']=$uinfo['height'];
			$result['sanwei']=$uinfo['measure1'].' '.$uinfo['measure2'].' '.$uinfo['measure3'];
			$result['graduated']=$uinfo['graduated'];
			$result['job']=$uinfo['job'];
			$result['edu']=getEdu($uinfo['edu']);
			$result['rna']=$uinfo['rna'];
			if($uinfo['rna'])
			{
				$result['wburl']=$uinfo['wburl'];
				$result['qq']=$uinfo['qq'];
			}
			$result['uid']=$uinfo['id'];
			$result['islogin']=session('uid')?'none':'block';
			if(session('uid'))
			{
				$score=M('score');
				$smap['uid']=$uinfo['id'];
				$smap['judges']=session('uid');
				$sinfo=$score->where($smap)->find();
				$result['stature']=$sinfo['stature']?$sinfo['stature']:0;
				$result['face']=$sinfo['face']?$sinfo['face']:0;
				$result['liked']=$sinfo['liked']?$sinfo['liked']:0;
				$result=array_merge($result,$this->getAve($uinfo['id']));
			}
		}
		$this->getAd();
		$this->assign('list',$result);
		$this->display();
	}
	
	private function getAd()
	{
		$m=M('ad');
		$field=array('model','uid','img','href','window','bgcolor');
		$b=$m->where('type=1')->field($field)->find();
		$i=$m->where('type=2')->field($field)->find();
		$banner=array();
		$ill=array();
		if(preg_match('/.*\.swf$/i', $b['img']))
		{
			$banner['swf']=1;
		}
		if(preg_match('/.*\.swf$/i', $i['img']))
		{
			$ill['swf']=1;
		}
		
		$banner['img']=$b['model'].'/'.$b['uid'].'/Images/'.$b['img'];
		$ill['img']=$i['model'].'/'.$i['uid'].'/Images/'.$i['img'];
		$banner['href']=$b['href'];
		$ill['href']=$i['href'];
		$banner['window']=$b['window'];
		$ill['window']=$i['window'];
		$banner['bgcolor']=$b['bgcolor'];
		$ill['bgcolor']=$i['bgcolor'];
		$this->assign('banner',$banner);
		$this->assign('ill',$ill);
	}
	
	//获取所有子类
	private function getAllType($id)
	{
		$id=$id?$id:$_GET['pid'];
		$m=M('type');
		$map['pid']=array('eq',$id);
		$result=$m->where($map)->field(array('id','title'))->select();
		return $result;
	}
	
	//评分
	public function score()
	{
		$list=$_POST;
		if(!session('uid'))
		{
			$this->error('请先登录后再进行评分');
		}
		if(session('uid')==$list['uid'])
		{
			$this->error('不支持对自己的评分');
		}
		$m=M('score');
		$data['uid']=$list['uid'];
		$data['judges']=session('uid');
		$id=$m->where($data)->getField('id');
		foreach ($list as $key=>$val)
		{
			if($key!='uid')
			{
				$data[$key]=$val;
				$str=$key;
				$num=$val;
			}
		}
		$data['time']=time();
		if($id>0)
		{
			$result=$m->where('id='.$id)->save($data);
		}
		else
		{
			$result=$m->add($data);
		}
		if($result>0)
		{
			$res=array('str'=>$str,'num'=>$num);
			$res=array_merge($res,$this->getAve($data['uid']));
			$this->ajaxReturn($res,'',1);
		}
		else
		{
			$this->error('评分失败');
		}
	}
	
	//获取平均分
	private function getAve($uid)
	{
		$m=M('score');
		$tmp=array();
		$tmp['stature_ave']=number_format($m->where('uid='.$uid)->avg('stature'),1);
		$tmp['face_ave']=number_format($m->where('uid='.$uid)->avg('face'),1);
		$tmp['liked_ave']=number_format($m->where('uid='.$uid)->avg('liked'),1);
		return $tmp;
	}	
	
	
	
	
	
	
	
	
	
	
	
	
	
}