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
	if(empty($truename) || empty($tel)){
		echo '<script type="text/javascript">';
		echo 'alert("参数错误");window.history.go(-1);';
		echo '</script>';exit;
		}
	$sql = "UPDATE `brc140910_userinfo` SET `truename`='$truename',`tel`='$tel' WHERE `openid`='".$db->real_escape_string($_SESSION['openid'])."'";
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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>蓝光BRC</title>
    <link rel="stylesheet" type="text/css" href="css/css.css?v=2"/>
</head>
    <body>
        <div class="conter">
             <div class="top"><img src="images/s2_0.png?v=2" width="249"></div>
             <div class="title"><img src="images/s2_1.png?v=2" width="148"></div>
             <div class="lottery">红米手机</div>
             <div class="title"><img src="images/s2_10.png?v=2" width="230"></div>
             <div class="text">
                <form action="yes.php" method="post">
                	<input name="dosubmit" type="hidden" value="dosubmit">
                    <label>微信昵称
                        <input type="text" name="nickname" id="nickname" readonly value="<?php echo $userInfo['nickname'];?>">
                    </label>
                    <label>姓名
                        <input type="text" id="truename" name="truename" value="<?php echo $userInfo['truename'];?>">
                    </label>
                    <label>电话
                        <input type="text" id="tel" name="tel" value="<?php echo $userInfo['tel'];?>">
                    </label>
                </form>
             </div>
             <div id="banner">
                <div class="title"><img src="images/s2_2.png" width="114"></div>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img id="pic1" class="loadimg" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" alt="1" width="100%" />
                            <p></p>
                        </div>
                        <div class="swiper-slide">
                            <img id="pic2" class="loadimg" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" alt="2" width="100%" />
                            <p></p>
                        </div>
                        <div class="swiper-slide">
                            <img id="pic3" class="loadimg" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" alt="3" width="100%" />
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="pagination"></div>
            </div>
        	<div class="txt"><—— 左右滑动查看更多项目 ——></div>

            <div class="bottom">
                <div class="title"><img src="images/s2_4.png" width="279"></div>
                <div class="btn clearfix"><a class="btn1" href="#">点击关注</a><a class="btn2" href="lottery_no.html">点击提交</a></div>
            </div>
        </div>
        <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript">
        document.write('<script src="js/' +('__proto__' in {} ? 'zepto' : 'jquery-2.0.3') +'.js"><\/script>')
    </script>
    <script type="text/javascript" src="js/idangerous.swiper-2.1.min.js"></script>
    <script type="text/javascript" src="js/minisite.js"></script>
    <script type="text/javascript">
        var mySwiper = new Swiper('.swiper-container',{
            autoplay:5000,
            pagination: '.pagination',
            grabCursor: true,
            paginationClickable: true,
            onSlideChangeEnd : function(){
                var idx = mySwiper.activeIndex;
                FCAPP.Common.loadImg(banner[idx].pic,banner[idx].id,loadedImgProcess);
            }
        });
        var path = location.href.substring(0,location.href.lastIndexOf('/'));
        var banner = [{id:"pic1",pic:path+"/images/1.png"},
                        {id:"pic2",pic:path+"/images/2.png"},
                        {id:"pic3",pic:path+"/images/3.png"}];

        function loadedImgProcess(img){
            img.style.width = "100%";
        }

        $().ready(function() {

            FCAPP.Common.loadImg(banner[0].pic,banner[0].id,loadedImgProcess);

        });

        FCAPP.Common.hideLoading();
        $(function(){
            $('.swiper-slide p').click(function(){
                $('.swiper-slide p').removeClass('active');
                $(this).addClass('active');

            });
        });
    </script>
    </body>
</html>