<?php
  session_start();
  $hostname="{".$_POST[hostname].":110/pop3}";
  $username=$_POST[username];
  $userpwd=$_POST[userpwd];
  if(!$mbox=@imap_open("$hostname","$username","$userpwd")){
     echo "<script>alert('��¼ʧ��!');history.back();</script>";
  }else{
  session_register("host");
  session_register("user");
  session_register("pwd");
  $_SESSION[host]=$hostname;
  $_SESSION[user]=$username;
  $_SESSION[pwd]=$userpwd;
  imap_close($mbox);
    echo "<script>window.location.href='indexs.php?lmbs=��¼';</script>";  
  }
?>
