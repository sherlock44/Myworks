<?php

/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */

class user extends actionAbstract {
	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 2;
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

	//用户列表
	public function lists() {
		$this->loadModel('member', 'basic');
		$this->loadHelper('extend');
		$sql = "select * from member_basic";
		$re = $this->member->basicModel->fetchAll($sql);
		include $this->loadWidget('franchiseeTheme');
	}

	//修改用户状态
	public function del() {
		$this->loadModel('member', 'basic');
		$this->loadHelper('extend');
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		$status = isset($_GET['status']) ? $_GET['status'] : '';
		if (!empty($id)) {
			$data['status'] = $status;
			$re = $this->member->basicModel->update($data, $id);
			if ($re) {
				ajaxReturn('back', '操作成功！', 1);exit;
			} else {
				ajaxReturn('', '操作失败！', 0);exit;
			}
		} else {
			ajaxReturn('', '无效参数！', 0);exit;
		}
	}

	//会员空卡管理
	public function cardvoid() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'card');
		$this->loadHelper('extend');
		$posapiconf = $this->loadConfig("posapiconfig");
		$cardType = $posapiconf['cardType'];

		$filed = "";
		$token = $this->info['token'];
		foreach ($cardType as $k => $val) {
			if ($k != 0) {
				$filed .= " , ";
			}
			$filed .= " (select count(*) from franchisee_card where token='" . $token . "' and cardtype=$k and status=0) as num$k,(select count(*) from franchisee_card where  token='" . $token . "'  and cardtype=$k and status=1) as passnum$k ";
		}
		//echo $filed;exit;
		$sql = "select $filed from franchisee_card  where token='" . $token . "'";

		$re = $this->franchisee->cardModel->fetchAll($sql);

		include $this->loadWidget('franchiseeTheme');
	}
	//会员卡管理
	public function card() {
		$this->leftpos = 2;
		$this->loadModel('franchisee', 'card');
		$this->loadHelper('extend');
		$token = $this->info['token'];
		$sql = "select * from franchisee_card    where token='" . $token . "' and status>0";
		$re = $this->franchisee->cardModel->fetchAll($sql);
		$posapiconf = $this->loadConfig("posapiconfig");
		$cardType = $posapiconf['cardType'];
		include $this->loadWidget('franchiseeTheme');
	}

}
?>