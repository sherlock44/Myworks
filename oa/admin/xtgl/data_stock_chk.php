<?php
	session_start();
	include "../inc/chec.php";
	include "../conn/conn.php";
	$mysqlstr = "D:\\\AppServ\\MySQL\\bin\\mysqldump -uroot -hlocalhost -proot --opt -B db_office > ../bak/".$_POST[b_name];
	exec($mysqlstr);
	echo "<script>alert('���ݳɹ�');location='data_stock.php'</script>";
?>
