<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ޱ����ĵ�</title>

<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

</head>

<body>
<table width="97%" border="1" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF" bgcolor="#EBEBEB">
  <tr>
    <td width="15%" height="20" align="center" bgcolor="#E9F7FD"><span class="STYLE1">����</span></td>
    <td width="15%" align="center" bgcolor="#E9F7FD"><span class="STYLE1">�绰</span></td>
    <td width="15%" align="center" bgcolor="#E9F7FD"><span class="STYLE1">����</span></td>
    <td width="15%" align="center" bgcolor="#E9F7FD"><span class="STYLE1">����</span></td>
    <td width="22%" align="center" bgcolor="#E9F7FD"><span class="STYLE1">��ַ</span></td>
    <td width="18%" align="center" bgcolor="#E9F7FD"><a href="#" class="STYLE1" onClick="MM_openBrWindow('insert_colleague.php','','toolbar=yes,width=440,height=219')">���ͬ��</a></td>
  </tr>
    <?php
       include("conn/conn.php");
	   $sql="select * from tb_colleague";
	   $rs=new com("adodb.recordset");
	   $rs->open($sql,$conn,3,3);
	 		   $rs->pagesize=10;
	   if((trim(intval($_GET[page]))=="")||(intval($_GET[page])>$rs->pagecount)||(intval($_GET[page])<=0))
	    {
		  $page=1;
		}
	   else
		{
		  $page=intval($_GET[page]); 
		}
	    
	   if($rs->eof || $rs->bof)
	    {
	?>
	<tr>
        <td height="20" colspan="6" align="center" bgcolor="#F8F8F8"><div align="center" class="STYLE1">û����Ϣ��</div></td>
        </tr>
	
	<?php
		}
	   else
		{		
		
		 $res->absolutepage=$page;
		 $mypagesize=$rs->pagesize;
		 while(!$rs->eof && $mypagesize>0)
		  {
	  ?>
  <tr>
    <td align="center" bgcolor="#F8F8F8"><span class="STYLE1">
      <?php $fields=$rs->fields(colleague_name);echo $fields->value;?>
    </span></td>
    <td align="center" bgcolor="#F8F8F8"><span class="STYLE1">
      <?php $fields=$rs->fields(colleague_tel);echo $fields->value;?>
    </span></td>
    <td align="center" bgcolor="#F8F8F8"><span class="STYLE1">
      <?php $fields=$rs->fields(colleague_mail);echo $fields->value;?>
    </span></td>
    <td align="center" bgcolor="#F8F8F8"><span class="STYLE1">
      <?php $fields=$rs->fields(colleague_birthday);echo $fields->value;?>
    </span></td>
    <td align="center" bgcolor="#F8F8F8"><span class="STYLE1">
      <?php $fields=$rs->fields(colleague_address);echo $fields->value;?>
    </span></td>
    <td align="center" bgcolor="#F8F8F8"><a href="delete_colleague_customer.php?lmbs=<?php echo $_GET[lmbs];?>&colleague=<?php $fields=$rs->fields(colleague_id);echo $fields->value;?>" class="STYLE1">ɾ��</a></td>
<?php
          $mypagesize--;
	     $rs->movenext;
	   }}
	  ?>
  </tr>
  <tr>
    <td colspan="6" align="center" bgcolor="#F8F8F8">
<table width="95%" height="20" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="345" height="25" class="STYLE1">
	<div align="left">�ϼ�<?php echo $rs->recordcount;?>��&nbsp;ÿҳ��ʾ<?php echo $rs->pagesize;?>����Ϣ&nbsp;��<?php echo $page;?>ҳ/��<?php echo $rs->pagecount;?>ҳ	</div></td>
    <td width="385" class="STYLE1">
	<div align="right">	
	<?php
   if($page>=2)
	{
?>
   
<?php
    }
   if($rs->pagecount<=4)
     {
		for($i=1;$i<=$rs->pagecount;$i++)
		{
?>
        <a href="file_gl.php?page=<?php echo $i;?>"><?php echo $i;?></a>
<?php
		 }
	  }
	else
	  {
		 for($i=1;$i<=4;$i++)
		  {	 
?>
          <a href="file_gl.php?page=<?php echo $i;?>"><?php echo $i;?></a>
<?php 
          }
?>
         
  <?php 
          }
  ?>
	</div>	</td>
  </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
