<?php 

	$title_h3 = $action == 'edit' ? '修改' : '添加';
	$form_action = $action == 'edit' ? 'regionUpdate' : 'regionInsert';
?>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/tagsinput/jquery.tagsinput.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/style.css">

<link rel="stylesheet" href="/public/assets/sysadmin/css/bootstrap-responsive.min.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css"/>

<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/chosen/chosen.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datetimepicker/datetimepicker.css">
<link rel="stylesheet" href="/public/js/plugins/kindeditor/themes/default/default.css" />
<div id="pub_edit_bootbox" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"><?=$title_h3?>子类别</h3>
        <div class="modal-body">
			<form id="pub_form" class="form-horizontal" method="POST" action="<?=$this->url('area/'.$form_action)?>">
				<div class="control-group">
					<label class="control-label" style="width: 80px;">名称：</label>
					<div class="controls" style="margin-left: 100px;">
						<input type="text" class="input-xlarge" value="<?=!empty($info['name']) ? $info['name'] : ''?>" name="region_name">
					</div>
				</div>
				<div class="form-actions">
					<input type="hidden" name="parent_id" value="<?=!empty($id) ? $id : ''?>">
					<input type="submit" value="确定" class="btn btn-primary">
					<button class="btn" type="button" data-dismiss="modal">取消</button>
				</div>
			</form>
		</div>
    </div>
<script type="text/javascript">
$('#pub_form').ajaxForm({
	success:function(r){
		if(r.state == 1){
			pub_alert_success(r.info);
			setTimeout('location.reload()',1000);
		}else{
			pub_alert_error(r.info);
		}
	}, 
	dataType: 'json'
});
</script>
</div>
