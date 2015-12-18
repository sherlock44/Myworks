<?php
require_once './db.php';
$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
if(strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false ){
	exit('请使用微信浏览器打开');
}
if(!isset($_SESSION['openid'])){
	echo '<script type="text/javascript">';
	echo 'window.location.href="index.php"';
	echo '</script>';
}
//获取用户信息
$sql = 'SELECT * FROM `brc140910_userinfo` WHERE `openid`="'.$db->real_escape_string($_SESSION['openid']).'" LIMIT 1';
$query = $db->query($sql);
if(0 == $query->num_rows){
	exit('用户无效!');
}
$userInfo = $query->fetch_assoc();
$query->free();
$sql = 'SELECT t.created,p.title FROM brc140910_take AS t,brc140910_prize_list AS p WHERE t.prizeid > 0 AND';
$sql .= ' t.prizeid = p.id AND t.uid = '.$userInfo['id'];
$query = $db->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>蓝光BRC</title>
    <link rel="stylesheet" type="text/css" href="css/css.css?v=1"/>
</head>
    <body>
        <div class="conter">
             <div class="top"><img src="images/s2_0.png" width="249"></div>
             <div class="title"><img src="images/s6_0.png" width="230"></div>
             <div class="text">
                <?php 
				$prizeNum = $query->num_rows;
                if(0 == $prizeNum){
                	echo '<p>你还没有抽到奖品哦</p>';
                }else{
                	while ($row = $query->fetch_assoc())
                	{
                		echo '<p>'.$row['title'].'</p>';
                	}
                }
                $query->free();
                ?>
             </div>
             <?php
			 if(!empty($userInfo['tel'])){
             ?>
             <div class="text">
                <div><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;姓名：</strong><span><?php echo $userInfo['truename'];?></span></div>
                <div><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;电话：</strong><span><?php echo substr_replace($userInfo['tel'],'****',4,4);?></span></div>
                <div><strong>微信昵称：</strong><span><?php echo $userInfo['nickname'];?></span></div>
                <div><strong>领奖地址：</strong><span><?php echo $userInfo['item'];?></span></div>
             </div>
             <?php
			 }elseif($prizeNum > 0 && empty($userInfo['tel'])){
             ?>
             <a class="submit" href="supplement.php">填写领奖信息</a>
             <?php
			 }
             ?>
        </div>
        <?php
	require_once './tj.php';
    ?>
    </body>
</html>