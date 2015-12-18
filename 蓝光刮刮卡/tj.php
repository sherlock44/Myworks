<div style="display:none;">
<script type="text/javascript">
function onBridgeReady() {
			<?php
			$sharetitle = isset($prizeName) ? '尖叫~我中了'.$prizeName.'，快来!1680闷MC演唱会门票、充电宝购物卡免费刮！' : '“成都准备尖叫”1680闷MC演唱会门票、充电宝购物卡免费刮！爽翻！';
			?>
            var mainTitle="<?php echo $sharetitle;?>",
                mainDesc="<?php echo $sharetitle;?>",
            	mainURL="http://www.cdmango.com/brc140910/",
                mainImgUrl= "http://114.215.183.215/brc140910/images/share.png";
            //转发朋友圈
            WeixinJSBridge.on("menu:share:timeline", function(e) {
                var data = {
                    img_url:mainImgUrl,
                    img_width: "120",
                    img_height: "120",
                    link: mainURL,
                    //desc这个属性要加上，虽然不会显示，但是不加暂时会导致无法转发至朋友圈，
                    desc: "",
                    title: mainTitle
                };
                WeixinJSBridge.invoke("shareTimeline", data, function(res) {
                    WeixinJSBridge.log(res.err_msg)
                });
            });
            //同步到微博
            WeixinJSBridge.on("menu:share:weibo", function() {
                WeixinJSBridge.invoke("shareWeibo", {
                    "content": mainDesc,
                    "url": mainURL
                }, function(res) {
                    WeixinJSBridge.log(res.err_msg);
                });
            });
            //分享给朋友
            WeixinJSBridge.on('menu:share:appmessage', function(argv) {
                WeixinJSBridge.invoke("sendAppMessage", {
                    img_url: mainImgUrl,
                    img_width: "120",
                    img_height: "120",
                    link: mainURL,
                    desc: mainDesc,
                    title: '蓝光有礼，成都准备尖叫！'
                }, function(res) {
                    WeixinJSBridge.log(res.err_msg)
                });
            });
        };
        //执行
        document.addEventListener('WeixinJSBridgeReady', function() {
            onBridgeReady();
        });
</script>


<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fa5dfb064a199a034f38f3b79f22c492f' type='text/javascript'%3E%3C/script%3E"));
</script>
</div>