<?php
	session_start();
	include "../inc/chec.php";
	include "../conn/conn.php";
	$sqlstr = "select s_id from tb_superson where id = ".$_GET[id];
	$result = mysql_query($sqlstr,$conn);
	$rows = mysql_fetch_row($RESULT);
	$num = split(",",$rows[0])
?>