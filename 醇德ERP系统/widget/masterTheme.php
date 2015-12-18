<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<title>醇德ERP系统</title>
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
  <script src="/public/adminlte/bootstrap/js/bootstrap.min.js"></script>
  <script src="/public/adminlte/plugins/bootbox/bootbox.min.js"></script>
<script src="/public/assets/sysadmin/js/zjj_function.js"></script>
<script src="/public/assets/sysadmin/js/plugins/form/jquery.form.min.js"></script>

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
<?
		$this->loadHelper("arrayHelper");

		$this->loadModel('system','menu');
		$sql	=	"select pin,menuid from system_menu where module='".$this->actionName."' and method='".$this->functionName."'";
		$userpin	=	$this->system->menuModel->fetchRow($sql);


		if(!isset($_SESSION['access_user_list']) || !in_array($userpin['pin'],$_SESSION['access_user_list']) ){
			if($this->actionName!='index'){
			ob_start();

			header("location:/index.php/iManage/common/alert?msg=没有权限&sleep=3");
			ob_end_flush();
			exit();;
			}
		}
		// 顶部菜单
		$menu_nav = menu_tree ( 0, $_SESSION['menudata'] );
		// 当前点击菜单组合
		$click_nav = intval ( isset($_GET['cnav']) ) ? intval ( $_GET['cnav'] ) : 0;
		$click_left = intval ( isset($_GET['cleft']) ) ? intval ( $_GET['cleft'] ) : 0;
		$click_menuid = intval ( isset($_GET['cmenuid']) ) ? intval ( $_GET['cmenuid'] ) : 0;
		// 左侧菜单
		if ($click_nav == 0) {
				$click_menuid = isset($_SESSION['menudata'][$userpin['menuid']]['parentid'])?$_SESSION['menudata'][$userpin['menuid']]['parentid']:0;
				$click_nav =    isset($_SESSION['menudata'][$click_menuid]['parentid'])?$_SESSION['menudata'][$click_menuid]['parentid']:0;
				$click_navs = $click_nav;
		}else{
			$click_navs = $click_nav;
			}
		$menu_left = menu_tree ( $click_navs, $_SESSION['menudata'] );

		
		
		
?>
<body >
	<div id="navigation">
		<div class="container-fluid">
			<a href="javascript:void(0)" id="brand">醇德ERP系统</a>
			<a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="隐藏/显示左侧导航"><i class="icon-reorder"></i></a>
			<ul class='main-nav'>
			<?if(is_array($menu_nav)){?>
				<?foreach($menu_nav as $key=>$val){?>
				<li <?if($click_navs==$val['menuid']){?>class="active"<?}?>>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<i class="icon-table"></i>
						<span><?=$val['title']?></span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
							<?foreach($val['childs'] as $k=>$v){?>
							<li <?if($click_menuid==$v['menuid']){?>class="active"<?}?>><a href="<?=$this->url($v['module'] . '/' . $v['method'] . '?cnav=' . $val['menuid'] . '&cleft=' . $k . '&cmenuid=' . $v['menuid'] . $v['parameter'])?>"><?=$v['title']?></a></li>
							<?}?>
					</ul>
				</li>
				<?}?>
				<?}?>




			</ul>
			<div class="user">

				<div class="dropdown asdf">
					<a href="#" class='dropdown-toggle' data-toggle="dropdown"><?=$_SESSION['admininfo']['truename']?></a>
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="<?=$this->url('index/user')?>">我的个人信息</a>
						</li>
						<li>
							<a href="<?=$this->url('index/mywebInfo')?>">我的站内信息</a>
						</li>
						<?if(!empty($_SESSION['indexmain'])){?>
						<li>
							<a href="<?=$_SESSION['indexmain']?>">我的工作台</a>
						</li>
						<?}?>
						<li>
							<a href="javascript:pub_alert_confirm(this,'您确定要退出系统吗？','<?=$this->url("common/logout")?>');">退出</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div id="content" class="container-fluid forced-fixed">
		<style>
	#main{margin-left:0px;}
	</style>
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