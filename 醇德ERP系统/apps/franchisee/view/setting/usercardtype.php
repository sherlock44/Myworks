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
			<a href="">会员卡管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">会员类型管理</a>
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
        					会员卡折扣规则
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
	        					<tr>
									<th >会员卡类型</th>
									<th >会员卡折扣率</th>
								</tr>
        					</thead>
                           <?foreach($cardtype as $key=>$value){ ?> 
	                            <tr>
									<td><?=$value?></td>
									<td>
										<?=$arr[$key]['discount']*100?>&nbsp;<span class="">%</span>
									</td>							
								</tr>
                            <?}?> 
        				</table>
        			</div>
        			</div>
        		</div>
        	</div>
        </div>
    
	
	<div class="row-fluid">
	
</div>


	
	</div>
</div>
<script>
	//修改采购数量
	function changenum(id){
		var num	=	$("#discount_"+id).val();
		if(isNaN(num)){return false;}
		$.ajax({
			url:"<?=$this->url('card/updatediscount')?>",
			data:"cardid="+id+"&num="+num,
			type:"post",
			dataType:"json",
			success:function(r){
				if(r.state == 1){
					pub_alert_success(r.info);
					if(r.data == 'back'){
					setTimeout('location.reload()',600);
					}
				  }else{
					pub_alert_error(r.info);
				  }
			}
		
		});
	
	}
	//提交
	// function tjcart(){
	// 	var remark	=	$("#remarkcart").val();
	// 	$.ajax({
	// 		url:"<?=$this->url('purchase/tjcart')?>",
	// 		data:{remark:remark},
	// 		type:"post",
	// 		dataType:"json",
	// 		success:function(r){
	// 			if(r.state == 1){
	// 				pub_alert_success(r.info);
	// 				setTimeout('window.location.href="<?=$this->url('purchase/orderconfirm')?>"',600);
	// 				/* if(r.data == 'back'){
	// 				setTimeout('location.reload()',600);
	// 				} */
	// 			  }else{
	// 				pub_alert_error(r.info);
	// 			  }
	// 		}
		
	// 	});
	
	// }


</script>