<?php
	session_start();
	include "conn/conn.php";
	include "inc/chec.php";
	$v_sqlstr = "update tb_grade set price = '".$_POST[price]."' where id = ".$_POST[name];
	$v_rst = $conn->execute($v_sqlstr);
	if(!($v_rst == false))
		echo "<script>alert('�޸ĳɹ�');top.opener.location.reload();window.close();</script>";
	else
		echo "<script>alert('�޸�ʧ��');history.go(-1);</script>";
?>