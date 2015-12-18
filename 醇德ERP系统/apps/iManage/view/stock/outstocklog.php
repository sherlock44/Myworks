<section class="content-header">
	<h1>
		出库记录
		<small>出库历史记录</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">库存管理</a></li>
		<li class="active">出库记录</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">出库列表</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
						<form action="<?=$this->url("stock/outstocklog")?>" method="GET" class="input-group input-group-sm" style="padding-bottom:10px;">
							<input id="keyword" name="keyword" class="form-control" style="width: 120px;" type="text" placeholder="名称/条码"  value="<?=!empty($keyword) ? $keyword : ''?>" />
							<input type="submit" class="btn btn-primary btn-sm" style="margin-left: 10px;" value="搜索" />
						</form>
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>下单时间</th>
									<th>订单号</th>
									<th>商品名称</th>
									<th>图片</th>
									<th>商品条码</th>
									<th>装箱规格</th>
									<th>数量</th>
								</tr>
							</thead>
							<tbody>
								<?foreach ($re as $value) {?>
								<tr>
									<td><?=date("Y-m-d",$value['createtime'])?></td>
									<td><?=$value['ordernum']?></td>
									<td><?=$value['title']?></td>
									<td><img width=25 height=25   src="<?=$value["imgpath"]?>"></td>
									<td><?=$value['barcode']?></td>
									<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>	
									<td><?=$value['num']?>箱</td>
								</tr>
								<?}?>	
							</tbody>
						</table>
						<div class="row">
							<?=$pageHtml?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	function sycntopshop() {
		$.ajax({
			data:"1=1",
			type:"post",
			url:"<?=$this->url('goods/ecsync')?>",
			dataType:"json",
			success:function(r){
				if(r.state == 1){
					pub_alert_success(r.info);
				}else{
					pub_alert_error(r.info);
				}
			}
		});
	}
	
	function sycntofshop() {
		$.ajax({
			data:"1=1",
			type:"post",
			url:"<?=$this->url('goods/posspsync')?>",
			dataType:"json",
			success:function(r){
				if(r.state == 1){
					pub_alert_success(r.info);
				}else{
					pub_alert_error(r.info);
				}
			}
		});
	}
</script>