<?php

/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */

class orderback extends actionAbstract {
	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 10;
	public $type = 0;
	public $leftpos = 1;
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
		// $this->info = acl::checkLogin('admininfo',$this->url('common/login'));
		if (!isset($_SESSION['admininfo'])) {header('location:' . $this->url('common/login'));}$this->info = $_SESSION['admininfo'];
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		$this->conf = $this->loadConfig('sysconf');
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			//ajax request
			$this->checkpower();
		}
	}

	//退货单列表
	public function lists() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'orderback');
		$sql = "select * from franchisee_order where orderbackstatus>0   and ( userid=" . $this->info['id'] . " or backdirectorid=" . $this->info['id'] . ")";
		$re = $this->franchisee->orderbackModel->fetchAll($sql);
		$sysconf = $this->loadConfig('sysconf');
		include $this->loadWidget('amdinlteTheme');
	}
	//可以退货的订单
	public function canbackorder() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'order');
		$sql = "select fo.*,fa.shoppname from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where (fo.status=3 or fo.status=4) and fo.userid=" . $this->info['id'] . " and fo.orderbackstatus=0";
		//	$sql	=	"select * from franchisee_order where (status=3 or status=4) and 1=1 ";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		$sysconf = $this->loadConfig('sysconf');
		include $this->loadWidget('amdinlteTheme');
	}
	//添加退货单---销售退货单详情
	public function add() {
		$token = $_GET['token'];
		$ordernum = $_GET['ordernum'];
		$userinfo = $this->getAllianceInfo($token);
		$this->loadModel('franchisee', 'orderinfo');
		$sql = "select fo.*,sa.truename from franchisee_order as fo left join system_admin as sa on sa.id=fo.backdirectorid where fo.ordernum='" . $ordernum . "'";
		$order = $this->franchisee->orderinfoModel->fetchRow($sql);
		if ($order['backstatus'] == 0) {
			$sql = "select fo.ordernum,fo.productontime,fo.id as ofid,fo.tag,fo.goodsid as id,fo.realbacknum,pg.beoverdue,pg.shelflife,fo.num as buynum,fo.price as buyprice,fo.backnum,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id  where fo.ordernum='" . $ordernum . "' ";
		} else {
			$sql = "select fo.ordernum,fo.productontime,fo.id as ofid,fo.tag,fo.goodsid as id,fo.realbacknum,pg.beoverdue,pg.shelflife,fo.num as buynum,fo.price as buyprice,fo.backnum,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id  where fo.ordernum='" . $ordernum . "' and fo.backnum>0";
		}
		$goods = $this->franchisee->orderinfoModel->fetchAll($sql);

		//后台管理员
		if ($order['backstatus'] == 0) {
			$sql = "select * from system_admin where status=1";
			$admin = $this->franchisee->orderinfoModel->fetchAll($sql);

		}

		//查看历史记录
		$sql = "select * from franchisee_orderdata where orderid=" . $order['id'] . "  and type=1";
		$log = $this->franchisee->orderinfoModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}

	//退货商品
	public function updatebackgoods() {
		$this->loadModel('franchisee', 'orderbackinfo');
		$this->loadModel('franchisee', 'orderback');
		$this->loadModel('franchisee', 'order');
		$this->loadHelper("extend");

		if (!isset($_POST['ofid'])) {
			ajaxReturn('', '未选择退货商品', 0);
		}
		$id = $_POST['id'];
		$ordernum = $_POST['ordernum'];
		$order = $this->franchisee->orderbackinfoModel->fetchRow("select id,ordernum from franchisee_order where ordernum='" . $ordernum . "'");

		$sql = "insert into franchisee_orderinfo(id,backnum) values";
		$tag = false;
		$i = 0;
		foreach ($_POST['ofid'] as $k => $val) {
			if (!empty($_POST['goodsnum_' . $val])) {
				//ajaxReturn ( '', '未选择退货商品数量', 0 );

				$tag = true;
			} else {
				$_POST['goodsnum_' . $val] = 0;
			}
			if ($_POST['buynum_' . $val] < $_POST['goodsnum_' . $val]) {
				ajaxReturn('', '退货数量不能大于订货数量', 0);
			}

			if ($i == 0) {
				$sql .= "(" . $val . "," . $_POST['goodsnum_' . $val] . ")";
			} else {
				$sql .= ",(" . $val . "," . $_POST['goodsnum_' . $val] . ")";
			}
			$i++;
		}
		if (!$tag) {
			ajaxReturn('', '未选择退货商品数量', 0);
		}
		$data = $_POST['data'];
		$data['backstatus'] = 1;
		$data['orderbackcreated'] = time();
		$data['backordernum'] = "t-" . $order['ordernum'];
		$line = $this->franchisee->orderModel->update($data, "ordernum='" . $ordernum . "'");
		$sql .= " on duplicate key update backnum=values(backnum)";
		//echo $sql;exit;

		if ($line) {
			$this->franchisee->orderbackinfoModel->sqlexec($sql);

			$data = array();
			$data['orderid'] = $order['id'];
			$data['truename'] = $this->info['truename'];
			$data['created'] = time();
			$data['type'] = 1;
			$data['results'] = "加盟商退货";
			$this->loadModel('franchisee', 'orderdata');
			$this->franchisee->orderdataModel->insert($data);
			$this->tezhisendmessage($order['id'], 1,'backdirectorid');
			ajaxReturn('', '操作成功', 1);

		} else {
			ajaxReturn('', '操作失败', 0);
		}

	}
	//销售反审
	public function backorderreturnxs() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data = $_POST['data'];

			$datas['backstatus'] = 0;

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			if ($line) {
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();
				$data['type'] = 1;
				$data['results'] = "反审";
				$this->franchisee->orderdataModel->insert($data);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//复核
	public function backorderfh() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];

			$datas['backstatus'] = 4;
			$datas['backremarkfh'] = $_POST['data']['backremarkfh'];

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			if ($line) {
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();
				$data['type'] = 1;
				$data['remark'] = $datas['backremarkfh'];
				$data['results'] = "业务经理复核";
				$this->franchisee->orderdataModel->insert($data);
				$this->sendemailandmessage($id, 4);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//主管审批
	public function directorcheck() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data = $_POST['data'];

			if ($data['results'] == 1) {
				$datas['backstatus'] = 2;
			} else {
				$datas['backstatus'] = -1;
			}

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			if ($line) {
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();
				$data['type'] = 1;
				$results = array('0' => '主管审批通过', '1' => '主管审批不通过');
				$data['results'] = $results[$data['results']];
				$this->franchisee->orderdataModel->insert($data);
				$this->sendemailandmessage($id, $datas['backstatus']);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//主管反审
	public function directorcheckback() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data = $_POST['data'];

			$datas['backstatus'] = 1;

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			if ($line) {
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();
				$data['type'] = 1;
				$data['results'] = "主管反审";
				$this->franchisee->orderdataModel->insert($data);
				$this->tezhisendmessage($id, 1);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//库房验收订单列表 orderinfohouse
	public function orderhouselists() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'orderback');
		$sql = "select * from franchisee_order where backstatus>=2 ";
		$re = $this->franchisee->orderbackModel->fetchAll($sql);
		$sysconf = $this->loadConfig('sysconf');
		include $this->loadWidget('amdinlteTheme');
	}
	//库房订单详情
	public function orderinfohouse() {
		$token = $_GET['token'];
		$ordernum = $_GET['ordernum'];
		$userinfo = $this->getAllianceInfo($token);
		$this->loadModel('franchisee', 'orderinfo');
		$sql = "select fo.*,sa.truename from franchisee_order as fo left join system_admin as sa on sa.id=fo.backdirectorid where fo.ordernum='" . $ordernum . "'";
		$order = $this->franchisee->orderinfoModel->fetchRow($sql);
		if ($order['backstatus'] == 0) {
			$sql = "select fo.ordernum,fo.productontime,fo.id as ofid,fo.tag,fo.goodsid as id,fo.realbacknum,pg.beoverdue,pg.shelflife,fo.num as buynum,fo.price as buyprice,fo.backnum,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id  where fo.ordernum='" . $ordernum . "' and fo.backnum>0";
		} else {
			$sql = "select fo.ordernum,fo.productontime,fo.id as ofid,fo.tag,fo.goodsid as id,fo.realbacknum,pg.beoverdue,pg.shelflife,fo.num as buynum,fo.price as buyprice,fo.backnum,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id  where fo.ordernum='" . $ordernum . "' and fo.backnum>0";
		}
		$goods = $this->franchisee->orderinfoModel->fetchAll($sql);

		//后台管理员
		if ($order['backstatus'] == 0) {
			$sql = "select * from system_admin where status=1";
			$admin = $this->franchisee->orderinfoModel->fetchAll($sql);

		}

		//查看历史记录
		$sql = "select * from franchisee_orderdata where orderid=" . $order['id'] . "  and type=1";
		$log = $this->franchisee->orderinfoModel->fetchAll($sql);
		//查看送货员
		$sql = "select * from system_admin where status=1";
		$user = $this->franchisee->orderinfoModel->fetchAll($sql);
		//查询库房人员信息
		$sql = "select fo.*,sa.truename as yanhuoname,san.truename as instorename from franchisee_orderbackhouse as fo left join system_admin as sa on fo.yanhuoid=sa.id left join system_admin as san on fo.instoreid=san.id where orderid=" . $order['id'];
		$houseinfo = $this->franchisee->orderinfoModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}

	//库房修改
	public function houseupdatebackgoods() {
		$this->loadModel('franchisee', 'orderbackinfo');
		$this->loadModel('franchisee', 'orderback');
		$this->loadModel('franchisee', 'order');
		$this->loadHelper("extend");

		if (!isset($_POST['ofid'])) {
			ajaxReturn('', '未选择退货商品', 0);
		}

		$ordernum = $_POST['ordernum'];

		$sql = "insert into franchisee_orderinfo(id,realbacknum) values";
		$tag = false;
		$i = 0;
		foreach ($_POST['ofid'] as $k => $val) {
			if ($_POST['goodsnum_' . $val] == '') {
				ajaxReturn('', '未填写实到退货商品数量', 0);
			}

			if ($i == 0) {
				$sql .= "(" . $val . "," . $_POST['goodsnum_' . $val] . ")";
			} else {
				$sql .= ",(" . $val . "," . $_POST['goodsnum_' . $val] . ")";
			}
			$i++;
		}

		$data = $_POST['data'];
		if ($data['results'] == 1) {
			$datas['housestatus'] = 1;
		} else {
			$datas['backstatus'] = 0;
		}

		$line = $this->franchisee->orderModel->update($datas, "ordernum='" . $ordernum . "'");
		$sql .= " on duplicate key update realbacknum=values(realbacknum)";
		//echo $sql;exit;

		if ($line) {
			$this->franchisee->orderbackinfoModel->sqlexec($sql);

			$order = $this->franchisee->orderbackinfoModel->fetchRow("select id from franchisee_order where ordernum='" . $ordernum . "'");
			$data = array();
			$data['orderid'] = $order['id'];
			$data['truename'] = $this->info['truename'];
			$data['created'] = time();
			$data['type'] = 1;

			$data['results'] = "退货实到商品数量";
			$this->loadModel('franchisee', 'orderdata');
			$this->franchisee->orderdataModel->insert($data);
			
			if(isset($datas['backstatus']) && $datas['backstatus'] == 0){
			$this->tezhisendmessage($order['id'], 0,'userid');
			}
			
			ajaxReturn('', '操作成功', 1);

		} else {
			ajaxReturn('', '操作失败', 0);
		}

	}

	//库房反审

	public function housecheckbackfirst() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data = $_POST['data'];

			$datas['housestatus'] = 0;

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			if ($line) {
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();
				$data['type'] = 1;
				$data['results'] = "库房确认实到数量后反审";
				$this->franchisee->orderdataModel->insert($data);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//库房反审

	public function housecheckback() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data = $_POST['data'];

			$datas['backstatus'] = 2;

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			if ($line) {
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();
				$data['type'] = 1;
				$data['results'] = "库房配货完成后反审";
				$this->franchisee->orderdataModel->insert($data);
				
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//物流模板---库房 product_general franchisee_orderlogistics
	public function sellogistics() {
		$this->loadModel('franchisee', 'orderlogistics');
		$id = $_POST['id'];
		$generalid = $_POST['generalid'];
		$sql = "select companystart,mobilestart,usernamestart,companyarrive,mobilearrive,usernamearrive from franchisee_orderlogistics where id=$id and generalid=$generalid";
		$re = $this->franchisee->orderlogisticsModel->fetchRow($sql);
		if (!$re) {
			$sql = "select companystart,mobilestart,usernamestart,companyarrive,mobilearrive,usernamearrive from product_general where  id=$generalid";
			$re = $this->franchisee->orderlogisticsModel->fetchRow($sql);
		}
		echo json_encode($re);
	}

	//配货处理
	public function preparegoods() {
		$id = $_GET['id']; //orderinfo 的id
		$ordernum = $_GET['ordernum'];
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderinfo');
		$re = $this->franchisee->orderModel->fetchRow("select ordernum from franchisee_order where ordernum='" . $ordernum . "' and status>=1");
		$res = array();
		//print_r($re);exit;
		if ($re) {

			$sql = "select foi.*,pg.title,pg.boxnum,pg.barcode,pg.beoverdue,pg.uuid as goodsuuid,pg.shelflife,pg.specs,pg.number as goodsnumber from franchisee_orderinfoprepare as foi left join product_goods as pg on pg.id=foi.goodsid   where foi.orderinfoid='" . $id . "'";
			$res = $this->franchisee->orderinfoModel->fetchAll($sql);

		}
		$info = $this->franchisee->orderinfoModel->fetchRow("select realbacknum from franchisee_orderinfo where id=$id");
		include $this->loadView();
	}

	//提交批货处理
	public function preparegoodstj() {
		$url = $this->url('orderback/preparegoods', array('id' => $_POST['orderinfoid'], 'ordernum' => $_POST['ordernum']));
		if (isset($_POST['asl'])) {
			$asl = $_POST['asl']; //分配数量
			$insertSql = "insert into franchisee_orderinfoprepare(id,realbacknum)values";
			$allnum = 0;
			foreach ($asl as $k => $val) {
				if (empty($val)) {
					//echo "<script>alert('分配数量不能为空');window.location.href='".$url."';</script>";exit;
					$val = 0;
				}
				$allnum += $val;
				if ($k == 0) {
					$insertSql .= "(" . $_POST['id'][$k] . "," . $val . ")";
				} else {
					$insertSql .= ",(" . $_POST['id'][$k] . "," . $val . ")";
				}
			}
			$insertSql .= " on duplicate key update realbacknum=values(realbacknum)";
			$this->loadModel('franchisee', 'orderinfoprepare');
			//查看该退货数量
			$sql = "select realbacknum from franchisee_orderinfo where id=" . $_POST['orderinfoid'];
			$checkre = $this->franchisee->orderinfoprepareModel->fetchRow($sql);
			if ($checkre['realbacknum'] != $allnum) {
				echo "<script>alert('分配数量与该商品实际退货数量不匹配');window.location.href='" . $url . "';</script>";exit;
			}

			//$this->franchisee->orderinfoprepareModel->delete('orderinfoid='.$_POST['orderinfoid'].' and goodsid='.$_POST['goodsid']);
			$tag = $this->franchisee->orderinfoprepareModel->sqlexec($insertSql);
			if ($tag) {
				echo "<script>alert('分配成功');window.location.href='" . $url . "';</script>";exit;
			} else {
				echo "<script>alert('分配失败');window.location.href='" . $url . "';</script>";exit;
			}
		} else {
			echo "<script>window.location.href='" . $url . "';</script>";exit;

		}

	}

	//库房完成配货操作
	public function houseupdatebackgoodspeihuo() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadModel('franchisee', 'orderbackhouse');
		$this->loadHelper("extend");
		if ($_POST) {
			$ordernum = $_POST['ordernum'];
			$id = $_POST['id'];
			$data = $_POST['data'];

			$datas['backstatus'] = 3;
			$datas['housestatus'] = 1;
			//查看是否配货完成，及正确----orderinfo与franchisee_orderinfoprepare 比较

			//配货表
			$sql = "select orderinfoid,realbacknum from franchisee_orderinfoprepare where ordernum='" . $ordernum . "' ";
			$preparecheck = $this->franchisee->orderModel->fetchAll($sql);
			$preparearray = array();
			foreach ($preparecheck as $val) {

				$preparearray[$val['orderinfoid']] = isset($preparearray[$val['orderinfoid']]) ? $preparearray[$val['orderinfoid']] + $val['realbacknum'] : $val['realbacknum'];
			}
			//两者进行比较
			$sql = "select id,realbacknum,goodsid from franchisee_orderinfo where ordernum='" . $ordernum . "' ";
			$infocheck = $this->franchisee->orderModel->fetchAll($sql);
			$infoarray = array();
			$goodsid = array();
			foreach ($infocheck as $key => $val) {
				if ($val['realbacknum'] != $preparearray[$val['id']]) {
					$goodsid[] = $val['goodsid'];
				}
			}
			if (!empty($goodsid)) {
				$goodsidstr = implode(',', $goodsid);
				$sql = "select title from product_goods where id in($goodsidstr)";
				$goods = $this->franchisee->orderModel->fetchAll($sql);
				$str = '操作失败,以下商品实到数量与匹配数量不符：<br>';
				foreach ($goods as $k => $v) {
					if ($k == 0) {
						$str .= $v['title'];
					} else {
						$str .= ',&nbsp;&nbsp;' . $v['title'];
					}
				}
				ajaxReturn('', $str, 0);
			}
			$datas['anytime']	=	time();
			if (!empty($_FILES['files']['name'])) {
					$this->loadHelper('uploader');
					$uploader = new uploader();
					$data['filepath'] = $uploader->start('files');
					$data['filetitle'] = $_FILES['files']['name'];
				} else {
					ajaxReturn('', '未上传供应商物流单', 0);exit;
				}
			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			
			if ($line) {
				
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['yanhuotime'] = strtotime($data['yanhuotime']);
				$this->franchisee->orderbackhouseModel->delete("orderid=" . $id);
				$this->franchisee->orderbackhouseModel->insert($data);

				$data = array();
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();
				$data['type'] = 1;
				$data['results'] = "库房配货";
				$this->franchisee->orderdataModel->insert($data);
				$this->tezhisendmessage($id,$datas['backstatus'],'userid');
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}

	//财务订单列表 orderinfohouse
	public function caiwulists() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'orderback');
		$sql = "select * from franchisee_order where backstatus>=4 ";
		$re = $this->franchisee->orderbackModel->fetchAll($sql);
		$sysconf = $this->loadConfig('sysconf');
		include $this->loadWidget('amdinlteTheme');
	}
	//财务订单详情
	public function orderinfocaiwu() {
		$token = $_GET['token'];
		$ordernum = $_GET['ordernum'];
		$userinfo = $this->getAllianceInfo($token);
		$this->loadModel('franchisee', 'orderinfo');
		$sql = "select fo.*,sa.truename from franchisee_order as fo left join system_admin as sa on sa.id=fo.backdirectorid where fo.ordernum='" . $ordernum . "'";
		$order = $this->franchisee->orderinfoModel->fetchRow($sql);

		$sql = "select fo.ordernum,fo.productontime,fo.id as ofid,fo.tag,fo.goodsid as id,fo.realbacknum,pg.beoverdue,pg.shelflife,fo.num as buynum,fo.price as buyprice,fo.backnum,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id  where fo.ordernum='" . $ordernum . "' and fo.backnum>0";
		$sql = "select foe.id as foeid,foe.ordernum,foe.allprice,foe.productontime,foe.num as buynum,foe.realbacknum,foe.backmoney,fo.id,fo.tag,fo.price as buyprice,pg.beoverdue,pg.shelflife,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfoprepare as foe left join franchisee_orderinfo as fo on fo.id=foe.orderinfoid left join product_goods as pg on foe.goodsid=pg.id where foe.ordernum='" . $ordernum . "' and foe.realbacknum>0";
		$goods = $this->franchisee->orderinfoModel->fetchAll($sql);

		//后台管理员
		if ($order['backstatus'] == 0) {
			$sql = "select * from system_admin where status=1";
			$admin = $this->franchisee->orderinfoModel->fetchAll($sql);

		}

		//查看历史记录
		$sql = "select * from franchisee_orderdata where orderid=" . $order['id'] . "  and type=1";
		$log = $this->franchisee->orderinfoModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//财务审核 franchisee_orderinfoprepare

	public function caiwucheck() {

		$this->loadModel('franchisee', 'orderinfoprepare');
		$this->loadModel('franchisee', 'orderback');
		$this->loadModel('franchisee', 'order');
		$this->loadHelper("extend");

		if (!isset($_POST['ofid'])) {
			ajaxReturn('', '未选择退货商品', 0);
		}
		$datas['backstatus'] = 5;
		$datas['backmoney'] = 0;
		$ordernum = $_POST['ordernum'];

		$sql = "insert into franchisee_orderinfoprepare(id,backmoney) values";
		$tag = false;
		$i = 0;
		foreach ($_POST['ofid'] as $k => $val) {
			if ($_POST['backmoney_' . $val] == '') {
				ajaxReturn('', '操作失败', 0);
			}

			if ($i == 0) {
				$sql .= "(" . $val . "," . $_POST['backmoney_' . $val] . ")";
			} else {
				$sql .= ",(" . $val . "," . $_POST['backmoney_' . $val] . ")";
			}
			$datas['backmoney'] = $datas['backmoney'] - 0 + $_POST['backmoney_' . $val];
			$i++;
		}

		$data = $_POST['data'];
		$datas['backbanknumber'] = $_POST['backbanknumber'];
		$datas['backmoneytime'] = $_POST['backbanknumber'];
		if (empty($datas['backmoneytime'])) {
			$datas['backmoneytime'] = 0;
		} else {
			$datas['backmoneytime'] = strtotime($datas['backmoneytime']);
		}
		if (!empty($_FILES['files']['name'])) {
			$this->loadHelper('uploader');
			$uploader = new uploader();
			$datas['backfilepath'] = $uploader->start('files');
			$datas['backfiletitle'] = $_FILES['files']['name'];
		} else {
			ajaxReturn('', '未上传退款单', 0);exit;
		}
		$datas['backremarkcw'] = $_POST['data']['remark'];
		$line = $this->franchisee->orderModel->update($datas, "ordernum='" . $ordernum . "'");
		$sql .= " on duplicate key update backmoney=values(backmoney)";
		//echo $sql;exit;

		if ($line) {
			$this->franchisee->orderinfoprepareModel->sqlexec($sql);
			$order = $this->franchisee->orderinfoprepareModel->fetchRow("select id from franchisee_order where ordernum='" . $ordernum . "'");
			$data = array();
			$data['orderid'] = $order['id'];
			$data['truename'] = $this->info['truename'];
			$data['created'] = time();
			$data['type'] = 1;
			$data['results'] = "财务审核";
			$this->loadModel('franchisee', 'orderdata');
			$this->franchisee->orderdataModel->insert($data);
			$this->sendemailandmessage($order['id'],5);
			ajaxReturn('', '操作成功', 1);
		} else {
			ajaxReturn('', '操作失败', 0);
		}

	}
	//财务反审

	public function caiwucheckback() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data = $_POST['data'];

			$datas['backstatus'] = 4;

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			if ($line) {
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();
				$data['type'] = 1;
				$data['results'] = "库房配货完成后反审";
				$this->franchisee->orderdataModel->insert($data);
				$this->sendemailandmessage($id,4);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//库房入库----加库存

	public function houseinsert() {
	set_time_limit(0);
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadModel('franchisee', 'orderbackhouse');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data = $_POST['data'];

			$datas['backstatus'] = 6;

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			//$line=true;
			if ($line) {
				//加库存
				$order = $this->franchisee->orderModel->fetchRow("select ordernum from franchisee_order where id=" . $id);
				$this->addgoods($order['ordernum']);
				$this->addproductlog($id);
				$data['instoreremark'] = $_POST['remark'];
				$data['instoretime'] = strtotime($data['instoretime']);
				$this->franchisee->orderbackhouseModel->update($data, "orderid=" . $id);
				$data = array();
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();
				$data['type'] = 1;
				$data['remark'] = $_POST['remark'];
				$data['results'] = "库房入库";
				$this->franchisee->orderdataModel->insert($data);
				$this->tezhisendmessage($id,6,'userid');
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//加库存
	public function addgoods($ordernum) {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('product', 'goods');
		$this->loadModel('product', 'productontime');
		$sql = "select fo.*,pg.uuid,pg.number from franchisee_orderinfoprepare as fo left join product_goods as pg on pg.id=fo.goodsid where fo.ordernum='" . $ordernum . "'";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		$updatesql = "insert into product_goods(id,number) values";
		$updatesqltime = "insert into product_productontime(id,num) values";
		$i = 0;
		$ks = 0;
		foreach ($re as $k => $val) {
			$goodsnum = $val['number'] + $val['realbacknum'];
			if ($i == 0) {
				$updatesql .= "(" . $val['goodsid'] . "," . $goodsnum . ")";
			} else {
				$updatesql .= ",(" . $val['goodsid'] . "," . $goodsnum . ")";
			}
			$i++;
			if (!empty($val['productontime'])) {
				//说明是正常 价，只用加主表
				$sql = "select * from  product_productontime where goodsuuid='" . $val['uuid'] . "' and productontime=" . $val['productontime'];
				$goodstime = $this->franchisee->orderModel->fetchRow($sql);
				if ($goodstime) {
					$timenum = $val['realbacknum'] + $goodstime['num'];
					if ($ks == 0) {
						$updatesqltime .= "(" . $goodstime['id'] . "," . $timenum . ")";
					} else {
						$updatesqltime .= ",(" . $goodstime['id'] . "," . $timenum . ")";
					}
					$ks++;
				}
			}

		}
		$updatesql .= " on duplicate key update number=values(number)";
		$updatesqltime .= " on duplicate key update num=values(num)";
		if ($i > 0) {
			$line = $this->product->goodsModel->sqlexec($updatesql);
		}
		if ($ks > 0) {
			//echo $updatesqltime;exit;
			$line = $this->product->goodsModel->sqlexec($updatesqltime);
		}
	}
	//添加入库记录 franchisee_orderinfo
	public function addproductlog($id){
		$this->loadModel('product', 'log');
		$this->loadModel('product', 'goods');
		$this->loadModel('franchisee', 'order');
		//查看是哪个加盟商
		$sql	=	"select fa.shoppname,fo.ordernum from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where fo.id='".$id."'";
		$r		=	$this->product->goodsModel->fetchRow($sql);
		if(!$r){
			$r['shoppname']='';
			return false;
		}
		$ordernum	=	$r['ordernum'];
		$loginsert	=	"insert into product_log(erpcode,title,type,number,username,boxnum,created,ordernum,hasnum) values";
		$sql	=	"select pg.erpcode,pg.title,fo.num as number,fo.backnum,fo.boxnum,pg.number as hasnum from franchisee_orderinfo as fo left join product_goods as pg on pg.id=fo.goodsid where ordernum='".$ordernum."'";
		$re		=	$this->product->goodsModel->fetchAll($sql);
		$i	=	0;
		$created	=	time();
		foreach($re as $v){
		$v['number']=$v['backnum'];
		if($v['number']==0){continue;}
			if($i==0){
				$loginsert.="('" . $v['erpcode'] . "','" . $v['title'] . "',2,'" . $v['number'] . "','" . $r['shoppname'] . "','" . $v['boxnum'] . "',".$created.",'" . $ordernum . "',".$v['hasnum'].")";
			}else{
			$loginsert.=",('" . $v['erpcode'] . "','" . $v['title'] . "',2,'" . $v['number'] . "','" . $r['shoppname'] . "','" . $v['boxnum'] . "',".$created.",'" . $ordernum . "',".$v['hasnum'].")";
			}
			$i++;
		
		}
		$this->product->logModel->sqlexec($loginsert);
	}
	//库房入库

	public function houseinsertback() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderdata');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data = $_POST['data'];

			$datas['backstatus'] = 5;

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			if ($line) {
				$data['orderid'] = $id;
				$data['truename'] = $this->info['truename'];
				$data['created'] = time();
				$data['type'] = 1;
				$data['results'] = "库房入库";
				$this->franchisee->orderdataModel->insert($data);
				$this->sendemailandmessage($id,5);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//库房打单
	public function hourseorderdan() {

		$ordernum = $_GET['ordernum'];

		$this->loadModel('franchisee', 'orderinfo');
		$sql = "select fo.*,sa.truename from franchisee_order as fo left join system_admin as sa on sa.id=fo.backdirectorid where fo.ordernum='" . $ordernum . "'";
		$order = $this->franchisee->orderinfoModel->fetchRow($sql);
		$userinfo = $this->getAllianceInfo($order['token']);
		if ($order['backstatus'] == 0) {
			$sql = "select fo.ordernum,fo.productontime,fo.id as ofid,fo.tag,fo.goodsid as id,fo.realbacknum,pg.beoverdue,pg.shelflife,fo.num as buynum,fo.price as buyprice,fo.backnum,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id  where fo.ordernum='" . $ordernum . "' and fo.backnum>0";
		} else {
			$sql = "select fo.ordernum,fo.productontime,fo.id as ofid,fo.tag,fo.goodsid as id,fo.realbacknum,pg.beoverdue,pg.shelflife,fo.num as buynum,fo.price as buyprice,fo.backnum,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.boxnum,pg.specs,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id  where fo.ordernum='" . $ordernum . "' and fo.backnum>0";
		}
		$re = $this->franchisee->orderinfoModel->fetchAll($sql);

		//查询库房人员信息
		$sql = "select fo.*,sa.truename as yanhuoname,san.truename as instorename from franchisee_orderbackhouse as fo left join system_admin as sa on fo.yanhuoid=sa.id left join system_admin as san on fo.instoreid=san.id where orderid=" . $order['id'];
		$houseinfo = $this->franchisee->orderinfoModel->fetchRow($sql);
		include $this->loadView('');

	}
	//```````````````````````````````````````````````````````````````````````````````````````````
	//加盟商信息
	public function getAllianceInfo($token) {
		$this->loadModel('franchisee', 'alliance');
		$sql = "select arr.name as cname,ar.name as pname,franchisee_alliance.*,crm_usertype.title as supplytype from franchisee_alliance left join crm_usertype on crm_usertype.id=franchisee_alliance.supplytypeid left join area_region as ar on ar.id=franchisee_alliance.proviceid left join area_region as arr on arr.id=franchisee_alliance.cityid where franchisee_alliance.token='" . $token . "'";
		return $this->franchisee->allianceModel->fetchRow($sql);

	}

	//```````````````````````````````````````邮件短信通知 franchisee_order
	public function tezhisendmessage($id, $status,$key='backdirectorid', $tag = 0) {
		set_time_limit(0);
		$this->loadModel("product", "messageremind");
		$keyword = "tuihuo";
		
		$sql = "select * from franchisee_order where id=" . $id;
		$order = $this->product->messageremindModel->fetchRow($sql);
		$sql	=	"select * from system_admin where id=".$order[$key];
		$user = $this->product->messageremindModel->fetchAll($sql);
		if($tag==1){
			$sql	=	"select * from franchisee_alliance token='".$order['token']."'";
			$alliance = $this->product->messageremindModel->fetchRow($sql);
			//$token	=	$alliance['token'];
		}
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
		$mailsubject = "您有一个订货单";
		//邮件内容
		$mailbody = "采购订单号：" . $order['ordernum'];
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
					$str = $order['ordernum'];
					$re = $this->sendmessage($str, $val['mobile']);
				}
			}
		}
		if(empty($token)){
			//	给加盟商发邮件及短信
			if(!empty($alliance['email'])){
				$re = $smtp->sendmail($alliance['email'], $smtpusermail, $mailsubject, $mailbody, $mailtype);
			
			}
			if (!empty($alliance['mobile'])) {
					$str = $order['ordernum'];
					$re = $this->sendmessage($str, $alliance['mobile']);
				}
		}

	}
	//发送邮件及短信,$tag=1时，表示须传给加盟商发消息通知
	public function sendemailandmessage($id, $status, $tag = 0) {
		set_time_limit(0);
		$this->loadModel("product", "messageremind");
		$keyword = "tuihuo";
		$sql = "select sa.* from product_messageremind as pm left join system_admin as sa on sa.id=pm.userid  where pm.keyword='" . $keyword . "' and orderstatus=" . $status;
		$user = $this->product->messageremindModel->fetchAll($sql);
		$sql = "select * from franchisee_order where id=" . $id;
		$order = $this->product->messageremindModel->fetchRow($sql);
		if($tag==1){
			$sql	=	"select * from franchisee_alliance token='".$order['token']."'";
			$alliance = $this->product->messageremindModel->fetchRow($sql);
			$token	=	$alliance['token'];
		}
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
		$mailsubject = "您有一个订货单";
		//邮件内容
		$mailbody = "采购订单号：" . $order['ordernum'];
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
					$str = $order['ordernum'];
					$re = $this->sendmessage($str, $val['mobile']);
				}
			}
		}
		if(empty($token)){
			//	给加盟商发邮件及短信
			if(!empty($alliance['email'])){
				$re = $smtp->sendmail($alliance['email'], $smtpusermail, $mailsubject, $mailbody, $mailtype);
			
			}
			if (!empty($alliance['mobile'])) {
					$str = $order['ordernum'];
					$re = $this->sendmessage($str, $alliance['mobile']);
				}
		}

	}

	//发送短信通知

	public function sendmessage($str, $mobile) {

		$this->loadHelper('sms');

		$sms = new sms();

		$bk = $sms->send_orderback_message($str, $mobile);
		//  print_r($bk);exit;
		return $bk;
	}
}
?>