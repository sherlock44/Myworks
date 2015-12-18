<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<title>加盟商采购平台</title>
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="stylesheet" href="/public/assets/sysadmin/css/bootstrap.min.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/bootstrap-responsive.min.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/jquery-ui/smoothness/jquery-ui.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/jquery-ui/smoothness/jquery.ui.theme.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/themes.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/style.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css"/>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/chosen/chosen.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/jquery.dataTables.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/TableTools.css">

<script src="/public/assets/sysadmin/js/jquery.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/jquery-ui/jquery-ui.custom.min.js"></script>
<script src="/public/assets/sysadmin/js/bootstrap.min.js"></script>
<script src="/public/assets/sysadmin/js/zjj_function.js"></script>
<script src="/public/assets/sysadmin/js/plugins/form/jquery.form.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/bootbox/jquery.bootbox.js"></script>
<script src="/public/assets/sysadmin/js/plugins/imagesLoaded/jquery.imagesloaded.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/chosen/chosen.jquery.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/TableTools.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColReorder.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColVis.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.columnFilter.js"></script>
<script type="text/javascript">
var auto_jump = false;
$(function(){
	if(auto_jump === true){
		var left_one = $(".subnav").eq(0);
		var left_one_menu = left_one.find(".subnav-menu a").eq(0);
		window.location.href = left_one_menu.attr('href');
	}
})
</script>
</head>

<body >
	<div id="navigation">
		<div class="container-fluid">
			<a href="<?=$this->url('index/main')?>" id="brand">欢迎登录醇德订货系统</a>
			<a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="隐藏/显示左侧导航"><i class="icon-reorder"></i></a>
			<ul class='main-nav'>



			<?foreach($this->menu['menu'] as $key=>$val){?>
				<li <?if($this->pos==$key){?>class="active"<?}?>>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<i class="icon-table"></i>
						<span><?=$val['title']?></span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
							<?foreach($val['items'] as $k=>$v){?>
							<li <?if($this->type==$k && $this->pos==$key){?>class="active"<?}?>><a href="<?=$this->url($v['url'], array('type' => $k))?>"><?=$v['title']?></a></li>
							<?}?>
					</ul>
				</li>
				<?}?>
			</ul>
			<div class="user">
				<ul class="icon-nav">
					<li class='dropdown colo'>
						<a href="#" class='dropdown-toggle' data-toggle="dropdown"><i class="icon-tint"></i></a>
						<ul class="dropdown-menu pull-right theme-colors">
							<li class="subtitle">
								后台主题
							</li>
							<li>
								<span class='red'></span>
								<span class='orange'></span>
								<span class='green'></span>
								<span class="brown"></span>
								<span class="blue"></span>
								<span class='lime'></span>
								<span class="teal"></span>
								<span class="purple"></span>
								<span class="pink"></span>
								<span class="magenta"></span>
								<span class="grey"></span>
								<span class="darkblue"></span>
								<span class="lightred"></span>
								<span class="lightgrey"></span>
								<span class="satblue"></span>
								<span class="satgreen"></span>
							</li>
						</ul>
					</li>
				</ul>
				<div class="dropdown asdf">
					<a href="#" class='dropdown-toggle' data-toggle="dropdown"><?=$this->info['truename']?></a>
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="<?=$this->url('index/main')?>">后台首页</a>
						</li>
						<li>
							<a href="javascript:pub_alert_confirm(this,'您确定要退出系统吗？','<?=$this->url("common/logout")?>');">退出</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div id="content" class="container-fluid forced-fixed">
		<!--div id="left" class="ui-sortable ui-resizable" style="display: block;">
			<form class="search-form" method="GET" action="search-results.html">
				<div class="search-pane">
					<input type="text" placeholder="搜索" name="search">
					<button type="submit"><i class="icon-search"></i></button>
				</div>
			</form>
				<div class="subnav">
				<div class="subnav-title">
					<a class="toggle-subnav" href="#"><i class="icon-angle-down"></i><span><?=$this->menu['menu'][$this->pos]['title']?></span></a>
				</div>
				<ul class="subnav-menu">


					<?$categoryuuid=isset($_GET['categoryuuid'])?$_GET['categoryuuid']:''?>
					<?foreach($category as $k=>$v){?>
						<li <?if($categoryuuid==$v['uuid']){?>class="active"<?}?>>
						<a href="<?=$this->url('purchase/apply', array('type' => $this->type, 'categoryuuid' => $v['uuid']))?>"><?=$v['title']?></a>
						</li>
					<?}?>
						<li>
						<a href="<?=$this->url('purchase/cartlist')?>">购物车管理</a>
						</li>
				</ul>
				</div>
	<div class="ui-resizable-handle ui-resizable-e" style="z-index: 90; height: 389px; top: 0px;"></div></div-->

	<script type="text/javascript">
	function currentTime(){
		var $el = $(".stats .icon-calendar").parent(),
		currentDate = new Date(),
		monthNames = [1,2,3,4,5,6,7,8,9,10,11,12],
		dayNames = ["周日","周一","周二","周三","周四","周五","周六"];

		$el.find(".details span").html(currentDate.getFullYear() + " - " + monthNames[currentDate.getMonth()] + " - " + currentDate.getDate());
		$el.find(".details .big").last().html(currentDate.getHours()+":"+ ("0" + currentDate.getMinutes()).slice(-2) + "  " + dayNames[currentDate.getDay()]);
		setTimeout(function(){
			currentTime();
		}, 10000);
	}
	currentTime();
	</script>
	<style>#main{width:100%;margin-left:0px;}</style>
	<? include $this->loadview();?>
</div>
<script type="text/javascript">
// dataTables
if($('.dataTable').length > 0){
	$('.dataTable').each(function(){
		var opt = {
			"sPaginationType": "full_numbers",
			"oLanguage":{
				"sSearch": "<span>搜索:</span> ",
				"sInfo": "<span>_START_</span> - <span>_END_</span> 共 <span>_TOTAL_</span>",
				"sLengthMenu": "_MENU_ <span>条每页</span>",
				"oPaginate": {
					"sFirst" : "首页",
					"sLast" : "尾页",
			   		"sPrevious": " 上一页 ",
			   		"sNext":     " 下一页 "
		   		},
				"sInfoEmpty" : "没有记录",
				"sInfoFiltered" : "",
				"sZeroRecords" : '没有找到想匹配记录'
			}
		};
		opt.bStateSave = true;
		if($(this).hasClass("dataTable-ajax")){
			opt.bProcessing = true;
			opt.bServerSide = true;
			opt.sAjaxSource = "/epmaster/personal/index";
		}
		// 文章
		if($(this).hasClass("dataTable-for-article")){
			opt.aoColumns = [
					{ "mData": "articleid" },
					{ "mData": "title" },
					{ "mData": "author" },
					{ "mData": "publictime" },
					{ "mData": "state" },
					{ "mData": "operation" }
				];
			opt.aaSorting = [[0,'desc']];
			opt.aoColumnDefs = [{ "bSortable": false, "aTargets": [ 4,5 ] }];
		}
		// 文章
		if($(this).hasClass("dataTable-for-teacher")){
			opt.aoColumns = [
					{ "mData": "tid" },
					{ "mData": "name" },
					{ "mData": "unit" },
					{ "mData": "profession" },
					{ "mData": "email" },
					{ "mData": "state" },
					{ "mData": "operation" }
				];
			opt.aaSorting = [[0,'desc']];
			opt.aoColumnDefs = [{ "bSortable": false, "aTargets": [ 4,5 ] }];
		}
		// 活动
		if($(this).hasClass("dataTable-for-activity")){
			opt.aoColumns = [
					{ "mData": "activityid" },
					{ "mData": "title" },
					{ "mData": "programaid" },
					{ "mData": "starttime" },
					{ "mData": "endtime" },
					{ "mData": "publictime" },
					{ "mData": "state" },
					{ "mData": "operation" }
				];
			opt.aaSorting = [[0,'desc']];
			opt.aoColumnDefs = [{ "bSortable": false, "aTargets": [ 6,7 ] }];
		}
		// 视频
		if($(this).hasClass("dataTable-for-video")){
			opt.aoColumns = [
					{ "mData": "videoid" },
					{ "mData": "title" },
					{ "mData": "programaid" },
					{ "mData": "publictime" },
					{ "mData": "state" },
					{ "mData": "operation" }
				];
			opt.aaSorting = [[0,'desc']];
			opt.aoColumnDefs = [{ "bSortable": false, "aTargets": [ 4,5 ] }];
		}
		var oTable = $(this).dataTable(opt);
		$('.dataTables_filter input').attr("placeholder", "关键字");
		$(".dataTables_length select").wrap("<div class='input-mini'></div>").chosen({
			disable_search_threshold: 9999999
		});
	});
}
</script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<script src="/public/assets/sysadmin/js/application.js"></script>
<script src="/public/assets/sysadmin/js/demonstration.js"></script>


</body></html>