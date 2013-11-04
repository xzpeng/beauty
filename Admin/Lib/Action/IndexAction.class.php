<?php 
class IndexAction extends CommonAction
{
	public function index()
	{
		$this->assign('myIp',get_client_ip());
		$this->assign('adInfo',$this->getAdminInfo());
		$this->display();
	}
	
	private function getAdminInfo()
	{
		$info=null;
		$info['adName']=session('adName');
		$info['adPost']=session('adPost');
		return $info;
	}
}
?>