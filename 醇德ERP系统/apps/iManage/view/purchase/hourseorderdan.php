<script language=javascript>history.go(-1);</script><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style>
			table{ border-collapse:collapse; border:1px black solid; margin:0 auto;}
			td{ border:1px black solid; height:20px}
		</style>
		<style type="text/css" media="print">.noprint { display:none;}</style>
		<script type="text/javascript" src="../resources/scripts/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../resources/scripts/my.js"></script>
		<script>
			function m_print(number){
				var queryString="number="+number+"&type="+"dayin_yes";
				send_request();
				http_request.open("POST","../action.php",true);
				http_request.onreadystatechange=function(){processrequest("dayin_yes","")};
				http_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
				http_request.send(queryString);
				javascript:window.print();
			}
		</script>
	</head>
	<body>
		<div id="main-content"> <!-- Main Content Section with everything -->
			<div class="clear"></div> <!-- End .clear -->
			<div class="content-box"><!-- Start Content Box -->
				<div class="content-box-content">
					<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
						<form action="../action.php" method="post" name="sure_m_orders">
						<input type="hidden" name="type" value="sure_m_orders">
						<input type="hidden" name="number" value="<?=$ordernum?>    ">
						<table style="width:100%;">
							<tbody>
																
										<tr><td width="150" align="right">订货日期：</td><td><?=date("Y-m-d",$order['created'])?></td></tr>
										<tr><td width="150" align="right">订单号码：</td><td><?=$ordernum?></td>
										<tr>
											<td width="150" align="right">出库类型：</td><td><?=$order['wstitle']?></td>
										</tr>
										
										<tr><td width="150" align="right">商品目录：</td>
											<td>
												<table style="width:100%;">
													<tbody>
														<tr>
															   <td style="font-size:12px;">商品名称</td>
															   
															   <td style="font-size:12px;">规格</td>
															   
															   <td style="font-size:12px;">保质期至</td>
															   <td style="font-size:12px;">数量</td>
															   <td style="font-size:12px;">重量</td>
															   <td style="font-size:12px;">应收金额</td>
															   	
														</tr>
													<?$weight=0;?>
													<?$num=0;?>
																						
															<?foreach($re as $key=>$value){?>	
																
															<tr>
																<td style="font-size:12px;"><?=$value['title']?></td>
																
																<td style="font-size:12px;"><?=$value['boxnum']?><?=$value['specs']?>/箱</td>
																
																<td style="font-size:12px;"><?if(empty($value['shelflife'])){echo '--';}else{echo date("Y-m-d",empty($value['productontime'])?time():$value['productontime']);}?></td>
																<?if($order['backstatus']!=6){$value['realbacknum']=0;}?>
																<td style="font-size:12px;"><?=$value['buynum']-$value['realbacknum']?>箱</td>
																
																<td style="font-size:12px;"><?=$value['weights']*($value['buynum']-$value['realbacknum'])?>kg</td>
																
																<td style="font-size:12px;"><?=$value['allprice']?>元</td>
																
																</tr>
																<?$weight+=$value['weights']*$value['buynum'];?>
																<?$num+=$value['buynum']-$value['realbacknum'];?>
																<?}?>
														       <tr>
															    <td style="font-size:12px;">合计</td>
															   <td style="font-size:12px;"></td>
															   <td style="font-size:12px;"></td>
															   <td style="font-size:12px;"><?=$num?>箱</td>
															   <td style="font-size:12px;"><?=$weight?>kg</td>
															   <td style="font-size:12px;"><?=$order['allprice']?>元</td>
                                                            </tr>
													</tbody>						
												</table>
										</td></tr>
											
											<tr><td width="150" align="right">加盟商信息：</td>
											<td>
											加盟商名称/电话：<?=$userinfo['suppname']?>/<?=$userinfo['supptel']?><br>
												加盟商类型：<?=$userinfo['supplytype']?><br>
												所属区域：<?=$userinfo['pname']?>省-<?=$userinfo['cname']?>市&nbsp;&nbsp;&nbsp;<br>
												地址：<?=$userinfo['address']?>&nbsp;&nbsp;&nbsp;
												<br>
												公司名称/电话：<?=$userinfo['commname']?>/<?=$userinfo['commtel']?>&nbsp;&nbsp;&nbsp;<br>
												
												负责人姓名/电话/邮箱：<?=$userinfo['truename']?>/<?=$userinfo['mobile']?>/<?=$userinfo['email']?>&nbsp;&nbsp;&nbsp;<br>
												业务联系人姓名/电话/邮箱：<?=$userinfo['proname']?>/<?=$userinfo['protel']?>/<?=$userinfo['proemail']?>&nbsp;&nbsp;&nbsp;<br>
												收货人姓名/电话/邮箱：<?=$userinfo['consigneename']?>/<?=$userinfo['consigneetel']?>/<?=$userinfo['consigneeemail']?>&nbsp;&nbsp;&nbsp;<br>
																								
											</td>
										</tr>
											<tr><td width="150" align="right">物流信息：</td>
											<td>
												物流公司：<?=empty($logistics['companystart'])?'':$logistics['companystart']?><br>
												发货日期：<?=empty($logistics['senddate'])?'':date('Y-m-d',$logistics['senddate'])?>&nbsp;&nbsp;&nbsp;
												预计到达：<?=empty($logistics['maybearrivedate'])?'':date('Y-m-d',$logistics['maybearrivedate'])?>&nbsp;&nbsp;&nbsp;
												<br>
												物流总运费：<?=empty($logistics['logisticscost'])?'':$logistics['logisticscost']?>&nbsp;&nbsp;&nbsp;
												
												货物总件数：<?=empty($logistics['goodsnum'])?'':$logistics['goodsnum']?>&nbsp;&nbsp;&nbsp;
												货物总重量：<?=empty($logistics['weight'])?'':$logistics['weight']?>&nbsp;&nbsp;&nbsp;
												物流单号：<?=empty($logistics['logisticsnumber'])?'':$logistics['logisticsnumber']?>&nbsp;&nbsp;&nbsp;
												物流车号：<?=empty($logistics['carnumber'])?'':$logistics['carnumber']?>												
											</td>
										</tr>
										<tr>
										<td width="150" align="right">备注信息：</td>
										<td>
										<table style="width:100%;">
													<tbody>
														<tr>
															   <td style="font-size:12px;">序号</td>
															   
															   <td style="font-size:12px;">审核人</td>
															   
															   <td style="font-size:12px;">审核</td>
															   <td style="font-size:12px;">备注</td>
															   <td style="font-size:12px;">审核时间</td>
														
															   	
														</tr>
											 <?
										foreach($log as $ks=>$value){
											?>
											<tr>
											<td style="font-size:12px;"><?=$ks+1?></td>
											<td style="font-size:12px;"><?=$value['truename']?></td>
											<td style="font-size:12px;"><?=$value['results']?></td>
											<td style="font-size:12px;"><?=$value['remark']?></td>	
											<td style="font-size:12px;"><?=date("Y-m-d H:i:s",$value['created'])?></td>					
											</tr>
											<?
												}
											?>
												</tbody>						
												</table>
										</td>
										</tr>
										</tbody>					
						</table>
						</form>
					</div>
				</div>
			</div>
							<div class="clear"><input type="button" onclick="javascript:window.print();" value="打印该订单" class="noprint" /></div>
						
					
		</div>
	</div>
	</body>
</html>