<?php  include("conn/conn.php");
if($Submit=="�ύ"){
   if(preg_match("/^(\d{11})$/",$customer_tel,$counts)){ 
     if(preg_match("/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/",$customer_mail,$counts)){   
$sql="insert into tb_customer(customer_name,customer_tel,customer_mail,customer_address,customer_category,customer_birthday)values('".$customer_name."','".$customer_tel."','".$customer_mail."','".$customer_address."','".$customer_category."','".$customer_birthday."')";
	   $rs=new com("adodb.recordset");
	   $rs->open($sql,$conn,3,1);
echo "<script>alert('�ͻ���ӳɹ���');history.back();</script>";

 }else{
         echo "<script>alert('������������ַ�ĸ�ʽ����ȷ!!');history.back()</script>";

}}else{
         echo "<script>alert('������ĵ绰����ĸ�ʽ����ȷ!!');history.back()</script>";
}}
?>