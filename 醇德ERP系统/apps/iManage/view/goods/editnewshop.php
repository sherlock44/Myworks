	<div id="main">
			<div class="container-fluid nopadding">
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/kindeditor-min.js"></script>
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/lang/zh_CN.js"></script>
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/php/upload_json.php"></script>
<script>
    var editor;
    KindEditor.ready(function(K) {
            editor = K.create('textarea[name="remark"]', {
                    allowFileManager : true,
                    afterBlur: function(){this.sync();}
            });
//            editor = K.create('textarea[name="basicinfo"]', {
//                    allowFileManager : true
//            });
//            editor = K.create('textarea[name="traffic"]', {
//                    allowFileManager : true
//            });
//            editor = K.create('textarea[name="service"]', {
//                    allowFileManager : true
//            });
//            editor = K.create('textarea[name="ambient"]', {
//                    allowFileManager : true
//            });
//            editor = K.create('textarea[name="special"]', {
//                    allowFileManager : true
//            });
    });
</script>	
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
			<a href=""><?=!empty($re)?"修改商品":"添加商品"?></a>
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
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("goods/updatenewshop")?>'  id="login" name="login" method='post'>
					
					<div class="control-group">
						<label for="mobile" class="control-label">商品名称</label>
						<div class="controls">
                            <input type="text" name="data[title]" id="title" value="<?=!empty($re) ? $re["title"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
                        
                        </div>
						
					</div>
				
					
					
					<div class="control-group">
						<label for="mobile" class="control-label">净含量</label>
						<div class="controls">
                            <input type="text" name="data[percent]" id="percent" value="<?=!empty($re) ? $re["percent"] : ''?>" data-rule-number="true" class="input-xlarge" data-rule-required="false" data-rule-minlength="0">
                        
                        </div>
						
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">规格</label>
						<div class="controls">
                            <input type="text" name="data[specs]" id="specs" value="<?=!empty($re) ? $re["specs"] : ''?>" data-rule-number="true" class="input-xlarge" data-rule-required="false" data-rule-minlength="0">
                        
                        </div>
						
					</div>
					
					
				
				
					
					
				
				
	
				
					
					
					<div class="control-group">
						<label for="mobile" class="control-label">商品品牌</label>
						<div class="controls">
                            <select name="data[branduuid]">
								<?foreach ($brand as $key => $vals) {?>
									<option value="<?=$vals['uuid']?>" <?=!empty($re) && $re['branduuid']==$vals['uuid']?'selected':''?>><?=$vals['title']?></option>
								<?}?>
							</select>

                        </div>
						
					</div>
					<div class="control-group">
						<label  class="control-label">所属系统类别</label>
						<div class="controls">
						<select name="data[categoryuuid]">
						<?=$trees?>
						</select>
						
						</div>
					</div>	
				
					
					 
				

					
       
				
				
				
				<div class="control-group">
						<label for="mobile" class="control-label">是否移入商品库</label>
						<div class="controls">
                            <select name="data[status]">
								
									<option value="1" <?=!empty($re) && $re['status']==1?'selected':''?>>是</option>
									<option value="0" <?=!empty($re) && $re['status']==0?'selected':''?>>否</option>
								
							</select>
                        (移入商品库后,需到商品管理列表编辑商品的其他信息)
                        </div>
						
				</div>
			
					
											
					
					<input type='hidden'  name="id" value='<?=!empty($re) ? $re['id']: ''?>'>
				
				
						
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
//返回列表
	function returnList(){
		window.location.href='<?=$this->url("goods/newlists")?>';
	}

</script>
