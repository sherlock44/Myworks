<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>打印</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="/public/adminlte/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/public/adminlte/dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/public/adminlte/dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/public/adminlte/dist/css/AdminLTE.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/public/adminlte/dist/js/html5shiv.min.js"></script>
    <script src="/public/adminlte/dist/js/respond.min.js"></script>
    <![endif]-->
</head>
<body onload="window.print();">
    <?php include $this->loadview();?>
    <!-- AdminLTE App -->
    <script src="/public/adminlte/dist/js/app.min.js"></script>
</body>
</html>
