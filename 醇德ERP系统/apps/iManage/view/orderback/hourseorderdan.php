
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
																
										<tr><td width="150" align="right">退货日期：</td><td><?=date("Y-m-d",$order['orderbackcreated'])?></td></tr>
										<tr><td width="150" align="right">退单号码：</td><td><?=$order['backordernum']?></td>
										<tr><td width="150" align="right">关联订单：</td><td><?=$ordernum?></td>
										
										<tr><td width="150" align="right">公司名称：</td><td><?=$userinfo['commname']?></td></tr>
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
															 
															   	
														</tr>
													<?$weight=0;?>
													<?$num=0;?>
																						
															<?foreach($re as $key=>$value){?>	
																
															<tr>
																<td style="font-size:12px;"><?=$value['title']?></td>
																
																<td style="font-size:12px;"><?=$value['boxnum']?><?=$value['specs']?>/箱</td>
																
																<td style="font-size:12px;"><?if(empty($value['shelflife'])){echo '--';}else{echo date("Y-m-d",empty($value['productontime'])?time():$value['productontime']);}?></td>
																
																<td style="font-size:12px;"><?=$value['realbacknum']?>箱</td>
																
																<td style="font-size:12px;"><?=$value['weight']*$value['buynum']*$value['boxnum']/1000?>kg</td>
																
																
																
																</tr>
																<?$weight+=$value['weight']*$value['realbacknum']*$value['boxnum'];?>
																<?$num+=$value['realbacknum'];?>
														<?}?>
														       <tr>
                                                            	<td colspan="3" style="color:#00F;font-size:12px;" align="right">合计</td>
                                                                <td style="font-size:12px;"><?=$num?>箱</td>
                                                                <td style="font-size:12px;"><?=$weight/1000?>kg</td>
																
																
                                                            </tr>
													</tbody>						
												</table>
										</td></tr>
											
										
										<tr>
										<td width="150" align="right">备注信息：</td>
										<td><?=empty($order['orderbackremark'])?'':$order['orderbackremark']?></td>
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