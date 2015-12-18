					<div id="main">
			<div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="#">系统管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">报价表设计</a>
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
					报价表设计
				</h3>
                <div class="actions">
					<a rel="tooltip" data-original-title="添加" href="<?=$this->url('system/offerSheetEdit')?>" class="btn btn-danger"><i class="icon-plus"></i> 添加报价</a>
				</div>
			</div>
			<div class="box-content nopadding">
				<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
				    <table width="100%" class="table table-hover table-nomargin dataTable table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
					<thead>
						<tr>
							<th>名称</th>
							<th>单价(元)</th>
							<th>状态</th>
                            <th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?foreach ($re as $key=>$val){?>
                        <tr>
							<td><?=$val['name']?></td>
							<td><?=$val['price']?></td>
							<td><?=$val['status']==0?'<font color="red">无效</font>':'<font color="green">有效</font>'?></td>
                            <td>
                                <a data-original-title="修改" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('system/offerSheetEdit')?>?id=<?=$val["id"]?>"><i class="fa fa-sign-out"></i></a>
                            </td>
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