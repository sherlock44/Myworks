<?php

/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */

class Financialaffairs extends actionAbstract {
	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 9;
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
		$sql = "select fo.num as buynum,fo.allprice as buyprice,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id where fo.ordernum='" . $ordernum . "'";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//应付款
	public function Tocopewith() {
		$this->leftpos = 1;
		$this->loadModel('product', 'orderinfo');
		$this->loadModel('product', 'goods');
		$sql = "select po.*,pg.title,pg.imgpath,pg.barcode,phs.title as phstitle,ph.title as phtitle from product_orderinfo as po left join product_goods as pg on pg.id=po.goodsid left join product_house as ph on ph.id=po.houseid left join product_housepos as phs on phs.id=po.houseposid where po.applyid=1";
		$re = $this->product->orderinfoModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');
	}
	//应收款
	public function handle() {
		$this->leftpos = 0;
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
		$this->leftpos = 2;
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
	//已付款
	public function fukuan() {
		$this->leftpos = 2;
		$this->loadModel('franchisee', 'order');
		$sql = "select * from franchisee_order where status=2  ";
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
	//加盟商信用额度管理
	public function creditManage() {
		$this->pos = 7;
		$this->loadModel('franchisee', 'alliance');
		$this->loadModel('area', 'region');
		$this->loadHelper('extend');
		$sql = "select franchisee_alliance.*,cs.title as ctitle from franchisee_alliance
              left join crm_usertype as cs on franchisee_alliance.supplytypeid=cs.id
              where franchisee_alliance.status=1";
		$re = $this->franchisee->allianceModel->fetchAll($sql);
		$sql = "select id,name from area_region ";
		$area = $this->area->regionModel->fetchAll($sql);
		$areaarray = array();
		foreach ($area as $k => $val) {
			$areaarray[$val['id']] = $val['name'];

		}
		$areaarray[0] = '';
		include $this->loadWidget('amdinlteTheme');
	}
	//修改信用额度
	public function editCredit() {
		$this->pos = 7;

		$id = $_GET['id'];
		$this->loadModel('franchisee', 'creditlog');
		$this->leftpos = 4;
		$this->loadModel('franchisee', 'alliance');
		$this->loadHelper('extend');
		$sql = "select fa.*,cs.title as ctitle from franchisee_alliance as fa
                left join crm_usertype as cs on fa.supplytypeid=cs.id
                where fa.id={$id}";
		$re = $this->franchisee->allianceModel->fetchRow($sql);
		$sql = "select fc.*,sa.name from franchisee_creditlog as fc join system_admin as sa on sa.id=fc.adminid where frid = {$id}";
		$log = $this->franchisee->creditlogModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');

	}

	//修改信用额度
	public function updateCredit() {
		$this->pos = 7;
		if ($_POST) {
			$this->loadHelper('extend');
			$this->loadModel('franchisee', 'alliance');
			$this->loadModel('franchisee', 'creditlog');
			$id = $_POST['id'];
			$data = $_POST['data'];
			$ue = $this->info;
			$sql = "select creditline,canusemoney from franchisee_alliance where id={$id}";
			$rs = $this->franchisee->allianceModel->fetchRow($sql);
			$bkid = $this->franchisee->allianceModel->update($data, $id);
			if ($bkid) {
				$lgdt['time'] = time();
				$lgdt['adminid'] = $ue['id'];
				$lgdt['note'] = $_POST['note'];
				$lgdt['frid'] = $id;
				$edct = '';
				if ($rs['creditline'] != $data['creditline']) {
					$edct = "信用额度由" . $rs['creditline'] . "调整到" . $data['creditline'] . ";";
				}
				if ($rs['canusemoney'] != $data['canusemoney']) {
					$edct .= "当前信用额度由" . $rs['canusemoney'] . "调整到" . $data['canusemoney'] . ".";
				}
				$lgdt['editcont'] = $edct;
				$this->franchisee->creditlogModel->insert($lgdt);
				ajaxReturn('back', '修改成功', 1);exit;
			} else {
				ajaxReturn('', '数据格式不正确或数据未发生改变', 0);exit;
			}
		}
	}
	//银行账户管理列表
	public function banklist() {
		$this->pos = 7;
		$this->loadModel('system', 'bank');
		$sql = "select * from system_bank ";
		$re = $this->system->bankModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//添加银行账户
	public function addBank() {
		$this->pos = 7;
		if ($_POST) {
			$this->loadHelper('extend');
			$this->loadModel('system', 'bank');
			$data = $_POST['data'];
			$data['uptime'] = time();
			$bkid = $this->system->bankModel->insert($data);
			if ($bkid) {
				ajaxReturn('back', '添加成功', 1);exit;
			} else {
				ajaxReturn('', '添加失败', 0);exit;
			}
		} else {
			include $this->loadWidget('amdinlteTheme');
		}
	}
	//修改银行账户
	public function editBank() {
		$this->pos = 7;
		if ($_POST) {
			$this->loadHelper('extend');
			$this->loadModel('system', 'bank');
			$data = $_POST['data'];
			$id = $_POST['id'];
			$data['uptime'] = time();
			$bkid = $this->system->bankModel->update($data, $id);
			if ($bkid) {
				ajaxReturn('back', '修改成功', 1);exit;
			} else {
				ajaxReturn('', '修改失败', 0);exit;
			}
		} else {
			$id = $_GET['id'];
			$this->loadModel('system', 'bank');
			$sql = "select * from system_bank where id =  {$id}";
			$one = $this->system->bankModel->fetchRow($sql);
			include $this->loadWidget('amdinlteTheme');
		}
	}
	//删除银行卡
	public function delBank() {
		$this->loadHelper('extend');
		$this->loadModel('system', 'bank');
		if ($_GET) {
			$id = $_GET['id'];
			$re = $this->system->bankModel->delete($id);
			if ($re) {
				ajaxReturn('', '删除成功', 1);exit;
			} else {
				ajaxReturn('', '删除失败', 0);exit;
			}
		}
	}
	//财务报表
	public function reportformcw(){
		$this->loadModel('product', 'log');
		$this->loadModel('franchisee', 'order');
		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$starttime = isset($_GET['starttime']) ? $_GET['starttime'] : 0;
		$endtime = isset($_GET['endtime']) ? $_GET['endtime'] : 0;
		$keyword	=	isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
		$where = "";
		if (!empty($starttime) && !empty($endtime)) {
			$starttime = strtotime($starttime);
			$endtime = strtotime($endtime)-1+24*3600;
			$where .= " and created>=" . $starttime . " and created<=" . $endtime;
		}
		if(!empty($keyword)){
			$where.=" and title like '%".$keyword."%' ";
		
		}
	
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = isset($_GET['pagenum']) ? $_GET['pagenum'] : 10;
		$offset = ($page - 1) * $size;
		$sql = "select count(*) from product_log  where 1=1 " . $where;

		$count = $this->franchisee->orderModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select * from product_log where 1=1 " . $where . "  order by created desc limit " . $offset . "," . $size . "";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		$ywtype	=	array('0'=>'采购入库','1'=>'加盟商订货出库','2'=>'加盟商退货入库');
		
		include $this->loadWidget('amdinlteTheme');
	
	}
}
?>