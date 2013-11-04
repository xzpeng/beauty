<?php
class UserAction extends CommonAction
{
	public function index()
	{
		cookie('index_url',__SELF__,session('life_time'));
		$m=M('user');
		$map=array();
		if(isset($_GET['userName']))
		{
			if(!empty($_GET['userName']))
			{
				$map['email']=array('eq',$_GET['userName']);
				$map['id']=array('eq',$_GET['userName']);
				$map['mphone']=array('eq',$_GET['userName']);
				$map['qq']=array('eq',$_GET['userName']);
			}
			$map['userName|nickName']=array('like','%'.$_GET['userName'].'%');
		}
		$od=array();
		if(isset($_GET['sub2']))
		{
			$od['lineup_time']='asc';
			$map['lineup']=array('eq','1');
		}
		else
		{
			$map['_logic']='OR';
		}
		$field=array('id','userName','nickName','sex','birthday','mphone','qq','rna','area','job','loginTime','loginDays');
		
		//分页
		import('ORG.Xly.Paging');// 导入分页类
		$total=$m->where($map)->count();
		$paging=new Paging($total, 40);
		
		$list=$m->where($map)->order($od)->field($field)->limit($paging->start,$paging->displayrows)->select();
		for($i=0;$i<count($list);$i++)
		{
			if($list[$i])
			{
				$list[$i]['sex']=getSex($list[$i]['sex']);
				$list[$i]['age']=getAge($list[$i]['birthday']);
				$list[$i]['loginTime']=getTimeStr($list[$i]['loginTime'])."前";
				$list[$i]=array_merge($list[$i],$this->getAve($list[$i]['id']));
			}
		}
		
		$this->assign('pageshow',$paging->show());// 赋值分页输出
		$this->assign('list',$list);
		$this->display();
	}
	
	public function show()
	{
		$m=M('user');
		$result=$m->where('id='.$_GET['id'])->find();
		if(empty($result))
		{
			$this->error('该用户已经不存在了');
		}
		$result['sex']=getSex($result['sex']);
		$arr=explode('|', $result['IDCard']);
		$result['IDCard_a']=$arr[0];
		$result['IDCard_b']=$arr[1];
		$result['IDCard']='';
		$result['marital']=getMarital($result['marital']);
		$result['loginTime_str']=getTimeStr($result['loginTime'])."前";
		$result['edu']=getEdu($result['edu']);
		$result=array_merge($result,$this->getAve($_GET['id']));
		$result['lineup']=$result['lineup']?'正在排队中':'已离开队列';
		$this->assign('userPath','Home/'.$result['id'].'/');
		$this->assign('list',$result);
		$this->display();
	}
	
	//重置密码
	public function resetPassword()
	{
		if(empty($_POST['id']))
		{
			$this->error('没有选中的记录');
		}
		$new='';
		$code="0123456789qwertyuipasdfghjkzxcvbnmQWERTYUIPASDFGHJKLZXCVBNM";//随机码(近似的已删除)
		for($i=0;$i<6;$i++)
		{
			$new.=$code[rand(0,58)];
		}
		$m=M('user');
		$result=$m->where('id='.$_POST['id'])->save(array('password'=>md5($new)));
		if($result>0)
		{
			$this->success($new);
		}
		else
		{
			$this->error('重置失败');
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
	
	public function update()
	{
		$m=M('user');
		$list=array();
		$num=0;
		if(!empty($_POST['list']))
		{
			$list=$_POST['list'];
		}
		else
		{
			array_push($list, $_POST);
		}
		
		for($i=0;$i<count($list);$i++)
		{
			if(!empty($list[$i]['rna']))
			{
				$list[$i]['lineup']='0';
			}
			$result=$m->where('id='.$list[$i]['id'])->save($list[$i]);
			if($result>0)
			{
				$num+=$result;
			}
		}
		
		if($num>0)
		{
			if(isset($_POST['com']))
			{
				$this->success('更新成功,共计更新了'.$num.'条记录',cookie('index_url'));
				return ;
			}
			$this->success('更新成功,共计更新了'.$num.'条记录');
		}
		else
		{
			$this->error('更新失败');
		}
		
	}
	
	//删除
	public function delete()
	{
		$m=M('user');
		$list=array();
		$num=0;
		if(!empty($_GET['id']))
		{
			array_push($list, $_GET['id']);
		}
		if(!empty($_POST['ids']))
		{
			$list=array_merge($list,$_POST['ids']);
		}
		if(count($list)==0)
		{
			$this->error('没有选中的记录');
		}
			
		for($i=0;$i<count($list);$i++)
		{
			$field=array('picture','IDCard');
			$info=$m->where('id='.$list[$i])->field($field)->find();
			//删除用户存储空间
			$base=C('UPLOAD_PATH').'Home/'.$list[$i].'/';
			if(file_exists($base))
			{
				delDir($base)?'':$this->error('删除资源空间出错');
			}
			//删除该用户的所有评分
			$score=M('score');
			$score->where('judges='.$list[$i])->delete();
			$result=$m->where('id='.$list[$i])->delete();
			if($result>0)
			{
				$num+=$result;
			}
		}
		if($num>0)
		{
			$this->success("删除成功,共计删除了".$num.'条记录');
		}
		else
		{
			$this->error('删除失败');
		}
	}
	
	

}