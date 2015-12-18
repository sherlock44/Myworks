					<div id="main">
			<div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">通用模块</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">物流管理</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="fa fa-close"></i></a>
	</div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
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
					物流列表
				</h3>
				<div class="actions">
					<a rel="tooltip" data-original-title="添加" href="<?=$this->url('General/addgeneral')?>" class="btn btn-danger"><i class="icon-plus"></i></a>
				</div>
			</div>
			<div class="box-content nopadding">
				<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
			
				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
					<thead>
						<tr>
							<th width="9%">公司名称</th>
							<th width="9%">收货地址</th>
							<th width="6%">收货联系人</th>
							<th width="6%">收货电话</th>
							<th width="9%">到达地址</th>
							<th width="4%">联系人</th>
							<th width="6%">电话</th>							
							<th width="5%">夏季价格</th>
							<th width="4%">元(吨)</th>
							<th width="4%">元(箱)</th>
					        <th width="7%">运送时间</th>
					        <th width="5%">冬季价格</th>
					        <th width="4%">元(吨)</th>
							<th width="4%">元(箱)</th>
							<th width="7%">运送时间</th>
							<th width="3">类型</th>
							<th width="5%">操作</th>
						</tr>
					</thead>
					<tbody>
						<?foreach ($re as $value) {?>
						<tr>
							<td><?=$value['company']?></td>
							<td><?=$value['address']?></td>
							<td><?=$value['consignee']?></td>
							<td><?=$value['phone']?></td>	
							<td><?=$value['arrive']?></td>
							<td><?=$value['contact']?></td>
							<td><?=$value['telephone']?></td>
							<td><?=$value['Summerprice']?></td>
							<td><?=$value['milliontons']?></td>
							<td><?=$value['elementbox']?></td>
							<td><?=$value['thetimeofreceipt']?></td>
							<td><?=$value['pricesinwinter']?></td>
							<td><?=$value['dunyuan']?></td>
							<td><?=$value['xiangyuan']?></td>
							<td><?=$value['deliverytime']?></td>
							<td><?=$value['type']?></td>
							
						<td>
							<a data-original-title="修改" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('General/editgeneral')?>?id=<?=$value["id"]?>"><i class="fa fa-sign-out"></i></a>
							
							<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("General/generaldel")?>?id=<?=$value["id"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-close"></i></a>
								
							</td>
						</tr>
					<?}?>	
					</tbody>
				</table>
				<?=$pageHtml?>
			</div>
			
		</div>
	</div>
</div>
</div></div>