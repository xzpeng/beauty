<?php
class ArticleAction extends CommonAction
{
	public function index()
	{
		cookie('index_url',__SELF__,session('life_time'));
		$get=$_GET;
		$map=array();
		if(!empty($get['id']))
		{
			$map['type']=array('eq',$get['id']);
		}
		if(!empty($get['keywords']))
		{
			$map['keywords|title']=array('like','%'.$get['keywords'].'%');
		}
		if(!empty($get['recommend']))
		{
			$map['recommend']=array('eq',$get['recommend']==2?0:$get['recommend']);
		}
		
		if(!empty($get['href']))
		{
			if($get['href']==1)
			{
				$map['href']=array('neq','');
			}
			else
			{
				$map['href']=array('eq','');
			}
		}
		
		$order=array();
		if(!empty($get['sort']))
		{
			$order['sort']=$get['sort'];
		}
		
		if(!empty($get['edit_time']))
		{
			$order['edit_time']=$get['edit_time'];
		}
		
		if(!empty($get['hits']))
		{
			$order['hits']=$get['hits'];
		}
		
		import('ORG.Xly.Paging');
		$m=M('article');
		$type=M('type');
		$total=$m->where($map)->count();
		$paging=new Paging($total, 40);
		$field=array('id','type','title','img','edit_time','hits','display','href','sort','promulgator','recommend','model');
		$result=$m->where($map)->order($order)->field($field)->limit($paging->start,$paging->displayrows)->select();
		for($i=0;$i<count($result);$i++)
		{
			$result[$i]['img']=$result[$i]['model'].'/'.$result[$i]['promulgator'].'/thumb/258_'.$result[$i]['img'];
			$result[$i]['haveHref']=$result[$i]['href']?'#f00':'#666';
			$result[$i]['href']=$result[$i]['href']?'href="'.$result[$i]['href'].'"':"";
			$result[$i]['promulgator']=$this->getPromulgator($result[$i]['promulgator'],$result[$i]['model']);
			$result[$i]['type']=$type->where('id='.$result[$i]['type'])->getField('title');
		}
		$this->assign('list',$result);
		$this->assign('pageshow',$paging->show());
		$typeInfo=array();
		$this->getTypeInfo(0,$typeInfo);
		$this->assign('typeInfo',json_encode($typeInfo));
		$this->display();
	}
	
	//更新
	public  function update()
	{
		$list=array();
		$num=0;
		if(isset($_POST['list']))
		{
			$list=$_POST['list'];
		}
		else
		{
			array_push($list, $_POST);
		}
		$m=M('article');
		for($i=0;$i<count($list);$i++)
		{
			$tmp=$list[$i];
			if(isset($tmp['title'])&&empty($tmp['title']))
			{
				$this->error('标题不能为空');
			}
			if(isset($tmp['keywords']))
			{
				$tmp['keywords']=preg_replace('/\s+/', ' ',$tmp['keywords']);
			}
			if(isset($tmp['edit_time']))
			{
				$tmp['edit_time']=$tmp['edit_time']?$this->getEditTime($tmp['edit_time']):time();
			}
			if(isset($tmp['content'])&&!empty($tmp['href']))
			{
				unset($tmp['content']);
			}
			//是否删除略缩图
			if($tmp['deleteImg'])
			{
				$old=$m->where('id='.$tmp['id'])->field(array('img,promulgator,model'))->find();
				if(!$this->deleteImg($old))
				{
					$this->error("略缩图删除出错");
				}
				$m->where('id='.$tmp['id'])->save(array('img'=>''));
			}
			//上传
			if(!empty($_FILES['img']['name']))
			{
				$old=$m->where('id='.$tmp['id'])->getField('img,promulgator,model');
				$this->deleteImg($old[0]);
				$up=$this->imageUp();
				$tmp['img']=$up['savename'];
				$tmp['img_width']=$up['width'];
				$tmp['img_height']=$up['height'];
			}

			$result=$m->where('id='.$tmp['id'])->save($tmp);
			if($result>0)
			{
				$num++;
			}
		}
		
		if($num>0)
		{
			if(isset($_POST['com']))
			{
				$this->success('更新成功,共计更新了'.$num.'条记录',cookie('index_url'));
				return ;
			}
			$this->success("更新成功，共计更新了".$num.'条记录');
		}
		else
		{
			$this->success("更新失败");
		}
	}
	
	
	//删除略缩图
	public function deleteImg($old)
	{
		if(!empty($old['img']))
		{
			$u1=unlink(C('UPLOAD_PATH').$old['model'].'/'.$old['promulgator'].'/Images/'.$old['img']);
			$u2=unlink(C('UPLOAD_PATH').$old['model'].'/'.$old['promulgator'].'/Images/thumb/258_'.$old['img']);
			if(!$u1||!$u2)
			{
				return false;
			}
		}
		
		return true;
	}
	
	//删除
	public function delete()
	{
		$list=array();
		$num=0;
		if(isset($_GET['id']))
		{
			array_push($list,$_GET['id']);
		}
		
		if(isset($_POST['ids']))
		{
			$list=array_merge($list,$_POST['ids']);
		}
		$m=M('article');
		for($i=0;$i<count($list);$i++)
		{
			$tmp=$list[$i];
			if(in_array($tmp,C('PROTECT_ARTICLE')))
			{
				$this->error('您没有权限删除受保护的信息');
				return ;
			}
			$old=$m->where('id='.$tmp)->field(array('img,promulgator,model'))->find();
			if(!$this->deleteImg($old))
			{
				$this->error("略缩图删除出错");
			}
			$result=$m->where('id='.$tmp)->delete();
			if($result>0)
			{
				$num++;
			}
		}
		
		if($num>0)
		{
			$this->success("删除成功，共计删除了".$num."条记录");
		}
		else
		{
			$this->error("删除失败");
		}
	}
	
	//编辑
	public function edit()
	{
		$id=$_GET['id'];
		$m=M('article');
		$result=$m->where('id='.$id)->select();
		$userPath=$result[0]['model'].'/'.$result[0]['promulgator'].'/Images/';
		$this->assign('userPath',$userPath);
		$this->assign('list',$result);
		$typeInfo=array();
		$this->getTypeInfo(0,$typeInfo);
		$this->assign('typeInfo',json_encode($typeInfo));
		$this->display();
	}
	
	//获取发布者
	private function getPromulgator($id,$model)
	{
		if($model=="Admin")
		{
			$m=M('administrator');
			$result=$m->where('id='.$id)->getField('adName');
			return $result."[后台]";
		}
		if($model=="Home")
		{
			$m=M('user');
			$result=$m->where('id='.$id)->getField('userName');
			return $result."[用户]";
		}
	}
	
	public function add()
	{
		$typeInfo=array();
		$this->getTypeInfo(0,$typeInfo);
		$this->assign('typeInfo',json_encode($typeInfo));
		$this->assign('edit_time',time());
		$this->assign('session_id',session_id());
		$this->display();
	}
	
	//添加
	public function doAdd()
	{
		$list=$_POST;
		if(empty($list['title']))
		{
			$this->error("标题不能为空");
		}
		$data['type']=$list['type'];
		$data['title']=$list['title'];
		$data['sort']=$list['sort'];
		$data['keywords']=preg_replace('/\s+/', ' ',$list['keywords']);
		$data['display']=$list['display'];
		$data['recommend']=$list['recommend'];
		$data['edit_time']=$list['edit_time']?$this->getEditTime($list['edit_time']):time();
		$data['href']=$list['href'];
		$data['promulgator']=session('aid')?session('aid'):session('uid');
		$data['model']=APP_NAME;
		if(empty($list['href']))
		{
			$data['content']=$list['content'];
		}
		//上传
		if(!empty($_FILES['img']['name']))
		{
			$up=$this->imageUp();
			$data['img']=$up['savename'];
			$data['img_width']=$up['width'];
			$data['img_height']=$up['height'];
		}
		$m=M('article');
		$result=$m->add($data);
		if($result>0)
		{
			if(isset($list['com']))
			{
				$this->success('添加成功',cookie('index_url'));
				return ;
			}
			$this->success('添加成功');
		}
		else
		{
			$this->error("添加失败");
		}
	}
	
	//上传略缩图
	private function imageUp()
	{
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->allowExts  = array('jpg','jpeg','png','gif');// 设置附件上传类型
		$upload->savePath = C('UPLOAD_PATH').getUserDir('Images');// 设置附件上传目录
		$upload->maxSize=2097152;//单位K
		$upload->thumb=true;
		$upload->thumbMaxWidth='258';
		$upload->thumbMaxHeight='500';
		$upload->thumbPath=C('UPLOAD_PATH').getUserDir('Images').'thumb/';
		if(!file_exists(C('UPLOAD_PATH').getUserDir('Images').'thumb/'))
		{
			mkdir(C('UPLOAD_PATH').getUserDir('Images').'thumb/');
		}
		$upload->thumbType=0;
		$upload->thumbPrefix='258_';
		if($upload->upload())
		{
			$info =  $upload->getUploadFileInfo();
			$tmp['savename']=$info[0]['savename'];
			$arr=getimagesize($info[0]['savepath'].$info[0]['savename']);
			$tmp['width']=$arr[0];
			$tmp['height']=$arr[1];
			return $tmp;
		}
		else
		{
			$this->error('略缩图上传失败，'.$upload->getErrorMsg());
		}
	}
	
	//获取编辑时间
	private function getEditTime($str)
	{
		$arr=explode('-', $str);
		$list=explode('-',date('Y-m-d-H-i-s'));
		$tmp=count($list)-count($arr);
		for($i=0;$i<count($arr);$i++)
		{
			$list[$tmp+$i]=$arr[$i];
		}
		return mktime($list[3],$list[4],$list[5],$list[1],$list[2],$list[0]);
	}
	
	//获取分类信息
	private function getTypeInfo($pid,&$arr)
	{
		$sid=$_GET['id']?$_GET['id']:0;
		$m=M('type');
		$field=array('id','title');
		$result=$m->where('pid='.$pid)->field($field)->select();
		if(!empty($result))
		{
			for($i=0;$i<count($result);$i++)
			{
				$obj=array('id'=>$result[$i]['id'],'title'=>$result[$i]['title'],'children'=>array());
				if($obj['id']==$sid)
				{
					$obj['selected']=true;
				}
				array_push($arr,$obj);
				$this->getTypeInfo($result[$i]['id'], $arr[$i]['children']);
			}
		}
	}//获取分类信息结束
}