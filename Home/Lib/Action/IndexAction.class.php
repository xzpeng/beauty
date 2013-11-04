<?php
class IndexAction extends CommonAction 
{
    public function index()
    {
    	$m=M('type');
    	$result=$m->where('pid=0')->field(array('title','remark','id'))->limit(0,4)->select();
    	$this->assign('list',$result);
    	$this->assign('pageTitle','--国内专业的模特代言 时尚购物 女性自身修养 美女集中营');
    	$this->display();
    }
    
    //分类
    public function type()
    {
    	$id=$_GET['id'];
    	$m=M('type');
    	$name=$m->where('id='.$id)->getField('title');
    	$result=$m->where('pid='.$id)->order('sort desc')->field(array('title','remark','id'))->select();
    	for($i=0;$i<count($result);$i++)
    	{
    		$color=strrchr($result[$i]['remark'],'|');
    		$result[$i]['remark']=htmlspecialchars(str_replace($color, '',$result[$i]['remark']));
    		$result[$i]['color']=str_replace('|', '',$color);
    	}
    	$this->assign('list',$result);
    	$this->assign('pageTitle',$name);
    	$this->assign('css',$id);
    	$this->display();
    }
}