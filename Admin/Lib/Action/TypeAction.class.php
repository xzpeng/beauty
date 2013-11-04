<?php
class TypeAction extends CommonAction
{
	public function index()
	{
		cookie('index_url',__SELF__,session('life_time'));
		$m=M('type');
		$pid=0;
		$pathArr=array(0);
		$pathHtml=array();
		if($_GET['pid'])
		{
			$pid=$_GET['pid'];
		}
		//分页
		import('ORG.Xly.Paging');
		$total=$m->where('pid='.$pid)->count();
		$paging=new Paging($total, 40);
		
		$list=$m->where('pid='.$pid)->order(array('sort'=>'desc'))->limit($paging->start,$paging->displayrows)->select();
		$pathResult=$m->where('id='.$pid)->getField('path');
	
		if($pathResult)
		{
			$pathArr=explode('/', $pathResult);
			array_pop($pathArr);
		}
	
		for($i=0;$i<count($pathArr);$i++)
		{
		if($pathArr[$i]==0)
		{
		$title="Root";
			}
				else
				{
				$title=$m->where('id='.$pathArr[$i])->getField("title");
			}
				array_push($pathHtml,array("title"=>$title,"pid"=>$pathArr[$i]));
		}
		
		$this->assign("list",$list);
		$this->assign('pid',$pid);
		$this->assign('pathHtml',$pathHtml);
		$this->assign('pageshow',$paging->show());// 赋值分页输出
		$this->display();
	}
	
	//修改
	public function edit()
	{
		$id=$_GET['id'];
		$m=M('type');
		$list=$m->find($id);
		$this->assign("list",$list);
		$this->display();
	}
	
	//添加
	public function add()
	{
		$m=M('type');
		$pid=0;
		$path='0/';
		$sort=0;
		$list=null;
		$list=$_POST;
	
		if($list['pid'])
		{
			$pid=$list['pid'];
			$path=$m->where('id='.$pid)->getField('path');
		}
	
		if($list['sort'])
		{
			$sort=$list['sort'];
		}
	
		if(empty($list['title']))
		{
			$this->error('类标题不能为空');
		}
	
		$data["pid"]=$pid;
		$data["title"]=$list['title'];
		$data["remark"]=$list['remark'];
		$data["display"]=$list['display'];
		$data["sort"]=$list['sort'];
		$data["edit_time"]=time();
		$result=$m->add($data);
		if($result>0)
		{
			$pdata['path']=$path.$result.'/';
			if($m->where('id='.$result)->save($pdata)>0)
			{
				if($pid>0)
				{
					$m->where('id='.$pid)->setInc('child',1);//父类的子级数量+1;
				}
				$this->success('添加成功');
			}
		}
	}
	
	//更新
	public function update()
	{
		$m=M('type');
		$list=array();
		$num=0;
		if($_POST['list'])
		{
			$list=$_POST['list'];
		}
		else
		{
			array_push($list,$_POST);
		}
		
		for($i=0;$i<count($list);$i++)
		{
			if(isset($list[$i]['title'])&&empty($list[$i]['title']))
			{
				$this->error('类标题不能为空');
			}
			$list[$i]['edit_time']=time();
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
			$m=M('type');
			$num=0;
			$list=array();
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
			
			$article=M('article');
			for($i=0;$i<count($list);$i++)
			{
				if(in_array($list[$i],C(PROTECT_TYPE)))
				{
					$this->error('您没有权限删除受保护的分类');
					return ;
				}
				$map['path'] = array('like','%'.$list[$i].'%');
				$delarr=$m->where($map)->field(array('id','pid'))->select();
				for($j=0;$j<count($delarr);$j++)
				{
					$arti=$article->where('type='.$delarr[$j]['id'])->getField('id');
					if(empty($arti))
					{
						$result=$m->where('id='.$delarr[$j]['id'])->delete();
						if($result>0)
						{	
							$m->where('id='.$delarr[$j]['pid'])->setDec('child',1);//父类子级数-1;
							$num+=$result;
						}
					}
					else
					{
						$this->error("请先删除该类的所有信息");
					}
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
		}//删除结束
		
		
		
		
		
		
		
		
		
}