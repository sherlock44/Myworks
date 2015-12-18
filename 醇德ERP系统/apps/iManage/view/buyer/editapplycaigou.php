<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<section class="content-header">
	<h1>
		采购列表
		<small>采购计划</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> ERP系统</a></li>
		<li><a href="#">采购管理</a></li>
		<li class="active">采购列表</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#activity" data-toggle="tab">采购信息</a></li>
					<li><a href="#timeline" data-toggle="tab">操作历史</a></li>
				</ul>
				<div class="tab-content">
					<div class="active tab-pane" id="activity" >
						<section class="invoice" style="margin: 0;">
							<div class="row">
								<div class="col-xs-12">
									<h2 class="page-header">
										<i class="fa fa-globe"></i> <?=$re['title']?>
										<small class="pull-right">申请日期: </small>
									</h2>
								</div><!-- /.col -->
							</div>
							<div class="row invoice-info">
								<div class="col-sm-6 invoice-col">
									<p class="lead">采购信息</p>
									<address>
										申请人: <?=!empty($re) ? $re['cgname']: ''?><br>
										审批人: <?=!empty($re) ? $re['zgname']: ''?><br>
										描述: <?=!empty($re) ? $re['remark']: ''?><br>
										当前状态: <?=$this->sysconf['purchasestatus'][$re['status']]?>
									</address>
								</div><!-- /.col -->
								<?if($re['status']>=4){?>
								<div class="col-sm-3 invoice-col">
									<p class="lead">供应商信息</p>
									<!-- <address>
										名称: <?=$userinfo['commname']?>.<br>
										类型: <?=$userinfo['commtel']?><br>
										地址: <?=$userinfo['pname']?>
									</address> -->
								</div><!-- /.col -->
								<div class="col-sm-3 invoice-col">
									<p class="lead">&nbsp;</p>
								<!-- 	<address>
										联系人: <?=$userinfo['proname']?><br>
										联系人电话: <?=$userinfo['protel']?>
									</address> -->
								</div><!-- /.col -->
								<?}?>
							</div><!-- /.row -->
							<?if($re['status']>=3){?>
							<div class="row">
								<div class="col-xs-12 table-responsive">
									<p class="lead">采购商品列表</p>
									<table class="table table-striped">
										<thead>
											<tr>
												<th >商品名称</th>
												<th >商品编码</th>
												<th >商品条码</th>
												<th >采购类型</th>
												<th >供应商</th>
												<th >进价(元)</th>			
												<th >总数量</th>
											</tr>
										</thead>
										<tbody>
											<?foreach($goods as $key=>$val){?>
											<tr>
												<td><?=$val['title']?>
													<input type="hidden" name="ids[]" value="<?=$val['id']?>">
												</td>
												<td><?=$val['erpcode']?></td>
												<td><?=$val['barcode']?></td>
												<td><?=$val['cashtype']?></td>
												<td><?=$val['supplyname']?></td>
												<td>
													<?if(!empty($val['costprice']) &&$val['costprice']>0){echo $val['costprice'];}?>
												</td>	
												<td><?=$val['number']?>
												</td>
											</tr>
											<?}?>
										</tbody>
										<tfoot>
											<?if($re['status']>=4){?>
											<?if(empty($contract)){?>
											<script>window.location.href=window.location.href;</script>
											<?}?>
											<tr><td colspan="7" >合同信息</td></tr>
											<tr><td>供应商</td><td colspan="6" ><?=empty($contract['supplyname'])?'':$contract['supplyname'];?></td></tr>
											<tr><td>备注</td><td colspan="6" ><textarea class="span10" name="remark<?=$contract['id']?>"><?=empty($contract['remark'])?'':$contract['remark']?></textarea></td></tr>
											<tr><td>上传合同</td><td colspan="6" ><input type="file" name="files"></td></tr>
											<?if(!empty($contract['truename'])){?>
											<tr>
												<td  >合同提交信息</td>
												<td colspan="6"><a  <?if(!empty($contract['contractpath'])){?>href="<?=$contract['contractpath']?>" target="_black"<?}?>>
													<?=$contract['contracttitle']?></a>&nbsp;&nbsp;&nbsp;&nbsp;<?=$contract['truename']?>&nbsp;&nbsp;<?if(!empty($contract['created'])){?>于<?=date("Y-m-d",$contract['created'])?>&nbsp;&nbsp;提交<?}?>
												</td>
											</tr>
											<?}?>
											<tr>
												<td colspan="7" style="text-align:center;">
													<input type="submit" onclick="$('#hetongtjbt').val('提交中...');" id="hetongtjbt"  class="btn btn-sm btn-primary" value="<?if(empty($contract['contracttitle'])){echo '提交';}else{ echo '修改';}?>">
													<?if(!empty($contract['truename']) && $re['status']==4){?>
													<input type="button" onclick="javascript:pub_alert_confirm(this,'确认合同信息都已上传','<?=$this->url("buyer/contractover",array("applyid"=>$re["id"]))?>');$('#hetongtjbt2').val('提交中...');" id="hetongtjbt2"  class="btn btn-sm btn-primary" value="提交合同" >
													<?}?>
												</td>
											</tr>
											<?}?>
										</tfoot>
									</table>
								</div>
							</div>
							<?}?>
						</section>
					</div>
				</div>
			</div>
		</div>
	</div>
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
				<?if($re['status']==$k){?>
				<span style="color:red;"><?echo ($k+1).".$v";?></span>
				<?}else{?>
				<?echo ($k+1).".$v";?>
				<?}?>
				<?}?>
			</div>
		</div>
	</div>
	<div class="box box-default">
		<div class="box-header with-border">
			采购信息
		</div>
		<div class="box-body">
			<?$url=$this->url("buyer/updateapply");?>
			<?if($re['status']==1){ $url=$this->url("buyer/changestatus1");	}?>
			<form  class='form-horizontal form-bordered form-validate' action='<?=$url?>' id="formtj" method='post'>
				<?if($re['status']==0 && $re['memberid']==$this->info['id']){?>
				<div class="control-group">
					<label for="mobile" class="control-label">名称</label>
					<div class="controls">
						<input type="text" name="data[title]" id="title" value="<?=$re['title']?>" class="input-xlarge" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
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
				<br>
				<input type="hidden" value="<?=!empty($re)?$re['id']:''?>" name="id">
				<div class="form-actions">
					<input type="submit" class="btn btn-sm btn-success" value="修改" >		
					<input type="button" class="btn btn-sm btn-default" value="返回列表" onclick='returnList()'>					
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
				<br>
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
				<br>
				<div class="form-actions">
					<input type="submit" class="btn btn-sm btn-success" value="提交">				
					<input type="button" class="btn btn-sm btn-default" value="返回列表" onclick='returnList()'>					
				</div>
				<?}?>
				<?if($re['status']==2){?>
				<div class="form-actions">
					<a href="<?=$this->url("buyer/plan",array("id"=>$re["id"]))?>" class="btn btn-sm btn-success"><?=$this->sysconf['purchasestatus'][$re['status']]?></a>
					<input type="button" class="btn btn-sm btn-default" value="取消采购" >		
				</div>
				<?}?>
				<?if($re['status']==3){?>
				<div class="form-actions">
					<input type="submit" class="btn btn-sm btn-danger" value="采购经理审核">
					<input type="button" class="btn btn-sm btn-default" value="取消采购" >		
				</div>
				<?}?>
				<?if($re['status']==4){?>
				<div class="form-actions">
					<input type="button" class="btn btn-sm btn-default" value="取消采购" >		
				</div>
				<?}?>
				<?if($re['status']>=6){?>
				<div class="form-actions">
					<?if($plan){$btname="再次制作验货单";}else{$btname="制作验货单";}?>
					<input type="button" onclick="javascript:window.location.href='<?=$this->url("buyer/makestorelist",array("ordernum"=>$re["ordernum"]))?>'" class="btn btn-sm btn-success" value="<?=$btname?>" >
					<input type="button" class="btn btn-sm btn-default" value="取消采购" >		
				</div>
				<?}?>				
				<input type="hidden" value="<?=!empty($re)?$re['id']:''?>" name="id">
				<?}?>
			</form>
		</div>
	</div>
	<?if($plan){?>
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">
				<i class="icon-th-list"></i>
				入库计划
			</h3>
		</div>
		<div class="box-body" >
			<form class='form-horizontal form-bordered form-validate' id="formmoney"	action='<?=$this->url("buyer/storelist")?>'   method='post'>
				<table class="table table-hover table-nomargin table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
					<thead>
						<tr>
							<th>日期</th>
							<th>操作人员</th>
							<th width="25%">备注</th>
							<th>状态</th>			
							<th>操作</th>
						</tr>
					</thead>
					<?foreach($plan as $key=>$val){?>
					<tr>
						<td><?=date("Y-m-d",$val['created'])?></td>
						<td><?=$val['truename']?></td>
						<td><?=$val['remark']?></td>
						<td><?=$this->sysconf['purchasestorestatus'][$val['status']]?></td>
						<td>
							<input type="button" onclick="javascript:window.location.href='<?=$this->url("buyer/makestorelist",array("ordernum"=>$re["ordernum"],'planid'=>$val['id']))?>'" class="btn btn-sm btn-primary" value="查看" >
							<?if($val['status']==2){?>
							<input type="button" onclick="$('#lhplanid').val(<?=$val['id']?>);$('#pub_edit_bootbox').removeClass('fade');$('#pub_edit_bootbox').removeClass('hide');$('#pub_edit_bootbox').attr('tabindex','1');"  class="btn btn-sm btn-primary" value="采购人员确认" >
							<?}?>
						</td>
					</tr>
					<?}?>
				</table>
				<input type="hidden" value="0" id="lhplanid">
			</form>
		</div>
	</div>
	<?}?>
	<input type="hidden" value="<?=$re["id"]?>" name="applyid" id="lhapplyid">
	<?if($re['status']>=3){?>
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">
				采购商品列表
			</h3>
			<?if($re['status']==3){?>
			<div class="box-tools pull-right">
				<a rel="tooltip" data-original-title="编辑整个计划" href="<?=$this->url('buyer/plan',array("id"=>$re['id'],'edit'=>1))?>" class="btn btn-sm btn-danger"> 编辑整个计划</a>
			</div>
			<?}?>
		</div>
		<div class="box-body">
			<form class='form-horizontal form-bordered form-validate' id="formmoneys"	action='<?=$this->url("buyer/contracttj")?>'   method='post'>
				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
					<thead>
						<tr>
							<th>商品名称</th>
							<th>商品编码</th>
							<th>商品条码</th>
							<th>采购类型</th>
							<th>供应商</th>
							<th>进价(元)</th>			
							<th>总数量</th>
						</tr>
					</thead>
					<tbody>
						<?foreach($goods as $key=>$val){?>
						<tr>
							<td><?=$val['title']?>
								<input type="hidden" name="ids[]" value="<?=$val['id']?>">
							</td>
							<td><?=$val['erpcode']?></td>
							<td><?=$val['barcode']?></td>
							<td><?=$val['cashtype']?></td>
							<td><?=$val['supplyname']?></td>
							<td>
								<?if(!empty($val['costprice']) &&$val['costprice']>0){echo $val['costprice'];}?>
							</td>	
							<td><?=$val['number']?>
							</td>
						</tr>
						<?}?>
					</tbody>
					<tfoot>
						<?if($re['status']>=4){?>
						<?if(empty($contract)){?>
						<script>window.location.href=window.location.href;</script>
						<?}?>
						<tr><td colspan="7" >合同信息</td></tr>
						<tr><td>供应商</td><td colspan="6" ><?=empty($contract['supplyname'])?'':$contract['supplyname'];?></td></tr>
						<tr><td>备注</td><td colspan="6" ><textarea class="span10" name="remark<?=$contract['id']?>"><?=empty($contract['remark'])?'':$contract['remark']?></textarea></td></tr>
						<tr><td>上传合同</td><td colspan="6" ><input type="file" name="files"></td></tr>
						<?if(!empty($contract['truename'])){?>
						<tr>
							<td  >合同提交信息</td>
							<td colspan="6"><a  <?if(!empty($contract['contractpath'])){?>href="<?=$contract['contractpath']?>" target="_black"<?}?>>
								<?=$contract['contracttitle']?></a>&nbsp;&nbsp;&nbsp;&nbsp;<?=$contract['truename']?>&nbsp;&nbsp;<?if(!empty($contract['created'])){?>于<?=date("Y-m-d",$contract['created'])?>&nbsp;&nbsp;提交<?}?>
							</td>
						</tr>
						<?}?>
						<tr>
							<td colspan="7" style="text-align:center;">
								<input type="submit" onclick="$('#hetongtjbt').val('提交中...');" id="hetongtjbt"  class="btn btn-sm btn-primary" value="<?if(empty($contract['contracttitle'])){echo '提交';}else{ echo '修改';}?>">
								<?if(!empty($contract['truename']) && $re['status']==4){?>
								<input type="button" onclick="javascript:pub_alert_confirm(this,'确认合同信息都已上传','<?=$this->url("buyer/contractover",array("applyid"=>$re["id"]))?>');$('#hetongtjbt2').val('提交中...');" id="hetongtjbt2"  class="btn btn-sm btn-primary" value="提交合同" >
								<?}?>
							</td>
						</tr>
						<?}?>
					</tfoot>
				</table>
				<input type="hidden" value="<?=empty($contract['id'])?0:$contract['id']?>" name="id" id="formid">
				<input type="hidden" value="<?=$re["id"]?>" name="applyid" >
			</form>		
			<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
			</div>
		</div>
	</div>
	<?}?>
</section>
<!--取消采购 开始 -->
<div id="pub_edit_bootbox_cg" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="row-fluid">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hidecengcg()">×</button>
			<h3 id="myModalLabel">描述</h3>
			<div class="modal-body">
				<div class="control-group">
					<div class="controls">
						<textarea id="caigouremark" class="form-control"></textarea>
					</div>
				</div>
				<div class="form-actions">
					<input type="button" onclick="cancelcg()" class="btn btn-sm btn-success" value="确认通过">
					<button class="btn btn-sm  btn-default" type="button" data-dismiss="modal" onclick="hidecengcg()">取消</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function cancelcg(){
		var applyid='<?=$re['id']?>';
		var status='<?=$re['status']?>';
		var remark=$("#caigouremark").val();
		$.ajax({
			data:{applyid:applyid,remark:remark,status:status},
			url:"<?=$this->url('buyer/canselapply')?>",
			dataType:"json",
			type:"post",
			success:function(data){
				if(data.state==1){
					location.reload();
				}else{
					pub_alert_error(data.info);
				}
			}
		});
	}
</script>
<!--取消采购 结束 -->
<!--采购经理审核 开始 -->
<?if($re['status']==3){?>
<div id="pub_edit_bootbox" class="modal  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="row-fluid">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
			<h3 id="myModalLabel">描述</h3>
			<div class="modal-body">
				<div class="control-group">
					<div class="controls">
						<textarea id="remark" class="span8"></textarea>
					</div>
				</div>
				<div class="form-actions">
					<input type="button" onclick="checkcg();$('#qytg1').val('提交中...');" id="qytg1" class="btn btn-primary" value="确认通过" class="btn ">
					<button class="btn" type="button" data-dismiss="modal" onclick="hideceng()">取消</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function checkcg(){
		var applyid=$("#lhapplyid").val();
		var remark=$("#remark").val();
		$.ajax({
			data:{applyid:applyid,remark:remark},
			url:"<?=$this->url('buyer/applyersurejl')?>",
			dataType:"json",
			type:"post",
			success:function(data){
				if(data.state==1){
					location.reload();
				}else{
					pub_alert_error(data.info);
				}
			}
		});
	}
</script>
<?}?>
<!--采购经理审核 结束 -->
<!--主管采购审核 开始 -->
<?if($re['status']==8){?>
<div id="pub_edit_bootbox" class="modal  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="row-fluid">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
			<h3 id="myModalLabel">描述</h3>
			<div class="modal-body">
				<div class="control-group">
					<div class="controls">
						<textarea id="remark" class="span8">已确认</textarea>
					</div>
				</div>
				<div class="form-actions">
					<input type="button" onclick="checkcg()" class="btn btn-primary" value="确认通过" class="btn ">
					<button class="btn" type="button" data-dismiss="modal" onclick="hideceng()">取消</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function checkcg(){
		var planid=$("#lhplanid").val();
		var applyid=$("#lhapplyid").val();
		var remark=$("#remark").val();
		$.ajax({
			data:{planid:planid,applyid:applyid,remark:remark},
			url:"<?=$this->url('buyer/applyersure')?>",
			dataType:"json",
			type:"post",
			success:function(data){
				if(data.state==1){
					location.reload();
				}else{
					pub_alert_error(data.info);
				}
			}
		});
	}
</script>
<?}?>
<script>
	function formtjmoney(){
		if(confirm("确认提交？")){
			$("#formmoney").submit();
		}
	}
	//返回列表
	function returnList(){
		window.location.href="<?=$this->url('buyer/applycaigou')?>";
	}
	function hideceng(){
		$('#pub_edit_bootbox').addClass('fade');$('#pub_edit_bootbox').addClass('hide');$('#pub_edit_bootbox').attr('tabindex','-1');
	}
	function hidecengcg(){
		$('#pub_edit_bootbox_cg').addClass('fade');$('#pub_edit_bootbox_cg').addClass('hide');$('#pub_edit_bootbox_cg').attr('tabindex','-1');
	}
</script>