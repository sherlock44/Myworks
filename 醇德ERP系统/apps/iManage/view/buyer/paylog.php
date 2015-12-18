<script language=javascript>history.go(-1);</script><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style>
			table{ border-collapse:collapse; border:1px black solid; margin:0 auto;}
			td{ border:1px black solid; height:20px}
		</style>
		<style type="text/css" media="print">.noprint { display:none;}</style>
<script src="/public/assets/script/jquery-1.9.1.min.js"></script>
<script src="/public/plugins/97date/WdatePicker.js"></script>

	<script>
	function addth(){
		
		var str	=	'';
		str+="<tr><th style=\"font-size:12px;border:#666666 solid 1px;\"><input type=\"text\" name=\"paymoney[]\" value=\"\"/></th><th style=\"font-size:12px;border:#666666 solid 1px;\"><input type=\"text\" name=\"banknum[]\" value=\"\"\/><\/th></th><th style=\"font-size:12px;border:#666666 solid 1px;\"><input type=\"text\" name=\"paytime[]\"  onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd'});\"\/><\/th><th style=\"font-size:12px;border:#666666 solid 1px;\"><select  name=\"paytype[]\">";
		
									<?foreach($paytype as $v){?>
									str+="<option value=\"<?=$v['id']?>\"><?=$v['title']?><\/option>";
									<?}?>
									str+="<\/select><\/th><th style=\"font-size:12px;border:#666666 solid 1px;\"><input type=\"text\" name=\"remark[]\" value=\"\"\/></th></tr><input type=\"hidden\" name=\"id[]\" value=\"0\">";
	$("#tbodytime").append(str);	
	}
	
	</script>
	</head>
	<body>
		<div id="main-content"> <!-- Main Content Section with everything -->
			<div class="clear"></div> <!-- End .clear -->
			<div class="content-box"><!-- Start Content Box -->
				<div class="content-box-content">
					<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
						<form action="<?=$this->url('buyer/paylogtj')?>" method="post" name="sure_m_orders">
						<input type="hidden" name="type" value="changesl">
						<input type="hidden" name="number" value="20150619110920S">
						<input type="hidden" name="spid" value="331">
						<input type="hidden" name="sl" value="50">
						<input type="hidden" name="id" value="5764">
						<table style="width:100%;">
							<tbody id="tbodytime">
								<tr>
								   <th style="font-size:12px;border:#666666 solid 1px;">付款额度</th>
								   <th style="font-size:12px;border:#666666 solid 1px;">银行账号</th>
								   <th style="font-size:12px;border:#666666 solid 1px;">支付时间</th>
								   <th style="font-size:12px;border:#666666 solid 1px;">付款方式</th>
								   <th style="font-size:12px;border:#666666 solid 1px;">备注</th>
								</tr>
								<?$k=0;?>
								<?foreach($paylog as $k=>$val){?>
									<tr>
									<?if($val['created']==0){$created=$val['created'];}else{$created=date("Y-m-d",$val['created']);}?>
										<th style="font-size:12px;border:#666666 solid 1px;">
										<input type="text" name="paymoney[]" value="<?=$val['paymoney']?>" />
										</th>
										<th style="font-size:12px;border:#666666 solid 1px;">
										<input type="text" name="banknum[]" value="<?=$val['banknum']?>"/>
										</th>
										<th style="font-size:12px;border:#666666 solid 1px;">
										<input type="text" name="paytime[]" value="<?=empty($val['paytime'])?'':date("Y-m-d",$val['paytime'])?>"/>
										</th>	
										<th style="font-size:12px;border:#666666 solid 1px;">
										
										<select  name="paytype[]"><?foreach($paytype as $v){?><option value="<?=$v['id']?>" <?=$val['paytype']==$v['id']?'selected':''?>><?=$v['title']?></option><?}?></select>
										</th>	
										<th style="font-size:12px;border:#666666 solid 1px;">
										<input type="text" name="remark[]" value="<?=$val['remark']?>"/>
										</th>	
												
									</tr>
									<input type="hidden" name="id[]" value="<?=$val['id']?>">
								<?}?>
								<?if(!$paylog){?>								
								<?for($k;$k<1;$k++){?>
									<tr>
									<th style="font-size:12px;border:#666666 solid 1px;">
									<input type="text" name="paymoney[]" value="" />
									</th>
									<th style="font-size:12px;border:#666666 solid 1px;"><input type="text" name="banknum[]" value=""/></th>
									<th style="font-size:12px;border:#666666 solid 1px;">
									<input type="text" name="paytime[]" value=""/>
									</th>	
									<th style="font-size:12px;border:#666666 solid 1px;">
									
									<select  name="paytype[]">
									<?foreach($paytype as $v){?>
									<option value="<?=$v['id']?>"><?=$v['title']?></option>
									<?}?>
									</select>
									</th>	
									<th style="font-size:12px;border:#666666 solid 1px;"><input type="text" name="remark[]" value=""/></th></tr><input type="hidden" name="id[]" value="0">
								<?}?>		
								<?}?>		
								
							</tbody>	
							<?if(!empty($re)){?>		
								<tr><th style="font-size:12px;border:#666666 solid 1px;" colspan="6" >采购商品:<span style="color:red;"></span>&nbsp;&nbsp;&nbsp;总数量:<span style="color:red;"></span></th></tr>
								
								<?}?>
								
								<tr>
								<th style="font-size:12px;border:#666666 solid 1px;" colspan="6">
								<input type="button" onclick="addth()" value=" 新增一行 ">&nbsp;<input type="submit" value=" 保 存 "></th>
								</tr>							
						</table>
						<input type="hidden" name="hetongid" value="<?=$hetongid?>">
						
						
						</form>
					</div>
				</div>
			</div>		
		</div>
	</div>
	
	<div id="divhide" style="display:none;">
	<tr><th style="font-size:12px;border:#666666 solid 1px;">
	<input type="text" name="asl[]" value="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});"/>
	</th>
	<th style="font-size:12px;border:#666666 solid 1px;">
	<input type="text" name="asl[]" value=""/>
	<?=$re['specs']?></th>			
	</tr>
	
	</div>
	</body>

</html>