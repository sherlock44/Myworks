<link rel="stylesheet" href="/public/adminlte/plugins/daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="/public/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap time picker -->
<script src="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<section class="content-header">
	<h1>
		报表统计
		<small>报表统计</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> 后台管理</a></li>
		<li><a href="#">财务管理</a></li>
		<li class="active">报表统计</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">报表统计</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
						<form action="<?=$this->url("Financialaffairs/reportformcw")?>" method="GET" class="input-group input-group-sm" style="padding-bottom:10px;">
							<input id="reservation" name="starttime" class="form-control" style="width: 120px;" type="text" placeholder="开始时间" value="<?=empty($starttime)?"":date('Y-m-d',$starttime)?>">	
							<input id="endtime" name="endtime" class="form-control" style="width: 120px;margin-left: 10px;" type="text" placeholder="结束时间" value="<?=empty($endtime)?"":date('Y-m-d',$endtime)?>">	
							<input id="keyword" name="keyword" class="form-control" style="width: 120px;margin-left: 10px;" type="text" placeholder="商品名称" value="<?=$keyword?>">
							<input type="submit" class="btn btn-primary btn-sm" style="margin-left: 10px;" value="搜索">
						</form>
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th >业务类型</th>
									<th >开单日期</th>
									<th>单据号</th>
									<th>名称</th>
									<th>收入数量</th>
									<th>发出数量</th>
									<th>结存数量</th>
								</tr>
							</thead>
							<tbody>
								<?foreach($re as $key=>$val){?>
								<tr >
									<td><?=$ywtype[$val['type']]?></td>
									<td><?=date("Y-m-d",$val['created'])?></td>
									<td><?=$val['ordernum']?></td>
									<td><?=$val['title']?></td>
									<td><?if($val['type']!=1){echo $val['number'];}?></td>
									<td><?if($val['type']==1){echo $val['number'];}?></td>
									<td><?=$val['hasnum']?></td>
								</tr>
								<?}?>
							</tbody>
						</table>
						<div class="row">
							<?=$pageHtml?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	$(function () {
		$('#reservation').daterangepicker({singleDatePicker: true,language: 'zh-CN', format: 'YYYY-MM-DD'});
		$('#endtime').daterangepicker({singleDatePicker: true,language: 'zh-CN', format: 'YYYY-MM-DD'});
	});
</script>