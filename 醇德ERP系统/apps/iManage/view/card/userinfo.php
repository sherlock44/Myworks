<section class="content-header">
	<h1>
		会员管理
		<small>会员详细信息</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"> <i class="fa fa-home"></i>ERP系统</a></li>
		<li><a href="#">会员卡管理</a></li>
		<li class="active">会员管理</li>
	</ol>
</section>
<section class="invoice">
	
	<!-- info row -->
	<div class="row invoice-info">
		<div class="col-sm-4 invoice-col">
			<p class="lead">基本信息</p>
			<address>
				姓名: <?=$re['truename']?><br />
				性别: <?=$re['sex']?><br />
				生日: <?if(!empty($re['birthdaytime'])){?><?=date("Y/m/d",$re['birthdaytime'])?><?}?><br />
				手机: <?=$re['mobile']?> <br />
				邮箱: <?=$re['email']?>
			</address>
		</div>
		<!-- /.col -->
		<div class="col-sm-4 invoice-col">
			<p class="lead">会员卡信息</p>
			<address>
				会员卡号: <?=$re['cardnum']?><br>
				开卡加盟店: <?=$re['shoppname']?><br>
				会员余额: ¥ <?=$re['nowmoney']?><br>
				共充值: ￥ <?=$re['allmoney']?><br>
				共消费: ￥ <?=$re['allmoney']-$re['nowmoney']?><br>
			</address>
		</div>
		<!-- /.col -->
		<div class="col-sm-4 invoice-col">
			<p class="lead">使用概况</p>
			<address>
				最近一次消费时间: <?if($lastpay){?><?=date("Y-m-d H:i:s",$lastpay['created'])?> <?}?><br>
				最近一笔消费金额: <?if($lastpay){?>￥<?=$lastpay['money']?><?}?><br><br>
				最近一次充值时间: <?if($lastuse){?><?=date("Y-m-d H:i:s",$lastuse['created'])?><?}?><br>
				最近一次充值金额: <?if($lastuse){?>¥ <?=$lastuse['money']?><?}?>
			</address>
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-xs-12">
			<p class="lead">使用记录</p>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th style="width: 40px;">＃</th>
							<th>操作时间</th>
							<th>描述</th>
							<th>操作类型</th>
							<th style="text-align: right; ">金额变化</th>
							<th style="text-align: right; ">变化后金额</th>
							<th style="text-align: center; ">操作</th>
						</tr>
					</thead>
					<tbody>
						<? $index=1;?>
						<?foreach($cardlog as $val){?>
						<tr>
							<td><?=$index++?></td>
							<td><?=date("Y-m-d H:i:s",$val['created'])?></td>
							<td><?=$val['remark']?></td>
							<td><?=$logtype[$val['type']]?></td>
							<td style="text-align: right; ">¥ <?=$val['money']?></td>
							<td style="text-align: right; ">¥ <?=$val['hasmoney']?></td>
							<td style="text-align: center; ">
								<?if($val['type']==2 || $val['type']==5){?>
								<a class="btn btn-success btn-xs" href="<?=$this->url('card/orderinfo',array('ordernum'=>$val['ordernum'],'ordertype'=>$val['type']))?>">详情</a>
								<?}else{?>
								<a class="btn btn-default btn-xs" href="#">详情</a>
								<?}?>
							</td>
						</tr>
						<?}?>
					</tbody>
				</table>
			</div>
		</div>
		<!-- /.col -->
	</div>
	<div class="row">
		<!-- /.col -->
		<div class="col-xs-12">
			<p class="lead">统计信息</p>
			<div class="table-responsive">
				<table class="table">
					<tr>
						<th style="width:80%">共充值次数</th>
						<td><?=isset($paylogcz['allnum'])?$paylogcz['allnum']:0?>次</td>
					</tr>
					<tr>
						<th>每次平均充值金额</th>
						<td>￥<?=isset($paylogcz['avgmoney'])?$paylogcz['avgmoney']:0?></td>
					</tr>
					<tr>
						<th>单次最大充值金额</th>
						<td>￥<?=isset($paylogcz['maxmoney'])?$paylogcz['maxmoney']:0?></td>
					</tr>
					<tr>
						<th>共消费次数</th>
						<td><?=isset($paylogxf['allnum'])?$paylogxf['allnum']:0?>次</td>
					</tr>
					<tr>
						<th>每次平均消费金额</th>
						<td>￥<?=isset($paylogxf['avgmoney'])?$paylogxf['avgmoney']:0?></td>
					</tr>
					<tr>
						<th>单次最大消费金额</th>
						<td>￥<?=isset($paylogxf['maxmoney'])?$paylogxf['maxmoney']:0?></td>
					</tr>
				</table>
			</div>
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
	<!-- /.row -->
</section>
<!-- /.content -->
<!-- FastClick -->
<script src="/public/adminlte/plugins/fastclick/fastclick.min.js"></script>
<script type="text/javascript">
	//返回列表
	function returnList(){
		window.location.href='<?=$this->url("card/cardlist?type=0")?>';
	}
	function show_history_detail() {
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->url("card/memberhistorydetail");?>',
			success: function(data) {
				bootbox.dialog({
					message: data,
					title: "会员详情",
					buttons: {
						alert: {
							label: "Ok!",
							className: "btn-success",
						},
					}
				});
			}
		});
	}
</script>