<section class="content-header">
	<h1>
		加盟商管理
		<small>所有加盟商信息管理</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">客户管理</a></li>
		<li class="active">加盟商管理</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">加盟商列表</h3>
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
									<th>公司名称</th>
									<th>公司账号</th>
									<th>负责人姓名</th>
									<th>负责人电话</th>
									<th>电子邮箱</th>
									<th>状态</th>
									<th>添加时间</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<?foreach ($re as $key=>$val){?>
								<tr>
									<td style="display:none;"><?echo 0-$val['created'];?></td>
									<td><?=$val['ctitle']?></td>
									<td><?=$areaarray[$val['proviceid']]?>&nbsp;<?=$areaarray[$val['cityid']]?></td>
									<td><?=$val['commname']?></td>	
									<td><?=$val['username']?></td>
									<td><?=$val['truename']?></td>
									<td><?=$val['mobile']?></td>
									<td><?=$val['email']?></td>
									<td>
										<a href="javascript:pub_alert_confirm(this,'<?=$val['status']==0?'确定恢复正常？':'确定禁用？'?>','<?=$this->url("user/changefseestatussys")?>?id=<?=$val["id"]?>&status=<?=$val['status']==0?1:0?>');" 
										class="btn btn-xs <?=$val['status']==0?'btn-danger':'btn-success'?>" title="<?=$val['status']==0?'恢复正常':'禁用'?>">
										<?=$val['status']==0?'禁用':'正常'?>
										</a>
									</td>
									<td><?=date('Y-m-d',$val['created'])?></td>
									<td>	 
										<a class="btn btn-xs btn-success" href="<?=$this->url('user/editJointrader',array('id'=>$val['id']))?>"><i class="fa fa-edit"></i></a>         				 
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