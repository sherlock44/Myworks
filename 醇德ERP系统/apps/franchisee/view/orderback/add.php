	<div id="main">
			<div class="container-fluid"><div class="page-header">
	<div class="pull-left">
		<h1>采购管理</h1>
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
			<a href="<?=$this->url('index/main')?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">采购管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href=""><?=!empty($re)?"修改退货单":"添加退货单"?></a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
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
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("orderback/insert")?>'  id="login" name="login" method='post'>
					
					<div class="control-group">
						<label for="mobile" class="control-label">名称</label>
						<div class="controls">
                            <input type="text" name="data[title]" id="title" value="<?=!empty($re) ? $re["title"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
                        
                        </div>
						
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">选择关联订单</label>
						<div class="controls">
                            <input type="text" name="data[oldordernum]" id="ordernum" value="<?=!empty($re) ? $re["ordernum"] : ''?>" class="input-xlarge" data-rule-required="true" data-rule-minlength="1">
							(<span style="color:red;">加盟商订货的订货单</span>)
                        </div>
						
					</div>
					
				<div class="control-group">
						<label for="number" class="control-label">说明</label>
						<div class="controls">
							<textarea  rows="3" name="data[remark]" class="span8"><?=!empty($re) ? $re['remark']: ''?></textarea>
						</div>
				</div>
				<div class="control-group" style="display:none;">
						<label for="number" class="control-label">状态</label>
						<div class="controls">
							<select name="data[status]">
								<option value="0">草稿</option>
								<option value="1">正常</option>
								
							</select>
						</div>
				</div>
				
					
					
											
					
					<input type='hidden'  name="id" value='<?=!empty($re) ? $re['id']: ''?>'>
						<div class="form-actions">
						<input type="submit" class="btn btn-primary" value="提交" >					
						<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>					
						
						</div>
				</form>
			</div>
		</div>
	</div>
</div>


</div>
</div>
</div>
<script>
//返回列表
	function returnList(){
		window.location.href='<?=$this->url("orderback/lists")?>';
	}

</script>
