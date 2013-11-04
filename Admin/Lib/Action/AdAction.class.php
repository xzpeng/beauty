<?php
class AdAction extends CommonAction
{
	public function add()
	{
		$this->display();
	}
	
	public function doAdd()
	{
		$list=$_POST;
		if(empty($list['type'])||empty($list['title']))
		{
			$this->error('广告类型和标题不能为空');
		}
		if(empty($_FILES['img']['name']))
		{
			$this->error('请上传广告图');
		}
		$m=M('ad');
		$id=$m->where('type='.$list['type'])->field(array('id','img','uid','model'))->find();
		$data['type']=$list['type'];
		$data['title']=$list['title'];
		$data['remark']=$list['remark'];
		if(!empty($list['demo']))
		{
			$data['href']=__ROOT__.'/index.php/Article/show/id/'.$list['demo'];
		}
		else
		{
			$data['href']=$list['href'];
		}
		$data['window']=$list['window'];
		$data['img']=$this->imageUp();
		$data['uid']=session('aid');
		$data['model']=APP_NAME;
		$data['bgcolor']=$list['bgcolor'];
		if($id['id']>0)
		{
			$img=C('UPLOAD_PATH').$id['model'].'/'.$id['uid'].'/Images/'.$id['img'];
			if(unlink($img))
			{
				$result=$m->where('id='.$id['id'])->save($data);
			}
			else
			{
				$this->error('广告图片替换失败');
			}
		}
		else
		{
			$result=$m->add($data);
		}
		
		if($result>0)
		{
			$this->success('发布成功');
		}
		else
		{
			$this->error('发布失败');
		}
	}
	
	//上传略缩图
	private function imageUp()
	{
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->allowExts  = array('jpg','jpeg','png','gif','swf');// 设置附件上传类型
		$upload->savePath = C('UPLOAD_PATH').getUserDir('Images');// 设置附件上传目录
		$upload->maxSize=2097152;//单位K
		if($upload->upload())
		{
			$info =  $upload->getUploadFileInfo();
			return $info[0]['savename'];
		}
		else
		{
			$this->error('广告图上传失败，'.$upload->getErrorMsg());
		}
	}
	
	
	
	
}