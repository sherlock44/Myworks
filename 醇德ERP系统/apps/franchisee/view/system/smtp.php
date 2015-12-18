	<div id="main">
			<div class="container-fluid"><div class="page-header">
	<div class="pull-left">
		<h1>smtp设置</h1>
	</div>
	<div class="pull-right">
		<ul class="stats">
			<li class='lightred'>
				<i class="icon-calendar"></i>
				<div class="details">
					<span class="big"></span>
					<span></span>
				</div>
			</li>
		</ul>
	</div>
</div>
<script type="text/javascript">
function currentTime(){
	var $el = $(".stats .icon-calendar").parent(),
	currentDate = new Date(),
	monthNames = [1,2,3,4,5,6,7,8,9,10,11,12],
	dayNames = ["周日","周一","周二","周三","周四","周五","周六"];

	$el.find(".details span").html(currentDate.getFullYear() + " - " + monthNames[currentDate.getMonth()] + " - " + currentDate.getDate());
	$el.find(".details .big").last().html(currentDate.getHours()+":"+ ("0" + currentDate.getMinutes()).slice(-2) + ", " + dayNames[currentDate.getDay()]);
	setTimeout(function(){
		currentTime();
	}, 10000);
}
currentTime();
</script>
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$this->url('index/main')?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">系统管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">smtp设置</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script><div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>
				</h3>
			</div>
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate' action='<?=$this->url("system/setting_smtp")?>'  id="login" name="login" method='post'>
					
					<div class="control-group">
						<label for="password" class="control-label">发送邮件服务器地址</label>
						<div class="controls">
							<input type="text" name="data[smtpaddress]" id="smtpaddress" value="<?=!empty($re)?$re[4]['value']:''?>" class="input-xlarge" data-rule-url="true" data-rule-required="true" data-rule-minlength="2">
						</div>
					</div>
					<div class="control-group">
						<label for="password" class="control-label">服务器端口</label>
						<div class="controls">
							<input type="text" name="data[port]" id="port" value="<?=$re[5]['value']?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="2">
						</div>
					</div>
					<div class="control-group">
						<label for="password" class="control-label">邮件发送帐号</label>
						<div class="controls">
							<input type="text" name="data[sendaccount]" id="sendaccount" value="<?=$re[6]['value']?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="2">
						</div>
					</div>
					<div class="control-group">
						<label for="password" class="control-label">邮件回复地址</label>
						<div class="controls">
							<input type="text" name="data[returnaddress]" id="returnaddress" value="<?=$re[7]['value']?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="2">
						</div>
					</div>
					<div class="form-actions">
						<input type="submit" class="btn btn-primary" value="设置">&nbsp;&nbsp;&nbsp;
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<script>
//返回列表
	/*function control(){
		window.location.href='<?=$this->url("system/control")?>';
	}

	$('#login').submit(function(){
	var data = $("#login").serialize();
	$.ajax({
		type:'POST',
		url:'<?=$this->url("system/check_modify")?>',
		data:data,
		dataType:'json',
		success:function(r){
			if(r.state == 1){
				alert('修改成功');
				window.location.href="<?=$this->url('system/control')?>";
			}else{
				$('#login').before('<div class="alert alert-error"><button data-dismiss="alert" class="close" type="button">×</button><strong>'+r.info+'</strong></div>');
			}
		}
	});
	return false;
});*/
</script>