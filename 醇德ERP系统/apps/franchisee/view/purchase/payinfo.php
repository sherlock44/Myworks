<div id="main">
    <div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="javascript:;">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购商品列表</a>
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
							<th width="10%">图片</th>
							<th width="10%">商品编号</th>
							<th width="10%">价格</th>						
							<th width="10%">库存</th>							
							<th width="15%">订购数量</th>
						</tr>
        					</thead>
                            <?
                                foreach($re as $key=>$value){
                            ?>
                            <tr>
							<td><?=$value['title']?></td>
							<td><img width=50 height=50   src="<?=$value["imgpath"]?>"></td>
							<td><?=$value['barcode']?></td>
							<td><?=$value['buyprice']?></td>	
							<td><?=$value['number']?></td>
							<td><?=$value['buynum']?></td>					
							</tr>
                            <?
                                }
                            ?>
        				</table>
						<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
						<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>				
						        
						
						</div>
        			</div>
        			</div>
        		</div>
        	</div>
        </div>
    
	

	
	</div>
</div>
<script>
//返回列表
	function returnList(){
		window.location.href='<?=$this->url("purchase/orderpay")?>';
	}

</script>