<?php
session_start();
if($_SESSION[username]=="")
 {
  echo "<script>alert('���ȵ�¼��ſ��Է��Ͷ���!');history.back();</script>"; 
  exit;
 }
  $idss=strval($_GET[idss]);
 
	    
  $arrayss=explode("@",$_SESSION[producelistss]);
  for($i=0;$i<count($arrayss)-1;$i++)
    {
	 if($arrayss[$i]==$idss)
	  {
	     echo "<script>alert('�õ绰�����Ѿ���ѡ��!');history.back();</script>";
		 exit;
	  }
	}
  $_SESSION[producelistss]=$_SESSION[producelistss].$idss."@";
  $_SESSION[quatityss]=$_SESSION[quatityss]."1@";
  
  header("location:indexs.php?lmbs=���Ӷ���");
?> 