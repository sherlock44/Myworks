<?php
	session_start();
	include "inc/chec.php";
	include "conn/conn.php";
?>
<table width="380" height="440" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" valign="top"><table width="380" height="60" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="20" colspan="4" align="center" valign="middle">�� �� Ա �� ��</td>
        </tr>
        <tr>
          <td colspan="4"><table width="375" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td height="10" colspan="5" align="right" valign="middle"><a href="#" onclick="javacript:Wopen=open('operation.php?action=addmanager','��ӹ���Ա','height=500,width=655,scrollbars=no');">����Ա���</a></td>
              </tr>
              <tr>
                <td height="30" align="center" valign="middle">ID</td>
                <td height="30" align="center" valign="middle">�ȼ�</td>
                <td height="30" align="center" valign="middle">����                </td>
                <td height="30" align="center" valign="middle">��ʵ����</td>
                <td height="30" align="center" valign="middle">����</td>
              </tr>
<?php
			  	$m_sqlstr="select * from tb_manager where id<>1 order by id";
				$m_rst = $conn->execute($m_sqlstr);
				while(!$m_rst->EOF){ 
?>
              <tr>
                <td height="18" align="center" valign="middle"><?php echo $m_rst->fields[0]; ?></td>
                <td height="18" align="center" valign="middle"><?php echo $m_rst->fields[3]; ?></td>
                <td height="18" align="center" valign="middle"><?php echo $m_rst->fields[1]; ?></td>
                <td height="18" align="center" valign="middle"><?php echo $m_rst->fields[4]; ?></td>
                 <form name="form1" method="post" action="m_freeze_chk.php">
				 <td height="18" align="center" valign="middle">
<?php
	if($m_rst->fields[6] == "1") 
		$bt = "����"; 
	else 
		$bt = "�ⶳ"; 

?>
					<input type="hidden" name="id" value="<?php echo $m_rst->fields[0]; ?>">
					<input type="hidden" name="whether" value="<?php echo $m_rst->fields[6]; ?>">
                    <input type="submit" name="Submit2" class="submit" value="<?php echo $bt; ?>">
                    <a href="del_mfreeze_chk.php?id=<?php echo $m_rst->fields[0]; ?>" onClick="return del_chk();">ɾ��</a>
                </td> 
				</form>
              </tr>
<?php
			  	$m_rst->movenext();
				}
?>
          </table></td>
        </tr>
    </table></td>
  </tr>
</table>

