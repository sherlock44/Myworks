
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/jquery-ui/smoothness/jquery-ui.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/jquery-ui/smoothness/jquery.ui.theme.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/style.css">
<script src="/public/assets/sysadmin/js/jquery.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/jquery-ui/jquery-ui.custom.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/form/jquery.form.min.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/dynatree/ui.dynatree.css">
<script src="/public/assets/sysadmin/js/jquery.cookie.js"></script>
<script src="/public/assets/sysadmin/js/plugins/dynatree/jquery.dynatree.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/js/plugins/poshytip/tip-darkgray/tip-darkgray.css">
<script src="/public/assets/sysadmin/js/plugins/poshytip/jquery.poshytip.min.js"></script>
<section class="content-header">
	<h1>
		后台菜单
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">后台菜单</a></li>
		<li class="active">后台菜单</li>
	</ol>
</section>
<script type="text/javascript">
	function edit_menu(node,span){
		$(span).poshytip({
			className: 'tip-darkgray',
			content:'<div class="actions"><a class="btn btn-xs content-refresh" href="#addmenu" data-toggle="modal" title="添加子菜单" onclick="m_add_action(\''+node.data.key+'\');"><i class="icon-plus"></i></a><a class="btn btn-mini content-remove" href="#addmenu" data-toggle="modal" onclick="m_edit_action(\''+node.data.key+'\');" title="修改"><i class="fa fa-sign-out"></i></a><a class="btn btn-mini content-slideUp" href="#removemenu" data-toggle="modal" title="删除" onclick="m_remove_action(\''+node.data.key+'\');"><i class="fa fa-close"></i></a></div>',
			offsetX: 5,
			offsetY: -32,
			alignTo: 'target',
			alignX: 'right'
		});
	}
	function m_add_action(menuid){
		$("#action").val('add');
		$("#menuid").val(menuid);
		$("#title").val('');
		$("#newtitle").val('');
		$("#module").val('');
		$("#method").val('');
		$("#parameter").val('');
		$("#isshow").val(1);
		$("#state").val(1);
		$("#myModalLabel").html('添加子菜单');
		$("#addmenu_form").attr('action','<?=$this->url('system/addmenu')?>');
	}
	function m_edit_action(menuid){
		$.ajax({
			type:'POST',
			url:'<?=$this->url('system/editmenu')?>',
			data:{menuid:menuid,a:'get'},
			dataType:'json',
			success:function(r){
				if(r.state == 1){
					$("#title").val(r.data.title);
					$("#newtitle").val(r.data.newtitle);
					$("#module").val(r.data.module);
					$("#method").val(r.data.method);
					$("#parameter").val(r.data.parameter);
					$("#state").val(r.data.state);
					$("#isshow").val(r.data.isshow);
				}
			}
		});
		$("#action").val('edit');
		$("#menuid").val(menuid); 
		$("#myModalLabel").html('修改菜单');
		$("#addmenu_form").attr('action','<?=$this->url('system/editmenu')?>');
	}
	function m_remove_action(menuid){
		bootbox.confirm("确定要删除吗？", function (a) {
			if (a){
				$.ajax({
					type:'POST',
					url:'<?=$this->url('system/deletemenu')?>',
					data:{menuid:menuid},
					dataType:'json',
					success:function(r){
						if(r.state == 1){
							pub_alert_success();
							setTimeout('location.reload()',1000);
						}else{
							pub_alert_error(r.info);
						}
					}
				});
			}
		});
	}
	$(function(){
		$('#addmenu_form').ajaxForm({
			success:function(r){
				if(r.state == 1){
					location.reload();
				}else{
					pub_alert_error(r.info);
				}
			}, 
			dataType: 'json'
		});
		opt = {};
		opt.debugLevel = 0;
		opt.persist = true,
		opt.dnd = {
			preventVoidMoves: true,
			onDragStart: function(node) {
				return true;
			},
			onDragEnter: function(node, sourceNode) {
				if(node.parent !== sourceNode.parent)
					return false;
				return ["before", "after"];
			},
			onDrop: function(node, sourceNode, hitMode, ui, draggable) {
				sourceNode.move(node, hitMode);
				var nodes = sourceNode.getParent().getChildren();
				var data_order = [];
				$(nodes).each( function(i,v){
					data_order[i] = v.data.key;
				});
				$.ajax({
					type:'POST',
					url:'<?=$this->url('system/orderby')?>',
					data:{orderby:data_order},
					dataType:'json',
					success:function(r){
						if(r.state == 1){
							pub_alert_success('排序成功');
						}else{
							pub_alert_error(r.info);
							setTimeout('location.reload()',1000);
						}
					}
				});
			}
		};
		opt.onCreate = function(node, span){
			edit_menu(node, span);
		}
		$("#menutree").dynatree(opt);
	});
</script>
<section class="content">
	<div class="box box-primary">
		<div class="box-body">
			<div class="filetree" id="menutree">
				<ul class="dynatree-container">
					<li id="root" class="expanded">ROOT
						<ul>
							<?=get_menu_tree($result)?>
						</ul>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<div id="addmenu" class="modal fade">
		<form class="modal-dialog form-validate" style="margin-top:50px;" id="modalform" action="<?=$this->url('user/addmenu')?>" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">添加子菜单</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="title">菜单名称</label>
						<input type="text" class="form-control" id="title" name="title">
					</div>
					<div class="form-group">
						<label for="newtitle">副标题</label>
						<input type="text" class="form-control" id="newtitle" name="newtitle">
					</div>
					<div class="form-group">
						<label for="module">模块</label>
						<input type="text" class="form-control" id="module" name="module">
					</div>
					<div class="form-group">
						<label for="method">方法</label>
						<input type="text" class="form-control" id="method" name="method">
					</div>
					<div class="form-group">
						<label for="parameter">参数</label>
						<input type="text" class="form-control" id="parameter" name="parameter">
					</div>
					<div class="form-group" style="display:none;">
						<label for="isshow">是否显示</label>
						<select data-rule-required="true" class="form-control" id="isshow" name="isshow">
							<option value="1">显示</option>
							<option value="0">不显示</option>
						</select>
					</div>
					<div class="form-group" style="display:none;">
						<label for="state">状态</label>
						<select data-rule-required="true" class="form-control" id="state" name="state">
							<option value="1">启用</option>
							<option value="0">禁用</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="action" id="action">
					<input type="hidden" name="menuid" id="menuid">
					<button class="btn btn-success" type="submit"><i class="fa fa-check"></i> 提交</button>
				</div>
			</div>
		</form>
	</div>
