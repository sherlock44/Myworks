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
			<a href="">详情</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="fa fa-close"></i></a>
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
        			<div class="box-content nopadding" style="overflow: auto;">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        						<tr>
							
							<th >商品名称</th>
							<th >商品条码</th>
							<th >采购类型</th>
							<th >供应商</th>
							
							
							
							<th >进价(元)</th>
							<?if($re['status']>=11){?>
							<th >售价(元)</th>
							<th >临期价(元)</th>
							<?}?>
							<th >单品单位</th>				
													
							
							<th >数量</th>
						
						
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
					<form   class='form-horizontal form-bordered form-validate'	action=''   method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
							<th width="3%">序号</th>
							<th >合作商</th>
							<th >提交人</th>
							<th >提交时间</th>
							<th >合同名称</th>
							<th >验货标准</th>
							<?if($re['status']>=6 || $re['status']==-2){?>
							<th >是否支付定金</th>
							<th >定金额度</th>
							
							<?}?>
							<?if($re['status']>=8  || $re['status']==-2){?>
							<th >库房验收结果</th>
							<?}?>
							
							<?if($re['status']>=10){?>
							<th >尾款</th>
							<?}?>
							<th >操作</th>
							
							
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
					<i class="icon-user"></i>采购信息
				</h3>
			</div>
			<div class="box-content nopadding">
				<?$url	=$this->url("buyer/updateapply");	?>
				<?if($re['status']==1){$url	=$this->url("buyer/changestatus1");	}?>
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$url?>'  id="formtjs" name="formtj" method='post'>
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
							<textarea cols="700" rows="18" name="remark" class="span12"><?=!empty($re) ? $re['remark']: ''?></textarea>
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
							<?=$this->sysconf['purchasestatus'][$re['status']]?>
						</div>
					</div>
					
					
					<?if($re['status']==1){?>
					<div class="control-group">
						<label for="mobile" class="control-label">备注</label>
						<div class="controls">
							<textarea name="data[remark]" class="span8"></textarea>
						</div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">审核结果</label>
						<div class="controls">
							<select name="data[results]">
							<option value="1">通过</option>
							<option value="-1">取消采购</option>
							</select>
						</div>
					</div>	
					<div class="form-actions">
					<input type="button"  onclick='buttonformtj()'  class="btn btn-primary" value="提交">				
					<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>					
					</div>
				<?}?>
						
						<input type="hidden" value="<?=!empty($re)?$re['id']:''?>" name="id">
						
					
				<?}?>
						
				</form>
			
				
				
				
				
				
			</div>
		</div>
	</div>
</div>




<?if($log){?>
 <div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					采购操作记录
        				</h3>
                        <div class="actions">
        					<a rel="tooltip"  href="javascript:void(0)" id="logtag" onclick="javascript:if($('#logcontent')[0].style.display=='none'){$('#logcontent').show();$('#logtag').html('-');}else{$('#logcontent').hide();$('#logtag').html('+');}"  class="btn btn-danger">+</a>
        				</div>
        			</div>
        			<div class="box-content nopadding" id="logcontent" style="display:none;">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
							
							<th >序号</th>
							<th >审核人</th>
							
							
							
							<th >审核</th>
														
							<th >描术</th>							
							
							<th >审核时间</th>
						
							
					
						
						</tr>
        					</thead>
							
                            <?
                              foreach($log as $ks=>$value){
                            ?>
                            <tr>
							<td><?=$ks+1?></td>
							<td><?=$value['truename']?></td>
							<td><?=$value['results']?></td>
							<td><?=$value['remark']?></td>	
							<td><?=date("Y-m-d H:i:s",$value['created'])?></td>					
							</tr>
                            <?
                                }
                            ?>
        				</table>
						
        			</div>
        			</div>
        		</div>
        	</div>
        </div>


<?}?>

</div>
</div>
<script>
	function buttonformtj(){
		if(confirm("确认提交？")){
			$("#formtjs").submit();
		}
	}
//返回列表
	function returnList(){
		window.location.href="<?=$this->url('buyer/apply')?>";
	}

</script>






<script>


	function hideceng(){
		$('#pub_edit_bootbox').addClass('fade');$('#pub_edit_bootbox').addClass('hide');$('#pub_edit_bootbox').attr('tabindex','-1');
	
	}

</script>