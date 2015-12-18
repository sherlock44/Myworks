<?php
/*
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */
class index extends actionAbstract {

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
		$this->info = acl::checkLogin('accessinfo', $this->url('common/login'));
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;

	}

	/*
	 * 显示修改密码页面
	 * */
	public function editPassword() {

		include $this->loadWidget('franchiseelteTheme');
	}
	/*
	 * 获得franchiseeThere中的commname
	 * 			<?=$this->info['commname']?>

	 * */
	public function getCommname() {
		$id = $this->info['id'];
		$this->loadHelper('extend');

		$this->loadModel('franchisee', 'alliance');
		$sql = "select commname from franchisee_alliance where id = $$id";
		$result = $this->franchisee->allianceModel->fetchRow($sql);
		ajaxReturn($result);

	}
/*
 * 修改密码
 * */
	public function savePassword() {
		$id = $this->info['id'];
		$this->loadHelper('extend');
		$this->loadModel('franchisee', 'alliance');
		//$data = $_POST['data'];
		$password = md5($_POST['password']);
		$oldpwd = md5($_POST['oldpwd']);
		$passwordArr = array();
		$passwordArr['password'] = $password;
		if($oldpwd!=$this->info['password']){
			ajaxReturn('', '原始密码不正确', 0);exit;
		}
		if (md5($_POST['pwd']) != $password) {
			ajaxReturn('', '两次密码不一致', 0);exit;
		} else {
			$result = $this->franchisee->allianceModel->update($passwordArr, 'id=' . $id);
			if ($result) {
				ajaxReturn('', '修改成功！', 1);exit;
			}
			ajaxReturn('', '修改失败', 0);exit;
		}
	}

	public function main() {

		$uf = $this->info;
		$this->leftpos = 0;
		//查看未完成订单
		$this->loadModel('franchisee', 'card');
		$this->loadModel('franchisee', 'order');
		$this->loadModel('product', 'webinfouser');
		$this->loadmodel('franchisee', 'userorder');
		$sql = "select * from franchisee_order where status>=0 and status<5  and token='" . $this->info['token'] . "'";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		//退货订单
		$this->loadModel('franchisee', 'orderback');
		$orderbacknum = $this->franchisee->orderbackModel->selectCnt(" status>=1 and token='" . $this->info['token'] . "'");
		//已处理订单
		$donenum = $this->franchisee->orderModel->selectCnt(" status=5 and token='" . $this->info['token'] . "'");
		//已发货订单
		$sendnum = $this->franchisee->orderModel->selectCnt(" status=3 and token='" . $this->info['token'] . "'");
		//已开通会员
		$cardnum = $this->franchisee->cardModel->selectCnt(" status=1 and token='" . $this->info['token'] . "'");
		$conf = $this->loadConfig('posapiconfig');
		//查询今日销售额
		$begin = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
		$where = "  and (fu.created>'{$begin}' and fu.created<'{$end}' ) and fu.token ='{$uf['token']}'";
		$sql = "select sum(fu.price) as tolpri from franchisee_userorder as fu
                     where fu.paystatus=1 " . $where;
		$tdmoney = $this->franchisee->userorderModel->fetchRow($sql);
		if (empty($tdmoney)) {
			$money = 0;
		} else {
			$money = $tdmoney['tolpri'];
		}
		//查看未读公告总数
		$sql = "select count(pwer.id) as num from product_webinfouser as pwer where pwer.token = '{$uf['token']}' and pwer.sign =1";
		$wdnum = $this->product->webinfouserModel->fetchRow($sql);
		$this->loadModel('product', 'webinfouser');
		$sql = "select pwer.* ,pw.time,pw.content
                from product_webinfouser as pwer
                join product_webinfo as pw on pw.id = pwer.webinfoid
                where pwer.token = '{$uf['token']}' and pwer.sign =1";
		$ntrs = $this->product->webinfouserModel->fetchAll($sql);
		include $this->loadWidget('franchiseelteTheme');
	}

	//公告
	public function getmessage() {
		$this->loadModel('franchisee', 'order');
		$sql = "select * from ";
	}

}
?>