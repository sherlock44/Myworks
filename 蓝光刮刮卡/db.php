<?php
header('Content-Type:text/html; Charset=utf-8');
date_default_timezone_set('PRC');
#error_reporting(E_ALL);
#ini_set('display_errors', '1');
#ini_set('max_execution_time', '3600');
$db = @new mysqli('localhost', 'root', 'eebce7027d', 'minisite',3306);
if($db->connect_error){
	die('Connect Error ('.$db->connect_errno.')'.$db->connect_error);
}
$db->set_charset('utf8');
//$db->query('SET NAMES "utf8"');
define('WECHAT_APPID','wx415df310c5d6d511');
define('WECHAT_APP_SECRET','3719358ba7188484ba708614a27177c8');
define('START_DATE',strtotime('2014-09-09'));
define('END_DATE',strtotime('2014-10-05'));
define('NOW_DATE',time());
define('MAX_NUM',5);//每天最大参与次数
session_start();
require_once './function.php';