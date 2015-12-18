<section class="content-header">
<h1>
  购物车
  <small>查看购物车列表</small>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> 采购平台</a></li>
  <li><a href="#">采购管理</a></li>
  <li class="active">购物车列表</li>
</ol>
</section>
<section class="content">
	<div class="row">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">已选商品</h3>
			</div>
			<!-- /.box-header -->
			<form class="table-responsive" action='<?=$this->url("purchase/tjcart")?>' id="logins" name="logins" method='post'>
			<div class="box-body">
				<div class="table-responsive">
				
					<table class="table table-bordered table-hover">
					<thead>
        				<tr>
							<th style="display:none;">商品名称</th>
							<th><input type="checkbox" id="selall" onclick="checkboxstatus()" checked="true">全选</th>
							<th>商品名称</th>
							<th>图片</th>
							<th>商品条码</th>
							<th>保质期(月)</th>
							<th>重量(g)</th>
							<th>价格(元)</th>
							<th>保质期至</th>
							<!--th width="5%">当前库存</th-->
							<th>装箱规格</th>
							<th width="130px">数量</th>
							<th>操作</th>
						</tr>
    				</thead>
    				<tbody>
                        <?
							$allheght	=	0;
							$allprice	=	0;
							$allnum	=	0;
							
                            foreach($re as $key=>$value){
							
							$allheght+=$value['weight']*$value['boxnum']*$value['num'];
							$allprice+=$value['price']*$value['boxnum']*$value['num'];
							$allnum+=$value['num'];
                        ?>
						<input type="hidden" id="allheght_<?=$value['cartid']?>" value="<?=$value['weight']?>">
						<input type="hidden" id="allprice_<?=$value['cartid']?>" value="<?=$value['price']?>">
						<input type="hidden" id="boxnum_<?=$value['cartid']?>" value="<?=$value['boxnum']?>">
                        <tr>
						<td style="display:none;"><?=$value['title']?></td>
						<td><input type="checkbox" class="boxchild" value="<?=$value['cartid']?>" name="selcartid[]" checked="true"></td>
						<td><?=$value['title']?></td>
					<td>
					<?if(empty($value["imgpath"])){?>
							<img width="25" height="25"   src="/public/assets/sysadmin/img/default.png">
							<?}else{?>
							<a href="<?=$value["imgpath"]?>" target="_black">
							<img width="25" height="25"   src="<?=$value["imgpath"]?>">
							</a>
							<?}?>
					</td>
						<td><?=$value['barcode']?></td>
						<td><?=!empty($value['shelflife'])?$value['shelflife']:'--'?></td>
						<td><?=$value['weight']?>/<?=$value['specs']?></td>
						<td>¥ <?=$value['price']?>/<?=$value['specs']?></td>
						<td>
						<?if(empty($value['shelflife'])){echo '--';}else{echo date("Y-m-d",empty($value['productontime'])?time():$value['productontime']);}?>
						</td>
						<!--td><?if(!empty($value['boxnum'])){echo floor($value['number']/$value['boxnum']);}?>箱</td-->
						<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>
						<td>
							<div class="input-group input-group-sm">
								<input type="text" class="checknum form-control" id="goodsnum_<?=$value['cartid']?>" name="goodsnum_<?=$value['cartid']?>" onchange="changenum(<?=$value['cartid']?>)"  value="<?=$value['num']?>" data-rule-required="true" data-rule-number="true" data-rule-minlength="1" placeholder="只能填数字">
								<span class="input-group-btn">
			                      <button class="btn btn-success" style="font-weight: bold;" type="button">箱</button>
			                    </span>
								<!-- <span class="input-group-addon">箱</span> -->
						   	</div>
						   	<input type="hidden" value="<?=$value['boxnum']?>" id="boxnum_<?=$value['cartid']?>">
							<input type="hidden"   id="hasnum_<?=$value['cartid']?>" value="<?=$value['number']?>">
						</td>
						<td>
							<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("purchase/delcart")?>?id=<?=$value["cartid"]?>');" class="btn btn-sm btn-danger" title="删除"><i class="fa fa-remove"></i></a>
						</td>
						</tr>
                        <?
                            }
                        ?>
						<tr style="color:green;text-align:center;">
							<td style="display:none;">商品名称</td>
							<td>小计</td>
							<td colspan="10">总重量:<span id="allheght"><?$kg=round($allheght/1000,2);echo $kg;?></span>kg,价格:<span id="allprice">
							<?=$allprice?></span>元,总箱数:<span id="allnum"><?=$allnum?></span>箱！<span id="rmark"><?if($kg-1000<0){?>提示语：还差<span style="color:red;"><?echo 1000-$kg;?></span>公斤满1吨<?}?></span></td>
							
						</tr>
                        </tbody>
					</table>
					
				</div>
			</div>
			<div class="box-body">
				
	                <textarea id="remarkcart" name="remark" class="form-control" rows="3" placeholder="请填写备注 ..."></textarea>
				
			</div>
			</form>
			<div class="box-footer">
			 	<button type="button" class="btn btn-primary" id="btntj" onclick="tjcart()">确认提交<i class="icon-shopping-cart"></i></button>
			</div>
		</div>
	</div>
</section>
<script>
	$(".boxchild").click(function(){
		getallinfo();
	});
	//全选
	 function checkboxstatus(){
		
		var cartlength=$(".boxchild").length;
		var child=document.getElementsByClassName("boxchild");
		if(document.getElementById("selall").checked){
			for(var i=0;i<child.length;i++){
				child[i].checked=true;
			}
		getallinfo();
		}else{
		for(var i=0;i<child.length;i++){
				child[i].checked=false;
			}
			$("#allheght").html(0);
			$("#allprice").html(0);
			$("#allnum").html(0);
			$("#rmark").html("");
		}
		
	
	}
	//计算总信息
	function getallinfo(){
		var allheght=0;
		var allprice=0;
		var allnum=0;
		var childheght=0;
		var childprice=0;
		var childnum=0;
		var boxnum=0;
		var nownum=0;
		var child=document.getElementsByClassName("boxchild");
		for(var i=0;i<child.length;i++){
				if(child[i].checked==false){continue;}
				childheght=$("#allheght_"+child[i].value).val();
				childprice=$("#allprice_"+child[i].value).val();
				childnum=$("#boxnum_"+child[i].value).val();
				nownum=$("#goodsnum_"+child[i].value).val();
				
			if(isNaN(nownum) || nownum<=0){continue;}
				allheght=childheght*nownum*childnum-0+allheght;//总重量
				allprice=childprice*nownum*childnum-0+allprice;//总价格
				allnum=nownum-0+allnum;//总数量
			}
			allheght=allheght/1000;
			allheght=Math.round(allheght*100)/100;
			allprice=Math.round(allprice*100)/100;
			//alert(allheght);
			//allheght=allheght.toFixed(2);
			$("#allheght").html(allheght);
			$("#allprice").html(allprice);
			$("#allnum").html(allnum);
			if(allheght<1000){
			var w	=	1000-allheght;
			w=Math.round(w*100)/100;
			var str	=	'提示语：还差<span style="color:red;">'+w+'</span>公斤满1吨';
			
			}else{
			var str	='';
			}
			$("#rmark").html(str);
	}
	//修改采购数量
	function changenum(id){
		var num	=	$("#goodsnum_"+id).val();
		if(isNaN(num)){return false;}
		var boxnum	=	$("#boxnum_"+id).val();
		var hasnum	=	$("#hasnum_"+id).val();
		if(isNaN(boxnum)){pub_alert_error("请联系总部修改装箱量");$("#goodsnum_"+id).val('');return false;}
		//if(num*boxnum>hasnum){pub_alert_error("购买数量不能超过库存量");$("#goodsnum_"+id).val('');return false;}
		$.ajax({
			url:"<?=$this->url('purchase/updatecart')?>",
			data:"id="+id+"&num="+num,
			type:"post",
			dataType:"json",
			success:function(r){
				if(r.state == 1){
					pub_alert_success(r.info);
					getallinfo();
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
	function tjcart(){
		var remark	=	$("#remarkcart").val();
		$(".checknum").each(function(){
			if($(this).val()=='' || $(this).val()==0){
				pub_alert_error("请填写购买数量");return false;
			}
		});
		var data = $("#logins").serialize();
		$("#btntj").html("提交中...");
		
		$.ajax({
			url:"<?=$this->url('purchase/tjcart')?>",
			data:data,
			type:"post",
			dataType:"json",
			success:function(r){
				if(r.state == 1){
					pub_alert_success(r.info);
					setTimeout('window.location.href="<?=$this->url('purchase/orderconfirm')?>"',600);
				  }else{
					pub_alert_error(r.info);
					$("#btntj").html('确认提交&nbsp;&nbsp;<i class="icon-shopping-cart"></i>');
				  }
			}
		});
	}
</script>