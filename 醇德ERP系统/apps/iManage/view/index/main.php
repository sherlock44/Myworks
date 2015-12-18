<section class="content-header">
	<h1>
		首页
		<small>控制台</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> ERP系统</a></li>
		<li><a href="#">系统管理</a></li>
		<li class="active">首页</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-2 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>&nbsp;<?=$franchiseenum?>&nbsp;</h3>
					<p>加盟商</p>
				</div>
				<div class="icon">
					<i class="ion ion-person"></i>
				</div>
				<a href="<?=$this->url('user/franchisee')?>" class="small-box-footer">查看更多<i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div><!-- ./col -->
		<div class="col-lg-2 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3>&nbsp;<?=count($re)?>&nbsp;</h3>
					<p>待处理订单</p>
				</div>
				<div class="icon">
					<i class="fa fa-shopping-cart"></i>
				</div>
				<a href="#" class="small-box-footer">查看更多 <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div><!-- ./col -->
		<div class="col-lg-2 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-primary">
				<div class="inner">
					<h3>&nbsp;<?=$orderbacknum?>&nbsp;</h3>
					<p>退货订单</p>
				</div>
				<div class="icon">
					<i class="ion ion-bag"></i>
				</div>
				<a href="#" class="small-box-footer">查看更多 <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div><!-- ./col -->
		<div class="col-lg-2 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-purple">
				<div class="inner">
					<h3>&nbsp;<?=count($cash)?>&nbsp;</h3>
					<p>待处理采购</p>
				</div>
				<div class="icon">
					<i class="ion ion-bag"></i>
				</div>
				<a href="#" class="small-box-footer">查看更多 <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div><!-- ./col -->
		<div class="col-lg-2 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-green">
				<div class="inner">
					<h3>&nbsp;<?=$sendnum?>&nbsp;</h3>
					<p>待入库事项</p>
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="#" class="small-box-footer">查看更多 <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div><!-- ./col -->

		<div class="col-lg-2 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-red">
				<div class="inner">
					<h3>&nbsp;<?=$cardnum?>&nbsp;</h3>
					<p>待出库事项</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="#" class="small-box-footer">查看更多 <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>

		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">
						待处理加盟订单
					</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
					<table class="table table-bordered table-hover">
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
							<td><?=$val['price']?></td>
							<td><?=$val['remark']?></td>
							<td><?=$conf['orderstatus'][$val['status']]?></td>
							<td>
								<a data-original-title="查看订购商品" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('purchase/orderinfo',array('ordernum'=>$val['ordernum']))?>"><i class="fa fa-edit"></i></a>
								<a href="javascript:pub_alert_confirm(this,'确定要取消吗？','<?=$this->url("purchase/updateorderstatus")?>?id=<?=$val["id"]?>&status=-1');" class="btn btn-xs btn-danger" title="取消"><i class="fa fa-close"></i></a>
							</td>
						</tr>
						<?}?>
					</table>
				</div>
			</div>
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">
						待处理采购
					</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>名称</th>
								<th>申请人</th>
								<th>审批人</th>
								<th>状态</th>
								<th>申请时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<?foreach($cash as $key=>$val){?>
						<tr>
							<td><?=$val['id']?></td>
							<td><?=$val['title']?></td>
							<td><?=$val['cgname']?></td>
							<td><?=$val['zgname']?></td>
							<td style="<?if($val['status']>0 && $val['status']<12){?>color:red;<?}?>"><?=$conf['purchasestatus'][$val['status']]?></td>
							<td><?=date("Y-m-d",$val['created'])?></td>
							<td>
								<a data-original-title="查看" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('newcash/editapply',array('id'=>$val['id']))?>"><i class="fa fa-sign-out"></i></a>
								<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("newcash/delapply")?>?id=<?=$val["id"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-close"></i></a>
							</td>
						</tr>
						<?}?>
					</table>
				</div>
			</div>
		</div>
	</div><!-- /.row -->
</section>
