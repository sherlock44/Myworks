<?php
	$tel = $_GET['tel'];
	$time = $_GET['time'];

	$pdo = new PDO('mysql:dbname=toupiao;charset=utf8','root','eebce7027d');
	
	$fsql = "select * from tel where tel='".$tel."' and wtime='".$time."'";
	$isnull = $pdo->query($fsql)->fetchAll();

	if(empty($isnull)){
		$sql = "insert into tel(tel,wtime,ttime) values('".$_GET['tel']."',now(),now())";
		$s = $pdo->prepare($sql)->execute();
		echo 1;
	}else{
		echo 0;
	}

	