<?php

/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */

class newcash extends actionAbstract {
	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 5;
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
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			//ajax request
			$this->checkpower();
		}
	}
	//采购列表
	public function apply() {
		$this->pos = 6;
		$this->loadModel('product', 'apply');
		$sql = "select pa.*,sa.name as cgname,zg.name as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid order by pa.id desc ";
		$re = $this->product->applyModel->fetchAll($sql);
		$sysconf = $this->loadConfig('sysconf');
		include $this->loadWidget('amdinlteTheme');
	}
	//添加采购申请
	public function addapply() {
		$this->pos = 6;
		$this->loadModel('system', 'admin');
		$sql = "select * from  system_admin where status=1";
		$admin = $this->system->adminModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//插入采购申请
	public function insertapply() {
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applyprofile');
		$this->loadHelper('extend');
		$this->loadModel('product', 'locked');
		$lock = $this->product->lockedModel->fetchRow("select * from product_locked where id=1");
		if ($lock['islocked'] == 1) {
			ajaxReturn('', '库房已锁定,正在进行调拨处理!请稍后再试', 0);exit;
		}
		//$id=$_POST['id'];
		$data = $_POST['data'];
		$data['remark'] = $_POST['remark'];
		$data['memberid'] = $this->info['id'];

		$data['uuid'] = 'uuid()';
		$data['created'] = time();
		$re = $this->product->applyModel->insert($data);
		if ($re) {
			$d['applyid'] = $re;
			$d['created'] = time();
			$d['truename'] = $this->info['truename'];
			$d['mobile'] = $this->info['mobile'];
			$line = $this->product->applyprofileModel->insert($d);
			if ($line) {
				ajaxReturn('back', '操作成功', 1);exit;
			} else {
				$this->product->applyModel->delete("id=$re");
				ajaxReturn('操作失败', 0);exit;
			}
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	//编辑采购申请
	public function editapply() {
		$this->loadModel('system', 'admin');
		$this->loadModel('product', 'applyprofile');
		$this->loadModel('product', 'apply');
		$sql = "select * from  system_admin where status=1";
		$admin = $this->system->adminModel->fetchAll($sql);

		$id = $_GET['id'];
		$sql = "select pa.*,sa.name as cgname,zg.name as zgname,cgzxr.name as cgzxrname,cs.title as supplytitle,cs.name as supplyname,cs.mobile as supplymobile from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid left join system_admin as cgzxr on cgzxr.id=pa.cgfzrid left join crm_supplier as cs on cs.id=pa.supplyid where pa.id=$id";
		$re = $this->product->applyModel->fetchRow($sql);
		$sql = "select * from product_applyprofile where applyid=$id";
		$otherapply = $this->product->applyprofileModel->fetchRow($sql);
		$sysconf = $this->loadConfig('sysconf');
		//当状态等于3时，采购单需要选择供应商信息
		$supply = null;
		if ($re['status'] == 2) {
			$sql = "select * from crm_supplier ";
			$supply = $this->system->adminModel->fetchAll($sql);
		}
		//查看商品信息
		if ($re['status'] >= 4) {
			//购物车信息
			$sql = "select pa.* from product_applycart as pa left join product_applyplan as plan on plan.id=pa.planid    where plan.applyid=" . $id . " and plan.status=1";

			$goods = $this->system->adminModel->fetchAll($sql);
		}
		//合同信息
		$contract = null;
		if ($re['status'] >= 5) {

			$sql = "select * from product_applycontract where applyid=$id";

			$contract = $this->system->adminModel->fetchAll($sql);

		}
		/* 	if($re['status']>=5){
		$sql	=	"select po.*,pg.title,pg.imgpath,pg.barcode,phs.title as phstitle,ph.title as phtitle from product_orderinfo as po left join product_goods as pg on pg.id=po.goodsid left join product_house as ph on ph.id=po.houseid left join product_housepos as phs on phs.id=po.houseposid where po.applyid=$id";
		$goods	=	$this->system->adminModel->fetchAll($sql);
		}  */

		include $this->loadWidget('amdinlteTheme');
	}
	//审批通过
	public function changestatus1() {
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applyprofile');
		$this->loadHelper('extend');
		$id = $_GET['id'];
		$data['status'] = 2;
		$line = $this->product->applyModel->update($data, "id=$id");
		if ($line) {
			$d['created1'] = time();
			$d['truename1'] = $this->info['truename'];
			$d['mobile1'] = $this->info['mobile'];
			$l = $this->product->applyprofileModel->update($d, "applyid=$id");
			if ($l) {
				ajaxReturn('', '操作成功', 1);exit;
			} else {
				ajaxReturn('', '操作失败', 0);exit;
			}
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}

	//修改采购申请
	public function updateapply() {
		$this->loadModel('product', 'apply');
		$this->loadHelper('extend');
		$data = $_POST['data'];
		$id = $_POST['id'];
		$data['remark'] = $_POST['remark'];
		$line = $this->product->applyModel->update($data, "id=$id");
		if ($line) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}

	//采购计划表表
	public function plan() {
		$applyid = $_GET['id'];
		$planid = isset($_GET['planid']) ? $_GET['planid'] : -1; //-1显示第一条记录，0表示新增，如果为-1且计划表中没有计录，则新增
		$this->loadModel('product', 'apply');
		$sql = "select * from product_apply where id=$applyid";
		$apply = $this->product->applyModel->fetchRow($sql);
		//计划列表

		$sql = "select * from product_applyplan where applyid=$applyid";
		$plan = $this->product->applyModel->fetchAll($sql);
		//具体的采购方案
		$planinfo = null;
		if ($planid == -1) {
			if ($plan) {
				$planid = $plan[0]['id'];
			} else {
				$planid = 0;
			}
		}
		if ($planid > 0) {
			$this->loadModel('product', 'applycart');
			$planinfo = $this->product->applycartModel->fetchAll("select * from product_applycart where planid=$planid");
			//查看总价，商品数，及多少供应商
			$sql = "select sum(allprice) as price from product_applycart where planid=$planid";
			$allprice = $this->product->applycartModel->fetchRow($sql);
			$sql = "select count(distinct barcode) as goodsnum from product_applycart where planid=$planid ";
			$goodsnum = $this->product->applycartModel->fetchRow($sql);
			$sql = "select count(distinct supplyname) as supplynum from product_applycart where planid=$planid ";
			$supplynum = $this->product->applycartModel->fetchRow($sql);

		}
		$sysconf = $this->loadConfig('sysconf');

		include $this->loadWidget('amdinlteTheme');
	}
	//通过商品编码得到商品信息
	public function getGoods() {
		$this->loadHelper('extend');
		$this->loadModel('product', 'goods');
		$barcode = trim($_POST['barcode']);
		$k = trim($_POST['i']);
		$data = array('into' => '', 'state' => 0, 'k' => $k, 're' => array());
		if (empty($barcode)) {
			echo json_encode($data);exit;
		}
		$sql = "select title,specs,uuid,costprice from product_goods where barcode='" . $barcode . "'";
		$re = $this->product->goodsModel->fetchRow($sql);
		if ($re) {
			$data['state'] = 1;
			$data['re'] = $re;
		} else {
			$data['state'] = 0;
		}
		echo json_encode($data);exit;
	}

	//提交计划
	public function insertapplycart() {
		$this->loadModel('product', 'applycart');
		$this->loadModel('product', 'applyplan');
		$this->loadHelper('extend');
		$tag = 0;
		foreach ($_POST['barcode'] as $k => $val) {
			if (empty($val)) {
				continue;
			}

			$tag = 1;
			break;
		}
		if ($tag == 0) {
			ajaxReturn('', '请填写采购商品', 0);exit;
		}
		$applyid = $_POST['applyid'];
		$sql = " select * from product_applyplan where applyid=$applyid order by sort desc ";
		$plan = $this->product->applyplanModel->fetchRow($sql);
		if ($plan) {
			$data['sort'] = $plan['sort'] + 1;
		} else {
			$data['sort'] = 1;
		}

		$data['title'] = '采购计划' . $data['sort'];
		$data['created'] = time();
		$data['applyid'] = $applyid;
		$data['truename'] = $this->info['name'];
		$data['mobile'] = $this->info['mobile'];
		$data['status'] = 0;
		$line = $this->product->applyplanModel->insert($data);
		if ($line) {
			$d['planid'] = $line;
			$d['applyid'] = $applyid;
			$sqlinsert = "insert into product_applycart(applyid,planid,goodsuuid,barcode,title,specs,costprice,number,cashtype,supplyname,allprice) values ";
			$i = 0;
			foreach ($_POST['barcode'] as $k => $val) {
				if (empty($val)) {
					continue;
				}

				if (empty($_POST['number'][$k])) {
					continue;
				}

				$allprice = $_POST['number'][$k] * $_POST['costprice'][$k];

				if ($i == 0) {
					$sqlinsert .= "($applyid,$line,'" . $_POST['goodsuuid'][$k] . "','" . $_POST['barcode'][$k] . "','" . $_POST['title'][$k] . "','" . $_POST['specs'][$k] . "','" . $_POST['costprice'][$k] . "','" . $_POST['number'][$k] . "','" . $_POST['cashtype'][$k] . "','" . $_POST['supplyname'][$k] . "','" . $allprice . "')";
				} else {
					$sqlinsert .= ",($applyid,$line,'" . $_POST['goodsuuid'][$k] . "','" . $_POST['barcode'][$k] . "','" . $_POST['title'][$k] . "','" . $_POST['specs'][$k] . "','" . $_POST['costprice'][$k] . "','" . $_POST['number'][$k] . "','" . $_POST['cashtype'][$k] . "','" . $_POST['supplyname'][$k] . "','" . $allprice . "')";
				}
				$i++;
			}
			if ($i == 0) {
				$this->product->applyplanModel->delete("id=$line");
				ajaxReturn('', '请填写采购商品的数量', 0);exit;
			}

			$l = $this->product->applycartModel->sqlexec($sqlinsert);
			if ($l) {
				$return['info'] = '操作成功';
				$return['state'] = 1;
				$return['data'] = 'url';
				$return['url'] = $this->url('newcash/plan', array('id' => $applyid, 'planid' => $line));
				echo json_encode($return);exit;
			} else {
				$this->product->applyplanModel->delete("id=$line");
				ajaxReturn('', '操作失败', 0);exit;
			}
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	//提交计划，修改申请状态
	public function plantj() {
		$this->loadHelper('extend');
		$this->loadModel('product', 'apply');
		$data['status'] = 3;
		$applyid = $_GET['applyid'];
		$line = $this->product->applyModel->update($data, 'id=' . $applyid);
		if ($line) {
			$this->loadModel('product', 'applyprofile');
			$d['created2'] = time();
			$d['truename2'] = $this->info['truename'];
			$d['mobile2'] = $this->info['mobile'];
			$l = $this->product->applyprofileModel->update($d, "applyid=$applyid");
			if ($l) {
				$url = "http://" . ROOT_URL . "/index.php/iManage/newcash/editapply?id=$applyid";
				$r = array('info' => "操作成功", 'data' => 'url', 'state' => 1, 'url' => $url);
				echo json_encode($r);exit;
			} else {
				$data['status'] = 2;
				$applyid = $_GET['applyid'];
				$line = $this->product->applyModel->update($data, 'id=' . $applyid);
				ajaxReturn('', '操作失败', 0);exit;
			}

		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	//确认计划
	public function plansure() {
		$this->loadHelper('extend');
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applyplan');
		$data['status'] = 4;
		$applyid = $_GET['applyid'];
		$planid = $_GET['planid'];
		$line = $this->product->applyModel->update($data, 'id=' . $applyid);
		if ($line) {
			$plandata['status'] = 1;
			$planline = $this->product->applyplanModel->update($plandata, 'id=' . $planid);
			if ($planline) {
				$this->loadModel('product', 'applyprofile');
				$d['created3'] = time();
				$d['truename3'] = $this->info['truename'];
				$d['mobile3'] = $this->info['mobile'];
				$l = $this->product->applyprofileModel->update($d, "applyid=$applyid");
				if ($l) {
					$url = "http://" . ROOT_URL . "/index.php/iManage/newcash/editapply?id=$applyid";
					$r = array('info' => "操作成功", 'data' => 'url', 'state' => 1, 'url' => $url);
					echo json_encode($r);exit;
				} else {
					$data['status'] = 3;
					$applyid = $_GET['applyid'];
					$line = $this->product->applyModel->update($data, 'id=' . $applyid);
					$plandata['status'] = 0;
					$planline = $this->product->applyplanModel->update($plandata, 'id=' . $planid);
					ajaxReturn('', '操作失败', 0);exit;
				}
			} else {
				$data['status'] = 3;
				$applyid = $_GET['applyid'];
				$line = $this->product->applyModel->update($data, 'id=' . $applyid);
				ajaxReturn('', '操作失败', 0);exit;

			}

		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}

	}

	//提交合同
	public function addContract() {
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applycontract');
		$sysconf = $this->loadConfig('sysconf');
		$applyid = $_GET['applyid'];
		//加盟商信息
		$sql = "select pa.id,pa.title,pa.status,plan.id as planid from product_apply as pa left join product_applyplan as plan on plan.applyid=pa.id where pa.id=$applyid and plan.status=1";

		$apply = $this->product->applyModel->fetchRow($sql);
		//查看该采购中的加盟商
		$sql = "select * from product_applycontract where applyid=$applyid";
		$contract = $this->product->applycontractModel->fetchAll($sql);
		if (!$contract) {
			//第一次进入，须初始化表，将该采购中的供应商名称加入到表里
			$sql = "select supplyname from product_applycart where applyid=$applyid and planid=" . $apply['planid'] . " group by supplyname";
			$r = $this->product->applycontractModel->fetchAll($sql);

			if ($r) {
				$insertsql = "insert into product_applycontract(applyid,supplyname) values";
				foreach ($r as $k => $val) {
					if ($k == 0) {
						$insertsql .= "(" . $applyid . ",'" . $val['supplyname'] . "')";
					} else {
						$insertsql .= ",(" . $applyid . ",'" . $val['supplyname'] . "')";
					}
				}
				$this->product->applycontractModel->sqlexec($insertsql);
				//查看该采购中的加盟商
				$sql = "select * from product_applycontract where applyid=$applyid";
				$contract = $this->product->applycontractModel->fetchAll($sql);
			}
		}

		include $this->loadWidget('amdinlteTheme');
	}
	//提交合同-界面
	public function contracttj() {
		$this->loadModel('product', 'applycontract');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		if (!empty($_FILES['files' . $id]['name'])) {
			$this->loadHelper('uploader');
			$uploader = new uploader();
			$odata['contractpath'] = $uploader->start('files' . $id);
			$odata['contracttitle'] = $_FILES['files' . $id]['name'];
		} /* else{
		ajaxReturn ( '', '未提交合同信息', 0 );
		} */
		$odata['truename'] = $this->info['truename'];
		$odata['created'] = time();
		$odata['remark'] = $_POST['remark' . $id];

		$line = $this->product->applycontractModel->update($odata, "id=$id");
		if ($line) {
			ajaxReturn('', '提交成功', 1);
		} else {
			ajaxReturn('', '提交失败', 0);
		}

	}
	//提交合同
	public function contractover() {
		$this->loadHelper('extend');
		$this->loadModel('product', 'apply');
		$data['status'] = 5;
		$applyid = $_GET['applyid'];
		$line = $this->product->applyModel->update($data, 'id=' . $applyid);
		if ($line) {
			$this->loadModel('product', 'applyprofile');
			$d['created4'] = time();
			$d['truename4'] = $this->info['truename'];
			$d['mobile4'] = $this->info['mobile'];
			$l = $this->product->applyprofileModel->update($d, "applyid=$applyid");
			if ($l) {
				$url = "http://" . ROOT_URL . "/index.php/iManage/newcash/editapply?id=$applyid";
				$r = array('info' => "操作成功", 'data' => 'url', 'state' => 1, 'url' => $url);
				echo json_encode($r);exit;
			} else {
				$data['status'] = 4;
				$applyid = $_GET['applyid'];
				$line = $this->product->applyModel->update($data, 'id=' . $applyid);
				ajaxReturn('', '操作失败', 0);exit;
			}

		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}

	}
	//合同确认
	public function contractsure() {
		$this->loadHelper('extend');
		$this->loadModel('product', 'apply');
		$data['status'] = 6;
		$applyid = $_GET['id'];
		$line = $this->product->applyModel->update($data, 'id=' . $applyid);
		if ($line) {
			$this->loadModel('product', 'applyprofile');
			$d['created5'] = time();
			$d['truename5'] = $this->info['truename'];
			$d['mobile5'] = $this->info['mobile'];
			$l = $this->product->applyprofileModel->update($d, "applyid=$applyid");
			if ($l) {
				$url = "http://" . ROOT_URL . "/index.php/iManage/newcash/editapply?id=$applyid";
				$r = array('info' => "操作成功", 'data' => 'url', 'state' => 1, 'url' => $url);
				echo json_encode($r);exit;
			} else {
				$data['status'] = 5;
				$applyid = $_GET['applyid'];
				$line = $this->product->applyModel->update($data, 'id=' . $applyid);
				ajaxReturn('', '操作失败', 0);exit;
			}

		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}

	}
	//财务信息录入-是否支付定金
	public function financeinfo() {
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applycontract');
		$sysconf = $this->loadConfig('sysconf');
		$applyid = $_GET['id'];
		//加盟商信息
		$sql = "select pa.id,pa.title,pa.status,plan.id as planid from product_apply as pa left join product_applyplan as plan on plan.applyid=pa.id where pa.id=$applyid and plan.status=1";
		$apply = $this->product->applyModel->fetchRow($sql);
		//查看该采购中的加盟商
		$sql = "select * from product_applycontract where applyid=$applyid";
		$contract = $this->product->applycontractModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');
	}
	//财务信息录入
	public function financeinfoupdate() {
		$this->loadModel('product', 'applycontract');
		$this->loadHelper('extend');
		$idarray = $_POST['id'];
		$applyid = $_POST['applyid'];
		$updatesql = "insert into product_applycontract(id,isdep,depnum) values";
		foreach ($idarray as $k => $val) {
			if (empty($_POST['depnum'][$k])) {$_POST['depnum'][$k] = 0;}
			if ($_POST['isdep'][$k] == 0) {$_POST['depnum'][$k] = 0;}
			if ($k == 0) {
				$updatesql .= "(" . $val . "," . $_POST['isdep'][$k] . ",'" . $_POST['depnum'][$k] . "')";
			} else {
				$updatesql .= ",(" . $val . "," . $_POST['isdep'][$k] . ",'" . $_POST['depnum'][$k] . "')";
			}

		}
		$updatesql .= "ON DUPLICATE KEY UPDATE isdep=values(isdep),depnum=values(depnum)";
		//echo $updatesql;exit;
		$line = $this->product->applycontractModel->sqlexec($updatesql);
		if ($line) {

			$this->loadModel('product', 'apply');
			$data['status'] = 7;
			$line = $this->product->applyModel->update($data, 'id=' . $applyid);
			if ($line) {
				$this->loadModel('product', 'applyprofile');
				$d['created6'] = time();
				$d['truename6'] = $this->info['truename'];
				$d['mobile6'] = $this->info['mobile'];
				$l = $this->product->applyprofileModel->update($d, "applyid=$applyid");
				if ($l) {
					$url = "http://" . ROOT_URL . "/index.php/iManage/newcash/editapply?id=$applyid";
					$r = array('info' => "操作成功", 'data' => 'url', 'state' => 1, 'url' => $url);
					echo json_encode($r);exit;
				} else {
					$data['status'] = 6;

					$line = $this->product->applyModel->update($data, 'id=' . $applyid);
					ajaxReturn('', '操作失败', 0);exit;
				}

			} else {
				ajaxReturn('', '操作失败', 0);exit;
			}

			$url = "http://" . ROOT_URL . "/index.php/iManage/newcash/editapply?id=$applyid";
			$re = array('state' => 1, 'info' => '操作成功', 'data' => 'url', 'url' => $url);
			echo json_encode($re);exit;
		} else {

			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	//库房验收
	public function storeinfo() {

		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applycontract');
		$sysconf = $this->loadConfig('sysconf');
		$applyid = $_GET['id'];
		//加盟商信息
		$sql = "select pa.id,pa.title,pa.status,plan.id as planid from product_apply as pa left join product_applyplan as plan on plan.applyid=pa.id where pa.id=$applyid and plan.status=1";
		$apply = $this->product->applyModel->fetchRow($sql);
		//查看该采购中的加盟商
		$sql = "select * from product_applycontract where applyid=$applyid";
		$contract = $this->product->applycontractModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');

	}
	//库房验收结果
	public function storeupdate() {
		$this->loadModel('product', 'applycontract');
		$this->loadHelper('extend');
		$idarray = $_POST['id'];
		$applyid = $_POST['applyid'];
		$updatesql = "insert into product_applycontract(id,contractpath,contracttitle,isproblem) values";
		$tag = false;
		foreach ($idarray as $k => $val) {
			if ($_POST['isproblem'][$k] != -1) {$tag = true;}
			if ($_POST['isproblem'][$k] == 0) {
				if (!empty($_FILES['files' . $val]['name'])) {
					$this->loadHelper('uploader');
					$uploader = new uploader();
					$_POST['contractpath'][$k] = $uploader->start('files' . $val);
					$_POST['contracttitle'][$k] = $_FILES['files' . $val]['name'];
				} else {
					ajaxReturn('', '未提交新的合同信息', 0);
				}
			}
			if ($k == 0) {
				$updatesql .= "(" . $val . ",'" . $_POST['contractpath'][$k] . "','" . $_POST['contracttitle'][$k] . "'," . $_POST['isproblem'][$k] . ")";
			} else {
				$updatesql .= ",(" . $val . ",'" . $_POST['contractpath'][$k] . "','" . $_POST['contracttitle'][$k] . "'," . $_POST['isproblem'][$k] . ")";
			}

		}
		$updatesql .= "ON DUPLICATE KEY UPDATE contractpath=values(contractpath),contracttitle=values(contracttitle),isproblem=values(isproblem)";
		//echo $updatesql;exit;
		$line = $this->product->applycontractModel->sqlexec($updatesql);
		if ($line) {

			$this->loadModel('product', 'apply');
			if ($tag) {
				$data['status'] = 8;
			} else {
				$data['status'] = -2;
			}
			$line = $this->product->applyModel->update($data, 'id=' . $applyid);
			if ($line) {
				$this->loadModel('product', 'applyprofile');
				$d['created7'] = time();
				$d['truename7'] = $this->info['truename'];
				$d['mobile7'] = $this->info['mobile'];
				$l = $this->product->applyprofileModel->update($d, "applyid=$applyid");
				if ($l) {
					$url = "http://" . ROOT_URL . "/index.php/iManage/newcash/editapply?id=$applyid";
					$r = array('info' => "操作成功", 'data' => 'url', 'state' => 1, 'url' => $url);
					echo json_encode($r);exit;
				} else {
					$data['status'] = 7;

					$line = $this->product->applyModel->update($data, 'id=' . $applyid);
					ajaxReturn('', '操作失败', 0);exit;
				}

			} else {
				ajaxReturn('', '操作失败', 0);exit;
			}

			$url = "http://" . ROOT_URL . "/index.php/iManage/newcash/editapply?id=$applyid";
			$re = array('state' => 1, 'info' => '操作成功', 'data' => 'url', 'url' => $url);
			echo json_encode($re);exit;
		} else {

			ajaxReturn('', '操作失败', 0);exit;
		}

	}
	//采购执行确认
	public function applychangestatus8() {
		$this->loadHelper('extend');
		$this->loadModel('product', 'apply');
		$data['status'] = 9;
		$applyid = $_GET['id'];
		$line = $this->product->applyModel->update($data, 'id=' . $applyid);
		if ($line) {
			$this->loadModel('product', 'applyprofile');
			$d['created8'] = time();
			$d['truename8'] = $this->info['truename'];
			$d['mobile8'] = $this->info['mobile'];
			$l = $this->product->applyprofileModel->update($d, "applyid=$applyid");
			if ($l) {
				$url = "http://" . ROOT_URL . "/index.php/iManage/newcash/editapply?id=$applyid";
				$r = array('info' => "操作成功", 'data' => 'url', 'state' => 1, 'url' => $url);
				echo json_encode($r);exit;
			} else {
				$data['status'] = 8;
				$applyid = $_GET['applyid'];
				$line = $this->product->applyModel->update($data, 'id=' . $applyid);
				ajaxReturn('', '操作失败', 0);exit;
			}

		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}

	}
	//财务付尾款
	public function paytail() {
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applycontract');
		$sysconf = $this->loadConfig('sysconf');
		$applyid = $_GET['id'];
		//加盟商信息
		$sql = "select pa.id,pa.title,pa.status,plan.id as planid from product_apply as pa left join product_applyplan as plan on plan.applyid=pa.id where pa.id=$applyid and plan.status=1";
		$apply = $this->product->applyModel->fetchRow($sql);
		//查看该采购中的加盟商
		$sql = "select * from product_applycontract where applyid=$applyid and isproblem!=-1 ";
		$contract = $this->product->applycontractModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');

	}
	//尾款提交
	public function paytailupdate() {
		$this->loadModel('product', 'applycontract');
		$this->loadHelper('extend');
		$idarray = $_POST['id'];
		$applyid = $_POST['applyid'];
		$updatesql = "insert into product_applycontract(id,tailmoney) values";
		foreach ($idarray as $k => $val) {
			if (empty($_POST['tailmoney'][$k])) {$_POST['tailmoney'][$k] = 0;}

			if ($k == 0) {
				$updatesql .= "(" . $val . ",'" . $_POST['tailmoney'][$k] . "')";
			} else {
				$updatesql .= ",(" . $val . ",'" . $_POST['tailmoney'][$k] . "')";
			}

		}
		$updatesql .= "ON DUPLICATE KEY UPDATE tailmoney=values(tailmoney)";
		//echo $updatesql;exit;
		$line = $this->product->applycontractModel->sqlexec($updatesql);
		if ($line) {

			$this->loadModel('product', 'apply');
			$data['status'] = 10;
			$line = $this->product->applyModel->update($data, 'id=' . $applyid);
			if ($line) {
				$this->loadModel('product', 'applyprofile');
				$d['created9'] = time();
				$d['truename9'] = $this->info['truename'];
				$d['mobile9'] = $this->info['mobile'];
				$l = $this->product->applyprofileModel->update($d, "applyid=$applyid");
				if ($l) {
					$url = "http://" . ROOT_URL . "/index.php/iManage/newcash/editapply?id=$applyid";
					$r = array('info' => "操作成功", 'data' => 'url', 'state' => 1, 'url' => $url);
					echo json_encode($r);exit;
				} else {
					$data['status'] = 9;

					$line = $this->product->applyModel->update($data, 'id=' . $applyid);
					ajaxReturn('', '操作失败', 0);exit;
				}

			} else {
				ajaxReturn('', '操作失败', 0);exit;
			}
		} else {

			ajaxReturn('', '操作失败', 0);exit;
		}

	}
	//财务核价
	public function checkgoodsprice() {
		$applyid = $_GET['id'];
		$planid = isset($_GET['planid']) ? $_GET['planid'] : -1; //-1显示第一条记录，0表示新增，如果为-1且计划表中没有计录，则新增
		$this->loadModel('product', 'apply');
		$sql = "select * from product_apply where id=$applyid";
		$apply = $this->product->applyModel->fetchRow($sql);
		//计划列表

		$sql = "select * from product_applyplan where applyid=$applyid";
		$plan = $this->product->applyModel->fetchAll($sql);
		//具体的采购方案
		$planinfo = null;
		if ($planid == -1) {
			if ($plan) {
				$planid = $plan[0]['id'];
			} else {
				$planid = 0;
			}
		}
		if ($planid > 0) {
			$this->loadModel('product', 'applycart');
			$planinfo = $this->product->applycartModel->fetchAll("select * from product_applycart where planid=$planid");
			//查看总价，商品数，及多少供应商
			$sql = "select sum(allprice) as price from product_applycart where planid=$planid";
			$allprice = $this->product->applycartModel->fetchRow($sql);
			$sql = "select count(distinct barcode) as goodsnum from product_applycart where planid=$planid ";
			$goodsnum = $this->product->applycartModel->fetchRow($sql);
			$sql = "select count(distinct supplyname) as supplynum from product_applycart where planid=$planid ";
			$supplynum = $this->product->applycartModel->fetchRow($sql);

		}
		$sysconf = $this->loadConfig('sysconf');

		include $this->loadWidget('amdinlteTheme');

	}
	//提交商品进价，售价等
	public function updategoodsprice() {
		$this->loadModel('product', 'applycart');
		$this->loadModel('product', 'applyplan');
		$this->loadHelper('extend');
		$applyid = $_POST['applyid'];
		$d['applyid'] = $applyid;
		$sqlinsert = "insert into product_applycart(id,costprice,saleprice,futureprice) values ";
		$i = 0;
		foreach ($_POST['id'] as $k => $val) {
			$_POST['costprice'][$k] = empty($_POST['costprice'][$k]) ? 0 : $_POST['costprice'][$k];
			$_POST['saleprice'][$k] = empty($_POST['saleprice'][$k]) ? 0 : $_POST['saleprice'][$k];
			$_POST['futureprice'][$k] = empty($_POST['futureprice'][$k]) ? 0 : $_POST['futureprice'][$k];
			if ($i == 0) {
				$sqlinsert .= "($val,'" . $_POST['costprice'][$k] . "','" . $_POST['saleprice'][$k] . "','" . $_POST['futureprice'][$k] . "')";
			} else {
				$sqlinsert .= ",($val,'" . $_POST['costprice'][$k] . "','" . $_POST['saleprice'][$k] . "','" . $_POST['futureprice'][$k] . "')";
			}
			$i++;
		}
		$sqlinsert .= "ON DUPLICATE KEY UPDATE costprice=values(costprice),saleprice=values(saleprice),futureprice=values(futureprice)";
		$l = $this->product->applycartModel->sqlexec($sqlinsert);
		if ($l) {
			$this->loadModel('product', 'apply');
			$data['status'] = 11;
			$line = $this->product->applyModel->update($data, 'id=' . $applyid);
			if ($line) {
				$this->loadModel('product', 'applyprofile');
				$d['created10'] = time();
				$d['truename10'] = $this->info['truename'];
				$d['mobile10'] = $this->info['mobile'];
				$l = $this->product->applyprofileModel->update($d, "applyid=$applyid");
				if ($l) {
					$url = "http://" . ROOT_URL . "/index.php/iManage/newcash/editapply?id=$applyid";
					$r = array('info' => "操作成功", 'data' => 'url', 'state' => 1, 'url' => $url);
					echo json_encode($r);exit;
				} else {
					$data['status'] = 10;

					$line = $this->product->applyModel->update($data, 'id=' . $applyid);
					ajaxReturn('', '操作失败', 0);exit;
				}

			} else {
				ajaxReturn('', '操作失败', 0);exit;
			}
		} else {
			$this->product->applyplanModel->delete("id=$line");
			ajaxReturn('', '操作失败', 0);exit;
		}

	}
	//确认入库
	public function applyover() {

		$this->loadHelper('extend');
		$this->loadModel('product', 'apply');
		$applyid = $_GET['id'];
		$data['status'] = 12;
		$line = $this->product->applyModel->update($data, 'id=' . $applyid);
		if ($line) {
			$this->loadModel('product', 'applyprofile');
			$d['created11'] = time();
			$d['truename11'] = $this->info['truename'];
			$d['mobile11'] = $this->info['mobile'];
			$l = $this->product->applyprofileModel->update($d, "applyid=$applyid");
			if ($l) {
				$url = "http://" . ROOT_URL . "/index.php/iManage/newcash/editapply?id=$applyid";
				$r = array('info' => "操作成功", 'data' => 'url', 'state' => 1, 'url' => $url);
				echo json_encode($r);exit;
			} else {
				$data['status'] = 11;

				$line = $this->product->applyModel->update($data, 'id=' . $applyid);
				ajaxReturn('', '操作失败', 0);exit;
			}

		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}

	}

}
?>