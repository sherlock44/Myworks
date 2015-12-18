<?php
/*
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */
class common extends actionAbstract {

	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 0;
	public $type = 0;
	public $leftpos = 0;

	/*
	 * 构造
	 */
	function __construct() {
		parent::__construct();
		//$this->info = acl::checkLogin('admininfo',$this->url('common/login'));

	}

	/*
	 * 登录页面
	 */
	public function login() {
		//print_r($_SESSION);
		if (isset($_SESSION['admininfo'])) {
			unset($_SESSION['admininfo']);}
		if (isset($_SESSION['menudata'])) {
			unset($_SESSION['menudata']);
		}

		if (isset($_SESSION['access_user_list'])) {
			unset($_SESSION['access_user_list']);
		}

		$this->leftpos = 0;
		include $this->loadView();
	}

	/*
	 * 验证登录信息
	 */
	public function checkLogin() {
		if ($_POST) {
			$this->loadHelper('extend');
			$this->loadHelper('log');
			if (!$_POST['name']) {
				exit(json_encode(array('state' => 0, 'info' => '请输入用户名')));
			}
			if (!$_POST['password']) {
				exit(json_encode(array('state' => 0, 'info' => '请输入密码')));
			}
			if (!$_POST['verify']) {
				exit(json_encode(array('state' => 0, 'info' => '请输入验证码')));
			}
			// 判断验证码
			if (!($_POST['verify'] == $_SESSION['verifycode_content'])) {
				exit(json_encode(array('state' => 0, 'info' => '验证码错误')));
			}
			// 判断用户名密码
			else {
				$this->loadModel('system', 'admin');
				$password = md5($_POST['password']);
				$sql = "select * from system_admin where name='" . $_POST['name'] . "' and password='" . $password . "'";

				$re = $this->system->adminModel->fetchRow($sql);
				if (!$re) {
					exit(json_encode(array('state' => 0, 'info' => '用户名或密码错误')));
				} else {
					if($re['status']!=1){
					exit(json_encode(array('state' => 0, 'info' => '账户已冻结')));
					}
					//获取登陆ip，保存到数据库
					//$time=new date();
					/*$re['ip']=$_SERVER["REMOTE_ADDR"];
					$ip=$re['ip'];
					$result=$this->ic->accountModel->update($re,"ip='{$ip}'");*/
					//存储cookie
					$sql = "select sa.*,sg.title from system_admin as sa left join system_group as sg on sg.groupid=sa.groupid where sa.id = {$re['id']}";
					$re = $this->system->adminModel->fetchRow($sql);
					acl::setCookie("admininfo", $re);
					$logdata['title'] = '登录';
					$logdata['userid'] = $re['id'];
					$logdata['content'] = '用户登录系统';
					$log = new log();
					$log->logwrite($logdata);
					$_SESSION['admininfo'] = $re;
					$sql = "select menupin from system_group_menu where groupid=" . $re['groupid'];
					$sqls = "select * from system_menu where pin in(" . $sql . ")  order by parentid asc";

					$result = $this->system->adminModel->fetchRow($sqls);

					if (!$result || empty($result['module'])) {
						exit(json_encode(array('state' => 0, 'info' => '没有权限')));
					} else {
						$cnf = $this->loadConfig('sysconf');
						$header = $cnf['rolemainmenu'];
						$_SESSION['indexmain'] = '';
						if (isset($header[$re['groupid']])) {

							$url = $this->url("index/" . $header[$re['groupid']] . "");
							$_SESSION['indexmain'] = $url;
						} else {
							$url = $this->url("index/user");
						}
						exit(json_encode(array('state' => 1, 'info' => '登录成功', 'url' => $url)));
					}
					/* $url=$this->url('index/main');
					exit(json_encode(array('state' => 1, 'info' =>  '登录成功','url'=>$url))); */
					//ajaxReturn ($this->url('system/website'),'登录成功', 1 );exit;
				}
			}
		}
	}
	/**
	 * @desc 安全退出
	 */
	public function logout() {
		//   $this->info = acl::checkLogin('admininfo',$this->url('common/login'));
		$this->loadHelper('extend');
		$this->loadHelper('log');
		$se = $_SESSION['admininfo'];
		$logdata['title'] = '系统退出';
		$logdata['userid'] = $se['id'];
		$logdata['content'] = '用户退出登录';
		$log = new log();
		$log->logwrite($logdata);
		//  setcookie("admininfo", "", time() - 3600,'/');
		unset($_SESSION['admininfo']);
		if (isset($_SESSION['menudata'])) {
			unset($_SESSION['menudata']);
		}

		if (isset($_SESSION['access_user_list'])) {
			unset($_SESSION['access_user_list']);
		}

		$url = "http://" . ROOT_URL . "/index.php/franchisee/common/login";
		$r = array('info' => "操作成功", 'data' => 'url', 'state' => 1, 'url' => $url);
		echo json_encode($r);exit;
		ajaxReturn('', '退出成功', 1);exit;
	}

	/**
	 * @desc 验证码
	 */
	function yzmCode() {
		$this->loadHelper("verifyCode");
		$code = new verifyCode(50, 26);
		echo $code;
	}

	function delc() {
		$this->loadHelper('js');
		$js = new js();
		acl::setCookie("admininfo", "");
		header("location:/index.php/sysadmin/index");
	}
	public function register() {
		include $this->loadView();
	}
	/*
	 * 验证注册信息
	 */
	public function doregister() {
		if ($_POST) {

			$this->loadHelper('extend');
			if (!$_POST['username']) {
				exit(json_encode(array('state' => 0, 'info' => '请输入用户名')));
			}
			if (!$_POST['password']) {
				exit(json_encode(array('state' => 0, 'info' => '请输入密码')));
			}
			if (!$_POST['pwdconfirm'] || $_POST['password'] != $_POST['pwdconfirm']) {
				exit(json_encode(array('state' => 0, 'info' => '两次输入的密码不一致')));
			}
			if (!$_POST['verify']) {
				exit(json_encode(array('state' => 0, 'info' => '请输入验证码')));
			}
			// 判断验证码
			if (!($_POST['verify'] == $_SESSION['verifycode_content'])) {
				exit(json_encode(array('state' => 0, 'info' => '验证码错误')));
			}
			// 判断用户名密码
			else {
				$this->loadModel('system', 'admin');
				$password = md5($_POST['password']);
				$sql = "select * from system_admin where name='" . $_POST['username'] . "'";
				$re = $this->system->adminModel->fetchRow($sql);
				if ($re) {
					$url = $this->url('system/register');
					exit(json_encode(array('state' => 0, 'info' => '已经存在相同的用户名', 'url' => $url)));
				} else {
					$sql = "insert into system_admin(name,password,lasttime,status,created,groupid) values('" . $_POST['username'] . "','" . $password . "',"
					. time() . ",1," . time() . ",0)";
					$re = $this->system->adminModel->fetchRow($sql);
					$url = $this->url('system/login');
					exit(json_encode(array('state' => 1, 'info' => '注册成功', 'url' => $url)));
				}

			}
		}
	}

	public function printorder() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		$this->loadModel('product', 'goods');
		$ordernum = $_GET['ordernum'];
		$sql = "select fo.weights,fo.allprice,fo.realbacknum,foe.ordernum,foe.productontime,foe.num as buynum,fo.id,fo.tag,fo.price as buyprice,pg.beoverdue,pg.shelflife,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number from franchisee_orderinfoprepare as foe left join franchisee_orderinfo as fo on fo.id=foe.orderinfoid left join product_goods as pg on foe.goodsid=pg.id where foe.ordernum='" . $ordernum . "'";
		$sql = "select fo.weights,fo.allprice,foe.ordernum,foe.productontime,foe.num as buynum,foe.realbacknum,fo.id,fo.tag,fo.price as buyprice,pg.beoverdue,pg.shelflife,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfoprepare as foe left join franchisee_orderinfo as fo on fo.id=foe.orderinfoid left join product_goods as pg on foe.goodsid=pg.id where foe.ordernum='" . $ordernum . "'";
		$re = $this->franchisee->orderModel->fetchAll($sql);

		//订单信息
		$sql = "select fo.created,fo.remark,fo.freeordernum,fo.id,fo.status,fo.token,fo.orderbackstatus,fo.backstatus,ws.title as wstitle,fo.created,fo.remark from franchisee_order as fo left join wms_setting as ws on ws.id=fo.storetypeid  where fo.ordernum='" . $ordernum . "'";
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
		include $this->loadWidget('printerTheme');
	}
	//库房打印
	public function printorderkf() {
		$this->leftpos = 2;
		$this->pos = 5;
		$this->loadModel('franchisee', 'order');
		$this->loadModel('product', 'goods');
		$ordernum = $_GET['ordernum'];
		$sql = "select fo.weights,fo.allprice,fo.realbacknum,foe.ordernum,foe.productontime,foe.num as buynum,fo.id,fo.tag,fo.price as buyprice,pg.beoverdue,pg.shelflife,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number from franchisee_orderinfoprepare as foe left join franchisee_orderinfo as fo on fo.id=foe.orderinfoid left join product_goods as pg on foe.goodsid=pg.id where foe.ordernum='" . $ordernum . "'";
		$sql = "select fo.weights,fo.allprice,foe.ordernum,foe.productontime,foe.num as buynum,foe.realbacknum,fo.id,fo.tag,fo.price as buyprice,pg.beoverdue,pg.shelflife,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfoprepare as foe left join franchisee_orderinfo as fo on fo.id=foe.orderinfoid left join product_goods as pg on foe.goodsid=pg.id where foe.ordernum='" . $ordernum . "'";
		$re = $this->franchisee->orderModel->fetchAll($sql);

		//订单信息
		$sql = "select fo.created,fo.remark,fo.freeordernum,fo.id,fo.status,fo.token,fo.orderbackstatus,fo.backstatus,ws.title as wstitle,fo.created,fo.remark from franchisee_order as fo left join wms_setting as ws on ws.id=fo.storetypeid  where fo.ordernum='" . $ordernum . "'";
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

		//加载操作记录
		$sql = "select truename,results,from_unixtime(created) as created from franchisee_orderdata where orderid=" . $order['id'] . "  and type=0  order by created desc";
		$log = $this->franchisee->orderModel->fetchAll($sql);
		//按时间重新组合日志  --开始
		// $logs = array();
		// foreach ($log as $k => $val) {
		// 	$logs[date("Y-m-d", $val['created'])][] = $val;
		// }
		include $this->loadWidget('printerTheme');
	}
//加盟商信息
	public function getAllianceInfo($token) {
		$this->loadModel('franchisee', 'alliance');

		$sql = "select arr.name as cname,ar.name as pname,franchisee_alliance.*,crm_usertype.title as supplytype from franchisee_alliance left join crm_usertype on crm_usertype.id=franchisee_alliance.supplytypeid left join area_region as ar on ar.id=franchisee_alliance.proviceid left join area_region as arr on arr.id=franchisee_alliance.cityid where franchisee_alliance.token='" . $token . "'";
		return $this->franchisee->allianceModel->fetchRow($sql);

	}
	/**
	 *错误提示
	 **/
	function alert() {
		$msg = $_GET['msg'];
		$sleep = $_GET['sleep'];
		$state = 0;
		include $this->loadView();
	}
}
?>