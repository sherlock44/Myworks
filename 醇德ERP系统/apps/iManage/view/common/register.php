<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<title>注册|醇得系统管理平台</title>
<link rel="stylesheet" href="/public/assets/sysadmin/css/bootstrap.min.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/bootstrap-responsive.min.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/jquery-ui/smoothness/jquery-ui.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/jquery-ui/smoothness/jquery.ui.theme.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/themes.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/style.css">
<script src="/public/assets/sysadmin/js/jquery.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/jquery-ui/jquery-ui.custom.min.js"></script>
<script src="/public/assets/sysadmin/js/bootstrap.min.js"></script>
<script src="/public/assets/sysadmin/js/zjj_function.js"></script>
<script src="/public/assets/sysadmin/js/plugins/form/jquery.form.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/bootbox/jquery.bootbox.js"></script>
<script src="/public/assets/sysadmin/js/plugins/imagesLoaded/jquery.imagesloaded.min.js"></script>
<link rel="shortcut icon" href="/favicon.ico" />

</head>
<body class='login' style="background-image: url('/public/assets/sysadmin/img/1.jpg');background-repeat: no-repeat;background-position: center;">
	<div class="wrapper">
		<h1><a href="javascript:;">醇得系统管理平台</a></h1>
		<div class="login-body">
			<h2>注册</h2>
			<form action="" id="register" name="login" method='post'>
				<div class="username">
					<input type="text" name='username' id="username" placeholder="用户名" class='input-block-level'>
				</div>
				<div class="pwd">
					<input type="password" name="password" id="password" placeholder="密码" class='input-block-level'>
				</div>
				<div class="pwdconfirm">
					<input type="password" name="pwdconfirm" id="pwdconfirm" placeholder="再次输入密码" class='input-block-level'>
				</div>
				<div class="verify">
					<input type="text" name='verify' id="verify" placeholder="验证码" class='input-block-level'>
				</div>
				<div class="submit">
					<img src="/index.php/sysadmin/common/yzmCode" alt="验证码" class='retina-ready' width="100" style="margin-top: -13px;" title="点击更换验证码" onclick="$(this).attr('src','/index.php/sysadmin/common/yzmCode?'+ new Date().getTime())">
					<input type="submit" value="注册系统" class='btn btn-primary'>
				</div>
			</form>
		</div>
	</div>
	
</body>
</html>
<script type="text/javascript">
$('#register').submit(function(){
	var data = $("#register").serialize();
	$.ajax({
		//alert(data);
		type:'POST',
		url:'<?=$this->url("common/doregister")?>',
		data:data,
		dataType:'json',
		success:function(r){
			if(r.state == 1){
				//alert(r.url);
				window.location.href =r.url;
			}else{
			     $('.alert-error').remove();
				$('#register').before('<div class="alert alert-error"><button data-dismiss="alert" class="close" type="button">×</button><strong>'+r.info+'</strong></div>');
			}
		}
	});
	return false;
});
</script>