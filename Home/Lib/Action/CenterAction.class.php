<?php
class CenterAction extends CommonAction
{
	public function index()
	{
		$m=M('article');
		$type=M('type');
		$map['promulgator']=session('uid');
		$map['model']=APP_NAME;
		$field=array('id','title','hits','edit_time','display','recommend','type');
		import('ORG.Xly.Paging');
		$total=$m->where($map)->count();
		$paging=new Paging($total, 40);
		$result=$m->where($map)->field($field)->limit($paging->start,$paging->displayrows)->select();
		for($i=0;$i<count($result);$i++)
		{
			$result[$i]['type']=$type->where('id='.$result[$i]['type'])->getField('title');
		}
		$this->assign('pageshow',$paging->show());
		$this->assign('list',$result);
		$this->assign('pageTitle','个人中心');
		$this->assign('empty',' <tr><td colspan="7" align="center">您还没有发布过文章哦！<a href="__URL__/addArticle">立即发布</a></td></tr>');
		$this->display();
	}
	
	//上传实名认证信息
	public function rna()
	{
		$m=M('user');
		$result=$m->where('id='.session('uid'))->field(array('lineup','lineup_time','rna'))->find();
		if(!empty($result['rna']))
		{
			$this->redirect("Center/index");
		}
		if(!empty($result['lineup']))
		{
			$map['lineup']=array('eq','1');
			$map['lineup_time']=array('lt',$result['lineup_time']);
			$linelength=$m->where($map)->count();
			$this->assign('linelength',$linelength);
		}
		$this->assign('lineup',$result['lineup']);
		$this->assign('pageTitle','实名认证');
		$this->display();
	}
	
	//上传审核信息
	public function doRna()
	{
		$list=$_POST;
		$isIDCard='/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{4}$/';
		if(empty($list['IDNum']))
		{
			$this->error('身份证号不能为空');
		}
		else
		{
			if(!preg_match($isIDCard, $list['IDNum']))
			{
				$this->error('身份证号格式不正确');
			}
		}
		if(empty($_FILES['IDCard_a']['name'])||empty($_FILES['IDCard_b']['name']))
		{
			$this->error('请上传正反面两张身份证图片');
		}
		$m=M('user');
		$result=$m->where('id='.session('uid'))->field(array('IDNum','IDCard','lineup','rna'))->find();
		$card=explode('|', $result['IDCard']);
		if(!empty($result['rna']))
		{
			$this->error('已通过实名认证，请勿重复认证');
		}
		if(!empty($result['lineup']))
		{
			$this->error('正在排队中');
		}
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->allowExts  = array('jpg','jpeg','png','gif');// 设置附件上传类型
		$upload->savePath = C('UPLOAD_PATH').getUserDir('IDCard');// 设置附件上传目录
		$upload->maxSize=2097152;//单位K
		$tmp=$upload->uploadOne($_FILES['IDCard_a']);
		if(empty($tmp))
		{
			$this->error('身份证正面:'.$upload->getErrorMsg());
		}
		else
		{
			if(!empty($card[0]))
			{
				unlink(C('UPLOAD_PATH').getUserDir('IDCard').$card[0]);
			}
			$card[0]=$tmp[0]['savename'];
		}
		$tmp=$upload->uploadOne($_FILES['IDCard_b']);
		if(empty($tmp))
		{
			$this->error('身份证反面:'.$upload->getErrorMsg());
		}
		else
		{
			if(!empty($card[1]))
			{
				unlink(C('UPLOAD_PATH').getUserDir('IDCard').$card[1]);
			}
			$card[1]=$tmp[0]['savename'];
		}
		$card[0]=$card[0]?$card[0]:"";
		$card[1]=$card[1]?$card[1]:"";
		$data['IDCard']=$card[0].'|'.$card[1];
		$data['IDNum']=$_POST['IDNum'];
		$data['lineup_time']=time();
		$data['lineup']='1';
		$ex=$m->where('id='.session('uid'))->save($data);
		if($ex>0)
		{
			$this->success('提交成功');
		}
		else
		{
			$this->success('提交失败');
		}
		
	}
	
	
	//上传头像
	public function uploadPic()
	{
		$m=M('user');
		$result=$m->where('id='.session('uid'))->field(array('picture','cover'))->find();
		$this->assign('list',$result);
		$this->assign('userPath',getUserDir('Picture'));
		$this->display();
	}
	
	//处理上传图像
	public function doUploadPic()
	{
		import('ORG.Net.UploadFile');
		$m=M('user');
		$result=$m->where('id='.session('uid'))->field(array('picture','cover'))->find();
		$data=array();
		$upload = new UploadFile();// 实例化上传类
		$upload->allowExts  = array('jpg','jpeg','png','gif');// 设置附件上传类型
		$upload->savePath = C('UPLOAD_PATH').getUserDir('Picture');// 设置附件上传目录
		$upload->maxSize=2097152;//单位K
		$upload->thumb=true;
		$upload->thumbPrefix='';
		$upload->thumbMaxWidth='200';
		$upload->thumbMaxHeight='200';
		if(!empty($_FILES['picture']['name']))
		{
			$upload->thumbMaxWidth='200';
			$upload->thumbMaxHeight='200';
			$tmp=$upload->uploadOne($_FILES['picture']);
			if(empty($tmp))
			{
				$this->error('头像:'.$upload->getErrorMsg());
			}
			else
			{
				$data['picture']=$tmp[0]['savename'];
				if(!empty($result['picture']))
				{
					unlink(C('UPLOAD_PATH').getUserDir('Picture').$result['picture']);
				}
			}
		}
		
		if(!empty($_FILES['cover']['name']))
		{
			$upload->thumbMaxWidth='490';
			$upload->thumbMaxHeight='640';
			$tmp=$upload->uploadOne($_FILES['cover']);
			if(empty($tmp))
			{
				$this->error('封面形象:'.$upload->getErrorMsg());
			}
			else
			{
				$data['cover']=$tmp[0]['savename'];
				if(!empty($result['cover']))
				{
					unlink(C('UPLOAD_PATH').getUserDir('Picture').$result['cover']);
				}
			}
		}
		$upre=$m->where('id='.session('uid'))->save($data);
		if($upre>0)
		{
			$this->success('上传成功');
		}
		else
		{
			$this->error('上传失败');
		}
	}
	
	public function addArticle()
	{
		$typeInfo=array();
		$this->getTypeInfo(0,$typeInfo);
		$this->assign('pageTitle','发表文章');
		$this->assign('typeInfo',json_encode($typeInfo));
		$this->display();
	}
	
	public function editArticle()
	{
		$id=$_GET['id'];
		$m=M('article');
		$field=array('id','title','hits','edit_time','display','recommend','type','content','img','model','promulgator');
		$result=$m->where('id='.$id)->field($field)->select();
		$userPath=$result[0]['model'].'/'.$result[0]['promulgator'].'/Images/';
		$this->assign('userPath',$userPath);
		$this->assign('list',$result);
		$typeInfo=array();
		$this->getTypeInfo(0,$typeInfo);
		$this->assign('typeInfo',json_encode($typeInfo));
		$this->assign('pageTitle','修改文章');
		$this->display();
	}
	
	//修改资料
	public function editData()
	{
		$m=M('user');
		$result=$m->where('id='.session('uid'))->find();
		$result['sex']=getSex($result['sex']);
		$arr=explode('|', $result['IDCard']);
		$result['IDCard_a']=$arr[0];
		$result['IDCard_b']=$arr[1];
		$result['IDCard']='';
		$result['marital']=getMarital($result['marital']);
		$result['loginTime_str']=getTimeStr($result['loginTime'])."前";
		$result['edu']=getEdu($result['edu']);
		$result['lineup']=$result['lineup']?'正在审核排队中':'不在队列中';
		$this->assign('userPath','Home/'.$result['id'].'/');
		$this->assign('list',$result);
		$this->display();
	}
	
	public function update()
	{
		$m=M('article');
		$tmp=$_POST;
		$data=array();
		if(isset($tmp['title'])&&empty($tmp['title']))
		{
			$this->error('标题不能为空');
		}
		$data['title']=$tmp['title'];
		if(isset($tmp['keywords']))
		{
			$data['keywords']=preg_replace('/\s+/', ' ',$tmp['keywords']);
		}
		$data['edit_time']=time();
		$data['href']=$tmp['href'];
		$data['content']=$tmp['content'];
		$data['type']=$tmp['type'];
		if(isset($tmp['content'])&&!empty($tmp['href']))
		{
			unset($data['content']);
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
			$data['img']=$up['savename'];
			$data['img_width']=$up['width'];
			$data['img_height']=$up['height'];
		}
		$data['display']=0;
		$result=$m->where('id='.$tmp['id'])->save($data);
		if($result>0)
		{
			$this->success('保存成功，等待审核中...');
		}
		else
		{
			$this->error("保存失败");
		}
	}
	
	public function editPassword()
	{
		$this->display();
	}
	
	public function doEditPassword()
	{
		$list=$_POST;
		if($list['newpassword']!=$list['newpassword2'])
		{
			$this->error('新密码两次输入不一致');
		}
		if($this->isAllNumber($list['newpassword']))
		{
			$this->error('密码不能由纯数字组成');
		}
		
		if(strlen($list['newpassword'])<6)
		{
			$this->error('密码不能小于6位');
		}
		
		if(strlen($list['newpassword'])>16)
		{
			$this->error('密码不能大于16位');
		}
		$m=M('user');
		$result=$m->where('id='.session('uid'))->getField('password');
		if(md5($list['password'])==$result)
		{
			$r=$m->where('id='.session('uid'))->save(array('password'=>md5($list['newpassword'])));
			if($r>0)
			{
				$this->error("修改成功");
			}
			else
			{
				$this->error("修改失败");
			}
		}
		else
		{
			$this->error("原密码输入不正确");
		}
	}
	
	//纯数字
	private function isAllNumber($str)
	{
		$arr=array('0','1','2','3','4','5','6','7','8','9','0');
		for($i=0;$i<strlen($str);$i++)
		{
		if(!array_search($str[$i], $arr))
		{
		return false;
		}
		}
		return true;
	}
	
	public function delete()
	{
		$a=A('Admin://Article');
		$a->delete();
	}
	
	public function add()
	{
		$list=$_POST;
		if(empty($list['title']))
		{
			$this->error("标题不能为空");
		}
		if(in_array($list['type'],C('PROTECT_TYPE')))
		{
			$this->error("类别不存在");
		}
		$data['type']=$list['type'];
		$data['title']=$list['title'];
		$data['sort']=0;
		$data['keywords']=preg_replace('/\s+/', ' ',$list['keywords']);
		$data['display']=0;
		$data['recommend']=0;
		$data['edit_time']=time();
		$data['href']=$list['href'];
		$data['promulgator']=session('uid');
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
			$this->success('发布成功，等待审核中');
		}
		else
		{
			$this->error("发布失败");
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
	
	//获取分类信息
	private function getTypeInfo($pid,&$arr)
	{
		$sid=$_GET['id']?$_GET['id']:0;
		$m=M('type');
		$field=array('id','title');
		$map['pid']=array('eq',$pid);
		$map['id']=array('not in',C('PROTECT_TYPE'));
		$result=$m->where($map)->field($field)->select();
		if(!empty($result))
		{
			for($i=0;$i<count($result);$i++)
			{
				if(!in_array($result[$i]['id'],C('PROTECT_TYPE')))
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
		}
	}//获取分类信息结束
}