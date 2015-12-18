<section class="content-header">
	<h1>
		消息提醒设置
		<small>业务状态改变时的消息提醒</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">参数设置</a></li>
		<li class="active">消息提醒设置</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">业务模块</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th style="width:10">名称</th>
									<th style="width:10">操作</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>采购设置</td>
									<td>
										<a data-original-title="修改" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('messageremind/userlist',array('keyword'=>'caigou'))?>"><i class="fa fa-edit"></i></a>
									</td>
								</tr>
								<tr>
									<td>加盟商订货设置</td>
									<td>
										<a data-original-title="修改" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('messageremind/userlist',array('keyword'=>'dinghuo'))?>"><i class="fa fa-edit"></i></a>
									</td>
								</tr>
								<tr>
									<td>加盟商退货设置</td>
									<td>
										<a data-original-title="修改" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('messageremind/userlist',array('keyword'=>'tuihuo'))?>"><i class="fa fa-edit"></i></a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
