<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>Ӱ��online</title>
<script src="js/chk.js" language="javascript"></script>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<center>
<?php
	include "top.php";			//banner
?>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="265" align="center" valign="top">
<?php
	include "left.php";			//��¼��������
?>
	</td>
    <td width="605" align="center" valign="top">
<?php
	include "main.php";			//�������
?>
	</td>
  </tr>
</table>
</center>
</body>
</html>
