<div id="main">
    <div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">入库管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">入库执行</a>
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
<script>
	function changehouse(goodsid,houseposid,houseid){
		
		if(houseid==0){
			var html	=	"<option value='0'>选择库位</option>";
			$("#housepos_"+goodsid).html(html);
		}else{
			$.ajax({
				data:{goodsid:goodsid,houseid:houseid,houseposid:houseposid},
				url:"<?=$this->url('orderback/getHousePos')?>",
				type:"post",
				dataType:"json",
				success:function(data){
					$("#housepos_"+data.goodsid).html(data.html);
				
				}
			
			});
		}
	
	
	}

</script>
<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url('cash/inserkwinfo')?>'  id="login" name="login" method='post'>
        <div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					入库商品列表
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
							<th width="15%">库房</th>
							<th width="15%">库位</th>				
						</tr>
        					</thead>
                            <?
                                foreach($re as $key=>$value){
                            ?>

                            <input type="hidden" name="trids[]" value="<?=$value['cartid']?>" />
                            <tr>
							
							<td><?=$value['title']?>&nbsp;<img width=50 height=50   src="<?=$value["imgpath"]?>"></td>
							<td><?=$value['barcode']?><br/><?=$value['pingyincode']?></td>
							<td><?=$value['costprice']?></td>	
						
							<td><?=$value['number']?></td>
							<td>
							<?=$value['num']?>
							
							</td>
							<td>
								<select id="houseid_<?=$value['id']?>" name="houseid[]" onchange="changehouse(<?=$value['id']?>,<?=$value['houseposid']?>,this.value)">
								<option value="0">选择库房</option>
									<?foreach($house as $val){?>
									<option value="<?=$val['id']?>" <?if($value['houseid']==$val['id']){echo "selected";}?>><?=$val['title']?></option>
									<?}?>
								</select>
							</td>	
							<td>
								<select name="houseposid[]" id="housepos_<?=$value['id']?>">
									<option value="0">选择库位</option>
								</select>
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
				
				<div class="control-group">
						<label for="number" class="control-label">入库类型<br>
						
						</label>
						<div class="controls">
								<select  name="data[rktp]" >
								<option value="0">选择入库类型</option>
									<?foreach($storetype as $val){?>
									<option value="<?=$val['id']?>" ><?=$val['title']?></option>
									<?}?>
								</select>
						</div>
				</div>
				
				<div class="control-group">
						<label for="number" class="control-label">入库说明<br>
						
						</label>
						<div class="controls">
							<textarea  rows="3" name="data[inremark]" class="span8" id="outremark"></textarea>
						</div>
				</div>
				
				
						<div class="form-actions">
						<input type="hidden" value="<?=$id?>" name="applyid" >
						 <button type="submit" class="btn btn-primary" >确认提交&nbsp;&nbsp;<i class="icon-shopping-cart"></i></button>    				
						
						</div>
				
			</div>
		</div>
	</div>
</div>
</form>

	
	</div>
</div>
<script>
	
	//提交
	function tjcart(){
		var remark	=	$("#remarkcart").val();
		$.ajax({
			url:"<?=$this->url('cash/inserkwinfo')?>",
			data:{remark:remark},
			type:"post",
			dataType:"json",
			success:function(r){

				 if(r.state == 1){
        pub_alert_success(r.info);
        if(r.data == 'back'){
        setTimeout('history.go(-1)',600);
        }else if(r.data == 'url'){

        	var url	=	"http://".ROOT_URL."/index.php/iManage/cash/back";
			window.location.href=url
		}
      }else{
        pub_alert_error(r.info);
      }

			}		
		});
	
	}


</script>