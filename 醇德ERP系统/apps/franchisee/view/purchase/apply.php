<!-- DataTables -->
<link rel="stylesheet" href="/public/adminlte/plugins/datatables/dataTables.bootstrap.css">
<section class="content-header">
<h1>
  挑选商品
  <small>在线挑选商品</small>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> 采购平台</a></li>
  <li><a href="#">采购管理</a></li>
  <li class="active">挑选商品</li>
</ol>
</section>
<section class="content">
    <div class="row">
        <div class="box">
        	<div class="box-header">
        		 <h3 class="box-title">商品列表</h3>
                    <div class="box-tools pull-right">
                 </div>
        	</div>
			<div class="box-body">
				<form action="<?=$this->url("purchase/apply")?>" method="GET" class="input-group input-group-sm" style="padding-bottom:10px;">
				    <select name='categoryuuid' class="form-control" style="width: 150px;">
					 <option value='' <?=isset($_GET['categoryuuid'])&&$_GET['categoryuuid']==''?"selected":""?> >全部分类</option>
					   <?=$trees?>
					</select>
					<select name='branduuid' class="form-control" style="width: 150px;margin-left: 10px;">
					 <option value='' <?=isset($_GET['branduuid'])&&$_GET['branduuid']==''?"selected":""?> >全部品牌</option>
					 <?foreach($brand as $val){?>
						<option value='<?=$val['uuid']?>' <?=isset($_GET['branduuid'])&&$_GET['branduuid']==$val['uuid']?"selected":""?> ><?=$val['title']?></option>
					 <?}?>
					</select>
					<input id="userphone" style="width: 180px; margin-left: 10px;" name="userphone" class="form-control" type="text" placeholder="商品名称/商品条码" value="<?=$userphone?>">
					<button style="margin-left: 10px;" class="btn btn-sm btn-primary" type="submit">搜索</button>
			   </form>
				<form class="table-responsive" action='<?=$this->url("purchase/addcart")?>' id="logins" name="logins" method='post'>
					<table scrollTop class="table table-hover table-nomargin table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
						<thead>
							<tr>
								<th>商品分类</th>
								<th>商品名称</th>
								<th>图片</th>
								<th>商品条码</th>
								<th>保质期(月)</th>
								<th>重量(g)</th>
								<th>采购价格(元)</th>
								<th>保质期至</th>
								<!--th width="5%">当前库存</th-->
								<th>装箱规格</th>
								<th width="130px">采购数量</th>
							</tr>
						</thead>
						<tbody id="nList">
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</section>
<div id="customactions" style="display: none;">
	<div class="actions" style="float: right;">
        <a id="btncart" class="btn btn-sm btn-danger" href="javascript:formcarttj();" ><i class="fa fa-plus"></i> 加入购物车</a>
    </div>
</div>

<div id="customform" style="display: none;">
   <form action="<?=$this->url("purchase/apply")?>" method="GET" class="input-group input-group-sm" style="float:left; width:200px;">
    <select name='categoryuuid' class="form-control">
	 <option value='' <?=isset($_GET['categoryuuid'])&&$_GET['categoryuuid']==''?"selected":""?> >全部分类</option>
	   <?=$trees?>
	</select>
	&nbsp;&nbsp;&nbsp;
	<select name='branduuid' class="form-control">
	 <option value='' <?=isset($_GET['branduuid'])&&$_GET['branduuid']==''?"selected":""?> >全部品牌</option>
	 <?foreach($brand as $val){?>
		<option value='<?=$val['uuid']?>' <?=isset($_GET['branduuid'])&&$_GET['branduuid']==$val['uuid']?"selected":""?> ><?=$val['title']?></option>
	 <?}?>
	</select>
	&nbsp;&nbsp;&nbsp;
	<input  id="userphone" name="userphone" class="form-control" type="text" placeholder="商品名称/商品条码" value="<?=$userphone?>">
	<span class="input-group-btn">
		<button class="btn btn-primary" type="submit">搜索</button>
	</span>
   </form>
</div>
<!-- DataTables -->
<script src="/public/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/public/adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">

	function formcarttj() {
		var data = $("#logins").serialize();
		var url = $("#logins").attr("action");
		$.ajax({
            type: 'POST',
            dataType: 'json',
            data : data,
            url : url,
            beforeSend : function() {
				$('#btncart').html('正在加入到购物车...');
				$('#btncart').addClass("disabled");
            },
            success : function(result) {
                if (result.state == 1) {
                    pub_alert_success(result.info);
                    $("#logins")[0].reset();
                } else {
                    pub_alert_error(result.info);
                }
            },
            error : function(result) {
            	pub_alert_error("系统出现错误，请稍后尝试");
            },
            complete : function(){
            	$("#btncart").html('<i class="fa fa-plus"></i> 加入购物车');
            	$('#btncart').removeClass("disabled");
            }
        });
	}
	function changenum(val,id,tag){
		//return true;
		var num	=	val;//$("#goodsnum_"+id).val();
		if(isNaN(num)){return false;}
		var boxnum	=	$("#boxnum_"+id).val();
		var hasnum	=	$("#hasnum_"+id).val();
		//if(isNaN(boxnum)){pub_alert_error("请联系总部修改装箱量");$("#goodsnum_"+id).val('');return false;}
		//if(num*boxnum>hasnum){pub_alert_error("购买数量不能超过库存量");$("#goodsnum_"+id).val('');return false;}
	}

	$(function(){
		
		var num = 2; //计数器初始化为1
        var maxnum = <?=$number?>+1; //设置一共要加载几次
		var userphone	=	'';<?if(!empty($userphone)){?>userphone=<?='"'.$userphone.'"'?>;<?}?>
		var categoryuuid=	'';<?if(!empty($categoryuuid)){?>categoryuuid	=	<?='"'.$categoryuuid.'"'?>;<?}?>
		var branduuid	=	'';<?if(!empty($branduuid)){?>branduuid	=	"'"+<?=$branduuid?>+"'";<?}?>
		LoadList(1);
    	$(window).scroll(function(){
            checkload();
		});
        function checkload() {
			var srollPos = $(window).scrollTop(); //滚动条距离顶部的高度
			var windowHeight = $(window).height(); //窗口的高度
			var dbHiht = $("body").height(); //整个页面文件的高度
			if((windowHeight + srollPos) >= (dbHiht) && num != maxnum){
				LoadList(num);
				num++; //计数器+1
			}
		}

		function LoadList(num) {
			$.get("<?=$this->url('purchase/ajaxApply')?>?",{page:num,userphone:userphone,categoryuuid:categoryuuid,branduuid:branduuid},function(result){
			     t = setTimeout(function(){$("#nList").append(result)},1);
			});
		}
		
		setfooterfixed($("#customactions").html());
		$("#customactions").html('');
	});

</script>