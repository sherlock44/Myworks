<?php
	session_start();
	include "conn/conn.php";
	include "inc/chec.php";
	$d_sqlstr = "delete from tb_manager where id = ".$_GET[id];
	if(!($d_rst = $conn->execute($d_sqlstr)) == false)
		echo "<script>alert('ɾ���ɹ�');location='main.php?action=manager';</script>";
	else
		echo "<script>alert('ɾ��ʧ��');history.go(-1);</script>";
?>