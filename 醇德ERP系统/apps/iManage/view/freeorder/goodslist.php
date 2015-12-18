<link rel="stylesheet" href="/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
<section class="content-header">
<h1>
  采购商品列表
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
				
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
				      <table id="orderTable" class="table table-bordered table-hover">
					<thead>
        				<tr>
									<th width="10%">商品名称</th>
							<th width="10%">图片</th>
							<th width="10%">商品编号</th>
							
							
							
							<th width="10%">价格</th>
														
							<th width="10%">库存</th>							
							
							<th width="15%">订购数量</th>
							<th width="15%">操作</th>
						</tr>
    				</thead>
    				<tbody>
					        <?
                                foreach($re as $key=>$value){
                            ?>
                            <tr>
							
							<td><?=$value['title']?></td>
							<td><img width=50 height=50   src="<?=$value["imgpath"]?>"></td>
							<td><?=$value['barcode']?></td>
							<td><?=$value['franchiseeprice']?></td>	
							
							<td><?=$value['number']?></td>
							<td>
							<input type="text" id="goodsnum_<?=$value['cartid']?>" name="goodsnum_<?=$value['cartid']?>" onchange="changenum(<?=$value['cartid']?>)"  value="<?=$value['num']?>" class="span8" data-rule-required="true" data-rule-number="true" data-rule-minlength="1" placeholder="只能填数字">
							</td>
							<td>
								
							
							
								<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("purchase/delcart")?>?id=<?=$value["cartid"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-close"></i></a>
								
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
 <script>
	//修改采购数量
	function changenum(id){
		var num	=	$("#goodsnum_"+id).val();
		if(isNaN(num)){return false;}
		$.ajax({
			url:"<?=$this->url('purchase/updatecart')?>",
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

</script>


