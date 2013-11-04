<?php
return array
(
	//'配置项'=>'配置值'
	'TMPL_L_DELIM'=>'<{', //修改左定界符
	'TMPL_R_DELIM'=>'}>', //修改右定界符
	//'DB_TYPE'=>'mysql',   //设置数据库类型
	'DB_TYPE'=>'PDO',//数据库驱动类型
	
	//'DB_DSN'=> 'mysql:host=id67.free.yunhosting.net;dbname=meiren1520',//PDO驱动参数
	//'DB_HOST'=>'id67.free.yunhosting.net',//设置主机
	//'DB_NAME'=>'meiren1520',//设置数据库名
	//'DB_USER'=>'meiren1520',    //设置用户名
	//'DB_PWD'=>'PPowuwHtKJ',        //设置密码
	'DB_DSN'=> 'mysql:host=localhost;dbname=ncms',//PDO驱动参数
	'DB_HOST'=>'localhost',//设置主机
	'DB_NAME'=>'ncms',//设置数据库名
	'DB_USER'=>'root',    //设置用户名
	'DB_PWD'=>'',        //设置密码
	
	'DB_PORT'=>'3306',   //设置端口号
	'DB_PREFIX'=>'nc_',  //设置表前缀
	'SESSION_TYPE'=>'db',//session保存至数据库
	//'SHOW_PAGE_TRACE'=>true,//开启页面Trace
	'UPLOAD_PATH'=>'./Public/Uploads/',//默认存储位置
	'UEDITOR_PATH'=>'./Public/Ueditor/',//默认编辑器位置	
	'PROTECT_TYPE'=>array(33,34),//受保护的分类
	'PROTECT_ARTICLE'=>array(1,2,3,4,5,6),//受保护的文章
);