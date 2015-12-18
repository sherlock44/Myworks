<?php


	$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
	if(strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false ){
		exit('请使用微信打开');
	}



	$pdo = new PDO('mysql:dbname=toupiao;charset=utf8','root','eebce7027d');
	
	$sql = "select * from hero order by score desc";
	$gs = $pdo->query($sql)->fetchAll();
	$j = 1;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>金房三径</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="css/mango.css"/>
    <link rel="stylesheet" href="css/style.css"/>
	<style>
		.mingzi{display:block;}
		.center .item .list .col .text span{display:inline-block;}
        .center .item .list .col .img img{ border-radius: 50%; }
        .btn{ padding: 0 10px; }
        .center .item .list .col .tic{ padding-left:5px; }
	</style>
</head>
<body>
    <div class="container">
        <div class="center">
            <div class="top"><span></span></div>
            <!-- A组 -->
            <?php 
            	foreach($gs as $g){
            ?>
            <div class="item">
                <div class="title">
                    <span></span>
                    <a id="more<?php echo $j ?>" onclick="showsubmenu(<?php echo $j ?>)" href="#"></a>
                </div>
                <div class="list">
                    <div class="col clearfix">
                        <div class="img" style="background:#999999;">
                            <img data-original="getimg.php?id=<?php echo $g['id'] ?>" width="55" />
                            <span class="<?php switch($j){
													case 1:
														echo 'red';
													break;
													case 2:
														echo 'orange';
													break;
													case 3:
														echo 'oranges';
													break;
													default:
														echo 'gray';
											} ?>">&nbsp;<?php echo $j ?></span>
                        </div>
                        <div class="text"><font class='mingzi'><?php echo $g['name'] ?></font><span>编号:<?php echo $g['number'] ?>&nbsp;&nbsp;|&nbsp;&nbsp;</span><span><font class='renshu'><?php echo $g['score'] ?></font>票</span></div>
                        <div class="tic"><a class="btn" href="#" ><span class="img"></span>投票</a></div>
                    </div>
                </div>
            </div>
            <?php 
				$j++;
            	}
            ?>

            <div class="item">
                <div id="bg"></div>
                <div id="write">
                    <div id="wrongmsg"></div>
					<label id="msg">
                    	电话：<input type="text" id="phone" placeholder="手机号码" maxlength="11"/>
                    </label>
                    <button id="confirmbut" type="button" value="" onclick="javascript:checkphone()">确定</button>
                    <button id="nobut" type="button" value="" onclick="javascript:closeBg()">取消</button>
                </div>
                <div class="images"></div>
            </div>
        </div>
		<div class="footer">
			<div class="bt-menu">
				<div>
					<a href="../index.html"><span>首页</span></a>
				</div>
				<div>
					<a href="javascript:void(0)" onclick="more(this)"><i class="icon-th-large"></i><span>楼盘介绍</span></a>
					<div class="submenu">
						<a href="../group.html">集团介绍</a>
						<a href="../summary.html">项目品鉴</a>
						<a href="../photo.html">实景呈现</a>
					</div>
				</div>
				<div>
					<a href="../look.html"><span>预约看房</span></a>
				</div>
				<div>
					<a href="index.html"><span>人气评选</span></a>
				</div>
			</div>
		</div>
    </div>
    <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="../scripts/minisite.js"></script>
	<script type="text/javascript" src="js/jquery.lazyload.js"></script>
    <script type="text/javascript">
    	
    </script>
    <script type="text/javascript">
    	var reg = /1[3|5|7|8]\d{9}/g;
    //检查电话号码
    	function checkphone(){
        	var telnum = $('#phone').val();

			var d = new Date();
			var m = d.getMonth()+1;
			var nowtime = '2014-0'+m+'-'+d.getDate();

			if(reg.test(telnum)){
				$.ajax({
				type: 'GET',
				url: 'tel.php',
				data:'tel='+telnum+'&time='+nowtime,
				success: function(o){
						console.log(o!=1);
						if(o!=1){
							$('#wrongmsg').text('该手机号今日已经投完票');
							return;
						}else{
							sessionStorage.phone = telnum;
							sessionStorage.time = 5;
							$('#wrongmsg').text('');
							closeBg();
						}
					}
				});
			}else{
				if(sessionStorage.phone==null){
					$('#wrongmsg').text('手机号格式错误');
				}
			}
        }
    //弹出层
        function showBg() { 
            var bh = $(window).height(); 
            var bw = $(window).width(); 
            $("#bg").css({ 
            height:bh, 
            width:bw, 
            display:"block" 
            }); 
            $("#write").show(); 
        }
        function showFx() { 
            var bh = $(window).height(); 
            var bw = $(window).width(); 
            $("#bg").css({ 
            height:bh, 
            width:bw, 
            display:"block" 
            }); 
            $(".images").show(); 
        }  
        //关闭灰色 jQuery 遮罩 
        function closeBg() { 
            $("#bg,#write,.images").hide(); 
        } 

        $(function() {
            $(".center .item .list .col .img img").lazyload();
        });
       $(function(){
            $('#bg').click(function(event) {
                closeBg();
            });

            $('.btn').click(function(){
                if(sessionStorage.phone==null){
					$('#wrongmsg').text('输入手机号之后有5次投票机会');
	                showBg();
                }else{
                    if(sessionStorage.time<=0){
                        $('#msg').html('您今天的投票次数已用完！');
                   		showBg();
                   		$('#confirmbut').click(function(){closeBg();});
						return;
                    }
                    var renshu = $(this).parent().parent().find('.renshu').text();
                    var mingzi = $(this).parent().parent().find('.mingzi').text();
					sessionStorage.hero = mingzi;
                    renshu++;
                    $(this).parent().parent().find('.renshu').text(renshu++);
                    var currentNum = $(this).parent().parent().find('.renshu').text();
                    $.ajax({
						type:'get',
						url:'saveNum.php',
						data:'name='+mingzi+'&renshu='+currentNum+'&tel='+sessionStorage.phone,
						success:function(s){
							if(s==1){
			                     sessionStorage.time--;
								 $('#msg').html('投票成功！今日所剩投票次数:'+sessionStorage.time+'次');
		                   		 showBg();
		                   		 $('#confirmbut').click(function(){
									 closeBg();
									 if(sessionStorage.time<=0){
										 showFx();
									 }
								 });
							}
						}
                    });
	                $(this).removeClass('active')
	                $(this).addClass('active');
                }
            });
            $('#write a').click(function(){
               closeBg();
            });

            $('')
        });

        function showsubmenu(sid)
        {
            var obj1= "ss" + sid
            whichEl = eval("submenu" + sid);
            if (whichEl.style.display == "none")
            {
            eval("submenu" + sid + ".style.display=\"\";");
            document.getElementById("more"+sid).innerHTML="-";
            }
            else
            {
            eval("submenu" + sid + ".style.display=\"none\";");
            document.getElementById("more"+sid).innerHTML="+";
            }
        }

    </script>
	<script type="text/javascript">
            document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
                // 分享到朋友圈
                WeixinJSBridge.on('menu:share:timeline', function (argv) {
                    WeixinJSBridge.invoke('shareTimeline', {
                        "img_url": "http://www.cdmango.com/webapp/jfsj/toupiao/images/Mickey.jpg",
                        "img_width": "160",
                        "img_height": "160",
                        "link": "http://www.cdmango.com/webapp/jfsj/toupiao/",
                        "desc":  "test",
                        "title": sessionStorage.hero+"参加了金房三径2014CCTV钢琴小提琴人气评选，快来帮我拉票~"
                    }, function (res) {
                        _report('timeline', res.err_msg);
                    });
                });
            }, false)
        </script>

    <div style="display:none">
        <script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F37ed4b4dba7caa4e754c943e300a49d9' type='text/javascript'%3E%3C/script%3E"));
</script>

    </div>
</body>
</html>