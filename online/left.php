<?php
	session_start();
?>
<!--��¼�� -->
<table width="265" border="0" cellpadding="0" cellspacing="0" class="left_table"> 
	<tr><td align="center" valign="top">
<?php
	if(isset($_SESSION[id]) and isset($_SESSION[name]))
		include "message.php";
	else
		include "login.php";
?>
</td></tr></table>
	<!-------------------��¼�����----------------------->
	<!--������.php-->
<table width="265" border="0" cellpadding="0" cellspacing="0" class="left_table"> 
	<tr><td align="center" valign="top">
	<?php include "found.php"; ?>
</td></tr></table>
	<!-- ------------------ -->
	<!--Ӱ������ -->
	<table width="265" border="0" cellpadding="0" cellspacing="0" class="left_table"> 
		<tr><td align="center" valign="top">
	<?php include "audio.php"; ?>
	</td></tr></table>
	<!-- ------------------ -->
	<!-- �������� -->
	<table width="265" border="0" cellpadding="0" cellspacing="0" class="left_table"> 
		<tr><td align="center" valign="top">
	<?php include "video.php"; ?>
	</td></tr></table>
	<!-- ------------------ -->