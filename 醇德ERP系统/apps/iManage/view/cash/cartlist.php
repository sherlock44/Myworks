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
			<a href="">采购商品管理</a>
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
							<th width="10%">净含量</th>
							<th width="10%">规格</th>
							<th width="10%">价格</th>				
							<th width="10%">库存</th>							
							<th width="15%">数量</th>
							<th width="15%">操作</th>
								</tr>
        					</thead>
                            <?
                                foreach($re as $key=>$value){
                            ?>
                            <tr>
							
							<td><?=$value['title']?>&nbsp;<img width=50 height=50   src="<?=$value["imgpath"]?>"></td>
							<td><?=$value['barcode']?><br/><?=$value['pingyincode']?></td>
							<td><?=$value['percent']?></td>
							<td><?=$value['specs']?></td>
							<td><?=$value['costprice']?></td>	
							
							<td><?=$value['number']?></td>
							<td>
							<input type="text" id="goodsnum_<?=$value['cartid']?>" name="goodsnum_<?=$value['cartid']?>" onchange="changenum(<?=$value['cartid']?>)"  value="<?=$value['num']?>" class="span8" data-rule-required="true" data-rule-number="true" data-rule-minlength="1" placeholder="只能填数字">
							</td>
							<td>
								
							
							
								<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("cash/delcart")?>?id=<?=$value["cartid"]?>');" class="btn btn-small btn-danger" title="删除"><i class="icon-remove"></i></a>
								
							</td>							
							</tr>
                            <?
                                }
                            ?>
        				</table>
						<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
						        <button class="btn btn-primary"  onclick="tjcart(<?=$applyid?>)">确认并提交&nbsp;&nbsp;<i class="icon-shopping-cart"></i></button>  
						</div>
        			</div>
        			</div>
        		</div>
        	</div>
        </div>
    
	


	
	</div>
</div>
<script>
	//修改采购数量
	function changenum(id){
		var num	=	$("#goodsnum_"+id).val();
		if(isNaN(num)){return false;}
		$.ajax({
			url:"<?=$this->url('cash/updatecart')?>",
			data:"id="+id+"&num="+num,
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
	function tjcart(applyid){
		
		$.ajax({
			url:"<?=$this->url('cash/changestatus2')?>",
			data:{applyid:applyid},
			type:"post",
			dataType:"json",
			success:function(r){
				if(r.state == 1){
					pub_alert_success(r.info);
					
					setTimeout('window.location.href="'+r.url+'"',600);
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