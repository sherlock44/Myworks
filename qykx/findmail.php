<?php session_start();
$hostname=$_SESSION[host];
$username=$_SESSION[user];
$userpwd=$_SESSION[pwd];
if(!$mbox=@imap_open("$hostname","$username","$userpwd")){
   echo "<script>alert('��¼��ʱ�������µ�¼!');history.back();</script>";
   exit;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�����ʼ�</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<style type="text/css">
<!--
.STYLE1 {color: #FFFFFF}
body {
	background-image: url(images/mrbg.gif);
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>
<script language="javascript">
  function chkinput(form){
    if(form.content.value==""){
	  alert("������Ҫ���ҵ����ݣ�");
	  form.content.select();
	  return(false);
	}
   var i=form.content.value.indexOf("@");
	var j=form.content.value.indexOf(".");
	if((form.method.value=="1")&&((i<0)||(i-j>0)||(j<0)))
	 {
       alert("��������ȷ���ռ���E-mail��ַ!");
	   form.content.select();
	   return(false);
	 }	
  
  }

</script>
<body>
<table width="604"  border="00" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="135" height="421" valign="top">
      <?php
	include("mail_left.php");
	?>    </td>
    <td width="454" align="center" valign="top"><table width="454" height="421" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="35"><img src="images/mail_04.gif" width="454" height="35"></td>
      </tr>
      <tr>
        <td width="454" height="29" background="images/mail_07.gif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="STYLE22"><?php echo $lmbs;?></span></td>
      </tr>
      <tr>
        <td align="center" valign="top"><table width="454" height="25" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <form action="indexs.php?lmbs=����" method="post" name="form1" id="form1" onSubmit="return chkinput(this)">
                            <td align="center">�����ʼ���
                                    <select name="method">
                                      <option value="1">������</option>
                                      <option value="2">��&nbsp;&nbsp;��</option>
                                    </select>
                    &nbsp;
                                    <input type="text" name="content" class="inputcss"  style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'" size="30" />
                    &nbsp;
                                    <input type="submit" value="����" class="buttoncss" name="submit" /></td>
                          </form>
                        </tr>
                      </table>
                        <table width="454" height="20" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
</table>
                        <?php
	 if($_POST[submit]!=""){
	?>
                    <table width="454" height="50" border="0" align="center" cellpadding="0" cellspacing="1">
                                <tr align="center" bgcolor="#BBE323">
                                  <td width="186"  height="25">�ʼ�����</td>
                                  <td width="153">������</td>
                                  <td width="136">����ʱ��</td>
                                  <td width="100">��С</td>
                                </tr>
                                <?php
				  $method=$_POST[method];
				  $content=$_POST[content];
	 if($method=="1"){
				  $arr=imap_search($mbox,"FROM $content");
                            
				  if($arr!=false){
		            for($a=0;$a<count($arr);$a++){
				       $i=$arr[$a];
		               $obj=imap_headerinfo($mbox,$i); 
				?>
                                <tr>
                                  <td height="25"><div align="left">&nbsp;<a href="lookmailinfo.php?id=<?php echo $i?>" class="a1">
                                      <?php 
			  if(strtolower(substr($obj->Subject,0,10))==strtolower("=?gb2312?B"))
			     echo base64_decode(substr($obj->Subject,11,(strlen($obj->Subject)-13)));
			   else
			     echo $obj->Subject;
            ?>
                                  </a></div></td>
                                  <td><div align="center"><?php echo ($obj->fromaddress);?></div></td>
                                  <td><div align="center">
                                      <?php 
			       $array=getdate(strtotime($obj->date));
			        echo $array[year]."-".$array[mon]."-".$array[mday]."&nbsp;".$array[hours].":".$array[minutes];
			   ?>
                                  </div></td>
                                  <td><div align="center">
                                      <?php 
			   $size=$obj->Size;
			    if($size>=1024)
				  {
				    echo number_format(($size/1024),2)."&nbsp;KB";
				  
				  }
				  elseif($size>1024*1024)
				  {
				    echo number_format(($size/(1024*1024)),2)."&nbsp;M";
				  }
				  elseif($size>1024*1024*1024)
				  {
				    echo number_format(($size/(1024*1024*1024)),2)."&nbsp;G";
				  }
				  elseif($size<1024)
				  {
				    echo ($size)."&nbsp;�ֽ�";
				  }
			?>
                                  </div></td>
                                </tr>
                                <?php   
				    }
				  }else{
				 
				  ?>
                                <tr>
                                  <td height="25" colspan="4"><div align="center">û�в��ҵ���Ҫ�ҵ��ʼ���</div></td>
                                </tr>
                                <?php
				  }
	    }elseif($method=="2"){
			     $check = imap_check($mbox);
		         $sum=$check->Nmsgs;
				 $arr=imap_search($mbox,"SUBJECT $content");
				if($arr!=false){
				 for($a=0;$a<count($arr);$a++){ 
				   $i=$arr[$a];
		         $obj=imap_headerinfo($mbox,$i); 
				?>
                                <tr>
                                  <td height="25"><div align="left">&nbsp;<a href="lookmailinfo.php?id=<?php echo $i?>" class="a1">
                                      <?php 
			  if(strtolower(substr($obj->Subject,0,10))==strtolower("=?gb2312?B"))
			     echo base64_decode(substr($obj->Subject,11,(strlen($obj->Subject)-13)));
			   else
			     echo $obj->Subject;
            ?>
                                  </a></div></td>
                                  <td><div align="center"><?php echo ($obj->fromaddress);?></div></td>
                                  <td><div align="center">
                                      <?php 
			       $array=getdate(strtotime($obj->date));
			        echo $array[year]."-".$array[mon]."-".$array[mday]."&nbsp;".$array[hours].":".$array[minutes];
			   ?>
                                  </div></td>
                                  <td><div align="center">
                                      <?php 
			   $size=$obj->Size;
			    if($size>=1024)
				  {
				    echo number_format(($size/1024),2)."&nbsp;KB";
				  
				  }
				  elseif($size>1024*1024)
				  {
				    echo number_format(($size/(1024*1024)),2)."&nbsp;M";
				  }
				  elseif($size>1024*1024*1024)
				  {
				    echo number_format(($size/(1024*1024*1024)),2)."&nbsp;G";
				  }
				  elseif($size<1024)
				  {
				    echo ($size)."&nbsp;�ֽ�";
				  }
			?>
                                  </div></td>
                                </tr>
                                <?php
				     
				    }
				  }else{
				  ?>
                                <tr>
                                  <td height="25" colspan="4" bgcolor="#FFFFFF"><div align="center">û�в��ҵ���Ҫ�ҵ��ʼ���</div></td>
                                </tr>
                                <?php
				  }
			}	  
				?>
                            </table>                        <?php
	 }
	?></td>
      </tr>
      <tr>
        <td height="27"><img src="images/mail_10.gif" width="454" height="27"></td>
      </tr>
    </table></td>
    <td width="15" valign="top"><img src="images/mail_05.gif" width="15" height="421"></td>
  </tr>
</table>

<?php
imap_close($mbox);
?>
</body>
</html>
