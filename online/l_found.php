<?php
	session_start();
	include "conn/conn.php";
?>
<!--����Ӱ��-->

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
			<td width="84" align="center" valign="middle" >��ϸ����</td>
		</tr>
<?php
		$l_sqlstr = "select style,name,actor,remark from tb_".$_POST[m_type]." where name like '%".$_POST[k_word]."%'";
		$l_rst = $conn->execute($l_sqlstr);
		while(!$l_rst->EOF){
?>
        <tr onmouseover="this.style.backgroundColor='#E8FEFF'" onmouseout="this.style.backgroundColor=''" onchange="k_change();">
          <td height="30" align="center" valign="middle"><?php echo $l_rst->fields[0]; ?></td>
		  <td  align="center" valign="middle"><?php echo $l_rst->fields[1]; ?></td>
		  <td  align="center" valign="middle"><?php echo $l_rst->fields[2]; ?></td>
		  <td  align="center" valign="middle"><a href=""><img src="images/online_icon.jpg" height="20" width="20" border="0"  /></a></td>
		  <td align="center" valign="middle"><a href=""><img src="images/downall_icon.jpg" height="20" width="20" border="0"  /></a></td>
		  <td  align="center" valign="middle"><a href=""><img src="images/show_icon.jpg" height="20" width="20" border="0"  /></a></td>
		</tr>
<?php			
			$l_rst->movenext();
		}
?>
      </table>
      