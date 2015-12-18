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
	public $pos = 5;
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
		$this->info = acl::checkLogin('admininfo', $this->url('common/login'));
		// if(!isset($_SESSION['accessinfo'])){ header('location:'.$this->url('common/login'));}
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
	}

	//退货单列表
	public function lists() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'orderback');
		$sql = "select * from franchisee_orderback where status>0 or status=-1 or (status=0 and userid=" . $this->info['id'] . ") ";
		$re = $this->franchisee->orderbackModel->fetchAll($sql);
		$sysconf = $this->loadConfig('sysconf');
		include $this->loadWidget('amdinlteTheme');
	}
	//添加退货单
	public function add() {

		include $this->loadWidget('amdinlteTheme');
	}
	//修改退货单资料
	public function edit() {
		$id = $_GET['id'];
		$this->loadModel('franchisee', 'orderback');
		$sql = "select * from franchisee_orderback where id=$id";
		$re = $this->franchisee->orderbackModel->fetchRow($sql);
		//商品信息

		$sql = "select pg.*,fo.num,fo.id as ofid from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id where fo.ordernum='" . $re['oldordernum'] . "' ";

		$goods = $this->franchisee->orderbackModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//插入退货单
	public function insert() {
		$this->loadModel('franchisee', 'orderback');
		$this->loadHelper("extend");
		if ($_POST) {
			$data = $_POST['data'];
			//先查看退货单存不存在
			$sql = "select * from franchisee_order where ordernum='" . $data['oldordernum'] . "' ";
			$re = $this->franchisee->orderbackModel->fetchRow($sql);
			if (!$re) {
				ajaxReturn('', '该关联订单不存在', 0);
			}
			//查看加盟商id
			$sql = "select id from franchisee_alliance where token='" . $re['token'] . "'";
			$alliance = $this->franchisee->orderbackModel->fetchRow($sql);
			$data['token'] = $re['token'];
			$data['uuid'] = 'uuid()';
			$data['created'] = time();
			$data['status'] = 0;
			$data['userid'] = $this->info['id'];
			$data['ordernum'] = date("YmdHis") . rand(10000, 99999) . $alliance['id'];
			$line = $this->franchisee->orderbackModel->insert($data);
			if ($line) {
				ajaxReturn('back', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}

	//退货商品
	public function updatebackgoods() {
		$this->loadModel('franchisee', 'orderbackinfo');
		$this->loadModel('franchisee', 'orderback');
		$this->loadHelper("extend");

		if (!isset($_POST['ofid'])) {
			ajaxReturn('', '未选择退货商品', 0);
		}
		$id = $_POST['id'];

		$this->franchisee->orderbackinfoModel->delete("backid=$id");
		$sql = "insert into franchisee_orderbackinfo(backid,num,goodsid,price,buynum) values";
		foreach ($_POST['ofid'] as $k => $val) {
			if (empty($_POST['goodsnum_' . $val])) {
				ajaxReturn('', '未选择退货商品数量', 0);
			}
			if ($k == 0) {
				$sql .= "(" . $id . "," . $_POST['goodsnum_' . $val] . "," . $_POST['goodsid_' . $val] . "," . $_POST['price_' . $val] . "," . $_POST['buynum_' . $val] . ")";
			} else {
				$sql .= ",(" . $id . "," . $_POST['goodsnum_' . $val] . "," . $_POST['goodsid_' . $val] . "," . $_POST['price_' . $val] . "," . $_POST['buynum_' . $val] . ")";
			}
		}
		$line = $this->franchisee->orderbackinfoModel->sqlexec($sql);

		if ($line) {
			$data['status'] = 1;
			$this->franchisee->orderbackModel->update($data, "id=$id");
			ajaxReturn('back', '操作成功', 1);
		} else {
			ajaxReturn('', '操作失败', 0);
		}

	}
	//删除退货单
	public function del() {
		$this->loadModel('franchisee', 'orderback');
		$this->loadModel('franchisee', 'orderbackinfo');
		$this->loadHelper("extend");
		if ($_GET) {
			$id = $_GET['id'];

			$line = $this->franchisee->orderbackinfoModel->delete("backid=" . $id);
			$line = $this->franchisee->orderbackModel->delete("id=" . $id);
			if ($line) {
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}

	//订单详情
	public function orderinfo() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'orderback');
		$id = $_GET['id'];
		//退单详情
		$sql = "select * from franchisee_orderback where id=$id";
		$re = $this->franchisee->orderbackModel->fetchRow($sql);
		$sql = "select fo.buynum ,fo.num,fo.price ,pg.barcode,pg.title,pg.imgpath from franchisee_orderbackinfo as fo left join product_goods as pg on fo.goodsid=pg.id where fo.backid='" . $id . "'";
		$goods = $this->franchisee->orderbackModel->fetchAll($sql);
		$sysconf = $this->loadConfig('sysconf');
		include $this->loadWidget('amdinlteTheme');
	}
	//订单初步审核
	public function checkfirst() {
		$this->loadModel('franchisee', 'orderback');
		$this->loadHelper("extend");
		if ($_GET) {
			$id = $_GET['id'];
			$data['status'] = 2;
			$line = $this->franchisee->orderbackModel->update($data, "id=" . $id);
			if ($line) {
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//财务审核通过
	public function cwcheck() {
		$this->loadModel('franchisee', 'orderback');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['backid'];
			$data = $_POST['data'];
			$data['status'] = 3;
			if ($data['price'] <= 0) {
				ajaxReturn('', '请填写退货单总价', 0);
			}
			if (!empty($_FILES['files']['name'])) {
				$this->loadHelper('uploader');
				$uploader = new uploader();
				$data['filepath'] = $uploader->start('files');
				$data['filename'] = $_FILES['files']['name'];
			} else {
				ajaxReturn('', '未提交合同信息', 0);
			}
			$line = $this->franchisee->orderbackModel->update($data, "id=" . $id);
			if ($line) {
				ajaxReturn('back', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//商品验收
	public function goodscheck() {

		$this->loadModel('franchisee', 'orderback');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['backid'];
			$data = $_POST['data'];
			if ($_POST['acceptance'] == 2) {
				$data['status'] = 4;
				unset($data['price']);
				unset($data['remarkinfo']);
			} else if ($_POST['acceptance'] == -1) {
				$data['status'] = -1;
				unset($data['price']);

			} else {
				$data['status'] = 4;
				if ($data['price'] <= 0) {
					ajaxReturn('', '请填写退货单总价', 0);
				}
				if (!empty($_FILES['files']['name'])) {
					$this->loadHelper('uploader');
					$uploader = new uploader();
					$data['filepath'] = $uploader->start('files');
					$data['filename'] = $_FILES['files']['name'];
				} else {
					ajaxReturn('', '未提交合同信息', 0);
				}
			}

			$line = $this->franchisee->orderbackModel->update($data, "id=" . $id);
			if ($line) {
				ajaxReturn('back', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
	//商品入库
	public function goodstostore() {
		$this->loadModel('franchisee', 'orderback');
		$id = $_GET["backid"];
		//查看商品
		$sql = "select fo.*,pg.title,pg.imgpath,pg.barcode from franchisee_orderbackinfo as fo left join product_goods as pg on pg.id=fo.goodsid where fo.backid=$id";
		$goods = $this->franchisee->orderbackModel->fetchAll($sql);

		//查看库房
		$this->loadModel('product', 'house');
		$sql = "select * from product_house ";
		$house = $this->product->houseModel->fetchAll($sql);
		//入库类型
		$this->loadModel('wms', 'setting');
		$sql = "select * from wms_setting where type=1 and status=1";
		$setting = $this->wms->settingModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//得到库位
	public function getHousePos() {
		$houseid = $_POST['houseid'];
		$goodsid = $_POST['goodsid'];
		$houseposid = $_POST['houseposid'];
		$this->loadModel('product', 'housepos');
		$this->loadHelper('extend');
		$sql = "select * from product_housepos where houseid=$houseid";
		$re = $this->product->houseposModel->fetchAll($sql);
		$html = "<option value='0'>选择库位</option>";
		foreach ($re as $val) {
			$select = $val['id'] == $houseposid ? "selected" : "";
			$html .= "<option value='" . $val['id'] . "' $select>" . $val['title'] . "</option>";
		}
		$data['html'] = $html;
		$data['houseid'] = $houseid;
		$data['goodsid'] = $goodsid;
		$data['houseposid'] = $houseposid;
		echo json_encode($data);

	}
	//商品入库
	public function goodstostoretj() {
		set_time_limit(0);
		$this->loadModel('franchisee', 'orderback');
		$this->loadModel('franchisee', 'orderbackinfo');
		$this->loadHelper('extend');
		$backid = $_POST['backid'];
		$tag = $_POST['tag']; //0草稿 1确认提交
		$id = $_POST['id'];
		$status = 4;
		if (!is_array($id)) {
			ajaxReturn('', '修改失败', 0);exit;
		}
		if ($tag == 1) {
			$housepos = $_POST['housepos'];
			if (in_array(0, $housepos)) {
				ajaxReturn('', '请选择商品的库位', 0);exit;
			}
			if ($_POST['storeid'] == 0) {
				ajaxReturn('', '请选择入库类型', 0);exit;
			}
			$status = 5;
		}
		$sql = "insert into franchisee_orderbackinfo(id,houseid,houseposid,badnum,storagenum) values";
		foreach ($id as $k => $v) {
			$_POST['storagenum_' . $v] = intval($_POST['storagenum_' . $v]);
			$_POST['badnum_' . $v] = intval($_POST['badnum_' . $v]);
			if ($k == 0) {
				$sql .= "(" . $v . "," . $_POST['houseid'][$k] . "," . $_POST['housepos'][$k] . "," . $_POST['badnum_' . $v] . "," . $_POST['storagenum_' . $v] . ")";
			} else {
				$sql .= ",(" . $v . "," . $_POST['houseid'][$k] . "," . $_POST['housepos'][$k] . "," . $_POST['badnum_' . $v] . "," . $_POST['storagenum_' . $v] . ")";
			}
		}
		$sql .= "ON DUPLICATE KEY UPDATE houseid=VALUES(houseid), houseposid=VALUES(houseposid), badnum=VALUES(badnum), storagenum=VALUES(storagenum)";
		//echo $sql;exit;
		$line = $this->franchisee->orderbackinfoModel->sqlexec($sql);
		/* if(!$line){
		ajaxReturn ( '','操作失败1', 0);exit;
		} */
		$data['status'] = $status;
		$line = $this->franchisee->orderbackModel->update($data, "id=$backid");
		//修改库存*************************** 开始  ******************************************
		if ($tag == 1) {
			$this->loadModel('product', 'relation');
			$updatesql = "update product_relation set num=CASE id";
			$insertql = "insert into product_relation(goodsid,houseid,houseposid,num) values";
			$updateid = null;
			$i = 0;
			$goodssql = "update product_goods set number=CASE id";
			foreach ($id as $k => $v) {
				$sql = "select num,id from product_relation where  goodsid=" . $_POST['goodsid'][$k] . " and houseid=" . $_POST['houseid'][$k] . " and houseposid=" . $_POST['housepos'][$k];
				$r = $this->product->relationModel->fetchRow($sql);
				if ($r) {
					$updatesql .= " when " . $r['id'] . " THEN " . ($_POST['num'][$k] - 0 + $r['num']) . " ";

					$updateid[] = $r['id'];
				} else {
					if ($i == 0) {
						$insertql .= "(" . $_POST['goodsid'][$k] . "," . $_POST['houseid'][$k] . "," . $_POST['housepos'][$k] . "," . $_POST['num'][$k] . ")";
					} else {
						$insertql .= ",(" . $_POST['goodsid'][$k] . "," . $_POST['houseid'][$k] . "," . $_POST['housepos'][$k] . "," . $_POST['num'][$k] . ")";
					}
					$i++;
				}
				$goodssql .= " when " . $_POST['goodsid'][$k] . " THEN number+" . $_POST['num'][$k] . " ";

			}
			if (!empty($updateid)) {
//修改
				$updateid = implode(',', $updateid);
				$updatesql .= " END where id in($updateid)";
				//echo $updatesql;exit;
				$this->product->relationModel->execSql($updatesql);
			}
			if ($i > 0) {
//新增
				$this->product->relationModel->execSql($insertql);
			}
			//修改商品信息
			if (is_array($_POST['goodsid'])) {
				$this->loadModel('product', 'goods');
				$goodsid = implode(',', $_POST['goodsid']);
				$goodssql .= " END where id in($goodsid)";

				$this->product->goodsModel->execSql($goodssql);
			}
			//通知pos端更新库存
			$sql = "select token from franchisee_orderback where id=$backid";
			$r = $this->franchisee->orderbackModel->fetchRow($sql);
			if ($r) {
				$rdata['keytype'] = 'orderback';
				$this->loadModel('financial', 'synctype');
				$this->financial->synctypeModel->update($rdata, "token='" . $r['token'] . "'");
			}
		}

		//修改库存*************************** 结束  ******************************************
		//ajaxReturn ( 'back', '操作成功', 1 );exit;
		if ($line) {

			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '草稿保存成功', 1);exit;
		}
	}
	//财务结算
	public function ordercompelete() {
		$this->loadModel('franchisee', 'orderback');
		$this->loadHelper("extend");
		if ($_GET) {
			$id = $_GET['id'];
			$data['status'] = 6;
			$line = $this->franchisee->orderbackModel->update($data, "id=" . $id);
			if ($line) {
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}
}
?>