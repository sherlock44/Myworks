<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<section class="content-header">
	<h1>
		角色管理
		<small><?=!empty($re)?'编辑角色':'添加角色'?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">系统管理</a></li>
		<li class="active">角色管理</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<form  class='box box-primary form-validate'  enctype="multipart/form-data" action='<?=$this->url("system/check_role")?>'  id="myform" name="login" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">请填写权限名称</h3>
			<div class="box-tools pull-right">
				<button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
			</div>
		</div><!-- /.box-header -->
		<div class="box-body">
			<div class="row">
				<!-- left column -->
				<div class="col-md-6">
					<!-- general form elements -->
					<div class="form-group">
						<label for="titlesss">权限组名称</label>
						<input type="text" data-rule-minlength="1"  data-rule-required="true" class="form-control valid" value="<?=!empty($re)?$re['title']:''?>"  id="titlesss" name="data[title]">
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<input type="hidden" name="id" value="<?=!empty($re)?$re['groupid']:''?>">
			<button class="btn btn-success" type="submit"><i class="fa fa-check"></i> 提交</button>
			<button class="btn btn-default" type="button" onclick="returnList()"><i class="fa fa-reply"></i> 返回</button>
		</div>
	</form>
</section>
<script>
	function returnList(){
		window.location.href='<?=$this->url("system/role")?>';
	}
</script>