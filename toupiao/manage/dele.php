<?php
	$id = $_GET['id'];

	$pdo = new PDO('mysql:dbname=toupiao;charset=utf8','root','eebce7027d');
	
	$r = $pdo->prepare('delete from hero where id=:id')->execute(array('id'=>$id));

	echo $r;
