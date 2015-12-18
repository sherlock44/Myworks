<?php
/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */
class messageremind extends actionAbstract {

	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 1;
	public $type = 0;
	public $leftpos = 0;

	/**
	 * 递归要操作的菜单PIN
	 *
	 * @var array
	 */
	protected $add_auth = array();

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
	//类型列表
	public function messagelist() {
		include $this->loadWidget('amdinlteTheme');
		//include $this->loadWidget('amdinlteTheme');
	}
	//所选用户列表 product_messageremind
	public function userlist() {
		$this->loadModel("product", "messageremind");
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : 'caigou';
		$confarr = $this->loadConfig('sysconf');
		$title = "采购设置";
		$conf = $confarr['purchasestatus'];
		if ($keyword == 'dinghuo') {
			$title = "加盟商订货设置";
			$conf = $confarr['orderstatus'];
		} else if ($keyword == 'tuihuo') {
			$title = "加盟商退货设置";
			$conf = $confarr['orderbackstatus'];
		}
		$sql = "select pm.orderstatus,sa.* from product_messageremind as pm left join system_admin as sa on sa.id=pm.userid  where pm.keyword='" . $keyword . "'";

		$re = $this->product->messageremindModel->fetchAll($sql);
		//查询哪些是选中了的
		$sql = "select * from product_messageremind where ";
		//include $this->loadWidget('amdinlteTheme');
		include $this->loadWidget('amdinlteTheme');
	}
	//选择修改发送用户列表
	public function edituser() {
		$this->loadModel("product", "messageremind");
		if ($_POST) {
			$this->loadHelper('extend');
			//$data	=	$_POST['data'];
			$userid = isset($_POST['userid']) ? $_POST['userid'] : '';
			$keyword = $_POST['keyword'];
			$orderstatus = $_POST['orderstatus'];
			$this->product->messageremindModel->delete("keyword='" . $keyword . "' and orderstatus=" . $orderstatus);
			if (empty($userid)) {
				//全部删除
				
				ajaxReturn('', '操作成功', 1);exit;
			}
			
			//$this->product->messageremindModel->delete("keyword='" . $keyword . "' and orderstatus=" . $orderstatus);
			$data['keyword'] = $keyword;
			$data['orderstatus'] = $orderstatus;
			foreach ($userid as $val) {
				$data['userid'] = $val;
				$this->product->messageremindModel->insert($data);
			}
			ajaxReturn('', '操作成功', 1);exit;
			exit;
		}

		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : 'caigou';
		$confarr = $this->loadConfig('sysconf');
		$title = "采购设置";
		$conf = $confarr['purchasestatusemail'];
		if ($keyword == 'dinghuo') {
			$title = "加盟商订货设置";
			$conf = $confarr['orderstatusemail'];
		} else if ($keyword == 'tuihuo') {
			$title = "加盟商退货设置";
			$conf = $confarr['orderbackstatusemail'];
		}
		$re = array();
		if (isset($_GET['orderstatus'])) {
			
			$sql = "select * from system_admin where status=1";
			$re = $this->product->messageremindModel->fetchAll($sql);
			$sql = "select * from product_messageremind where keyword='" . $keyword . "' and orderstatus=" . $_GET['orderstatus'];

			$hasuser = $this->product->messageremindModel->fetchAll($sql);
			$hasuserid = array();
			foreach ($hasuser as $v) {
				$hasuserid[] = $v['userid'];
			}
		}

		include $this->loadWidget('amdinlteTheme');

	}

}
?>