<?php
	include "conn/conn.php";
	
switch ($_GET[action]){
	case "newlist":
?>
<table width="605" border="0" cellspacing="0" cellpadding="0" class="right_table">
        <tr>
          <td height="30" colspan="6" align="center" valign="middle" background="images/new_file_left.jpg"><div style="font-size:15px; color:#ffffff;">����Ӱ��</div>
		  </td>
        </tr>
		<tr>
			<td width="100" height="25" align="center" valign="middle">���</td>
			<td width="25%" align="center" valign="middle">����</td>
			<td width="28%" align="center" valign="middle">��Ҫ��Ա</td>
			<td width="75" align="center" valign="middle">���߹ۿ�</td>
			<td width="75" align="center" valign="middle">����</td>
			<td width="75" align="center" valign="middle">����</td> 
		</tr>
<?php
		$l_sqlstr = "select * from tb_audio where bool = '1' order by id";
		$l_rst = $conn->execute($l_sqlstr);
		while(!$l_rst->EOF){
?>
        <tr onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''">
			<td height="25" align="right" valign="middle" >��<?php echo $l_rst->fields[11]; ?>��</td>
			<td align="center" valign="middle"><?php echo $l_rst->fields[1]; ?></td>
			<td align="center" valign="middle"><?php echo $l_rst->fields[6]; ?></td>
			<td align="center" valign="middle"><img src="images/online_icon.jpg" width="21" height="20" border="0" alt="���߹ۿ�"></td>
			<td align="center" valign="middle"><img src="images/down.jpg" width="20" height="18" border="0" alt="����"></td>
			<td align="center" valign="middle"><img src="images/show_icon.jpg" width="20" height="20" border="0" alt="����"></td>
		</tr>
<?php			
			$l_rst->movenext();
		}
?>
</table>

<?php
	break;
	case "":
	default:
?>
<table width="605" border="0" cellspacing="0" cellpadding="0" class="right_table">
        <tr>
          <td height="30" colspan="6" align="center" valign="middle" background="images/new_file_left.jpg"><div style="font-size:15px; color:#ffffff;">Ӱ��ר��</div>
		  </td>
        </tr>
		<tr>
			<td width="100" height="25" align="center" valign="middle">���</td>
			<td width="25%" align="center" valign="middle">����</td>
			<td width="28%" align="center" valign="middle">��Ҫ��Ա</td>
			<td width="75" align="center" valign="middle">���߹ۿ�</td>
			<td width="75" align="center" valign="middle">����</td>
			<td width="75" align="center" valign="middle">����</td> 
		</tr>
<?php
		$l_sqlstr = "select * from tb_audio where order by id";
		$l_rst = $conn->execute($l_sqlstr);
		while(!$l_rst->EOF){
?>
        <tr onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''">
			<td height="25" align="right" valign="middle" >��<?php echo $l_rst->fields[11]; ?>��</td>
			<td align="center" valign="middle"><?php echo $l_rst->fields[1]; ?></td>
			<td align="center" valign="middle"><?php echo $l_rst->fields[6]; ?></td>
			<td align="center" valign="middle"><img src="images/online_icon.jpg" width="21" height="20" border="0" alt="���߹ۿ�"></td>
			<td align="center" valign="middle"><img src="images/down.jpg" width="20" height="18" border="0" alt="����"></td>
			<td align="center" valign="middle"><img src="images/show_icon.jpg" width="20" height="20" border="0" alt="����"></td>
		</tr>
<?php			
			$l_rst->movenext();
		}
?>
</table>
<?php
	break;
}
?>