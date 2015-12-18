	<div id="main">
			<div class="container-fluid nopadding">

<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">商品管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href=""><?=!empty($re)?"修改品牌":"添加商品库位"?></a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="fa fa-close"></i></a>
	</div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script><div class="row-fluid">


<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/chosen/chosen.css">
<script src="/public/assets/sysadmin/js/plugins/chosen/chosen.jquery.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datetimepicker/datetimepicker.css">
<script src="/public/assets/sysadmin/js/plugins/datetimepicker/datetimepicker.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datetimepicker/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="/public/assets/sysadmin/js/plugins/kindeditor/kindeditor-min.js"></script>
<link rel="stylesheet" href="/public/js/plugins/kindeditor/themes/default/default.css" />
<script src="/public/assets/sysadmin/js/plugins/fileupload/bootstrap-fileupload.min.js"></script>
	
	<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>
				</h3>				
			</div>
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("stock/insertgoodsstore")?>'  id="login" name="login" method='post'>
					
					<div class="control-group">
						<label for="mobile" class="control-label">商品名称</label>
						<div class="controls">
                            <?=$goods['title']?>
                        
                        </div>
						
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">库房</label>
						<div class="controls">
                           <select id="houseid_<?=$goodsid?>" name="data[houseid]" onchange="changehouse(this.value)">
								<option value="0">选择库房</option>
									<?foreach($house as $val){?>
									<option value="<?=$val['id']?>" ><?=$val['title']?></option>
									<?}?>
								</select>
                        
                        </div>
						
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">库位</label>
						<div class="controls">
                          <select name="data[houseposid]" id="housepos">
									<option value="0">选择库位</option>
								</select>
                        
                        </div>
						
					</div>
					
				    <div class="control-group">
						<label for="password" class="control-label">数量</label>
						<div class="controls">
							<input type="text" name="data[num]" id="port"   class="input-xlarge" data-rule-required="true" data-rule-number="true" data-rule-minlength="1">
						</div>
					</div>
					
					
											
					
					<input type='hidden'  name="goodsid" value='<?=$goodsid?>'>
				
				
						
						<div class="form-actions">
						<input type="submit" class="btn btn-primary" value="提交" >					
						<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>					
						
						</div>
				</form>
			</div>
		</div>
	</div>
</div>


</div>
</div>
</div>

<script>
	function changehouse(houseid){
		
		if(houseid==0){
			var html	=	"<option value='0'>选择库位</option>";
			$("#housepos").html(html);
		}else{
			$.ajax({
				data:{houseid:houseid},
				url:"<?=$this->url('goods/getHousePos')?>",
				type:"post",
				dataType:"json",
				success:function(data){
					$("#housepos").html(data.html);
				
				}
			
			});
		}
	}
</script>	
