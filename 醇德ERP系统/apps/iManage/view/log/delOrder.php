					<div id="main">
			<div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="#">日志管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">订单删除记录</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="fa fa-close"></i></a>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-th-list"></i>
					订单删除记录
				</h3>
			</div>
			<div class="box-content nopadding">
				<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
				    <table width="100%" class="table table-hover table-nomargin dataTable table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
					<thead>
						<tr>
							<th>序号</th>
							<th>手机号</th>
							<th>订单号</th>
							<th>时间</th>
						</tr>
					</thead>
					<tbody>
						<?foreach ($re as $k=>$v){?>
                        <tr>
							<td><?=$k?></td>
							<td><?=$v['mobile']?></td>
                            <td><?=$v['noid']?></td>
                            <td><?=date('Y-m-d H:i:s',$v['created'])?></td>
						</tr>					
						<?}?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
</div>