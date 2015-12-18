<link rel="stylesheet" href="/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
<section class="content-header">
<h1>
  会员管理
  <small>会员卡使用记录</small>
</h1>
<ol class="breadcrumb">
  <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> 后台管理</a></li>
  <li><a href="#">会员卡管理</a></li>
  <li class="active">会员卡使用记录</li>
</ol>
</section>
<section class="content">
	<div class="row">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">会员卡使用记录</h3>
				
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
				      <table id="orderTable" class="table table-bordered table-hover">
					<thead>
        				<tr>
								<th style="display:none;">排序</th>
        							
        							<th >操作时间</th>
											<th >描术</th>
											<th >操作类型</th>
											<th >金额变化</th>
											<th >变化后金额</th>
											<th >操作</th>
						</tr>
    				</thead>
    				<tbody>
					 <?foreach($cardlog as $val){?>
											<td><?=date("Y-m-d H:i:s",$val['created'])?></td>
											<td><?=$val['remark']?></td>
											<td><?=$logtype[$val['type']]?></td>
											<td><?=$val['money']?></td>
											<td><?=$val['hasmoney']?></td>
										
											<td>
											<?if($val['type']==2){?>
											<a class="label label-success" href="<?=$this->url('card/orderinfo',array('ordernum'=>$val['ordernum']))?>">详情</a>
											<?}?>
											</td>
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
 
