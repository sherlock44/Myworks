<?php
	session_start();
	
	include "conn/conn.php";
	$m_sqlstr = "select * from tb_account where id = ".$_SESSION[id];
	$m_rst = $conn->execute($m_sqlstr);
	if(!$m_rst->EOF){
?>
<table width="500" border="1" cellspacing="0" cellpadding="0">
	<tr>
		<td><table width="500" border="0" cellspacing="0" cellpadding="0">
 		<form id="reg" name="reg" method="post" action="mod_vip_chk.php">
 			<tr>
   			   <td width="50" rowspan="18" align="center" valign="top">&nbsp;</td>
   			   <td height="20" colspan="2" align="center" valign="top" class="top_td">&nbsp;</td>
   			   <td width="50" rowspan="18" align="center" valign="top">&nbsp;</td>
  			</tr>
  			<tr>
      			<td width="150" height="20" align="right" valign="middle" class="left_td" scope="col">�û�����</td>
   			  <td align="left" valign="middle" class="right_td" scope="col"><input type="text" name="name" id="name" class="usual" value="<?php echo $m_rst->fields[1]; ?>" readonly="readonly" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''"/></td>
    		</tr>
    		<tr>
      			<td width="150" height="20" align="right" valign="middle" class="left_td">���룺</td>
   			  <td align="left" valign="middle" class="right_td"><input type="password" name="password" id="password" class="usual" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''"/><span class="STYLE1"> *</span>(����3λ)</td>
    		</tr>
    		<tr>
      			<td width="150" height="20" align="right" valign="middle" class="left_td">ȷ�����룺</td>
   			  <td align="left" valign="middle" class="right_td"><input type="password" name="t_password" id="t_password" class="usual" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''" /><span class="STYLE1"> *</span></td>
    		</tr>
    		<tr>
      			<td width="150" height="20" align="right" valign="middle" class="left_td">��ʵ������</td>
      			<td align="left" valign="middle" class="right_td"><input type="text" name="realname" id="realname" class="usual" value="<?php echo $m_rst->fields[5]; ?>" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''"/></td>
    		</tr>
    		<tr>
      			<td width="150" height="20" align="right" valign="middle" class="left_td">�Ա�</td>
      			<td align="left" valign="middle" class="right_td">
				<?php if($m_rst->fields[7] == "��"){ ?>
				<input name="sex" id="sex" type="radio" value="��" checked />��
				<input name="sex" id="sex" type="radio" value="Ů"/>Ů
				<?php }else{?>
				<input name="sex" id="sex" type="radio" value="��" />��
				<input name="sex" id="sex" type="radio" value="Ů" checked />Ů
				<?php } ?>
				</td>
    		</tr>
    		<tr>
      			<td width="150" height="20" align="right" valign="middle" class="left_td">���䣺</td>
     			<td align="left" valign="middle" class="right_td"><input type="text" name="age" id="age" class="usual" value="<?php echo $m_rst->fields[8]; ?>" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''"/></td>
    		</tr>
    		<tr>
      			<td width="150" height="20" align="right" valign="middle" class="left_td">���֤�ţ�</td>
      			<td align="left" valign="middle" class="right_td"><input type="text" name="numbers" id="numbers" class="usual" value="<?php echo $m_rst->fields[6]; ?>" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''"/></td>
    		</tr>
    		<tr>
      			<td width="150" height="20" align="right" valign="middle" class="left_td">ְҵ��</td>
      			<td align="left" valign="middle" class="right_td"><input type="text" name="job" id="job" class="usual" value="<?php echo $m_rst->fields[9]; ?>" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''"/></td>
    		</tr>
    		<tr>
      			<td width="150" height="20" align="right" valign="middle" class="left_td">E-mail��</td>
      			<td align="left" valign="middle" class="right_td"><input type="text" name="email" id="email" class="usual" value="<?php echo $m_rst->fields[10]; ?>" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''"/></td>
    		</tr>
    		<tr>
      			<td width="150" height="20" align="right" valign="middle" class="left_td">��ϵ�绰��</td>
      			<td align="left" valign="middle" class="right_td"><input type="text" name="phone" id="phone" class="usual" value="<?php echo $m_rst->fields[12]; ?>" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''"/></td>
    		</tr>
    		<tr>
      			<td width="150" height="20" align="right" valign="middle" class="left_td">��ϵ��ַ��</td>
      			<td align="left" valign="middle" class="right_td"><input type="text" name="address" id="address" class="usual" value="<?php echo $m_rst->fields[11]; ?>" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''"/></td>
    		</tr>
    		<tr>
      			<td width="150" height="20" align="right" valign="middle" class="left_td">QQ��</td>
      			<td align="left" valign="middle" class="right_td"><input type="text" name="qq" id="qq" class="usual" value="<?php echo $m_rst->fields[13]; ?>" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''" /></td>
    		</tr>
   			<tr>
     			 <td width="150" height="20" align="right" valign="middle" class="left_td">������ҳ��</td>
      			<td align="left" valign="middle" class="right_td"><input type="text" name="http" id="http" class="usual" value="<?php echo $m_rst->fields[14]; ?>" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''"/></td>
   		 	</tr>
    		<tr>
      			<td height="30" colspan="2" align="center" valign="middle" class="bottom_td">
				<input type="hidden" name="id" value="<?php echo $_SESSION[id]; ?>">
				<input name="regi" type="submit" id="regi" value="�޸�" onclick="return reg_chk();" />(<span class="STYLE1">*</span>��Ϊ������)
   			    <input name="reset" type="reset" id="reset" value="����" /></td>
    		</tr></form></table>
	</td></tr></table>
<?php
	}
?>
