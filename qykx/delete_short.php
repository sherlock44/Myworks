<?php  include("conn/conn.php");
	
   $sql='delete from tb_short where short_id='.$_GET[lmbes].'';
	   $rs=new com("adodb.recordset");
	   $rs->open($sql,$conn,3,3);
echo "<script>alert('���ż�¼ɾ���ɹ���');window.location.href='indexs.php?lmbs=���Ӷ���&lmlb=���ż�¼����'</script>";
?>