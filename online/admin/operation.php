<?php
	session_start();
	include "inc/chec.php";
?>
<link href="css/style.css" rel="stylesheet"/>
<script src="js/admin_js.js" language="javascript"></script>
<center>
<table>
	<tr>
		<td width="665" height="164" background="images/ball.jpg">&nbsp;</td>
	</tr>
</table>
<?php
	switch ($_GET[action]){
		case "audiolist":					//�����ƵĿ¼
			include "audiolist.php";
			break;
		case "videolist":					//�����ƵĿ¼
			include "videolist.php";
			break;
		case "audioadd":					//�����Ƶ
			include "audioadd.php";
			break;
		case "videoadd":					//�����Ƶ
			include "videoadd.php";
			break;
		case "v_grade":						//��Ա��������
			include "v_grade.php";
			break;
		case "v_found":						//��Ա��ѯ
			include "v_found.php";
			break;
		case "freeze":						//�����ʺ�
			include "freeze.php";
			break;
		case "l_found":						//��ѯ��־
			include "l_found.php";
			break;
		case "addmanager":					//��ӹ���Ա
			include "addmanager.php";		 
			break;
		case "audio":						//��Ƶ����
?>
		<iframe src="intro.php?id=<?php echo $_GET[id]; ?>" width="665" height="700" scrolling="no"></iframe>
<?php
		break;
	case "video":							//��Ƶ����
?>
		<iframe src="v_intro.php?id=<?php echo $_GET[id]; ?>" width="665" height="700" scrolling="no"></iframe>
<?php
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
}
?>
</center>