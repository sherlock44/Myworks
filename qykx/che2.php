<?php
session_start();
if($_SESSION[username]=="")
 {
  echo "<script>alert('���ȵ�¼��ſ��Է��Ͷ���!');history.back();</script>"; 
  exit;
 }
  $ids=strval($_POST[new_tel]);
 
if(preg_match("/^(\d{11})$/",$new_tel,$counts)){ 
    
  $arrays=explode("@",$_SESSION[producelists]);
  for($i=0;$i<count($arrays)-1;$i++)
    {
	 if($arrays[$i]==$ids)
	  {
	     echo "<script>alert('�õ绰�����Ѿ���ѡ��!');history.back();</script>";
		 exit;
	  }
	}
  $_SESSION[producelists]=$_SESSION[producelists].$ids."@";
  $_SESSION[quatitys]=$_SESSION[quatitys]."1@";
  
  header("location:indexs.php?lmbs=���Ӷ���");
}else{
         echo "<script>alert('������ĵ绰����ĸ�ʽ����ȷ!!');history.back()</script>";
}
?> 