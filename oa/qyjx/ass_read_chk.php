<?php
	session_start();
	include "../inc/chec.php";
	include "../conn/conn.php";
	$u_level = $_POST[g_list];
	
	$sqlstr = "insert into tb_superson values('','".$_POST[s_fdate]."','".$_POST[s_ldate]."','".$u_level."')";
	$result = mysql_query($sqlstr,$conn);
	if($result)
		echo "<script>alert('�����ɹ���');location='exc_staf.php';</script>";
	else
		echo "<script>alert('ϵͳ��æ�����Ժ�����');history.go(-1);</script>";
?>