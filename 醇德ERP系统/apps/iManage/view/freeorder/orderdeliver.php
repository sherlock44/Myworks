<link rel="stylesheet" href="/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
<section class="content-header">
<h1>
  已发货订单
  <small>已发货订单</small>
</h1>
<ol class="breadcrumb">
  <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> 后台管理</a></li>
  <li><a href="#">采购管理</a></li>
  <li class="active">已发货订单</li>
</ol>
</section>
<section class="content">
	<div class="row">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">已发货订单</h3>
				 
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
				      <table id="orderTable" class="table table-bordered table-hover">
					<thead>
        				<tr>
										<th >订货日期</th>
        							<th >订单号</th>
        							<th>订单金额(元)</th>
        							<th>运费(元)</th>
        							<th>总金额(元)</th>
                                    <th>备注</th>
                                    <th>操作</th>
						</tr>
    				</thead>
    				<tbody>
					    <?
                                foreach($re as $key=>$val){
                                    ?>
                                    <tr>
            							<td><?=date("Y-m-d",$val['created'])?></td>
            							<td><?=$val['ordernum']?></td>
            							<td><?=$val['price']?></td>
										<td><?=$val['freight']?></td>
										<td><?=$val['allprice']?></td>
            							<td><?=$val['remark']?></td>
            							<td>
     								       <a data-original-title="查看订购商品" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('purchase/deliverinfo',array('ordernum'=>$val['ordernum']))?>"><i class="icon-signout"></i></a>
           								  <a href="javascript:pub_alert_confirm(this,'确定已收货？','<?=$this->url("purchase/updateorderstatus")?>?id=<?=$val["id"]?>&status=5');" class="btn btn-xs btn-warning" title="完成"><i class="icon-inbox"></i></a>
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
 

