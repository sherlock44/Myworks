<?php
	session_start();
	include "conn/conn.php";
	$a_sqlstr = "select * from tb_manager where name= '$_POST[manager]'";
	$a_rst = $conn->execute($a_sqlstr);
	if(!$a_rst->EOF){
		if($a_rst->fields[2] != $_POST[pwd]){
			echo "<script>alert('�û����������������');history.go(-1);</script>";
			exit();
		}
		if($a_rst->fields[6] == "0"){
			echo "<script>alert('������¼���û������ᣬ����������벦��绰0431-1234****��ѯ��ϸ��Ϣ');history.go(-1)</script>";
			exit();
		}
		$_SESSION[admin]=$a_rst->fields[1];
		$_SESSION[type]=$a_rst->fields[3];
		$_SESSION[m_id]=$a_rst->fields[0];
		echo "<script>alert('��½�ɹ�');location='main.php';</script>";
	}
	else{
		echo "<script>alert('�û����������������');history.go(-1);</script>";
	}
?>