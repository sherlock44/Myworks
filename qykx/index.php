<?php session_start(); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�û������֤</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<style type="text/css">
<!--
.STYLE1 {color: #FFFFFF}
body {
	margin-top: 0px;
	margin-bottom: 0px;
	background-color: #656465;
}
-->
</style>
</head>
<script language="javascript">
 function chkinput(form){
   if(form.username.value==""){
   
      alert("���������Ա����!");
      form.username.focus();
      return(false); 
   }
    if(form.userpwd.value==""){
   
      alert("���������Ա����!");
      form.userpwd.focus();
      return(false); 
   }
   return(true);
 
 }
</script>
<body>
<table width="200" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table align="center" width="505" height="421" border="0" cellpadding="0" cellspacing="0" background="images/bg1.jpg">
  <tr>
    <td width="205" height="190">&nbsp;</td>
    <td width="172">&nbsp;</td>
    <td width="128">&nbsp;</td>
  </tr>
    <form name="form1" method="post" action="index.php" onSubmit="return chkinput(this)">
  <tr>
    <td height="28">&nbsp;</td>
    <td>&nbsp;<input type="text" name="username" size="22" class="inputcss"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="28">&nbsp;</td>
    <td>&nbsp;<input type="password" name="userpwd" size="22" class="inputcss"></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td height="59">&nbsp;</td>
    <td><input name="Submit" type="image" id="submit" src="images/bg2.gif">
       <input type="image" name="imageField2" src="images/bg3.gif" onClick="form.reset();return false;"></td>
    <td>&nbsp;</td>
  </tr>	</form>
  <tr>
    <td height="116">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
if($_POST[username]!="")
 {
   
    $username=$_POST[username];
	$userpwd=$_POST[userpwd]; 
	 class chk
	 {
	    private $name;
		private $pwd;
		public function __construct($x,$y)
		 {
		   $this->name=$x;
		   $this->pwd=$y;
		 }
	    public function chkuser()
		 {
		    include_once("conn/conn.php"); 
		    $rs=new com("adodb.recordset");          //������¼������
		    $rs->open("select * from tb_user where username='".$this->name."' and userpwd='".$this->pwd."'",$conn,3,1); 
            if($rs->eof || $rs->bof)
			 {
			    echo "<script>alert('�Բ���������û�������!');history.back();</script>";
	            exit;
			 }
			else
			 { 
               session_register("username");      //����һ������
               $username=$name;       
    /*       
	          
			   session_register("producelist");   //�绰����洢��
			   $producelist="";                   //Ĭ��ֵΪ��
			   session_register("quatity");       
			    $quatity="";
               session_register("producelists");  
			   $producelists="";
			   session_register("quatitys");
			    $quatitys="";
                
               session_register("producelistes");  //���ö���洢��
			   $producelistes="";
			   session_register("quatityes");
			   $quatityes="";
       */       
            $data=substr(date("Y-n-j"),5,50);
            $rss=new com('adodb.recordset');          //������¼������
		    $rss->open("select * from tb_colleague where colleague_birthday='".$data."'",$conn,3,1); 

            $res=new com('adodb.recordset');          //������¼������
            $res->open("select * from tb_customer where customer_birthday='".$data."'",$conn,3,1); 

            if($rss->eof and $res->eof){
echo "<script>alert('��¼�ɹ�!');window.location.href='indexs.php';</script>";            
// echo "<meta http-equiv=\"Refresh\" content=\"3;url=indexs.php\">��¼�ɹ�,3����ת��ǰҳ,���Ե�......";
			}else{

echo "������";
            $data=substr(date("Y-n-j"),5,50);
            $rss=new com('adodb.recordset');          //������¼������
		    $rss->open("select * from tb_colleague where colleague_birthday='".$data."'",$conn,3,1); 
            while(!$rss->eof){
               $fields=$rss->fields(colleague_name);
               $birthday=$fields->value;
               echo $birthday.".";
             $rss->movenext;
			}
            $res=new com('adodb.recordset');          //������¼������
            $res->open("select * from tb_customer where customer_birthday='".$data."'",$conn,3,1); 
            while(!$res->eof){
               $fields=$res->fields(customer_name);
               $birthday=$fields->value;
               echo $birthday.".";
             $res->movenext;
			}

echo "������";
echo "<meta http-equiv=\"Refresh\" content=\"10;url=indexs.php\">10����ת����ҳ,���Ե�......";
}
            }
	     }
	 }
	$chk1=new chk($username,$userpwd);
	$chk1->chkuser();  
	 
 }

?>
</body>
</html>

