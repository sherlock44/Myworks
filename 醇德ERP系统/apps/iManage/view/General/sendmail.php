<section class="content-header">
	<h1>
		写邮件
		<small>写站内信给<? echo $type==1?"内部员工":"加盟商"?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">通用管理</a></li>
		<li class="active">邮件推送</li>
	</ol>
</section>
<section class="content">
	<form class="box box-default form-validate" id="myform">
		<div class="box-header">
			<h3 class="box-title">请选择要发送邮件的加盟商</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-xs-8">
					<?php if($type==1){?>
					<div class="form-group">
						<label>员工角色</label>
						<hr />
						<?php foreach ($grup as $key => $val){ ?>
						<label style=" padding:5px 10px;">
							<input class="ygjs" type="checkbox" value="<?=$val['groupid']?>" >
							&nbsp;&nbsp;<?=$val['title']?>
						</label>
						<?php } ?>
					</div>
					<div class="form-group">
						<label>员工列表</label>
						<hr />
						<?php foreach ($re as $key => $val){ ?>
						<label style=" padding:5px 10px;">
							<input class="ygxz " data-id="<?=$val['groupid']?>" type="checkbox" value="<?=$val['id']?>" name="nbyg[]">
							&nbsp;&nbsp;<?=$val['name']?>
						</label>
						<?php } ?>
					</div>
					<?php } else {?>

					<div class="form-group">
						<label>客户类型</label>
						<hr />
						<?php foreach ($kharr as $key => $val){ ?>
						<label style=" padding:5px 10px;">
							<input class=" khxz" type="checkbox" value="<?=$val['id']?>" >
							&nbsp;&nbsp;<?=$val['title']?>
						</label>
						<?php } ?>
					</div>
					<div class="form-group">
						<label>所在城市</label>
						<hr />
						<?php foreach ($ctarr as $key => $val){ ?>
						<label style=" padding:5px 10px;">
							<input class=" ctxz" type="checkbox" value="<?=$val['id']?>" >
							&nbsp;&nbsp;<?=$val['name']?>
						</label>
						<?php } ?>
					</div>
					<div class="form-group">
						<label>用户列表</label>
						<hr />
						<?php foreach ($rs as $key => $val){ ?>
						<label style=" padding:5px 10px;">
							<input class="jmsxz" type="checkbox" data-tid="<?=$val['supplytypeid']?>" data-id="<?=$val['cityid']?>" value="<?=$val['id']?>" name="jms[]">
							&nbsp;&nbsp;<?=$val['truename']?>
						</label>
						<?php } ?>
					</div>
					<?php } ?>
					<div class="form-group">
						<label for="title">主题</label>
						<input type="text" name="data[title]" id="title"  class="form-control" data-rule-required="true" data-rule-mobile="false" data-rule-minlength="1">
					</div>
					<div class="form-group">
						<label for="remark">邮件内容</label>
						<textarea cols="700" data-rule-required="true" id="remark" rows="18" name="remark" class="form-control"></textarea>
					</div>
				</div>
			</div>
		</div>
		<!-- /.box-body -->
		<div class="box-footer">
			<input type="submit" class="btn btn-primary" value="提交" >
			<input type="button" class="btn btn-default" value="返回列表" onclick='returnList()'>
		</div>
	</form>
</section>

<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script>
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/kindeditor-min.js"></script>
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/lang/zh_CN.js"></script>
<script charset="utf-8" src="/public/assets/script/kindeditor-4.1.10/php/upload_json.php"></script>
<script>
	var editor;
	KindEditor.ready(function(K) {
		editor = K.create('textarea[name="remark"]', {
			allowFileManager : true,
			afterBlur: function(){this.sync();}
		});
	});
//返回列表
function returnList(){
	window.location.href="<?=$this->url('General/maillist')?>";
}

    //根据用户类型变化样式
    $(".ustp").click(function(){
    	var tp = $(this).val();
    	if(tp==1){
    		$("#yg").hide();
    		$("#jms").hide();
    	}else if(tp==2){
    		$("#jms").hide();
    		$("#yg").show();
    	}else{
    		$("#yg").hide();
    		$("#jms").show();
    	}
    });
    //员工全选
    $("#checkall").click(function(){
    	$(".ygxz").prop("checked", true);
    })
	//员工全不选
	$("#checknone").click(function(){
		$(".ygxz").prop("checked", false);
	})
	 //加盟商全选
	 $("#checkall1").click(function(){
	 	$(".jmsxz").prop("checked", true);
	 })
	//加盟商全不选
	$("#checknone1").click(function(){
		$(".jmsxz").prop("checked", false);
	})

	//内部员工选择
	$('.ygjs').click(function(){
		var jsid = $(this).val();
		$('.ygxz[data-id='+jsid+']').prop("checked", $(this).prop('checked'));
	});
	//加盟商选择
	$('.ctxz').click(function(){
		var jsid = $(this).val();
		$('.jmsxz[data-id='+jsid+']').prop("checked", $(this).prop('checked'));
	});
	//客户类型选择
	$('.khxz').click(function(){
		var jsid = $(this).val();
		$('.jmsxz[data-tid='+jsid+']').prop("checked", $(this).prop('checked'));
	});
</script>
