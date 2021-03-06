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
	}

	/*
	 * 登录页面
	 */
	public function login() {

		//print_r($_SESSION);
		/*  if(isset($_SESSION['accessinfo'])){
		unset($_SESSION['accessinfo']);}
		if(isset($_SESSION['menudata']))
		unset($_SESSION['menudata']);
		if(isset($_SESSION['access_user_list']))
		unset($_SESSION['access_user_list']); */

		$token = isset($_GET['token']) ? $_GET['token'] : '';
		if (!empty($token)) {
			$this->loadModel('franchisee', 'alliance');
			$sql = "select * from franchisee_alliance where token='" . $token . "'";
			$re = $this->franchisee->allianceModel->fetchRow($sql);
			if ($re) {
				acl::setCookie("accessinfo", $re);
				$gotoUrl = $this->url('system/website');
				header('location:' . $gotoUrl);
				exit;
			}
		}

		include $this->loadView();
	}

	/*
	 * 验证登录信息
	 */
	public function checkLogin() {
		if ($_POST) {
			$this->loadHelper('extend');
			if (!$_POST['username']) {
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
				$this->loadModel('franchisee', 'alliance');
				$password = md5($_POST['password']);
				$sql = "select * from franchisee_alliance where username='" . $_POST['username'] . "' and password='" . $password . "' and status=1";
				$re = $this->franchisee->allianceModel->fetchRow($sql);

				if (!$re) {
					exit(json_encode(array('state' => 0, 'info' => '用户名或密码错误')));
				} else {

					//获取登陆ip，保存到数据库
					//$time=new date();
					/*$re['ip']=$_SERVER["REMOTE_ADDR"];
					$ip=$re['ip'];
					$result=$this->ic->accountModel->update($re,"ip='{$ip}'");*/

					//存储cookie

					acl::setCookie("accessinfo", $re);

					/* $_SESSION['accessinfo']=$re;
					$sql    =   "select menupin from system_group_menu where groupid=".$re['groupid'];
					$sqls   =   "select * from system_menu where pin in(".$sql.") order by parentid asc";

					$result=$this->ic->allianceModel->fetchRow($sqls);

					if(!$result || empty($result['module'])){
					exit(json_encode(array('state' => 0, 'info' =>  '没有权限')));
					}else{
					$url    =   $this->url($result['module']."/".$result['method']);
					exit(json_encode(array('state' => 1, 'info' =>  '登录成功','url'=>$url)));
					} */
					$url = $this->url('index/main');
					exit(json_encode(array('state' => 1, 'info' => '登录成功', 'url' => $url)));

					//ajaxReturn ($this->url('system/website'),'登录成功', 1 );exit;

				}
			}
		}
	}

	/**
	 * @desc 安全退出
	 */
	public function logout() {
		$this->loadHelper('extend');
		setcookie("accessinfo", "", time() - 3600, '/');

		// unset($_SESSION['accessinfo']);
		// // if(isset($_SESSION['menudata']))
		// // unset($_SESSION['menudata']);
		// // if(isset($_SESSION['access_user_list']))
		// // unset($_SESSION['access_user_list']);
		ajaxReturn('', '退出成功', 1);
		exit;
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
		acl::setCookie("accessinfo", "");
		header("location:/index.php/sysadmin/index");
	}
	public function register() {
		include $this->loadView();
	}

	/**
	 *错误提示
	 *
	 */
	function alert() {
		$msg = $_GET['msg'];
		$sleep = $_GET['sleep'];
		$state = 0;
		include $this->loadView();
	}
}
?>