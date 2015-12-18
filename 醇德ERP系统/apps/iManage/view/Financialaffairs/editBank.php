<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script> 
<section class="content-header">
	<h1>
		银行账户管理
		<small>编辑银行账户信息</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">财务管理</a></li>
		<li class="active">银行账户管理</li>
	</ol>
</section>
<section class="content">
	<form class='box form-validate form-confirm' action='<?=$this->url("Financialaffairs/editBank")?>'  id="login" name="login" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">请填写意向客户信息</h3>
			<div class="box-tools pull-right">
				<button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
			</div>
		</div><!-- /.box-header -->
		<div class="box-body row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="bankname">开户银行</label>
					<input type="text" name="data[bankname]" id="" value="<?=$one['bankname']?>" class="form-control"  data-rule-required="true" data-rule-minlength="1">
				</div>
				<div class="form-group">
					<label for="bankuser">开户用户名</label>
					<input type="text" name="data[bankuser]" id="port" value="<?=$one['bankuser']?>" class="form-control" data-rule-required="true"  data-rule-minlength="1">
				</div>
				<div class="form-group">
					<label for="banknum">开户账户</label>
					<input type="text" name="data[banknum]" id="sendaccount" value="<?=$one['banknum']?>" class="form-control" data-rule-required="true" data-rule-number="true"  data-rule-minlength="1">
				</div>
			</div>
		</div>
		<div class="box-footer">
			<input type="hidden" name="id" value="<?=$id?>">
			<input type="submit" class="btn btn-primary" value="确认修改">
			<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>
		</div>
	</form>
</section>
<script>
	function returnList(){
		window.location.href='<?=$this->url("Financialaffairs/banklist")?>';
	}
</script>