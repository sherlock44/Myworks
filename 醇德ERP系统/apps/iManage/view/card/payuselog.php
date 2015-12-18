<link rel="stylesheet" href="/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="/public/adminlte/plugins/daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="/public/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap time picker -->
<script src="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<section class="content-header">
	<h1>
		会员卡管理
		<small>会员消费记录</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> 后台管理</a></li>
		<li><a href="#">会员卡管理</a></li>
		<li class="active">会员消费记录</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">会员消费记录</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<form action="<?=$this->url("card/payuselog")?>" method="GET" class="input-group input-group-sm" style="padding-bottom:10px;">
						<input id="reservation" name="starttime" style="width: 150px;" class="form-control" type="text" placeholder="开始时间" value="<?=empty($starttime)?"":date('Y-m-d',$starttime)?>">
						<input id="endtime" name="endtime" style="width: 150px;margin-left: 10px;" class="form-control" type="text" placeholder="结束时间" value="<?=empty($endtime)?"":date('Y-m-d',$endtime)?>">
						<input id="keyword" name="keyword" style="width: 150px;margin-left: 10px;" class="form-control" type="text" placeholder="卡号/姓名/加盟商" value="<?=$keyword?>">
						<button type="submit" class="btn btn-primary btn-sm" style="margin-left: 10px;"><i class="fa fa-filter"></i>&nbsp;&nbsp;筛选</button>
					</form>
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th >消费时间</th>
									<th >消费卡号</th>
									<th >卡联系人</th>
									<th >加盟商</th>
									<th >消费金额</th>
									<th >备注</th>
								</tr>
							</thead>
							<tbody>
								<?foreach ($re as $value) {?>
								<tr>
									<td><?=date("Y-m-d H:i:s",$value['created'])?></td>
									<td><?=$value['cardnum']?></td>
									<td><?=$value['truename']?></td>
									<td><?=$value['shoppname']?></td>
									<td><?=$value['money']?></td>
									<td><?=$value['remark']?></td>
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