<?php
	session_start();
	include "conn/conn.php";
?>
<body leftmargin="0" topmargin="0" onUnload="javascript:top.opener.location.reload();"> 
<center>
<?php
	if($_SERVER['HTTP_REFERER'] != ""){
		$sql = "delete from tb_register where id = ".$_GET[id];
		$rst = $conn->execute($sql);
		if($rst != false){
?>
  <embed src="upfiles/video/<?php echo $_GET[name];?>" ShowStatusBar=true></embed>
<?php
		}else{
			echo "<script>alert('ɾ��ʧ��');window.close();</script>";
			exit();
		}
	}else{
		echo "<script>alert('��������ⲿ����');window.close();</script>";
			exit();
	}
?>	
</center>
</body>
