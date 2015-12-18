



<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/dynatree/ui.dynatree.css">
<script src="/public/assets/sysadmin/js/jquery.cookie.js"></script>
<script src="/public/assets/sysadmin/js/plugins/dynatree/jquery.dynatree.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/js/plugins/poshytip/tip-darkgray/tip-darkgray.css">
<script src="/public/assets/sysadmin/js/plugins/poshytip/jquery.poshytip.min.js"></script>
<div id="pub_edit_bootbox" class="modal fade">
	<form class="modal-dialog  box-primary " style="margin-top:50px;" id="modalform" action="/index.php/iManage/system/role_lock" method="post">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">授权至权限组</h4>
			</div>
			<div class="modal-body">
				<div class="filetree" id="menutree">
					<ul class="dynatree-container">
						<li id="root" class="expanded">ROOT<ul><?=get_menu_tree($menu,$haveauth)?></ul>
					</ul>
				</div>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="action" value="true">
				<input type="hidden" name="id" value="<?=$id?>">
				<input type="hidden" name="menuids" id="menuids">
				<button class="btn btn-success" type="button" onclick="formtj()" ><i class="fa fa-check"></i> 提交</button>
			
			</div>
		</div>
	</form>
</div>
<script src="/public/assets/sysadmin/js/plugins/validation/jquery.validate.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/validation/additional-methods.min.js"></script>
<script src="/public/assets/sysadmin/js/eakroko.js"></script> 
<script type="text/javascript">

	opt = {};
	opt.debugLevel = 0;
	opt.checkbox = true;
	opt.selectMode = 3;
	opt.onSelect = function(select, node) {
		var s = node.tree.getSelectedNodes();
		var auth = [];
		$(s).each( function(i,v){
			auth[i] = v.data.key;
		});
		$("#menuids").val(auth);
	}
	opt.dnd = {
		onDragStart: function(node) {
			return true;
		},
		onDragEnter: function(node, sourceNode) {
			if(node.parent !== sourceNode.parent)
				return false;
			return ["before", "after"];
		}
	};
	$("#menutree").dynatree(opt);
	$('#modalform').ajaxForm({
		success:function(r){
			if(r.state == 1){
				pub_alert_success(r.info);
			}else{
				pub_alert_error(r.info);
			}
		}, 
		dataType: 'json'
	});
	var s = $("#menutree").dynatree("getSelectedNodes");
	var auth = [];
	$(s).each( function(i,v){
		auth[i] = v.data.key;
	});
	$("#menuids").val(auth);
	function formtj(){
		
		var data = $("#modalform").serialize();
		$.ajax({
			type: 'POST',
			data: data,
			url: "/index.php/iManage/system/role_lock",
			dataType: 'json',
			success: function(r) {
				if (r.state == 1) {
					pub_alert_success(r.info);
					if (r.data == 'back') {
						setTimeout('history.go(-1)', 600);
					} else if (r.data == 'url') {
						window.location.href = r.url;
					} else if (r.data == "delnum") {
						$("." + r.className).val('');
						$("." + r.btClassName).html(r.btstr);
					} else {
						location.reload();
					}
				} else {
					pub_alert_error(r.info);
					if (r.data = "delnum") {
						$("." + r.btClassName).html(r.btstr);
					}
				}
			}
		});
	
	}
</script>
