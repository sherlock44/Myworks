<?php session_start(); include("conn/conn.php"); 
$sqls="select * from tb_user where username='".$username."' and userpwd='".$_POST[pwd]."'";
$res=new com("adodb.recordset");
$res->open($sqls,$conn,1,1);
if(!$res->eof){
   $sqls="update tb_user set userpwd='".$_POST[password]."'";
   $rs=new com("adodb.recordset");
   $rs->open($sqls,$conn,1,1);
   if(!$res->eof){
      echo "<script>alert('������³ɹ���');history.back();</script>";  
   }else{
      echo "<script>alert('�������ʧ�ܣ�');history.back();</script>";  
   }
}else{
      echo "<script>alert('����������벻��ȷ��');history.back();</script>";  

}
?>
