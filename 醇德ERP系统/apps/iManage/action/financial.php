<?php
/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */
class financial extends actionAbstract {

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
		// $this->info = acl::checkLogin('admininfo',$this->url('common/login'));
		if (!isset($_SESSION['admininfo'])) {header('location:' . $this->url('common/login'));}$this->info = $_SESSION['admininfo'];
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			//ajax request
			$this->checkpower();
		}
	}

	/**
	 * 入库设置列表
	 */
	public function paytype() {
		$this->leftpos = 4;
		$this->loadModel('financial', 'paytype');
		$sql = "select * from financial_paytype where type=1 ";
		$re = $this->financial->paytypeModel->fetchAll($sql);
		//include $this->loadWidget('amdinlteTheme');
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 添中入库设置
	 */
	public function addpaytype() {
		$this->leftpos = 4;
		$this->loadModel('financial', 'paytype');
		include $this->loadWidget('amdinlteTheme');

	}
	/**
	 * 插入入库设置
	 */
	public function insertpaytype() {
		$this->loadModel('financial', 'paytype');
		$this->loadHelper('extend');
		//$id=$_POST['id'];
		$data = $_POST['data'];
		$data['type'] = 1;
		$re = $this->financial->paytypeModel->insert($data);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/**
	 * 编辑入库设置
	 */
	public function editpaytype() {
		$this->leftpos = 4;
		$this->loadModel('financial', 'paytype');
		$id = $_GET['id'];
		$sql = "select * from financial_paytype where id=$id";
		$re = $this->financial->paytypeModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 保存入库设置
	 */
	public function updatepaytype() {
		$this->loadModel('financial', 'paytype');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$data = $_POST['data'];
		$re = $this->financial->paytypeModel->update($data, 'id=' . $id);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/*
	 * 删除入库设置
	 */
	public function delpaytype() {

		$this->loadHelper('extend');
		$id = $_GET['id'];
		$this->loadModel('financial', 'paytype');
		$re = $this->financial->paytypeModel->delete($id);
		if ($re) {
			ajaxReturn('back', '删除成功', 1);exit;
		} else {
			ajaxReturn('back', '删除失败', 0);exit;
		}
	}

	/**
	 * 出库设置列表
	 */
	public function paytypeout() {
		$this->leftpos = 5;
		$this->loadModel('financial', 'paytype');
		$sql = "select * from financial_paytype where type=0 ";
		$re = $this->financial->paytypeModel->fetchAll($sql);
		//include $this->loadWidget('amdinlteTheme');
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 添中出库设置
	 */
	public function addpaytypeout() {
		$this->leftpos = 5;
		$this->loadModel('financial', 'paytype');
		include $this->loadWidget('amdinlteTheme');

	}
	/**
	 * 插入出库设置
	 */
	public function insertpaytypeout() {
		$this->loadModel('financial', 'paytype');
		$this->loadHelper('extend');
		//$id=$_POST['id'];
		$data = $_POST['data'];
		$data['type'] = 0;
		$re = $this->financial->paytypeModel->insert($data);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/**
	 * 编辑出库设置
	 */
	public function editpaytypeout() {
		$this->leftpos = 5;
		$this->loadModel('financial', 'paytype');
		$id = $_GET['id'];
		$sql = "select * from financial_paytype where id=$id";
		$re = $this->financial->paytypeModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 保存出库设置
	 */
	public function updatepaytypeout() {
		$this->loadModel('financial', 'paytype');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$data = $_POST['data'];
		$re = $this->financial->paytypeModel->update($data, 'id=' . $id);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/*
	 * 删除出库设置
	 */
	public function delpaytypeout() {

		$this->loadHelper('extend');
		$id = $_GET['id'];
		$this->loadModel('financial', 'paytype');
		$re = $this->financial->paytypeModel->delete($id);
		if ($re) {
			ajaxReturn('back', '删除成功', 1);exit;
		} else {
			ajaxReturn('back', '删除失败', 0);exit;
		}
	}

}
?>