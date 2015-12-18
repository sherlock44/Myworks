<?php

$name = $_POST['name'];
$ename = $_POST['ename'];
$num = $_POST['number'];

echo $name.','.$ename.','.$_FILES['img']['tmp_name'];

//$pdo = new PDO('mysql:dbname=toupiao;charset=utf8','root','eebce7027d');
//	
//$sql = "insert into hero(name,ename,number,score,headimg) values(:name,:ename,:number,0,:img)";
//$s = $pdo->prepare($sql)->execute(array('name'=>$name,'ename'=>$ename,'number'=>$num,'img'=>$$_FILES['img']['name']));
//
//if( $_FILES['img']['error']!=0 ) {
//	die('文件上传错误!');
//}
//
//if( move_uploaded_file($_FILES['img']['tmp_name'],'test.jpg') ) {
//	echo "上传成功,".$s;
//} else {
//	echo "因为种种原因，上传失败";
//}