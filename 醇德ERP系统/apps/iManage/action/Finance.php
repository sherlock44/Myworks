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
		// $this->info = acl::checkLogin('admininfo',$this->url('common/login'));
		if (!isset($_SESSION['admininfo'])) {header('location:' . $this->url('common/login'));}$this->info = $_SESSION['admininfo'];
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			//ajax request
			$this->checkpower();
		}
	}

	//待确认订单
	public function orderconfirm() {
		$this->leftpos = 2;
		$this->loadModel('franchisee', 'order');
		$sql = "select * from franchisee_order where status=0 ";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//修改订单状态
	public function updateorderstatus() {
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
	//订单详情
	public function orderinfo() {
		$this->leftpos = 2;
		$this->loadModel('franchisee', 'order');
		$ordernum = $_GET['ordernum'];
		$sql = "select fo.num as buynum,fo.price as buyprice,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id where fo.ordernum='" . $ordernum . "'";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//未付款订单
	public function ordernopay() {
		$this->leftpos = 3;
		$this->loadModel('franchisee', 'order');
		$sql = "select * from franchisee_order where status=1  ";
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
		include $this->loadWidget('amdinlteTheme');
	}
	//已付款订单
	public function orderpay() {
		$this->leftpos = 4;
		$this->loadModel('franchisee', 'order');
		$sql = "select * from franchisee_order where status=2  ";
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
		include $this->loadWidget('amdinlteTheme');
	}
	//未发货订单
	public function ordernodeliver() {
		$this->leftpos = 5;
		$this->loadModel('franchisee', 'order');
		$sql = "select * from franchisee_order where status=3  ";
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
		include $this->loadWidget('amdinlteTheme');
	}
	//已发货订单
	public function orderdeliver() {
		$this->leftpos = 6;
		$this->loadModel('franchisee', 'order');
		$sql = "select * from franchisee_order where status=4  ";
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
		include $this->loadWidget('amdinlteTheme');
	}
	//已完成订单
	public function ordercomplete() {
		$this->leftpos = 7;
		$this->loadModel('franchisee', 'order');
		$sql = "select * from franchisee_order where status=5  ";
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
		include $this->loadWidget('amdinlteTheme');
	}
	//已取消订单
	public function ordercancel() {
		$this->leftpos = 8;
		$this->loadModel('franchisee', 'order');
		$sql = "select * from franchisee_order where status=-1  ";
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

}
?>