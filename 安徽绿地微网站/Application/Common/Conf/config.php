<?php
return array(
	'URL_MODEL'             =>  3,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => 'localhost', // 服务器地址
	'DB_NAME'   => 'WebApps', // 数据库名
	'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => 'eebce7027d', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => 'ldah_', // 数据库表前缀
);