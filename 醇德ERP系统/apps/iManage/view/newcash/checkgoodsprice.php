<div id="main">
    <div class="container-fluid nopadding">

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
			<a href="">采购计划列表</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/chosen/chosen.css">
<script src="/public/assets/sysadmin/js/plugins/chosen/chosen.jquery.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/jquery.dataTables.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/TableTools.css">
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/TableTools.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColReorder.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColVis.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.columnFilter.js"></script>
<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i><?=$apply['title']?> 采购流程
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
        					采购商品列表
							
        				</h3>
                        <div class="actions">
        					
        				</div>
                    
        			</div>
        			<div class="box-content nopadding">
						<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("newcash/updategoodsprice")?>'  id="planform" name="logins" method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" width="100%">
        					<thead>
        						<tr>
        						
        							<th style="display:none">ID</th>
        							<th width="10%">商品编号</th>
        							<th width="10%">名称</th>
                                    <th width="5%">采购类型</th>
                                    <th width="10%">供应商</th>
                                    <th width="10%">规格</th>
                                    <th width="10%">单价(进价)(元)</th>
                                    <th width="10%">售价(元)</th>
                                    <th width="10%">临期价(元)</th>
                                    <th width="5%">数量</th>
                                    <th width="10%">总价</th>
                                
        						</tr>
        					</thead>
									
									<?foreach($planinfo as $key=>$val){?>
                                    <tr>
            						
            							<td style="display:none;"><?=$key?></td>
            							<td style=""><?=$val['barcode']?></td>
            							<td style=""><?=$val['title']?></td>
            							<td style=""><?=$val['cashtype']?></td>
            							<td style=""><?=$val['supplyname']?></td>
            							<td style=""><?=$val['specs']?></td>
            							<td style="padding:0px;">
										<input type="text" name="costprice[]" value="<?if(!empty($val['costprice']) && $val['costprice']>0){echo $val['costprice'];}?>"  onchange="checkprice(this.value)" class="span8"  style="width:100%;margin-bottom:-1px;margin-top:3px;">
										</td>
            							<td style="padding:0px;">
										<input type="text" name="saleprice[]" value="<?if(!empty($val['saleprice']) && $val['saleprice']>0){echo $val['saleprice'];}?>"  onchange="checkprice(this.value)" class="span8"  style="width:100%;margin-bottom:-1px;margin-top:3px;">
										</td>
            							<td style="padding:0px;">
										<input type="text" name="futureprice[]" value="<?if(!empty($val['futureprice']) && $val['futureprice']>0){echo $val['futureprice'];}?>"  onchange="checkprice(this.value)" class="span8"  style="width:100%;margin-bottom:-1px;margin-top:3px;">
										</td>
            							<td style=""><?=$val['number']?></td>
            							<td style=""><?=$val['allprice']?></td>
            							<input type="hidden" value="<?=$val['id']?>" name="id[]">
            							
            						</tr>
                                    <?}?>
								
        				</table>
						<input type="hidden" id="tag" value="1" >
						<input type="hidden" name="applyid" value="<?=$applyid?>" >
						<input type="hidden" name="planid" value="<?=$planid?>" >
						 </form>
						 <div class="dataTables_info" id="DataTables_Table_0_info" style="float:left;margin:10px;">
						
						</div>
						 <div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_full_numbers" style="float:right;margin:10px;">
						 <button class="btn btn-success" onclick="formcarttj()" >&nbsp;&nbsp;保存方案</button>	
						</div>
						 
						 
						 
        			</div>
        		</div>
        	</div>
        </div>
		
		
	
    </div>
</div>
<script>
	//提交表单
	function formcarttj(){
	
		$("#planform").submit();
	}



	

	//修改价格
	function checkprice(s){
		if(!isPirce(s)){
			
			pub_alert_error("请输入正确的价格");
		}
	}
	function isPirce(s){
    s=s.trim();
    var p =/^[1-9](\d+(\.\d{1,2})?)?$/; 
    var p1=/^[0-9](\.\d{1,2})?$/;
    return p.test(s) || p1.test(s);
}
</script>

