<?php
	session_start();
	include "conn/conn.php";
	include "inc/func.php";
?>
<table width="558" height="110" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="567" height="26" valign="bottom"><div align="center"><font style="color:#000000; font-size:13px; ">�� �� �� ��</font> </td>
  </tr>
  <tr>
    <td><table width="559" height="94" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="92"><table width="404" height="90" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="402" valign="top"><table width="400" height="300" border="0" align="center" cellpadding="0" cellspacing="0">
              
              <tr>
                <td colspan="2" valign="top"><table width="404" height="90" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="402" valign="top"><table width="400" height="480" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td height="15" colspan="2">&nbsp;</td>
                        </tr>
						<form action="trans_chk.php" method="post" enctype="multipart/form-data" name="list">
						<tr>
                          <td height="20" align="right" valign="middle">��Ϣ���ͣ�</td>
                          <td height="20">
                            <select name="types" onchange="window.location='operation.php?action=trans&types=' + this.value;">
                              <option value="Audio" <?php if ($_REQUEST[types]=="Audio") echo "selected"; ?>>��Ƶ</option>
                              <option value="Video" <?php if (($_REQUEST[types]=="Video") or ($_REQUEST[types]=="")) echo "selected"; ?>>��Ƶ</option>
                            </select>							</td>
                        </tr>
                        <tr>
                          <td height="20" align="right" valign="top">ͼƬ��Ϣ��</td>
                          <td height="20" valign="top">
						      <input name="picture" type="file">
						      <br /><font color="red">(�ϴ�ͼƬ��С���ܳ���700K)</font></td>
                        </tr>
                        <tr>
                          <td height="20" align="right" valign="top">�ϴ����ݣ�</td>
                          <td height="20" valign="top">						 
						      <input name="address" type="file">
						      <br /><font color="red">(��Ƶ�ļ����ܳ���10M����Ƶ�ļ����ܳ���300M)</font></td>
                        </tr>
				<?php 
				

						switch ($types){
							case "Audio":
								Audio();
								break;
						 	case "Video":
						 		Video();
								break; 
							default:
						 		Video();
								break; 
						}
				?>
                        <tr>
                          <td height="30" colspan="2"><div align="center">
                              <input name="Submit" type="submit"  value="  ��  ��">
                              ��*Ϊ�����
                              <input name="Submit2" type="button"  value="��  ��  " onClick="javascript:top.window.close()">                          </td>
                        </tr>
						 </form>
                    </table></td>
                  </tr>
                </table></td>
                </tr> 
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>