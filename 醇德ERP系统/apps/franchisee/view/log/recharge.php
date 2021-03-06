					<div id="main">
			<div class="container-fluid"><div class="page-header">
	<div class="pull-left">
		<h1>充值记录</h1>
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
			<a href="#">日志管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">充值记录</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-th-list"></i>
					充值记录
				</h3>
			</div>
			<div class="box-content nopadding">
				<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
				    <table width="100%" class="table table-hover table-nomargin dataTable table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
					<thead>
						<tr>
							<th>序号</th>
							<th>手机号</th>
							<th>充值金额</th>
							<th>订单号</th>
							<th>流水号</th>
							<th>状态</th>
							<th>时间</th>
						</tr>
					</thead>
					<tbody>
						<?foreach ($re as $k=>$v){?>
                        <tr>
							<td><?=$k?></td>
							<td><?=$v['mobile']?></td>
							<td><?=$v['money']?></td>
                            <td><?=$v['noid']?></td>
                            <td><?=$v['dealid']?></td>
                            <td><?=$v['status']==0?'<font color="red">未完成</font>':'<font color="green">已完成</font>'?></td>
                            <td><?=date('Y-m-d H:i:s',$v['created'])?></td>
						</tr>					
						<?}?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
</div>