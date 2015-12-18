<link rel="stylesheet" href="/public/adminlte/plugins/daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="/public/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap time picker -->
<script src="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<section class="content-header">
	<h1>
		订单统计
		<small>订单统计信息</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">订单管理</a></li>
		<li class="active">订单统计</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">订单统计列表</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
						<form action="<?=$this->url("purchasesr/orderlist")?>" method="GET" class="input-group input-group-sm" style="padding-bottom:10px;"  >
							<select name='status' id='status' class="form-control" style="width: 120px;">					
								<option value='' <?=isset($_GET['status'])&&$_GET['status']==''?"selected":""?> >选择订单状态</option>
								<option value='0' <?=isset($_GET['status'])&&$_GET['status']!==''&&$_GET['status']==0?"selected":""?>>待处理</option>							 
								<option value='1' <?=isset($_GET['status'])&&$_GET['status']==1 ?"selected":""?>>未完全成</option>
								<option value='2' <?=isset($_GET['status'])&&$_GET['status']==2 ?"selected":""?>>已完全成</option>
								<option value='-1' <?=isset($_GET['status'])&&$_GET['status']=-1 ?"selected":""?>>无效</option>
							</select>
							<select name='proviceid' id='brandid' onchange="getcity(this.value)" class="form-control" style="width: 120px;margin-left: 10px;">
								<option value='' <?=isset($_GET['proviceid'])&&$_GET['proviceid']==''?"selected":""?> >选择省份</option>
								<?foreach($provice as $val){?>
								<option value='<?=$val['id']?>' <?=isset($_GET['proviceid'])&&$_GET['proviceid']==$val['id']?"selected":""?> ><?=$val['name']?></option>
								<?}?>
							</select>
							<select name='cityid' id='cityid'  class="form-control" style="width: 120px;margin-left: 10px;">
								<option value='' <?=isset($_GET['cityid'])&&$_GET['cityid']==''?"selected":""?> >选择城市</option>
								<?foreach($city as $val){?>
								<option value='<?=$val['id']?>' <?=isset($_GET['cityid'])&&$_GET['cityid']==$val['id']?"selected":""?> ><?=$val['name']?></option>
								<?}?>
							</select>

							<input id="reservation" name="starttime" class="form-control" style="width: 120px;margin-left: 10px;" type="text" placeholder="开始时间" value="<?=empty($starttime)?"":date('Y-m-d',$starttime)?>">	

							<input id="endtime" name="endtime" class="form-control" style="width: 120px;margin-left: 10px;" type="text" placeholder="结束时间" value="<?=empty($endtime)?"":date('Y-m-d',$endtime)?>">	
							<input type="submit" class="btn btn-primary btn-sm" style="margin-left: 10px;" value="搜索">
						</form>
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>订货日期</th>
									<th>订单号</th>
									<th>订单金额(元)</th>
									<th>付款日期</th>
									<th>发货日期</th>
									<th>验收日期</th>
									<th>状态</th>
									<th>备注</th>
									<th >操作</th>
								</tr>
							</thead>
							<tbody>
								<?foreach($re as $key=>$val){?>
								<tr >
									<td><?=date("Y-m-d",$val['created'])?></td>
									<td><?=$val['ordernum']?></td>
									<td>¥ <?=$val['price']?></td>
									<td><?if(!empty($val['paydate'])){echo date("Y-m-d",$val['paydate']);}?></td>
									<td><?if(!empty($val['senddate'])){echo date("Y-m-d",$val['senddate']);}?></td>
									<td><?if(!empty($val['acceptancedate'])){echo date("Y-m-d",$val['acceptancedate']);}?></td>
									<td><?=$this->conf['orderstatus'][$val['status']]?><?if($val['orderbackstatus']>0){?><span style="color:red;"><b>【退货】</b></span><?}?></td>
									<td><?=$val['remark']?></td>
									<td>
										<a data-original-title="查看订购商品" rel="tooltip" class="btn btn-xs btn-success" href="<?=$this->url('purchasesr/orderinfo',array('ordernum'=>$val['ordernum'],'token'=>$val['token']))?>"><i class="fa fa-edit"></i></a>
										<?if($val['orderbackstatus']==0 && $val['status']>=3 && $val['status']<=5){?>
										<a data-original-title="退货" rel="tooltip" class="btn btn-xs btn-danger" href="<?=$this->url('orderback/add',array('ordernum'=>$val['ordernum']))?>"><i class="fa fa-ban"></i></a>
										<?}?>
									</td>
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
	function getcity(id){
		if(id==''){return false;}
//if(isNaN(num)){return false;}
		$.ajax({
			url:"<?=$this->url('purchasesr/getCity')?>",
			data:"id="+id,
			type:"post",
			success:function(r){
				$("#cityid").html(r);
			}
		});
	}
</script>