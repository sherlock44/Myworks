	<div id="main">
			<div class="container-fluid nopadding">


<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/dynatree/ui.dynatree.css">
<script src="/public/assets/sysadmin/js/jquery.cookie.js"></script>
<script src="/public/assets/sysadmin/js/plugins/dynatree/jquery.dynatree.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/js/plugins/poshytip/tip-darkgray/tip-darkgray.css">
<script src="/public/assets/sysadmin/js/plugins/poshytip/jquery.poshytip.min.js"></script>

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
			<a href="">编辑采购管理</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>

<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>采购流程
				</h3>				
			</div>
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("newcash/insertplan")?>'  id="login" name="login" method='post'>
					<div class="control-group" style="height:45px;background-color:white;text-align:center;padding-top:10px;">
						<?foreach($sysconf['purchasestatus'] as $k=>$v){?>
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
	

	<?if($re['status']>=4){?>
<div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					采购商品列表
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        						<tr>
							
							<th width="15%">商品名称</th>
							<th width="10%">商品编号</th>
							<th width="5%">采购类型</th>
							<th width="10%">供应商</th>
							
							
							
							<th width="5%">进价(元)</th>
							<?if($re['status']>=11){?>
							<th width="5%">售价(元)</th>
							<th width="5%">临期价(元)</th>
							<?}?>
							<th width="5%">规格</th>				
													
							
							<th width="5%">数量</th>
						
						
						</tr>
        					</thead>
                            <?
                                foreach($goods as $key=>$value){
                            ?>
                            <tr>
							
							<td><?=$value['title']?></td>
							<td><?=$value['barcode']?></td>
							<td><?=$value['cashtype']?></td>
							<td><?=$value['supplyname']?></td>
							<td><?=$value['costprice']?></td>	
							<?if($re['status']>=11){?>
							<td><?=$value['saleprice']?></td>
							<td><?=$value['futureprice']?></td>
							<?}?>
							<td><?=$value['specs']?></td>
							
							<td>
						<?=$value['number']?>
							</td>
							
							</tr>
                            <?
                                }
                            ?>
        				</table>
						<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
						
						        
						
						</div>
        			</div>
        			</div>
        		</div>
        	</div>
        </div>
    
	

	<?}?>
	
	
	<?if($contract){?>
	<div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					合同列表
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					<form  id="formtj" class='form-horizontal form-bordered form-validate'	action=''   method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
							<th width="3%">序号</th>
							<th width="15%">合作商</th>
							<th width="5%">提交人</th>
							<th width="10%">提交时间</th>
							<th width="10%">合同名称</th>
							<th width="15%">验货标准</th>
							<?if($re['status']>=6 || $re['status']==-2){?>
							<th width="5%">是否支付定金</th>
							<th width="5%">定金额度</th>
							
							<?}?>
							<?if($re['status']>=8  || $re['status']==-2){?>
							<th width="5%">库房验收结果</th>
							<?}?>
							
							<?if($re['status']>=10){?>
							<th width="5%">尾款</th>
							<?}?>
							<th width="5%">操作</th>
							
							
							</tr>
        					</thead>
							
							<?foreach($contract as $k=>$val){?>
							
							<tr>
							<td><?=($k+1)?></td>
							<td><?=$val['supplyname']?></td>		
							<td><?=$val['truename']?></td>		
							<td><?if(!empty($val['created'])){?><?=date("Y-m-d",$val['created'])?><?}?></td>	
							<td><?=$val['contracttitle']?></td>		
							<td><?=$val['remark']?></td>	
							<?if($re['status']>=6  || $re['status']==-2){?>	
							<td><?=empty($val['isdep'])?"否":"是"?></td>		
							<td><?=$val['depnum']?></td>	
								
							<?}?>
							<?if($re['status']>=8 || $re['status']==-2){?>	
							
							<td><?if($val['isproblem']==1){echo "通过";}else if($val['isproblem']==0){echo "已重新调整合同";}else if($val['isproblem']==-1){echo "退回";}?></td>	
							<?}?>
							<?if($re['status']>=10){?>	
								
							<td><?=$val['tailmoney']?></td>	
								
							<?}?>							
							<td><a href="<?=$val['contractpath']?>" >点击下载</a></td>		
						
							</tr>		
							
							
							<?}?>
							
        				</table>
						
						</form>		
					
        			</div>
        			</div>
        		</div>
        	</div>
        </div>
    
	
	
	
	
	<?}?>

<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>基本信息
				</h3>
			</div>
			<div class="box-content nopadding">
			
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("newcash/updateapply")?>'  id="login" name="login" method='post'>
				<?if($re['status']==0 && $re['memberid']==$this->info['id']){?>
					<div class="control-group">
						<label for="mobile" class="control-label">名称</label>
						<div class="controls">
							<input type="text" name="data[title]" id="title" value="<?=$re['title']?>"  class="input-xlarge" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
							
						</div>
					</div>
					
					<div class="control-group">
						<label for="mobile" class="control-label">审批人</label>
						<div class="controls">
							
							<select name='data[zgid]'  >
							<?foreach($admin as $val){?>
							<option value="<?=$val['id']?>" <?if($val['id']==$re['zgid']){echo "selected";}?> ><?=$val['name']?></option>
							<?}?>
							</select>
							
						</div>
					</div>
	
				
					<div class="control-group">
						<label for="number" class="control-label">描述</label>
						<div class="controls">
							<textarea  name="remark" class="span12"><?=!empty($re) ? $re['remark']: ''?></textarea>
							(商品信息，数量，目的)
						</div>
						
					</div>
					<div class="control-group">
						<label for="number" class="control-label">当前状态</label>
						<div class="controls">
							
							<select name='data[status]'>
							
							<option value="0">草稿</option>
							<option value="1">审批人审核</option>
							
							</select>
							
						</div>
						
					</div>
						<input type="hidden" value="<?=!empty($re)?$re['id']:''?>" name="id">
						<div class="form-actions">
						
						<input type="submit" class="btn btn-primary" value="修改" >		
										
						<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>					
						
						</div>
						
				<?}else{?>
				<!--其他流程-->
				
					
					
					<div class="control-group">
						<label for="mobile" class="control-label">名称</label>
						<div class="controls">
							<?=$re['title']?>
						</div>
					</div>
					
				
				
				
					<div class="control-group">
						<label for="number" class="control-label">描述</label>
						<div class="controls">
							<?=!empty($re) ? $re['remark']: ''?>
						</div>
						
					</div>
				
					<div class="control-group">
						<label for="number" class="control-label">当前状态</label>
						<div class="controls">
							<?=$sysconf['purchasestatus'][$re['status']]?>
						</div>
					</div>
					<div class="control-group">
						<label for="number" class="control-label">操作说明</label>
						<div class="controls">
							申请人：<?=$otherapply['truename']?>,时间:<?=date("Y-m-d H:i:s",$otherapply['created'])?><hr style="margin:0;"/>
							<?if($re['status']>=2 || $re['status']==-2){?>
							申批人：<?=$otherapply['truename1']?>,时间:<?=date("Y-m-d H:i:s",$otherapply['created1'])?><hr style="margin:0;"/>
							<?}?>
							<?if($re['status']>=3 || $re['status']==-2){?>
							采购总方案提交人：<?=$otherapply['truename2']?>,时间:<?=date("Y-m-d H:i:s",$otherapply['created2'])?><hr style="margin:0;"/>
							<?}?>
							<?if($re['status']>=4 || $re['status']==-2){?>
							采购方案确认人员：<?=$otherapply['truename3']?>,时间:<?=date("Y-m-d H:i:s",$otherapply['created3'])?><hr style="margin:0;"/>
							<?}?>
							<?if($re['status']>=5 || $re['status']==-2){?>
							合同提交人员：<?=$otherapply['truename4']?>,时间:<?=date("Y-m-d H:i:s",$otherapply['created4'])?><hr style="margin:0;"/>
							<?}?>
							<?if($re['status']>=6 || $re['status']==-2){?>
							合同审核人员：<?=$otherapply['truename5']?>,时间:<?=date("Y-m-d H:i:s",$otherapply['created5'])?><hr style="margin:0;"/>
							<?}?>
							<?if($re['status']>=7 || $re['status']==-2){?>
							财务信息录入人员：<?=$otherapply['truename6']?>,时间:<?=date("Y-m-d H:i:s",$otherapply['created6'])?><hr style="margin:0;"/>
							<?}?>
							<?if($re['status']>=8 || $re['status']==-2){?>
							库房验收人员：<?=$otherapply['truename7']?>,时间:<?=date("Y-m-d H:i:s",$otherapply['created7'])?><hr style="margin:0;"/>
							<?}?>
							<?if($re['status']>=9){?>
							采购执行人：<?=$otherapply['truename8']?>,时间:<?=date("Y-m-d H:i:s",$otherapply['created8'])?><hr style="margin:0;"/>
							<?}?>
							<?if($re['status']>=10){?>
							财务：<?=$otherapply['truename9']?>,时间:<?=date("Y-m-d H:i:s",$otherapply['created9'])?><hr style="margin:0;"/>
							<?}?>
							<?if($re['status']>=11){?>
							核价人员：<?=$otherapply['truename10']?>,时间:<?=date("Y-m-d H:i:s",$otherapply['created10'])?><hr style="margin:0;"/>
							<?}?>
						</div>
					</div>
						<input type="hidden" value="<?=!empty($re)?$re['id']:''?>" name="id">
						<div class="form-actions">
						<?if($re['status']==3){?>
						<input type="button" onclick="javascript:window.location.href='<?=$this->url("newcash/plan",array("id"=>$re["id"]))?>'" class="btn btn-primary" value="<?=$sysconf['purchasestatus'][$re['status']]?>" class="btn ">
						<?}else if($re['status']==1){?>
						<input type="button" onclick="javascript:pub_alert_confirm(this,'确认审批通过，采购部门执行采购计划','<?=$this->url("newcash/changestatus1",array("id"=>$re["id"]))?>');"  class="btn btn-primary" value="<?=$sysconf['purchasestatus'][$re['status']]?>" >
						<?}else if($re['status']==2){?>
						<input type="button" onclick="javascript:window.location.href='<?=$this->url("newcash/plan",array("id"=>$re["id"]))?>'" class="btn btn-primary" value="<?=$sysconf['purchasestatus'][$re['status']]?>" class="btn ">
						
						<?}else if($re['status']==-2){?>
						
						<?}else if($re['status']==4){?>
						
						<input type="button" onclick="javascript:window.location.href='<?=$this->url("newcash/addContract",array("applyid"=>$re["id"]))?>'" class="btn btn-primary" value="<?=$sysconf['purchasestatus'][$re['status']]?>" class="btn ">
						
						
						<?}else if($re['status']==5){?>
						<input type="button" onclick="javascript:pub_alert_confirm(this,'确认合同无误，开始财务信息录入？','<?=$this->url("newcash/contractsure",array("id"=>$re["id"]))?>');"  class="btn btn-primary" value="<?=$sysconf['purchasestatus'][$re['status']]?>" >
						
						<?}else if($re['status']==6){?>
						<input type="button" onclick="javascript:window.location.href='<?=$this->url("newcash/financeinfo",array("id"=>$re["id"]))?>'" class="btn btn-primary" value="<?=$sysconf['purchasestatus'][$re['status']]?>" class="btn ">
						<?}else if($re['status']==7){?>
						<input type="button" onclick="javascript:window.location.href='<?=$this->url("newcash/storeinfo",array("id"=>$re["id"]))?>'" class="btn btn-primary" value="<?=$sysconf['purchasestatus'][$re['status']]?>" class="btn ">
						<?}else if($re['status']==8){?>
						<input type="button" onclick="javascript:pub_alert_confirm(this,'采购执行确认，通知财务付尾款？','<?=$this->url("newcash/applychangestatus8",array("id"=>$re["id"]))?>');"  class="btn btn-primary" value="<?=$sysconf['purchasestatus'][$re['status']]?>" >
						<?}else if($re['status']==9){?>
						
						<input type="button" onclick="javascript:window.location.href='<?=$this->url("newcash/paytail",array("id"=>$re["id"]))?>'" class="btn btn-primary" value="<?=$sysconf['purchasestatus'][$re['status']]?>" class="btn ">
						<?}else if($re['status']==10){?>
						
						<input type="button" onclick="javascript:window.location.href='<?=$this->url("newcash/checkgoodsprice",array("id"=>$re["id"]))?>'" class="btn btn-primary" value="<?=$sysconf['purchasestatus'][$re['status']]?>" class="btn ">
						<?}else if($re['status']==11){?>
						<input type="button" onclick="javascript:pub_alert_confirm(this,'确认商品已入库?','<?=$this->url("newcash/applyover",array("id"=>$re["id"]))?>');"  class="btn btn-primary" value="<?=$sysconf['purchasestatus'][$re['status']]?>" >
						
						<?}else{?>
						<input type="button" onclick="$('#pub_edit_bootbox').removeClass('fade');$('#pub_edit_bootbox').removeClass('hide');$('#pub_edit_bootbox').attr('tabindex','1');"  class="btn btn-primary" value="<?=$sysconf['purchasestatus'][$re['status']]?>" >
						
						<?}?>
						<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>					
						
						</div>
					
				<?}?>
						
				</form>
			
				
				
				
				
				
			</div>
		</div>
	</div>
</div>
</div>
</div>
<script>
//返回列表
	function returnList(){
		window.location.href="<?=$this->url('newcash/apply')?>";
	}

</script>






<!--主管采购审核 开始 -->
<?if($re['status']==11){?>

<div id="pub_edit_bootbox" class="modal  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
        <h3 id="myModalLabel">主管采购审核</h3>
        <div class="modal-body">
			<div class="control-group">
						
						<div class="controls">
							<select id="cgzrr" >
							<option value='0'>选择采购责任人</option>
							<?foreach($admin as $val){?>
							<option value="<?=$val['id']?>" ><?=$val['name']?></option>
							<?}?>
							</select>
							
						</div>
			</div>
				<div class="form-actions">
					
					<input type="button" onclick="checkcg(<?=$re['id']?>)" class="btn btn-primary" value="确认通过" class="btn ">
				
					<button class="btn" type="button" data-dismiss="modal" onclick="hideceng()">取消</button>
				</div>
		</div>
    </div>
</div>
</div>
<script>
	function checkcg(id){
		var cgzrrid	=	$("#cgzrr").val();
		//pub_alert_success("选择采购责任人");
		if(cgzrrid==0){pub_alert_error("选择采购责任人");return false;}
		$.ajax({
			data:{cgzrrid:cgzrrid,id:id},
		    url:"<?=$this->url('newcash/cgfzrcheck')?>",
			dataType:"json",
			type:"post",
			success:function(data){
				if(data.status==1){
					//pub_alert_success(data.info,1);
					location.reload();
				}else{
					pub_alert_error(data.info);
				}
			
			}
		});
	}
</script>
<?}?>
<!--主管采购审核 结束 -->




<!-- 库房验收 开始 -->
<?if($re['status']==7){?>
<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("newcash/storecheck")?>'  id="acceptancecheck" name="acceptancecheck" method='post'>
<div id="pub_edit_bootbox" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
        <h3 id="myModalLabel">库房验收</h3>
        <div class="modal-body">
			<div class="control-group">
						<label for="number" class="control-label">验收结果<br>
						
						</label>
						<div class="controls">
						
							<select id="acceptance" name="acceptance" onchange="checkresult(this.value)" >
							<option value="2" >通过</option>
							<option value='1'>有问题</option>
							
							
							</select>
							
						</div>
			</div>
			
						<div class="control-group checkno"  style="display:none;">
						<label for="number" class="control-label">是否退回<br>
						
						</label>
						<div class="controls">
							<select id="isback" name="isback"  onchange="checksec(this.value)">
						
							<option value='1'>退回</option>
							<option value='2'>不退回</option>
							
							</select>
						</div>
						</div>
			
						<div class="control-group checknono"  style="display:none;">
						<label for="number" class="control-label">合同调整<br>
						
						</label>
						<div class="controls">
							<input type="file" class="input-block-level" id="file" name="files">
						</div>
						</div>
						<div class="control-group checknono"  style="display:none;">
						<label for="number" class="control-label">调整合同金额<br>
						
						</label>
						<div class="controls">
								<input name="price" id="allprice" value="" class="span3" type="text">元
						</div>
				</div>
			
				<div class="form-actions">		
					<input type="hidden" name="applyid" value="<?=$re['id']?>">
					<input type="button" onclick="checkcg(<?=$re['id']?>)"  class="btn btn-primary" value="确认通过" class="btn ">
					<button class="btn" type="button" data-dismiss="modal" onclick="hideceng()">取消</button>
				</div>
		</div>
    </div>
</div>
</div>
</form>
<script>
	function checkcg(id){
		$("#acceptancecheck").submit();return false;
	}
	function checkresult(val){
		if(val==2){
			$(".checkno,.checknono").css("display","none");
		}else{
			$(".checkno").css("display","block");
		}
	}
	function checksec(val){
		if(val==1){
			$(".checknono").css("display","none");
		}else{
			$(".checknono").css("display","block");
		}
	
	}
	
</script>
<?}?>
<!-- 制定采购单 结束 -->

<script>
	function hideceng(){
		$('#pub_edit_bootbox').addClass('fade');$('#pub_edit_bootbox').addClass('hide');$('#pub_edit_bootbox').attr('tabindex','-1');
	
	}

</script>