<link rel="stylesheet" href="/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
<section class="content-header">
  <h1>
    当前库存管理
    <small><?=$goods['title']?> 库存详情</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
    <li><a href="#">库存管理</a></li>
    <li class="active">当前库存管理</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">库存列表</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="orderTable" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>保质期至</th>
                  <th>库存(箱)</th>
                  <!--th>操作</th-->
                </tr>
              </thead>
              <tbody>
                <?foreach($re as $key=>$val){?>
                <tr>
                  <td><?=date("Y-m-d",$val['productontime'])?></td>
                  <td><?=$val['num']?></td>
                </tr>
                <?}?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>