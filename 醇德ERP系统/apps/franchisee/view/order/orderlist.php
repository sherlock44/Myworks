					<div id="main">
			<div class="container-fluid"><div class="page-header">
	<div class="pull-left">
		<h1>网络订单</h1>
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
			<a href="">订单管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">本地订单</a>
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
					本地订单列表
				</h3>
			</div>
			<div class="box-content nopadding">
				<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					
					<div id="DataTables_Table_0_length" class="dataTables_length" style="height:36px;">				
						<form action="<?=$this->url("orders/sport_order")?>" method="GET"  id="bb">
							<div class="row-fluid" style="width:1000px;height:3px;">
								<div class="span3" style="display:none;">
		                            <div class="control-group">                                
		                                <div class="controls controls-row">
		                                     <select name='status' id='status' class="input-block-level">	
		                                     <option value='' <?=isset($_GET['status'])&&$_GET['status']==''?"selected":""?>>全部订单</option>				
											 <option value='0' <?=isset($_GET['status'])&&$_GET['status']!==''&&$_GET['status']==0?"selected":""?>>未处理订单</option>
											 <option value='1' <?=isset($_GET['status'])&&$_GET['status']==1?"selected":""?>>已处理订单</option>
											 </select>
		                                </div>
		                            </div>
		                        </div>
													
								<div class="span3">
		                            <div class="control-group">                                
		                                <div class="controls controls-row">
		                                     <input id="userphone" name="userphone" class="input-block-level" type="text" placeholder="订单号/用户名" value="<?=$userphone?>">                              	
		                                    
		                                </div>
		                            </div>
		                        </div>

		                        <div class="span4" style="display:none;">
		                          <div class="control-group">                               
		                                <div class="controls controls-row">
		                                	<input class='btn' type="button" onclick="javascript:pub_alert_html('/index.php/sysadmin/common/timeselect');" value="时间筛选 :"><span id="seltime"><?=isset($seltimename)?$seltimename:''?></span>                                     
							                 <input type="hidden" name="timesel"  value="<?=isset($timesel)?$timesel:''?>" id="timesel">
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
						<tr>
							<th width="11%">ID</th>
							<th width="11%">订单号</th>
							<th width="11%">用户名</th>
						    <th width="11%">订单总金额</th>	 					
							<th width="11%">时间</th>						
							<th width="11%">订单状态</th>
							<th width="7%">操作</th>
						</tr>
						</thead>
						<tbody>
							<?foreach ($re as $key=> $value){?>
							<tr>
								<td><?=$value['id']?></td>
								<td><?=$value['ordernum']?></td>
								<td><?=$value['username']?></td>
								<td><?=$value['price']?></td> 						
								<td><?=date('Y-m-d',$value['created'])?></td>
								<td>
									<span class="label label-green"><?=$rs[$value['orderstatus']]?></span>
									</td>
								<td>
									<a data-original-title="查看详情" rel="tooltip" class="btn btn-small btn-primary" href="<?=$this->url("order/orderinfo")?>?uuid=<?=$value["uuid"]?>"><i class="icon-eye-open"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
							</tr>
							<?}?>
						</tbody>
					</table>
						<?=$pageHtml?>
				</div>
			</div>
		</div>
	</div>
</div></div>