<?php
	session_start();
	include "inc/chec.php";
	include "conn/conn.php";
?>
<script language="javascript">
function check(){
		var types=list.grade.value;
		if(types=="2"){
			list.father.disabled=false;
		}
		else{
			list.father.disabled=true;
		}	
	}
</script>
<table width="558" height="110" border="0" align="center" cellpadding="0" cellspacing="0">
<form name="list" method="post" action="audiolist_chk.php">
  <tr>
    <td width="567" height="26" align="center" valign="middle"><font style="font-size:13px; ">�� Ƶ Ŀ ¼ �� �� �� ��</font></td>
  </tr>
  <tr>
    <td><table width="559" height="94" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="92"><table width="404" height="90" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="402" valign="top"><table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td height="15" colspan="2">&nbsp;</td>
                </tr>
              <tr>
                <td width="150" height="40" align="right" valign="middle">Ŀ ¼ �� �ƣ�</td>
                <td width="250" height="40" align="left" valign="middle"><input name="names" type="text" id="names"></td>
              </tr>
              <tr>
                <td height="40" align="right" valign="middle">Ŀ ¼ �� ��</td>
                <td height="40" align="left" valign="middle"><select name="grade" OnChange="check()">
                  <option value="1" selected>һ��Ŀ¼</option>
                  <option value="2">����Ŀ¼</option>
                </select></td>
              </tr>
              <tr>
                <td height="40" align="right" valign="middle">�� �� �� �ƣ�</td>
                <td height="40" align="left" valign="middle">
				<select name="father" disabled>
				<?php
					$l_sqlstr = "select * from tb_audiolist where grade = '1'";
					$l_rst = $conn->execute($l_sqlstr);
					while(!$l_rst->EOF){
				?>	
				<option value="<?php echo $l_rst->fields[2]; ?>"><?php echo $l_rst->fields[2]; ?></option>
				<?php
						$l_rst->MoveNext();
					}
				?>
                </select></td>
              </tr>
              <tr>
                <td height="30" colspan="2" align="center" valign="middle">
                    <input name="Submit" type="submit" class="submit" value="��  ��" onclick="return n_chk();">
                    <input name="Submit2" type="button" class="submit" value="��  ��" onClick="javascript:top.window.close()"></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
 </form>
</table>