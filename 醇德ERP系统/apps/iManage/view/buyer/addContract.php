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
        					供应商列表
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
					<div role="grid" class="dataTables_wrapper" style="overflow: auto;" id="DataTables_Table_0_wrapper">
					<form  id="formtj" class='form-horizontal form-bordered form-validate'	action='<?=$this->url("buyer/contracttj")?>'   method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
							
							<th width="10%">合作商</th>
							<th width="10%">采购商品</th>
							<th width="35%">备注</th>
							<th width="10%">提交人</th>
							<th width="10%">提交时间</th>
							<th width="10%">合同名称</th>
							<th width="10%">选择合同</th>
							<th width="5%">操作</th>
							</tr>
        					</thead>
							
							<?foreach($contract as $k=>$val){?>
							
							<tr>
							
							<td><?=$val['supplyname']?></td>		
							<td><?foreach($val['goods'] as $v){echo $v['title']."&nbsp;,&nbsp;";}?></td>		
							<td><textarea class="span10" name="remark<?=$val['id']?>"><?=$val['remark']?></textarea></td>		
							<td><?=$val['truename']?></td>		
							<td><?if(!empty($val['created'])){?><?=date("Y-m-d",$val['created'])?><?}?></td>	
							<td><a href="<?=$val['contractpath']?>" ><?=$val['contracttitle']?></a></td>		
							<td><input type="file" name="files<?=$val['id']?>"></td>	
							<td><input type="button" onclick="formti(<?=$val['id']?>)" class="btn btn-primary" value="<?if(empty($val['contracttitle'])){echo '提交';}else{ echo '修改';}?>"></td>	
							</tr>		
							
							
							<?}?>
							
        				</table>
						<input type="hidden" value="0" name="id" id="formid">
						<input type="hidden" value="<?=$applyid?>" name="applyid" >
						</form>		
						<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
						<input type="button" onclick="javascript:pub_alert_confirm(this,'该计划共需<?=count($contract)?>份合同，确认都已上传','<?=$this->url("buyer/contractover",array("applyid"=>$applyid))?>');"  class="btn btn-primary" value="提交合同" >
						</div>
        			</div>
        			</div>
        		</div>
        	</div>
        </div>
    
	


	



</div>
</div>
<script>
function formti(id){
	$("#formid").val(id);
	$("#formtj").submit();

}

</script>





