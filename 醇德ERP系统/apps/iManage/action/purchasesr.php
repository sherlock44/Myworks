<?php

/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */

class purchasesr extends actionAbstract {
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
		//$this->info = acl::checkLogin('admininfo',$this->url('common/login'));
		if (!isset($_SESSION['admininfo'])) {header('location:' . $this->url('common/login'));}$this->info = $_SESSION['admininfo'];
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		$this->conf = $this->loadConfig('sysconf');
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			//ajax request
			$this->checkpower();
		}

	}

	//待确认订单
	public function orderconfirm() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token  where fo.token in(select token from franchisee_alliance  where userid=" . $this->info['id'] . ") and fo.status=0";
		//$sql	=	"select * from franchisee_order where  status=0";

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
	//已完成订单
	public function orderover() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		//$sql = "select * from franchisee_order where token in(select token from franchisee_alliance  where userid=" . $this->info['id'] . ") and status=5";
		$sql = "select fo.*,fa.shoppname,fa.supplytypeid,freefo.ordernum as freeordernum from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token left join  franchisee_order as freefo on freefo.freeordernum=fo.ordernum where fo.token in(select token from franchisee_alliance  where userid=" . $this->info['id'] . ") and  fo.status=5";
		
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
	//未完成订单
	public function ordernoover() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		
		$sql = "select fo.*,fa.shoppname,fa.supplytypeid,freefo.ordernum as freeordernum from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token  left join  franchisee_order as freefo on freefo.freeordernum=fo.ordernum where fo.token in(select token from franchisee_alliance  where userid=" . $this->info['id'] . ") and fo.status>0 and fo.status<5";
		
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
	////赠送订单
	public function freeorder() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		
		$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where fo.token in(select token from franchisee_alliance  where userid=" . $this->info['id'] . ") and fo.status>0 and freeordernum is not null ";
		
		
		$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where fo.token in(select token from franchisee_alliance  where userid=" . $this->info['id'] . ") and fo.status>=0 and freeordernum!='' ";
		
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
	//关联订单列表
	public function freeorderlist(){
		$freeordernum	=	$_GET['ordernum'];
		$this->loadModel('franchisee', 'order');
		
		$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where  freeordernum='".$freeordernum."'";
		
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
	//无效订单
	public function orderwuxiao() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		//$sql = "select * from franchisee_order where token in(select token from franchisee_alliance  where userid=" . $this->info['id'] . ") and status<0 ";
		$sql = "select fo.*,fa.shoppname,fa.supplytypeid from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where fo.token in(select token from franchisee_alliance  where userid=" . $this->info['id'] . ") and  fo.status<0";
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

	//所有订单---统计
	public function orderlist() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$starttime = isset($_GET['starttime']) ? $_GET['starttime'] : 0;
		$endtime = isset($_GET['endtime']) ? $_GET['endtime'] : 0;
		$cityid = isset($_GET['cityid']) ? $_GET['cityid'] : 0;
		$proviceid = isset($_GET['proviceid']) ? $_GET['proviceid'] : 0;
		$status = isset($_GET['status']) ? $_GET['status'] : '';
		$where = "";
		if (!empty($starttime) && !empty($endtime)) {
			$starttime = strtotime($starttime);
			$endtime = strtotime($endtime);
			$where .= " and created>=" . $starttime . " and created<=" . $endtime;
		}
		if (!empty($cityid)) {
			$where .= " and cityid=" . $cityid;
		}
		if ($status != '') {
			if ($status == 0) {
				$where .= " and status=" . $status;
			} else if ($status == 2) {
				$where .= " and status=5";
			} else if ($status == 1) {
				$where .= " and status>0 and status<5";
			} else {
				$where .= " and status<0";
			}
		}
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = isset($_GET['pagenum']) ? $_GET['pagenum'] : 10;
		$offset = ($page - 1) * $size;
		$sql = "select count(*) from franchisee_order  where token in(select token from franchisee_alliance  where userid=" . $this->info['id'] . ") " . $where;

		$count = $this->franchisee->orderModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select * from franchisee_order where token in(select token from franchisee_alliance  where userid=" . $this->info['id'] . ") " . $where . "  limit " . $offset . "," . $size . "";
		$re = $this->franchisee->orderModel->fetchAll($sql);

		//查询所有省
		$sql = "select * from area_region where parentid=1";
		$provice = $this->franchisee->orderModel->fetchAll($sql);
		$city = array();
		if ($proviceid > 0) {
			$sql = "select * from area_region where parentid=" . $proviceid;
			$city = $this->franchisee->orderModel->fetchAll($sql);
		}
		include $this->loadWidget('amdinlteTheme');

	}
	//通过省Id 得到对应的城市
	public function getCity() {
		$parentid = $_POST['id'];
		$this->loadModel('franchisee', 'order');
		$sql = "select * from area_region where parentid=" . $parentid;
		$city = $this->franchisee->orderModel->fetchAll($sql);
		$str = "<option value='0'>选择城市</option>";
		foreach ($city as $val) {
			$str .= "<option value='" . $val['id'] . "'>" . $val['name'] . "</option>";
		}
		echo $str;
	}
	//订单详情
	public function orderinfo() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		$this->loadModel('product', 'goods');
		$ordernum = $_GET['ordernum'];
		//订单信息
		$sql = "select fo.allprice ,fo.created,fo.remark,fo.freeordernum,fo.survey,fo.id,fo.status,fo.token,ws.title as wstitle,fo.orderbackstatus,fo.backstatus from franchisee_order as fo left join wms_setting as ws on ws.id=fo.storetypeid  where fo.ordernum='" . $ordernum . "'";
		$order = $this->franchisee->orderModel->fetchRow($sql);
		//查看该订单是否有赠送订单
		$sql	=	"select ordernum from franchisee_order where freeordernum='".$ordernum."'";
		$freeorder = $this->franchisee->orderModel->fetchRow($sql);
		//$sql = "select fo.weights,fo.allprice,fo.realbacknum,fo.id,fo.tag,fo.productontime,pg.beoverdue,pg.uuid,pg.shelflife,fo.num as buynum,fo.price as buyprice,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id  where fo.ordernum='" . $ordernum . "'";
		if ($order['status'] >= 2) {

			$sql = "select fo.weights ,fo.realbacknum,foe.allprice,foe.ordernum,foe.productontime,foe.num as buynum,fo.id,fo.tag,fo.price as buyprice,pg.uuid,pg.beoverdue,pg.shelflife,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfoprepare as foe left join franchisee_orderinfo as fo on fo.id=foe.orderinfoid left join product_goods as pg on foe.goodsid=pg.id where foe.ordernum='" . $ordernum . "'";
		} else {
			$sql = "select fo.weights ,fo.realbacknum,fo.allprice,fo.ordernum,fo.productontime,fo.id,fo.tag,pg.beoverdue,pg.shelflife,pg.uuid,fo.num as buynum,fo.price as buyprice,pg.uuid,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id  where fo.ordernum='" . $ordernum . "'";

		}
		$re = $this->franchisee->orderModel->fetchAll($sql);
		if ($order['status'] < 1) {
			//	查看库存 product_productontime

			foreach ($re as $k => $v) {
				$v['boxnum'] = $v['boxnum'] - 0;
				if (empty($v['boxnum'])) {
					$re[$k]['hasnumber'] = '0';
					continue;
				}
				if ($v['productontime'] == 0) {
					//正常的库存
					//$re[$k]['hasnumber'] = floor($v['number'] / $v['boxnum']);
					$re[$k]['hasnumber'] = $v['number'];
				} else {
					if ($v['tag'] == 1) {
						//未临期
						$sql = "select sum(num) as number from product_productontime where goodsuuid='" . $v['uuid'] . "' and productontime>='" . $v['productontime'] . "'";
						$r = $this->franchisee->orderModel->fetchRow($sql);
						if ($r) {
							//$re[$k]['hasnumber'] = floor($r['number'] / $v['boxnum']);
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

		//加盟商信息
		$token = $order['token'];
		$userinfo = $this->getAllianceInfo($token);

		//查看历史记录
		$sql = "select * from franchisee_orderdata where orderid=" . $order['id'] . "  and type=0 order by created desc";
		$log = $this->franchisee->orderModel->fetchAll($sql);
		//按时间重新组合日志  --开始
		$logs	=	array();
		foreach($log as $k=>$val){
			$logs[date("Y-m-d",$val['created'])][]=$val;
		}
		//print_r($logs);exit;
		//按时间重新组合日志  --结束
		//
		$this->loadModel('wms', 'setting');
		$sql = "select * from wms_setting where type=0 ";
		$store = $this->wms->settingModel->fetchAll($sql);
		
		//查看物流信息
				//查看物流信息
		$sql = "select fo.*,sa.truename as peihuoname,saa.truename as heyanname,saaa.truename as fahuoname from  franchisee_orderlogistics as fo left join system_admin as sa on sa.id=fo.peihuoid  left join system_admin as saa on saa.id=fo.heyanid  left join system_admin as saaa on saaa.id=fo.fahuoid where fo.orderid=" . $order['id'];
		$logistics = $this->franchisee->orderModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
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

				$sql = "select freight,allprice from franchisee_order where ordernum='" . $order['ordernum'] . "'";
				$r = $this->franchisee->orderModel->fetchRow($sql);
				$data = array();
				if(!$res){
				$data['status'] = -1;
				}
				$data['price'] = $price;
				$data['allprice'] = $price - 0 + $r['freight'];
				$data['survey'] = "共" . count($res) . "种商品,重量" . $weight . "Kg,总计" . $data['allprice'];
				$this->franchisee->orderModel->update($data, "ordernum='" . $order['ordernum'] . "'");
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//修改订单状态
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
				$datas['status'] = 1;
			}

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			if ($line) {
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();
				$results = array('0' => '修改通过', '1' => '通过', '-1' => '未通过');
				$data['results'] = $results[$data['results']];
				$this->franchisee->orderdataModel->insert($data);
				$this->sendemailandmessage($id,$datas['status']);
				//$this->tezhisendmessage($id,$datas['status']);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//反审
	public function reupdateorderstatus() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data = $_POST['data'];

			$datas['status'] = 0;

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
	//加盟商退货
	public function orderback() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data = $_POST['data'];

			$datas['orderbackstatus'] = $_POST['orderbackstatus'];

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			if ($line) {
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();
				$str = $_POST['orderbackstatus'] == 1 ? '商品未发货' : '商品已发货';
				$data['results'] = "加盟商退货" . $str;
				$this->franchisee->orderdataModel->insert($data);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
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
	//未付款订单
	public function ordernopay() {
		$this->leftpos = 3;
		$this->loadModel('franchisee', 'order');
		$sql = "select * from franchisee_order where status=1  and userid=" . $this->info['id'];
		$re = $this->franchisee->orderModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//订单详情
	public function nopayinfo() {
		$this->leftpos = 3;
		$this->loadModel('franchisee', 'order');
		$ordernum = $_GET['ordernum'];
		$sql = "select fo.num as buynum,fo.price as buyprice,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id where fo.ordernum='" . $ordernum . "'";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		$token = $_GET['token'];
		$userinfo = $this->getAllianceInfo($token);
		$sql = "select status from franchisee_order where ordernum='" . $ordernum . "'";
		$order = $this->franchisee->orderModel->fetchRow($sql);

		include $this->loadWidget('amdinlteTheme');
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
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//已付款订单
	public function orderpay() {
		$this->leftpos = 4;
		$this->loadModel('franchisee', 'order');
		$sql = "select * from franchisee_order where status=2  and userid=" . $this->info['id'];
		$re = $this->franchisee->orderModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//订单详情
	public function payinfo() {
		$this->leftpos = 4;
		$this->loadModel('franchisee', 'order');
		$ordernum = $_GET['ordernum'];
		$sql = "select fo.num as buynum,fo.price as buyprice,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id where fo.ordernum='" . $ordernum . "'";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		$token = $_GET['token'];
		$userinfo = $this->getAllianceInfo($token);
		$sql = "select status from franchisee_order where ordernum='" . $ordernum . "'";
		$order = $this->franchisee->orderModel->fetchRow($sql);

		include $this->loadWidget('amdinlteTheme');
	}

	//修改订单状态
	public function updatepayorderstatus() {
		$this->loadModel('franchisee', 'order');
		$this->loadHelper("extend");
		if ($_GET) {
			$id = $_GET['id'];
			$data['status'] = $_GET['status'];

			$line = $this->franchisee->orderModel->update($data, "id=" . $id);
			if ($line) {
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//未发货订单
	public function ordernodeliver() {
		$this->leftpos = 5;
		$this->loadModel('franchisee', 'order');
		$sql = "select * from franchisee_order where status=3  and userid=" . $this->info['id'];
		$re = $this->franchisee->orderModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//订单详情
	public function nodeliverinfo() {
		$this->leftpos = 5;
		$this->loadModel('franchisee', 'order');
		$ordernum = $_GET['ordernum'];
		$sql = "select fo.num as buynum,fo.price as buyprice,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id where fo.ordernum='" . $ordernum . "'";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		$token = $_GET['token'];
		$userinfo = $this->getAllianceInfo($token);

		$sql = "select status from franchisee_order where ordernum='" . $ordernum . "'";
		$order = $this->franchisee->orderModel->fetchRow($sql);

		include $this->loadWidget('amdinlteTheme');
	}
	//修改订单状态
	public function updatedeliverstatus() {
		$this->loadModel('franchisee', 'order');
		$this->loadHelper("extend");
		if ($_GET) {
			$id = $_GET['id'];
			$data['status'] = $_GET['status'];

			$line = $this->franchisee->orderModel->update($data, "id=" . $id);
			if ($line) {
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//已发货订单
	public function orderdeliver() {
		$this->leftpos = 6;
		$this->loadModel('franchisee', 'order');
		$sql = "select * from franchisee_order where status=4  and userid=" . $this->info['id'];
		$re = $this->franchisee->orderModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//订单详情
	public function deliverinfo() {
		$this->leftpos = 6;
		$this->loadModel('franchisee', 'order');
		$ordernum = $_GET['ordernum'];
		$sql = "select fo.num as buynum,fo.price as buyprice,fo.lossnum,fo.id,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id where fo.ordernum='" . $ordernum . "'";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		$token = $_GET['token'];
		$userinfo = $this->getAllianceInfo($token);

		$sql = "select status from franchisee_order where ordernum='" . $ordernum . "'";
		$order = $this->franchisee->orderModel->fetchRow($sql);

		include $this->loadWidget('amdinlteTheme');
	}
	//已完成订单
	public function ordercomplete() {
		$this->leftpos = 7;
		$this->loadModel('franchisee', 'order');
		$sql = "select * from franchisee_order where status=5  and userid=" . $this->info['id'];
		$re = $this->franchisee->orderModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//订单详情
	public function completeinfo() {
		$this->leftpos = 7;
		$this->loadModel('franchisee', 'order');
		$ordernum = $_GET['ordernum'];
		$sql = "select fo.num as buynum,fo.price as buyprice,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id where fo.ordernum='" . $ordernum . "'";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		$token = $_GET['token'];
		$userinfo = $this->getAllianceInfo($token);

		$sql = "select status from franchisee_order where ordernum='" . $ordernum . "'";
		$order = $this->franchisee->orderModel->fetchRow($sql);

		include $this->loadWidget('amdinlteTheme');
	}
	//已取消订单
	public function ordercancel() {
		$this->leftpos = 8;
		$this->loadModel('franchisee', 'order');
		$sql = "select * from franchisee_order where status=-1  and userid=" . $this->info['id'];
		$re = $this->franchisee->orderModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//订单详情
	public function cancelinfo() {
		$this->leftpos = 8;
		$this->loadModel('franchisee', 'order');
		$ordernum = $_GET['ordernum'];
		$sql = "select fo.num as buynum,fo.price as buyprice,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id where fo.ordernum='" . $ordernum . "'";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		$token = $_GET['token'];
		$userinfo = $this->getAllianceInfo($token);

		$sql = "select status from franchisee_order where ordernum='" . $ordernum . "'";
		$order = $this->franchisee->orderModel->fetchRow($sql);

		include $this->loadWidget('amdinlteTheme');
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
	
	//创建关联订单
	public function createorder() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderinfo');
		$this->loadHelper("extend");
		
		
		include $this->loadWidget('amdinlteTheme');
	

	}
	//商品列表ajax
	
	//加盟商信息
	public function getAllianceInfo($token) {
		$this->loadModel('franchisee', 'alliance');

		$sql = "select arr.name as cname,ar.name as pname,franchisee_alliance.*,crm_usertype.title as supplytype from franchisee_alliance left join crm_usertype on crm_usertype.id=franchisee_alliance.supplytypeid left join area_region as ar on ar.id=franchisee_alliance.proviceid left join area_region as arr on arr.id=franchisee_alliance.cityid where franchisee_alliance.token='" . $token . "'";
		return $this->franchisee->allianceModel->fetchRow($sql);

	}
	//```````````````````````````````````````邮件短信通知 franchisee_order
	//特制消息人员
	public function tezhisendmessage($id, $status, $tag = 0){
		set_time_limit(0);
		$this->loadModel("product", "messageremind");
		$keyword = "dinghuo";
		$sql = "select * from franchisee_order where id=" . $id;
		$order = $this->product->messageremindModel->fetchRow($sql);
		$sql	=	"select * from system_admin where id=".$order['userid'];
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
		if($tag==1){
			$sql	=	"select * from franchisee_alliance token='".$order['token']."'";
			$alliance = $this->product->messageremindModel->fetchRow($sql);
			$token	=	$alliance['token'];
		}
		//smtp配置
		$sql = "select * from system_setting";
		$set = $this->product->messageremindModel->fetchAll($sql);
		$this->loadHelper('encrypt');
		$en = new encrypt();
		$this->loadHelper('extend');
		$this->loadHelper('smtp');
		$data = $_POST['data'];
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
		if(empty($token)){
			//	给加盟商发邮件及短信
			if(!empty($alliance['email'])){
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

		$bk = $sms->send_orderback_message($str, $mobile);
		//  print_r($bk);exit;
		return $bk;
	}
}
?>