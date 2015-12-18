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
		//$this->info = acl::checkLogin('admininfo',$this->url('common/login'));
		if (!isset($_SESSION['admininfo'])) {header('location:' . $this->url('common/login'));}$this->info = $_SESSION['admininfo'];
		// if(!isset($_SESSION['admininfo'])){ header('location:'.$this->url('common/login'));}$this->info	=	 $_SESSION['admininfo'];
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			//ajax request
			$this->checkpower();
		}
	}

	//用户列表
	public function lists() {
		$this->loadModel('user', 'basic');
		$this->loadHelper('extend');
		$sql = "select * from user_basic where type=0";
		$re = $this->user->basicModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}

	//修改用户状态
	public function del() {
		$this->loadModel('user', 'basic');
		$this->loadHelper('extend');
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		$status = isset($_GET['status']) ? $_GET['status'] : '';
		if (!empty($id)) {
			$data['status'] = $status;
			$re = $this->user->basicModel->update($data, $id);
			if ($re) {
				ajaxReturn('', '操作成功！', 1);exit;
			} else {
				ajaxReturn('', '操作失败！', 0);exit;
			}
		} else {
			ajaxReturn('', '无效参数！', 0);exit;
		}
	}
	//所以加盟店管理
	public function joinTrader() {
		$this->loadModel('franchisee', 'alliance');
		$this->loadModel('area', 'region');
		$this->loadHelper('extend');
		$sql = "select franchisee_alliance.*,cs.title as ctitle from franchisee_alliance
              left join crm_usertype as cs on franchisee_alliance.supplytypeid=cs.id ";
		$re = $this->franchisee->allianceModel->fetchAll($sql);
		$sql = "select id,name from area_region ";
		$area = $this->area->regionModel->fetchAll($sql);
		$areaarray = array();
		foreach ($area as $k => $val) {
			$areaarray[$val['id']] = $val['name'];
		}
		$areaarray[0] = '';
		include $this->loadWidget('amdinlteTheme');
	}
	//修改加盟商信息
	public function editJointrader() {
		$id = $_GET['id'];
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'alliance');
		$this->loadModel('area', 'region');
		$this->loadModel('system', 'admin');
		$this->loadHelper('extend');
		$sql = "select * from franchisee_alliance  where id=$id";
		$re = $this->franchisee->allianceModel->fetchRow($sql);
		$province = $this->area->regionModel->select("*", "parentid=1");
		//市
		$city = $this->area->regionModel->fetchAll("select * from area_region where parentid=" . $re['proviceid']);
		$qu = $this->area->regionModel->fetchAll("select * from area_region where parentid=" . $re['cityid']);
		//加盟商类型
		$sql = "select id,title from crm_usertype ";
		$supplytype = $this->area->regionModel->fetchAll($sql);
		//系统管理员
		$sql = "select id,name,truename from system_admin ";
		$admins = $this->system->adminModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');

	}

	//我的加盟店
	public function franchisee() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'alliance');
		$this->loadModel('area', 'region');
		$this->loadHelper('extend');
		$sql = "select franchisee_alliance.*,cs.title as ctitle from franchisee_alliance
              left join crm_usertype as cs on franchisee_alliance.supplytypeid=cs.id
              where franchisee_alliance.userid = {$this->info['id']}";
		$re = $this->franchisee->allianceModel->fetchAll($sql);
		$sql = "select id,name from area_region ";
		$area = $this->area->regionModel->fetchAll($sql);
		$areaarray = array();
		foreach ($area as $k => $val) {
			$areaarray[$val['id']] = $val['name'];

		}
		$areaarray[0] = '';
		include $this->loadWidget('amdinlteTheme');
	}
	//添加加盟店
	public function addfranchisee() {
		$this->leftpos = 1;
		$this->loadModel('area', 'region');
		$province = $this->area->regionModel->select("*", "parentid=1");
		//加盟商类型
		$sql = "select id,title from crm_usertype ";
		$supplytype = $this->area->regionModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//加盟店数据插入
	public function insertfranchisee() {
		$this->loadModel('franchisee', 'alliance');
		$this->loadHelper('extend');
		//$id=$_POST['id'];
		$data = $_POST['data'];
		//echo "XXXX";exit;
		if (empty($data['password']) || $data['password'] != $_POST['pwd']) {
			ajaxReturn('', '两次密码不一致', 0);exit;
		}
		
		$data['password'] = md5($data['password']);
		$data['created'] = time();
		$data['token'] = "uuid()";
		$data['userid'] = $this->info['id'];
		//查看用户名存不存在
		$sql = "select * from franchisee_alliance where username='" . $data['username'] . "'";

		$check = $this->franchisee->allianceModel->fetchRow($sql);
//        var_dump($check);exit;
		if ($check) {
			ajaxReturn('', '该用户已存在', 0);exit;
		}
		$re = $this->franchisee->allianceModel->insert($data);
		if ($re) {
			$sql = "select token from franchisee_alliance where id=$re";
			$rs = $this->franchisee->allianceModel->fetchRow($sql);
			if ($rs) {
				$l = $this->pushtopos($rs['token']);
				if ($l) {
					$nd['url']	=	"/index.php/iManage/user/franchisee";
					$nd['info']	=	'操作成功';
					$nd['state']=1;
					$nd['data']='url';
					
					echo json_encode($nd);exit;
					ajaxReturn('', '操作成功', 1);exit;
				} else {
					$this->franchisee->allianceModel->delete("id=$re");
					ajaxReturn('', '操作失败', 0);exit;
				}
			} else {
				$this->franchisee->allianceModel->delete("id=$re");
				ajaxReturn('', '操作失败', 0);exit;
			}

		} else {
				ajaxReturn('', '操作失败', 0);exit;
		}

	}
	//编辑加盟店
	public function editfranchisee() {
		$id = $_GET['id'];
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'alliance');
		$this->loadModel('area', 'region');
		$this->loadHelper('extend');
		$sql = "select * from franchisee_alliance  where id=$id";
		$re = $this->franchisee->allianceModel->fetchRow($sql);
		$province = $this->area->regionModel->select("*", "parentid=1");
		//市
		$city = $this->area->regionModel->fetchAll("select * from area_region where parentid=" . $re['proviceid']);
		$qu = $this->area->regionModel->fetchAll("select * from area_region where parentid=" . $re['cityid']);
		//加盟商类型
		$sql = "select id,title from crm_usertype ";
		$supplytype = $this->area->regionModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//修改加盟店
	public function updatefranchisee() {
		$this->loadModel('franchisee', 'alliance');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$data = $_POST['data'];
		//查看有没有填写密码
		if (!empty($data['password'])) {
			if ($data['password'] != $_POST['pwd']) {
				ajaxReturn('', '两次密码不一致', 0);exit;
			}
			$data['password'] = md5($data['password']);
		} else {
			unset($data['password']);
		}
		//查看账号
		$sql = "select id,token from franchisee_alliance where username='" . $data['username'] . "' and id!=$id";
		$check = $this->franchisee->allianceModel->fetchRow($sql);
		if ($check) {
			ajaxReturn('', '该用户名已存在', 0);exit;
		}
		// $data=$_POST['data'];

		$re = $this->franchisee->allianceModel->update($data, 'id=' . $id);
		if ($re) {
			$sql = "select id,token from franchisee_alliance where  id=$id";
			$checks = $this->franchisee->allianceModel->fetchRow($sql);
			$this->loadModel('financial','synctype');
			$ds['keytype']='updatemysel';
			$ds['token']=$checks['token'];
			$this->financial->synctypeModel->insert($ds);
			ajaxReturn('', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	/*
	 * 删除供应商
	 */
	public function delfranchisee() {
		$this->loadHelper('extend');
		$id = $_GET['id'];
		$this->loadModel('franchisee', 'alliance');
		$re = $this->franchisee->allianceModel->delete($id);
		if ($re) {
			ajaxReturn('', '删除成功', 1);exit;
		} else {
			ajaxReturn('', '删除失败', 0);exit;
		}
	}
	//修改加盟商状态
	public function changefseestatus() {
		$this->loadModel('franchisee', 'alliance');
		$this->loadHelper('extend');
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		$status = isset($_GET['status']) ? $_GET['status'] : '';
		if (!empty($id)) {
			$data['status'] = $status;
			$re = $this->franchisee->allianceModel->update($data, $id);
			if ($re) {
				ajaxReturn('', '操作成功！', 1);exit;
			} else {
				ajaxReturn('', '操作失败！', 0);exit;
			}
		} else {
			ajaxReturn('', '无效参数！', 0);exit;
		}
	}

	//修改加盟商状态--总部
	public function changefseestatussys() {
		$this->loadModel('franchisee', 'alliance');
		$this->loadHelper('extend');
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		$status = isset($_GET['status']) ? $_GET['status'] : '';
		if (!empty($id)) {
			$data['status'] = $status;
			$re = $this->franchisee->allianceModel->update($data, $id);
			if ($re) {
				ajaxReturn('', '操作成功！', 1);exit;
			} else {
				ajaxReturn('', '操作失败！', 0);exit;
			}
		} else {
			ajaxReturn('', '无效参数！', 0);exit;
		}
	}
	//客户型弄

	/**
	 * 客户型弄列表
	 */
	public function usertype() {
		$this->leftpos = 2;
		$this->pos = 1;
		$this->loadModel('crm', 'usertype');
		$sql = "select * from crm_usertype ";
		$re = $this->crm->usertypeModel->fetchAll($sql);
		//include $this->loadWidget('amdinlteTheme');
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 添中客户型弄
	 */
	public function addusertype() {
		$this->leftpos = 2;
		$this->pos = 1;
		$this->loadModel('crm', 'usertype');
		include $this->loadWidget('amdinlteTheme');

	}
	/**
	 * 插入客户型弄
	 */
	public function insertusertype() {
		$this->loadModel('crm', 'usertype');
		$this->loadHelper('extend');
		//$id=$_POST['id'];
		$data = $_POST['data'];

		$re = $this->crm->usertypeModel->insert($data);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	/**
	 * 编辑客户型弄
	 */
	public function editusertype() {
		$this->leftpos = 2;
		$this->pos = 1;
		$this->loadModel('crm', 'usertype');
		$id = $_GET['id'];
		$sql = "select * from crm_usertype where id=$id";
		$re = $this->crm->usertypeModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 保存客户型弄
	 */
	public function updateusertype() {
		$this->loadModel('crm', 'usertype');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$data = $_POST['data'];
		$re = $this->crm->usertypeModel->update($data, 'id=' . $id);
		if ($re) {
			ajaxReturn('', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	/*
	 * 删除客户型弄
	 */
	public function delusertype() {

		$this->loadHelper('extend');
		$id = $_GET['id'];
		$this->loadModel('crm', 'usertype');
		$sql="select * from franchisee_alliance where supplytypeid=".$id;
		$user	=	$this->crm->usertypeModel->fetchAll($sql);
		if($user){
		ajaxReturn('', '该类型下有加盟商,不能删除', 0);exit;
		}
		$re = $this->crm->usertypeModel->delete($id);
		if ($re) {
			ajaxReturn('', '删除成功', 1);exit;
		} else {
			ajaxReturn('', '删除失败', 0);exit;
		}
	}

	/**
	 * 客户型弄列表
	 */
	public function usertypeyx() {
		$this->leftpos = 2;
		$this->pos = 1;
		$this->loadModel('crm', 'yixiangusertype');
		$sql = "select * from crm_yixiangusertype ";
		$re = $this->crm->yixiangusertypeModel->fetchAll($sql);
		//include $this->loadWidget('amdinlteTheme');
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 添中客户型弄
	 */
	public function addusertypeyx() {
		$this->leftpos = 2;
		$this->pos = 1;
		$this->loadModel('crm', 'yixiangusertype');
		include $this->loadWidget('amdinlteTheme');

	}
	/**
	 * 插入客户型弄
	 */
	public function insertusertypeyx() {
		$this->loadModel('crm', 'yixiangusertype');
		$this->loadHelper('extend');
		//$id=$_POST['id'];
		$data = $_POST['data'];

		$re = $this->crm->yixiangusertypeModel->insert($data);
		if ($re) {
			ajaxReturn('', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	/**
	 * 编辑客户型弄
	 */
	public function editusertypeyx() {
		$this->leftpos = 2;
		$this->pos = 1;
		$this->loadModel('crm', 'yixiangusertype');
		$id = $_GET['id'];
		$sql = "select * from crm_yixiangusertype where id=$id";
		$re = $this->crm->yixiangusertypeModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 保存客户型弄
	 */
	public function updateusertypeyx() {
		$this->loadModel('crm', 'yixiangusertype');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$data = $_POST['data'];
		$re = $this->crm->yixiangusertypeModel->update($data, 'id=' . $id);
		if ($re) {
			ajaxReturn('', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	/*
	 * 删除客户型弄
	 */
	public function delusertypeyx() {

		$this->loadHelper('extend');
		$id = $_GET['id'];
		$this->loadModel('crm', 'yixiangusertype');
		$re = $this->crm->yixiangusertypeModel->delete($id);
		if ($re) {
			ajaxReturn('', '删除成功', 1);exit;
		} else {
			ajaxReturn('', '删除失败', 0);exit;
		}
	}
	/**
	 * 客户列表
	 */
	public function customer() {
		$this->leftpos = 3;
		$this->loadModel('crm', 'member');
		$sql = "select cm.*,sa.name as jlname,cu.title as cutitle from crm_member as cm
              left join system_admin as sa on sa.id=cm.account_managerid
              left join crm_yixiangusertype as cu on cu.id=cm.type
              where cm.account_managerid = {$this->info['id']}";
		$re = $this->crm->memberModel->fetchAll($sql);
		$sysconf = $this->loadConfig('sysconf');
		//客户类型
		$sql = "select c.title from crm_yixiangusertype as c join crm_member as m on c.id=m.type";
		$usertype = $this->crm->memberModel->fetchAll($sql);
//      var_dump($usertype);exit;
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 添中客户
	 */
	public function addcustomer() {
		$this->leftpos = 3;
		$this->loadModel('crm', 'member');
		$this->loadModel('area', 'region');
		$sysconf = $this->loadConfig('sysconf');
		$province = $this->area->regionModel->select("*", "parentid=1");

//         var_dump($sysconf);exit;
		//客户类型
		$sql = "select id,title from crm_yixiangusertype ";
		$usertype = $this->crm->memberModel->fetchAll($sql);
		//客户经理
		$sql = "select id,name from system_admin ";
		$admin = $this->crm->memberModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');

	}
	//添加客户回访记录
	public function customerlog() {
		$this->loadModel('crm', 'member');
		$this->loadModel('crm', 'memberlog');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		//修改上下次回访时间，及状态 productontime
		$data['visittime'] = strtotime($_POST['productontime']);

		$productontime = $_POST['productontime'];
		if (empty($data['visittime'])) {
			ajaxReturn('', '请填写回访时间', 0);exit;
		}
		$thiscontent = $_POST['thiscontent'];
		if (empty($thiscontent)) {
			ajaxReturn('', '请填写回访内容', 0);exit;
		}
		if ($_POST['checkstate'] == 0) {
			$data['nextvisittime'] = strtotime($_POST['nexttime']);
			if (empty($data['nextvisittime'])) {
				ajaxReturn('', '请填写下次回访时间', 0);exit;
			}
		} else {
			$data['nextvisittime'] = 0;
		}
		$data['status'] = $_POST['checkstate'];
		//$data=$_POST['data'];
		$line = $this->crm->memberModel->update($data, 'id=' . $id);

		if ($line) {
			$logdata['visittime'] = $data['visittime'];
			$logdata['nextvisittime'] = $data['nextvisittime'];
			$logdata['status'] = $data['status'];
			$logdata['content'] = $_POST['thiscontent'];
			$logdata['nextcontent'] = $_POST['nextcontent'];
			$logdata['memberid'] = $_POST['id'];
			$l = $this->crm->memberlogModel->insert($logdata);
			if ($l) {
				ajaxReturn('', '操作成功', 1);exit;
			} else {
				print_r($logdata);exit;
			}
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	/**
	 * 插入客户
	 */
	public function insertcustomer() {
		$this->loadModel('crm', 'member');
		$this->loadHelper('extend');
		//$id=$_POST['id'];
		$data = $_POST['data'];
		$data['account_managerid'] = $this->info['id'];
		$data['created'] = time();
		$re = $this->crm->memberModel->insert($data);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	/**       <?=!empty($re) ? $re['source']: ''?>

	 * 编辑客户insertcustomer
	 */
	public function editcustomer() {
		$this->leftpos = 3;
		$this->loadModel('crm', 'member');
		$this->loadModel('crm', 'memberlog');
		$this->loadModel('area', 'region');
		$id = $_GET['id'];
		$sql = "select a.name as city,a.id as city_id,c.name as area,c.id as area_id,p.name as provice,p.id as provice_id from area_region as a join crm_member as f on a.id=f.cityid join area_region as c on c.id=f.areaid join area_region as p on p.id=f.proviceid WHERE f.id=" . $id;
		$area = $this->area->regionModel->fetchRow($sql);

		$sql = "select * from crm_member where id=$id";
		$re = $this->crm->memberModel->fetchRow($sql);
		$sysconf = $this->loadConfig('sysconf');

		$provinces = $this->area->regionModel->select("*", "parentid=1");
		$citys = $this->area->regionModel->select('*', "parentid=" . $area['provice_id']);
		$areas = $this->area->regionModel->select('*', "parentid=" . $area['city_id']);
//      var_dump($areas);exit;
		//客户类型
		$sql = "select id,title from crm_yixiangusertype ";
		$usertype = $this->crm->memberModel->fetchAll($sql);
		//客户经理
		$sql = "select id,name from system_admin ";
		$admin = $this->crm->memberModel->fetchAll($sql);
		//回访日志
		$sql = "select * from crm_memberlog where memberid=" . $id;
		$log = $this->crm->memberlogModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 保存客户
	 */
	public function updatecustomer() {
		$this->loadModel('crm', 'member');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$data = $_POST['data'];
		$re = $this->crm->memberModel->update($data, 'id=' . $id);
		if ($re) {
			ajaxReturn('', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	/*
	 * 删除客户
	 */
	public function delcustomer() {

		$this->loadHelper('extend');
		$id = $_GET['id'];
		$this->loadModel('crm', 'member');
		$re = $this->crm->memberModel->delete($id);
		if ($re) {
			ajaxReturn('', '删除成功', 1);exit;
		} else {
			ajaxReturn('', '删除失败', 0);exit;
		}
	}
	/**
	 * 供应商类型列表
	 */
	public function supplytype() {
		$this->leftpos = 2;
		$this->pos = 1;
		$this->loadModel('crm', 'supplytype');
		$sql = "select * from crm_supplytype ";
		$re = $this->crm->supplytypeModel->fetchAll($sql);
		//include $this->loadWidget('amdinlteTheme');
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 添中供应商类型
	 */
	public function addsupplytype() {
		$this->leftpos = 2;
		$this->pos = 1;
		$this->loadModel('crm', 'supplytype');
		include $this->loadWidget('amdinlteTheme');

	}
	/**
	 * 插入供应商类型
	 */
	public function insertsupplytype() {
		$this->loadModel('crm', 'supplytype');
		$this->loadHelper('extend');
		//$id=$_POST['id'];
		$data = $_POST['data'];
		
		$re = $this->crm->supplytypeModel->insert($data);
		if ($re) {
			ajaxReturn('', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	/**
	 * 编辑供应商类型
	 */
	public function editsupplytype() {
		$this->leftpos = 2;
		$this->pos = 1;
		$this->loadModel('crm', 'supplytype');

		$id = $_GET['id'];
		$sql = "select * from crm_supplytype where id=$id";
		$re = $this->crm->supplytypeModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 保存客户型弄
	 */
	public function updatesupplytype() {
		$this->loadModel('crm', 'supplytype');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$data = $_POST['data'];
		$re = $this->crm->supplytypeModel->update($data, 'id=' . $id);
		if ($re) {
			ajaxReturn('', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	/*
	 * 删除供应商类型
	 */
	public function delsupplytype() {
		$this->loadHelper('extend');
		$id = $_GET['id'];
		$this->loadModel('crm', 'supplytype');
		$re = $this->crm->supplytypeModel->delete($id);
		if ($re) {
			ajaxReturn('', '删除成功', 1);exit;
		} else {
			ajaxReturn('', '删除失败', 0);exit;
		}
	}

	/**
	 * 供应商列表
	 */
	public function supply() {
		$this->leftpos = 5;
		$this->loadModel('crm', 'supplier');
		$sql = "select cs.*,ce.title as typename from crm_supplier as cs left join crm_supplytype as ce on ce.id=cs.type ";
		$re = $this->crm->supplierModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 添中供应商
	 */
	public function addsupply() {
		$this->leftpos = 5;
		$this->loadModel('crm', 'supplier');
		//供应商类型
		$sql = "select id,title from crm_supplytype ";
		$supplytype = $this->crm->supplierModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 插入供应商
	 */
	public function insertsupply() {
		$this->loadModel('crm', 'supplier');
		$this->loadHelper('extend');
		//$id=$_POST['id'];
		$data = $_POST['data'];

		//查看用户名存不存在
	/* 	$sql = "select id from crm_supplier where account='" . $data['account'] . "'";
		$check = $this->crm->supplierModel->fetchRow($sql);
		if ($check) {
			ajaxReturn('', '该用户名已存在', 0);exit;
		} */
		$data['created']	=	time();
		$re = $this->crm->supplierModel->insert($data);
		if ($re) {
			ajaxReturn('', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	/**
	 * 编辑供应商
	 */
	public function editsupply() {
		$this->leftpos = 5;
		$this->loadModel('crm', 'supplier');
		$id = $_GET['id'];
		$sql = "select * from crm_supplier where id=$id";
		$re = $this->crm->supplierModel->fetchRow($sql);
		//供应商类型
		$sql = "select id,title from crm_supplytype ";
		$supplytype = $this->crm->supplierModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 保存客户
	 */
	public function updatesupply() {
		$this->loadModel('crm', 'supplier');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$data = $_POST['data'];

		//查看账号
		/* $sql = "select id from crm_supplier where account='" . $data['account'] . "' and id!=$id";
		$check = $this->crm->supplierModel->fetchRow($sql);
		if ($check) {
			ajaxReturn('', '该用户名已存在', 0);exit;
		} */
		$data = $_POST['data'];
		//$data['created'] = strtotime($_POST['created']);
		$re = $this->crm->supplierModel->update($data, 'id=' . $id);
		if ($re) {
			ajaxReturn('', '操作成功', 0);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	/*
	 * 删除供应商
	 */
	public function delsupply() {
		$this->loadHelper('extend');
		$id = $_GET['id'];
		$this->loadModel('crm', 'supplier');
		$re = $this->crm->supplierModel->delete($id);
		if ($re) {
			ajaxReturn('', '删除成功', 1);exit;
		} else {
			ajaxReturn('', '删除失败', 0);exit;
		}
	}

	//修改加盟店
	public function updateJointrader() {
		$this->loadModel('franchisee', 'alliance');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$data = $_POST['data'];
		//查看有没有填写密码
		if (!empty($data['password'])) {
			if ($data['password'] != $_POST['pwd']) {
				ajaxReturn('', '两次密码不一致', 0);exit;
			}
			$data['password'] = md5($data['password']);
		} else {
			unset($data['password']);
		}
		//查看账号
		$sql = "select id from franchisee_alliance where username='" . $data['username'] . "' and id!=$id";
		$check = $this->franchisee->allianceModel->fetchRow($sql);
		if ($check) {
			ajaxReturn('', '该用户名已存在', 0);exit;
		}
		// $data=$_POST['data'];

		$re = $this->franchisee->allianceModel->update($data, 'id=' . $id);
		if ($re) {
			ajaxReturn('', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	//添加了加盟商之后，给加盟商推消息 financial_synctype
	public function pushtopos($token) {
		$this->loadModel('financial', 'synctype');
		$sql = "insert into financial_synctype(token,keytype) values('" . $token . "','brand'),('" . $token . "','goodscategory')";
		return $this->financial->synctypeModel->sqlexec($sql);
	}
	/*
	 * 供应商重置数据
	 */
	public function refranchisee() {
		$this->loadHelper('extend');
		$token = $_GET['token'];
		$line = $this->pushtoposagain($token);

		if ($line) {
			ajaxReturn('', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}

	//加盟商重装系统后，给加盟商推消息 financial_synctype  resysproduct
	public function pushtoposagain($token) {
		$this->loadModel('financial', 'synctype');
		$sql = "insert into financial_synctype(token,keytype) values('" . $token . "','regoodscategory'),('" . $token . "','regetGoods'),('" . $token . "','reproductontime'),('" . $token . "','resummary'),('" . $token . "','reworker'),('" . $token . "','recharactar'),('" . $token . "','rediscountinfo'),('" . $token . "','regoodsbrand'),('" . $token . "','regoodsgroup'),('" . $token . "','reinstockorder'),('" . $token . "','reinstockorderinfo'),('" . $token . "','reproductdiscount'),('" . $token . "','restockcheck'),('" . $token . "','restockcheckinfo'),('" . $token . "','reuserorder'),('" . $token . "','reuserorderinfo'),('" . $token . "','reorderdingcan'),('" . $token . "','reorderdingcaninfo'),('" . $token . "','refoodcategory')";
		//$sql = "insert into financial_synctype(token,keytype) values('" . $token . "','readdcard'),('" . $token . "','regoodscategory'),('" . $token . "','regetGoods'),('" . $token . "','reproductontime'),('" . $token . "','resummary'),('" . $token . "','reworker'),('" . $token . "','recharactar'),('" . $token . "','rediscountinfo'),('" . $token . "','regoodsbrand'),('" . $token . "','regoodsgroup'),('" . $token . "','reinstockorder'),('" . $token . "','reinstockorderinfo'),('" . $token . "','reproductdiscount'),('" . $token . "','restockcheck'),('" . $token . "','restockcheckinfo'),('" . $token . "','reuserorder'),('" . $token . "','reuserorderinfo'),('" . $token . "','reorderdingcan'),('" . $token . "','reorderdingcaninfo'),('" . $token . "','refoodcategory')";

		return $this->financial->synctypeModel->sqlexec($sql);
	}

}