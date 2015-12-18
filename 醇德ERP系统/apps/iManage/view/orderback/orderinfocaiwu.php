<link rel="stylesheet" href="/public/adminlte/plugins/daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="/public/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap time picker -->
<script src="/public/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<section class="content-header">
	<h1>
		未完成退货
		<small>未完成退货</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> ERP系统</a></li>
		<li><a href="#">退货管理</a></li>
		<li class="active">未完成退货</li>
	</ol>
</section>
<section class="content">
	<div class="box box-default" >
		<div class="box-header with-border">
			退货流程和当前状态
		</div>
		<div class="box-body">
			<div class="form-group" style="height:45px;background-color:white;text-align:center;padding-top:10px;">
				<?foreach($this->conf['orderbackstatus'] as $k=>$v){?>
				<?if($k<0){continue;}?>
				<?if($order['backstatus']==$k){?>
				<span style="color:red;"><?echo ($k+1).".$v";?></span>
				<?}else{?>
				<?echo ($k+1).".$v";?>
				<?}?>
				<?}?>
			</div>
		</div>
		<div class="box-header with-border">
			请选择退货商品和数量
		</div>
		<?$url=$this->url("orderback/caiwucheck");$colspannum=11;?>
		<form class="form-validate form-confirm" action='<?=$url?>' id="logins" name="logins" method='post'>
			<div class="box-body">
				<table class="table table-bordered table-hover">

					<thead>
						<tr>
							<th >商品分类</th>
							<th width="18%">商品名称</th>
							<th >图片</th>
							<th >商品条码</th>
							<th >保质期(月)</th>
							<th >重量</th>
							<th >保质期至</th>											
							<th width="7%">装箱规格</th>
							<th width="7%">退货数量</th>
							<th width="7%">订购单价</th>
							<th width="7%">订单金额</th>
							<th width="130">实收金额</th>
						</tr>
					</thead>
					<?foreach($goods as $key=>$value){?>
					<tr>
						<td><?=$value['fctitle']?></td>
						<td><?=$value['title']?></td>
						<td><img width=25 height=25   src="<?=$value["imgpath"]?>"></td>
						<td><?=$value['barcode']?></td>
						<td><?=!empty($value['shelflife'])?$value['shelflife']:'--'?></td>
						<td><?=$value['weight']?>g/<?=$value['specs']?></td>
						<td><?if(empty($value['shelflife'])){echo '--';}else{echo date("Y-m-d",empty($value['productontime'])?time():$value['productontime']);}?></td>	
						<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>
						<td><?=$value['realbacknum']?>箱</td>
						<td><?=$value['buyprice']?>元</td>
						<td><?=$value['allprice']?>元</td>
						<td>
							<div class="input-group input-group-sm">
								<input type="text" onchange="changeprice()" id="backmoney_<?=$value['foeid']?>" name="backmoney_<?=$value['foeid']?>"   value="<?=empty($value['backmoney'])?'':$value['backmoney']?>" class="form-control backmoney" data-rule-required="false" data-rule-number="false" data-rule-minlength="1" placeholder="只能填数字">
								<span class="input-group-btn">
									<button class="btn btn-success" style="font-weight: bold;" type="button">元</button>
								</span>
								<!-- <span class="input-group-addon">箱</span> -->
							</div>
							<input type="hidden" name="ofid[]" value="<?=$value['foeid']?>">
							<input type="hidden" name="goodsid_<?=$value['foeid']?>" value="<?=$value['id']?>">
							<input type="hidden" name="price_<?=$value['foeid']?>" value="<?=$value['buyprice']?>">
							<input type="hidden" name="backnum_<?=$value['foeid']?>" value="<?=$value['realbacknum']?>">
						</td>
					</tr>
					<?}?>
					<tr>
						<td>实收总价</td>
						<td colspan="<?=$colspannum?>"> 
							<?=empty($order['allprice'])?'':$order['allprice']?>元
						</td>
					</tr>
					<tr>
						<td>退款总价</td>	
						<td colspan="<?=$colspannum?>"> 
							<div class="input-group input-group-sm">
								<input type="text" id="backmoney" style="width:150px;" name="backmoney" readonly value="<?=empty($order['backmoney'])?'':$order['backmoney']?>" class="form-control" data-rule-required="false" data-rule-number="false" data-rule-minlength="1" placeholder="只能填数字">
								<span class="input-group-btn">
									<button class="btn btn-default" style="font-weight: bold;" type="button">元</button>
								</span>
								<!-- <span class="input-group-addon">箱</span> -->
							</div>
						</td>
					</tr>
					<tr>
						<td>退款银行账号</td>	
						<td colspan="<?=$colspannum?>"> 
							<input type="text" id="backbanknumber" style="width:200px;" name="backbanknumber" value="<?=empty($order['backbanknumber'])?'':$order['backbanknumber']?>" class="form-control" data-rule-required="false" data-rule-number="false" data-rule-minlength="1" placeholder="">
						</td>
					</tr>
					<tr>
						<td>退款时间</td>	
						<td colspan="<?=$colspannum?>"> 
							<input type="text" id="backmoneytime" style="width:120px;" name="backmoneytime" value="<?=empty($order['backmoneytime'])?date('Y-m-d'):date("Y-m-d",$order['backmoneytime'])?>" class="form-control datepick" data-rule-required="false" data-rule-number="false" data-rule-minlength="1" placeholder="只能填数字">
						</td>
					</tr>
					<tr>
						<td>退款单</td>
						<td colspan="<?=$colspannum?>"> 
							<input type="file" name="files"><a href="<?=empty($order['backfilepath'])?'':$order['backfilepath']?>" target="_black"><?=empty($order['backfiletitle'])?"":$order['backfiletitle']?></a> 
						</td>
					</tr>
					<?if($order['backstatus']==4){?>
					<tr>
						<td>备注</td>
						<td colspan="<?=$colspannum?>"><textarea rows="3" name="data[remark]" class="form-control" style="width:500px;"></textarea></td>
					</tr>
					<?}?>
					<tr>
						<td>退货订单号</td><td colspan="<?=$colspannum?>"><?=$ordernum?></td>
					</tr>
					<tr>
						<td>审批人</td>	
						<td colspan="<?=$colspannum?>">
							<?=!empty($order) ? $order['truename']: ''?>
						</td>
					</tr>
					<tr>
						<td>当前发货状态</td>	
						<td colspan="<?=$colspannum?>">
							<?if($order['orderbackstatus']==1){echo "未发货";}else{echo "已发货";}?>
						</td>	
					</tr>
					<tr>
						<td>备注</td><td colspan="<?=$colspannum?>"><?=!empty($order) ? $order['orderbackremark']: ''?></td>
					</tr>
					<tr>
						<td>复核备注</td>	<td colspan="<?=$colspannum?>"><?=!empty($order) ? $order['backremarkfh']: ''?></td>
					</tr>
					<?if($order['backstatus']>=5){?>
					<tr>
						<td>财务备注</td>	<td colspan="<?=$colspannum?>"><?=!empty($order) ? $order['backremarkcw']: ''?></td>
					</tr>
					<?}?>
				</table>
				<input type="hidden" value="<?=$ordernum?>" name="ordernum">
				<input type="hidden" value="<?=$order['id']?>" name="id">
			</div>
			<?if($order['backstatus']==4){?>
			<div class="box-footer">
				<input type="submit" class="btn btn-success" value="提交">
				<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>	
			</div>
			<?}?>
		</form>
	</div>
	<?if($order['backstatus']==5){?>
	<form class="box box-default form-validate form-confirm" action='<?=$this->url("orderback/caiwucheckback")?>'  id="formtj1" name="login" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">反审核</h3>
		</div>
		<div class="box-body row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="remark">备注</label>
					<textarea name="data[remark]" class="form-control" placeholder="(反审后，可以修改退款金额)"></textarea>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<input type="hidden" value="<?=$order['id']?>" name="id">
			<input type="submit" class="btn btn-danger" value="反审">
			<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>				
		</div>
	</form>
	<?}?>
	<?if($log){?>
	<div class="box box-default">
		<div class="box-header">
			<h3 class="box-title">
				订单操作记录
			</h3>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-init">
					<thead>
						<tr>
							<th>序号</th>
							<th>审核人</th>
							<th>审核</th>
							<th>描术</th>							
							<th>审核时间</th>
						</tr>
					</thead>
					<?foreach($log as $ks=>$value){?>
					<tr>
						<td><?=$ks?></td>
						<td><?=$value['truename']?></td>
						<td><?=$value['results']?></td>
						<td><?=$value['remark']?></td>	
						<td><?=date("Y-m-d H:i:s",$value['created'])?></td>					
					</tr>
					<?}?>
				</table>
			</div>
		</div>
	</div>
	<?}?>
</section>
<script>
//返回列表
function returnList(){
	window.location.href='<?=$this->url("orderback/orderhouselists")?>';
}
function formtj(){
	if(confirm("确认提交？")){
		$("#formtj").submit();
	}
}
function formtjs(){
	if(confirm("确认提交？")){
		$("#formtjs").submit();
	}
}
function changeprice(){
	
	var money	=	0;
	var price	=	0;
	$(".backmoney").each(function(){
		price=$(this).val()-0;
		money=Number((money+price).toFixed(2));

	});
	
	$("#backmoney").val(money);
}	
</script>
