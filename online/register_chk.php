<?php
	session_start();
	include "conn/conn.php";
	$c_sql = "select * from tb_account where name = '".$_POST[name]."'";
	$c_rst = $conn->execute($c_sql);
	if(!($c_rst == false)){
		if(!$c_rst->EOF){
			echo "<script>alert('�û����ظ�������������');history.go(-1);</script>";
			exit();
		}
	}
	if(isset($_POST[regi])){
	$sqlstr = "insert into tb_account(name,password,question,answer,realname,sex,age,numbers,job,email,phone,address,qq,http) values ('".$_POST[name]."','".$_POST[password]."','".$_POST[question]."','".$_POST[answer]."','".$_POST[realname]."','".$_POST[sex]."',".(empty($_POST[age])?0:$_POST[age]).",'".$_POST[numbers]."','".$_POST[job]."','".$_POST[email]."','".$_POST[phone]."','".$_POST[address]."','".$_POST[qq]."','".$_POST[http]."')";
	if($conn->Execute($sqlstr) == false){
		echo "<script>alert('��Ӵ���".$conn->Errormsg()."');history.go(-1);</script>";
	}
	else{
		echo "<script>alert('��ϲ,�û�ע��ɹ�.�����µ�¼');window.close();</script>";
	}}
	else{
		echo "<script>alert('!@#$$#@!@#,�Ƿ���¼');window.close();</script>";
	}
?>