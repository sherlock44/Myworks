<?php

/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */

class pos extends actionAbstract {
	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 1;
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
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
	}
	//会员统计
	public function userlist() {
		$re = $this->info;
		$this->loadModel('franchisee', 'card');
		$sql = "select * from franchisee_card where status=1 and token = '{$re['token']}'";
		$rs = $this->franchisee->cardModel->fetchAll($sql);
		include $this->loadWidget('franchiseelteTheme');
	}
	//消费记录
	public function recharge() {
		$re = $this->info;
		$this->loadModel('franchisee', 'cardlog');
		$card = $_GET['card'];
		$sql = "select * from franchisee_cardlog where token = '{$re['token']}' and cardnum = '{$card}'";
		$rs = $this->franchisee->cardlogModel->fetchAll($sql);
		include $this->loadWidget('franchiseelteTheme');
	}
	//关联订单
	public function consume() {
		$re = $this->info;
		$this->loadModel('franchisee', 'userorder');
		$card = $_GET['card'];
		$sql = "select fu.*,fw.truename from franchisee_userorder as fu
                 join franchisee_worker as fw on fu.workeruuid = fw.uuid
                 where fu.token = '{$re['token']}' and fu.carduuid = '{$card}' ";
		$rs = $this->franchisee->userorderModel->fetchAll($sql);
		include $this->loadWidget('franchiseelteTheme');
	}
	//订单详情
	public function useroderDetail() {
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
		include $this->loadWidget('franchiseelteTheme');
	}
	//收银管理
	public function cashier() {
		$this->loadModel('franchisee', 'summary');
		$this->loadHelper('extend');
		if (isset($_GET['date']) && !empty($_GET['date'])) {
			$tmdur = $this->getTimedur($_GET['date']);
			$sql = "select fs.* from franchisee_summary as fs  where fs.logintime>'{$tmdur['begin']}' and fs.endtime<'{$tmdur['end']}' and
                  fs.token='" . $this->info['token'] . "' order by fs.id desc";
		} else {
			$sql = "select fs.* from franchisee_summary as fs  where fs.token='" . $this->info['token'] . "' order by fs.id desc";
		}
		$re = $this->franchisee->summaryModel->fetchAll($sql);
		include $this->loadWidget('franchiseelteTheme');
	}
	//获取时间起止时间戳 1今天 2昨天 3本周(周一开始) 4本月
	public function getTimedur($type) {
		//本周开始时间和结束时间
		$date = date("Y-m-d");
		$w = date('w', strtotime($date));
		$first = 1;
		$now_start = date('Y-m-d', strtotime("$date -" . ($w ? $w - $first : 6) . ' days'));
		$week_end = date('Y-m-d', strtotime("$now_start +7 days"));
		$timeDur = array();
		switch ($type = 3) {
			case 1:
				$timeDur['begin'] = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
				$timeDur['end'] = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
				break;
			case 2:
				$timeDur['begin'] = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
				$timeDur['end'] = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1;
				break;
			case 3:
				$timeDur['begin'] = strtotime($now_start);
				$timeDur['end'] = strtotime($week_end) - 1;
				break;
			case 4:
				$timeDur['begin'] = mktime(0, 0, 0, date('m'), 1, date('Y'));
				$timeDur['end'] = mktime(23, 59, 59, date('m'), date('t'), date('Y'));
				break;
			default:
				return $timeDur;
				break;
		}
		return $timeDur;
	}
}
?>