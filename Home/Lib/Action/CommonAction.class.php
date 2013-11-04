<?php
class CommonAction extends Action
{
	public function _initialize()
	{
		if(session('?uid'))
		{
			$this->assign('isLogin','none');
			$this->assign('myInfo','block');
			
			//已登录并进行登录统计，此操作对数据库有一定压力
			if(C('LOGIN_COUNT'))
			{
				$m=M('user');
				$result=$m->where('id='.session('uid'))->getField('loginTime');
				if(!isInToday($result))
				{
					$m->where('id='.session('uid'))->setInc('loginDays',1);//记录登录天数
				}
				$data['loginTime']=time();
				$m->where('id='.session('uid'))->save($data);
			}
			
		}
		else
		{
			if(MODULE_NAME=='Center')
			{
				$this->error('登录超时，请重新登录！');
			}
			$this->assign('isLogin','block');
			$this->assign('myInfo','none');
		}
		$m=M('user');
		$userInfo=$m->where('id='.session('uid'))->field(array('picture','rna','loginDays'))->find();
		$this->assign('userName',session('userName'));
		$this->assign('picture',getPicture($userInfo['picture']));
		$this->assign('rna',$userInfo['rna']);
		$this->assign('loginDays',$userInfo['loginDays']);
		$this->assign('nickName',session('nickName'));
		$this->assign('uid',session('uid'));
		$this->assign('birthday',session('birthday'));
		$this->assign('sex',getSex(session('sex')));
	}
	
}