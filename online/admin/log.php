<?php
	session_start();
	include "inc/chec.php";
	include "conn/conn.php";
?>
<table width="380" height="440" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" valign="top"><table width="380" height="60" border="0" cellpadding="0" cellspacing="0"  >
        <tr>
          <td height="20" colspan="4" align="center" valign="middle">�� �� �� ־ �� ��</td>
        </tr>
        <tr>
          <td colspan="4"><table width="375" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td height="10" colspan="5" align="right" valign="middle"><a href="#" onclick="javacript:Wopen=open('operation.php?action=l_found','���Ŀ¼','height=500,width=665,scrollbars=no');">��־��ѯ</a></td>
              </tr>
              <tr>
                <td height="30" align="center" valign="middle">ID</td>
                <td height="30" align="center" valign="middle">��������</td>
                <td height="30" align="center" valign="middle">�û���</td>
                <td height="30" align="center" valign="middle">�ϴ�ʱ��</td>
                <td height="30" align="center" valign="middle">����</td>
              </tr>
              <?php
			    $years=date("Y");
				$months=date("m");
				
			  	switch ($_GET[types]){	
					case "all":
						$q_date = $years."-".$months."-".$_GET[days];
						$l_sqlstr="select id,name,userName,issueDate,type  from tb_audio where property='�û�' and issueDate like '%".$q_date."%' Union select id,name,userName,issueDate,type from tb_video where property='�û�' and issueDate like '%".$q_date."%'";
						break;
					case "audio":
						$q_date = $years."-".$months."-".$_GET[days];
						$l_sqlstr="select id,name,userName,issueDate,type,address from tb_audio where property='�û�' and issueDate like '%".$q_date."%'";
						break;
					case "video":
						$q_date = $years."-".$months."-".$_GET[days];
			  			$l_sqlstr="select id,name,userName,issueDate,type,address from tb_video where property='�û�' and issueDate like '%".$q_date."%'";
						break;
					default:
			  			$l_sqlstr="select id,name,userName,issueDate,type,address from tb_audio where property='�û�' Union select id,name,userName,issueDate,type,address from tb_video where property='�û�'";
						break;
				}
				$l_rst = $conn->execute($l_sqlstr);
				while(!$l_rst->EOF){ 
				?>
              <tr>
                <td height="18" align="center" valign="middle"><?php echo $l_rst->fields[0]; ?></td>
                <td height="18" align="center" valign="middle"><?php echo $l_rst->fields[1]; ?></td>
                <td height="18" align="center" valign="middle"><?php echo $l_rst->fields[2]; ?></td>
                <td height="18" align="center" valign="middle"><?php echo $l_rst->fields[3]; ?></td>
                	<form name="form1" method="post" action=""><td height="18" align="center" valign="middle">
					<input type="button" name="Submit2" class="submit" value="��ϸ" onclick="javascript:Wopen=open('operation.php?action=<?php echo ($l_rst->fields[4])=="Audio"?"audio":"video"; ?>&id=<?php echo $l_rst->fields[0]; ?>','','height=700,width=665,scrollbars=no');">                    
					</td></form>
              </tr>
              <?php
			  		$l_rst->movenext();
					}
			  ?>
          </table></td>
        </tr>
    </table></td>
  </tr>
</table>

