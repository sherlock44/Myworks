<center>
<?php
	include "conn/conn.php";
	if(!isset($_GET[name]) or $_GET[name] == ""){
		echo "<font color='red'>�Ƿ��û���!</font>";
		exit();
	}
	$c_sql = "select * from tb_account where name='".$_GET[name]."'";
	$c_rst = $conn->execute($c_sql);
	if($c_rst){
		if(!$c_rst->EOF){
			echo "<font color='red'>�û�����ռ��!</font>";
			exit();
		}else{
			echo "<font color='green'>��ϲ�������û�������!</font>";
			exit();
		}}
?>
</center>