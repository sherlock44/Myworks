<section class="content-header">
	<h1>
		库房设置
		<small>新增库房</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">参数设置</a></li>
		<li class="active">库房设置</li>
	</ol>
</section>
<section class="content">
	<form  class='box box-primary form-validate' action='<?=$this->url("preferences/inserthouse")?>' id="myform" method='post'>
		<div class="box-header with-border">
			<h3 class="box-title">请填写库房信息</h3>
			<div class="box-tools pull-right">
				<button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
			</div>
		</div><!-- /.box-header -->
		<div class="box-body">
			<div class="row">
				<!-- left column -->
				<div class="col-md-6">
					<!-- general form elements -->
					<div class="form-group">
						<label for="title" class="control-label">名称设置</label>
						<input type="text" name="data[title]" id="title" class="form-control" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
					</div>
					<div class="form-group">
						<label for="cityid" class="control-label">区域</label>
						<div class="controls">
							<select id="proviceid" name='data[proviceid]' class="form-control" onchange="changesheng(this.value)">
								<option value="0">选择省份</option>
								<?foreach($sheng as $val){?>
								<option value="<?=$val['id']?>" ><?=$val['name']?></option>
								<?}?>
							</select>
							<br />
							<select name='data[cityid]' id="cityid" class="form-control">
								<option value="0">选择城市</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="address" class="control-label">地址</label>
						<textarea name="data[address]" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<label for="number" class="control-label">库房楼层</label>
						<div class="input-group">
							<input type="text" name="data[number]" id="number" class="form-control" data-rule-required="true" data-rule-number="true" data-rule-minlength="1">
							<span class="input-group-btn">
								<button class="btn btn-default btn-flat" type="button">只能输入数字</button>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="rows" class="control-label">楼层库位行数</label>
						<div class="input-group">
							<input type="text" name="data[rows]" id="rows" class="form-control" data-rule-required="true" data-rule-number="true" data-rule-minlength="1">
							<span class="input-group-btn">
								<button class="btn btn-default btn-flat" type="button">只能输入数字</button>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="cols" class="control-label">楼层库位列数</label>
						<div class="input-group">
							<input type="text" name="data[cols]" id="cols" class="form-control" data-rule-required="true" data-rule-number="true" data-rule-minlength="1">
							<span class="input-group-btn">
								<button class="btn btn-default btn-flat" type="button">只能输入数字</button>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="remark" class="control-label">备注</label>
						<textarea name="data[remark]" class="form-control" rows="3"></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<input type="hidden" value="<?=!empty($re)?$re['id']:''?>" name="id">
			<button class="btn btn-success" type="submit"><i class="fa fa-check"></i> 提交</button>
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
	window.location.href="<?=$this->url('preferences/house')?>";
}
function changesheng(val){
	if(val==0){return false;}
	$.ajax({
		url:"<?=$this->url('preferences/getcity')?>",
		data:"parentid="+val,
		type:"post",
		success:function(r){
			$("#cityid").html(r);
		}
	});
}
</script>
