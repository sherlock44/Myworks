<div id="main">
    <div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="javascript:;">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">退货单</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script>


        
		
<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
		
		<div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					退货商品
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
					
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
        					<th width="10%">商品名称</th>
							<th width="10%">商品编号</th>
							<th width="10%">购买单价(元)</th>						
							<th width="15%">订购数量</th>
                            <th width="10%">退货数量</th>
                            <th width="10%">退货总价(元)</th>
        					</tr>
        					</thead>
                            <?
                                foreach($goods as $key=>$value){
                                    ?>
                                    <tr>
            						
            						
            							<td><?=$value['title']?>&nbsp;<img width=50 height=50   src="<?=$value["imgpath"]?>"></td>
            							<td><?=$value['barcode']?></td>
            							<td><?=$value['price']?></td>
            							<td><?=$value['buynum']?></td>
            							<td><?=$value['num']?></td>
            							<td><?=$value['num']*$value['price']?></td>
            							
            						
            						</tr>
                                    <?
                                }
                            ?>
        				</table>
						<input type="hidden" value="<?=$id?>" name="id">
						
						
        			</div>
        		</div>
        	</div>
        </div>
		
		
		<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>退货详情
				</h3>				
			</div>
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("orderback/insert")?>'  id="login" name="login" method='post'>
					
					<div class="control-group">
						<label for="mobile" class="control-label">名称</label>
						<div class="controls">
                           <?=!empty($re) ? $re["title"] : ''?>
                        
                        </div>
						
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">选择关联订单</label>
						<div class="controls">
                           <?=!empty($re) ? $re["ordernum"] : ''?>&nbsp;&nbsp;
							(<span style="color:red;">加盟商订货的订货单</span>)
                        </div>
						
					</div>
					
				<div class="control-group">
						<label for="number" class="control-label">说明</label>
						<div class="controls">
							<?=!empty($re) ? $re['remark']: ''?>
						</div>
				</div>
				<?if($re['status']>=3){?>
				<div class="control-group">
						<label for="number" class="control-label">合同附件<br>
						
						</label>
						<div class="controls">
							<a href="<?=!empty($re) ? $re["filepath"] : ''?>"><?=!empty($re) ? $re["filename"] : ''?></a>
						</div>
				</div>
				<div class="control-group">
						<label for="number" class="control-label">退单总价</label>
						<div class="controls">
							<?=!empty($re) ? $re['price']: '0'?>元
						</div>
				</div>
				<?}?>
				<div class="control-group">
						<label for="number" class="control-label">当前状态</label>
						<div class="controls">
							
							<?=$sysconf['orderbackstatus'][$re['status']]?>
							
						</div>
						
					</div>
						<div class="form-actions">
						<?if($re['status']==1){?>
						<input type="button" onclick="javascript:pub_alert_confirm(this,'确认退货?','<?=$this->url("orderback/checkfirst",array("id"=>$re["id"]))?>');"  class="btn btn-primary" value="<?=$sysconf['orderbackstatus'][$re['status']]?>" >
						<?}else if($re['status']==4){?>	
						<input type="button" onclick="javascript:window.location.href='<?=$this->url("orderback/goodstostore",array("backid"=>$re["id"]))?>';"  class="btn btn-primary" value="<?=$sysconf['orderbackstatus'][$re['status']]?>" >
						<?}else if($re['status']==5){?>	
						<input type="button" onclick="javascript:pub_alert_confirm(this,'确认财务已结算?','<?=$this->url("orderback/ordercompelete",array("id"=>$re["id"]))?>');"  class="btn btn-primary" value="<?=$sysconf['orderbackstatus'][$re['status']]?>" >
						<?}else{?>
						<input type="button" onclick="$('#pub_edit_bootbox').removeClass('fade');$('#pub_edit_bootbox').removeClass('hide');$('#pub_edit_bootbox').attr('tabindex','1');"  class="btn btn-primary" value="<?=$sysconf['orderbackstatus'][$re['status']]?>" >
						<?}?>	
										
						</div>
				</form>
			</div>
		</div>
	</div>
</div>
		
		
		
		
    </div>
</div>




<!-- 财务信息 开始 -->
<?if($re['status']==2){?>

<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("orderback/cwcheck")?>'  id="acceptancecheck" name="acceptancecheck" method='post'>
<div id="pub_edit_bootbox" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
        <h3 id="myModalLabel">财务信息</h3>
        <div class="modal-body">
			<div class="control-group checknono"  >
						<label for="number" class="control-label">合同附件<br>
						
						</label>
						<div class="controls">
							<input type="file" class="input-block-level" id="file" name="files">
						</div>
			</div>
			<div class="control-group">
						<label for="number" class="control-label">退货单总价<br>
						
						</label>
						<div class="controls">
						<input type="text" name="data[price]" id="price" value="" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">(元)
						</div>
			</div>
			<div class="form-actions">		
				<input type="hidden" name="backid" value="<?=$re['id']?>">
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
</script>
<?}?>
<!-- 财务信息 结束 -->



<!-- 商品审核 开始 -->
<?if($re['status']==3){?>

<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("orderback/goodscheck")?>'  id="acceptancecheck" name="acceptancecheck" method='post'>
<div id="pub_edit_bootbox" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="row-fluid">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="hideceng()">×</button>
        <h3 id="myModalLabel">商品验收</h3>
        <div class="modal-body">
			<div class="control-group">
						<label for="number" class="control-label">验收结果<br>
						</label>
						<div class="controls">
							<select id="acceptance" name="acceptance" onchange="checksec(this.value)" >
							<option value="2" >通过</option>
							<option value='1'>有问题,重写合同</option>
							<option value='-1'>有问题,取消该退货单</option>
							</select>
						</div>
			</div>
			<div class="control-group checknono"  style="display:none;">
						<label for="number" class="control-label">合同附件<br>
						
						</label>
						<div class="controls">
							<input type="file" class="input-block-level" id="file" name="files">
						</div>
			</div>
			<div class="control-group checknono" style="display:none;">
						<label for="number" class="control-label">退货单总价<br>
						</label>
						<div class="controls">
						<input type="text" name="data[price]" id="price" value="" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">(元)
						</div>
			</div>
			<div class="control-group checknonos" style="display:none;">
						<label for="number" class="control-label">备注<br>
						</label>
						<div class="controls">
						<textarea  rows="3" name="data[remarkinfo]" class="span8"></textarea>
						</div>
			</div>
			<div class="form-actions">		
				<input type="hidden" name="backid" value="<?=$re['id']?>">
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
	function checksec(val){
		if(val==2){
			$(".checknono,.checknonos").css("display","none");
		}else if(val==-1){
			$(".checknono").css("display","none");
			$(".checknonos").css("display","block");
		}else{
			$(".checknono,.checknonos").css("display","block");
		}
	
	}
</script>
<?}?>
<!-- 商品审核 结束 -->

<script>
	function hideceng(){
		$('#pub_edit_bootbox').addClass('fade');$('#pub_edit_bootbox').addClass('hide');$('#pub_edit_bootbox').attr('tabindex','-1');
	
	}
</script>