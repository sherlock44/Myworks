<?php
/*
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */
class statis extends actionAbstract {

	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 11;
	public $type = 0;
	public $leftpos = 11;
	/*
	 * 构造
	 */
	function __construct() {
		parent::__construct();
		//$this->info = acl::checkLogin('admininfo',$this->url('common/login'));
		if (!isset($_SESSION['admininfo'])) {header('location:' . $this->url('common/login'));}$this->info = $_SESSION['admininfo'];
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$this->checkpower();
		}
	}
	//加盟商营业额统计
	public function turnover() {
		$this->leftpos = 1;
		$this->loadmodel('franchisee', 'userorder');
		$this->loadmodel('franchisee', 'alliance');
		$start = '';
		$end = '';
		$jms = '';
		$where = '';
		if (isset($_GET['jms']) && !empty($_GET['jms'])) {
			$jms = $_GET['jms'];
			$where = " and fa.suppname like '%" . $_GET['jms'] . "%' ";
		}
		//开始时间戳
		if (isset($_GET['start']) && !empty($_GET['start'])) {
			$start = $_GET['start'];
			$stsjc = strtotime($start);
		}
		//结束时间戳
		if (isset($_GET['end']) && !empty($_GET['end'])) {
			$end = $_GET['end'];
			$edsjc = strtotime($end);
		}
		if ($start && $end) {
			$where .= "  and (fu.created>'{$stsjc}' and fu.created<'{$edsjc}' )";
			$sql = "select sum(fu.price) as tolpri,fa.suppname from franchisee_userorder as fu
                    join franchisee_alliance as fa on fa.token = fu.token
    	            where fu.paystatus=1 " . $where . "group by fu.token ";
			$rs = $this->franchisee->userorderModel->fetchAll($sql);
			include $this->loadWidget('amdinlteTheme');
		} else {
			$rs = array();
			include $this->loadWidget('amdinlteTheme');
		}
	}
	//加盟商订单管理
	public function order() {
		$this->leftpos = 2;
		$this->loadModel('franchisee', 'alliance');
		$this->loadModel('area', 'region');
		$this->loadHelper('extend');
		$sql = "select franchisee_alliance.*,cs.title as ctitle from franchisee_alliance left join crm_usertype as cs on franchisee_alliance.supplytypeid=cs.id ";
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
	//订单列表
	public function listOrder() {
		$this->leftpos = 2;
		$this->loadmodel('franchisee', 'userorder');
		$sql = "select * from franchisee_userorder where token =" . $_GET['id'];
		$rs = $this->franchisee->userorderModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//订单详情
	public function orderDetil() {
		$this->leftpos = 2;
		$this->loadModel('franchisee', 'userorder');
		$this->loadModel('franchisee', 'userorderinfo');
		$id = $_GET['id'];
		$sql = "select fu.*,fw.truename from franchisee_userorder as fu
                     join franchisee_worker as  fw on fu.workeruuid = fw.uuid
                     where fu.id = {$id}";
		$bsinfo = $this->franchisee->userorderModel->fetchRow($sql);
		$sql = "select fuf.* ,fp.title,fp.barcode from franchisee_userorderinfo as fuf
                   join franchisee_product as fp on fp.uuid = fuf.productuuid
                   where fuf.userorderuuid = '{$bsinfo['uuid']}'";
		$orinfo = $this->franchisee->userorderinfoModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//统计商品的销售量
	public function getgoods() {
		$this->loadModel('franchisee', 'orderinfo');
		$this->loadModel('product', 'goods');
		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$where = "";
		$starttime = isset($_GET['starttime']) ? strtotime($_GET['starttime']) : '';
		$endtime = isset($_GET['endtime']) ? strtotime($_GET['endtime']) : '';
		$re = array();
		$pageHtml = '';
		if (!empty($starttime) && !empty($endtime)) {

			$where = " created>='" . $starttime . "' and created<='" . $endtime . "' and status=5";
			$sql1 = "select ordernum from franchisee_order where $where";
			$sql2 = "select goodsid from franchisee_orderinfo where ordernum in($sql1)";
			$page = !empty($_GET['page']) ? $_GET['page'] : 1;
			$size = isset($_GET['pagenum']) ? $_GET['pagenum'] : 10;
			$offset = ($page - 1) * $size;

			$sql = "select count(*) from product_goods  where 1=1  and id in($sql2)";
			$count = $this->product->goodsModel->fetchRow($sql);
			$count = $count["count(*)"];
			$number = ceil($count / $size);
			$extend = new pager();
			$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
			$sql = "select product_goods.*,fc.title as fctitle from product_goods left join product_goodscategory as fc on fc.uuid=product_goods.categoryuuid  where product_goods.id in($sql2)  limit " . $offset . "," . $size . "";
			//echo $sql;exit;
			//var_dump($sql); exit;

			$re = $this->product->goodsModel->fetchAll($sql);
			foreach ($re as $k => $val) {
				$sql = "select sum(num) as number from franchisee_orderinfo where goodsid=" . $val['id'] . " and ordernum in($sql1)";
				$gnum = $this->product->goodsModel->fetchRow($sql);
				if ($gnum) {
					$re[$k]['salenum'] = $gnum['number'];
				} else {
					$re[$k]['salenum'] = 0;
				}
			}
		} else {

		}

		include $this->loadWidget('amdinlteTheme');
	}
}
?>