<?php
session_start();
if($_SESSION[username]=="")
 {
  echo "<script>alert('请先登录后才可以发送短信!');history.back();</script>"; 
  exit;
 }
  $idss=strval($_GET[idss]);
 
	    
  $arrayss=explode("@",$_SESSION[producelistss]);
  for($i=0;$i<count($arrayss)-1;$i++)
    {
	 if($arrayss[$i]==$idss)
	  {
	     echo "<script>alert('该电话号码已经被选中!');history.back();</script>";
		 exit;
	  }
	}
  $_SESSION[producelistss]=$_SESSION[producelistss].$idss."@";
  $_SESSION[quatityss]=$_SESSION[quatityss]."1@";
  
  header("location:indexs.php?lmbs=连接短信");
?> 