
<script src="/public/assets/sysadmin/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/jquery-ui/jquery-ui.custom.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/form/jquery.form.min.js"></script>
<section class="content-header">
	<h1>
		角色管理
		<small>系统角色管理</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">系统管理</a></li>
		<li class="active">角色管理</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">角色列表</h3>
					<div class="box-tools pull-right">
						<a href="<?=$this->url('system/group_modify')?>" class="btn btn-default btn-sm"> <i class="fa fa-group"></i>
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
									<th width="50">ID</th>
									<th>权限组名称</th>
									<th width="100">操作</th>
								</tr>
							</thead>
							<tbody>
								<?foreach($re as $value){?>
								<tr>
									<td><?=$value['groupid']?></td>
									<td><?=$value['title']?></td>
									<td>
										<a data-original-title="修改" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('system/group_modify')?>?id=<?=$value["groupid"]?>"><i class="fa fa-edit"></i></a>
										<a class="btn btn-xs btn-primary" href="javascript:pub_alert_html('<?=$this->url('system/role_lock')?>?id=<?=$value["groupid"]?>');"  ><i class="fa fa-gear"></i></a>
										<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("system/group_del")?>?id=<?=$value["groupid"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-trash"></i></a>
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
