<?php
//跨应用公共函数库

//是否是今天内
function isInToday($time)
{
	$list=explode('-',date('Y-m-d'));
	$today=mktime(0,0,0,$list[1],$list[2],$list[0]);
	$tmp=$time-$today;
	if($tmp>=0)
	{
		return true;
	}
	return false;
}

//获取用户存储空间Admin/1/$child/格式
function getUserDir($child='',$uid=0,$model='')
{
	if($uid>0)
	{
		$id=$uid;
	}
	else
	{
		$id=session('aid')?session('aid'):session('uid');
	}
	
	$app=$model?$model:APP_NAME;
	if($child)
	{
		return $app.'/'.$id.'/'.$child.'/';
	}
	else
	{
		return $app.'/'.$id.'/';
	}
}

//删除整个目录
function delDir( $dir )
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
				delDir( $fullpath );
			}
		}
	}
	closedir( $dh );
	//删除当前文件夹：
	return rmdir( $dir );
}

//返回当前年龄
function getAge($time)
{
	$d=date('Y-m-d',$time);
	$list=explode('-', $d);
	$now=getdate();
	$age=$now['year']-$list[0]-1;
	if($list[1]<=$now['mon'])
	{
		if($list[2]<=$now['mday'])
		{
			$age+=1;
		}
	}
	return $age;
}

//返回大概时间描述
function getTimeStr($time)
{
	$num=time()-$time;
	$val='';
	if($num<60)
	{
		$val=$num.'秒';
		return $val;
	}
	if($num/60<60)
	{
		$val=round($num/60).'分钟';
		return $val;
	}
	if($num/3600<24)
	{
		$val=round($num/3600).'小时';
		return $val;
	}
	if($num/86400<30)
	{
		$val=round($num/86400).'天';
		return $val;
	}
	if($num/2592000<12)
	{
		$val=round($num/2592000).'月';
		return $val;
	}
	else
	{
		$val=round($num/31104000).'年';
		return $val;
	}

}

function getSex($sex)
{
	switch ($sex)
	{
		case '1':return '男';break;
		case '2':return '女';break;
		default:return '保密';break;
	}
}

function getMarital($marital)
{
	switch ($marital)
	{
		case '1':return '已婚';break;
		case '2':return '未婚';break;
		default:return '保密';break;
	}
}

function getEdu($edu)
{
	switch ($edu)
	{
		case 1: return '初中及以下';break;
		case 2: return '高中';break;
		case 3: return '中专/技校';break;
		case 4: return '大专';break;
		case 5: return '本科';break;
		case 6: return '硕士及以上';break;
		default:return '保密';
	}
}

function getPicture($pic)
{
	if($pic)
	{
		return getUserDir('Picture').$pic;
	}
	else
	{
		return 'System/default__picture.png';
	}
}


//输出信息写入HTML
function traceHtml($str,$path='./')
{
	$con='';
	if(file_exists($path.'trace.html'))
	{
		$con=file_get_contents($path.'trace.html').'<br/>';
	}
	$fp=fopen($path.'trace.html', 'w+');
	fwrite($fp, $con.$str);
	fclose($fp);
}