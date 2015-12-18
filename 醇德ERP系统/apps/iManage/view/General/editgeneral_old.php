
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
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("General/updategenral")?>'  id="login" name="login" method='post'>

					<div class="control-group">
						<label for="mobile" class="control-label">公司名称</label>
						<div class="controls">
                            <input type="text" name="data[company]" id="company" value="<?=!empty($re) ? $re["company"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">

                        </div>

					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">收货地址</label>
						<div class="controls">
                            <input type="text" name="data[address]" id="address" value="<?=!empty($re) ? $re["address"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">

                        </div>

					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">收货联系人</label>
						<div class="controls">
                            <input type="text" name="data[consignee]" id="consignee" value="<?=!empty($re) ? $re["consignee"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">

                        </div>

					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">收货人电话</label>
						<div class="controls">
                            <input type="text" name="data[phone]" id="phone" value="<?=!empty($re) ? $re["phone"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">

                        </div>

					</div>

					<div class="control-group">
						<label for="mobile" class="control-label">到达地址</label>
						<div class="controls">

                            <input type="text" name="data[arrive]" id="arrive" value="<?=!empty($re) ? $re["arrive"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-number="true" data-rule-minlength="1" >

                        </div>

					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">联系人</label>
						<div class="controls">
                            <input type="text" name="data[contact]" id="contact" value="<?=!empty($re) ? $re["contact"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">

                        </div>

					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">电话</label>
						<div class="controls">
                            <input type="text" name="data[telephone]" id="telephone" value="<?=!empty($re) ? $re["telephone"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">

                        </div>

					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">夏季价格</label>
						<div class="controls">
                            <input type="text" name="data[Summerprice]" id="Summerprice" value="<?=!empty($re) ? $re["Summerprice"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">

                        </div>

					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">元(吨)</label>
						<div class="controls">
                            <input type="text" name="data[milliontons]" id="milliontons" value="<?=!empty($re) ? $re["milliontons"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">

                        </div>

					</div>
					
					<div class="control-group">
						<label for="mobile" class="control-label">元(箱)</label>
						<div class="controls">
                            <input type="text" name="data[elementbox]" id="elementbox" value="<?=!empty($re) ? $re["elementbox"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">

                        </div>

					</div>

					<div class="control-group">
						<label for="mobile" class="control-label">运送时间</label>
						<div class="controls">
                            <input type="text" name="data[thetimeofreceipt]" id="thetimeofreceipt" value="<?=!empty($re) ? $re["thetimeofreceipt"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">

                        </div>

					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">冬季价格</label>
						<div class="controls">
                            <input type="text" name="data[pricesinwinter]" id="pricesinwinter" value="<?=!empty($re) ? $re["pricesinwinter"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">

                        </div>

					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">元(吨)</label>
						<div class="controls">
                            <input type="text" name="data[dunyuan]" id="dunyuan" value="<?=!empty($re) ? $re["dunyuan"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
                        </div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">元(箱)</label>
						<div class="controls">
                            <input type="text" name="data[xiangyuan]" id="xiangyuan" value="<?=!empty($re) ? $re["xiangyuan"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
                        </div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">运送时间</label>
						<div class="controls">
                            <input type="datetime" name="data[deliverytime]" id="deliverytime" value="<?=!empty($re) ? $re["deliverytime"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
                        </div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">类型</label>
						<div class="controls">
                            <select name="data[type]">

								<?foreach ($brand as $key => $vals) {?>
									<option value="<?=$vals?>" <?=!empty($re) && $re==$vals?'selected':''?>><?=$vals?></option>
								<?}?>
							</select>

                        </div>

					</div>
					<input type="hidden" class="btn btn-primary" name="id" value="<?= !empty($re)?$re['id']:''  ?>">
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
		window.location.href='<?=$this->url("goods/lists")?>';
	}

</script>
