<div id="pub_edit_bootbox" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">授权至权限组</h3>
        <div class="modal-body">
			<form id="pub_form" class="form-horizontal" method="POST" action="<?=$this->url('system/role_lock')?>">
				<div class="filetree" id="menutree">
					<ul class="dynatree-container">
						<li id="root" class="expanded">ROOT<ul><?=get_menu_tree($menu,$haveauth)?></ul>
			        </ul>
				</div>
				<div class="form-actions">
					<input type="hidden" name="action" value="true">
					<input type="hidden" name="id" value="<?=$id?>">
					<input type="hidden" name="menuids" id="menuids">
					<input type="submit" value="确定" class="btn btn-primary">
					<button class="btn" type="button" data-dismiss="modal">取消</button>
				</div>
			</form>
		</div>
    </div>
	<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/dynatree/ui.dynatree.css">
<script src="/public/assets/sysadmin/js/jquery.cookie.js"></script>
<script src="/public/assets/sysadmin/js/plugins/dynatree/jquery.dynatree.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/js/plugins/poshytip/tip-darkgray/tip-darkgray.css">
<script src="/public/assets/sysadmin/js/plugins/poshytip/jquery.poshytip.min.js"></script>



<script type="text/javascript">
// dynatree
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

	$('#pub_form').ajaxForm({
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
</script>
</div>
