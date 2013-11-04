<?php
/*///////////////////////////////////////////////////////////
 @xulinyang  session 数据库处理方式驱动
//////////////////////////////////////////////////////////*/

defined('THINK_PATH') or exit();
class SessionDb {
	//Session有效时间
	protected $lifeTime      = '';
	//session保存的数据库名
	protected $sessionTable  = '';
	//数据库句柄
	protected $hander;
	//更新记录延迟时间
	protected $delay;//s
	//客户端IP
	protected $clientIp;//客户端IP
	//现在时间
	protected $nowTime;//现在时间
	 
	//打开Session
	public function open($savePath, $sessName) {
		$this->lifeTime = C('SESSION_EXPIRE')?C('SESSION_EXPIRE'):ini_get('session.gc_maxlifetime');
		$this->sessionTable  =   C('SESSION_TABLE')?C('SESSION_TABLE'):C("DB_PREFIX")."session";
		$this->delay=C('SESSION_UPDATE_DELAY')?C('SESSION_UPDATE_DELAY'):0;
		try{
			$dsn=C('DB_DSN')?C('DB_DSN'):"mysql:host=".C('DB_HOST').";dbname=".C('DB_NAME');
			$hander=new PDO($dsn,C('DB_USER'),C('DB_PWD'));
		}catch(PDOException $e){
			return false;
		}
		$this->hander = $hander;
		$this->clientIp=get_client_ip();
		$this->nowTime=time();
		$this->setConfig();
		return true;
	}

	//关闭session
	public function close() {
		return true;
	}

	//读取session
	public function read($sessID) {
		$result=$this->selectSession($sessID);
		//记录不能为空
		if(!$result){
			return "";
		}
		//客户端IP一致性
		if($result["ip"]!=$this->clientIp){
			return "";
		}
		//是否过期
		if($this->nowTime>$result["life_time"]+$result["update_time"]){
			$this->destroy($sessID);
			return "";
		}
		//返回数据
		return $result["data"];
	}

	//写入session
	public function write($sessID,$sessData) {
		if($_SESSION['life_time'])
		{
			$this->lifeTime=$_SESSION['life_time'];
		}
		$result=$this->selectSession($sessID);
		//记录是否存在，存在则更新，否则插入一条新记录
		if($result){
	  //$sessData数据发生变化时或更新时间达到延迟时间时执行更新
	  if($sessData!=$result['data'] || $this->nowTime>$result["update_time"]+$this->delay){
	  	$sql="update ".$this->sessionTable." set life_time=?,update_time=?,data=? where sid=?";
	  	$stmt=$this->hander->prepare($sql);
	  	$result=$stmt->execute(array($this->lifeTime,$this->nowTime,$sessData,$sessID));
	  	return $result;
	  }
		}else{
	  //数据不为空
	  if(!empty($sessData)){
	  	$sql="insert into ".C('SESSION_TABLE')."(sid,ip,life_time,update_time,data) values(?,?,?,?,?)";
	  	$stmt=$this->hander->prepare($sql);
	  	$result=$stmt->execute(array($sessID,$this->clientIp,$this->lifeTime,$this->nowTime,$sessData));
	  	return $result;
	  }
		}
		return false;
	}

	//删除session
	public function destroy($sessID) {
		$sql="delete from ".$this->sessionTable.' where sid=?';
		$stmt=$this->hander->prepare($sql);
		$result=$stmt->execute(array($sessID));
		$_SESSION=array();//清空session
		if(isset($_COOKIE[session_name()])){
			setCookie(session_name(),'',time()-3600,'/');
		}
		return $result;
	}

	//session垃圾回收器
	public function gc($sessMaxLifeTime) {
		$sql="delete from ".$this->sessionTable." where life_time+update_time<?";
		$stmt=$this->hander->prepare($sql);
		$result=$stmt->execute(array($this->nowTime));
		return $result;
	}

	//执行驱动
	public function execute() {
		ini_set('session.save_handler', 'user');
		session_set_save_handler(array(&$this,"open"),
		array(&$this,"close"),
		array(&$this,"read"),
		array(&$this,"write"),
		array(&$this,"destroy"),
		array(&$this,"gc"));
	}

	//查询session数据表,返回关联数组
	private function selectSession($sessID){
		$sql="select ip,life_time,data,update_time from ".$this->sessionTable." where sid=?";
		$stmt=$this->hander->prepare($sql);
		$stmt->execute(array($sessID));
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	//session配置项
	private function setConfig(){
		//回收几率,SESSION_GC_PROBABILITY/SESSION_GC_DIVISOR;
		if(C('SESSION_GC_PROBABILITY')){
			ini_set('session.gc_probability',C('SESSION_GC_PROBABILITY'));
		}
		if(C('SESSION_GC_DIVISOR')){
			ini_set('session.gc_divisor',C('SESSION_GC_DIVISOR'));
		}
		//SID
		if(C('SESSION_USE_TRANS_SID')){
			ini_set('session.use_trans_sid',C('SESSION_USE_TRANS_SID'));
		}
	}
}