<div id="main">
    <div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购执行</a>
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
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datetimepicker/datetimepicker.css">
<script src="/public/assets/sysadmin/js/plugins/datetimepicker/datetimepicker.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datetimepicker/locales/bootstrap-datetimepicker.zh-CN.js"></script>
        <div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					采购商品列表
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        						<tr>
							
							<th width="10%">商品名称</th>
							<th width="10%">商品编号<br/>拼音码</th>
							
							
							
							<th width="10%">价格</th>
												
							<th width="10%">库存</th>							
							
							<th width="15%">数量</th>
							
							
					
						
						</tr>
        					</thead>
                            <?
                                foreach($re as $key=>$value){
                            ?>
                            <tr>
							
							<td><?=$value['title']?>&nbsp;<img width=50 height=50   src="<?=$value["imgpath"]?>"></td>
							<td><?=$value['barcode']?><br/><?=$value['pingyincode']?></td>
							<td><?=$value['costprice']?></td>	
						
							<td><?=$value['number']?></td>
							<td>
						<?=$value['num']?>
							</td>
												
							</tr>
                            <?
                                }
                            ?>
        				</table>
						<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
						
						        
						
						</div>
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
					<i class="icon-user"></i>
				</h3>				
			</div>
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url('cash/tjcart')?>'  id="login" name="login" method='post'>
				<div class="control-group">
						<label for="number" class="control-label">发货时间<br>
						
						</label>
						<div class="controls">
								<input name="data[sendtime]" id="sendtime" value="<?=!empty($res) ? date("Y-m-d",$res["sendtime"]) : date('Y-m-d')?>" class="input-medium datepick valid" type="text">
						</div>
				</div>
				<div class="control-group">
						<label for="number" class="control-label">合同金额<br>
						
						</label>
						<div class="controls">
								<input name="data[price]" id="allprice" value="<?=!empty($res) ? $res["price"] : ''?>" class="span2" type="text">元
						</div>
				</div>
				<div class="control-group">
						<label for="number" class="control-label">验贷标准<br>
						
						</label>
						<div class="controls">
							<textarea  rows="3" name="data[inspectionstandard]" class="span8" id="inspectionstandard"></textarea>
						</div>
				</div>
				
				<div class="control-group">
						<label for="number" class="control-label">上传合同附件<br>
						
						</label>
						<div class="controls">
							<input type="file" class="input-block-level" id="file" name="files">
						</div>
				</div>
						<div class="form-actions">
						 <input type="hidden" value="<?=$applyid?>" name="applyid" >
						 <button type="submit" class="btn btn-primary" >确认提交&nbsp;&nbsp;<i class="icon-shopping-cart"></i></button>    				
						
						</div>
				</form>
			</div>
		</div>
	</div>
</div>


	
	</div>
</div>
<script>
	
	//提交
	function tjcart(){
	
		var remark	=	$("#remarkcart").val();
		$.ajax({
			url:"<?=$this->url('cash/tjcart')?>",
			data:{remark:remark},
			type:"post",
			dataType:"json",
			success:function(r){
				if(r.state == 1){
					pub_alert_success(r.info);
					setTimeout('window.location.href="<?=$this->url('cash/orderconfirm')?>"',600);
					/* if(r.data == 'back'){
					setTimeout('location.reload()',600);
					} */
				  }else{
					pub_alert_error(r.info);
				  }
			}
		
		});
	
	}


</script>