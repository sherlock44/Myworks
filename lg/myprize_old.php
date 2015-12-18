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
$sql = 'SELECT t.created,p.title FROM brc140910_take AS t,brc140910_prize_list AS p WHERE t.prizeid > 0 AND';
$sql .= ' t.prizeid = p.id AND t.uid = (SELECT id FROM brc140910_userinfo WHERE openid = "'.$db->real_escape_string($_SESSION['openid']).'" LIMIT 1)';
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
                if(0 == $query->num_rows){
                	echo '你还没有抽到奖品哦';
                }else{
                	while ($row = $query->fetch_assoc())
                	{
                		echo $row['title'].'<br>';
                	}
                }
                $query->free();
                ?>
             </div>
        </div>
        <?php
	require_once './tj.php';
    ?>
    </body>
</html>