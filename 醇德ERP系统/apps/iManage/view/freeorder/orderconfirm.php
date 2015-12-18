<link rel="stylesheet" href="/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
<section class="content-header">
<h1>
  我的订单管理
  <small>我的订单管理</small>
</h1>
<ol class="breadcrumb">
  <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> 后台管理</a></li>
  <li><a href="#">采购管理</a></li>
  <li class="active">我的订单管理</li>
</ol>
</section>
<section class="content">
	<div class="row">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">我的订单管理</h3>
				 
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
        							
        							<th>订单金额</th>
        							
        							<th>付款日期</th>
        							<th>发货日期</th>
        							<th>验收日期</th>
                                  
                                    <th>订单状态</th>
                                    <th>操作</th>
						</tr>
    				</thead>
    				<tbody>
					    <?
                                foreach($re as $key=>$val){
                                    ?>
                                    <tr title="<?=$val['survey']?>">
									<td style="display:none;"><?=0-$val['created']?></td>
            							<td><?=date("Y-m-d",$val['created'])?></td>
            							<td><?=$val['ordernum']?></td>
            							<td>
										
										<?if($val['orderbackstatus']>0 && $val['backstatus']==5){?>
										<?=$val['price']-$val['backmoney']?>元
										<?}else{?>
										<?=$val['price']?>元
										<?}?>
										</td>
            							<td><?if(!empty($val['paydate'])){echo date("Y-m-d",$val['paydate']);}?></td>
            							<td><?if(!empty($val['senddate'])){echo date("Y-m-d",$val['senddate']);}?></td>
            							<td><?if(!empty($val['acceptancedate'])){echo date("Y-m-d",$val['acceptancedate']);}?></td>
            							<td><?=$this->conf['orderstatus'][$val['status']]?><?if($val['orderbackstatus']>0 && $val['backstatus']!=5){?>
										<span style="color:red;"><b>【退货中】</b></span>
										<?}else if($val['orderbackstatus']>0 && $val['backstatus']==5){?>
										<span style="color:red;"><b>【退货已完成】</b></span>
										<?}?></td>
            							<td>
     								       <a data-original-title="查看订购商品" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('purchase/orderinfo',array('ordernum'=>$val['ordernum']))?>"><i class="icon-signout"></i></a>
										   <?if($val['status']==0){?>
           								   <a href="javascript:pub_alert_confirm(this,'确定要取消吗？','<?=$this->url("purchase/updatestatus")?>?id=<?=$val["id"]?>&status=-1');" class="btn btn-xs btn-danger" title="取消"><i class="fa fa-close"></i></a>
										   <?}?>
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
 



