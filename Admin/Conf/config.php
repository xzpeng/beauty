<?php
$public=require './config.php';
$private=array
(
	//'配置项'=>'配置值'
	'SESSION_TABLE'=>'nc_admin_session',//session保存位置
	'SESSION_EXPIRE'=>'1200',//session生存时间
);

return array_merge($private,$public);