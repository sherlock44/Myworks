<?php

/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */

class storeout extends actionAbstract {
	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 5;
	public $type = 0;
	public $leftpos = 4;
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
		// if(!isset($_SESSION['accessinfo'])){ header('location:'.$this->url('common/login'));}
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			//ajax request
			$this->checkpower();
		}
	}

	//采购列表
	public function apply() {
		$this->leftpos = 4;
		$this->pos = 6;
		$this->loadModel('product', 'storeout');
		$sql = "select pa.*,sa.name as cgname from product_storeout as pa left join system_admin as sa on sa.id=pa.memberid  ";
		$re = $this->product->storeoutModel->fetchAll($sql);
		//
		$sysconf = $this->loadConfig('sysconf');
		include $this->loadWidget('amdinlteTheme');
	}
	//添加采购申请
	public function addapply() {
		$this->loadModel('system', 'admin');
		$sql = "select * from  system_admin where status=1";
		$admin = $this->system->adminModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//插入采购申请
	public function insertapply() {
		$this->loadModel('product', 'storeout');
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
		$re = $this->product->storeoutModel->insert($data);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	//编辑采购申请
	public function editapply() {
		$this->loadModel('system', 'admin');
		$this->loadModel('product', 'storeout');
		$sql = "select * from  system_admin where status=1";
		$admin = $this->system->adminModel->fetchAll($sql);
		$id = $_GET['id'];
		$sql = "select pa.*,sa.name as cgname,ws.title as storetype from product_storeout as pa left join system_admin as sa on sa.id=pa.memberid  left join wms_setting as ws on ws.id=pa.storeid  where pa.id=$id";
		$re = $this->product->storeoutModel->fetchRow($sql);
		$sysconf = $this->loadConfig('sysconf');
		//当状态等于3时，采购单需要选择供应商信息
		$supply = null;
		if ($re['status'] == 2) {
			$sql = "select * from crm_supplier ";
			$supply = $this->system->adminModel->fetchAll($sql);
		}
		//查看商品信息
		if ($re['status'] >= 2) {
			$sql = "select po.*,pg.title,pg.imgpath,pg.barcode,phs.title as phstitle,ph.title as phtitle from product_storeorderinfo as po left join product_goods as pg on pg.id=po.goodsid left join product_house as ph on ph.id=po.houseid left join product_housepos as phs on phs.id=po.houseposid where po.applyid=$id";
			$goods = $this->system->adminModel->fetchAll($sql);
		}
		include $this->loadWidget('amdinlteTheme');
	}
	//修改采购申请
	public function updateapply() {
		$this->loadModel('product', 'storeout');
		$this->loadHelper('extend');
		$data = $_POST['data'];
		$id = $_POST['id'];
		$data['remark'] = $_POST['remark'];
		$line = $this->product->storeoutModel->update($data, "id=$id");
		if ($line) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	//采购负责人审核
	public function cgfzrcheck() {
		$this->loadModel('product', 'storeout');
		$this->loadHelper('extend');
		$data['cgfzrid'] = $_POST['cgzrrid'];
		$data['status'] = 2;
		$id = $_POST['id'];

		$line = $this->product->storeoutModel->update($data, "id=$id");
		if ($line) {
			$result = array('status' => 1, 'info' => '操作成功');
		} else {
			$result = array('status' => 0, 'info' => '操作失败');
		}
		exit(json_encode($result));
	}
	//选择采购方式
	public function cgfscheck() {
		$this->loadModel('product', 'storeout');
		$this->loadHelper('extend');
		$data['type'] = $_POST['cgtype'];
		$data['supplyid'] = $_POST['supplyid'];
		$data['status'] = 3;
		$id = $_POST['id'];

		$line = $this->product->storeoutModel->update($data, "id=$id");
		if ($line) {
			$result = array('status' => 1, 'info' => '操作成功');
		} else {
			$result = array('status' => 0, 'info' => '操作失败');
		}
		exit(json_encode($result));
	}
	//选择采购的商品
	public function selgoods() {
		$this->loadModel('product', 'goods');
		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$userphone = null;
		$id = $_GET['id'];

		if (!empty($_GET['userphone'])) {
			$this->where .= " and (product_goods.title like  '%" . $_GET['userphone'] . "%' or product_goods.barcode like '%" . $_GET['userphone'] . "%')";

			$userphone = $_GET['userphone'];
		}
		$sid = '';
		if (isset($_GET['categoryuuid']) && $_GET['categoryuuid'] !== "") {
			$sid = $_GET['categoryuuid'];
			//得到二级分类
			$sqlc = "select id from product_goodscategory where parentuuid=" . $_GET['categoryuuid'];
			$c = $this->product->goodsModel->fetchAll($sqlc);
			if ($c) {
				$this->where .= " and (product_goods.categoryuuid = " . $_GET['categoryuuid'] . " or product_goods.categoryuuid in($sqlc))";
			} else {
				$this->where .= " and product_goods.categoryuuid = " . $_GET['categoryuuid'] . "";
			}
		}
		if (isset($_GET['branduuid']) && $_GET['branduuid'] !== "") {
			$this->where .= " and product_goods.branduuid = " . $_GET['branduuid'] . "";
		}
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = 10;
		$offset = ($page - 1) * $size;
		$sql = "select count(*) from product_goods  where 1=1 " . $this->where;
		$count = $this->product->goodsModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select product_goods.*,fc.title as fctitle,pb.title as brandtitle from product_goods left join product_goodscategory as fc on fc.id=product_goods.categoryuuid  left join product_brand as pb on pb.id=product_goods.branduuid where 1=1  " . $this->where . "  limit " . $offset . "," . $size . "";

		//echo $sql;exit;
		$re = $this->product->goodsModel->fetchAll($sql);
		foreach ($re as $k => $val) {
			$sql = "select * from product_productontime where goodsuuid='" . $val['uuid'] . "'";
			$r = $this->product->goodsModel->fetchAll($sql);
			$re[$k]['time'] = $r;
		}
		//品牌和名称
		$this->loadModel('product', 'goodscategory');
		$this->loadHelper("Treeuuid");
		$sql = "select * from product_goodscategory ";
		$category = $this->product->goodscategoryModel->fetchAll($sql);
		$tree = new Treeuuid($category);
		$str = "<option value=\$uuid >\$spacer\$title</option>";
		$str = "<option value=\$uuid \$selected>\$spacer\$title</option>";
		$trees = $tree->get_tree(0, $str, $sid);
		//品牌
		$sql = "select id,title from product_brand order by sort asc ";
		$brand = $this->product->goodscategoryModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//加入购物车
	public function addcart() {
		$this->loadModel('product', 'storercart');
		$this->loadHelper("extend");
		if ($_POST) {

			if (!isset($_POST['goodsid'])) {
				ajaxReturn('', '请选择采购商品', 0);
			}
			$applyid = $_POST['id'];
			$tag = true;
			foreach ($_POST['goodsid'] as $v) {
				$data = array();
				$data['goodsid'] = $v;

				$data['num'] = $_POST['goodsnum_' . $v];
				if (empty($data['num'])) {continue;}
				//查看之前有没有添加该购物车
				$sql = 'select * from product_storercart where  goodsid=' . $v . ' and applyid=' . $applyid;
				$r = $this->product->storercartModel->fetchRow($sql);
				if ($r) {
					$odata['num'] = $_POST['goodsnum_' . $v] + $r['num'];
					$this->product->storercartModel->update($odata, 'goodsid=' . $v . ' and applyid=' . $applyid);
				} else {
					$data['applyid'] = $applyid;
					$this->product->storercartModel->insert($data);
				}

			}
			ajaxReturn('0', '操作成功', 1);
		}

	}
	//查看已选中的商品--购物车中的商品
	public function cartlist() {

		$this->loadModel('product', 'storercart');
		$applyid = $_GET['applyid'];
		$sql = "select pg.*,fo.num,fo.id  as cartid,fo.houseposid,fo.houseid from product_storercart as fo left join  product_goods as pg on fo.goodsid=pg.id  where fo.applyid=" . $applyid;

		$re = $this->product->storercartModel->fetchAll($sql);

		//查看库房
		$this->loadModel('product', 'house');
		$sql = "select * from product_house ";
		$house = $this->product->houseModel->fetchAll($sql);

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
	//修改购物车数量
	public function updatecart() {
		$this->loadModel('product', 'storercart');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data['num'] = $_POST['num'];
			if (empty($data['num'])) {
				ajaxReturn('', '数据有误', 0);
			}

			$line = $this->product->storercartModel->update($data, "id=" . $id);
			if ($line) {
				ajaxReturn('', '修改成功', 1);
			} else {
				ajaxReturn('', '修改失败', 0);
			}

		}

	}
//提交其他相关信息
	public function cartotherinfo() {

		$this->loadModel('product', 'ordercart');
		$applyid = $_GET['applyid'];
		//购物车信息
		$sql = "select pg.*,fo.num,fo.id  as cartid,fo.houseposid,fo.houseid from product_storercart as fo left join  product_goods as pg on fo.goodsid=pg.id  where fo.applyid=" . $applyid;
		$re = $this->product->ordercartModel->fetchAll($sql);
		//查看库房
		$this->loadModel('product', 'house');
		$sql = "select * from product_house ";
		$house = $this->product->houseModel->fetchAll($sql);
		//出库类型
		$sql = "select * from wms_setting where type=0 ";
		$storetype = $this->product->houseModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');

	}
	//提交购物车--
	public function tjcart() {
		$this->loadModel('product', 'storercart');
		$this->loadModel('product', 'storeout');
		$this->loadModel('product', 'storeorderinfo');
		$this->loadHelper("extend");

		if ($_POST) {

			//查看总价
			$applyid = $_POST['applyid'];
			$sql = "select pg.*,fo.num,fo.id as cartid from product_storercart as fo left join  product_goods as pg on fo.goodsid=pg.id  where fo.applyid=" . $applyid;
			$re = $this->product->storercartModel->fetchAll($sql);
			if (!$re) {
				ajaxReturn('', '购物车中无商品', 0);
			}
			if (in_array(0, $_POST['houseposid'])) {
				ajaxReturn('', '请选择商品的库房库位', 0);
			}
			$odata = $_POST['data'];
			if ($odata['storeid'] == 0) {
				ajaxReturn('', '请选择出库类型', 0);
			}
			$ordernum = date("ymdhis") . substr(uniqid(rand()), -6);

			//$odata['uuid']		=	'uuid()';
			//$odata['applyid']	=	$applyid;
			//$odata['ordernum']	=	$ordernum;

			//$odata['created']	=	time();
			//print_r($odata);exit;
			$line = $this->product->storeoutModel->update($odata, "id=$applyid");

			$allprice = 0;
			$tag = true;
			if ($line) {
				foreach ($re as $k => $val) {
					//$allprice+=$val['costprice']*$val['num'];
					$data = array();
					$data['applyid'] = $applyid;
					$data['num'] = $val['num'];
					//$data['price']		=	$val['costprice'];
					$data['houseid'] = $_POST['houseid'][$k];
					$data['houseposid'] = $_POST['houseposid'][$k];
					$data['goodsid'] = $val['id'];

					$tag = $this->product->storeorderinfoModel->insert($data);
					if (!$tag) {

						$this->product->storeorderinfoModel->delete("applyid=$applyid");
						break;
					} else {
						//$this->product->orderModel->update(array('price'=>$allprice,'status'=>4),"id=".$line);

					}
				}
			} else {
				$tag = false;
			}
			if ($tag) {
				//	删除购物车
				//$this->product->storercartModel->delete("applyid=$applyid");
				$this->product->storeoutModel->update(array('status' => 3), "id=" . $applyid);
				$url = "http://" . ROOT_URL . "/index.php/iManage/storeout/apply";
				echo json_encode(array('state' => 1, 'info' => "操作成功", 'data' => 'url', 'url' => $url));exit;

			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}

	//采购执行确认
	public function purchasecheck() {
		$this->loadModel('product', 'storeout');
		$this->loadHelper('extend');
		$id = $_GET['id'];
		$data['status'] = 2;
		$line = $this->product->storeoutModel->update($data, "id=$id");
		if ($line) {
			ajaxReturn('', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}

	/* //商品入库
	public function goodstostore(){
	$this->loadModel('product','storeout');
	$id	=	$_GET["id"];
	//查看商品
	$sql	=	"select po.*,pg.title,pg.imgpath,pg.barcode from product_storeorderinfo as po left join product_goods as pg on pg.id=po.goodsid where po.applyid=$id";
	$goods	=	$this->product->storeoutModel->fetchAll($sql);

	//查看库房
	$this->loadModel('product','house');
	$sql="select * from product_house ";
	$house=$this->product->houseModel->fetchAll($sql);
	//入库类型
	$this->loadModel('wms','setting');
	$sql="select * from wms_setting where type=1 and status=1";
	$setting=$this->wms->settingModel->fetchAll($sql);
	include $this->loadWidget('amdinlteTheme');
	} */

	//商品出库
	public function goodstostoretj() {
		set_time_limit(0);
		$this->loadModel('product', 'storeout');
		$this->loadModel('product', 'storeorderinfo');
		$this->loadHelper('extend');
		$applyid = $id = $_GET['id'];

		$status = 4;

		$data['status'] = $status;
		$line = $this->product->storeoutModel->update($data, "id=$applyid");
		//修改库存*************************** 开始  ******************************************

		$this->loadModel('product', 'relation');
		$sql = "select * from product_storeorderinfo where applyid=$applyid";
		$re = $this->product->storeoutModel->fetchAll($sql);
		foreach ($re as $val) {
			$where = "goodsid=" . $val['goodsid'] . " and houseposid=" . $val['houseposid'];
			$sql = "select id,num from product_relation where $where ";
			$r = $this->product->storeoutModel->fetchRow($sql);
			if (!$r) {continue;}
			$dat['num'] = $r['num'] - 0 + $val['num'];
			$this->product->storeorderinfoModel->update($dat, "id=" . $r['id']);
		}
		//修改库存*************************** 结束  ******************************************
		if ($line) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	public function ediTdiaobo() {
		$this->loadModel('', '');
	}

}
?>