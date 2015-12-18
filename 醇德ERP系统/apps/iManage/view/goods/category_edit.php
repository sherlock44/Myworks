<?php 

	$title_h3 = $action == 'edit' ? '修改' : '添加';
	$form_action = $action == 'edit' ? 'categoryupdate' : 'categoryinsert';
?>

<link rel="stylesheet" href="/public/assets/sysadmin/css/bootstrap.min.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/bootstrap-responsive.min.css">

<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css"/>

<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/dynatree/ui.dynatree.css">
<script src="/public/assets/sysadmin/js/jquery.cookie.js"></script>
<script src="/public/assets/sysadmin/js/plugins/dynatree/jquery.dynatree.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/js/plugins/poshytip/tip-darkgray/tip-darkgray.css">
<script src="/public/assets/sysadmin/js/plugins/poshytip/jquery.poshytip.min.js"></script>

    <div  id="pub_edit_bootbox" class="modal-header modal fade" style="height:auto;">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"><?=$title_h3?>子类别</h3>
        <div class="modal-body">
			<form id="pub_form" class="form-horizontal" method="POST" action="<?=$this->url('goods/'.$form_action)?>">
				<div class="control-group">
					<label class="control-label">名称</label>
					<div class="controls">
						<input type="text" class="input-xlarge" value="<?=!empty($info['title']) ? $info['title'] : ''?>" name="data[title]" style="height:30px;">
					</div>
				</div>
				
				
				<div class="control-group">
					<label class="control-label">备注</label>
					<div class="controls">
						<textarea type="text" class="input-block-level"id="intro" name="data[remark]" rows="2"><?=!empty($info['remark']) ? $info['remark'] : ''?></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">排序</label>
					<div class="controls">
						<input type="text" class="input-xlarge"  data-rule-number="true" value="<?=!empty($info['sort']) ? $info['sort'] : '0'?>" name="data[sort]" style="height:30px;">
					</div>
				</div>
				
				<div class="form-actions">
					<input type="hidden" name="categoryuuid" value="<?=!empty($id) ? $id : ''?>">
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

