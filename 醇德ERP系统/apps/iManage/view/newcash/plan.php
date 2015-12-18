<div id="main">
    <div class="container-fluid nopadding">

<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购计划列表</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/chosen/chosen.css">
<script src="/public/assets/sysadmin/js/plugins/chosen/chosen.jquery.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/jquery.dataTables.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/TableTools.css">
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/TableTools.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColReorder.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColVis.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.columnFilter.js"></script>
<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i><?=$apply['title']?> 采购流程
				</h3>				
			</div>
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("newcash/insertplan")?>'  id="login" name="login" method='post'>
					<div class="control-group" style="height:45px;background-color:white;text-align:center;padding-top:10px;">
						<?foreach($sysconf['purchasestatus'] as $k=>$v){?>
								<?if($k<0){continue;}?>
								<?if($apply['status']==$k){?>
								<span style="color:red;"><?echo ($k+1).".$v";?></span>
								<?}else{?>
								<?echo ($k+1).".$v";?>
								<?}?>
							<?}?>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

        <div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					<?foreach($plan as $k=>$val){?>
								<a href="<?=$this->url('newcash/plan',array('id'=>$applyid,'planid'=>$val['id']))?>" class="btn btn-danger" style="color:white;background:<?if($planid==$val['id']){?>red<?}else{?>blue<?}?> none repeat scroll 0 0"><?=$val['title']?></a>&nbsp;|&nbsp;
							<?}?>
							<?if($apply['status']==2){?>
							<a href="<?=$this->url('newcash/plan',array('id'=>$applyid,'planid'=>0))?>" class="btn btn-danger" style="color:white;background:<?if($planid==0){?>red<?}else{?>blue<?}?> none repeat scroll 0 0">新增计划</a>
							<?}?>
        				</h3>
                        <div class="actions">
        					
        				</div>
                    
        			</div>
        			<div class="box-content nopadding">
						<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("newcash/insertapplycart")?>'  id="planform" name="logins" method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" width="100%">
        					<thead>
        						<tr>
        						
        							<th style="display:none">ID</th>
        							<th width="15%">商品编号</th>
        							<th>名称</th>
                                    <th width="5%">采购类型</th>
                                    <th width="15%">供应商</th>
                                    <th width="10%">规格</th>
                                    <th width="10%">单价(元)</th>
                                    <th width="5%">数量</th>
                                    <th width="10%">总价</th>
                                
        						</tr>
        					</thead>
									<?if($planid>0){?>
									<?foreach($planinfo as $key=>$val){?>
                                    <tr>
            						
            							<td style="display:none;"><?=$key?></td>
            							<td><?=$val['barcode']?></td>
            							<td><?=$val['title']?></td>
            							<td><?=$val['cashtype']?></td>
            							<td><?=$val['supplyname']?></td>
            							<td><?=$val['specs']?></td>
            							<td><?=$val['costprice']?></td>
            							<td><?=$val['number']?></td>
            							<td><?=$val['allprice']?></td>
            							
            							
            						</tr>
                                    <?}?>
									<tr>
									<td colspan="9">
									该方案共采购<span style="color:red"><?=$goodsnum['goodsnum']?></span>种商品，来自<span style="color:red"><?=$supplynum['supplynum']?></span>个供应商，合计价格：<span style="color:red"><?=$allprice['price']?></span>元
									</td>
									</tr>
                                    <?}else{?>
									<tbody id="table_plan">	
									<?for($i=1;$i<=5;$i++){?>	
									 <tr>
            							<td style="display:none;"></td>
            							<td style="padding:0px;">
										<input type="text" name="barcode[]" id="barcode_<?=$i?>" class="span8 cashinput" style="width:100%;margin-bottom:-1px;margin-top:3px;" onchange="checkgoods(this.value,<?=$i?>)" >
										<input type="hidden" name="goodsuuid[]" id="goodsuuid_<?=$i?>" value="0" >
										</td>
            							<td style="padding:0px;">
										<input type="text" name="title[]" id="title_<?=$i?>" class="span8" style="width:100%;margin-bottom:-1px;margin-top:3px;" >   </td>
            							<td style="padding:0px;">
										<input type="text" name="cashtype[]"  id="cashtype_<?=$i?>" class="span8" placeholder=""  style="width:100%;margin-bottom:-1px;margin-top:3px;" ></td>
            							<td style="padding:0px;">
										<input type="text" name="supplyname[]" id="supplyname_<?=$i?>" class="span8"  style="width:100%;margin-bottom:-1px;margin-top:3px;" ></td>
            							<td style="padding:0px;">
										<input type="text" name="specs[]"  id="specs_<?=$i?>" class="span8"  style="width:100%;margin-bottom:-1px;margin-top:3px;"></td>
            							<td style="padding:0px;">
										<input type="text" name="costprice[]"  id="costprice_<?=$i?>" onchange="getallprice(<?=$i?>)" class="span8"  style="width:100%;margin-bottom:-1px;margin-top:3px;"></td>
            							<td style="padding:0px;">
										<input type="text" name="number[]" id="number_<?=$i?>" onchange="getallprice2(<?=$i?>)" class="span8"  style="width:100%;margin-bottom:-1px;margin-top:3px;"></td>
            							<td style="padding:0px;">
										<input type="text" name="allprice[]" id="allprice_<?=$i?>" class="span8" disabled style="width:100%;margin-bottom:-1px;margin-top:3px;"></td>
            						</tr>
									<?}?>
									
									</tbody>
									<?}?>
        				</table>
						<input type="hidden" name="applyid" value="<?=$applyid?>" >
						<input type="hidden" name="planid" value="<?=$planid?>" >
						 </form>
						 <div class="dataTables_info" id="DataTables_Table_0_info" style="float:left;margin:10px;">
						 <?if(!$planinfo){?>
						 	<button class="btn btn-primary" onclick="addGoods()" ><i class="icon-shopping-cart"></i>&nbsp;&nbsp;新增5行</button>
							<input type="hidden" value="<?=$i?>" id="nowkey" >
							<?}?>
						</div>
						 <div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_full_numbers" style="float:right;margin:10px;">
						 <?if($apply['status']==2){?>
						 <?if(!$planinfo){?>
							<button class="btn btn-success" onclick="formcarttj()" ><i class="icon-ambulance"></i>&nbsp;&nbsp;保存方案</button>
							<?}else{?>
							<input type="button" onclick="javascript:pub_alert_confirm(this,'该采购共有<?=count($plan)?>份计划，确认提交这些计划？','<?=$this->url("newcash/plantj",array("applyid"=>$applyid))?>');"  class="btn btn-primary" value="提交整个计划" >
							<?}?>
						<?}else if($apply['status']==3){?>
							<input type="button" onclick="javascript:pub_alert_confirm(this,'确认选择该计划？','<?=$this->url("newcash/plansure",array("applyid"=>$applyid,'planid'=>$planid))?>');"  class="btn btn-primary" value="提交计划" >
						<?}?>	
						</div>
						 
						 
						 
        			</div>
        		</div>
        	</div>
        </div>
		
		
	
    </div>
</div>
<script>
	//提交表单
	function formcarttj(){
	
		$("#planform").submit();
	}
	function tjplan(applyid){
		$.ajax({
			data:"applyid="+applyid,
			url:"<?=$this->url('cash/changestatus1')?>",
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
	 function checkgoods(val,i){
		if(val.length<4){
			return false;
		}
		$.ajax({
			data:"barcode="+val+"&i="+i,
			url:"<?=$this->url('newcash/getGoods')?>",
			dataType:"json",
			type:"post",
			success:function(r){
				if(r.state == 1){
					$("#cashtype_"+r.k).val("补采");
					$("#title_"+r.k).val(r.re.title);
					$("#costprice_"+r.k).val(r.re.costprice);
					$("#specs_"+r.k).val(r.re.specs);
					$("#goodsuuid_"+r.k).val(r.re.uuid);
				  }else{
					$("#cashtype_"+r.k).val("新品");
					$("#title_"+r.k).val('');
					$("#costprice_"+r.k).val(r.re.costprice);
					$("#specs_"+r.k).val(r.re.specs);
					$("#goodsuuid_"+r.k).val(0);
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
			str+="<tr>";
			str+="<td style=\"display:none;\"><\/td>";
			str+="<td style=\"padding:0px;\"><input type=\"text\" name=\"barcode[]\" id=\"barcode_"+i+"\" class=\"span8 cashinput\" style=\"width:100%;margin-bottom:-1px;margin-top:3px;\" onchange=\"checkgoods(this.value,"+i+")\" ><input type=\"hidden\" name=\"goodsuuid[]\" id=\"goodsuuid_"+i+"\" value=\"0\" ><\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"title[]\" id=\"title_"+i+"\" class=\"span8\" style=\"width:100%;margin-bottom:-1px;margin-top:3px;\" ><\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"cashtype[]\"  id=\"cashtype_"+i+"\" class=\"span8\"   style=\"width:100%;margin-bottom:-1px;margin-top:3px;\" ><\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"supplyname[]\" id=\"supplyname_"+i+"\" class=\"span8\"  style=\"width:100%;margin-bottom:-1px;margin-top:3px;\" ><\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"specs[]\"  id=\"specs_"+i+"\" class=\"span8\"  style=\"width:100%;margin-bottom:-1px;margin-top:3px;\"><\/td><td style=\"padding:0px;\"><input type=\"text\" onchange=\"getallprice("+i+")\" name=\"costprice[]\"  id=\"costprice_"+i+"\" class=\"span8\"  style=\"width:100%;margin-bottom:-1px;margin-top:3px;\"><\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"number[]\" onchange=\"getallprice2("+i+")\" id=\"number_"+i+"\" class=\"span8\"  style=\"width:100%;margin-bottom:-1px;margin-top:3px;\"><\/td><td style=\"padding:0px;\"><input type=\"text\" name=\"allprice[]\" id=\"allprice_"+i+"\" class=\"span8\" disabled style=\"width:100%;margin-bottom:-1px;margin-top:3px;\"><\/td>";
			
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
		var allprice	=	price*num;
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
		var allprice	=	price*num;
		$("#allprice_"+i).val(allprice);
	}
	function isPirce(s){
    s=s.trim();
    var p =/^[1-9](\d+(\.\d{1,2})?)?$/; 
    var p1=/^[0-9](\.\d{1,2})?$/;
    return p.test(s) || p1.test(s);
}
</script>

