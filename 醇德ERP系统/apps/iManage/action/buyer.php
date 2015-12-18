<?php

/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */

class buyer extends actionAbstract {
	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 5;
	public $type = 0;
	public $leftpos = 0;
	public $where = '';
	public $sysconf = array();
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
		// $this->info = acl::checkLogin('admininfo',$this->url('common/login'));

		if (!isset($_SESSION['admininfo'])) {header('location:' . $this->url('common/login'));}$this->info = $_SESSION['admininfo'];
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		$this->sysconf = $this->loadConfig('sysconf');
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			//ajax request
			$this->checkpower();
		}
	}
	//采购计划列表
	public function pubapply() {
		$this->pos = 6;
		$this->loadModel('product', 'apply');
		$sql = "select pa.*,sa.truename as cgname,zg.truename as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid where pa.memberid=" . $this->info['id'] . " or pa.zgid=" . $this->info['id'] . " order by pa.id desc ";
		$re = $this->product->applyModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');
	}
	//查看已完成采购商品
	public function getourgoods(){
		$this->loadModel('product', 'apply');
	
	}
	//编辑采购计划
	public function editpubapply() {
		$this->loadModel('system', 'admin');
		$this->loadModel('product', 'applydata');
		$this->loadModel('product', 'apply');
		$sql = "select * from  system_admin where status=1";
		$admin = $this->system->adminModel->fetchAll($sql);

		$id = $_GET['id'];
		$sql = "select pa.*,sa.truename as cgname,zg.truename as zgname,cgzxr.truename as cgzxrname,cs.title as supplytitle,cs.name as supplyname,cs.mobile as supplymobile from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid left join system_admin as cgzxr on cgzxr.id=pa.cgfzrid left join crm_supplier as cs on cs.id=pa.supplyid where pa.id=$id";
		$re = $this->product->applyModel->fetchRow($sql);
		//查看商品信息
		if ($re['status'] >= 3) {
			//购物车信息
			$sql = "select pa.*,ss.title as supplyname from product_applycart as pa left join crm_supplier as ss on ss.id=pa.supplyid where pa.applyid=$id and pa.status=1 order by pa.id asc ";
			$goods = $this->system->adminModel->fetchAll($sql);
		}
		$contract = ''; //合同
		//操作记录
		$sql = "select * from product_applydata where applyid=" . $id;
		$log = $this->product->applydataModel->fetchAll($sql);
		//按时间重新组合日志  --开始
		$logs = array();
		foreach ($log as $k => $val) {
			$logs[date("Y-m-d", $val['created'])][] = $val;
		}
		include $this->loadWidget('amdinlteTheme');
	}
	//采购列表
	public function apply() {
		$this->pos = 6;
		$this->loadModel('product', 'apply');
		$sql = "select pa.*,sa.truename as cgname,zg.truename as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid where pa.memberid=" . $this->info['id'] . " or pa.zgid=" . $this->info['id'] . " order by pa.id desc ";
		$re = $this->product->applyModel->fetchAll($sql);

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
		$this->loadModel('product', 'applydata');
		$this->loadHelper('extend');
		$this->loadModel('product', 'locked');

		//$id=$_POST['id'];
		$data = $_POST['data'];
		$ordernum = date("ymdhis") . substr(uniqid(rand()), -6);
		$data['ordernum'] = $ordernum;
		$data['remark'] = $_POST['remark'];
		$data['memberid'] = $this->info['id'];

		$data['uuid'] = 'uuid()';
		$data['created'] = time();
		$re = $this->product->applyModel->insert($data);
		if ($re) {
			$d['applyid'] = $re;
			$d['created'] = time();
			$d['truename'] = $this->info['truename'];
			$d['results'] = "添加采购申请单";
			$line = $this->product->applydataModel->insert($d);
			if ($line) {
				$this->tezhisendmessage($re, 1);
				$url = "http://" . ROOT_URL . "/index.php/iManage/buyer/pubapply";
				$dt = array('state' => 1, 'info' => '操作成功', 'data' => 'url', 'url' => $url);
				echo json_encode($dt);exit;
				//  ajaxReturn ( 'url', '操作成功', 1 );exit;
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
		$this->loadModel('product', 'applydata');
		$this->loadModel('product', 'apply');
		$sql = "select * from  system_admin where status=1";
		$admin = $this->system->adminModel->fetchAll($sql);

		$id = $_GET['id'];
		$sql = "select pa.*,sa.truename as cgname,zg.truename as zgname,cgzxr.truename as cgzxrname,cs.title as supplytitle,cs.name as supplyname,cs.mobile as supplymobile from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid left join system_admin as cgzxr on cgzxr.id=pa.cgfzrid left join crm_supplier as cs on cs.id=pa.supplyid where pa.id=$id";
		$re = $this->product->applyModel->fetchRow($sql);
		//查看商品信息
		if ($re['status'] >= 3) {
			//购物车信息
			$sql = "select pa.*,ss.title as supplyname from product_applycart as pa left join crm_supplier as ss on ss.id=pa.supplyid where pa.applyid=$id and pa.status=1 order by pa.id asc ";
			$goods = $this->system->adminModel->fetchAll($sql);
		}
		$contract = ''; //合同
		//操作记录
		$sql = "select * from product_applydata where applyid=" . $id;
		$log = $this->product->applydataModel->fetchAll($sql);
		//按时间重新组合日志  --开始
		$logs = array();
		foreach ($log as $k => $val) {
			$logs[date("Y-m-d", $val['created'])][] = $val;
		}
		include $this->loadWidget('amdinlteTheme');
	}
	//申请人确认---库房验货后
	public function applyersure() {
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applydata');
		$this->loadModel('product', 'applystoreplan');
		$this->loadHelper('extend');
		$planid = $_POST['planid'];
		$id = $_POST['applyid'];
		$remark = $_POST['remark'];
		if(empty($remark)){
		ajaxReturn('', '请填写备注', 0);exit;
		}
		$datas['status'] = 9;
		$datas['sometimenouse'] = time();

		$line = $this->product->applyModel->update($datas, "id=$id");
		if ($line) {
			//采购人员的备注信息
			$dd['applyremark'] = $remark;
			$dd['sometimenouse'] = time();
			$dd['status'] = 3;
			$this->product->applystoreplanModel->update($dd, "id=$planid");

			$d['results'] = "采购申请人员确认";
			$d['created'] = time();
			$d['truename'] = $this->info['truename'];
			$d['remark'] = $remark;
			$d['applyid'] = $id;
			$l = $this->product->applydataModel->insert($d);
			if ($l) {
				$this->sendemailandmessage($id, 9);
				ajaxReturn('', '操作成功', 1);exit;
			} else {
				ajaxReturn('', '操作失败', 0);exit;
			}
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}

	}
	//采购经理确认---库房验货后
	public function applyersurejl() {
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applydata');
		$this->loadModel('product', 'applystoreplan');
		$this->loadHelper('extend');

		$id = $_POST['applyid'];
		$remark = $_POST['remark'];

		$datas['status'] = 4;
		$datas['sometimenouse'] = time();

		$line = $this->product->applyModel->update($datas, "id=$id");
		if ($line) {

			$d['results'] = "采购申请人员确认";
			$d['created'] = time();
			$d['truename'] = $this->info['truename'];
			$d['remark'] = $remark;
			$d['applyid'] = $id;
			$l = $this->product->applydataModel->insert($d);
			if ($l) {
				//$this->sendemailandmessage($id, 4);
				$this->tezhisendmessage($id, 4,'makeplanuserid');
				ajaxReturn('', '操作成功', 1);exit;
			} else {
				ajaxReturn('', '操作失败', 0);exit;
			}
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}

	}
	//审批通过
	public function changestatus1() {
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applydata');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$d = $_POST['data'];
		if ($d['results'] == 1) {
			$datas['status'] = 2;
			$d['results'] = "审批人审核通过";
		} else {
			$datas['status'] = -1;
			$d['results'] = "审批人取消采购";
		}
		$line = $this->product->applyModel->update($datas, "id=$id");
		if ($line) {

			$d['created'] = time();
			$d['truename'] = $this->info['truename'];
			// $d['remark']		=	$_POST['remark'];
			$d['applyid'] = $id;
			$l = $this->product->applydataModel->insert($d);
			if ($l) {
			if($datas['status']==2){
				$this->sendemailandmessage($id, $datas['status']);
				
				}else{
				$this->tezhisendmessage($id, $datas['status'],'memberid');
				}
				ajaxReturn('', '操作成功', 1);exit;
			} else {
				ajaxReturn('', '操作失败', 0);exit;
			}
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}

/* 	//修改采购申请
public function updateapply(){
$this->loadModel('product','apply');
$this->loadHelper('extend');
$data=$_POST['data'];
$id	=	$_POST['id'];
$data['remark']	=	$_POST['remark'];
$line	=	$this->product->applyModel->update($data,"id=$id");
if($line){
ajaxReturn ( 'back', '操作成功', 1 );exit;
}else{
ajaxReturn ( '','操作失败', 0);exit;
}
} */
	//采购列表--采购部门
	public function applycaigou() {
		$this->pos = 6;
		$this->loadModel('product', 'apply');
		//$sql = "select pa.*,sa.truename as cgname,zg.truename as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid where pa.status>=2 or pa.memberid=" . $this->info['id'] . " or pa.zgid=" . $this->info['id'] . " order by pa.id desc ";
		$sql = "select pa.*,sa.truename as cgname,zg.truename as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid where pa.status>=2  order by pa.id desc ";
		$re = $this->product->applyModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');
	}
	//编辑采购申请--采购部门详情
	public function editapplycaigou() {
		$this->loadModel('system', 'admin');
		$this->loadModel('product', 'applydata');
		$this->loadModel('product', 'apply');

		$id = $_GET['id'];
		$sql = "select pa.*,sa.truename as cgname,zg.truename as zgname,cgzxr.truename as cgzxrname,cs.title as supplytitle,cs.name as supplyname,cs.mobile as supplymobile from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid left join system_admin as cgzxr on cgzxr.id=pa.cgfzrid left join crm_supplier as cs on cs.id=pa.supplyid where pa.id=$id";
		$re = $this->product->applyModel->fetchRow($sql);
		//查看商品信息
		if ($re['status'] >= 3) {
			//购物车信息
			$sql = "select pa.*,ss.title as supplyname from product_applycart as pa left join crm_supplier as ss on ss.id=pa.supplyid where pa.applyid=$id and pa.status=1 order by pa.id asc ";
			$goods = $this->system->adminModel->fetchAll($sql);
			
		}
		if ($re['status'] == 3) {
			$sql = "select id from product_applycontract  where applyid=$id";
			$c = $this->system->adminModel->fetchRow($sql);
			
			if(!$c){
				$this->addContract($id);
			}
		}
		$contract = array(); //合同
		if ($re['status'] >= 4) {
			$sql = "select pa.*,ss.title as supplyname from product_applycontract as pa left join crm_supplier as ss on ss.id=pa.supplyid where pa.applyid=$id";
			$contract = $this->system->adminModel->fetchRow($sql);
			//查询商品信息
			/* foreach ($contract as $k => $v) {
				$sql = "select title from product_applycart where status=1 and supplyid=" . $v['supplyid'] . " and applyid=" . $id;
				$res = $this->system->adminModel->fetchAll($sql);
				$contract[$k]['goods'] = $res;
			} */
			if(!$contract){
			$contract=$this->addContract($id);
			}
			//var_dump($contract);exit;
		}
		
		
		/* if ($re['status'] >= 6) {
			$sql = "select pa.*,ss.title as supplyname from product_applycontract as pa left join crm_supplier as ss on ss.id=pa.supplyid where pa.applyid=$id";
			$contract = $this->system->adminModel->fetchAll($sql);
			 //查询商品信息
			foreach ($contract as $k => $v) {
				$sql = "select title from product_applycart where status=1 and supplyid=" . $v['supplyid'] . " and applyid=" . $id;
				$res = $this->system->adminModel->fetchAll($sql);
				$contract[$k]['goods'] = $res;
			} 
		} */
		//操作记录
		$sql = "select * from product_applydata where applyid=" . $id . " order by id desc";
		$log = $this->product->applydataModel->fetchAll($sql);
		//按时间重新组合日志  --开始
		$logs = array();
		foreach ($log as $k => $val) {
			$logs[date("Y-m-d", $val['created'])][] = $val;
		}
		//查看入库计划
		$sql = "select * from product_applystoreplan where ordernum='" . $re['ordernum'] . "'";
		$plan = $this->product->applydataModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//采购计划表表
	public function plan() {

		$applyid = $_GET['id'];
		$planid = isset($_GET['planid']) ? $_GET['planid'] : -1; //-1显示第一条记录，0表示新增，如果为-1且计划表中没有计录，则新增
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applycart');
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
			$planinfo = $this->product->applycartModel->fetchAll("select pa.*,ss.title as supplyname from product_applycart as pa left join crm_supplier as ss on ss.id=pa.supplyid where pa.planid=$planid order by pa.id asc ");
			//查看总价，商品数，及多少供应商
			$sql = "select sum(allprice) as price from product_applycart where planid=$planid  and status=1 ";
			$allprice = $this->product->applycartModel->fetchRow($sql);
			$sql = "select count(distinct barcode) as goodsnum from product_applycart where planid=$planid and status=1";
			$goodsnum = $this->product->applycartModel->fetchRow($sql);
			$sql = "select count(distinct supplyid) as supplynum from product_applycart where planid=$planid ";
			$supplynum = $this->product->applycartModel->fetchRow($sql);
			
		}
		//$sysconf	=	$this->loadConfig('sysconf');
		$edit = isset($_GET['edit']) ? $_GET['edit'] : 0;
		//供应商列表
		$sql = "select * from crm_supplier where status=1";
		$supplier = $this->product->applycartModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');
	}

	//改变加盟商，更改价格
	public function supplychangeprice() {
		$barcode = $_POST['barcode'];
		$supplyid = $_POST['supplyid'];
		$key = $_POST['key'];
		$this->loadModel('product', 'goods');
		$data = array('key' => $key, 'state' => 0, 'price' => '');
		if (empty($barcode)) {
			echo json_encode($data);exit;
		}
		$sql = "select costprice from product_applycart where barcode='" . $barcode . "' and supplyid=" . $supplyid . " and tag=1 order by id desc";
		$re = $this->product->goodsModel->fetchRow($sql);

		if (!$re) {
			echo json_encode($data);exit;
		} else {
			$data['price'] = $re['costprice'];
			$data['state'] = 1;
		}
		echo json_encode($data);exit;
	}

	//查询历史采购商品
	public function historygoods() {
		$keyword = $_POST['keyword'];
		$data = array('state' => 0, 're' => '');
		if (empty($keyword)) {
			echo json_encode($data);exit;
		}
		$where = "pat.barcode like '%" . $keyword . "%' or pat.title like '%" . $keyword . "%' or pat.erpcode like '%" . $keyword . "%'";

		$this->loadModel('product', 'goods');
		$sql = "select pat.*,cs.title as supplyname from product_applycart as pat left join crm_supplier as cs on cs.id=pat.supplyid where " . $where;
		$re = $this->product->goodsModel->fetchAll($sql);

		if ($re) {
			$data['state'] = 1;
			$data['re'] = $re;
		}
		echo json_encode($data);exit;
	}
	//通过商品编码得到商品信息
	public function getGoods() {
		$this->loadHelper('extend');
		$this->loadModel('product', 'goods');
		$erpcode = trim($_POST['erpcode']);
		$k = trim($_POST['i']);
		$data = array('into' => '', 'state' => 0, 'k' => $k, 're' => array());

		if (empty($erpcode)) {
			echo json_encode($data);exit;
		}
		$sql = "select title,specs,uuid,costprice,barcode from product_goods where erpcode='" . $erpcode . "'";
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

		foreach ($_POST['title'] as $k => $val) {
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

		if (!$plan) {
			$data['title'] = '采购计划';
			$data['created'] = time();
			$data['applyid'] = $applyid;
			$data['truename'] = $this->info['truename'];
			$data['mobile'] = $this->info['mobile'];
			$data['status'] = 0;
			$line = $this->product->applyplanModel->insert($data);
		} else {
			$line = $plan['id'];
		}

		if ($line) {
			$d['planid'] = $line;
			$d['applyid'] = $applyid;
			$sqlinsert = "insert into product_applycart(applyid,planid,goodsuuid,erpcode,barcode,title,specs,costprice,number,cashtype,supplyid,allprice) values ";
			$i = 0;
			foreach ($_POST['title'] as $k => $val) {
				if (empty($val)) {
					continue;
				}

				if (empty($_POST['number'][$k])) {
					continue;
				}

				$allprice = $_POST['number'][$k] * $_POST['costprice'][$k];

				if ($i == 0) {
					$sqlinsert .= "($applyid,$line,'" . $_POST['goodsuuid'][$k] . "','" . $_POST['erpcode'][$k] . "','" . $_POST['barcode'][$k] . "','" . $_POST['title'][$k] . "','" . $_POST['specs'][$k] . "','" . $_POST['costprice'][$k] . "','" . $_POST['number'][$k] . "','" . $_POST['cashtype'][$k] . "','" . $_POST['supplyid'][$k] . "','" . $allprice . "')";
				} else {
					$sqlinsert .= ",($applyid,$line,'" . $_POST['goodsuuid'][$k] . "','" . $_POST['erpcode'][$k] . "','" . $_POST['barcode'][$k] . "','" . $_POST['title'][$k] . "','" . $_POST['specs'][$k] . "','" . $_POST['costprice'][$k] . "','" . $_POST['number'][$k] . "','" . $_POST['cashtype'][$k] . "','" . $_POST['supplyid'][$k] . "','" . $allprice . "')";
				}
				$i++;
			}
			if ($i == 0) {
				$this->product->applyplanModel->delete("id=$line");
				ajaxReturn('', '请填写采购商品的数量', 0);exit;
			}
			$this->product->applycartModel->delete("applyid=$applyid");
			$l = $this->product->applycartModel->sqlexec($sqlinsert);
			if ($l) {
				$return['info'] = '操作成功';
				$return['state'] = 1;
				$return['data'] = 'url';
				$return['url'] = $this->url('buyer/plan', array('id' => $applyid, 'planid' => $line));
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
		$this->loadModel('product', 'applycart');
		$this->loadModel('product', 'applydata');
		//print_r($_POST);exit;
		if (!isset($_POST['cartid'])) {
			ajaxReturn('', '未选择采购商品', 0);exit;
		}
		$data['status'] = 3;
		$data['makeplanuserid'] = $this->info['id'];
		$applyid = $_POST['applyid'];
		$line = $this->product->applyModel->update($data, 'id=' . $applyid);
		
		if ($line) {
			//修改选中商品
			$cartid = implode(",", $_POST['cartid']);
			$l1 = $this->product->applycartModel->update(array('status' => 0), "applyid=" . $applyid);
			$this->product->applycartModel->update(array('status' => 1), " id in(" . $cartid . ")");
			$sql	=	"select sum(number) as num ,sum(allprice) as aprice from product_applycart where id in(" . $cartid . ")";
			$tj		=	$this->product->applycartModel->fetchRow($sql);
			
			if($tj){
				$dd['sometimenouse']	=	time();
				$dd['allgoodsnum']	=	$tj['num'];
				$dd['allprice']	=	$tj['aprice'];
				$lines = $this->product->applyModel->update($dd, 'id=' . $applyid);
				if(!$lines){
				$data['status'] = 2;
				$line = $this->product->applyModel->update($data, 'id=' . $applyid);
				$this->product->applycartModel->update(array('status' => 0), " id in(" . $cartid . ")");
				}
			}else{
				$data['status'] = 2;
				$line = $this->product->applyModel->update($data, 'id=' . $applyid);
				$this->product->applycartModel->update(array('status' => 0), " id in(" . $cartid . ")");
			}
			$this->loadModel('product', 'applydata');
			$d['applyid'] = $applyid;
			$d['created'] = time();
			$d['truename'] = $this->info['truename'];

			$d['remark'] = $_POST['remark'];
			$d['results'] = "确认采购计划";
			$l = $this->product->applydataModel->insert($d);
			if ($l) {
				$url = "http://" . ROOT_URL . "/index.php/iManage/buyer/editapplycaigou?id=$applyid";
				$r = array('info' => "操作成功", 'data' => 'url', 'state' => 1, 'url' => $url);
				$this->sendemailandmessage($applyid, 3);
				//$this->tezhisendmessage($applyid, 3,'zgid');
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
		$this->loadModel('product', 'applycart');
		$this->loadModel('product', 'applyplan');
		$data['status'] = 4;
		$applyid = $_POST['applyid'];
		$line = $_POST['planid'];
		$l	=	$this->product->applyModel->update(array('status'=>2),"id=$applyid");
		if($l){
			$d['planid'] = $line;
			$d['applyid'] = $applyid;
			$sqlinsert = "insert into product_applycart(applyid,planid,goodsuuid,erpcode,barcode,title,specs,costprice,number,cashtype,supplyid,allprice) values ";
			$i = 0;
			foreach ($_POST['title'] as $k => $val) {
				if (empty($val)) {
					continue;
				}

				if (empty($_POST['number'][$k])) {
					continue;
				}

				$allprice = $_POST['number'][$k] * $_POST['costprice'][$k];

				if ($i == 0) {
					$sqlinsert .= "($applyid,$line,'" . $_POST['goodsuuid'][$k] . "','" . $_POST['erpcode'][$k] . "','" . $_POST['barcode'][$k] . "','" . $_POST['title'][$k] . "','" . $_POST['specs'][$k] . "','" . $_POST['costprice'][$k] . "','" . $_POST['number'][$k] . "','" . $_POST['cashtype'][$k] . "','" . $_POST['supplyid'][$k] . "','" . $allprice . "')";
				} else {
					$sqlinsert .= ",($applyid,$line,'" . $_POST['goodsuuid'][$k] . "','" . $_POST['erpcode'][$k] . "','" . $_POST['barcode'][$k] . "','" . $_POST['title'][$k] . "','" . $_POST['specs'][$k] . "','" . $_POST['costprice'][$k] . "','" . $_POST['number'][$k] . "','" . $_POST['cashtype'][$k] . "','" . $_POST['supplyid'][$k] . "','" . $allprice . "')";
				}
				$i++;
			}
			if ($i == 0) {
				$this->product->applyplanModel->delete("id=$line");
				ajaxReturn('', '请填写采购商品的数量', 0);exit;
			}
			$this->product->applycartModel->delete("applyid=$applyid");
			$l = $this->product->applycartModel->sqlexec($sqlinsert);
			if ($l) {
				$return['info'] = '操作成功';
				$return['state'] = 1;
				$return['data'] = 'url';
				$return['url'] = $this->url('buyer/plan', array('id' => $applyid, 'planid' => $line));
				echo json_encode($return);exit;
			} else {
				$this->product->applyplanModel->delete("id=$line");
				ajaxReturn('', '操作失败', 0);exit;
			}
		}
	}
	//采购部门---采购入库单
	public function storelist() {
		$this->loadModel('product', 'applycart');
		$this->loadModel('product', 'applystoreplan');
		$this->loadModel('product', 'applycartstore');
		$this->loadHelper('extend');
		//print_r($_POST);exit;
		$idarray = $_POST['id'];
		$applyid = $_POST['applyid'];

		$planid = $plantag = $_POST['planid'];
		$sql = "select ordernum from product_apply where id=$applyid";
		$apply = $this->product->applystoreplanModel->fetchRow($sql);
		$ordernum = $apply['ordernum'];
		if (empty($plantag)) {
			//新增
			$this->loadModel('product', 'applydata');
			if (!empty($_FILES['files']['name'])) {
				$this->loadHelper('uploader');
				$uploader = new uploader();
				$dp['filepath'] = $uploader->start('files');
				$dp['filetitle'] = $_FILES['files']['name'];
			} else {
				//ajaxReturn('', '未上传供应商物流单', 0);exit;
			}
			$dp['created'] = time();
			$dp['truename'] = $this->info['truename'];
			$dp['mobile'] = $this->info['mobile'];
			$dp['remark'] = $_POST['remark'];
			$dp['ordernum'] = $ordernum;
			$dp['title'] = date("Y年m月d日") . "入库计划";
			if(empty($_POST['sendtime'])){
			ajaxReturn('', '请填写发货时间', 0);exit;
			}
			if(empty($_POST['arrivetime'])){
			ajaxReturn('', '请填写预计收货时间', 0);exit;
			}
			$dp['sendtime']	=	$_POST['sendtime'];
			$dp['arrivetime']	=	$_POST['arrivetime'];
			$planid = $this->product->applystoreplanModel->insert($dp);
			if (!$planid) {
				ajaxReturn('', '操作失败', 0);exit;
			}

		} else {
			$this->loadModel('product', 'applydata');
			$dp = array();
			if (!empty($_FILES['files']['name'])) {
				$this->loadHelper('uploader');
				$uploader = new uploader();
				
				$dp['filepath'] = $uploader->start('files');
				$dp['filetitle'] = $_FILES['files']['name'];
				
				if (!$dp['filepath']) {
					ajaxReturn('', '供应商物流单上传失败', 0);exit;
				}
			}
			if(empty($_POST['sendtime'])){
			ajaxReturn('', '请填写发货时间', 0);exit;
			}
			if(empty($_POST['arrivetime'])){
			ajaxReturn('', '请填写预计收货时间', 0);exit;
			}
			$dp['sendtime']	=	$_POST['sendtime'];
			$dp['arrivetime']	=	$_POST['arrivetime'];
			$plan = $this->product->applystoreplanModel->update($dp, 'id=' . $planid);

		}
		$updatesql = "insert into product_applycartstore(id,cartid,planid,supplyid,ordernum,erpcode,barcode,number,realnumber,weight,boxnum,specs,shelflife,box) values";
		$updatecartsql="insert into product_applycart(id,erpcode,barcode) values";
		$i = 0;
		$arraycartid = array();
		foreach ($idarray as $k => $val) {
			if (empty($_POST['realnumber'][$k])) {continue;}
			if(empty($_POST['erpcode'][$k])){
			    $sq="select title from product_applycart where id=".$_POST['cartid'][$k];
				$rs=$this->product->applystoreplanModel->fetchRow($sq);
				ajaxReturn('', '请填写商品【'.$rs['title'].'】的编码', 0);exit;
			}
			//if($_POST['isdep'][$k]==0){$_POST['depnum'][$k]=0;}
			$arraycartid[] = $_POST['cartid'][$k];
			if ($i == 0) {
				$updatesql .= "(" . $val . "," . $_POST['cartid'][$k] . "," . $planid . "," . $_POST['supplyid'][$k] . ",'" . $ordernum . "','" . $_POST['erpcode'][$k] . "','" . $_POST['barcode'][$k] . "','" . $_POST['number'][$k] . "','" . $_POST['realnumber'][$k] . "','" . $_POST['weight'][$k] . "','" . $_POST['boxnum'][$k] . "','" . $_POST['specs'][$k] . "','" . $_POST['shelflife'][$k] . "','" . $_POST['box'][$k] . "')";
			    $updatecartsql.="(".$_POST['cartid'][$k].",'".$_POST['erpcode'][$k]."','".$_POST['barcode'][$k]."')";
			} else {
				$updatesql .= ",(" . $val . "," . $_POST['cartid'][$k] . "," . $planid . "," . $_POST['supplyid'][$k] . ",'" . $ordernum . "','" . $_POST['erpcode'][$k] . "','" . $_POST['barcode'][$k] . "','" . $_POST['number'][$k] . "','" . $_POST['realnumber'][$k] . "','" . $_POST['weight'][$k] . "','" . $_POST['boxnum'][$k] . "','" . $_POST['specs'][$k] . "','" . $_POST['shelflife'][$k] . "','" . $_POST['box'][$k] . "')";
				$updatecartsql.=",(".$_POST['cartid'][$k].",'".$_POST['erpcode'][$k]."','".$_POST['barcode'][$k]."')";
			}
			$i++;
		}
		$updatesql .= "ON DUPLICATE KEY UPDATE cartid=values(cartid),planid=values(planid),supplyid=values(supplyid),ordernum=values(ordernum),erpcode=values(erpcode),barcode=values(barcode),number=values(number),realnumber=values(realnumber),weight=values(weight),boxnum=values(boxnum),specs=values(specs),shelflife=values(shelflife),box=values(box)";
		$updatecartsql.="ON DUPLICATE KEY UPDATE erpcode=values(erpcode),barcode=values(barcode)";
		//echo $updatesql;exit;
		if ($i == 0) {
			$this->product->applycartstoreModel->delete("planid=$planid");
			$this->product->applystoreplanModel->delete("id=$planid");
			$url = "http://" . ROOT_URL . "/index.php/iManage/buyer/editapplycaigou?id=$applyid";
			$r = array('info' => "请填写商品详细信息", 'data' => 'url', 'state' => 0, 'url' => $url);
			
			echo json_encode($r);exit;
		}
		$cartidstr = implode(",", $arraycartid);
		$this->product->applycartstoreModel->delete("planid=$planid and cartid in(" . $cartidstr . ")");
		$line = $this->product->applycartstoreModel->sqlexec($updatesql);
		 $this->product->applycartModel->sqlexec($updatecartsql);
		/* $this->loadModel('product','apply');
		$data['status']	=	5;
		$line		=	$this->product->applyModel->update($data,'id='.$applyid); */
		if ($line) {
			$this->loadModel('product', 'applydata');
			$d['created'] = time();
			$d['truename'] = $this->info['truename'];
			$d['remark'] = $_POST['remark'];
			$d['applyid'] = $applyid;
			$d['results'] = "制作入库单";
			$l = $this->product->applydataModel->insert($d);
			if ($l) {
				$url = "http://" . ROOT_URL . "/index.php/iManage/buyer/editapplycaigou?id=$applyid";
				$r = array('info' => "操作成功", 'data' => '', 'state' => 1, 'url' => $url);
				echo json_encode($r);exit;
			} else {
				$this->product->applystoreplanModel->delete("id=$planid");
				ajaxReturn('', '操作失败', 0);exit;
			}

		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}

	}
	//采购部门---制作入库单--入库单列表
	public function makestorelist() {

		$this->loadModel('product', 'applycart');
		$this->loadModel('product', 'applycartstore');
		$this->loadModel('product', 'applystoreplan');
		$ordernum = $_GET["ordernum"];
		$planid = $plantag = isset($_GET['planid']) ? $_GET['planid'] : 0;
		$goodsstore = array();
		$goodscart = array();
		$plan = array();
		$planrow = array();
		$sql = "select * from product_apply where ordernum='" . $ordernum . "'";
		$re = $this->product->applycartModel->fetchRow($sql);
		$sql = "select id,title from product_applystoreplan where ordernum='" . $ordernum . "' ";
		$plan = $this->product->applystoreplanModel->fetchAll($sql);
		if (empty($planid)) {
			//查询所有

			if ($plan) {
				$planid = $plan[0]['id'];
			}
		}
		if (!empty($plantag)) {
			$sql = "select pa.*,ss.title as supplyname,pat.title,pat.cashtype,pat.costprice from product_applycartstore as pa left join crm_supplier as ss on ss.id=pa.supplyid left join product_applycart as pat on pat.id=pa.cartid where pa.planid=$planid order by pa.id asc";

			$goodsstore = $this->product->applycartModel->fetchAll($sql);
			$planrow = $this->product->applycartModel->fetchRow("select * from product_applystoreplan where id=" . $planid);
			
		} else {
			$sql = "select pa.*,ss.title as supplyname from product_applycart as pa left join crm_supplier as ss on ss.id=pa.supplyid where pa.applyid=" . $re['id'] . " and pa.status=1 order by pa.id asc ";
			$goods = $this->product->applycartModel->fetchAll($sql);
			
		}
		//
		if(!empty($planrow) && $planrow['status']>1){
			foreach ($goodsstore as $k => $val) {
			$sql = "select * from product_applyproducttime where cartstoreid=" . $val['id'];
			$r = $this->product->applycartModel->fetchAll($sql);
			$goodsstore[$k]['time'] = $r;
			}
		}
		include $this->loadWidget('amdinlteTheme');
	}
	//采购部门---分配采购商品的到期时间 preparegoods
	public function preparegoodstime() {
		$cartstoreid = $_GET["id"];
		$this->loadModel('product', 'applycart');
		$re = $this->product->applycartModel->fetchRow("select pae.*,pa.title from product_applycartstore as pae left join product_applycart as pa on pa.id=pae.cartid where pae.id=$cartstoreid");

		$producttime = $this->product->applycartModel->fetchAll("select * from product_applyproducttime where cartstoreid=$cartstoreid");
		//print_r($producttime);exit;
		include $this->loadView('');

	}
	//采购部门--提交分配的保质时间
	public function updatepreparegoodtime() {
		$this->loadModel('product', 'applyproducttime');
		$insqlsql = "insert into product_applyproducttime(id,planid,cartstoreid,productendtime,num) values";
		$url = $this->url('buyer/preparegoodstime', array('id' => $_POST['cartstoreid']));

		if (!isset($_POST['id'])) {
			echo "<script>alert('操作无效');window.location.href='" . $url . "';</script>";exit;
		}
		$idarr = $_POST['id'];
		$sqlid = array();
		$i = 0;
		//print_r($_POST);exit;
		$number	=	0;
		$realnumber	=	$_POST['numbergb'];
		foreach ($idarr as $k => $v) {
			$num = $_POST['num'][$k];
			$productendtime = $_POST['productendtime'][$k];
			if (empty($num)) {continue;}
			$number+=$num;
			$productendtime = strtotime($productendtime);
			if ($i == 0) {
				$insqlsql .= "(" . $v . ",'" . $_POST['planid'] . "','" . $_POST['cartstoreid'] . "','" . $productendtime . "','" . $_POST['num'][$k] . "')";
			} else {
				$insqlsql .= ",(" . $v . ",'" . $_POST['planid'] . "','" . $_POST['cartstoreid'] . "','" . $productendtime . "','" . $_POST['num'][$k] . "')";
			}
			$i++;
			if ($v > 0) {$sqlid[] = $v;}
		}
		
		if ($i == 0) {
			echo "<script>alert('请填写到货数量及到期时间');window.location.href='" . $url . "';</script>";exit;
		}
		if($realnumber!=$number){
		echo "<script>alert('实际到货数量与分配数量不匹配,操作失败');window.location.href='" . $url . "';</script>";exit;
		}
		if (!empty($sqlid)) {
			$sqlid = implode(",", $sqlid);
			$this->product->applyproducttimeModel->delete("cartstoreid='".$_POST['cartstoreid']."' and id  in(" . $sqlid . ")");
		}
		//echo $insqlsql;exit;
		$insqlsql .= " on duplicate key update planid=values(planid),cartstoreid=values(cartstoreid),productendtime=values(productendtime),num=values(num)";
		$line = $this->product->applyproducttimeModel->sqlexec($insqlsql);
		if ($line) {
			echo "<script>alert('操作成功');window.location.href='" . $url . "';</script>";exit;
		} else {
			echo "<script>alert('操作失败');window.location.href='" . $url . "';</script>";exit;
		}
	}
	//采购部门提交采购入库单
	public function storelisttj() {
		$id = $_GET['id'];
		$this->loadHelper('extend');
		$this->loadModel('product', 'applystoreplan');
		$this->loadModel('product', 'applyproducttime');
		$this->loadModel('product', 'apply');
		$sql = "select pa.*,pay.id as applyid from product_applystoreplan as pa left join product_apply as pay on pay.ordernum=pa.ordernum where pa.id=$id";
		$plan = $this->product->applystoreplanModel->fetchRow($sql);
		//查看商品有没有写保质期
		$sql = "select pa.title from product_applycartstore as pae left join product_applycart as pa  on pa.id=pae.cartid  where pae.shelflife>0 and  pae.planid=$id and pae.id not in(select cartstoreid from product_applyproducttime where planid=$id)";

		$notimebarcode = $this->product->applystoreplanModel->fetchAll($sql);
		if ($notimebarcode) {
			$str = '请填写以下商品的保质期至信息:';
			foreach ($notimebarcode as $k => $v) {
				$s = $k + 1;
				$str .= '<br>(' . $s . ")." . $v['title'];

			}
			ajaxReturn('', $str, 0);
		}
		//将没有保质期的商品汪加到 product_applyproducttime 表
		$sql	=	"select * from product_applycartstore where shelflife=0 and planid=$id";
		$notime	=	$this->product->applystoreplanModel->fetchAll($sql);
		foreach($notime as $k=>$val){
			$this->product->applyproducttimeModel->delete("planid=$id and cartstoreid=".$val['id']);
			$nd	=	array();
			$nd['planid']	=	$id;
			$nd['cartstoreid']	=	$val['id'];
			$nd['productendtime']	=	0;
			$nd['num']	=	$val['number'];
			$this->product->applyproducttimeModel->insert($nd);
		}
		$data['status'] = 1;
		$line = $this->product->applystoreplanModel->update($data, "id=" . $id);
		
		if ($line) {
			$datas['status'] = 7;
			$lins = $this->product->applyModel->update($datas, "id=" . $plan['applyid']);
			
			if (!$lins) {
				$data['status'] = 0;
				$this->product->applystoreplanModel->update($data, "id=" . $id);
				ajaxReturn('', '操作失败', 0);
			}

			$this->loadModel('product', 'applydata');
			$d['created'] = time();
			$d['truename'] = $this->info['truename'];
			$d['remark'] = "提交入库单";
			$d['applyid'] = $plan['applyid'];
			$d['results'] = "提交入库单";
			$l = $this->product->applydataModel->insert($d);
			$url = "http://" . ROOT_URL . "/index.php/iManage/buyer/editapplycaigou?id=" . $plan['applyid'];
			$r = array('info' => "操作成功", 'data' => '', 'state' => 1, 'url' => $url);
			$this->sendemailandmessage($plan['applyid'], 7);
			echo json_encode($r);exit;
		} else {
			ajaxReturn('', '操作失败', 0);
		}
	}

	//采购列表--财务部门
	public function applycaiwu() {
		$this->pos = 6;
		$this->loadModel('product', 'apply');
		//$sql = "select pa.*,sa.truename as cgname,zg.truename as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid where pa.status>=3 or pa.memberid=" . $this->info['id'] . " or pa.zgid=" . $this->info['id'] . " order by pa.id desc ";
		$sql = "select pa.*,sa.truename as cgname,zg.truename as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid where pa.status>=5  order by pa.id desc ";
		$re = $this->product->applyModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');
	}
	//编辑采购申请--财务详情
	public function editapplycaiwu() {
		$this->loadModel('system', 'admin');
		$this->loadModel('product', 'applydata');
		$this->loadModel('product', 'apply');

		$id = $_GET['id'];
		$sql = "select pa.*,sa.truename as cgname,zg.truename as zgname,cgzxr.truename as cgzxrname,cs.title as supplytitle,cs.name as supplyname,cs.mobile as supplymobile from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid left join system_admin as cgzxr on cgzxr.id=pa.cgfzrid left join crm_supplier as cs on cs.id=pa.supplyid where pa.id=$id";
		$re = $this->product->applyModel->fetchRow($sql);
		//查看商品信息
		$goods = array();
		if ($re['status'] >= 3) {
			//购物车信息
			$sql = "select pa.*,ss.title as supplyname from product_applycart as pa left join crm_supplier as ss on ss.id=pa.supplyid  where pa.applyid=$id and pa.status=1 order by pa.id asc ";
			$goods = $this->system->adminModel->fetchAll($sql);

			//得到加盟商类型
			$sql = "select * from crm_usertype order by id asc";
			$supplytype = $this->product->applyModel->fetchAll($sql);
			foreach ($goods as $k => $val) {
				$goods[$k]['result'] = array();
				//$goods[$k]['rt']	=	array();
				if ($val['tag'] == 0) {
					//查询产品库数据
					$sql = "select id,suggestprice,beoverdue,futureprice from product_goods where barcode='" . $val['barcode'] . "'";
					$result = $this->product->applyModel->fetchRow($sql);

					$goods[$k]['result'] = $result;

					/* if($result){
				//查加盟商价格---result为空，该商品没有数据或为新品采购
				$sql	=	"select * from product_allianceprice where goodsid=".$result['id']." order by supplytypeid asc";
				$rt		=	$this->product->applyModel->fetchAll($sql);
				$goods[$k]['rt']	=	$rt;
				} */

				} /* else{
			$sql	=	"select * from product_applyallianceprice where cartid=".$val['id']." order by supplytypeid asc";
			$rt		=	$this->product->applyModel->fetchAll($sql);
			$goods[$k]['rt']	=	$rt;
			} */

			}

		}
		/*  echo "<pre>";
		print_r($goods);exit;  */
		$contract = ''; //合同
		if ($re['status'] >= 5) {
			$sql = "select pa.*,ss.title as supplyname from product_applycontract as pa left join crm_supplier as ss on ss.id=pa.supplyid where pa.applyid=$id";
			$contract = $this->system->adminModel->fetchAll($sql);
			//查询商品信息
			/* foreach($contract as $k=>$v){
			$sql	=	"select title from product_applycart where status=1 and supplyid=".$v['supplyid']." and applyid=".$id;
			$res	=	$this->system->adminModel->fetchAll($sql);
			$contract[$k]['goods']	=	$res;
			} */
			//支付日志
			$hetongid = $contract[0]['id'];
			$this->loadModel('product', 'applypaylog');
			$sql = "select * from product_applypaylog where applycontractid=" . $hetongid;
			$paylog = $this->product->applypaylogModel->fetchAll($sql);
			//支付方式
			$this->loadModel('financial', 'paytype');
			$sql = "select * from financial_paytype where type=0 and status=1";
			$paytype = $this->financial->paytypeModel->fetchAll($sql);
		}
		//操作记录
		$sql = "select * from product_applydata where applyid=" . $id . " order by id desc";
		$log = $this->product->applydataModel->fetchAll($sql);
		//按时间重新组合日志  --开始
		$logs = array();
		foreach ($log as $k => $val) {
			$logs[date("Y-m-d", $val['created'])][] = $val;
		}
		//查看入库计划
		$sql = "select * from product_applystoreplan where ordernum='" . $re['ordernum'] . "' and status>=2";
		$plan = $this->product->applydataModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//付款记录界面
	public function paylog() {
		$hetongid = $_GET['id'];
		$this->loadModel('product', 'applypaylog');
		$sql = "select * from product_applypaylog where applycontractid=" . $hetongid;
		$paylog = $this->product->applypaylogModel->fetchAll($sql);
		//支付方式
		$this->loadModel('financial', 'paytype');
		$sql = "select * from financial_paytype where type=0 and status=1";
		$paytype = $this->financial->paytypeModel->fetchAll($sql);
		include $this->loadView('');
	}
	/* public function paylogtjold(){
	$url	=	$this->url('buyer/paylog',array('id'=>$_POST['hetongid']));
	$this->loadHelper('extend');
	//echo "<script>alert('分配数量不能为空');window.location.href='".$url."';</script>";exit;
	$hetongid	=	$_POST['hetongid'];
	$idarr			=	$_POST['id'];
	$this->loadModel('product','applypaylog');
	$insertsql	=	"insert into product_applypaylog(id,applycontractid,paymoney,banknum,paytype,paytime,truename,created,remark)values ";
	$i	=	0;
	foreach($idarr as $k=>$val){
	$paytime	=	empty($_POST['paytime'][$k])?0:$_POST['paytime'][$k];
	$paytime	=	strtotime($paytime);
	$truename	=	$this->info['truename'];
	$created	=	time();
	if(empty($_POST['paymoney'][$k]) && $_POST['remark'][$k]){continue;}
	if($i==0){
	$insertsql.="(".$val.",".$hetongid.",'".$_POST['paymoney'][$k]."','".$_POST['banknum'][$k]."',".$_POST['paytype'][$k].",'".$paytime."','".$truename."','".$created."','".$_POST['remark'][$k]."')";
	}else{
	$insertsql.=",(".$val.",".$hetongid.",'".$_POST['paymoney'][$k]."','".$_POST['banknum'][$k]."',".$_POST['paytype'][$k].",'".$paytime."','".$truename."','".$created."','".$_POST['remark'][$k]."')";
	}
	$i++;
	}
	$insertsql.=" on duplicate key update applycontractid=values(applycontractid),paymoney=values(paymoney),banknum=values(banknum),paytype=values(paytype),paytime=values(paytime),truename=values(truename),created=values(created),remark=values(remark)";
	//echo $insertsql;exit;
	if($i>0){
	$line	=	$this->product->applypaylogModel->sqlexec($insertsql);
	}else{
	$line=0;
	}
	if($line){
	echo "<script>alert('分配成功');window.location.href='".$url."';</script>";exit;
	}else{
	echo "<script>alert('分配失败');window.location.href='".$url."';</script>";exit;
	}
	} */
	public function paylogtj() {
		$url = $this->url('buyer/paylog', array('id' => $_POST['hetongid']));
		$this->loadHelper('extend');
		//echo "<script>alert('分配数量不能为空');window.location.href='".$url."';</script>";exit;
		$hetongid = $_POST['hetongid'];
		$idarr = $_POST['id'];
		$this->loadModel('product', 'applypaylog');
		$insertsql = "insert into product_applypaylog(id,applycontractid,paymoney,banknum,paytype,paytime,truename,created,remark)values ";
		$i = 0;
		$paytime = strtotime($_POST['paytime']);
		$truename = $this->info['truename'];
		$created = time();
		$insertsql .= "(" . $_POST['id'] . "," . $hetongid . ",'" . $_POST['paymoney'] . "','" . $_POST['banknum'] . "'," . $_POST['paytype'] . ",'" . $paytime . "','" . $truename . "','" . $created . "','" . $_POST['remark'] . "')";
		$insertsql .= " on duplicate key update applycontractid=values(applycontractid),paymoney=values(paymoney),banknum=values(banknum),paytype=values(paytype),paytime=values(paytime),truename=values(truename),created=values(created),remark=values(remark)";
		//echo $insertsql;exit;

		$line = $this->product->applypaylogModel->sqlexec($insertsql);
		$data = array('state' => 0, 'info' => "操作失败");
		if ($line) {
			$data['state'] = 1;
			echo json_encode($data);
			exit;
		} else {
			echo json_encode($data);exit;
		}
	}
	//删除支付日志
	public function delpaylog(){
		$this->loadHelper('extend');
		$this->loadModel('product', 'applypaylog');
		$line	=	$this->product->applypaylogModel->delete("id=".$_POST['id']);
		$data = array('state' => 0, 'info' => "操作失败");
		if ($line) {
			$data['state'] = 1;
			echo json_encode($data);
			exit;
		} else {
			echo json_encode($data);exit;
		}
	
	}
	//提交合同
	public function addContract($applyid) {
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applycontract');
		//$sysconf	=	$this->loadConfig('sysconf');
		//$applyid = $_GET['applyid'];
		//加盟商信息
		$sql = "select pa.id,pa.title,pa.status from product_apply as pa  where pa.id=$applyid ";

		$apply = $this->product->applyModel->fetchRow($sql);
		//查看该采购中的加盟商
		/* $sql = "select pa.*,cs.title as supplyname from product_applycontract as pa left join crm_supplier as cs on cs.id=pa.supplyid where pa.applyid=$applyid";
		$contract = $this->product->applycontractModel->fetchAll($sql); */

		//if (!$contract) {
			//第一次进入，须初始化表，将该采购中的供应商名称加入到表里
			$sql = "select supplyid from product_applycart where applyid=$applyid and status=1  group by supplyid";
			$r = $this->product->applycontractModel->fetchAll($sql);

			if ($r) {
				$insertsql = "insert into product_applycontract(applyid,supplyid) values";
				foreach ($r as $k => $val) {
					if ($k == 0) {
						$insertsql .= "(" . $applyid . ",'" . $val['supplyid'] . "')";
					} else {
						$insertsql .= ",(" . $applyid . ",'" . $val['supplyid'] . "')";
					}
				}
				$this->product->applycontractModel->sqlexec($insertsql);
				//查看该采购中的加盟商
				$sql = "select pa.*,cs.title as supplyname from product_applycontract as pa left join crm_supplier as cs on cs.id=pa.supplyid where pa.applyid=$applyid";
				$contract = $this->product->applycontractModel->fetchAll($sql);
			}
		//}
		foreach ($contract as $k => $val) {
			$sql = "select title from product_applycart where applyid=" . $applyid . " and status=1 and supplyid=" . $val['supplyid'];
			//echo $sql;exit;
			$res = $this->product->applycontractModel->fetchAll($sql);
			$contract[$k]['goods'] = $res;
		}
		return $contract;
		//include $this->loadWidget('amdinlteTheme');
	}
	//提交合同-界面
	public function contracttj() {
		$this->loadModel('product', 'applycontract');
		$this->loadModel('product', 'applydata');
		$this->loadModel('product', 'apply');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		if (!empty($_FILES['files'])) {
			$this->loadHelper('uploader');
			$uploader = new uploader();
			$odata['contractpath'] =  $uploader->start('files');
			$odata['contracttitle'] = $_FILES['files']['name'];
			
		}  else{
			
			//ajaxReturn ( '', '未提交合同信息', 0 );
		} 
		
		$odata['truename'] = $this->info['truename'];
		$odata['created'] = time();
		$odata['remark'] = isset($_POST['remark' . $id])?$_POST['remark' . $id]:'';
		
		
		$line = $this->product->applycontractModel->update($odata, "id=$id");
		
		if ($line) {
			$data['sometimenouse'] = time();
			$data['status'] = 5;
			$applyid = $_POST['applyid'];
			$this->product->applyModel->update($data, 'id=' . $applyid." and status=4");
			
			$d['applyid'] = $_POST['applyid'];
			$d['truename'] = $this->info['truename'];
			$d['created'] = time();
			$d['remark'] = $_POST['remark' . $id];
			$d['results'] = "提交合同信息";
			$this->product->applydataModel->insert($d);
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
			$this->loadModel('product', 'applydata');
			$d['created'] = time();
			$d['truename'] = $this->info['truename'];
			$d['applyid'] = $applyid;
			$d['remark'] = "确认并提交合同信息";
			$d['results'] = "";
			$l = $this->product->applydataModel->insert($d);
			if ($l) {
				$url = "http://" . ROOT_URL . "/index.php/iManage/buyer/editapplycaigou?id=$applyid";
				$r = array('info' => "操作成功", 'data' => 'url', 'state' => 1, 'url' => $url);
				$this->sendemailandmessage($applyid, 5);
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

	//财务信息录入-
	public function financeinfo() {
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applycontract');
		//$sysconf	=	$this->loadConfig('sysconf');
		$applyid = $_GET['id'];
		//加盟商信息
		$sql = "select pa.id,pa.title,pa.status from product_apply as pa  where pa.id=$applyid ";
		$apply = $this->product->applyModel->fetchRow($sql);
		//查看该采购中的加盟商
		$sql = "select pa.*,cs.title as supplyname from product_applycontract as pa left join crm_supplier as cs on cs.id=pa.supplyid where pa.applyid=$applyid";
		$contract = $this->product->applycontractModel->fetchAll($sql);
		foreach ($contract as $k => $val) {
			$sql = "select title from product_applycart where applyid=" . $applyid . " and status=1 and supplyid=" . $val['supplyid'];
			//echo $sql;exit;
			$res = $this->product->applycontractModel->fetchAll($sql);
			$contract[$k]['goods'] = $res;
		}
		include $this->loadWidget('amdinlteTheme');
	}
	//财务信息录入---修改合同价格
	public function financeinfoupdate() {
		$this->loadModel('product', 'applycontract');
		$this->loadHelper('extend');
		$idarray = $_POST['id'];
		$applyid = $_POST['applyid'];
		$updatesql = "insert into product_applycontract(id,allprice,depnum,deptime,endmoney,endpaytime,cwremark) values";
		foreach ($idarray as $k => $val) {
			if (empty($_POST['depnum'][$k])) {$_POST['depnum'][$k] = 0;}
			//if($_POST['isdep'][$k]==0){$_POST['depnum'][$k]=0;}
			$deptime = $_POST['deptime'][$k];
			if (empty($deptime)) {$deptime = 0;} else { $deptime = strtotime($deptime);}
			$endpaytime = $_POST['endpaytime'][$k];
			if (empty($endpaytime)) {$endpaytime = 0;} else { $endpaytime = strtotime($endpaytime);}
			$_POST['allprice'][$k]	=	empty($_POST['allprice'][$k])?0:$_POST['allprice'][$k]-0;
			$_POST['endmoney'][$k]	=	empty($_POST['endmoney'][$k])?0:$_POST['endmoney'][$k]-0;
			if ($k == 0) {
				$updatesql .= "(" . $val . "," . $_POST['allprice'][$k] . ",'" . $_POST['depnum'][$k] . "','" . $deptime . "','" . $_POST['endmoney'][$k] . "','" . $endpaytime . "','" . $_POST['remark'] . "')";
			} else {
				$updatesql .= ",(" . $val . "," . $_POST['allprice'][$k] . ",'" . $_POST['depnum'][$k] . "','" . $deptime . "','" . $_POST['endmoney'][$k] . "','" . $endpaytime . "','" . $_POST['remark'] . "')";
			}

		}
		$updatesql .= "ON DUPLICATE KEY UPDATE allprice=values(allprice),depnum=values(depnum),deptime=values(deptime),endmoney=values(endmoney),endpaytime=values(endpaytime),cwremark=values(cwremark)";
		//echo $updatesql;exit;
		$line = $this->product->applycontractModel->sqlexec($updatesql);
		/* $this->loadModel('product','apply');
		$data['status']	=	5;
		$line		=	$this->product->applyModel->update($data,'id='.$applyid); */
		if ($line) {
			$this->loadModel('product', 'applydata');
			$d['created'] = time();
			$d['truename'] = $this->info['truename'];
			$d['remark'] = $_POST['remark'];
			$d['applyid'] = $applyid;
			$d['results'] = "修改合同价格";
			$l = $this->product->applydataModel->insert($d);
			if ($l) {
				$url = "http://" . ROOT_URL . "/index.php/iManage/buyer/editapplycaiwu?id=$applyid";
				$r = array('info' => "操作成功", 'data' => 'url', 'state' => 1, 'url' => $url);
				echo json_encode($r);exit;
			} else {
				/* $data['status']	=	6;

				$line		=	$this->product->applyModel->update($data,'id='.$applyid); */
				ajaxReturn('', '操作失败', 0);exit;
			}

		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	//提交财务信息
	public function updateapplystatuscaiwu() {
		$applyid = $_GET['id'];
		$this->loadHelper('extend');
		$this->loadModel('product', 'apply');
		$data['status'] = 6;
		$line = $this->product->applyModel->update($data, 'id=' . $applyid);
		if ($line) {
			$this->loadModel('product', 'applydata');
			$d['created'] = time();
			$d['truename'] = $this->info['truename'];
			$d['remark'] = "提交财务信息";
			$d['applyid'] = $applyid;
			$d['results'] = "提交财务信息";
			$l = $this->product->applydataModel->insert($d);
			if ($l) {
				$url = "http://" . ROOT_URL . "/index.php/iManage/buyer/editapplycaiwu?id=$applyid";
				$r = array('info' => "操作成功", 'data' => 'url', 'state' => 1, 'url' => $url);
				//$this->sendemailandmessage($applyid, 6);
				$this->tezhisendmessage($applyid, 6,'makeplanuserid');
				echo json_encode($r);exit;
			} else {
				$data['status'] = 5;

				$line = $this->product->applyModel->update($data, 'id=' . $applyid);
				ajaxReturn('', '操作失败', 0);exit;
			}

		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}

	}
	//财务核价页面
	public function caiwustorelist() {

		$this->loadModel('product', 'applycart');
		$this->loadModel('product', 'applycartstore');
		$this->loadModel('product', 'applystoreplan');
		$ordernum = $_GET["ordernum"];
		$planid = $plantag = isset($_GET['planid']) ? $_GET['planid'] : 0;
		$goodsstore = array();
		$goodscart = array();
		$plan = array();
		$planrow = array();
		$sql = "select * from product_apply where ordernum='" . $ordernum . "' ";
		$re = $this->product->applycartModel->fetchRow($sql);
		$sql = "select id,title,status from product_applystoreplan where ordernum='" . $ordernum . "' and status>=2";
		$plan = $this->product->applystoreplanModel->fetchAll($sql);

		$sql = "select pa.*,ss.title as supplyname,pat.title,pat.cashtype from product_applycartstore as pa left join crm_supplier as ss on ss.id=pa.supplyid left join product_applycart as pat on pat.id=pa.cartid where pa.planid=$planid and pa.status>=1 order by pa.id asc";

		$goodsstore = $this->product->applycartModel->fetchAll($sql);

		foreach ($goodsstore as $k => $val) {
			$sql = "select * from product_applyproducttime where cartstoreid=" . $val['id'];
			$r = $this->product->applycartModel->fetchAll($sql);
			$goodsstore[$k]['time'] = $r;
		}
		$planrow = $this->product->applycartModel->fetchRow("select remark,status,id,houseremark from product_applystoreplan where id=" . $planid);

		include $this->loadWidget('amdinlteTheme');
	}
	//财务核价-提交
	public function caiwucheckprice() {
		$this->loadHelper('extend');
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applydata');
		$this->loadModel('product', 'applycart');
		$this->loadModel('product', 'applyallianceprice');
		$applyid = $_POST['applyid'];
		
				//改变状态
				$data = array();
				$data['status'] = 10;
				$data['sometimenouse'] = time();
				$line = $this->product->applyModel->update($data, 'id=' . $applyid);
				if ($line) {

					//操作记录
					$this->loadModel('product', 'applydata');
					$d['created'] = time();
					$d['truename'] = $this->info['truename'];
					$d['remark'] = "";
					$d['applyid'] = $applyid;
					$d['results'] = "财务核价";
					$l = $this->product->applydataModel->insert($d);
					$this->sendemailandmessage($applyid, 10);
					ajaxReturn('', '操作成功', 1);exit;
				} else {
					$this->product->applycartModel->update(array('tag' => 0), "applyid=" . $applyid);
					ajaxReturn('', '操作失败', 0);exit;
				}
			
		

	}
	
		//财务核价-提交
	public function caiwucheckprice_old_2015_10_5() {
		$this->loadHelper('extend');
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applydata');
		$this->loadModel('product', 'applycart');
		$this->loadModel('product', 'applyallianceprice');
		$applyid = $_POST['applyid'];
		$cartidarr = $_POST['id'];
		
		//$insertsql		=	"insert into product_applycart(id,costprice,chengbuprice,suggestprice,beoverdue,futureprice,tag,checkpricetime) values";
		$insertsql = "insert into product_applycart(id,costprice,yunfei,chengbuprice,tag,checkpricetime) values";
		//$insertsql2		=	"insert into product_applyallianceprice(id,supplytypeid,cartid,price,applyid) values";
		$i = 0;
		$j = 0;
		$time = time();
		foreach ($cartidarr as $key => $val) {
			if ($i == 0) {
				$insertsql .= "(" . $val . ",'" . $_POST['costprice'][$key] . "','" . $_POST['yunfei'][$key] . "','" . $_POST['chengbuprice'][$key] . "',1," . $time . ")";
			} else {
				//$insertsql.=",(".$val.",'".$_POST['costprice'][$key]."','".$_POST['chengbuprice'][$key]."','".$_POST['suggestprice'][$key]."','".$_POST['beoverdue'][$key]."','".$_POST['futureprice'][$key]."',1,".$time.")";
				$insertsql .= ",(" . $val . ",'" . $_POST['costprice'][$key] . "','" . $_POST['yunfei'][$key] . "','" . $_POST['chengbuprice'][$key] . "',1," . $time . ")";
			}
			$i++;
			//print_r($_POST);exit;
			//查看加盟商价格
			/* if(isset($_POST['aid_'.$val])){
		foreach($_POST['aid_'.$val] as $k=>$v){
		if($j==0){
		$insertsql2.="(".$v.",'".$_POST['supplytypeid_'.$val][$k]."',".$val.",'".$_POST['supplyprice_'.$val][$k]."',".$applyid.")";

		}else{
		$insertsql2.=",(".$v.",'".$_POST['supplytypeid_'.$val][$k]."',".$val.",'".$_POST['supplyprice_'.$val][$k]."',".$applyid.")";
		}
		$j++;
		}

		} */
		}

		if ($i == 0) {
			ajaxReturn('', '操作失败', 0);exit;
		}
		//$insertsql	.="ON DUPLICATE KEY UPDATE costprice=values(costprice),chengbuprice=values(chengbuprice),suggestprice=values(suggestprice),beoverdue=values(beoverdue),futureprice=values(futureprice),tag=values(tag),checkpricetime=values(checkpricetime)";
		$insertsql .= "ON DUPLICATE KEY UPDATE costprice=values(costprice),yunfei=values(yunfei),chengbuprice=values(chengbuprice),suggestprice=values(suggestprice),tag=values(tag),checkpricetime=values(checkpricetime)";

		$line = $this->product->applycartModel->sqlexec($insertsql);
		$j = 1;
		if ($line) {
			if ($j > 0) {
				/* $insertsql2	.="ON DUPLICATE KEY UPDATE supplytypeid=values(supplytypeid),cartid=values(cartid),price=values(price),applyid=values(applyid)";

				$line	=	$this->product->applyalliancepriceModel->sqlexec($insertsql2); */
				//改变状态
				$data = array();
				$data['status'] = 10;
				$data['sometimenouse'] = time();
				$line = $this->product->applyModel->update($data, 'id=' . $applyid);
				if ($line) {

					//操作记录
					$this->loadModel('product', 'applydata');
					$d['created'] = time();
					$d['truename'] = $this->info['truename'];
					$d['remark'] = $_POST['remark'];
					$d['applyid'] = $applyid;
					$d['results'] = "财务核价";
					$l = $this->product->applydataModel->insert($d);
					$this->sendemailandmessage($applyid, 10);
					ajaxReturn('', '操作成功', 1);exit;
				} else {
					$this->product->applycartModel->update(array('tag' => 0), "applyid=" . $applyid);
					ajaxReturn('', '操作失败', 0);exit;
				}
			}
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}

	}
	//库房确认入库 product_applycartstore product_applyproducttime
	public function caiwuinstore() {
		set_time_limit(0);
		$applyid = $_GET['applyid'];
		$planid = $_GET['planid'];
		  /*    $l=$this->addgoodsstore($applyid,$planid);
		echo $l;
		exit;     */

		$this->loadHelper('extend');
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applystoreplan');

		$data['status'] = 11;
		$data['sometimenouse'] = time();
		$line = $this->product->applyModel->update($data, 'id=' . $applyid);
		if ($line) {
			$ls = $this->product->applystoreplanModel->update(array('status' => 4, 'sometimenouse' => time()), 'id=' . $planid);
			if ($ls) {
				$s = $this->addgoodsstore($applyid, $planid);
				//print_r($s);
				if ($s < 0) {
					if ($s == -1) {
						ajaxReturn('', '无入库的商品', 1);exit;

					}
					$data['status'] = 10;
					$this->product->applyModel->update($data, 'id=' . $applyid);
					$this->product->applystoreplanModel->update(array('status' => 3), 'id=' . $planid);
					ajaxReturn('', '操作失败4', 0);exit;
				}
			} else {
				$data['status'] = 10;
				$this->product->applyModel->update($data, 'id=' . $applyid);
				ajaxReturn('', '操作失败3', 0);exit;
			}
			//核减库存

			$this->loadModel('product', 'applydata');
			$d['created'] = time();
			$d['truename'] = $this->info['truename'];
			$d['remark'] = "提交财务信息";
			$d['applyid'] = $applyid;
			$d['results'] = "提交财务信息";
			$l = $this->product->applydataModel->insert($d);
			if ($l) {
				//$url    =   "http://".ROOT_URL."/index.php/iManage/buyer/editapplycaiwu?id=$applyid";
				$r = array('info' => "操作成功", 'data' => '', 'state' => 1);
				//$this->sendemailandmessage($applyid, 11);
				$this->tezhisendmessage($applyid, 11,'makeplanuserid');
				$this->tezhisendmessage($applyid, 11,'memberid');
				echo json_encode($r);exit;
			} else {
				$data['status'] = 10;

				$this->product->applyModel->update($data, 'id=' . $applyid);
				$this->product->applystoreplanModel->update(array('status' => 3), 'id=' . $planid);
				ajaxReturn('', '操作失败2', 0);exit;
			}

		} else {
			ajaxReturn('', '操作失败1', 0);exit;
		}

	}

	//财务确认商品无误
	public function cwpassgoods() {
		$this->loadModel('product', 'applycart');
		$this->loadModel('product', 'applystoreplan');
		$this->loadModel('product', 'applycartstore');
		$this->loadModel('product', 'apply');
		$this->loadHelper('extend');
		if (!isset($_POST['ids'])) {
			ajaxReturn('', '未选择商品', 0);exit;
		}
		//$id = implode(",", $_POST['ids']);
		//$line = $this->product->applycartstoreModel->update(array('cwstatus' => 1), "id in(" . $id . ")");
		$updatesql = "insert into product_applycartstore(id,cwstatus,thmoney,yunfei,chengbuprice,anytime) values";
		$i=0;
		$time	=	time();
		foreach($_POST['ids'] as $id){
			$thmoney	=	$_POST['thmoney_'.$id]-0;
			$yunfei	=	$_POST['yunfei_'.$id]-0;
			$chengbuprice	=	$_POST['chengbuprice_'.$id]-0;
			if($i==0){
				$updatesql.="(".$id.",1,'".$thmoney."','".$yunfei."','".$chengbuprice."','".$time."')";
			}else{
			$updatesql.=",(".$id.",1,'".$thmoney."','".$yunfei."','".$chengbuprice."','".$time."')";
			}
			$i++;
		}
		
		
		$updatesql .= "ON DUPLICATE KEY UPDATE cwstatus=values(cwstatus),thmoney=values(thmoney),yunfei=values(yunfei),chengbuprice=values(chengbuprice),anytime=values(anytime)";
		
		$line = $this->product->applycartstoreModel->sqlexec($updatesql);
		if ($line) {
			ajaxReturn('', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}

	//库房列表
	public function applyhouse() {
		$this->pos = 6;
		$this->loadModel('product', 'apply');
		//$sql = "select pa.*,sa.truename as cgname,zg.truename as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid where pa.status>=6 or pa.memberid=" . $this->info['id'] . " or pa.zgid=" . $this->info['id'] . " order by pa.id desc ";
		$sql = "select pa.*,sa.truename as cgname,zg.truename as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid where pa.status>=6  order by pa.id desc ";
		$re = $this->product->applyModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');

	}
	//库房验收
	public function storeinfo() {

		$this->loadModel('system', 'admin');
		$this->loadModel('product', 'applydata');
		$this->loadModel('product', 'apply');

		$id = $_GET['id'];
		$sql = "select pa.*,sa.truename as cgname,zg.truename as zgname,cgzxr.truename as cgzxrname,cs.title as supplytitle,cs.name as supplyname,cs.mobile as supplymobile from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid left join system_admin as cgzxr on cgzxr.id=pa.cgfzrid left join crm_supplier as cs on cs.id=pa.supplyid where pa.id=$id";
		$re = $this->product->applyModel->fetchRow($sql);
		//查看商品信息
		if ($re['status'] >= 3) {
			//购物车信息
			$sql = "select pa.*,ss.title as supplyname from product_applycart as pa left join crm_supplier as ss on ss.id=pa.supplyid where pa.applyid=$id and pa.status=1 order by pa.id asc ";
			$goods = $this->system->adminModel->fetchAll($sql);
		}
		$contract = ''; //合同
		if ($re['status'] >= 4) {
			$sql = "select pa.*,ss.title as supplyname from product_applycontract as pa left join crm_supplier as ss on ss.id=pa.supplyid where pa.applyid=$id";
			$contract = $this->system->adminModel->fetchAll($sql);
			//查询商品信息
			foreach ($contract as $k => $v) {
				$sql = "select title from product_applycart where status=1 and supplyid=" . $v['supplyid'] . " and applyid=" . $id;
				$res = $this->system->adminModel->fetchAll($sql);
				$contract[$k]['goods'] = $res;
			}
		}
		//操作记录
		$sql = "select * from product_applydata where applyid=" . $id;
		$log = $this->product->applydataModel->fetchAll($sql);
		//按时间重新组合日志  --开始
		$logs = array();
		foreach ($log as $k => $val) {
			$logs[date("Y-m-d", $val['created'])][] = $val;
		}
		//查看入库计划
		$sql = "select * from product_applystoreplan where ordernum='" . $re['ordernum'] . "' and status>=1";
		$plan = $this->product->applydataModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');

	}
	//库房部门---库房核验页面
	/* 	public function housestorelist(){

	$this->loadModel('product','applycart');
	$this->loadModel('product','applycartstore');
	$this->loadModel('product','applystoreplan');
	$ordernum	=	$_GET["ordernum"];
	$planid	= $plantag=	isset($_GET['planid'])?$_GET['planid']:0;
	$goodsstore	=	array();
	$goodscart	=	array();
	$plan		=	array();
	$planrow	=	array();
	$sql	=	"select * from product_apply where ordernum='".$ordernum."' ";
	$re	=	$this->product->applycartModel->fetchRow($sql);
	$sql	=	"select id,title,status from product_applystoreplan where ordernum='".$ordernum."' and status>=1";
	$plan	=	$this->product->applystoreplanModel->fetchAll($sql);


	$sql	=	"select pa.*,ss.title as supplyname,pat.title,pat.cashtype from product_applycartstore as pa left join crm_supplier as ss on ss.id=pa.supplyid left join product_applycart as pat on pat.id=pa.cartid where pa.planid=$planid and pa.status>=1 order by pa.id asc";

	$goodsstore	=	$this->product->applycartModel->fetchAll($sql);
	$planrow	=	$this->product->applycartModel->fetchRow("select * from product_applystoreplan where id=".$planid);



	include $this->loadWidget('amdinlteTheme');
	} */
	//库房部门---库房核验页面
	public function housestorelist() {

		$this->loadModel('product', 'applycart');
		$this->loadModel('product', 'applycartstore');
		$this->loadModel('product', 'applystoreplan');
		$ordernum = $_GET["ordernum"];
		$planid = $plantag = isset($_GET['planid']) ? $_GET['planid'] : 0;
		$goodsstore = array();
		$goodscart = array();
		$plan = array();
		$planrow = array();
		$sql = "select * from product_apply where ordernum='" . $ordernum . "' ";
		$re = $this->product->applycartModel->fetchRow($sql);
		$sql = "select id,title,status from product_applystoreplan where ordernum='" . $ordernum . "' and status>=1";
		$plan = $this->product->applystoreplanModel->fetchAll($sql);

		$sql = "select pa.*,ss.title as supplyname,pat.title,pat.cashtype from product_applycartstore as pa left join crm_supplier as ss on ss.id=pa.supplyid left join product_applycart as pat on pat.id=pa.cartid where pa.planid=$planid and pa.status>=1 order by pa.id asc";
		//$sql	=	"select pa.*,ptime.productendtime,ptime.puoshunnum,ptime.duanzhuangnum,ptime.yizhuangnum from product_applyproducttime as ptime left join product_applycartstore as pa on ap.id=ptime.cartstoreid where pa.planid=$planid and pa.status>=1 order by pa.id asc";
		$goodsstore = $this->product->applycartModel->fetchAll($sql);
		foreach ($goodsstore as $k => $val) {
			$sql = "select * from product_applyproducttime where cartstoreid=" . $val['id'];
			$r = $this->product->applycartModel->fetchAll($sql);
			$goodsstore[$k]['time'] = $r;
		}
		$planrow = $this->product->applycartModel->fetchRow("select * from product_applystoreplan where id=" . $planid);
		//print_r($goodsstore);exit;

		include $this->loadWidget('amdinlteTheme');
	}
	//库房核验结果 caiwustorelist
	public function housecheck() {
		$this->loadModel('product', 'applycart');
		$this->loadModel('product', 'applystoreplan');
		$this->loadModel('product', 'applycartstore');
		$this->loadModel('product', 'apply');
		$this->loadHelper('extend');
		$idarray = $_POST['id'];
		$applyid = $_POST['applyid'];

		$planid = $plantag = $_POST['planid'];
		$timeid = isset($_POST['timeid']) ? $_POST['timeid'] : '';
		if (empty($timeid)) {
			ajaxReturn('', '请联系采购部门填写商品保质期至', 0);exit;
		}

		$this->loadModel('product', 'applydata');

		$updatesql = "insert into product_applycartstore(id,barcode,realnumber,box,anytime,thmoney) values";
		$i = 0;
		$arraycartid = array();
		foreach ($idarray as $k => $val) {
			if (empty($_POST['realnumber'][$k])) {continue;}
			//if($_POST['isdep'][$k]==0){$_POST['depnum'][$k]=0;}
			$arraycartid[] = $_POST['cartid'][$k];
			if ($k == 0) {
				$updatesql .= "(" . $val . ",'" . $_POST['barcode'][$k] . "','" . $_POST['realnumber'][$k] . "','" . $_POST['box'][$k] . "'," . time() . ",'" . $_POST['thmoney'][$k] . "')";
			} else {
				$updatesql .= ",(" . $val . ",'" . $_POST['barcode'][$k] . "','" . $_POST['realnumber'][$k] . "','" . $_POST['box'][$k] . "'," . time() . ",'" . $_POST['thmoney'][$k] . "')";
			}
			$i++;
		}
		$updatesql .= "ON DUPLICATE KEY UPDATE barcode=values(barcode),realnumber=values(realnumber),box=values(box),anytime=values(anytime),thmoney=values(thmoney)";
		//echo $updatesql;exit;
		if ($i == 0) {

			$url = "http://" . ROOT_URL . "/index.php/iManage/buyer/editapplycaigou?id=$applyid";
			$r = array('info' => "操作失败", 'data' => 'url', 'state' => 1, 'url' => $url);
			echo json_encode($r);exit;
		}
		$cartidstr = implode(",", $arraycartid);
		//$this->product->applycartstoreModel->delete("planid=$planid and cartid in(".$cartidstr.")");
		$line = $this->product->applycartstoreModel->sqlexec($updatesql);
		/* $this->loadModel('product','apply');
		$data['status']	=	5;
		$line		=	$this->product->applyModel->update($data,'id='.$applyid); */
		if ($line >= 0) {
			//确损数量
			$updatetimesql = "insert into product_applyproducttime(id,puoshunnum,duanzhuangnum,yizhuangnum,anytime) values";
			foreach ($timeid as $k => $v) {
				$_POST['puoshunnum_' . $v] = $_POST['puoshunnum_' . $v] ? $_POST['puoshunnum_' . $v] : 0;
				$_POST['duanzhuangnum_' . $v] = $_POST['duanzhuangnum_' . $v] ? $_POST['duanzhuangnum_' . $v] : 0;
				$_POST['yizhuangnum_' . $v] = $_POST['yizhuangnum_' . $v] ? $_POST['yizhuangnum_' . $v] : 0;
				if ($k == 0) {
					$updatetimesql .= "(" . $v . "," . $_POST['puoshunnum_' . $v] . "," . $_POST['duanzhuangnum_' . $v] . "," . $_POST['yizhuangnum_' . $v] . "," . time() . ")";
				} else {
					$updatetimesql .= ",(" . $v . "," . $_POST['puoshunnum_' . $v] . "," . $_POST['duanzhuangnum_' . $v] . "," . $_POST['yizhuangnum_' . $v] . "," . time() . ")";
				}

			}
			$updatetimesql .= "ON DUPLICATE KEY UPDATE puoshunnum=values(puoshunnum),duanzhuangnum=values(duanzhuangnum),yizhuangnum=values(yizhuangnum),anytime=values(anytime)";
			//echo $updatetimesql;exit;
			$ls = $this->product->applycartstoreModel->sqlexec($updatetimesql);
			if (!$ls) {
				ajaxReturn('', '操作失败!', 0);exit;
			}
			$this->loadModel('product', 'applydata');
			$d['created'] = time();
			$d['truename'] = $this->info['truename'];
			$d['remark'] = $_POST['remark'];
			$d['applyid'] = $applyid;
			$d['results'] = "库房核验";
			$l = $this->product->applydataModel->insert($d);

			$url = "http://" . ROOT_URL . "/index.php/iManage/buyer/storeinfo?id=$applyid";
			$r = array('info' => "操作成功", 'data' => '', 'state' => 1, 'url' => $url);
			echo json_encode($r);exit;

		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}

	}
	//库房验收--审核
	public function housecheckpass() {
		$this->loadModel('product', 'applycart');
		$this->loadModel('product', 'applystoreplan');
		$this->loadModel('product', 'applycartstore');
		$this->loadModel('product', 'apply');
		$this->loadHelper('extend');
		$applyid = $_GET['applyid'];
		$planid = $plantag = $_GET['planid'];
		$this->loadModel('product', 'applydata');
		$dp['status'] = 2;
		$dp['sometimenouse'] = time();
		$t = $this->product->applystoreplanModel->update($dp, "id=" . $planid);

		if (!$t) {
			ajaxReturn('', '操作失败1', 0);exit;
		}
		$t = $this->product->applyModel->update(array('status' => 8, 'sometimenouse' => time()), "id=" . $applyid);
		if (!$t) {

			$dp['status'] = 1;
			$dp['sometimenouse'] = time();
			$t = $this->product->applystoreplanModel->update($dp, "id=" . $planid);
			ajaxReturn('', '操作失败2', 0);exit;
		}

		$url = "http://" . ROOT_URL . "/index.php/iManage/buyer/storeinfo?id=$applyid";
		$r = array('info' => "操作成功", 'data' => 'url', 'state' => 1, 'url' => $url);
		//$this->sendemailandmessage($applyid, 8);
		$this->tezhisendmessage($applyid, 8,'makeplanuserid');
		echo json_encode($r);exit;
		ajaxReturn('', '操作成功', 1);exit;

	}
	//采购入库 -1 无产品
	public function addgoodsstore($applyid, $planid) {
		$this->loadModel('product', 'log');
		$this->loadModel('product', 'goods');
		$this->loadModel('product', 'applycart');
		$this->loadModel('product', 'applyallianceprice');
		$this->loadModel('product', 'applycartstore');
		$this->loadModel('product', 'allianceprice');
		$this->loadModel('product', 'productontime');
		//将采购的新品导入商品库
		$sql	=	"select ordernum from product_apply where id=$applyid";
		$apply = $this->product->applycartModel->fetchRow($sql);
		//查看本次的商品
		$sql = "select pae.*,pac.title,pac.costprice,pac.suggestprice,pac.beoverdue,pac.futureprice,pac.supplyid from product_applycartstore as pae left join product_applycart as pac on pac.id=pae.cartid where pae.planid=" . $planid . " and pae.cwstatus=1";
		$re = $this->product->applycartModel->fetchAll($sql);

		$insertsql = "insert into product_goods(id,uuid,title,erpcode,barcode,specs,shelflife,boxnum,weight,costprice,suggestprice,beoverdue,futureprice,number)values";
		$loginsert	=	"insert into product_log(erpcode,title,type,number,username,boxnum,created,ordernum,hasnum) values";
		$i = 0;
		$upid = array();
		$created	=	time();
		foreach ($re as $k => $v) {
			//查询供应商 
			$sql	=	"select title from crm_supplier where id=".$v['supplyid'];
			$supply 		= $this->product->applycartModel->fetchRow($sql);
			if(!$supply){
				$supply['title']	=	'';
			}
			//查看是新品还是补采
			//$sql = "select id,number,uuid from product_goods where barcode='" . $v['barcode'] . "'";
			$sql = "select id,number,uuid from product_goods where erpcode='" . $v['erpcode'] . "'";
			$g = $this->product->applycartModel->fetchRow($sql);
			$goodsid = 0;
			$upid[] = $v['id'];
			//查看有没有保质期
			if($v['shelflife']){
			$sql	=	"select num from product_applyproducttime where cartstoreid=".$v['id'];
			$timenum = $this->product->applycartModel->fetchAll($sql);
			if(!$timenum){
				$comenumber=$number =ceil($v['number']/$v['boxnum']);
				}else{
					$vnum	=	0;
					foreach($timenum as $vtm){
						$vnum+=ceil($v['number']/$v['boxnum']);
					}
					$comenumber=$number =$vnum;
				}
			
			}else{
			$comenumber=$number = ceil($v['number']/$v['boxnum']);
			}
			//echo $v['number'].'--'.$v['boxnum'];exit;
			$uuid = 0;
			if ($g) {
				//补采
				$goodsid = $g['id'];
				$number = $number - 0 + $g['number'];
				$uuid = $g['uuid'];
				
			}
			if ($i == 0) {
				$insertsql .= "(" . $goodsid . ",";
				if (empty($uuid)) {
					$insertsql .= "uuid(),";
				} else {
					$insertsql .= "'" . $uuid . "',";
				}
				$insertsql .= "'" . $v['title'] . "','" . $v['erpcode'] . "','" . $v['barcode'] . "','" . $v['specs'] . "','" . $v['shelflife'] . "','" . $v['boxnum'] . "','" . $v['weight'] . "','" . $v['costprice'] . "','" . $v['suggestprice'] . "','" . $v['beoverdue'] . "','" . $v['futureprice'] . "','" . $number . "')";
				
				$loginsert.="('" . $v['erpcode'] . "','" . $v['title'] . "',0,'" . $comenumber . "','" . $supply['title'] . "','" . $v['boxnum'] . "',".$created.",'" . $apply['ordernum'] . "',".$number.")";
			} else {
				$insertsql .= ",(" . $goodsid . ",";
				if (empty($uuid)) {
					$insertsql .= "uuid(),";
				} else {
					$insertsql .= "'" . $uuid . "',";
				}
				$insertsql .= "'" . $v['title'] . "','" . $v['erpcode'] . "','" . $v['barcode'] . "','" . $v['specs'] . "','" . $v['shelflife'] . "','" . $v['boxnum'] . "','" . $v['weight'] . "','" . $v['costprice'] . "','" . $v['suggestprice'] . "','" . $v['beoverdue'] . "','" . $v['futureprice'] . "','" . $number . "')";
				//$loginsert	=	"insert into product_log(erpcode,title,type,number,username,boxnum,created,ordernum,hasnum) values";
				$loginsert.=",('" . $v['erpcode'] . "','" . $v['title'] . "',0,'" . $comenumber . "','" . $supply['title'] . "','" . $v['boxnum'] . "',".$created.",'" . $apply['ordernum'] . "',".$number.")";
			}
			$i++;

		}
		if ($i == 0) {
			return -1;
		}
		$insertsql .= " on duplicate key update title=values(title),erpcode=values(erpcode),barcode=values(barcode),specs=values(specs),shelflife=values(shelflife),boxnum=values(boxnum),weight=values(weight),costprice=values(costprice),suggestprice=values(suggestprice),beoverdue=values(beoverdue),futureprice=values(futureprice),number=values(number)";
		/* echo $insertsql;
		echo "<br>";
		echo $loginsert;exit; */
		$line = $this->product->goodsModel->sqlexec($insertsql);
		$this->product->logModel->sqlexec($loginsert);
		//echo $insertsql;exit;
		if (!$line) {
			return -2;
		}
		//修改状态
		$idss = implode(",", $upid);
		$this->product->applycartstoreModel->update(array('cwstatus' => 2), "id in(" . $idss . ")");
		
		
		
		/* //供应商类型对应的价格
		$sql = "select pat.id as cartid,pg.id as goodsid from product_applycart as pat left join product_goods as pg on pg.barcode=pat.barcode where pat.applyid=" . $applyid;
		$res = $this->product->goodsModel->fetchAll($sql);
		$insertsql2 = "insert into product_allianceprice(id,supplytypeid,goodsid,price)values";
		$goodsid = array();
		$j = 0;
		foreach ($res as $k => $v) {
			if (in_array($v['goodsid'], $goodsid)) {continue;}
			$goodsid[] = $v['goodsid'];
			$sql = "select * from product_applyallianceprice where cartid=" . $v['cartid'];
			$cart = $this->product->goodsModel->fetchAll($sql);
			if (!$cart) {continue;}
			$supplyprice = array();
			foreach ($cart as $val) {
				$supplyprice[$val['supplytypeid']] = $val['price'];
			}
			//查看商品库中的加盟商代理价
			$sql = "select * from product_allianceprice where goodsid=" . $v['goodsid'];
			$goodsprice = $this->product->goodsModel->fetchAll($sql);
			if (!$goodsprice) {
				//没有的情况下，，新增
				foreach ($supplyprice as $ke => $ve) {
					if ($j == 0) {
						$insertsql2 .= "(0," . $ke . "," . $v['goodsid'] . ",'" . $ve . "')";
					} else {
						$insertsql2 .= ",(0," . $ke . "," . $v['goodsid'] . ",'" . $ve . "')";
					}
					$j++;
				}
			} else {
				//商品库存在加盟商代理对应价格，修改
				foreach ($goodsprice as $va) {
					if (!isset($supplyprice[$va['supplytypeid']])) {continue;}
					if ($j == 0) {

						$insertsql2 .= "(" . $va['goodsid'] . "," . $val['supplytypeid'] . "," . $v['goodsid'] . ",'" . $supplyprice[$va['supplytypeid']] . "')";
					} else {
						$insertsql2 .= ",(" . $va['goodsid'] . "," . $val['supplytypeid'] . "," . $v['goodsid'] . ",'" . $supplyprice[$va['supplytypeid']] . "')";
					}
					$j++;
					unset($supplyprice[$va['supplytypeid']]);
				}
				if (!empty($supplyprice)) {
					//以前的加盟商代理数据不全--新增
					foreach ($supplyprice as $ke => $ve) {
						if ($j == 0) {
							$insertsql2 .= "(0," . $ke . "," . $v['goodsid'] . ",'" . $ve . "')";
						} else {
							$insertsql2 .= ",(0," . $ke . "," . $v['goodsid'] . ",'" . $ve . "')";
						}
						$j++;
					}

				}
			}

		}

		if ($j > 0) {
			$insertsql2 .= " on duplicate key update supplytypeid=values(supplytypeid),goodsid=values(goodsid),price=values(price)";
			$l = $this->product->goodsModel->sqlexec($insertsql2);
		}
		 */
		
		$goodsuuid=array();
		//到期时间对应的商品库存
		$sql = "select pat.id ,pg.uuid as goodsuuid,pg.id as goodsid,pg.boxnum,pg.number from product_applycartstore as pat left join product_goods as pg on pg.barcode=pat.barcode where pat.planid=" . $planid;
		$res = $this->product->goodsModel->fetchAll($sql);
		$insertsql3 = "insert into product_productontime(id,goodsuuid,productontime,num)values";
		$goodsid = array();
		$k = 0;
		$gnum=array();
		foreach ($res as $val) {
			if (in_array($val['goodsid'], $goodsid)) {continue;}
			$goodsid[] = $val['goodsid'];
			$sql = "select * from product_applyproducttime where planid=" . $planid . " and cartstoreid=" . $val['id'];

			$carttime = $this->product->goodsModel->fetchAll($sql);
			//echo $sql;
			//print_r($carttime);
			if (!$carttime) {continue;}
			$cartkeyvalue = array();
			foreach ($carttime as $vv) {
				if(empty($vv['productendtime'])){continue;}
				$val['boxnum']-=0;
				if(empty($val['boxnum'])){$val['boxnum']=1;}
				$cartkeyvalue[$vv['productendtime']] = ceil($vv['num']/$val['boxnum']);
			}
			//查看商品库的到期时间
			$sql = "select * from product_productontime where goodsuuid='" . $val['goodsuuid'] . "'";
			$gs = $this->product->goodsModel->fetchAll($sql);
			$gnum[$val['goodsid']]=isset($gnum[$val['goodsid']])?$gnum[$val['goodsid']]:0;
			$goodsuuid[]="'".$val['goodsuuid']."'";
			if (!$gs) {
				//新增
				
				foreach ($cartkeyvalue as $ke => $v) {
				$gnum[$val['goodsid']]=$gnum[$val['goodsid']]-0+$v;
					if ($k == 0) {
						$insertsql3 .= "(0,'" . $val['goodsuuid'] . "','" . $ke . "','" . $v . "')";
					} else {
						$insertsql3 .= ",(0,'" . $val['goodsuuid'] . "','" . $ke . "','" . $v . "')";
					}
					$k++;

				}
			} else {
				foreach ($gs as $vss) {
					if (!isset($cartkeyvalue[$vss['productontime']])) {continue;}
					$num = $vss['num'] - 0 + $cartkeyvalue[$vss['productontime']];
					$gnum[$val['goodsid']]=$gnum[$val['goodsid']]-0+$num;
					if ($k == 0) {
						$insertsql3 .= "(" . $vss['id'] . ",'" . $val['goodsuuid'] . "','" . $vss['productontime'] . "','" . $num . "')";
					} else {
						$insertsql3 .= ",(" . $vss['id'] . ",'" . $val['goodsuuid'] . "','" . $vss['productontime'] . "','" . $num . "')";
					}
					$k++;
					unset($cartkeyvalue[$vss['productontime']]);
				}
				if (!empty($cartkeyvalue)) {
					//新增
					foreach ($cartkeyvalue as $ke => $v) {
					$gnum[$val['goodsid']]=$gnum[$val['goodsid']]-0+$v;
						if ($k == 0) {
							$insertsql3 .= "(0,'" . $val['goodsuuid'] . "','" . $ke . "','" . $v . "')";
						} else {
							$insertsql3 .= ",(0,'" . $val['goodsuuid'] . "','" . $ke . "','" . $v . "')";
						}
						$k++;

					}
				}
			}
		}
		if ($k > 0) {
			$insertsql3 .= " on duplicate key update goodsuuid=values(goodsuuid),productontime=values(productontime),num=values(num)";

			$l = $this->product->productontimeModel->sqlexec($insertsql3);
			if($l){
			  $goodsuuid=array_unique($goodsuuid);
			 
			  if(!empty($goodsuuid)){
			  $uuidstr	=	implode(",",$goodsuuid);
			  $sql	=	"select sum(num) as number,goodsuuid from product_productontime where goodsuuid in(".$uuidstr.")";
			  $goodsnumberarray=$this->product->productontimeModel->fetchAll($sql);
			  
			  foreach($goodsnumberarray as $val){
				$this->product->goodsModel->update(array('number'=>$val['number']),"uuid='".$val['goodsuuid']."'");
			  }
			  }
			}
			/* print_r($l);
			echo $insertsql3;exit; */
		}
		return 1;
	}
	//取消采购
	public function canselapply() {
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applydata');
		$this->loadModel('product', 'applystoreplan');
		$this->loadHelper('extend');
		$cf = $this->sysconf['purchasestatuscansel'];
		$status = $_POST['status'];
		$id = $_POST['applyid'];
		$remark = $_POST['remark'];

		$datas['status'] = $cf[$status];
		$datas['sometimenouse'] = time();

		$line = $this->product->applyModel->update($datas, "id=$id");
		if ($line) {
			//采购人员的备注信息

			$d['results'] = "取消采购";
			$d['created'] = time();
			$d['truename'] = $this->info['truename'];
			$d['remark'] = $remark;
			$d['applyid'] = $id;
			$l = $this->product->applydataModel->insert($d);
			//$this->sendemailandmessage($id, $datas['status']);
			//$this->tezhisendmessage($id, $datas['status'],'memberid');
			if ($l) {
				ajaxReturn('', '操作成功', 1);exit;
			} else {
				ajaxReturn('', '操作失败', 0);exit;
			}
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}

	}

	//财务确认，取消采购
	public function cancelsurecw() {
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applydata');
		$this->loadModel('product', 'applystoreplan');
		$this->loadHelper('extend');
		$cf = $this->sysconf['purchasestatuscansel'];
		$status = $sendstatus = $_POST['status'];
		$id = $_POST['applyid'];
		$remark = $_POST['remark'];
		$tag = $_POST['tag'];
		if ($tag == 1) {
			$datas['iscansel'] = 1;
			$d['results'] = "财务确认采购取消";
		} else {
			$ncf = array_flip($cf);
			$datas['status'] = $sendstatus = $ncf[$status];
			$d['results'] = "采购取消财务确认不通过，继续采购";
		}
		$datas['sometimenouse'] = time();

		$line = $this->product->applyModel->update($datas, "id=$id");
		if ($line) {
			//采购人员的备注信息

			// $d['results']	=	"取消采购";
			$d['created'] = time();
			$d['truename'] = $this->info['truename'];
			$d['remark'] = $remark;
			$d['applyid'] = $id;
			$l = $this->product->applydataModel->insert($d);
			//$this->sendemailandmessage($id, $sendstatus);
			//$this->tezhisendmessage($id, $sendstatus,'memberid');
			if ($l) {

				ajaxReturn('', '操作成功', 1);exit;
			} else {
				ajaxReturn('', '操作失败', 0);exit;
			}
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}

	}
	//商品选择库位
	public function selgoodspos(){
		$erpcode	=	$_GET['erpcode'];
		$ordernum	=	$_GET['ordernum'];
		$this->loadModel('product', 'relation');
		$this->loadModel('product', 'goods');
		if(empty($erpcode)){
			$erpcode	=	"test";
		}
		//通过erpcode得到商品id
		$sql	=	"select id from product_goods where erpcode='".$erpcode."'";
		$re		=		$this->product->goodsModel->fetchRow($sql);
		//$re['id']	=	1;
		if(!$re){die("新采购商品须先入库再选择库位");}
		//通过商品id查询库位表
		$sql	=	"select * from product_relation where goodsid='".$re['id']."'";
		$res		=		$this->product->goodsModel->fetchAll($sql);
		$goodspos	=	array();
		if($res){
		foreach($res as $val){
			$goodspos[]	=	$val['houseposid'];
		}
		}
		//查询库位--先查询库房，库房默认为第一个
		$sql	=	"select * from product_house ";
		$house		=		$this->product->goodsModel->fetchRow($sql);
		if(!$house){
			die("还未设置库房");
		}
		//再通过库房查询库位
		$sql	=	"select * from product_housepos where houseid=".$house['id']." order by floortitle asc,myrows asc,colspan asc";
		$pos		=		$this->product->goodsModel->fetchAll($sql);
		
		$posarray = array();
		$num = $house['rows'] * $house['cols'];
		foreach ($pos as $k => $v) {
			$i = floor($k / $num);
			$j = floor($k / $house['cols']);
			$posarray[$i][$j][] = $v;
		}
		include $this->loadWidget('amdinlteTheme');
	}
	//提交库位
	public function goodspostj(){
		$this->loadHelper('extend');
		$this->loadModel('product', 'relation');
		$this->loadModel('product', 'goods');
		$houseid	=	$_POST['houseid'];
		$goodsid	=	$_POST['goodsid'];
		$ordernum	=	$_POST['ordernum'];
		$posid	=	isset($_POST['posid'])?$_POST['posid']:'';
		if(empty($posid)){
			ajaxReturn('', '未选择库位', 0);exit;
		}
		$this->product->relationModel->delete("ordernum='".$ordernum."' and goodsid=".$goodsid);
		//添加
		$insertsql	=	"insert into product_relation (goodsid,houseid,houseposid,ordernum) values";
		foreach($posid as $k=>$houseposid){
			if($k==0){
				$insertsql.="(".$goodsid.",".$houseid.",".$houseposid.",'".$ordernum."')";
			}else{
				$insertsql.=",(".$goodsid.",".$houseid.",".$houseposid.",'".$ordernum."')";
			}
		}
		$line	=	$this->product->relationModel->sqlexec($insertsql);
		if($line){
		ajaxReturn('', '操作成功', 1);exit;
		}else{
		ajaxReturn('', '操作失败', 0);exit;
		}
	}
	//得到编码
	public function  geterpcode(){
		$id=$_POST['id'];
		$barcode=$_POST['barcode'];
		$data=	array('id'=>$id,'barcode'=>$barcode,'info'=>'该商品有多个编码,请手动填写','erpcode'=>'','state'=>0);
		if(empty($barcode)){
			$data['info']='商品条码不能为空';
			echo json_encode($data);exit;
		}
		
		$this->loadModel('product', 'applycart');
		$sql="select * from product_applycart where id=$id";
		$re=	$this->product->applycartModel->fetchRow($sql);
		
		if($re['cashtype']=='新品'){
			$sql="select * from erpcode from prduct_goods where barcode='".$barcode."' order by erpcode desc";
			$goods=$this->product->applycartModel->fetchRow($sql);
			$data['erpcode']=$barcode.'a';
			
			if($goods){
				
				if(!empty($goods['erpcode'])){
					$code=substr($goods['erpcode'],-1);
					switch($code){
						case 'a':$c='b';break;
						case 'a':$c='c';break;
						case 'a':$c='d';break;
						default :$c='a';break;
					}
					$data['erpcode']=$barcode.$c;
				
				}
				
			}
				$data['state']=1;
		
		}else{
			$sql="select * from erpcode from prduct_goods where barcode='".$barcode."' ";
			$goodsre=$this->product->applycartModel->fetchAll($sql);
			if(count($goodsre)>1){
				$data['info']='该商品有多个编码,请手动填写';
			}else if(count($goodsre)==1){
					if(!empty($goodsre[0]['erpcode'])){
					$code=substr($goodsre[0]['erpcode'],-1);
					switch($code){
						case 'a':$c='b';break;
						case 'a':$c='c';break;
						case 'a':$c='d';break;
						default :$c='a';break;
					}
					$data['erpcode']=$barcode.$c;
					$data['state']=1;
					}else{
						$data['erpcode']=$barcode.'a';
						$data['state']=1;
					}
			}else{
				$data['erpcode']=$barcode.'a';
				$data['state']=1;
			}
		}
		echo json_encode($data);exit;
	}
	//得到条码 4-12随机
	public function getbarcode(){
		$data['id']=$_POST['id'];
		$data['barcode']="400".rand(100000000,999999999);
		$data['barcode']	=	$this->EAN13($data['barcode']);
		//查看该条码是否存在
		$sql	=	"select id from product_goods where barcode='".$data['barcode']."'";
		$this->loadModel('product', 'goods');
		$goods = $this->product->goodsModel->fetchRow($sql);
		if($goods){
			$data['barcode']="400".rand(100000000,999999999);
			$data['barcode']	=	$this->EAN13($data['barcode']);
		}
		$sql	=	"select id from product_goods where barcode='".$data['barcode']."'";
		$this->loadModel('product', 'goods');
		$goods = $this->product->goodsModel->fetchRow($sql);
		if($goods){
			$data['barcode']	=	'';
		}
		echo json_encode($data);exit;
	}
	public function EAN13($n){
        $n=(string)$n;
        $a=(($n[1]+$n[3]+$n[5]+$n[7]+$n[9]+$n[11])*3+$n[0]+$n[2]+$n[4]+$n[6]+$n[8]+$n[10])%10;
        $a=$a==0?0:10-$a;
        return $n.$a;
    }
	//发送邮件及短信
	public function tezhisendmessage($applyid, $status,$key='zgid') {
		set_time_limit(0);
		$this->loadModel("product", "messageremind");
		$keyword = "caigou";
		
		$sql = "select * from product_apply where id=" . $applyid;
		$apply = $this->product->messageremindModel->fetchRow($sql);
		
		$sql	=	"select * from system_admin where id=".$apply[$key];
		$user = $this->product->messageremindModel->fetchAll($sql);
		//smtp配置
		$sql = "select * from system_setting";
		$set = $this->product->messageremindModel->fetchAll($sql);
		$this->loadHelper('encrypt');
		$en = new encrypt();
		$this->loadHelper('extend');
		$this->loadHelper('smtp');
		//$data = $_POST['data'];
		$smtpserver = $set[4]['value'];
		$smtpserverport = $set[5]['value'];
		$smtpusermail = $set[6]['value'];
		$temparr = explode('@', $smtpusermail);
		$smtpuser = $temparr[0];
		$smtppass = $en->decode($set[8]['value']);
		//邮件主题
		$mailsubject = "您有一个采购须要处理";
		//邮件内容
		$mailbody = "采购订单号：" . $apply['ordernum'];
		//邮件格式（HTML/TXT）,TXT为文本邮件
		$mailtype = "HTML";
		//这里面的一个true是表示使用身份验证,否则不使用身份验证.
		$smtp = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
		if ($user) {
			//给内部员工发送邮件及短信
			foreach ($user as $val) {
				if (!empty($val['email'])) {
					$re = $smtp->sendmail($val['email'], $smtpusermail, $mailsubject, $mailbody, $mailtype);
					
				}
				if (!empty($val['mobile'])) {
					$str = $apply['ordernum'];
					$re = $this->sendmessage($str, $val['mobile']);
				}
			}
		}

	}
	
	public function sendemailandmessage($applyid, $status) {
		set_time_limit(0);
		$this->loadModel("product", "messageremind");
		$keyword = "caigou";
		$sql = "select sa.* from product_messageremind as pm left join system_admin as sa on sa.id=pm.userid  where pm.keyword='" . $keyword . "' and orderstatus=" . $status;
		$user = $this->product->messageremindModel->fetchAll($sql);
		$sql = "select * from product_apply where id=" . $applyid;
		$apply = $this->product->messageremindModel->fetchRow($sql);

		//smtp配置
		$sql = "select * from system_setting";
		$set = $this->product->messageremindModel->fetchAll($sql);
		$this->loadHelper('encrypt');
		$en = new encrypt();
		$this->loadHelper('extend');
		$this->loadHelper('smtp');
		//$data = $_POST['data'];
		$smtpserver = $set[4]['value'];
		$smtpserverport = $set[5]['value'];
		$smtpusermail = $set[6]['value'];
		$temparr = explode('@', $smtpusermail);
		$smtpuser = $temparr[0];
		$smtppass = $en->decode($set[8]['value']);
		//邮件主题
		$mailsubject = "您有一个采购须要处理";
		//邮件内容
		$mailbody = "采购订单号：" . $apply['ordernum'];
		//邮件格式（HTML/TXT）,TXT为文本邮件
		$mailtype = "HTML";
		//这里面的一个true是表示使用身份验证,否则不使用身份验证.
		$smtp = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
		if ($user) {
			//给内部员工发送邮件及短信
			foreach ($user as $val) {
				if (!empty($val['email'])) {
					$re = $smtp->sendmail($val['email'], $smtpusermail, $mailsubject, $mailbody, $mailtype);
				}
				if (!empty($val['mobile'])) {
					$str = $apply['ordernum'];
					$re = $this->sendmessage($str, $val['mobile']);
				}
			}
		}

	}

	//发送短信通知

	public function sendmessage($str, $mobile) {

		$this->loadHelper('sms');

		$sms = new sms();

		$bk = $sms->send_sys_message($str, $mobile);
		//  print_r($bk);exit;
		return $bk;
	}

}
?>