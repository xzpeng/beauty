<?php
class UserAction extends CommonAction
{	
	private $field=array('id','userName','password','email','nickName','sex','birthday','qq','rna','loginTime','loginDays','picture','name');
	
	public function regis()
	{
		$this->assign('pageTitle','注册中心');
		$this->display();
	}
	
	//登录
	public function doLogin()
	{
		$list=$_POST;
		if(md5(strtoupper($list['verify']))!=session('verify'))
		{
			return $this->error('验证码错误');
		}
		else
		{
			session('verify',null);
			session('life_time',null);
		}
		
		if(session('?uid'))
		{
			$this->error('不允许重复登录');
		}
		
		if($list['userName'])
		{
			$m=M('user');
			$data['userName']=$list['userName'];
			$result=$m->where($data)->field($this->field)->find();
			if($result&&$result['password']==md5($list['password']))
			{
				if($list['autoLogin'])
				{
					session('life_time',2592000);
				}
				$this->writeLoginInfo($result);
				$this->success('登录成功');
			}
			else 
			{
				$this->error('用户名或密码错误');
			}
		}
		else
		{
			$this->error('用户名不能为空');
		}
	}
	
	//退出
	public function loginout()
	{
		session('[destroy]');
		$this->success('退出成功',__APP__.'/Index/index');
	}
	
	//写入登录信息
	private function writeLoginInfo($result)
	{
		foreach ($result as $key=>$val)
		{
			if($key=='id')
			{
				session('uid',$val);
			}
			else
			{
				$nos=array('password','rna','IDCard','address','zip','job','picture','cover','loginTime','loginDays');
				if(!in_array($nos, $key))
				{
					session($key,$val);
				}
			}
		}
	}
	
	//修改资料
	public function doEditData()
	{
		$list=$_POST;
		$m=M('user');
		$rna=$m->where('id='.$list['id'])->getField('rna');
		$this->checkFormat($list,false,!empty($rna));
		//实名认证后真实姓名、性别、出生日期、地区、身份证号、身份证照片等不可修改
		if(empty($rna))
		{
			$data['sex']=$list['sex'];
			$data['birthday']=$list['birthday'];
			$data['name']=$list['name'];
			$data['area']=$list['area'];
		}
		$data['nickName']=$list['nickName']?trim($list['nickName']):$data['userName'];
		$data['email']=$list['email'];
		$data['height']=$list['height'];
		$data['weight']=$list['weight'];
		$data['measure1']=$list['measure1'];
		$data['measure2']=$list['measure2'];
		$data['measure3']=$list['measure3'];
		$data['edu']=$list['edu'];
		$data['mphone']=$list['mphone'];
		$data['qq']=$list['qq'];
		$data['job']=$list['job'];
		$data['workRemark']=$list['workRemark'];
		$data['marital']=$list['marital']?$list['marital']:0;
		$data['address']=$list['address'];
		$data['wburl']=$list['wburl'];
		$data['zip']=$list['zip'];
		$result=$m->where('id='.$list['id'])->save($data);
		if($result>0)
		{
			$this->success('保存成功');
		}
		else
		{
			$this->error('保存失败');
		}	
	}
	
	
	//注册
	public function doRegis()
	{
		$list=$_POST;
		$this->checkFormat($list);
		$data['userName']=trim($list['userName']);
		$data['nickName']=$list['nickName']?trim($list['nickName']):$data['userName'];
		$data['password']=md5($list['password']);
		$data['email']=$list['email'];
		$data['sex']=$list['sex'];
		$data['birthday']=$list['birthday'];
		$data['height']=$list['height'];
		$data['weight']=$list['weight'];
		$data['measure1']=$list['measure1'];
		$data['measure2']=$list['measure2'];
		$data['measure3']=$list['measure3'];
		$data['edu']=$list['edu'];
		$data['name']=$list['name'];
		$data['area']=$list['area'];
		$data['zip']=$list['zip'];
		$data['mphone']=$list['mphone'];
		$data['qq']=$list['qq'];
		$data['job']=$list['job'];
		$data['workRemark']=$list['workRemark'];
		$data['marital']=$list['marital']?$list['marital']:0;
		$data['address']=$list['address'];
		$data['regTime']=time();
		$data['wburl']=$list['wburl'];
		$m=M('user');
		$result=$m->add($data);
		if($result>0)
		{
			//为用户创建存储空间
			$base=C('UPLOAD_PATH').'Home/';
			if(!file_exists($base))
			{
				mkdir($base);
			}
			if(!file_exists($base.$result.'/'))
			{
				mkdir($base.$result.'/');
				mkdir($base.$result.'/Picture/');
				mkdir($base.$result.'/Images/');
				mkdir($base.$result.'/IDCard/');
				mkdir($base.$result.'/Files');
			}
			$loginInfo=$m->where('id='.$result)->field($this->field)->find();
			$this->writeLoginInfo($loginInfo);//直接登录
			$this->success('用户名：'.$list['userName'].'<br/>恭喜你！注册成功',__APP__.'/Center/index');
		}
		else
		{
			$this->error('注册失败，请重试！');
		}
	}
	
	//检查格式
	private  function checkFormat($list,$first=true,$rna=false)
	{
		//首次注册将会检查用户名和密码的合法性
		if($first)
		{
			if(empty($list['userName']))
			{
				$this->error('用户名不能为空');
			}
			if(strlen($list['userName'])<9)
			{
				$this->error('用户名不能小于9位');
			}
			if(strlen($list['userName'])>30)
			{
				$this->error('用户名不能大于30位');
			}
			if(!$this->hasUserName('userName',$list["userName"]))
			{
				$this->error('用户名已经存在，请重新更换一个用户名');
			}
			
			if($list["password"]!=$list['password2'])
			{
				$this->error('两次输入的密码不一致');
			}
			
			if($this->isAllNumber($list['password']))
			{
				$this->error('密码不能由纯数字组成');
			}
			
			if(strlen($list['password'])<6)
			{
				$this->error('密码不能小于6位');
			}
			
			if(strlen($list['password'])>16)
			{
				$this->error('密码不能大于16位');
			}
		}
		
		if(!$rna)
		{
			if(!$this->isNotEmpty($list,array('name','birthday','area')))
			{
				$this->error('请检查表单是否填写完整');
			}
				
			if(!$this->isNotNull($list,array('sex')))
			{
				$this->error('请检查表单是否填写完整');
			}
		}
		
		if(intval($list['height'])>400)
		{
			$this->error('身高数值不合法');
		}
		
		if(!preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/",$list['mphone']))
		{
			$this->error('手机号码格式不正确');
		}
		
		if(!preg_match("/^\s*[.0-9]{5,10}\s*$/",$list['qq']))
		{
			$this->error('QQ格式不正确');
		}
		
		if(!preg_match("/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/",$list['email']))
		{
			$this->error('邮箱地址格式不正确');
		}
		
		if(empty($list['wburl']))
		{
			$this->error('微博地址不能为空');
		}
		
		if(!$this->isNotEmpty($list,array('address')))
		{
			$this->error('请检查详细地址是否填写完整');
		}
			
		if(!$this->isNotNull($list,array('edu')))
		{
			$this->error('请选择学历选项');
		}
	}
	
	//检测用户名可用性
	public function checkUserName()
	{
		if($this->hasUserName('userName',$_POST['userName']))
		{
			$this->ajaxReturn(null,'',1);//返回
		}
		else
		{
			$this->ajaxReturn(null,'',0);//返回
		}
	}
	
	//检测用户名是否存在
	private  function hasUserName($fieldName,$val)
	{
		$val=trim($val);
		$m=M('user');
		$result=$m->where($fieldName.'="'.$val.'"')->getField('userName');
		return empty($result);
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
	
	//不能为空
	private function isNotNull($arr1,$arr2)
	{
		for($i=0;$i<count($arr2);$i++)
		{
			if(!isset($arr1[$arr2[$i]]))
			{
				return false;
			}
		}
		
		return true;
	}
	
	//不能为false或空
	private function isNotEmpty($arr1,$arr2)
	{
		for($i=0;$i<count($arr2);$i++)
		{
			if(empty($arr1[$arr2[$i]]))
			{
				return false;
			}
		}
		
		return true;
	}


	//登录地址
	public function snsLogin($type = null){
		empty($type) && $this->error('参数错误');

		//加载ThinkOauth类并实例化一个对象
		import("ORG.ThinkSDK.ThinkOauth");
		$sns  = ThinkOauth::getInstance($type);

		//跳转到授权页面
		redirect($sns->getRequestCodeURL());
	}

	//授权回调地址
	public function callback($type = null, $code = null){
		(empty($type) || empty($code)) && $this->error('参数错误');
		
		//加载ThinkOauth类并实例化一个对象
		import("ORG.ThinkSDK.ThinkOauth");
		$sns  = ThinkOauth::getInstance($type);

		//腾讯微博需传递的额外参数
		$extend = null;
		if($type == 'tencent'){
			$extend = array('openid' => $this->_get('openid'), 'openkey' => $this->_get('openkey'));
		}

		//请妥善保管这里获取到的Token信息，方便以后API调用
		//调用方法，实例化SDK对象的时候直接作为构造函数的第二个参数传入
		//如： $qq = ThinkOauth::getInstance('qq', $token);
		$token = $sns->getAccessToken($code , $extend);

		//获取当前登录用户信息
		if(is_array($token)){
			$user_info = A('Type', 'Event')->$type($token);

			echo("<h1>恭喜！使用 {$type} 用户登录成功</h1><br>");
			echo("授权信息为：<br>");
			dump($token);
			echo("当前登录用户信息为：<br>");
			dump($user_info);
		}
	}
	
	
	
	
	
	
}