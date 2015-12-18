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
							<th width="4%">采购类型</th>
						
							<th width="5%">单品重量</th>
							<th width="5%">装箱量</th>
							<th width="4%">单品单位</th>
							<th width="6%">保质期(月)</th>
								
							<th width="5%">计划采<br>购数量</th>
						
							<th width="8%">保质期质</th>
						
							<?if($planrow['status']>=3){?>
							<th width="8%">状态</th>
							<?}?>
							<!--th width="5%">操作</th-->
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
						
							</td>
							<td rowspan="<?=$n?>">
							<?=$val['erpcode']?>
							</td>
							<td rowspan="<?=$n?>">
							<?=$val['barcode']?>
							</td>
							<td rowspan="<?=$n?>"><?=$val['cashtype']?></td>
						
							<td rowspan="<?=$n?>"><?if(!empty($val['weight']) &&$val['weight']>0){echo $val['weight'];}?>g</td>
							<td rowspan="<?=$n?>">
							<?if(!empty($val['boxnum']) &&$val['boxnum']>0){echo $val['boxnum'];}?>
							</td>
							<td rowspan="<?=$n?>">
							<?if(!empty($val['specs'])){echo $val['specs'];}?>
							</td>
							<td rowspan="<?=$n?>">
							<?if(!empty($val['shelflife']) &&$val['shelflife']>0){echo $val['shelflife'];}?>
							</td>
							<td rowspan="<?=$n?>"><?=$val['number']?><?if(!empty($val['specs'])){echo $val['specs'];}?>
							</td>
							<?}?>
							<?if($planrow['status']>=3){?>
						
							<td >
							<?if($ve['productendtime']>0){echo date("Y-m-d",$ve['productendtime']);}else{echo "无保质期";}?>
							</td>
						
						
						
							<?if($ke==0){?>
							<td>
							<?if($val['cwstatus']==0){echo "财务未审核";}else if($val['cwstatus']==1){echo "待入库";}else{echo "已入库";}?>
							</td>
							<?}?>
							<?}else{?>	
						
							<td >
							<?if($ve['productendtime']>0){echo date("Y-m-d",$ve['productendtime']);}else{echo "无保质期";}?>
							</td>
						
						
							
							<?}?>
							<!--td>
							<input type="button"  onclick="javascript:window.open('<?=$this->url("buyer/preparegoodstime",array("id"=>$val["id"]))?>','','toolbar=false,status=false,menubar=false,location=false,directions=false,width=800,height=600,scrollbars=yes')"  class="btn btn-primary" value="保质期至">
							</td-->
							</tr>
							<?}?>
                            <?
                                }
                            ?>
						
						
						
					
							<?}?>
							
        				</table>
					
						</form>		
					
        			</div>
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
								<a href="<?=$this->url('buyer/housestorelist',array('ordernum'=>$ordernum,'planid'=>$val['id']))?>" class="btn btn-danger" style="color:white;background:<?if($plantag==$val['id']){?>red<?}else{?>blue<?}?> none repeat scroll 0 0"><?=$val['title']?></a>&nbsp;|&nbsp;
							<?}?>
					
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					<form   class='form-horizontal form-bordered form-validate' id="formmoney"	action='<?=$this->url("buyer/housecheck")?>'   method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
							<th width="10%">商品名称</th>
							<th width="8%">商品编码</th>
							<th width="8%">商品条码</th>

						
							<th width="4%">单品重量</th>
							<th width="4%">装箱量</th>
						
								
							<th width="5%">计划采<br>购数量</th>
							<th width="8%">实到数量</th>
							
							<th width="7%">总箱数</th>
							<th width="7%">提货费(元)</th>
							<th width="7%">操作</th>
							<th width="8%">保质期质</th>
							<th width="7%">破损数量</th>
							<th width="7%">短装数量</th>
							<th width="7%">溢装数量</th>
							<?if($planrow['status']>=3){?>
							<th width="8%">状态</th>
							<?}?>
							<!--th width="5%">操作</th-->
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
							<td rowspan="<?=$n?>"><?=$val['erpcode']?>
							</td>
							<td rowspan="<?=$n?>">
							<input type="hidden" name="barcode[]"  class="span8" style="width:100%" value="<?if(!empty($val['barcode'])){echo $val['barcode'];}?>" >
							<?if(!empty($val['barcode'])){echo $val['barcode'];}?>
							</td>
						
						
							<td rowspan="<?=$n?>"><?if(!empty($val['weight']) &&$val['weight']>0){echo $val['weight'];}?>g</td>
							<td rowspan="<?=$n?>">
							<?if(!empty($val['boxnum']) &&$val['boxnum']>0){echo $val['boxnum'];}?>
							</td>
						
							<td rowspan="<?=$n?>"><?=$val['number']?><?if(!empty($val['specs'])){echo $val['specs'];}?>
							</td>
							<?}?>
							<?if($planrow['status']>=3){?>
							<?if($ke==0){?>
							<td rowspan="<?=$n?>">
							<?echo $val['realnumber'];?><?if(!empty($val['specs'])){echo $val['specs'];}?>
							</td>
							<td rowspan="<?=$n?>">
							<?echo $val['box'];?>
							</td>
							<td rowspan="<?=$n?>">
							<?if(!empty($val['thmoney'])){echo $val['thmoney'];}?>
							</td>
							<td rowspan="<?=$n?>">
							
							<a data-original-title="选择商品库位" rel="tooltip" class="btn btn-xs  btn-success" href="<?=$this->url('buyer/selgoodspos',array('erpcode'=>$val['erpcode'],"ordernum"=>$val['ordernum']))?>"><i class="icon-cloud"></i></a>
							<?if(!empty($ve['productendtime'])){?>
							
								
								<a data-original-title="保质期至" onclick="javascript:alert('保存或修改后,需刷新当前界面!');window.open('<?=$this->url("buyer/preparegoodstime",array("id"=>$val["id"]))?>','','toolbar=false,status=false,menubar=false,location=false,directions=false,width=800,height=600,scrollbars=yes')" rel="tooltip" class="btn btn-xs  btn-warning" href="javascript:void(0)"><i class="icon-signout"></i></a>
							<?}?>
							</td>
							<?}?>
							<td >
							<?if($ve['productendtime']>0){echo date("Y-m-d",$ve['productendtime']);}else{echo "无保质期";}?>
							</td>
							<td >
							<?if($planrow['status']>1){echo $ve['puoshunnum'];}?>
							</td>
							<td >
							<?if($planrow['status']>1){echo $ve['duanzhuangnum'];}?>
							</td>
							<td>
							<?if($planrow['status']>1){echo $ve['yizhuangnum'];}?>
							</td>
							<?if($ke==0){?>
							<td>
							<?if($val['cwstatus']==0){echo "财务未审核";}else if($val['cwstatus']==1){echo "待入库";}else{echo "已入库";}?>
							</td>
							<?}?>
							<?}else{?>	
							<?if($ke==0){?>
							<td rowspan="<?=$n?>">
							<input type="text" name="realnumber[]"  class="span8" style="width:85%" value="<?echo $val['realnumber'];?>" ><?if(!empty($val['specs'])){echo $val['specs'];}?>
							</td>
							<td rowspan="<?=$n?>">
							<input type="text" name="box[]"  class="span8" style="width:100%" value="<?echo $val['box'];?>" >
							</td>
							<td rowspan="<?=$n?>">
							<input type="text" name="thmoney[]"  class="span8" style="width:100%" value="<?if(!empty($val['thmoney'])){echo $val['thmoney'];}?>" >
							</td>
							<td rowspan="<?=$n?>">
							
						
							
						
						<?if(!empty($ve['productendtime'])){?>
							
							<a data-original-title="保质期至" onclick="javascript:alert('保存或修改后,需刷新当前界面!');window.open('<?=$this->url("buyer/preparegoodstime",array("id"=>$val["id"]))?>','','toolbar=false,status=false,menubar=false,location=false,directions=false,width=800,height=600,scrollbars=yes')" rel="tooltip" class="btn btn-xs  btn-warning" href="javascript:void(0)"><i class="icon-signout"></i></a>
							<?}?>
						
							</td>
							<?}?>
							<td >
							<?if($ve['productendtime']>0){echo date("Y-m-d",$ve['productendtime']);}else{echo "无保质期";}?>
							</td>
							<td>
							<input type="hidden" value="<?=$ve['id']?>" name="timeid[]">
							<input type="text" name="puoshunnum_<?=$ve['id']?>"  class="span8" style="width:100%" value="<?if($val['realnumber']>0){echo $ve['puoshunnum'];}?>" >
							</td>
							<td>
							<input type="text" name="duanzhuangnum_<?=$ve['id']?>"  class="span8" style="width:100%" value="<?if($val['realnumber']>0){echo $ve['duanzhuangnum'];}?>" >
							</td>
							<td>
							<input type="text" name="yizhuangnum_<?=$ve['id']?>"  class="span8" style="width:100%" value="<?if($val['realnumber']>0){echo $ve['yizhuangnum'];}?>" >
							</td>
							
							<?}?>
							<!--td>
							<input type="button"  onclick="javascript:window.open('<?=$this->url("buyer/preparegoodstime",array("id"=>$val["id"]))?>','','toolbar=false,status=false,menubar=false,location=false,directions=false,width=800,height=600,scrollbars=yes')"  class="btn btn-primary" value="保质期至">
							</td-->
							</tr>
							<?}?>
                            <?
                                }
                            ?>
							<tr>
							<td>采购入库备注</td>
							<td colspan="13"><?=$planrow['remark']?></td>
							</tr>
							<?if($planrow['status']>=3){?>
							<tr>
							<td>采购申请人审核备注</td>
							<td colspan="13"><?=$planrow['applyremark']?></td>
							</tr>
							<?}?>
							<tr>
							<td>备注</td>
							<td colspan="13"><textarea name="remark" class="span8"><?=$planrow['houseremark']?></textarea></td>
							</tr>
							<tr>
							<td colspan="13" style="text-align:center;">
							<?if($planrow['status']==1){?>
							<input type="button" onclick="formtjmoney()" class="btn btn-primary" value="修改商品数量信息" >		
							<input type="button" onclick="javascript:pub_alert_confirm(this,'确认商品及其保质期验收完成，等待采购人员确认？','<?=$this->url("buyer/housecheckpass",array("applyid"=>$re["id"],'planid'=>$plantag))?>');" class="btn btn-primary" value="库房验收" >	
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="button" onclick="$('#pub_edit_bootbox_cg').removeClass('fade');$('#pub_edit_bootbox_cg').removeClass('hide');$('#pub_edit_bootbox_cg').attr('tabindex','1');"  class="btn btn-primary" value="取消采购" >		
							<?}?>
							<?if($re['status']>=9  && $planrow['status']>=3){?>
								&nbsp;&nbsp;<input type="button" class="btn btn-primary" value="入库" onclick="javascript:pub_alert_confirm(this,'确认入库？','<?=$this->url("buyer/caiwuinstore",array("applyid"=>$re["id"],'planid'=>$plantag))?>');$(this).val('入库中..');$(this).attr('disabled', true);">	
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="button" onclick="$('#pub_edit_bootbox_cg').removeClass('fade');$('#pub_edit_bootbox_cg').removeClass('hide');$('#pub_edit_bootbox_cg').attr('tabindex','1');"  class="btn btn-primary" value="取消采购" >
							<?}?>
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
    
	
	
    </div>
</div>


<!--取消采购 开始 -->


<div id="pub_edit_bootbox_cg" class="modal  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hidecengcg()">×</button>
        <h3 id="myModalLabel">描述</h3>
        <div class="modal-body">
			<div class="control-group">
						
						<div class="controls">
							<textarea id="caigouremark" class="span8"></textarea>
							
						</div>
			</div>
				<div class="form-actions">
					
					<input type="button" onclick="cancelcg()" class="btn btn-primary" value="确认通过" class="btn ">
				
					<button class="btn" type="button" data-dismiss="modal" onclick="hidecengcg()">取消</button>
				</div>
		</div>
    </div>
</div>
</div>
<script>
	function cancelcg(){
		var applyid	=	'<?=$re['id']?>';
		var status	=	'<?=$re['status']?>';
		
		var remark	=	$("#caigouremark").val();
		
		//pub_alert_success("选择采购责任人");
		//if(cgzrrid==0){pub_alert_error("选择采购责任人");return false;}
		$.ajax({
			data:{applyid:applyid,remark:remark,status:status},
		    url:"<?=$this->url('buyer/canselapply')?>",
			dataType:"json",
			type:"post",
			success:function(data){
				if(data.state==1){
					//pub_alert_success(data.info,1);
					location.reload();
				}else{
					pub_alert_error(data.info);
				}
			
			}
		});
	}
</script>

<!--取消采购 结束 -->
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

	
	function isPirce(s){
    s=s.trim();
    var p =/^[1-9](\d+(\.\d{1,2})?)?$/; 
    var p1=/^[0-9](\.\d{1,2})?$/;
    return p.test(s) || p1.test(s);
}
//返回列表
	function returnList(){
		window.location.href="<?=$this->url('buyer/applyhouse')?>";
	}
	function hidecengcg(){
		$('#pub_edit_bootbox_cg').addClass('fade');$('#pub_edit_bootbox_cg').addClass('hide');$('#pub_edit_bootbox_cg').attr('tabindex','-1');
	
	}
</script>

