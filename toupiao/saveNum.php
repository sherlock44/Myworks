<?php 
	$pdo = new PDO('mysql:dbname=toupiao;charset=utf8','root','eebce7027d');
	
	$panduan = $pdo->query("select score from hero where name='".$_GET['name']."'")->fetchAll();

	if($_GET['renshu']>$panduan[0]['score']){
		$sql = "update hero set score=".$_GET['renshu']." where name='".$_GET['name']."'";
		$s = $pdo->prepare($sql)->execute();

		echo $s;

		$sql2 = "update tel set heroname='".$_GET['name']."' where tel='".$_GET['tel']."'";
		$pdo->prepare($sql2)->execute();
	}
	


