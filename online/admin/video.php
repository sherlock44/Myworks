<?php
	session_start();
	include "conn/conn.php";
	include "inc/chec.php";
?>
<table width="380" height="440" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" valign="top"><table width="380" height="60" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="20" colspan="4" align="center" valign="middle">�� Ƶ �� �� �� ��</td>
        </tr>
        <tr>
          <td colspan="4" class="style1"><table width="375" border="0" align="center" cellpadding="2" cellspacing="2">
              <tr>
                <td height="10" colspan="5" align="right" valign="middle"><a href="#" onclick="javacript:Wopen=open('operation.php?action=videoadd','�����Ƶ','height=700,width=665,scrollbars=no');">�������</a></td>
              </tr>
              <tr>
                <td width="22" height="30" align="center" valign="middle">ID</td>
                <td width="134" height="30" align="center" valign="middle">����</td>
                <td width="67" height="30" align="center" valign="middle">���</td>
                <td width="78" height="30" align="center" valign="middle">����</td>
                <td height="30" align="center" valign="middle">����</td>
              </tr>
              <?php
					$sqlstr = "select * from tb_video";
					$rst = $conn->execute($sqlstr);
					While(!$rst->EOF){
				?>
              <tr>
                <td height="18" align="center" valign="middle"><?php echo $rst->fields[0]; ?></td>
                <td height="18" align="center" valign="middle"><a href="#"><?php echo $rst->fields[1]; ?></a></td>
				<td height="18" align="center" valign="middle"><?php echo $rst->fields[10]; ?></td>
                <td height="18" align="center" valign="middle"><?php echo $rst->fields[3]; ?></td>
				 <td height="18" align="center" valign="middle"><a href="del_video_chk.php?id=<?php echo $rst->fields[0]; ?>" onclick="return del_chk();">ɾ��</a></td> 
				</form>
              </tr>
              <?php $rst->MoveNext();}
				?>
          </table></td>
        </tr>
    </table></td>
  </tr>
</table>
