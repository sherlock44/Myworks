<?php
/**
 * 系统配置文件
 * author:David Yan (yanwd@ivysoft.com.cn)
 * @version $Id: global.php  2012-01-21 23:00:00Z David Yan $
 *
 */
$posapiconf['cardType'] = array(
	'0' => '普通会员卡',
	'1' => '金卡',
	'2' => '银卡',
	'3' => '白金卡',
);
$posapiconf['sportOrderStatus'] = array(
	'-1' => '已取消',
	'0' => '未完成',
	'1' => '已完成',
);
$posapiconf['bookingOrderStatus'] = array(
	'0' => '未付款',
	'1' => '已付款',
	'2' => '未发货',
	'3' => '已发货',
	'4' => '已收货',
	'5' => '已完成',
);
/*****商品出库流程******/
/*****退货订单流程******/
$posapiconf['orderbackstatus'] = array(
	'-1' => '商品验收,退回',
	'0' => '草稿',
	'1' => '待审核',
	'2' => '财务信息',
	'3' => '商品验收',
	'4' => '商品入库',
	'5' => '财务结算',
	'6' => '退货单已完成',
);
/*****加盟商订货流程******/
$posapiconf['orderstatus'] = array(
	'-1' => '无效订单',
	'0' => '待确认单',
	'1' => '未付款订单',
	'2' => '已付款订单',
	'3' => '未发货订单',
	'4' => '已发货订单',
	'5' => '已完成订单',
);
return $posapiconf;
?>