	<div id="main">
	<div class="container-fluid" style="padding:0;">
<div class="breadcrumbs" >
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">订单管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">退货操作列表</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="fa fa-close"></i></a>
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


<div class="row-fluid" >
	<div class="span12" >
		<div class="box box-color box-bordered" style="margin-top:-10px;">
			<div class="box-title">
				<h3>
					<i class="icon-th-list"></i>
					退货操作记录列表
				</h3>
				
				
			</div>
			<div class="box-content nopadding">
				<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
				<div id="DataTables_Table_0_length" class="dataTables_length" style="height:36px;">				
					<form action="<?=$this->url("log/purchaseorder")?>" method="GET"  id="bb">
					<div class="row-fluid"  style="width:1000px;height:5px;">
						<div class="span2 ">
                            <div class="control-group">                                
                                <div class="controls controls-row">
                                     <select name='pagenum' id='pagenum' class="input-block-level">					
									 <option value='10' <?=$size==10?"selected":""?> >每页显示条数</option>
									 <option value='20' <?=$size==20?"selected":""?>>20</option>							 
									 <option value='50' <?=$size==50 ?"selected":""?>>50</option>
									 <option value='100' <?=$size==100 ?"selected":""?>>100</option>
									 </select>
                                </div>
                            </div>
                       </div>	
								
                     					   
						<div class="span3">
                            <div class="control-group">                                
                                <div class="controls controls-row">
                                     <input id="ordernum" name="ordernum" class="input-block-level" type="text" placeholder="订单号" value="<?=$ordernum?>">                              	
                                    
                                </div>
                            </div>
                       </div>
                      
                        <div class="span1">                            
                                    <input type="submit" class="btn btn-primary" value="搜索">                             
                       </div>                       
				</div>
					
					
                   </form>
                   </div>
				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
					<thead>
						<tr>
						<th width="10%">订单号</th>
						<th width="10%">审核人</th>
							<th width="25%">审核状态</th>
							<th width="8%">描述</th>
							<th width="10%">审核时间</th>
							
						</tr>
					</thead>
					<tbody>
						<?foreach ($re as $value) {?>
						<tr>
						<td><?=$value['ordernum']?></td>
						<td><?=$value['truename']?></td>
							<td><?=$value['results']?></td>
							<td><?=$value['remark']?></td>	
							<td><?=date("Y-m-d H:i:s",$value['created'])?></td>		
						</tr>
					<?}?>	
					</tbody>
				</table>
				<?=$pageHtml?>
			</div>
			</div>
		</div>
	</div>
</div>
</div>
    </div>

 
<script>
function sycntopshop()
{
    
    $.ajax({
        data:"1=1",
        type:"post",
        url:"<?=$this->url('goods/ecsync')?>",
        dataType:"json",
        success:function(r){
        if(r.state == 1){
        pub_alert_success(r.info);
         }else{
        pub_alert_error(r.info);
        }
        }

    });
     
}
</script>
<script>
function sycntofshop()
{
    
    $.ajax({
        data:"1=1",
        type:"post",
        url:"<?=$this->url('goods/posspsync')?>",
        dataType:"json",
        success:function(r){
        if(r.state == 1){
        pub_alert_success(r.info);
         }else{
        pub_alert_error(r.info);
        }
        }

    });
     
}
</script>