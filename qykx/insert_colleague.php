<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>�ޱ����ĵ�</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<script language="javascript">
function checkit(){
		if(form1.colleague_name.value==""){
	        alert("����������!");
   		    form1.colleague_name.select();
			return(false);
         }		        		
       if(form1.colleague_tel.value==""){
			alert("������绰����!");
			form1.colleague_tel.select();
			return(false);
		 }
       if(form1.colleague_mail.value==""){
			alert("�����������ַ!");
			form1.colleague_mail.select();
			return(false);
		 }
	   if(form1.colleague_birthday.value==""){
	        alert("����������!");
			form1.colleague_birthday.select();
			return(false);
		 }	
				return(true);				 
}	
</script>
<body>
<table width="440" height="219" border="0" align="center" cellpadding="0" cellspacing="0" background="images/bg_36.gif">
  <tr>
    <td height="40" colspan="2" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="STYLE33">ͬ����Ϣ���</span></td>
  </tr>
<form name="form1" method="post" action="insert_colleague_ok.php" onSubmit="javascript: return checkit()"> 
 <tr>
    <td width="104" height="22" align="center">����</td>
    <td width="336"><input name="colleague_name" type="text" id="colleague_name" size="25"></td>
  </tr>
  <tr>
    <td height="22" align="center">�绰</td>
    <td><input name="colleague_tel" type="text" id="colleague_tel" size="28" maxlength="20">
      *</td>
  </tr>
  <tr>
    <td height="22" align="center">����</td>
    <td><input name="colleague_mail" type="text" id="colleague_mail" size="28" maxlength="20">
      *</td>
  </tr>
  <tr>
    <td height="22" align="center">����</td>
    <td><input name="colleague_birthday" type="text" id="colleague_birthday" size="15" maxlength="20">
      *�����磺1-1��</td>
  </tr>
  <tr>
    <td height="22" align="center">��ַ</td>
    <td><input name="colleague_address" type="text" id="colleague_address" size="40" maxlength="20"></td>
  </tr>
  <tr>
    <td height="22" align="center">���</td>
    <td><input name="colleague_category" type="text" id="colleague_category" size="28" maxlength="20"></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td><input type="submit" name="Submit" value="�ύ">
    <input type="reset" name="Submit2" value="����"></td>
  </tr>
  <tr>
    <td height="17">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</form>
</table>

</body>
</html>
