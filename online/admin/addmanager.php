<?php
	session_start();
	include "conn/conn.php";
	include "inc/chec.php";
?>
<table width="558" height="110" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="567" height="26" align="center" valign="middle"><font style=" font-size:13px; ">�� �� Ա �� Ϣ �� ��</font></td>
  </tr>
  <tr>
    <td><table width="559" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="92"><table width="404" height="90" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="402" valign="top"><table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
              <form name="list" method="post" action="addmanager_chk.php">
              <tr>
                <td height="15" colspan="2">&nbsp;</td>
                </tr>
              <tr>
                <td width="131" height="30" align="right" valign="middle"> ����Ա���ƣ�</td>
                <td width="269" height="30" align="left" valign="middle"><input name="names" type="text"  id="names" size="30"></td>
              </tr>
              <tr>
                <td height="30" align="right" valign="middle">�������룺</td>
                <td height="30" align="left" valign="middle"><input name="password" type="password"  id="password" size="30"></td>
              </tr>
              <tr>
                <td height="30" align="right" valign="middle">����ȷ�ϣ�</td>
                <td height="30" align="left" valign="middle"><input name="password2" type="password"  id="password2" size="30"></td>
              </tr>
			  <tr>
                <td height="30" align="right" valign="middle">����Ȩ�ޣ�</td>
                <td height="30" align="left" valign="middle">                  <select name="grade"  id="select">
                  <option value="��ƵĿ¼����Ա" selected>��ƵĿ¼����Ա</option>
                  <option value="��ƵĿ¼����Ա">��ƵĿ¼����Ա</option>
                  <option value="��Ƶ���ݹ���Ա">��Ƶ���ݹ���Ա</option>
                  <option value="��Ƶ���ݹ���Ա">��Ƶ���ݹ���Ա</option>
                  <option value="��Ա���ݹ���Ա">��Ա���ݹ���Ա</option>
                  <option value="��Ա�ȼ�����Ա">��Ա�ȼ�����Ա</option>
                </select></td>
              </tr>
			  <tr>
                <td height="30" align="right" valign="middle">��ʵ������</td>
                <td height="30" align="left" valign="middle"><input name="realname" type="text"  id="realname" size="30"></td>
              </tr>
              <tr>
                <td height="30" colspan="2" align="center" valign="middle">
					<?php echo $_POST[names]; ?>
                    <input name="Submit" type="button"  value="��  ��" class="submit" onClick="check();">
                    <input name="Submit2" type="button"  value="��  ��" class="submit" onClick="javascript:top.window.close()"></td>
                </tr> </form>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>