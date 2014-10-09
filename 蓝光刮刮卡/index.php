<?php
require_once './db.php';
$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
if(strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false ){
	exit('请使用微信浏览器打开');
	}
if(END_DATE < NOW_DATE){
	exit('活动已结束');
	}
if(!isset($_SESSION['openid'])){
	$userInfo = getUserInfo(getCurUrl());
	$_SESSION['openid'] = $userInfo['openid'];
	$sql = 'SELECT * FROM `brc140910_userinfo` WHERE `openid` = "'.$db->real_escape_string($userInfo['openid']).'" LIMIT 1';
	$result = $db->query($sql);
	if(0 >= $result->num_rows){
		$result->free();
		$sql = 'INSERT INTO `brc140910_userinfo`(`openid`,`nickname`,`sex`,`province`,`city`,`country`,`headimgurl`) VALUES (?,?,?,?,?,?,?)';
		$stmt = $db->prepare($sql);
		$stmt->bind_param('sssssss',$userInfo['openid'],$userInfo['nickname'],$userInfo['sex'],$userInfo['province'],$userInfo['city'],$userInfo['country'],$userInfo['headimgurl']);
		$stmt->execute();
		$stmt->close();
	}	
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>蓝光有礼，成都准备尖叫！</title>
    <link rel="stylesheet" type="text/css" href="css/css.css?v=3"/>
    <style type="text/css">
	/*#ScratchArea canvas{left:0;}*/
    </style>
</head>
    <body>
        <div class="container">
            <div class="bg"><img src="images/bg1.jpg?v=2" width="100%"></div>
            <div class="button">
            	<div class="centent" id="ScratchArea" style="width:160px; float:right;">
                	<div style="width:100%; height:100%; position:absolute;">
                    <table width="100%" border="0">
                      <tr>
                        <td style="width:100%; height:80px; text-align:center; vertical-align:middle; line-height:30px; font-size:14px;" id="prize">正在加载开奖结果</td>
                      </tr>
                    </table>
                    </div>
                </div>
                <a href="javascript:" id="btn1"></a>
                <a href="buy.php" id="btn2"></a>
        		<a href="myprize.php" id="btn3"></a>
            </div>
            <div class="copyright">活动最终解释权归成都蓝光地产所有<br>全程推广 ©芒果互动</div>
        </div>
        <div class="fullbg"></div>
        <div class="fenx"><span>×</span><img src="images/bg_rule.jpg" width="100%"></div>
        <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript">
        //弹出层
        $('#btn1').click(function(e){
            $(".fenx,.fullbg").show();
            $("html,body").animate({scrollTop:0},200);
        });
        $(".fenx span").click(function(e){
            $(".fullbg,.fenx").hide();
        });
    </script>
    <script type="text/javascript" src="js/wScratchPad.min.js?v=2"></script>
    <script type="text/javascript">
	var timeFlag = 0;
	var response;
	$(function(){
		$('#ScratchArea').wScratchPad({			
		  size        : 15,
		  bg		  : '#cacaca',
		  fg          : './images/fg.gif',
		  scratchDown : null,
		  scratchUp   : null,
		  scratchMove : function (e, percent){
			  timeFlag++;
			  if(2 == timeFlag){
				  $.getJSON('doworks.php',function(data){
					  response = data;
					  if(data.state == 'Failure'){
						  $('#prize').html(data.message);
						  alert(data.message);
						  }else if(data.state == 'Success'){
							  $('#prize').html(data.prize.title)
							  }else{
								  alert('系统异常~');
								  }
					  });
				  }
			  if(percent > 70){
				  this.clear();
				  setTimeout(function(){
					  if(parseInt(response.prize.id) == 0){
							window.location.href = 'no.php';
						}else{
						  window.location.href = 'yes.php?id='+response.prize.insert;
						  }
					  },1000);
				  }
			  $(this.canvas).css('margin-right', $(this.canvas).css('margin-right') == "0px" ? "1px" : "0px");
			  },
			scratchDown: function(e, percent){
                $(this.canvas).css('margin-right', $(this.canvas).css('margin-right') == "0px" ? "1px" : "0px");
            },
            scratchUp: function(e, percent){
                $(this.canvas).css('margin-right', $(this.canvas).css('margin-right') == "0px" ? "1px" : "0px");
            }
		});
		$('#ScratchArea img').remove();
		})
    </script>
    <?php
	require_once './tj.php';
    ?>
    </body>
</html>