	<div id="main">
			<div class="container-fluid nopadding">
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/kindeditor-min.js"></script>
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/lang/zh_CN.js"></script>
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/php/upload_json.php"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/dynatree/ui.dynatree.css">
<script src="/public/assets/sysadmin/js/jquery.cookie.js"></script>
<script src="/public/assets/sysadmin/js/plugins/dynatree/jquery.dynatree.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/js/plugins/poshytip/tip-darkgray/tip-darkgray.css">
<script src="/public/assets/sysadmin/js/plugins/poshytip/jquery.poshytip.min.js"></script>
<script>
    var editor;
    KindEditor.ready(function(K) {
            editor = K.create('textarea[name="note"]', {
                    allowFileManager : true,
                    afterBlur: function(){this.sync();}
            });
    });
</script>	
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">库存管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">添加调拨申请</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script><div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>添加调拨申请
				</h3>
			</div>
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("cash/addtrans")?>'  id="login" name="login" method='post'>
					<div class="control-group">
						<label for="mobile" class="control-label">名称</label>
						<div class="controls">
							<input type="text" name="data[title]" id="title"   class="input-xlarge" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">					
						</div>
					</div>
					
					<div class="control-group">
						<label for="mobile" class="control-label">调拨主管</label>
						<div class="controls">
							<select name='data[zgid]' data-rule-required="true">
							<?foreach($admin as $val){?>
							<option value="<?=$val['id']?>"><?=$val['name']?></option>
							<?}?>
							</select>
						</div>
					</div>
					
					<div class="control-group">
						<label for="number" class="control-label">描述</label>
						<div class="controls">
							<textarea cols="700" rows="18" name="note" class="span12"><?=!empty($re) ? $re['remark']: ''?></textarea>
							(商品信息，数量，目的)
						</div>					
					</div>	
					<input type="hidden" value="<?=!empty($re)?$re['id']:''?>" name="id">
					<div class="form-actions">
					<input type="submit" class="btn btn-primary" value="添加" >					
					<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>					
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<script>
//返回列表
	function returnList(){
		window.location.href="<?=$this->url('cash/bank')?>";
	}

</script>
