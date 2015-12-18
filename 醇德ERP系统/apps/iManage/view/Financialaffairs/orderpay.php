<link rel="stylesheet" href="/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
<section class="content-header">
<h1>
  收款记录
  <small>收款记录</small>
</h1>
<ol class="breadcrumb">
  <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> 后台管理</a></li>
  <li><a href="#">财务管理</a></li>
  <li class="active">收款记录</li>
</ol>
</section>
<section class="content">
	<div class="row">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">收款记录</h3>
				
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
				      <table id="orderTable" class="table table-bordered table-hover">
					<thead>
        				<tr>
									<th style="display:none;">订货日期</th>
									<th>订货日期</th>
        							<th>订单号</th>
        							
        							<th>订单金额(元)</th>
                                    <th>备注</th>
                                    <th>操作</th>
						</tr>
    				</thead>
    				<tbody>
					  <?
                                foreach($re as $key=>$val){
                                    ?>
                                    <tr>
            							<td><?=-$val['created']?></td>
            							<td><?=date("Y-m-d",$val['created'])?></td>
            							<td><?=$val['ordernum']?></td>
            							<td><?=$val['price']?></td>
            							<td><?=$val['remark']?></td>
            							
            							<td>
     								       <a data-original-title="查看订购商品" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('purchase/payinfo',array('ordernum'=>$val['ordernum']))?>"><i class="icon-signout"></i></a>
						                </td>
            						</tr>
                                    <?
                                }
                            ?>
                        </tbody>
					</table>
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
</script>
 



<div id="main">
    <div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">财务管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">收款记录</a>
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
        <div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					收款记录
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
        				<table class="table table-hover table-nomargin dataTable table-bordered" width="100%">
        					<thead>
        						<tr>
        							<th>订货日期</th>
        							<th>订单号</th>
        							
        							<th>订单金额(元)</th>
                                    <th>备注</th>
                                    <th>操作</th>
        						</tr>
        					</thead>
                            <?
                                foreach($re as $key=>$val){
                                    ?>
                                    <tr>
            							<td><?=date("Y-m-d",$val['created'])?></td>
            							<td><?=$val['ordernum']?></td>
            							<td><?=$val['price']?></td>
            							<td><?=$val['remark']?></td>
            							
            							<td>
     								       <a data-original-title="查看订购商品" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('purchase/payinfo',array('ordernum'=>$val['ordernum']))?>"><i class="icon-signout"></i></a>
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