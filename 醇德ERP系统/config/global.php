<?php
/**
 * 系统配置文件
 * author:David Yan (yanwd@ivysoft.com.cn)
 * @version $Id: global.php  2012-01-21 23:00:00Z David Yan $
 *
 */
// 定义全局变量
global $configs;

// 数据库配置

// $configs['database'] = array(
// 	'data' => array(
// 		'Host' => 'localhost',
// 		'Port' => '3306',
// 		'User' => 'root',
// 		'Password' => 'xiaofukeji2015@',
// 		'Name' => 'imanage',
// 	),
// );
$configs['database'] = array(
	'data' => array(
		'Host' => 'localhost',
		'Port' => '3306',
		'User' => 'root',
		'Password' => '',
		'Name' => 'imanage',
	),
);

//自加载helper
$configs['autoLoadHelper'] = array('acl', 'js', 'arrayHelper');

return $configs;
?>