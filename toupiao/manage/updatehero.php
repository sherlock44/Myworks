<?php
	$sql = "select * from hero";
	$pdo = new PDO('mysql:dbname=toupiao;charset=utf8','root','eebce7027d');
	
//	$pdo = new PDO('mysql:dbname=nwll;charset=utf8','root','mango118Aa');
	$news = $pdo->query($sql)->fetchAll();
	$all = $pdo->query('select count(id) from hero')->fetchAll();
?>
<!DOCTYPE html>
<html>
	<head>
        <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="content-type" content="text/html;charset=utf-8">
        <title>allnews</title>
		<!-- Maniac stylesheets -->
        <link rel="stylesheet" href="css/bootstrap.min.css" tppabs="http://demo.yakuzi.eu/maniac/css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/font-awesome.min.css" tppabs="http://demo.yakuzi.eu/maniac/css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/style.css" tppabs="http://demo.yakuzi.eu/maniac/css/style.css" />
		<script type="text/javascript" src="../js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="../js/limit.js"></script>
		<script type="text/javascript">
			function update(id){
				location = "rehero.php?id="+id;
			}
			function dele(id){
				$.ajax({
					url:'dele.php',
					data:'id='+id,
					success:function(s){
						if(s==1){
							alert('删除成功！');
							location = "updatehero.php";
						}else{
							alert('删除失败！');
						}
					}
				});
			}
		</script>
	</head>
	<body class="fixed" style="width:1180px">
		<!-- wrapper -->
        <div class="wrapper">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-title">
                                    <h3>选手列表</h3>
                                </div>
                                <div class="box-body table-responsive no-padding">
                                     <table class="table table-hover table-striped">
									  <thead>
										  <tr>
											  <th>姓名</th>
											  <th>头像</th>
											  <th>编号</th>
											  <th>得票数</th>
											  <th>修改</th>
											  <th>删除</th>
										  </tr>
									  </thead>   
									  <tbody>
									  <?php
											foreach($news as $n){
										?>
										<tr>
											<td><?php
												echo $n['name'];
											?></td>
											<td><img data-original="../images/heros/<?php echo $n['id'];?>.jpg" src="../images/heros/<?php echo $n['id'];?>.jpg" width="50" height="50"></td>
											<td><?php
												echo $n['number'];
											?></td>
											<td><?php
												echo $n['score'];
											?></td>
											<td><a href="javascript:if(confirm('确定修改此条目？')){update(<?php echo $n['id'] ?>)};" class="ask"><img src="../images/user_edit.png" alt="" title="" border="0" /></a></td>
											<td><a href="javascript:if(confirm('确定删除此条目？')){dele(<?php echo $n['id'] ?>)};" class="ask"><img src="../images/trash.png" alt="" title="" border="0" /></a></td>
										</tr>
										<?php
											}
										?>
									  </tbody>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
            </div>
        </div><!-- /.wrapper -->
		</div>
		<script type="text/javascript" src="js/jquery.lazyload.js"></script>
    </body>
</html>