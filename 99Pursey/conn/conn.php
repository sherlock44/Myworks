<?php
     $conn=mysql_connect("localhost","root") or die("���ݿ���������Ӵ���".mysql_error());
     mysql_select_db("project_01",$conn) or die("���ݿ���ʴ���".mysql_error());
     mysql_query("set names utf8");
?>
