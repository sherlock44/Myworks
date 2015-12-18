<div id="main">
    <div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="javascript:;">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">未发货订单</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
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
        					未发货订单
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
        				<table class="table table-hover table-nomargin dataTable table-bordered" width="100%">
        					<thead>
        						<tr>
        							<th style="width:15%">订货日期</th>
        							<th style="width:15%">订单号</th>
        							<th>订单金额(元)</th>
        							<th style="width:10%">运费(元)</th>
        							<th>总金额(元)</th>
                                    <th style="width:20%">备注</th>
                                    <th style="width:10%">操作</th>
        						</tr>
        					</thead>
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
     								       <a data-original-title="查看订购商品" rel="tooltip" class="btn btn-small btn-success" href="<?=$this->url('purchase/nodeliverinfo',array('ordernum'=>$val['ordernum']))?>"><i class="icon-signout"></i></a>
           								   
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