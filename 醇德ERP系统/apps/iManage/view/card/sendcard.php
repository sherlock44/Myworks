	<div id="main">
	<div class="container-fluid" style="padding:0;">
<div class="breadcrumbs" >
	<div class="pull-left">
		<h1>分发会员卡</h1>
	</div>
	<div class="pull-right">
		<ul class="stats">
			<li class='lightred'>
				<i class="icon-calendar"></i>
				<div class="details">
					<span class="big"></span>
					<span></span>
				</div>
			</li>
		</ul>
	</div>
</div>
<script type="text/javascript">
function currentTime(){
	var $el = $(".stats .icon-calendar").parent(),
	currentDate = new Date(),
	monthNames = [1,2,3,4,5,6,7,8,9,10,11,12],
	dayNames = ["周日","周一","周二","周三","周四","周五","周六"];

	$el.find(".details span").html(currentDate.getFullYear() + " - " + monthNames[currentDate.getMonth()] + " - " + currentDate.getDate());
	$el.find(".details .big").last().html(currentDate.getHours()+":"+ ("0" + currentDate.getMinutes()).slice(-2) + ", " + dayNames[currentDate.getDay()]);
	setTimeout(function(){
		currentTime();
	}, 10000);
}
currentTime();
</script>

<script type="text/javascript" src="/public/assets/KindEditor/kindeditor-min.js" charset="utf-8"></script>
<script>
var editor;
KindEditor.ready(function(K) {
	editor = K.create('textarea[name="content"]',{
		allowFileManager : true
	});
});
</script>
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="<?=$this->url('user/cmslist')?>">会员卡管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">分发会员卡</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="fa fa-close"></i></a>
	</div>
</div>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script><div class="row-fluid">


<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/chosen/chosen.css">
<script src="/public/assets/sysadmin/js/plugins/chosen/chosen.jquery.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datetimepicker/datetimepicker.css">
<script src="/public/assets/sysadmin/js/plugins/datetimepicker/datetimepicker.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datetimepicker/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="/public/assets/sysadmin/js/plugins/kindeditor/kindeditor-min.js"></script>
<link rel="stylesheet" href="/public/js/plugins/kindeditor/themes/default/default.css" />
<script src="/public/assets/sysadmin/js/plugins/fileupload/bootstrap-fileupload.min.js"></script>
<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>
				</h3>
			</div>
			<div class="box-content nopadding">
				<form action="<?=$this->url("card/cardtosupply")?>" method="POST" class='form-horizontal form-bordered form-validate' id="bb">
					
					
					<div class="control-group">
						<label  class="control-label">会员卡</label>
						<div class="controls">
						<select name="cardtype" id="cardtype" onchange="selcardlevel(this.value)">
						<?foreach($cardtype as $k=>$val){?>
							<option value="<?=$k?>"><?=$val?></option>
						<?}?>
						</select>
						
						</div>
					</div>
					<div class="control-group">
						<label  class="control-label">剩余未分配空卡</label>
						<div class="controls">
							<span id="cardnum">0</span>
							<span id="cardnumhtml" style="color:red;"></span>
						</div>
					</div>
					<div class="control-group">
						<label for="title" class="control-label">加盟商选择</label>
						<div class="controls">							
							
						<select name="data[token]" id="token" onchange="selsupply(this.value)">
						<?foreach($franchisee as $val){?>
							<option value="<?=$val['token']?>"><?=$val['suppname']?></option>
						<?}?>
						</select>
						</div>
					</div>
					
					<div class="control-group">
						<label  class="control-label">该加盟商未开通空卡</label>
						<div class="controls">
							<span id="supplaycardnum">0</span>
							
						
						</div>
					</div>
					<div class="control-group">
						<label  class="control-label">分配数量</label>
						<div class="controls">
							<input  type="text" name="num" id="num" value="" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
							
						
						</div>
					</div>
					<div class="form-actions">

						
						 <input type="hidden" name="id" value="<?=!empty($re) ? $re["id"] : ''?>">
						 <input type="submit" class="btn btn-primary" value="提交">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						
					</div>

					
				</form>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<script>

//剩余空卡数量

selcardlevel($("#cardtype").val());
function selcardlevel(val){
	selsupply($("#token").val());
	$.ajax({
		data:'cardtype='+val,
		type:"post",
		url:"<?=$this->url('card/nosupplycard')?>",
		dataType:"json",
		success:function(data){
			
			$('#cardnum').html(data.num);
			if(data.state==0){
				$('#cardnumhtml').html("该类型的空卡数量不足");
			}else{
			$('#cardnumhtml').html("");
			}
		}
	
	});

}
//查看该加盟商的空卡数

function selsupply(val){
	var cardtype	=	$("#cardtype").val();
	$.ajax({
		data:'token='+val+"&cardtype="+cardtype,
		type:"post",
		url:"<?=$this->url('card/supplycardnum')?>",
		dataType:"json",
		success:function(data){
			
			$('#supplaycardnum').html(data.num);
			
		}
	
	});

}		 
</script>	