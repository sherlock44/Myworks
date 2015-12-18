<?
$cfg_master['menu'] =  array(
    array(
        'title'=>'系统基础设置',

        'items'=>array(
		   array(
				'title'=>'SMTP设置',
				'url'=>'system/smtp',
				'leftpos'=>1,
            ),
           array(
                'title'=>'系统用户管理',
                'url'=>'system/admin',
                'leftpos'=>2,
            ),

           array(
                'title'=>'角色管理',
                'url'=>'system/role',
                'leftpos'=>3,
            ),
		    array(
                'title'=>'后台菜单',
                'url'=>'system/menu',
                'leftpos'=>4,
            ),
            /* array(
                'title'=>'短信接口设置',
                'url'=>'system/message',
                'leftpos'=>6,
            ),  */
           /*  array(
                'title'=>'系统清空',
                'url'=>'system/message',
                'leftpos'=>7,
            ),  */
        )

    ),
      array(
        'title'=>'ERP参数设置',

       'items'=>array(
	    array(
                'title'=>'客户类型',
                'url'=>'user/usertype',
                'leftpos'=>2,
            ),

           array(
                'title'=>'供应商类型',
                'url'=>'user/supplytype',
                'leftpos'=>4,
            ),
	        array(
                'title'=>'入库设置',
                'url'=>'preferences/storage',

                'leftpos'=>0,
            ),
             array(
                'title'=>'出库设置',
                'url'=>'preferences/storageout',

                'leftpos'=>1,
            ),
         /*   array(
                'title'=>'入库类型设置',
                'url'=>'preferences/storagetype',
                'leftpos'=>2,
            ),
			array(
                'title'=>'出库类型设置',
                'url'=>'preferences/storagetypeout',
                'leftpos'=>3,
            ),   */
            array(
                'title'=>'收款方式',
                'url'=>'financial/paytype',
                'leftpos'=>4,
            ),
			array(
                'title'=>'付款方式',
                'url'=>'financial/paytypeout',
                'leftpos'=>5,
            ),
			array(
                'title'=>'库房设置',
                'url'=>'preferences/house',
                'leftpos'=>6,
            ),

            )
        ),
     array(
        'title'=>'用户管理',
        'items'=>array(
            /* array(
                'title'=>'用户管理',
                'url'=>'user/lists',
                'leftpos'=>0,
            ), */
           array(
                'title'=>'加盟商管理',
                'url'=>'user/franchisee',
                'leftpos'=>1,
            ),
          array(
                'title'=>'意向客户管理',
                'url'=>'user/customer',
                'leftpos'=>3,
            ),
			array(
                'title'=>'我的客户管理',
                'url'=>'user/franchisee',
                'leftpos'=>1,
            ),
           array(
                'title'=>'客户类型管理',
                'url'=>'user/usertype',
                'leftpos'=>2,
            ),



            /* array(
                 'title'=>'物流商',
                 'url'=>'user/institution',
                 'leftpos'=>6,
             ), 	 */
        )

    ),

        array(
        'title'=>'加盟商订货',

            'items'=>array(
			array(
                'title'=>'待确认订单',
                'url'=>'purchasesr/orderconfirm',
                'leftpos'=>3,
            ),
			array(
                'title'=>'待客审订单',
                'url'=>'purchase/orderconfirm',
                'leftpos'=>2,
            ),

			array(
                'title'=>'待财审订单',
                'url'=>'purchase/frorder',
                'leftpos'=>4,
            ),
			array(
                'title'=>'库房管理',
                'url'=>'purchase/hourseorder',
                'leftpos'=>4,
            ),
			/* array(
                'title'=>'无效订单',
                'url'=>'purchase/ordercancel',
                'leftpos'=>8,
            ),	 */
        )

    ),
      array(
        'title'=>'商品管理',

        'items'=>array(
            array(
                'title'=>'商品类型',
                'url'=>'goods/category',
                'leftpos'=>0,
            ),
			array(
                'title'=>'商品品牌',
                'url'=>'goods/brand',
                'leftpos'=>1,
            ),
            array(
                'title'=>'单品管理',
                'url'=>'goods/lists',
                'leftpos'=>2,
            ),
            array(
                'title'=>'回收站',
                'url'=>'goods/del_lists',
                'leftpos'=>3,
            ),

        )


    ),
	array(
        'title'=>'采购管理',
        'items'=>array(
           /* array(
                'title'=>'采购申请',
                'url'=>'cash/apply',
                'leftpos'=>0,
            ),  */
			array(
                'title'=>'采购申请',
                'url'=>'newcash/apply',
                'leftpos'=>0,
            ),

             array(
                'title'=>'调拨入库',
                'url'=>'cash/bank',
                'leftpos'=>3,
            ),
             array(
                'title'=>'出库管理',
                'url'=>'storeout/apply',
                'leftpos'=>4,
            ),

        )

    ),
	array(
        'title'=>'通用模块',
        'items'=>array(
			array(
                'title'=>'邮件推送',
                'url'=>'General/sendmail',
                'leftpos'=>1,
            ),
            /*
			array(
                'title'=>'短信推送',
                'url'=>'log/user',
                'leftpos'=>4,
            ),
            */
			array(
                'title'=>'站内信息',
                'url'=>'General/statWithinfo',
                'leftpos'=>5,
            ),
            /*
			array(
                'title'=>'报表管理',
                'url'=>'log/user',
                'leftpos'=>6,
            ),
            */
			array(
                'title'=>'个人资料',
                'url'=>'General/user',
                'leftpos'=>7,
            ),
            /*
			array(
                'title'=>'业务考试',
                'url'=>'General/busiTest',
                'leftpos'=>8,
            ),
            */
			/* array(
                'title'=>'宣传资料',
                'url'=>'General/TouristBrochure',
                'leftpos'=>9,
            ),
			array(
                'title'=>'相关文档',
                'url'=>'General/documents',
                'leftpos'=>10,
            ), */
			 array(
                'title'=>'文件管理',
                'url'=>'General/filemanage',
                'leftpos'=>10,
            ),
			array(
                'title'=>'物流管理',
                'url'=>'General/generalhome',
                'leftpos'=>11,
            ),
        )

    ),
	array(
        'title'=>'预警管理',

        'items'=>array(

           array(
                'title'=>'库存预警',
                'url'=>'earlywarning/Inventory',
                'leftpos'=>1,
            ),
              array(
                'title'=>'临期预警',
                'url'=>'earlywarning/Beoverdue',
                'leftpos'=>2,
            ),
            /* array(
                'title'=>'采购预警',
                'url'=>'cash/bank',
                'leftpos'=>3,
            ),      */
           /*  array(
                'title'=>'费用预警',
                'url'=>'cash/bank',
                'leftpos'=>3,
            ), 	*/
        )

    ),
       array(
        'title'=>'库存管理',
        'items'=>array(
           array(
                'title'=>'到货计划管理',
                'url'=>'log/ruku',
                'leftpos'=>4,
            ),
            array(
                'title'=>'当前库存管理',
                'url'=>'stock/goodslists',
                'leftpos'=>5,
            ),
			array(
                'title'=>'临期库存管理',
                'url'=>'log/sysLog',
                'leftpos'=>0,
            ),
        )
    ),

    array(
        'title'=>'财务管理',

        'items'=>array(
           /*  array(
                'title'=>'应收账款',
                'url'=>'Financialaffairs/handle',
                'leftpos'=>0,
            ),

              array(
                'title'=>'应付账款',
                'url'=>'Financialaffairs/Tocopewith',
                'leftpos'=>1,
            ),

             array(
                'title'=>'收款记录',
                'url'=>'Financialaffairs/orderpay',
                'leftpos'=>2,
            ),  */
           /* array(
                'title'=>'付款记录',
                'url'=>'Financialaffairs/fukuan',
                'leftpos'=>2,
            ), */
			array(
                'title'=>'银行账户管理',
                'url'=>'Financialaffairs/banklist',
                'leftpos'=>1,
            ),
            array(
                'title'=>'加盟商信用管理',
                'url'=>'Financialaffairs/creditManage',
                'leftpos'=>1,
            ),
        )

    ),
	   array(
        'title'=>'日志管理',

        'items'=>array(
            array(
                'title'=>'订货操作日志',
                'url'=>'log/purchaseorder',
                'leftpos'=>4,
            ),
              array(
                'title'=>'退货操作日志',
                'url'=>'log/backorder',
                'leftpos'=>5,
            ),
          /*  array(
                'title'=>'入库记录',
                'url'=>'log/ruku',
                'leftpos'=>4,
            ),
              array(
                'title'=>'出库记录',
                'url'=>'log/chuku',
                'leftpos'=>5,
            ), */
            /*
             array(
                'title'=>'盘点记录',
                'url'=>'cash/bank',
                'leftpos'=>6,
            ),
            */
           /*  array(
                'title'=>'已锁定库存记录',
                'url'=>'cash/bank',
                'leftpos'=>3,
            ), 	*/
        /*
            array(
                'title'=>'调差记录',
                'url'=>'cash/bank',
                'leftpos'=>3,
            ),
            */
			array(
                'title'=>'系统日志',
                'url'=>'log/sysLog',
                'leftpos'=>0,
            ),
            array(
                'title'=>'系统备份',
                'url'=>'log/sysBack',
                'leftpos'=>1,
            ),

           /*  array(
                'title'=>'系统还原',
                'url'=>'log/dataredue',
                'leftpos'=>2,
            ), 		*/
        )

    ),
	    array(
        'title'=>'会员卡管理',

        'items'=>array(
            array(
                'title'=>'会员卡列表',
                'url'=>'card/cardlist',
                'leftpos'=>0,
            ),

           /* array(
                'title'=>'生成会员卡类型',
                'url'=>'card/cardtype',
                'leftpos'=>1,
            ), */
            array(
                'title'=>'批量生成会员卡',
                'url'=>'card/batchcard',
                'leftpos'=>2,
            ),
           /*  array(
                'title'=>'分发会员卡',
                'url'=>'card/sendcard',
                'leftpos'=>3,
            ),  */
            array(
                'title'=>'加盟店关联',
                'url'=>'card/crmrelated',
                'leftpos'=>4,
            ),
             array(
                'title'=>'会员卡折扣',
                'url'=>'card/carddiscount',
                'leftpos'=>5,
            ),

        )

    ),
	array(
        'title'=>'退货管理',
        'items'=>array(
         array(
                'title'=>'选择退货单',
                'url'=>'orderback/canbackorder',
                'leftpos'=>1,
            ),
            array(
                'title'=>'待处理订单',
                'url'=>'orderback/lists',
                'leftpos'=>1,
            ),
           	array(
                'title'=>'库房核验订单',
                'url'=>'orderback/orderhouselists',
                'leftpos'=>1,
            ),
          	array(
                'title'=>'待财审订单',
                'url'=>'orderback/caiwulists',
                'leftpos'=>1,
            ),
        )

    ),
);


return $cfg_master;