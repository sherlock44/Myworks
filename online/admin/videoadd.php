<?php
	session_start();
	include "inc/chec.php";
	include "conn/conn.php";
?>
<script src="js/riq.js" language="javascript"></script>
<table width="558" height="110" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="567" height="26" align="center" valign="middle"><font style=" font-size:13px; ">�� Ƶ �� �� �� ��</font></td>
  </tr>
  <tr>
    <td>
	<table width="559" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="92">
		<table width="404" border="0" align="center" cellpadding="0" cellspacing="0"  >
          <tr>
            <td width="402" valign="top">
			 <form name="list" method="post" action="dataadd_chk.php" enctype="multipart/form-data">
			<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
             
              <tr>
                <td width="400" height="15" colspan="2">&nbsp;</td>
                </tr>
				   <tr>
                      <td width="131" height="20" align="right" valign="middle">���ƣ�</td>
                          <td width="269" height="20" align="left" valign="middle">
                        <input name="names" type="text"  id="names" size="30">*</td>
                      </tr>
				   <tr>
				     <td height="20" align="right" valign="middle">ͼƬ���ƣ�</td>
				     <td height="20" align="left" valign="middle"><input name="picture" type="file"  id="picture" size="15" >
					 *(���700K)</td>
				     </tr>
				   <tr>
				     <td height="20" align="right" valign="middle">�������ƣ�</td>
				     <td height="20" align="left" valign="middle"><input name="address" type="file" id="address" size="15">
					 *(���300M)</td>
				     </tr>
                        <tr>
                          <td height="20" align="right" valign="middle">�ݳ��ߣ�</td>
                          <td height="20" align="left" valign="middle">
                            <input name="actor" type="text"  id="grade" size="30">*</td>
                        </tr>
                        <tr>
                          <td height="20" align="right" valign="middle">�ݳ������ͣ�</td>
                          <td height="20" align="left" valign="middle">
                      <input type="radio" name="actortype" value="����" checked>����
                      <input type="radio" name="actortype" value="���">���
					  <input type="radio" name="actortype" value="�ֶ�">�ֶ�*</td>
                        </tr>
                        <tr>
                          <td height="20" align="right" valign="middle">���ʣ�</td>
                          <td height="20" align="left" valign="middle">
                            <input name="ci" type="text" >*</td>
                        </tr>
                        <tr>
                          <td height="20" align="right" valign="middle">������</td>
                          <td height="20" align="left" valign="middle">
                            <input name="qu" type="text" >*</td>
                        </tr>
                        <tr>
                          <td height="20" align="right" valign="middle">�����̣�</td>
                          <td height="20" align="left" valign="middle">
                            <input name="publisher" type="text"  id="publisher" size="30">*</td>
                        </tr>
                        <tr>
                          <td height="20" align="right" valign="middle">���ԣ�</td>
                          <td height="20" align="left" valign="middle">                            
                        <input type="radio" name="language" value="����" checked> 
                        ����
                        <input type="radio" name="language" value="Ӣ��">
                        Ӣ��
                        <input type="radio" name="language" value="����"> 
                        ����
                        <br>
                        <input type="radio" name="language" value="����"> 
                        ����
                        <input type="radio" name="language" value="����">
                        ����
                        <input type="radio" name="language" value="����"> 
                        ���� *</td>
                        </tr>
                        <tr>
                          <td height="20" align="right" valign="middle">�������ࣺ</td>
                          <td height="20" align="left" valign="middle">
							<select name="style"  id="style" >
<?php		$a_sqlstr="select * from tb_videoList where grade='2'";
			$a_rst = $conn->execute($a_sqlstr);
			while(!$a_rst->EOF){ 
?>
							<option value="<?php echo $a_rst->fields[2]; ?>"><?php echo $a_rst->fields[2]; ?></option>
<?php 		$a_rst->movenext();
			}
?>
							</select>*</td>
                        </tr>
						<tr>
                          <td height="20" align="right" valign="middle">һ�����ࣺ</td>
                          <td height="20" align="left" valign="middle">                                                        
                            <select name="types"  id="types">
<?php
		$t_sqlstr = "select * from tb_videolist where grade = '1'";
		$t_rst = $conn->execute($t_sqlstr);
		while(!$t_rst->EOF){
?>
					<option value="<?php echo $t_rst->fields[2]; ?>"><?php echo $t_rst->fields[2]; ?></option>
<?php
			$t_rst->movenext();
		}
?>
							</select>
                          *</td>
                        </tr>
                        <tr>
                          <td height="20" align="right" valign="middle">���й��ң�</td>
                          <td height="20" align="left" valign="middle">
                            <input name="from" type="text"  id="from" size="30">*</td>
                        </tr>
                        <tr>
                          <td height="20" align="right" valign="middle">����ʱ�䣺</td>
                          <td height="20" align="left" valign="middle">
                            <input name="publishtime" type="text"  id="publishtime" size="15" readonly="readonly"><input type="button" value="" onClick="loadCalendar(list.publishtime);">*</td>
                        </tr>

                        <tr>
                          <td height="20" align="right" valign="middle">��Ҫ���ܣ�</td>
                          <td height="20" align="left" valign="middle">
                            <textarea name="remark" cols="35" rows="5"  id="remark"></textarea>*</td>
                        </tr>
              		<tr>
               			 <td height="30" colspan="2" align="center">
						 <input name="action" type="hidden" value="v">
                     <input name="Submit" type="submit" class="submit"  value="��  ��" onclick="return a_chk();">
                    ��*Ϊ�����                    
                    <input name="Submit2" type="button" class="submit"  value="��  ��" onClick="javascript:top.window.close()">                		</td>
                </tr> 
            </table>
			</form>
			</td>
          </tr>
        </table>
		</td>
      </tr>
    </table>
	</td>
  </tr>
</table>