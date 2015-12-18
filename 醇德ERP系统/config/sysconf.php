<?php

	/*****采购流程菜单******/
	$sysconf['purchasestatus']	=	array(
									'-11'=>'采购已取消',
									'-10'=>'采购已取消',
									'-9'=>'采购已取消',
									'-8'=>'采购已取消',
									'-7'=>'采购已取消',
									'-6'=>'采购已取消',
									'-5'=>'采购已取消',
									'-4'=>'采购已取消',
									'-3'=>'采购已取消',
									'-2'=>'库房验收退回',
									'-1'=>'审批人退回',
									'0'=>'采购申请',
									'1'=>'审批人审核',
									'2'=>'制作采购计划',
									'3'=>'采购经理审核',
									'4'=>'提交合同',
									'5'=>'财务信息录入',
									'6'=>'制作验货单',
									'7'=>'库房验收',
									'8'=>'采购部门确认',
									'9'=>'财务核价',
									'10'=>'确认入库',
									'11'=>'已完成',
									);
		/*****采购流程邮件通知******/
	$sysconf['purchasestatusemail']	=	array(
									'2'=>'制作采购计划',
									'3'=>'采购经理审核',
									'5'=>'财务信息录入',
									'7'=>'库房验收',
									'9'=>'财务核价',
									'10'=>'确认入库',
									);								
	/*****采购流程菜单key为取消时订单的状态，value为采购流程取消的状态******/
	$sysconf['purchasestatuscansel']	=	array(
									'2'=>'-3',
									'3'=>'-4',
									'4'=>'-5',
									'5'=>'-6',
									'6'=>'-7',
									'7'=>'-8',
									'8'=>'-9',
									'9'=>'-10',
									'10'=>'-11',
									);

/*****采购入库流程菜单******/

	$sysconf['purchasestorestatus']	=	array(
									'0'=>'未提交',
									'1'=>'库房验收 ',
									'2'=>'采购确认 ',
									'3'=>'财务审核,待入库',
									'4'=>'已完成',
									);
	/*****采购类型******/								
	$sysconf['purchasetype']	=	array(
									'0'=>'新品采购',
									'1'=>'补货采购'
									);
	/*****系统内部角色******/								
	$sysconf['interrole']	=	array(
									'0'=>'总部角色',
									'1'=>'销售角色',
									'2'=>'财务角色',
									'3'=>'库房角色',
									'4'=>'采购角色',
									);
	/*****系统外部角色******/								
	$sysconf['outerrole']	=	array(
									'0'=>'加盟店',
									'1'=>'代理商',
									'2'=>'大客户',
									'3'=>'意向客户',
									'4'=>'供应商',
									'4'=>'物流商',
									);	
    $sysconf['typeone']   =  array(
                                     '0'=>'普通',
                                     '1'=>'冷链',
    	                            );	
	/*****退货订单流程******/								
	$sysconf['orderbackstatus']	=	array(
									'-1'=>'主管审批未通过',
									'0'=>'待确认订单',
									'1'=>'待主管审批',
									'2'=>'库管验货',
									'3'=>'业务经理复核',
									'4'=>'财务退款',
									'5'=>'库管入库',
									'6'=>'入库完成',
									);	
		/*****退货订单邮件通頟流程******/								
	$sysconf['orderbackstatusemail']	=	array(
									'2'=>'库管验货',
									'4'=>'财务退款',
									'5'=>'库管入库',
									);								
	/*****退货订单流程******/								
	$sysconf['orderbackstatusold']	=	array(
									'-1'=>'商品验收,退回',
									'0'=>'草稿',
									'1'=>'待主管审核',
									'2'=>'财务信息',
									'3'=>'商品验收',
									'4'=>'商品入库',
									'5'=>'财务结算',
									'6'=>'退货单已完成',
									);
	/*****商品出库流程******/
	$sysconf['storeout']	=	array(
									'-1'=>'退回',
									'0'=>'草稿',
									'1'=>'提交审核',
									'2'=>'制定出库单',
									'3'=>'出库结束',
									'4'=>'已完成',
									);									
	/******调拨入库流程******/
    $sysconf['diaobostatue'] = array(
    	                       			'0' => '调拨制定',
    	                       			'1' => '制定验货单',
    	                       			'2' => '财务审核,并锁定库房',
    	                       			'3' => '调拨单至调出库房',
    	                       			'4' => '库房配货',
    	                       			'5' => '库房核验',
    	                       			'6' => '物流录入',
    	                       			'7' => '库房核验失败',
    	                       			'8' => '入库确认',
    	                       			'9' => '确认收货',
    	                       			'10'=> '货物损坏',
    	                       			'11'=> '货物丢失',
    	                       			'12'=> '入库结束',
    	                            );
		/*****加盟商订货流程******/								
	$sysconf['orderstatus']	=	array(
									'-5'=>'无效订单,用户取消',
									'-4'=>'用户取消订单',
									'-4'=>'退款,取消订单',
									'-3'=>'订单未付款',
									'-2'=>'总部取消订单',
									'-1'=>'无效订单',
									'0'=>'待确认',
									'1'=>'待客审',
									'2'=>'待财审',
									'3'=>'备货中',
									'4'=>'已发货',
									'5'=>'已完成',
									);
			/*****加盟商订货邮件通頟流程******/								
	$sysconf['orderstatusemail']	=	array(
									'0'=>'待确认',
									'1'=>'待客审',
									'2'=>'待财审',
									'3'=>'备货中',
									);							
	/*****加盟商确认收货状态******/	
	$sysconf['franchiseeorderdonestatus']	=	array(
									'0'=>'确认收货',
									'1'=>'货物漏发',
									'2'=>'货物损坏',
									'3'=>'货物丢失',
	);	
			/*****角色对应的主页0主页，1菜单模板******/								
	$sysconf['rolemainmenu']	=	array(
									//'1'=>'main',
									//'2'=>'main',
									'7'=>'mainxiaoshao',
									'8'=>'maincaiwu',
									'9'=>'mainhouse',
									'10'=>'maincaigou',
									'29'=>'mainkefu',
									);


$sysconf['clientsource'] = array(
	'0' => '展会',
	'1' => '电话',
	'2' => '网络',
	'3' => '转介绍',
	'4' => '陌拜',
);

$sysconf['intention_type'] = array(
	'0' => '醇德超市',
	'1' => '啤酒坊',
	'2' => '产品代理',
	'3' => '商超采购',
);
//会员卡类型
$sysconf['cardType'] = array(
	'1' => '普通会员卡',
	'2' => '金卡',
	'3' => '银卡',
	'4' => '白金卡',
);
//创建赠送订单
$sysconf['freeorder'] = array(
	'1' => '选择商品',
	'2' => '审核购物车',
	'3' => '创建订单',
);
//代理级别对应的客户类型id
$sysconf['freeorderpricetype'] = array(
	'1' => '1',
	'2' => '2',
	'3' => '3',
	'4' => '4',
);
return $sysconf;
?>