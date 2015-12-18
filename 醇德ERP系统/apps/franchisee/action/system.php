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
		$this->info = acl::checkLogin('accessinfo', $this->url('common/login'));
		//     if(!isset($_SESSION['accessinfo'])){ header('location:'.$this->url('common/login'));}
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
	}
	//系统公告列表
	public function sysNotice() {
		$se = $this->info;
		$this->loadModel('product', 'webinfouser');
		$sql = "select pwer.* ,pw.time,sa.truename
                from product_webinfouser as pwer
                join product_webinfo as pw on pw.id = pwer.webinfoid
                join system_admin as sa on sa.id    = pw.seuserid
                where pwer.token = '{$se['token']}' ";
		$re = $this->product->webinfouserModel->fetchAll($sql);
		include $this->loadWidget('franchiseelteTheme');
	}
	//删除系统公告信息
	public function delinfo() {
		$this->leftpos = 2;

		$this->loadHelper('extend');
		$this->loadModel('product', 'webinfouser');
		if ($_GET) {
			$id = $_GET['id'];
			$re = $this->product->webinfouserModel->delete($id);
			if ($re) {
				ajaxReturn('', '删除成功', 1);exit;
			} else {
				ajaxReturn('', '删除失败', 0);exit;
			}
		}
	}
	//查看收到的站内信详情
	public function myskin() {
		$id = $_GET['id'];
		$this->loadModel('product', 'webinfouser');
		$sql = "select pwer.* ,(select truename from system_admin where id = pwer.reuserid ) as glynm ,
                (select truename from franchisee_alliance where token = pwer.token) as jmsnm,pw.time,pw.title,pw.content
                from product_webinfouser as pwer
                join product_webinfo as pw on pw.id = pwer.webinfoid
                where pwer.id = {$id}";
		$re = $this->product->webinfouserModel->fetchRow($sql);
		$data['sign'] = 2;
		$this->product->webinfouserModel->update($data, $id);
		include $this->loadWidget('franchiseeTheme');
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
		include $this->loadWidget('franchiseeTheme');
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
	 * 进入修改账号
	 */
	public function edit() {
		$this->leftpos = 2;
		$this->pos = 3;
		$this->loadModel('franchisee', 'alliance');
		$this->loadModel('area', 'region');
		$id = $this->info['id'];
		$sql = "select * from franchisee_alliance    where id=" . $this->info['id'];
		$re = $this->franchisee->allianceModel->fetchRow($sql);
		$sql = "select a.name as city,c.name as area,p.name as provice from area_region as a join franchisee_alliance as f on a.id=f.cityid join area_region as c on c.id=f.areaid join area_region as p on p.id=f.proviceid WHERE f.id=" . $this->info['id'];
		$area = $this->area->regionModel->fetchRow($sql);
		include $this->loadWidget('franchiseelteTheme');
	}
	/**
	 * 修改账号
	 */
	public function update() {
		if ($_POST) {
			$this->loadHelper('extend');
			$this->loadModel('franchisee', 'alliance');
			$data = array();
			$id = $this->info['id'];
			$data = $_POST['data'];
			if ($id > 0) {
				$sql = "select * from franchisee_alliance where id!={$id} and mobile='" . $data['username'] . "'";
				$re = $this->franchisee->allianceModel->fetchRow($sql);
				if ($re) {
					ajaxReturn('', '账号已存在', 0);exit;
				}
				$re2 = $this->franchisee->allianceModel->update($data, $id);
				$this->loadModel('financial','synctype');
				$ds['keytype']='updatemysel';
				$ds['token']=$this->info['token'];
				$s=$this->financial->synctypeModel->insert($ds);
				//print_r($s);exit;
				if (!$re2) {
					ajaxReturn('', '修改失败', 0);exit;
				} else {
					ajaxReturn('', '修改成功', 1);exit;
				}
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
		include $this->loadWidget('franchiseeTheme');
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
		if (isset($_GET['state']) && $_GET['state'] !== "") {
			$this->where .= " and state = " . $_GET['state'] . "";
		}
		if (!empty($_GET['title'])) {
			$this->where .= " and title like  '%" . $_GET['title'] . "%'";
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
		$sql = "select * from system_group " . $this->where . " limit " . $offset . "," . $size . "";
		$re = $this->system->groupModel->fetchAll($sql);

		include $this->loadWidget('franchiseeTheme');
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
		include $this->loadWidget('franchiseeTheme');
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
				ajaxReturn('back', '删除成功', 1);exit;

			}
		}
		include $this->loadWidget('franchiseeTheme');
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

		//echo "<pre>";
		//print_r($result);exit;
		include $this->loadWidget('franchiseeTheme');
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
		if (isset($this->menudata[$menuid]['level'])) {
			$level = $this->menudata[$menuid]['level'] + 1;
		} else {
			$level = 0;
		}
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
		//print_r($data);exit;
		$line = $this->system->menuModel->insert($data);
		//$result = $this->menu_model->add ( $menuid, $title, $module, $method, $parameter, $state, $level, $isshow );
		if ($line) {
			//$this->cacha ();
			ajaxReturn('', '', 1);
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
		$this->leftpos = 1;
		$this->loadModel('system', 'setting');
		$sql = "select * from system_setting";
		$re = $this->system->settingModel->fetchAll($sql);
		include $this->loadWidget('franchiseeTheme');
	}

	/*
	 * SMTP设置
	 */
	public function setting_smtp() {
		$this->leftpos = 1;
		$this->loadModel('system', 'setting');
		$count = 0;
		$this->loadHelper('extend');
		if ($_POST) {
			foreach ($_POST['data'] as $key => $value) {
				$re = $this->system->settingModel->update("value='{$value}'", "`key`='{$key}'");
				if ($re) {
					$count++;
				}
			}
			if ($count > 0) {
				ajaxReturn('', '修改成功', 1);exit;
			}

		}
	}

}
?>