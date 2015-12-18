
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>加盟商采购平台</title>
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
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav layout-boxed">
  <div class="wrapper">
    <header class="main-header">
      <nav class="navbar navbar-static-top">
        <div class="container">
          <div class="navbar-header">
            <a href="<?=$this->url("index/main")?>" class="navbar-brand">加盟商采购平台</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
              <i class="fa fa-bars"></i>
            </button>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            <ul class="nav navbar-nav">
              <?foreach($this->menu['menu'] as $key=>$val){?>
              <li <?if($this->pos==$key){?>class="active"<?}?>>
                <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                  <?=$val['title']?>
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                  <?foreach($val['items'] as $k=>$v){?>
                  <li <?if($this->type==$k && $this->pos==$key){?>class="active"<?}?>><a href="<?=$this->url($v['url'], array('type' => $k))?>"><?=$v['title']?></a></li>
                  <?}?>
                </ul>
              </li>
              <?}?>
            </ul>
<!-- <form class="navbar-form navbar-left" role="search">
<div class="form-group">
<input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
</div>
</form> -->
</div><!-- /.navbar-collapse -->
<!-- Navbar Right Menu -->
<?
//购物车
$this->loadModel('franchisee', 'ordercart');
$sql = "select pg.title from franchisee_ordercart as fo left join  product_goods as pg on fo.goodsid=pg.id  where token='" . $this->info['token'] . "'";

$recart = $this->franchisee->ordercartModel->fetchAll($sql);
?>
<div class="navbar-custom-menu">
  <ul class="nav navbar-nav">
    <!-- Messages: style can be found in dropdown.less-->
    <li class="dropdown notifications-menu">
      <!-- Menu toggle button -->
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-shopping-cart"></i>
       <?if(count($recart)){?> <span class="label label-warning"><?=count($recart)?></span><?}?>
      </a>
      <ul class="dropdown-menu">
        <li class="header">您的购物车中有 <?=count($recart)?> 件商品</li>
        <li>
          <!-- inner menu: contains the messages -->
          <ul class="menu">
            <?foreach($recart as $k=>$v){?>
            <?if($k==5){break;}?>
            <li><!-- start message -->
              <a href="javascript:void(0)">
                <?=$v['title']?>
              </a>
            </li><!-- end message -->
            <?}?>

          </ul><!-- /.menu -->
        </li>
        <li class="footer"><a href="<?=$this->url('purchase/cartlist')?>">查看购物车</a></li>
      </ul>
    </li><!-- /.messages-menu -->
    <?
    $this->loadModel('product', 'webinfouser');
    $sql  = "select count(*) as num from product_webinfouser where token='".$this->info['token']."' and sign=1";
    $smesn  = $this->product->webinfouserModel->fetchRow($sql);
    $smesnum  = $smesn['num'];
    $sql = "select pwer.* ,pw.time,sa.truename,sa.imgpath
    from product_webinfouser as pwer
    join product_webinfo as pw on pw.id = pwer.webinfoid
    join system_admin as sa on sa.id    = pw.seuserid
    where pwer.token = '".$this->info['token']."' ";
    $smes = $this->product->webinfouserModel->fetchAll($sql);
    ?>
    <li class="dropdown messages-menu">
      <!-- Menu toggle button -->
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-envelope-o"></i>
         <?if($smesnum){?><span class="label label-danger"><?=$smesnum?></span><?}?>
      </a>
      <ul class="dropdown-menu">
        <li class="header">您有 <?=$smesnum?> 个未读消息</li>
        <li>
          <!-- inner menu: contains the messages -->
          <ul class="menu">
            <?foreach($smes as $val){?>
            <li><!-- start message -->
              <a href="#">
                <div class="pull-left">
                  <!-- User Image -->
                  <img src="<?=empty($val['imgpath'])?'/public/adminlte/dist/img/user2-160x160.jpg':$val['imgpath']?>" class="img-circle" alt="User Image">
                </div>
                <!-- Message title and timestamp -->
                <h4>
                  管理员
                  <small><i class="fa fa-clock-o"></i> <?=date("Y-m-d H:i:s",$val['time'])?></small>
                </h4>
                <!-- The message -->
                <p><?=$val['title']?></p>
              </a>
            </li><!-- end message -->
            <?}?>
          </ul><!-- /.menu -->
        </li>
        <li class="footer"><a href="<?=$this->url('system/sysNotice')?>">查看所有消息</a></li>
      </ul>
    </li><!-- /.messages-menu -->
    <!-- User Account Menu -->
    <li class="dropdown user user-menu">
      <!-- Menu Toggle Button -->
      <a href="" class="dropdown-toggle" data-toggle="dropdown">
        <!-- The user image in the navbar-->
        <img src="/public/adminlte/dist/img/avatar04.png" class="user-image" alt="User Image">
        <!-- hidden-xs hides the username on small devices so only the image appears. -->
        <span class="hidden-xs"><?=$this->info['commname']?></span>
      </a>
      <ul class="dropdown-menu">
        <!-- The user image in the menu -->
        <li class="user-header">
          <img src="/public/adminlte/dist/img/avatar04.png" class="img-circle" alt="User Image">
          <p>
            <?=$this->info['commname']?>
          </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body">
          <div class="col-xs-12 text-center">
            <a href="<?=$this->url('system/edit')?>">编辑个人信息</a>
          </div>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
          <div class="pull-left">
            <a href="<?=$this->url('index/editPassword')?>" class="btn btn-default btn-flat">修改密码</a>
          </div>
          <div class="pull-right">
            <a href="javascript:pub_alert_confirm(this,'您确定要退出系统吗？','<?=$this->url("common/logout")?>');" class="btn btn-default btn-flat">退出系统</a>
          </div>
        </li>
      </ul>
    </li>
  </ul>
</div><!-- /.navbar-custom-menu -->
</div><!-- /.container-fluid -->
</nav>
</header>
<!-- Full Width Column -->
<div class="content-wrapper">
  <div class="container">
    <?php include $this->loadview();?>
  </div><!-- /.container -->
</div><!-- /.content-wrapper -->
<footer id="footer" class="main-footer" style="position: fixed; bottom: 0px; width:100%; display: none; padding: 0px;">
  <div class="container" id="footer-container">
<!--  <div class="pull-right hidden-xs">
<b>Version</b> 2.0
</div>
<strong>Copyright &copy; 2015 <a href="http://www.chunde001.cn">醇德国际品牌管理有限公司</a>.</strong> 版权所有.
-->
</div>
</footer>
</div><!-- ./wrapper -->
<!-- SlimScroll -->
<script src="/public/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/public/adminlte/plugins/fastclick/fastclick.min.js"></script>
<!-- DataTables -->
<script src="/public/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/public/adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/public/adminlte/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="/public/adminlte/dist/js/demo.js"></script> -->

<script type="text/javascript">
  function setfooterfixed(html){
    $("#footer-container").html(html);
    $("#footer").css("padding","8px");
    $("#footer").show();
  }

  $(function () {
    if ($('table.table-init').length > 0) {
      $('table.table-init').each(function() {
        $(this).DataTable({
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
