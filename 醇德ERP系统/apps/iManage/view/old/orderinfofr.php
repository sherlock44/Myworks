<div id="main">
    <div class="container-fluid nopadding">
<div class="breadcrumbs">
	<ul>
		<li>
			<a href="<?=$_SESSION['indexmain']?>">后台管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">订货管理</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="">订货商品列表</a>
		</li>
	</ul>
	<div class="close-bread">
		<a href="#"><i class="icon-remove"></i></a>
	</div>
</div>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/gritter/jquery.gritter.css">
<script src="/public/assets/sysadmin/js/plugins/gritter/jquery.gritter.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/chosen/chosen.css">
<script src="/public/assets/sysadmin/js/plugins/chosen/chosen.jquery.min.js"></script><link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/jquery.dataTables.css">
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datatable/TableTools.css">
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/TableTools.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColReorder.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/ColVis.min.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datatable/jquery.dataTables.columnFilter.js"></script>
<link rel="stylesheet" href="/public/assets/sysadmin/css/plugins/datetimepicker/datetimepicker.css">
<script src="/public/assets/sysadmin/js/plugins/datetimepicker/datetimepicker.js"></script>
<script src="/public/assets/sysadmin/js/plugins/datetimepicker/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>订货流程
				</h3>				
			</div>
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("newcash/insertplan")?>'  id="login" name="login" method='post'>
					<div class="control-group" style="height:45px;background-color:white;text-align:center;padding-top:10px;">
					<?if($order['orderbackstatus']>0){?><span style="color:red;"><b>【加盟商已退货】</b></span><?}?>
						<?foreach($this->conf['orderstatus'] as $k=>$v){?>
								<?if($k<0){continue;}?>
								<?if($order['status']==$k){?>
								<span style="color:red;"><?echo ($k+1).".$v";?></span>
								<?}else{?>
								<?echo ($k+1).".$v";?>
								<?}?>
							<?}?>
							
							<?if(!empty($order['freeordernum'])){?><span style="color:red;"><b>【赠送订单】</b></span>关联订单【<a href="<?=$this->url('purchase/orderinfofr',array('ordernum'=>$order['freeordernum'],'token'=>$order['token']))?>"><?=$order['freeordernum']?></a>】<?}?>&nbsp;&nbsp;
								<?if(!empty($freeorder)){?><span style="color:red;"></span>【关联赠送订单-<a href="<?=$this->url('purchase/orderinfofr',array('ordernum'=>$freeorder['ordernum'],'token'=>$order['token']))?>"><?=$freeorder['ordernum']?></a>】<?}?>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

        <div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					订货商品列表
        				</h3>
                        
        			</div>
        			<div class="box-content nopadding" style="overflow: auto;">
				
					<div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
						<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url('purchase/changeprice')?>'  id="formtjtable" name="login" method='post'>
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
							<?$colspan=11;?>
							<th width="8%">商品分类</th>
							<th width="15%">商品名称</th>
							<th width="5%">图片</th>
							<th width="10%">商品条码</th>
							<th width="6%">保质期(月)</th>
							<th width="6%">重量</th>
							<th width="6%">订货价格</th>
							<th width="5%">装箱规格</th>
							<th width="8%">保质期至</th>											
							<th width="5%">订购数量</th>
							<?if($order['backstatus']==6){$colspan=12;?>
							<th width="5%">退货数量</th>
							<?}?>
							<th width="10%">小计(元)</th>
							</tr>
        					</thead>
                            <?
							$weights	=	0;
								$aprices	=	0;
								$anum	=	0;
                                foreach($re as $key=>$value){
								$weights+=$value['weights']*($value['buynum']-$value['realbacknum']);
								$aprices+=$value['allprice'];		
								$anum+=	$value['buynum']-$value['realbacknum'];	
                            ?>
                            <tr style="<?if($value['tag']==0){?>background:#EC2085;<?}?>">
							
							<td><?=$value['fctitle']?></td>
							<td><?=$value['title']?></td>
							<td><?if(empty($value["imgpath"])){?>
								<img width=25 height=25   src="/public/assets/sysadmin/img/default.png">
								<?}else{?>
								<a href="<?=$value["imgpath"]?>" target="_black">
								<img width=25 height=25   src="<?=$value["imgpath"]?>">
								</a>
								<?}?></td>
							<td><?=$value['barcode']?></td>
							<td><?=!empty($value['shelflife'])?$value['shelflife']:'--'?></td>
							<td><?=$value['weight']?>g/<?=$value['specs']?></td>
							<td><?=$value['buyprice']?>元/<?=$value['specs']?></td>	
							<td><?=$value['boxnum']?><?=$value['specs']?>/箱</td>	
							<td><?if(empty($value['shelflife'])){echo '--';}else{echo date("Y-m-d",empty($value['productontime'])?time():$value['productontime']);}?></td>	
							
							
						
							<td><?=$value['buynum']?>箱</td>		
							<?if($order['backstatus']==6){?>
							<td><?=$value['realbacknum']?>箱</td>
							<?}?>
							<td>
							<?
							$aprice	=	$value['allprice'];
							if($value['allprice']==0){
							$aprice	=	$value['buynum']*$value['boxnum']*$value['buyprice'];
							}
							?>
							<input type="text" class="span8 backmoney" name="foeallprice[]" onchange="changeprice()" value="<?=$aprice?>">元
							<input type="hidden" class="span8" name="foeid[]" value="<?=$value['foeid']?>">
							</td>		
												
							</tr>
                            <?
                                }
                            ?>
							<tr>
							<td width="8%">总计</td>
							<td width="15%"></td>
							<td width="5%"></td>
							<td width="10%"></td>
							<td width="6%"></td>
							<td width="6%"><?=$weights?>kg</td>
							<td width="6%"></td>
							<td width="5%"></td>
							<td width="8%"></td>											
							<td width="5%"><?=$anum?>箱</td> 
							<?if($order['backstatus']==6){?>
							<td width="5%"><?=$realbacknum?>箱</td>
							<?}?>
							<td width="10%">
							<input type="hidden" class="span1" name="orderid"  value="<?=$order['id']?>">
							<input readonly type="text" class="span8" name="allprice" id="allprice" value="<?=$order['allprice']?>" >元&nbsp;&nbsp;
							</td>
							</tr>
							<tr>
							<td width="8%" colspan="<?=$colspan-1?>"><?if($order['status']>=3 ){?>收款方式：<?=$order['paytype']?"全额收款":"信用收款"?>&nbsp;&nbsp;<?if(isset($bankarray[$order['bankid']])){?>收款银行:<?=$bankarray[$order['bankid']]?><?}}?></td>
							
							<td width="10%">
							<input type="button" onclick="formcarttj()"    class="btn btn-primary" value="修改">
							</td>
							</tr>
							
							
        				</table>
						</form>
        			</div>
					
        			</div>
        		</div>
        	</div>
        </div>
    
	<div class="row-fluid" >
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>加盟商信息
				</h3>
				<div class="actions">
        					<a rel="tooltip"  href="javascript:void(0)" id="othermessage" onclick="javascript:if($('#otherdiv')[0].style.display=='none'){$('#otherdiv').show();$('#othermessage').html('-隐藏');}else{$('#otherdiv').hide();$('#othermessage').html('+展开');}"  class="btn btn-danger">+展开</a>
        				</div>
			</div>
			<div class="box-content nopadding" id="otherdiv" style="display:none;">
				<form  class='form-horizontal form-bordered form-validate'	action=''  id="login" name="login" method='post'>
					<div class="control-group">
						<label for="mobile" class="control-label">加盟商类型</label>
						<div class="controls">
							<?=$userinfo['supplytype']?>
						</div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">所属区域</label>
						<div class="controls">
							<?=$userinfo['pname']?>省-<?=$userinfo['cname']?>市
						</div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">地址</label>
						<div class="controls">
							<?=$userinfo['address']?>
						</div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">公司名称-电话</label>
						<div class="controls">
							<?=$userinfo['commname']?>-<?=$userinfo['commtel']?>
						</div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">负责人姓名-电话</label>
						<div class="controls">
							<?=$userinfo['truename']?>-<?=$userinfo['mobile']?>
						</div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">负责人姓名-电话-邮箱</label>
						<div class="controls">
							<?=$userinfo['truename']?>-<?=$userinfo['mobile']?>-<?=$userinfo['email']?>
						</div>
					</div>
				<div class="control-group">
						<label for="mobile" class="control-label">业务联系人姓名-电话-邮箱</label>
						<div class="controls">
							<?=$userinfo['proname']?>-<?=$userinfo['protel']?>-<?=$userinfo['proemail']?>
						</div>
					</div>
				<div class="control-group">
						<label for="mobile" class="control-label">收货人姓名-电话-邮箱</label>
						<div class="controls">
							<?=$userinfo['consigneename']?>-<?=$userinfo['consigneetel']?>-<?=$userinfo['consigneeemail']?>
						</div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">加盟商名字-电话</label>
						<div class="controls">
							<?=$userinfo['suppname']?>-<?=$userinfo['supptel']?>
						</div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">备注</label>
						<div class="controls">
							<?=$userinfo['remark']?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>




	<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>财务信息
				</h3>
			</div>
			<div class="box-content nopadding">
			<?$url=$this->url("purchase/updateorderstatusfr");?>
			<?if($order['status']==4){?>
			<?$url=$this->url("purchase/updateorderstatusfr2");?>
			<?}?>
			<?if($order['status']==-4){?>
			<?$url=$this->url("purchase/updateorderstatusfr3");?>
			<?}?>
				<form  class='form-horizontal form-bordered form-validate' 	action='<?=$url?>'  id="formtjsh" name="login" method='post'>
					
				
					<?if($order['status']==2){?>
					<div class="control-group paydate">
						<label for="mobile" class="control-label">付款日期</label>
						<div class="controls">
							<input type="text" name="paydate" id="paydate" value="<?=empty($logistics['paydate'])?date('Y-m-d'):date('Y-m-d',$logistics['paydate'])?>" class="input-medium datepick valid" data-rule-required="true" data-rule-minlength="1" >
						</div>
					</div>
					<div class="control-group paydate" >
						<label for="mobile" class="control-label">收款类型</label>
						<div class="controls">
							<input type="checkbox" name="paytype" id="paytype1" onclick="changepaytype(this.value);$('#skzh').show();" value="1">全额收款&nbsp;&nbsp;&nbsp;<input id="paytype0" type="checkbox" name="paytype" onclick="changepaytype(this.value);$('#skzh').hide();" value="0">信用收款
						</div>
					</div>
					<div class="control-group paydate" id="skzh">
						<label for="mobile" class="control-label">收款账号</label>
						<div class="controls">
							<select name="bankid">
							<option value="0">选择收款账号</option>
							<?foreach($bank as $val){?>
							<option value="<?=$val['id']?>"><?=$val['bankname']?></option>
							<?}?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label for="mobile" class="control-label">备注</label>
						<div class="controls">
							<textarea name="data[remark]" class="span8"></textarea>
						</div>
					</div>
					
					
					
					
					
				
						
					<?}?>
		
					<?if($order['status']==-4){?>
					<div class="control-group">
						<label for="mobile" class="control-label">备注</label>
						<div class="controls">
							<textarea name="data[remark]" class="span8"></textarea>
						</div>
					</div>
					
					<div class="control-group">
						<label for="mobile" class="control-label">财务审核</label>
						<div class="controls">
							<select name="data[results]">
							<option value="1">等待退款</option>
							<option value="-1">已退款,订单已无效</option>
							</select>
						</div>
					</div>
					
				
						
					<?}?>
					<div class="control-group">
						<label for="mobile" class="control-label">付款纪录</label>
						<div class="controls">
							<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
							<th width="10%">付款金额(元)</th>
							<th width="10%">银行账号</th>
							<th width="10%">收款时间</th>						
							<th width="10%">收款方式</th>							
							<th width="15%">备注</th>
							<th width="5%">操作</th>
							</tr>
        					</thead>
							
                           <?$k=0;?>
							<?foreach($paylog as $k=>$val){?>
                            <tr>
							<?if($val['created']==0){$created=$val['created'];}else{$created=date("Y-m-d",$val['created']);}?>
										<td style="font-size:12px;border:#666666 solid 1px;">
										<input type="text"  id="paymoney_<?=$val['id']?>" value="<?=$val['paymoney']?>" style="width:100px;"  />
										</td>
										<td style="font-size:12px;border:#666666 solid 1px;">
										<input type="text"  value="<?=$val['banknum']?>" id="banknum_<?=$val['id']?>"/>
										</td>
										<td style="font-size:12px;border:#666666 solid 1px;">
										<input id="paytime_<?=$val['id']?>" type="text"   class=" input-medium datepick valid" value="<?=empty($val['paytime'])?'':date("Y-m-d",$val['paytime'])?>"/>
										</td>	
										<td style="font-size:12px;border:#666666 solid 1px;">
										
										<select id="paytype_<?=$val['id']?>" style="width:100px;"   ><?foreach($paytype as $v){?><option value="<?=$v['id']?>" <?=$val['paytype']==$v['id']?'selected':''?>><?=$v['title']?></option><?}?></select>
										</td>	
										<td style="font-size:12px;border:#666666 solid 1px;">
										<input id="payremark_<?=$val['id']?>" type="text"  value="<?=$val['remark']?>"/>
										</td>	
										<td style="font-size:12px;border:#666666 solid 1px;">
										<a href="javascript:void(0)" onclick="addpaylog(<?=$val['id']?>)">修改</a>
										&nbsp;&nbsp;<a href="javascript:void(0)" onclick="delpaylog(<?=$val['id']?>)">删除</a>
										</td>	
									</tr>
									
								<?}?>
															
								
									<tr>
									<td style="font-size:12px;border:#666666 solid 1px;">
									<input type="text"  id="paymoney_0" value=""  style="width:100px;" />
									</td>
									<td style="font-size:12px;border:#666666 solid 1px;"><input type="text"  id="banknum_0" value=""/></td>
									<td style="font-size:12px;border:#666666 solid 1px;">
									<input type="text"  class=" input-medium datepick valid"   id="paytime_0" value=""/>
									</td>	
									<td style="font-size:12px;border:#666666 solid 1px;">
									
									<select    style="width:100px;" id="paytype_0">
									<?foreach($paytype as $v){?>
									<option value="<?=$v['id']?>"><?=$v['title']?></option>
									<?}?>
									</select>
									</td>	
									<td style="font-size:12px;border:#666666 solid 1px;"><input type="text"  id="payremark_0" value=""/></td>
									<td style="font-size:12px;border:#666666 solid 1px;"><a href="javascript:void(0)" onclick="addpaylog(0)">提交</a></td>
									</tr>
									
									
								
									
        				</table>
							
							
						</div>
					</div>
					
					<?if(in_array($order['status'],array(2,-4))){?>
						<input type="hidden" value="<?=$order['id']?>" name="id">
							<div class="form-actions">		
								<input type="button"  onclick="formtjs();"  class="btn btn-primary" value="提交">
						<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>					
						</div>
					<?}?>
				</form>
			</div>
		</div>
	</div>
</div>


	<?if($order['status']==3){?>
<div class="row-fluid">
	<div class="span12">
		<div class="box box-color box-bordered">
			<div class="box-title">
				<h3>
					<i class="icon-user"></i>反审
				</h3>
			</div>
			<div class="box-content nopadding">
				<form  class='form-horizontal form-bordered form-validate'	action='<?=$this->url("purchase/updateorderstatusfrback")?>'  id="formtjie" name="login" method='post'>
					<div class="control-group">
						<label for="mobile" class="control-label">备注</label>
						<div class="controls">
							<textarea name="data[remark]" class="span8"></textarea>(反审之后,可以修改商品订购数据)
						</div>
					</div>
					
					
	
				
						<input type="hidden" value="<?=$order['id']?>" name="id">
							<div class="form-actions">		
								<input type="button"  onclick="formtj();"  class="btn btn-primary" value="提交">
								<input type="button" class="btn btn-primary" value="返回列表" onclick='returnList()'>					
										
									
						
						</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?}?>
<?if($log){?>
 <div class="row-fluid">
        	<div class="span12">
        		<div class="box box-color box-bordered">
        			<div class="box-title">
        				<h3>
        					<i class="icon-th-list"></i>
        					订单操作记录
        				</h3>
                        <div class="actions">
        					<a rel="tooltip"  href="javascript:void(0)" id="logtag" onclick="javascript:if($('#logcontent')[0].style.display=='none'){$('#logcontent').show();$('#logtag').html('-隐藏');}else{$('#logcontent').hide();$('#logtag').html('+展开');}"  class="btn btn-danger">+展开</a>
        				</div>
        			</div>
        			<div class="box-content nopadding" id="logcontent" style="display:none;">
					<div role="grid" class="dataTables_wrapper" style="overflow: auto;" id="DataTables_Table_0_wrapper">
					
        				<table class="table table-hover table-nomargin  table-bordered" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
        					<thead>
        					<tr>
							
							<th width="10%">序号</th>
							<th width="10%">审核人</th>
							
							
							
							<th width="10%">审核</th>
														
							<th width="10%">描术</th>							
							
							<th width="15%">审核时间</th>
						
							
					
						
						</tr>
        					</thead>
							
                            <?
                              foreach($log as $ks=>$value){
                            ?>
                            <tr>
							<td><?=$ks?></td>
							<td><?=$value['truename']?></td>
							<td><?=$value['results']?></td>
							<td><?=$value['remark']?></td>	
							<td><?=date("Y-m-d H:i:s",$value['created'])?></td>					
							</tr>
                            <?
                                }
                            ?>
        				</table>
						
        			</div>
        			</div>
        		</div>
        	</div>
        </div>

<?}?>


	</div>
</div>
<script>
	function changepaytype(val){
		if(val==1){
			var other=0;
		}else{
			var other	=	1;
		}
		if($("#paytype"+val).prop('checked')){
			
			$("#paytype"+other).attr("checked",false);
		}
	
	}
//返回列表
	function returnList(){
		window.location.href='<?=$this->url("purchase/orderinfofr")?>';
	}
//修改订货数量
	function changenum(id,ordernum){
		var num	=	$("#goodsnum_"+id).val();
		if(isNaN(num)){return false;}
		$.ajax({
			url:"<?=$this->url('purchasesr/updatecart')?>",
			data:"id="+id+"&num="+num+"&ordernum="+ordernum,
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

	function formtjs(){
		if(confirm("确认提交？")){
			$("#formtjsh").submit();
		}
	}
	function formtj(){
		if(confirm("确认提交？")){
			$("#formtjie").submit();
		}
	}
	function formcarttj(){
		
		if(confirm("确认提交？")){
			$("#formtjtable").submit();
		}
	
	}
	function changeprice(){
	
	var money	=	0;
	var price	=	0;
	$(".backmoney").each(function(){
		price=$(this).val()-0;
		money=Number((money+price).toFixed(2));
	
	});
	
	$("#allprice").val(money);
	}	
	
	//	提交支付记录
	function addpaylog(id){
		var ordernum	=	"<?=$ordernum?>";
		var paymoney	=	$("#paymoney_"+id).val();
		var banknum	=	$("#banknum_"+id).val();
		var paytime	=	$("#paytime_"+id).val();
		var paytype	=	$("#paytype_"+id).val();
		var payremark	=	$("#payremark_"+id).val();
		$.ajax({
			data:{paymoney:paymoney,banknum:banknum,paytime:paytime,paytype:paytype,remark:payremark,ordernum:ordernum,id:id},
			url:"<?=$this->url('purchase/paylogtj')?>",
			dataType:"json",
			type:"post",
			success:function(r){
				if(r.state==1){
					alert("保存成功");
					 location.reload();
				}else{
					alert(r.info);
				}
			}
		
		});
	
	}
	//删除支付记录
	function delpaylog(id){
		$.ajax({
			data:{id:id},
			url:"<?=$this->url('purchase/delpaylog')?>",
			dataType:"json",
			type:"post",
			success:function(r){
				if(r.state==1){
					
					 location.reload();
				}else{
					alert(r.info);
				}
			}
		
		});
	
	}
</script>