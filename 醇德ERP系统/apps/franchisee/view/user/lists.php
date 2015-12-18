<div id="main">
<div class="container-fluid">
    <div class="page-header">
    	<div class="pull-left">
    		<h1>用户列表</h1>
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
			<a href="">用户列表</a>
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
					用户列表
				</h3>
			</div>
			<div class="box-content nopadding">
				<table class="table table-hover table-nomargin dataTable table-bordered" width="100%">
					<thead>
						<tr>
							<th>手机号</th>
							<th>余额(元)</th>
							<th>级别</th>
							<th>新消息总数</th>
							<th>最后登陆时间</th>
                            <th>注册时间</th>
                            <th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?foreach ($re as $key=>$val){?>
						<tr>
							<td><?=$val['mobile']?></td>
							<td><?=$val['balance']?></td>
							<td><?=$val['level']?></td>
                            <td><?=$val['messages']?></td>
							<td><?=date('Y-m-d H:i:s',$val['lastLogin'])?></td>
							<td><?=date('Y-m-d H:i:s',$val['created'])?></td>
							<td>
								<a href="javascript:pub_alert_confirm(this,'<?=$val['status']==0?'确定恢复正常？':'确定禁用？'?>','<?=$this->url("user/del")?>?id=<?=$val["id"]?>&status=<?=$val['status']==0?1:0?>');" class="btn btn-small btn-danger" title="<?=$val['status']==0?'恢复正常':'禁用'?>" style="background-color: <?=$val['status']==0?'#40bf40':'#f43'?>;"><?=$val['status']==0?'恢复正常':'禁用'?></a>
							</td>
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