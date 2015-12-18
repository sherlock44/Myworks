	<div id="main">
			<div class="container-fluid"><div class="page-header">
	<div class="pull-left">
		<h1>平台设置</h1>
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
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="javascript:;">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">系统管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">添加管理员账号</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div>

<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css"/>
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>

<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>
                    添加管理员账号
				</h3>
			</div>
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate' action='<?=$this->url("system/add")?>'  id="login" name="login" method='post'>
					<div class="control-group">
						<label class="control-label">账号名称</label>
						<div class="controls">
							<input type="text" name="uname" id="uname" value="" class="input-xlarge" data-rule-required="true" data-rule-minlength="2">
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label">所属权限组</label>
						<div class="controls">
							<select name="groupid">
                                <?
                                    foreach($r as $k=>$v){?>
                                        <option value="<?=$v['groupid']?>"><?=$v['title']?></option>
                                    <?}
                                ?>
                            </select>
						</div>
					</div>
					<div class="control-group">
						<label  class="control-label">密码</label>
						<div class="controls">
							<input type="password" name="password" id="url" value="" placeholder="请填写6-20位长度的密码" class="input-xlarge" data-rule-required="false" data-rule-email="false" data-rule-minlength="2">
                        </div>
					</div>
					<div class="control-group">
						<label  class="control-label">确认密码</label>
						<div class="controls">
							<input type="password" name="pwd" id="pwd" value="" placeholder="请再次确认密码" class="input-xlarge" data-rule-required="false" data-rule-email="false" data-rule-minlength="2">
						</div>
					</div>
                    <div class="control-group">
						<label  class="control-label">状态</label>
						<div class="controls">
							<select name="status" id="status">
                                <option value="0">冻结</option>
                                <option value="1">正常</option>
                            </select>
						</div>
					</div>
					<input type='hidden'  name="created" value='<?=time()?>'>
					<div class="form-actions">
						<input type="submit" class="btn btn-primary" value="确认添加" />
                        <input type="reset" class="btn btn-primary" value="重置" style="width: 60px;margin: 0px 20px;" />
                        <input type="button" id="first" class="btn btn-primary" value="返回" style="width: 60px;" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<script>
    $(document).ready(function(){
        $('#first').click(function(){
            window.location.href="/index.php/sysadmin/system/admin";
        })
    })
</script>