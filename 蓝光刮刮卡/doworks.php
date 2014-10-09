<?php
require_once './db.php';
$outResult['state'] = 'Failure';
$outResult['message'] = '';
if(!isset($_SESSION['openid'])){
	$outResult['message'] = '认证失败!';
	echo json_encode($outResult);exit;
}
//获取用户信息
$sql = 'SELECT * FROM `brc140910_userinfo` WHERE `openid`="'.$db->real_escape_string($_SESSION['openid']).'" LIMIT 1';
$query = $db->query($sql);
if(0 == $query->num_rows){
	$outResult['message'] = '用户无效!';
	echo json_encode($outResult);exit;
}
$userInfo = $query->fetch_assoc();
$query->free();
//用户当天参与信息
$sql = "SELECT COUNT(*) AS num FROM `brc140910_take` WHERE `uid`='{$userInfo['id']}' AND `dt` = '".date('Y-m-d',NOW_DATE)."'";
$query = $db->query($sql);
$result = $query->fetch_assoc();
$query->free();
if($result['num'] >= MAX_NUM){
	$outResult['message'] = '今天参与次数已用完,请明天继续!';
	echo json_encode($outResult);exit;
}
//设置默认奖品
$defaultPrize = array('id'=>0,'title'=>'谢谢参与');
//获取奖品列表
$sql = 'SELECT * FROM `brc140910_prize_list`';
$query = $db->query($sql);
$prizeList = array();
while ($row = $query->fetch_assoc())
{
	$prizeList[] = $row;
}
$query->free();
//按照奖品中奖概率升序排序
$prizeList = arrOrder($prizeList,'probability');
//累加中奖中概率
$probabilitySum = 0;
foreach ($prizeList as $r)
{
	$probabilitySum += intval($r['probability']);
}
if(!$probabilitySum){
	$outResult['message'] = '系统出错,请与管理员联系!';
	echo json_encode($outResult);exit;
}
//根据概率获取中奖奖品
$prizeResult = $defaultPrize;
reset($prizeList);
foreach ($prizeList as $r)
{
	$randNum = mt_rand(1, $probabilitySum);
	if ($randNum <= $r['probability']){
		$prizeResult = $r;
		break;
	}else{
		$probabilitySum -= $r['probability'];
	}
}
if($prizeResult['id']){
	//获取本次抽中的奖品总配额,如果已使用完,则替换本次奖品为谢谢参与
	$sql = "SELECT COUNT(*) AS num FROM `brc140910_take` WHERE `prizeid`='{$prizeResult['id']}'";
	$query = $db->query($sql);
	$result = $query->fetch_assoc();
	$useAmount = $result['num'];
	$query->free();
	//计算活动总共进行天数
	$activityDay = intval((END_DATE-START_DATE)/86400);
	//活动已进行天数
	$spendDay = floor((NOW_DATE-START_DATE)/86400);
	$spendDay = $spendDay ? $spendDay+1 : 1;
	//截止当前日期该奖品最多允许抽取的数量
	$prizeMaxNum = ceil($prizeResult['amount']/$activityDay*$spendDay);
	if($prizeMaxNum <= $useAmount || $useAmount >= $prizeResult['amount']){
		$prizeResult = $defaultPrize;//配额已使用完,替换本次奖品为谢谢参与
	}
}
$sql = 'INSERT INTO `brc140910_take`(`uid`,`prizeid`,`created`,`dt`) VALUES ('.$userInfo['id'];
$sql .= ','.$prizeResult['id'].','.NOW_DATE.',"'.date('Y-m-d',NOW_DATE).'")';
$db->query($sql);
$prizeResult['insert'] = $db->insert_id;
$db->close();
if(isset($prizeResult['probability'])){
	unset($prizeResult['probability'],$prizeResult['amount']);
}
$outResult['state'] = 'Success';
$outResult['prize'] = $prizeResult;
echo json_encode($outResult);