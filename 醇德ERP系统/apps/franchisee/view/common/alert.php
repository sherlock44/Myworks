<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?
if(isset($_SERVER ["HTTP_REFERER"])){$url=$_SERVER ["HTTP_REFERER"];}else{$url=$this->url('common/login');}
?>
<meta http-equiv='Refresh' content='<?=$sleep?>;URL=<?=$url?>'>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<title><?=$msg?></title>
<link rel="shortcut icon" href="http://www.mbachina.com/favicon.ico" />

<link rel="stylesheet" href="/public/assets/sysadmin/css/bootstrap.min.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/bootstrap-responsive.min.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/jquery-ui/smoothness/jquery-ui.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/jquery-ui/smoothness/jquery.ui.theme.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/themes.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/style.css">


</head>
<body class='error'>
	<div class="wrapper">
		<div class="code"><span><?=$state == 1 ? '成功' : '错误'?></span><i class="icon-warning-sign"></i></div>
		<div class="desc"><?=$msg?>，<?=$sleep?> 秒后跳转...</div>
		<div class="buttons">
			<div class="pull-left"><a href="<?=$url?>" class="btn"><i class="icon-arrow-left"></i> 返回</a></div>
		</div>
	</div>

</body>

</html>