<?php  include("conn/conn.php");
if($colleague==true){
   $sql='delete from tb_colleague where colleague_id='.$colleague.'';
	   $rs=new com("adodb.recordset");
	   $rs->open($sql,$conn,3,3);
echo "<script>alert('ͬ����Ϣɾ���ɹ���');window.location.href='indexs.php?lmbs=$_GET[lmbs]&lmlb=ͬ����Ϣ����';</script>";
}

if($customer==true){
   $sql='delete from tb_customer where customer_id='.$customer.'';
	   $res=new com("adodb.recordset");
	   $res->open($sql,$conn,3,3);
echo "<script>alert('�ͻ���Ϣɾ���ɹ���');window.location.href='indexs.php?lmbs=$_GET[lmbs]&lmlb=�ͻ���Ϣ����';</script>";
}

if($note==true){
   $sql='delete from tb_note where note_id='.$note.'';
	   $ress=new com("adodb.recordset");
	   $ress->open($sql,$conn,3,3);
echo "<script>alert('������Ϣɾ���ɹ���');window.location.href='indexs.php?lmbs=$_GET[lmbs]&lmlb=���ö������';</script>";
}


?>