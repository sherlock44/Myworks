<?php
/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */
class setting extends actionAbstract {

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
		$this->info = acl::checkLogin('accessinfo', $this->url('common/login'));
		//     if(!isset($_SESSION['accessinfo'])){ header('location:'.$this->url('common/login'));}
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
	}

	/**
	 * 会员卡类型设置
	 */
	public function usercardtype() {
		$this->leftpos = 0;
		$posapiconf = $this->loadConfig("posapiconfig");
		$cardtype = $posapiconf['cardType'];

		$this->loadHelper('extend');
		$this->loadModel('franchisee', 'carddiscount');
		$arr = array();
		foreach ($cardtype as $k => $v) {
			$k = $k + 1;
			$sql = "select * from franchisee_carddiscount where cardid={$k}";
			$re = $this->franchisee->carddiscountModel->fetchRow($sql);
			$arr[$k - 1] = $re;
		}
		include $this->loadWidget('franchiseeTheme');
	}

	/**
	 * 出库设置列表
	 */
	public function storageout() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'cardtype');
		$sql = "select * from franchisee_cardtype where type=0 ";
		$re = $this->franchisee->cardtypeModel->fetchAll($sql);
		include $this->loadWidget('franchiseeTheme');
	}
	/**
	 * 添中出库设置
	 */
	public function addstorageout() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'cardtype');
		include $this->loadWidget('franchiseeTheme');

	}
	/**
	 * 插入出库设置
	 */
	public function insertstorageout() {
		$this->loadModel('franchisee', 'cardtype');
		$this->loadHelper('extend');
		//$id=$_POST['id'];
		$data = $_POST['data'];
		$data['type'] = 0;
		$re = $this->franchisee->cardtypeModel->insert($data);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/**
	 * 编辑出库设置
	 */
	public function editstorageout() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'cardtype');
		$id = $_GET['id'];
		$sql = "select * from franchisee_cardtype where id=$id";
		$re = $this->franchisee->cardtypeModel->fetchRow($sql);
		include $this->loadWidget('franchiseeTheme');
	}
	/**
	 * 保存出库设置
	 */
	public function updatestorageout() {
		$this->loadModel('franchisee', 'cardtype');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$data = $_POST['data'];
		$re = $this->franchisee->cardtypeModel->update($data, 'id=' . $id);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/*
	 * 删除出库设置
	 */
	public function delstorageout() {

		$this->loadHelper('extend');
		$id = $_GET['id'];
		$this->loadModel('franchisee', 'cardtype');
		$re = $this->franchisee->cardtypeModel->delete($id);
		if ($re) {
			ajaxReturn('back', '删除成功', 1);exit;
		} else {
			ajaxReturn('back', '删除失败', 0);exit;
		}
	}

	/**
	 * 入库类型设置列表
	 */
	public function storagetype() {
		$this->leftpos = 2;
		$this->loadModel('franchisee', 'typesetting');
		$sql = "select * from wms_typesetting where type=1 ";
		$re = $this->wms->typesettingModel->fetchAll($sql);
		include $this->loadWidget('franchiseeTheme');
	}
	/**
	 * 添中入库类型设置
	 */
	public function addstoragetype() {
		$this->leftpos = 2;
		$this->loadModel('franchisee', 'typesetting');
		include $this->loadWidget('franchiseeTheme');

	}
	/**
	 * 插入入库类型设置
	 */
	public function insertstoragetype() {
		$this->loadModel('franchisee', 'typesetting');
		$this->loadHelper('extend');
		//$id=$_POST['id'];
		$data = $_POST['data'];
		$data['type'] = 1;
		$re = $this->wms->typesettingModel->insert($data);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/**
	 * 编辑入库类型设置
	 */
	public function editstoragetype() {
		$this->leftpos = 2;
		$this->loadModel('franchisee', 'typesetting');
		$id = $_GET['id'];
		$sql = "select * from wms_typesetting where id=$id";
		$re = $this->wms->typesettingModel->fetchRow($sql);
		include $this->loadWidget('franchiseeTheme');
	}
	/**
	 * 保存入库类型设置
	 */
	public function updatestoragetype() {
		$this->loadModel('franchisee', 'typesetting');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$data = $_POST['data'];
		$re = $this->wms->typesettingModel->update($data, 'id=' . $id);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/*
	 * 删除入库类型设置
	 */
	public function delstoragetype() {

		$this->loadHelper('extend');
		$id = $_GET['id'];
		$this->loadModel('franchisee', 'typesetting');
		$re = $this->wms->typesettingModel->delete($id);
		if ($re) {
			ajaxReturn('back', '删除成功', 1);exit;
		} else {
			ajaxReturn('back', '删除失败', 0);exit;
		}
	}

	/**
	 * 出库类型设置列表
	 */
	public function storagetypeout() {
		$this->leftpos = 3;
		$this->loadModel('franchisee', 'typesetting');
		$sql = "select * from wms_typesetting where type=0 ";
		$re = $this->wms->typesettingModel->fetchAll($sql);
		include $this->loadWidget('franchiseeTheme');
	}
	/**
	 * 添中出库类型设置
	 */
	public function addstoragetypeout() {
		$this->leftpos = 3;
		$this->loadModel('franchisee', 'typesetting');
		include $this->loadWidget('franchiseeTheme');

	}
	/**
	 * 插入出库类型设置
	 */
	public function insertstoragetypeout() {
		$this->loadModel('franchisee', 'typesetting');
		$this->loadHelper('extend');
		//$id=$_POST['id'];
		$data = $_POST['data'];
		$data['type'] = 0;
		$re = $this->wms->typesettingModel->insert($data);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/**
	 * 编辑出库类型设置
	 */
	public function editstoragetypeout() {
		$this->leftpos = 3;
		$this->loadModel('franchisee', 'typesetting');
		$id = $_GET['id'];
		$sql = "select * from wms_typesetting where id=$id";
		$re = $this->wms->typesettingModel->fetchRow($sql);
		include $this->loadWidget('franchiseeTheme');
	}
	/**
	 * 保存出库类型设置
	 */
	public function updatestoragetypeout() {
		$this->loadModel('franchisee', 'typesetting');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$data = $_POST['data'];
		$re = $this->wms->typesettingModel->update($data, 'id=' . $id);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/*
	 * 删除出库类型设置
	 */
	public function delstoragetypeout() {

		$this->loadHelper('extend');
		$id = $_GET['id'];
		$this->loadModel('franchisee', 'typesetting');
		$re = $this->wms->typesettingModel->delete($id);
		if ($re) {
			ajaxReturn('back', '删除成功', 1);exit;
		} else {
			ajaxReturn('back', '删除失败', 0);exit;
		}
	}

}
?>