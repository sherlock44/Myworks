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
			<div class="small-box bg-purple">
				<div class="inner">
					<h3>&nbsp;<?=count($cash)+count($cashplan)?>&nbsp;</h3>
					<p>待处理采购</p>
				</div>
				<div class="icon">
					<i class="ion ion-bag"></i>
				</div>
				<a href="#" class="small-box-footer">查看更多 <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div><!-- ./col -->
	
	
	

		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">
						待处理任务
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
								<tr>
        							<th style="display:none;">业务日期</th>
        							<th>业务日期</th>
        							<th>业务单号</th>
        							<th>业务类型</th>
									<th>状态</th>
                                    <th>备注</th>
                                   
                                    <th>操作</th>
        						</tr>
							</tr>
						</thead>
						
									<!--待处理采购-->
                            <?
                                foreach($cash as $key=>$val){
                                    ?>
                                    <tr>
										
            							<td  style="display:none;"><?echo 0-$val['created'];?></td>
            							<td><?=date("Y-m-d",$val['created'])?></td>
            							<td><?=$val['ordernum']?></td>
            							<td>采购</td>
										<td><?=$conf['purchasestatus'][$val['status']]?></td>
            							<td><?=$val['remark']?></td>
            							
            							 
            							<td>
     								      <a data-original-title="查看" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('buyer/editapplycaigou',array('id'=>$val['id']))?>"><i class="fa fa-sign-out"></i></a>
						                </td>
            						</tr>
                                    <?}?>
										<!--待处理采购计划-->
                            <?
                                foreach($cashplan as $key=>$val){
                                    ?>
                                    <tr>
									<td  style="display:none;"><?echo 0-$val['created'];?></td>
            							<td><?=date("Y-m-d",$val['created'])?></td>
            							<td><?=$val['ordernum']?></td>
            							<td>采购计划</td>
										<td><?=$conf['purchasestatus'][$val['status']]?></td>
            							<td><?=$val['remark']?></td>
            							
            							
            							<td>
     								      <a data-original-title="查看" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('buyer/editpubapply',array('id'=>$val['id']))?>"><i class="fa fa-sign-out"></i></a>
						                </td>
            						</tr>
                                    <?}?>
					</table>
				</div>
			</div>
			

		</div>
	</div><!-- /.row -->
</section>

