<?php
	include "conn/conn.php";
?>
<script>
	function found_chk(){
		if(document.getElementById("username").value == ""){
			alert("�ʺŲ�����Ϊ��");
			document.getElementById("username").focus();
			return false;
		}
		if(document.getElementById("question").value == ""){
			alert("������ʾ���ⲻ����Ϊ��");
			document.getElementById("question").focus();
			return false;
		}
		if(document.getElementById("answer").value == ""){
			alert("������ʾ�𰸲�����Ϊ��");
			document.getElementById("answer").focus();
			return false;
		}
	}
	function chk_pwd(){
		if(document.getElementById("password").value == ""){
			alert("���벻����Ϊ��");
			document.getElementById("password").focus();
			return false;
		}
		if(document.getElementById("password").value != document.getElementById("two_pwd").value){
			alert("�������벻һ��");
			document.getElementById("password").focus();
			return false;
		}
	}
</script>
<style type="text/css">
<!--
.submit {
	border: 1px solid #000000;
}
-->
</style>
<?php
	if($_POST[action] == "chk"){
		if(($_POST[username] != "") and ($_POST[question] != "") and ($_POST[answer] != "")){
			$f_sql = "select * from tb_account where question = '$_POST[question]' and answer = '$_POST[answer]' and name='$_POST[username]'";
			$f_rst = $conn->execute($f_sql);
			if(!$f_rst->EOF){	
?>
	<table width="400" border="0" cellspacing="0" cellpadding="0">
<form name="form1" method="post" action="#">
<tr>
	<td width="100" height="30" align="right" valign="middle" scope="col">�û�����</td>
	<td width="294" height="30" align="left" valign="middle" scope="col"><input name="username" id="username" type="text" size="25" readonly="readonly" value="<?php echo $f_rst->fields[1];  ?>" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''">
	<input type="hidden" name="id" value="<?php echo $f_rst->fields[0]; ?>">
	</td>
</tr>
<tr>
	<td height="30" align="right" valign="middle" scope="col">���������룺</td>
	<td height="30" align="left" valign="middle" scope="col"><input name="password" type="password" size="25" id="password" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''"></td>
</tr>
<tr>
	<td width="100" height="30" align="right" valign="middle">ȷ�����룺</td>
	<td width="294" height="30" align="left" valign="middle"><input name="two_pwd" id="two_pwd" type="password" size="25" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''"></td>
</tr>
<tr>
	<td height="30">&nbsp;</td>
	<td height="30">
		<input type="hidden" name="action" value="mod">
  		<input type="submit" name="Submit" value="�ύ" class="submit" onClick="return chk_pwd();">&nbsp;
  		<input type="reset" name="Submit2" value="����" class="submit">    
	</td>
</tr>
</form>
</table>
<?php	
			}
			else{
				echo "<script>alert('������ʾ�����𰸲���ȷ������������');history.back();</script>";
				exit();
			}
		}
	}
	else if($_POST[action] == "mod"){
		if($_POST[password] == $_POST[two_pwd]){
			$m_sql = "update tb_account set password = '".$_POST[password]."' where id = ".$_POST[id];
			if($m_rst = $conn->execute($m_sql) != false)
				echo "<script>alert('�����޸ĳɹ������¼');top.window.close();</script>";
				exit();
				
		}
		else{
			echo "<script>alert('�����޸�ʧ�ܣ����Ժ�����');top.window.close();</script>";
			exit();
		}
	}
	else{
?>
<table width="400" border="0" cellspacing="0" cellpadding="0">
<form name="form1" method="post" action="#">
<tr>
<td width="100" height="30" align="right" valign="middle" scope="col">�û�����</td>
<td width="294" height="30" align="left" valign="middle" scope="col"><input name="username" id="username" type="text" size="25" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''"></td>
</tr>
<tr>
<td height="30" align="right" valign="middle" scope="col">������ʾ���⣺</td>
<td height="30" align="left" valign="middle" scope="col"><input name="question" type="text" size="25" id="question" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''"></td>
</tr>
<tr>
<td width="100" height="30" align="right" valign="middle">������ʾ�𰸣�</td>
<td width="294" height="30" align="left" valign="middle"><input name="answer" id="answer" type="text" size="25" onmouseover="this.style.backgroundColor='#deebef'" onmouseout="this.style.backgroundColor=''"></td>
</tr>
<tr>
<td height="30">&nbsp;</td>
<td height="30">
	<input type="hidden" name="action" value="chk">
	<input type="submit" name="Submit" value="�ύ" class="submit" onClick="return found_chk();">&nbsp;
	<input type="reset" name="Submit2" value="����" class="submit">    
</td>
</tr>
</form>
</table>
<?php
}
?>
