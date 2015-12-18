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
		 <p style="color:gray;font-size:13px;">小提示：选手姓名的拼音请正确书写，以保证分组的正确性</p>
		<!-- wrapper -->
        <div class="wrapper" style="margin-left:-150px;margin-top:-50px">
            <div class="rightside">
                <div class="content">
                <!-- Main row -->
					
				<div class="row">	
					<div class="col-md-12">
                        <div class="box">
                            <div class="box-title">
                               <h3>添加选手</h3>
                            </div>
                            <div class="box-body">
								<div class="form-horizontal" role="form">
									<!-- Text input -->
									<div class="form-group">
										<label for="input-text" class="col-sm-2 control-label">选手姓名</label>
										<div class="col-sm-10">
										<input name="name" type="text" class="form-control" id="name" placeholder="如：王大锤">
										</div>
									</div>
									
									<!-- Input text with help -->
									<div class="form-group">
										<label for="input-text-help" class="col-sm-2 control-label">姓名拼音</label>
										<div class="col-sm-10">
										<input name="ename" type="text" class="form-control" id="ename" placeholder="如：wangdachui">
										</div>
									</div>
									
									<!-- Input password -->
									<div class="form-group">
										<label for="inputPassword" class="col-sm-2 control-label">选手编号</label>
										<div class="col-sm-10">
										<input name="number" class="form-control" id="number" placeholder="选手编号">
										</div>
									</div>
									
									<div class="form-group">
										<label for="input-text" class="col-sm-2 control-label">选手头像</label>
										<div class="col-sm-10">
										<input name="img" type="file" class="form-control" id="img" placeholder="支持格式-jpg/png/gif">
										</div>
										<div id="butdiv" style="text-align:center;height:30px;">
										</div>
										<button type='submit' style="margin-left:500px;margin-top:30px;" class="pull-left btn btn-success">提交</button>
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
			if($('#img').val()==""){
				alert('选手头像不能为空!');
				return;
			}

			var fr = new FileReader();
			fr.onload = function(){
				db.query('insert into hero(name,ename,number,score,headimg) values("'+$('#name').val()+'","'+$('#ename').val()+'","'+$('#number').val()+'",0,"'+encodeURIComponent(fr.result)+'")',function(){
					alert('上传成功！');
				});
			}

			fr.readAsDataURL(inpFile.files[0]);


			
链接头像
 			$.ajax({
 				type:'get',
 				url:'save.php',
 				data:'name='+$('#name').val()+'&ename='+$('#ename').val()+'&number='+$('#number').val()+'&img='+encodeURIComponent($('#img').val()),
 				success:function(status){
 					if(status==1){
 						alert('提交成功');
 						location="updatehero.php";
 					}else{
 						alert('提交失败');
 					}
 				}
 			});
		});
	</script>
    </body>
</html>