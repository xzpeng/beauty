<?php
class AdministratorAction extends  CommonAction
{
	public function index()
	{
		$this->display();
	}
	
	
	public function login()
	{
		if(session('?aid'))
		{
			//已登录
			$this->redirect('Index/index');//跳转到管理首页
			return;
		}
		$this->display();
	}
	
	//执行登录
	public function doLogin()
	{
		$list=$_POST;
		if(md5(strtoupper($list['verify']))!=session('verify'))
		{
			return $this->error('验证码错误',__APP__.'/Administrator/login');
		}
		else
		{
			session('verify',null);
			session('life_time',null);
		}
		
		if(session('?aid'))
		{
			$this->error('不允许重复登录');
		}
		
		if($list['adName'])
		{
			$m=M('administrator');
			$info['adName']=$list['adName'];
			$result=$m->where($info)->find();
			if($result&&$result['password']==md5($list['password']))
			{
				//登录ip限制
				if($result['ips'])
				{
					$myip=get_client_ip();
					$ips=explode(';', $result['ips']);
					if(!in_array($myip, $ips))
					{
						return $this->error('限制登录',__APP__.'/Administrator/login');
					}
				}
				
				//30天自动登录
				if($list['autoLogin'])
				{
					session('life_time',2592000);
				}
				session('adName',$result['adName']);
				session('aid',$result['id']);
				session('adPost',$result['adPost']);
				$url=__APP__.'/Index/index';
				if($list['redirect'])
				{
					$url=$list['redirect'];
				}
				return $this->success('登录成功',$url);//跳转到后台首页
			}
			else 
			{
				return $this->error('用户名或密码错误',__APP__.'/Administrator/login');
			}
		}
		else 
		{
			return $this->error('用户名不能为空',__APP__.'/Administrator/login');
		}
		
	}
	
	//退出登录
	public function logout()
	{
		session('[destroy]');
		return $this->success('退出成功',__APP__.'/Administrator/login');
	}
}