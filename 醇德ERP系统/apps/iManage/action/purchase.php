<?php

/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */

class purchase extends actionAbstract {
	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 3;
	public $type = 0;
	public $leftpos = 0;
	public $where = '';
	/**
	 * 递归要添加的菜单PIN
	 *
	 * @var array
	 */
	protected $add_auth = array();
	protected $menudatas = array();

	/**
	 * 构造
	 */
	function __construct() {
		parent::__construct();
		$this->info = acl::checkLogin('admininfo',$this->url('common/login'));
		if (!isset($_SESSION['admininfo'])) {header('location:' . $this->url('common/login'));}$this->info = $_SESSION['admininfo'];
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		$this->conf = $this->loadConfig('sysconf');
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			//ajax request
			$this->checkpower();
		}
	}

	//待确认订单--待处理订单 0，1，2----总部角色--客审
	public function orderconfirm() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		//$sql = "select * from franchisee_order  where status=0 or status=1 ";
		$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where fo.status=0 or fo.status=1";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		//加盟商级别
		$sql = "select * from crm_usertype ";
		$supplys = $this->franchisee->orderModel->fetchAll($sql);
		$supply = array();
		foreach ($supplys as $val) {
			$supply[$val['id']] = $val['title'];

		}

		include $this->loadWidget('amdinlteTheme');
	}
	//待确认订单--未完成
	public function orderconfirmnoover() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		//$sql = "select * from franchisee_order  where status>1 and status<5 ";
		$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where fo.status>1 and fo.status<5";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		//加盟商级别
		$sql = "select * from crm_usertype ";
		$supplys = $this->franchisee->orderModel->fetchAll($sql);
		$supply = array();
		foreach ($supplys as $val) {
			$supply[$val['id']] = $val['title'];

		}
		include $this->loadWidget('amdinlteTheme');
	}
	//待确认订单--已完成
	public function orderconfirmover() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		//$sql = "select * from franchisee_order  where  status=5 ";
		$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where  fo.status=5";
		$re = $this->franchisee->orderModel->fetchAll($sql);
//加盟商级别
		$sql = "select * from crm_usertype ";
		$supplys = $this->franchisee->orderModel->fetchAll($sql);
		$supply = array();
		foreach ($supplys as $val) {
			$supply[$val['id']] = $val['title'];

		}
		include $this->loadWidget('amdinlteTheme');
	}
	//待确认订单--无效
	public function orderconfirwuxiao() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		//$sql = "select * from franchisee_order  where  status<0 ";
		$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where  fo.status<0";
		$re = $this->franchisee->orderModel->fetchAll($sql);
//加盟商级别
		$sql = "select * from crm_usertype ";
		$supplys = $this->franchisee->orderModel->fetchAll($sql);
		$supply = array();
		foreach ($supplys as $val) {
			$supply[$val['id']] = $val['title'];

		}
		include $this->loadWidget('amdinlteTheme');
	}
	//订单详情
	public function orderinfo() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		$this->loadModel('product', 'goods');
		$ordernum = $_GET['ordernum'];
		//订单信息
		$sql = "select fo.allprice ,fo.id,fo.status,fo.orderbackstatus,fo.token,ws.title as wstitle,fo.freeordernum,fo.created,fo.remark from franchisee_order as fo left join wms_setting as ws on ws.id=fo.storetypeid  where fo.ordernum='" . $ordernum . "'";
		$order = $this->franchisee->orderModel->fetchRow($sql);
		//查看该订单是否有赠送订单
		$sql = "select ordernum from franchisee_order where freeordernum='" . $ordernum . "'";
		$freeorder = $this->franchisee->orderModel->fetchRow($sql);
		if ($order['status'] >= 2) {

			$sql = "select fo.weights ,fo.realbacknum,foe.allprice,foe.ordernum,foe.productontime,foe.num as buynum,fo.id,fo.tag,fo.price as buyprice,pg.beoverdue,pg.shelflife,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfoprepare as foe left join franchisee_orderinfo as fo on fo.id=foe.orderinfoid left join product_goods as pg on foe.goodsid=pg.id where foe.ordernum='" . $ordernum . "'";
		} else {
			$sql = "select fo.weights ,fo.realbacknum,fo.allprice,fo.ordernum,fo.productontime,fo.id,fo.tag,pg.beoverdue,pg.shelflife,pg.uuid,fo.num as buynum,fo.price as buyprice,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id  where fo.ordernum='" . $ordernum . "'";

		}
		$re = $this->franchisee->orderModel->fetchAll($sql);
		
		if ($order['status'] <= 1) {
			//	查看库存 product_productontime

			foreach ($re as $k => $v) {
				$v['boxnum'] = $v['boxnum'] - 0;
				if (empty($v['boxnum'])) {
					$re[$k]['hasnumber'] = '0';
					continue;
				}

				if ($v['shelflife'] == 0) {
					//正常的库存
					//$re[$k]['hasnumber'] = floor($v['number'] / $v['boxnum']);
					$re[$k]['hasnumber'] = $v['number'];
				} else {
					if ($v['tag'] == 1) {
						//未临期
						$sql = "select sum(num) as number from product_productontime where goodsuuid='" . $v['uuid'] . "' and productontime>='" . $v['productontime'] . "'";
						$r = $this->franchisee->orderModel->fetchRow($sql);

						if ($r) {
							$re[$k]['hasnumber'] = floor($r['number'] / $v['boxnum']);
							$re[$k]['hasnumber'] = $r['number'];
						} else {
							$re[$k]['hasnumber'] = 0;
						}

					} else {
						$time = time(); //过期时间境界线  productontime>$time  没过期的
						$time1 = time() + $v['beoverdue'] * 24 * 3600; //临期时间境界线  productontime>$time  正常价，小于临期价
						$sql = "select sum(num) as number from product_productontime where goodsuuid='" . $v['uuid'] . "' and productontime>='" . $v['productontime'] . "' and productontime<" . $time1;
						$r = $this->franchisee->orderModel->fetchRow($sql);
						if ($r) {
							//$re[$k]['hasnumber'] = floor($r['number'] / $v['boxnum']);
							$re[$k]['hasnumber'] = $r['number'];
						} else {
							$re[$k]['hasnumber'] = 0;
						}
					}

				}

			}
		
		}
			//查看物流信息
		$sql = "select fo.*,sa.truename as peihuoname,saa.truename as heyanname,saaa.truename as fahuoname from  franchisee_orderlogistics as fo left join system_admin as sa on sa.id=fo.peihuoid  left join system_admin as saa on saa.id=fo.heyanid  left join system_admin as saaa on saaa.id=fo.fahuoid where fo.orderid=" . $order['id'];
		$logistics = $this->franchisee->orderModel->fetchRow($sql);
		//加盟商信息
		$token = $order['token'];
		$userinfo = $this->getAllianceInfo($token);

		//查看历史记录
		$sql = "select * from franchisee_orderdata where orderid=" . $order['id'] . " and type=0 order by created desc";
		$log = $this->franchisee->orderModel->fetchAll($sql);

		//按时间重新组合日志  --开始
		$logs = array();
		foreach ($log as $k => $val) {
			$logs[date("Y-m-d", $val['created'])][] = $val;
		}
		//
		$this->loadModel('wms', 'setting'); 
		$sql = "select * from wms_setting where type=0 ";
		$store = $this->wms->settingModel->fetchAll($sql);
		
		include $this->loadWidget('amdinlteTheme');
	}
	//删除订单商品
	public function delgoods() {
		$this->loadModel('franchisee', 'orderinfo');
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderinfoprepare');
		$this->loadHelper("extend");
		if ($_GET) {
			$id = $_GET['id'];
			$order = $this->franchisee->orderinfoModel->fetchRow("select * from franchisee_orderinfo where id=" . $id);

			$line = $this->franchisee->orderinfoModel->delete("id=" . $id);
			if ($line) {
				//删除  franchisee_orderinfoprepare
				$this->franchisee->orderinfoprepareModel->delete("orderinfoid=" . $id);
				//修改总订单价格
				$sql = "select fo.price,fo.num,fo.boxnum,fo.id,pg.weight from franchisee_orderinfo as fo left join product_goods as pg on pg.id=fo.goodsid where fo.ordernum='" . $order['ordernum'] . "'";
				$res = $this->franchisee->orderinfoModel->fetchAll($sql);
				$price = 0;
				$weight = 0;
				foreach ($res as $k => $val) {
					$price += $val['price'] * $val['num'] * $val['boxnum'];
					$weight += $val['weight'] * $val['num'] * $val['boxnum'] / 1000;
				}

				$sql = "select freight,allprice,id from franchisee_order where ordernum='" . $order['ordernum'] . "'";
				$r = $this->franchisee->orderModel->fetchRow($sql);
				$data = array();
				if (!$res) {
					$data['status'] = -1;
					//$this->tezhisendmessage($r['id'],-1);
				}
				$data['price'] = $price;
				$data['allprice'] = $price - 0 + $r['freight'];
				$data['survey'] = "共" . count($res) . "种商品,重量" . $weight . "Kg,总计" . $data['allprice'];
				$this->franchisee->orderModel->update($data, "ordernum='" . $order['ordernum'] . "'");
				if (!$res) {

					$this->tezhisendmessage($r['id'], -1);
				}
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//修改购物车数量
	public function updatecart() {
		$this->loadModel('franchisee', 'orderinfo');
		$this->loadModel('franchisee', 'order');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data['num'] = $_POST['num'] - 0;
			$hasnumber = $_POST['hasnumber'];
			if (empty($data['num'])) {
				ajaxReturn('', '数据有误', 0);
			}
			if ($data['num'] > $hasnumber) {
				ajaxReturn('', '库存不足', 0);

			}

			$line = $this->franchisee->orderinfoModel->update($data, "id=" . $id);
			if ($line) {
				//修改总订单价格
				$sql = "select fo.price,fo.num,fo.boxnum,fo.id,pg.weight from franchisee_orderinfo as fo left join product_goods as pg on pg.id=fo.goodsid where fo.ordernum='" . $_POST['ordernum'] . "'";
				$res = $this->franchisee->orderinfoModel->fetchAll($sql);
				$price = 0;
				$weight = 0;
				foreach ($res as $k => $val) {
					$price += $val['price'] * $val['num'] * $val['boxnum'];
					$weight += $val['weight'] * $val['num'] * $val['boxnum'] / 1000;
					//修改单价
					if ($val['id'] == $id) {
						$infoprice = $val['price'] * $val['num'] * $val['boxnum'];
						$this->franchisee->orderinfoModel->update(array('allprice' => $infoprice), "id=" . $id);
					}

				}

				$sql = "select freight,allprice from franchisee_order where ordernum='" . $_POST['ordernum'] . "'";
				$r = $this->franchisee->orderModel->fetchRow($sql);
				$data = array();
				$data['price'] = $price;
				$data['allprice'] = $price - 0 + $r['freight'];
				$data['survey'] = "共" . count($res) . "种商品,重量" . $weight . "Kg,总计" . $data['allprice'];
				$this->franchisee->orderModel->update($data, "ordernum='" . $_POST['ordernum'] . "'");
				ajaxReturn('', '修改成功', 1);
			} else {
				ajaxReturn('', '修改失败', 0);
			}

		}

	}
	//财务角色
	public function frorder() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		//$sql = "select * from franchisee_order where status=2  ";
		$sql = "select fo.*,fa.shoppname from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where  fo.status=2";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		//加盟商级别
		$sql = "select * from crm_usertype ";
		$supplys = $this->franchisee->orderModel->fetchAll($sql);
		$supply = array();
		foreach ($supplys as $val) {
			$supply[$val['id']] = $val['title'];

		}
		include $this->loadWidget('amdinlteTheme');
	}
	//财务角色---未罕成
	public function frordernoover() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		//$sql = "select * from franchisee_order where status>2 and status<5";
		$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where fo.status>2 and fo.status<5";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		//加盟商级别
		$sql = "select * from crm_usertype ";
		$supplys = $this->franchisee->orderModel->fetchAll($sql);
		$supply = array();
		foreach ($supplys as $val) {
			$supply[$val['id']] = $val['title'];

		}
		include $this->loadWidget('amdinlteTheme');
	}
	//财务角色---已完全成
	public function frorderover() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		//$sql = "select * from franchisee_order where  status=5";
		$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where  fo.status=5";
		$re = $this->franchisee->orderModel->fetchAll($sql);
//加盟商级别
		$sql = "select * from crm_usertype ";
		$supplys = $this->franchisee->orderModel->fetchAll($sql);
		$supply = array();
		foreach ($supplys as $val) {
			$supply[$val['id']] = $val['title'];

		}
		include $this->loadWidget('amdinlteTheme');

	}
	//财务角色---无效
	public function frorderwuxiao() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		//$sql = "select * from franchisee_order where  status<0";
		$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where  fo.status in(-3,-4)";
		$re = $this->franchisee->orderModel->fetchAll($sql);
//加盟商级别
		$sql = "select * from crm_usertype ";
		$supplys = $this->franchisee->orderModel->fetchAll($sql);
		$supply = array();
		foreach ($supplys as $val) {
			$supply[$val['id']] = $val['title'];

		}
		include $this->loadWidget('amdinlteTheme');

	}
	//财务订单详情
	public function orderinfofr() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		$this->loadModel('product', 'goods');
		$ordernum = $_GET['ordernum'];
		$sql = "select foe.ordernum,foe.productontime,foe.num as buynum,fo.id,fo.tag,fo.price as buyprice,pg.beoverdue,pg.shelflife,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number from franchisee_orderinfoprepare as foe left join franchisee_orderinfo as fo on fo.id=foe.orderinfoid left join product_goods as pg on foe.goodsid=pg.id where foe.ordernum='" . $ordernum . "'";

		$sql = "select fo.weights,foe.id as foeid,foe.ordernum,foe.allprice,foe.productontime,foe.num as buynum,foe.realbacknum,fo.id,fo.tag,fo.price as buyprice,pg.beoverdue,pg.shelflife,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfoprepare as foe left join franchisee_orderinfo as fo on fo.id=foe.orderinfoid left join product_goods as pg on foe.goodsid=pg.id where foe.ordernum='" . $ordernum . "'";
		$re = $this->franchisee->orderModel->fetchAll($sql);

		//订单信息
		$sql = "select fo.freeordernum,fo.paytype,fo.bankid,fo.id,fo.allprice,fo.status,fo.token,fo.orderbackstatus,fo.backstatus,ws.title as wstitle,fo.created,fo.remark from franchisee_order as fo left join wms_setting as ws on ws.id=fo.storetypeid  where fo.ordernum='" . $ordernum . "'";
		$order = $this->franchisee->orderModel->fetchRow($sql);
		
//查看该订单是否有赠送订单
		$sql = "select ordernum from franchisee_order where freeordernum='" . $ordernum . "'";
		$freeorder = $this->franchisee->orderModel->fetchRow($sql);
		//加盟商信息
		$token = $order['token'];
		$userinfo = $this->getAllianceInfo($token);

		//查看历史记录
		$sql = "select * from franchisee_orderdata where orderid=" . $order['id'] . " and type=0  order by created desc";
		$log = $this->franchisee->orderModel->fetchAll($sql);
		//按时间重新组合日志  --开始
		$logs = array();
		foreach ($log as $k => $val) {
			$logs[date("Y-m-d", $val['created'])][] = $val;
		}
		//
		$this->loadModel('wms', 'setting');
		$sql = "select * from wms_setting where type=0 ";
		$store = $this->wms->settingModel->fetchAll($sql);
		//查看银行信息
		$sql = "select * from system_bank ";
		$bank = $this->wms->settingModel->fetchAll($sql);
		$bankarray = array();
		foreach ($bank as $v) {
			$bankarray[$v['id']] = $v['bankname'];
		}

		//支付日志

		$this->loadModel('franchisee', 'orderpaylog');
		$sql = "select * from franchisee_orderpaylog where ordernum='" . $ordernum . "'";
		$paylog = $this->franchisee->orderpaylogModel->fetchAll($sql);
		//支付方式
		$this->loadModel('financial', 'paytype');
		$sql = "select * from financial_paytype where type=1 and status=1";
		$paytype = $this->financial->paytypeModel->fetchAll($sql);
		
		//查看物流信息
				//查看物流信息
		$sql = "select fo.*,sa.truename as peihuoname,saa.truename as heyanname,saaa.truename as fahuoname from  franchisee_orderlogistics as fo left join system_admin as sa on sa.id=fo.peihuoid  left join system_admin as saa on saa.id=fo.heyanid  left join system_admin as saaa on saaa.id=fo.fahuoid where fo.orderid=" . $order['id'];
		$logistics = $this->franchisee->orderModel->fetchRow($sql);
		
		include $this->loadWidget('amdinlteTheme');

	}
	public function paylogtj() {

		$this->loadHelper('extend');
		//echo "<script>alert('分配数量不能为空');window.location.href='".$url."';</script>";exit;
		$ordernum = $_POST['ordernum'];
		$idarr = $_POST['id'];
		$this->loadModel('franchisee', 'orderpaylog');
		$insertsql = "insert into franchisee_orderpaylog(id,ordernum,paymoney,banknum,paytype,paytime,truename,created,remark)values ";
		$i = 0;
		$paytime = strtotime($_POST['paytime']);
		$truename = $this->info['truename'];
		$created = time();
		$insertsql .= "(" . $_POST['id'] . ",'" . $ordernum . "','" . $_POST['paymoney'] . "','" . $_POST['banknum'] . "'," . $_POST['paytype'] . ",'" . $paytime . "','" . $truename . "','" . $created . "','" . $_POST['remark'] . "')";
		$insertsql .= " on duplicate key update ordernum=values(ordernum),paymoney=values(paymoney),banknum=values(banknum),paytype=values(paytype),paytime=values(paytime),truename=values(truename),created=values(created),remark=values(remark)";
		//echo $insertsql;exit;

		$line = $this->franchisee->orderpaylogModel->sqlexec($insertsql);
		$data = array('state' => 0, 'info' => "操作失败");
		if ($line) {
			$data['state'] = 1;
			echo json_encode($data);
			exit;
		} else {
			echo json_encode($data);exit;
		}
	}
	//删除支付日志
	public function delpaylog() {
		$this->loadHelper('extend');
		$this->loadModel('franchisee', 'orderpaylog');
		$line = $this->franchisee->orderpaylogModel->delete("id=" . $_POST['id']);
		$data = array('state' => 0, 'info' => "操作失败");
		if ($line) {
			$data['state'] = 1;
			echo json_encode($data);
			exit;
		} else {
			echo json_encode($data);exit;
		}

	}
	//财务修改订单价格
	public function changeprice() {
		$this->loadHelper("extend");
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadModel('franchisee', 'orderinfoprepare');
		if (!empty($_POST['foeid'])) {
			$orderid = $_POST['orderid'];
			$sql = "select status,survey from franchisee_order where id=" . $orderid . " and status=2";
			$check = $this->franchisee->orderModel->fetchRow($sql);
			if (!$check) {ajaxReturn('', '现阶段不能执行该操作', 0);}
			$insertsql = "insert into franchisee_orderinfoprepare(id,allprice) values";
			foreach ($_POST['foeid'] as $k => $val) {
				if ($k == 0) {
					$insertsql .= "(" . $_POST['foeid'][$k] . ",'" . $_POST['foeallprice'][$k] . "')";
				} else {
					$insertsql .= ",(" . $_POST['foeid'][$k] . ",'" . $_POST['foeallprice'][$k] . "')";
				}

			}

			$insertsql .= " on duplicate key update allprice=values(allprice)";
			//echo $insertsql;exit;
			$survey = explode(',', $check['survey']);

			$orderdata['allprice'] = $_POST['allprice'];
			$orderdata['price'] = $_POST['allprice'];
			if (isset($survey[2])) {
				$orderdata['survey'] = $survey[0] . ',' . $survey[1] . ',共计' . $_POST['allprice'] . "元";
			}
			//print_r($orderdata);exit;
			$line = $this->franchisee->orderModel->update($orderdata, "id=" . $orderid);

			$l = $this->franchisee->orderinfoprepareModel->sqlexec($insertsql);
			if ($l || $line) {
				$data = array();
				$data['orderid'] = $orderid;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();

				$data['results'] = "修改订单价格";
				$this->franchisee->orderdataModel->insert($data);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		} else {
			ajaxReturn('', '操作失败1', 0);
		}

	}
	//库房打单
	public function orderinfohouse() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		$this->loadModel('product', 'goods');
		$ordernum = $_GET['ordernum'];
		$sql = "select fo.weights,fo.allprice,fo.realbacknum,foe.ordernum,foe.productontime,foe.num as buynum,fo.id,fo.tag,fo.price as buyprice,pg.beoverdue,pg.shelflife,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number from franchisee_orderinfoprepare as foe left join franchisee_orderinfo as fo on fo.id=foe.orderinfoid left join product_goods as pg on foe.goodsid=pg.id where foe.ordernum='" . $ordernum . "'";
		$sql = "select fo.weights,foe.allprice,foe.ordernum,foe.productontime,foe.num as buynum,foe.realbacknum,fo.id,fo.tag,fo.price as buyprice,pg.beoverdue,pg.shelflife,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfoprepare as foe left join franchisee_orderinfo as fo on fo.id=foe.orderinfoid left join product_goods as pg on foe.goodsid=pg.id where foe.ordernum='" . $ordernum . "'";
		$re = $this->franchisee->orderModel->fetchAll($sql);

		//订单信息
		$sql = "select fo.allprice,fo.created,fo.remark,fo.freeordernum,fo.id,fo.status,fo.token,fo.orderbackstatus,fo.backstatus,ws.title as wstitle,fo.created,fo.remark from franchisee_order as fo left join wms_setting as ws on ws.id=fo.storetypeid  where fo.ordernum='" . $ordernum . "'";
		
		$order = $this->franchisee->orderModel->fetchRow($sql);
	
//查看该订单是否有赠送订单
		$sql = "select ordernum from franchisee_order where freeordernum='" . $ordernum . "'";
		$freeorder = $this->franchisee->orderModel->fetchRow($sql);
		//加盟商信息
		$token = $order['token'];
		$userinfo = $this->getAllianceInfo($token);

		//查看历史记录
		$sql = "select * from franchisee_orderdata where orderid=" . $order['id'] . "  and type=0  order by created desc";
		$log = $this->franchisee->orderModel->fetchAll($sql);
		//按时间重新组合日志  --开始
		$logs = array();
		foreach ($log as $k => $val) {
			$logs[date("Y-m-d", $val['created'])][] = $val;
		}
		//查看物流信息
		$sql = "select * from  franchisee_orderlogistics where orderid=" . $order['id'];
		$logistics = $this->franchisee->orderModel->fetchRow($sql);
		$this->loadModel('wms', 'setting');
		$sql = "select * from wms_setting where type=0 ";
		$store = $this->wms->settingModel->fetchAll($sql);
		//查看送货员
		$sql = "select * from system_admin where status=1 and groupid=9";
		$user = $this->wms->settingModel->fetchAll($sql);
		//查看快递公司--物流模板
		$sql = "select * from product_general ";
		$company = $this->wms->settingModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');

	}
	//库房角色
	public function hourseorder() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		$sql = " select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where fo.status>=3 ";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		//加盟商级别
		$sql = "select * from crm_usertype ";
		$supplys = $this->franchisee->orderModel->fetchAll($sql);
		$supply = array();
		foreach ($supplys as $val) {
			$supply[$val['id']] = $val['title'];

		}
		include $this->loadWidget('amdinlteTheme');
	}
	//库房角色---未完成
	public function hourseordernoorder() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		//$sql = " select * from franchisee_order where status>=3 and status<5 ";
		$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where  fo.status>=3 and fo.status<5";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		//加盟商级别
		$sql = "select * from crm_usertype ";
		$supplys = $this->franchisee->orderModel->fetchAll($sql);
		$supply = array();
		foreach ($supplys as $val) {
			$supply[$val['id']] = $val['title'];

		}
		include $this->loadWidget('amdinlteTheme');
	}
	//库房角色---已完成
	public function hourseorderorder() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		$sql = " select * from franchisee_order where  status=5 ";
		$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where  fo.status=5";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		//加盟商级别
		$sql = "select * from crm_usertype ";
		$supplys = $this->franchisee->orderModel->fetchAll($sql);
		$supply = array();
		foreach ($supplys as $val) {
			$supply[$val['id']] = $val['title'];

		}
		include $this->loadWidget('amdinlteTheme');
	}
	//库房角色---无效
	public function hourseorderwuxiao() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		$sql = " select * from franchisee_order where  status<0 ";
		$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where   fo.status in(-4)";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		//加盟商级别
		$sql = "select * from crm_usertype ";
		$supplys = $this->franchisee->orderModel->fetchAll($sql);
		$supply = array();
		foreach ($supplys as $val) {
			$supply[$val['id']] = $val['title'];

		}
		include $this->loadWidget('amdinlteTheme');
	}
	//打单界面
	public function hourseorderdan() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		$this->loadModel('product', 'goods');
		$ordernum = $_GET['ordernum'];
		$sql = "select foe.ordernum,foe.productontime,foe.num as buynum,fo.id,fo.tag,fo.price as buyprice,pg.beoverdue,pg.shelflife,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number from franchisee_orderinfoprepare as foe left join franchisee_orderinfo as fo on fo.id=foe.orderinfoid left join product_goods as pg on foe.goodsid=pg.id where foe.ordernum='" . $ordernum . "'";
		$sql = "select fo.weights,foe.realbacknum,foe.ordernum,foe.allprice,foe.productontime,foe.num as buynum,fo.id,fo.tag,fo.price as buyprice,pg.beoverdue,pg.shelflife,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfoprepare as foe left join franchisee_orderinfo as fo on fo.id=foe.orderinfoid left join product_goods as pg on foe.goodsid=pg.id where foe.ordernum='" . $ordernum . "'";
		$re = $this->franchisee->orderModel->fetchAll($sql);

		//订单信息
		$sql = "select fo.backstatus,fo.id,fo.created,fo.allprice,fo.status,fo.token,fo.orderbackstatus,ws.title as wstitle from franchisee_order as fo left join wms_setting as ws on ws.id=fo.storetypeid  where fo.ordernum='" . $ordernum . "'";
		$order = $this->franchisee->orderModel->fetchRow($sql);

		//加盟商信息
		$token = $order['token'];
		$userinfo = $this->getAllianceInfo($token);

		//查看物流信息
		$sql = "select * from  franchisee_orderlogistics where orderid=" . $order['id'];
		$logistics = $this->franchisee->orderModel->fetchRow($sql);
		$this->loadModel('wms', 'setting');
		$sql = "select * from wms_setting where type=0 ";
		$store = $this->wms->settingModel->fetchAll($sql);
		//查看送货员
		$sql = "select * from system_admin where status=1";
		$user = $this->wms->settingModel->fetchAll($sql);
		//查看快递公司--物流模板
		$sql = "select * from product_general ";
		$company = $this->wms->settingModel->fetchAll($sql);
		//查看历史记录
		$sql = "select * from franchisee_orderdata where orderid=" . $order['id'] . "  and type=0";
		$log = $this->franchisee->orderModel->fetchAll($sql);

		include $this->loadView('');

	}

	//修改订单状态--库房配货
	public function updateorderstatushouse() {
		set_time_limit(0);
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadModel('franchisee', 'orderlogistics');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			
				
			$data = $_POST['data'];
			if (empty($data['senddate'])) {
				ajaxReturn('', '请填写发货日期', 0);
			}
			if (empty($data['logisticsnumber'])) {
				ajaxReturn('', '请填写物流单号', 0);
			}
			
			$datas['status'] = 4;
			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			//$line	=	true;
			if ($line) {
			
				$this->franchisee->orderlogisticsModel->delete("orderid=" . $id);
				$data['senddate'] = strtotime($data['senddate']);
				$data['maybearrivedate'] = strtotime($data['maybearrivedate']);
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();
				//$data['results']	=	"已发货";
				$l = $this->franchisee->orderlogisticsModel->insert($data);
			
				if ($l) {
					$data = array();
					$data['orderid'] = $id;
					$data['truename'] = $this->info['truename'];
					$data['created'] = time();
					$data['results'] = "已发货";
					$this->franchisee->orderdataModel->insert($data);
					$this->sendemailandmessage($id, 4, 1);
					$this->tezhisendmessage($id, 4);
					
					$this->addproductlog($id);
					
					ajaxReturn('', '操作成功', 1);
				} else {
					ajaxReturn('', '操作失败', 0);
				}

			} else {
				ajaxReturn('', '操作失败', 0);

			}

		}

	}
	//添加出库记录 franchisee_orderinfo
	public function addproductlog($id) {
		$this->loadModel('product', 'log');
		$this->loadModel('product', 'goods');
		$this->loadModel('franchisee', 'order');
		//查看是哪个加盟商
		$sql = "select fa.shoppname,fo.ordernum from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where fo.id='" . $id . "'";
		$r = $this->product->goodsModel->fetchRow($sql);
		if (!$r) {
			$r['shoppname'] = '';
			return false;
		}
		
		$ordernum = $r['ordernum'];
		$loginsert = "insert into product_log(erpcode,title,type,number,username,boxnum,created,ordernum,hasnum) values";
		$sql = "select pg.erpcode,pg.title,fo.num as number,fo.backnum,fo.boxnum,pg.number as hasnum from franchisee_orderinfo as fo left join product_goods as pg on pg.id=fo.goodsid where ordernum='" . $ordernum . "'";
		$re = $this->product->goodsModel->fetchAll($sql);
		
		$i = 0;
		$created = time();
		foreach ($re as $v) {
			$v['number'] -= $v['backnum'];
			if ($v['number'] == 0) {continue;}
			$v['hasnum']=empty($v['hasnum'])?0:$v['hasnum'];
			
			if ($i == 0) {
				$loginsert .= "('" . $v['erpcode'] . "','" . $v['title'] . "',1,'" . $v['number'] . "','" . $r['shoppname'] . "','" . $v['boxnum'] . "'," . $created . ",'" . $ordernum . "'," . $v['hasnum'] . ")";
			} else {
			
				$loginsert .= ",('" . $v['erpcode'] . "','" . $v['title'] . "',1,'" . $v['number'] . "','" . $r['shoppname'] . "','" . $v['boxnum'] . "'," . $created . ",'" . $ordernum . "'," . $v['hasnum'] . ")";
			}
			$i++;

		}
		if($i==0){
		return true;
		}
		
		$this->product->logModel->sqlexec($loginsert);
	}

//反审--库房
	public function reupdateorderstatushouse() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data = $_POST['data'];

			$datas['status'] = 3;

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			if ($line) {
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();

				$data['results'] = "反审";
				$this->franchisee->orderdataModel->insert($data);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}

	//修改订单状态 storetypeid 客审 storetypeid
	public function updateorderstatus() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data = $_POST['data'];

			if ($data['results'] == -1) {

				$datas['status'] = -1;
			} else {
				$datas['storetypeid'] = $_POST['storetypeid'];
				$datas['status'] = 2;
			}

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			if ($line) {
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();
				$results = array('0' => '修改通过', '1' => '通过', '-1' => '取消订单');
				$data['results'] = "总部复审结果:" . $results[$data['results']];
				$this->loadModel('wms', 'setting');
				$sql = "select title from wms_setting where id=" . $_POST['storetypeid'];
				$store = $this->wms->settingModel->fetchRow($sql);
				$data['results'] = $data['results'] . ",&nbsp;&nbsp;出库类型:" . $store['title'];
				if ($datas['status'] != -1) {

					$sql = "select ordernum from franchisee_order where id=" . $id;
					$order = $this->franchisee->orderModel->fetchRow($sql);
					$return = $this->systemfpgoods($order['ordernum']); //系统自动算出出库单数据
					//print_r($return);exit;
					if ($return['type'] == 1) {
						$this->franchisee->orderdataModel->insert($data);
						$this->sendemailandmessage($id, $datas['status']);
						ajaxReturn('', '操作成功', 1);
					} else {
						$line = $this->franchisee->orderModel->update(array('status' => 1), "id=" . $id);
						ajaxReturn('', '操作失败,' . $return['str'], 0);
					}
				} else {
					$this->franchisee->orderdataModel->insert($data);

					ajaxReturn('', '操作成功', 1);
				}

			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}

	//反审--客审
	public function reupdateorderstatus() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data = $_POST['data'];

			$datas['status'] = 1;

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			if ($line) {
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();

				$data['results'] = "反审";
				$this->franchisee->orderdataModel->insert($data);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//选择出库类型--修改订单状态
	public function selstoretype() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$datas['status'] = 3;
			$datas['storetypeid'] = $_POST['storetypeid'];

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			if ($line) {
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();
				$this->loadModel('wms', 'setting');
				$sql = "select title from wms_setting where id=" . $_POST['storetypeid'];
				$store = $this->wms->settingModel->fetchRow($sql);
				$data['results'] = "出库类型:" . $store['title'];
				$this->franchisee->orderdataModel->insert($data);
				$this->sendemailandmessage($id, $datas['status']);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}
	}

	//修改订单状态--财务确认-是否支付
	public function updateorderstatusfr() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper("extend");
		if ($_POST) {

			$id = $_POST['id'];

			$data = $_POST['data'];
			$sql = "select ordernum from franchisee_order where id=" . $id;
			$order = $this->franchisee->orderModel->fetchRow($sql);

			if (!isset($_POST['paytype'])) {
				ajaxReturn('', '选择确认收款项', 0);
			}
			if ($_POST['paytype'] == 0) {
				//$_POST['bankid'] = 0;
			}
			$datas['status'] = 3;

			//$datas['bankid'] = $_POST['bankid'];
			$paydate = $_POST['paydate'];
			$paytype = $_POST['paytype'];
			$datas['paytype'] = $paytype;
			$datas['paydate'] = empty($paydate) ? time() : strtotime($paydate);
			//print_r($datas);exit;

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			//$line=1;
			if ($line) {

				//锁定库存
				$line = $this->lockgoods($id);
				$str = "锁定库库失败";

				if (!$line) {
					$this->franchisee->orderModel->update(array('status' => 2), "id=" . $id);
					ajaxReturn('', $str, 0);
				}
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();
				$results = array('0' => '订单未付款,取消订单', '1' => '已付款,立即锁定库存', '-1' => '用户已取消订单,需退款');
				$data['results'] = '已付款,立即锁定库存';
				$this->franchisee->orderdataModel->insert($data);
				$this->sendemailandmessage($id, $datas['status']);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}

	//反审--财务---加回库存
	public function updateorderstatusfrback() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data = $_POST['data'];

			$datas['status'] = 2;

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			if ($line) {

				//加回库存
				$line = $this->addlockgoods($id);
				$str = "返还库库失败";
				if (!$line) {
					$this->franchisee->orderModel->update(array('status' => 3), "id=" . $id);
					ajaxReturn('', $str, 0);
				}
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();

				$data['results'] = "反审";
				$this->franchisee->orderdataModel->insert($data);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//锁定库存
	public function lockgoods($id) {
		//锁定库存---减掉库存--主表及生产日期表
		$this->loadModel('franchisee', 'order');
		$this->loadModel('product', 'productontime');
		$this->loadModel('product', 'goods');
		$sql = "select ordernum from franchisee_order where id=" . $id;
		$order = $this->franchisee->orderModel->fetchRow($sql);
		$sql = "select foe.num,foe.goodsid,foe.productontime,foe.goodsid,pg.uuid as goodsuuid,pg.number,pg.shelflife,ppe.id as ppeid,ppe.num as timenum from franchisee_orderinfoprepare as foe left join product_goods as pg on pg.id=foe.goodsid left join product_productontime as ppe on ppe.productontime=foe.productontime where foe.ordernum='" . $order['ordernum'] . "' order by foe.productontime asc";

		$sql = "select foe.num,foe.goodsid,foe.productontime,foe.goodsid,pg.uuid as goodsuuid,pg.number,pg.shelflife,pg.uuid from franchisee_orderinfoprepare as foe left join product_goods as pg on pg.id=foe.goodsid  where foe.ordernum='" . $order['ordernum'] . "' order by foe.productontime asc";

		$goods = $this->franchisee->orderModel->fetchAll($sql);

		$updatesql = "insert into product_goods(id,number) values";
		$updatesqlre = "insert into product_goods(id,number) values";
		$updatesqltime = "insert into product_productontime(id,num) values";
		$updatesqltimere = "insert into product_productontime(id,num) values";
		$i = 0;
		$ktype = 0;
		$itype = 0;
		$tag = true;
		foreach ($goods as $k => $val) {
			if ($k > 0) {$updatesql .= ",";}
			//$goodsnum = $val['number'] - $val['num'];
			if (isset($gnum[$val['goodsid']])) {$gnum[$val['goodsid']] = $gnum[$val['goodsid']] - $val['num'];} else { $gnum[$val['goodsid']] = $val['number'] - $val['num'];}
			if ($gnum[$val['goodsid']] < 0) {
				$this->franchisee->orderModel->update(array('status' => 2), "id=" . $id);

				ajaxReturn('', '商品库存不足', 0);exit;
			}
			$updatesql .= "(" . $val['goodsid'] . "," . $gnum[$val['goodsid']] . ")";
			//$updatesqlre = "(" . $val['goodsid'] . "," . $val['number'] . ")";
			$ktype = 1;
			if (empty($val['shelflife'])) {continue;}
			//到期时间表
			$sql = "select * from product_productontime where productontime=" . $val['productontime'] . " and goodsuuid='" . $val['uuid'] . "'";
			$pre = $this->franchisee->orderModel->fetchRow($sql);
			if (!$pre) {continue;}
			$val['ppeid'] = $pre['id'];
			$val['timenum'] = $pre['num'];
			if ($i > 0) {$updatesqltime .= ",";}
			$goodsnum = $val['timenum'] - $val['num'];
			if ($goodsnum < 0) {
				$this->franchisee->orderModel->update(array('status' => 2), "id=" . $id);
				ajaxReturn('', '商品库存不足', 0);exit;
			}
			$updatesqltime .= "(" . $val['ppeid'] . "," . $goodsnum . ")";
			$updatesqltimere .= "(" . $val['ppeid'] . "," . $val['timenum'] . ")";
			$i = 1;
			$itype = 1;

		}
		$line = true;
		if ($itype) {
			$updatesqltime .= " on duplicate key update num=values(num)";
			$updatesqltimere .= " on duplicate key update num=values(num)";
			//	echo $updatesqltime;echo "<br>";
			$line = $this->product->goodsModel->sqlexec($updatesqltime);

		}
		if ($ktype && $line) {
			$updatesql .= " on duplicate key update number=values(number)";
			$line = $this->product->goodsModel->sqlexec($updatesql);
			//	echo $updatesql;echo "<br>";
			if (!$line && $itype) {
				$line = $this->product->goodsModel->sqlexec($updatesqltimere);
				$tag = false;
			}
		}

		return $tag;

	}

	//锁定库存---加回库存
	public function addlockgoods($id) {
		//锁定库存---加回库存--主表及生产日期表
		//锁定库存---减掉库存--主表及生产日期表
		$this->loadModel('franchisee', 'order');
		$this->loadModel('product', 'productontime');
		$this->loadModel('product', 'goods');
		$sql = "select ordernum from franchisee_order where id=" . $id;
		$order = $this->franchisee->orderModel->fetchRow($sql);
		$sql = "select foe.num,foe.goodsid,foe.productontime,foe.goodsid,pg.uuid as goodsuuid,pg.number,pg.shelflife,ppe.id as ppeid,ppe.num as timenum from franchisee_orderinfoprepare as foe left join product_goods as pg on pg.id=foe.goodsid left join product_productontime as ppe on ppe.productontime=foe.productontime where foe.ordernum='" . $order['ordernum'] . "' order by foe.productontime asc";

		$sql = "select foe.num,foe.goodsid,foe.productontime,foe.goodsid,pg.uuid as goodsuuid,pg.number,pg.shelflife,pg.uuid from franchisee_orderinfoprepare as foe left join product_goods as pg on pg.id=foe.goodsid  where foe.ordernum='" . $order['ordernum'] . "' order by foe.productontime asc";

		$goods = $this->franchisee->orderModel->fetchAll($sql);

		$updatesql = "insert into product_goods(id,number) values";
		$updatesqlre = "insert into product_goods(id,number) values";
		$updatesqltime = "insert into product_productontime(id,num) values";
		$updatesqltimere = "insert into product_productontime(id,num) values";
		$i = 0;
		$ktype = 0;
		$itype = 0;
		$tag = true;
		foreach ($goods as $k => $val) {
			if ($k > 0) {$updatesql .= ",";}
			//$goodsnum = $val['number'] - 0 + $val['num'];
			if (isset($gnum[$val['goodsid']])) {$gnum[$val['goodsid']] = $gnum[$val['goodsid']] - 0 + $val['num'];} else { $gnum[$val['goodsid']] = $val['number'] - 0 + $val['num'];}
			$updatesql .= "(" . $val['goodsid'] . "," . $gnum[$val['goodsid']] . ")";
			//$updatesqlre = "(" . $val['goodsid'] . "," . $val['number'] . ")";
			$ktype = 1;
			if (empty($val['shelflife'])) {continue;}
			//到期时间表
			$sql = "select * from product_productontime where productontime=" . $val['productontime'] . " and goodsuuid='" . $val['uuid'] . "'";
			$pre = $this->franchisee->orderModel->fetchRow($sql);
			if (!$pre) {continue;}
			$val['ppeid'] = $pre['id'];
			$val['timenum'] = $pre['num'];
			if ($i > 0) {$updatesqltime .= ",";}
			$goodsnum = $val['timenum'] - 0 + $val['num'];
			$updatesqltime .= "(" . $val['ppeid'] . "," . $goodsnum . ")";
			$updatesqltimere .= "(" . $val['ppeid'] . "," . $val['timenum'] . ")";
			$i = 1;
			$itype = 1;

		}
		$line = true;
		if ($itype) {
			$updatesqltime .= " on duplicate key update num=values(num)";
			$updatesqltimere .= " on duplicate key update num=values(num)";

			$line = $this->product->goodsModel->sqlexec($updatesqltime);

		}
		if ($ktype && $line) {
			$updatesql .= " on duplicate key update number=values(number)";
			$line = $this->product->goodsModel->sqlexec($updatesql);
			if (!$line && $itype) {
				$line = $this->product->goodsModel->sqlexec($updatesqltimere);
				$tag = false;
			}
		}
		return $tag;

	}

	//修改订单状态--财务核验-锁定库存
	public function updateorderstatusfr2() {
		$this->loadModel('product', 'goods');
		$this->loadModel('product', 'productontime');
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadModel('franchisee', 'productontime');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data = $_POST['data'];

			if ($data['results'] == -1) {
				$datas['status'] = -4;
			} else if ($data['results'] == 1) {
				$datas['status'] = 5;
				$datas['paydate'] = time();
			}
			if ($data['results'] == 1 || $data['results'] == -1) {
				$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
				//$line=1;
			} else {
				$line = 1;
			}
			if ($line) {
				if ($data['results'] == 1) {
					//锁定库存---减掉库存--主表及生产日期表
					$sql = "select ordernum from franchisee_order where id=" . $id;
					$order = $this->franchisee->orderModel->fetchRow($sql);
					$sql = "select fo.num,fo.goodsid,fo.productontime,pg.uuid as goodsuuid from franchisee_orderinfo as fo left join product_goods as pg on pg.id=fo.goodsid  where fo.ordernum='" . $order['ordernum'] . "' order by fo.productontime asc";
					$goods = $this->franchisee->orderModel->fetchAll($sql);

					foreach ($goods as $k => $val) {
						$sql = "select * from product_productontime where goodsuuid='" . $val['goodsuuid'] . "' and productontime>=" . $val['productontime'] . " and num>0 order by productontime asc ";

						$goodstime = $this->franchisee->orderModel->fetchAll($sql);

						if ($goodstime) {
							$datap = array();
							if ($goodstime[0]['num'] < $val['num']) {
								$datap['num'] = 0;
								$num = $val['num'] - $goodstime[0]['num'];
								$this->product->productontimeModel->update($datap, "id=" . $goodstime[0]['id']);
								//第一次不够，再减第二个生产日期
								if (isset($goodstime[1]['num']) && $goodstime[1]['num'] < $num) {
									$datap['num'] = 0;
									$num = $goodstime[1]['num'] < $num;
									$this->product->productontimeModel->update($datap, "id=" . $goodstime[1]['id']);
								} else {
									$datap['num'] = $goodstime[1]['num'] - $num;
									$this->product->productontimeModel->update($datap, "id=" . $goodstime[1]['id']);
								}
							} else {
								$datap['num'] = $goodstime[0]['num'] - $val['num'];

								$this->product->productontimeModel->update($datap, "id=" . $goodstime[0]['id']);
							}

						}
						//主表数据
						$updatesql = "update product_goods set number=number-" . $val['num'] . " where id=" . $val['goodsid'];
						$this->product->goodsModel->sqlexec($updatesql);

					}
				}
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();
				$results = array('1' => '通过,立即锁定库存', '-1' => '用户已取消订单,需退款');
				$data['results'] = $results[$data['results']];
				$this->franchisee->orderdataModel->insert($data);
				$this->sendemailandmessage($id, $datas['status']);
				$this->tezhisendmessage($id, $datas['status']);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}

	//修改订单状态--财务核验-锁定库存
	/* 	public function updateorderstatusfr3(){
	$this->loadModel('franchisee','order');
	$this->loadModel('franchisee','orderdata');
	$this->loadHelper("extend");
	if($_POST){
	$id	=	$_POST['id'];
	$data	=	$_POST['data'];

	if($data['results']==-1){
	$datas['status']=-5;
	}else if($data['results']==1){
	$datas['status']=-4;
	}
	if($data['results']==-1){
	$line =$this->franchisee->orderModel->update($datas,"id=".$id);
	}else{
	$line	=	1;
	}
	if($line){

	$data['orderid']	=	$id;
	$data['truename']	=	$this->info['truename'];
	$data['created']	=	time();
	$results	=	array('1'=>'等待退款','-1'=>'已退款,订单已无效');
	$data['results']	=	$results[$data['results']];
	$this->franchisee->orderdataModel->insert($data);
	ajaxReturn ( '', '操作成功', 1 );
	}else{
	ajaxReturn ( '', '操作失败', 0 );
	}

	}


	} */
	//修改订单运费
	public function updatefreight() {
		$this->loadModel('franchisee', 'order');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data['freight'] = $_POST['freight'] - 0;
			if ($data['freight'] < 0) {
				$data['freight'] = 0;
			}
			$sql = "select id,price from franchisee_order where id=$id";
			$re = $this->franchisee->orderModel->fetchRow($sql);
			$data['allprice'] = $re['price'] + $data['freight'];
			$line = $this->franchisee->orderModel->update($data, "id=" . $id);
			if ($line) {
				ajaxReturn('back', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}

	//修改订单状态
	public function updatenopayorderstatus() {
		$this->loadModel('franchisee', 'order');
		$this->loadHelper("extend");
		if ($_GET) {
			$id = $_GET['id'];
			$data['status'] = $_GET['status'];

			$line = $this->franchisee->orderModel->update($data, "id=" . $id);
			if ($line) {
				$this->sendemailandmessage($id, $data['status']);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}

	//查看采购的商品
	public function goodslist() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'ordercart');

		$sql = "select pg.*,fo.num,fo.id as cartid from franchisee_ordercart as fo left join  product_goods as pg on fo.goodsid=pg.id  where token='" . $this->info['token'] . "'";
		$re = $this->franchisee->ordercartModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//修改报损数量
	public function updatelossnum() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderinfo');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data['lossnum'] = $_POST['lossnum'];
			$line = $this->franchisee->orderinfoModel->update($data, "id=" . $id);
			if ($line) {
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}

	////赠送订单
	public function freeorder() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');

		$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where fo.token in(select token from franchisee_alliance  where userid=" . $this->info['id'] . ") and fo.status>0 and freeordernum is not null ";

		$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where  fo.status>0 and freeordernum!='' ";

		$re = $this->franchisee->orderModel->fetchAll($sql);
		//加盟商级别
		$sql = "select * from crm_usertype ";
		$supplys = $this->franchisee->orderModel->fetchAll($sql);
		$supply = array();
		foreach ($supplys as $val) {
			$supply[$val['id']] = $val['title'];

		}
		include $this->loadWidget('amdinlteTheme');

	}
	//加盟商信息
	public function getAllianceInfo($token) {
		$this->loadModel('franchisee', 'alliance');
		$sql = "select arr.name as cname,ar.name as pname,franchisee_alliance.*,crm_usertype.title as supplytype from franchisee_alliance left join crm_usertype on crm_usertype.id=franchisee_alliance.supplytypeid left join area_region as ar on ar.id=franchisee_alliance.proviceid left join area_region as arr on arr.id=franchisee_alliance.cityid where franchisee_alliance.token='" . $token . "'";
		return $this->franchisee->allianceModel->fetchRow($sql);

	}
	//物流模板---库房 product_general franchisee_orderlogistics
	public function sellogistics() {
		$this->loadModel('franchisee', 'orderlogistics');
		$id = $_POST['id'];
		$generalid = $_POST['generalid'];
		$sql = "select companystart,mobilestart,usernamestart,companyarrive,mobilearrive,usernamearrive from franchisee_orderlogistics where id=$id and generalid=$generalid";
		$re = $this->franchisee->orderlogisticsModel->fetchRow($sql);
		if (!$re) {
			$sql = "select companystart,mobilestart,usernamestart,companyarrive,mobilearrive,usernamearrive from product_general where  id=$generalid";
			$re = $this->franchisee->orderlogisticsModel->fetchRow($sql);
		}
		echo json_encode($re);
	}
	//配货处理
	public function preparegoods() {
		$id = $_GET['id']; //orderinfo 的id
		$ordernum = $_GET['ordernum'];
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderinfo');
		$re = $this->franchisee->orderModel->fetchRow("select ordernum from franchisee_order where ordernum='" . $ordernum . "' and status>=0");
		$res = array();
		//print_r($re);exit;
		if ($re) {

			$sql = "select foi.*,pg.title,pg.boxnum,pg.barcode,pg.beoverdue,pg.uuid,pg.shelflife,pg.specs,pg.number as goodsnumber from franchisee_orderinfo as foi left join product_goods as pg on pg.id=foi.goodsid   where foi.id=$id";
			$info = $this->franchisee->orderinfoModel->fetchRow($sql);

			if (empty($info['shelflife'])) {
				//没有到期时间

				$res[0]['title'] = $info['title'];
				$res[0]['specs'] = $info['specs'];
				$res[0]['boxnum'] = $info['boxnum'];
				$res[0]['barcode'] = $info['barcode'];
				$res[0]['orderinfoid'] = $info['id'];
				$res[0]['ordernum'] = $re['ordernum'];
				$res[0]['goodsid'] = $info['goodsid'];
				$res[0]['goodsuuid'] = $info['uuid'];
				$res[0]['goodsnumber'] = $info['goodsnumber']; //库存
				$res[0]['productontime'] = 0; //保质期到
				$sql = "select num from franchisee_orderinfoprepare where orderinfoid=" . $info['id'] . " and goodsid=" . $info['goodsid'] . " and productontime=0";
				$r = $this->franchisee->orderinfoModel->fetchRow($sql);

				if ($r) {
					$res[0]['pnum'] = $r['num']; //保质期到
				}
			} else {
				$where = " goodsuuid='" . $info['uuid'] . "' ";
				$time = time(); //过期时间境界线  productontime>$time  没过期的
				$time1 = time() + $info['beoverdue'] * 24 * 3600; //临期时间境界线  productontime>$time  正常价，小于临期价
				if ($info['tag'] == 0) { //临期的
					$where .= " and productontime>=" . $info['productontime'] . " and productontime<" . $time1 . "  "; //临期价格---快过期了
				} else {
					$where .= " and  productontime>" . $time1 . "  ";
				}
				$sql = "select productontime,num,id from product_productontime where $where "; //临期价格---快过期了
				$rel = $this->franchisee->orderinfoModel->fetchAll($sql);

				foreach ($rel as $k => $val) {

					$res[$k]['title'] = $info['title'];
					$res[$k]['boxnum'] = $info['boxnum'];
					$res[$k]['specs'] = $info['specs'];
					$res[$k]['barcode'] = $info['barcode'];
					$res[$k]['orderinfoid'] = $info['id'];
					$res[$k]['ordernum'] = $re['ordernum'];
					$res[$k]['goodsid'] = $info['goodsid'];
					$res[$k]['goodsuuid'] = $info['uuid'];
					$res[$k]['goodsnumber'] = $val['num']; //库存
					$res[$k]['productontime'] = $val['productontime']; //保质期到
					$sql = "select num from franchisee_orderinfoprepare where orderinfoid=" . $info['id'] . " and goodsid=" . $info['goodsid'] . " and productontime=" . $val['productontime'];
					//echo $sql;exit;
					$r = $this->franchisee->orderinfoModel->fetchRow($sql);
					if ($r) {
						$res[$k]['pnum'] = $r['num']; //保质期到
					}

				}
			}
		}

		include $this->loadView();
	}

	//提交批货处理
	public function preparegoodstj() {
		$url = $this->url('purchase/preparegoods', array('id' => $_POST['orderinfoid'], 'ordernum' => $_POST['ordernum']));
		if (isset($_POST['asl'])) {
			$asl = $_POST['asl']; //分配数量
			$orderinfoid = $_POST['orderinfoid'];
			$this->loadModel('franchisee', 'orderinfoprepare');
			$this->loadModel('franchisee', 'orderinfo');
			$sql = "select num,price,boxnum from franchisee_orderinfo where id=" . $orderinfoid;
			$r = $this->franchisee->orderinfoModel->fetchRow($sql);
			if(!$r){
			echo "<script>alert('分配失败');window.location.href='" . $url . "';</script>";exit;
			}
			$insertSql = "insert into franchisee_orderinfoprepare(productontime,ordernum,num,goodsid,orderinfoid,allprice)values";
			$allnum = 0;
			$i = 0;
			foreach ($asl as $k => $val) {
				if (empty($val)) {
					//echo "<script>alert('分配数量不能为空');window.location.href='".$url."';</script>";exit;
					$val = 0;
					continue;
				}
				if ($val > $_POST['kc'][$k]) {
					echo "<script>alert('分配数量不能大于当前库存数量');window.location.href='" . $url . "';</script>";exit;
				}
				$allprice	=	$r['price']*$val*$r['boxnum'];
				if ($i == 0) {
					$insertSql .= "(" . $_POST['bzq'][$k] . ",'" . $_POST['ordernum'] . "'," . $val . "," . $_POST['goodsid'] . "," . $_POST['orderinfoid'] . ",".$allprice.")";
				} else {
					$insertSql .= ",(" . $_POST['bzq'][$k] . ",'" . $_POST['ordernum'] . "'," . $val . "," . $_POST['goodsid'] . "," . $_POST['orderinfoid'] . ",".$allprice.")";
				}
				$i++;
				$allnum += $val;
			}
			
			//查看一下商品订购数量和分配数量是否一致
			
			if ($r && $r['num'] != $allnum) {
				echo "<script>alert('分配失败,商品订购数量与分配数量不一致');window.location.href='" . $url . "';</script>";exit;
			}
			$this->franchisee->orderinfoprepareModel->delete('orderinfoid=' . $_POST['orderinfoid'] . ' and goodsid=' . $_POST['goodsid']);
			$tag = $this->franchisee->orderinfoprepareModel->sqlexec($insertSql);
			if ($tag) {
				echo "<script>alert('分配成功');window.location.href='" . $url . "';</script>";exit;
			} else {
				echo "<script>alert('分配失败');window.location.href='" . $url . "';</script>";exit;
			}
		} else {
			echo "<script>window.location.href='" . $url . "';</script>";exit;

		}

	}

	//客审点提交，如果没有配货,系统自动分配
	public function systemfpgoods($ordernum) {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('product', 'productontime');
		$this->loadModel('product', 'goods');
		$this->loadModel('franchisee', 'orderinfoprepare');
		//查看哪些没有配货
		$sql = "select fo.*,pg.title,pg.beoverdue,pg.uuid,pg.number,pg.shelflife from franchisee_orderinfo as fo left join product_goods as pg on pg.id=fo.goodsid   where fo.ordernum='" . $ordernum . "' and fo.id not in(select orderinfoid from franchisee_orderinfoprepare where ordernum='" . $ordernum . "')";
		$orderinfo = $this->franchisee->orderinfoprepareModel->fetchAll($sql);
		if (empty($orderinfo)) {
			return array('type' => 1, 'str' => '');
		}
		$type = 1;
		$insertSql = "insert into franchisee_orderinfoprepare(productontime,ordernum,num,goodsid,orderinfoid,allprice)values";
		$i = 0;
		$str = '';
		foreach ($orderinfo as $key => $val) {
			$time = time(); //过期时间境界线  productontime>$time  没过期的
			$time1 = time() + $val['beoverdue'] * 24 * 3600; //临期时间境界线  productontime>$time  正常价，小于临期价
			
			if ($val['tag'] == 0) {
				$sql = "select productontime,num,id from product_productontime where goodsuuid='" . $val['uuid'] . "' and productontime>=" . $val['productontime'] . " and productontime<" . $time1 . " order by  productontime asc "; //临期价格---快过期了
				$r = $this->product->goodsModel->fetchAll($sql);

				if (!$r) {
					$type = 0;
					$str .= $val['title'];
					break; //商品数据不对--手动分配
				}
				$num = $val['num'];
				foreach ($r as $k => $v) {

					if ($v['num'] <= 0) {continue;}
					if ($v['num'] >= $num) {
						$allprice	=	$val['price']*$val['boxnum']*$num;
						if ($i > 0) {$insertSql .= ",";}
						$insertSql .= "(" . $v['productontime'] . ",'" . $ordernum . "'," . $num . "," . $val['goodsid'] . "," . $val['id'] . ",".$allprice.")";
						$num = 0;
						$i = 1;
						break;
					} else {
						if ($v['num'] <= 0) {continue;}
						if ($i > 0) {$insertSql .= ",";}
						$num = $num - $v['num'];
						$allprice	=	$val['price']*$val['boxnum']*$v['num'];
						$insertSql .= "(" . $v['productontime'] . ",'" . $ordernum . "'," . $v['num'] . "," . $val['goodsid'] . "," . $val['id'] . ",".$allprice.")";
						$i = 1;
					}
				}

				if ($num != 0) {
					$type = 0;
					$str .= $val['title'];
					break; //商品数据不对--手动分配
				}

			} else {

				//正常价==>查看有没有保质期
				if (empty($val['shelflife'])) {
					//没有保质期==烟
					if ($val['num'] > $val['number']) {
						$type = 0;
						$str .= $val['title'];
						break; //商品数据不对--手动分配
					} else {
						if ($val['num'] <= 0) {continue;}
						if ($i > 0) {$insertSql .= ",";}
						$allprice	=	$val['price']*$val['boxnum']*$val['num'];
						$insertSql .= "(" . $val['productontime'] . ",'" . $ordernum . "'," . $val['num'] . "," . $val['goodsid'] . "," . $val['id'] . ",".$allprice.")";
						$i = 1;
					}
				} else {
					$sql = "select productontime,num,id from product_productontime where goodsuuid='" . $val['uuid'] . "'  and productontime>" . $time1 . " order by  productontime asc "; //正常价格
					$r = $this->product->goodsModel->fetchAll($sql);
					if (!$r) {
						$type = 0;
						$str .= $val['title'];
						break; //商品数据不对--手动分配
					}

					$num = $val['num'];
					foreach ($r as $k => $v) {

						if ($v['num'] >= $num) {
							if ($num <= 0) {continue;}
							if ($i > 0) {$insertSql .= ",";}
							$allprice	=	$val['price']*$val['boxnum']*$num;
							$insertSql .= "(" . $v['productontime'] . ",'" . $ordernum . "'," . $num . "," . $val['goodsid'] . "," . $val['id'] . ",".$allprice.")";
							$num = 0;
							$i = 1;
							break;
						} else {
							if ($v['num'] <= 0) {continue;}
							if ($i > 0) {$insertSql .= ",";}
							$num = $num - $v['num'];
							$allprice	=	$val['price']*$val['boxnum']*$v['num'];
							$insertSql .= "(" . $v['productontime'] . ",'" . $ordernum . "'," . $v['num'] . "," . $val['goodsid'] . "," . $val['id'] . ",".$allprice.")";
							$i = 1;
						}
					}

					if ($num != 0) {
						$type = 0;
						$str .= $val['title'];
						break; //商品数据不对--手动分配
					}

				}

			}

		}
		//echo $insertSql;exit;

		if ($type) {

			$this->loadModel('franchisee', 'orderinfoprepare');
			$line = $this->franchisee->orderinfoprepareModel->sqlexec($insertSql);
			if (!$line) {
				$type = -1; //操作失败
				$str = "自动配货失败,请手动配货";
			}
		} else {
			$str .= "自动配货失败,请手动配货";
		}

		return array('type' => $type, 'str' => $str);

	}
/* 	//关联订单列表-财务
public function freeorderlistcw(){
$freeordernum	=	$_GET['ordernum'];
$this->loadModel('franchisee', 'order');

$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where   freeordernum='".$freeordernum."'";

$re = $this->franchisee->orderModel->fetchAll($sql);
//加盟商级别
$sql	=	"select * from crm_usertype ";
$supplys	=	$this->franchisee->orderModel->fetchAll($sql);
$supply		=	array();
foreach($supplys as $val){
$supply[$val['id']]	=	$val['title'];

}
include $this->loadWidget('amdinlteTheme');
}
//关联订单列表-库房
public function freeorderlisthouse(){
$freeordernum	=	$_GET['ordernum'];
$this->loadModel('franchisee', 'order');

$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where   freeordernum='".$freeordernum."'";

$re = $this->franchisee->orderModel->fetchAll($sql);
//加盟商级别
$sql	=	"select * from crm_usertype ";
$supplys	=	$this->franchisee->orderModel->fetchAll($sql);
$supply		=	array();
foreach($supplys as $val){
$supply[$val['id']]	=	$val['title'];

}
include $this->loadWidget('amdinlteTheme');
}
//关联订单列表-总部
public function freeorderlistkf(){
$freeordernum	=	$_GET['ordernum'];
$this->loadModel('franchisee', 'order');

$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where   freeordernum='".$freeordernum."'";

$re = $this->franchisee->orderModel->fetchAll($sql);
//加盟商级别
$sql	=	"select * from crm_usertype ";
$supplys	=	$this->franchisee->orderModel->fetchAll($sql);
$supply		=	array();
foreach($supplys as $val){
$supply[$val['id']]	=	$val['title'];

}
include $this->loadWidget('amdinlteTheme');
} */
	//```````````````````````````````````````邮件短信通知 franchisee_order

	//特制消息人员
	public function tezhisendmessage($id, $status, $tag = 0) {
		set_time_limit(0);
		$this->loadModel("product", "messageremind");
		$keyword = "dinghuo";
		$sql = "select * from franchisee_order where id=" . $id;
		$order = $this->product->messageremindModel->fetchRow($sql);
		$sql = "select * from system_admin where id=" . $order['userid'];
		$user = $this->product->messageremindModel->fetchAll($sql);
		//smtp配置
		$sql = "select * from system_setting";
		$set = $this->product->messageremindModel->fetchAll($sql);
		$this->loadHelper('encrypt');
		$en = new encrypt();
		$this->loadHelper('extend');
		$this->loadHelper('smtp');
		//$data = $_POST['data'];
		$smtpserver = $set[4]['value'];
		$smtpserverport = $set[5]['value'];
		$smtpusermail = $set[6]['value'];
		$temparr = explode('@', $smtpusermail);
		$smtpuser = $temparr[0];
		$smtppass = $en->decode($set[8]['value']);
		//邮件主题
		$mailsubject = "您有一个订货单";
		//邮件内容
		$mailbody = "采购订单号：" . $order['ordernum'];
		//邮件格式（HTML/TXT）,TXT为文本邮件
		$mailtype = "HTML";
		//这里面的一个true是表示使用身份验证,否则不使用身份验证.
		$smtp = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
		if ($user) {
			//给内部员工发送邮件及短信
			foreach ($user as $val) {
				if (!empty($val['email'])) {
					$re = $smtp->sendmail($val['email'], $smtpusermail, $mailsubject, $mailbody, $mailtype);
				}
				if (!empty($val['mobile'])) {
					$str = $order['ordernum'];
					$re = $this->sendmessage($str, $val['mobile']);
				}
			}
		}
	}
	//发送邮件及短信,$tag=1时，表示须传给加盟商发消息通知
	public function sendemailandmessage($id, $status, $tag = 0) {
		set_time_limit(0);
		$this->loadModel("product", "messageremind");
		$keyword = "dinghuo";
		$sql = "select sa.* from product_messageremind as pm left join system_admin as sa on sa.id=pm.userid  where pm.keyword='" . $keyword . "' and orderstatus=" . $status;
		$user = $this->product->messageremindModel->fetchAll($sql);
		$sql = "select * from franchisee_order where id=" . $id;
		$order = $this->product->messageremindModel->fetchRow($sql);
		//print_r($order);exit;
		if ($tag == 1) {
			$sql = "select * from franchisee_alliance token='" . $order['token'] . "'";
			$alliance = $this->product->messageremindModel->fetchRow($sql);
			$token = $alliance['token'];
		}
		//smtp配置
		$sql = "select * from system_setting";
		$set = $this->product->messageremindModel->fetchAll($sql);
		$this->loadHelper('encrypt');
		$en = new encrypt();
		$this->loadHelper('extend');
		$this->loadHelper('smtp');
		//$data = $_POST['data'];
		$smtpserver = $set[4]['value'];
		$smtpserverport = $set[5]['value'];
		$smtpusermail = $set[6]['value'];
		$temparr = explode('@', $smtpusermail);
		$smtpuser = $temparr[0];
		$smtppass = $en->decode($set[8]['value']);
		//邮件主题
		$mailsubject = "您有一个订货单";
		//邮件内容
		$mailbody = "订货单单号：" . $order['ordernum'];
		//邮件格式（HTML/TXT）,TXT为文本邮件
		$mailtype = "HTML";
		//这里面的一个true是表示使用身份验证,否则不使用身份验证.
		$smtp = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
		if ($user) {
			//给内部员工发送邮件及短信
			foreach ($user as $val) {
				if (!empty($val['email'])) {
					$re = $smtp->sendmail($val['email'], $smtpusermail, $mailsubject, $mailbody, $mailtype);
				}
				if (!empty($val['mobile'])) {
					$str = $order['ordernum'];
					$re = $this->sendmessage($str, $val['mobile']);
				}
			}
		}
		if (empty($token)) {
			//	给加盟商发邮件及短信
			if (!empty($alliance['email'])) {
				$re = $smtp->sendmail($alliance['email'], $smtpusermail, $mailsubject, $mailbody, $mailtype);

			}
			if (!empty($alliance['mobile'])) {
				$str = $order['ordernum'];
				$re = $this->sendmessage($str, $alliance['mobile']);
			}
		}

	}

	//发送短信通知

	public function sendmessage($str, $mobile) {
		
		$this->loadHelper('sms');

		$sms = new sms();

		$bk = $sms->send_order_message($str, $mobile);
		//  print_r($bk);exit;
		
		return $bk;
	}

}
?>