<section class="content-header">
	<h1>
		导入品牌<small>批量导入品牌数据</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"> <i class="fa fa-dashboard"></i>商品管理</a></li>
		<li><a href="javascript:returnList()">商品品牌</a></li>
		<li class="active">导入品牌</li>
	</ol>
</section>
<section class="content">
	<form class="box box-default form-validate" action='<?php echo $this->url("goods/brandin");?>' id="myform" enctype="multipart/form-data" name="add_brand" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">品牌信息</h3>
			<div class="box-tools pull-right">
				<a class="btn btn-default btn-sm" href="/data/moban.xls"><i class="fa  fa-cloud-download"></i> 
					下载模板
				</a>
			</div>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">导入的excel文件</label>
						<input type="file" class="form-controls" name="excel" id="username" value="" ><?=$str?>
					</div>
				</div>
			</div>
		</div>
		<!-- /.box-body -->
		<div class="box-footer">
			<input type='hidden'  name="id" value="<?php echo !empty($re) ? $re['id'] : ''?>">
			<button type="submit" class="btn btn-success" ><i class="fa fa-check"></i> 提交</button>
			<button class="btn btn-default" onclick='returnList()' type="button"><i class="fa fa-reply"></i> 返回</button>
		</div>
	</form>
</section>
<script>
//返回列表
function returnList(){
	window.location.href='<?php echo $this->url("goods/brand")?>';
}
</script>
