
<link rel="stylesheet" href="/public/adminlte/plugins/daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="/public/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap time picker -->
<script src="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<section class="content-header">
	<h1>
		商品销售量统计
		<small>商品销售量数据统计</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">统计管理</a></li>
		<li class="active">商品销售量统计</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">商品销售量列表</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
						<form action="<?=$this->url("statis/getgoods")?>" method="GET" class="input-group input-group-sm" style="padding-bottom:10px;">
							<input name="starttime" id="reservation" class="form-control" style="width: 120px;" value="<?=!empty($starttime) ? date("Y-m-d",$starttime) : ''?>" type="text" >   
							<input name="endtime" id="endtime"  class="form-control" style="width: 120px;margin-left: 10px;" value="<?=!empty($endtime) ? date("Y-m-d",$endtime) : ''?>"type="text" placeholder="结束时间">
							<input type="submit" class="btn btn-primary btn-sm" style="margin-left: 10px;" value="搜索">
						</form>
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th >商品类别</th>
									<th >商品名称</th>
									<th >图片</th>
									<th>商品条码</th>
									<th>装箱规格</th>
									<th>销售量</th>
								</tr>
							</thead>
							<tbody>
								<?foreach ($re as $value) {?>
								<tr>
									<td><?=$value['fctitle']?></td>
									<td><?=$value['title']?></td>
									<td><img width=25 height=25   src="<?=$value["imgpath"]?>"></td>
									<td><?=$value['barcode']?></td>
									<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>	
									<td><?=$value['salenum']?>箱</td>
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
