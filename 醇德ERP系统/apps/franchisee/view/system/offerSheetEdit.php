<div id="main">
<div class="container-fluid">
<div class="page-header">
	<div class="pull-left">
		<h1><?=empty($id)?'添加报价':'修改报价'?></h1>
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
			<a href="javascript:void(0);">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="javascript:void(0);">系统管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="javascript:void(0);"><?=empty($id)?'添加报价':'修改报价'?></a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="javascript:void(0);"><i class="icon-remove"></i></a>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i> <?=empty($id)?'添加报价':'修改报价'?>
				</h3>
			</div>
			<div class="box-content nopadding">
				<form action="<?=$this->url("system/offerSheetEdit")?>" method="POST" class='form-horizontal form-bordered form-validate' id="bb">
				    <div class="control-group">
						<label for="serialnumber" class="control-label">名称</label>
						<div class="controls">
							<input type="text" name="data[name]" value="<?=empty($re)?'':$re['name']?>" class="input-xlarge" />
						</div>
					</div>
					<div class="control-group">
						<label for="userid" class="control-label">单价</label>
						<div class="controls">
							<input type="text" name="data[price]" value="<?=empty($re)?'':$re['price']?>" class="input-xlarge" />
						</div>
					</div>
					<div class="control-group">
						<label for="userid" class="control-label">状态</label>
						<div class="controls">
						    <select name="data[status]" class="input-xlarge">
                                <option value="1" <?=!empty($re)&&$re['status']==1?'selected':''?> >有效</option>
                                <option value="0" <?=!empty($re)&&$re['status']==0?'selected':''?> >无效</option>
                            </select>
                        </div>
					</div>
                    <input type="hidden" name="id" value="<?=empty($re)?'0':$re['id']?>" />
					<div class="form-actions">
						<input type="submit" id="edit" class="btn btn-primary" value="提交"  style="width: 60px;" />
                        <input type="button" id="frist" class="btn btn-primary" value="返回" style="width: 60px;" />
					</div>
				</form>
			</div>	
		</div>
	</div>
</div>
</div>
</div>
<script>
    $('#frist').click(function(){
        window.history.go(-1);
    });
</script>	