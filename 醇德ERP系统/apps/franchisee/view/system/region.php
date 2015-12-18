	<div id="main">
			<div class="container-fluid"><div class="page-header">
	<div class="pull-left">
		<h1>省市区管理</h1>
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
			<a href="">系统管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">省市区管理</a>
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
function edit_programa(node,span){
	$(span).poshytip({
		className: 'tip-darkgray',
		content:'<div class="actions"><a class="btn btn-mini content-refresh" title="添加子类别" onclick="pub_alert_html(\'<?=$this->url('system/regionAdd')?>?id='+node.data.key+'\');"><i class="icon-plus"></i></a><a class="btn btn-mini content-remove" onclick="pub_alert_html(\'<?=$this->url('system/regionEdit')?>?id='+node.data.key+'\');" title="修改"><i class="icon-edit"></i></a><a class="btn btn-mini content-slideUp" title="删除" onclick="pub_alert_confirm(this,\'\',\'<?=$this->url('system/regionDel')?>?id='+node.data.key+'\');"><i class="icon-remove"></i></a></div>',
		offsetX: 5,
		offsetY: -32,
		alignTo: 'target',
		alignX: 'right'
	});
}

$(function(){

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
				url:'/index.php/sysadmin/system/region',
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
		edit_programa(node, span);
		}

	$("#menutree").dynatree(opt);

});
</script>
 

<div class="row-fluid"> 
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-list-alt"></i>
                    省市区管理
				</h3>
			</div>

			<div class="box-content nopadding">
				<div class="span4">
					<div class="filetree" id="menutree">
						<ul class="dynatree-container">
							<li id="root" class="expanded">ROOT<ul><?=get_menu_tree($result,null,'region_id')?></ul>
				        </ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div></div>