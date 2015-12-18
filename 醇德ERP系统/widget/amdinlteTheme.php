<?php

$this->
loadHelper("arrayHelper");

$this->loadModel('system', 'menu');
$sql = "select pin,menuid from system_menu where module='" . $this->actionName . "' and method='" . $this->functionName . "'";
$userpin = $this->system->menuModel->fetchRow($sql);

// if (!isset($_SESSION['access_user_list']) || !in_array($userpin['pin'], $_SESSION['access_user_list'])) {
//     if ($this->actionName != 'index') {
//         ob_start();

//         header("location:/index.php/iManage/common/alert?msg=没有权限&sleep=3");
//         ob_end_flush();
//         exit();
//     }
// }
// 顶部菜单
$menu_nav = menu_tree(0, $_SESSION['menudata']);
// 当前点击菜单组合
$click_nav = intval(isset($_GET['cnav'])) ? intval($_GET['cnav']) : 0;
$click_left = intval(isset($_GET['cleft'])) ? intval($_GET['cleft']) : 0;
$click_menuid = intval(isset($_GET['cmenuid'])) ? intval($_GET['cmenuid']) : 0;
// 左侧菜单
if ($click_nav == 0) {
	$click_menuid = isset($_SESSION['menudata'][$userpin['menuid']]['parentid']) ? $_SESSION['menudata'][$userpin['menuid']]['parentid'] : 0;
	$click_nav = isset($_SESSION['menudata'][$click_menuid]['parentid']) ? $_SESSION['menudata'][$click_menuid]['parentid'] : 0;
	$click_navs = $click_nav;
} else {
	$click_navs = $click_nav;
}
$menu_left = menu_tree($click_navs, $_SESSION['menudata']);

/*
echo "
<pre>";
print_r($_SESSION['menudata']);
echo "<hr>";
print_r($click_navs);

exit;
 */
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>醇德ERP系统</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="/public/adminlte/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/public/adminlte/dist/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/public/adminlte/dist/css/ionicons.min.css">
  <!--DataTables -->
  <link rel="stylesheet" href="/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/public/adminlte/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/public/adminlte/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="/public/adminlte/dist/js/html5shiv.min.js"></script>
    <script src="/public/adminlte/dist/js/respond.min.js"></script>
  <![endif]-->
  <!-- jQuery 2.1.4 -->
  <script src="/public/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="/public/adminlte/bootstrap/js/bootstrap.min.js"></script>
  <script src="/public/adminlte/plugins/bootbox/bootbox.min.js"></script>
  <script src="/public/assets/sysadmin/js/zjj_function.js"></script>
<script src="/public/assets/sysadmin/js/plugins/form/jquery.form.min.js"></script>
  <style type="text/css">
  .modal-dialog{ margin-top: 120px;  }
  </style>
</head>
  <!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
  <!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue fixed sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <header class="main-header">
      <!-- Logo -->
      <a href="javascript:void(0);" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">ERP</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">醇德<b>ERP</b>
        </span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            <li class="dropdown messages-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope-o"></i>
                <!-- <span class="label label-success">4</span> -->
              </a>
			  <?
				$this->loadModel('product', 'webinfouser');
				$this->loadModel('product', 'webinfo');
				$sql = "select pwer.* ,pw.time,sa.truename,pw.title
						from product_webinfouser as pwer
						join product_webinfo as pw on pw.id = pwer.webinfoid
						join system_admin as sa on sa.id    = pw.seuserid
						where pwer.sign=1 and  pwer.reuserid = ".$this->info['id'];
				$remeslh = $this->product->webinfouserModel->fetchAll($sql);
			  
			  ?>
              <ul class="dropdown-menu">
                <li class="header">您有<?=count($remeslh)?>个新消息</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
				  <?foreach($remeslh as $k=>$val){?>
                    <li>
                      <!-- start message -->
                      <a href="<?=$this->url('index/myskin',array('id'=>$val['id']))?>">
                        
                        <h4>
                         <?=$val['title']?>
                          <small> <i class="fa fa-clock-o"></i>
                           <?=date('Y-m-d',$val['time'])?>
                          </small>
                        </h4>
                       
                      </a>
                    </li>
					<?}?>
                    <!-- end message --> </ul>
                </li>
                <li class="footer">
                  <a href="<?=$this->url('index/mywebInfo')?>">更多</a>
                </li>
              </ul>
            </li>
            <!-- Notifications: style can be found in dropdown.less -->
            
            <!-- Tasks: style can be found in dropdown.less -->
           
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?=$_SESSION['admininfo']['imgpath']?$_SESSION['admininfo']['imgpath']:'/public/adminlte/dist/img/avatar04.png'?>" class="user-image" alt="User Image">
                <span class="hidden-xs"><?=$_SESSION['admininfo']['truename'];?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">

                  <img src="<?=$_SESSION['admininfo']['imgpath']?$_SESSION['admininfo']['imgpath']:'/public/adminlte/dist/img/avatar04.png'?>" class="img-circle" alt="User Image">
                  <p>
                    <?=$_SESSION['admininfo']['truename'];?> - <?=$_SESSION['admininfo']['title'];?>
                    <small><?=$_SESSION['admininfo']['name'];?></small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                  <a href="<?=$this->url('index/user');?>" class="btn btn-default btn-flat"><i class="fa fa-user"></i> 个人信息</a>
                  </div>
                  <div class="pull-right">
                    <a href="javascript:pub_alert_confirm(this,'您确定要退出系统吗？','<?=$this->url("common/logout");?>');" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> 退出系统</a>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
              <a href="#" data-toggle="control-sidebar">
                <i class="fa fa-gears"></i>
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="<?=$_SESSION['admininfo']['imgpath']?$_SESSION['admininfo']['imgpath']:'/public/adminlte/dist/img/avatar04.png'?>" class="img-circle" alt="User Image"></div>
          <div class="pull-left info">
            <p><?=$_SESSION['admininfo']['truename'];?></p>
            <a href="#">
              <i class="fa fa-circle text-success"></i>
              在线
            </a>
          </div>
        </div>

        <!-- search form -->
        <!--<form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                <i class="fa fa-search"></i>
              </button>
            </span>
          </div>
        </form> -->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">系统栏目</li>
         <?php if (is_array($menu_nav)) {
	       foreach ($menu_nav as $key => $val) { ?>
              <li <?php echo $click_navs == $val['menuid'] ? 'class="treeview active"' : 'class="treeview"';?>>
                <a href="#"><span><?=$val['title'];?></span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                <?php foreach ($val['childs'] as $k => $v) {;?>
                  <li <?php echo $click_menuid == $v['menuid'] ? 'class="active"' : '';?>>
                    <a href="<?=$this->url($v['module'] . '/' . $v['method'] . '?cnav=' . $val['menuid'] . '&cleft=' . $k . '&cmenuid=' . $v['menuid'] . $v['parameter']);?>">
                      <i class="fa fa-circle-o"></i><?=$v['title'];?>
                    </a>
                  </li>
                <?php } ?>
                </ul>
              </li>
           <?php } ?>
        <?php } ?>
        </ul>
      </section>
      <!-- /.sidebar --> </aside>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


      <!-- Main content -->

      <?php include $this->loadview();?>
        <!-- /.box -->
      <!-- /.content --> </div>
    <!-- /.content-wrapper -->

    <!-- <footer class="main-footer">
      <div class="pull-right hidden-xs"> <b>Version</b>
        2.3.0
      </div> <strong>Copyright &copy; 2014-2015
        <a href="http://almsaeedstudio.com">Almsaeed Studio</a>
        .</strong>
      All rights reserved.
    </footer> -->
<footer id="footer" class="main-footer" style="position: fixed; bottom: 0px; width:100%; display: none; padding: 0px;">
  <div class="container" id="footer-container">
<!--  <div class="pull-right hidden-xs">
<b>Version</b> 2.0
</div>
<strong>Copyright &copy; 2015 <a href="http://www.chunde001.cn">醇德国际品牌管理有限公司</a>.</strong> 版权所有.
-->
</div>
</footer>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Create the tabs -->
      <!-- Tab panes -->
      <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
          </div>
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->
  <!-- SlimScroll -->
  <script src="/public/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
<script src="/public/adminlte/plugins/fastclick/fastclick.min.js"></script>
  <!-- DataTables -->
  <script src="/public/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="/public/adminlte/plugins/datatables/dataTables.bootstrap.js"></script>
  <!-- AdminLTE App -->
  <script src="/public/adminlte/dist/js/app.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="/public/adminlte/dist/js/demo.js"></script>
  <script type="text/javascript">
  function setfooterfixed(html){
    $("#footer-container").html(html);
    $("#footer").css("padding","8px");
    $("#footer").show();
  }
    $(function () {
      if ($('table.table-init').length > 0) {
        $('table.table-init').each(function() {
          $(this).dataTable({
            "language": {
                "search":"搜索",
                "searchPlaceholder":"请输入关键字",
                "lengthMenu": "每页 _MENU_ 条记录",
                "zeroRecords": "没有找到记录",
                "info": "第 _PAGE_ 页 - 共 _PAGES_ 页",
                "infoEmpty": "无记录",
                "infoFiltered": "(从 _MAX_ 条记录过滤)",
                "paginate": {
                    "first": "首页",
                    "last": "尾页",
                    "previous": '<i class="fa fa-angle-left"></i>',
                    "next": '<i class="fa fa-angle-right"></i>'
                }
            },
            "pagingType": "full_numbers",
          });
        });
      }
    });
  </script>
</body>
</html>