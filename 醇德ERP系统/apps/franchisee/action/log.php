<?php

class log extends actionAbstract {
	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 5;
	public $type = 0;
	public $leftpos = 0;
	public $like = "";
	public $where = "";

	/*
	 * 构造
	 */
	function __construct() {
		parent::__construct();
		$this->info = acl::checkLogin('accessinfo', $this->url('common/login'));
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
	}

	//入库记录
	public function storeage() {
		$this->leftpos = 0;
		$this->loadModel('franchisee', 'log');
		$re = $this->franchisee->logModel->fetchAll("select * from franchisee_log where  token='" . $this->info['token'] . "' type=1 order by id desc");
		include $this->loadWidget('franchiseeTheme');
	}

	//出库记录
	public function stroeout() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'log');
		$re = $this->franchisee->logModel->fetchAll("select * from franchisee_log where token='" . $this->info['token'] . "' type=2 order by id desc");
		include $this->loadWidget('franchiseeTheme');
	}

	//盘点记录
	public function turkey() {
		$this->leftpos = 2;
		$this->loadModel('franchisee', 'log');
		$re = $this->franchisee->logModel->fetchAll("select * from franchisee_log where  token='" . $this->info['token'] . "' status=3 order by id desc");
		include $this->loadWidget('franchiseeTheme');
	}
	//报损记录
	public function loss() {
		$this->leftpos = 3;
		$this->loadModel('franchisee', 'log');
		$re = $this->franchisee->logModel->fetchAll("select * from franchisee_log where  token='" . $this->info['token'] . "' status=4 order by id desc");
		include $this->loadWidget('franchiseeTheme');
	}
}