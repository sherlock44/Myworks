<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/imagesLoaded/jquery.imagesloaded.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/fileupload/bootstrap-fileupload.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<link rel="stylesheet" href="/public/adminlte/dist/css/fileupload.css">
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		商品品牌<small>编辑品牌信息</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"> <i class="fa fa-home"></i>ERP系统</a></li>
		<li><a href="javascript:returnList()">商品管理</a></li>
		<li class="active">商品品牌</li>
	</ol>
</section>
<section class="content">
	<form class="box box-default form-validate" action='<?php echo $this->url("goods/updatebrand");?>' id="myform" name="add_brand" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">请填写品牌信息</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="title">品牌名称-中文</label>
						<input type="text" name="data[title]" id="title" class="form-control" value="<?php echo !empty($re) ? $re["title"] : ''?>"
						data-rule-required="true" placeholder="请输入品牌中文名称" data-rule-minlength="1" autofocus/>
					</div>
					<div class="form-group">
						<label for="title_en">品牌名称-英文</label>
						<input type="text" name="data[title_en]" id="title_en" value="<?php echo !empty($re) ? $re["title_en"] : ''?>"
						class="form-control" data-rule-required="true" placeholder="请输入品牌英文名称" data-rule-minlength="1">
					</div>
					<div class="form-group">
						<label for="imagefile">品牌logo图片 [300px*300px]</label>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 150px; max-height: 150px;">
								<img src="<?php echo !empty($re) ? $re['icon'] : '/public/assets/sysadmin/img/200_200_no_image.gif'?>" /></div>
								<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
								<div style="margin-top:-10px; ">
									<span class="btn btn-default btn-sm btn-file">
										<span class="fileupload-new"><i class="fa fa-photo"></i> 浏览</span>
										<span class="fileupload-exists"><i class="fa fa-edit"></i> 重选</span>
										<input type="file" name="imagefile" id="imagefile" data-rule-required="true" />
									</span>
									<span class="btn btn-danger btn-sm fileupload-exists" data-dismiss="fileupload"><i class="fa fa-remove"></i> 移除</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="sort">排序</label>
							<input type="text" name="data[sort]" id="sort" value="<?php echo !empty($re) ? $re["sort"] : '0'?>" class="form-control"
							data-rule-required="true" data-rule-minlength="1" placeholder="请输入数字，排序由小到大排">
						</div>
						<div class="form-group">
							<label for="title">简介说明</label>
							<textarea rows="3" name="data[intro]" id="intro" class="form-control" placeholder="请输入简介说明"><?php echo !empty($re) ? $re['intro'] : ''?></textarea>
						</div>
					</div>
				</div>
				<!-- /.row -->
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<input type='hidden'  name="id" value="<?php echo !empty($re) ? $re['id'] : ''?>">
				<div class="form-actions">
					<button type="submit" class="btn btn-success" ><i class="fa fa-check"></i> 提交</button>
					<button class="btn btn-default" onclick='returnList()'><i class="fa fa-reply"></i> 返回</button>
				</div>
			</div>
		</form>
	</section>
	<script>
//返回列表
function returnList(){
	window.location.href='<?php echo $this->url("goods/brand")?>';
}
</script>