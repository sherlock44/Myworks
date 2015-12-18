<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<section class="content-header">
	<h1>
		单品管理
		<small>批量修改商品分类</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> ERP系统</a></li>
		<li><a href="<?=$this->url('goods/lists')?>">商品管理</a></li>
		<li class="active">单品管理</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<form  class='box box-primary form-validate' action='<?=$this->url("messageremind/edituser")?>'  id="login" name="login" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">请选择当前分类信息后再修改</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<div class="row">
				<!-- left column -->
				<div class="col-md-6">
					<!-- general form elements -->
					<div class="form-group">
						<label for="categoryuuid">商品当前分类</label>
						<select name="categoryuuid" class="form-control" onchange="javascript:window.location.href='/index.php/iManage/goods/changeshopcategory?categoryuuid='+this.value">
							<option value="0">选择移除商品的分类</option>
							<?foreach($category as $k=>$val){?>
							<option value="<?=$val['uuid']?>" <?if($val['uuid']==$sid){echo "selected";}?>><?=$val['title']?></option>
							<?}?>
						</select>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th width="40">
								<input type="checkbox" id="allcheck" onclick="checkall()">
							</th>
							<th>商品类别</th>
							<th>商品名称</th>
							<th>图片</th>
							<th>商品条码</th>
							<th>保质期(月)</th>		
							<th>单品重量</th>
							<th>装箱规格</th>
							<th>状态</th>
						</tr>
					</thead>
					<tbody>
						<?foreach ($re as $value) {?>
						<tr>
							<td><input type="checkbox" value="<?=$value['id']?>" class="goodsid" name="goodsid[]"></td>
							<td><?=$value['fctitle']?></td>
							<td><?=$value['title']?></td>
							<td><img width=25 height=25   src="<?=empty($value["imgpath"])?"/public/assets/sysadmin/img/200_200_no_image.gif":$value["imgpath"]?>"></td>
							<td><?=$value['barcode']?></td>
							<td><?=$value['shelflife']?></td>
							<td><?=$value['weight']?>g/<?=$value['specs']?></td>	
							<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>			
							<td>
								<?switch ($value['status']){
									case 0:
									echo "<span class='label label-red'>下架</span>";
									break;
									case 1:
									echo "<span class='label label-success'>上架</span>";
									break;
								}?>
							</td>
						</tr>
						<?}?>	
					</tbody>
				</table>
			</div>
			<div class="row">
				<!-- left column -->
				<div class="col-md-6">
					<!-- general form elements -->
					<div class="form-group">
						<label for="categoryuuid2">修改后的商品分类</label>
						<select name="categoryuuid2" clas="form-control">
							<option value="0">选择所属分类</option>
							<?foreach($category as $k=>$val){?>
							<option value="<?=$val['uuid']?>"><?=$val['title']?></option>
							<?}?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<button class="btn btn-success" type="submit"><i class="fa fa-check"></i> 提交</button>
			<button class="btn btn-default" type="button" onclick="returnList()"><i class="fa fa-reply"></i> 返回</button>
		</div>
	</form>
</section>
<script>
//返回列表
function returnList(){
	window.location.href='<?php echo $this->url("goods/lists")?>';
}
function checkall(){
	if($("#allcheck").is(":checked")){
	//$(".goodsid").attr("checked", true);
		$(".goodsid").each(function(){
			this.checked=true;
		});
	}else{
		// $(".goodsid").removeAttr("checked");
		$(".goodsid").each(function(){
			this.checked=false;
		});
	}
}
</script>