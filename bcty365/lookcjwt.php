<link rel="stylesheet" type="text/css" href="css/style.css">
<table width="642" align="center" border="0" cellspacing="0" cellpadding="0">
          <td height="30" valign="middle" background="images/bg_12(2).jpg"><table width="610">
            <tr>
              <td width="109" rowspan="2">&nbsp;</td>
              <td width="379" height="3"></td>
              <td width="106" rowspan="2">&nbsp;</td>
            <tr>
              <td>&nbsp;��������</td>
            </table></td>
        </tr>
        <tr>
          <td  width="642" align="center" valign="top">
   <table width="642" border="1" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF" bgcolor="#6EBEC7">
        <tr>
          <td bgcolor="#FFFFFF">


<?php
include_once("conn/conn.php");
include_once("function.php");
$sql=mysql_query("select * from tb_cjwt where id='".$_GET["id"]."'",$conn);
$info=mysql_fetch_array($sql);
?>
<table width="635" height="100" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="94" height="30"><div align="center"><strong>��&nbsp;&nbsp;�⣺</strong></div></td>
              <td width="541"><?php echo unhtml($info["question"]);?></td>
            </tr>
            <tr>
              <td height="70"><div align="center"><strong>��&nbsp;&nbsp;��</strong></div></td>
              <td height="70">&nbsp;<?php echo unhtml($info["answer"]);?></td>
            </tr>
</table>


</td>
        </tr></table>
          </td>
        </tr>
      </table>