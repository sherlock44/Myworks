-- 表的结构：cloud_api --
CREATE TABLE `cloud_api` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：cloud_api_role --
CREATE TABLE `cloud_api_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apiid` int(10) NOT NULL,
  `roleid` int(10) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：cloud_productgoods --
CREATE TABLE `cloud_productgoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `costprice` decimal(11,0) NOT NULL,
  `name` varchar(256) NOT NULL,
  `keyword` varchar(20) NOT NULL,
  `price` decimal(65,0) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `star` int(11) NOT NULL,
  `discount` int(5) NOT NULL,
  `created` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `is_recommend` int(11) NOT NULL,
  `is_promotion` int(11) NOT NULL,
  `brandid` int(11) NOT NULL,
  `area` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：cloud_productprofile --
CREATE TABLE `cloud_productprofile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsid` int(10) NOT NULL,
  `key` varchar(500) NOT NULL,
  `value` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：cloud_token --
CREATE TABLE `cloud_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `crm_memberid` int(11) NOT NULL,
  `crm_membername` varchar(255) NOT NULL,
  `token` varchar(50) NOT NULL,
  `created` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：cms_category --
CREATE TABLE `cms_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(222) NOT NULL COMMENT '????',
  `keys` varchar(200) DEFAULT NULL COMMENT '???????????',
  `parentid` int(11) NOT NULL COMMENT '????id',
  `paths` varchar(100) DEFAULT NULL COMMENT '??id??(?????,????ID????????????)',
  `intro` varchar(500) DEFAULT NULL COMMENT '????',
  `sort` int(5) DEFAULT '999' COMMENT '??',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：cms_info --
CREATE TABLE `cms_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(254) NOT NULL COMMENT '????',
  `thumbimage` varchar(254) DEFAULT NULL COMMENT '??',
  `click` varchar(254) DEFAULT NULL COMMENT '????',
  `categoryid` int(11) DEFAULT NULL COMMENT '??id',
  `content` text COMMENT '??',
  `status` tinyint(1) DEFAULT NULL COMMENT '???0.????1.????',
  `created` int(10) DEFAULT NULL COMMENT '????',
  `isindex` int(1) DEFAULT '0' COMMENT '???????0? 1?',
  `top` int(1) DEFAULT '0' COMMENT '???? 0?? 1???',
  `publishtime` int(10) DEFAULT NULL COMMENT '????',
  `introduction` varchar(300) DEFAULT NULL COMMENT '????',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：comm_arearegion --
CREATE TABLE `comm_arearegion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL,
  `name` varchar(11) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：comm_customerservice --
CREATE TABLE `comm_customerservice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_typeid` int(10) NOT NULL,
  `member_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `member_name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `reply_content` text NOT NULL,
  `replay_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：comm_customerservicetype --
CREATE TABLE `comm_customerservicetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cst_name` varchar(255) NOT NULL,
  `cst_info` text NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：comm_payment --
CREATE TABLE `comm_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_code` varchar(20) NOT NULL,
  `payment_namee` varchar(20) NOT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `payment_config` varchar(255) DEFAULT NULL,
  `payment_state` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：comm_task --
CREATE TABLE `comm_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `points` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：comm_upload --
CREATE TABLE `comm_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(258) NOT NULL,
  `file_thumb` varchar(256) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `file_size` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：comm_waybill --
CREATE TABLE `comm_waybill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `waybill_name` varchar(50) NOT NULL,
  `waybill_image` varchar(50) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `express_id` int(10) NOT NULL,
  `express_name` varchar(50) NOT NULL,
  `reply_id` int(11) NOT NULL,
  `reply_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：crm_associate --
CREATE TABLE `crm_associate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) NOT NULL,
  `account_managerid` int(11) NOT NULL,
  `remark` varchar(254) NOT NULL,
  `tips` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：crm_channel --
CREATE TABLE `crm_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channels_name` varchar(255) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `operation_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：crm_companyinfo --
CREATE TABLE `crm_companyinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) NOT NULL,
  `provinceid` int(5) NOT NULL,
  `cityid` int(5) NOT NULL,
  `areaid` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：crm_franchisee --
CREATE TABLE `crm_franchisee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password truename` varchar(100) NOT NULL,
  `truename` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `provinceid` int(11) NOT NULL,
  `cityid` int(11) NOT NULL,
  `areaid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `openid` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：crm_invoice --
CREATE TABLE `crm_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `inv_state` enum('1','2') DEFAULT NULL,
  `inv_title` varchar(50) DEFAULT NULL,
  `inv_content` varchar(10) DEFAULT NULL,
  `inv_company` varchar(50) DEFAULT NULL,
  `inv_code` varchar(50) DEFAULT NULL,
  `inv_reg_addr` varchar(50) DEFAULT NULL,
  `inv_reg_phone` varchar(15) DEFAULT NULL,
  `inv_reg_bname` varchar(30) DEFAULT NULL,
  `inv_reg_baccount` varchar(30) DEFAULT NULL,
  `inv_rec_name` varchar(30) DEFAULT NULL,
  `inv_rec_mobphone` varchar(30) DEFAULT NULL,
  `inv_rec_province` varchar(30) DEFAULT NULL,
  `inv_goto_addr` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：crm_member --
CREATE TABLE `crm_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_managerid` int(11) NOT NULL,
  `source` varchar(256) NOT NULL,
  `intent` text NOT NULL,
  `status` int(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(11) DEFAULT '0' COMMENT '????',
  `mobile` varchar(254) DEFAULT NULL COMMENT '????',
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：crm_personnel --
CREATE TABLE `crm_personnel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) NOT NULL,
  `roleid` int(11) NOT NULL,
  `position` varchar(254) NOT NULL,
  `landline` varchar(254) NOT NULL,
  `address` varchar(256) NOT NULL,
  `qq` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：crm_receiving --
CREATE TABLE `crm_receiving` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) NOT NULL,
  `communication` varchar(256) NOT NULL,
  `Receiver` varchar(256) NOT NULL,
  `address` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：crm_supplier --
CREATE TABLE `crm_supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(100) NOT NULL,
  `password` varchar(11) NOT NULL,
  `title` varchar(254) DEFAULT NULL COMMENT '?????',
  `name` varchar(11) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `remark` varchar(1024) DEFAULT NULL COMMENT '??',
  `type` int(11) DEFAULT '0' COMMENT '?????',
  `provinceid` int(11) NOT NULL,
  `cityid` int(11) NOT NULL,
  `areaid` int(11) NOT NULL,
  `address` varchar(254) NOT NULL,
  `settled` decimal(10,0) NOT NULL,
  `unsettled` decimal(10,0) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：crm_supplytype --
CREATE TABLE `crm_supplytype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `remark` varchar(1024) DEFAULT NULL COMMENT '??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：crm_usertype --
CREATE TABLE `crm_usertype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `remark` varchar(1024) DEFAULT NULL COMMENT '??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：financial_cardtype --
CREATE TABLE `financial_cardtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(254) DEFAULT NULL COMMENT '??',
  `uuid` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：financial_paytype --
CREATE TABLE `financial_paytype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(254) DEFAULT NULL COMMENT '??',
  `type` tinyint(2) DEFAULT '0' COMMENT '0?????1????',
  `status` tinyint(2) DEFAULT '0' COMMENT '0???1??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：financial_synctype --
CREATE TABLE `financial_synctype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(254) DEFAULT NULL COMMENT '??',
  `keytype` varchar(254) DEFAULT NULL,
  `updateid` varchar(254) DEFAULT NULL COMMENT '?????id?uuid??????',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：franchisee_alliance --
CREATE TABLE `franchisee_alliance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(254) NOT NULL COMMENT '?????',
  `token` varchar(100) DEFAULT NULL COMMENT '??????',
  `mobile` varchar(20) DEFAULT NULL COMMENT '????',
  `password` varchar(100) DEFAULT NULL COMMENT '??',
  `truename` varchar(100) DEFAULT NULL COMMENT '????',
  `codenum` varchar(50) DEFAULT NULL COMMENT '????',
  `proviceid` int(11) DEFAULT '0' COMMENT '?id',
  `cityid` int(11) DEFAULT '0' COMMENT '?id',
  `areaid` int(11) DEFAULT NULL,
  `address` varchar(1024) DEFAULT NULL COMMENT '??',
  `status` tinyint(1) DEFAULT '0' COMMENT '0????1???',
  `created` int(11) DEFAULT NULL,
  `opentime` int(11) DEFAULT NULL COMMENT '????',
  `remark` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：franchisee_card --
CREATE TABLE `franchisee_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(254) DEFAULT NULL,
  `cardnum` varchar(100) DEFAULT NULL COMMENT '??',
  `token` varchar(100) DEFAULT NULL COMMENT '???????',
  `password` varchar(100) DEFAULT NULL COMMENT '??',
  `cardtype` tinyint(2) DEFAULT NULL COMMENT '?????id',
  `truename` varchar(100) DEFAULT NULL COMMENT '????',
  `mobile` varchar(50) DEFAULT NULL COMMENT '??',
  `expirationtime` int(11) DEFAULT NULL COMMENT '????',
  `birthdaytime` varchar(50) DEFAULT NULL COMMENT '??',
  `address` varchar(1024) DEFAULT NULL COMMENT '????',
  `remark` varchar(1024) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0' COMMENT '0????1????2???',
  `opentime` int(11) DEFAULT NULL COMMENT '????',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=474 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：franchisee_carddiscount --
CREATE TABLE `franchisee_carddiscount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cardid` int(11) DEFAULT NULL COMMENT '?????id',
  `created` int(11) DEFAULT NULL COMMENT '????',
  `discount` int(10) DEFAULT '0' COMMENT '?????? ',
  `updatetime` int(11) DEFAULT NULL COMMENT '????',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：franchisee_cardtype --
CREATE TABLE `franchisee_cardtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(100) DEFAULT NULL,
  `title` varchar(254) DEFAULT NULL COMMENT '??',
  `uuid` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：franchisee_category --
CREATE TABLE `franchisee_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(100) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL COMMENT '??',
  `parentuuid` varchar(100) DEFAULT NULL COMMENT '??uuid',
  `sort` int(10) DEFAULT '0',
  `remark` varchar(1024) DEFAULT NULL COMMENT '??',
  `tag` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：franchisee_log --
CREATE TABLE `franchisee_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(100) DEFAULT NULL COMMENT '??????',
  `content` varchar(1022) DEFAULT NULL COMMENT '????',
  `created` int(11) DEFAULT NULL,
  `type` tinyint(2) DEFAULT '0' COMMENT '?? 1????',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：franchisee_order --
CREATE TABLE `franchisee_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(254) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL COMMENT '???????',
  `ordernum` varchar(100) DEFAULT NULL COMMENT '????',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '??',
  `lossprice` decimal(10,2) DEFAULT '0.00' COMMENT '???',
  `status` tinyint(2) DEFAULT '0' COMMENT '?? 0 ?????1????2????3????',
  `created` int(11) DEFAULT NULL COMMENT '????',
  `remark` varchar(1024) DEFAULT NULL COMMENT '??',
  `issync` tinyint(2) DEFAULT '0' COMMENT '0????1???',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：franchisee_ordercart --
CREATE TABLE `franchisee_ordercart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(100) DEFAULT NULL COMMENT '???????',
  `goodsid` int(11) DEFAULT '0',
  `num` int(11) DEFAULT '0' COMMENT '??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：franchisee_orderinfo --
CREATE TABLE `franchisee_orderinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordernum` varchar(254) DEFAULT NULL COMMENT '????',
  `num` varchar(100) DEFAULT NULL COMMENT '??',
  `goodsid` int(11) DEFAULT '0' COMMENT '??id',
  `price` decimal(10,2) DEFAULT '0.00',
  `lossnum` int(11) DEFAULT '0' COMMENT '????',
  `status` tinyint(2) DEFAULT '1' COMMENT '0?? 1??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：franchisee_product --
CREATE TABLE `franchisee_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(100) DEFAULT NULL,
  `uuid` varchar(100) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL COMMENT '???',
  `title` varchar(100) DEFAULT NULL COMMENT '????',
  `imgpath` varchar(100) DEFAULT NULL COMMENT '????',
  `categoryuuid` varchar(100) DEFAULT NULL COMMENT '??uuID',
  `pingyincode` varchar(100) DEFAULT NULL COMMENT '???',
  `supplier` varchar(254) DEFAULT NULL COMMENT '???',
  `shelflife` int(11) DEFAULT NULL COMMENT '???',
  `costprice` decimal(10,2) DEFAULT '0.00' COMMENT '???',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '???',
  `number` int(10) DEFAULT '0' COMMENT '??',
  `maxnumber` int(10) DEFAULT '0' COMMENT '????',
  `minnumber` int(10) DEFAULT '0' COMMENT '????',
  `status` tinyint(2) DEFAULT '0' COMMENT '?? 0 ?? 1??',
  `isdiscount` tinyint(2) DEFAULT '0' COMMENT '0??? 1??',
  `remark` varchar(1024) DEFAULT NULL COMMENT '??',
  `discountprice` decimal(10,2) DEFAULT '0.00' COMMENT '??????',
  `issync` tinyint(2) DEFAULT '0' COMMENT '0?????1???',
  `productiontime` int(11) DEFAULT NULL COMMENT '????',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：franchisee_productontime --
CREATE TABLE `franchisee_productontime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsuuid` varchar(100) DEFAULT NULL COMMENT '??',
  `productontime` int(11) DEFAULT NULL COMMENT '????',
  `num` int(11) DEFAULT '0' COMMENT '??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：franchisee_summary --
CREATE TABLE `franchisee_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(100) DEFAULT NULL COMMENT '??????',
  `workeruuid` varchar(100) DEFAULT NULL COMMENT '??uuid',
  `workercode` varchar(100) DEFAULT NULL COMMENT '????',
  `workername` varchar(100) DEFAULT NULL COMMENT '????',
  `codenum` varchar(100) DEFAULT NULL COMMENT '????',
  `mobile` varchar(20) DEFAULT NULL,
  `allordernum` int(11) DEFAULT '0' COMMENT '????',
  `allprice` decimal(10,2) DEFAULT '0.00' COMMENT '???',
  `allsaleprice` decimal(10,2) DEFAULT '0.00' COMMENT '????',
  `cashpaymoney` decimal(10,2) DEFAULT '0.00' COMMENT '?????',
  `unionpaymoney` decimal(10,2) DEFAULT '0.00' COMMENT '?????',
  `linepaymoney` decimal(10,2) DEFAULT '0.00' COMMENT '?????',
  `storepaymoney` decimal(10,2) DEFAULT '0.00' COMMENT '?????',
  `rechargemoney` decimal(10,2) DEFAULT '0.00' COMMENT '?????',
  `rechargegive` decimal(10,2) DEFAULT '0.00' COMMENT '????',
  `cardnum` int(11) DEFAULT '0' COMMENT '????',
  `unionpaycard` decimal(10,2) DEFAULT '0.00' COMMENT '????????',
  `cashpaycard` decimal(10,2) DEFAULT '0.00' COMMENT '???????',
  `starttime` int(11) DEFAULT NULL COMMENT '????',
  `endtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：franchisee_userorder --
CREATE TABLE `franchisee_userorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(254) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL COMMENT '???????',
  `ordernum` varchar(100) DEFAULT NULL COMMENT '????',
  `price` decimal(10,2) DEFAULT '0.00',
  `orderstatus` tinyint(2) DEFAULT '0' COMMENT '?? 0 ?????1????2????3????',
  `ordertype` tinyint(2) DEFAULT '0' COMMENT '????',
  `useruuid` varchar(254) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL COMMENT '??',
  `usermobile` varchar(20) DEFAULT NULL COMMENT '??',
  `userprovinceid` int(11) DEFAULT '0' COMMENT '?id',
  `usercityid` int(11) DEFAULT '0',
  `userareaid` int(11) DEFAULT '0' COMMENT '??id',
  `address` varchar(1000) DEFAULT NULL COMMENT '??',
  `created` int(11) DEFAULT NULL COMMENT '????',
  `remark` varchar(1024) DEFAULT NULL COMMENT '??',
  `paystatus` tinyint(2) DEFAULT '0' COMMENT '0??? 1???',
  `paytype` tinyint(2) DEFAULT '0' COMMENT '????',
  `carduuid` varchar(254) DEFAULT NULL COMMENT '???uuid',
  `issync` tinyint(2) DEFAULT '0' COMMENT '0?????1???',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：franchisee_userorderinfo --
CREATE TABLE `franchisee_userorderinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userorderuuid` varchar(254) DEFAULT NULL COMMENT '??uuid',
  `num` varchar(100) DEFAULT NULL COMMENT '??',
  `costprice` decimal(10,2) DEFAULT '0.00' COMMENT '???',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '???',
  `saleprice` decimal(10,2) DEFAULT '0.00' COMMENT '????',
  `discount` varchar(50) DEFAULT '1' COMMENT '??',
  `productuuid` varchar(254) DEFAULT NULL COMMENT '??uuid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：franchisee_worker --
CREATE TABLE `franchisee_worker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(100) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL COMMENT '??????',
  `workercode` varchar(100) DEFAULT NULL COMMENT '????',
  `password` varchar(100) DEFAULT NULL COMMENT '??',
  `truename` varchar(100) DEFAULT NULL COMMENT '????',
  `mobile` varchar(20) DEFAULT NULL,
  `codenum` varchar(50) DEFAULT NULL COMMENT '????',
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：pos_log --
CREATE TABLE `pos_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `market_id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `operation` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_apply --
CREATE TABLE `product_apply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(254) DEFAULT NULL,
  `title` varchar(500) NOT NULL,
  `memberid` int(10) NOT NULL,
  `zgid` int(11) DEFAULT '0' COMMENT '????Id',
  `cgfzrid` int(11) NOT NULL,
  `supplyid` int(11) NOT NULL DEFAULT '0' COMMENT '???',
  `status` int(11) NOT NULL,
  `remark` text NOT NULL COMMENT '??',
  `type` int(1) NOT NULL,
  `sendtime` int(11) DEFAULT NULL COMMENT '????',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '????',
  `inspectionstandard` text COMMENT '????',
  `filename` varchar(200) DEFAULT NULL COMMENT '????',
  `filepath` varchar(100) DEFAULT NULL COMMENT '????',
  `ispaydeposit` tinyint(2) DEFAULT '0' COMMENT '??????0??1??',
  `deposit` decimal(10,2) DEFAULT '0.00' COMMENT '????',
  `isback` tinyint(2) DEFAULT '2' COMMENT '1???2?????????????',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_brand --
CREATE TABLE `product_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(254) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `intro` varchar(500) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `created` int(11) NOT NULL,
  `sort` int(11) DEFAULT '0' COMMENT '??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_check --
CREATE TABLE `product_check` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applyid` int(10) NOT NULL,
  `memberid` int(10) NOT NULL,
  `status` int(2) NOT NULL,
  `tips` varchar(256) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_comfirm --
CREATE TABLE `product_comfirm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `infoid` int(11) NOT NULL,
  `operateid` int(10) NOT NULL,
  `tips` text NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_discount --
CREATE TABLE `product_discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(11,0) NOT NULL,
  `productid` int(11) NOT NULL,
  `startat` int(11) NOT NULL,
  `endat` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_distributionorder --
CREATE TABLE `product_distributionorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_wms_distributionid` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_earnest --
CREATE TABLE `product_earnest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `infoid` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_goods --
CREATE TABLE `product_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(100) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL COMMENT '???',
  `title` varchar(100) DEFAULT NULL COMMENT '????',
  `imgpath` varchar(100) DEFAULT NULL COMMENT '????',
  `categoryuuid` varchar(254) DEFAULT NULL COMMENT '??uuID',
  `branduuid` varchar(254) DEFAULT NULL,
  `pingyincode` varchar(100) DEFAULT NULL COMMENT '???',
  `supplier` varchar(254) DEFAULT NULL COMMENT '???',
  `shelflife` int(11) DEFAULT NULL COMMENT '???',
  `costprice` decimal(10,2) DEFAULT '0.00' COMMENT '???',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '???',
  `franchiseeprice` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '?????',
  `number` int(10) DEFAULT '0' COMMENT '??',
  `maxnumber` int(10) DEFAULT '0' COMMENT '????',
  `minnumber` int(10) DEFAULT '0' COMMENT '????',
  `status` tinyint(2) DEFAULT '0' COMMENT '?? 0 ?? 1??',
  `isdiscount` tinyint(2) DEFAULT '0' COMMENT '0??? 1??',
  `remark` varchar(1024) DEFAULT NULL COMMENT '??',
  `discountprice` decimal(10,2) DEFAULT '0.00' COMMENT '??????',
  `numberone` int(10) DEFAULT NULL,
  `beoverdue` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_goodsbath --
CREATE TABLE `product_goodsbath` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsuuid` varchar(254) NOT NULL,
  `num` int(10) NOT NULL DEFAULT '0' COMMENT '????',
  `price` varchar(20) NOT NULL DEFAULT '0' COMMENT '???',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_goodscategory --
CREATE TABLE `product_goodscategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL COMMENT '??',
  `parentuuid` varchar(254) DEFAULT NULL COMMENT '??uuid',
  `sort` int(10) DEFAULT '0',
  `remark` varchar(1024) DEFAULT NULL COMMENT '??',
  `uuid` varchar(254) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_goodscomment --
CREATE TABLE `product_goodscomment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsid` int(10) NOT NULL,
  `memberid` int(10) NOT NULL,
  `nickname` varchar(256) NOT NULL,
  `content` text NOT NULL,
  `star` int(1) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_goodsimg --
CREATE TABLE `product_goodsimg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsid` int(10) NOT NULL,
  `thumburl` varchar(256) NOT NULL,
  `url` varchar(256) NOT NULL,
  `created` int(11) NOT NULL,
  `sort` int(11) DEFAULT NULL COMMENT '??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_goodsprofile --
CREATE TABLE `product_goodsprofile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsid` int(10) NOT NULL,
  `key` varchar(500) NOT NULL,
  `value` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_house --
CREATE TABLE `product_house` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(254) DEFAULT NULL COMMENT '??',
  `content` varchar(1024) DEFAULT NULL COMMENT '??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_housepos --
CREATE TABLE `product_housepos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `houseid` int(11) DEFAULT '0' COMMENT '??id',
  `title` varchar(254) DEFAULT NULL COMMENT '??',
  `content` varchar(1024) DEFAULT NULL COMMENT '??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_info --
CREATE TABLE `product_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applyid` int(10) NOT NULL,
  `contract` decimal(10,0) NOT NULL,
  `contract_file` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_order --
CREATE TABLE `product_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(254) DEFAULT NULL,
  `applyid` int(11) DEFAULT '0' COMMENT '????id',
  `ordernum` varchar(100) DEFAULT NULL COMMENT '????',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '??',
  `lossprice` decimal(10,2) DEFAULT '0.00' COMMENT '???',
  `status` tinyint(2) DEFAULT '0' COMMENT '?? 0 ?????1????2????3????',
  `created` int(11) DEFAULT NULL COMMENT '????',
  `remark` varchar(1024) DEFAULT NULL COMMENT '??',
  `issync` tinyint(2) DEFAULT '0' COMMENT '0????1???',
  `inspectionstandard` varchar(1020) DEFAULT NULL COMMENT '????',
  `filename` varchar(254) DEFAULT NULL COMMENT '????',
  `filepath` varchar(254) DEFAULT NULL COMMENT '????',
  `sendtime` int(11) DEFAULT NULL COMMENT '????',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_ordercart --
CREATE TABLE `product_ordercart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applyid` int(11) DEFAULT '0' COMMENT '????applyid',
  `goodsid` int(11) DEFAULT '0',
  `num` int(11) DEFAULT '0' COMMENT '??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_orderinfo --
CREATE TABLE `product_orderinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applyid` int(11) DEFAULT '0' COMMENT '??id',
  `num` varchar(100) DEFAULT NULL COMMENT '??',
  `goodsid` int(11) DEFAULT '0' COMMENT '??id',
  `price` decimal(10,2) DEFAULT '0.00',
  `lossnum` int(11) DEFAULT '0' COMMENT '????',
  `status` tinyint(2) DEFAULT '1' COMMENT '0?? 1??',
  `houseid` int(11) DEFAULT '0' COMMENT '??',
  `houseposid` int(11) DEFAULT '0' COMMENT '??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_paganda --
CREATE TABLE `product_paganda` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `time` datetime(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_productontime --
CREATE TABLE `product_productontime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsuuid` varchar(100) DEFAULT NULL COMMENT '??',
  `productontime` varchar(100) DEFAULT NULL COMMENT '????',
  `num` int(11) DEFAULT '0' COMMENT '??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_relation --
CREATE TABLE `product_relation` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `goodsid` varchar(11) NOT NULL,
  `houseid` varchar(11) NOT NULL,
  `houseposid` varchar(11) NOT NULL,
  `num` char(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_supplier --
CREATE TABLE `product_supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(10) NOT NULL,
  `supplierid` int(10) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_upload --
CREATE TABLE `product_upload` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(11) NOT NULL COMMENT '??',
  `document` varchar(100) NOT NULL COMMENT '????',
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_user --
CREATE TABLE `product_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(55) DEFAULT NULL,
  `user_name` varchar(30) DEFAULT NULL,
  `user_gender` int(1) DEFAULT NULL,
  `user_portrait` varchar(55) DEFAULT NULL,
  `user_bir` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_webinfo --
CREATE TABLE `product_webinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '??????',
  `reuserid` int(11) DEFAULT NULL COMMENT '?????id',
  `seuserid` int(11) DEFAULT NULL COMMENT '?????id',
  `title` varchar(55) DEFAULT NULL COMMENT '??',
  `content` varchar(255) DEFAULT NULL COMMENT '??',
  `time` int(11) DEFAULT NULL COMMENT '????',
  `sign` tinyint(1) DEFAULT '1' COMMENT '1:?? 2:??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_wms --
CREATE TABLE `product_wms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `storeid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：product_wmsdistribution --
CREATE TABLE `product_wmsdistribution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wms_distributio` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_admin --
CREATE TABLE `shop_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '?? Id',
  `uuid` varchar(64) DEFAULT NULL COMMENT 'uuid',
  `name` varchar(254) NOT NULL COMMENT '???',
  `password` varchar(128) NOT NULL COMMENT '??(128? MD5)',
  `lasttime` int(10) NOT NULL COMMENT '??????',
  `lastip` varchar(32) NOT NULL COMMENT '??IP',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '???0??? 1:???',
  `created` int(10) NOT NULL COMMENT '????',
  `groupid` int(11) DEFAULT '0' COMMENT '???id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_advinfo --
CREATE TABLE `shop_advinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `advkey` int(11) DEFAULT NULL COMMENT '???????',
  `title` varchar(100) DEFAULT NULL COMMENT '????',
  `info` varchar(254) DEFAULT NULL COMMENT '??????',
  `img` varchar(100) DEFAULT NULL COMMENT '??????',
  `sort` int(11) DEFAULT NULL COMMENT '??',
  `url` varchar(100) DEFAULT NULL COMMENT '??????',
  `status` tinyint(2) DEFAULT '0' COMMENT '???? 0 ??? 1 ??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_album --
CREATE TABLE `shop_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `operate_id` int(11) NOT NULL,
  `album_info` text NOT NULL,
  `album_background` varchar(255) NOT NULL,
  `album_image` varchar(255) NOT NULL,
  `state` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_cardinfo --
CREATE TABLE `shop_cardinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(254) DEFAULT NULL,
  `cardnum` varchar(100) DEFAULT NULL COMMENT '??',
  `token` varchar(100) DEFAULT NULL COMMENT '???????',
  `password` varchar(100) DEFAULT NULL COMMENT '??',
  `cardtypeuuid` int(11) DEFAULT NULL COMMENT '???uuId',
  `truename` varchar(100) DEFAULT NULL COMMENT '????',
  `mobile` varchar(50) DEFAULT NULL COMMENT '??',
  `expirationtime` int(11) DEFAULT NULL COMMENT '????',
  `birthdaytime` varchar(50) DEFAULT NULL COMMENT '??',
  `address` varchar(1024) DEFAULT NULL COMMENT '????',
  `remark` varchar(1024) DEFAULT NULL COMMENT '??',
  `status` tinyint(2) DEFAULT '0' COMMENT '0????1????2???',
  `opentime` int(11) DEFAULT NULL COMMENT '????',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_cardtype --
CREATE TABLE `shop_cardtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(100) DEFAULT NULL,
  `title` varchar(254) DEFAULT NULL COMMENT '??',
  `uuid` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_cmscategory --
CREATE TABLE `shop_cmscategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(222) NOT NULL COMMENT '????',
  `keys` varchar(200) DEFAULT NULL COMMENT '???????????',
  `parentid` int(11) NOT NULL COMMENT '????id',
  `paths` varchar(100) DEFAULT NULL COMMENT '??id??(?????,????ID????????????)',
  `intro` varchar(500) DEFAULT NULL COMMENT '????',
  `sort` int(5) DEFAULT '999' COMMENT '??',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_cmsinfo --
CREATE TABLE `shop_cmsinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(254) NOT NULL COMMENT '????',
  `thumbimage` varchar(254) DEFAULT NULL COMMENT '??',
  `click` varchar(254) DEFAULT NULL COMMENT '????',
  `categoryid` int(11) DEFAULT NULL COMMENT '??id',
  `content` text COMMENT '??',
  `status` tinyint(1) DEFAULT NULL COMMENT '???0.????1.????',
  `created` int(10) DEFAULT NULL COMMENT '????',
  `isindex` int(1) DEFAULT '0' COMMENT '???????0? 1?',
  `top` int(1) DEFAULT '0' COMMENT '???? 0?? 1???',
  `publishtime` int(10) DEFAULT NULL COMMENT '????',
  `introduction` varchar(300) DEFAULT NULL COMMENT '????',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_gifthistory --
CREATE TABLE `shop_gifthistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gift_id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_giftinfo --
CREATE TABLE `shop_giftinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gift_name` varchar(50) NOT NULL,
  `gift_desc` text NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `gift_image` varchar(255) NOT NULL,
  `gift_integration` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_goodsbrand --
CREATE TABLE `shop_goodsbrand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(254) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `created` int(11) NOT NULL,
  `type` tinyint(2) DEFAULT '0' COMMENT '??????',
  `status` int(2) NOT NULL COMMENT '?????? 0 ?? 1 ??',
  `intro` varchar(254) NOT NULL COMMENT '??????',
  `sort` tinyint(2) DEFAULT NULL COMMENT '??????',
  `categoryid` int(11) DEFAULT NULL COMMENT '??id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_goodscategory --
CREATE TABLE `shop_goodscategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL COMMENT '??',
  `parentuuid` varchar(254) DEFAULT NULL COMMENT '??id',
  `uuid` varchar(254) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `sort` int(10) DEFAULT '0',
  `remark` varchar(1024) DEFAULT NULL COMMENT '??',
  `tag` tinyint(2) DEFAULT '1' COMMENT '???? 0 ?? 1 ???',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_goodsimg --
CREATE TABLE `shop_goodsimg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsid` int(10) NOT NULL,
  `thumburl` varchar(256) NOT NULL,
  `created` int(11) NOT NULL,
  `sort` int(11) DEFAULT NULL COMMENT '??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_goodsinfo --
CREATE TABLE `shop_goodsinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(100) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL COMMENT '???',
  `title` varchar(100) DEFAULT NULL COMMENT '????',
  `imgpath` varchar(100) DEFAULT NULL COMMENT '????',
  `categoryuuid` varchar(100) DEFAULT NULL COMMENT '??uuID',
  `branduuid` int(11) DEFAULT NULL,
  `pingyincode` varchar(100) DEFAULT NULL COMMENT '???',
  `supplier` varchar(254) DEFAULT NULL COMMENT '???',
  `shelflife` int(11) DEFAULT NULL COMMENT '???',
  `costprice` decimal(10,2) DEFAULT '0.00' COMMENT '???',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '???',
  `franchiseeprice` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '?????',
  `number` int(10) DEFAULT '0' COMMENT '??',
  `maxnumber` int(10) DEFAULT '0' COMMENT '????',
  `minnumber` int(10) DEFAULT '0' COMMENT '????',
  `status` tinyint(2) DEFAULT '0' COMMENT '?? 0 ?? 1??',
  `isdiscount` tinyint(2) DEFAULT '0' COMMENT '0??? 1??',
  `remark` varchar(1024) DEFAULT NULL COMMENT '??',
  `discountprice` decimal(10,2) DEFAULT '0.00' COMMENT '??????',
  `type` tinyint(2) DEFAULT '1' COMMENT '???? 0 ???? 1????',
  `tag` tinyint(2) DEFAULT '0' COMMENT '???? 0 ?? 1 ???',
  `ispurchase` tinyint(2) DEFAULT '0' COMMENT '???? 0 ? 1 ?',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_goodsontime --
CREATE TABLE `shop_goodsontime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsuuid` varchar(100) DEFAULT NULL COMMENT '??',
  `productontime` varchar(100) DEFAULT NULL COMMENT '????',
  `num` int(11) DEFAULT '0' COMMENT '??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_news --
CREATE TABLE `shop_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `operate_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `type_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_newstype --
CREATE TABLE `shop_newstype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `operate_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_ordersdetail --
CREATE TABLE `shop_ordersdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userorderuuid` varchar(254) DEFAULT NULL COMMENT '??uuid',
  `num` varchar(100) DEFAULT NULL COMMENT '??',
  `costprice` decimal(10,2) DEFAULT '0.00' COMMENT '???',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '???',
  `saleprice` decimal(10,2) DEFAULT '0.00' COMMENT '????',
  `discount` varchar(50) DEFAULT '1' COMMENT '??',
  `productuuid` varchar(254) DEFAULT NULL COMMENT '??uuid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_ordersinfo --
CREATE TABLE `shop_ordersinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(254) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL COMMENT '???????',
  `ordernum` varchar(100) DEFAULT NULL COMMENT '????',
  `price` decimal(10,2) DEFAULT '0.00',
  `orderstatus` tinyint(2) DEFAULT '0' COMMENT '????',
  `useruuid` varchar(254) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL COMMENT '??',
  `usermobile` varchar(20) DEFAULT NULL COMMENT '??',
  `userprovinceid` int(11) DEFAULT '0' COMMENT '?id',
  `usercityid` int(11) DEFAULT '0',
  `userareaid` int(11) DEFAULT '0' COMMENT '??id',
  `address` varchar(1000) DEFAULT NULL COMMENT '??',
  `created` int(11) DEFAULT NULL COMMENT '????',
  `remark` varchar(255) DEFAULT NULL COMMENT '??',
  `paystatus` tinyint(2) DEFAULT '0' COMMENT '0??? 1???',
  `paytype` tinyint(2) DEFAULT '0' COMMENT '????',
  `carduuid` varchar(254) DEFAULT NULL COMMENT '???uuid',
  `issync` tinyint(2) DEFAULT '0' COMMENT '0?????1???',
  `sendtime` int(10) DEFAULT NULL COMMENT '????',
  `ordertype` tinyint(2) DEFAULT '0' COMMENT '???? 0 ?? 1 ??',
  `tag` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_purchaseorder --
CREATE TABLE `shop_purchaseorder` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '??',
  `telphone` int(11) DEFAULT NULL COMMENT '????',
  `info` varchar(254) DEFAULT NULL COMMENT '????',
  `created` int(11) DEFAULT NULL COMMENT '??',
  `status` tinyint(2) DEFAULT NULL COMMENT '????',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：shop_transport --
CREATE TABLE `shop_transport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(258) NOT NULL,
  `info` text NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `count` decimal(10,0) NOT NULL,
  `send_tpl_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：system_admin --
CREATE TABLE `system_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '?? Id',
  `uuid` varchar(64) DEFAULT NULL COMMENT 'uuid',
  `name` varchar(254) NOT NULL COMMENT '???',
  `password` varchar(128) NOT NULL COMMENT '??(128? MD5)',
  `lasttime` int(10) NOT NULL COMMENT '??????',
  `lastip` varchar(32) NOT NULL COMMENT '??IP',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '???0??? 1:???',
  `created` int(10) NOT NULL COMMENT '????',
  `groupid` int(11) DEFAULT '0' COMMENT '???id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：system_category --
CREATE TABLE `system_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(222) NOT NULL COMMENT '????',
  `keys` varchar(200) DEFAULT NULL COMMENT '???????????',
  `parentid` int(11) NOT NULL COMMENT '????id',
  `paths` varchar(100) DEFAULT NULL COMMENT '??id??(?????,????ID????????????)',
  `imgpath` varchar(100) DEFAULT NULL COMMENT '???? ',
  `intro` varchar(500) DEFAULT NULL COMMENT '????',
  `sort` int(5) DEFAULT '999' COMMENT '??',
  `state` tinyint(2) DEFAULT '1' COMMENT '?????? 0 ?? 1 ??',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：system_framework --
CREATE TABLE `system_framework` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `remark` varchar(50) NOT NULL,
  `describe` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：system_frameworkorganization --
CREATE TABLE `system_frameworkorganization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `addr` varchar(256) NOT NULL,
  `managerid` int(10) NOT NULL,
  `parentid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：system_frameworkpartment --
CREATE TABLE `system_frameworkpartment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `remark` varchar(50) NOT NULL,
  `managerid` int(10) NOT NULL,
  `orgid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：system_group --
CREATE TABLE `system_group` (
  `groupid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(254) NOT NULL,
  `state` int(2) NOT NULL,
  PRIMARY KEY (`groupid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：system_group_menu --
CREATE TABLE `system_group_menu` (
  `groupid` int(11) NOT NULL COMMENT '?????',
  `menupin` varchar(200) NOT NULL COMMENT '?????'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='????????\r\n\r\n???';-- <xjx> --

-- 表的结构：system_log --
CREATE TABLE `system_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `created` int(11) NOT NULL,
  `ip` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：system_menu --
CREATE TABLE `system_menu` (
  `menuid` int(11) NOT NULL AUTO_INCREMENT COMMENT '????',
  `title` varchar(200) NOT NULL COMMENT '????',
  `pin` varchar(200) NOT NULL COMMENT '????? ??????\r\n\r\n?',
  `parentid` int(11) DEFAULT '0' COMMENT '?id',
  `level` tinyint(1) DEFAULT '0' COMMENT '??',
  `module` varchar(50) NOT NULL COMMENT '??',
  `method` varchar(50) NOT NULL COMMENT '??',
  `parameter` varchar(100) DEFAULT NULL COMMENT '??',
  `isshow` tinyint(1) DEFAULT '1' COMMENT '???? 1 ?? 0?\r\n\r\n??',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '?? 0?? 1\r\n\r\n??',
  `orderby` smallint(5) DEFAULT '0' COMMENT '??',
  PRIMARY KEY (`menuid`)
) ENGINE=MyISAM AUTO_INCREMENT=516 DEFAULT CHARSET=utf8 COMMENT='?????';-- <xjx> --

-- 表的结构：system_message --
CREATE TABLE `system_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '?? Id',
  `title` varchar(64) DEFAULT NULL COMMENT '????',
  `content` varchar(254) NOT NULL COMMENT '????',
  `groupid` tinyint(2) NOT NULL COMMENT '????id',
  `sendtime` int(10) NOT NULL COMMENT '????',
  `status` varchar(32) NOT NULL DEFAULT '1' COMMENT '?????(0??? 1???)',
  `starttime` int(10) NOT NULL COMMENT '??????',
  `created` int(10) DEFAULT NULL COMMENT '??????',
  `endtime` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：system_messagetype --
CREATE TABLE `system_messagetype` (
  `groupid` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(254) NOT NULL,
  `state` int(2) NOT NULL,
  PRIMARY KEY (`groupid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：system_role --
CREATE TABLE `system_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '????????????\r\n\r\n???',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '???0',
  `status` tinyint(2) NOT NULL COMMENT '0???1??',
  `remark` varchar(255) DEFAULT NULL COMMENT '??',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：system_sendgroup --
CREATE TABLE `system_sendgroup` (
  `groupid` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(254) NOT NULL,
  PRIMARY KEY (`groupid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：system_setting --
CREATE TABLE `system_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '?? Id',
  `key` varchar(254) NOT NULL COMMENT '?',
  `value` tinytext NOT NULL COMMENT '?',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：user_basic --
CREATE TABLE `user_basic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created` int(11) NOT NULL,
  `type` tinyint(2) DEFAULT '0' COMMENT '0?? ',
  `status` tinyint(2) DEFAULT '1' COMMENT '1?? 0??',
  `email` varchar(100) DEFAULT NULL,
  `lasttime` int(11) DEFAULT NULL,
  `lastip` varchar(100) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：user_basicprofile --
CREATE TABLE `user_basicprofile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL COMMENT '???? id',
  `truename` varchar(100) DEFAULT NULL,
  `sex` varchar(10) NOT NULL DEFAULT '',
  `signature` varchar(255) NOT NULL COMMENT '????',
  `descri` varchar(255) NOT NULL COMMENT '????',
  `face` varchar(255) DEFAULT NULL COMMENT '????',
  `addres` varchar(255) DEFAULT NULL,
  `birthday` varchar(20) DEFAULT NULL,
  `qq` int(11) DEFAULT NULL,
  `tm` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：user_group --
CREATE TABLE `user_group` (
  `groupid` int(11) NOT NULL AUTO_INCREMENT COMMENT '?? Id',
  `title` varchar(254) NOT NULL COMMENT '???',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '???0??? 1:???',
  PRIMARY KEY (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：user_integration --
CREATE TABLE `user_integration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `task` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：user_membership --
CREATE TABLE `user_membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `backgound` varchar(255) NOT NULL,
  `qrcode` varchar(255) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：user_order --
CREATE TABLE `user_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `ordersn` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `paysn` int(40) NOT NULL,
  `goods_amount` decimal(10,0) NOT NULL,
  `order_amount` decimal(10,0) NOT NULL,
  `shipping_fee` decimal(10,0) NOT NULL,
  `evaluation_state` int(4) NOT NULL,
  `order_state` int(4) NOT NULL,
  `refund_state` int(4) NOT NULL,
  `refund_amount` decimal(10,0) NOT NULL,
  `shipping_code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：wms_distribution --
CREATE TABLE `wms_distribution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outid` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `completed` int(11) NOT NULL,
  `sender` varchar(256) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：wms_distributionop --
CREATE TABLE `wms_distributionop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outid` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `operation` varchar(256) NOT NULL,
  `status` int(1) NOT NULL,
  `operation_info` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：wms_in --
CREATE TABLE `wms_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplierid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `locationid` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `completed` int(11) NOT NULL,
  `approverid` int(11) NOT NULL,
  `delivererid` varchar(256) NOT NULL,
  `Recipient` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：wms_in_detail --
CREATE TABLE `wms_in_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `locationid` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `completed` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：wms_inventory --
CREATE TABLE `wms_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `storeid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `locationid` int(11) NOT NULL,
  `instocktime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：wms_location --
CREATE TABLE `wms_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `detail` varchar(256) NOT NULL,
  `size` int(10) NOT NULL,
  `created` int(11) NOT NULL,
  `storeid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：wms_out --
CREATE TABLE `wms_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `locationid` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `completed` int(11) NOT NULL,
  `approverid` int(10) NOT NULL,
  `delivererid` varchar(256) NOT NULL,
  `recipient` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：wms_outdetail --
CREATE TABLE `wms_outdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `locationid` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `completed` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：wms_setting --
CREATE TABLE `wms_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(254) DEFAULT NULL COMMENT '??',
  `status` tinyint(2) DEFAULT '1' COMMENT '0???1??',
  `type` tinyint(2) DEFAULT '0' COMMENT '0???1??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：wms_store --
CREATE TABLE `wms_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `addr` varchar(256) NOT NULL,
  `size` int(10) NOT NULL,
  `owner` varchar(256) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的结构：wms_typesetting --
CREATE TABLE `wms_typesetting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(254) DEFAULT NULL COMMENT '??',
  `type` tinyint(2) DEFAULT '0' COMMENT '0???????1??????',
  `status` tinyint(2) DEFAULT '0' COMMENT '0???1??',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;-- <xjx> --

-- 表的数据：cms_category --
INSERT INTO `cms_category` VALUES
('1','111',NULL,'0',NULL,NULL,'8'),
('3','3333',NULL,'1',NULL,'111111','2'),
('4','44444',NULL,'0',NULL,'','1'),
('7','123123',NULL,'4',NULL,'123','0'),
('8','234',NULL,'0',NULL,'234','7'),
('10','12',NULL,'0',NULL,'123','5'),
('11','121414',NULL,'0',NULL,'afaf','4'),
('12','123',NULL,'0',NULL,'123','6'),
('14','2355',NULL,'0',NULL,'4535','9'),
('16','fsd',NULL,'0',NULL,'dsf','2'),
('17','huang',NULL,'0',NULL,'','0'),
('18','123',NULL,'0',NULL,'','3'),
('19','??????',NULL,'0',NULL,'???????????','0'),
('20','rewrew',NULL,'0',NULL,'rewr','2'),
('21','rewr',NULL,'0',NULL,'rewrew','4');-- <xjx> --

-- 表的数据：cms_info --
INSERT INTO `cms_info` VALUES
('1','aaaa ','/data/2014/04/21/201404211398043968.jpg','1001','3','????????????','1','1428478084','0','1','0','123123123'),
('2','???','/data/2015/04/09/201504091428560368.jpg','2001','7','dadsad??????','0','1428560340','0','0','0','123123123123'),
('9','666','/data/2014/04/21/201404211398043992.jpg','6666','1','????????????????????????????????????????','0','1398044069','0','0','0','123123'),
('13','12312','/data/2014/04/21/201404211398044022.jpg','12','1','<p>\r\n	?????????\r\n</p>\r\n<p>\r\n	<br />\r\n</p>','0','1398043996','0','0','1397186700',NULL);-- <xjx> --

-- 表的数据：crm_supplier --
INSERT INTO `crm_supplier` VALUES
('1','???1','123456','?????','voidlh','13678134391','????????????????','1','0','0','0','??','0','0','1','1429545600');-- <xjx> --

-- 表的数据：crm_supplytype --
INSERT INTO `crm_supplytype` VALUES
('1','??(???)','???aawewq'),
('2','??(???)','???');-- <xjx> --

-- 表的数据：crm_usertype --
INSERT INTO `crm_usertype` VALUES
('1','1212','3??');-- <xjx> --

-- 表的数据：financial_cardtype --
INSERT INTO `financial_cardtype` VALUES
('5','????12',NULL),
('6','????1',NULL);-- <xjx> --

-- 表的数据：financial_paytype --
INSERT INTO `financial_paytype` VALUES
('5','????12','1','1'),
('6','????1','0','1');-- <xjx> --

-- 表的数据：financial_synctype --
INSERT INTO `financial_synctype` VALUES
('5','123456','cardtype',NULL),
('6','1234567','cardtype',NULL);-- <xjx> --

-- 表的数据：franchisee_alliance --
INSERT INTO `franchisee_alliance` VALUES
('1','???1','123456','13678134392','e10adc3949ba59abbe56e057f20f883e','3333','234','0','0',NULL,'??','0',NULL,NULL,NULL),
('2','???2','123124','123132','e10adc3949ba59abbe56e057f20f883e','33332','21','0','0',NULL,NULL,'0',NULL,NULL,NULL);-- <xjx> --

-- 表的数据：franchisee_card --
INSERT INTO `franchisee_card` VALUES
('1',NULL,'CD-201504227744','123456',NULL,'0',NULL,NULL,'1461174426',NULL,NULL,NULL,'1',NULL),
('2',NULL,'CD-201504224483','123456',NULL,'0',NULL,NULL,'1461174426',NULL,NULL,NULL,'0',NULL),
('3',NULL,'CD-201504223595','123456',NULL,'0',NULL,NULL,'1461174427',NULL,NULL,NULL,'0',NULL),
('4',NULL,'CD-201504224871','123456',NULL,'0',NULL,NULL,'1461174427',NULL,NULL,NULL,'0',NULL),
('5',NULL,'CD-201504228263','123456',NULL,'0',NULL,NULL,'1461174427',NULL,NULL,NULL,'0',NULL),
('6',NULL,'CD-201504224347','123456',NULL,'0',NULL,NULL,'1461174427',NULL,NULL,NULL,'0',NULL),
('7',NULL,'CD-201504222527','123456',NULL,'0',NULL,NULL,'1461174427',NULL,NULL,NULL,'0',NULL),
('8',NULL,'CD-20150422990','123456',NULL,'0',NULL,NULL,'1461174427',NULL,NULL,NULL,'0',NULL),
('9',NULL,'CD-201504222592','123456',NULL,'0',NULL,NULL,'1461174427',NULL,NULL,NULL,'0',NULL),
('10',NULL,'CD-20150422445','123456',NULL,'0',NULL,NULL,'1461174427',NULL,NULL,NULL,'0',NULL),
('11',NULL,'CD-201504229617','123124',NULL,'0',NULL,NULL,'1461174427',NULL,NULL,NULL,'0',NULL),
('12',NULL,'CD-201504228452',NULL,NULL,'0',NULL,NULL,'1461174427',NULL,NULL,NULL,'0',NULL),
('13',NULL,'CD-201504223626',NULL,NULL,'0',NULL,NULL,'1461174427',NULL,NULL,NULL,'0',NULL),
('14',NULL,'CD-201504221759',NULL,NULL,'0',NULL,NULL,'1461174427',NULL,NULL,NULL,'0',NULL),
('15',NULL,'CD-201504229372',NULL,NULL,'0',NULL,NULL,'1461174427',NULL,NULL,NULL,'0',NULL),
('16',NULL,'CD-201504228981',NULL,NULL,'0',NULL,NULL,'1461174428',NULL,NULL,NULL,'0',NULL),
('17',NULL,'CD-20150422452',NULL,NULL,'0',NULL,NULL,'1461174428',NULL,NULL,NULL,'0',NULL),
('18',NULL,'CD-201504221363',NULL,NULL,'0',NULL,NULL,'1461174428',NULL,NULL,NULL,'0',NULL),
('19',NULL,'CD-201504227287',NULL,NULL,'0',NULL,NULL,'1461174428',NULL,NULL,NULL,'0',NULL),
('20',NULL,'CD-201504221317',NULL,NULL,'0',NULL,NULL,'1461174428',NULL,NULL,NULL,'0',NULL),
('21',NULL,'CD-201504229065',NULL,NULL,'0',NULL,NULL,'1461174428',NULL,NULL,NULL,'0',NULL),
('22',NULL,'CD-201504228323',NULL,NULL,'0',NULL,NULL,'1461174428',NULL,NULL,NULL,'0',NULL),
('23',NULL,'CD-201504229514',NULL,NULL,'0',NULL,NULL,'1461174428',NULL,NULL,NULL,'0',NULL),
('24',NULL,'CD-201504222989',NULL,NULL,'0',NULL,NULL,'1461174428',NULL,NULL,NULL,'0',NULL),
('25',NULL,'CD-201504226994',NULL,NULL,'0',NULL,NULL,'1461174428',NULL,NULL,NULL,'0',NULL),
('26',NULL,'CD-201504226462',NULL,NULL,'0',NULL,NULL,'1461174428',NULL,NULL,NULL,'0',NULL),
('27',NULL,'CD-20150422121',NULL,NULL,'0',NULL,NULL,'1461174428',NULL,NULL,NULL,'0',NULL),
('28',NULL,'CD-201504222072',NULL,NULL,'0',NULL,NULL,'1461174428',NULL,NULL,NULL,'0',NULL),
('29',NULL,'CD-201504221715',NULL,NULL,'0',NULL,NULL,'1461174429',NULL,NULL,NULL,'0',NULL),
('30',NULL,'CD-201504223436',NULL,NULL,'0',NULL,NULL,'1461174429',NULL,NULL,NULL,'0',NULL),
('31',NULL,'CD-201504221470',NULL,NULL,'0',NULL,NULL,'1461174429',NULL,NULL,NULL,'0',NULL),
('32',NULL,'CD-201504227963',NULL,NULL,'0',NULL,NULL,'1461174429',NULL,NULL,NULL,'0',NULL),
('33',NULL,'CD-20150422462',NULL,NULL,'0',NULL,NULL,'1461174429',NULL,NULL,NULL,'0',NULL),
('34',NULL,'CD-201504227615',NULL,NULL,'0',NULL,NULL,'1461174429',NULL,NULL,NULL,'0',NULL),
('35',NULL,'CD-201504222757',NULL,NULL,'0',NULL,NULL,'1461174429',NULL,NULL,NULL,'0',NULL),
('36',NULL,'CD-201504222801',NULL,NULL,'0',NULL,NULL,'1461174429',NULL,NULL,NULL,'0',NULL),
('37',NULL,'CD-201504224639',NULL,NULL,'0',NULL,NULL,'1461174429',NULL,NULL,NULL,'0',NULL),
('38',NULL,'CD-201504224842',NULL,NULL,'0',NULL,NULL,'1461174429',NULL,NULL,NULL,'0',NULL),
('39',NULL,'CD-201504221508',NULL,NULL,'0',NULL,NULL,'1461174429',NULL,NULL,NULL,'0',NULL),
('40',NULL,'CD-201504227849',NULL,NULL,'0',NULL,NULL,'1461174429',NULL,NULL,NULL,'0',NULL),
('41',NULL,'CD-201504227084',NULL,NULL,'0',NULL,NULL,'1461174429',NULL,NULL,NULL,'0',NULL),
('42',NULL,'CD-201504221661',NULL,NULL,'0',NULL,NULL,'1461174430',NULL,NULL,NULL,'0',NULL),
('43',NULL,'CD-201504226584',NULL,NULL,'0',NULL,NULL,'1461174430',NULL,NULL,NULL,'0',NULL),
('44',NULL,'CD-201504225290',NULL,NULL,'0',NULL,NULL,'1461174430',NULL,NULL,NULL,'0',NULL),
('45',NULL,'CD-201504224186',NULL,NULL,'0',NULL,NULL,'1461174430',NULL,NULL,NULL,'0',NULL),
('46',NULL,'CD-201504229164',NULL,NULL,'0',NULL,NULL,'1461174430',NULL,NULL,NULL,'0',NULL),
('47',NULL,'CD-201504224951',NULL,NULL,'0',NULL,NULL,'1461174430',NULL,NULL,NULL,'0',NULL),
('48',NULL,'CD-201504229262',NULL,NULL,'0',NULL,NULL,'1461174430',NULL,NULL,NULL,'0',NULL),
('49',NULL,'CD-201504228400',NULL,NULL,'0',NULL,NULL,'1461174430',NULL,NULL,NULL,'0',NULL),
('50',NULL,'CD-201504223290',NULL,NULL,'0',NULL,NULL,'1461174430',NULL,NULL,NULL,'0',NULL),
('51',NULL,'CD-201504224542',NULL,NULL,'0',NULL,NULL,'1461174430',NULL,NULL,NULL,'0',NULL),
('52',NULL,'CD-201504221004',NULL,NULL,'0',NULL,NULL,'1461174430',NULL,NULL,NULL,'0',NULL),
('53',NULL,'CD-201504225956',NULL,NULL,'0',NULL,NULL,'1461174430',NULL,NULL,NULL,'0',NULL),
('54',NULL,'CD-201504229181',NULL,NULL,'0',NULL,NULL,'1461174430',NULL,NULL,NULL,'0',NULL),
('55',NULL,'CD-201504226399',NULL,NULL,'0',NULL,NULL,'1461174431',NULL,NULL,NULL,'0',NULL),
('56',NULL,'CD-201504225489',NULL,NULL,'0',NULL,NULL,'1461174431',NULL,NULL,NULL,'0',NULL),
('57',NULL,'CD-201504225424',NULL,NULL,'0',NULL,NULL,'1461174431',NULL,NULL,NULL,'0',NULL),
('58',NULL,'CD-201504221864',NULL,NULL,'0',NULL,NULL,'1461174431',NULL,NULL,NULL,'0',NULL),
('59',NULL,'CD-201504227648',NULL,NULL,'0',NULL,NULL,'1461174431',NULL,NULL,NULL,'0',NULL),
('60',NULL,'CD-201504224100',NULL,NULL,'0',NULL,NULL,'1461174431',NULL,NULL,NULL,'0',NULL),
('61',NULL,'CD-2015042272',NULL,NULL,'0',NULL,NULL,'1461174431',NULL,NULL,NULL,'0',NULL),
('62',NULL,'CD-201504221745',NULL,NULL,'0',NULL,NULL,'1461174431',NULL,NULL,NULL,'0',NULL),
('63',NULL,'CD-20150422141',NULL,NULL,'0',NULL,NULL,'1461174431',NULL,NULL,NULL,'0',NULL),
('64',NULL,'CD-201504228914',NULL,NULL,'0',NULL,NULL,'1461174431',NULL,NULL,NULL,'0',NULL),
('65',NULL,'CD-201504222642',NULL,NULL,'0',NULL,NULL,'1461174431',NULL,NULL,NULL,'0',NULL),
('66',NULL,'CD-201504229740',NULL,NULL,'0',NULL,NULL,'1461174431',NULL,NULL,NULL,'0',NULL),
('67',NULL,'CD-201504222496',NULL,NULL,'0',NULL,NULL,'1461174431',NULL,NULL,NULL,'0',NULL),
('68',NULL,'CD-201504223518',NULL,NULL,'0',NULL,NULL,'1461174432',NULL,NULL,NULL,'0',NULL),
('69',NULL,'CD-201504221947',NULL,NULL,'0',NULL,NULL,'1461174432',NULL,NULL,NULL,'0',NULL),
('70',NULL,'CD-201504225620',NULL,NULL,'0',NULL,NULL,'1461174432',NULL,NULL,NULL,'0',NULL),
('71',NULL,'CD-201504222735',NULL,NULL,'0',NULL,NULL,'1461174432',NULL,NULL,NULL,'0',NULL),
('72',NULL,'CD-201504223621',NULL,NULL,'0',NULL,NULL,'1461174432',NULL,NULL,NULL,'0',NULL),
('73',NULL,'CD-201504221035',NULL,NULL,'0',NULL,NULL,'1461174432',NULL,NULL,NULL,'0',NULL),
('74',NULL,'CD-201504225260',NULL,NULL,'0',NULL,NULL,'1461174432',NULL,NULL,NULL,'0',NULL),
('75',NULL,'CD-201504228723',NULL,NULL,'0',NULL,NULL,'1461174432',NULL,NULL,NULL,'0',NULL),
('76',NULL,'CD-201504228458',NULL,NULL,'0',NULL,NULL,'1461174432',NULL,NULL,NULL,'0',NULL),
('77',NULL,'CD-201504228510',NULL,NULL,'0',NULL,NULL,'1461174432',NULL,NULL,NULL,'0',NULL),
('78',NULL,'CD-201504222301',NULL,NULL,'0',NULL,NULL,'1461174432',NULL,NULL,NULL,'0',NULL),
('79',NULL,'CD-201504221991',NULL,NULL,'0',NULL,NULL,'1461174432',NULL,NULL,NULL,'0',NULL),
('80',NULL,'CD-201504229251',NULL,NULL,'0',NULL,NULL,'1461174432',NULL,NULL,NULL,'0',NULL),
('81',NULL,'CD-201504228692',NULL,NULL,'0',NULL,NULL,'1461174432',NULL,NULL,NULL,'0',NULL),
('82',NULL,'CD-201504227472',NULL,NULL,'0',NULL,NULL,'1461174433',NULL,NULL,NULL,'0',NULL),
('83',NULL,'CD-201504223484',NULL,NULL,'0',NULL,NULL,'1461174433',NULL,NULL,NULL,'0',NULL),
('84',NULL,'CD-201504222624',NULL,NULL,'0',NULL,NULL,'1461174433',NULL,NULL,NULL,'0',NULL),
('85',NULL,'CD-201504228865',NULL,NULL,'0',NULL,NULL,'1461174433',NULL,NULL,NULL,'0',NULL),
('86',NULL,'CD-201504221267',NULL,NULL,'0',NULL,NULL,'1461174433',NULL,NULL,NULL,'0',NULL),
('87',NULL,'CD-201504223209',NULL,NULL,'0',NULL,NULL,'1461174433',NULL,NULL,NULL,'0',NULL),
('88',NULL,'CD-201504223229',NULL,NULL,'0',NULL,NULL,'1461174433',NULL,NULL,NULL,'0',NULL),
('89',NULL,'CD-20150422181',NULL,NULL,'0',NULL,NULL,'1461174433',NULL,NULL,NULL,'0',NULL),
('90',NULL,'CD-201504224672',NULL,NULL,'0',NULL,NULL,'1461174433',NULL,NULL,NULL,'0',NULL),
('91',NULL,'CD-201504221252',NULL,NULL,'0',NULL,NULL,'1461174433',NULL,NULL,NULL,'0',NULL),
('92',NULL,'CD-201504224358',NULL,NULL,'0',NULL,NULL,'1461174433',NULL,NULL,NULL,'0',NULL),
('93',NULL,'CD-201504221932',NULL,NULL,'0',NULL,NULL,'1461174433',NULL,NULL,NULL,'0',NULL),
('94',NULL,'CD-201504226507',NULL,NULL,'0',NULL,NULL,'1461174433',NULL,NULL,NULL,'0',NULL),
('95',NULL,'CD-201504229471',NULL,NULL,'0',NULL,NULL,'1461174434',NULL,NULL,NULL,'0',NULL),
('96',NULL,'CD-201504223707',NULL,NULL,'0',NULL,NULL,'1461174434',NULL,NULL,NULL,'0',NULL),
('97',NULL,'CD-201504221967',NULL,NULL,'0',NULL,NULL,'1461174434',NULL,NULL,NULL,'0',NULL),
('98',NULL,'CD-201504229816',NULL,NULL,'0',NULL,NULL,'1461174434',NULL,NULL,NULL,'0',NULL),
('99',NULL,'CD-201504222976',NULL,NULL,'0',NULL,NULL,'1461174434',NULL,NULL,NULL,'0',NULL),
('100',NULL,'CD-201504221010',NULL,NULL,'0',NULL,NULL,'1461174434',NULL,NULL,NULL,'0',NULL),
('101',NULL,'CD-201504225705',NULL,NULL,'0',NULL,NULL,'1461174434',NULL,NULL,NULL,'0',NULL),
('102',NULL,'CD-201504228922',NULL,NULL,'0',NULL,NULL,'1461174434',NULL,NULL,NULL,'0',NULL),
('103',NULL,'CD-201504227561',NULL,NULL,'0',NULL,NULL,'1461174434',NULL,NULL,NULL,'0',NULL),
('104',NULL,'CD-201504224198',NULL,NULL,'0',NULL,NULL,'1461174434',NULL,NULL,NULL,'0',NULL),
('105',NULL,'CD-201504227119',NULL,NULL,'0',NULL,NULL,'1461174434',NULL,NULL,NULL,'0',NULL),
('106',NULL,'CD-20150422583',NULL,NULL,'0',NULL,NULL,'1461174434',NULL,NULL,NULL,'0',NULL),
('107',NULL,'CD-201504229469',NULL,NULL,'0',NULL,NULL,'1461174434',NULL,NULL,NULL,'0',NULL),
('108',NULL,'CD-20150422513',NULL,NULL,'0',NULL,NULL,'1461174435',NULL,NULL,NULL,'0',NULL),
('109',NULL,'CD-20150422395',NULL,NULL,'0',NULL,NULL,'1461174435',NULL,NULL,NULL,'0',NULL),
('110',NULL,'CD-201504223507',NULL,NULL,'0',NULL,NULL,'1461174435',NULL,NULL,NULL,'0',NULL),
('111',NULL,'CD-201504223950',NULL,NULL,'0',NULL,NULL,'1461174435',NULL,NULL,NULL,'0',NULL),
('112',NULL,'CD-201504229537','123456',NULL,'1',NULL,NULL,'1461174441',NULL,NULL,NULL,'0',NULL),
('113',NULL,'CD-201504224002','123456',NULL,'1',NULL,NULL,'1461174442',NULL,NULL,NULL,'0',NULL),
('114',NULL,'CD-201504229131','123456',NULL,'1',NULL,NULL,'1461174442',NULL,NULL,NULL,'0',NULL),
('115',NULL,'CD-201504222682','123456',NULL,'1',NULL,NULL,'1461174442',NULL,NULL,NULL,'0',NULL),
('116',NULL,'CD-201504224517','123456',NULL,'1',NULL,NULL,'1461174442',NULL,NULL,NULL,'0',NULL),
('117',NULL,'CD-201504229020',NULL,NULL,'1',NULL,NULL,'1461174442',NULL,NULL,NULL,'0',NULL),
('118',NULL,'CD-201504228517',NULL,NULL,'1',NULL,NULL,'1461174442',NULL,NULL,NULL,'0',NULL),
('119',NULL,'CD-201504223213',NULL,NULL,'1',NULL,NULL,'1461174442',NULL,NULL,NULL,'0',NULL),
('120',NULL,'CD-201504229513',NULL,NULL,'1',NULL,NULL,'1461174442',NULL,NULL,NULL,'0',NULL),
('121',NULL,'CD-201504228954',NULL,NULL,'1',NULL,NULL,'1461174442',NULL,NULL,NULL,'0',NULL),
('122',NULL,'CD-201504225935',NULL,NULL,'1',NULL,NULL,'1461174442',NULL,NULL,NULL,'0',NULL),
('123',NULL,'CD-201504226927',NULL,NULL,'1',NULL,NULL,'1461174442',NULL,NULL,NULL,'0',NULL),
('124',NULL,'CD-201504226474',NULL,NULL,'1',NULL,NULL,'1461174442',NULL,NULL,NULL,'0',NULL),
('125',NULL,'CD-201504229284',NULL,NULL,'1',NULL,NULL,'1461174442',NULL,NULL,NULL,'0',NULL),
('126',NULL,'CD-201504222116',NULL,NULL,'1',NULL,NULL,'1461174443',NULL,NULL,NULL,'0',NULL),
('127',NULL,'CD-201504225987',NULL,NULL,'1',NULL,NULL,'1461174443',NULL,NULL,NULL,'0',NULL),
('128',NULL,'CD-201504222268',NULL,NULL,'1',NULL,NULL,'1461174443',NULL,NULL,NULL,'0',NULL),
('129',NULL,'CD-201504223916',NULL,NULL,'1',NULL,NULL,'1461174443',NULL,NULL,NULL,'0',NULL),
('130',NULL,'CD-201504221548',NULL,NULL,'1',NULL,NULL,'1461174443',NULL,NULL,NULL,'0',NULL),
('131',NULL,'CD-201504221834',NULL,NULL,'1',NULL,NULL,'1461174443',NULL,NULL,NULL,'0',NULL),
('132',NULL,'CD-201504228959',NULL,NULL,'1',NULL,NULL,'1461174443',NULL,NULL,NULL,'0',NULL),
('133',NULL,'CD-201504221974',NULL,NULL,'1',NULL,NULL,'1461174443',NULL,NULL,NULL,'0',NULL),
('134',NULL,'CD-201504227421',NULL,NULL,'1',NULL,NULL,'1461174443',NULL,NULL,NULL,'0',NULL),
('135',NULL,'CD-201504225680',NULL,NULL,'1',NULL,NULL,'1461174443',NULL,NULL,NULL,'0',NULL),
('136',NULL,'CD-20150422927',NULL,NULL,'1',NULL,NULL,'1461174443',NULL,NULL,NULL,'0',NULL),
('137',NULL,'CD-201504224304',NULL,NULL,'1',NULL,NULL,'1461174443',NULL,NULL,NULL,'0',NULL),
('138',NULL,'CD-201504223418',NULL,NULL,'1',NULL,NULL,'1461174444',NULL,NULL,NULL,'0',NULL),
('139',NULL,'CD-201504222616',NULL,NULL,'1',NULL,NULL,'1461174444',NULL,NULL,NULL,'0',NULL),
('140',NULL,'CD-201504221811',NULL,NULL,'1',NULL,NULL,'1461174444',NULL,NULL,NULL,'0',NULL),
('141',NULL,'CD-201504225650',NULL,NULL,'1',NULL,NULL,'1461174444',NULL,NULL,NULL,'0',NULL),
('142',NULL,'CD-201504229034',NULL,NULL,'1',NULL,NULL,'1461174444',NULL,NULL,NULL,'0',NULL),
('143',NULL,'CD-20150422291',NULL,NULL,'1',NULL,NULL,'1461174444',NULL,NULL,NULL,'0',NULL),
('144',NULL,'CD-201504224138',NULL,NULL,'1',NULL,NULL,'1461174444',NULL,NULL,NULL,'0',NULL),
('145',NULL,'CD-201504229225',NULL,NULL,'1',NULL,NULL,'1461174444',NULL,NULL,NULL,'0',NULL),
('146',NULL,'CD-201504229196',NULL,NULL,'1',NULL,NULL,'1461174444',NULL,NULL,NULL,'0',NULL),
('147',NULL,'CD-201504224015',NULL,NULL,'1',NULL,NULL,'1461174444',NULL,NULL,NULL,'0',NULL),
('148',NULL,'CD-201504223226',NULL,NULL,'1',NULL,NULL,'1461174444',NULL,NULL,NULL,'0',NULL),
('149',NULL,'CD-201504221802',NULL,NULL,'1',NULL,NULL,'1461174444',NULL,NULL,NULL,'0',NULL),
('150',NULL,'CD-201504225008',NULL,NULL,'1',NULL,NULL,'1461174444',NULL,NULL,NULL,'0',NULL),
('151',NULL,'CD-201504227917',NULL,NULL,'1',NULL,NULL,'1461174445',NULL,NULL,NULL,'0',NULL),
('152',NULL,'CD-201504225826',NULL,NULL,'1',NULL,NULL,'1461174445',NULL,NULL,NULL,'0',NULL),
('153',NULL,'CD-201504222738',NULL,NULL,'1',NULL,NULL,'1461174445',NULL,NULL,NULL,'0',NULL),
('154',NULL,'CD-201504229418',NULL,NULL,'1',NULL,NULL,'1461174445',NULL,NULL,NULL,'0',NULL),
('155',NULL,'CD-20150422827',NULL,NULL,'1',NULL,NULL,'1461174445',NULL,NULL,NULL,'0',NULL),
('156',NULL,'CD-201504224666',NULL,NULL,'1',NULL,NULL,'1461174445',NULL,NULL,NULL,'0',NULL),
('157',NULL,'CD-201504221492',NULL,NULL,'1',NULL,NULL,'1461174445',NULL,NULL,NULL,'0',NULL),
('158',NULL,'CD-201504227993',NULL,NULL,'1',NULL,NULL,'1461174445',NULL,NULL,NULL,'0',NULL),
('159',NULL,'CD-20150422209',NULL,NULL,'1',NULL,NULL,'1461174445',NULL,NULL,NULL,'0',NULL),
('160',NULL,'CD-201504222359',NULL,NULL,'1',NULL,NULL,'1461174445',NULL,NULL,NULL,'0',NULL),
('161',NULL,'CD-201504223467',NULL,NULL,'1',NULL,NULL,'1461174445',NULL,NULL,NULL,'0',NULL),
('162',NULL,'CD-201504221188',NULL,NULL,'1',NULL,NULL,'1461174445',NULL,NULL,NULL,'0',NULL),
('163',NULL,'CD-201504226501',NULL,NULL,'1',NULL,NULL,'1461174445',NULL,NULL,NULL,'0',NULL),
('164',NULL,'CD-20150422806',NULL,NULL,'1',NULL,NULL,'1461174446',NULL,NULL,NULL,'0',NULL),
('165',NULL,'CD-201504227235',NULL,NULL,'1',NULL,NULL,'1461174446',NULL,NULL,NULL,'0',NULL),
('166',NULL,'CD-201504224129',NULL,NULL,'1',NULL,NULL,'1461174446',NULL,NULL,NULL,'0',NULL),
('167',NULL,'CD-201504224805',NULL,NULL,'1',NULL,NULL,'1461174446',NULL,NULL,NULL,'0',NULL),
('168',NULL,'CD-201504227228',NULL,NULL,'1',NULL,NULL,'1461174446',NULL,NULL,NULL,'0',NULL),
('169',NULL,'CD-20150422329',NULL,NULL,'1',NULL,NULL,'1461174446',NULL,NULL,NULL,'0',NULL),
('170',NULL,'CD-201504226407',NULL,NULL,'1',NULL,NULL,'1461174446',NULL,NULL,NULL,'0',NULL),
('171',NULL,'CD-201504224524',NULL,NULL,'1',NULL,NULL,'1461174446',NULL,NULL,NULL,'0',NULL),
('172',NULL,'CD-201504221097',NULL,NULL,'1',NULL,NULL,'1461174446',NULL,NULL,NULL,'0',NULL),
('173',NULL,'CD-201504223012',NULL,NULL,'1',NULL,NULL,'1461174446',NULL,NULL,NULL,'0',NULL),
('174',NULL,'CD-201504227132',NULL,NULL,'1',NULL,NULL,'1461174446',NULL,NULL,NULL,'0',NULL),
('175',NULL,'CD-201504222030',NULL,NULL,'1',NULL,NULL,'1461174446',NULL,NULL,NULL,'0',NULL),
('176',NULL,'CD-201504228013',NULL,NULL,'1',NULL,NULL,'1461174446',NULL,NULL,NULL,'0',NULL),
('177',NULL,'CD-201504224295',NULL,NULL,'1',NULL,NULL,'1461174447',NULL,NULL,NULL,'0',NULL),
('178',NULL,'CD-201504224370',NULL,NULL,'1',NULL,NULL,'1461174447',NULL,NULL,NULL,'0',NULL),
('179',NULL,'CD-20150422918',NULL,NULL,'1',NULL,NULL,'1461174447',NULL,NULL,NULL,'0',NULL),
('180',NULL,'CD-201504222860',NULL,NULL,'1',NULL,NULL,'1461174447',NULL,NULL,NULL,'0',NULL),
('181',NULL,'CD-201504223475',NULL,NULL,'1',NULL,NULL,'1461174447',NULL,NULL,NULL,'0',NULL),
('182',NULL,'CD-201504228410',NULL,NULL,'1',NULL,NULL,'1461174447',NULL,NULL,NULL,'0',NULL),
('183',NULL,'CD-201504223451',NULL,NULL,'1',NULL,NULL,'1461174447',NULL,NULL,NULL,'0',NULL),
('184',NULL,'CD-201504228465',NULL,NULL,'1',NULL,NULL,'1461174447',NULL,NULL,NULL,'0',NULL),
('185',NULL,'CD-201504221991',NULL,NULL,'1',NULL,NULL,'1461174447',NULL,NULL,NULL,'0',NULL),
('186',NULL,'CD-201504228370',NULL,NULL,'1',NULL,NULL,'1461174447',NULL,NULL,NULL,'0',NULL),
('187',NULL,'CD-201504222956',NULL,NULL,'1',NULL,NULL,'1461174447',NULL,NULL,NULL,'0',NULL),
('188',NULL,'CD-201504222797',NULL,NULL,'1',NULL,NULL,'1461174447',NULL,NULL,NULL,'0',NULL),
('189',NULL,'CD-201504227219',NULL,NULL,'1',NULL,NULL,'1461174448',NULL,NULL,NULL,'0',NULL),
('190',NULL,'CD-201504229717',NULL,NULL,'1',NULL,NULL,'1461174448',NULL,NULL,NULL,'0',NULL),
('191',NULL,'CD-201504225027',NULL,NULL,'1',NULL,NULL,'1461174448',NULL,NULL,NULL,'0',NULL),
('192',NULL,'CD-201504223015',NULL,NULL,'1',NULL,NULL,'1461174448',NULL,NULL,NULL,'0',NULL),
('193',NULL,'CD-20150422447',NULL,NULL,'1',NULL,NULL,'1461174448',NULL,NULL,NULL,'0',NULL),
('194',NULL,'CD-201504224557',NULL,NULL,'1',NULL,NULL,'1461174448',NULL,NULL,NULL,'0',NULL),
('195',NULL,'CD-201504228039',NULL,NULL,'1',NULL,NULL,'1461174448',NULL,NULL,NULL,'0',NULL),
('196',NULL,'CD-201504223208',NULL,NULL,'1',NULL,NULL,'1461174448',NULL,NULL,NULL,'0',NULL),
('197',NULL,'CD-201504221754',NULL,NULL,'1',NULL,NULL,'1461174448',NULL,NULL,NULL,'0',NULL),
('198',NULL,'CD-201504226748',NULL,NULL,'1',NULL,NULL,'1461174448',NULL,NULL,NULL,'0',NULL),
('199',NULL,'CD-201504229707',NULL,NULL,'1',NULL,NULL,'1461174448',NULL,NULL,NULL,'0',NULL),
('200',NULL,'CD-201504222019',NULL,NULL,'1',NULL,NULL,'1461174448',NULL,NULL,NULL,'0',NULL),
('201',NULL,'CD-20150422202',NULL,NULL,'1',NULL,NULL,'1461174448',NULL,NULL,NULL,'0',NULL),
('202',NULL,'CD-201504227462',NULL,NULL,'1',NULL,NULL,'1461174449',NULL,NULL,NULL,'0',NULL),
('203',NULL,'CD-201504228033',NULL,NULL,'1',NULL,NULL,'1461174449',NULL,NULL,NULL,'0',NULL),
('204',NULL,'CD-201504228201',NULL,NULL,'1',NULL,NULL,'1461174449',NULL,NULL,NULL,'0',NULL),
('205',NULL,'CD-201504225230',NULL,NULL,'1',NULL,NULL,'1461174449',NULL,NULL,NULL,'0',NULL),
('206',NULL,'CD-201504226010',NULL,NULL,'1',NULL,NULL,'1461174449',NULL,NULL,NULL,'0',NULL),
('207',NULL,'CD-201504229111',NULL,NULL,'1',NULL,NULL,'1461174449',NULL,NULL,NULL,'0',NULL),
('208',NULL,'CD-201504227715',NULL,NULL,'1',NULL,NULL,'1461174449',NULL,NULL,NULL,'0',NULL),
('209',NULL,'CD-201504225355',NULL,NULL,'1',NULL,NULL,'1461174449',NULL,NULL,NULL,'0',NULL),
('210',NULL,'CD-20150422155',NULL,NULL,'1',NULL,NULL,'1461174449',NULL,NULL,NULL,'0',NULL),
('211',NULL,'CD-201504227223',NULL,NULL,'1',NULL,NULL,'1461174449',NULL,NULL,NULL,'0',NULL),
('212',NULL,'CD-201504229697',NULL,NULL,'1',NULL,NULL,'1461174449',NULL,NULL,NULL,'0',NULL),
('213',NULL,'CD-20150422692',NULL,NULL,'1',NULL,NULL,'1461174449',NULL,NULL,NULL,'0',NULL),
('214',NULL,'CD-201504223905',NULL,NULL,'1',NULL,NULL,'1461174449',NULL,NULL,NULL,'0',NULL),
('215',NULL,'CD-201504221543',NULL,NULL,'1',NULL,NULL,'1461174450',NULL,NULL,NULL,'0',NULL),
('216',NULL,'CD-201504222901',NULL,NULL,'1',NULL,NULL,'1461174450',NULL,NULL,NULL,'0',NULL),
('217',NULL,'CD-201504221213',NULL,NULL,'1',NULL,NULL,'1461174450',NULL,NULL,NULL,'0',NULL),
('218',NULL,'CD-201504224140',NULL,NULL,'1',NULL,NULL,'1461174450',NULL,NULL,NULL,'0',NULL),
('219',NULL,'CD-201504228775',NULL,NULL,'1',NULL,NULL,'1461174450',NULL,NULL,NULL,'0',NULL),
('220',NULL,'CD-201504221325',NULL,NULL,'1',NULL,NULL,'1461174450',NULL,NULL,NULL,'0',NULL),
('221',NULL,'CD-201504223707',NULL,NULL,'1',NULL,NULL,'1461174450',NULL,NULL,NULL,'0',NULL),
('222',NULL,'CD-201504226593',NULL,NULL,'1',NULL,NULL,'1461174450',NULL,NULL,NULL,'0',NULL),
('223',NULL,'CD-201504222838',NULL,NULL,'1',NULL,NULL,'1461174450',NULL,NULL,NULL,'0',NULL),
('224',NULL,'CD-201504224574',NULL,NULL,'1',NULL,NULL,'1461174450',NULL,NULL,NULL,'0',NULL),
('225',NULL,'CD-201504222',NULL,NULL,'1',NULL,NULL,'1461174450',NULL,NULL,NULL,'0',NULL),
('226',NULL,'CD-201504225143',NULL,NULL,'1',NULL,NULL,'1461174450',NULL,NULL,NULL,'0',NULL),
('227',NULL,'CD-201504222405',NULL,NULL,'1',NULL,NULL,'1461174450',NULL,NULL,NULL,'0',NULL),
('228',NULL,'CD-201504221230',NULL,NULL,'1',NULL,NULL,'1461174451',NULL,NULL,NULL,'0',NULL),
('229',NULL,'CD-201504222920',NULL,NULL,'1',NULL,NULL,'1461174451',NULL,NULL,NULL,'0',NULL),
('230',NULL,'CD-201504229800',NULL,NULL,'1',NULL,NULL,'1461174451',NULL,NULL,NULL,'0',NULL),
('231',NULL,'CD-201504225644',NULL,NULL,'1',NULL,NULL,'1461174451',NULL,NULL,NULL,'0',NULL),
('232',NULL,'CD-201504222451',NULL,NULL,'1',NULL,NULL,'1461174451',NULL,NULL,NULL,'0',NULL),
('233',NULL,'CD-201504227841',NULL,NULL,'1',NULL,NULL,'1461174451',NULL,NULL,NULL,'0',NULL),
('234',NULL,'CD-201504229464',NULL,NULL,'1',NULL,NULL,'1461174451',NULL,NULL,NULL,'0',NULL),
('235',NULL,'CD-201504229918',NULL,NULL,'1',NULL,NULL,'1461174451',NULL,NULL,NULL,'0',NULL),
('236',NULL,'CD-201504227911',NULL,NULL,'1',NULL,NULL,'1461174451',NULL,NULL,NULL,'0',NULL),
('237',NULL,'CD-20150422699',NULL,NULL,'1',NULL,NULL,'1461174451',NULL,NULL,NULL,'0',NULL),
('238',NULL,'CD-201504224235',NULL,NULL,'1',NULL,NULL,'1461174451',NULL,NULL,NULL,'0',NULL),
('239',NULL,'CD-201504225098',NULL,NULL,'1',NULL,NULL,'1461174451',NULL,NULL,NULL,'0',NULL),
('240',NULL,'CD-201504228147',NULL,NULL,'1',NULL,NULL,'1461174451',NULL,NULL,NULL,'0',NULL),
('241',NULL,'CD-201504228429',NULL,NULL,'1',NULL,NULL,'1461174452',NULL,NULL,NULL,'0',NULL),
('242',NULL,'CD-20150422765',NULL,NULL,'1',NULL,NULL,'1461174452',NULL,NULL,NULL,'0',NULL),
('243',NULL,'CD-201504222824',NULL,NULL,'1',NULL,NULL,'1461174452',NULL,NULL,NULL,'0',NULL),
('244',NULL,'CD-201504222457',NULL,NULL,'1',NULL,NULL,'1461174452',NULL,NULL,NULL,'0',NULL),
('245',NULL,'CD-201504228329',NULL,NULL,'1',NULL,NULL,'1461174452',NULL,NULL,NULL,'0',NULL),
('246',NULL,'CD-201504226702',NULL,NULL,'1',NULL,NULL,'1461174452',NULL,NULL,NULL,'0',NULL),
('247',NULL,'CD-201504224379',NULL,NULL,'1',NULL,NULL,'1461174452',NULL,NULL,NULL,'0',NULL),
('248',NULL,'CD-20150422305',NULL,NULL,'1',NULL,NULL,'1461174452',NULL,NULL,NULL,'0',NULL),
('249',NULL,'CD-201504225216',NULL,NULL,'1',NULL,NULL,'1461174452',NULL,NULL,NULL,'0',NULL),
('250',NULL,'CD-201504223012',NULL,NULL,'1',NULL,NULL,'1461174452',NULL,NULL,NULL,'0',NULL),
('251',NULL,'CD-201504223755',NULL,NULL,'1',NULL,NULL,'1461174452',NULL,NULL,NULL,'0',NULL),
('252',NULL,'CD-201504221019',NULL,NULL,'1',NULL,NULL,'1461174452',NULL,NULL,NULL,'0',NULL),
('253',NULL,'CD-201504227870',NULL,NULL,'1',NULL,NULL,'1461174452',NULL,NULL,NULL,'0',NULL),
('254',NULL,'CD-201504228216',NULL,NULL,'1',NULL,NULL,'1461174453',NULL,NULL,NULL,'0',NULL),
('255',NULL,'CD-201504228356',NULL,NULL,'1',NULL,NULL,'1461174453',NULL,NULL,NULL,'0',NULL),
('256',NULL,'CD-20150422221',NULL,NULL,'1',NULL,NULL,'1461174453',NULL,NULL,NULL,'0',NULL),
('257',NULL,'CD-201504226871',NULL,NULL,'1',NULL,NULL,'1461174453',NULL,NULL,NULL,'0',NULL),
('258',NULL,'CD-201504221448',NULL,NULL,'1',NULL,NULL,'1461174453',NULL,NULL,NULL,'0',NULL),
('259',NULL,'CD-201504221082',NULL,NULL,'1',NULL,NULL,'1461174453',NULL,NULL,NULL,'0',NULL),
('260',NULL,'CD-201504223608',NULL,NULL,'1',NULL,NULL,'1461174453',NULL,NULL,NULL,'0',NULL),
('261',NULL,'CD-201504224026',NULL,NULL,'1',NULL,NULL,'1461174453',NULL,NULL,NULL,'0',NULL),
('262',NULL,'CD-20150422802',NULL,NULL,'1',NULL,NULL,'1461174453',NULL,NULL,NULL,'0',NULL),
('263',NULL,'CD-201504223248',NULL,NULL,'2',NULL,NULL,'1461174461',NULL,NULL,NULL,'0',NULL),
('264',NULL,'CD-201504224837',NULL,NULL,'2',NULL,NULL,'1461174461',NULL,NULL,NULL,'0',NULL),
('265',NULL,'CD-20150422581',NULL,NULL,'2',NULL,NULL,'1461174461',NULL,NULL,NULL,'0',NULL),
('266',NULL,'CD-20150422421',NULL,NULL,'2',NULL,NULL,'1461174461',NULL,NULL,NULL,'0',NULL),
('267',NULL,'CD-201504226362',NULL,NULL,'2',NULL,NULL,'1461174461',NULL,NULL,NULL,'0',NULL),
('268',NULL,'CD-201504229626',NULL,NULL,'2',NULL,NULL,'1461174461',NULL,NULL,NULL,'0',NULL),
('269',NULL,'CD-201504222718',NULL,NULL,'2',NULL,NULL,'1461174461',NULL,NULL,NULL,'0',NULL),
('270',NULL,'CD-201504222218',NULL,NULL,'2',NULL,NULL,'1461174461',NULL,NULL,NULL,'0',NULL),
('271',NULL,'CD-201504223269',NULL,NULL,'2',NULL,NULL,'1461174461',NULL,NULL,NULL,'0',NULL),
('272',NULL,'CD-201504223176',NULL,NULL,'2',NULL,NULL,'1461174462',NULL,NULL,NULL,'0',NULL),
('273',NULL,'CD-201504221476',NULL,NULL,'2',NULL,NULL,'1461174462',NULL,NULL,NULL,'0',NULL),
('274',NULL,'CD-201504227109',NULL,NULL,'2',NULL,NULL,'1461174462',NULL,NULL,NULL,'0',NULL),
('275',NULL,'CD-201504229496',NULL,NULL,'2',NULL,NULL,'1461174462',NULL,NULL,NULL,'0',NULL),
('276',NULL,'CD-201504226926',NULL,NULL,'2',NULL,NULL,'1461174462',NULL,NULL,NULL,'0',NULL),
('277',NULL,'CD-201504226489',NULL,NULL,'2',NULL,NULL,'1461174462',NULL,NULL,NULL,'0',NULL),
('278',NULL,'CD-20150422601',NULL,NULL,'2',NULL,NULL,'1461174462',NULL,NULL,NULL,'0',NULL),
('279',NULL,'CD-201504222734',NULL,NULL,'2',NULL,NULL,'1461174462',NULL,NULL,NULL,'0',NULL),
('280',NULL,'CD-201504229463',NULL,NULL,'2',NULL,NULL,'1461174462',NULL,NULL,NULL,'0',NULL),
('281',NULL,'CD-201504221627',NULL,NULL,'2',NULL,NULL,'1461174462',NULL,NULL,NULL,'0',NULL),
('282',NULL,'CD-201504229663',NULL,NULL,'2',NULL,NULL,'1461174462',NULL,NULL,NULL,'0',NULL),
('283',NULL,'CD-201504223840',NULL,NULL,'2',NULL,NULL,'1461174462',NULL,NULL,NULL,'0',NULL),
('284',NULL,'CD-201504223377',NULL,NULL,'2',NULL,NULL,'1461174462',NULL,NULL,NULL,'0',NULL),
('285',NULL,'CD-201504224897',NULL,NULL,'2',NULL,NULL,'1461174463',NULL,NULL,NULL,'0',NULL),
('286',NULL,'CD-201504222887',NULL,NULL,'2',NULL,NULL,'1461174463',NULL,NULL,NULL,'0',NULL),
('287',NULL,'CD-20150422576',NULL,NULL,'2',NULL,NULL,'1461174463',NULL,NULL,NULL,'0',NULL),
('288',NULL,'CD-201504224436',NULL,NULL,'2',NULL,NULL,'1461174463',NULL,NULL,NULL,'0',NULL),
('289',NULL,'CD-201504228135',NULL,NULL,'2',NULL,NULL,'1461174463',NULL,NULL,NULL,'0',NULL),
('290',NULL,'CD-201504228079',NULL,NULL,'2',NULL,NULL,'1461174463',NULL,NULL,NULL,'0',NULL),
('291',NULL,'CD-201504228480',NULL,NULL,'2',NULL,NULL,'1461174463',NULL,NULL,NULL,'0',NULL),
('292',NULL,'CD-201504229129',NULL,NULL,'2',NULL,NULL,'1461174463',NULL,NULL,NULL,'0',NULL),
('293',NULL,'CD-20150422789',NULL,NULL,'2',NULL,NULL,'1461174463',NULL,NULL,NULL,'0',NULL),
('294',NULL,'CD-201504223535',NULL,NULL,'2',NULL,NULL,'1461174463',NULL,NULL,NULL,'0',NULL),
('295',NULL,'CD-201504222942',NULL,NULL,'2',NULL,NULL,'1461174463',NULL,NULL,NULL,'0',NULL),
('296',NULL,'CD-201504221918',NULL,NULL,'2',NULL,NULL,'1461174463',NULL,NULL,NULL,'0',NULL),
('297',NULL,'CD-201504221192',NULL,NULL,'2',NULL,NULL,'1461174464',NULL,NULL,NULL,'0',NULL),
('298',NULL,'CD-201504221277',NULL,NULL,'2',NULL,NULL,'1461174464',NULL,NULL,NULL,'0',NULL),
('299',NULL,'CD-201504223374',NULL,NULL,'2',NULL,NULL,'1461174464',NULL,NULL,NULL,'0',NULL),
('300',NULL,'CD-201504224332',NULL,NULL,'2',NULL,NULL,'1461174464',NULL,NULL,NULL,'0',NULL),
('301',NULL,'CD-201504223897',NULL,NULL,'2',NULL,NULL,'1461174464',NULL,NULL,NULL,'0',NULL),
('302',NULL,'CD-201504221432',NULL,NULL,'2',NULL,NULL,'1461174464',NULL,NULL,NULL,'0',NULL),
('303',NULL,'CD-201504228472',NULL,NULL,'2',NULL,NULL,'1461174464',NULL,NULL,NULL,'0',NULL),
('304',NULL,'CD-201504223855',NULL,NULL,'2',NULL,NULL,'1461174464',NULL,NULL,NULL,'0',NULL),
('305',NULL,'CD-201504225793',NULL,NULL,'2',NULL,NULL,'1461174464',NULL,NULL,NULL,'0',NULL),
('306',NULL,'CD-201504221701',NULL,NULL,'2',NULL,NULL,'1461174464',NULL,NULL,NULL,'0',NULL),
('307',NULL,'CD-201504229444',NULL,NULL,'2',NULL,NULL,'1461174464',NULL,NULL,NULL,'0',NULL),
('308',NULL,'CD-20150422629',NULL,NULL,'2',NULL,NULL,'1461174464',NULL,NULL,NULL,'0',NULL),
('309',NULL,'CD-201504222920',NULL,NULL,'2',NULL,NULL,'1461174464',NULL,NULL,NULL,'0',NULL),
('310',NULL,'CD-201504222377',NULL,NULL,'2',NULL,NULL,'1461174465',NULL,NULL,NULL,'0',NULL),
('311',NULL,'CD-201504223334',NULL,NULL,'2',NULL,NULL,'1461174465',NULL,NULL,NULL,'0',NULL),
('312',NULL,'CD-201504226958',NULL,NULL,'2',NULL,NULL,'1461174465',NULL,NULL,NULL,'0',NULL),
('313',NULL,'CD-201504225903',NULL,NULL,'2',NULL,NULL,'1461174465',NULL,NULL,NULL,'0',NULL),
('314',NULL,'CD-201504228225',NULL,NULL,'2',NULL,NULL,'1461174465',NULL,NULL,NULL,'0',NULL),
('315',NULL,'CD-201504223823',NULL,NULL,'2',NULL,NULL,'1461174465',NULL,NULL,NULL,'0',NULL),
('316',NULL,'CD-201504227965',NULL,NULL,'2',NULL,NULL,'1461174465',NULL,NULL,NULL,'0',NULL),
('317',NULL,'CD-201504224615',NULL,NULL,'2',NULL,NULL,'1461174465',NULL,NULL,NULL,'0',NULL),
('318',NULL,'CD-201504223191',NULL,NULL,'2',NULL,NULL,'1461174465',NULL,NULL,NULL,'0',NULL),
('319',NULL,'CD-201504229035',NULL,NULL,'2',NULL,NULL,'1461174465',NULL,NULL,NULL,'0',NULL),
('320',NULL,'CD-201504228447',NULL,NULL,'2',NULL,NULL,'1461174465',NULL,NULL,NULL,'0',NULL),
('321',NULL,'CD-201504226936',NULL,NULL,'2',NULL,NULL,'1461174465',NULL,NULL,NULL,'0',NULL),
('322',NULL,'CD-201504226378',NULL,NULL,'2',NULL,NULL,'1461174465',NULL,NULL,NULL,'0',NULL),
('323',NULL,'CD-201504226143',NULL,NULL,'2',NULL,NULL,'1461174466',NULL,NULL,NULL,'0',NULL),
('324',NULL,'CD-201504227808',NULL,NULL,'2',NULL,NULL,'1461174466',NULL,NULL,NULL,'0',NULL),
('325',NULL,'CD-201504223674',NULL,NULL,'2',NULL,NULL,'1461174466',NULL,NULL,NULL,'0',NULL),
('326',NULL,'CD-201504224449',NULL,NULL,'2',NULL,NULL,'1461174466',NULL,NULL,NULL,'0',NULL),
('327',NULL,'CD-201504222448',NULL,NULL,'2',NULL,NULL,'1461174466',NULL,NULL,NULL,'0',NULL),
('328',NULL,'CD-201504222748',NULL,NULL,'2',NULL,NULL,'1461174466',NULL,NULL,NULL,'0',NULL),
('329',NULL,'CD-201504223051',NULL,NULL,'2',NULL,NULL,'1461174466',NULL,NULL,NULL,'0',NULL),
('330',NULL,'CD-201504225680',NULL,NULL,'2',NULL,NULL,'1461174466',NULL,NULL,NULL,'0',NULL),
('331',NULL,'CD-201504227264',NULL,NULL,'2',NULL,NULL,'1461174466',NULL,NULL,NULL,'0',NULL),
('332',NULL,'CD-201504227680',NULL,NULL,'2',NULL,NULL,'1461174466',NULL,NULL,NULL,'0',NULL),
('333',NULL,'CD-201504227284',NULL,NULL,'2',NULL,NULL,'1461174466',NULL,NULL,NULL,'0',NULL),
('334',NULL,'CD-201504229175',NULL,NULL,'2',NULL,NULL,'1461174466',NULL,NULL,NULL,'0',NULL),
('335',NULL,'CD-201504229093',NULL,NULL,'2',NULL,NULL,'1461174466',NULL,NULL,NULL,'0',NULL),
('336',NULL,'CD-201504229910',NULL,NULL,'2',NULL,NULL,'1461174467',NULL,NULL,NULL,'0',NULL),
('337',NULL,'CD-201504229105',NULL,NULL,'2',NULL,NULL,'1461174467',NULL,NULL,NULL,'0',NULL),
('338',NULL,'CD-201504227477',NULL,NULL,'2',NULL,NULL,'1461174467',NULL,NULL,NULL,'0',NULL),
('339',NULL,'CD-20150422729',NULL,NULL,'2',NULL,NULL,'1461174467',NULL,NULL,NULL,'0',NULL),
('340',NULL,'CD-201504224771',NULL,NULL,'2',NULL,NULL,'1461174467',NULL,NULL,NULL,'0',NULL),
('341',NULL,'CD-201504227308',NULL,NULL,'2',NULL,NULL,'1461174467',NULL,NULL,NULL,'0',NULL),
('342',NULL,'CD-201504225056',NULL,NULL,'2',NULL,NULL,'1461174467',NULL,NULL,NULL,'0',NULL),
('343',NULL,'CD-201504226943',NULL,NULL,'2',NULL,NULL,'1461174467',NULL,NULL,NULL,'0',NULL),
('344',NULL,'CD-201504227960',NULL,NULL,'2',NULL,NULL,'1461174467',NULL,NULL,NULL,'0',NULL),
('345',NULL,'CD-201504221869',NULL,NULL,'2',NULL,NULL,'1461174467',NULL,NULL,NULL,'0',NULL),
('346',NULL,'CD-201504224721',NULL,NULL,'2',NULL,NULL,'1461174467',NULL,NULL,NULL,'0',NULL),
('347',NULL,'CD-201504225171',NULL,NULL,'2',NULL,NULL,'1461174467',NULL,NULL,NULL,'0',NULL),
('348',NULL,'CD-201504228600',NULL,NULL,'2',NULL,NULL,'1461174467',NULL,NULL,NULL,'0',NULL),
('349',NULL,'CD-201504228199',NULL,NULL,'2',NULL,NULL,'1461174468',NULL,NULL,NULL,'0',NULL),
('350',NULL,'CD-201504227873',NULL,NULL,'2',NULL,NULL,'1461174468',NULL,NULL,NULL,'0',NULL),
('351',NULL,'CD-201504225380',NULL,NULL,'2',NULL,NULL,'1461174468',NULL,NULL,NULL,'0',NULL),
('352',NULL,'CD-201504225236',NULL,NULL,'2',NULL,NULL,'1461174468',NULL,NULL,NULL,'0',NULL),
('353',NULL,'CD-201504221234',NULL,NULL,'2',NULL,NULL,'1461174468',NULL,NULL,NULL,'0',NULL),
('354',NULL,'CD-201504229221',NULL,NULL,'2',NULL,NULL,'1461174468',NULL,NULL,NULL,'0',NULL),
('355',NULL,'CD-201504221947',NULL,NULL,'2',NULL,NULL,'1461174468',NULL,NULL,NULL,'0',NULL),
('356',NULL,'CD-201504228561',NULL,NULL,'2',NULL,NULL,'1461174468',NULL,NULL,NULL,'0',NULL),
('357',NULL,'CD-201504228764',NULL,NULL,'2',NULL,NULL,'1461174468',NULL,NULL,NULL,'0',NULL),
('358',NULL,'CD-201504224749',NULL,NULL,'2',NULL,NULL,'1461174468',NULL,NULL,NULL,'0',NULL),
('359',NULL,'CD-201504224798',NULL,NULL,'2',NULL,NULL,'1461174468',NULL,NULL,NULL,'0',NULL),
('360',NULL,'CD-201504229642',NULL,NULL,'2',NULL,NULL,'1461174468',NULL,NULL,NULL,'0',NULL),
('361',NULL,'CD-20150422753',NULL,NULL,'2',NULL,NULL,'1461174468',NULL,NULL,NULL,'0',NULL),
('362',NULL,'CD-201504225428',NULL,NULL,'2',NULL,NULL,'1461174469',NULL,NULL,NULL,'0',NULL),
('363',NULL,'CD-201504228979',NULL,NULL,'2',NULL,NULL,'1461174469',NULL,NULL,NULL,'0',NULL),
('364',NULL,'CD-201504222094',NULL,NULL,'2',NULL,NULL,'1461174469',NULL,NULL,NULL,'0',NULL),
('365',NULL,'CD-201504221761',NULL,NULL,'2',NULL,NULL,'1461174469',NULL,NULL,NULL,'0',NULL),
('366',NULL,'CD-201504225510',NULL,NULL,'2',NULL,NULL,'1461174469',NULL,NULL,NULL,'0',NULL),
('367',NULL,'CD-201504223796',NULL,NULL,'2',NULL,NULL,'1461174469',NULL,NULL,NULL,'0',NULL),
('368',NULL,'CD-20150422694',NULL,NULL,'2',NULL,NULL,'1461174469',NULL,NULL,NULL,'0',NULL),
('369',NULL,'CD-201504225870',NULL,NULL,'2',NULL,NULL,'1461174469',NULL,NULL,NULL,'0',NULL),
('370',NULL,'CD-201504226140',NULL,NULL,'2',NULL,NULL,'1461174469',NULL,NULL,NULL,'0',NULL),
('371',NULL,'CD-201504229663',NULL,NULL,'2',NULL,NULL,'1461174469',NULL,NULL,NULL,'0',NULL),
('372',NULL,'CD-20150422984',NULL,NULL,'2',NULL,NULL,'1461174469',NULL,NULL,NULL,'0',NULL),
('373',NULL,'CD-201504223344',NULL,NULL,'2',NULL,NULL,'1461174469',NULL,NULL,NULL,'0',NULL),
('374',NULL,'CD-201504227784',NULL,NULL,'2',NULL,NULL,'1461174469',NULL,NULL,NULL,'0',NULL),
('375',NULL,'CD-201504221368',NULL,NULL,'2',NULL,NULL,'1461174470',NULL,NULL,NULL,'0',NULL),
('376',NULL,'CD-201504227988',NULL,NULL,'2',NULL,NULL,'1461174470',NULL,NULL,NULL,'0',NULL),
('377',NULL,'CD-20150422733',NULL,NULL,'2',NULL,NULL,'1461174470',NULL,NULL,NULL,'0',NULL),
('378',NULL,'CD-201504227112',NULL,NULL,'2',NULL,NULL,'1461174470',NULL,NULL,NULL,'0',NULL),
('379',NULL,'CD-201504227802',NULL,NULL,'2',NULL,NULL,'1461174470',NULL,NULL,NULL,'0',NULL),
('380',NULL,'CD-201504229703',NULL,NULL,'2',NULL,NULL,'1461174470',NULL,NULL,NULL,'0',NULL),
('381',NULL,'CD-201504226506',NULL,NULL,'2',NULL,NULL,'1461174470',NULL,NULL,NULL,'0',NULL),
('382',NULL,'CD-201504228145',NULL,NULL,'2',NULL,NULL,'1461174470',NULL,NULL,NULL,'0',NULL),
('383',NULL,'CD-201504228090',NULL,NULL,'2',NULL,NULL,'1461174470',NULL,NULL,NULL,'0',NULL),
('384',NULL,'CD-201504227346',NULL,NULL,'2',NULL,NULL,'1461174470',NULL,NULL,NULL,'0',NULL),
('385',NULL,'CD-201504224903',NULL,NULL,'2',NULL,NULL,'1461174470',NULL,NULL,NULL,'0',NULL),
('386',NULL,'CD-201504229993',NULL,NULL,'2',NULL,NULL,'1461174470',NULL,NULL,NULL,'0',NULL),
('387',NULL,'CD-201504227565',NULL,NULL,'2',NULL,NULL,'1461174470',NULL,NULL,NULL,'0',NULL),
('388',NULL,'CD-201504227987',NULL,NULL,'2',NULL,NULL,'1461174471',NULL,NULL,NULL,'0',NULL),
('389',NULL,'CD-201504223407',NULL,NULL,'2',NULL,NULL,'1461174471',NULL,NULL,NULL,'0',NULL),
('390',NULL,'CD-201504224510',NULL,NULL,'2',NULL,NULL,'1461174471',NULL,NULL,NULL,'0',NULL),
('391',NULL,'CD-201504221391',NULL,NULL,'2',NULL,NULL,'1461174471',NULL,NULL,NULL,'0',NULL),
('392',NULL,'CD-201504228867',NULL,NULL,'2',NULL,NULL,'1461174471',NULL,NULL,NULL,'0',NULL),
('393',NULL,'CD-201504222914',NULL,NULL,'2',NULL,NULL,'1461174471',NULL,NULL,NULL,'0',NULL),
('394',NULL,'CD-201504229501',NULL,NULL,'2',NULL,NULL,'1461174471',NULL,NULL,NULL,'0',NULL),
('395',NULL,'CD-201504224438',NULL,NULL,'2',NULL,NULL,'1461174471',NULL,NULL,NULL,'0',NULL),
('396',NULL,'CD-201504223411',NULL,NULL,'2',NULL,NULL,'1461174471',NULL,NULL,NULL,'0',NULL),
('397',NULL,'CD-201504222703',NULL,NULL,'2',NULL,NULL,'1461174471',NULL,NULL,NULL,'0',NULL),
('398',NULL,'CD-201504221831',NULL,NULL,'2',NULL,NULL,'1461174471',NULL,NULL,NULL,'0',NULL),
('399',NULL,'CD-201504222081',NULL,NULL,'2',NULL,NULL,'1461174471',NULL,NULL,NULL,'0',NULL),
('400',NULL,'CD-201504224580',NULL,NULL,'2',NULL,NULL,'1461174471',NULL,NULL,NULL,'0',NULL),
('401',NULL,'CD-201504229340',NULL,NULL,'2',NULL,NULL,'1461174472',NULL,NULL,NULL,'0',NULL),
('402',NULL,'CD-201504226242',NULL,NULL,'2',NULL,NULL,'1461174472',NULL,NULL,NULL,'0',NULL),
('403',NULL,'CD-201504225088',NULL,NULL,'2',NULL,NULL,'1461174472',NULL,NULL,NULL,'0',NULL),
('404',NULL,'CD-201504224931',NULL,NULL,'2',NULL,NULL,'1461174472',NULL,NULL,NULL,'0',NULL),
('405',NULL,'CD-201504224005',NULL,NULL,'2',NULL,NULL,'1461174472',NULL,NULL,NULL,'0',NULL),
('406',NULL,'CD-201504228215',NULL,NULL,'2',NULL,NULL,'1461174472',NULL,NULL,NULL,'0',NULL),
('407',NULL,'CD-201504223210',NULL,NULL,'2',NULL,NULL,'1461174472',NULL,NULL,NULL,'0',NULL),
('408',NULL,'CD-201504223722',NULL,NULL,'2',NULL,NULL,'1461174472',NULL,NULL,NULL,'0',NULL),
('409',NULL,'CD-201504221841',NULL,NULL,'2',NULL,NULL,'1461174472',NULL,NULL,NULL,'0',NULL),
('410',NULL,'CD-201504222123',NULL,NULL,'2',NULL,NULL,'1461174472',NULL,NULL,NULL,'0',NULL),
('411',NULL,'CD-201504227372',NULL,NULL,'2',NULL,NULL,'1461174472',NULL,NULL,NULL,'0',NULL),
('412',NULL,'CD-201504224189',NULL,NULL,'2',NULL,NULL,'1461174472',NULL,NULL,NULL,'0',NULL),
('413',NULL,'CD-201504225526',NULL,NULL,'2',NULL,NULL,'1461174473',NULL,NULL,NULL,'0',NULL),
('414',NULL,'CD-201504226804',NULL,NULL,'2',NULL,NULL,'1461174473',NULL,NULL,NULL,'0',NULL),
('415',NULL,'CD-201504225103',NULL,NULL,'2',NULL,NULL,'1461174473',NULL,NULL,NULL,'0',NULL),
('416',NULL,'CD-201504228575',NULL,NULL,'2',NULL,NULL,'1461174473',NULL,NULL,NULL,'0',NULL),
('417',NULL,'CD-201504221181',NULL,NULL,'2',NULL,NULL,'1461174473',NULL,NULL,NULL,'0',NULL),
('418',NULL,'CD-201504221217',NULL,NULL,'2',NULL,NULL,'1461174473',NULL,NULL,NULL,'0',NULL),
('419',NULL,'CD-201504225045',NULL,NULL,'2',NULL,NULL,'1461174473',NULL,NULL,NULL,'0',NULL),
('420',NULL,'CD-201504224254',NULL,NULL,'2',NULL,NULL,'1461174473',NULL,NULL,NULL,'0',NULL),
('421',NULL,'CD-201504222484',NULL,NULL,'2',NULL,NULL,'1461174473',NULL,NULL,NULL,'0',NULL),
('422',NULL,'CD-201504228154',NULL,NULL,'2',NULL,NULL,'1461174473',NULL,NULL,NULL,'0',NULL),
('423',NULL,'CD-201504229879',NULL,NULL,'2',NULL,NULL,'1461174474',NULL,NULL,NULL,'0',NULL),
('424',NULL,'CD-201504225963',NULL,NULL,'2',NULL,NULL,'1461174474',NULL,NULL,NULL,'0',NULL),
('425',NULL,'CD-201504228712',NULL,NULL,'2',NULL,NULL,'1461174474',NULL,NULL,NULL,'0',NULL),
('426',NULL,'CD-201504221526',NULL,NULL,'2',NULL,NULL,'1461174474',NULL,NULL,NULL,'0',NULL),
('427',NULL,'CD-20150422959',NULL,NULL,'2',NULL,NULL,'1461174474',NULL,NULL,NULL,'0',NULL),
('428',NULL,'CD-201504225455',NULL,NULL,'2',NULL,NULL,'1461174474',NULL,NULL,NULL,'0',NULL),
('429',NULL,'CD-201504221383',NULL,NULL,'2',NULL,NULL,'1461174474',NULL,NULL,NULL,'0',NULL),
('430',NULL,'CD-201504223327',NULL,NULL,'2',NULL,NULL,'1461174474',NULL,NULL,NULL,'0',NULL),
('431',NULL,'CD-201504221656',NULL,NULL,'2',NULL,NULL,'1461174474',NULL,NULL,NULL,'0',NULL),
('432',NULL,'CD-201504229467',NULL,NULL,'2',NULL,NULL,'1461174474',NULL,NULL,NULL,'0',NULL),
('433',NULL,'CD-201504221822',NULL,NULL,'2',NULL,NULL,'1461174474',NULL,NULL,NULL,'0',NULL),
('434',NULL,'CD-201504229057',NULL,NULL,'2',NULL,NULL,'1461174474',NULL,NULL,NULL,'0',NULL),
('435',NULL,'CD-201504223766',NULL,NULL,'2',NULL,NULL,'1461174474',NULL,NULL,NULL,'0',NULL),
('436',NULL,'CD-201504226533',NULL,NULL,'2',NULL,NULL,'1461174475',NULL,NULL,NULL,'0',NULL),
('437',NULL,'CD-201504226851',NULL,NULL,'2',NULL,NULL,'1461174475',NULL,NULL,NULL,'0',NULL),
('438',NULL,'CD-201504223669',NULL,NULL,'2',NULL,NULL,'1461174475',NULL,NULL,NULL,'0',NULL),
('439',NULL,'CD-201504225231',NULL,NULL,'2',NULL,NULL,'1461174475',NULL,NULL,NULL,'0',NULL),
('440',NULL,'CD-201504229607',NULL,NULL,'2',NULL,NULL,'1461174475',NULL,NULL,NULL,'0',NULL),
('441',NULL,'CD-201504226137',NULL,NULL,'2',NULL,NULL,'1461174475',NULL,NULL,NULL,'0',NULL),
('442',NULL,'CD-201504224308',NULL,NULL,'2',NULL,NULL,'1461174475',NULL,NULL,NULL,'0',NULL),
('443',NULL,'CD-20150422925',NULL,NULL,'2',NULL,NULL,'1461174475',NULL,NULL,NULL,'0',NULL),
('444',NULL,'CD-201504225637',NULL,NULL,'2',NULL,NULL,'1461174475',NULL,NULL,NULL,'0',NULL),
('445',NULL,'CD-201504223624',NULL,NULL,'2',NULL,NULL,'1461174475',NULL,NULL,NULL,'0',NULL),
('446',NULL,'CD-201504226437',NULL,NULL,'2',NULL,NULL,'1461174475',NULL,NULL,NULL,'0',NULL),
('447',NULL,'CD-201504222639',NULL,NULL,'2',NULL,NULL,'1461174475',NULL,NULL,NULL,'0',NULL),
('448',NULL,'CD-201504222268',NULL,NULL,'2',NULL,NULL,'1461174475',NULL,NULL,NULL,'0',NULL),
('449',NULL,'CD-201504222810',NULL,NULL,'2',NULL,NULL,'1461174476',NULL,NULL,NULL,'0',NULL),
('450',NULL,'CD-201504227900',NULL,NULL,'2',NULL,NULL,'1461174476',NULL,NULL,NULL,'0',NULL),
('451',NULL,'CD-201504227469',NULL,NULL,'2',NULL,NULL,'1461174476',NULL,NULL,NULL,'0',NULL),
('452',NULL,'CD-201504223818',NULL,NULL,'2',NULL,NULL,'1461174476',NULL,NULL,NULL,'0',NULL),
('453',NULL,'CD-201504227640',NULL,NULL,'2',NULL,NULL,'1461174476',NULL,NULL,NULL,'0',NULL),
('454',NULL,'CD-201504228748',NULL,NULL,'2',NULL,NULL,'1461174476',NULL,NULL,NULL,'0',NULL),
('455',NULL,'CD-201504227937',NULL,NULL,'2',NULL,NULL,'1461174476',NULL,NULL,NULL,'0',NULL),
('456',NULL,'CD-201504227578',NULL,NULL,'2',NULL,NULL,'1461174476',NULL,NULL,NULL,'0',NULL),
('457',NULL,'CD-201504227235',NULL,NULL,'2',NULL,NULL,'1461174476',NULL,NULL,NULL,'0',NULL),
('458',NULL,'CD-201504224686',NULL,NULL,'2',NULL,NULL,'1461174476',NULL,NULL,NULL,'0',NULL),
('459',NULL,'CD-201504223535',NULL,NULL,'2',NULL,NULL,'1461174476',NULL,NULL,NULL,'0',NULL),
('460',NULL,'CD-201504224514',NULL,NULL,'2',NULL,NULL,'1461174476',NULL,NULL,NULL,'0',NULL),
('461',NULL,'CD-201504227437',NULL,NULL,'2',NULL,NULL,'1461174476',NULL,NULL,NULL,'0',NULL),
('462',NULL,'CD-201504227123',NULL,NULL,'2',NULL,NULL,'1461174477',NULL,NULL,NULL,'0',NULL),
('463',NULL,'CD-201504224222',NULL,NULL,'2',NULL,NULL,'1461174477',NULL,NULL,NULL,'0',NULL),
('464','6b2f1b36-ea25-11e4-a4de-00163e0e2b8e','CD-20150424771',NULL,NULL,'1',NULL,NULL,'1461376716',NULL,NULL,NULL,'0',NULL),
('465','6b402282-ea25-11e4-a4de-00163e0e2b8e','CD-201504241022',NULL,NULL,'1',NULL,NULL,'1461376716',NULL,NULL,NULL,'0',NULL),
('466','6b4b3082-ea25-11e4-a4de-00163e0e2b8e','CD-201504247947',NULL,NULL,'1',NULL,NULL,'1461376716',NULL,NULL,NULL,'0',NULL),
('467','6b5bc320-ea25-11e4-a4de-00163e0e2b8e','CD-201504245903',NULL,NULL,'1',NULL,NULL,'1461376716',NULL,NULL,NULL,'0',NULL),
('468','6b66cc52-ea25-11e4-a4de-00163e0e2b8e','CD-201504241837',NULL,NULL,'1',NULL,NULL,'1461376716',NULL,NULL,NULL,'0',NULL),
('469','6b71cf26-ea25-11e4-a4de-00163e0e2b8e','CD-201504248577',NULL,NULL,'1',NULL,NULL,'1461376716',NULL,NULL,NULL,'0',NULL),
('470','6b7cd998-ea25-11e4-a4de-00163e0e2b8e','CD-201504247949',NULL,NULL,'1',NULL,NULL,'1461376716',NULL,NULL,NULL,'0',NULL),
('471','6b87e9f0-ea25-11e4-a4de-00163e0e2b8e','CD-201504245632',NULL,NULL,'1',NULL,NULL,'1461376716',NULL,NULL,NULL,'0',NULL),
('472','6b930718-ea25-11e4-a4de-00163e0e2b8e','CD-201504248586',NULL,NULL,'1',NULL,NULL,'1461376716',NULL,NULL,NULL,'0',NULL),
('473','6b9e1ae0-ea25-11e4-a4de-00163e0e2b8e','CD-201504249003',NULL,NULL,'1',NULL,NULL,'1461376716',NULL,NULL,NULL,'0',NULL);-- <xjx> --

-- 表的数据：franchisee_carddiscount --
INSERT INTO `franchisee_carddiscount` VALUES
('1','1','1429857256','1','1430124512'),
('2','2','1429857270','1','1430124515'),
('3','3','1429857263','1','1430124517');-- <xjx> --

-- 表的数据：franchisee_cardtype --
INSERT INTO `franchisee_cardtype` VALUES
('5',NULL,'????12',NULL),
('6',NULL,'????1',NULL),
('8','123456','????',NULL),
('9','123456','?????',NULL);-- <xjx> --

-- 表的数据：franchisee_category --
INSERT INTO `franchisee_category` VALUES
('9','42e882e9-d380-11e4-b4d7-5404a6a7fdf8','123456','11111111','0','0','',NULL),
('10','49eb71e6-d380-11e4-b4d7-5404a6a7fdf8','123456','222222','42e882e9-d380-11e4-b4d7-5404a6a7fdf8','0','',NULL),
('11','123',NULL,'1111111123','0','1','21321',NULL),
('12','1234',NULL,'222222','0','1','11111111',NULL),
('13','12',NULL,'33333','0','0','',NULL),
('14','34',NULL,'4444','0','0','',NULL),
('15','213',NULL,'555555555','7','0','',NULL),
('16','457',NULL,'6666666666','8','0','',NULL),
('17','2321',NULL,'77777777777','4','0','',NULL),
('18','756765',NULL,'88888888888','6','0','',NULL),
('19','65464',NULL,'131321','6','13','23123',NULL),
('20','645435432',NULL,'dad','7','2','dsads',NULL),
('21','64586278-e6d7-11e4-a4de-00163e0e2b8e',NULL,'55555','','21','54353',NULL),
('22','65c2518c-e6d7-11e4-a4de-00163e0e2b8e',NULL,'55555','','21','54353',NULL),
('23','6642d898-e6d7-11e4-a4de-00163e0e2b8e',NULL,'55555','','21','54353',NULL),
('24','6794fe92-e6d7-11e4-a4de-00163e0e2b8e',NULL,'55555','','21','54353',NULL);-- <xjx> --

-- 表的数据：franchisee_order --
INSERT INTO `franchisee_order` VALUES
('9','c749c18c-d50c-11e4-823f-5404a6a7fdf8','123456','1503280139219e4a02','0.00','0.00','0','1427521161','111111111','0'),
('10','ff826ae8-d50c-11e4-823f-5404a6a7fdf8','123456','15032801405684019b','0.00','0.00','1','1427521256','22','0'),
('11','25eab3c4-d50d-11e4-823f-5404a6a7fdf8','123456','1503280142008ab33e','0.00','0.00','2','1427521320','3333333333','0'),
('12','4bb6a20b-d50d-11e4-823f-5404a6a7fdf8','123456','15032801430481c17c','0.00','0.00','3','1427521384','444444455555','0'),
('13','63b7205c-d50d-11e4-823f-5404a6a7fdf8','123456','15032801434405e159','0.00','0.00','4','1427521424','6','0'),
('14','8c5f090c-d50d-11e4-823f-5404a6a7fdf8','123456','150328014452491bba','0.00','0.00','5','1427521492','77777777','1'),
('16','2e71058e-e4e3-11e4-a4de-00163e0e2b8e','123456','150417052151f91929','1696.00','0.00','5','1429262511','??11','0'),
('17','25a7b1c8-e588-11e4-a4de-00163e0e2b8e','123456','1504180102433dd492','20.00','0.00','5','1429333363','','0'),
('18','2e71058e-e4e3-11e4-a4de-00163e0e2b8c','123456','150417052151f91929','0.00','0.00','2','1429333363',NULL,'0'),
('19','8ef284e6-e8a8-11e4-a4de-00163e0e2b8e','123456','1504221232171db529','1220.00','0.00','0','1429677137','','0');-- <xjx> --

-- 表的数据：franchisee_ordercart --
INSERT INTO `franchisee_ordercart` VALUES
('6','','2','1');-- <xjx> --

-- 表的数据：franchisee_orderinfo --
INSERT INTO `franchisee_orderinfo` VALUES
('5','1503280139219e4a02','10','1','0.00','0','1'),
('6','1503280139219e4a02','100','2','0.00','0','1'),
('7','15032801405684019b','1','1','0.00','0','1'),
('8','1503280142008ab33e','1','2','0.00','0','1'),
('9','15032801430481c17c','13','1','0.00','0','1'),
('10','15032801430481c17c','12','2','0.00','0','1'),
('11','15032801434405e159','1','1','0.00','2','1'),
('12','150328014452491bba','1','2','0.00','0','1'),
('15','150417052151f91929','11','2','20.00','0','1'),
('16','150417052151f91929','12','3','123.00','0','1'),
('17','1504180102433dd492','1','2','20.00','0','1'),
('18','1504221232171db529','12','1','100.00','0','1'),
('19','1504221232171db529','1','2','20.00','0','1');-- <xjx> --

-- 表的数据：franchisee_product --
INSERT INTO `franchisee_product` VALUES
('1','123456','4f921899-cf96-11e4-9b1e-5404a6a7fdf8','11111','121212','/data/2015/03/21/201503211426920522.jpg','3','2222','3333','2014','111.00','200.00','100','1000','50','1','0','31231232312','150.00','0','0'),
('2','123456','0ba8806a-d48a-11e4-823f-5404a6a7fdf8',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0.00','0.00','0','0','0','0','0','','0.00','0','0');-- <xjx> --

-- 表的数据：franchisee_userorder --
INSERT INTO `franchisee_userorder` VALUES
('1','12345678','123456','12','0.00','0','0','12','??','13678154392','0','0','0','??',NULL,'??','0','0',NULL,'1');-- <xjx> --

-- 表的数据：franchisee_userorderinfo --
INSERT INTO `franchisee_userorderinfo` VALUES
('1','12345678','2','10.00','20.00','30.00','1','4f921899-cf96-11e4-9b1e-5404a6a7fdf8');-- <xjx> --

-- 表的数据：product_apply --
INSERT INTO `product_apply` VALUES
('1','123456','????1','1','2','1','0','7','111111111','0','1430150400','12312.00','312312','POS???????.doc','/data/2015/04/28/201504281430211691.doc','1','123.00','2'),
('2','e94bd2ce-e684-11e4-a4de-00163e0e2b8e','1231','1','1','1','0','3','123123','0',NULL,'0.00',NULL,NULL,NULL,'0','0.00','2'),
('3','89fb4244-e7da-11e4-a4de-00163e0e2b8e','??','1','2','1','1','3','?????????10? ??-??<br />','0',NULL,'0.00',NULL,NULL,NULL,'0','0.00','2'),
('4','821d3122-e7e4-11e4-a4de-00163e0e2b8e','111111112','1','1','1','1','3','31231231','0',NULL,'0.00',NULL,NULL,NULL,'0','0.00','2'),
('5','82bcbf9e-e7e4-11e4-a4de-00163e0e2b8e','111111112','1','1','0','0','1','31231231','0',NULL,'0.00',NULL,NULL,NULL,'0','0.00','2');-- <xjx> --

-- 表的数据：product_brand --
INSERT INTO `product_brand` VALUES
('1','123456','????1','????????2','/data/2015/03/27/201503271427433222.png','1427433222','10'),
('4',NULL,'123','321312','/data/2015/04/29/201504291430293344.jpg','1430293344','11');-- <xjx> --

-- 表的数据：product_goods --
INSERT INTO `product_goods` VALUES
('1','4f921899-cf96-11e4-9b1e-5404a6a7fdf8','11111','121212','/data/2015/04/20/201504201429469318.png','1234','123456','2222','3333','1000','111.00','200.00','100.00','102','1000','50','1','0','31231232312','150.00','12',NULL),
('2','4a7b0955-d443-11e4-823f-5404a6a7fdf8','123456789','??','/data/2015/03/27/201503271427434620.png','123','1234567','pijiu','??','2015','12.00','28.00','20.00','402','1000','100','1','0','????????????????????','20.00','100','100'),
('3','304bb28c-e4ca-11e4-a4de-00163e0e2b8e','123','123','/data/2015/04/17/201504171429262263.png','1234','1234567','123','123','123','123.00','123.00','123.00','123','123','132','1','0','132','123.00','100','100'),
('4','42e71f26-e4ca-11e4-a4de-00163e0e2b8e','123','123',NULL,'4','1','123','123','123','123.00','123.00','123.00','123','123','123','1','0','123','123.00',NULL,NULL),
('5','b234047c-ee4d-11e4-ba5b-00163e000efe','12313','3213','/data/2015/04/29/201504291430297624.jpg','12','4','123123','12312','312','12331.00','3131.00','312312.00','312312','312312','3123123','1','1','3123123123','32131.00',NULL,NULL);-- <xjx> --

-- 表的数据：product_goodscategory --
INSERT INTO `product_goodscategory` VALUES
('4','1111111123','0','1','21321','123'),
('6','222222','0','1','11111111','1234'),
('7','33333','0','0','','12'),
('8','4444','0','0','','34'),
('10','555555555','7','0','','213'),
('11','6666666666','8','0','','457'),
('12','77777777777','4','0','','2321'),
('13','88888888888','6','0','','756765'),
('14','131321','6','13','23123','65464'),
('15','dad','7','2','dsads','645435432'),
('16','55555','','21','54353','64586278-e6d7-11e4-a4de-00163e0e2b8e'),
('17','55555','','21','54353','65c2518c-e6d7-11e4-a4de-00163e0e2b8e'),
('18','55555','','21','54353','6642d898-e6d7-11e4-a4de-00163e0e2b8e'),
('19','55555','','21','54353','6794fe92-e6d7-11e4-a4de-00163e0e2b8e'),
('20','31231','','123123','3123123','a9a89831-ee4f-11e4-ba5b-00163e000efe'),
('21','3131','','312312','32131','1378f177-ee50-11e4-ba5b-00163e000efe'),
('22','321','4','321','321','aef165cd-ee50-11e4-ba5b-00163e000efe'),
('23','12313','7','12313','123123','b6019bad-ee50-11e4-ba5b-00163e000efe');-- <xjx> --

-- 表的数据：product_house --
INSERT INTO `product_house` VALUES
('6','??222',NULL),
('7','111111',NULL);-- <xjx> --

-- 表的数据：product_housepos --
INSERT INTO `product_housepos` VALUES
('5','0','????12',NULL),
('6','0','????1',NULL),
('7','6','???111122',NULL);-- <xjx> --

-- 表的数据：product_order --
INSERT INTO `product_order` VALUES
('9','c749c18c-d50c-11e4-823f-5404a6a7fdf8','123456','1503280139219e4a02','0.00','0.00','-1','1427521161','111111111','1',NULL,NULL,NULL,NULL),
('10','ff826ae8-d50c-11e4-823f-5404a6a7fdf8','123456','15032801405684019b','0.00','0.00','1','1427521256','22','0',NULL,NULL,NULL,NULL),
('11','25eab3c4-d50d-11e4-823f-5404a6a7fdf8','123456','1503280142008ab33e','0.00','0.00','2','1427521320','3333333333','0',NULL,NULL,NULL,NULL),
('12','4bb6a20b-d50d-11e4-823f-5404a6a7fdf8','123456','15032801430481c17c','0.00','0.00','3','1427521384','444444455555','0',NULL,NULL,NULL,NULL),
('13','63b7205c-d50d-11e4-823f-5404a6a7fdf8','123456','15032801434405e159','0.00','0.00','4','1427521424','6','0',NULL,NULL,NULL,NULL),
('14','8c5f090c-d50d-11e4-823f-5404a6a7fdf8','123456','150328014452491bba','0.00','0.00','5','1427521492','77777777','0',NULL,NULL,NULL,NULL),
('15','7b820e93-e4db-11e4-8189-5404a6a7fdf8','123456','1504170426444d050c','0.00','0.00','-1','1429259204','??111','0',NULL,NULL,NULL,NULL),
('16','41dfcd58-e4dc-11e4-8189-5404a6a7fdf8','123456','1504170432171b43c5','120.00','0.00','-1','1429259537','??111','0',NULL,NULL,NULL,NULL),
('17','895a936e-e4dc-11e4-8189-5404a6a7fdf8','123456','1504170434179a2099','1340.00','0.00','0','1429259657','??11','0',NULL,NULL,NULL,NULL);-- <xjx> --

-- 表的数据：product_ordercart --
INSERT INTO `product_ordercart` VALUES
('5','4','1','5'),
('6','4','2','3'),
('7','1','2','1'),
('8','1','3','1');-- <xjx> --

-- 表的数据：product_orderinfo --
INSERT INTO `product_orderinfo` VALUES
('5','2147483647','10','1','0.00','0','1','0','0'),
('6','2147483647','100','2','0.00','0','1','0','0'),
('7','2147483647','1','1','0.00','0','1','0','0'),
('8','2147483647','1','2','0.00','0','1','0','0'),
('9','2147483647','13','1','0.00','0','1','0','0'),
('10','2147483647','12','2','0.00','0','1','0','0'),
('11','2147483647','1','1','0.00','2','1','0','0'),
('12','2147483647','1','2','0.00','0','1','0','0'),
('13','2147483647','10','1','100.00','0','1','0','0'),
('14','2147483647','12','2','20.00','0','1','0','0'),
('15','2147483647','11','1','100.00','0','1','0','0'),
('16','2147483647','12','2','20.00','0','1','0','0'),
('17','2147483647','11','1','100.00','0','1','0','0'),
('18','2147483647','12','2','20.00','0','1','0','0'),
('19','1','1','2','12.00','0','1','0','0'),
('20','1','1','3','123.00','0','1','0','0');-- <xjx> --

-- 表的数据：product_paganda --
INSERT INTO `product_paganda` VALUES
('1','43242432','/data/2015/04/29/201504291430277372.jpg','2015-04-29 11:16:12.000000');-- <xjx> --

-- 表的数据：product_productontime --
INSERT INTO `product_productontime` VALUES
('17','4','1427385600','110'),
('18','4f921899-cf96-11e4-9b1e-5404a6a7fdf8','1425398400','100'),
('19','4f921899-cf96-11e4-9b1e-5404a6a7fdf8','1427385600','200'),
('20','4a7b0955-d443-11e4-823f-5404a6a7fdf8','1427817600','200');-- <xjx> --

-- 表的数据：product_upload --
INSERT INTO `product_upload` VALUES
('11','123123','/data/2015/04/28/201504281430211889.xls','2015-04-28 17:04:49'),
('10','1423423','/data/2015/04/28/201504281430211237.doc','2015-04-28 16:53:57'),
('12','111','/data/2015/04/28/201504281430211934.jpg','2015-04-28 17:05:34'),
('13','5454','/data/2015/04/29/201504291430276657.jpg','2015-04-29 11:04:17');-- <xjx> --

-- 表的数据：product_user --
INSERT INTO `product_user` VALUES
('1','leechongguo@163.com','??','1','/data/2015/04/28/201504281430203626.jpg','1991-03-05');-- <xjx> --

-- 表的数据：product_webinfo --
INSERT INTO `product_webinfo` VALUES
('1','1','6','121212','21212121','1430216769','2'),
('2','6','1','fds fdsf','fsafsdfdsf','1430216852','1'),
('3','6','1','121211','121212121','1430216893','1'),
('5','6','1','23231423','423424242','1430218246','1'),
('6','2','1','21343242','423424242','1430218291','1'),
('7','6','1','2131313','3213131313','1430218313','1'),
('8','2','1','21343242','423424242','1430218320','1'),
('9','2','1','11111111','222222222222222222444','1430218381','1');-- <xjx> --

-- 表的数据：shop_admin --
INSERT INTO `shop_admin` VALUES
('1','13dfd','admin','e10adc3949ba59abbe56e057f20f883e','1430293430','127.0.0.1','1','1428469794','1'),
('2','dfdfgfg','cici','e10adc3949ba59abbe56e057f20f883e','1396233476','127.0.0.1','0','12121','2'),
('20','','aa','e10adc3949ba59abbe56e057f20f883e','1430129696','','1','1429599476','1');-- <xjx> --

-- 表的数据：shop_advinfo --
INSERT INTO `shop_advinfo` VALUES
('2','3','???','44444','/data/2015/04/29/201504291430291778.jpg','4','www.baidu.com123','1'),
('3','3','???','12312312','/data/2015/04/29/201504291430291763.jpg','2','www.baidu.com','1'),
('4','3','???','312312','/data/2015/04/29/201504291430291075.jpg','2','www.baidu.com','1'),
('5','1','???','423423','/data/2015/04/29/201504291430291094.jpg','423423','12342342','1');-- <xjx> --

-- 表的数据：shop_cardinfo --
INSERT INTO `shop_cardinfo` VALUES
('1','21201','100','dsa','312213','3213213','fgfdg','42321321','4135','4532131','sgfdgsd','gfdgsfsd','1','13123'),
('2','677654','45123','hgjh','46512315','5454352','tyrytrey','15313213','4516231','13132131','ytreytr','ytreytr','0','21321'),
('3','5656456354','6546354','gfdgsdf','g4321423','5454352','43243fdfsd','231434','432432','432143','gfdgfdg','fgfdsgfd','1','21432423');-- <xjx> --

-- 表的数据：shop_cardtype --
INSERT INTO `shop_cardtype` VALUES
('1','dfdsa','???','3213213'),
('2','fgfdgfdg','??','5454352');-- <xjx> --

-- 表的数据：shop_cmscategory --
INSERT INTO `shop_cmscategory` VALUES
('29','213213',NULL,'0',NULL,'3213','321321'),
('30','432432',NULL,'29',NULL,'fdsfd','321321');-- <xjx> --

-- 表的数据：shop_cmsinfo --
INSERT INTO `shop_cmsinfo` VALUES
('44','1212','/data/2015/04/22/201504221429697200.jpg','123','7','','1','1429701333','0','0','-2147483648',NULL),
('46','123546','/data/2015/04/27/201504271430121732.jpg','10000','4','','0','1430121693','0','0','1429076700',NULL);-- <xjx> --

-- 表的数据：shop_goodsbrand --
INSERT INTO `shop_goodsbrand` VALUES
('1','123456','??','/data/2015/04/24/201504241429864608.jpg','1427433222','0','0','gongniu','1','217'),
('3','1234567','??','/data/2015/04/23/201504231429752069.jpg','1427433358','1','0','sanyecao','1','217'),
('4','cea522d0-e8ec-11e4-a4de-00163e0e2b8e','2324','/data/2015/04/24/201504241429864594.jpg','0','0','0','',NULL,'217'),
('5','f98fba3c-e8f1-11e4-a4de-00163e0e2b8e','2324','/data/2015/04/24/201504241429864580.jpg','0','0','1','',NULL,'217');-- <xjx> --

-- 表的数据：shop_goodscategory --
INSERT INTO `shop_goodscategory` VALUES
('222','????','0','457',NULL,'1','','1'),
('223','???????','0','2321',NULL,'2','','1'),
('225','????','0','65464',NULL,'4','23123','1'),
('226','?????','0','645435432',NULL,'3','dsads','1'),
('227','????','0','64586278-e6d7-11e4-a4de-00163e0e2b8e',NULL,'5','54353','1'),
('232','??�????????','222','721d5e93-ed66-11e4-ba5b-00163e000efe',NULL,'1','aaaaaaaaaaaa','1'),
('233','??�????????','222','2b30c60f-ed6f-11e4-ba5b-00163e000efe',NULL,'1','','1'),
('234','??�????????','222','2b4270c8-ed75-11e4-ba5b-00163e000efe',NULL,'1','','1'),
('235','??�????????','223','34ec1ea7-ed75-11e4-ba5b-00163e000efe',NULL,'1','','1'),
('236','??�????????','226','3b9bbc35-ed75-11e4-ba5b-00163e000efe',NULL,'1','','1'),
('237','??�????????','225','420d94d8-ed75-11e4-ba5b-00163e000efe',NULL,'111112','','1'),
('238','??�????????','227','474da4a3-ed75-11e4-ba5b-00163e000efe',NULL,'2','','1'),
('239','??�????????','0','3a65d93d-ed7a-11e4-ba5b-00163e000efe',NULL,'6','','1'),
('240','??�????????','232','7d932261-ed7a-11e4-ba5b-00163e000efe',NULL,'1','','1'),
('241','??�????????','233','8672a1fc-ed7a-11e4-ba5b-00163e000efe',NULL,'1','','1'),
('242','??�????????','234','8e4c2d4f-ed7a-11e4-ba5b-00163e000efe',NULL,'1','','1'),
('243','??�????????','234','96cf9aa7-ed7a-11e4-ba5b-00163e000efe',NULL,'1','','1'),
('244','??�????????','239','a1567a28-ed7a-11e4-ba5b-00163e000efe',NULL,'1','','1'),
('245','??�????????','232','b068847f-ed7a-11e4-ba5b-00163e000efe',NULL,'1','','1'),
('246','????','0','5f92e9a0-ee2d-11e4-ba5b-00163e000efe',NULL,'7','','1'),
('249','??�????????','235','44de3c56-ee39-11e4-ba5b-00163e000efe',NULL,'1','','1');-- <xjx> --

-- 表的数据：shop_goodsinfo --
INSERT INTO `shop_goodsinfo` VALUES
('1','4a7b0955-d443-11e4-823f-5404a6a7fdf8','11111','???','/data/2015/04/29/201504291430291260.jpg','457','1','2222','3333','1000','111.00','200.00','100.00','100','1000','50','1','0',NULL,'0.00','1','0','0'),
('2','35daa840-ee44-11e4-ba5b-00163e000efe','1232','??','/data/2015/04/29/201504291430293745.jpg','2321','1','123','123123','123123','123123.00','12312.00','123123.00','1231','12312','2321','1','0','','122.00','1','0','0'),
('3','4ba10b8e-ee44-11e4-ba5b-00163e000efe','1231','12313','/data/2015/04/29/201504291430293782.jpg','457','1','12312','21321','1231','1231.00','12312.00','1231.00','12312','12312','12312','1','0','','23123.00','1','0','0'),
('4','61b943f2-ee44-11e4-ba5b-00163e000efe','1231','1231','/data/2015/04/29/201504291430293819.jpg','457','3','12312','1231','12312','1231.00','2131.00','1231.00','123','13','123','1','0','','1231.00','1','0','0'),
('5','35b264fe-ee47-11e4-ba5b-00163e000efe','123','213','/data/2015/04/29/201504291430295033.jpg','457','1','123','123','123','123.00','123.00','213.00','1231','123','123','1','0','','123.00','1','0','0'),
('6','49ac3290-ee47-11e4-ba5b-00163e000efe','123','123','/data/2015/04/29/201504291430295067.jpg','2321','1','123','123','123','123.00','123.00','123.00','123','123','23','1','0','','123.00','1','0','0'),
('7','5f4b451a-ee47-11e4-ba5b-00163e000efe','123','123','/data/2015/04/29/201504291430295103.jpg','457','1','123','123','123','123.00','123.00','123.00','123','123','123','1','0','','123.00','1','0','0'),
('8','f1eb22b8-ee47-11e4-ba5b-00163e000efe','123','1234','/data/2015/04/29/201504291430295349.jpg','457','1','123','123','123','213.00','123.00','213.00','123','123','123','1','0','','213.00','1','0','0');-- <xjx> --

-- 表的数据：shop_ordersdetail --
INSERT INTO `shop_ordersdetail` VALUES
('1','1','12','10.00','12.00','11.00','1','4a7b0955-d443-11e4-823f-5404a6a7fdf8'),
('2','232','23','110.00','150.00','140.00','1','4a7b0955-d443-11e4-823f-5404a6a7fdf8');-- <xjx> --

-- 表的数据：shop_ordersinfo --
INSERT INTO `shop_ordersinfo` VALUES
('1','1','123456','15','12.00','0','1','1213','dsada','45612323','21','12','12','0','456123132','0','1','2','0','0','1',NULL),
('2','232','123456','15666','12.00','0','1','134554','13678134392','45612323','21','12','12','0','456123132','0','1','0','0','0','1',NULL);-- <xjx> --

-- 表的数据：system_admin --
INSERT INTO `system_admin` VALUES
('1','13dfd','admin','e10adc3949ba59abbe56e057f20f883e','1428472845','127.0.0.1','1','1399529131','1'),
('2','dfdfgfg','qq','e10adc3949ba59abbe56e057f20f883e','1396233476','127.0.0.1','1','12121','1'),
('6','323234','lili','12123232','142','127.0.0.1','1','1111','1');-- <xjx> --

-- 表的数据：system_category --
INSERT INTO `system_category` VALUES
('1','111','','0','',NULL,'','8','1'),
('21','???','?? ?? ??','1',NULL,'/data/2015/04/19/201504191429421415.jpg','???? ????','1','1');-- <xjx> --

-- 表的数据：system_group --
INSERT INTO `system_group` VALUES
('1','?????','1'),
('2','?????','0'),
('4','??','1'),
('5','adawqe','1');-- <xjx> --

-- 表的数据：system_group_menu --
INSERT INTO `system_group_menu` VALUES
('1','e1ab838d7cd885d2965d22ba83a94b3b'),
('1','fd4c8e9d65f6c4243613e147e75d5450'),
('1','ae5e5442ac7d5cbbfa0f71dbcc8d6dbd'),
('1','89c2409cff285d97846bebba0ab1ba08'),
('1','b295a79f64acdf6a99f18e5aa0ed5bd9'),
('1','55948aed543573fe160a24c475b9f33e'),
('1','038f4089d471c33ab24e9f4ba95817d2'),
('1','9c7d5eea01acee7fb6da3787bd5bfa63'),
('1','bdccdc5b31931c3c1f5b673d51324081'),
('1','2abc64458fe7ac8d9cbea97119a129f4'),
('1','5c98f85cbaa05e0a33648cf398107486'),
('1','dd886403400bdabe5f42416c9f60a3b4'),
('1','b30016eaafc16fdd945e9e2497e736b4'),
('1','29a9efd9d385b4896be9875e1d43610a'),
('1','e6869d0e4e77019c29712a3117b7f6b0'),
('1','842687063c2646a2f524b1847d354034'),
('1','a0a9300682db04fb3f291188b4795572'),
('1','8ebf1db405601896535d8e94c69101e9'),
('1','806fec89cbb902ca6c1af2cd0c8b2cc8'),
('1','025086c730b3e267cb9fbcf5fb8e4690'),
('1','60ee38c34b2648c570a648b0eeb54e62'),
('1','7383e45ce458cfc9c59b4bff1be77e7c'),
('1','481ad93afa6b863fa900a55aea6e583b'),
('1','26b2e339af7d6a9a1dffba3801a8fdac'),
('1','d1d39379d4a4a0a87b6c66d5dc30039b'),
('1','aa2183e828e5349a215b5214abd7474f'),
('1','5b7dabec4068eedc5f385fad5fac1734'),
('1','0d01af220967b414ef6c1b764aee406c'),
('1','946a3a420230d9f7ee4790e7ad45bfdf'),
('1','fbcbc145dbb05567db94df9b9d6e512c'),
('1','99b8b965f0e34995b435e08021cfc36e'),
('1','2589dd9de8c3f940e0a9fa23a56105ef'),
('1','14a56b169e65b239f992dd8e3957aaf3'),
('1','c2a312b46535c755c9fb195763511cf4'),
('1','64679a0728139da131ee7fc7dde1778b'),
('1','93d078be2eac10b0c33d593043d5137e'),
('1','8fc3c82c1052973a511c6ae01de33b29'),
('1','84516af5bc264dec11a75db1e3a79a45'),
('1','d2c5ffb4bfbdcd5361bdf82a801fdbcd'),
('1','34e9ca7fbfb7a04e31065fd1dd0d3291'),
('1','a096c2a743bd98cdf9c94137d7f29287'),
('1','d675aed5fea8859799d42a29c1a21096'),
('1','22d7b62de6b9737941ae2104da139c4c'),
('1','9de56bca26a2da9d5ae2369ff46d377a'),
('1','c0b7045d997ba48130b60b585afdf7e3'),
('1','32d4bb02866ef69edc84a5302cce2c24'),
('1','6314bbc94b7565f0519b34c32c4828a8'),
('1','0327160a364dd4dbb2e37a23db3edc7f'),
('1','f879e4ab36874094a826511615711034'),
('1','dcaeafe8f110e0f2d51762462f049366'),
('1','198adbc8bddbd60ee65aa69103e0c1c2'),
('1','f5834a8e1554bc15d92589539ee2ac0d'),
('1','20f97ece59078857cb3deca8d7f3fb57'),
('1','56164191744cd6dc3ac36efc9d4fcb12'),
('1','39f9d20c74236f560bf939273b8fe45a'),
('1','6d28046616d27ba08bc60aa96e88a96e'),
('1','dce22ab751d226b1ad153081468e1787'),
('1','ed9946c2fe71665613b0e573bab6fa46'),
('1','28f26771dd61a7e6537576eec6f75985'),
('1','f6c89036b476a4fde4cdca22b76fbc70'),
('1','30f5ee7114af0e9bed79cbab73723a75'),
('1','d16d49384f36fbbc5d3f8fea8a8acc82'),
('1','9ea150ce888b9aa51834032cd4ad3bbc'),
('1','2bd2e806b7dc769afea44fa46db2e43d'),
('1','99e4fc4a604144c29e37449f9747dcf5'),
('1','ac29cc41784228af296e3131000f13cf'),
('1','f8dcb24119ae64759fa590289694c702'),
('1','7e0531bc102ce3c76c9494587fb40e54'),
('1','8b5bee31f6f631f5a8066e571a1f9cf7'),
('1','1ebd5d1631b9db46bccac4ae7872a019'),
('1','76d518598f6aa0251430e163378f23e6'),
('1','b72a77fcdf20dcf528a7fcb9452fd6c7'),
('1','4cd208aa152c920cc1a5325704455382'),
('1','efa33cbc63fda59c32e72648cdcd31b9'),
('1','0539d75b028c2b7390febc9373353152'),
('1','b055007e90c0086e509bec95d272cb18'),
('1','833707b326b8a833802e762e374d8c86'),
('1','3df32f8a6ac5d18d0f14674226277d98'),
('1','7afb80a2a95a502d9ae6571c092d1ac9'),
('1','7acbd26619c25dfb2cd0e7e9a4f65359'),
('1','3f932d4e941ccfd6ea76a0cee6b993d8'),
('1','5e71a997434c5f9611cbb76029fced4f'),
('1','091fb41b33c8cafcbe9cd83d1dddbf6a'),
('1','680cd10310326b89d5e31f990767bb8a'),
('22','c1319613a55eaf130b21c07d5bd82c8a'),
('22','8d260eec241ce446d9ffa432aa53e72b'),
('22','52ee8e7f864fcbd02c8341c1c13e120e'),
('1','8ce97022b3f364167922ddacb6763694'),
('1','bfd42a58b0f3c0eb62f1d096403ed49f'),
('1','fe6a53ed30b097fd241fa33310e9204e'),
('1','c8f842109d207313806ca1a26707eb64'),
('1','c9d2bbcf5cce84a29028bee5b39ca252'),
('1','ad411972d2ea6ebd4dddf9c902810874'),
('1','c6cea5b7d59a534d823f83786f4093d1'),
('1','ea874d1a06a5cb55ecd5df28dbc0c3c8'),
('1','18a37951d62aa9a26131707feea89f62'),
('1','84a95b47353481b4562790c01a26c0da');-- <xjx> --

-- 表的数据：system_menu --
INSERT INTO `system_menu` VALUES
('378','??????','39f9d20c74236f560bf939273b8fe45a','373','0','user','category','','1','1','3'),
('379','??????','56164191744cd6dc3ac36efc9d4fcb12','373','0','user','group','','1','1','4'),
('380','??????','0327160a364dd4dbb2e37a23db3edc7f','373','0','user','suggestion','','1','1','5'),
('375','????','2bd2e806b7dc769afea44fa46db2e43d','373','0','user','institution','','1','1','1'),
('374','????','1ebd5d1631b9db46bccac4ae7872a019','373','0','user','basic','','1','1','0'),
('373','????','1ebd5d1631b9db46bccac4ae7872a019','0','0','user','basic','','1','1','1'),
('21','????','18a37951d62aa9a26131707feea89f62','0','1','system','category','','1','1','0'),
('23','????','ea874d1a06a5cb55ecd5df28dbc0c3c8','21','2','system','setting','','1','1','1'),
('24','SMTP??','ad411972d2ea6ebd4dddf9c902810874','21','2','system','smtp','','1','1','2'),
('25','????','0539d75b028c2b7390febc9373353152','21','2','system','message','','1','1','8'),
('471','????','70958ab50355e6bdf7b251dd4638207e','410','0','log','all_del','','1','1','0'),
('420','????','28f26771dd61a7e6537576eec6f75985','377','0','user','look_export','','1','1','0'),
('419','??','ed9946c2fe71665613b0e573bab6fa46','377','0','user','export_modify','','1','1','0'),
('417','??','9ea150ce888b9aa51834032cd4ad3bbc','375','0','user','institution_del','','1','1','0'),
('418','??','d16d49384f36fbbc5d3f8fea8a8acc82','375','0','user','institution_modify','','1','1','0'),
('415','??','8b5bee31f6f631f5a8066e571a1f9cf7','374','0','user','basic_del','','1','1','0'),
('416','??','d16d49384f36fbbc5d3f8fea8a8acc82','375','0','user','institution_modify','','1','1','0'),
('412','??','7e0531bc102ce3c76c9494587fb40e54','374','0','user','basic_modify','','1','1','0'),
('413','??????','ac29cc41784228af296e3131000f13cf','374','0','user','lookdetail','','1','1','0'),
('414','??????','99e4fc4a604144c29e37449f9747dcf5','374','0','user','user','','1','1','0'),
('514','123','7496173c76d89aec8bd9a71a258d71f1','21','0','123','1158','21','1','1','0'),
('381','??????','32d4bb02866ef69edc84a5302cce2c24','373','0','user','data_analysis','','1','1','6'),
('384','????','c0b7045d997ba48130b60b585afdf7e3','383','0','cms','category','','1','1','0'),
('452','??','8ebf1db405601896535d8e94c69101e9','395','0','goods','comment_modify','','1','1','0'),
('453','??','a0a9300682db04fb3f291188b4795572','452','0','goods','comment_check','','1','1','0'),
('454','??','29a9efd9d385b4896be9875e1d43610a','396','0','goods','lookauction','','1','1','0'),
('455','??','29a9efd9d385b4896be9875e1d43610a','454','0','goods','lookauction','','1','1','0'),
('456','????????','b30016eaafc16fdd945e9e2497e736b4','396','0','goods','lookaudituser','','1','1','0'),
('457','????','5c98f85cbaa05e0a33648cf398107486','398','0','orders','lookcancle','','1','1','0'),
('458','????','5c98f85cbaa05e0a33648cf398107486','399','0','orders','lookcancle','','1','1','0'),
('459','????','5c98f85cbaa05e0a33648cf398107486','400','0','orders','lookcancle','','1','1','0'),
('460','????','5c98f85cbaa05e0a33648cf398107486','401','0','orders','lookcancle','','1','1','0'),
('461','????','5c98f85cbaa05e0a33648cf398107486','402','0','orders','lookcancle','','1','1','0'),
('462','????','89c2409cff285d97846bebba0ab1ba08','405','0','cash','looktrad','','1','1','0'),
('463','??','fd4c8e9d65f6c4243613e147e75d5450','406','0','cash','lookapply','','1','1','0'),
('464','??','e1ab838d7cd885d2965d22ba83a94b3b','463','0','cash','updade_apply','','1','1','0'),
('466','??','c2f4172b0c27cd6788dba4783c5b2e30','409','0','log','lookhandle','','1','1','0'),
('467','??','a5852fdc672ab5b6bdf9a1adb28ae1ff','409','0','log','del_handle','','1','1','0'),
('468','????','70958ab50355e6bdf7b251dd4638207e','409','0','log','all_del','','1','1','0'),
('469','??','406ed36afdd6e1ab27b3d1ad0e2110a2','410','0','log','lookuser','','1','1','0'),
('371','?????','7acbd26619c25dfb2cd0e7e9a4f65359','21','0','system','roleuser','','1','1','6'),
('370','????','3f932d4e941ccfd6ea76a0cee6b993d8','21','0','system','menu','','1','1','5'),
('368','????','c8f842109d207313806ca1a26707eb64','21','0','system','account','','1','1','3'),
('369','???','bfd42a58b0f3c0eb62f1d096403ed49f','21','0','system','role','','1','1','4'),
('481','??','8ce97022b3f364167922ddacb6763694','369','0','system','group_del','','1','1','0'),
('480','??','680cd10310326b89d5e31f990767bb8a','369','0','system','role_lock','','1','1','0'),
('477','??','fe6a53ed30b097fd241fa33310e9204e','368','0','system','account_modify','','1','1','0'),
('476','??','c9d2bbcf5cce84a29028bee5b39ca252','24','0','system','setting_smtp','','1','1','0'),
('474','????','70958ab50355e6bdf7b251dd4638207e','411','0','log','all_del','','1','1','0'),
('475','??','c6cea5b7d59a534d823f83786f4093d1','23','0','system','setting_modify','','1','1','0'),
('473','??','53f67ba9ac293e672e5ab3b8cb00f82b','411','0','log','del_payment','','1','1','0'),
('470','??','a087e40930458ae336cd82e420a82049','410','0','log','del_user','','1','1','0'),
('439','??','2589dd9de8c3f940e0a9fa23a56105ef','391','0','goods','basic_look','','1','1','0'),
('440','????','99b8b965f0e34995b435e08021cfc36e','439','0','goods','check_audit','','1','1','0'),
('441','??','946a3a420230d9f7ee4790e7ad45bfdf','392','0','goods','basic_modify','','1','1','0'),
('421','??','6d28046616d27ba08bc60aa96e88a96e','377','0','user','export_del','','1','1','0'),
('422','??','ed9946c2fe71665613b0e573bab6fa46','377','0','user','export_modify','','1','1','0'),
('423','??','20f97ece59078857cb3deca8d7f3fb57','379','0','user','group_modify','','1','1','0'),
('424','????','198adbc8bddbd60ee65aa69103e0c1c2','379','0','user','lookgrouplist','','1','1','0'),
('425','??','f879e4ab36874094a826511615711034','379','0','user','group_del','','1','1','0'),
('426','??','20f97ece59078857cb3deca8d7f3fb57','379','0','user','group_modify','','1','1','0'),
('427','????','dcaeafe8f110e0f2d51762462f049366','424','0','user','lookgroup','','1','1','0'),
('428','????','6314bbc94b7565f0519b34c32c4828a8','380','0','user','looksuggestion','','1','1','0'),
('429','??','22d7b62de6b9737941ae2104da139c4c','385','0','cms','looklist','','1','1','0'),
('430','??','d675aed5fea8859799d42a29c1a21096','385','0','cms','del_cms','','1','1','0'),
('431','??','22d7b62de6b9737941ae2104da139c4c','385','0','cms','looklist','','1','1','0'),
('432','??','34e9ca7fbfb7a04e31065fd1dd0d3291','387','0','store','lookaudit','','1','1','0'),
('433','??','84516af5bc264dec11a75db1e3a79a45','388','0','store','lookstore','','1','1','0'),
('434','??','84516af5bc264dec11a75db1e3a79a45','388','0','store','lookstore','','1','1','0'),
('435','??','8fc3c82c1052973a511c6ae01de33b29','388','0','store','del_store','','1','1','0'),
('436','??','64679a0728139da131ee7fc7dde1778b','389','0','store','lookphoto','','1','1','0'),
('437','??','64679a0728139da131ee7fc7dde1778b','389','0','store','lookphoto','','1','1','0'),
('438','??','c2a312b46535c755c9fb195763511cf4','389','0','store','del_photo','','1','1','0'),
('479','??','5e71a997434c5f9611cbb76029fced4f','478','0','system','check_role','','1','1','0'),
('478','??','091fb41b33c8cafcbe9cd83d1dddbf6a','369','0','system','group_modify','','1','1','0'),
('451','??','a0a9300682db04fb3f291188b4795572','450','0','goods','comment_check','','1','1','0'),
('449','??','60ee38c34b2648c570a648b0eeb54e62','393','0','goods','check_brand','','1','1','0'),
('450','??','8ebf1db405601896535d8e94c69101e9','394','0','goods','comment_modify','','1','1','0'),
('448','??','025086c730b3e267cb9fbcf5fb8e4690','393','0','goods','brand_del','','1','1','0'),
('442','??','0d01af220967b414ef6c1b764aee406c','441','0','goods','check_goods','','1','1','0'),
('443','??????','5b7dabec4068eedc5f385fad5fac1734','392','0','goods','show_comment','','1','1','0'),
('444','??????','5b7dabec4068eedc5f385fad5fac1734','392','0','goods','show_comment','','1','1','0'),
('445','??','aa2183e828e5349a215b5214abd7474f','392','0','goods','goods_del','','1','1','0'),
('446','??','60ee38c34b2648c570a648b0eeb54e62','393','0','goods','check_brand','','1','1','0'),
('447','??','60ee38c34b2648c570a648b0eeb54e62','446','0','goods','check_brand','','1','1','0'),
('377','????','f6c89036b476a4fde4cdca22b76fbc70','373','0','user','export','','1','1','2'),
('383','CMS??','c0b7045d997ba48130b60b585afdf7e3','0','0','cms','category','','1','1','2'),
('385','????','9de56bca26a2da9d5ae2369ff46d377a','383','0','cms','cmslist','','1','1','1'),
('386','????','a096c2a743bd98cdf9c94137d7f29287','0','0','store','audit','','1','1','3'),
('387','????','a096c2a743bd98cdf9c94137d7f29287','386','0','store','audit','','1','1','0'),
('388','????','d2c5ffb4bfbdcd5361bdf82a801fdbcd','386','0','store','storetheme','','1','1','0'),
('389','????','93d078be2eac10b0c33d593043d5137e','386','0','store','phototheme','','1','1','0'),
('390','????','14a56b169e65b239f992dd8e3957aaf3','0','0','goods','audit','','1','1','4'),
('391','????','14a56b169e65b239f992dd8e3957aaf3','390','0','goods','audit','','1','1','0'),
('392','????','fbcbc145dbb05567db94df9b9d6e512c','390','0','goods','basic','','1','1','0'),
('393','????','7383e45ce458cfc9c59b4bff1be77e7c','390','0','goods','brand','','1','1','0'),
('394','????','806fec89cbb902ca6c1af2cd0c8b2cc8','390','0','goods','usercomment','','1','1','0'),
('395','????','842687063c2646a2f524b1847d354034','390','0','goods','exportcomment','','1','1','0'),
('396','????','e6869d0e4e77019c29712a3117b7f6b0','390','0','goods','auction','','1','1','0'),
('397','????','dd886403400bdabe5f42416c9f60a3b4','0','0','orders','unaudited','','1','1','5'),
('398','?????','dd886403400bdabe5f42416c9f60a3b4','397','0','orders','unaudited','','1','1','0'),
('399','?????','2abc64458fe7ac8d9cbea97119a129f4','397','0','orders','untreatment','','1','1','0'),
('400','?????','bdccdc5b31931c3c1f5b673d51324081','397','0','orders','treatment','','1','1','0'),
('401','?????','9c7d5eea01acee7fb6da3787bd5bfa63','397','0','orders','cancle','','1','1','0'),
('402','????','038f4089d471c33ab24e9f4ba95817d2','397','0','orders','history','','1','1','0'),
('403','??????','55948aed543573fe160a24c475b9f33e','397','0','orders','order_analysis','','1','1','0'),
('404','????','b295a79f64acdf6a99f18e5aa0ed5bd9','0','0','cash','trad','','1','1','6'),
('405','????','b295a79f64acdf6a99f18e5aa0ed5bd9','404','0','cash','trad','','1','1','0'),
('406','????','ae5e5442ac7d5cbbfa0f71dbcc8d6dbd','404','0','cash','apply','','1','1','1'),
('408','??','52ee8e7f864fcbd02c8341c1c13e120e','0','0','log','handle','','1','1','7'),
('409','??????','52ee8e7f864fcbd02c8341c1c13e120e','408','0','log','handle','','1','1','0'),
('410','??????','8d260eec241ce446d9ffa432aa53e72b','408','0','log','user','','1','1','1'),
('411','????','c1319613a55eaf130b21c07d5bd82c8a','408','0','log','payment','','1','1','2'),
('482','??','091fb41b33c8cafcbe9cd83d1dddbf6a','369','0','system','group_modify','','1','1','0'),
('483','??','5e71a997434c5f9611cbb76029fced4f','482','0','system','check_role','','1','1','0'),
('484','??','7afb80a2a95a502d9ae6571c092d1ac9','371','0','system','roleuser_modify','','1','1','0'),
('485','??','3df32f8a6ac5d18d0f14674226277d98','484','0','system','check_account','','1','1','0'),
('486','??','7afb80a2a95a502d9ae6571c092d1ac9','371','0','system','roleuser_modify','','1','1','0'),
('487','??','3df32f8a6ac5d18d0f14674226277d98','486','0','system','check_account','','1','1','0'),
('488','??','833707b326b8a833802e762e374d8c86','371','0','system','roleuser_del','','1','1','0'),
('489','??','efa33cbc63fda59c32e72648cdcd31b9','25','0','system','message_modify','','1','1','0'),
('490','??','4cd208aa152c920cc1a5325704455382','489','0','system','message_check','','1','1','0'),
('491','??','efa33cbc63fda59c32e72648cdcd31b9','25','0','system','message_modify','','1','1','0'),
('492','??','4cd208aa152c920cc1a5325704455382','491','0','system','message_check','','1','1','0'),
('493','??','b72a77fcdf20dcf528a7fcb9452fd6c7','25','0','system','message_del','','1','1','0'),
('494','??','34e9ca7fbfb7a04e31065fd1dd0d3291','432','0','store','lookaudit','','1','1','0'),
('495','??','84516af5bc264dec11a75db1e3a79a45','433','0','store','lookstore','','1','1','0'),
('496','??','84516af5bc264dec11a75db1e3a79a45','434','0','store','lookstore','','1','1','0'),
('497','??','64679a0728139da131ee7fc7dde1778b','436','0','store','lookphoto','','1','1','0'),
('498','??','64679a0728139da131ee7fc7dde1778b','437','0','store','lookphoto','','1','1','0'),
('499','??','22d7b62de6b9737941ae2104da139c4c','429','0','cms','looklist','','1','1','0'),
('500','??','22d7b62de6b9737941ae2104da139c4c','431','0','cms','looklist','','1','1','0'),
('501','????','f8dcb24119ae64759fa590289694c702','412','0','user','basic_checkmodify','','1','1','0'),
('502','??','30f5ee7114af0e9bed79cbab73723a75','418','0','user','institution_check','','1','1','0'),
('503','??','30f5ee7114af0e9bed79cbab73723a75','416','0','user','institution_check','','1','1','0'),
('504','??','dce22ab751d226b1ad153081468e1787','419','0','user','export_check','','1','1','0'),
('505','??','dce22ab751d226b1ad153081468e1787','422','0','user','export_check','','1','1','0'),
('506','??','f5834a8e1554bc15d92589539ee2ac0d','423','0','user','group_check','','1','1','0'),
('507','??','f5834a8e1554bc15d92589539ee2ac0d','426','0','user','group_check','','1','1','0'),
('508','??????','d1d39379d4a4a0a87b6c66d5dc30039b','392','0','goods','export','','1','1','0'),
('509','??????','26b2e339af7d6a9a1dffba3801a8fdac','508','0','goods','export_add','','1','1','0'),
('510','??','481ad93afa6b863fa900a55aea6e583b','509','0','goods','export_check','','1','1','0');-- <xjx> --

-- 表的数据：system_message --
INSERT INTO `system_message` VALUES
('1','????','?????????????????????????.','2','1428474712','1','0','0','0'),
('7','?????','?????????','1','0','0','0','1429602589','0');-- <xjx> --

-- 表的数据：system_messagetype --
INSERT INTO `system_messagetype` VALUES
('1','????','1'),
('2','??','1'),
('3','??','1'),
('5','????','1');-- <xjx> --

-- 表的数据：system_sendgroup --
INSERT INTO `system_sendgroup` VALUES
('1','????'),
('2','??'),
('3','??'),
('4','??');-- <xjx> --

-- 表的数据：system_setting --
INSERT INTO `system_setting` VALUES
('1','websiteName','??'),
('2','url','http://www.imanage.com'),
('3','keywords','??'),
('4','description','????3'),
('5','smtpaddress','http://www.imanage.com'),
('6','port','80'),
('7','sendaccount','23132131'),
('8','returnaddress','www.xuekaole.com');-- <xjx> --

-- 表的数据：user_basic --
INSERT INTO `user_basic` VALUES
('1','??','0','0','0',NULL,NULL,NULL,NULL);-- <xjx> --

-- 表的数据：user_basicprofile --
INSERT INTO `user_basicprofile` VALUES
('1','1','0',NULL,'?','????????','??????',NULL,NULL,NULL,NULL,NULL);-- <xjx> --

-- 表的数据：user_group --
INSERT INTO `user_group` VALUES
('1','??','1'),
('2','??','1'),
('3','??','1');-- <xjx> --

-- 表的数据：user_integration --
INSERT INTO `user_integration` VALUES
('1','1','500','1234564','45','12');-- <xjx> --

-- 表的数据：wms_setting --
INSERT INTO `wms_setting` VALUES
('2','1323134234','0','0'),
('3','13231','1','0'),
('4','??','1','0'),
('5','??','0','1'),
('6','1212','0','1');-- <xjx> --

-- 表的数据：wms_typesetting --
INSERT INTO `wms_typesetting` VALUES
('1','??????1','1','1'),
('3','??????1','0','1');-- <xjx> --

