<?php

/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */

class property extends actionAbstract {
	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 3;
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

	//交接班管理
	public function lists() {
		$this->loadModel('franchisee', 'summary');
		$this->loadHelper('extend');
		$sql = "select fs.*,fw.truename from franchisee_summary as fs left join franchisee_worker as fw on fs.workeruuid=fw.uuid where fs.token='" . $this->info['token'] . "' order by fs.id desc";
		$sql = "select fs.* from franchisee_summary as fs  where fs.token='" . $this->info['token'] . "' order by fs.id desc";
		$re = $this->franchisee->summaryModel->fetchAll($sql);
		include $this->loadWidget('franchiseeTheme');
	}

}
?>