<link rel="stylesheet" href="/public/adminlte/dist/css/fileupload.css">
<section class="content-header">
	<h1>
		单品管理
		<small>编辑商品基本信息</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">商品管理</a></li>
		<li class="active">单品管理</li>
	</ol>
</section>
<section class="content">
	<form class="box box-default form-validate" id="myform" action='<?=$this->url("goods/updateshop")?>'>
		<div class="box-header with-border">
			<h3 class="box-title">请填写商品信息</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-xs-4">
					<div class="form-group">
						<label for="categoryuuid">所属系统类别</label>
						<select class="form-control" name="data[categoryuuid]">
							<?=$trees?>
						</select>
					</div>
					<div class="form-group">
						<label for="title">商品名称(中文)</label>
						<input type="text" name="data[title]" id="title" value="<?=!empty($re) ? $re["title"] : ''?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
					</div>
					<div class="form-group">
						<label for="barcode">商品条码</label>
						<div class="input-group">
							<input type="text" name="data[barcode]" id="barcode" value="<?=!empty($re) ? $re["barcode"] : ''?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
							<span class="input-group-btn">
								<button type="button" title="随机生成条码" rel="tooltip" class="btn btn-success btn-flat" onclick="getbarcode(<?=$re['id']?>)"><i class="fa fa-refresh"></i></button>
							</span>
						</div><!-- /input-group -->
					</div>
					<div class="form-group">
						<label for="pingyincode">拼音码</label>
						<input type="text" name="data[pingyincode]" id="pingyincode" value="<?=!empty($re) ? $re["pingyincode"] : ''?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
					</div>
					<div class="form-group">
						<label for="weight">商品重量</label>
						<div class="input-group">
							<input type="text" name="data[weight]" id="weight" value="<?=!empty($re) ? $re["weight"] : ''?>" data-rule-number="false" class="form-control" data-rule-required="false" data-rule-number="false" data-rule-minlength="1" placeholder="">
							<span class="input-group-btn">
								<button class="btn btn-default btn-flat">单位g(克)</button>
							</span>
						</div><!-- /input-group -->
					</div>
					<div class="form-group">
						<label for="shelflife">保质期</label>
						<div class="input-group">
							<input type="text" name="data[shelflife]" id="shelflife" value="<?=!empty($re) ? $re["shelflife"] : ''?>" data-rule-number="true" class="form-control" data-rule-required="true" data-rule-number="true" data-rule-minlength="1" placeholder="无保质期商品填“0”,只能填数字">
							<span class="input-group-btn">
								<button class="btn btn-default btn-flat">月</button>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="number">总库存</label>
						<div class="input-group">
						<input type="text" class="form-control" value="<?=!empty($re) ? $re["number"] : ''?>"  disabled>
						
							<span class="input-group-btn">
								<button class="btn btn-default btn-flat">箱</button>
							</span>
					</div>
					</div>
					<div class="form-group">
						<label for="status">状态</label>
						<select name="data[status]" class="form-control">
							<option value="1" <?=!empty($re) && $re['status']==1?'selected':''?>>上架</option>
							<option value="0" <?=!empty($re) && $re['status']==0?'selected':''?>>下架</option>
						</select>
					</div>
					<div class="form-group">
						<label for="explain">产品特点</label>
						<textarea  name="data[explain]" class="form-control"><?=!empty($re) ? $re['explain']: ''?></textarea>
					</div>
					<div class="form-group">
						<label for="remark">备注</label>
						<textarea  name="data[remark]" class="form-control"><?=!empty($re) ? $re['remark']: ''?></textarea>
					</div>
				</div>
				<div class="col-xs-4">
					<div class="form-group">
						<label for="branduuid">商品品牌</label>
						<select class="form-control" name="data[branduuid]">
							<?foreach ($brand as $key => $vals) {?>
							<option value="<?=$vals['uuid']?>" <?=!empty($re) && $re['branduuid']==$vals['uuid']?'selected':''?>><?=$vals['title']?></option>
							<?}?>
						</select>
					</div>
					<div class="form-group">
						<label for="title_en">商品名称(英文)</label>
						<input type="text" name="data[title_en]" id="title_en" value="<?=!empty($re) ? $re["title_en"] : ''?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
					</div>
					<div class="form-group">
						<label for="erpcode">商品编码</label>
						<div class="input-group">
							<input type="text" name="data[erpcode]" id="erpcode" value="<?=!empty($re) ? $re["erpcode"] : ''?>" class="form-control" data-rule-required="false" data-rule-minlength="1">
							<span class="input-group-btn">
								<button type="button" title="根据条码生成编码" rel="tooltip" class="btn btn-warning btn-flat" onclick="geterpcode(<?=$re['id']?>)"><i class="fa fa-refresh"></i></button>
							</span>
						</div><!-- /input-group -->
					</div>
					<div class="form-group">
						<label for="specs">单品单位</label>
						<input type="text" name="data[specs]" id="specs" value="<?=!empty($re) ? $re["specs"] : ''?>" class="form-control" data-rule-required="false" data-rule-minlength="0">
					</div>
					<div class="form-group">
						<label for="boxnum">装箱规格</label>
						<input type="text" name="data[boxnum]" id="boxnum" value="<?=!empty($re) ? $re["boxnum"] : ''?>" data-rule-number="true" class="form-control" data-rule-required="true" data-rule-number="true" data-rule-minlength="1" placeholder="只能填数字">
					</div>
					<div class="form-group">
						<label for="address">产地</label>
						<input  type="text" name="data[address]" id="address" value="<?=!empty($re) ? $re["address"] : ''?>"  class="form-control" data-rule-required="false" data-rule-minlength="1">
					</div>
					<div class="form-group">
						<label for="mobile">详情链接</label>
						<input type="text" class="form-control" name="data[goodsurl]" id="goodsurl" value="<?=!empty($re) ? $re["goodsurl"] : ''?>" class="form-control" data-rule-required="false" data-rule-minlength="1" placeholder="如:http://www.chunde001.com">
					</div>
					<div class="form-group">
						<label for="numberone">库存预警</label>
						<div class="input-group">
							<input type="text" class="form-control" name="data[numberone]" id="numberone" value="<?=!empty($re) ? $re["numberone"] : ''?>" class="form-control" data-rule-required="true" data-rule-minlength="1">
							<span class="input-group-btn">
								<button class="btn btn-default btn-flat">数量</button>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="imagefile">商品照片[300px*300px]</label>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 150px; max-height: 150px;">
								<img src="<?php echo !empty($re) ? $re['imgpath'] : '/public/assets/sysadmin/img/200_200_no_image.gif'?>" />
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
							<div style="margin-top:-10px; ">
								<span class="btn btn-default btn-sm btn-file">
									<span class="fileupload-new"><i class="fa fa-photo"></i> 浏览</span>
									<span class="fileupload-exists"><i class="fa fa-edit"></i> 重选</span>
									<input type="file" name="imagefile" id="imagefile" />
								</span>
								<span class="btn btn-danger btn-sm fileupload-exists" data-dismiss="fileupload"><i class="fa fa-remove"></i> 移除</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-4">
					<div class="form-group">
						<label>建议售价</label>
						<div class="input-group">
							<span class="input-group-addon">¥</span>
							<input type="text" class="form-control" value="<?=!empty($re) ? $re["suggestprice"] : ''?>" disabled>
						</div>
					</div>
					<?foreach($supplytype as $key=>$val){?>
					<div class="form-group">
						<label><?=$val['title']?>价格</label>
						<div class="input-group">
							<span class="input-group-addon">¥</span>
							<input type="text" class="form-control" value="<?=!empty($val) ? $val["price"] : ''?>" disabled>
						</div>
					</div>
					<?}?>
					<div class="form-group">
						<label for="mobile">临期预警(天)</label>
						<div class="input-group">
							<input type="text" class="form-control" value="<?=!empty($re) ? $re["beoverdue"] : ''?>" disabled>
							<span class="input-group-addon">天</span>
						</div>
					</div>
					<div class="form-group">
						<label for="mobile">临期价格</label>
						<div class="input-group">
							<span class="input-group-addon">¥</span>
							<input type="text" class="form-control" value="<?=!empty($re) ? $re["futureprice"] : ''?>" disabled>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div class="form-actions">
					<input type="hidden" name="id" value="<?=$id?>">
					<input type="submit" class="btn btn-primary" value="提交" >
					<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>
				</div>
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
	window.location.href='<?=$this->url("goods/lists")?>';
}
//生成条码
function getbarcode(id){
	$.ajax({
		data:"id="+id,
		url:"<?=$this->url('goods/getbarcode')?>",
		dataType:"json",
		type:"post",
		success:function(r){
			$("#barcode").val(r.barcode);
		}
	});
}
//生成编码
function geterpcode(id){
	var barcode=	$("#barcode").val();
	$.ajax({
		data:"id="+id+"&barcode="+barcode,
		url:"<?=$this->url('goods/geterpcode')?>",
		dataType:"json",
		type:"post",
		success:function(r){
			if(r.state == 1){
				$("#erpcode").val(r.erpcode);
			}else{
				pub_alert_error(r.info);
			}
		}
	});
}
</script>
