<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<section class="content-header">
	<h1>
		采购申请
		<small>发起采购申请</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> 后台管理</a></li>
		<li><a href="＃">采购管理</a></li>
		<li class="active">采购申请</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<form  class='box box-primary form-validate form-confirm' action='<?=$this->url("buyer/insertapply")?>' id="login" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">请填写采购申请内容</h3>
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
						<label for="title">名称</label>
						<input type="text" name="data[title]" id="title"   class="form-control" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
					</div>
					<div class="form-group">
						<label for="zgid">审批人</label>
						<select name='data[zgid]' class="form-control">
							<?foreach($admin as $val){?>
							<option value="<?=$val['id']?>"><?=$val['truename']?></option>
							<?}?>
						</select>
					</div>
					<div class="form-group">
						<label for="remark">描述</label>
						<textarea  name="remark" class="form-control"><?=!empty($re) ? $re['remark']: ''?></textarea>
						(商品信息，数量，目的)
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<input type="hidden" value="<?=!empty($re)?$re['id']:''?>" name="id">
			<input type="hidden" value="1" name='data[status]'>
			<button class="btn btn-success" type="submit"><i class="fa fa-check"></i> 提交</button>
			<button class="btn btn-default" type="button" onclick="returnList()"><i class="fa fa-reply"></i> 返回</button>
		</div>
	</form>
</section>
<script>
	function returnList(){
		window.location.href="<?=$this->url('buyer/apply')?>";
	}
</script>
