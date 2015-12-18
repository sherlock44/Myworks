<link rel="stylesheet" href="/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
<section class="content-header">
<h1>
  站内信息
  <small>站内信息</small>
</h1>
<ol class="breadcrumb">
  <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> 后台管理</a></li>
  <li><a href="#">通用管理</a></li>
  <li class="active">站内信息</li>
</ol>
</section>
<section class="content">
	<div class="row">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">站内信息</h3>
				 
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
				      <table id="orderTable" class="table table-bordered table-hover">
					<thead>
        				<tr>
									<th>ID</th>
        							<th>发送者</th>
                                    <th>信息状态</th>
        							<th>发送时间</th>      
                                    <th>操作</th>
						</tr>
    				</thead>
    				<tbody>
					    <?
                                foreach($re as $key=>$val){
                                    ?>
                                    <tr>
                                        <td><?=$val['id']?></td>
                                        <td><?=$val['truename']?></td>
                                        <td><?=$val['sign']==1?'未读':'已读';?></td>
                                        <td><? echo date("Y-m-d h:i:s",$val['time'])?></td>
                                        <td>
                                           <a data-original-title="查看" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('General/myskin',array('id'=>$val['id']))?>"  ><i class="fa fa-sign-out"></i></a>
                                           <a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("General/delMyinfo")?>?id=<?=$val["id"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-close"></i></a> 
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
 
