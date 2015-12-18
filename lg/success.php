<?php
require_once './db.php';
$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
if(strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false ){
	exit('请使用微信浏览器打开');
	}
if(!isset($_SESSION['openid'])){
	exit('认证失败!');
}
//获取用户信息
$sql = 'SELECT * FROM `brc140910_userinfo` WHERE `openid`="'.$db->real_escape_string($_SESSION['openid']).'" LIMIT 1';
$query = $db->query($sql);
if(0 == $query->num_rows){
	exit('用户无效!');
}
$userInfo = $query->fetch_assoc();
$query->free();
$sql = 'SELECT p.title FROM `brc140910_take` AS t LEFT JOIN `brc140910_prize_list` AS p ON t.prizeid = p.id WHERE t.uid = '.$userInfo['id'].' ORDER BY t.id DESC LIMIT 1';
$query = $db->query($sql);
$prizeName = ''; 
if(0 < $query->num_rows){
	$row = $query->fetch_assoc();
	$prizeName = $row['title'];
}
$query->free();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>蓝光有礼，成都准备尖叫！</title>
    <link rel="stylesheet" type="text/css" href="css/css.css?v=1"/>
</head>
    <body>
        <div class="conter">
            <div class="bg"><img src="images/bg5.jpg" width="100%"></div>
            <div class="success">
                <div class="top"><img src="images/s2_0.png" width="249"></div>
                <div class="title"><img src="images/s5_0.png" width="230"></div>
                <div class="cen">
                    <form>
                        <label class="clearfix"><span>奖品</span><input type="text" value="<?php echo $prizeName;?>" readonly></label>
                        <label class="clearfix"><span>姓名</span><input type="text" value="<?php echo $userInfo['truename'];?>" readonly></label>
                        <label class="clearfix"><span>电话</span><input type="text" value="<?php echo $userInfo['tel'];?>" readonly></label>
                        <label class="clearfix"><span>微信昵称</span><input type="text" value="<?php echo $userInfo['nickname'];?>" readonly></label>
                        <label class="clearfix"><span>领取地址</span><input type="text" value="<?php echo $userInfo['item'];?>" readonly></label>
                    </form>
                </div>
                <div class="foot"><img src="images/s5_1.png" width="204"></div>
            </div>
        </div>
        <?php
	require_once './tj.php';
    ?>
    </body>
</html>