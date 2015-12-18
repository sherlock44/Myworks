


<link rel="stylesheet" href="/public/adminlte/plugins/daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="/public/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap time picker -->
<script src="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>

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
								<form class="col-xs-12 table-responsive form-validate form-confirm" action='<?=$this->url('purchase/changeprice')?>' id="editprice" method='post'>
									<p class="lead">商品列表</p>
									<table class="table table-striped">
										<thead>
											<tr>
												<?$colspan=11;?>
												<th>品名</th>
												<th>条码</th>
												<th>订货单价</th>
												<th>装箱规格</th>
												<th>重量</th>
												<th>保质期至</th>
												<th style="text-align: right;">订购量</th>
												<?if($order['backstatus']==6){ $colspan=12;?>
												<th style="text-align: right;">退货数量</th>
												<?}?>
												<th style="text-align: center;" width="130">小计</th>
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
											$aprice	= $value['allprice'];
											if(empty($value['allprice']) || $value['allprice']<=0){
												//$aprice	= $value['buynum']*$value['boxnum']*$value['buyprice'];
											}
											$aprices+=$aprice;		
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
												<td align="right"><?=$value['buynum']?>&nbsp;箱</td>
												<?if($order['backstatus']==6){?>
												<td align="right"><?=$value['realbacknum']?>箱</td>
												<?}?>
												<td>
													<div class="input-group input-group-sm">
														<span class="input-group-addon">¥</span>
														<input type="text" class="form-control backmoney" name="foeallprice[]" onchange="changeprice()" value="<?=$aprice?>">
														<input type="hidden" name="foeid[]" value="<?=$value['foeid']?>">
													</div>
												</td>						
											</tr>
											<?}?>
										</tbody>
									</table>
									<input type="hidden" value="<?=$order['id']?>" name="orderid">
									<input  type="hidden" class="span8" name="allprice" id="allprice" value="<?=$order['allprice']?>" >
									<button type="submit" class="btn btn-primary btn-sm pull-right"><i class="fa fa-edit"></i> 修改价格</button>
								</form><!-- /.col -->
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
												<td>¥ <?=$order['allprice']?> 元
												
												</td>
											</tr>
										</table>
									</div>
								</div><!-- /.col -->
								<?if($logistics){?>
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
			<?$url=$this->url("purchase/updateorderstatusfr");?>
			<?if($order['status']==4){?>
			<?$url=$this->url("purchase/updateorderstatusfr2");?>
			<?}?>
			<?if($order['status']==-4){?>
			<?$url=$this->url("purchase/updateorderstatusfr3");?>
			<?}?>
			<form class="box form-validate form-confirm" action='<?=$url?>' id="myform" method='post'>
				<div class="box-header with-border">
					<h3 class="box-title">付款记录</h3>
				</div>
				<div class="box-body row">
					<div class="col-xs-12">
						<table class="table table-bordered table-hover" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
							<thead>
								<tr>
									<th >付款金额(元)</th>
									<th >银行账号</th>
									<th >收款时间</th>						
									<th >收款方式</th>							
									<th >备注</th>
									<th >操作</th>
								</tr>
							</thead>
							<?$k=0;?>
							<?foreach($paylog as $k=>$val){?>
							<tr>
								<?if($val['created']==0){$created=$val['created'];}else{$created=date("Y-m-d",$val['created']);}?>
								<td>
									<input class="form-control input-sm" type="text" id="paymoney_<?=$val['id']?>" value="<?=$val['paymoney']?>" style="width:150px;"  />
								</td>
								<td>
									<select class="form-control input-sm" style="width:200px;" id="banknum_<?=$val['id']?>">
										<?foreach($bank as $valb){?>
										<?if($val['banknum']==$valb['bankname']){?>
										<option value="<?=$valb['bankname']?>" selected="selected"><?=$valb['bankname']?></option>
										<?}else{?>
										<option value="<?=$valb['bankname']?>"><?=$valb['bankname']?></option>
										<?}?>
										<?}?>
									</select>
								</td>
								<td>
									<input class="form-control input-sm datepick1" id="paytime_<?=$val['id']?>" type="text"  style="width:150px;" value="<?=empty($val['paytime'])?'':date("Y-m-d",$val['paytime'])?>"/>
								</td>	
								<td>
									<select class="form-control input-sm" id="paytype_<?=$val['id']?>" style="width:100px;" ><?foreach($paytype as $v){?><option value="<?=$v['id']?>" <?=$val['paytype']==$v['id']?'selected':''?>><?=$v['title']?></option><?}?></select>
								</td>	
								<td>
									<input class="form-control input-sm" id="payremark_<?=$val['id']?>" type="text"  value="<?=$val['remark']?>"/>
								</td>	
								<td>
									<a class="btn btn-primary btn-sm" href="javascript:void(0)" onclick="addpaylog(<?=$val['id']?>)">修改</a>
									&nbsp;&nbsp;
									<a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="delpaylog(<?=$val['id']?>)">删除</a>
								</td>	
							</tr>
							<?}?>
							<tr>
								<td>
									<input class="form-control input-sm" type="text" id="paymoney_0" value=""  style="width:150px;" />
								</td>
								<td>
									<select class="form-control input-sm" style="width:200px;" id="banknum_0">
										<?foreach($bank as $val){?>
										<option value="<?=$val['bankname']?>"><?=$val['bankname']?></option>
										<?}?>
									</select>
								</td>
								<td>
									<input class="form-control input-sm datepick2" type="text"  id="paytime_0" style="width:150px;" value=""/>
								</td>	
								<td>
									<select class="form-control input-sm" style="width:100px;" id="paytype_0">
										<?foreach($paytype as $v){?>
										<option value="<?=$v['id']?>"><?=$v['title']?></option>
										<?}?>
									</select>
								</td>	
								<td><input class="form-control input-sm" type="text" id="payremark_0" value=""/></td>
								<td><a class="btn btn-success btn-sm" href="javascript:void(0)" onclick="addpaylog(0)">提交</a></td>
							</tr>
						</table>
					</div>
					<div class="col-xs-6">
						<?if($order['status']==2){?>
						<input type="hidden" name="paydate">
						<div class="form-group">
							<label for="paytype" >收款类型</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="paytype" id="paytype1" onclick="changepaytype(this.value);$('#skzh').show();" value="1">全额收款&nbsp;&nbsp;&nbsp;
							</label>
							<label>
								<input id="paytype0" type="checkbox" name="paytype" onclick="changepaytype(this.value);$('#skzh').hide();" value="0">信用收款
							</label>
						</div>
						<input type="hidden" name="bankid">
						<div class="form-group">
							<label for="remark">备注</label>
							<textarea name="data[remark]" class="form-control" rows="3"></textarea>
						</div>

						<?}?>
						<?if($order['status']==-4){?>
						<div class="form-group">
							<label for="remark" >备注</label>
							<textarea name="data[remark]" class="form-control" rows="3"></textarea>
						</div>
						<div class="form-group">
							<label for="results" >财务审核</label>
							<select name="data[results]" class="form-control">
								<option value="1">等待退款</option>
								<option value="-1">已退款,订单已无效</option>
							</select>
						</div>
						<?}?>
					</div>
				</div>
				<?if(in_array($order['status'],array(2,-4))){?>
				<div class="box-footer">
					<input type="hidden" value="<?=$order['id']?>" name="id">
					<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> 提交信息</button>
				</div>
				<?}?>
			</form>
			<?if($order['status']==3){?>
			<form class="box form-validate form-confirm" action='<?=$this->url("purchase/updateorderstatusfrback")?>' id="myform2" method='post'>
				<div class="box-header with-border">
					<h3 class="box-title">反审</h3>
				</div>
				<div class="row box-body">
					<div class="col-xs-6">
						<div class="form-group">
							<label for="remark">备注</label>
							<textarea name="data[remark]" rows="3" class="form-control" placeholder="反审之后,可以修改商品订购数据"></textarea>
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
$(function () {
		$('.datepick1').daterangepicker({singleDatePicker: true,language: 'zh-CN', format: 'YYYY-MM-DD'});
		$('.datepick2').daterangepicker({singleDatePicker: true,language: 'zh-CN', format: 'YYYY-MM-DD'});
	});
	function changepaytype(val){
		if(val==1){
			var other=0;
		}else{
			var other=1;
		}
		if($("#paytype"+val).prop('checked')){
			$("#paytype"+other).attr("checked",false);
		}
	}
	function returnList(){
		window.location.href='<?=$this->url("purchase/orderinfofr")?>';
	}
	function changeprice(){
		var money	=	0;
		var price	=	0;
		$(".backmoney").each(function(){
			price=$(this).val()-0;
			money=Number((money+price).toFixed(2));
		});
		$("#allprice").val(money);
	}	
	function addpaylog(id){
		var ordernum="<?=$ordernum?>";
		var paymoney=$("#paymoney_"+id).val();
		var banknum=$("#banknum_"+id).val();
		var paytime=$("#paytime_"+id).val();
		var paytype=$("#paytype_"+id).val();
		var payremark=$("#payremark_"+id).val();
		$.ajax({
			data:{paymoney:paymoney,banknum:banknum,paytime:paytime,paytype:paytype,remark:payremark,ordernum:ordernum,id:id},
			url:"<?=$this->url('purchase/paylogtj')?>",
			dataType:"json",
			type:"post",
			success:function(r){
				if(r.state==1){
					alert("保存成功");
					location.reload();
				}else{
					alert(r.info);
				}
			}
		});
	}
	function delpaylog(id){
		$.ajax({
			data:{id:id},
			url:"<?=$this->url('purchase/delpaylog')?>",
			dataType:"json",
			type:"post",
			success:function(r){
				if(r.state==1){
					location.reload();
				}else{
					alert(r.info);
				}
			}
		});
	}
</script>