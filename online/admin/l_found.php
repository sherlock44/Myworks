<?php
	session_start();
	include "inc/chec.php";
	include "conn/conn.php";
?>
<table width="558" height="110" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="50" align="center" valign="middle" ><font style="font-size:13px; ">�� ־ �� ѯ</font></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><table cellpadding="0" cellspacing="0">
      <tr>
        <td ><table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td ><table border="0" align="center" cellpadding="0" cellspacing="0">
              <form name="list" method="post" action="l_found_chk.php">
              <tr>
                <td height="50" colspan="2" align="center" valign="middle">* ��ϵͳֻ�ܲ�ѯ���µ���־�ļ�</td>
                </tr>
              <tr>
                <td width="125" height="50" align="right" valign="middle">�ļ����</td>
                <td width="200" height="50" align="left" valign="middle"><select name="style"  id="style">
                  <option value="audio" selected>��Ƶ�ļ�</option>
                  <option value="video">��Ƶ�ļ�</option>
				   <option value="all">ȫ��</option>
                </select></td>
              </tr>
              <tr>
                <td height="50" align="right" valign="middle">���ڣ�</td>
                <td height="50" align="left" valign="middle">
				<select name="days"  id="days">
<?PHP
				 $days=date("t");
				 for($i=1; $i <= $days;$i++){
?>
				 <option value="<?php echo $i; ?>" <?php if($i==date("d")) echo "selected"; ?> > <?php echo $i; ?> ��</option>
<?php
	}
?>
                </select></td>
              </tr>
              <tr>
                <td height="50" colspan="2" align="center" valign="middle">
                    <input name="Submit" type="submit" class="submit" value="  ��  ѯ  ">
                    <input name="Submit2" type="button" class="submit" value="  ��  ��  " onClick="javascript:top.window.close()"></td>
                </tr> </form>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
		