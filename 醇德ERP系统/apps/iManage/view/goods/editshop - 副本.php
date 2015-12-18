	<div id="main">
			<div class="container-fluid nopadding">
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/kindeditor-min.js"></script>
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/lang/zh_CN.js"></script>
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/php/upload_json.php"></script>
<script>   15008216771  
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
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("goods/updateshop")?>'  id="login" name="login" method='post'>
					
					<div class="control-group">
						<label for="mobile" class="control-label">商品名称</label>
						<div class="controls">
                            <input type="text" name="data[title]" id="title" value="<?=!empty($re) ? $re["title"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
                        
                        </div>
						
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">条型码</label>
						<div class="controls">
                            <input type="text" name="data[barcode]" id="barcode" value="<?=!empty($re) ? $re["barcode"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
                        
                        </div>
						
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">拼音码</label>
						<div class="controls">
                            <input type="text" name="data[pingyincode]" id="pingyincode" value="<?=!empty($re) ? $re["pingyincode"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
                        
                        </div>
						
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">供应商</label>
						<div class="controls">
                            <input type="text" name="data[supplier]" id="supplier" value="<?=!empty($re) ? $re["supplier"] : ''?>" class="input-xlarge" data-rule-required="false" data-rule-minlength="1">
                        
                        </div>
						
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">净含量</label>
						<div class="controls">
                            <input type="text" name="data[percent]" id="percent" value="<?=!empty($re) ? $re["percent"] : ''?>" data-rule-number="false" class="input-xlarge" data-rule-required="false" data-rule-minlength="0">
                        
                        </div>
						
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">规格</label>
						<div class="controls">
                            <input type="text" name="data[specs]" id="specs" value="<?=!empty($re) ? $re["specs"] : ''?>" data-rule-number="false" class="input-xlarge" data-rule-required="false" data-rule-minlength="0">
                        
                        </div>
						
					</div>
					
					<div class="control-group">
						<label for="mobile" class="control-label">保质期</label>
						<div class="controls">
                            <input type="text" name="data[shelflife]" id="shelflife" value="<?=!empty($re) ? $re["shelflife"] : ''?>" data-rule-number="true" class="input-xlarge" data-rule-required="true" data-rule-number="true" data-rule-minlength="1" placeholder="只能填数字">(天)
                        </div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">逾期下线</label>
						<div class="controls">
                            <input type="text" name="data[beoverdue]" id="beoverdue" value="<?=!empty($re) ? $re["beoverdue"] : ''?>" data-rule-number="true" class="input-xlarge" data-rule-required="false" data-rule-number="true" data-rule-minlength="1" placeholder="只能填数字">(天)
                        </div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">成本价(单价)</label>
						<div class="controls">
                            <input type="text" name="data[costprice]" id="costprice" value="<?=!empty($re) ? $re["costprice"] : ''?>" data-rule-number="true" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">元
                        
                        </div>
						
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">销售价</label>
						<div class="controls">
                            <input type="text" name="data[price]" id="price" value="<?=!empty($re) ? $re["price"] : ''?>" class="input-xlarge" data-rule-number="true" data-rule-required="true" data-rule-minlength="1">元
                        
                        </div>
						
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">加盟商进货价</label>
						<div class="controls">
                            <input type="text" name="data[franchiseeprice]" id="franchiseeprice" value="<?=!empty($re) ? $re["franchiseeprice"] : ''?>" class="input-xlarge" data-rule-number="true" data-rule-required="true" data-rule-minlength="1">元
                        
                        </div>
						
					</div>
					
					<div class="control-group">
						<label for="mobile" class="control-label">装箱量</label>
						<div class="controls">
                            <input type="text" name="data[boxnum]" id="boxnum" value="<?=!empty($re) ? $re["boxnum"] : '0'?>" class="input-xlarge" data-rule-number="true" data-rule-required="false" data-rule-number="true" data-rule-minlength="1" placeholder="只能填数字">(天)
                        </div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">整箱价格(元/箱)</label>
						<div class="controls">
                            <input type="text" name="data[boxprice]" id="boxprice" value="<?=!empty($re) ? $re["boxprice"] : ''?>" class="input-xlarge" data-rule-number="true" data-rule-required="false" data-rule-minlength="1">
                        
                        </div>
						
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">是否打折</label>
						<div class="controls">
                            <select name="data[isdiscount]">
								
									<option value="0" <?=!empty($re) && $re['isdiscount']==0?'selected':''?>>不打折</option>
									<option value="1" <?=!empty($re) && $re['isdiscount']==1?'selected':''?>>打折</option>
								
							</select>
                        
                        </div>
						
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">打折后的价格</label>
						<div class="controls">
                            <input type="text" name="data[discountprice]" id="discountprice" value="<?=!empty($re) ? $re["discountprice"] : '0'?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">元
                        
                        </div>
						
					</div>
	
					<div class="control-group">
						<label for="mobile" class="control-label">库存</label>
						<div class="controls">
                            <input type="text" name="data[number]" id="number" value="<?=!empty($re) ? $re["number"] : '0'?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
                        
                        </div>
						
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">库存上限</label>
						<div class="controls">
                            <input type="text" name="data[maxnumber]" id="maxnumber" value="<?=!empty($re) ? $re["maxnumber"] : '0'?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
                        </div>
					</div>
					<div class="control-group">
                            <label for="mobile" class="control-label">库存下限</label>
                            <div class="controls">
                                <input type="text" name="data[minnumber]" id="minnumber" value="<?=!empty($re) ? $re["minnumber"] : '0'?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
                            </div>
                     <div class="control-group">
                            <label for="mobile" class="control-label">预警下限</label>
                            <div class="controls">
                                <input type="text" name="data[numberone]" id="numberonr" value="<?=!empty($re) ? $re["numberone"] : '0'?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
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
                        <label for="textfield" class="control-label">图片</label>
                        <div class="controls">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 150px; max-height: 150px;"><img src="<?=!empty($re) ? $re['imgpath'] : '/public/assets/sysadmin/img/200_200_no_image.gif'?>" /></div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-file"><span class="fileupload-new">浏览</span><span class="fileupload-exists">重选</span>
									<input type="file" name='imagefile' />
									</span>
                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">移除</a>
                                </div>
                            </div>
                        </div>
                    </div>

					
       
				
				<div class="control-group">
						<label for="number" class="control-label">详情内容</label>
						<div class="controls">
							<textarea cols="700" rows="18" name="remark" class="span12"><?=!empty($re) ? $re['remark']: ''?></textarea>
						</div>
						
					</div>
				
				<div class="control-group">
						<label for="mobile" class="control-label">状态</label>
						<div class="controls">
                            <select name="data[status]">
								
									<option value="1" <?=!empty($re) && $re['status']==1?'selected':''?>>正常</option>
									<option value="0" <?=!empty($re) && $re['status']==0?'selected':''?>>禁止</option>
								
							</select>
                        
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
		window.location.href='<?=$this->url("goods/lists")?>';
	}

</script>
