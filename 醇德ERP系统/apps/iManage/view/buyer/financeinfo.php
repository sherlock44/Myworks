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
			<a href="">财务信息录入</a>
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
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("buyer/insertplan")?>'  id="login" name="login" method='post'>
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
        					供应商合同列表
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding" style="overflow: auto;">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					<form  id="formtj" class='form-horizontal form-bordered form-validate'	action='<?=$this->url("buyer/financeinfoupdate")?>'   method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
							
							<th width="8%">合作商</th>
							<th width="10%">采购商品</th>
							<th width="10%">备注</th>
							<th width="5%">提交人</th>
							<th width="8%">提交时间</th>
							<th width="10%">合同名称</th>
							
							<th width="10%">总额度(元)</th>
							<th width="10%">预付款(元)</th>
							<th width="10%">预付款时间</th>
							<th width="10%">未付款金额(元)</th>
							<th width="10%">付尾款时间</th>
							
							</tr>
        					</thead>
							
							<?foreach($contract as $k=>$val){?>
							
							<tr>
							
							<td><?=$val['supplyname']?></td>
							<td><?foreach($val['goods'] as $v){echo $v['title']."&nbsp;,&nbsp;";}?></td>							
							<td><?=$val['remark']?></td>		
							<td><?=$val['truename']?></td>		
							<td><?if(!empty($val['created'])){?><?=date("Y-m-d",$val['created'])?><?}?></td>	
							<td><a href="<?=$val['contractpath']?>" ><?=$val['contracttitle']?></a></td>		
								
							<td><input type="text" name="allprice[]" class="span8" style="width:100%" value="<?if(!empty($val['allprice']) &&$val['allprice']>0){echo $val['allprice'];}?>">
							
							</td>
							<td><input type="text" name="depnum[]" class="span8" value="<?if(!empty($val['depnum']) &&$val['depnum']>0){echo $val['depnum'];}?>">
							<input type="hidden" name="id[]" value="<?=$val['id']?>">
							</td>
							<td><input type="text" name="depnum[]" class="span8" style="width:100%" value="<?if(!empty($val['depnum']) &&$val['depnum']>0){echo $val['depnum'];}?>">
							
							</td>
							<td><input type="text" name="depnum[]" class="span8" value="<?if(!empty($val['depnum']) &&$val['depnum']>0){echo $val['depnum'];}?>">
							
							</td>
							<td><input type="text" name="depnum[]" class="span8" value="<?if(!empty($val['depnum']) &&$val['depnum']>0){echo $val['depnum'];}?>">
							
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
	if(!confirm("确认该"+num+"份信息已录入完成,进入库房验收流程?")){
		return false;
	}
	$("#formtj").submit();

}
//返回列表
	function returnList(){
		window.location.href="<?=$this->url('buyer/editapplycaiwu',array('id'=>$applyid))?>";
	}
</script>





