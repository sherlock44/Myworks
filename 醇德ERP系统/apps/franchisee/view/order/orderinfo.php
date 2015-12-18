	<div id="main">
			<div class="container-fluid"><div class="page-header">
	<div class="pull-left">
		<h1>订单详情</h1>
	</div>
	<div class="pull-right">
		<ul class="stats">
			<li class='lightred'>
				<i class="icon-calendar"></i>
				<div class="details">
					<span class="big"></span>
					<span></span>
				</div>
			</li>
		</ul>
	</div>
</div>
<script type="text/javascript">
function currentTime(){
	var $el = $(".stats .icon-calendar").parent(),
	currentDate = new Date(),
	monthNames = [1,2,3,4,5,6,7,8,9,10,11,12],
	dayNames = ["周日","周一","周二","周三","周四","周五","周六"];

	$el.find(".details span").html(currentDate.getFullYear() + " - " + monthNames[currentDate.getMonth()] + " - " + currentDate.getDate());
	$el.find(".details .big").last().html(currentDate.getHours()+":"+ ("0" + currentDate.getMinutes()).slice(-2) + ", " + dayNames[currentDate.getDay()]);
	setTimeout(function(){
		currentTime();
	}, 10000);
}
currentTime();
</script>
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$this->url('index/main')?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="#">订单管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">订单详情</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-th-list"></i>
					商品列表
				</h3>
			</div>
			<div class="box-content nopadding">
				<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					<table width="100%" class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
						<thead>
							<tr>
								<th width="14%">商品名称</th>
								<th width="14%">商品描述图片</th>
								<th width="14%">商品单价(元)</th>
								<th width="14%">商品数量(件)</th>
								<th width="14%">该商品总金额(元)</th>
								
							</tr>
						</thead>
						<tbody>
							<?foreach ($shops as $value) {?>
								<tr>
								<td><?=$value['title']?></td>
								<td><img width="50" height="50" src="<?=$value['imgpath']?>"></td>
								<td><?='&yen'.$value['price']?></td>
								<td><?=$value['num']?></td>
								<td><?='&yen'.$value['price']*$value['num'].'.00'?></td>
							</tr>
							<?}?>
							
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
	</div>
</div>
	<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">

			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					订单详情表
        				</h3>
                        
        	</div>

			<div class="box-content nopadding">	
			</div>
			<div class="box-content nopadding">
				
				
				<form action="<?=$this->url("orders/checkorders")?>" method="POST" class='form-horizontal form-bordered form-validate' id="bb">
					<div class="control-group">
						<label for="serialnumber" class="control-label">订单号</label>
						<div class="controls">
							<label class="span"><?=$order['ordernum']?></label>
						</div>
					</div>
					<div class="control-group">
						<label for="paytype" class="control-label">订单支付状态</label>
						<div class="controls">
							<label class="span"><? if($order['paystatus']==0){
								echo "未支付";
							}else if($order['paystatus']==1){
								echo "已支付";
							}?></label>
						</div>
					</div>
					<div class="control-group">
						<label for="paytype" class="control-label">支付方式</label>
						<div class="controls">
							<label class="span"><? if($order['paytype']==0){
								echo "网银";
							}else if($order['paytype']==1){
								echo "alipay";
							}else if($order['paytype']==2){
								echo "线下支付";
							}
							?></label>
						</div>
					</div>
					<div class="control-group">
						<label for="totalprice" class="control-label">订单创建时间</label>
						<div class="controls">
							<label class="span"><?=date('y-m-d',$order['created'])?></label>
						</div>
					</div>
				
					
					<div class="control-group">
						<label for="address" class="control-label">支付状态</label>
						<div class="controls">
							<label class="span"><?if($order['paystatus']==0){
								echo "未支付";
							}else if($order['paystatus']==-1){
								echo "支付失败";
							}else if($order['paystatus']==1){
								echo "支付成功";
							}
							else if($order['paystatus']==3){
                                echo "未发货";
							}						
							?></label>
						</div>
					</div>
					<div class="control-group">
						<label for="userid" class="control-label">收货人</label>
						<div class="controls">
							<label class="span"><?=$order['username']?></label>
						</div>
					</div>
					<div class="control-group">
						<label for="userid" class="control-label">收货人电话</label>
						<div class="controls">
							<label class="span"><?=$order['usermobile']?></label>
						</div>
					</div>
					<div class="control-group">
						<label for="userid" class="control-label">收货详细街道地址</label>
						<div class="controls">
							<label class="span"><?=$order['address']?></label>
						</div>
					</div>
					
					<div class="control-group">
						<label for="userid" class="control-label">用户给商家的订单留言</label>
						<div class="controls">
							<label class="span"><?=$order['remark']?></label>
						</div>
					</div>				
					
					
					<div class="control-group">
						<label for="paytype" class="control-label">订单状态</label>
						<div class="controls">
							<label class="span">
								<?=$order['ordertype']==1 ?$rs[$order['orderstatus']] : $rss[$order['orderstatus']]?>
							</label>
						</div>
					</div>

					
					<div class="form-actions">
						 
						 <input type="hidden" name="id" value="<?=!empty($order) ? $order["id"] : ''?>">
						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="button" class="btn btn-primary" value="返回列表" onclick="returns()">
					</div>					
				</form>
			
			</div>	
		</div>
	</div>
</div>
</div>
</div>
<script>

      function returns(){
  window.history.go(-1);
         }
</script>	