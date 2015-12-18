<section class="invoice">
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
		<div class="col-md-6 invoice-col">
			<p class="lead">订单信息</p>
			<address>
				订单号: #<?=$ordernum?> <?if($order['orderbackstatus']>0){?><span style="color:red;">[已退货]</span><?}?><br>
				订单类型: <?=!empty($order['freeordernum'])?"赠送订单":"销售订单"?><br>
				<?if(!empty($order['freeordernum'])){?>
				关联订单: #<?=$order['freeordernum']?><br>
				<?}?>
				<?if(!empty($freeorder)){?>
				关联赠送订单: #<?=$freeorder['ordernum']?><br>
				<?}?>
				下单时间: <?=date("H:i:s",$order['created']);?>
			</address>
		</div><!-- /.col -->
		<div class="col-md-3 invoice-col">
			<p class="lead">客户信息</p>
			<address>
				名称: <?=$userinfo['commname']?>.<br>
				电话: <?=$userinfo['commtel']?><br>
				邮箱: <?=$userinfo['email']?><br>
				地址: <?=$userinfo['pname']?>省 <?=$userinfo['cname']?>市<br>
				<?=$userinfo['address']?>
			</address>
		</div><!-- /.col -->
		<div class="col-md-3 invoice-col">
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
			<table class="table table-striped" style="font-size: 9px">
				<thead>
					<tr>
						<th>品名</th>
						<th>条码</th>
						<th>订货单价</th>
						<th>装箱规格</th>
						<!-- <th>重量</th> -->
						<th>保质期至</th>
						<th style="text-align: right;">订购量</th>
						<?if($order['backstatus']==6){?>
						<th style="text-align: right;">退货数量</th>
						<?}?>
						<th style="text-align: right;">小计</th>
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
					<tr>
						<td style="max-width: 250px;"><?=$value['title']?></td>
						<td><?=$value['barcode']?></td>
						<!-- <td><?=!empty($value['shelflife'])?$value['shelflife']:'--'?></td> -->
						<td>¥ <?=$value['buyprice']?>/<?=$value['specs']?></td>	
						<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>
						<!-- <td><?=$value['weight']?>g/<?=$value['specs']?></td> -->
						<td><?if(empty($value['shelflife'])){echo '--';}else{echo date("Y-m-d",empty($value['productontime'])?time():$value['productontime']);}?></td>	
						<td align="right"><?=$value['buynum']?>&nbsp;箱</td>
						<?if($order['backstatus']==6){?>
						<td align="right"><?=$value['realbacknum']?>箱</td>
						<?}?>
						<td align="right">¥ <?=$value['allprice']?></td>					
					</tr>
					<?}?>
				</tbody>
				<tfoot>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td align="right">合计:</td>
						<td align="right"><?=$anum?> 箱</td>
						<?if($order['backstatus']==6){?>
						<td align="right">&nbsp;</td>
						<?}?>
						<td align="right">¥ <?=$aprices?> 元</td>
					</tr>
				</tfoot>
			</table>
		</div><!-- /.col -->
		<!-- <div class="col-md-12">
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
						<td>¥ <?=$aprices?> 元</td>
					</tr>
				</table>
			</div>
		</div> -->
		<?if($order['status']>=2){?>
		<div class="col-md-12">
			<p class="lead">物流信息</p>
			<div class="table-responsive">
				<table class="table" style="font-size: 9px;">
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
	</div>
	<!-- /.row -->
	<!-- this row will not appear when printing -->
	<!--物流信息 开始 -->
	<!--物流信息 结束 -->
</section>