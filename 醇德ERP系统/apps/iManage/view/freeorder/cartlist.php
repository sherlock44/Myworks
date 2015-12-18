<section class="content-header">
<h1>
  购物车
  <small>查看购物车列表</small>
</h1>
<ol class="breadcrumb">
<li><a href="<?=$_SESSION['indexmain']?>"><i class="fa fa-home"></i> 首页</a></li>
  <li><a href="#">赠送订单</a></li>
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
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
					<thead>
        				<tr>
							<th >商品名称</th>
							<th >图片</th>
							<th >商品条码</th>
							<th >保质期</th>
							<th >重量</th>
							<th >价格</th>
							<th >保质期至</th>					
							<th >当前库存</th>
							<th >装箱规格</th>						
														
							<th width="130px">数量</th>
							<th >操作</th>
						</tr>
    				</thead>
    				<tbody>
                         <?
                                foreach($re as $key=>$value){
                            ?>
                            <tr>
							
							<td><?=$value['title']?></td>
							<td><img width=25 height=25   src="<?=empty($value["imgpath"])?"/public/assets/sysadmin/img/default.png":$value["imgpath"]?>"></td>
							<td><?=$value['barcode']?></td>
							<td><?=!empty($value['shelflife'])?$value['shelflife']:'--'?></td>
							<td><?=$value['weight']?></td>	
							<td><?=$value['price']?></td>	
							<td>
							<?if(empty($value['shelflife'])){echo '--';}else{echo date("Y-m-d",empty($value['productontime'])?time():$value['productontime']);}?>
							</td>	
							
							<td><?if(!empty($value['boxnum'])){echo floor($value['number']/$value['boxnum']);}?>箱</td>
							<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>
							<td>
							<div class="input-group input-group-sm">
							<input type="text" class="checknum form-control" id="goodsnum_<?=$value['cartid']?>" name="goodsnum_<?=$value['cartid']?>" onchange="changenum(<?=$value['cartid']?>)"  value="<?=$value['num']?>"  data-rule-number="true" data-rule-minlength="1" placeholder="只能填数字">
								<span class="input-group-btn">
			                      <button class="btn btn-success" style="font-weight: bold;" type="button">箱</button>
			                    </span>
							<input type="hidden" value="<?=$value['boxnum']?>" id="boxnum_<?=$value['cartid']?>">
							<input type="hidden"   id="hasnum_<?=$value['cartid']?>" value="<?=$value['number']?>">
							</div>
							</td>
							<td>
								<a href="javascript:pub_alert_confirm(this,'确定要删除吗？','<?=$this->url("freeorder/delcart")?>?id=<?=$value["cartid"]?>');" class="btn btn-xs btn-danger" title="删除"><i class="fa fa-close"></i></a>
							</td>							
							</tr>
                            <?
                                }
                            ?>
							<tr>
							<td>选择加盟商</td>
							<td  colspan="10">
							<select name="alliance" id="alliance" onchange="getoldorder(this.value)">
							<option value="0">选择加盟商</option>
							<?foreach($alliance as $val){?>
								<option value="<?=$val['token']?>"><?=$val['shoppname']?></option>
							<?}?>	
							</select>
							</td>
							
							</tr>
							<tr>
							<td>选择关联订单</td>
							<td colspan="10">
								<select name="oldordersel"  id="oldordersel">
									<option value="0">选择关联订单</option>
								</select>
							
							</td>
							</tr>
							<tr>
							<td>输入关联订单</td>
							<td colspan="10">
								<input type="text" value="" id="ordernum"  placeholder="输入关联订单号" class="span3">(注:<span style="color:red;">若在下拉选项和文本框中同时选择关联订单,以文本框中订单号为准</span>)
							</td>
							</tr>
							
                        </tbody>
					</table>
				</div>
			</div>
			<div class="box-body">
				<form  class='form-horizontal form-bordered form-validate'	action='' id="login" name="login" method='post'>
	                <textarea id="remarkcart" name="data[intro]" class="form-control" rows="3" placeholder="请填写备注 ..."></textarea>
				</form>
			</div>
			<div class="box-footer">
			 	<button type="button" class="btn btn-primary" id="btntj" onclick="tjcart()">确认提交<i class="icon-shopping-cart"></i></button>
			</div>
		</div>
	</div>
</section>

<script>
	//修改采购数量
	function changenum(id){
		var num	=	$("#goodsnum_"+id).val();
		if(isNaN(num)){return false;}
		var boxnum	=	$("#boxnum_"+id).val();
		var hasnum	=	$("#hasnum_"+id).val();
		if(isNaN(boxnum)){pub_alert_error("请联系总部修改装箱量");$("#goodsnum_"+id).val('');return false;}
		//if(num*boxnum>hasnum){pub_alert_error("购买数量不能超过库存量");$("#goodsnum_"+id).val('');return false;}
		$.ajax({
			url:"<?=$this->url('freeorder/updatecart')?>",
			data:"id="+id+"&num="+num,
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
	function tjcart(){
		var remark	=	$("#remarkcart").val();
		var alliance	=	$("#alliance").val();
		var oldordersel	=	$("#oldordersel").val();
		var ordernum	=	$("#ordernum").val();
		$(".checknum").each(function(){
			if($(this).val()=='' || $(this).val()==0){
			pub_alert_error("请填写购买数量");return false;
			
			}
		});
		
		$("#btntj").html("提交中...");
		$.ajax({
			url:"<?=$this->url('freeorder/tjcart')?>",
			data:{remark:remark,alliance:alliance,oldordersel:oldordersel,ordernum:ordernum},
			type:"post",
			dataType:"json",
			success:function(r){
				if(r.state == 1){
					pub_alert_success(r.info);
					setTimeout('window.location.href="<?=$this->url('purchasesr/ordernoover')?>"',600);
					
				  }else{
					pub_alert_error(r.info);
					$("#btntj").html('确认提交&nbsp;&nbsp;<i class="icon-shopping-cart"></i>');
				  }
			}
		
		});
	
	}
	//得到关联订单
	function getoldorder(token){
		$.ajax({
			data:"token="+token,
			url:"<?=$this->url('freeorder/getoldorder')?>",
			type:"post",
			dataType:"json",
			success:function(r){
				if(r.state==1){
					var str	=	"<option value='0'>选择关联订单</option>";
					for(var i=0;i<r.re.length;i++){
						str+="<option value='"+r.re[i]['ordernum']+"'>"+r.re[i]['ordernum']+"</option>";
					}
					$("#oldordersel").html(str);
				}else{
					alert("请输入关联订单号");
				}
			
			}
		
		});
	
	}

</script>



