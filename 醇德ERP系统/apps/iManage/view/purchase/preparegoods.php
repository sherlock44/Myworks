<script language=javascript>history.go(-1);</script><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style>
			table{ border-collapse:collapse; border:1px black solid; margin:0 auto;}
			td{ border:1px black solid; height:20px}
		</style>
		<style type="text/css" media="print">.noprint { display:none;}</style>
	</head>
	<body>
		<div id="main-content"> <!-- Main Content Section with everything -->
			<div class="clear"></div> <!-- End .clear -->
			<div class="content-box"><!-- Start Content Box -->
				<div class="content-box-content">
					<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
						<form action="<?=$this->url('purchase/preparegoodstj')?>" method="post" name="sure_m_orders">
						<input type="hidden" name="type" value="changesl">
						<input type="hidden" name="number" value="20150619110920S">
						<input type="hidden" name="spid" value="331">
						<input type="hidden" name="sl" value="50">
						<input type="hidden" name="id" value="5764">
						<table style="width:100%;">
							<tbody>
								<tr>
								   <th style="font-size:12px;border:#666666 solid 1px;">商品名称</th>
								   <th style="font-size:12px;border:#666666 solid 1px;">商品条码</th>
								   <th style="font-size:12px;border:#666666 solid 1px;">保质期至</th>
								   <th style="font-size:12px;border:#666666 solid 1px;">装箱格格</th>
								   <th style="font-size:12px;border:#666666 solid 1px;">当前库存</th>
								   <th style="font-size:12px;border:#666666 solid 1px;">出库数量</th>
								</tr>
								<?foreach($res as $k=>$val){?>
									<tr>
									<?if($val['productontime']==0){$productontime=$val['productontime'];}else{$productontime=date("Y-m-d",$val['productontime']);}?>
												<th style="font-size:12px;border:#666666 solid 1px;"><?=$val['title']?></th>
												<th style="font-size:12px;border:#666666 solid 1px;"><?=$val['barcode']?></th>
												<th style="font-size:12px;border:#666666 solid 1px;"><?=empty($productontime)?"--":$productontime?></th>
												<th style="font-size:12px;border:#666666 solid 1px;"><?=$val['boxnum']?><?=$val['specs']?>/箱</th>
												<th style="font-size:12px;border:#666666 solid 1px;"><?=$val['goodsnumber']?>箱</th>
												<th style="font-size:12px;border:#666666 solid 1px;">
													<input type="text" name="asl[]" value="<?=empty($val['pnum'])?'':$val['pnum']?>"/>箱
													<input type="hidden" name="kc[]" value="<?=$val['goodsnumber']?>"/>	
													<input type="hidden" name="bzq[]" value="<?=$val['productontime']?>"/>
													<input type="hidden" name="goodsid" value="<?=empty($val['goodsid'])?0:$val['goodsid'];?>"/>
												</th>
									</tr>
								<?}?>		
								<input type="hidden" name="orderinfoid" value="<?=$id?>"/>
													
													<input type="hidden" name="ordernum" value="<?=$ordernum?>"/>
														
								<?if(!empty($res)){?>		
								<tr><th style="font-size:12px;border:#666666 solid 1px;" colspan="6">该商品的订购数量:<?=$info['num']?>箱。配货总数必须与订购数量一致</th></tr>
								<tr><th style="font-size:12px;border:#666666 solid 1px;" colspan="6"><input type="submit" value=" 保 存 "></th></tr>
								<?}?>
							</tbody>					
						</table>
						</form>
					</div>
				</div>
			</div>		
		</div>
	</div>
	</body>
</html>