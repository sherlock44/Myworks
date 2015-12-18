<?
$cfg_master['menu'] = array(

	// array(
	//       'title'=>'系统公告',

	//       'items'=>array(
	//           array(
	//               'title'=>'系统公告',
	//               'url'=>'system/sysNotice',
	//               'leftpos'=>0,
	//           ),

	//       )

	//   ),
	array(
		'title' => '采购管理',

		'items' => array(
			array(
				'title' => '在线挑选商品',
				'url' => 'purchase/apply',
				'leftpos' => 0,
			),
			array(
				'title' => '购物车列表',
				'url' => 'purchase/cartlist',
				'leftpos' => 1,
			),

			array(
				'title' => '未完成订单',
				'url' => 'purchase/orderconfirm',
				'leftpos' => 2,
			),
			array(
				'title' => '已完成订单',
				'url' => 'purchase/ordercomplete',
				'leftpos' => 3,
			),
			array(
				'title' => '已取消订单',
				'url' => 'purchase/ordercancel',
				'leftpos' => 4,
			),
		),

	),
	array(
		'title' => '收银统计',
		'items' => array(
			array(
				'title' => '会员统计',
				'url' => 'pos/userlist',
				'leftpos' => 0,
			),
			array(
				'title' => '收银统计',
				'url' => 'pos/cashier',
				'leftpos' => 1,
			),
			array(
				'title' => '库存情况',
				'url' => 'inventory/invenlist',
				'leftpos' => 2,
			),

		),

	),

	/*  array(
	'title'=>'退货管理',

	'items'=>array(

	array(
	'title'=>'退货管理',
	'url'=>'orderback/lists',
	'leftpos'=>2,
	),


	)


	array(
	'title'=>'POS统计',

	'items'=>array(
	array(
	'title'=>'会员统计',
	'url'=>'property/lists',
	'leftpos'=>0,
	),
	array(
	'title'=>'收银统计',
	'url'=>'property/lists',
	'leftpos'=>0,
	),
	)

	),


	array(
	'title'=>'库存概况',

	'items'=>array(
	array(
	'title'=>'库存概况',
	'url'=>'property/lists',
	'leftpos'=>0,
	),

	)

	),*/
	// array(
	//        'title'=>'个人资料',

	//        'items'=>array(

	//           array(
	//                'title'=>'个人资料',
	//                'url'=>'system/edit',
	//                'leftpos'=>2,
	//            ),

	//        )

	//    ),

);

return $cfg_master;