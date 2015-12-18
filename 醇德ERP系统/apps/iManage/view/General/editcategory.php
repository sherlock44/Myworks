<section class="content-header">
<h1>
  文件管理
  <small>编辑文件夹信息</small>
</h1>
<ol class="breadcrumb">
  <li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-dashboard"></i> 后台管理</a></li>
  <li><a href="#">通用管理</a></li>
  <li class="active">文件管理</li>
</ol>
</section>
<section class="content">
	<form class="box box-default form-validate" id="myform" action='<?=$this->url("General/updatecategory")?>'>
		<div class="box-header">
			<h3 class="box-title">
			<?foreach($this->filemenu as $k=>$val){?>
				<a href="<?=$this->url('General/filemanage',array('id'=>$val['id']))?>" rel="tooltip">&nbsp;<?=$val['title']?>&nbsp;&nbsp;</a>&gt;
			<?}?><?=!empty($re) ? $re["title"] : ''?>目录编辑</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-xs-6">
              		<div class="form-group">
						<label for="title">目录名称</label>
						<input type="text" name="data[title]" id="title" class="form-control" value="<?=!empty($re) ? $re["title"] : ''?>" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
					</div>
					<div class="form-group">
						<label for="remark">简介</label>
						<textarea type="text" rows="5" name="data[remark]" id="remark" class="form-control" data-rule-required="true" data-rule-minlength="2"><?=!empty($re) ? $re["remark"] : ''?></textarea>
					</div>
					<div class="form-group">
						<label for="sort">排序</label>
						<input type="text" name="data[sort]" id="sort" value="<?php echo !empty($re) ? $re["sort"] : '0'?>" class="form-control"
								data-rule-required="true" data-rule-minlength="1" placeholder="请输入数字，排序由小到大排">
					</div>
				</div>
			</div>
		</div>
		<!-- /.box-body -->
		<div class="box-footer">
			<div class="form-actions">
				<input type="hidden" name="id" value="<?=$re['id']?>" >
				<input type="submit" class="btn btn-primary" value="提交" >
				<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>
			</div>
		</div>
	</form>
</section>
<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<script>
//返回列表
	function returnList(){
		window.location.href='<?=$this->url("General/filemanage")?>';
	}

</script>