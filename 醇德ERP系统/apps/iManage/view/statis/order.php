<section class="content-header">
	<h1>
		加盟商订单统计
		<small>加盟商订单信息统计</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">统计管理</a></li>
		<li class="active">加盟商订单统计</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
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
									<th style="display:none;">ID</th>
									<th>客户类型</th>
									<th>所属区域</th>
									<th>公司名称</th>
									<th>负责人姓名</th>
									<th>负责人电话</th>
									<th>电子邮箱</th>
									<th>添加时间</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<?foreach ($re as $key=>$val){?>
								<tr>
									<td style="display:none;"><?echo 0-$val['created'];?></td>
									<td><?=$val['ctitle']?></td>
									<td><?=$areaarray[$val['proviceid']]?>&nbsp;<?=$areaarray[$val['cityid']]?>&nbsp;<?=$areaarray[$val['areaid']]?></td>
									<td><?=$val['commname']?></td>
									<td><?=$val['truename']?></td>
									<td><?=$val['mobile']?></td>
									<td><?=$val['email']?></td>
									<td><?=date('Y-m-d',$val['created'])?></td>
									<td>	 
										<a data-original-title="查看订单" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('statis/listOrder',array('id'=>$val['token']))?>"><i class="fa fa-edit"></i></a>
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