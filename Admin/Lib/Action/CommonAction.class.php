<?php
class CommonAction extends Action
{
	public function _initialize()
	{
		if(MODULE_NAME=='Administrator' && (ACTION_NAME=='login' || ACTION_NAME=='doLogin'))
		{
			//登录动作
		}
		else
		{
			$this->checkLogin();//检查登录状态
		}
		
	}
	
	private function checkLogin()
	{
		if(isset($_GET['session_id']))
		{
			session_id($_GET['session_id']);
		}
		if(session('?aid'))
		{
			//已登录
		}
		else
		{
			$this->error('登录超时，请重新登录！',__APP__.'/Administrator/login');
		}
	}
	
	
}