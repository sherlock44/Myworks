	<div id="main">
			<div class="container-fluid nopadding">


<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/dynatree/ui.dynatree.css">
<script src="/public/assets/sysadmin/js/jquery.cookie.js"></script>
<script src="/public/assets/sysadmin/js/plugins/dynatree/jquery.dynatree.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/js/plugins/poshytip/tip-darkgray/tip-darkgray.css">
<script src="/public/assets/sysadmin/js/plugins/poshytip/jquery.poshytip.min.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datetimepicker/datetimepicker.css">
<script src="/public/assets/sysadmin/js/plugins/datetimepicker/datetimepicker.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datetimepicker/locales/bootstrap-datetimepicker.zh-CN.js"></script>
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
			<a href="">编辑</a>
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
				<?if($re['status']==7){$url	=$this->url("buyer/applyersure");	}?>
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
							<th width="10%">日期</th>
							<th width="10%">操作人员</th>
							<th width="25%">备注</th>
							<th width="8%">状态</th>			
							<th width="10%">操作</th>
							
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
							<input type="button" onclick="javascript:window.location.href='<?=$this->url("buyer/housestorelist",array("ordernum"=>$re["ordernum"],'planid'=>$val['id']))?>'" class="btn btn-primary" value="查看" class="btn ">
							
							
							</td>
							
							
							</tr>
                            <?
                                }
                            ?>
							<tr>
							
        				</table>
						<input type="hidden" value="<?=$re["id"]?>" name="applyid" id="lhapplyid" >
						<input type="hidden" value="0"  id="lhplanid" >
						</form>		
						<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
						
						        
						
						</div>
        			</div>
        			</div>
        		</div>
        	</div>
        </div>
    
	

	<?}?>

	<?if($re['status']>=3){?>
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
					<form   class='form-horizontal form-bordered form-validate' id="formmoney"	action='<?=$this->url("buyer/storelist")?>'   method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
							<th width="10%">商品名称</th>
							<th width="8%">商品编码</th>
							<th width="8%">商品条码</th>
							<th width="5%">采购类型</th>
							<th width="8%">供应商</th>
							
							<th width="8%">进价(元)</th>			
							<th width="5%">总数量</th>
							
							</tr>
        					</thead>
                            <?
                                foreach($goods as $key=>$val){
                            ?>
                            <tr>
							
							<td><?=$val['title']?>
							<input type="hidden" name="id[]" value="<?=$val['id']?>">
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
							<th width="10%">序号</th>
							<th width="10%">审核人</th>
							<th width="10%">审核</th>						
							<th width="10%">描术</th>							
							<th width="15%">审核时间</th>
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
						</div>
		</div>				
</div>
</div>
<script>
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
//返回列表
	function returnList(){
		window.location.href="<?=$this->url('buyer/applyhouse')?>";
	}

</script>

<!--主管采购审核 开始 -->
<?if($re['status']==7){?>

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
					
					<input type="button" onclick="checkcg()" class="btn btn-primary" value="确认通过" class="btn ">
				
					<button class="btn" type="button" data-dismiss="modal" onclick="hideceng()">取消</button>
				</div>
		</div>
    </div>
</div>
</div>
<script>
	function checkcg(){
		var planid	=	$("#lhplanid").val();
		var applyid	=	$("#lhapplyid").val();
		var remark	=	$("#remark").val();
		
		//pub_alert_success("选择采购责任人");
		//if(cgzrrid==0){pub_alert_error("选择采购责任人");return false;}
		$.ajax({
			data:{planid:planid,applyid:applyid,remark:remark},
		    url:"<?=$this->url('buyer/applyersure')?>",
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
<?}?>
<!--主管采购审核 结束 -->







<script>


	function hideceng(){
		$('#pub_edit_bootbox').addClass('fade');$('#pub_edit_bootbox').addClass('hide');$('#pub_edit_bootbox').attr('tabindex','-1');
	
	}

</script>