<?php  include_once("conn/conn.php");		//�������ݿ�
if($_POST[colleague_tel]==""){				//�жϵ绰�����Ƿ�Ϊ��
	echo "<script>alert('����д���͵��ֻ�����!');history.back();</script>";
}else{
	$carrier="����ʡ���տƼ����޹�˾";    //��ȡ����
	$userid=trim($_POST[regtel]);         //��ȡ�����ֻ�����
	$password=trim($_POST[regpwd]);       //��ȡ����
	$content=trim($_POST[mess]);          //��ȡ��������
	$data=date("Y-m-d H:i:s");            //��ȡʱ��	
	$ip=getenv('REMOTE_ADDR');            //��ȡIP��ַ
while(list($name,$value)=each($_POST[colleague_tel])){      //��ȡҪ���͵ĵ绰����
	if(is_numeric($value)==true){        //�жϵ绰��ʽ�Ƿ���ȷ
    	$mobilenumber=$value;            //����ȡ�ĵ绰���븽������
     	$msgtype="Text";                 //ָ������Ϊ�ı���ʽ
     	/*�����ݿ�����ӷ��Ͷ��ŵļ�¼*/
     	$sql="insert into tb_short(short_ip,short_tel,short_tels,short_content,short_date,short_title)values('$ip','$userid','$mobilenumber','$content','$data','$carrier')";
     	$rs=new com("adodb.recordset");
     	$rs->open($sql,$conn,3,3);		//ִ��������
		/*------------------------*/
    	include('nusoap/lib/nusoap.php');    //��ȡPHP���ļ�,ʵ�ֶ��ŵķ���
		/*���������������ʽ��ӵ�sendXml������*/
     	$s=new soapclient('http://smsinter.sina.com.cn/ws/smswebservice0101.wsdl','WSDL');
     	$s->call('sendXml',array('parameters' =>array('carrier' => $carrier,'userid'=> $userid,'password' => $password,'mobilenumber' => $mobilenumber,'content' => $content,'msgtype' => $msgtype))); 
		/*-------------------------------------*/
     	echo "<script>alert('���ŷ��ͳɹ�!');window.location.href='indexs.php?lmbs=���Ӷ���';</script>";
  	}}}
?>
