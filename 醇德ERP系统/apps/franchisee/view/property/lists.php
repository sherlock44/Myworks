					<div id="main">
			<div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$this->url('index/main')?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="#">交接班管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">交接班管理</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div>


<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-th-list"></i>
					交接班管理
				</h3>
			</div>
			<div class="box-content nopadding">
				<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
				    <table width="100%" class="table table-hover table-nomargin dataTable table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
					<thead>
						<tr>
							<th style="display:none;">序号</th>
							<th>工作人员</th>
							<th>联系方式</th>
							<th>订单总数</th>
							<th>总销售额</th>
							<th>现金支付额</th>
							<th>卡付额</th>
							<th>在线支付额</th>
							<th>登录时间</th>
							<th>结束时间</th>
						</tr>
					</thead>
					<tbody>
						<?foreach ($re as $k=>$v){?>
                        <tr>
							<td style="display:none;"><?echo (0-$v['id']);?></td>
							<td><?=$v['workername']?></td>
							<td><?=$v['mobile']?></td>
                            <td><?=$v['ordernum']?></td>
                            <td><?=$v['totalprice']?></td>
                            <td><?=$v['cashpaymoney']?></td>
                            <td><?=$v['cardpaymoney']?></td>
                            <td><?=$v['netpaymoney']?></td>
                           
                            
                            <td><?=date('Y-m-d H:i:s',$v['logintime'])?></td>
                            <td><?=date('Y-m-d H:i:s',$v['endtime'])?></td>
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