					<div id="main">
			<div class="container-fluid"><div class="page-header">
	<div class="pull-left">
		<h1>权限组</h1>
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
			<a href="">系统管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">权限组管理</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/chosen/chosen.css">
<script src="/public/assets/sysadmin/js/plugins/chosen/chosen.jquery.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/jquery.dataTables.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/TableTools.css">
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/TableTools.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColReorder.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColVis.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.columnFilter.js"></script><div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-th-list"></i>
					权限组列表
				</h3>
				<div class="actions">
					<a rel="tooltip" data-original-title="添加" href="<?=$this->url('system/group_modify')?>" class="btn btn-danger"><i class="icon-plus"></i></a>
				</div>
			</div>
			<div class="box-content nopadding">
				<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper" >
					
					<div id="DataTables_Table_0_length" class="dataTables_length" style="height:36px;">				
					<form action="<?=$this->url("system/role")?>" method="GET"  id="bb">
					<div class="row-fluid" style="width:1000px;height:3px;">
						
										
						<div class="span3">
                            <div class="control-group">                                
                                <div class="controls controls-row">
                                     <input id="title" name="title" class="input-block-level" type="text" placeholder="权限组名称" value="<?=$title?>" >
                                </div>
                            </div>
                       </div>
                       
                        <div class="span1">                            
                                    <input type="submit" class="btn btn-primary" value="搜索">                             
                       </div>                       
				</div>
					
					
                   </form>
                   </div>
					<table width="100%" class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
					<thead>
						<tr>
							<th width="25%">ID</th>
							<th width="25%">权限组名称</th>
						
							<th width="10%">操作</th>
						</tr>
					</thead>	

					<tbody>
						<?foreach($re as $value){?>
						<tr>
							<td><?=$value['groupid']?></td>
							<td><?=$value['title']?></td>
							
							<td>
								<a data-original-title="修改" rel="tooltip" class="btn btn-small btn-success" href="<?=$this->url('system/group_modify')?>?id=<?=$value["groupid"]?>"><i class="icon-edit"></i></a>
								<a class="btn btn-small btn-primary" data-original-title="授权" rel="tooltip" href="javascript:pub_alert_html('<?=$this->url('system/role_lock')?>?id=<?=$value["groupid"]?>');"  ><i class="icon-lock"></i></a>
								<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("system/group_del")?>?id=<?=$value["groupid"]?>');" class="btn btn-small btn-danger" title="删除"><i class="icon-remove"></i></a>
							</td>

						</tr>
						<?}?>
					</tbody>
				</table>
				<?=$pageHtml?>
				<form>
			</div>
		</div>
	</div>
</div>
</div></div>
