<?php

/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */

class order extends actionAbstract {
	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 5;
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
		$this->info = acl::checkLogin('accessinfo', $this->url('common/login'));
		// if(!isset($_SESSION['accessinfo'])){ header('location:'.$this->url('common/login'));}
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
	}

	//网络订单 source=0 网络订单
	public function orderline() {
		$this->loadModel('franchisee', 'userorder');
		$this->loadHelper('extend');
		$this->loadHelper("pager");

		$posapiconfig = $this->loadConfig("posapiconfig");
		$rs = $posapiconfig['sportOrderStatus'];
		$this->where = " where ordertype = 0 ";

		$userphone = null;

		if (isset($_GET['status']) && $_GET['status'] != '') {
			$this->where .= " and orderstatus =" . $_GET['status'] . "";
		}

		if (!empty($_GET['userphone'])) {
			$this->where .= " and ordernum like  '%" . $_GET['userphone'] . "%' or username like '%" . $_GET['userphone'] . "%'";
			$userphone = $_GET['userphone'];
		}
		if (!empty($_GET['timesel'])) {
			/*  $configset=$posapiconfig['state'];
		$seltimename=isset($configset[$_GET['timesel']])?$configset[$_GET['timesel']]:'';

		$timesel=$_GET['timesel'];
		$now=time();
		if ($timesel==1) {
		$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
		$this->where .=" and created >=$beginThismonth and created <=$endThismonth" ;
		}
		else if ($timesel==2) {
		$time = strtotime('-2 month', $now);
		$beginmonth = mktime(0, 0,0, date('m', $time), 1, date('Y', $time));
		$endmonth=  mktime(0, 0, 0, date('m', $now), date('t', $now), date('Y', $now));
		$this->where .=" and created >=$beginmonth and created <=$endmonth" ;
		}
		else if ($timesel==3) {
		$beginThismonth=mktime(0, 0,0, 1, 1, date('Y',$now));
		$endThismonth=mktime(0, 0, 0, 12, 31, date('Y',$now));
		$this->where .=" and created >=$beginThismonth and created <=$endThismonth" ;

		}
		else if ($timesel==5) {
		$beginLastweek=mktime(0,0,0,date('m'),date('d')-date('w')+1) ;
		$endLastweek=mktime(23,59,59,date('m'),date('d')-date('w')+7);
		$this->where .=" and created >=$beginLastweek and created <=$endLastweek" ;
		}
		else if($timesel){
		$data= explode("@",$timesel);
		$datebegintime = strtotime($data[0]);
		$dateendtime= strtotime($data[1]);
		$this->where .=" and created >=$datebegintime and created <=$dateendtime" ;
		$seltimename=     $data[0]."至".$data[1];
		} */

		}

		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = 10;
		$offset = ($page - 1) * $size;
		$sql = "select count(*) from franchisee_userorder " . $this->where . "";
		$count = $this->franchisee->userorderModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select * from franchisee_userorder " . $this->where . " limit " . $offset . "," . $size . "";

		$re = $this->franchisee->userorderModel->fetchAll($sql);

		include $this->loadWidget('franchiseeTheme');
	}
	//订单详情
	public function onlineinfo() {
		$this->loadModel('franchisee', 'userorder');

		$uuid = $_GET['uuid'];
		$this->leftpos = 0;
		$this->loadModel('shop', 'ordersinfo');

		$configset = $this->loadConfig("posapiconfig");
		$rs = $configset['bookingOrderStatus'];
		$rss = $configset['sportOrderStatus'];
		//订单信息
		$sql = "select * from franchisee_userorder where uuid='" . $uuid . "'";
		$result = $this->franchisee->userorderModel->fetchRow($sql);
		//商品信息
		$sql = "select so.*,sg.title,sg.imgpath from franchisee_userorderinfo as so left join product_goods as sg on so.productuuid=sg.uuid where so.userorderuuid='" . $order['uuid'] . "'";
		$shops = $this->franchisee->userorderModel->fetchAll($sql);

		include $this->loadWidget('franchiseeTheme');

	}
	//本地订单
	public function orderlist() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'userorder');
		$this->loadHelper('extend');
		$this->loadHelper("pager");

		$posapiconfig = $this->loadConfig("posapiconfig");
		$rs = $posapiconfig['sportOrderStatus'];
		$this->where = " where ordertype = 1 ";

		$userphone = null;

		if (isset($_GET['status']) && $_GET['status'] != '') {
			$this->where .= " and orderstatus =" . $_GET['status'] . "";
		}

		if (!empty($_GET['userphone'])) {
			$this->where .= " and ordernum like  '%" . $_GET['userphone'] . "%' or username like '%" . $_GET['userphone'] . "%'";
			$userphone = $_GET['userphone'];
		}
		if (!empty($_GET['timesel'])) {
			/*  $configset=$posapiconfig['state'];
		$seltimename=isset($configset[$_GET['timesel']])?$configset[$_GET['timesel']]:'';

		$timesel=$_GET['timesel'];
		$now=time();
		if ($timesel==1) {
		$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
		$this->where .=" and created >=$beginThismonth and created <=$endThismonth" ;
		}
		else if ($timesel==2) {
		$time = strtotime('-2 month', $now);
		$beginmonth = mktime(0, 0,0, date('m', $time), 1, date('Y', $time));
		$endmonth=  mktime(0, 0, 0, date('m', $now), date('t', $now), date('Y', $now));
		$this->where .=" and created >=$beginmonth and created <=$endmonth" ;
		}
		else if ($timesel==3) {
		$beginThismonth=mktime(0, 0,0, 1, 1, date('Y',$now));
		$endThismonth=mktime(0, 0, 0, 12, 31, date('Y',$now));
		$this->where .=" and created >=$beginThismonth and created <=$endThismonth" ;

		}
		else if ($timesel==5) {
		$beginLastweek=mktime(0,0,0,date('m'),date('d')-date('w')+1) ;
		$endLastweek=mktime(23,59,59,date('m'),date('d')-date('w')+7);
		$this->where .=" and created >=$beginLastweek and created <=$endLastweek" ;
		}
		else if($timesel){
		$data= explode("@",$timesel);
		$datebegintime = strtotime($data[0]);
		$dateendtime= strtotime($data[1]);
		$this->where .=" and created >=$datebegintime and created <=$dateendtime" ;
		$seltimename=     $data[0]."至".$data[1];
		} */

		}

		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = 10;
		$offset = ($page - 1) * $size;
		$sql = "select count(*) from franchisee_userorder " . $this->where . "";
		$count = $this->franchisee->userorderModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select * from franchisee_userorder " . $this->where . " limit " . $offset . "," . $size . "";

		$re = $this->franchisee->userorderModel->fetchAll($sql);

		include $this->loadWidget('franchiseeTheme');

	}
	//本地订单详情
	public function info() {
		$this->loadModel('franchisee', 'userorder');
		$uuid = $_GET['uuid'];
		$sql = "select * from franchisee_userorder where uuid='" . $uuid . "'";
		$result = $this->franchisee->userorderModel->fetchRow($sql);
		include $this->loadWidget('franchiseeTheme');

	}

}
?>