<?php
/*
 *Ueditor编辑器处理类
 *@xulinyang
 */
class UeditorHandler
{
	public $savePath='';//图片保存地址
	public $managerPath=array();//在线管理地址，最好使用缩略图地址，否则当网速慢时可能会造成严重的延时
	public $maxSize=2097152;//上传最大尺寸，单位k
	public $basePath='';//基础地址,类似于前端修正地址
	public $ueditorPath='';//编辑器地址
	public $allowExts=array('jpg', 'gif', 'png', 'jpeg');//允许的格式
	
	//构造函数
	public function __construct() 
	{
		$this->basePath=C('UPLOAD_PATH');
		$this->ueditorPath=C('UEDITOR_PATH');
	}
	
	//图片上传
	public function imageUp()
	{
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->allowExts  = $this->allowExts;// 设置附件上传类型
		$upload->savePath = $this->basePath.$this->savePath;// 设置附件上传目录
		$upload->maxSize=$this->maxSize;
		if($upload->upload()){
			$info =  $upload->getUploadFileInfo();
			echo json_encode(array(
					'url'=>$this->savePath.$info[0]['savename'],
					'title'=>htmlspecialchars($_POST['pictitle'], ENT_QUOTES),
					'original'=>$info[0]['name'],
					'state'=>'SUCCESS'
			));
		}else{
			echo json_encode(array(
					'state'=>$upload->getErrorMsg()
			));
		}
	}
	
	//在线管理
	public function imageManager()
	{
		$action = htmlspecialchars( $_POST[ "action" ] );
		$paths=$this->managerPath;
		if ( $action == "get" ) 
		{
			$files = array();
			foreach ( $paths as $path)
			{
				$tmp = $this->getfiles( $path );
				if($tmp)
				{
					$files = array_merge($files,$tmp);
				}
			}
			if ( !count($files) ) return;
			rsort($files,SORT_STRING);
			$str = "";
			foreach ( $files as $file ) 
			{
				$str .= $file . "ue_separate_ue";
			}
			echo $str;
		}
	}
	
	//涂鸦上传
	public function scrawlUp()
	{
		//获取当前上传的类型
		$action = htmlspecialchars( $_GET[ "action" ] );
		$tmpPath = $this->basePath.$this->savePath."tmp/";//临时文件目录
		
		if ( $action == "tmpImg" ) 
		{	
			// 背景上传
			import('ORG.Net.UploadFile');
			$upload = new UploadFile();// 实例化上传类
			$upload->allowExts  = $this->allowExts;// 设置附件上传类型
			$upload->savePath = $tmpPath;// 设置附件上传目录
			$upload->maxSize=$this->maxSize;
			if($upload->upload())
			{
				$info =  $upload->getUploadFileInfo();
				echo "<script>parent.ue_callback('" . $this->savePath."tmp/".$info[0]['savename'] . "','" . "SUCCESS" . "')</script>";
			}
			else 
			{
				echo "<script>parent.ue_callback('" . $this->savePath."tmp/".$info[0]['savename'] . "','" . $upload->getErrorMsg() . "')</script>";
			}
			
		} 
		else 
		{
			//涂鸦上传，上传方式采用了POST base64编码模式
			$info=$this->base64ToImage($_POST['content']);
			//上传成功后删除临时目录
			if(file_exists($tmpPath))
			{
				$this->delDir($tmpPath);
			}
			echo "{'url':'" . $this->savePath.$info[ "name" ] . "',state:'" . $info[ "state" ] . "'}";
		}		
		
	}
	
	//附件上传
	public function fileUp()
	{
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->allowExts  = $this->allowExts;// 设置附件上传类型
		$upload->savePath = $this->basePath.$this->savePath;// 设置附件上传目录
		$upload->maxSize=$this->maxSize;
		if($upload->upload()){
			$info =  $upload->getUploadFileInfo();
			echo json_encode(array(
					'url'=>$this->savePath.$info[0]['savename'],
					'fileType'=>$info[0]['type'],
					'original'=>$info[0]['name'],
					'state'=>'SUCCESS'
			));
		}else{
			echo json_encode(array(
					'state'=>$upload->getErrorMsg()
			));
		}
	}
	
	//远程图片抓取
	public function getRemoteImage()
	{
		$uri = htmlspecialchars( $_POST[ 'upfile' ] );
		$uri = str_replace( "&amp;" , "&" , $uri );
		//抓取时间限制3分钟
		set_time_limit( 180 );
		//ue_separate_ue  ue用于传递数据分割符号
		$imgUrls = explode( "ue_separate_ue" , $uri );
		$tmpNames = array();
		foreach ( $imgUrls as $imgUrl ) {
			//http开头验证
			if(strpos($imgUrl,"http")!==0){
				array_push( $tmpNames , "error" );
				continue;
			}
			//获取请求头
			$heads = get_headers( $imgUrl );
			//死链检测
			if ( !( stristr( $heads[ 0 ] , "200" ) && stristr( $heads[ 0 ] , "OK" ) ) ) {
				array_push( $tmpNames , "error" );
				continue;
			}
			//格式验证(扩展名验证和Content-Type验证)
			$fileType = strtolower( strrchr( $imgUrl , '.' ) );
			$fileType=substr($fileType, 1,strlen($fileType)-1);
			if ( !in_array( $fileType , $this->allowExts) || stristr( $heads[ 'Content-Type' ] , "image" ) ) 
			{
				array_push( $tmpNames , "error" );
				continue;
			}
		
			//打开输出缓冲区并获取远程图片
			ob_start();
			$context = stream_context_create(
					array (
							'http' => array (
									'follow_location' => false // don't follow redirects
							)
					)
			);
			//请确保php.ini中的fopen wrappers已经激活
			readfile( $imgUrl,false,$context);
			$img = ob_get_contents();
			ob_end_clean();
		
			//大小验证
			$uriSize = strlen( $img ); //得到图片大小
			if ( $uriSize > $this->maxSize ) {
				array_push( $tmpNames , "error" );
				continue;
			}
			//写入文件
			$tmpName = $this->savePath.uniqid().'.'.$fileType;
			$tmpName2= $this->basePath.$tmpName;
			try {
				$fp2 = @fopen( $tmpName2 , "a" );
				fwrite( $fp2 , $img );
				fclose( $fp2 );
				array_push( $tmpNames ,  $tmpName );
			} catch ( Exception $e ) {
				array_push( $tmpNames , "error" );
			}
		}
		/**
		 * 返回数据格式
		 * {
		 *   'url'   : '新地址一ue_separate_ue新地址二ue_separate_ue新地址三',
		 *   'srcUrl': '原始地址一ue_separate_ue原始地址二ue_separate_ue原始地址三'，
		 *   'tip'   : '状态提示'
		 * }
		 */
		echo "{'url':'" . implode( "ue_separate_ue" , $tmpNames ) . "','tip':'远程图片抓取成功！','srcUrl':'" . $uri . "'}";
	}
	
	//遍历文件
	private function getfiles( $path , &$files = array() )
    {
        if ( !is_dir( $this->basePath.$path ) ) return null;
        $handle = opendir( $this->basePath.$path );
        while ( false !== ( $file = readdir( $handle ) ) ) 
        {
            if ( $file != '.' && $file != '..' ) 
            {
                $path2 = $path . '/' . $file;
                if ( is_dir( $this->basePath.$path2 ) ) 
                {
                    $this->getfiles( $path2 , $files );
                } 
                else 
                {
                    if ( preg_match( '/\.(gif|jpeg|jpg|png|bmp)$/i' , $file ) ) 
                    {
                        $files[] = $path2;
                    }
                }
            }
        }
        return $files;
    }
    
    //处理64位图像数据上传
    private function base64ToImage( $base64Data )
    {
    	$img = base64_decode( $base64Data );
    	$fileName = uniqid(). ".png";
    	$fullName = $this->basePath.$this->savePath. $fileName;
    	if ( !file_put_contents( $fullName , $img ) ) 
    	{
    		$state='输入输出错误';
    	}
    	else
    	{
    		$state='SUCCESS';
    	}
    	$info['state']=$state;
    	$info['name']=$fileName;
    	return $info;
    }
    
    //删除整个目录
    private function delDir( $dir )
    {
    	//先删除目录下的所有文件：
    	$dh = opendir( $dir );
    	while( $file = readdir( $dh ) ) 
    	{
    		if ( $file != "." && $file != ".." )
    		{
    			$fullpath = $dir . "/" . $file;
    			if ( !is_dir( $fullpath ) ) 
    			{
    				unlink( $fullpath );
    			} 
    			else 
    			{
    				$this->delDir( $fullpath );
    			}
    		}
    	}
    	closedir( $dh );
    	//删除当前文件夹：
    	return rmdir( $dir );
    }
}
