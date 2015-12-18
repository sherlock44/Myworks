	<div id="main">
			<div class="container-fluid nopadding">


<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script>
<script src="/public/assets/sysadmin/js/jquery.cookie.js"></script>
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

<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>基本信息
				</h3>
			</div>
			<div class="box-content nopadding">
				<?$url	=$this->url("buyer/updateapply");	?>
				<?if($re['status']==1){$url	=$this->url("buyer/changestatus1");	}?>
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$url?>'  id="formtj" name="formtj" method='post'>
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
						<label for="number" class="control-label">采购申请人</label>
						<div class="controls">
							<?=!empty($re) ? $re['cgname']: ''?>
						</div>
					</div>
					<div class="control-group">
						<label for="number" class="control-label">采购审批人</label>
						<div class="controls">
							<?=!empty($re) ? $re['zgname']: ''?>
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

			<?if($plan){?>
<div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					入库计划
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding" style="overflow: auto;">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					<form   class='form-horizontal form-bordered form-validate' id="formmoney"	action='<?=$this->url("buyer/storelist")?>'   method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
							<th >日期</th>
							<th >操作人员</th>
							<th width="25%">备注</th>
							<th >状态</th>			
							<th >操作</th>
							
							</tr>
        					</thead>
                            <?
                                foreach($plan as $key=>$val){
                            ?>
                            <tr>
							
							<td><?=date("Y-m-d",$val['created'])?></td>
							<td><?=$val['truename']?></td>
							<td><?=$val['remark']?></td>
							<td><?=$this->sysconf['purchasestorestatus'][$val['status']]?></td>
							
							
							
								
							<td>
							<input type="button" onclick="javascript:window.location.href='<?=$this->url("buyer/caiwustorelist",array("ordernum"=>$re["ordernum"],'planid'=>$val['id']))?>'" class="btn btn-primary" value="查看" class="btn ">
							
							
							
							
							</td>
							
							
							</tr>
                            <?
                                }
                            ?>
							<tr>
							
        				</table>
						<input type="hidden" value="<?=$re["id"]?>" name="applyid" >
						</form>		
						<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
						
						        
						
						</div>
        			</div>
        			</div>
        		</div>
        	</div>
        </div>
    
	

	<?}?>
	

	
	
	
	


	<?if(!empty($goods)){?>
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
						<form   class='form-horizontal form-bordered form-validate' id="formtjcheck"	action='<?=$this->url("buyer/caiwucheckprice")?>'   method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        						<tr>
							<?$colspan=6;?>
							<th >商品名称</th>
						
							<th width="2%">商品条码</th>
							<th >采购类型</th>
							<th >供应商</th>
										
							<th >数量</th>
							<th width="7%">采购单价(元)</th>
							<?if($re['status']>=19){?>
							<?$colspan=8;?>
							<th width="7%">运费(元)</th>
							<th width="7%">成本价(元)</th>
							<?}?>
						
						</tr>
        					</thead>
                            <?
								$sallnum=0;
								$danjie=0;
								$yunfei=0;
								$chengbuprice=0;
                                foreach($goods as $key=>$value){
								$sallnum+=$value['number'];
								$danjie+=$value['costprice'];
								$yunfei+=$value['yunfei'];
								$chengbuprice+=$value['chengbuprice'];
                            ?>
                            <tr>
							
							<td><?=$value['title']?>
							<input type="hidden" name="id[]"  value="<?=$value['id']?>" >
							</td>
							
							<td><?=$value['barcode']?></td>
							<td><?=$value['cashtype']?></td>
							<td><?=$value['supplyname']?></td>
							
							<td><?=$value['number']?>/<?=$value['specs']?></td>
							<td><?=$value['costprice']?></td>
							<?if($value['tag']==0 && false){?>
								<?if(empty($value['result'])){?>
								<?if($re['status']==9){?>
								<td><input type="text" name="costprice[]"  class="span8" style="width:100%" value="<?=$value['costprice']?>" ></td>
								<td><input type="text" name="yunfei[]"  class="span8" style="width:100%" value="<?=$value['yunfei']?>" ></td>
									<td><input type="text" name="chengbuprice[]"  class="span8" style="width:100%" value="<?if($value['chengbuprice']>0){echo $value['chengbuprice'];}?>" ></td>
								<?}else if($re['status']>9){?>
									<td><?=$value['costprice']?></td>
									<td><?=$value['yunfei']?></td>
									<td><?if($value['chengbuprice']>0){echo $value['chengbuprice'];}?></td>
								<?}else{?>	
								<td><?=$value['costprice']?></td>
								<?}?>
								
								<?}else{?>
								<?if($re['status']==9){?>
								<td><input type="text" name="costprice[]"  class="span8" style="width:100%" value="<?if(!empty($value['costprice'])){echo $value['costprice'];}?>" ></td>
								<td><input type="text" name="yunfei[]"  class="span8" style="width:100%" value="<?=$value['yunfei']?>" ></td>
								<td><input type="text" name="chengbuprice[]"  class="span8" style="width:100%" value="" ></td>
								<?}else if($re['status']>9){?>
								<td><?=$value['costprice']?></td>
									<td><?=$value['yunfei']?></td>
									<td><?if($value['chengbuprice']>0){echo $value['chengbuprice'];}?></td>
								<?}else{?>	
								<td><?=$value['costprice']?></td>
								<?}?>
								
									
								<?}?>
								
							<?}else if(false){?>
							<?if($re['status']==9){?>
							<td><input type="text" name="costprice[]"  class="span8" style="width:100%" value="<?=$value['costprice']?>" ></td>
							<td><input type="text" name="yunfei[]"  class="span8" style="width:100%" value="<?=$value['yunfei']?>" ></td>
									<td><input type="text" name="chengbuprice[]"  class="span8" style="width:100%" value="<?=$value['chengbuprice']?>" ></td>
							<?}else if($re['status']>9){?>
							<td><?=$value['costprice']?></td>
							<td><?=$value['yunfei']?></td>
							<td><?=$value['chengbuprice']?></td>
							<?}else{?>	
							
							<?}?>
									
								
							
							
							
							<?}?>
						
						
						
							

							
							</tr>
                            <?
                                }
                            ?>
							<tr>
							
							<td >合计</td>
						
							<td width="2%"></td>
							<td ></td>
							<td ></td>
										
							<td ><?=$sallnum?></td>
							<td width="7%"><?=$danjie?>元</td>
							<?if($re['status']>=19){?>
							
							<td width="7%"><?=$yunfei?></td>
							<td width="7%"><?=$chengbuprice?>元</td>
							<?}?>
						
						</tr>
							<?if($re['status']==9 && false){?>
							<tr>
							<td>备注</td>
							<td colspan="<?=$colspan-1?>"><textarea name="remark" class="span8"></textarea></td>
							</tr>
							<tr>
							<td colspan="<?=$colspan?>" style="text-align:center;">
							<input type="button" onclick="formtjcheck()" class="btn btn-primary" value="财务核价" >		
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="button" onclick="$('#pub_edit_bootbox_cg').removeClass('fade');$('#pub_edit_bootbox_cg').removeClass('hide');$('#pub_edit_bootbox_cg').attr('tabindex','1');"  class="btn btn-primary" value="取消采购" >
							</td>
							</tr>
							<?}?>
        				</table>
						<input type="hidden" value="<?=$id?>" name="applyid" >
						
						</form>	
						<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
						
						        
						
						</div>
        			</div>
        			</div>
        		</div>
        	</div>
        </div>
    
	<?}?>

	

	
	
		<?if($contract){?>
		<?$val	=	$contract[0];?>
<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>合同信息
				</h3>
			</div>
			<div class="box-content nopadding">
				
				
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("buyer/financeinfoupdate")?>'  id="formmoneymore" name="formtj" method='post'>
				
				
					
					
					<div class="control-group">
						<label for="mobile" class="control-label">合同信息</label>
						<div class="controls">
							<a href="<?=$val['contractpath']?>"  title="点击查看" target="_black" ><?=$val['contracttitle']?></a>&nbsp;&nbsp;&nbsp;<?=!empty($val) ? $val['truename']: ''?>&nbsp;&nbsp;于<?if(!empty($val['created'])){?><?=date("Y-m-d H:i:s",$val['created'])?><?}?>&nbsp;&nbsp;提交
						</div>
					</div>
					
				
				
				
					<div class="control-group">
						<label for="number" class="control-label">描述</label>
						<div class="controls">
							<?=!empty($val) ? $val['remark']: ''?>
						</div>
						
					</div>
				
					
					<div class="control-group">
						<label for="number" class="control-label">总金额</label>
						<div class="controls">
							<input type="text" name="allprice[]" id="allprice_<?=$val['id']?>" class="" value="<?if(!empty($val['allprice']) &&$val['allprice']>0){echo $val['allprice'];}?>" onchange="getendmoney(<?=$val['id']?>)">元
						</div>
					</div>
					<div class="control-group">
						<label for="number" class="control-label">预付款</label>
						<div class="controls">
							<input type="text" name="depnum[]" id="depnum_<?=$val['id']?>" class=""  value="<?if(!empty($val['depnum']) &&$val['depnum']>0){echo $val['depnum'];}?>" onchange="getendmoney(<?=$val['id']?>)">
							<input type="hidden" name="endmoney[]" id="inputendmoney_<?=$val['id']?>"  value="<?if(!empty($val['endmoney']) &&$val['endmoney']>0){echo $val['endmoney'];}?>">元
						</div>
					</div>
					
				<div class="control-group">
						<label for="number" class="control-label">预付款时间</label>
						<div class="controls">
							<input type="text" name="deptime[]" class="span2 input-medium datepick valid"   value="<?=!empty($val['deptime'])?date("Y-m-d"):''?>">
						</div>
				</div>
				<div class="control-group">
						<label for="number" class="control-label">未付款</label>
						<div class="controls">
							<span id="endmoney_<?=$val['id']?>"><?if(!empty($val['endmoney']) &&$val['endmoney']>0){echo $val['endmoney'];}?></span>元
						</div>
						
					</div>
					<div class="control-group">
						<label for="number" class="control-label">付尾款时间</label>
						<div class="controls">
							<input type="text" name="endpaytime[]" class="span2 input-medium datepick valid"   value="<?=!empty($val['endpaytime'])?date("Y-m-d"):''?>">
							<input type="hidden" name="id[]" value="<?=$val['id']?>"> 
						</div>
						
					</div>
				<div class="control-group">
						<label for="number" class="control-label">备注</label>
						<div class="controls">
							<textarea name="remark" class="span8"><?=!empty($val) ? $val['cwremark']: ''?></textarea>
						</div>
						<input type="hidden" id="hetongid" value="<?=$val['id']?>">
					</div>
				<div class="control-group">
						<label for="number" class="control-label">付款记录</label>
						<div class="controls">
							
						<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
							<th >付款金额(元)</th>
							<th >银行账号</th>
							<th >支付时间</th>						
							<th >付款方式</th>							
							<th >备注</th>
							<th >操作</th>
							</tr>
        					</thead>
							
                           <?$k=0;?>
							<?foreach($paylog as $k=>$val){?>
                            <tr>
							<?if($val['created']==0){$created=$val['created'];}else{$created=date("Y-m-d",$val['created']);}?>
										<td style="font-size:12px;border:#666666 solid 1px;">
										<input type="text"  id="paymoney_<?=$val['id']?>" value="<?=$val['paymoney']?>" style="width:100px;"  />
										</td>
										<td style="font-size:12px;border:#666666 solid 1px;">
										<input type="text"  value="<?=$val['banknum']?>" id="banknum_<?=$val['id']?>"/>
										</td>
										<td style="font-size:12px;border:#666666 solid 1px;">
										<input id="paytime_<?=$val['id']?>" type="text"   class=" input-medium datepick valid" value="<?=empty($val['paytime'])?'':date("Y-m-d",$val['paytime'])?>"/>
										</td>	
										<td style="font-size:12px;border:#666666 solid 1px;">
										
										<select id="paytype_<?=$val['id']?>" style="width:100px;"   ><?foreach($paytype as $v){?><option value="<?=$v['id']?>" <?=$val['paytype']==$v['id']?'selected':''?>><?=$v['title']?></option><?}?></select>
										</td>	
										<td style="font-size:12px;border:#666666 solid 1px;">
										<input id="payremark_<?=$val['id']?>" type="text"  value="<?=$val['remark']?>"/>
										</td>	
										<td style="font-size:12px;border:#666666 solid 1px;">
										<a href="javascript:void(0)" onclick="addpaylog(<?=$val['id']?>)">修改</a>
										&nbsp;&nbsp;<a href="javascript:void(0)" onclick="delpaylog(<?=$val['id']?>)">删除</a>
										</td>	
									</tr>
									
								<?}?>
															
								
									<tr>
									<td style="font-size:12px;border:#666666 solid 1px;">
									<input type="text"  id="paymoney_0" value=""  style="width:100px;" />
									</td>
									<td style="font-size:12px;border:#666666 solid 1px;"><input type="text"  id="banknum_0" value=""/></td>
									<td style="font-size:12px;border:#666666 solid 1px;">
									<input type="text"  class=" input-medium datepick valid"   id="paytime_0" value=""/>
									</td>	
									<td style="font-size:12px;border:#666666 solid 1px;">
									
									<select    style="width:100px;" id="paytype_0">
									<?foreach($paytype as $v){?>
									<option value="<?=$v['id']?>"><?=$v['title']?></option>
									<?}?>
									</select>
									</td>	
									<td style="font-size:12px;border:#666666 solid 1px;"><input type="text"  id="payremark_0" value=""/></td>
									<td style="font-size:12px;border:#666666 solid 1px;"><a href="javascript:void(0)" onclick="addpaylog(0)">提交</a></td>
									</tr>
									
									
								
									
        				</table>
						
							
							
							
							
							
							
							
						</div>
						
					</div>		
						
					
				<div class="form-actions">
					<input type="button" onclick="formtjmoneymore();$('#lrcwxx1').val('财务信息录入中...');" id="lrcwxx1" class="btn btn-primary" value="录入财务信息" >		
							<?if($re['status']==5){?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="button" onclick="javascript:pub_alert_confirm(this,'确认信息已录入，开始制作验货单？','<?=$this->url("buyer/updateapplystatuscaiwu",array("id"=>$re["id"]))?>');$('#lrcwxx2').val('财务信息提交中...');" id="lrcwxx2"  class="btn btn-primary" value="提交财务信息" >
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="button" onclick="$('#pub_edit_bootbox_cg').removeClass('fade');$('#pub_edit_bootbox_cg').removeClass('hide');$('#pub_edit_bootbox_cg').attr('tabindex','1');$('#lrcwxx3').val('正在取消采购...');" id="lrcwxx3" class="btn btn-primary" value="取消采购" >
							<?}?>
							
					</div>
						<input type="hidden" value="<?=$re["id"]?>" name="applyid" >
				</form>
			
				
				
				
				
				
			</div>
		</div>
	</div>
</div>

<?}?>

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
		<div class="box-content nopadding">
					<div class="form-actions" style="text-align:center;">			
						
						<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>		
							<?if($re['status']<-6 && $re['status']!=-10 && $re['iscansel']==0){?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="button" onclick="$('#pub_edit_bootbox').removeClass('fade');$('#pub_edit_bootbox').removeClass('hide');$('#pub_edit_bootbox').attr('tabindex','1');"  class="btn btn-primary" value="取消采购,财务确认" >
							<?}?>
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

<!--财务确认取消采购 开始 -->


<div id="pub_edit_bootbox" class="modal  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
        <h3 id="myModalLabel">描述</h3>
        <div class="modal-body">
			<div class="control-group">
						
						<div class="controls">
							<textarea id="caigouremark" class="span8"></textarea>
							
						</div>
			</div>
				<div class="form-actions">
					
					<input type="button" onclick="cancelsurecw(1)" class="btn btn-primary" value="确认取消" class="btn ">
					<input type="button" onclick="cancelsurecw(0)" class="btn btn-primary" value="取消无效,继续采购" class="btn ">
				
				</div>
		</div>
    </div>
</div>
</div>
<script>
	function cancelsurecw(val){
		var applyid	=	'<?=$re['id']?>';
		var status	=	'<?=$re['status']?>';
		
		var remark	=	$("#caigouremark").val();
		
		//pub_alert_success("选择采购责任人");
		//if(cgzrrid==0){pub_alert_error("选择采购责任人");return false;}
		$.ajax({
			data:{applyid:applyid,remark:remark,status:status,tag:val},
		    url:"<?=$this->url('buyer/cancelsurecw')?>",
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

<!--财务确认取消采购 结束 -->
<script>
//提交表单
	function formtjcheck(){
		if(confirm("确认提交？")){
			$("#formtjcheck").submit();
		}
	}
	function buttonformtj(){
		if(confirm("确认提交？")){
			$("#formtj").submit();
		}
	} 
	function formtjmoney(){
		if(confirm("确认提交？")){
			$("#formmoney").submit();
		}
	}
	function formtjmoneymore(){
		if(confirm("确认提交？")){
			$("#formmoneymore").submit();
		}
	}
//返回列表
	function returnList(){
		window.location.href="<?=$this->url('buyer/applycaigou')?>";
	}
//计算尾款
function getendmoney(id){
	var allprice	=	$("#allprice_"+id).val()-0;
	if(allprice<=0){return false;}
	var depnum	=	$("#depnum_"+id).val()-0; 
	var endprice	=	allprice-depnum;
	$("#inputendmoney_"+id).val(endprice);
	$("#endmoney_"+id).html(endprice);
}
</script>






<script>


	function hideceng(){
		$('#pub_edit_bootbox').addClass('fade');$('#pub_edit_bootbox').addClass('hide');$('#pub_edit_bootbox').attr('tabindex','-1');
	
	}
	function hidecengcg(){
		$('#pub_edit_bootbox_cg').addClass('fade');$('#pub_edit_bootbox_cg').addClass('hide');$('#pub_edit_bootbox_cg').attr('tabindex','-1');
	
	}
	//	提交支付记录
	function addpaylog(id){
		var hetongid	=	$("#hetongid").val();
		var paymoney	=	$("#paymoney_"+id).val();
		var banknum	=	$("#banknum_"+id).val();
		var paytime	=	$("#paytime_"+id).val();
		var paytype	=	$("#paytype_"+id).val();
		var payremark	=	$("#payremark_"+id).val();
		$.ajax({
			data:{paymoney:paymoney,banknum:banknum,paytime:paytime,paytype:paytype,remark:payremark,hetongid:hetongid,id:id},
			url:"<?=$this->url('buyer/paylogtj')?>",
			dataType:"json",
			type:"post",
			success:function(r){
				if(r.state==1){
					alert("保存成功");
					 location.reload();
				}else{
					alert(r.info);
				}
			}
		
		});
	
	}
	//删除支付记录
	function delpaylog(id){
		$.ajax({
			data:{id:id},
			url:"<?=$this->url('buyer/delpaylog')?>",
			dataType:"json",
			type:"post",
			success:function(r){
				if(r.state==1){
					
					 location.reload();
				}else{
					alert(r.info);
				}
			}
		
		});
	
	}
</script>