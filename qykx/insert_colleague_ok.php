<?php  include("conn/conn.php");
if($Submit=="�ύ"){
   if(preg_match("/^(\d{11})$/",$colleague_tel,$counts)){ 
     if(preg_match("/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/",$colleague_mail,$counts)){   
$sql="insert into tb_colleague(colleague_name,colleague_tel,colleague_mail,colleague_address,colleague_category,colleague_birthday)values('".$colleague_name."','".$colleague_tel."','".$colleague_mail."','".$colleague_address."','".$colleague_category."','".$colleague_birthday."')";
	   $rs=new com("adodb.recordset");
	   $rs->open($sql,$conn,3,1);
echo "<script>alert('ͬ����ӳɹ���');history.back();</script>";

 }else{
         echo "<script>alert('������������ַ�ĸ�ʽ����ȷ!!');history.back()</script>";

}}else{
         echo "<script>alert('������ĵ绰����ĸ�ʽ����ȷ!!');history.back()</script>";
}}
?>