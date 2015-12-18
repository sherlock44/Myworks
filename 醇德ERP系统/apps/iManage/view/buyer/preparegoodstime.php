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
	<script src="/public/assets/My97DatePicker/WdatePicker.js"></script>

	<script>
		function addth(){
			
			var str	=	'';
			str+="<tr><th style=\"font-size:12px;border:#666666 solid 1px;\"><input type=\"text\" name=\"productendtime[]\"  onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd'});\"\/><\/th><th style=\"font-size:12px;border:#666666 solid 1px;\"><input class=\"goodsnum\" type=\"text\" name=\"num[]\" \/><?=$re['specs']?><\/th><\/tr><input type=\"hidden\" name=\"id[]\" value=\"0\">";
			$("#tbodytime").append(str);	
		}
		function forttj(){
			var num	=	0;
			var n	=	0;
			$(".goodsnum").each(function(){
				n	=	$(this).val();
				if(isNaN(n)){
					n=0;$(this).val(0);
				}
				num=num-0+n;
			});
			var gbnum	=	$("#numbergb").val()-0;
		//if(gbnum!=num){alert("总数量和填写数量不符");return false;}
		$("#formtj").submit();
	}
</script>
</head>
<body>
	<div id="main-content"> <!-- Main Content Section with everything -->
		<div class="clear"></div> <!-- End .clear -->
		<div class="content-box"><!-- Start Content Box -->
			<div class="content-box-content">
				<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
					<form action="<?=$this->url('buyer/updatepreparegoodtime')?>" method="post" id="formtj" name="sure_m_orders">
						
						<table style="width:100%;">
							<tbody id="tbodytime">
								<tr>
									<th style="font-size:12px;border:#666666 solid 1px;">保质期至</th>
									<th style="font-size:12px;border:#666666 solid 1px;">数量</th>
								</tr>
								<?$k=0;?>
								<?foreach($producttime as $k=>$val){?>
								<tr>
									<?if($val['productendtime']==0){$productendtime=$val['productendtime'];}else{$productendtime=date("Y-m-d",$val['productendtime']);}?>
									<th style="font-size:12px;border:#666666 solid 1px;">
										<input type="text" name="productendtime[]" value="<?=$productendtime?>" onclick="WdatePicker();"/>
									</th>
									<th style="font-size:12px;border:#666666 solid 1px;">
										<input type="text" name="num[]" class="goodsnum" value="<?=$val['num']?>"/><?=$re['specs']?></th>
										
									</tr>
									<input type="hidden" name="id[]" value="<?=$val['id']?>">
									<?}?>		
									<?for($k;$k<1;$k++){?>
									<tr>
										<th style="font-size:12px;border:#666666 solid 1px;">
											<input type="text" name="productendtime[]" value="" onclick="WdatePicker();"/>
										</th>
										<th style="font-size:12px;border:#666666 solid 1px;">
											<input type="text" name="num[]" class="goodsnum" value=""/>
											<?=$re['specs']?></th>			
										</tr>
										<input type="hidden" name="id[]" value="0">
										<?}?>		
										
									</tbody>	
									<?if(!empty($re)){?>		
									<tr><th style="font-size:12px;border:#666666 solid 1px;" colspan="6" >采购商品:<span style="color:red;"><?=$re['title']?></span>&nbsp;&nbsp;&nbsp;实到总数量:<span style="color:red;"><?=$re['realnumber']?></span><?=$re['specs']?></th></tr>
									<input type="hidden" value="<?=$re['realnumber']?>" id="numbergb" name="numbergb">
									<?}else{?>
									<input type="hidden" value="0" id="numbergb" name="numbergb">
									<?}?>
									<tr><th style="font-size:12px;border:#666666 solid 1px;" colspan="6">
										<input type="button" onclick="addth()" value=" 新增一行 ">&nbsp;<input type="button" onclick="forttj()" value=" 保 存 "></th></tr>							
									</table>
									<input type="hidden" name="planid" value="<?=$re['planid']?>">
									<input type="hidden" name="cartstoreid" value="<?=$re['id']?>">
									
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