<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<section class="content-header">
	<h1>
		当前库存管理
		<small>修改商品价格</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">库存管理</a></li>
		<li class="active">当前库存管理</li>
	</ol>
</section>
<section class="content">
	<form  class='box box-primary form-validate' action='<?=$this->url("stock/updateshop")?>'  id="login" name="login" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">请填写商品价格</h3>
			<div class="box-tools pull-right">
				<button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
			</div>
		</div><!-- /.box-header -->
		<div class="box-body">
			<div class="row">
				<!-- left column -->
				<div class="col-md-6">
					<div class="form-group">
						<label for="mobile">商品名称(中文)</label>
						<br>
						<?=!empty($re) ? $re["title"] : ''?>
					</div>
					<div class="form-group">
						<label for="mobile">商品条码</label>
						<br>
						<?=!empty($re) ? $re["barcode"] : ''?>
					</div>
					<div class="form-group">
						<label for="mobile">建议售价</label>
						<div class="input-group">
							<span class="input-group-addon">
								¥
							</span>
							<input class="form-control" type="text" name="data[suggestprice]" id="suggestprice" value="<?=!empty($re) ? $re["suggestprice"] : ''?>" data-rule-number="true" data-rule-required="true" data-rule-minlength="1">
						</div>
					</div>
					<?foreach($supplytype as $key=>$val){?>
					<div class="form-group">
						<label for="mobile"><?=$val['title']?>价格</label>
						<div class="input-group">
							<span class="input-group-addon">
								¥
							</span>
							<input class="form-control" type="text" name="supplyprice[]" id="price" value="<?=!empty($val) ? $val["price"] : ''?>" data-rule-number="true" data-rule-required="true" data-rule-minlength="1">
							<input type="hidden" name="supplytypeid[]" value="<?=$val['id']?>"></div>
						</div>
						<?}?>
						<div class="form-group">
							<label for="mobile">临期预警(天)</label>
							<input class="form-control" type="text" name="data[beoverdue]" id="beoverdue" value="<?=!empty($re) ? $re["beoverdue"] : ''?>" data-rule-number="true" data-rule-required="false" data-rule-number="true" data-rule-minlength="1" placeholder="只能填数字">
						</div>
						<div class="form-group">
							<label for="mobile">临期价格</label>
							<div class="input-group">
								<span class="input-group-addon">
									¥
								</span>
								<input class="form-control" type="text" name="data[futureprice]" id="futureprice" value="<?=!empty($re) ? $re["futureprice"] : ''?>" data-rule-number="true" data-rule-required="false" data-rule-minlength="1">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<input type='hidden'  name="id" value='<?=!empty($re) ? $re['id']: ''?>'>
				<input type="submit" class="btn btn-success" value="提交" >					
				<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>	
			</div>
		</form>
	</section>
	<script>
//返回列表
function returnList(){
	window.location.href='<?=$this->url("stock/goodslists")?>';
}
</script>
