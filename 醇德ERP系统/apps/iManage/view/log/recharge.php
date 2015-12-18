<link rel="stylesheet" href="/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
<section class="content-header">
<h1>
  日志管理
  <small>充值记录</small>
</h1>
<ol class="breadcrumb">
  <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> 后台管理</a></li>
  <li><a href="#">日志管理</a></li>
  <li class="active">充值记录</li>
</ol>
</section>
<section class="content">
	<div class="row">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">充值记录</h3>
				
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
				      <table id="orderTable" class="table table-bordered table-hover">
					<thead>
        				<tr>
								<th>序号</th>
							<th>手机号</th>
							<th>充值金额</th>
							<th>订单号</th>
							<th>流水号</th>
							<th>状态</th>
							<th>时间</th>
						</tr>
    				</thead>
    				<tbody>
					   	<?foreach ($re as $k=>$v){?>
                        <tr>
							<td><?=$k?></td>
							<td><?=$v['mobile']?></td>
							<td><?=$v['money']?></td>
                            <td><?=$v['noid']?></td>
                            <td><?=$v['dealid']?></td>
                            <td><?=$v['status']==0?'<font color="red">未完成</font>':'<font color="green">已完成</font>'?></td>
                            <td><?=date('Y-m-d H:i:s',$v['created'])?></td>
						</tr>					
						<?}?>
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
 
