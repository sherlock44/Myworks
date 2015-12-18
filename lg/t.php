<?php
require_once './db.php';exit;
$sql = 'SELECT nickname,sex,province,city,headimgurl,truename,tel FROM brc140910_userinfo ORDER BY tel DESC';
$query = $db->query($sql);
$fileName = date('Y-m-d-H:i:s').'.csv';
$filePath = dirname(__FILE__).'/file/'.$fileName;
$handle = fopen($filePath, 'w');
flock($handle, LOCK_EX);
fwrite($handle, pack('H*','EFBBBF'));
$title = array('微信昵称','性别','省','市','头像','姓名','电话');
fputcsv($handle,$title);
while($row = $query->fetch_row())
{
	$sex = '';
	switch ($row[1])
	{
		case 0:
			$sex = '未知';
			break;
		case 1:
			$sex = '男';
			break;
		case 2:
			$sex = '女';
			break; 
	}
	$row[1] = $sex;
	fputcsv($handle,$row);
}
flock($handle, LOCK_UN);
fclose($handle);
$downurl = $_SERVER['HTTP_HOST'].'/brc140910/file/'.$fileName;
header("Location: http://$downurl");