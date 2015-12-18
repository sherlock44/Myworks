<div id="main">
<div class="container-fluid nopadding">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/chosen/chosen.css">
<script src="/public/assets/sysadmin/js/plugins/chosen/chosen.jquery.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/jquery.dataTables.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/TableTools.css">
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/TableTools.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColReorder.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColVis.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.columnFilter.js"></script>
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="javascript:;">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="#">POS管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">会员订单详情</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
		  <div class="box-content nopadding">
		  <form  class='form-horizontal form-bordered form-validate' >
			<div class="box-title">
				<h3>
					<i class="icon-th-list"></i>
					订单商品详情
				</h3>	
			</div>
			<div class="box-content nopadding">
				<table class="table table-hover table-nomargin dataTable table-bordered" width="100%">
					<thead>
						<tr>
							<th width="30%">商品名称</th>
							<th width="30%">条形码</th>
							<th width="20%">价格</th>
							<th width="20%">购买数量</th>	
						</tr>
					</thead>
					<tbody>
						<?foreach ($orinfo as $key=>$val){?>
						<tr>	
							<td><?=$val['title']?></td>
							<td><?=$val['barcode']?></td>
							<td><?=$val['price']?></td>
							<td><?=$val['num']?></td>
						</tr>
						<?}?>
					</tbody>
				</table>
			</div>

			<div class="box-title">
				<h3>
					<i class="icon-user"></i>
					其它信息
				</h3>
			</div>
			<div class="control-group">
				<label for="mobile" class="control-label">订单总价</label>
					<div class="controls"><?=$bsinfo['price']?></div>
			</div>
			<div class="control-group">
				<label for="mobile" class="control-label">现金支付</label>
					<div class="controls"><?=$bsinfo['cashprice']?></div>
			</div>
			<div class="control-group">
				<label for="mobile" class="control-label">刷卡支付</label>
					<div class="controls"><?=$bsinfo['cardprice']?></div>
			</div>
			<div class="control-group">
				<label for="mobile" class="control-label">下单用户名</label>
					<div class="controls"><?=$bsinfo['username']?></div>
			</div>
			<div class="control-group">
				<label for="mobile" class="control-label">用户联系电话</label>
					<div class="controls"><?=$bsinfo['usermobile']?></div>
			</div>
			<div class="control-group">
				<label for="mobile" class="control-label">地址</label>
					<div class="controls"><?=$bsinfo['address']?></div>
			</div>
			<div class="control-group">
				<label for="mobile" class="control-label">支付状态</label>
					<div class="controls"><?=$bsinfo['paystatus']==0?'未支付':'已支付';?></div>
			</div>

			<div class="control-group">
				<label for="mobile" class="control-label">收银员</label>
					<div class="controls"><?=$bsinfo['truename']?></div>
			</div>
			<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>
		</div>
	  </div>
	  </form>

	</div>
</div>
</div>
</div>

<script>
var name= '<?php echo $bsinfo['carduuid'];?>';
	function returnList(){
		window.location.href="<?=$this->url('pos/consume?card="+name+"')?>";
	}
</script>