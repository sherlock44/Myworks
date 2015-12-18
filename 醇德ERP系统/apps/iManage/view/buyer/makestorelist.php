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
		<a href="#"><i class="fa fa-close"></i></a>
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
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datetimepicker/datetimepicker.css">
<script src="/public/assets/sysadmin/js/plugins/datetimepicker/datetimepicker.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datetimepicker/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>采购流程
					
				</h3>				
			</div>
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("buyer/insertplan")?>'  id="login" name="login" method='post'>
					<div class="control-group" style="height:45px;background-color:white;text-align:center;padding-top:10px;">
						<?foreach($this->sysconf['purchasestatus'] as $k=>$v){?>
								<?if($k<0){continue;}?>
								<?if($re['status']==$k){?>
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
        					商品信息
					
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding" style="overflow: auto;">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					<form   class='form-horizontal form-bordered form-validate'    method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
							<th width="10%">商品名称</th>
							<th width="8%">商品编码</th>
							<th width="8%">商品条码</th>
						
							<th width="5%">采购类型</th>
							<th width="8%">供应商</th>
						
							
							
						
							<th width="6%">进价(元)</th>	
											
							<th width="5%">计划采<br>购数量</th>
					
							</tr>
        					</thead>
							
							<?if($plantag>0){?>
                            <?
                                foreach($goodsstore as $key=>$val){
                            ?>
                            <tr>
							
							<td><?=$val['title']?>
							</td>
							<td><?=$val['erpcode']?></td>
							<td><?=$val['barcode']?></td>
							<td><?=$val['cashtype']?></td>
							<td><?=$val['supplyname']?></td>
							<td>
							<?if(!empty($val['costprice']) &&$val['costprice']>0){echo $val['costprice'];}?>
							</td>
								
												
							<td><?=$val['number']?><?if(!empty($val['specs'])){echo $val['specs'];}?>
							</td>
						
							
						
							</tr>
							
                            <?
                                }
                            ?>
						
						
						
							<?}else{?>
							
							<?
                                foreach($goods as $key=>$val){
                            ?>
                            <tr>
							
							<td><?=$val['title']?>
							</td>
							<td><?=$val['erpcode']?></td>
							<td><?=$val['barcode']?></td>
							<td><?=$val['cashtype']?></td>
							<td><?=$val['supplyname']?></td>
							
							
							
						
							
							<td>
							<?if(!empty($val['costprice']) &&$val['costprice']>0){echo $val['costprice'];}?>
							</td>
												
							<td><?=$val['number']?><?if(!empty($val['specs'])){echo $val['specs'];}?>
							</td>
						
						
							
							</tr>
                            <?}?>
						
						
						
							
							<?}?>
							
        				</table>
					
						</form>		
						
        			</div>
        			</div>
        		</div>
        	</div>
        </div>














<?if(!empty($planrow) && $planrow['status']>1){?>
<div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					<?foreach($plan as $k=>$val){?>
								<a href="<?=$this->url('buyer/housestorelist',array('ordernum'=>$ordernum,'planid'=>$val['id']))?>" class="btn btn-danger" style="color:white;background:<?if($plantag==$val['id']){?>red<?}else{?>blue<?}?> none repeat scroll 0 0"><?=$val['title']?></a>&nbsp;|&nbsp;
							<?}?>
					<a href="<?=$this->url('buyer/makestorelist',array('ordernum'=>$ordernum,'planid'=>0))?>" class="btn btn-danger" style="color:white;background:<?if($plantag==0){?>red<?}else{?>blue<?}?> none repeat scroll 0 0">添加验货单</a>	
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					<form   class='form-horizontal form-bordered form-validate' id="formmoney"	action='<?=$this->url("buyer/cwpassgoods")?>'   method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
						
							<th width="10%">名称</th>
							<th width="8%">条码</th>
							<th width="4%">类型</th>
							<th width="4%">单品单位</th>
							<th width="5%">单品重量</th>
							<th width="5%">装箱量</th>
							
							<th width="6%">保质期(月)</th>
								
							<th width="5%">计划采<br>购数量</th>
							<th width="9%">实到数量</th>
							<th width="8%">总箱数</th>
							<th width="8%">保质期质</th>
							<th width="8%">破损数量</th>
							<th width="8%">短装数量</th>
							<th width="8%">溢装数量</th>
							
							</tr>
        					</thead>
							<?if($plantag>0){?>
                            <?
                                foreach($goodsstore as $key=>$val){
								$n	=	count($val['time'])?count($val['time']):1;
                            ?>
							<?foreach($val['time'] as $ke=>$ve){?>
                            <tr>
								<?if($ke==0){?>
							
							<td rowspan="<?=$n?>"><?=$val['title']?>
							<input type="hidden" name="id[]" value="<?=$val['id']?>">
							
							
							
							<input type="hidden" name="cartid[]" value="<?=$val['cartid']?>">
							</td>
							<td rowspan="<?=$n?>">
							<?if(!empty($val['barcode'])){echo $val['barcode'];}?>
							</td>
							<td rowspan="<?=$n?>"><?=$val['cashtype']?></td>
						<td rowspan="<?=$n?>">
							<?if(!empty($val['specs'])){echo $val['specs'];}?>
							</td>
							<td rowspan="<?=$n?>"><?if(!empty($val['weight']) &&$val['weight']>0){echo $val['weight'];}?>g</td>
							<td rowspan="<?=$n?>">
							<?if(!empty($val['boxnum']) &&$val['boxnum']>0){echo $val['boxnum'];}?>
							</td>
							
							<td rowspan="<?=$n?>">
							<?if(!empty($val['shelflife']) &&$val['shelflife']>0){echo $val['shelflife'];}else{echo "无";}?>
							</td>
							
								
							<td rowspan="<?=$n?>"><?=$val['number']?><?if(!empty($val['specs'])){echo $val['specs'];}?>
							</td>
							<td rowspan="<?=$n?>">
							<?echo $val['realnumber'];?><?if(!empty($val['specs'])){echo $val['specs'];}?>
							</td>
							<td  rowspan="<?=$n?>">
							<?echo $val['box'];?>
							</td>
							<?}?>
							<td>
							<?if($planrow['status']>1){ if($ve['productendtime']){echo date("Y-m-d",$ve['productendtime']);}else{echo "--";}}?>
							</td>
							<td>
							<?if($planrow['status']>1){echo $ve['puoshunnum'];}?>
							</td>
							<td>
						<?if($planrow['status']>1){echo $ve['duanzhuangnum'];}?>
							</td>
							<td>
							<?if($planrow['status']>1){echo $ve['yizhuangnum'];}?>
							</td>
							
							</tr>
							
							<?}?>
                            <?
                                }
                            ?>
							
							<?}?>
							
        				</table>
						<input type="hidden" value="<?=$re["id"]?>" name="applyid" >
						<input type="hidden" value="<?=$plantag?>" name="planid" >
						</form>		
						<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
						
						        
						
						</div>
        			</div>
        			</div>
        		</div>
        	</div>
        </div>
    
	




<?}else{?>
   <div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					<?foreach($plan as $k=>$val){?>
								<a href="<?=$this->url('buyer/makestorelist',array('ordernum'=>$ordernum,'planid'=>$val['id']))?>" class="btn btn-danger" style="color:white;background:<?if($plantag==$val['id']){?>red<?}else{?>blue<?}?> none repeat scroll 0 0"><?=$val['title']?></a>&nbsp;|&nbsp;
							<?}?>
					<a href="<?=$this->url('buyer/makestorelist',array('ordernum'=>$ordernum,'planid'=>0))?>" class="btn btn-danger" style="color:white;background:<?if($plantag==0){?>red<?}else{?>blue<?}?> none repeat scroll 0 0">添加验货单</a>		
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					<form   class='form-horizontal form-bordered form-validate' id="formmoney"	action='<?=$this->url("buyer/storelist")?>'   method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
							<th width="10%">商品名称</th>
							<th width="8%">商品编码</th>
							<th width="8%">商品条码</th>
							
						
							<th width="8%">单品重量</th>
							
							
							<th width="6%">保质期(月)</th>
							<th width="6%">进价(元)</th>	
							<th width="5%">单品单位</th>	
							<th width="5%">装箱量</th>						
							<th width="5%">计划采<br>购数量</th>
							<th width="9%">实到数量</th>
							<th width="8%">总箱数</th>
							<th width="5%">操作</th>
							</tr>
        					</thead>
							
							<?if($plantag>0){?>
                            <?
                                foreach($goodsstore as $key=>$val){
                            ?>
                            <tr>
							
							<td><?=$val['title']?>
							<input type="hidden" name="id[]" value="<?=$val['id']?>">
							<input type="hidden" name="cartid[]" value="<?=$val['cartid']?>">
							<!--input type="hidden" name="barcode[]" value="<?=$val['barcode']?>">
							<input type="hidden" name="erpcode[]" value="<?=$val['erpcode']?>"-->
							<input type="hidden" name="number[]" value="<?=$val['number']?>">
							<input type="hidden" name="supplyid[]" value="<?=$val['supplyid']?>">
							</td>
							<td>
							
							<input type="text" name="erpcode[]" class="span8" style="width:90%" value="<?if(!empty($val['erpcode'])){echo $val['erpcode'];}?>" >
							</td>
							<td>
							<input type="text" name="barcode[]" class="span8" style="width:90%" value="<?if(!empty($val['barcode'])){echo $val['barcode'];}?>" >
							</td>
					
							<td>
							<input type="text" name="weight[]"  class="span8" style="width:90%" value="<?if(!empty($val['weight']) &&$val['weight']>0){echo $val['weight'];}?>" >g
							</td>
							
							
							<td>
							<input type="text" name="shelflife[]"  class="span8" style="width:100%" value="<?if(!empty($val['shelflife']) &&$val['shelflife']>0){echo $val['shelflife'];}?>" >
							</td>
							
							<td>
							<?if(!empty($val['costprice']) &&$val['costprice']>0){echo $val['costprice'];}?>
							</td>
							<td>
							<input type="text" name="specs[]"  class="span8" style="width:100%" value="<?if(!empty($val['specs'])){echo $val['specs'];}?>" >
							</td>	
							<td>
							<input type="text" name="boxnum[]"  class="span8" style="width:100%" value="<?if(!empty($val['boxnum']) &&$val['boxnum']>0){echo $val['boxnum'];}?>" >
							</td>							
							<td><?=$val['number']?><?if(!empty($val['specs'])){echo $val['specs'];}?>
							</td>
							<td>
							<input type="text" name="realnumber[]"  class="span8" style="width:85%" value="<?if(!empty($val['realnumber']) &&$val['realnumber']>0){echo $val['realnumber'];}?>" ><?if(!empty($val['specs'])){echo $val['specs'];}?>
							</td>
							<td>
							<input type="text" name="box[]"  class="span8" style="width:100%" value="<?if(!empty($val['box']) &&$val['box']>0){echo $val['box'];}?>" >
							</td>
							<td>
							<?if(!empty($val['shelflife'])){?>
							<input type="button"  onclick="javascript:window.open('<?=$this->url("buyer/preparegoodstime",array("id"=>$val["id"]))?>','','toolbar=false,status=false,menubar=false,location=false,directions=false,width=800,height=600,scrollbars=yes')"  class="btn btn-primary" value="保质期至">
							<?}?>
							
							</td>
							</tr>
							
                            <?
                                }
                            ?>
							<tr>
							<td>供应商物流单</td>
							<td colspan="11">
							<input type="file" name="files"><a href="<?=$planrow['filepath']?>" target="_black"><?=$planrow['filetitle']?></a></td>
							</tr>
							<tr>
							<td>发货时间</td>
							<td colspan="11"><input type="text" name="sendtime" class="span2 input-medium datepick valid"  value="<?=!empty($planrow['sendtime'])?$planrow['sendtime']:''?>"></td>
							
							</tr>
							<tr>
							<td>预计到货时间</td>
							<td colspan="11"><input type="text" name="arrivetime" class="span2 input-medium datepick valid"  value="<?=!empty($planrow['arrivetime'])?$planrow['arrivetime']:''?>"></td>
							
							</tr>
							<tr>
							<td>备注</td>
							<td colspan="11"><textarea name="remark" class="span8"><?=$planrow['remark']?></textarea></td>
							</tr>
							<tr>
							<td colspan="12" style="text-align:center;">
							<input type="button" onclick="formtjmoney()" class="btn btn-primary" value="填写商品入库信息" >		
							<?if(($re['status']==6 || $re['status']==11) && $planrow["status"]==0){?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="button" onclick="javascript:pub_alert_confirm(this,'验货单已完成，等待库房核验？','<?=$this->url("buyer/storelisttj",array("id"=>$planrow["id"]))?>');"  class="btn btn-primary" value="提交验货单" >
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>	
							<?}?>
							</td>
							</tr>
							<?}else{?>
							
							<?
                                foreach($goods as $key=>$val){
                            ?>
                            <tr>
							
							<td><?=$val['title']?>
							<input type="hidden" name="cartid[]" value="<?=$val['id']?>">
							<input type="hidden" name="id[]" value="0">
							<!--input type="hidden" name="barcode[]" value="<?=$val['barcode']?>">
							<input type="hidden" name="erpcode[]" value="<?=$val['erpcode']?>"-->
							<input type="hidden" name="number[]" value="<?=$val['number']?>">
							<input type="hidden" name="supplyid[]" value="<?=$val['supplyid']?>">
							</td>
							<td>
							
							<input type="text" name="erpcode[]" id="erpcode_<?=$val['id']?>"   class="span8" style="width:90%" value="<?if(!empty($val['erpcode'])){echo $val['erpcode'];}?>" >
							</td>
							<td>
							<input type="text" name="barcode[]"  id="barcode_<?=$val['id']?>" class="span8" style="width:90%" value="<?if(!empty($val['barcode'])){echo $val['barcode'];}?>" >
							</td>
					
							<td>
							<input type="text" name="weight[]"  class="span8" style="width:90%" value="<?if(!empty($val['weight']) &&$val['weight']>0){echo $val['weight'];}?>" >g
							</td>
							
							
							<td>
							<input type="text" name="shelflife[]"  class="span8" style="width:100%" value="<?if(!empty($val['shelflife']) &&$val['shelflife']>0){echo $val['shelflife'];}?>" >
							</td>
							
							<td>
							<?if(!empty($val['costprice']) &&$val['costprice']>0){echo $val['costprice'];}?>
							</td>
							<td>
							<input type="text" name="specs[]"  class="span8" style="width:100%" value="<?if(!empty($val['specs'])){echo $val['specs'];}?>" >
							</td>	
							<td>
							<input type="text" name="boxnum[]"  class="span8" style="width:100%" value="<?if(!empty($val['boxnum']) &&$val['boxnum']>0){echo $val['boxnum'];}?>" >
							</td>							
							<td><?=$val['number']?><?if(!empty($val['specs'])){echo $val['specs'];}?>
							</td>
							<td>
							<input type="text" name="realnumber[]"  class="span8" style="width:85%" value="<?if(!empty($val['realnumber']) &&$val['realnumber']>0){echo $val['realnumber'];}?>" ><?if(!empty($val['specs'])){echo $val['specs'];}?>
							</td>
							<td>
							<input type="text" name="box[]"  class="span8" style="width:100%" value="<?if(!empty($val['box']) &&$val['box']>0){echo $val['box'];}?>" >
							</td>
							<td>
							<?if(empty($val['barcode'])){?>
							<a data-original-title="随机生成条码" rel="tooltip" class="btn btn-xs  btn-success" onclick="getbarcode(<?=$val['id']?>)" href="javascript:void(0)"><i class="icon-cloud"></i></a>
							<?}?>
								<?if(empty($val['erpcode'])){?>
							
							<a data-original-title="根据条码生成编码" rel="tooltip" class="btn btn-xs  btn-warning" onclick="geterpcode(<?=$val['id']?>)" href="javascript:void(0)"><i class="icon-signout"></i></a>
							
							<?}?>
							

							</td>
							</tr>
                            <?
                                }
                            ?>
							<tr>
							<td>供应商物流单</td>
							<td colspan="11"><input type="file" name="files"></td>
							
							</tr>
							<tr>
							<td>发货时间</td>
							<td colspan="11"><input type="text" name="sendtime" class="span2 input-medium datepick valid"  value="<?=!empty($val['sendtime'])?$val['sendtime']:''?>"></td>
							
							</tr>
							<tr>
							<td>预计到货时间</td>
							<td colspan="11"><input type="text" name="arrivetime" class="span2 input-medium datepick valid"  value="<?=!empty($val['arrivetime'])?$val['arrivetime']:''?>"></td>
							
							</tr>
							<tr>
							<td>备注</td>
							<td colspan="11"><textarea name="remark" class="span8"></textarea></td>
							</tr>
							<tr>
							<td colspan="12" style="text-align:center;">
							<input type="button" onclick="formtjmoney()" class="btn btn-primary" value="提交" >		
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>	
							</td>
							</tr>
							
							<?}?>
							
        				</table>
						<input type="hidden" value="<?=$re["id"]?>" name="applyid" >
						<input type="hidden" value="<?=$plantag?>" name="planid" >
						</form>		
						<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
						
						        
						
						</div>
        			</div>
        			</div>
        		</div>
        	</div>
        </div>
    
	<?}?>
	
    </div>
</div>
<script>
	//提交表单
	function formtjmoney(){
	
		$("#formmoney").submit();
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
//生成编码
function geterpcode(id){
	var barcode=	$("#barcode_"+id).val();

$.ajax({
			data:"id="+id+"&barcode="+barcode,
			url:"<?=$this->url('buyer/geterpcode')?>",
			dataType:"json",
			type:"post",
			success:function(r){
				
				if(r.state == 1){
						$("#erpcode_"+r.id).val(r.erpcode);
					
				  }else{
				  	
					pub_alert_error(r.info);
				  }
			
			}
		
		});

}
//生成条码
function getbarcode(id){

$.ajax({
			data:"id="+id,
			url:"<?=$this->url('buyer/getbarcode')?>",
			dataType:"json",
			type:"post",
			success:function(r){
						$("#barcode_"+r.id).val(r.barcode);
			}
		
		});

}
	
	function isPirce(s){
    s=s.trim();
    var p =/^[1-9](\d+(\.\d{1,2})?)?$/; 
    var p1=/^[0-9](\.\d{1,2})?$/;
    return p.test(s) || p1.test(s);
}
//返回列表
	function returnList(){
		window.location.href="<?=$this->url('buyer/applycaigou')?>";
	}
</script>

