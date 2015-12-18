<link rel="stylesheet" href="/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
<section class="content-header">
	<h1>
		加盟商管理
		<small>加盟商订单列表</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> 后台管理</a></li>
		<li><a href="#">加盟商管理</a></li>
		<li class="active">加盟商订单列表</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">加盟商订单列表</h3>

				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-init">
							<thead>
								<tr>
									<th>订单编号</th>
									<th>订单总价</th>
									<th>支付状态</th>
									<th>下单时间</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<?foreach ($rs as $key=>$val){?>
								<tr>
									<td ><?=$val['orderno']?></td>
									<td><?=$val['price']?></td>
									<td><?=$val['paystatus']==0?'未支付':'已支付';?></td>
									<td><?=date('Y-m-d',$val['created'])?></td>
									<td> 
										<a data-original-title="查看订单详情" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('statis/orderDetil',array('id'=>$val['id']))?>"><i class="fa fa-sign-out"></i></a>
									</td>
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