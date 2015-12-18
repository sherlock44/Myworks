<section class="content-header">
<h1>
	物流信息编辑
  <small>物流信息编辑</small>
</h1>
<ol class="breadcrumb">
  <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
  <li><a href="#">通用管理</a></li>
  <li class="active">物流信息编辑</li>
</ol>
</section>
<section class="content">
	<form class="box box-default form-validate" id="myform" action='<?=$this->url("General/updategenral")?>' method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">请填写信息</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="companystart">发货地物流公司名称</label>
	                    <input type="text" name="data[companystart]" id="companystart" value="<?=!empty($re) ? $re["companystart"] : ''?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
					</div>
					<div class="form-group">
						<label for="mobilestart">发货地物流公司电话</label>
	                    <input type="text" name="data[mobilestart]" id="mobilestart" value="<?=!empty($re) ? $re["mobilestart"] : ''?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
					</div>
					<div class="form-group">
						<label for="usernamestart">发货地物流公司联系人</label>
	                    <input type="text" name="data[usernamestart]" id="usernamestart" value="<?=!empty($re) ? $re["usernamestart"] : ''?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
					</div>
					<div class="form-group">
						<label for="summersmallprice">夏季价格(散货)</label>
						<div class="input-group">
		                   	<span class="input-group-addon">¥</span>
		                    <input type="text" name="data[summersmallprice]" id="summersmallprice" value="<?=!empty($re) ? $re["summersmallprice"] : ''?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
		                    <span class="input-group-btn">
		                      <button class="btn btn-default btn-flat" type="button">元/箱</button>
		                    </span>
		                    <!-- <span class="input-group-addon">元/箱</span> -->
	                  	</div>
	                </div>
					<div class="form-group">
						<label for="summerbigprice">夏季价格(散货)</label>
						<div class="input-group">
							<span class="input-group-addon">¥</span>
	                    	<input type="text" name="data[summerbigprice]" id="summerbigprice" value="<?=!empty($re) ? $re["summerbigprice"] : ''?>" class="form-control" data-rule-required="true" data-rule-number="true" data-rule-minlength="1">
							<span class="input-group-btn">
		                      <button class="btn btn-success btn-flat" type="button">元/吨</button>
		                    </span>
	                  	</div>
					</div>
					<div class="form-group">
						<label for="mobile">冬季价格(散货)</label>
						<div class="input-group">
		                   	<span class="input-group-addon">¥</span>
		                    <input type="text" name="data[sinwintersmallprice]" id="sinwintersmallprice" value="<?=!empty($re) ? $re["sinwintersmallprice"] : ''?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
							<span class="input-group-btn">
		                      <button class="btn btn-default btn-flat" type="button">元/箱</button>
		                    </span>
	                  	</div>
                  	</div>
					<div class="form-group">
						<label for="mobile">冬季价格(散货)</label>
						<div class="input-group">
							<span class="input-group-addon">¥</span>
	                    	<input type="text" name="data[sinwinterbigprice]" id="sinwinterbigprice" value="<?=!empty($re) ? $re["sinwinterbigprice"] : ''?>" class="form-control" data-rule-required="true" data-rule-number="true" data-rule-minlength="1">
	                    	<span class="input-group-btn">
		                      <button class="btn btn-success btn-flat" type="button">元/吨</button>
		                    </span>
	                  	</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.box-body -->
		<div class="box-footer">
			<div class="form-actions">
				<input type="hidden" name="id" value="<?= !empty($re)?$re['id']:''  ?>">
				<input type="submit" class="btn btn-primary" value="提交" >
				<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>
			</div>
		</div>
	</form>
</section>

<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<script>
//返回列表
	function returnList(){
		window.location.href='<?=$this->url("goods/lists")?>';
	}
</script>
