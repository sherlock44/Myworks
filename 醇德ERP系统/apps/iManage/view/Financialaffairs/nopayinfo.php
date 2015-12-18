<link rel="stylesheet" href="/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
<section class="content-header">
<h1>
  采购管理
  <small>采购商品列表</small>
</h1>
<ol class="breadcrumb">
  <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> 后台管理</a></li>
  <li><a href="#">采购管理</a></li>
  <li class="active">采购商品列表</li>
</ol>
</section>
<section class="content">
	<div class="row">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">采购商品列表</h3>
				 <div class="actions" style="float: right;">
				   <a rel="tooltip" data-original-title="添加" href="<?=$this->url('user/addusertypeyx')?>" class="btn btn-info btn-sm"> <i class="fa fa-plus"></i>
                            添加
                        </a>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
				      <table id="orderTable" class="table table-bordered table-hover">
					<thead>
        				<tr>
									<th >商品名称</th>
							<th >商品编号</th>
							
							
							
							<th >价格</th>
							<th >供应商</th>							
							<th >库存</th>							
							
							<th >订购数量</th>
						</tr>
    				</thead>
    				<tbody>
					    <?
                                foreach($re as $key=>$value){
                            ?>
                            <tr>
							
							<td><?=$value['title']?>&nbsp;<img width=50 height=50   src="<?=$value["imgpath"]?>"></td>
							<td><?=$value['barcode']?></td>
							<td><?=$value['buyprice']?></td>	
							<td><?=$value['supplier']?></td>
							<td><?=$value['number']?></td>
							<td><?=$value['buynum']?></td>
						
							
													
							</tr>
                            <?
                                }
                            ?>
                        </tbody>
					</table>
					<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
						<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>				
						        
						
						</div>
				</div>
			</div>
			 
			
		</div>
	</div>
</section>
<!-- DataTables -->
<script src="/public/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/public/adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>

<script>
      $(function () {
        $('#orderTable').DataTable({
            "language": {
                "search":"搜索",
                "searchPlaceholder":"请输入关键字",
                "lengthMenu": "每页 _MENU_ 条记录",
                "zeroRecords": "没有找到记录",
                "info": "第 _PAGE_ 页 - 共 _PAGES_ 页",
                "infoEmpty": "无记录",
                "infoFiltered": "(从 _MAX_ 条记录过滤)",
                "paginate": {
                    "last": "尾页",
                    "last": "尾页",
                    "previous": "上一页",
                    "next": "下一页"
                }
             }
        });
      });
	  //返回列表
	function returnList(){
		window.location.href='<?=$this->url("Financialaffairs/handle")?>';
	}
</script>
 

