	<div id="main">
			<div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">系统管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">平台设置</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="fa fa-close"></i></a>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>
                    平台设置
				</h3>
			</div>
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate' action='<?=$this->url("system/check")?>'  id="login" name="login" method='post'>
					<div class="control-group">
						<label class="control-label">网站名称</label>
						<div class="controls">
							<input type="text" name="data[websiteName]" id="websiteName" value="<?=(empty($re))?'':$re[0]['value']?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
						</div>
					</div>
					<div class="control-group">
						<label  class="control-label">网站地址</label>
						<div class="controls">
							<input type="text" name="data[url]" id="url" value="<?=(empty($re))?'':$re[1]['value']?>" class="input-xlarge" data-rule-required="false" data-rule-email="false" data-rule-minlength="1">
						</div>
					</div>
					<div class="control-group">
						<label  class="control-label">网站关键字</label>
						<div class="controls">
							<input type="text" name="data[keywords]" id="keywords" value="<?=(empty($re))?'':$re[2]['value']?>" class="input-xlarge" data-rule-required="false" data-rule-email="false" data-rule-minlength="1">
						</div>
					</div>
                    <div class="control-group">
						<label  class="control-label">商城简介</label>
						<div class="controls">
							<input type="text" name="data[description]" id="description" value="<?=(empty($re))?'':$re[3]['value']?>" class="input-xlarge" data-rule-required="false" data-rule-email="false" data-rule-minlength="1">
						</div>
					</div>
                    <!--<div class="control-group">
						<label class="control-label">文章底色</label>
						<div class="controls">
							
							<input type="text" name="color" value="" class="input-mini colorpick" id="textfield" >
						</div>
					</div>-->
					<div class="form-actions">
						<input type="submit" class="btn btn-primary" value="确认修改">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
</div>