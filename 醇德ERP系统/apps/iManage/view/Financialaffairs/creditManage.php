<section class="content-header">
	<h1>
		加盟商信用管理
		<small>加盟商信用额度管理</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> ERP系统</a></li>
		<li><a href="#">财务管理</a></li>
		<li class="active">加盟商信用管理</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">加盟商信用列表</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-init">
							<thead>
								<tr>
									<th style="display:none;">ID</th>
									<th>客户类型</th>
									<th>所属区域</th>
									<th>公司账号</th>
									<th>公司名称</th>
									<th>负责人姓名</th>
									<th>负责人电话</th>
									<th>电子邮箱</th>
									<th>信用额度</th>
									<th>可用额度</th>
									<th>状态</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<?foreach ($re as $key=>$val){?>
								<tr>
									<td style="display:none;"><?echo 0-$val['created'];?></td>
									<td><?=$val['ctitle']?></td>
									<td><?=$areaarray[$val['proviceid']]?>&nbsp;<?=$areaarray[$val['cityid']]?></td>
									<td><?=$val['username']?></td>
									<td><?=$val['commname']?></td>
									<td><?=$val['truename']?></td>
									<td><?=$val['mobile']?></td>
									<td><?=$val['email']?></td>
									<td><?=$val['creditline']?></td>
									<td><?=$val['canusemoney']?></td>
									<td>
										<?if($val['status']==0){?>
											<a href="javascript:pub_alert_confirm(this,'确定恢复正常？','<?=$this->url("user/changefseestatus")?>?id=<?=$val["id"]?>&status=1');" class="btn btn-xs btn-danger" title="恢复正常">禁用</a>
										<?}else{?>
											<a href="javascript:pub_alert_confirm(this,'确定禁用？','<?=$this->url("user/changefseestatus")?>?id=<?=$val["id"]?>&status=0');" class="btn btn-xs btn-success" title="禁用">正常</a>
										<?}?>
									</td>
									<td>
										<a data-original-title="修改信用额度" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('Financialaffairs/editCredit',array('id'=>$val['id']))?>"><i class="fa fa-edit"></i></a>
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