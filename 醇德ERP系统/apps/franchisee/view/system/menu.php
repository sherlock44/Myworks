					<div id="main">
			<div class="container-fluid"><div class="page-header">
	<div class="pull-left">
		<h1>后台菜单</h1>
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
			<a href="javascript:;">总台</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="/epmaster/admin/index?cnav=2&cleft=21&cmenuid=22">管理员管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">后台菜单</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/dynatree/ui.dynatree.css">
<script src="/public/assets/sysadmin/js/jquery.cookie.js"></script>
<script src="/public/assets/sysadmin/js/plugins/dynatree/jquery.dynatree.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/js/plugins/poshytip/tip-darkgray/tip-darkgray.css">
<script src="/public/assets/sysadmin/js/plugins/poshytip/jquery.poshytip.min.js"></script>
<script type="text/javascript">
function edit_menu(node,span){

	$(span).poshytip({
		className: 'tip-darkgray',
		content:'<div class="actions"><a class="btn btn-mini content-refresh" href="#addmenu" data-toggle="modal" title="添加子菜单" onclick="m_add_action(\''+node.data.key+'\');"><i class="icon-plus"></i></a><a class="btn btn-mini content-remove" href="#addmenu" data-toggle="modal" onclick="m_edit_action(\''+node.data.key+'\');" title="修改"><i class="icon-edit"></i></a><a class="btn btn-mini content-slideUp" href="#removemenu" data-toggle="modal" title="删除" onclick="m_remove_action(\''+node.data.key+'\');"><i class="icon-remove"></i></a></div>',
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
	bootbox.confirm("确定要删除吗？", "取消", "确定", function (a) {
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

	// dynatree
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
<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-reorder"></i>
				</h3>
			</div>
			<div class="box-content nopadding">
				<div class="span4">
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
		</div>
	</div>
</div>
<div id="addmenu" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">添加子菜单</h3>
        <div class="modal-body">
			<form id="addmenu_form" class="form-horizontal" method="POST" action="<?=$this->url('system/addmenu')?>">
				<div class="control-group">
					<label class="control-label">菜单名称</label>
					<div class="controls">
						<input type="text" class="input-xlarge" id="title" name="title">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">模块</label>
					<div class="controls">
						<input type="text" class="input-xlarge" id="module" name="module">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">方法</label>
					<div class="controls">
						<input type="text" class="input-xlarge" id="method" name="method">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">参数</label>
					<div class="controls">
						<input type="text" class="input-xlarge" id="parameter" name="parameter">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">是否显示</label>
					<div class="controls">
						<select data-rule-required="true" id="isshow" name="isshow">
							<option value="1">显示</option>
							<option value="0">不显示</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">状态</label>
					<div class="controls">
						<select data-rule-required="true" id="state" name="state">
							<option value="1">启用</option>
							<option value="0">禁用</option>
						</select>
					</div>
				</div>
				<div class="form-actions">
					<input type="hidden" name="action" id="action">
					<input type="hidden" name="menuid" id="menuid">
					<input type="submit" value="确定" class="btn btn-primary">
					<button class="btn" type="button" data-dismiss="modal">取消</button>
				</div>
			</form>
		</div>
    </div>
</div>
</div></div></div>