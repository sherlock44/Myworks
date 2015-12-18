

<?php

class log extends actionAbstract {
	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 9;
	public $type = 0;
	public $leftpos = 0;
	public $like = "";
	public $where = "";

	public $host; //数据库地址
	public $user; //登录名
	public $pwd; //密码
	public $database; //数据库名
	public $charset = 'utf8'; //数据库连接编码：mysql_set_charset
	/*
	 * 构造
	 */
	function __construct() {
		parent::__construct();
		//$this->info = acl::checkLogin('admininfo',$this->url('common/login'));
		if (!isset($_SESSION['admininfo'])) {header('location:' . $this->url('common/login'));}$this->info = $_SESSION['admininfo'];
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		GLOBAL $configs;
		$this->host = $configs['database']['data']['Host'];
		$this->user = $configs['database']['data']['User'];
		$this->pwd = $configs['database']['data']['Password'];
		$this->database = $configs['database']['data']['Name'];
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			//ajax request
			$this->checkpower();
		}
	}
	//订货操作日志
	public function purchaseorder() {
		$this->pos = 5;
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = isset($_GET['pagenum']) ? $_GET['pagenum'] : 10;
		$offset = ($page - 1) * $size;
		$where = " foa.type=0 ";
		$ordernum = '';
		if (isset($_GET['ordernum']) && !empty($_GET['ordernum'])) {
			$ordernum = trim($_GET['ordernum']);
			$where .= " and fo.ordernum='" . $ordernum . "' ";
		}
		$sql = "select count(*) from franchisee_orderdata as foa left join franchisee_order as fo on fo.id=foa.orderid where " . $where;
		$count = $this->franchisee->orderdataModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select foa.*,fo.ordernum from franchisee_orderdata as foa  left join franchisee_order as fo on fo.id=foa.orderid where " . $where . " order by foa.id desc limit " . $offset . "," . $size . "";
		$re = $this->franchisee->orderdataModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//退货日志 backorder
	public function backorder() {
		$this->pos = 5;
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = isset($_GET['pagenum']) ? $_GET['pagenum'] : 10;
		$offset = ($page - 1) * $size;
		$where = " foa.type=1 ";
		$ordernum = '';
		if (isset($_GET['ordernum']) && !empty($_GET['ordernum'])) {
			$ordernum = trim($_GET['ordernum']);
			$where .= " and fo.ordernum='" . $ordernum . "' ";
		}
		$sql = "select count(*) from franchisee_orderdata as foa left join franchisee_order as fo on fo.id=foa.orderid where " . $where;
		$count = $this->franchisee->orderdataModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select foa.*,fo.ordernum from franchisee_orderdata as foa  left join franchisee_order as fo on fo.id=foa.orderid where " . $where . " order by foa.id desc limit " . $offset . "," . $size . "";
		$re = $this->franchisee->orderdataModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//充值记录
	public function recharge() {
		$this->leftpos = 0;
		$this->loadModel('system', 'log');
		$re = $this->system->logModel->fetchAll("select * from system_log where type=2 order by created desc");
		include $this->loadWidget('amdinlteTheme');
	}

	//支付记录
	public function pay() {
		$this->leftpos = 1;
		$this->loadModel('system', 'log');
		$re = $this->system->logModel->fetchAll("select * from system_log where type=1 order by created desc");
		include $this->loadWidget('amdinlteTheme');
	}

	//用户删除订单记录
	public function delOrder() {
		$this->leftpos = 2;
		$this->loadModel('system', 'log');
		$this->loadModel('orders', 'summary');
		$re = $this->system->logModel->fetchAll("select * from system_log where status=9 order by created desc");
		include $this->loadWidget('amdinlteTheme');
	}

	//入库记录
	public function ruku() {
		$this->leftpos = 4;
		$this->pos = 8;
		$this->loadModel('product', 'transfer');
		$sql = "select pt.* , pg.title,sa.name,ph1.title as yknm,ph2.title as mbknm,phs1.title as ywnm,
                phs2.title as mbwnm
                from product_transfer as pt
                join product_goods as pg on pg.id = pt.goodsid
                join system_admin  as sa on sa.id = pt.userid
                join product_house as ph1  on ph1.id   = pt.fromku
                join product_house as ph2  on ph2.id   = pt.toku
                join product_housepos as phs1 on phs1.id  = pt.fromwei
                join product_housepos as phs2 on phs2.id  = pt.towei
                where pt.state = 2 and pt.rksta=1";
		$re = $this->product->transferModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//删除入库记录
	public function delerk() {
		$this->loadHelper('extend');
		$this->loadModel('product', 'transfer');
		if ($_GET) {
			$id = $_GET['id'];
			$data['rksta'] = 2;
			$re = $this->product->transferModel->update($data, $id);
			if ($re) {
				ajaxReturn('back', '删除成功', 1);exit;
			} else {
				ajaxReturn('', '删除失败', 0);exit;
			}
		}
	}
	//出库记录
	public function chuku() {
		$this->leftpos = 5;
		$this->loadModel('product', 'transfer');
		$sql = "select pt.* , pg.title,sa.name,ph1.title as yknm,ph2.title as mbknm,phs1.title as ywnm,
                phs2.title as mbwnm
                from product_transfer as pt
                join product_goods as pg on pg.id = pt.goodsid
                join system_admin  as sa on sa.id = pt.userid
                join product_house as ph1  on ph1.id   = pt.fromku
                join product_house as ph2  on ph2.id   = pt.toku
                join product_housepos as phs1 on phs1.id  = pt.fromwei
                join product_housepos as phs2 on phs2.id  = pt.towei
                where pt.state = 2 and pt.cksta=1";
		$re = $this->product->transferModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//删除出库记录
	public function deleck() {
		$this->loadHelper('extend');
		$this->loadModel('product', 'transfer');
		if ($_GET) {
			$id = $_GET['id'];
			$data['cksta'] = 2;
			$re = $this->product->transferModel->update($data, $id);
			if ($re) {
				ajaxReturn('back', '删除成功', 1);exit;
			} else {
				ajaxReturn('', '删除失败', 0);exit;
			}
		}
	}

	//系统日志目录
	public function sysLog() {
		$this->pos = 0;
		$this->loadModel('system', 'log');
		$this->loadHelper('extend');
		$sql = "select sl.*,sa.name from system_log as sl
              join system_admin as sa on sa.id = sl.userid ";
		$re = $this->system->logModel->fetchAll($sql);
		//include $this->loadWidget('amdinlteTheme');
		include $this->loadWidget('amdinlteTheme');
	}
	//删除系统日志
	public function delelog() {
		$this->loadHelper('extend');
		$this->loadModel('system', 'log');
		if ($_GET) {
			$id = $_GET['id'];
			$re = $this->system->logModel->delete($id);
			if ($re) {
				ajaxReturn('', '删除成功', 1);exit;
			} else {
				ajaxReturn('', '删除失败', 0);exit;
			}
		}
	}
	//数据备份
	public function sysBack() {
		if ($_POST) {
			$this->loadHelper('extend');
			$con = mysqli_connect($this->host, $this->user, $this->pwd, $this->database);
			//@mysql_set_charset("utf8");
			$sql = $this->sqlcreate();
			$sql2 = $this->sqlinsert();
			$data = $sql . $sql2;
			$name = $_POST['filename'];
			$filename = "data/" . $name . ".sql";
			//var_dump($data);
			//$encode = mb_detect_encoding($data);
			$re = file_put_contents($filename, $data);
			if ($re) {
				ajaxReturn('back', '备份成功(根目录的data目录下)', 1);exit;
			} else {
				ajaxReturn('back', '备份失败', 1);exit;
			}
		} else {
			$this->leftpos = 1;
			$this->pos = 0;
			include $this->loadWidget('amdinlteTheme');
		}
	}
	//获取表数据
	public function tblist() {
		$list = array();
		$con = mysqli_connect($this->host, $this->user, $this->pwd, $this->database);
		//@mysql_set_charset("utf8");
		$rs = mysqli_query($con, "SHOW TABLES FROM $this->database");
		while ($temp = mysqli_fetch_row($rs)) {
			$list[] = $temp[0];
		}
		return $list;
	}

	public function sqlcreate() {
		$sql = '';
		$tb = $this->tblist();
		$con = mysqli_connect($this->host, $this->user, $this->pwd, $this->database);
		//@mysql_set_charset("utf8");
		foreach ($tb as $v) {
			$rs = mysqli_query($con, "SHOW CREATE TABLE $v");
			$temp = mysqli_fetch_row($rs);
			$sql .= "-- 表的结构：{$temp[0]} --\r\n";
			$sql .= "{$temp[1]}";
			$sql .= ";-- <xjx> --\r\n\r\n";
		}
		return $sql;
	}

	function sqlinsert() {
		$sql = '';
		$con = mysqli_connect($this->host, $this->user, $this->pwd, $this->database);
		//@mysql_set_charset("utf8");
		$tb = $this->tblist();
		foreach ($tb as $v) {
			$rs = mysqli_query($con, "SELECT * FROM $v");
			if (!mysqli_num_rows($rs)) {
//无数据返回
				continue;
			}
			$sql .= "-- 表的数据：$v --\r\n";
			$sql .= "INSERT INTO `$v` VALUES\r\n";
			while ($temp = mysqli_fetch_row($rs)) {
				$sql .= '(';
				foreach ($temp as $v2) {
					if ($v2 === null) {
						$sql .= "NULL,";
					} else {
						$v2 = @mysql_real_escape_string($v2);
						$sql .= "'$v2',";
					}
				}
				$sql = mb_substr($sql, 0, -1);
				$sql .= "),\r\n";
			}
			$sql = mb_substr($sql, 0, -3);
			$sql .= ";-- <xjx> --\r\n\r\n";
		}
		return $sql;
	}
	//银行账户管理
	public function payment() {
		if ($_POST) {
			$this->loadHelper('extend');
			$this->loadModel('system', 'bank');
			$data = $_POST['data'];
			$data['uptime'] = time();
			$bkid = $this->system->bankModel->update($data, 1);
			if ($bkid) {
				ajaxReturn('', '修改成功', 1);exit;
			} else {
				ajaxReturn('', '修改失败', 0);exit;
			}
		} else {
			$this->loadModel('system', 'bank');
			$sql = "select * from system_bank where id =  1";
			$one = $this->system->bankModel->fetchRow($sql);
			include $this->loadWidget('amdinlteTheme');
		}
	}
}