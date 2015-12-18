
<section class="content-header">
	<h1>
		单品管理
		<small>根据商品类型批量导入数据</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">商品管理</a></li>
		<li class="active">单品管理</li>
	</ol>
</section>
<section class="content">
	<form class="box box-default form-validate" action='<?php echo $this->url("goods/goodsin");?>' id="myform" enctype="multipart/form-data" name="add_brand" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">请选择相应的分类和文件</h3>
			<div class="box-tools pull-right">
				<a class="btn btn-default btn-sm" href="/data/moban.xls"><i class="fa fa-download"></i> 
					下载模板
				</a>
			</div>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="uuid">商品分类</label>
							<select class="form-control" name="uuid">
							<option value="0">选择所属分类</option>
							<?foreach($category as $k=>$val){?>
								<option value="<?=$val['uuid']?>"><?=$val['title']?></option>
							<?}?>
							</select>
					</div>
					<div class="form-group">
						<label class="control-label">导入的excel文件</label>
						<input type="file" class="form-controls" name="excel" value="" >
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
	<form class="box box-default form-validate" action='<?php echo $this->url("goods/goodsintime");?>' id="myform" enctype="multipart/form-data" name="add_brand" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">导入商品保质期至</h3>
			<div class="box-tools pull-right">
				<a class="btn btn-default btn-sm" href="/data/baozhiqi.xls"><i class="fa fa-download"></i> 
					下载模板
				</a>
			</div>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">导入的excel文件<span style="color:red;">excel表中所有数据格式存储格式为文本形式</span></label>
						<input type="file" class="form-controls" name="excel" value="" >
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
	window.location.href='<?php echo $this->url("goods/lists")?>';
}
</script>
