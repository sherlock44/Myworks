<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<section class="content-header">
	<h1>
		采购申请
		<small><?=$this->sysconf['purchasestatus'][$re['status']]?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> ERP系统</a></li>
		<li><a href="#">采购管理</a></li>
		<li class="active">采购申请</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<?if($re['status'] < 1 && $re['memberid']==$this->info['id']){?>
			<form class="box form-validate form-confirm" action='<?=$this->url("buyer/updateapply")?>' id="myform" method='post'>
				<div class="box-header">
					<h3 class="box-title">修改申请信息</h3>
				</div>
				<div class="box-body row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="title">名称</label>
							<input type="text" name="data[title]" id="title" value="<?=$re['title']?>" class="form-control" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
						</div>
						<div class="form-group">
							<label for="zgid">审批人</label>
							<select name='data[zgid]' class="form-control" >
								<?foreach($admin as $val){?>
								<option value="<?=$val['id']?>" <?if($val['id']==$re['zgid']){echo "selected";}?> ><?=$val['name']?></option>
								<?}?>
							</select>
						</div>
						<div class="form-group">
							<label for="remark">描述</label>
							<textarea class="form-control" name="remark" placeholder="(商品信息，数量，目的)"><?=!empty($re) ? $re['remark']: ''?></textarea>
						</div>
						<div class="form-group">
							<label for="status">当前状态</label>
							<select name='data[status]' class="form-control">
								<option value="0">草稿</option>
								<option value="1">审批人审核</option>
							</select>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<input type="hidden" value="<?=!empty($re)?$re['id']:''?>" name="id">
					<input type="submit" class="btn btn-success" value="修改">				
					<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>	
				</div>
			</form>
			<?} else {?>
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#activity" data-toggle="tab">采购信息</a></li>
					<li><a href="#timeline" data-toggle="tab">操作历史</a></li>
				</ul>
				<div class="tab-content">
					<div class="active tab-pane" id="activity" >
						<section class="invoice" style="margin: 0;">
							<div class="row">
								<div class="col-xs-12">
									<h2 class="page-header">
										<i class="fa fa-globe"></i> <?=$re['title']?>
										<small class="pull-right">申请日期: </small>
									</h2>
								</div><!-- /.col -->
							</div>
							<div class="row invoice-info">
								<div class="col-sm-6 invoice-col">
									<p class="lead">采购信息</p>
									<address>
										申请人: <?=!empty($re) ? $re['cgname']: ''?><br>
										审批人: <?=!empty($re) ? $re['zgname']: ''?><br>
										描述: <?=!empty($re) ? $re['remark']: ''?><br>
										当前状态: <?=$this->sysconf['purchasestatus'][$re['status']]?>
									</address>
								</div><!-- /.col -->
								<?if($re['status']>=4){?>
								<div class="col-sm-3 invoice-col">
									<p class="lead">供应商信息</p>
									<!-- <address>
										名称: <?=$userinfo['commname']?>.<br>
										类型: <?=$userinfo['commtel']?><br>
										地址: <?=$userinfo['pname']?>
									</address> -->
								</div><!-- /.col -->
								<div class="col-sm-3 invoice-col">
									<p class="lead">&nbsp;</p>
								<!-- 	<address>
										联系人: <?=$userinfo['proname']?><br>
										联系人电话: <?=$userinfo['protel']?>
									</address> -->
								</div><!-- /.col -->
								<?}?>
							</div><!-- /.row -->
							<?if($re['status']>=4){?>
							<div class="row">
								<div class="col-xs-12 table-responsive">
									<p class="lead">采购商品列表</p>
									<table class="table table-striped">
										<thead>
											<tr>
												<th >商品名称</th>
												<th >商品条码</th>
												<th >采购类型</th>
												<th >供应商</th>
												<th >进价(元)</th>
												<?if($re['status']>=11){?>
												<th >售价(元)</th>
												<th >临期价(元)</th>
												<?}?>
												<th >单品单位</th>				
												<th >数量</th>
											</tr>
										</thead>
										<?foreach($goods as $key=>$value){?>
										<tr>
											<td><?=$value['title']?></td>
											<td><?=$value['barcode']?></td>
											<td><?=$value['cashtype']?></td>
											<td><?=$value['supplyname']?></td>
											<td><?=$value['costprice']?></td>	
											<?if($re['status']>=11){?>
											<td><?=$value['saleprice']?></td>
											<td><?=$value['futureprice']?></td>
											<?}?>
											<td><?=$value['specs']?></td>
											<td>
												<?=$value['number']?>
											</td>
										</tr>
										<?}?>
									</table>
								</div>
							</div>
							<?}?>
						</section>
					</div>
					<div class="tab-pane" id="timeline" style="padding:5px;">
						<ul class="timeline timeline-inverse">
							<!-- timeline time label -->
							<?  $firstdate='';?>
							<?foreach($logs as $ks=>$value){?>
							<?$firstdate=$ks;?>
							<li class="time-label">
								<span class="bg-red">
									<?=$ks;?>
								</span>
							</li>
							<?foreach($value as $kd=>$value2){?>
							<li>
								<div class="timeline-item">
									<span class="time"><i class="fa fa-clock-o"></i> <?=date("H:i:s",$value2['created'])?></span>
									<h3 class="timeline-header"><?=$value2['results']?> － 操作人: <?=$value2['truename']?> </h3>
									<?if($value2['remark']){?>
									<div class="timeline-body">
										<?=$value2['remark']?>
									</div>
									<?}?>
								</div>
							</li>
							<?}?>
							<?}?>
							<?if(count($logs) < 1 || $firstdate!=date("Y-m-d",$order['created'])){?>
							<li class="time-label">
								<span class="bg-red">
									<?=date("Y-m-d",$order['created']);?>
								</span>
							</li>
							<?}?>
							<li>
								<div class="timeline-item">
									<span class="time"><i class="fa fa-clock-o"></i> <?=date("H-i-s",$order['created']);?></span>
									<h3 class="timeline-header"><a href="#"><?=$userinfo['commname']?></a> 提交了订单</h3>
									<?if($order['remark']){?>
									<div class="timeline-body">
										<?=$order['remark']?>
									</div>
									<?}?>
								</div>
							</li>
							<!-- END timeline item -->
							<li>
								<i class="fa fa-clock-o bg-gray"></i>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<?if($re['status']==1 && $this->info['id']==$re['zgid']){?>
			<form class="box form-validate form-confirm" action='<?=$this->url("buyer/changestatus1")?>' id="myform" method='post'>
				<div class="box-header">
					<h3 class="box-title">审核</h3>
				</div>
				<div class="box-body row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="remark">备注</label>
							<textarea name="data[remark]" style="width:500px;" rows="3" class="form-control"></textarea>
						</div>
						<div class="form-group">
							<label for="results">审核结果</label>
							<select name="data[results]" style="width:120px;" class="form-control">
								<option value="1">通过</option>
								<option value="-1">取消采购</option>
							</select>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<input type="hidden" value="<?=!empty($re)?$re['id']:''?>" name="id">
					<input type="submit" class="btn btn-success" value="提交">				
					<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>	
				</div>
			</form>
			<?}?>
			<?}?>
		</div>
	</div>
</section>
<?if($contract){?>
<div class="box box-default">
	<div class="box-header with-border">
		合同列表
	</div>
	<div class="box-body">
		<div class="table-responsive">
			<form   class='form-horizontal form-bordered form-validate'	action=''   method='post'>
				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
					<thead>
						<tr>
							<th width="3%">序号</th>
							<th >合作商</th>
							<th >提交人</th>
							<th >提交时间</th>
							<th >合同名称</th>
							<th >验货标准</th>
							<?if($re['status']>=6 || $re['status']==-2){?>
							<th >是否支付定金</th>
							<th >定金额度</th>
							<?}?>
							<?if($re['status']>=8  || $re['status']==-2){?>
							<th >库房验收结果</th>
							<?}?>
							<?if($re['status']>=10){?>
							<th >尾款</th>
							<?}?>
							<th >操作</th>
						</tr>
					</thead>
					<?foreach($contract as $k=>$val){?>
					<tr>
						<td><?=($k+1)?></td>
						<td><?=$val['supplyname']?></td>		
						<td><?=$val['truename']?></td>		
						<td><?if(!empty($val['created'])){?><?=date("Y-m-d",$val['created'])?><?}?></td>	
						<td><?=$val['contracttitle']?></td>		
						<td><?=$val['remark']?></td>	
						<?if($re['status']>=6  || $re['status']==-2){?>	
						<td><?=empty($val['isdep'])?"否":"是"?></td>		
						<td><?=$val['depnum']?></td>	
						<?}?>
						<?if($re['status']>=8 || $re['status']==-2){?>	
						<td><?if($val['isproblem']==1){echo "通过";}else if($val['isproblem']==0){echo "已重新调整合同";}else if($val['isproblem']==-1){echo "退回";}?></td>	
						<?}?>
						<?if($re['status']>=10){?>	
						<td><?=$val['tailmoney']?></td>	
						<?}?>							
						<td><a href="<?=$val['contractpath']?>" >点击下载</a></td>		
					</tr>		
					<?}?>
				</table>
			</form>		
		</div>
	</div>
</div>
<?}?>
<script>
	//返回列表
	function returnList(){
		window.location.href="<?=$this->url('buyer/pubapply')?>";
	}
</script>