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
    <td align="center" valign="top">
<!---->
<table width="605" border="0" cellspacing="0" cellpadding="0" class="right_table">
        <tr>
          <td height="30" colspan="6" align="center" valign="middle" background="images/new_file_left.jpg" style=" font-size:14px; color:#FFFFFF;">��ѯ���</td>
        </tr>
		<tr>
			<td width="51" height="20" align="center" valign="middle">���</td>
		    <td width="225" align="center" valign="middle" ><?php echo (($_POST[m_type] == "audio")?"��Ӱ����":"��������"); ?></td>
		    <td width="128" align="center" valign="middle" ><?php echo (($_POST[m_type] == "audio")?"����":"����"); ?></td>
		    <td width="57" align="center" valign="middle" ><?php echo (($_POST[m_type] == "audio")?"���߹ۿ�":"��������"); ?></td>
		    <td width="60" align="center" valign="middle" >����</td>
			<td width="84" align="center" valign="middle" >����</td>
		</tr>
<?php
		$l_sqlstr = "select id,style,name,actor,remark from tb_".$_POST[m_type]." where name like '%".$_POST[k_word]."%'";
		$l_rst = $conn->execute($l_sqlstr);
		while(!$l_rst->EOF){
?>
        <tr onmouseover="this.style.backgroundColor='#E8FEFF'" onmouseout="this.style.backgroundColor=''" onchange="k_change();">
          <td height="30" align="center" valign="middle"><?php echo $l_rst->fields[1]; ?></td>
		  <td  align="center" valign="middle"><?php echo $l_rst->fields[2]; ?></td>
		  <td  align="center" valign="middle"><?php echo $l_rst->fields[3]; ?></td>
		  <td  align="center" valign="middle"><a href=""><img src="images/online_icon.jpg" height="20" width="20" border="0"  /></a></td>
		  <td align="center" valign="middle"><a href=""><img src="images/downall_icon.jpg" height="20" width="20" border="0"  /></a></td>
		  <td  align="center" valign="middle"><a href="#" onclick="javascript:Wopen=open('operation.php?action=intro&id=<?php echo $l_rst->fields[0]; ?>','','height=700,width=665,scrollbars=no');"><img src="images/show_icon.jpg" height="20" width="20" border="0" alt="��ϸ����" /></a></td>
		</tr>
<?php			
			$l_rst->movenext();
		}
?>
      </table>
<!---->
	</td>
  </tr>
</table>
</center>
</body>
</html>