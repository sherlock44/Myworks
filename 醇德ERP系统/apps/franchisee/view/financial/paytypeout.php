<div id="main">
    <div class="container-fluid">
        <div class="page-header">
        	<div class="pull-left">
        		<h1>参数设置</h1>
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
			<a href="javascript:;">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">参数设置</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">付款方式</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/chosen/chosen.css">
<script src="/public/assets/sysadmin/js/plugins/chosen/chosen.jquery.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/jquery.dataTables.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/TableTools.css">
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/TableTools.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColReorder.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColVis.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.columnFilter.js"></script>
        <div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					付款方式
        				</h3>
                        <div class="actions">
        					<a rel="tooltip" data-original-title="添加" href="<?=$this->url('financial/addpaytypeout')?>" class="btn btn-danger"><i class="icon-plus"></i> 添加</a>
        				</div>
        			</div>
        			<div class="box-content nopadding">
        				<table class="table table-hover table-nomargin dataTable table-bordered" width="100%">
        					<thead>
        						<tr>
        							<th>ID</th>
        							<th>名称</th>

                                    <th>状态</th>
                                    <th>操作</th>
        						</tr>
        					</thead>
                            <?
                                foreach($re as $key=>$val){
                                    ?>
                                    <tr>
            							<td><?=$val['id']?></td>
            							<td><?=$val['title']?></td>
            							<td><?if($val['status']==0){echo '<font color="red">禁用</font>';}else{echo '<font color="green">正常</font>';}?></td>
            							<td>
     								       <a data-original-title="修改" rel="tooltip" class="btn btn-small btn-success" href="<?=$this->url('financial/editpaytypeout',array('id'=>$val['id']))?>"><i class="icon-edit"></i></a>
           								   <a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("financial/delpaytypeout")?>?id=<?=$val["id"]?>');" class="btn btn-small btn-danger" title="删除"><i class="icon-remove"></i></a>
						                </td>
            						</tr>
                                    <?
                                }
                            ?>
        				</table>
        			</div>
        		</div>
        	</div>
        </div>
    </div>
</div>