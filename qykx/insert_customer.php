<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="css/sytle.css">
<title>�ͻ���Ϣ����</title>
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
		if(form1.customer_name.value==""){
	        alert("����������!");
   		    form1.customer_name.select();
			return(false);
         }		        		
       if(form1.customer_tel.value==""){
			alert("������绰����!");
			form1.customer_tel.select();
			return(false);
		 }
       if(form1.customer_mail.value==""){
			alert("�����������ַ!");
			form1.customer_mail.select();
			return(false);
		 }
	   if(form1.customer_birthday.value==""){
	        alert("����������!");
			form1.customer_birthday.select();
			return(false);
		 }	
				return(true);				 
}	
</script>
<body>
<table width="440" height="219" border="0" align="center" cellpadding="0" cellspacing="0" background="images/bg_36.gif">
  <tr>
    <td height="40" colspan="2" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="STYLE33">�ͻ���Ϣ���</span></td>
  </tr>
<form name="form1" method="post" action="insert_customer_ok.php" onSubmit="javascript: return checkit()"> 
 <tr>
    <td width="107" align="center" class="STYLE1">����</td>
    <td width="333"><input name="customer_name" type="text" id="customer_name" size="25"></td>
  </tr>
  <tr>
    <td align="center" class="STYLE1">�绰</td>
    <td><input name="customer_tel" type="text" id="customer_tel" size="28" maxlength="20">
      <span class="STYLE1">*</span></td>
  </tr>
  <tr>
    <td align="center" class="STYLE1">����</td>
    <td><input name="customer_mail" type="text" id="customer_mail" size="28" maxlength="20">
      <span class="STYLE1">*</span></td>
  </tr>
  <tr>
    <td align="center" class="STYLE1">����</td>
    <td><input name="customer_birthday" type="text" id="customer_birthday" size="15" maxlength="20">
      <span class="STYLE1">*�����磺1-11��</span></td>
  </tr>
  <tr>
    <td align="center" class="STYLE1">��ַ</td>
    <td><input name="customer_address" type="text" id="customer_address" size="40" maxlength="20"></td>
  </tr>
  <tr>
    <td align="center" class="STYLE1">���</td>
    <td><input name="customer_category" type="text" id="customer_category" size="28" maxlength="20"></td>
  </tr>
  <tr>
    <td height="47">&nbsp;</td>
    <td><input type="submit" name="Submit" value="�ύ">
    <input type="reset" name="Submit2" value="����"></td>
  </tr>
</form>
</table>

</body>
</html>
