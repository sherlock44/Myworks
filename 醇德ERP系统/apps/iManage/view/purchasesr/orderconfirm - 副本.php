<div id="main">
    <div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">订货管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">待确认订单</a>
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
        					待确认订单
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
        				<table class="table table-hover table-nomargin dataTable table-bordered" width="100%">
        					<thead>
        						<tr>
        							<th>订货日期</th>
        							<th>订单号</th>
        							
        							<th>订单金额(元)</th>
        							<th>运费(元)</th>
        							<th>总金额(元)</th>
        							<th>状态</th>
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
            							<td>
										<input type="text"  data-rule-minlength="1" data-rule-number="true" data-rule-required="true" class="span12" value="<?=$val['freight']?>" onchange="changenum(<?=$val['id']?>)" name="goodsnum_<?=$val['id']?>" id="goodsnum_<?=$val['id']?>">
										
										</td>
            							<td><?=$val['allprice']?></td>
            							<td><?=$this->conf['orderstatus'][$val['status']]?></td>
            							<td><?=$val['remark']?></td>
            							
            							<td>
     								       <a data-original-title="查看订购商品" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('purchasesr/orderinfo',array('ordernum'=>$val['ordernum'],'token'=>$val['token']))?>"><i class="fa fa-backward"></i></a>
           								  
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
<script>
	//修改订单运费
	function changenum(id){
		var freight	=	$("#goodsnum_"+id).val();
		//if(isNaN(num)){return false;}
		$.ajax({
			url:"<?=$this->url('purchase/updatefreight')?>",
			data:"id="+id+"&freight="+freight,
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