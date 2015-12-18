<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<section class="content-header">
	<h1>
		采购申请
		<small>采购申请审批</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> ERP系统</a></li>
		<li><a href="#">采购管理</a></li>
		<li class="active">采购申请</li>
	</ol>
</section>
<section class="content">
	<div class="box box-default" >
		<div class="box-header with-border">
			退货流程和当前状态
		</div>
		<div class="box-body">
			<div class="control-group" style="height:45px;background-color:white;text-align:center;padding-top:10px;">
				<?foreach($this->sysconf['purchasestatus'] as $k=>$v){?>
				<?if($k<0){continue;}?>
				<?if($apply['status']==$k){?>
				<span style="color:red;"><?echo ($k+1).".$v";?></span>
				<?}else{?>
				<?echo ($k+1).".$v";?>
				<?}?>
				<?}?>
			</div>
		</div>
	</div>
	<div class="box box-default" <?if($apply['status']>=5){?>style="display:none;"<?}?>>
		<div class="box-header with-border">
			历史采购查询
		</div>
		<div class="box-body">
			<div class="table-responsive">	
				<form id="bb" method="GET" action="<?=$this->url("buyer/historygoods")?>" class="input-group input-group-sm" style="padding-bottom:10px;">	   
					<input type="text" placeholder="商品名称/条形码" class="form-control" style="width: 150px;" name="keyword" id="keyword">                         
					<input type="button" value="搜索" class="btn btn-primary btn-sm" style="margin-left: 10px;"  onclick="getsearchgoods()">                                             
				</form>
				<table class="table table-hover table-nomargin table-bordered" width="100%">
					<thead>
						<tr>
							<th width="50">选择</th>
							<th>商品名称</th>
							<th>商品条码</th>
							<th>商品编码</th>
							<th>供应商</th>
							<th>单品单位</th>
							<th>单价(元)</th>
						</tr>
					</thead>
					<tbody id="searchtbody">
					</tbody>
					<tfoot>
						<tr>
							<td colspan="7">
								<button class="btn btn-success btn-sm" type="button" onclick="tocaigou()" ><i class="icon-ambulance"></i>&nbsp;&nbsp;加入采购单</button>
							</td>
						</tr>
					</tfoot>								
				</table>
			</div>
			<div class="box-header with-border">
				采购计划明细
			</div>
			<div class="box-body">
				<?$url=$this->url("buyer/insertapplycart");?>
				<?if($planid>0   && !$edit){$url=$this->url("buyer/plantj");}?>
				<?if($apply['status']==3){$url=$this->url("buyer/plansure");}?>
				<form class='table-responsive form-horizontal form-bordered form-validate' action='<?=$url?>'  id="planform" name="logins" method='post'>
					<table class="table table-hover table-nomargin table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
						<thead>
							<tr>
								<?$colspan=10;?>
								<th style="display:none">ID</th>
								<?if($planid>0   && !$edit){?>
								<th width="5%">是否购买</th>
								<?$colspan=11;?>
								<?}?>
								<th>名称</th>
								<th width="10%">商品条码</th>
								<th width="10%" >商品编码</th>
								<th width="10%">采购类型</th>
								<th width="12%">供应商</th>
								<th width="8%">单品单位</th>
								<th width="10%">单价(元)</th>
								<th width="5%">数量</th>
								<th width="10%">小计(元)</th>
							</tr>
							<?if($apply['status']==3){?>
							<input type="hidden" name="planid" value="<?=$planid?>">
							<input type="hidden" name="applyid" value="<?=$applyid?>">
							<?}?>
						</thead>
						<?if($planid>0   && !$edit){?>
						<?foreach($planinfo as $key=>$val){?>
						<tr>
							<td style="display:none;"><?=$key?></td>
							<td><input type="checkbox"  value="<?=$val['id']?>" name="cartid[]" <?if($val['status']==1){echo "checked";}?>></td>
							<td><?=$val['title']?></td>
							<td><?=$val['barcode']?></td>
							<td ><?=$val['erpcode']?></td>
							<td><?=$val['cashtype']?></td>
							<td><?=$val['supplyname']?></td>
							<td><?=$val['specs']?></td>
							<td><?=$val['costprice']?></td>
							<td><?=$val['number']?></td>
							<td><?=$val['allprice']?></td>
						</tr>
						<?}?>
						<tr>
							<td colspan="<?=$colspan?>">
								该方案共采购来自<span style="color:red"><?=$supplynum['supplynum']?></span>个供应商，合计价格：<span style="color:red"><?=$allprice['price']?></span>元
							</td>
						</tr>
						<tr>
							<td>
								备注：
							</td>
							<td colspan="<?=$colspan?>">
								<textarea name="remark" class="form-control"></textarea>
							</td>
						</tr>
						<?}else{?>
						<tbody id="table_plan">	
							<?if($planid>0){?>
							<?foreach($planinfo as $key=>$val){?>
							<tr>
								<td style="display:none;"><?=$key?></td>
								<td style="padding:0px;">
									<input type="text" name="title[]" value="<?=$val['title']?>" id="title_<?=$key?>" class="span8" style="width:100%;margin-bottom:-1px;margin-top:3px;" > 
								</td>
								<td style="padding:0px;">
									<input type="text" name="barcode[]" id="barcode_<?=$key?>" class="span8 cashinput" value="<?=$val['barcode']?>" style="width:100%;margin-bottom:-1px;margin-top:3px;"  >
									<input type="hidden" name="goodsuuid[]" id="goodsuuid_<?=$key?>" value="0" >
								</td>
								<td style="padding:0px;">
									<input type="text" name="erpcode[]" id="erpcode_<?=$key?>" class="span8 cashinput" value="<?=$val['erpcode']?>" style="width:100%;margin-bottom:-1px;margin-top:3px;" onchange="checkgoodserpcode(this.value,<?=$key?>)" >
								</td>
								<td style="padding:0px;">
									<!--input type="text" name="cashtype[]" value="<?=$val['cashtype']?>" id="cashtype_<?=$key?>" class="span8" placeholder=""  style="width:100%;margin-bottom:-1px;margin-top:3px;" -->
									<select name="cashtype[]" id="cashtype_<?=$key?>" class="span8">
										<option value="新品" <?if($val['cashtype']=='新品'){echo "selected";}?>>新品</option>
										<option value="补采" <?if($val['cashtype']=='补采'){echo "selected";}?>>补采</option>
									</select>
								</td>
								<td style="padding:0px;">
									<select name="supplyid[]" id="supplyname_<?=$key?>" onchange="changeprice(this.value,<?=$key?>)" class="span8">
										<option value="0">选择供应商</option>
										<?foreach($supplier as $k=>$v){?>
										<option value="<?=$v['id']?>" <?if($v['title']==$val['supplyname']){?>selected<?}?> ><?=$v['title']?></option>
										<?}?>
									</select>
								</td>
								<td style="padding:0px;">
									<input type="text" name="specs[]" value="<?=$val['specs']?>" id="specs_<?=$key?>" class="span8"  style="width:100%;margin-bottom:-1px;margin-top:3px;">
								</td>
								<td style="padding:0px;">
									<input type="text" name="costprice[]" value="<?=$val['costprice']?>"  id="costprice_<?=$key?>" onchange="getallprice(<?=$key?>)" class="span8"  style="width:100%;margin-bottom:-1px;margin-top:3px;">
								</td>
								<td style="padding:0px;">
									<input type="text" name="number[]" value="<?=$val['number']?>" id="number_<?=$key?>" onchange="getallprice2(<?=$key?>)" class="span8"  style="width:100%;margin-bottom:-1px;margin-top:3px;">
								</td>
								<td style="padding:0px;">
									<input type="text" name="allprice[]" value="<?=$val['allprice']?>" id="allprice_<?=$key?>" class="span8" disabled style="width:100%;margin-bottom:-1px;margin-top:3px;">
								</td>
							</tr>
							<?}?>
							<?}?>
							<?for($i=$key+1;$i<=5+$key;$i++){?>	
							<tr class="plantr">
								<td style="display:none;"></td>
								<td style="padding:0px;">
									<input type="text" name="title[]" id="title_<?=$i?>" class="span8 titletag" style="width:100%;margin-bottom:-1px;margin-top:3px;" >
								</td>
								<td style="padding:0px;">
									<input type="text" name="barcode[]" id="barcode_<?=$i?>" class="span8 cashinput" style="width:100%;margin-bottom:-1px;margin-top:3px;"  >
									<input type="hidden" name="goodsuuid[]" id="goodsuuid_<?=$i?>" value="0" >
								</td>
								<td style="padding:0px;">
									<input type="text" name="erpcode[]" id="erpcode_<?=$i?>" class="span8 cashinput" style="width:100%;margin-bottom:-1px;margin-top:3px;" onchange="checkgoodserpcode(this.value,<?=$i?>)" >
								</td>
								<td style="padding:0px;">
									<!--input type="text" name="cashtype[]"  id="cashtype_<?=$i?>" class="span8" placeholder=""  style="width:100%;margin-bottom:-1px;margin-top:3px;" -->
									<select name="cashtype[]" id="cashtype_<?=$i?>" class="span8">
										<option value="新品">新品</option>
										<option value="补采">补采</option>
									</select>
								</td>
								<td style="padding:0px;">
									<select name="supplyid[]" id="supplyname_<?=$i?>" onchange="changeprice(this.value,<?=$i?>)" class="span8">
										<option value="0">选择供应商</option>
										<?foreach($supplier as $k=>$v){?>
										<option value="<?=$v['id']?>"><?=$v['title']?></option>
										<?}?>
									</select>
								</td>
								<td style="padding:0px;">
									<input type="text" name="specs[]"  id="specs_<?=$i?>" class="span8"  style="width:100%;margin-bottom:-1px;margin-top:3px;">
								</td>
								<td style="padding:0px;">
									<input type="text" name="costprice[]"  id="costprice_<?=$i?>" onchange="getallprice(<?=$i?>)" class="span8"  style="width:100%;margin-bottom:-1px;margin-top:3px;">
								</td>
								<td style="padding:0px;">
									<input type="text" name="number[]" id="number_<?=$i?>" onchange="getallprice2(<?=$i?>)" class="span8"  style="width:100%;margin-bottom:-1px;margin-top:3px;">
								</td>
								<td style="padding:0px;">
									<input type="text" name="allprice[]" id="allprice_<?=$i?>" class="span8" disabled style="width:100%;margin-bottom:-1px;margin-top:3px;">
								</td>
							</tr>
							<?}?>
						</tbody>
						<?}?>
					</table>
					<input type="hidden" name="applyid" value="<?=$applyid?>" >
					<input type="hidden" name="planid" value="<?=$planid?>" >
				</form>
			</div>
			<div class="dataTables_info" id="DataTables_Table_0_info" style="float:left;margin:10px;">
				<?if(!$planinfo  || $edit){?>
				<button class="btn btn-primary btn-sm" onclick="addGoods()" >新增5行</button>
				<input type="hidden" value="<?=$i?>" id="nowkey" >
				<?}?>
			</div>
			<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_full_numbers" style="float:right;margin:10px;">
				<?if($apply['status']==2){?>
				<?if(!$planinfo || $edit){?>
				<button class="btn btn-success btn-sm" type="button" onclick="formcarttj()" >保存方案</button>
				<?}else{?>
				<input type="button" onclick="javascript:window.location.href='<?=$this->url("buyer/plan",array("id"=>$applyid,'planid'=>$planid,'edit'=>1))?>'"  class="btn btn-primary btn-sm" value="编辑整个计划" >
				<input type="button" onclick="formcarttj();$('#tjzgjh').val('计划提交中...');" id="tjzgjh" class="btn btn-success btn-sm" value="提交整个计划" >
				<?}?>
				<?}else if($apply['status']==3){?>
				<input type="button" onclick="formcarttj()" class="btn btn-success btn-sm" value="提交计划" >
				<?}?>	
			</div>
		</div>
	</div>
</section>

<script>
//提交表单
function formcarttj(){
	$("#planform").submit();
}
function tjplan(applyid){
	$.ajax({
		data:"applyid="+applyid,
		url:"<?=$this->url('buyer/changestatus1')?>",
		dataType:"json",
		type:"post",
		success:function(r){
			if(r.state == 1){
				pub_alert_success(r.info);
				if(r.data == 'back'){
					setTimeout('location.reload()',600);
				}
			}else{
				pub_alert_error(r.info);
			}
		}
	});
}
//输入商品编码后关联商品
function checkgoodserpcode(val,i){
	return false;
	if(val.length<4){
		return false;
	}
	$.ajax({
		data:"erpcode="+val+"&i="+i,
		url:"<?=$this->url('buyer/getGoods')?>",
		dataType:"json",
		type:"post",
		success:function(r){
			if(r.state == 1){
				$("#cashtype_"+r.k).val("补采");
				$("#barcode_"+r.k).val(re.barcode);
//$("#barcode_"+r.k).val(re.erpcode);
$("#title_"+r.k).val(r.re.title);
$("#costprice_"+r.k).val(r.re.costprice);
$("#specs_"+r.k).val(r.re.specs);
$("#goodsuuid_"+r.k).val(r.re.uuid);
}else{
	$("#cashtype_"+r.k).val("新品");
	$("#barcode_"+r.k).val('');
	$("#title_"+r.k).val('');
	$("#costprice_"+r.k).val(r.re.costprice);
	$("#specs_"+r.k).val(r.re.specs);
	$("#goodsuuid_"+r.k).val(0);
}
}
});
}
//加盟商变了之后，改变价格
function changeprice(supplyid,key){
	if(supplyid==0){return false;}
	var barcode	=	$("#barcode_"+key).val();
	if(barcode.length==0){return false;}
	$.ajax({
		data:"barcode="+barcode+"&supplyid="+supplyid+"&key="+key,
		type:'post',
		url:"<?=$this->url('buyer/supplychangeprice')?>",
		dataType:"json",
		success:function(r){
			if(r.state==1){
				$("#costprice_"+r.key).val(r.price);
			}
		}
	});
}
//查询历史采购商品
function getsearchgoods(){
	var keyword	=$("#keyword").val();
	if(keyword==''){return false;}
	$.ajax({
		data:"keyword="+keyword,
		type:'post',
		url:"<?=$this->url('buyer/historygoods')?>",
		dataType:"json",
		success:function(r){
			if(r.state==1){
				var str	=	'';
				var count_re	=	eval(r.re).length;
				for(var i=0;i<count_re;i++){
					if(!r.re[i]['supplyname']){r.re[i]['supplyname']='';}
					str+="<tr><td><input class='historyid' type='checkbox' value='"+r.re[i]['id']+"'><\/td>";
					str+="<td class='historyid_"+r.re[i]['id']+"_2'>"+r.re[i]['title']+"<\/td>";
					str+="<td class='historyid_"+r.re[i]['id']+"_1'>"+r.re[i]['barcode']+"<\/td>";
					str+="<td  class='historyid_"+r.re[i]['id']+"_0'>"+r.re[i]['erpcode']+"<\/td>";
					str+="<td class='historyid_"+r.re[i]['id']+"_3'>"+r.re[i]['supplyname']+"<\/td>";
					str+="<td class='historyid_"+r.re[i]['id']+"_4'>"+r.re[i]['specs']+"<\/td>";
					str+="<td class='historyid_"+r.re[i]['id']+"_5'>"+r.re[i]['costprice']+"<\/td><\/tr>";
				}
				$("#searchtbody").html(str);
			}
		}
	});
}
//添加5行商品
function addGoods(){
	var i	=	$("#nowkey").val();
	var	j	=	i-0+5;
	var	str	=	'';
	for(;i<=j;i++){
		str+="<tr class='plantr'>";
		str+="<td style=\"display:none;\"><\/td>";
//str+="<td style=\"padding:0px;\"><input type=\"text\" name=\"title[]\" id=\"title_"+i+"\" class=\"span8 titletag\" style=\"width:100%;margin-bottom:-1px;margin-top:3px;\" ><\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"barcode[]\" id=\"barcode_"+i+"\" class=\"span8 cashinput\" style=\"width:100%;margin-bottom:-1px;margin-top:3px;\"  ><input type=\"hidden\" name=\"goodsuuid[]\" id=\"goodsuuid_"+i+"\" value=\"0\" ><\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"erpcode[]\" id=\"erpcode_"+i+"\" class=\"span8 cashinput\" style=\"width:100%;margin-bottom:-1px;margin-top:3px;\" onchange=\"checkgoodserpcode(this.value,"+i+")\" ><\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"cashtype[]\"  id=\"cashtype_"+i+"\" class=\"span8\"   style=\"width:100%;margin-bottom:-1px;margin-top:3px;\" ><\/td><td style=\"padding:0px;\">";
str+="<td style=\"padding:0px;\"><input type=\"text\" name=\"title[]\" id=\"title_"+i+"\" class=\"span8 titletag\" style=\"width:100%;margin-bottom:-1px;margin-top:3px;\" ><\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"barcode[]\" id=\"barcode_"+i+"\" class=\"span8 cashinput\" style=\"width:100%;margin-bottom:-1px;margin-top:3px;\"  ><input type=\"hidden\" name=\"goodsuuid[]\" id=\"goodsuuid_"+i+"\" value=\"0\" ><\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"erpcode[]\" id=\"erpcode_"+i+"\" class=\"span8 cashinput\" style=\"width:100%;margin-bottom:-1px;margin-top:3px;\" onchange=\"checkgoodserpcode(this.value,"+i+")\" ><\/td><td style=\"padding:0px;\">";
str+="<select name=\"cashtype[]\" id=\"cashtype_"+i+"\" class=\"span8\">";
str+="<option value=\"新品\" >新品<\/option>";
str+="<option value=\"补采\" >补采<\/option><\/select><\/td>";
str+="<td style=\"padding:0px;\"><select name=\"supplyid[]\" id=\"supplyname_"+i+"\" onchange=\"changeprice(this.value,"+i+")\" class=\"span8\">";
str+="<option value=\"0\">选择供应商<\/option>";
<?foreach($supplier as $k=>$v){?>
	str+="<option value=\"<?=$v['id']?>\"><?=$v['title']?><\/option>";
	<?}?>
	str+="<\/select>";
	str+="<\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"specs[]\"  id=\"specs_"+i+"\" class=\"span8\"  style=\"width:100%;margin-bottom:-1px;margin-top:3px;\"><\/td><td style=\"padding:0px;\"><input type=\"text\" onchange=\"getallprice("+i+")\" name=\"costprice[]\"  id=\"costprice_"+i+"\" class=\"span8\"  style=\"width:100%;margin-bottom:-1px;margin-top:3px;\"><\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"number[]\" onchange=\"getallprice2("+i+")\" id=\"number_"+i+"\" class=\"span8\"  style=\"width:100%;margin-bottom:-1px;margin-top:3px;\"><\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"allprice[]\" id=\"allprice_"+i+"\" class=\"span8\" disabled style=\"width:100%;margin-bottom:-1px;margin-top:3px;\"><\/td>";
	str+="<\/tr>";
}
$("#table_plan").append(str);
$("#nowkey").val(j);
}
//修改商品数量或单位，总价修改--通过价格
function getallprice(i){
	var num	=	$("#number_"+i).val();
	var price	=	$("#costprice_"+i).val();
	if(!isPirce(price)){
		pub_alert_error("请输入正确的价格");
		$("#allprice_"+i).val('');
		return false;
	}
	if(isNaN(num)){
		return false;
	}
	var allprice	=	price*100*num/100;
	$("#allprice_"+i).val(allprice);
}
//修改商品数量或单位，总价修改--通过修改数量
function getallprice2(i){
	var num	=	$("#number_"+i).val();
	var price	=	$("#costprice_"+i).val();
	if(isNaN(num)){
		pub_alert_error("数量为自然数");
		$("#allprice_"+i).val('');return false;
	}
	if(!isPirce(price)){
		return false;
	}
	var allprice	=	price*100*num/100;;
	$("#allprice_"+i).val(allprice);
}
function isPirce(s){
	s=s.trim();
	var p =/^[1-9](\d+(\.\d{1,2})?)?$/; 
	var p1=/^[0-9](\.\d{1,2})?$/;
	return p.test(s) || p1.test(s);
}
//加入到采购单
function tocaigou(){
	i	=	$("#nowkey").val();
	j	=	i-0+$(".historyid:checked").length;
	var	str	=	'';
	$(".historyid:checked").each(function(){
		var id	=	$(this).val();
//采购明细是空白的行删除
var len	=	$(".plantr").length;
var jl=0;
for(var ii=0;ii<len;ii++){
	if($(".titletag").eq(jl).val()==''){
		$(".plantr").eq(jl).remove();
	}else{
		jl++;
	}
}
var erpcode	=	$('.historyid_'+id+'_0').html();
var barcode	=	$('.historyid_'+id+'_1').html();
var title	=	$('.historyid_'+id+'_2').html();
var supplyname	=	$('.historyid_'+id+'_3').html();
var specs	=	$('.historyid_'+id+'_4').html();
var price	=	$('.historyid_'+id+'_5').html();
str+="<tr class='plantr'>";
str+="<td style=\"display:none;\"><\/td>";
str+="<td style=\"padding:0px;\"><input type=\"text\" name=\"title[]\" value='"+title+"' id=\"title_"+i+"\" class=\"span8 titletag\" style=\"width:100%;margin-bottom:-1px;margin-top:3px;\" ><\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"barcode[]\" id=\"barcode_"+i+"\" class=\"span8 cashinput\" style=\"width:100%;margin-bottom:-1px;margin-top:3px;\" onchange=\"checkgoods(this.value,"+i+")\" value='"+barcode+"'><input type=\"hidden\" name=\"goodsuuid[]\" id=\"goodsuuid_"+i+"\" value=\"0\" ><\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"erpcode[]\" value='"+erpcode+"' id=\"erpcode_"+i+"\" class=\"span8 cashinput\" style=\"width:100%;margin-bottom:-1px;margin-top:3px;\" onchange=\"checkgoodserpcode(this.value,"+i+")\" ><\/td><td style=\"padding:0px;\">";
str+="<select name=\"cashtype[]\" id=\"cashtype_"+i+"\" class=\"span8\">";
str+="<option value=\"新品\" >新品<\/option>";
str+="<option value=\"补采\" selected>补采<\/option><\/select><\/td>";
str+="<td style=\"padding:0px;\"><select name=\"supplyid[]\" id=\"supplyname_"+i+"\" onchange=\"changeprice(this.value,"+i+")\" class=\"span8\">";
str+="<option value=\"0\">选择供应商<\/option>";
<?foreach($supplier as $k=>$v){?>
	var supplytitle	=	'<?=$v['title']?>';
	if(supplyname==supplytitle){
		str+="<option selected	value=\"<?=$v['id']?>\"><?=$v['title']?><\/option>";	
	}else{
		str+="<option	value=\"<?=$v['id']?>\"><?=$v['title']?><\/option>";
	}
	<?}?>
	str+="<\/select>";
	str+="<\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"specs[]\" value='"+specs+"' id=\"specs_"+i+"\" class=\"span8\"  style=\"width:100%;margin-bottom:-1px;margin-top:3px;\"><\/td><td style=\"padding:0px;\"><input type=\"text\" onchange=\"getallprice("+i+")\" name=\"costprice[]\"  id=\"costprice_"+i+"\" value='"+price+"' class=\"span8\"  style=\"width:100%;margin-bottom:-1px;margin-top:3px;\"><\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"number[]\" onchange=\"getallprice2("+i+")\" id=\"number_"+i+"\" class=\"span8\"  style=\"width:100%;margin-bottom:-1px;margin-top:3px;\"><\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"allprice[]\" id=\"allprice_"+i+"\" class=\"span8\" disabled style=\"width:100%;margin-bottom:-1px;margin-top:3px;\"><\/td>";
	str+="<\/tr>";
	i++;
});
$("#table_plan").append(str);
$("#nowkey").val(j);
}
</script>
