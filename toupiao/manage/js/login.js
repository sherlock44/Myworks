$(window).load(function(){
	$('#login').click(function(){
		if($('#name').val()==""){
			alert('用户名不能为空！');
			return;
		}
		if($('#password').val()==""){
			alert('密码不能为空！');
			return;
		}
		if($('#name').val()!="admin"||$('#password').val()!="admin"){
			alert('用户名或密码错误！');
			return;
		}
		sessionStorage.mark = "pass";
		location="manage.php?current=1";
	});
});