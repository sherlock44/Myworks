<div id="main">
<div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="javascript:void(0);">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="javascript:void(0);">系统管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="javascript:void(0);"><?=empty($id)?'添加报价':'修改报价'?></a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="javascript:void(0);"><i class="fa fa-close"></i></a>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i> <?=empty($id)?'添加报价':'修改报价'?>
				</h3>
			</div>
			<div class="box-content nopadding">
				<form action="<?=$this->url("system/offerSheetEdit")?>" method="POST" class='form-horizontal form-bordered form-validate' id="bb">
				    <div class="control-group">
						<label for="serialnumber" class="control-label">名称</label>
						<div class="controls">
							<input type="text" name="data[name]" value="<?=empty($re)?'':$re['name']?>" class="input-xlarge" />
						</div>
					</div>
					<div class="control-group">
						<label for="userid" class="control-label">单价</label>
						<div class="controls">
							<input type="text" name="data[price]" value="<?=empty($re)?'':$re['price']?>" class="input-xlarge" />
						</div>
					</div>
					<div class="control-group">
						<label for="userid" class="control-label">状态</label>
						<div class="controls">
						    <select name="data[status]" class="input-xlarge">
                                <option value="1" <?=!empty($re)&&$re['status']==1?'selected':''?> >有效</option>
                                <option value="0" <?=!empty($re)&&$re['status']==0?'selected':''?> >无效</option>
                            </select>
                        </div>
					</div>
                    <input type="hidden" name="id" value="<?=empty($re)?'0':$re['id']?>" />
					<div class="form-actions">
						<input type="submit" id="edit" class="btn btn-primary" value="提交"  style="width: 60px;" />
                        <input type="button" id="frist" class="btn btn-primary" value="返回" style="width: 60px;" />
					</div>
				</form>
			</div>	
		</div>
	</div>
</div>
</div>
</div>
<script>
    $('#frist').click(function(){
        window.history.go(-1);
    });
</script>	