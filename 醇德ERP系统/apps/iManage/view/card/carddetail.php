<section class="content-header">
	<h1>
		会员卡列表
		<small>会员卡详情</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">会员卡管理</a></li>
		<li class="active">会员卡列表</li>
	</ol>
</section>
<section class="content">
	<form class="box box-default form-validate" action=''  id="myform" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">会员卡详情</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="row">
				<div class="col-xs-6">
					<div class="form-group">
						<label for="mobile">会员卡卡号</label>
						<input type="text" value="<?=$re['cardnum']?>" class="form-control" data-rule-required="true" data-rule-minlength="1" readonly>
					</div>
					<div class="form-group">
						<label for="mobile">会员卡类型</label>
						<input type="text" value="<?=$card[$re['cardtype']]?>" class="form-control" data-rule-required="true" data-rule-minlength="1" readonly>
					</div>
					<div class="form-group">
						<label for="mobile">持卡人姓名</label>
						<input type="text" value="<?=$re['truename']?>" class="form-control" data-rule-required="true" data-rule-minlength="1" readonly>
					</div>
					<div class="form-group">
						<label for="mobile">持卡人电话</label>
						<input type="text" value="<?=$re['mobile']?>" class="form-control" data-rule-required="true" data-rule-number="true" data-rule-minlength="1" readonly>
					</div>
					<div class="form-group">
						<label for="mobile">持卡人生日</label>
						<input type="text" value="<?=$re['birthdaytime']?>" class="form-control" data-rule-required="true" data-rule-minlength="1" readonly>
					</div>
					<div class="form-group">
						<label for="mobile">持卡人联系地址</label>
						<input type="text" value="<?=$re['address']?>" class="form-control" data-rule-required="true" data-rule-minlength="1" readonly>
					</div>
					<div class="form-group">
						<label for="mobile">会员卡状态</label>
						<input type="text" value="<?=$re['status']=='1' ? '已激活' : '未激活'?>" class="form-control" data-rule-required="true" data-rule-minlength="1" readonly>
					</div>
					<div class="form-group">
						<label for="mobile">会员卡开通时间</label>
						<input type="text" value="<?=date('Y-m-d H:i:s',$re['opentime'])?>" class="form-control" data-rule-required="true" data-rule-minlength="1" readonly>
					</div>
					<div class="form-group">
						<label for="mobile">会员卡过期时间</label>
						<input type="text" value="<?=date('Y-m-d H:i:s',$re['expirationtime'])?>" class="form-control" data-rule-required="true" data-rule-minlength="1" readonly>
					</div>
					<div class="form-group">
						<label for="number">会员卡备注</label>
						<input type="text" value="<?=$re['remark']?>" class="form-control" data-rule-required="true" data-rule-minlength="1" readonly>
						<!-- <textarea cols="700" rows="18" name="remark" class="span12"><?=$re['remark']?></textarea> -->
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<input type='hidden'  name="id" value=''>
			<button class="btn btn-default" type="button" onclick="returnList()"><i class="fa fa-reply"></i> 返回</button>
		</div>
	</form>
</section>
<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<script>
//返回列表
function returnList(){
	window.location.href='<?=$this->url("card/cardlist?type=0")?>';
}
</script>
