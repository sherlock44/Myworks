<?php
session_start();
if($_SESSION[username]=="")
 {
  echo "<script>alert('���ȵ�¼��ſ��Է��Ͷ���!');history.back();</script>"; 
  exit;
 }
  $ides=strval($_GET[ides]);
 
	    
  $arrayes=explode("@",$_SESSION[producelistes]);
  for($i=0;$i<count($arrayes)-1;$i++)
    {
	 if($arrayes[$i]==$ides)
	  {
	     echo "<script>alert('�õ绰�����Ѿ���ѡ��!');history.back();</script>";
		 exit;
	  }
	}
  $_SESSION[producelistes]=$_SESSION[producelistes].$ides."@";
  $_SESSION[quatityes]=$_SESSION[quatityes]."1@";
  
  header("location:indexs.php?lmbs=���Ӷ���");
?> 