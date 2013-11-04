<?php
$public=require './config.php';
define('URL_CALLBACK', "http://beauty.local/index.php/User/callback?type=");
$private=array
(
	//'配置项'=>'配置值'
	'SESSION_TABLE'=>'nc_home_session',//session保存位置
	'SESSION_EXPIRE'=>'1200',//session生存时间
	'LOGIN_COUNT'=>true,//实时在线统计（对数据库有一定压力）
    //腾讯QQ登录配置
    'THINK_SDK_QQ' => array(
        'APP_KEY'    => '1101085750', //应用注册成功后分配的 APP ID
        'APP_SECRET' => 'iN3EWMRI5AmD0s4a', //应用注册成功后分配的KEY
        'CALLBACK'   => URL_CALLBACK . 'qq',
    ),
    //腾讯微博配置
    'THINK_SDK_Tencent' => array(
        'APP_KEY'    => '801436977', //应用注册成功后分配的 APP ID
        'APP_SECRET' => 'cb4b2abf76cb22047725160740c0ad94', //应用注册成功后分配的KEY
        'CALLBACK'   => URL_CALLBACK . 'tencent',
    ),
);

return array_merge($private,$public);