<?php
	session_start();
	include "inc/chec.php";
	include "conn/conn.php";
	include "inc/func.php";
	if(is_chk("name","tb_audiolist",$_POST[names]) == false){
		echo "<script>alert('�����ظ�');history.go(-1);</script>";
		exit();
	}
		
	$a_sqlstr = "insert into tb_audiolist (grade,name,father,userName,issueDate) values('$_POST[grade]','$_POST[names]','$_POST[father]','$_SESSION[admin]','".date("Y-m-d H:i:s")."')";
	if($conn->execute($a_sqlstr) == false)
		echo "<script>alert('���ʧ��');history.go(-1);</script>";
	else
		echo "<script>top.opener.location.reload();alert('��ӳɹ�');window.close();</script>";
	
?>
