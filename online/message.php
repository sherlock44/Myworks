<?php
	
	include "./conn/conn.php";
	$sqlstr="select Count(*) as numbers from tb_Register where ToName='".$_SESSION[name]
	."'";
	$u_rst = $conn->execute($sqlstr);
	if(!$u_rst->EOF)
		$num = $u_rst->fields[0];
	else
		$num = 0;
?>
<table width="265" height="205" border="0" cellpadding="0" cellspacing="0">
	<tr>
	  <td colspan="2" align="center" class="l_td">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
	<tr>
	  <td colspan="2" align="center" class="l_td">&nbsp;<a href="#" style="color:#000000 " onClick="javascript:Wopen=open('operation.php?action=s_music','���ϵͳ','height=500,width=665,scrollbars=no');" class="b">���� <?php echo $num; ?> ������Ϣ</a></td>
  </tr>
	<tr>
	  	<td width="100" align="right" valign="middle" class="l_td">�û�����</td>
		<td align="left" valign="middle" class="l_td"><?php echo $_SESSION[name]; ?></td>
	</tr>
	<tr>
	  	<td width="100" align="right" valign="middle" class="l_td">�ȼ���</td>
		<td align="left" valign="middle" class="l_td"><?php echo $_SESSION[grades]; ?></td>
	</tr>
	<tr>
	  	<td width="100" align="right" valign="middle" class="l_td">�ϴ�������</td>
		<td align="left" valign="middle" class="l_td"><?php echo $_SESSION[counts]; ?></td>
	</tr>
<form name="form1" method="post" action="">
	<tr>
		<td colspan="2" align="center" valign="middle" class="l_td">
		<input name="Submit" type="button" id="mod_vip" value="��Ա�����޸�" onClick="javascript:Wopen=open('operation.php?action=mod_vip','','height=500,width=665,scrollbars=no');"><input type="button" name="logout" id="logout" value="�˳���¼" onclick="return l_chk();" class="submit" /></td>
	</tr>
	<tr>
	  <td colspan="2" align="center" valign="middle" class="l_td">&nbsp;</td>
    </tr>
</form>
</table>
