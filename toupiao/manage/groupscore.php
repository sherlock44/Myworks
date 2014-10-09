<?php
	$sql = "select * from hero where ename like '".$_GET['word']."%'";
	$pdo = new PDO('mysql:dbname=toupiao;charset=utf8','root','eebce7027d');
	
//	$pdo = new PDO('mysql:dbname=nwll;charset=utf8','root','mango118Aa');
	$news = $pdo->query($sql)->fetchAll();
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
			function groupquery(str){
				location = "groupscore.php?word="+str;
			}
			function update(id){
				location = "update.php?id="+id;
			}
			function dele(id){
				$.ajax({
					url:'dele.php',
					data:'id='+id,
					success:function(s){
						if(s==1){
							alert('删除成功！');
							location = "allnews.php?key=all";
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
                                    <h3>个别选手分数列表</h3>
                                </div>
                                <div class="box-body table-responsive no-padding">
                                     <table class="table table-hover table-striped">
									  <thead>
									  		<tr>
											  <td colspan="4">
											  <a href="javascript:groupquery('a')">A</a>
											  <a href="javascript:groupquery('b')">B</a>
											  <a href="javascript:groupquery('c')">C</a>
											  <a href="javascript:groupquery('d')">D</a>
											  <a href="javascript:groupquery('e')">E</a>
											  <a href="javascript:groupquery('f')">F</a>
											  <a href="javascript:groupquery('g')">G</a>
											  <a href="javascript:groupquery('h')">H</a>
											  <a href="javascript:groupquery('i')">I</a>
											  <a href="javascript:groupquery('j')">J</a>
											  <a href="javascript:groupquery('k')">K</a>
											  <a href="javascript:groupquery('l')">L</a>
											  <a href="javascript:groupquery('m')">M</a>
											  <a href="javascript:groupquery('n')">N</a>
											  <a href="javascript:groupquery('o')">O</a>
											  <a href="javascript:groupquery('p')">P</a>
											  <a href="javascript:groupquery('q')">Q</a>
											  <a href="javascript:groupquery('r')">R</a>
											  <a href="javascript:groupquery('s')">S</a>
											  <a href="javascript:groupquery('t')">T</a>
											  <a href="javascript:groupquery('u')">U</a>
											  <a href="javascript:groupquery('v')">V</a>
											  <a href="javascript:groupquery('w')">W</a>
											  <a href="javascript:groupquery('x')">X</a>
											  <a href="javascript:groupquery('y')">Y</a>
											  <a href="javascript:groupquery('z')">Z</a>
											  </td>
										  	</tr>
										  <tr>
											  <th>分组</th>
											  <th>姓名</th>
											  <th>编号</th>
											  <th>得票数</th>
										  </tr>
									  </thead>   
									  <tbody>
									  <?php
											foreach($news as $n){
										?>
										<tr>
											<td><?php
												echo strtoupper($_GET['word']).'组';
											?></td>
											<td><?php
												echo $n['name'];
											?></td>
											<td><?php
												echo $n['number'];
											?></td>
											<td><?php
												echo $n['score'];
											?></td>
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
    </body>
</html>