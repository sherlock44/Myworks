<section class="content-header">
	<h1>
		会员统计
		<small>会员订单管理</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> 采购平台</a></li>
		<li><a href="#">收银统计</a></li>
		<li class="active">会员统计</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">
					会员订单记录
				</h3>	
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-init">
						<thead>
							<tr>
								<th>订单号</th>
								<th>订单金额</th>
								<th>操作人员</th>
								<th>订单日期</th>	
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?foreach ($rs as $key=>$val){?>
							<tr>	
								<td><?=$val['orderno']?></td>
								<td><?=$val['price']?></td>
								<td><?=$val['truename']?></td>
								<td><?=date('Y-m-d',$val['created'])?></td>
								<td>
									<a data-original-title="查看详情" rel="tooltip" class="btn btn-small btn-info" href="<?=$this->url('pos/useroderDetail',array('id'=>$val['id']))?>"  ><i class="icon-edit"></i></a>
								</td>
							</tr>
							<?}?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>