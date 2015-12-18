<?php
/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */
class system extends actionAbstract {

	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 0;
	public $type = 0;
	public $leftpos = 0;

	/**
	 * 递归要添加的菜单PIN
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
		//     if(!isset($_SESSION['admininfo'])){ header('location:'.$this->url('common/login'));}$this->info	=	 $_SESSION['admininfo'];
		$this->menu = $this->loadConfig();

		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			//ajax request
			$this->checkpower();
		}
	}

	/**
	 * 平台设置
	 */
	public function website() {
		$this->leftpos = 0;
		$this->loadModel('system', 'setting');
		$where = "`key`='websiteName' or `key`='url' or `key`='keywords' or `key`='description'";
		$sql = "select * from system_setting where " . $where;
		$re = $this->system->settingModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 平台设置修改
	 */
	public function check() {
		$this->loadHelper('extend');
		$this->loadModel('system', 'setting');
		if ($_POST) {
			$data = isset($_POST['data']) ? $_POST['data'] : '';
			if (!empty($data)) {
				foreach ($data as $k => $v) {
					$re = $this->system->settingModel->update('value="' . $v . '"', '`key`="' . $k . '"');
				}
			}
			if ($re) {
				ajaxReturn('', '更新成功！', 1);exit;
			} else {
				ajaxReturn('', '更新失败！', 0);exit;
			}
		}
	}

	/**
	 * 帐号管理
	 */
	public function admin() {
		$this->leftpos = 2;
		$this->loadModel('system', 'admin');
		$sql = "select system_admin.*,system_group.title from system_admin left join system_group on system_group.groupid=system_admin.groupid ";
		$re = $this->system->adminModel->fetchAll($sql);

		$this->loadModel('system', 'group');
		$s = "select * from system_group";
		$r = $this->system->groupModel->fetchAll($s);

		include $this->loadWidget('amdinlteTheme');
	}

	/**
	 * 进入修改账号
	 */
	public function edit() {
		$this->leftpos = 2;
		$this->loadModel('system', 'admin');
		$this->loadModel('system', 'group');
		if ($_GET) {
			$id = $_GET['id'];
			
			$sql = "select * from system_admin   where id={$id}";
			$re = $this->system->adminModel->fetchRow($sql);
			$groupid = $re['groupid'];
			$s = "select * from system_group";
			$r = $this->system->groupModel->fetchAll($s);
		}
		include $this->loadWidget('amdinlteTheme');
	}

	/**
	 * 修改账号
	 */
	public function update() {
		if ($_POST) {
			$this->loadHelper('extend');
			$this->loadModel('system', 'admin');
			$data = array();
			$id = $_POST['id'];
			$data = $_POST['data'];
			$data['status'] = $_POST['status'];
			$data['groupid'] = $_POST['groupid'];
			$username = $_POST['username'];
			if ($_POST['password'] != "") {
				if ($_POST['password'] != $_POST['pwd']) {
					ajaxReturn('', '密码不一致', 0);exit;
				}
				if (strlen($_POST['pwd']) < 6 || strlen($_POST['pwd']) > 20) {
					ajaxReturn('', '请填写6到20位的密码', 0);exit;
				}
				$data['password'] = md5($_POST['pwd']);
			}
			if ($id > 0) {
				$sql = "select * from system_admin where id!={$id} and name='" . $username . "'";
				$re = $this->system->adminModel->fetchRow($sql);
				if (!$re) {
					$data['name'] = $username;
				} else {
					ajaxReturn('', '账号已存在', 0);exit;
				}
				$re2 = $this->system->adminModel->update($data, $id);
				if (!$re2) {
					ajaxReturn('', '修改失败', 0);exit;
				} else {
					ajaxReturn('', '修改成功', 1);exit;
				}
			}
		}
	}
	/**
	 * 添加管理员账号
	 */
	public function add() {
		$this->leftpos = 2;
		$this->loadHelper('extend');
		$this->loadModel('system', 'admin');
		$this->loadModel('system', 'group');
		$s = "select * from system_group";
		$r = $this->system->groupModel->fetchAll($s);
		if ($_POST) {
			$data = array();
			$data = $_POST['data'];
			$data['created'] = $_POST['created'];
			$data['status'] = $_POST['status'];
			$data['lasttime'] = $_POST['created'];
			$data['groupid'] = $_POST['groupid'];
			$data['lastip'] = $_SERVER['SERVER_ADDR'];
			if ($_POST['password'] != "" && $_POST['pwd'] == $_POST['password'] && strlen($_POST['pwd']) > 5 && strlen($_POST['pwd']) < 21) {
				$data['password'] = md5($_POST['pwd']);
				$sql = "select * from system_admin where name='" . $_POST['uname'] . "'";
				$re = $this->system->adminModel->fetchRow($sql);
				if ($re) {
					ajaxReturn('', '该账号已存在', 1);exit;
				} else {
					$data['name'] = $_POST['uname'];
					$re2 = $this->system->adminModel->insert($data);
					//$this->loadModel('product', 'user');
					//$udata['id'] = $re2;
					//$r3 = $this->product->userModel->insert($udata);
					if ($re2) {
						ajaxReturn('', '添加成功', 1);exit;
					} else {
						ajaxReturn('', '添加失败', 0);exit;
					}
				}
			} else {
				ajaxReturn('', '请检查你的密码是否正确', 0);exit;
			}
		}
		include $this->loadWidget('amdinlteTheme');
	}

	/**
	 * 删除操作
	 */
	public function del() {
		$this->leftpos = 2;
		$this->loadHelper('extend');
		$this->loadModel('system', 'admin');
		if ($_GET) {
			$id = $_GET['id'];
			$re = $this->system->adminModel->delete($id);
			if ($re) {
				ajaxReturn('', '删除成功', 1);exit;
			} else {
				ajaxReturn('', '删除失败', 0);exit;
			}
		}
	}

	//日志管理
	public function log() {
		$this->leftpos = 1;
		$this->loadModel('system', 'log');
		$this->loadHelper('extend');
		$sql = "select * from system_log";
		$re = $this->system->logModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}

	/*
	 * 权限组
	 */
	public function role() {
		$this->leftpos = 3;
		$this->loadModel('system', 'group');
		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$this->where = " where 1=1 ";
		$title = null;

		if (!empty($_GET['title'])) {
			$this->where .= " and sr.title like  '%" . $_GET['title'] . "%'";
			$title = $_GET['title'];
		}

		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = 10;
		$offset = ($page - 1) * $size;
		$sql = "select count(*) from system_group " . $this->where . "";
		$count = $this->system->groupModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select sr.*,se.title as parenttitle from system_group as sr left join system_group as se on se.groupid=sr.parentid " . $this->where;

		$re = $this->system->groupModel->fetchAll($sql);

		//include $this->loadWidget('amdinlteTheme');
		include $this->loadWidget('amdinlteTheme');
	}

	/*
	 * 查看权限组
	 */
	public function group_modify() {
		$this->leftpos = 3;
		$this->loadModel('system', 'group');
		if ($_GET) {
			$id = $_GET['id'];
			$sql = "select * from system_group where groupid={$id}";
			$re = $this->system->groupModel->fetchRow($sql);
		}
		include $this->loadWidget('amdinlteTheme');
	}

	/*
	 * 修改，添加权限组
	 */
	public function check_role() {
		$this->leftpos = 3;
		$this->loadModel('system', 'group');
		$this->loadHelper('extend');
		$data = $_POST['data'];
		if ($_POST && !empty($_POST['id'])) {
			$id = $_POST['id'];
			$re = $this->system->groupModel->update($data, 'groupid=' . $id);
			if ($re) {
				ajaxReturn('back', '修改成功', 1);exit;
			}
		}

		if ($_POST && empty($_POST['id'])) {
			$re = $this->system->groupModel->insert($data);
			if ($re) {
				ajaxReturn('back', '添加成功', 1);exit;
			}
		}
	}
	/*
	 *授权页面
	 */
	public function role_lock() {
		$this->leftpos = 3;
		$this->loadHelper('arrayHelper');
		$this->loadHelper('extend');
		$this->loadModel('system', 'group_menu');
		$this->loadModel('system', 'menu');
		$sql = "select * from system_menu    order by orderby asc ";
		$allmenu = $this->system->menuModel->fetchAll($sql);
		//print_r($allmenu);exit;
		$menudata = array();
		foreach ($allmenu as $key => $val) {
			$menudata[$val['menuid']] = $val;
		}
		$this->menudata = $menudata;
		if (isset($_GET['id'])) {
			$id = intval($_GET['id']);
		} else if (isset($_POST['id'])) {
			$id = intval($_POST['id']);
		} else {
			$id = 0;
		}
		if ($id) {
			$action = isset($_POST['action']) ? $_POST['action'] : '';
			if ($action && $action == 'true') {

				$menuids = trim($_POST['menuids']);
				$menuids = explode(',', $menuids);
				foreach ($menuids as $menuid) {
					if ($menuid == 'root' || !isset($this->menudata[$menuid])) {
						continue;
					}

					if ($this->menudata[$menuid]['parentid'] != 0) {
						$this->_add_menu_pin($menuid);
					}
				}
				// 组合添加菜单pin
				$addpin = array_unique($this->add_auth);
				if (empty($addpin)) {
					ajaxReturn('', '请选择要授权的菜单', 0);
				}

				// 更新权限
				$this->system->group_menuModel->delete('groupid=' . $id); //删除
				foreach ($addpin as $val) {
					$datas = array('groupid' => $id, 'menupin' => $val);
					$this->system->group_menuModel->insert($datas);
				}
				//$result = $this->role_model->authorization ( $id, $addpin );
				ajaxReturn('', '授权成功', 1);
			}

			$sql = " select * from system_group_menu where groupid=" . $id;
			$result = $this->system->group_menuModel->fetchAll($sql);
			$haveauth = array();
			if (!empty($result)) {
				foreach ($result as $key => $val) {
					$haveauth[] = $val['menupin'];
				}
			}
			//	$sql	=	"select * from system_menu order by orderby asc ";
			//$re		=	$this->system->menuModel->fetchAll($sql);
			$results = toTree($this->menudata, 'menuid', 'parentid', 'childs');
			$data['haveauth'] = $haveauth;
			$data['menu'] = $results;
			$data['id'] = $id;

			$html = $this->loadAjaxView('system/role_authorization', $data);
			ajaxReturn($html, '', 1);
		} else {
			ajaxReturn('', '缺少必要参数', 0);
		}
	}

	/**
	 * 递归到本次菜单添加关联pin
	 *
	 * @param array $menu
	 * @param array $addmenuids
	 */
	private function _add_menu_pin($menuid) {
		if (isset($this->menudata[$menuid]['parentid'])) {
			$this->add_auth[] = $this->menudata[$menuid]['pin'];
			$this->_add_menu_pin($this->menudata[$menuid]['parentid']);
		}
	}
	/*
	 * 删除权限组
	 */
	public function group_del() {
		$this->leftpos = 3;
		$this->loadModel('system', 'group');
		$this->loadHelper('extend');
		if ($_GET) {
			$id = $_GET['id'];
			$re = $this->system->groupModel->delete('groupid=' . $id);
			if ($re) {
				ajaxReturn('', '删除成功', 1);exit;

			}
		}
		include $this->loadWidget('amdinlteTheme');
	}
	/*
	 * 后台菜单
	 */
	public function menu() {
		$this->leftpos = 4;
		$this->loadModel('system', 'menu');
		$this->loadHelper('arrayHelper');
		$this->loadHelper('extend');
		$sql = "select * from system_menu order by orderby asc ";
		$re = $this->system->menuModel->fetchAll($sql);
		$result = toTree($re, 'menuid', 'parentid', 'childs');

		//var_dump($this->munult[0]['items']);exit;
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 *  编辑菜单
	 **/
	public function editmenu() {
		$this->leftpos = 4;
		$this->loadHelper('extend');
		$this->loadModel('system', 'menu');
		$sql = "select * from system_menu    order by orderby asc ";
		$allmenu = $this->system->menuModel->fetchAll($sql);
		//print_r($allmenu);exit;
		$menudata = array();
		foreach ($allmenu as $key => $val) {
			$menudata[$val['menuid']] = $val;
		}
		if (isset($_POST['menuid']) && isset($_POST['a']) && $_POST['a'] == 'get') {

			if (isset($menudata[$_POST['menuid']])) {
				//print_r($this->menudata [$_POST['menuid']]);exit;
				ajaxReturn($menudata[$_POST['menuid']], '', 1);exit;
			}
		}
		$menuid = $_POST['menuid'];
		// 验证不为空
		if (empty($menuid)) {
			ajaxReturn('', '缺少必要参数', 0);
		}

		$title = trim($_POST['title']);
		if (empty($title)) {
			ajaxReturn('', '菜单名称不能为空', 0);
		}

		$newtitle = trim($_POST['newtitle']);
		if (empty($newtitle)) {
			ajaxReturn('', '副标题不能为空', 0);
		}

		$module = trim($_POST['module']);
		if (empty($module)) {
			ajaxReturn('', '模块不能为空', 0);
		}

		$method = trim($_POST['method']);
		if (empty($method)) {
			$method = 'index';
		}

		$parameter = trim($_POST['parameter']);
		$isshow = intval($_POST['isshow']);
		$state = intval($_POST['state']);
		$level = $menudata[$menuid]['level'];
		$oldpin = $menudata[$menuid]['pin'];
		//$data['menuid']	=	$menuid;
		$data['title'] = $title;
		$data['newtitle'] = $newtitle;
		$data['module'] = $module;
		$data['method'] = $method;
		$data['parameter'] = $parameter;
		$data['state'] = $state;
		$data['level'] = $level;
		$data['isshow'] = $isshow;
		$data['pin'] = md5($module . '/' . $method . '/' . $level);
		$line = $this->system->menuModel->update($data, 'menuid=' . $menuid);
		//$result = $this->menu_model->edit ( $menuid, $title, $module, $method, $parameter, $state, $level, $oldpin, $isshow );
		if ($line) {
			//$this->cacha ();
			ajaxReturn('', '', 1);
		} else {
			ajaxReturn('', '菜单修改失败', 0);
		}
	}
	/***
	 *排序
	 *
	 ****/
	public function orderby() {
		$this->loadModel('system', 'menu');
		if ($_POST) {
			$orderby = $_POST;
			foreach ($orderby['orderby'] as $k => $v) {
				$r = $this->system->menuModel->update("orderby='" . $k . "'", "menuid='" . $v . "'");
			}
			echo json_encode(array('state' => 1, 'info' => ''));exit;
		}

	}
	/**
	 *添加菜单
	 *
	 **/
	public function addmenu() {
		$this->loadHelper('extend');
		$this->loadModel('system', 'menu');
		// 验证不为空
		$menuid = $_POST['menuid'];

		if (empty($menuid)) {
			ajaxReturn('', '缺少必要参数', 0);
		}

		$title = trim($_POST['title']);
		if (empty($title)) {
			ajaxReturn('', '菜单名称不能为空', 0);
		}

		$newtitle = trim($_POST['newtitle']);
		if (empty($newtitle)) {
			ajaxReturn('', '副标题不能为空', 0);
		}

		$module = trim($_POST['module']);

		if (empty($module)) {
			ajaxReturn('', '模块不能为空', 0);
		}

		$method = trim($_POST['method']);
		if (empty($method)) {
			$method = 'index';
		}

		$parameter = trim($_POST['parameter']);
		$state = intval($_POST['state']);
		$isshow = intval($_POST['isshow']);
		// 计算本次添加菜单等级
		$menuid = intval($menuid);
		if (isset($this->menudata[$menuid]['level'])) {
			$level = $this->menudata[$menuid]['level'] + 1;
		} else {
			$level = 0;
		}
		$data['newtitle'] = $newtitle;
		$data['title'] = $title;
		$data['module'] = $module;
		$data['method'] = $method;
		$data['parameter'] = $parameter;
		$data['state'] = $state;
		$data['level'] = $level;
		$data['parentid'] = $menuid;
		$data['isshow'] = $isshow;
		$data['pin'] = md5($module . '/' . $method . '/' . $level);
		//echo "<pre>";

		$line = $this->system->menuModel->insert($data);
		//$result = $this->menu_model->add ( $menuid, $title, $module, $method, $parameter, $state, $level, $isshow );
		if ($line) {
			//$this->cacha ();
			ajaxReturn('', '添加成功', 1);
		} else {
			ajaxReturn('', '菜单添加失败', 0);
		}
	}
	/*
	 *删除菜单
	 */
	public function deletemenu() {
		$this->loadHelper('extend');
		$this->loadModel('system', 'menu');
		$menuid = intval($_POST['menuid']);
		if ($menuid) {
			$result = $this->system->menuModel->delete('menuid=' . $menuid);
			if ($result) {
				//	$this->cacha ();
				ajaxReturn('', '', 1);
			} else {
				ajaxReturn('', '删除失败', 0);
			}
		}
	}
	/*
	 * SMTP设置
	 */
	public function smtp() {

		$this->loadHelper('encrypt');
		$en = new encrypt();
		$this->leftpos = 1;
		$this->loadModel('system', 'setting');
		$sql = "select * from system_setting";
		$re = $this->system->settingModel->fetchAll($sql);
		$re[8]['value'] = $en->decode($re[8]['value']);
		include $this->loadWidget('amdinlteTheme');
	}

	/*
	 * SMTP设置
	 */
	public function setting_smtp() {
		$se = $this->info;
		$this->loadHelper('encrypt');
		$this->loadHelper('log');
		$en = new encrypt();
		$this->leftpos = 1;
		$this->loadModel('system', 'setting');
		$count = 0;
		$this->loadHelper('extend');
		if ($_POST) {
			foreach ($_POST['data'] as $key => $value) {
				if ($key == 'emailpwd') {
					$value = $en->encode($value);
				}
				$re = $this->system->settingModel->update("value='{$value}'", "`key`='{$key}'");
				if ($re) {
					$count++;
				}
			}
			if ($count > 0) {
				//日志
				$logdata['title'] = '系统设置';
				$logdata['userid'] = $se['id'];
				$logdata['content'] = '修改SMTP配置信息';
				$log = new log();
				$log->logwrite($logdata);
				ajaxReturn('', '修改成功', 1);exit;
			}

		}
	}
}
?>