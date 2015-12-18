<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/jquery-ui/smoothness/jquery-ui.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/jquery-ui/smoothness/jquery.ui.theme.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/style.css">
<script src="/public/assets/sysadmin/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/jquery-ui/jquery-ui.custom.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/form/jquery.form.min.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/dynatree/ui.dynatree.css">
<script src="/public/assets/sysadmin/js/jquery.cookie.js"></script>
<script src="/public/assets/sysadmin/js/plugins/dynatree/jquery.dynatree.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/js/plugins/poshytip/tip-darkgray/tip-darkgray.css">
<script src="/public/assets/sysadmin/js/plugins/poshytip/jquery.poshytip.min.js"></script>
<section class="content-header">
	<h1>
		商品类型
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">商品管理</a></li>
		<li class="active">商品分类</li>
	</ol>
</section>
<section class="content">
	<div class="box box-primary">
		<div class="box-body">
			<div class="filetree" id="menutree">
				<ul class="dynatree-container">
					<li id="root" class="expanded">全部分类<ul><?=get_menu_tree($result,null,'id')?></ul>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<script type="text/javascript">
		function edit_programa(node,span){
			$(span).poshytip({
				className: 'tip-darkgray',
				content:'<div class="actions"><a class="btn btn-mini content-refresh" title="添加子类别" onclick="pub_alert_html(\'<?=$this->url('goods/categoryadd')?>?id='+node.data.key+'\');"><i class="icon-plus"></i></a><a class="btn btn-mini content-remove" onclick="pub_alert_html(\'<?=$this->url('goods/categoryedit')?>?id='+node.data.key+'\');" title="修改"><i class="fa fa-sign-out"></i></a><a class="btn btn-mini content-slideUp" title="删除" onclick="pub_alert_confirm(this,\'\',\'<?=$this->url('goods/categorydelete')?>?id='+node.data.key+'\');"><i class="fa fa-close"></i></a></div>',
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
			url:'category/category',
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
<script >
	function sycntoshop()
	{
		$.ajax({
			data:"1=1",
			type:"post",
			url:"<?=$this->url('goods/possync')?>",
			dataType:"json",
			success:function(r){
				if(r.state == 1){
					pub_alert_success(r.info);
				}else{
					pub_alert_error(r.info);
				}
			}
		});
	}
</script>
<script >
	function sycntodshop()
	{
		$.ajax({
			data:"1=1",
			type:"post",
			url:"<?=$this->url('goods/posdync')?>",
			dataType:"json",
			success:function(r){
				if(r.state == 1){
					pub_alert_success(r.info);
				}else{
					pub_alert_error(r.info);
				}
			}
		});
	}
</script>