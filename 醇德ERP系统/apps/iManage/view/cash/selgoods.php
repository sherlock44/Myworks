					<div id="main">
			<div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="javascript:;">采购管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">商品管理</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
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
					<i class="icon-th-list"></i>
					商品列表
				</h3>
			
				
			</div>
			<div class="box-content nopadding">
				<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
				<?
				if($apply['type']==1){//补货采购
				?>
				<div id="DataTables_Table_0_length" class="dataTables_length" style="height:36px;">				
					<form action="<?=$this->url("cash/selgoods")?>" method="GET"  id="bb">
					<div class="row-fluid"  style="width:1000px;height:5px;">
						
							
                       
						<div class="span2 ">
                            <div class="control-group">                                
                                <div class="controls controls-row">
                                     <select name='categoryuuid' id='categoryuuid' class="input-block-level">					
									 <option value='' <?=isset($_GET['categoryuuid'])&&$_GET['categoryuuid']==''?"selected":""?> >商品分类</option>
									  <?=$trees?>
									 </select>
                                </div>
                            </div>
                       </div>
						<div class="span2 ">
                            <div class="control-group">                                
                                <div class="controls controls-row">
                                     <select name='branduuid' id='branduuid' class="input-block-level">					
									 <option value='' <?=isset($_GET['branduuid'])&&$_GET['branduuid']==''?"selected":""?> >全部品牌</option>
									 <?foreach($brand as $val){?>
										<option value='<?=$val['id']?>' <?=isset($_GET['branduuid'])&&$_GET['branduuid']==$val['id']?"selected":""?> ><?=$val['title']?></option>
									 <?}?>
									 </select>
                                </div>
                            </div>
                       </div>					   
						<div class="span3">
                            <div class="control-group">                                
                                <div class="controls controls-row">
                                     <input  id="userphone" name="userphone" class="input-block-level" type="text" placeholder="商品名称/商品编号" value="<?=$userphone?>">                              	
                                    
                                </div>
                            </div>
                       </div>
                      
                        <div class="span1"> 
									<input type="hidden" value="<?=$id?>" name="id" >
                                    <input type="submit" class="btn btn-primary" value="搜索">                             
                       </div>                       
				</div>
					
					
                   </form>
                   </div>
				   
				   <?}?>
			<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("cash/addcart")?>'  id="logins" name="logins" method='post'>
				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
					<thead>
						<tr>
							
							<th width="10%">商品名称</th>
							<th width="10%">商品编号</th>
							<th width="10%">商品分类</th>
							<th width="10%">商品品牌</th>
							<th width="10%">净含量</th>
							<th width="10%">规格</th>
							<th width="5%">价格</th>		
							<th width="5%">库存</th>							
							<th width="15%">数量</th>
							<!--th width="10%">合作过的<br/>供应商</th>			
							<th >所有供应商</th-->			
					
						
						</tr>
					</thead>
					<tbody>
						<?foreach ($re as $value) {?>
						<tr>
						
							<td><?=$value['title']?>&nbsp;<img width=50 height=50   src="<?=$value["imgpath"]?>"></td>
							<td><?=$value['barcode']?></td>
							<td><?=$value['fctitle']?></td>
							<td><?=$value['brandtitle']?></td>
							<td><?=$value['percent']?></td>
							<td><?=$value['specs']?></td>
							<td><?=$value['franchiseeprice']?></td>	
							<td><?=$value['number']?></td>
							<td>
							<input type="text" name="goodsnum_<?=$value['id']?>"  value="" class="span8" data-rule-required="false" data-rule-number="true" data-rule-minlength="1" placeholder="只能填数字">
							<input type="hidden" name="goodsid[]" value="<?=$value['id']?>">
							</td>	
							<!--td>
							<?if($value['supply']){?>
							<select name="">
							<option value="0">合作过的供应商</option>
							<?foreach($value['supply'] as $val){?>
							<option value="<?=$val['supplyid']?>"><?=$val['title']?></option>
							<?}?>
							</select>
							<?}?>
							</td>
							<td>
							<select name="">
							<option value="0">供应商</option>
							<?foreach($supply as $val){?>
							<option value="<?=$val['id']?>"><?=$val['title']?></option>
							<?}?>
							</select>
							</td-->
							
										
							
						
							
						</tr>
					<?}?>	
					</tbody>
				</table>
				<input type="hidden" value="<?=$id?>" name="id" >
				 </form>
				<div class="dataTables_info" id="DataTables_Table_0_info">
				<button class="btn btn-success" onclick="formcarttj()" ><i class="icon-ambulance"></i>&nbsp;&nbsp;确认采购</button>
				<button class="btn btn-primary" onclick="javascript:window.location.href='<?=$this->url("cash/cartlist",array('applyid'=>$id))?>'" ><i class="icon-shopping-cart"></i>&nbsp;&nbsp;采购列表</button>
				</div>
				<?=$pageHtml?>
			</div>
			
			</div>
			
		</div>
	</div>
</div>
</div></div>
<script>
	function formcarttj(){
		$("#logins").submit();
	
	}

</script>