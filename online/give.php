<?php
	session_start();
	include "conn/conn.php";
?>
<script src="js/register.js"></script>
<table width="558" height="110" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="567" height="26" valign="bottom"><div align="center"><font style="color:#000000; font-size:13px; ">�� �� �� ¼ �� ��</font> </div></td>
  </tr>
  <tr>
    <td><table width="559" height="94" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="92"><table width="404" height="90" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="402" valign="top"><table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
              <form name="list" method="post" action="?action=give">
              <tr>
                <td height="15" colspan="2">&nbsp;</td>
                </tr>
              <tr valign="top">
                <td width="75" height="30"><div align="right" ></div> 
                  <div align="right" >�����ˣ�</div></td>
                <td width="325" height="30"><input name="toname" type="text"  id="toname" size="30"></td>
              </tr>
              <tr>
                <td height="30" valign="top"><div align="right" >ף���</div></td>
                <td height="80" valign="top"><textarea name="remark" cols="40" rows="5"  id="remark"></textarea></td>
              </tr>
              <tr>
                <td height="40" colspan="2"><div align="center">
					<input name="id" type="hidden" value="<?php echo $_GET[id] ?>">
                    <input name="Submit" type="button"  value="  ��  ��  " onClick="return register()">
                    <input name="Submit2" type="button"  value="  ��  ��  " onClick="javascript:top.window.close()">
                </div></td>
                </tr> </form>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>

<?php
	if($_POST[toname] <> ""){
	
	$id=$_POST[id];
	$toname=$_POST[toname];
	$from=$_SESSION[name];
	$remark=$_POST[remark];
	$sql="insert into tb_register Values('',".$id.",'".$from."','".$toname."','".$remark."','".date("Y-m-d H:i:s")."')";
	$rst = $conn->execute($sql);
	
?>
<script language="javascript">
<?php
	if(!($rst == false)){	
?>
	alert("�����Ϣ����ɹ�");
<?php
	}else{
?>
	alert("���ʧ��");
<?php
}
?>
	top.opener.location.reload();
	top.window.close();
</script>	
<?php 
}
?>