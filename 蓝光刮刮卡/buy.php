<?php
require_once './db.php';
$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
if(strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false ){
	exit('请使用微信浏览器打开');
	}
//获取用户信息
$sql = 'SELECT * FROM `brc140910_userinfo` WHERE `openid`="'.$db->real_escape_string($_SESSION['openid']).'" LIMIT 1';
$query = $db->query($sql);
if(0 == $query->num_rows){
	exit('用户无效!');
}
$userInfo = $query->fetch_assoc();
$query->free();
//获取各个价位已售数量
$sql = 'SELECT COUNT(*) AS num,price FROM brc140910_discount GROUP BY price';
$ticketAmountQuery = $db->query($sql);
$ticketAmount = array();
while($row = $ticketAmountQuery->fetch_assoc())
{
	$ticketAmount[] = $row;
}
//获取各个价位中数
$sql = 'SELECT * FROM brc140910_ticket AS t ORDER BY t.price DESC';
$ticketListQuery = $db->query($sql);
$ticketList = array();
//计算余量
while($row = $ticketListQuery->fetch_assoc())
{
	foreach ($ticketAmount as $t)
	{
		if($t['price'] == $row['price']){
			$row['amount'] -= $t['num']; 
			break;
		}		
	}
	reset($ticketAmount);
	$ticketList[] = $row;
}
$ticketAmountQuery->free();
$ticketListQuery->free();
if(isset($_POST['dosubmit'])){
	$truename = isset($_POST['truename']) ? $db->real_escape_string(trim($_POST['truename'])) : '';
	$tel = isset($_POST['tel']) ? $db->real_escape_string(trim($_POST['tel'])) : '';
	$item = isset($_POST['item']) ? $db->real_escape_string(trim($_POST['item'])) : '';
	$price = isset($_POST['price']) ? intval($_POST['price']) : '';
	foreach($ticketList as $row)
	{
		if(0 >=$row['amount'] && intval($row['price']) == $price){
			echo '<script type="text/javascript">';
			echo 'alert("您选择的票已经没有了");window.history.go(-1);';
			echo '</script>';exit;
		}
	}
	if(empty($truename) || empty($tel) || empty($item) || empty($price)){
		echo '<script type="text/javascript">';
		echo 'alert("参数错误");window.history.go(-1);';
		echo '</script>';exit;
		}
	if(!preg_match('/^1\d{10}/', $tel)){
		echo '<script type="text/javascript">';
		echo 'alert("手机号码格式错误");window.history.go(-1);';
		echo '</script>';exit;
	}
	/**$sql = 'SELECT `id` FROM brc140910_discount WHERE `uid`='.$userInfo['id'];
	$query = $db->query($sql);
	if(0 < $query->num_rows){
		echo '<script type="text/javascript">';
		echo 'alert("您已经预约过啦");window.history.go(-1);';
		echo '</script>';exit;
	}**/
	$sql = "INSERT INTO `brc140910_discount`(`uid`,`turename`,`tel`,`price`,`item`) VALUES ('{$userInfo['id']}','$truename','$tel','$price','$item')";
	$db->query($sql);
	echo '<script type="text/javascript">';
	echo 'alert("操作成功！操作成功！您的预约信息已登记，请于活动期间周末前往您预约项目\"'.$item.'\"购买演唱会9.5折特权门票。");window.location.href="index.php";';
	echo '</script>';exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>蓝光有礼，成都准备尖叫！</title>
    <link rel="stylesheet" type="text/css" href="css/css.css?v=1.2"/>
</head>
    <body>
        <div class="conter">
             <div class="top"><img src="images/s2_0.png" width="249"></div>
             <div class="title"><img src="images/s4_0.png" width="230"></div>
             <div class="text">
               	<form action="buy.php" method="post" id="from1">
	                <input name="item" id="item" type="hidden" value="">
                    <input name="price" id="price" type="hidden" value="">
                	<input name="dosubmit" type="hidden" value="dosubmit">
                    <label>姓名
                        <input type="text" id="truename" name="truename" value="">
                    </label>
                    <label>电话
                        <input type="tel" id="tel" name="tel" value="">
                    </label>
                </form>
             </div>             
             <div class="ticket">
                <div class="title"><img src="images/s3_1.png" width="58"></div>
                <div class="list">
                    <?php
                foreach ($ticketList as $row)
                { 
                	echo '<div class="line" data-title="'.$row['price'].'"><span>'.$row['price'].'元</span><span>剩余<i>'.$row['amount'].'</i>张</span></div>';
                }
                ?>
                </div>
             </div>
             <div id="banner">
                <div class="title"><img src="images/s3_2.png" width="114"></div>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="images/1.png" alt="邛崃coco时代" width="100%" />
                            <p></p>
                        </div>
                        <div class="swiper-slide">
                            <img src="images/2.png" alt="coco国际" width="100%" />
                            <p></p>
                        </div>
                        <div class="swiper-slide">
                            <img src="images/3.png?v=1" alt="coco金沙" width="100%" />
                            <p></p>
                        </div>
                        <div class="swiper-slide">
                            <img src="images/4.png" alt="东方天地" width="100%" />
                            <p></p>
                        </div>
                        <div class="swiper-slide">
                            <img src="images/5.png" alt="观岭国际社区" width="100%" />
                            <p></p>
                        </div>
                        <div class="swiper-slide">
                            <img src="images/6.png" alt="花满庭2期" width="100%" />
                            <p></p>
                        </div>
                        <div class="swiper-slide">
                            <img src="images/7.png" alt="金双楠2期" width="100%" />
                            <p></p>
                        </div>
                        <div class="swiper-slide">
                            <img src="images/8.png" alt="锦绣城" width="100%" />
                            <p></p>
                        </div>
                        <div class="swiper-slide">
                            <img src="images/9.png?v=1" alt="空港国际城" width="100%" />
                            <p></p>
                        </div>
                        <div class="swiper-slide">
                            <img src="images/10.png" alt="乐彩城" width="100%" />
                            <p></p>
                        </div>
                        <div class="swiper-slide">
                            <img src="images/11.png" alt="蓝光·青城河谷" width="100%" />
                            <p></p>
                        </div>
                        <div class="swiper-slide">
                            <img src="images/13.png" alt="幸福耍街" width="100%" />
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="pagination"></div>
            </div>
    		<div class="txt">&larr; 左右滑动选择您的购买项目 &rarr;</div>
			<div class="hint"><span>提示：</span>留下你的定票信息后，请于周末前往你所选取的蓝光项目售楼部缴费并留下具体地
址信息，随后我们将会代您购票并以邮寄的方式派发到你手中。</div>
            <div class="bottom">
                <div class="title"><img src="images/s4_1.png" width="279"></div>
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
			$('.line').click(function(){
                $('.line').removeClass('click');
                $(this).addClass('click');
				$('#price').val($(this).attr('data-title'));
            });
			$('#dosubmit').on('click',function(){
				var telpreg = /(^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$)|(^0{0,1}1[3|4|5|6|7|8|9][0-9]{9}$)/;
				var truename = $('#truename').val();
				var _item = $('#item').val();
				var tel= $('#tel').val();
				var price = $('#price').val();
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
				if(!price){
					alert('请选择票价');
					return false;
					}
				$('#from1').submit();
				});
        });
    </script>
    <?php
	require_once './tj.php';
    ?>
    </body>
</html>