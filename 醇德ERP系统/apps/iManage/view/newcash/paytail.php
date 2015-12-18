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
			<a href="">财务付尾款</a>
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
					<i class="icon-user"></i>采购流程
				</h3>				
			</div>
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("newcash/insertplan")?>'  id="login" name="login" method='post'>
					<div class="control-group" style="height:45px;background-color:white;text-align:center;padding-top:10px;">
						<?foreach($sysconf['purchasestatus'] as $k=>$v){?>
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
        					合同列表
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					<form  id="formtj" class='form-horizontal form-bordered form-validate'	action='<?=$this->url("newcash/paytailupdate")?>'   method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
							<th width="3%">序号</th>
							<th width="10%">合作商</th>
							<th width="20%">验货标准</th>
							
							<th width="10%">合同名称</th>
							<th width="10%">是否支付定金</th>
							<th width="10%">定金额度(元)</th>
							<th width="5%">库房验收结果</th>
							<th width="15%">尾款(元)</th>
							</tr>
        					</thead>
							
							<?foreach($contract as $k=>$val){?>
							
							<tr>
							<td><?=($k+1)?></td>
							<td><?=$val['supplyname']?></td>		
							<td><?=$val['remark']?></td>		
							
							<td><a href="<?=$val['contractpath']?>" ><?=$val['contracttitle']?></a></td>		
							<td><?=empty($val['isdep'])?"否":"是"?></td>		
							<td><?=$val['depnum']?></td>	
							<td><?if($val['isproblem']==1){echo "通过";}else if($val['isproblem']==0){echo "已重新调整合同";}else if($val['isproblem']==-1){echo "退回";}?></td>
							<td><input type="text" name="tailmoney[]" class="span10" value="<?if(!empty($val['tailmoney']) &&$val['tailmoney']>0){echo $val['tailmoney'];}?>">
							<input type="hidden" name="id[]" value="<?=$val['id']?>">
							</td>
							</tr>		
						
							
							<?}?>
							
        				</table>
						
						<input type="hidden" value="<?=$applyid?>" name="applyid" >
						</form>		
						<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
						<input type="button" onclick="formti(<?=count($contract)?>)"    class="btn btn-primary" value="提交该<?=count($contract)?>份财务信息" >
						<input type="button" onclick="returnList()"    class="btn btn-primary" value="返回" >
						</div>
        			</div>
        			</div>
        		</div>
        	</div>
        </div>

    </div>
</div>



   
 








<script>
function formti(num){
	if(!confirm("确认该"+num+"份信息已录入完成,进入财务核价流程?")){
		return false;
	}
	$("#formtj").submit();

}
//返回列表
	function returnList(){
		window.location.href="<?=$this->url('newcash/editapply',array('id'=>$applyid))?>";
	}
</script>





