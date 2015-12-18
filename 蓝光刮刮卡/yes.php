<?php
require_once './db.php';
$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
if(strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false ){
	exit('请使用微信浏览器打开');
	}
if(!isset($_SESSION['openid'])){
	exit('认证失败!');
}
if(isset($_POST['dosubmit'])){
	$truename = isset($_POST['truename']) ? $db->real_escape_string(trim($_POST['truename'])) : '';
	$tel = isset($_POST['tel']) ? $db->real_escape_string(trim($_POST['tel'])) : '';
	$item = isset($_POST['item']) ? $db->real_escape_string(trim($_POST['item'])) : '';
	if(empty($truename) || empty($tel) || empty($item)){
		echo '<script type="text/javascript">';
		echo 'alert("参数错误");window.history.go(-1);';
		echo '</script>';exit;
		}
	if(!preg_match('/^1\d{10}/', $tel)){
		echo '<script type="text/javascript">';
		echo 'alert("手机号码格式错误");window.history.go(-1);';
		echo '</script>';exit;
	}
	$sql = "UPDATE `brc140910_userinfo` SET `truename`='$truename',`tel`='$tel',`item`='$item' WHERE `openid`='".$db->real_escape_string($_SESSION['openid'])."'";
	$db->query($sql);
	header('Location: success.php');exit;
	}
//获取用户信息
$sql = 'SELECT * FROM `brc140910_userinfo` WHERE `openid`="'.$db->real_escape_string($_SESSION['openid']).'" LIMIT 1';
$query = $db->query($sql);
if(0 == $query->num_rows){
	exit('用户无效!');
}
$userInfo = $query->fetch_assoc();
$query->free();
//获取用户最后一次抽中的奖品
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
    <link rel="stylesheet" type="text/css" href="css/css.css?v=2"/>
</head>
    <body>
        <div class="conter">
             <div class="top"><img src="images/s2_0.png?v=2" width="249"></div>
             <div class="title"><img src="images/s2_1.png?v=2" width="148"></div>
             <div class="lottery"><?php echo $prizeName;?></div>
             <div class="title"><img src="images/s2_10.png?v=2" width="230"></div>
             <div class="text">
                <form action="yes.php" method="post" id="from1">
                	<input name="item" id="item" type="hidden" value="">
                	<input name="dosubmit" type="hidden" value="dosubmit">
                    <label>微信昵称
                        <input type="text" name="nickname" id="nickname" readonly value="<?php echo $userInfo['nickname'];?>">
                    </label>
                    <label>姓名
                        <input type="text" id="truename" name="truename" value="<?php echo $userInfo['truename'];?>">
                    </label>
                    <label>电话
                        <input type="tel" id="tel" name="tel" value="<?php echo $userInfo['tel'];?>">
                    </label>
                </form>
             </div>
             <div id="banner">
                <div class="title"><img src="images/s2_2.png" width="114"></div>
                <div class="swiper-container">
                    <div class="swiper-wrapper" id="item_select">
                        <div class="swiper-slide">
                            <img src="images/2.png" alt="coco国际" width="100%" />
                            <p></p>
                        </div>
                        <div class="swiper-slide">
                            <img src="images/3.png?v=1" alt="coco金沙" width="100%" />
                            <p></p>
                        </div>
                        <div class="swiper-slide">
                            <img src="images/10.png" alt="乐彩城" width="100%" />
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="pagination"></div>
            </div>
        	<div class="txt">&larr; 左右滑动选择您的领取项目 &rarr;</div>

            <div class="bottom">
                <div class="title"><img src="images/s2_4.png" width="279"></div>
                <div class="btn clearfix"><a class="btn1" href="http://mp.weixin.qq.com/s?__biz=MjM5ODc5Mjg5Mw==&mid=200441193&idx=1&sn=3bc059ba5e68011b39044641583c5ed8#rd">点击关注</a><a class="btn2" href="javascript:" id="dosubmit">点击提交</a></div>
            </div>
        </div>
        <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="js/idangerous.swiper-2.1.min.js"></script>
    <script type="text/javascript">
        var mySwiper = new Swiper('.swiper-container',{
            pagination: '.pagination',
            grabCursor: true,
            paginationClickable: true,
        });
        $(function(){
            $('.swiper-slide p').click(function(){
                $('.swiper-slide p').removeClass('active');
                $(this).addClass('active');
				var _item = $(this).siblings('img').attr('alt');
				$('#item').val(_item);
            });
			$('#dosubmit').on('click',function(){
				var telpreg = /(^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$)|(^0{0,1}1[3|4|5|6|7|8|9][0-9]{9}$)/;
				var truename = $('#truename').val();
				var _item = $('#item').val();
				var tel= $('#tel').val();
				if('' == truename){
					alert('请填写真实姓名');
					$('#truename').focus();
					return false;
					}
				if('' == tel){
					alert('请填写您的手机号码');
					$('#tel').focus();
					return false;
					}
				if('' == _item){
					alert('请选择领奖地址');
					return false;
					}
				if(!telpreg.test(tel)){
					alert('手机号码格式错误');
					$('#tel').focus();
					return false;
					}
				if(window.confirm('提交之后不能修改,你确认要提交吗?')){
					$('#from1').submit();
					}
				});
        });
    </script>
    <?php
	require_once './tj.php';
    ?>
    </body>
</html>