function slimScrollUpdate(elem, toBottom) {
    if(elem.length > 0){
        var height = parseInt(elem.attr('data-height')),
        vis = (elem.attr("data-visible") == "true") ? true : false,
        start = (elem.attr("data-start") == "bottom") ? "bottom" : "top";
        var opt = {
            height: height,
            color: "#666",
            start: start
        };
        if (vis) {
            opt.alwaysVisible = true;
            opt.disabledFadeOut = true;
        }
        if (toBottom !== undefined) opt.scrollTo = toBottom+"px";
        elem.slimScroll(opt);
    }
}

function destroySlimscroll(elem) { 
    elem.parent().replaceWith(elem); 
}

function initSidebarScroll(){
    getSidebarScrollHeight();
    if(!$("#left").hasClass("hasScroll")){
        $("#left").niceScroll({
            cursorborder: 0,
            cursorcolor: '#999',
            railoffset:{
                top:0,
                left:-2
            },
            autohidemode:false,
            horizrailenabled:false
        });
        $("#left").addClass("hasScroll");
    } else {
        $("#left").getNiceScroll().resize().show();
    }
}

function getSidebarScrollHeight(){
    var $el = $("#left"),
    $w = $(window),
    $nav = $("#navigation");
    var height = $w.height();

    if($nav.hasClass("navbar-fixed-top") || $w.scrollTop() == 0) height -= 40;

    if($el.hasClass("sidebar-fixed")) $el.height(height);
}

function checkLeftNav(){
    var $w = $(window),
    $content = $("#content"),
    $left = $("#left");
    if($w.width() <= 767){
        $left.hide();
        $("#main").css("margin-left", 0 );
        if($(".toggle-mobile").length == 0){
            $("#navigation .user").before('<a href="#" class="toggle-mobile"><i class="icon-reorder"></i></a>');
        }

        if($(".mobile-nav").length == 0){
            createSubNav();
        }
        
        if(!$content.hasClass("nav-fixed")){
            $content.addClass("nav-fixed forced-fixed");
            $("#navigation").addClass("navbar-fixed-top");
        }
    } else {
        if(!$left.is(":visible") && !$left.hasClass("forced-hide")){
            $left.show();
            $("#main").css("margin-left", $left.width());
        }

        $(".toggle-mobile").remove();
        $(".mobile-nav").removeClass("open");

        if($content.hasClass("forced-fixed")){
         $content.removeClass("nav-fixed");
         $("#navigation").removeClass("navbar-fixed-top");
     }

     if($w.width() < 1200) {
        if($("#navigation .container").length > 0){
            // it is fixed layout -> reset to fluid
            $(".version-toggle .set-fluid").trigger("click");
        }
    }
}
}

function resizeHandlerHeight(){
    var wHeight = $(window).height(),
    minus = ($(window).scrollTop() == 0) ? 40 : 0;
    $("#left .ui-resizable-handle").height(wHeight-minus);
}

function toggleMobileNav(){
    var mobileNav = $(".mobile-nav");
    mobileNav.toggleClass("open");
}

function createSubNav(){
    if($(".mobile-nav").length == 0){
        var original = $("#navigation .main-nav");
        $("#navigation .main-nav").parent().after("<ul class='mobile-nav'></ul>");
        var mobile = $(".mobile-nav");

        original.find("> li > a").each(function(e){
            var mainElement = $(this),
            subElements = "",
            arrow = "";
            if(mainElement.hasClass("dropdown-toggle")){
                arrow = " <i class='icon-angle-left'></i>";
                subElements += "<ul>";
                mainElement.parent().find(".dropdown-menu > li > a").each(function(){
                    subElements += "<li><a href='"+$(this).attr("href")+"'>"+$(this).text()+"</a></li>";
                });
                subElements += "</ul>";
            }
            mobile.append("<li><a href='"+mainElement.attr("href")+"'>"+mainElement.text()+arrow+"</a>"+subElements+"</li>");
        });

        $(".mobile-nav > li > a").click(function(e){
            var el = $(this);
            if(el.next().length !== 0){
                e.preventDefault();

                var sub = el.next();
                el.parents(".mobile-nav").find(".open").not(sub).each(function(){
                    var t = $(this);
                    t.removeClass("open");
                    t.prev().find("i").removeClass("icon-angle-down").addClass("icon-angle-left");
                });
                sub.toggleClass("open");
                el.find("i").toggleClass('icon-angle-left').toggleClass("icon-angle-down");
            }
        });
    }
}

function initTopbarCollisionDetection(){
    var $el = $(".icon-nav"),
    $userMenu = $(".user .dropdown").last(),
    $w = $(window),
    $mainNav = $(".main-nav"),
    mainNavOffsetLeft = 200,
    horizontalPadding = 20,
    tolerance = 20;
    var lastCollisionOn = 0;

    $userMenu.imagesLoaded(function(){
        $w.resize(function(){
            var collisionOn = $el.outerWidth(true) + $userMenu.outerWidth(true) + $mainNav.outerWidth(true) + mainNavOffsetLeft + horizontalPadding + tolerance;
            if($w.width() <= collisionOn){
                while($w.width() <= collisionOn && $el.find(">li:visible").length > 0){
                    lastCollisionOn = collisionOn;
                    $el.find(">li:visible").first().hide();
                    collisionOn = $el.outerWidth(true) + $userMenu.outerWidth(true) + $mainNav.outerWidth(true) + mainNavOffsetLeft + horizontalPadding;
                }
            } else {
                if($w.width() > lastCollisionOn){
                    while($w.width() > lastCollisionOn && $el.find(">li:hidden").length > 0){
                        $el.find(">li:hidden").last().show();
                        lastCollisionOn = collisionOn;
                    }
                }
            }
        }).resize();
    });
}

$(document).ready(function () {

    initTopbarCollisionDetection();

    createSubNav();
    // hide breadcrumbs
    $(".breadcrumbs .close-bread > a").click(function (e) {
        e.preventDefault();
        $(".breadcrumbs").fadeOut();
    });

    $("#navigation").on('click', '.toggle-mobile' , function(e){
        e.preventDefault();
        console.log("asdf");
        toggleMobileNav();
    });

    $(".content-slideUp").click(function (e) {
        e.preventDefault();
        var $el = $(this),
        content = $el.parents('.box').find(".box-content");
        content.slideToggle('fast', function(){
           $el.find("i").toggleClass('icon-angle-up').toggleClass("icon-angle-down");
           if(!$el.find("i").hasClass("icon-angle-up")){
            if(content.hasClass('scrollable')) slimScrollUpdate(content);
        } else {
            if(content.hasClass('scrollable')) destroySlimscroll(content);
        }
    });
    });

    $(".content-remove").click(function (e) {
        e.preventDefault();
        var url = $(this).attr('data-remove-href');
        bootbox.animate(true);
        bootbox.confirm("确定要删除吗？", "取消", "确定", function (r) {
            if (r){
                $.gritter.add({ title: '操作提示', text: '<span class="icon-ok btn-success"></span> 删除成功', time: 2000, class_name: 'gritter-light' });
            }
        });
    });

    $(".content-refresh").click(function (e) {
        e.preventDefault();
        var $el = $(this);
        $el.find("i").addClass("icon-spin");
        setTimeout(function () {
            $el.find("i").removeClass("icon-spin");
        }, 2000);
    });

    if($('#vmap').length > 0)
    {
     $('#vmap').vectorMap({
        map: 'world_en',
        backgroundColor: null,
        color: '#ffffff',
        hoverOpacity: 0.7,
        selectedColor: '#2d91ef',
        enableZoom: true,
        showTooltip: false,
        values: sample_data,
        scaleColors: ['#8cc3f6', '#5c86ac'],
        normalizeFunction: 'polynomial'
    });
 }

 $(".custom-checkbox").each(function () {
    var $el = $(this);
    if ($el.hasClass("checkbox-active")) {
        $el.find("i").toggleClass("icon-check-empty").toggleClass("icon-check");
    }
    $el.bind('click', function (e) {
        e.preventDefault();
        $el.find("i").toggleClass("icon-check-empty").toggleClass("icon-check");
        $el.toggleClass("checkbox-active");
    });
});

 $(".toggle-subnav").click(function (e) {
    e.preventDefault();
    var $el = $(this);
    $el.parents(".subnav").toggleClass("subnav-hidden").find('.subnav-menu,.subnav-content').slideToggle("fast");
    $el.find("i").toggleClass("icon-angle-down").toggleClass("icon-angle-right");
});

 $("#left").sortable({
    items:".subnav",
    placeholder: "widget-placeholder",
    forcePlaceholderSize: true,
    axis: "y",
    handle:".subnav-title",
    tolerance:"pointer"
});

 if($(".scrollable").length > 0){
    $('.scrollable').each(function () {
        var $el = $(this);
        var height = parseInt($el.attr('data-height')),
        vis = ($el.attr("data-visible") == "true") ? true : false,
        start = ($el.attr("data-start") == "bottom") ? "bottom" : "top";
        var opt = {
            height: height,
            color: "#666",
            start: start,
            allowPageScroll:true
        };
        if (vis) {
            opt.alwaysVisible = true;
            opt.disabledFadeOut = true;
        }
        $el.slimScroll(opt);
    });
}

$("#message-form .text input").on("focus", function (e) {
    var $el = $(this);
    $el.parents(".messages").find(".typing").addClass("active").find(".name").html("John Doe");
    slimScrollUpdate($el.parents(".scrollable"), 100000);
});

$("#message-form .text input").on("blur", function (e) {
    var $el = $(this);
    $el.parents(".messages").find(".typing").removeClass("active");
    slimScrollUpdate($el.parents(".scrollable"), 100000);
});

if($(".jq-datepicker").length > 0){
    $(".jq-datepicker").datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        prevText: "",
        nextText: ""
    });
}

if($(".spark-me").length > 0){
    $(".spark-me").sparkline("html", {
        height: '25px',
        enableTagOptions: true
    });
}


if(!$("#left").hasClass("no-resize")){
    $("#left").resizable({
        minWidth: 60,
        handles: "e",
        resize: function (event, ui) {
            var searchInput = $('.search-form .search-pane input[type=text]'),
            content = $("#main");
            searchInput.css({
                width: ui.size.width - 55
            });
            if(Math.abs(200 - ui.size.width) <= 20){
                $("#left").css("width", 200);
                searchInput.css("width", 145 );
                content.css("margin-left", 200);
            } else{
                content.css("margin-left", $("#left").width());
            }

        },
        stop: function(){
            $("#left .ui-resizable-handle").css("background","none");
        },
        start: function(){
            $("#left .ui-resizable-handle").css("background","#aaa");
        }
    });
}

$("[rel=popover]").popover();

$('.toggle-nav').click(function(e){
    e.preventDefault();
    $("#left").toggle().toggleClass("forced-hide");
    if($("#left").is(":visible")) {
        $("#main").css("margin-left", $("#left").width());
    } else {
        $("#main").css("margin-left", 0);
    }
});

$('.table-mail .sel-star').click(function(e){
    e.preventDefault();
    e.stopPropagation();
    var $el = $(this);
    $el.toggleClass('active');
});

$('.table .sel-all').change(function(e){
    e.preventDefault();
    e.stopPropagation();
    var $el = $(this);
    $el.parents('.table').find("tbody .selectable").prop('checked', (el.prop('checked')));
});

$('.table-mail > tbody > tr').click(function(e){
    var $el = $(this);
    var checkbox = el.find('.table-checkbox > input');
    $el.toggleClass('warning');
    
    if(e.target.nodeName != 'INPUT')
    {
        checkbox.prop('checked', !(checkbox.prop('checked')));
    }
});

// set resize handler to corret height
resizeHandlerHeight();

$(".table .alpha").click(function (e) {
    e.preventDefault();
    var $el = $(this),
    str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
    elements = "",
    available = [];
    $el.parents().find('.alpha .alpha-val span').each(function(){
        available.push($(this).text());
    });

    for(var i=0; i<str.length; i++)
    {   
        var active = ($.inArray(str.charAt(i), available) != -1) ? " class='active'" : "";
        elements += "<li"+active+"><span>"+str.charAt(i)+"</span></li>";
    }
    $el.parents(".table").before("<div class='letterbox'><ul class='letter'>"+elements+"</ul></div>");
    $(".letterbox .letter > .active").click(function(){
        var $el = $(this);
        slimScrollUpdate($el.parents(".scrollable"), 0);
        var scrollToElement = $el.parents(".box-content").find(".table .alpha:contains('"+$el.text()+"')");
        slimScrollUpdate($el.parents(".scrollable"), scrollToElement.position().top);
        $el.parents(".letterbox").remove();
    });
});

$(".theme-colors > li > span").hover(function(e){
    var $el = $(this),
    body = $('body');
    body.attr("class","").addClass("theme-"+$el.attr("class"));
}, function(){
    var $el = $(this),
    body = $('body');
    if(body.attr("data-theme") !== undefined) {
        body.attr("class","").addClass(body.attr("data-theme"));
    } else {
        body.attr("class","");
    }
}).click(function(){
    var $el = $(this);
    document.cookie='theme_class='+$el.attr("class")+';domain='+document.domain+';path=/';
    $("body").addClass("theme-"+$el.attr("class")).attr("data-theme","theme-"+$el.attr("class"));
});

$(".version-toggle > a").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    var $el = $(this);
    var parent = $el.parent();
    if(!$el.hasClass("active")){
        parent.find(".active").removeClass("active");
        $el.addClass("active");
    }

    if($el.hasClass("set-fixed")){
        if($(window).width() >= 1200) {
            $("#content").addClass("container").removeClass("container-fluid");
            $("#navigation .container-fluid").addClass("container").removeClass("container-fluid");
            if($("#left").hasClass("sidebar-fixed")){
                $("#left").css("left", $("#content").offset().left);
            }
        }
    } else {
        $("#content").addClass("container-fluid").removeClass("container");
        $("#navigation .container").addClass("container-fluid").removeClass("container");
        $("#left").css("left", 0);
    }
});

$(".topbar-toggle > a").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    var $el = $(this);
    var $parent = $el.parent();
    if(!$el.hasClass("active")){
        $parent.find(".active").removeClass("active");
        $el.addClass("active");
    }

    if($el.hasClass("set-topbar-fixed")){
        $("#content").addClass("nav-fixed");
        $("#navigation").addClass("navbar-fixed-top");
    } else {
        $("#content").removeClass("nav-fixed");
        $("#navigation").removeClass("navbar-fixed-top");
    }
});

$(".sidebar-toggle > a").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    var $el = $(this);
    var $parent = $el.parent();
    if(!$el.hasClass("active")){
        $parent.find(".active").removeClass("active");
        $el.addClass("active");
    }  

    $(".search-form .search-pane input").attr("style", "");
    $("#main").attr("style","");

    if($el.hasClass("set-sidebar-fixed")){
        $("#left").addClass("sidebar-fixed");
        $("#left .ui-resizable-handle").css("top", 0);
        if($("#content").hasClass("container")){
            $("#left").css("left", $("#content").offset().left);
        }
        $("#left").getNiceScroll().resize().show();
        initSidebarScroll();
    } else {
        $("#left").removeClass("sidebar-fixed").css({
            "height": "auto",
            "top": "auto",
            "left": "auto"
        });
        $("#left").getNiceScroll().resize().hide();
        $("#left").removeClass("hasScroll");
    }
});


$(".del-gallery-pic").click(function(e){
    e.preventDefault();
    var $el = $(this);
    var $parent = $el.parents("li");
    $parent.fadeOut(400, function(){
        $parent.remove();
    });
});

checkLeftNav();

 // check layout
 if($("body").attr("data-layout") == "fixed"){
    $(".version-toggle .set-fixed").trigger('click');
}

if($("body").attr("data-layout-topbar") == "fixed"){
    $(".topbar-toggle .set-topbar-fixed").trigger("click");
}

if($("body").attr("data-layout-sidebar") == "fixed"){
    $(".sidebar-toggle .set-sidebar-fixed").trigger("click");
}
});

$.fn.scrollBottom = function() { 
  return $(document).height() - this.scrollTop() - this.height(); 
};

$(window).scroll(function(e){
    var height = 0,
    $w = $(window),
    $d = $(document);

    if($w.scrollTop() == 0 || $("#left").hasClass("sidebar-fixed"))
    {
        $("#left .ui-resizable-handle").css("top", height);
    } else {
        if($w.scrollTop() + $("#left .ui-resizable-handle").height() <= $d.height()) {
            height = $w.scrollTop() - 40;
        } else {
            height = $d.height() - $("#left .ui-resizable-handle").height() - 40;
        }
        $("#left .ui-resizable-handle").css("top", height);
    }

    if(!$("#content").hasClass("nav-fixed") && $("#left").hasClass("sidebar-fixed")){
        if($w.scrollTop() < 40){
            $("#left").css("top", 40 - $w.scrollTop());
        } else {
            $("#left").css("top", 0);
        }
    }


    
    getSidebarScrollHeight();
    resizeHandlerHeight();
});

$(window).resize(function(e){
    checkLeftNav();
    getSidebarScrollHeight();
});