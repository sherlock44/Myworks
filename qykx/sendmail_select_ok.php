<?php session_start(); include("conn/conn.php");
if($check==""){
 echo "<script>alert('��ѡ��Ҫɾ�����ʼ�!');history.back();</script>";
}else{
 $ress=new com("adodb.recordset");
while(list($name,$value)=each($_POST[check])){
   $sql='delete from tb_mail where mail_id='.$value.'';
	  	   $ress->open($sql,$conn,3,1);
}
  echo "<script>alert('�ʼ����ͼ�¼ɾ���ɹ�!');window.location.href='indexs.php?lmbs=�鿴�ʼ����ͼ�¼'</script>";
}
?>