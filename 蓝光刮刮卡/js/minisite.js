var FCAPP = FCAPP || {
    Common: {
        RUNTIME: {
            loadImg: {},
            records: 0
        },
        init: function() {
            FCAPP.Common.initElements();
        },
        initElements: function() {
            var R = FCAPP.Common.RUNTIME;
            R.popTips = $('#popTips');
            R.tipsTitle = $('#tipsTitle');
            R.tipsMsg = $('#tipsMsg');
            R.tipsOK = $('#tipsOK');
            R.tipsCancel = $('#tipsCancel');
            R.popMask = $('#popMask');
        },
        showToolbar: function() {
            try {
                WeixinJSBridge.invoke('showToolbar');
            } catch(e) {
                setTimeout(FCAPP.Common.showToolbar, 30);
            }
        },
        hideToolbar: function() {
            if (!/MicroMessenger/i.test(navigator.userAgent)) {
                return;
            }
            try {
                WeixinJSBridge.invoke('hideToolbar');
            } catch(e) {
                setTimeout(FCAPP.Common.hideToolbar, 30);
            }
        },
        closeWindow: function() {
            try {
                WeixinJSBridge.invoke('closeWindow');
            } catch(e) {
                setTimeout(FCAPP.Common.closeWindow, 30);
            }
        },
        hideLoading: function() {
            var R = FCAPP.Common.RUNTIME;
            if (!R.loading) {
                R.loading = $('#popFail');
            }
            if (R.loading) {
                R.loading.hide();
            }
        },
        showLoading: function(boo) {
            var R = FCAPP.Common.RUNTIME;
            if (!R.loading) {
                R.loading = $('#popFail');
            }
            if (R.loading) {
                if (!boo) {
                    window.scrollTo(0, 0);
                }
                R.loading.show();
            }
        },
        loadImg: function(src, id, callback, force) {
            var R = FCAPP.Common.RUNTIME,
            loadImg = R.loadImg,
            chk = loadImg[id + src],
            img;
            if (!force && !!chk && (chk.loaded || chk.loading)) {
                return;
            }
            loadImg[id + src] = {
                id: id,
                loading: true,
                loaded: false,
                dom: false
            };
            img = new Image();
            img.idx = id;
            if (callback && typeof(callback) == 'function') {
                img.cb = callback;
            }
            img.onload = img.onerror = img.onreadystatechange = function() {
                if ( !! this.readyState && this.readyState != 4) {
                    return;
                }
                var info = loadImg[this.idx + this.src],
                oimg,
                bw = document.documentElement.clientWidth,
                bh = document.documentElement.clientHeight;
                info.loaded = true;
                if ( !! info.dom) {
                    oimg = info.dom;
                } else {
                    oimg = document.getElementById(this.idx);
                    info.dom = oimg;
                }
                if (!oimg.parentNode) {
                    return;
                }
                if ( !! this.cb) {
                    this.cb(this);
                    delete this.cb;
                } else {
                    this.width = bw;
                    this.height = bh;
                }
                oimg.parentNode.replaceChild(this, oimg);
                this.onload = null;
                delete this.onload;
            };
            img.src = src;
        },
        escapeHTML: function(str) {
            if (typeof(str) == 'string' || str instanceof String) {
                str = str.toString().replace(/<+/gi, '&lt;').replace(/>+/gi, '&gt;');
                str = str.replace(/&lt;strong&gt;/gi, '<strong>').replace(/&lt;\/strong&gt;/gi, '</strong>');
                str = str.replace(/&lt;br&gt;/gi, '<br/>').replace(/&lt;\/br&gt;/gi, '<br/>');
                if ((str.indexOf('电话') != -1 || str.indexOf('致电') != -1) && /[\d\-]{8,11}/.test(str)) {
                    str = str.replace(/(\d[\d\-]+\d)/g, '<a style="color:#74a3a5" href="tel:$1">$1</a>');
                }
                return str;
            } else {
                return str;
            }
        },
        msg: function(boo, obj) {
            var R = FCAPP.Common.RUNTIME,
            title = '温馨提示',
            msg = '';
            if (!boo) {
                R.popTips.hide();
                if (R.popMask.length) {
                    R.popMask.hide();
                }
                return;
            }
            if (!R.popTips.length || !obj.msg) {
                return;
            }
            if (obj.title) {
                title = FCAPP.Common.escapeHTML(obj.title);
            }
            R.tipsTitle.html(title);
            msg = FCAPP.Common.escapeHTML(obj.msg);
            R.tipsMsg.html(msg);
            var that = arguments.callee;
            that.okFunc = null,
            that.noFunc = null;
            if (obj.ok && typeof(obj.ok) == 'function') {
                that.okFunc = obj.ok;
                R.tipsOK.one('click',
                function() {
                    if (that.okFunc) {
                        that.okFunc.apply(null, obj.okParams || []);
                    }
                    R.popTips.hide();
                    if (R.popMask.length) {
                        R.popMask.hide();
                    }
                });
            } else {
                R.tipsOK.one('click',
                function() {
                    R.popTips.hide();
                    if (R.popMask.length) {
                        R.popMask.hide();
                    }
                });
            }
            if (obj.no && typeof(obj.no) == 'function') {
                R.tipsCancel.show();
                that.noFunc = obj.no;
                R.tipsCancel.one('click',
                function() {
                    if (that.noFunc) {
                        that.noFunc.apply(null, obj.noParams || []);
                    }
                    R.popTips.hide();
                    if (R.popMask.length) {
                        R.popMask.hide();
                    }
                });
            } else {
                R.tipsCancel.hide();
                R.tipsCancel.one('click',
                function() {
                    R.popTips.hide();
                    if (R.popMask.length) {
                        R.popMask.hide();
                    }
                });
            }
            var div = $('#randDivForMask');
            if (div.length) {
                div.html(div.html() == '' ? '<br>&nbsp;': '');
            } else {
                div = document.createElement("div");
                div.id = "randDivForMask";
                div.innerHTML = "<br/>&nbsp;";
                document.body.appendChild(div);
            }
            FCAPP.Common.hideLoading();
            if (!obj.noscroll) {
                window.scrollTo(0, 0);
            }
            if (R.popMask.length) {
                R.popMask.show();
            }
            setTimeout(function() {
                R.popTips.show();
            },
            30);
        }
    }
};
function more(){
    $('.submenu').toggleClass('open');
}
$().ready(function(){
    FCAPP.Common.init();
    FCAPP.Common.hideToolbar();

	$('.house_list li a.title').click(function(e){
		e.stopPropagation();
		e.preventDefault();
		var parent = $(this).parent();
		if(!$(this).parent().hasClass('open')){
			$('.house_list li').removeClass('open');
			parent.addClass('open');
		}
	});

    // $(window).on('scroll',function(){
    //     var scrollHeight = $(document).height();
    //     var scrollTop    = $(window).scrollTop();
    //     var headerHeight = $('.header > img').height();
    //     if(scrollTop > headerHeight){
    //         $('.menu').addClass('affix');
    //     }
    //     else{
    //         $('.menu').removeClass('affix');
    //     }
    // });

    // $(window).on('touchmove',function(){
    //     var scrollHeight = $(document).height();
    //     var scrollTop    = $(window).scrollTop();
    //     var headerHeight = $('.header > img').height();
    //     if(scrollTop > headerHeight){
    //         $('.menu').addClass('affix');
    //     }
    //     else{
    //         $('.menu').removeClass('affix');
    //     }
    // });

     
});