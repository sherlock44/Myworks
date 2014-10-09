<?php
require_once './db.php';exit;
$sql = 'SELECT p.title AS prize,u.nickname,u.sex,u.province,u.city,u.truename,u.tel,u.item';
$sql .= ' FROM brc140910_take AS t,brc140910_prize_list AS p,brc140910_userinfo AS u ';
$sql .= ' WHERE t.prizeid > 0 AND t.prizeid = p.id AND t.uid = u.id';
$query = $db->query($sql);
$fileName = date('Y-m-d-H:i:s').'.csv';
$filePath = dirname(__FILE__).'/file/'.$fileName;
$handle = fopen($filePath, 'w');
flock($handle, LOCK_EX);
fwrite($handle, pack('H*','EFBBBF'));
$title = array('奖品','微信昵称','性别','省','市','姓名','电话','领奖项目');
fputcsv($handle,$title);
while($row = $query->fetch_row())
{
	$sex = '';
	switch ($row[2])
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
	$row[2] = $sex;
	fputcsv($handle,$row);
}
flock($handle, LOCK_UN);
fclose($handle);
$downurl = $_SERVER['HTTP_HOST'].'/brc140910/file/'.$fileName;
header("Location: http://$downurl");