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
								<div class="col-md-12">
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
								<div class="col-md-12 table-responsive">
									<p class="lead">商品列表</p>
									<table class="table table-striped">
										<thead>
											<tr>
												<th>品名</th>
												<th>条码</th>
												<!--th>订货单价</th-->
												<th>装箱规格</th>
												<th>重量</th>
												<th>保质期至</th>
												<th style="text-align: right;">订购量</th>
												<?if($order['backstatus']==6){?>
												<th style="text-align: right;">退货数量</th>
												<?}?>
												<!--th style="text-align: right;">小计</th-->
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
												<!--td>¥ <?=$value['buyprice']?>/<?=$value['specs']?></td-->	
												<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>
												<td><?=$value['weight']?>g/<?=$value['specs']?></td>
												<td><?if(empty($value['shelflife'])){echo '--';}else{echo date("Y-m-d",empty($value['productontime'])?time():$value['productontime']);}?></td>	
												<td align="right"><?=$value['buynum']?>&nbsp;箱</td>
												<?if($order['backstatus']==6){?>
												<td align="right"><?=$value['realbacknum']?>箱</td>
												<?}?>
												<!--td align="right">¥ <?=$value['allprice']?></td-->					
											</tr>
											<?}?>
										</tbody>
									</table>
								</div><!-- /.col -->
								<div class="col-md-12">
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
											<!--tr>
												<th>总额:</th>
												<td>¥ <?=$order['allprice']?> 元</td>
											</tr-->
										</table>
									</div>
								</div><!-- /.col -->
								<div class="col-md-12">
									<a id="dy" href="<?=$this->url("common/printorderkf",array('ordernum'=>$ordernum));?>" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> 打印</a>
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
									<span class="time" id="usertime"><i class="fa fa-clock-o"></i> <?=date("Y-m-d H:i:s",$order['created']);?></span>
									<h3 class="timeline-header"><a href="#" id="username"><?=$userinfo['commname']?></a> 提交了订单</h3>
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
			<?if(in_array($order['status'],array(5,3,4))){?>
			<?$url=$this->url("purchase/updateorderstatushouse");?>
			<form class="box form-validate form-confirm" action='<?=$url?>' id="myform" method='post'>
				<div class="box-header with-border">
					<h3 class="box-title">物流信息</h3>
				</div>
				<div class="row box-body">
					<div class="col-md-4">
						<div class="form-group">
							<label for="peihuoid">配货员</label>
							<select name="data[peihuoid]" class="form-control">
								<?foreach($user as $k=>$val){?>
								<option value="<?=$val['id']?>" <?if(!empty($logistics['peihuoid']) &&  $val['id']==$logistics['peihuoid']){echo "selected";}?>><?=$val['truename']?></option>
								<?}?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="heyanid">核验员</label>
							<select name="data[heyanid]" class="form-control">
								<?foreach($user as $k=>$val){?>
								<option value="<?=$val['id']?>" <?if(!empty($logistics['heyanid']) &&  $val['id']==$logistics['heyanid']){echo "selected";}?>><?=$val['truename']?></option>
								<?}?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="fahuoid">发货人</label>
							<select name="data[fahuoid]" class="form-control">
								<?foreach($user as $k=>$val){?>
								<option value="<?=$val['id']?>" <?if(!empty($logistics['fahuoid']) &&  $val['id']==$logistics['fahuoid']){echo "selected";}?>><?=$val['truename']?></option>
								<?}?>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="generalid">物流公司 (创建<a href="<?=$this->url('General/addgeneral')?>" target="_black">物流模板</a>)</label>
							<?$generalid=empty($logistics['generalid'])?0:$logistics['generalid'];?>
							<?$logisticsid=empty($logistics['id'])?0:$logistics['id'];?>
							<select name="data[generalid]" class="form-control" style="width:200px;" onchange="sellogistics(this.value,<?=$logisticsid?>)">
								<option value="0">选择物流公司</option>
								<?foreach($company as $k=>$val){?>
								<option value="<?=$val['id']?>" <?if($val['id']==$generalid){echo "selected";}?>><?=$val['companystart']?></option>
								<?}?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="companystart">发货地物流公司名称</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-plane"></i>
								</span>
								<input type="text" name="data[companystart]" id="companystart" value="<?=empty($logistics['companystart'])?'':$logistics['companystart']?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="mobilestart">发货地物流公司电话</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-phone"></i>
								</span>
								<input type="text" name="data[mobilestart]" id="mobilestart" value="<?=empty($logistics['mobilestart'])?'':$logistics['mobilestart']?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="usernamestart">发货地物流公司联系人</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-user"></i>
								</span>
								<input type="text" name="data[usernamestart]" id="usernamestart" value="<?=empty($logistics['usernamestart'])?'':$logistics['usernamestart']?>" class="form-control" data-rule-required="true" data-rule-minlength="1" >
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="companyarrive">到达地物流公司名称</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-home"></i>
								</span>
								<input type="text" name="data[companyarrive]" id="companyarrive" value="<?=empty($logistics['companyarrive'])?'':$logistics['companyarrive']?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="mobilearrive">到达地物流公司电话</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-phone"></i>
								</span>
								<input type="text" name="data[mobilearrive]" id="mobilearrive" value="<?=empty($logistics['mobilearrive'])?'':$logistics['mobilearrive']?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="usernamearrive">到达地物流公司联系人</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-user"></i>
								</span>
								<input type="text" name="data[usernamearrive]" id="usernamearrive" value="<?=empty($logistics['usernamearrive'])?'':$logistics['usernamearrive']?>" class="form-control" data-rule-required="true" data-rule-minlength="1" >
							</div>
						</div>
					</div>
					
					<div class="col-md-3">
						<div class="form-group">
							<label for="weight">总重量</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-balance-scale"></i>
								</span>
								<input value="<?=$weights?>kg" type="text" name="data[weight]" id="weight" value="<?=empty($logistics['weight'])?'':$logistics['weight']?>" class=" form-control" data-rule-required="true" data-rule-minlength="1">
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="senddate">发货日期</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input type="text" name="data[senddate]" id="senddate" value="<?=empty($logistics['senddate'])?'':date('Y-m-d',$logistics['senddate'])?>" class="form-control datepick1" data-rule-required="true" data-rule-minlength="1">
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="logisticscost">物流费用</label>
							<div class="input-group">
								<span class="input-group-addon">¥</span>
								<input type="text" name="data[logisticscost]" id="logisticscost" value="<?=empty($logistics['logisticscost'])?'':$logistics['logisticscost']?>"  class="form-control"  data-rule-required="true" data-rule-minlength="1">
							</div>
						</div>
					</div>
					
					<div class="col-md-3">
						<div class="form-group">
							<label for="logisticsnumber">物流单号</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-tag"></i>
								</span>
								<input type="text" name="data[logisticsnumber]" id="logisticsnumber" value="<?=empty($logistics['logisticsnumber'])?'':$logistics['logisticsnumber']?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="goodsnum">货物总件数</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-cubes"></i>
								</span>
								<input value="<?=$anum?>箱" type="text" name="data[goodsnum]" id="title" value="<?=empty($logistics['goodsnum'])?'':$logistics['goodsnum']?>" class="form-control"  data-rule-required="true" data-rule-minlength="1">
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="maybearrivedate">预计到达</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar-check-o"></i>
								</span>
								<input type="text" name="data[maybearrivedate]" id="maybearrivedate" value="<?=empty($logistics['maybearrivedate'])?'':date('Y-m-d',$logistics['maybearrivedate'])?>" class="form-control datepick2" data-rule-required="true" data-rule-minlength="1">
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="sendmoney">送货费用</label>
							<div class="input-group">
								<span class="input-group-addon">¥</span>
								<input type="text" name="data[sendmoney]" id="sendmoney" value="<?=empty($logistics['sendmoney'])?'':$logistics['sendmoney']?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
								<span class="input-group-addon">
									<input type="checkbox" value="1" name="data[isarrivepay]"<?if(!empty($logistics['isarrivepay'])){echo "checked";}?> >&nbsp;&nbsp;到付
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="carnumber">物流车号</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-truck"></i>
								</span>
								<input type="text" name="data[carnumber]" id="carnumber" value="<?=empty($logistics['carnumber'])?'':$logistics['carnumber']?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="remark">备注</label>
							<textarea name="data[remark]" class="form-control" rows="3"><?=empty($logistics['remark'])?'':$logistics['remark']?></textarea>
						</div>
					</div>
				</div>
				<?if($order['status']==3){?>
				<div class="box-footer">
					<input type="hidden" value="<?=$order['id']?>" name="id">
					<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> 提交信息</button>
				</div>
				<?}?>
			</form>
			<?}?>
			<?if($order['status']==4){?>
			<form class="box form-validate form-confirm" action='<?=$this->url("purchase/reupdateorderstatushouse")?>' id="myforms" method='post'>
				<div class="box-header with-border">
					<h3 class="box-title">反审</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="mobile">备注</label>
								<textarea name="data[remark]" rows="3" class="form-control" placeholder="反审之后,可以修改物流信息"></textarea>
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
$("#dy").click(function(event) {
	var un = $('#username').text();
	var ut = $('#usertime').text();
	sessionStorage.username = un;
	sessionStorage.usertime = ut;
});

$(function () {
		$('.datepick1').daterangepicker({singleDatePicker: true,language: 'zh-CN', format: 'YYYY-MM-DD'});
		$('.datepick2').daterangepicker({singleDatePicker: true,language: 'zh-CN', format: 'YYYY-MM-DD'});
	});
//返回列表
function returnList(){
	window.location.href='<?=$this->url("purchase/orderinfofr")?>';
}
//修改订货数量
function changenum(id,ordernum){
	var num	=	$("#goodsnum_"+id).val();
	if(isNaN(num)){return false;}
	$.ajax({
		url:"<?=$this->url('purchasesr/updatecart')?>",
		data:"id="+id+"&num="+num+"&ordernum="+ordernum,
		type:"post",
		dataType:"json",
		success:function(r){
			if(r.state == 1){
				pub_alert_success(r.info);
				if(r.data == 'back'){
					setTimeout('location.reload()',600);
				}
			}else{
				pub_alert_error(r.info);
			}
		}
	});
}
//选择物流模板
function sellogistics(generalid,id){
	if(generalid==0){
		return false;
	}
	$.ajax({
		url:"<?=$this->url('purchase/sellogistics')?>",
		data:"id="+id+"&generalid="+generalid,
		type:"post",
		dataType:"json",
		success:function(r){
			$("#companystart").val(r.companystart);
			$("#mobilestart").val(r.mobilestart);
			$("#usernamestart").val(r.usernamestart);
			$("#companyarrive").val(r.companyarrive);
			$("#mobilearrive").val(r.mobilearrive);
			$("#usernamearrive").val(r.usernamearrive);
		}
	});
}
</script>