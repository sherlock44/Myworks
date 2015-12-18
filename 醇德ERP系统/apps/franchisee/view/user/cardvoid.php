<div id="main">
<div class="container-fluid">
    <div class="page-header">
    	<div class="pull-left">
    		<h1>空卡管理</h1>
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
			<a href="#">用户管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">会员卡管理</a>
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
					会员卡管理
				</h3>
			</div>
			<div class="box-content nopadding">
				<table class="table table-hover table-nomargin dataTable table-bordered" width="100%">
					<thead>
						<tr>
							<?foreach($cardType as $v){?>
							<th width="10%"><?=$v?>未开通数量<br/>已开通数量</th>
							<?}?>
							

						</tr>
					</thead>
					<tbody>
						<?foreach($re as $val){?>
					<tr>
							<?foreach($cardType as $k=>$v){?>
							<td><?=$val['num'.$k]?><br/><?=$val['passnum'.$k]?></td>
							<?}?>
							
						
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