<?php
	session_start();
	include "conn/conn.php";
	include "inc/chec.php";
	
	if($_POST[whether] == "1")
		$wt = "0";
	else if($_POST[whether] == "0")
		$wt = "1";
	else{
		echo "<script>alert('�Ƿ�����!');history.go(-1);</script>";
		exit();
	}
	$o_sqlstr = "update tb_account set whether = '".$wt."' where id = ".$_POST[id];
	$o_rst = $conn->execute($o_sqlstr);
	if(!($o_rst == false)){
		echo "<script>alert('�����ɹ�');location='main.php?action=member';</script>";
	}
?>
