					<div id="main">
			<div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="javascript:;">店铺管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">商品管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">新品采购管理</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="fa fa-close"></i></a>
	</div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
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
					新品采购商品列表
				</h3>
				<div class="actions">
					<a rel="tooltip" data-original-title="添加" href="<?=$this->url("goods/addnewshop")?>" class="btn btn-danger"><i class="icon-plus"></i></a>
				</div>
			</div>
			<div class="box-content nopadding">
				<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
				
				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
					<thead>
						<tr>
							<th width="10%">商品名称</th>
						
							<th width="10%">商品分类</th>
							<th width="10%">净含量</th>
							<th width="10%">规格</th>
							<th width="15%">操作</th>
						</tr>
					</thead>
					<tbody>
						<?foreach ($re as $value) {?>
						<tr>
							<td><?=$value['title']?></td>
						
							<td><?=$value['fctitle']?></td>
							<td><?=$value['percent']?></td>
							<td><?=$value['specs']?></td>
							<td>
							<a data-original-title="修改" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('goods/editnewshop')?>?id=<?=$value["id"]?>"><i class="fa fa-sign-out"></i></a>
						<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("goods/newshopdel")?>?id=<?=$value["id"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-close"></i></a>
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
</div>
</div></div>

 
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