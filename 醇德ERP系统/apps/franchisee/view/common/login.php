<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<title>加盟商采购平台</title>
<link rel="stylesheet" href="/public/adminlte/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="/public/adminlte/dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="/public/adminlte/plugins/iCheck/square/blue.css">
<link rel="shortcut icon" href="/favicon.ico" />
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#">
        加盟商采购平台
      </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">请输入您的用户名和密码</p>
      <form action="" id="login" name="login" method="post">
        <div class="form-group has-feedback">
          <input type="text" id="username" name="username" placeholder="用户名" class="form-control" >
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password"  name="password" id="password"  placeholder="密码" class="form-control">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="text" name='verify' id="verify" placeholder="验证码" class="form-control">
          <span class="glyphicon glyphicon-qrcode form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <div class="checkbox icheck">
              <label>
                <img src="/index.php/franchisee/common/yzmCode" alt="验证码" class='retina-ready' width="100" style="margin-top: -13px;" title="点击更换验证码" onclick="$(this).attr('src','/index.php/franchisee/common/yzmCode?'+ new Date().getTime())"></label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">登陆</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <a href="#">忘记密码？</a><br>
    </div>
    <a style="margin-top:10px;margin-left:16%" class="btn btn-primary" href="http://download.firefox.com.cn/releases/stub/official/zh-CN/Firefox-latest.exe">火狐下载</a>
      <a style="margin-top:10px;margin-left:16%" class="btn btn-primary" href="http://dlsw.baidu.com/sw-search-sp/soft/9d/14744/ChromeStandalone_47.0.2526.73_Setup.1449470176.exe">谷歌下载</a>
    <!-- /.login-box-body -->
   </div>
  <!-- /.login-box -->
  <!-- jQuery 2.1.4 -->
  <script src="/public/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="/public/adminlte/bootstrap/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="/public/adminlte/plugins/iCheck/icheck.min.js"></script>
  <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
</body>
</html>
<script type="text/javascript">
$('#login').submit(function(){
	var data = $("#login").serialize();
	$.ajax({
		type:'POST',
		url:'<?=$this->url("common/checkLogin")?>',
		data:data,
		dataType:'json',
		success:function(r){
            console.log(r);
			if(r.state == 1){
				//alert(r.url);
				window.location.href = r.url;
			}else{
			    $('.alert-error').remove();
				$('#login').before('<div class="alert alert-error"><button data-dismiss="alert" class="close" type="button">×</button><strong>'+r.info+'</strong></div>');
			}
		}
	});
	return false;
});
</script>