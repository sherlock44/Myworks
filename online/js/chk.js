// JavaScript Document
//index.php
//��¼��֤
function chk_log(){
	if(this.login.name.value == ""){
		alert("�������û���!");
		this.login.name.focus();
		return false;
	}
	if(this.login.password.value == ""){
		alert("����������!");
		this.login.password.focus();
		return false;
	}
}
//ע����֤
function reg_chk(){
	if(this.reg.name.value == ""){
		alert("������ע���ʺ�!");
		this.reg.name.focus();
		return false;
	}
	if(this.reg.password.value == ""){
		alert("����������!");
		this.reg.password.focus();
		return false;
	}
	if(this.reg.password.value.length < 3){
		alert("���볤������Ϊ3λ");
		this.reg.password.focus();
		return false;
	}
	if(this.reg.password.value != this.reg.t_password.value){
		alert("�����������벻һ��");
		this.reg.password.focus();
		return false;
	}
	if(this.reg.question.value == ""){
		alert("������������ʾ����!");
		this.reg.question.focus();
		return false;
	}
	if(this.reg.answer.value == ""){
		alert("�����������!");
		this.reg.answer.focus();
		return false;
	}
	if(this.reg.email.value != ""){
		var mailObj = this.reg.email;
		var email_ch= /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
		if(! email_ch.test(mailObj.value)){
			alert("��������ȷ�������ַ��");
			mailObj.focus();
			return false;	
		}
	}
}
//�޸���֤
function reg_chk(){
	if(this.reg.name.value == ""){
		alert("������ע���ʺ�!");
		this.reg.name.focus();
		return false;
	}
	if(this.reg.password.value == ""){
		alert("����������!");
		this.reg.password.focus();
		return false;
	}
	if(this.reg.password.value.length < 3){
		alert("���볤������Ϊ3λ");
		this.reg.password.focus();
		return false;
	}
	if(this.reg.password.value != this.reg.t_password.value){
		alert("�����������벻һ��");
		this.reg.password.focus();
		return false;
	}
	if(this.reg.email.value != ""){
		var mailObj = this.reg.email;
		var email_ch= /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
		if(!email_ch.test(mailObj.value)){
			alert("��������ȷ�������ַ��");
			mailObj.focus();
			return false;	
		}
	}
}
//�˳���¼
function l_chk(){
	if(confirm("ȷ��Ҫ�˳���¼��")){
		window.location="logout.php";
	} 
	else
     return false; 
}









