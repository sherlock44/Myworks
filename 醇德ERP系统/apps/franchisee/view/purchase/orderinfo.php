<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<section class="content-header">
	<h1>
		采购详情
		<small>采购状态和明细</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> 采购平台</a></li>
		<li><a href="#">采购管理</a></li>
		<li class="active">采购详情</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="box box-color box-bordered">
			<div class="box-header with-border">
				<h3 class="box-title">订单状态和明细</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body no-padding">
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("newcash/insertplan")?>'  id="login" name="login" method='post'>
					<div class="control-group" style="height:45px;background-color:white;text-align:center;padding-top:10px;">
						<?foreach($this->conf['orderstatus'] as $k=>$v){?>
						<?if($k<0){continue;}?>
						<?if($order['status']==$k){?>
						<span style="color:red;"><?echo ($k+1).".$v";?></span>
						<?}else{?>
						<?echo ($k+1).".$v";?>
						<?}?>
						<?}?>
					</div>
				</form>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
						<thead>
							<tr>
								<th>商品分类</th>
								<th>商品名称</th>
								<th>图片</th>
								<th>商品条码</th>
								<th>保质期(月)</th>
								<th>重量</th>
								<th>采购价格</th>
								<th>装箱规格</th>
								<th>保质期至</th>
								<th>订购数量</th>
							</tr>
						</thead>
						<tbody>
							<?
							$weights	=	0;
							$aprices	=	0;
							$anum	=	0;
							foreach($re as $key=>$value){
								$weights+=$value['weights']*($value['buynum']-$value['realbacknum']);
								$aprices+=$value['allprice'];
								$anum+=	$value['buynum']-$value['realbacknum'];
								?>
								<tr>
									<td><?=$value['fctitle']?></td>
									<td><?=$value['title']?></td>
									<td>
									
									<?if(empty($value["imgpath"])){?>
									<img width=25 height=25   src="/public/assets/sysadmin/img/default.png">
									<?}else{?>
									<a href="<?=$value["imgpath"]?>" target="_black">
									<img width=25 height=25   src="<?=$value["imgpath"]?>">
									</a>
									<?}?>
									
									
									</td>
									<td><?=$value['barcode']?></td>
									<td><?=!empty($value['shelflife'])?$value['shelflife']:'--'?></td>
									<td><?=$value['weight']?>g/<?=$value['specs']?></td>
									<td>¥ <?=$value['buyprice']?>/<?=$value['specs']?></td>
									<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>
									<td  ><?if(empty($value['shelflife'])){echo '--';}else{echo date("Y-m-d",empty($value['productontime'])?time():$value['productontime']);}?></td>			
									<td>
										<?if($order['orderbackstatus']>0 && $order['backstatus']==6){?>
										<?=$value['buynum']-$value['realbacknum']?>
										<?}else{?>
										<?=$value['buynum']?>
										<?}?>
										箱</td>
									</tr>
									<?
								}
								?>
							</tbody>
							<tfoot style="color: green; font-size: 15px;">
								<tr>
									<td colspan="5">合计</td>
									<td><?=$weights?>kg</td>
									<td colspan="3">¥ <?=$aprices?></td>
									<td><?=$anum?>箱</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				<?if($logistics){?>
				<div class="box-header">
					<h3 class="box-title">物流信息</h3>
				</div>
				<div class="box-body">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<tr>
									<th width="12.5%">打单员:</th>
									<td width="12.5%"><?=empty($logistics['truename'])?'':$logistics['truename']?></td>
									<th width="12.5%">配货员:</th>
									<td width="12.5%">
										<?foreach($user as $k=>$val){?>
										<?if(!empty($logistics['peihuoid']) &&  $val['id']==$logistics['peihuoid']){echo $val['truename'];}?>
										<?}?>
									</td>
									<th width="12.5%">核验员:</th>
									<td width="12.5%">
										<?foreach($user as $k=>$val){?>
										<?if(!empty($logistics['heyanid']) &&  $val['id']==$logistics['heyanid']){echo $val['truename'];}?>
										<?}?>
									</td>
									<th width="12.5%">发货人:</th>
									<td width="12.5%">
										<?foreach($user as $k=>$val){?>
										<?if(!empty($logistics['fahuoid']) &&  $val['id']==$logistics['fahuoid']){echo $val['truename'];}?>
										<?}?>
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
					<?if(in_array($order['status'],array(4))){?>
					<?$url=$this->url("purchase/updateorderstatus");?>
					<form class="form-validate form-confirm" action='<?=$url?>'  id="formtj" name="login" method='post'>
						<div class="box-body row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="completeremark" class="control-label">备注</label>
									<textarea name="completeremark" class="form-control"></textarea>
								</div>
								<div class="control-group" style="display:none;">
									<label for="mobile" class="control-label">审核</label>
									<div class="controls">
										<select name="results">
											<option value="0">确认收货</option>
											<option value="1">货物漏发</option>
											<option value="2">货物损坏</option>
											<option value="3">货物丢失</option>
										</select>
									</div>
								</div>
								<input type="hidden" value="<?=$order['id']?>" name="id">
							</div>
						</div>
						<div class="box-footer">
							<input type="submit" id="butsure" class="btn btn-success" value="确认收货">
							<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>
						</div>
					</form>
					<?}else {?>
					<div class="box-footer">
						<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>
					</div>
					<?}?>
				</div>
			</div>
		</section>
	</div>
</div>
<script>
//返回列表
function returnList(){
	window.location.href='<?=$this->url("purchase/orderconfirm")?>';
}
function formtj(){
	if(confirm("确认提交？")){
		$("#butsure").attr('disabled',true);
		$("#formtj").submit();
	}
}
</script>