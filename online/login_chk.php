<?php
	session_start();
	include "conn/conn.php";
	if((trim($_POST[name]) == "") or (trim($_POST[password]) == "")){
		echo "<script>alert('�ʺŻ��������');history.go(-1);</script>";
		exit();
	}
	$sqlstr = "select * from tb_account where name = '".$_POST[name]."' and password = '".$_POST[password]."'";
	$u_rst = $conn->execute($sqlstr);
	if(!$u_rst->EOF){
		if($u_rst->fields[17] == "0")
			echo "<script>alert('���ʺű����ᣬ�������벦��绰0431-XXXXXXXX��ѯ');history.go(-1);</script>";
		else{
		$g_rst = $conn->execute("select * from tb_grade");
			if($u_rst->fields[15] >= (int)$g_rst->fields[2]){
				$grade = array();
				$grade["grade"] = "�߼���Ա";
				$updata = $conn->getupdateSql($u_rst,$grade);
				$conn->execute($updata);
			}
			$_SESSION[name]=$u_rst->fields[1];
			$_SESSION[id]=$u_rst->fields[0];
			$_SESSION[grades]=$u_rst->fields[16];
			$_SESSION[counts]=$u_rst->fields[15];
			echo "<script>alert('�û���¼�ɹ�!');location='index.php';</script>";
		}
	}
	else{
		echo "<script>alert('�û�����������������µ�¼��');history.go(-1);</script>";
	}
?>