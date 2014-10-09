<?php
	$sql = "select * from hero where id=".$_GET['id'];
	$pdo = new PDO('mysql:dbname=toupiao;charset=utf8','root','eebce7027d');
	
//	$pdo = new PDO('mysql:dbname=nwll;charset=utf8','root','mango118Aa');
	$news = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
        <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="content-type" content="text/html;charset=utf-8">
        <title>allnews</title>
		
		<!-- Maniac stylesheets -->
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/style.css" />
		<script type="text/javascript" src="../js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="../js/limit.js"></script>
		<script type="text/javascript" src="js/MySql.js"></script>
	</head>
	<body class="fixed">
		<!-- wrapper -->
        <div class="wrapper" style="margin-left:-150px;margin-top:-50px">
            <div class="rightside">
                <div class="content">
                <!-- Main row -->
				<div id="idiv" style="display:none"><?php echo $_GET['id'] ?></div>
				<div class="row">	
					<div class="col-md-12">
                        <div class="box">
                            <div class="box-title">
                               <h3>修改选手信息</h3>
                            </div>
                            <div class="box-body">
								<div class="form-horizontal" role="form">
									<!-- Text input -->
									<div class="form-group">
										<label for="input-text" class="col-sm-2 control-label">选手姓名</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" id="name" value="<?php echo $news[0]['name'] ?>">
										</div>
									</div>
									
									<!-- Input text with help -->
									<div class="form-group">
										<label for="input-text-help" class="col-sm-2 control-label">姓名拼音</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" id="ename" value="<?php echo $news[0]['ename'] ?>">
										</div>
									</div>

									<!-- Input text with help -->
									<div class="form-group">
										<label for="input-text-help" class="col-sm-2 control-label">选手得票</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" id="score" value="<?php echo $news[0]['score'] ?>">
										</div>
									</div>
									
									<!-- Input password -->
									<div class="form-group">
										<label for="inputPassword" class="col-sm-2 control-label">选手编号</label>
										<div class="col-sm-10">
										<input class="form-control" id="number" value="<?php echo $news[0]['number'] ?>">
										</div>
									</div>
									
									<div class="form-group">
										<label for="input-text" class="col-sm-2 control-label">当前头像</label>
										<div class="col-sm-10">
										<img width="50" height="50" alt="头像" src="<?php echo urldecode($news[0]['headimg']);?>">
										</div>
									</div>
									<div class="form-group">
										<label for="input-text" class="col-sm-2 control-label">更改头像</label>
										<div class="col-sm-10">
										<input type="file" class="form-control" id="img" placeholder="支持格式-jpg/png/gif">
										</div>
										<div id="butdiv" style="text-align:center;height:30px;">
										</div>
										<button style="margin-left:500px;margin-top:30px;" class="pull-left btn btn-success">确认修改</button>
									</div>
								</div>
                            </div>
						</div>
					</div><!-- ./col -->
                </div>
            </div>
        </div><!-- /.wrapper -->
		<script type="text/javascript">
		var db = new MySql('toupiao','localhost','root','eebce7027d');
		var inpFile = document.getElementById('img');
		$('button').click(function(){
			if($('#name').val()==""){
				alert('姓名不能为空！');
				return;
			}
			if($('#ename').val()==""){
				alert('正确填写姓名拼音有助于选手分组!');
				return;
			}
			if($('#number').val()==""){
				alert('选手编号呢?!');
				return;
			}

			if(inpFile.files[0]==null){
				db.query('update hero set name="'+$('#name').val()+'",ename="'+$('#ename').val()+'",score="'+$('#score').val()+'",number="'+$('#number').val()+'" where id='+$('#idiv').text(),function(){
					alert('修改成功！');
				});
			}else{
				var fr = new FileReader();
				fr.onload = function(){
					db.query('update hero set name="'+$('#name').val()+'",ename="'+$('#ename').val()+'",score="'+$('#score').val()+'",number="'+$('#number').val()+'",headimg="'+encodeURIComponent(fr.result)+'" where id='+$('#idiv').text(),function(){
						alert('修改成功！');
					});
				}
	
				fr.readAsDataURL(inpFile.files[0]);
			}
			


			
//链接头像
// 			$.ajax({
// 				type:'get',
// 				url:'save.php',
// 				data:'name='+$('#name').val()+'&ename='+$('#ename').val()+'&number='+$('#number').val()+'&img='+encodeURIComponent($('#img').val()),
// 				success:function(status){
// 					if(status==1){
// 						alert('提交成功');
// 						location="updatehero.php";
// 					}else{
// 						alert('提交失败');
// 					}
// 				}
// 			});
		});
	</script>
    </body>
</html>