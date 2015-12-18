<section class="content-header">
	<h1>
		入库设置
		<small>入库类型设置</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">参数设置</a></li>
		<li class="active">入库设置</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">入库类型列表</h3>
					<div class="box-tools pull-right">
						<a href="<?=$this->url('preferences/addstorage')?>" class="btn btn-default btn-sm">
							<i class="fa fa-plus"></i>&nbsp;添加
						</a>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-init">
							<thead>
								<tr>
									<th>ID</th>
									<th>名称</th>
									<th>状态</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<?foreach($re as $key=>$val){?>
								<tr>
									<td><?=$val['id']?></td>
									<td><?=$val['title']?></td>
									<td><?if($val['status']==0){echo '<span class="label label-warning">禁用</span>';}else{echo '<span class="label label-success">正常</span>';}?></td>
									<td>
										<a class="btn btn-xs btn-success" href="<?=$this->url('preferences/editstorage',array('id'=>$val['id']))?>">
											<i class="fa fa-edit"></i>
										</a>
										<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("preferences/delstorage")?>?id=<?=$val["id"]?>');" class="btn btn-xs btn-danger">
											<i class="fa fa-trash"></i>
										</a>
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