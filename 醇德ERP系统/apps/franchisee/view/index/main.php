<section class="content-header">
  <h1>
    首页
    <small>控制台</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> 采购平台</a></li>
    <li><a href="#">管理中心</a></li>
    <li class="active">首页</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">公告消息</span>
          <span class="info-box-number"><?=$wdnum['num']?><small>条</small></span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-hourglass-half"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">待处理订单</span>
          <span class="info-box-number"><?=count($re)?></span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->
    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">本周新增会员</span>
          <span class="info-box-number"><?=$sendnum?></span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-cart-outline"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">本周消费会员</span>
          <span class="info-box-number"><?=$cardnum?></span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header ">
          <h3 class="box-title">最新未读公告</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>公告内容</th>
                  <th>公告日期</th>
                </tr>
              </thead>
              <?foreach ($ntrs as $key => $value) {?>
              <tr>
                <td><?=$value['content']?></td>
                <td><?=date("Y-m-d",$value['time'])?></td>
              </tr>
              <?}?>
            </table>
          </div>
        </div><!-- ./box-body -->
      </div><!-- /.box -->
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">未完成订单</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>订货日期</th>
                  <th>订单号</th>
                  <th>订单金额(元)</th>
                  <th>备注</th>
                  <th>状态</th>
                  <th>操作</th>
                </tr>
              </thead>
              <?foreach($re as $key=>$val){?>
              <tr>
                <td><?=date("Y-m-d",$val['created'])?></td>
                <td><?=$val['ordernum']?></td>
                <td>¥ <?=$val['price']?></td>
                <td><?=$val['remark']?></td>
                <td><?=$conf['orderstatus'][$val['status']]?></td>
                <td>
                  <a data-original-title="查看订购商品" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('purchase/orderinfo',array('ordernum'=>$val['ordernum']))?>"><i class="fa fa-sign-out"></i></a>
                </td>
              </tr>
              <?}?>
            </table>
          </div>
        </div><!-- ./box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section>
