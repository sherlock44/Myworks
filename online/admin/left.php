<?php
	session_start();
	include "conn/conn.php";
	include "inc/chec.php";
?>
<table width="201" border="0" cellspacing="0" cellpadding="0" bgcolor="#f0f0f0">
  <tr>
    <td colspan="2" height="25">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" class="menu_td"><div align="center">
<?php
	if(($_SESSION[type] == "super") or ($_SESSION[type] == "��ƵĿ¼����Ա")){
		echo "<img src='images/unlock.png' width='11' height='13' />";
	}else{
		echo "<img src='images/lock.png' width='11' height='13' />";
	}
?>

	</td>
    <td height="25" class="menu_td"><div align="left"><a <?php if(($_SESSION[type]=="super") or ($_SESSION[type]=="��ƵĿ¼����Ա")) echo "href='main.php?action=audioList'"; ?>>��ƵĿ¼����</a></div></td>
  </tr>
  <tr>
    <td height="25" class="menu_td"><div align="center">
      <?php
	if(($_SESSION[type] == "super") or ($_SESSION[type] == "��ƵĿ¼����Ա"))
		echo "<img src='images/unlock.png' width='11' height='13' />";
	else
		echo "<img src='images/lock.png' width='11' height='13' />";
?>
    </td>
    <td height="25" class="menu_td"><div align="left"><a <?php if(($_SESSION[type]=="super") or ($_SESSION[type]=="��ƵĿ¼����Ա")) echo "href='main.php?action=videoList'"; ?>>��ƵĿ¼����</a></div></td>
  </tr>
  <tr>
    <td height="25" class="menu_td"><div align="center">
      <?php
	if(($_SESSION[type] == "super") or ($_SESSION[type] == "��Ƶ���ݹ���Ա"))
		echo "<img src='images/unlock.png' width='11' height='13' />";
	else
		echo "<img src='images/lock.png' width='11' height='13' />";
?>
    </td>
    <td height="25" class="menu_td"><div align="left"><a <?php if(($_SESSION[type]=="super") or ($_SESSION[type]=="��Ƶ���ݹ���Ա")) echo "href='main.php?action=audio'";  ?>>��Ƶ���ݹ���</a></div></td>
  </tr>
  <tr>
    <td height="25" class="menu_td"><div align="center">
      <?php
	if(($_SESSION[type] == "super") or ($_SESSION[type] == "��Ƶ���ݹ���Ա"))
		echo "<img src='images/unlock.png' width='11' height='13' />";
	else
		echo "<img src='images/lock.png' width='11' height='13' />";
?>
    </td>
    <td height="25" class="menu_td"><div align="left"><a  <?php if (($_SESSION[type]=="super") or ($_SESSION[type]=="��Ƶ���ݹ���Ա")) echo "href='main.php?action=video'";  ?>>�������ݹ���</a></div></td>
  </tr>
  <tr>
    <td height="25" class="menu_td"><div align="center">
      <?php
	if(($_SESSION[type] == "super") or ($_SESSION[type] == "��Ա�ȼ�����Ա"))
		echo "<img src='images/unlock.png' width='11' height='13' />";
	else
		echo "<img src='images/lock.png' width='11' height='13' />";
?>
    </td>
    <td height="25" class="menu_td"><div align="left"><a  <?php if(($_SESSION[type]=="super") or ($_SESSION[type]=="��Ա�ȼ�����Ա")) echo "href='main.php?action=grade'"; ?>>��Ա�ȼ�����</a></div></td>
  </tr>
  <tr>
    <td height="25" class="menu_td"><div align="center">
      <?php
	if(($_SESSION[type] == "super") or ($_SESSION[type] == "��Ա���ݹ���Ա"))
		echo "<img src='images/unlock.png' width='11' height='13' />";
	else
		echo "<img src='images/lock.png' width='11' height='13' />";
?>
    </td>
    <td height="25" class="menu_td"><div align="left"><a  <?php if(($_SESSION[type]=="super") or ($_SESSION[type]=="��Ա���ݹ���Ա")) echo "href='main.php?action=member'"; ?>>��Ա���ݹ���</a></div></td>
  </tr>
  <tr>
    <td height="25" class="menu_td"><div align="center">
      <?php
	if($_SESSION[type] == "super")
		echo "<img src='images/unlock.png' width='11' height='13' />";
	else
		echo "<img src='images/lock.png' width='11' height='13' />";
?>
    </td>
    <td height="25" class="menu_td"><div align="left"><a  <?php if($_SESSION[type]=="super") echo "href='main.php?action=log'";  ?>>�ϴ���־����</a></div></td>
  </tr>
  <tr>
    <td height="25" class="menu_td"><div align="center">
      <?php
	if($_SESSION[type] == "super")
		echo "<img src='images/unlock.png' width='11' height='13' />";
	else
		echo "<img src='images/lock.png' width='11' height='13' />";
?>
    </td>
    <td height="25" class="menu_td"><div align="left"><a  <?php if($_SESSION[type]=="super") echo "href='main.php?action=manager'";  ?>>����Ա����</a></div></td>
  </tr>
  <tr>
  	<td colspan="2" height="20">&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="2"><img src="images/bottom.jpg" width="185" height="50" /></td>
  </tr>
</table>
