<?php
	session_start();
?>
<script src="js/chk.js"></script>
<link rel="stylesheet" href="css/reg.css"/>
<link rel="stylesheet" href="css/style.css"/>
<center>
<table>
	<tr>
		<td width="665" height="164" background="images/ball.jpg">&nbsp;</td>
	</tr>
</table>
<?php
/*  �������  */
	switch($_GET[action]){
		case "reg":					//ע��
			include "register.php";
			break;
		case "s_music":				//�鿴���ϵͳ
			include "s_music.php";
			break;
		case "mod_vip":				//�޸�����
			include "mod_vip.php";	
			break;
		case "intro":				//��Ƶ����
?>
			<iframe src="intro.php?id=<?php echo $_GET[id]; ?>" width="665" height="700" scrolling="no"></iframe>
<?php
			break;
		case "v_intro":				//��Ƶ����
?>
			<iframe src="v_intro.php?id=<?php echo $_GET[id]; ?>" width="665" height="700" scrolling="no"></iframe>
<?php
			break;
		case "call":
			include "call.php";
			break;
		case "trans":
			include "trans.php";
			break;
		case "found":
			include "found_pwd.php";
			break;
		case "search":
			include "high.php";
			break;
		case "see":
?>
			<iframe src="see.php?id=<?php echo $_GET[id]; ?>" width="665" height="530" scrolling="no" frameborder="0" align="middle"></iframe>
<?php
			break;
		case "listen":
?>
			<iframe src="listen.php?id=<?php echo $_GET[id]; ?>" width="665" height="530" scrolling="no" frameborder="0" align="middle"></iframe>
<?php
			break;
		case "give":
?>
			<iframe src="give.php?id=<?php echo $_GET[id]; ?>" width="665" height="530" scrolling="no" frameborder="0" align="middle"></iframe>
<?php
			break;
		case "dotlisten":
?>
			<iframe src="dotlisten.php?id=<?php echo $_GET[id]; ?>&name=<?php echo $_GET[name]; ?>" width="665" height="530" scrolling="no" frameborder="0" align="middle"></iframe>
<?php
		default:
			break;
	}
/**************/
?>
</center>