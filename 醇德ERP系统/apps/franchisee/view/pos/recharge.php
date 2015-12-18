<section class="content-header">
	<h1>
		会员统计
		<small>会员消费记录</small>
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
				<h3 class="box-title">会员消费详情</h3>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-init">
						<thead>
							<tr>
								<th>类型</th>
								<th>金额</th>
								<th>备注</th>
								<th>时间</th>	
							</tr>
						</thead>
						<tbody>
							<?foreach ($rs as $key=>$val){?>
							<tr>
								<th><?=$val['type']==1?'充值':'消费';?></th>
								<td><?=$val['money']?>元</td>
								<td><?=$val['remark']?></td>
								<td><?=date('Y-m-d',$val['created'])?></td>
							</tr>
							<?}?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>