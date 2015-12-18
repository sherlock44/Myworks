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
			<a href=""><?=!empty($re)?"修改":"添加"?></a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script><div class="row-fluid">


<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/chosen/chosen.css">
<script src="/public/assets/sysadmin/js/plugins/chosen/chosen.jquery.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/ckeditor/ckeditor.js"></script>

<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("cash/updateplan")?>'  id="login" name="login" method='post'>
	<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>
				</h3>				
			</div>
			<div class="box-content nopadding">
				
					
					<div class="control-group">
						<label for="mobile" class="control-label">名称</label>
						<div class="controls">
                            <input type="text" name="data[title]" id="title" value="<?=!empty($re) ? $re["title"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
                        
                        </div>
						
					</div>
					<div class="control-group">
							<label for="number" class="control-label">备注</label>
							<div class="controls">
								<textarea  rows="3" name="data[remark]" class="span8"><?=!empty($re) ? $re['remark']: ''?></textarea>
							</div>
					</div>
											
					
					<input type='hidden'  name="id" value='<?=!empty($re) ? $re['id']: ''?>'>
					
				
				
						
					
			
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
                        
        			</div>
        			<div class="box-content nopadding">
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
					
					<div id="DataTables_Table_0_length" class="dataTables_length" style="height:36px;">				
						注：当合作过的供应商和所有供应商同时选择时，以合作过的供应商为准
                   </div>
				   
					
					
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        						<tr>
							<th width="20%">商品名称</th>
							
							<th width="5%">净含量</th>
							<th width="5%">规格</th>
							<th width="5%">价格</th>				
							<th width="5%">库存</th>							
							<th width="5%">数量</th>
							<th width="15%">合作过的<br/>供应商</th>			
							<th width="15%">所有供应商</th>	
						
								</tr>
        					</thead>
                            <?
                                foreach($goods as $key=>$value){
                            ?>
                            <tr>
							<td><?=$value['title']?>&nbsp;<?if(!empty($value['imgpath'])){?><img width=50 height=50   src="<?=$value["imgpath"]?>"><?}?></td>
							<td><?=$value['percent']?></td>
							<td><?=$value['specs']?></td>
							<td><?=$value['costprice']?></td>	
							<td><?=$value['number']?></td>
							<td>
							<?=$value['num']?>
							</td>
							
							<td>
								<?$tag=true;?>
								<?if($value['supply']){?>
								<select name="oldsupply_<?=$value['cartid']?>" onchange="changesupply(this.value,'<?=$value['uuid']?>',<?=$value['cartid']?>)">
								<option value="0">合作过的供应商</option>
								<?foreach($value['supply'] as $val){?>
								<option value="<?=$val['supplyid']?>" <?if($val['supplyid']==$value['supplyid']){$tag=false;echo "selected";}?>><?=$val['title']?></option>
								<?}?>
								</select>
								<?}else{$tag=true;}?><br/>
								<span id="supplygoods_<?=$value['cartid']?>"></span>
							</td>
							<td>
								<select name="supply_<?=$value['cartid']?>">
								<option value="0">供应商</option>
								<?foreach($supply as $val){?>
								<option value="<?=$val['id']?>" <?if($tag && $val['id']==$value['supplyid']){echo "selected";}?>><?=$val['title']?></option>
								<?}?>
								</select>
								<input type="hidden" value="<?=$value['cartid']?>" name="cartid[]">
								<input type="hidden" value="<?=$value['num']?>" name="num[]">
								<input type="hidden" value="<?=$value['id']?>"  name="goodsid[]">
								<input type="hidden" value="<?=$value['price']?>" name="price[]">
							</td>
														
							</tr>
							
                           <?}?>
        				</table>
						<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
						        <button class="btn btn-primary"  >确认并提交&nbsp;&nbsp;<i class="icon-shopping-cart"></i></button>  
						</div>
        			</div>
        			</div>
        		</div>
        	</div>
        </div>
    </form>
	


</div>
</div>
</div>
<script>
//返回列表
	function returnList(){
		window.location.href='<?=$this->url("cash/plan")?>';
	}

</script>
