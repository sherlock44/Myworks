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
<title>��ȡ�ʼ�</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(images/mrbg.gif);
}
-->
</style>
</head>
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
        <td align="center" valign="top">
		<form action="delmail.php" method="post" name="form1" id="form1">
					  <table width="454" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><table width="454" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr bgcolor="#CCFF33">
                              <td width="44" height="25" align="center" bgcolor="#FAFCFF"><div align="center" class="STYLE1">ѡ��</div></td>
                              <td width="115" height="25" bgcolor="#FAFCFF"><div align="center" class="STYLE1 style2">�ʼ�����</div></td>
                              <td width="127" bgcolor="#FAFCFF"><div align="center" class="STYLE1 style2">������</div></td>
                              <td width="114" bgcolor="#FAFCFF"><div align="center" class="STYLE1 style2">����ʱ��</div></td>
                              <td width="54" bgcolor="#FAFCFF"><div align="center" class="STYLE1 style2">��С</div></td>
                            </tr>
                            <?php
		  $check = imap_check($mbox);
		  $sum=$check->Nmsgs;
		  print_r(imap_search($mbox,"SEEN"));
		  if($sum<=0){
		  ?>
                            <tr>
                              <td height="25" colspan="5" align="center">�����ʼ�</td>
                            </tr>
                            <?php
		  }else{
		   if($_GET[page]=="" || is_numeric($_GET[page]==false)){
		     $page=1;
		   }else{
		     $page=$_GET[page];
		   }
		   
		   $pagesize=10;
		   if($sum%$pagesize==0){
		     $totalpage=$sum/$pagesize;
		   }else{
		     $totalpage=ceil($sum/$pagesize);
		   }
		   
		  
		   $frompage=($page-1)*$pagesize+1; //��ȡÿҳ�ĵ�һ����¼
		   $topage=$frompage+$pagesize;		//��ȡÿҳ�����һ����¼
		   if(($sum-$topage)<0){
		     $topage=$sum+1;
		   }
		  
		  for($i=$frompage;$i<$topage;$i++){ 
		    $obj=imap_headerinfo($mbox,$i);
		  ?>
                            <tr>
                              <td height="25" bgcolor="#FFFFFF"><div align="center">
                                  <input type="checkbox" name="<?php echo $i;?>2" value="<?php echo $i;?>" />
                              </div></td>
                              <td height="25" bgcolor="#FFFFFF"><div align="left">&nbsp;<a href="indexs.php?lmbs=�鿴�ʼ�&id=<?php echo $i?>" class="a1">
                                  <?php
										  if(strtolower(substr($obj->Subject,0,10))==strtolower("=?gb2312?B"))
											 echo base64_decode(substr($obj->Subject,11,(strlen($obj->Subject)-13)));
										   else
											 echo $obj->Subject;
										?>
                              </a></div></td>
                              <td bgcolor="#FFFFFF"><div align="center"><?php echo ($obj->fromaddress);?></div></td>
                              <td bgcolor="#FFFFFF"><div align="center">
                                  <?php 
										   $array=getdate(strtotime($obj->date));
										   echo $array[year]."-".$array[mon]."-".$array[mday]."&nbsp;".$array[hours].":".$array[minutes];
										?>
                              </div></td>
                              <td bgcolor="#FFFFFF"><div align="center">
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
								  ?>
                          </table>
                            <table width="454" height="25" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr bgcolor="#EEEEEE">
                                <td width="50" align="center">
                                  <input name="submit2" type="submit" class="buttoncss" value="ɾ��" /></td>
                                <td width="374"><div align="left">�����ʼ�&nbsp;<?php echo $sum;?>&nbsp;��&nbsp;&nbsp;ÿҳ��ʾ&nbsp;<?php echo $pagesize;?>&nbsp;��&nbsp;(��&nbsp;<?php echo $page;?>&nbsp;ҳ/��&nbsp;<?php echo $totalpage;?>&nbsp;ҳ)</div></td>
                                <td width="162">
                                  <div align="right">
                                    <?php
								  if($page>=2){
								 ?>
                                    <a href="lookmail.php?page=1" title="��ҳ" class="a1"></a> <a href="lookmail.php?page=<?php echo $page-1;?>" class="a1" title="ǰһҳ"></a>
                                    <?    
								  }
								 if($totalpage<=4){
								   for($j=1;$j<=$totalpage;$j++){
								  echo "<a href=lookmail.php?page=".$j." class=a1>".$j."</a>&nbsp;";
								  }
								 }else{
								  for($j=1;$j<=4;$j++){
								  echo "<a href=lookmail.php?page=".$j." class=a1>".$j."</a>&nbsp;";
								  } 
								?>
                                    <a href="lookmail.php?page=<?php if($totalpage>($page+1)) echo $page+1;else echo 1;?>" title="��һҳ" class="a1"></a> <a href="lookmail.php?page=<?php echo $totalpage;?>" title="βҳ" class="a1"></a>
                                    <?php
			}}
			?>
&nbsp;&nbsp;</div></td>
                              </tr>
                            </table></td>
                        </tr>
              </table>
            </form>
		</td>
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
