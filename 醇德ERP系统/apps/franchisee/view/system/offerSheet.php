					<div id="main">
			<div class="container-fluid"><div class="page-header">
	<div class="pull-left">
		<h1>报价表设计</h1>
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
			<a href="#">系统管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">报价表设计</a>
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
					报价表设计
				</h3>
                <div class="actions">
					<a rel="tooltip" data-original-title="添加" href="<?=$this->url('system/offerSheetEdit')?>" class="btn btn-danger"><i class="icon-plus"></i> 添加报价</a>
				</div>
			</div>
			<div class="box-content nopadding">
				<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
				    <table width="100%" class="table table-hover table-nomargin dataTable table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
					<thead>
						<tr>
							<th>名称</th>
							<th>单价(元)</th>
							<th>状态</th>
                            <th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?foreach ($re as $key=>$val){?>
                        <tr>
							<td><?=$val['name']?></td>
							<td><?=$val['price']?></td>
							<td><?=$val['status']==0?'<font color="red">无效</font>':'<font color="green">有效</font>'?></td>
                            <td>
                                <a data-original-title="修改" rel="tooltip" class="btn btn-small btn-success" href="<?=$this->url('system/offerSheetEdit')?>?id=<?=$val["id"]?>"><i class="icon-edit"></i></a>
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