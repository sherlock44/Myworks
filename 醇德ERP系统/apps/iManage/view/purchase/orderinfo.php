<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<section class="content-header">
	<h1>
		订单详情
		<small>
			<? $kk=0;?>
			<?foreach($this->conf['orderstatus'] as $k=>$v){?>
			<?if($k < 0){ 
				continue; 
			}?>
			<?if($kk>0){?>
			<?="&rArr;&nbsp;";?>
			<?}?>
			<?if($order['status']==$k){?>
			<span style="color:green;"><?echo $v;?></span>
			<?}else{?>
			<?=$v;?>
			<?}?>
			<? $kk++;?>
			<?}?>
		</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">订单管理</a></li>
		<li class="active">订单详情</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#activity" data-toggle="tab">订单信息</a></li>
					<li><a href="#timeline" data-toggle="tab">操作历史</a></li>
				</ul>
				<div class="tab-content">
					<div class="active tab-pane" id="activity" >
						<!-- Main content -->
						<section class="invoice" style="margin: 0;">
							<!-- title row -->
							<div class="row">
								<div class="col-xs-12">
									<h2 class="page-header">
										<i class="fa fa-globe"></i> <?=$userinfo['commname']?> 订货单
										<small class="pull-right">订单日期: <?=date("Y-m-d",$order['created']);?></small>
									</h2>
								</div><!-- /.col -->
							</div>
							<!-- info row -->
							<div class="row invoice-info">
								<div class="col-sm-6 invoice-col">
									<p class="lead">订单信息</p>
									<address>
										订单号: #<?=$ordernum?> <?if($order['orderbackstatus']>0){?><span style="color:red;">[已退货]</span><?}?><br>
										订单类型: <?=!empty($order['freeordernum'])?"赠送订单":"销售订单"?><br>
										<?if(!empty($order['freeordernum'])){?>
										关联订单: #<a href="<?=$this->url('purchase/orderinfo',array('ordernum'=>$order['freeordernum'],'token'=>$order['token']))?>"><?=$order['freeordernum']?></a><br>
										<?}?>
										<?if(!empty($freeorder)){?>
										关联赠送订单: #<a href="<?=$this->url('purchase/orderinfo',array('ordernum'=>$freeorder['ordernum'],'token'=>$order['token']))?>"><?=$freeorder['ordernum']?></a><br>
										<?}?>
										下单时间: <?=date("H:i:s",$order['created']);?>
									</address>
								</div><!-- /.col -->
								<div class="col-sm-3 invoice-col">
									<p class="lead">客户信息</p>
									<address>
										名称: <?=$userinfo['commname']?>.<br>
										电话: <?=$userinfo['commtel']?><br>
										邮箱: <?=$userinfo['email']?><br>
										地址: <?=$userinfo['pname']?>省 <?=$userinfo['cname']?>市<br>
										<?=$userinfo['address']?>
									</address>
								</div><!-- /.col -->
								<div class="col-sm-3 invoice-col">
									<p class="lead">&nbsp;</p>
									<address>
										联系人: <?=$userinfo['proname']?><br>
										联系人电话: <?=$userinfo['protel']?><br>
										联系人邮箱: <?=$userinfo['proemail']?>
									</address>
								</div><!-- /.col -->
								
							</div><!-- /.row -->
							<!-- Table row -->
							<div class="row">
								<div class="col-xs-12 table-responsive">
									<p class="lead">商品列表</p>
									<table class="table table-striped">
										<thead>
											<tr>
												<th>品名</th>
												<th>条码</th>
												<th>订货单价</th>
												<th>装箱规格</th>
												<th>重量</th>
												<th>保质期至</th>
												<?if($order['status']==0 || $order['status']==1){?>
												<th>剩余库存</th>
												<th  width="130px">订购量</th>
												<th>操作</th>
												<?}else{?>
												<th style="text-align: right;">订购量</th>
												<th style="text-align: right;">小计</th>
												<?}?>
											</tr>
										</thead>
										<tbody>
											<?
											$weights=0;
											$aprices=0;
											$anum=0;
											$realbacknum=0;?>
											<?foreach($re as $key=>$value){?>
											<?$weights+=$value['weights']*($value['buynum']-$value['realbacknum']);
											$aprices+=$value['allprice'];		
											$anum+=	$value['buynum'];		
											$realbacknum+=	$value['realbacknum'];?>
											<tr style="<?if($value['tag']==0){?>background:#EC2085;<?}?>">
												<td><?=$value['title']?></td>
												<td><?=$value['barcode']?></td>
												<!-- <td><?=!empty($value['shelflife'])?$value['shelflife']:'--'?></td> -->
												<td>¥ <?=$value['buyprice']?>/<?=$value['specs']?></td>	
												<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>
												<td><?=$value['weight']?>g/<?=$value['specs']?></td>
												<td><?if(empty($value['shelflife'])){echo '--';}else{echo date("Y-m-d",empty($value['productontime'])?time():$value['productontime']);}?></td>	
												<?if($order['status']==0 || $order['status']==1){?>
												<td><?=$value['hasnumber']?>箱<input type="hidden" value="<?=$value['hasnumber']?>" id="hasnumber_<?=$value['id']?>"></td>
												<td>
													<div class="input-group input-group-sm">
														<input type="text" id="goodsnum_<?=$value['id']?>" style="min-width:70px;" name="goodsnum_<?=$value['id']?>" onchange="changenum(<?=$value['id']?>,'<?=$ordernum?>')"  value="<?=$value['buynum']?>" class="form-control" data-rule-required="true" data-rule-number="true" data-rule-minlength="1" placeholder="只能填数字">
														<span class="input-group-btn">
															<button class="btn btn-success" type="button">箱</button>
														</span>
													</div>
												</td>
												<td>
													<button onclick="javascript:window.open('<?=$this->url("purchase/preparegoods",array("id"=>$value["id"],"ordernum"=>$value["ordernum"]))?>','','toolbar=false,status=false,menubar=false,location=false,directions=false,width=800,height=600,scrollbars=yes')"  class="btn btn-primary btn-xs"><i class="fa fa-check"></i></button>
													<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("purchase/delgoods")?>?id=<?=$value["id"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-trash"></i></a>
												</td>
												<?}else{?>
												<td align="right"><?=$value['buynum']?>&nbsp;箱</td>
												<td align="right">¥ <?=$value['allprice']?></td>
												<?}?>						
											</tr>
											<?}?>
										</tbody>
									</table>
								</div><!-- /.col -->
								<div class="col-xs-12">
									<p class="lead">合计</p>
									<div class="table-responsive">
										<table class="table">
											<tr>
												<th style="width:80%">总重量:</th>
												<td><?=$weights?>kg</td>
											</tr>
											<tr>
												<th>总箱数:</th>
												<td><?=$anum?> 箱</td>
											</tr>
											<tr>
												<th>总额:</th>
												<td>¥ <?=$order['allprice']?> 元</td>
											</tr>
										</table>
									</div>
								</div><!-- /.col -->
								<?if(!empty($logistics)){?>
								<div class="col-md-12">
									<p class="lead">物流信息</p>
									<div class="table-responsive">
										<table class="table">
											<tr>
												<th width="12.5%">打单员:</th>
												<td width="12.5%"><?=empty($logistics['truename'])?'':$logistics['truename']?></td>
												<th width="12.5%">配货员:</th>
												<td width="12.5%">
													<?=$logistics['peihuoname']?>
												</td>
												<th width="12.5%">核验员:</th>
												<td width="12.5%">
													<?=$logistics['heyanname']?>
												</td>
												<th width="12.5%">发货人:</th>
												<td width="12.5%">
													<?=$logistics['fahuoname']?>
												</td>
											</tr>
											<tr>
												<th>物流公司:</th>
												<td colspan="7"><?=empty($logistics['companystart'])?'':$logistics['companystart']?></td>
											</tr>
											<tr>
												<th colspan="2">发货地物流公司名称:</th>
												<td colspan="2"><?=empty($logistics['companystart'])?'':$logistics['companystart']?></td>
												<th>电话:</th>
												<td><?=empty($logistics['mobilestart'])?'':$logistics['mobilestart']?></td>
												<th>联系人:</th>
												<td><?=empty($logistics['usernamestart'])?'':$logistics['usernamestart']?></td>
											</tr>
											<tr>
												<th colspan="2">到达地物流公司名称:</th>
												<td colspan="2"><?=empty($logistics['companyarrive'])?'':$logistics['companyarrive']?></td>
												<th>电话:</th>
												<td><?=empty($logistics['mobilearrive'])?'':$logistics['mobilearrive']?></td>
												<th>联系人:</th>
												<td><?=empty($logistics['usernamearrive'])?'':$logistics['usernamearrive']?></td>
											</tr>
											<tr>
												<th>总重量:</th>
												<td><?=empty($logistics['weight'])?'':$logistics['weight']?></td>
												<th>发货日期:</th>
												<td><?=empty($logistics['senddate'])?'':date('Y-m-d',$logistics['senddate'])?></td>
												<th>物流费用:</th>
												<td><?=empty($logistics['logisticscost'])?'':$logistics['logisticscost']?></td>
												<th>物流单号:</th>
												<td><?=empty($logistics['logisticsnumber'])?'':$logistics['logisticsnumber']?></td>
											</tr>
											<tr>
												<th>货物总件数:</th>
												<td><?=empty($logistics['goodsnum'])?'':$logistics['goodsnum']?>箱</td>
												<th>预计到达:</th>
												<td><?=empty($logistics['maybearrivedate'])?'':date('Y-m-d',$logistics['maybearrivedate'])?></td>
												<th>送货费用:</th>
												<td><?=empty($logistics['sendmoney'])?'':$logistics['sendmoney']?>
													<?if(!empty($logistics['isarrivepay'])){echo "&nbsp;&nbsp;到付";}?>
												</td>
												<th>物流车号:</th>
												<td><?=empty($logistics['carnumber'])?'':$logistics['carnumber']?></td>
											</tr>
											<tr>
												<th>备注:</th>
												<td colspan="7"><?=empty($logistics['remark'])?'':$logistics['remark']?></td>
											</tr>
										</table>
									</div>
								</div>
								<?}?>
								<div class="col-xs-12">
									<a href="<?=$this->url("common/printorder",array('ordernum'=>$ordernum));?>" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> 打印</a>
								</div>
							</div><!-- /.row -->
							<!-- this row will not appear when printing -->
						</section>

					</div><!-- /.tab-pane -->
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
					</div><!-- /.tab-pane -->
				</div><!-- /.tab-content -->
			</div><!-- /.nav-tabs-custom -->
			<?if(in_array($order['status'],array(0,1))){?>
			<?$url=$this->url("purchase/updateorderstatus");?>
			<?if($order['status']==2){?>
			<?$url=$this->url("purchase/selstoretype");?>
			<?}?>
			<form class="box form-validate form-confirm" action='<?=$url?>' id="myform" method='post'>
				<div class="box-header with-border">
					<h3 class="box-title">审核</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-xs-6">
							<?if($order['status']==0 || $order['status']==1){?>
							<div class="form-group">
								<label for="results">审核结果</label>
								<select name="data[results]" onchange="changeresult(this.value)" class="form-control">
									<option value="1">通过</option>
									<option value="0">修改通过</option>
									<option value="-1">取消订单</option>
								</select>
							</div>
							<div class="form-group">
								<label for="mobile">选择出库类型</label>
								<select name="storetypeid" class="form-control">
									<?foreach($store as $val){?>
									<option value="<?=$val['id']?>"><?=$val['title']?></option>
									<?}?>
								</select>
							</div>
							<div class="form-group">
								<label for="mobile">备注</label>
								<textarea name="data[remark]" class="form-control" rows="3"></textarea>
							</div>
							<script>
								function changeresult(val){
									if(val==-1){
										$(".storetypetype").hide();
									}else{
										$(".storetypetype").show();
									}
								}
							</script>	
							<?}?>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<input type="hidden" value="<?=$order['id']?>" name="id">
					<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> 审核订单</button>
				</div>
			</form>
			<?}?>
			<?if($order['status']==2){?>
			<form class="box form-validate form-confirm" action='<?=$this->url("purchase/reupdateorderstatus")?>' id="myform" method='post'>
				<div class="box-header with-border">
					<h3 class="box-title">反审</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<label for="mobile">备注</label>
								<textarea name="data[remark]" rows="3" class="form-control" placeholder="反审之后,可以修改商品订购数据"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<input type="hidden" value="<?=$order['id']?>" name="id">
					<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> 反审核</button>
				</div>
			</form>
			<?}?>
		</div><!-- /.col -->
	</div>
</section>
<script>
	function returnList(){
		window.location.href='<?=$this->url("purchase/orderconfirm")?>';
	}
	function changenum(id,ordernum){
		var num	=	$("#goodsnum_"+id).val();
		var hasnumber	=	$("#hasnumber_"+id).val();
		if(isNaN(num)){return false;}
		$.ajax({
			url:"<?=$this->url('purchase/updatecart')?>",
			data:"id="+id+"&num="+num+"&ordernum="+ordernum+"&hasnumber="+hasnumber,
			type:"post",
			dataType:"json",
			success:function(r){
				if(r.state == 1){
					pub_alert_success(r.info);
					if(r.data == 'back'){
						setTimeout('location.reload()',100);
					}
				}else{
					pub_alert_error(r.info);
				}
			}
		});
	}
</script>