<section class="content-header">
	<h1>
		会员卡类型
		<small>会员卡类型折扣</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> ERP系统</a></li>
		<li><a href="#">会员卡管理</a></li>
		<li class="active">会员卡类型</li>
	</ol>
</section>
<section class="content">
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">会员卡折扣规则</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="row">
				<div class="col-xs-4">
					<?foreach($cardtype as $key=>$value){ ?> 
					<div class="form-group">
						<label for="categoryuuid"><?=$value?></label>
						<div class="input-group input-group-sm">
							<input type="text" id="discount_<?=$key?>" name="discount_<?=$key?>" onchange="changenum(<?=$key?>)"  value="<?=$arr[$key]['discount']?>" class="form-control" data-rule-required="true" data-rule-number="true" data-rule-minlength="1" placeholder="只能填数字">
							<span class="input-group-btn">
								<button class="btn btn-primary" style="font-weight: bold;" type="button">%</button>
							</span>
							<!-- <span class="input-group-addon">箱</span> -->
						</div>
					</div>
					<?}?> 
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	//修改采购数量
	function changenum(id){
		var num	=	$("#discount_"+id).val();
		if(isNaN(num)){return false;}
		$.ajax({
			url:"<?=$this->url('card/updatediscount')?>",
			data:"cardid="+id+"&num="+num,
			type:"post",
			dataType:"json",
			success:function(r){
				if(r.state == 1){
					pub_alert_success(r.info);
					if(r.data == 'back'){
						setTimeout('location.reload()',600);
					}
				}else{
					pub_alert_error(r.info);
				}
			}
		});
	}
	//提交
	// function tjcart(){
	// 	var remark	=	$("#remarkcart").val();
	// 	$.ajax({
	// 		url:"<?=$this->url('purchase/tjcart')?>",
	// 		data:{remark:remark},
	// 		type:"post",
	// 		dataType:"json",
	// 		success:function(r){
	// 			if(r.state == 1){
	// 				pub_alert_success(r.info);
	// 				setTimeout('window.location.href="<?=$this->url('purchase/orderconfirm')?>"',600);
	// 				/* if(r.data == 'back'){
	// 				setTimeout('location.reload()',600);
	// 				} */
	// 			  }else{
	// 				pub_alert_error(r.info);
	// 			  }
	// 		}
	// 	});
	// }
</script>