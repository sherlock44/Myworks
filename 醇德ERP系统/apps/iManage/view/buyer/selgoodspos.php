<div id="main">
    <div class="container-fluid  nopadding">
       

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
			<a href="">库位选择</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="fa fa-close"></i></a>
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
        					<i class="icon-th-list"></i>
        					<?=$house['title']?>-库位设置
        				</h3>
                       
        			</div>
					
        			<div class="box-content nopadding" style="overflow: auto;">
					<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("buyer/goodspostj")?>'  id="logins" name="logins" method='post'>
						<?foreach($posarray as  $k=>$val){?>
        				<table class="table table-hover table-nomargin  table-bordered" width="100%">
							<thead><tr><th colspan="<?=$house['cols']?>"><?=$k+1?>楼</th></tr></thead>
                           <tbody id="table_plan">	
									<?foreach($val as $ke=>$v){?>
									 <tr>
            							<?foreach($v as $ve){?>
            							<td style="padding:0px;text-align:center;">
										<label for="label_<?=$ve['id']?>"><input type="checkbox" id="label_<?=$ve['id']?>" name="posid[]" value="<?=$ve['id']?>"  <?if(in_array($ve['id'],$goodspos)){echo "checked";}?>  >&nbsp;<?=$ve['myrows']?>行<?=$ve['colspan']?>列</label>
										<input type="hidden" name="id[]"  value="<?=$ve['id']?>" >
										</td>
										<?}?>
            							
									</tr>
									<?}?>
									
									</tbody>
        				</table>
						<?}?>
						<input type="hidden" name="ordernum" value="<?=$ordernum?>">
						<input type="hidden" name="goodsid" value="<?=$re['id']?>">
						<input type="hidden" name="houseid" value="<?=$house['id']?>">
						</form>
        			</div>
					
					<div class="box-content nopadding">
					<table class="table table-hover table-nomargin  table-bordered" width="100%">
					<tr><td colspan="9" style="text-align:center;"> <button class="btn btn-success" onclick="formcarttj()" >保存</button></td></td>
					</table>
					</div>
        		</div>
        	</div>
        </div>
    </div>
</div>
<script>
	function formcarttj(){
		
		$("#logins").submit();
	
	}
</script>	