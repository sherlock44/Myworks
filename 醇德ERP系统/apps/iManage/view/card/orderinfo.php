<section class="content-header">
	<h1>
		会员管理
		<small>会员卡消费详情</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"> <i class="fa fa-home"></i>后台管理</a></li>
		<li><a href="#">会员卡管理</a></li>
		<li class="active">会员卡消费详情</li>
	</ol>
</section>
<section class="invoice">
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header"> <i class="fa fa-user"></i>
				的详情
				<small class="pull-right">注册日期: </small>
			</h2>
		</div>
	</div>
	<!-- info row -->
	<div class="row invoice-info">
		<div class="col-sm-4 invoice-col">
			<p class="lead">基本信息</p>
			<address>
			
				订单号: <?=$order['orderno']?><br />
				卡号: <?=$order['carduuid']?><br />
				消费金额: <?=$order['price']?><br />
				消费时间: <?=date("Y/m/d",$order['created'])?>
				
			</address>
		</div>


		<!-- /.col -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-xs-12">
			<p class="lead">详细信息    </p>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
								<th >商品名称</th>
											<th >商品条码</th>
											
											<th >购买数量</th>
											<th >商品单价</th>
											<th >小计</th>
						</tr>
					</thead>
					<tbody>
						<?foreach($goods as $val){?>
										<tr>
											<td><?=$val['ftitle']?></td>
											<td><?=$val['fbarcode']?></td>
											
											<td><?=$val['num']?></td>
											<td><?=$val['saleprice']?></td>
											<td><?=$val['totalprice']?></td>
										</tr>
										<?}?>
					</tbody>
				</table>
			</div>
		</div>
		<!-- /.col -->
	</div>

	<!-- /.row -->
	<!-- /.row -->
</section>



<script>
//返回列表
	function returnList(){
		window.location.href='<?=$this->url("card/cardlist?type=0")?>';
	}

</script>
