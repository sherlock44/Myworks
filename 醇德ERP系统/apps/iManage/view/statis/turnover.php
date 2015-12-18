
<link rel="stylesheet" href="/public/adminlte/plugins/daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="/public/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap time picker -->
<script src="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<section class="content-header">
	<h1>
		加盟商营业额
		<small>加盟商营业额数据统计</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">统计管理</a></li>
		<li class="active">加盟商营业额</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">加盟商营业概况</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
						<form action="<?=$this->url("statis/turnover")?>" method="GET" class="input-group input-group-sm" style="padding-bottom:10px;">
							<input name="start" value="<?=$start?>" id="reservation" class="form-control" style="width: 120px;" type="text" data-rule-required="true"  placeholder="开始时间" > 
							<input name="end" value="<?=$end?>" id="endtime" class="form-control" style="width: 120px;margin-left: 10px;" type="text" data-rule-required="true"  placeholder="结束时间" > 
							<input name="jms" class="form-control" style="width: 120px;margin-left: 10px;" value="<?=$jms?>" type="text" data-rule-required="true" placeholder="加盟商名称" >     
							<input type="submit" class="btn btn-primary btn-sm" style="margin-left: 10px;" value="搜索">
						</form>
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th style="text-align:center">加盟商</th>
									<th style="text-align:center">营业额总计</th>
								</tr>
							</thead>
							<tbody>
								<?foreach($rs as $key=>$val){?>
								<tr>
									<td><?=$val['suppname']?></td>
									<td><?=$val['tolpri']?>元</td>
								</tr>
								<?}?>
							</tbody>
						</table>
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
