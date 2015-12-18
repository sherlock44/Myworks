<section class="content-header">
	<h1>
		银行账户管理
		<small>银行账户信息管理</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> ERP系统</a></li>
		<li><a href="#">财务管理</a></li>
		<li class="active">银行账户管理</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">银行账户列表</h3>
					<div class="box-tools pull-right">
						<a href="<?=$this->url('Financialaffairs/addBank')?>" class="btn btn-default btn-sm"> <i class="fa fa-plus"></i>
							添加
						</a>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-init">
							<thead>
								<tr>
									<th >ID</th>
									<th>开户银行</th>
									<th>开户用户名</th>
									<th>银行账户</th>
									<th>更新时间</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<?foreach ($re as $key=>$val){?>
								<tr>
									<td><?=$val['id']?></td>
									<td><?=$val['bankname']?></td>
									<td><?=$val['bankuser']?></td>
									<td><?=$val['banknum']?></td>
									<td><?=date('Y-m-d',$val['uptime'])?></td>
									<td> 
										<a data-original-title="修改" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('Financialaffairs/editBank',array('id'=>$val['id']))?>"><i class="fa fa-edit"></i></a>
										<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("Financialaffairs/delBank")?>?id=<?=$val["id"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-trash"></i></a>
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