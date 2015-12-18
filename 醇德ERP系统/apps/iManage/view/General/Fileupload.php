<link rel="stylesheet" href="/public/adminlte/dist/css/fileupload.css">
<section class="content-header">
<h1>
  文件管理
  <small>新增文件</small>
</h1>
<ol class="breadcrumb">
  <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> 后台管理</a></li>
  <li><a href="#">通用管理</a></li>
  <li class="active">文件管理</li>
</ol>
</section>
<section class="content">
	<form class="box box-default form-validate" id="myform" action='<?=$this->url("General/filupload")?>'>
		<div class="box-header">
			<h3 class="box-title">请选择要发送邮件的加盟商</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-xs-6">
              		<div class="form-group">
						<label for="name">文件名</label>
						<input type="text" name="data[name]" id="name" class="form-control" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
					</div>
					<div class="form-group">
						<label for="brief">简介</label>
						<textarea type="text" rows="5" name="data[brief]" id="brief" value="<?=!empty($re) ? $re["brief"] : ''?>" class="form-control" data-rule-required="true" data-rule-minlength="2"></textarea>
					</div>
					<div class="form-group">
                        <label for="document">文件</label>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 150px; padding:10px;"></div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="padding:10px;"></div>
							<div style="margin-top:-10px; ">
								<span class="btn btn-default btn-sm btn-file">
									<span class="fileupload-new"><i class="fa fa-file-o"></i> 浏览</span>
									<span class="fileupload-exists"><i class="fa fa-edit"></i> 重选</span>
									<input type="file" name="document" id="document" data-rule-required="true" />
								</span>
								<span class="btn btn-danger btn-sm fileupload-exists" data-dismiss="fileupload"><i class="fa fa-remove"></i> 移除</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.box-body -->
		<div class="box-footer">
			<div class="form-actions">
				<input type="hidden" name="data[categoryid]" value="<?=$categoryid?>">
				<input type="submit" class="btn btn-primary" value="提交" >
				<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>
			</div>
		</div>
	</form>
</section>
<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/imagesLoaded/jquery.imagesloaded.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/fileupload/bootstrap-fileupload.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<script>
//返回列表
	function returnList(){
		window.location.href='<?=$this->url("General/filemanage")?>';
	}

</script>
