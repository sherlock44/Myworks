	<div id="main">
			<div class="container-fluid nopadding">


<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/dynatree/ui.dynatree.css">
<script src="/public/assets/sysadmin/js/jquery.cookie.js"></script>
<script src="/public/assets/sysadmin/js/plugins/dynatree/jquery.dynatree.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/js/plugins/poshytip/tip-darkgray/tip-darkgray.css">
<script src="/public/assets/sysadmin/js/plugins/poshytip/jquery.poshytip.min.js"></script>
<script>
	function changehouse(goodsid,houseposid,houseid){
		
		if(houseid==0){
			var html	=	"<option value='0'>选择库位</option>";
			$("#housepos_"+goodsid).html(html);
		}else{
			$.ajax({
				data:{goodsid:goodsid,houseid:houseid,houseposid:houseposid},
				url:"<?=$this->url('cash/getHousePos')?>",
				type:"post",
				dataType:"json",
				success:function(data){
					$("#housepos_"+data.goodsid).html(data.html);
				
				}
			
			});
		}
	
	
	}

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
			<a href="">商品入库</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
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
					<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("cash/goodstostoretj")?>'  id="formtj" name="formtj" method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        						<tr>
							
							<th width="10%">商品名称</th>
							<th width="10%">商品编号</th>
							
							
							
							<th width="10%">价格</th>
											
													
							
							<th width="15%">数量</th>
							<th width="15%">库房</th>
							<th width="15%">库位</th>
							
							
					
						
						</tr>
        					</thead>
                            <?
                                foreach($goods as $key=>$value){
                            ?>
                            <tr>
							
							<td><?=$value['title']?>&nbsp;<img width=50 height=50   src="<?=$value["imgpath"]?>"></td>
							<td><?=$value['barcode']?></td>
							<td><?=$value['price']?></td>	
						
							
							<td>
								<?=$value['num']?>
								<input type="hidden" name="id[]" value="<?=$value['id']?>">
								<input type="hidden" name="num[]" value="<?=$value['num']?>">
								<input type="hidden" name="goodsid[]" value="<?=$value['goodsid']?>">
							</td>
							<td>
								<select id="houseid_<?=$value['goodsid']?>" name="houseid[]" onchange="changehouse(<?=$value['goodsid']?>,<?=$value['houseposid']?>,this.value)">
								<option value="0">选择库房</option>
									<?foreach($house as $val){?>
									<option value="<?=$val['id']?>" <?if($value['houseid']==$val['id']){echo "selected";}?>><?=$val['title']?></option>
									<?}?>
								</select>
							</td>	
							<td >
								<select name="housepos[]" id="housepos_<?=$value['goodsid']?>">
									<option value="0">选择库位</option>
								</select>
							</td>							
							</tr>
							<?if($value['houseid']>0){?>
							<script>
							changehouse(<?=$value['goodsid']?>,<?=$value['houseposid']?>,<?=$value['houseid']?>);
							</script>
							<?}?>
                            <?
                                }
                            ?>
        				</table>
						<div class="dataTables_info" id="DataTables_Table_0_info">
						
						<select name="storeid">
							<option value="0">选择入库类型</option>
							<?foreach($setting as $val){?>
							<option value="<?=$val['id']?>"><?=$val['title']?></option>
							<?}?>
						</select>
						
						</div>
						<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
						<input type="hidden" name="applyid" value="<?=$id?>">
						<input type="hidden" id="tag" name="tag" value="0">
						
						 <button class="btn btn-primary" onclick="$('#tag').val(0);$('#formtj').submit();return false;" >部份保存</button> 
						 <button class="btn btn-primary"  onclick="$('#tag').val(1);$('#formtj').submit();return false;" >确认入库，采购完成</button>        
						</form>
						</div>
						
        			</div>
        			</div>
        		</div>
        	</div>
        </div>
    
	

	
	
	

</div>
</div>






