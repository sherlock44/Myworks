<?php
include "ado/adodb.inc.php";								//����adodb
$conn = &ADONewConnection('mysql');							//����mysql����
$conn->PConnect("localhost","root","root","db_online");		//����"db_online"���ݿ�
$conn->execute("set names gb2312");
?>