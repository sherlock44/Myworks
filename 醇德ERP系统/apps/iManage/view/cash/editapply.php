	<div id="main">
			<div class="container-fluid nopadding">

<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/kindeditor-min.js"></script>
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/lang/zh_CN.js"></script>
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/php/upload_json.php"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/dynatree/ui.dynatree.css">
<script src="/public/assets/sysadmin/js/jquery.cookie.js"></script>
<script src="/public/assets/sysadmin/js/plugins/dynatree/jquery.dynatree.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/js/plugins/poshytip/tip-darkgray/tip-darkgray.css">
<script src="/public/assets/sysadmin/js/plugins/poshytip/jquery.poshytip.min.js"></script>
<script>
    var editor;
    KindEditor.ready(function(K) {
            editor = K.create('textarea[name="remark"]', {
                    allowFileManager : true,
                    afterBlur: function(){this.sync();}
            });
//            editor = K.create('textarea[name="basicinfo"]', {
//                    allowFileManager : true
//            });
//            editor = K.create('textarea[name="traffic"]', {
//                    allowFileManager : true
//            });
//            editor = K.create('textarea[name="service"]', {
//                    allowFileManager : true
//            });
//            editor = K.create('textarea[name="ambient"]', {
//                    allowFileManager : true
//            });
//            editor = K.create('textarea[name="special"]', {
//                    allowFileManager : true
//            });
    });
</script>	
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
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("cash/insertplan")?>'  id="login" name="login" method='post'>
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
							
							<th width="10%">商品名称</th>
							<th width="10%">商品编号</th>
							
							
							
							<th width="10%">价格</th>
							<th width="10%">净含量</th>
							<th width="10%">规格</th>				
													
							
							<th width="5%">数量</th>
							<?if($re['status']>=9){?>
							<th width="5%">库房</th>
							<th width="5%">库位</th>
							<?}?>
						
						</tr>
        					</thead>
                            <?
                                foreach($goods as $key=>$value){
                            ?>
                            <tr>
							
							<td><?=$value['title']?>&nbsp;<img width=50 height=50   src="<?=$value["imgpath"]?>"></td>
							<td><?=$value['barcode']?></td>
							<td><?=$value['costprice']?></td>	
							<td><?=$value['percent']?></td>
							<td><?=$value['specs']?></td>
							
							<td>
						<?=$value['num']?>
							</td>
							<?if($re['status']>=9){?>
							<td><?=$value['phtitle']?></td>
							<td><?=$value['phstitle']?></td>	
							<?}?>	
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
	

<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>
				</h3>
			</div>
			<div class="box-content nopadding">
			
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("cash/updateapply")?>'  id="login" name="login" method='post'>
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
					
				
				
					<?if($re['status']==-1 || $re['status']>=3){?>
					<div class="control-group">
						<label for="mobile" class="control-label">采购方式</label>
						<div class="controls">
						<?=$sysconf['purchasetype'][$re['type']]?>
						</div>
					</div>
					<?}?>
					<div class="control-group">
						<label for="number" class="control-label">描述</label>
						<div class="controls">
							<?=!empty($re) ? $re['remark']: ''?>
						</div>
						
					</div>
				
					<?if($re['status']>=5){?>
					<div class="control-group">
						<label for="number" class="control-label">支付定金<br>
						</label>
						<div class="controls">
						<?=$re['ispaydeposit']==1?$re['deposit']."元":"未支付定金"?>
						</div>
					</div>
					
					<?}?>
					<div class="control-group">
						<label for="number" class="control-label">当前状态</label>
						<div class="controls">
							<?=$sysconf['purchasestatus'][$re['status']]?>
						</div>
					</div>
					<div class="control-group">
						<label for="number" class="control-label">操作说明</label>
						<div class="controls">
							申请人：<?=$otherapply['truename']?>,时间:<?=date("Y-m-d H:i:s",$otherapply['created'])?><br/>
							<?if($re['status']>=2){?>
							申批人：<?=$otherapply['truename1']?>,时间:<?=date("Y-m-d H:i:s",$otherapply['created1'])?><br/>
							<?}?>
							<?if($re['status']>=3){?>
							采购方式确认人员：<?=$otherapply['truename2']?>,时间:<?=date("Y-m-d H:i:s",$otherapply['created2'])?><br/>
							<?}?>
							<?if($re['status']>=4){?>
							选择采购商品人员：<?=$otherapply['truename3']?>,时间:<?=date("Y-m-d H:i:s",$otherapply['created3'])?><br/>
							<?}?>
						</div>
					</div>
						<input type="hidden" value="<?=!empty($re)?$re['id']:''?>" name="id">
						<div class="form-actions">
						<?if($re['status']==3){?>
						<input type="button" onclick="javascript:window.location.href='<?=$this->url("cash/selgoods",array("id"=>$re["id"]))?>'" class="btn btn-primary" value="选择采购商品" class="btn ">
						<?}else if($re['status']==1){?>
						<input type="button" onclick="javascript:pub_alert_confirm(this,'确认审批通过，采购部门执行采购计划','<?=$this->url("cash/changestatus1",array("id"=>$re["id"]))?>');"  class="btn btn-primary" value="<?=$sysconf['purchasestatus'][$re['status']]?>" >
						<?}else if($re['status']==4){?>
						
						<input type="button" onclick="javascript:window.location.href='<?=$this->url("cash/plan",array("id"=>$re["id"]))?>'" class="btn btn-primary" value="<?=$sysconf['purchasestatus'][$re['status']]?>" class="btn ">
						<?}else if($re['status']==-2){?>
						
						<?}else if($re['status']==6){?>
						<input type="button" onclick="javascript:pub_alert_confirm(this,'确认执行采购','<?=$this->url("cash/purchasecheck",array("id"=>$re["id"]))?>');"  class="btn btn-primary" value="<?=$sysconf['purchasestatus'][$re['status']]?>" >
						<?}else if($re['status']==7){?>
						<input type="button" onclick="javascript:pub_alert_confirm(this,'确认已支付尾款?','<?=$this->url("cash/paymoney",array("id"=>$re["id"]))?>');"  class="btn btn-primary" value="<?=$sysconf['purchasestatus'][$re['status']]?>" >
						<?}else if($re['status']==8){?>
						
						<input type="button" onclick="javascript:window.location.href='<?=$this->url("cash/goodstostore",array("id"=>$re["id"]))?>'" class="btn btn-primary" value="<?=$sysconf['purchasestatus'][$re['status']]?>" class="btn ">
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
		window.location.href="<?=$this->url('cash/apply')?>";
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
		    url:"<?=$this->url('cash/cgfzrcheck')?>",
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



<!-- 采购执行 开始 -->
<?if($re['status']==2){?>

<div id="pub_edit_bootbox" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
        <h3 id="myModalLabel">采购执行</h3>
        <div class="modal-body">
			<div class="control-group">
						
						<div class="controls">
							<select id="cgtype" onchange="changetype(this.value)" >
							<option value='-1'>选择采购方式</option>
							<?foreach($sysconf['purchasetype'] as $k=>$val){?>
							<option value="<?=$k?>" ><?=$val?></option>
							<?}?>
							</select>
							
						</div>
			</div>
		
			<div class="control-group newgoods" style="display:none;">
						
						<div class="controls">
							<a href="<?=$this->url('goods/newlists')?>" target="_black">点击添加新采购商品</a>
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
		var cgtype	=	$("#cgtype").val();
		var supplyid	=	$("#supplyid").val();
		//pub_alert_success("选择采购责任人");
		if(cgtype==-1){pub_alert_error("选择采购方式");return false;}
		$.ajax({
			data:{cgtype:cgtype,id:id,supplyid:supplyid},
		    url:"<?=$this->url('cash/cgfscheck')?>",
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
	function changetype(val){
		if(val==0){
			$(".newgoods").css("display","block");
		
		}else{
			$(".newgoods").css("display","none");
		}
	}
</script>
<?}?>
<!-- 采购执行 结束 -->

<!-- 库房验收 开始 -->
<?if($re['status']==5){?>
<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("cash/storecheck")?>'  id="acceptancecheck" name="acceptancecheck" method='post'>
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