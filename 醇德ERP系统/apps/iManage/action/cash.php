<?php

/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */

class cash extends actionAbstract {
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
		// $this->info = acl::checkLogin('admininfo',$this->url('common/login'));
		if (!isset($_SESSION['admininfo'])) {header('location:' . $this->url('common/login'));}$this->info = $_SESSION['admininfo'];
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			//ajax request
			$this->checkpower();
		}
	}
	//调拨申请列表
	public function bank() {
		$this->leftpos = 3;
		$this->pos = 8;
		$this->loadModel('product', 'transfer');
		$sql = "select pt.* , sa.name,sd.name as zgnm
    	        from product_transfer as pt
                join system_admin  as sa on sa.id = pt.userid
                join system_admin  as sd on sd.id = pt.zgid";
		$re = $this->product->transferModel->fetchAll($sql);
		$sysconf = $this->loadConfig('sysconf');
		include $this->loadWidget('amdinlteTheme');
	}
	//添加调拨申请
	public function addtrans() {
		$this->pos = 8;
		if ($_POST) {
			$this->loadHelper('extend');
			$this->loadModel('product', 'transfer');
			$this->loadModel('product', 'locked');
			$lock = $this->product->lockedModel->fetchRow("select * from product_locked where id=1");

			if ($lock['islocked'] == 1) {
				ajaxReturn('', '库房已锁定,正在进行调拨处理!请稍后再试', 0);exit;
			}

			$data = $_POST['data'];
			$data['userid'] = $this->info['id'];
			$data['uuid'] = 'uuid()';
			$data['applytime'] = time();
			$data['note'] = $_POST['note'];
			$bkid = $this->product->transferModel->insert($data);
			if ($bkid) {
				ajaxReturn('back', '提交申请成功', 1);exit;
			} else {
				ajaxReturn('', '提交申请失败', 0);exit;
			}
		} else {
			$this->leftpos = 3;
			$this->loadModel('system', 'admin');
			$sql = "select * from  system_admin where status=1";
			$admin = $this->system->adminModel->fetchAll($sql);
			include $this->loadWidget('amdinlteTheme');
		}
	}
	//查看调拨申请详情
	public function skintrans() {
		$this->leftpos = 3;
		$this->pos = 8;
		$id = $_GET['id'];
		$this->loadHelper('extend');
		$this->loadModel('product', 'transfer');
		$this->loadModel('product', 'transgood');
		$sql = "select step from product_transfer where id = {$id}";
		$te = $this->product->transferModel->fetchRow($sql);

		if ($te['step'] == 1) {
			$sql = "select pt.* , sa.name,sd.name as zgnm
    	             from product_transfer as pt
                     join system_admin  as sa on sa.id = pt.userid
                     join system_admin  as sd on sd.id = pt.zgid
    	             where pt.id = {$id}";
		}
		if ($te['step'] >= 2) {
			$sql = "select pt.* , sa.name,sd.name as zgnm,ws.title as rktpnm
    	             from product_transfer as pt
                     join system_admin  as sa on sa.id = pt.userid
                     join system_admin  as sd on sd.id = pt.zgid
                     join wms_setting   as ws on ws.id = pt.rktp
    	             where pt.id = {$id}";
		}
		$sysconf = $this->loadConfig('sysconf');
		$re = $this->product->transferModel->fetchRow($sql);
		//查看商品信息
		if ($re['step'] >= 2) {
			$sql = "select po.*,pg.title,pg.imgpath,pg.barcode,phs.title as phstitle,ph.title as phtitle from product_transgood as po left join product_goods as pg on pg.id=po.goodsid left join product_house as ph on ph.id=po.houseid left join product_housepos as phs on phs.id=po.houseposid where po.transid=$id";
			$goods = $this->product->transgoodModel->fetchAll($sql);
		}
		include $this->loadWidget('amdinlteTheme');
	}
	//确认商品调度入库
	public function subruku() {
		set_time_limit(0);
		$this->loadModel('product', 'transfer');
		$this->loadModel('product', 'transgood');

		$this->loadHelper('extend');
		$data['step'] = 3;
		if ($_POST) {
			$id = $_POST['id'];
			$line = $this->product->transferModel->update($data, "id=$id");
			//修改库存
			$this->loadModel('product', 'relation');
			$sql = "select * from product_transgood where transid=$id";
			$re = $this->product->transgoodModel->fetchAll($sql);

			foreach ($re as $val) {
				$where = "goodsid=" . $val['goodsid'] . " and houseposid=" . $val['houseposid'];
				$sql = "select id,num from product_relation where $where ";
				$r = $this->product->relationModel->fetchRow($sql);
				if (!$r) {
					$dat['num'] = $val['num'];
					$dat['goodsid'] = $val['goodsid'];
					$dat['houseid'] = $val['houseid'];
					$dat['houseposid'] = $val['houseposid'];
					$this->product->relationModel->insert($dat);
				} else {
					$dat['num'] = $r['num'] + $val['num'];
					$this->product->relationModel->update($dat, "id=" . $r['id']);
				}
			}
			$this->loadModel('product', 'locked');
			$this->product->lockedModel->update(array('islocked' => 1, 'created' => time()), "id=1");
			if ($line) {
				$result = array('status' => 1, 'info' => '提交成功');
			} else {
				$result = array('status' => 0, 'info' => '提交失败');
			}
			exit(json_encode($result));
		}
	}
	//调拨商品选择
	public function tranchgood() {
		$this->leftpos = 3;
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
	//插入选择的调拨商品信息
	public function addtrangood() {
		$this->loadModel('product', 'transgood');
		$this->loadHelper("extend");
		if ($_POST) {
			if (!isset($_POST['goodsid'])) {
				ajaxReturn('', '请选择采购商品', 0);
			}
			$transid = $_POST['id'];
			$tag = true;
			foreach ($_POST['goodsid'] as $v) {
				$data = array();
				$data['goodsid'] = $v;
				$data['num'] = $_POST['goodsnum_' . $v];
				if (empty($data['num'])) {continue;}
				//查看之前有没有添加
				$sql = 'select * from product_transgood where  goodsid=' . $v . ' and transid=' . $transid;
				$r = $this->product->transgoodModel->fetchRow($sql);
				if ($r) {
					$odata['num'] = $_POST['goodsnum_' . $v] + $r['num'];
					$this->product->transgoodModel->update($odata, 'goodsid=' . $v . ' and transid=' . $transid);
				} else {
					$data['transid'] = $transid;
					$this->product->transgoodModel->insert($data);
				}
			}
			ajaxReturn('0', '操作成功', 1);
		}
	}
	//查看调度的商品列表
	public function tranlist() {
		$this->leftpos = 3;
		$this->loadModel('product', 'transgood');
		$transid = $_GET['id'];
		$sql = "select pg.*,fo.num,fo.id as cartid from product_transgood as fo left join  product_goods as pg on fo.goodsid=pg.id  where fo.transid=" . $transid;
		$re = $this->product->transgoodModel->fetchAll($sql);
		$this->loadModel('product', 'housepos');
		$sql = "select phs.*,ph.title as ptitle from product_housepos as phs
		        left join product_house as ph on phs.houseid = ph.id";
		$kwdt = $this->product->houseposModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//修改调度商品的数量
	public function updatetranum() {
		$this->loadModel('product', 'transgood');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data['num'] = $_POST['num'];
			if (empty($data['num'])) {
				ajaxReturn('', '数据有误', 0);
			}
			$line = $this->product->transgoodModel->update($data, "id=" . $id);
			if ($line) {
				ajaxReturn('', '修改成功', 1);
			} else {
				ajaxReturn('', '修改失败', 0);
			}
		}
	}
	//删除调度商品
	public function deltrangood() {
		$this->loadModel('product', 'transgood');
		$this->loadHelper('extend');
		if ($_GET) {
			$id = $_GET['id'];
			$line = $this->product->transgoodModel->delete('id=' . $id);
			if ($line) {
				ajaxReturn('back', '操作成功', 1);
			} else {
				ajaxReturn('back', '操作失败', 0);
			}
		}
	}
	//选择调度商品库位信息
	public function subkwinfo() {
		$this->leftpos = 3;
		$this->loadModel('product', 'transgood');
		$id = $_GET['id'];
		//购物车信息
		$sql = "select pg.*,fo.num,fo.id  as cartid,fo.houseposid,fo.houseid from product_transgood as fo left join  product_goods as pg on fo.goodsid=pg.id  where fo.transid=" . $id;
		$re = $this->product->transgoodModel->fetchAll($sql);
		//查看库房
		$this->loadModel('product', 'house');
		$sql = "select * from product_house ";
		$house = $this->product->houseModel->fetchAll($sql);

		//var_dump($house);
		//exit;
		//入库类型
		$sql = "select * from wms_setting where type=1 ";
		$storetype = $this->product->houseModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}

	//重新配置库位信息
	public function resubkwinfo() {

		$this->leftpos = 3;
		$this->loadModel('product', 'transgood');
		$this->loadModel('product', 'transfer');
		$this->loadModel('product', 'housepos');

		$id = $_GET['id'];
		//购物车信息
		$sql = "select pg.*,fo.num,fo.id  as cartid,fo.houseposid,fo.houseid from product_transgood as fo left join  product_goods as pg on fo.goodsid=pg.id  where fo.transid=" . $id;
		$re = $this->product->transgoodModel->fetchAll($sql);
		foreach ($re as $key => $value) {
			$sql = "select id,title from product_housepos where houseid = {$value['houseid']}";
			$posrs = $this->product->houseposModel->fetchAll($sql);
			$re[$key]['pos'] = $posrs;
		}
		//查看库房
		$this->loadModel('product', 'house');
		$sql = "select * from product_house ";
		$house = $this->product->houseModel->fetchAll($sql);
		//入库类型
		$sql = "select * from wms_setting where type=1 ";
		$storetype = $this->product->houseModel->fetchAll($sql);
		$sql = "select * from product_transfer where id = {$id}";
		$rs = $this->product->transferModel->fetchRow($sql);
		//var_dump($rs);exit;
		include $this->loadWidget('amdinlteTheme');
	}

	//重新保存库位信息
	public function reinsert() {

		if ($_POST) {
			$this->loadModel('product', 'transgood');
			$this->loadModel('product', 'transfer');
			$this->loadHelper("extend");
			$id = $_POST['applyid'];
			$sql = "select pg.*,fo.num,fo.id as cartid from product_transgood as fo left join  product_goods as pg on fo.goodsid=pg.id  where fo.transid=" . $id;
			$re = $this->product->transgoodModel->fetchAll($sql);
			if (!$re) {
				ajaxReturn('', '没有任何入库的商品', 0);
			}
			if (in_array(0, $_POST['houseposid'])) {
				ajaxReturn('', '请选择商品的库房库位', 0);
			}
			$odata = $_POST['data'];
			if ($odata['rktp'] == 0) {
				ajaxReturn('', '请选择入库类型', 0);
			}
			$rs = $_POST['trids'];
			$odata['step'] = 5;
			$line = $this->product->transferModel->update($odata, "id=$id");
			$tag = true;
			foreach ($rs as $k => $val) {
				$data = array();
				$data['houseid'] = $_POST['houseid'][$k];
				$data['houseposid'] = $_POST['houseposid'][$k];
				$ta = $this->product->transgoodModel->update($data, "id=$val");
				if (!$ta) {
					continue;
				}
			}
			if ($tag) {
				$url = "http://" . ROOT_URL . "/index.php/iManage/cash/bank";
				echo json_encode(array('state' => 1, 'info' => "操作成功", 'data' => 'url', 'url' => $url));exit;
			} else {
				ajaxReturn('', '提交失败', 0);exit;
			}
		}
	}
	//商品调度损坏登记
	public function goodDestory() {
		$this->leftpos = 3;
		$this->loadModel('product', 'transgood');
		$this->loadModel('product', 'transfer');
		$this->loadModel('product', 'housepos');
		$id = $_GET['id'];
		$sql = "select pg.*,fo.num,fo.id  as cartid,fo.houseposid,fo.houseid,fo.desnum,fo.losnum from product_transgood as fo left join  product_goods as pg on fo.goodsid=pg.id  where fo.transid=" . $id;
		$re = $this->product->transgoodModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//商品调度丢失登记
	public function goodLoss() {
		$this->leftpos = 3;
		$this->loadModel('product', 'transgood');
		$this->loadModel('product', 'transfer');
		$this->loadModel('product', 'housepos');
		$id = $_GET['id'];
		$sql = "select pg.*,fo.num,fo.id  as cartid,fo.houseposid,fo.houseid,fo.desnum,fo.losnum from product_transgood as fo left join  product_goods as pg on fo.goodsid=pg.id  where fo.transid=" . $id;
		$re = $this->product->transgoodModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}

	//商品损坏登记提交
	public function subDestory() {

		if ($_POST) {
			$this->loadModel('product', 'transfer');
			$this->loadHelper('extend');
			$data['step'] = 9;
			$id = $_POST['id'];
			$line = $this->product->transferModel->update($data, "id=$id");
			if ($line) {
				$url = "http://" . ROOT_URL . "/index.php/iManage/cash/bank";
				echo json_encode(array('state' => 1, 'info' => "操作成功", 'data' => 'url', 'url' => $url));exit;
			} else {
				$result = array('status' => 0, 'info' => '操作失败');
			}
			exit(json_encode($result));
		}
	}

	//修改商品损坏的数量
	public function updatedesnum() {
		$this->loadModel('product', 'transgood');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data['desnum'] = $_POST['num'];
			$sql = "select num from product_transgood where id ={$id}";
			$rs = $this->product->transgoodModel->fetchRow($sql);
			if ($data['desnum'] > $rs['num']) {
				ajaxReturn('', '损坏数量不能大于总数量', 0);
			}
			if (empty($data['desnum'])) {
				ajaxReturn('', '数据有误', 0);
			}
			$line = $this->product->transgoodModel->update($data, "id=" . $id);
			if ($line) {
				ajaxReturn('', '修改成功', 1);
			} else {
				ajaxReturn('', '修改失败或数据未改变', 0);
			}
		}
	}
	//修改商品丢失的数量
	public function updatelosnum() {
		$this->loadModel('product', 'transgood');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data['losnum'] = $_POST['num'];
			$sql = "select num from product_transgood where id ={$id}";
			$rs = $this->product->transgoodModel->fetchRow($sql);
			if ($data['losnum'] > $rs['num']) {
				ajaxReturn('', '丢失数量不能大于总数量', 0);
			}
			if (empty($data['losnum'])) {
				ajaxReturn('', '数据有误', 0);
			}
			$line = $this->product->transgoodModel->update($data, "id=" . $id);
			if ($line) {
				ajaxReturn('', '修改成功', 1);
			} else {
				ajaxReturn('', '修改失败或数据未改变', 0);
			}
		}
	}
	//物流信息录入
	public function inserwl() {

		$this->leftpos = 3;
		$id = $_GET['id'];
		$this->loadHelper('extend');
		$this->loadModel('product', 'transfer');
		$this->loadModel('product', 'transgood');
		$sql = "select po.*,pg.title,pg.imgpath,pg.barcode,phs.title as phstitle,ph.title as phtitle from product_transgood as po left join product_goods as pg on pg.id=po.goodsid left join product_house as ph on ph.id=po.houseid left join product_housepos as phs on phs.id=po.houseposid where po.transid=$id";
		$goods = $this->product->transgoodModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//保存物流信息
	public function saveWlinfo() {
		if ($_POST) {
			$this->loadModel('product', 'transfer');
			$this->loadHelper("extend");
			$id = $_POST['applyid'];
			$data = $_POST['data'];
			$data['step'] = 8;
			$line = $this->product->transferModel->update($data, "id=$id");
			if ($line) {
				$url = "http://" . ROOT_URL . "/index.php/iManage/cash/bank";
				echo json_encode(array('state' => 1, 'info' => "操作成功", 'data' => 'url', 'url' => $url));exit;
			} else {
				ajaxReturn('', '提交失败', 0);exit;
			}
		}
	}
	//保存库位信息
	public function inserkwinfo() {
		if ($_POST) {
			$this->loadModel('product', 'transgood');
			$this->loadModel('product', 'transfer');
			$this->loadHelper("extend");
			$id = $_POST['applyid'];
			$sql = "select pg.*,fo.num,fo.id as cartid from product_transgood as fo left join  product_goods as pg on fo.goodsid=pg.id  where fo.transid=" . $id;
			$re = $this->product->transgoodModel->fetchAll($sql);
			if (!$re) {
				ajaxReturn('', '没有任何入库的商品', 0);
			}
			if (in_array(0, $_POST['houseposid'])) {
				ajaxReturn('', '请选择商品的库房库位', 0);
			}
			$odata = $_POST['data'];
			if ($odata['rktp'] == 0) {
				ajaxReturn('', '请选择入库类型', 0);
			}
			$rs = $_POST['trids'];
			$line = $this->product->transferModel->update($odata, "id=$id");
			$tag = true;

			if ($line) {
				foreach ($rs as $k => $val) {
					$data = array();
					$data['houseid'] = $_POST['houseid'][$k];
					$data['houseposid'] = $_POST['houseposid'][$k];
					$tag = $this->product->transgoodModel->update($data, "id=$val");
					if (!$tag) {
						break;
					}
				}
			} else {
				$tag = false;
			}
			if ($tag) {
				$this->product->transferModel->update(array('step' => 2), "id=" . $id);
				$url = "http://" . ROOT_URL . "/index.php/iManage/cash/bank";
				echo json_encode(array('state' => 1, 'info' => "操作成功", 'data' => 'url', 'url' => $url));exit;
			} else {

				ajaxReturn('', '提交失败', 0);exit;
			}

		}
	}

	//商品调度库位选择
	public function subtrankw() {
		$this->loadModel('product', 'transfer');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data['towei'] = $_POST['kwid'];
			$data['step'] = 2;
			$line = $this->product->transferModel->update($data, "id=" . $id);
			if ($line) {
				$result = array('status' => 1, 'info' => '提交成功');
			} else {
				$result = array('status' => 0, 'info' => '提交失败');
			}
			exit(json_encode($result));
		}
	}
	//选择调度商品
	public function chosegood() {
		if ($_POST) {
			$this->loadHelper('extend');
			$data = $_POST['data'];
			$this->loadModel('product', 'relation');
			$sql1 = "select houseid,houseposid,num from product_relation where id = {$data['ykw']} ";
			$sql2 = "select houseid,houseposid from product_relation where id = {$data['mbkw']} ";
			$re1 = $this->product->relationModel->fetchRow($sql1);
			$re2 = $this->product->relationModel->fetchRow($sql2);
			$trdata['goodsid'] = $data['goodsid'];
			$trdata['userid'] = $this->info['id'];
			$trdata['num'] = $data['num'];
			$trdata['fromku'] = $re1['houseid'];
			$trdata['fromwei'] = $re1['houseposid'];
			$trdata['toku'] = $re2['houseid'];
			$trdata['towei'] = $re2['houseposid'];
			$trdata['applytime'] = time();
			$trdata['note'] = $data['note'];
			$trdata['yreid'] = $data['ykw'];
			$trdata['mbreid'] = $data['mbkw'];
			$trdata['title'] = $data['title'];
			if ($trdata['towei'] == $trdata['fromwei']) {
				ajaxReturn('back', '位置未发生改变,提交失败', 0);
				exit;
			}
			if ($data['num'] > $re1['num']) {
				ajaxReturn('back', '转移的数量不合法,需少于' . $re1['num'], 0);
				exit;
			}
			$this->loadModel('product', 'transfer');
			$bkid = $this->product->transferModel->insert($trdata);
			if ($bkid) {
				ajaxReturn('back', '提交申请成功', 1);exit;
			} else {
				ajaxReturn('back', '提交申请失败', 0);exit;
			}
		} else {
			$this->leftpos = 3;
			$this->loadModel('product', 'goods');
			$sql = "select id,title from product_goods";
			$re = $this->product->goodsModel->fetchAll($sql);
			$this->loadModel('wms', 'setting');
			$sql = "select * from wms_setting where status=1 and type = 0";
			$ck = $this->wms->settingModel->fetchAll($sql);
			$sql = "select * from wms_setting where status=1 and type ";
			$rk = $this->wms->settingModel->fetchAll($sql);
			include $this->loadWidget('amdinlteTheme');
		}
	}
	//获取商品对于的库存位置
	public function getpoi() {
		$goodsid = $_POST['goodsid'];
		$this->loadModel('product', 'relation');
		$this->loadHelper('extend');
		$sql = "select pre.*,ph.title as kfnm ,phs.title as kunm from product_relation as pre
              join product_house    as ph  on ph.id   = pre.houseid
              join product_housepos as phs on phs.id  = pre.houseposid
		      where goodsid=$goodsid";
		$re = $this->product->relationModel->fetchAll($sql);
		$html = "<option value=''>选择位置</option>";
		foreach ($re as $val) {

			$html .= "<option value='" . $val['id'] . "' >" . $val['kfnm'] . '-' . $val['kunm'] . '(&nbsp;' . $val['num'] . '件&nbsp;)' . "</option>";
		}
		$data['html'] = $html;
		echo json_encode($data);
	}
	//申请审核处理
	public function check() {
		if ($_POST) {
			$this->loadHelper('extend');
			$this->loadModel('product', 'transfer');
			$data = $_POST['data'];
			$data['dtime'] = time();
			$bk = $this->product->transferModel->update($data, $data['id']);

			if ($data['state'] == 2) {
				$sql = "select yreid,mbreid,num from product_transfer where id = {$data['id']}";
				$re = $this->product->transferModel->fetchRow($sql);
				$this->loadModel('product', 'relation');
				$sql1 = "select num from product_relation where id ={$re['yreid']}";
				$sql2 = "select num from product_relation where id ={$re['mbreid']}";
				$re1 = $this->product->relationModel->fetchRow($sql1);
				$re2 = $this->product->relationModel->fetchRow($sql2);
				$data1['num'] = $re1['num'] - $re['num'];
				$data2['num'] = $re2['num'] + $re['num'];
				$this->product->relationModel->update($data1, $re['yreid']);
				$this->product->relationModel->update($data2, $re['mbreid']);
			}
			if ($bk) {
				ajaxReturn('back', '审核成功', 1);exit;
			} else {
				ajaxReturn('back', '审核失败', 0);exit;
			}
		} else {
			$this->leftpos = 3;
			$id = $_GET['id'];
			include $this->loadWidget('amdinlteTheme');
		}
	}

	//删除采购申请
	public function del() {
		$this->leftpos = 6;
		$this->loadModel('product', 'transfer');
		$this->loadHelper('extend');
		if ($_GET) {
			$id = $_GET['id'];

			$line = $this->product->transferModel->delete('id=' . $id);
			if ($line) {
				ajaxReturn('back', '操作成功', 1);
			} else {
				ajaxReturn('back', '操作失败', 0);
			}
		}
	}
	//删除采购申请
	public function delapply() {
		$this->loadModel('product', 'apply');
		$this->loadHelper('extend');
		if ($_GET) {
			$id = $_GET['id'];

			$line = $this->product->applyModel->delete('id=' . $id);
			if ($line) {
				ajaxReturn('back', '操作成功', 1);
			} else {
				ajaxReturn('back', '操作失败', 0);
			}
		}
	}

	//采购列表
	public function apply() {
		$this->loadModel('product', 'apply');
		$sql = "select pa.*,sa.name as cgname,zg.name as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid order by pa.id desc ";
		$re = $this->product->applyModel->fetchAll($sql);
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
		if ($re['status'] == 4) {
			//购物车信息
			$sql = "select pg.*,fo.num,fo.id as cartid from product_ordercart as fo left join  product_goods as pg on fo.goodsid=pg.id  where fo.applyid=" . $id;

			$goods = $this->system->adminModel->fetchAll($sql);
		}
		if ($re['status'] >= 5) {
			$sql = "select po.*,pg.title,pg.imgpath,pg.barcode,phs.title as phstitle,ph.title as phtitle from product_orderinfo as po left join product_goods as pg on pg.id=po.goodsid left join product_house as ph on ph.id=po.houseid left join product_housepos as phs on phs.id=po.houseposid where po.applyid=$id";
			$goods = $this->system->adminModel->fetchAll($sql);
		}

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
			ajaxReturn('操作失败', 0);exit;
		}
	}
/* 	//采购负责人审核
public function cgfzrcheck(){
$this->loadModel('product','apply');
$this->loadHelper('extend');
$data['cgfzrid']=$_POST['cgzrrid'];
$data['status']=2;
$id	=	$_POST['id'];

$line	=	$this->product->applyModel->update($data,"id=$id");
if($line){
$result	=	array('status'=>1,'info'=>'操作成功');
}else{
$result	=	array('status'=>0,'info'=>'操作失败');
}
exit(json_encode($result));
} */
	//选择采购方式
	public function cgfscheck() {
		$this->loadModel('product', 'apply');
		$this->loadHelper('extend');
		$data['type'] = $_POST['cgtype'];

		$data['status'] = 3;
		$id = $_POST['id'];
		$line = $this->product->applyModel->update($data, "id=$id");
		if ($line) {
			$this->loadModel('product', 'applyprofile');
			$d['created2'] = time();
			$d['truename2'] = $this->info['truename'];
			$d['mobile2'] = $this->info['mobile'];
			$l = $this->product->applyprofileModel->update($d, "applyid=$id");
			if ($l) {
				$result = array('status' => 1, 'info' => '操作成功');
			} else {
				$result = array('status' => 0, 'info' => '操作失败1');
			}
			// $result	=	array('status'=>1,'info'=>'操作成功');
		} else {
			$result = array('status' => 0, 'info' => '操作失败');
		}
		exit(json_encode($result));
	}
	//采购计划表表
	public function plan() {
		$applyid = $_GET['id'];
		$this->loadModel('product', 'apply');
		$sql = "select title from product_apply where id=$applyid";
		$apply = $this->product->applyModel->fetchRow($sql);
		//计划列表
		$sql = "select * from product_applyplan where applyid=$applyid";
		$plan = $this->product->applyModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//添加采购计划
	public function addplan() {
		$applyid = $_GET['id'];
		$this->loadModel('product', 'apply');
		$sql = "select title from product_apply where id=$applyid";
		$apply = $this->product->applyModel->fetchRow($sql);

		$this->loadModel('product', 'ordercart');

		$sql = "select pg.*,fo.num,fo.id as cartid from product_ordercart as fo left join  product_goods as pg on fo.goodsid=pg.id  where fo.applyid=" . $applyid;
		$goods = $this->product->ordercartModel->fetchAll($sql);
		foreach ($goods as $k => $val) {
			//查看之前合作过的加盟商
			$sql = "select pg.*,cs.title from product_goodssupply as pg left join crm_supplier as cs on cs.id=pg.supplyid where pg.goodsuuid='" . $val['uuid'] . "' order by pg.id desc	";
			$supp = $this->product->applyModel->fetchAll($sql);
			$goods[$k]['supply'] = $supp;
		}
		//查看所有供应商
		$sql = "select * from crm_supplier ";
		$supply = $this->product->applyModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');

	}
	//通过商品uuid查询供应商历史购买信息
	public function getGoodsSupply() {
		$this->loadModel('product', 'goodssupply');
		$this->loadHelper('extend');
		$supplyid = $_POST['id'];
		$goodsuuid = $_POST['goodsuuid'];
		$cartid = $_POST['cartid'];
		$sql = "select * from product_goodssupply where goodsuuid='" . $goodsuuid . "' and supplyid=$supplyid";
		$re = $this->product->goodssupplyModel->fetchAll($sql);
		$str = "采购历史记录:";
		foreach ($re as $k => $val) {
			$str .= ($k + 1) . ".采购数量" . $val['num'] . " 采购单价:" . $val['price'] . " 采购时间：" . date("Y-m-d") . "&nbsp;&nbsp;<br/>";
		}
		echo $str;

	}
	//插入采购计划
	public function insertplan() {
		$this->loadModel('product', 'applyplan');
		$this->loadModel('product', 'applygoods');
		$this->loadHelper('extend');
		//$id=$_POST['id'];
		$data = $_POST['data'];
		if (empty($data['title'])) {
			ajaxReturn('', '操作失败', 0);exit;
		}
		if (empty($_POST['cartid'])) {
			ajaxReturn('', '没有采购商品', 0);exit;
		}
		foreach ($_POST['cartid'] as $k => $val) {
			if (empty($_POST['oldsupply_' . $val]) && empty($_POST['supply_' . $val])) {
				ajaxReturn('', '有商品未选择采购商', 0);exit;
			}

		}

		$data['truename'] = $this->info['truename'];
		$data['mobile'] = $this->info['mobile'];
		$data['created'] = time();
		$re = $this->product->applyplanModel->insert($data);
		if ($re) {
			$insertsql = " insert into product_applygoods(applyid,planid,num,goodsid,price,supplyid) values";
			foreach ($_POST['cartid'] as $k => $val) {
				$supplyid = empty($_POST['oldsupply_' . $val]) ? $_POST['supply_' . $val] : $_POST['oldsupply_' . $val];
				if ($k == 0) {
					$insertsql .= "(" . $data['applyid'] . "," . $re . "," . $_POST['num'][$k] . "," . $_POST['goodsid'][$k] . ",'" . $_POST['price'][$k] . "'," . $supplyid . ")";
				} else {
					$insertsql .= ",(" . $data['applyid'] . "," . $re . "," . $_POST['num'][$k] . "," . $_POST['goodsid'][$k] . ",'" . $_POST['price'][$k] . "'," . $supplyid . ")";
				}
			}
			$line = $this->product->applygoodsModel->sqlexec($insertsql);
			if ($line) {
				ajaxReturn('back', '操作成功', 1);exit;
			} else {
				$this->product->applyplanModel->delete("id=$re");
				ajaxReturn('', '操作失败', 0);exit;
			}

		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	//编辑采购计划
	public function editplan() {
		$id = $_GET['id'];
		$this->loadModel('product', 'applyplan');
		$sql = "select pan.*,pp.title as applytitle from product_applyplan as pan left join product_apply as pp on pp.id=pan.applyid where pan.id=$id";
		$re = $this->product->applyplanModel->fetchRow($sql);
		//商品信息
		$this->loadModel('product', 'ordercart');
		$applyid = $re['applyid'];
		$sql = "select pg.*,fo.num,fo.id as cartid,fo.supplyid from product_applygoods as fo left join  product_goods as pg on fo.goodsid=pg.id  where fo.applyid=" . $applyid;
		$goods = $this->product->ordercartModel->fetchAll($sql);
		foreach ($goods as $k => $val) {
			//查看之前合作过的加盟商
			$sql = "select pg.*,cs.title from product_goodssupply as pg left join crm_supplier as cs on cs.id=pg.supplyid where pg.goodsuuid='" . $val['uuid'] . "' order by pg.id desc	";
			$supp = $this->product->ordercartModel->fetchAll($sql);
			$goods[$k]['supply'] = $supp;
		}
		//查看所有供应商
		$sql = "select * from crm_supplier ";
		$supply = $this->product->ordercartModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');
	}
	//保存采购计划
	public function updateplan() {
		$this->loadModel('product', 'applyplan');
		$this->loadModel('product', 'applygoods');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$data = $_POST['data'];
		if (empty($_POST['cartid'])) {
			ajaxReturn('', '没有采购商品', 0);exit;
		}
		foreach ($_POST['cartid'] as $k => $val) {
			if (empty($_POST['oldsupply_' . $val]) && empty($_POST['supply_' . $val])) {
				ajaxReturn('', '有商品未选择采购商', 0);exit;
			}

		}
		//开启事物
		// $this->product->applyplanModel->beginTransaction();
		$re = $this->product->applyplanModel->update($data, "id=$id");

		$sql = "insert into test_tbl (id,dr) values  (1,'2'),(2,'3'),...(x,'y') on duplicate key update dr=values(dr)";
		$insertsql = " insert into product_applygoods(id,supplyid) values";
		foreach ($_POST['cartid'] as $k => $val) {
			$supplyid = empty($_POST['oldsupply_' . $val]) ? $_POST['supply_' . $val] : $_POST['oldsupply_' . $val];
			if ($k == 0) {
				$insertsql .= "(" . $val . "," . $supplyid . ")";
			} else {
				$insertsql .= ",(" . $val . "," . $supplyid . ")";
			}
		}
		$insertsql .= " on duplicate key update supplyid=values(supplyid)";
		$line = $this->product->applygoodsModel->sqlexec($insertsql);
		if ($line) {
			//$this->product->applyplanModel->beginCommit();
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			// $this->product->applyplanModel->rollback();
			//$this->product->applyplanModel->delete("id=$re");
			ajaxReturn('', '操作失败', 0);exit;
		}

	}
	//删除采购计划
	public function delplan() {
		$this->loadModel('product', 'applyplan');
		$this->loadHelper('extend');
		if ($_GET) {
			$id = $_GET['id'];
			$line = $this->product->applyplanModel->delete('id=' . $id);
			if ($line) {
				ajaxReturn('back', '操作成功', 1);
			} else {
				ajaxReturn('back', '操作失败', 0);
			}
		}

	}
	//选择采购的商品
	public function selgoods() {
		$this->loadModel('product', 'goods');
		$this->loadModel('product', 'apply');
		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$userphone = null;
		$id = $_GET['id'];
		$sql = "select type from product_apply where id=$id";
		$apply = $this->product->applyModel->fetchRow($sql);
		if ($apply['type'] == 1) {
//补货采购
			$this->where .= " and isnew=0 ";
		} else {
			$this->where .= " and isnew=1 ";
		}
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
			//查看之前合作过的加盟商
			$sql = "select pg.*,cs.title from product_goodssupply as pg left join crm_supplier as cs on cs.id=pg.supplyid where pg.goodsuuid='" . $val['uuid'] . "' order by pg.id desc	";
			$supp = $this->product->goodsModel->fetchAll($sql);
			$re[$k]['supply'] = $supp;
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
		//查看所有供应商
		$sql = "select * from crm_supplier ";
		$supply = $this->product->goodscategoryModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//加入购物车
	public function addcart() {
		$this->loadModel('product', 'ordercart');
		$this->loadHelper("extend");
		if ($_POST) {
			if (!isset($_POST['goodsid'])) {
				ajaxReturn('', '请选择采购商品', 0);
			}
			$applyid = $_POST['id'];
			$tag = false;
			foreach ($_POST['goodsid'] as $v) {
				$data = array();
				$data['goodsid'] = $v;

				$data['num'] = $_POST['goodsnum_' . $v];
				if (empty($data['num'])) {continue;}
				$tag = true;
				//查看之前有没有添加该购物车
				$sql = 'select * from product_ordercart where  goodsid=' . $v . ' and applyid=' . $applyid;
				$r = $this->product->ordercartModel->fetchRow($sql);
				if ($r) {
					$odata['num'] = $_POST['goodsnum_' . $v] + $r['num'];
					$this->product->ordercartModel->update($odata, 'goodsid=' . $v . ' and applyid=' . $applyid);
				} else {
					$data['applyid'] = $applyid;
					$this->product->ordercartModel->insert($data);
				}

			}
			if ($tag) {
				ajaxReturn('0', '操作成功', 1);
			} else {
				ajaxReturn('0', '未填写购买商品数量', 0);
			}
		}

	}
	//查看已选中的商品--购物车中的商品
	public function cartlist() {
		$this->leftpos = 0;
		$this->loadModel('product', 'ordercart');
		$applyid = $_GET['applyid'];
		$sql = "select pg.*,fo.num,fo.id as cartid from product_ordercart as fo left join  product_goods as pg on fo.goodsid=pg.id  where fo.applyid=" . $applyid;
		$re = $this->product->ordercartModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}

	//修改购物车数量
	public function updatecart() {
		$this->loadModel('product', 'ordercart');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data['num'] = $_POST['num'];
			if (empty($data['num'])) {
				ajaxReturn('', '数据有误', 0);
			}

			$line = $this->product->ordercartModel->update($data, "id=" . $id);
			if ($line) {
				ajaxReturn('', '修改成功', 1);
			} else {
				ajaxReturn('', '修改失败', 0);
			}

		}

	}
	//提交所选商品
	public function changestatus2() {
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applyprofile');
		$this->loadHelper('extend');
		$id = $_POST['applyid'];
		$sql = "select * from product_ordercart where applyid=$id";
		$check = $this->product->applyModel->fetchRow($sql);
		if (!$check) {
			ajaxReturn('', '未选择采购商品', 0);exit;
		}
		$data['status'] = 4;
		$line = $this->product->applyModel->update($data, "id=$id");
		if ($line) {
			$d['created3'] = time();
			$d['truename3'] = $this->info['truename'];
			$d['mobile3'] = $this->info['mobile'];
			$l = $this->product->applyprofileModel->update($d, "applyid=$id");
			if ($l) {

				//ajaxReturn ( '', '操作成功', 1 );exit;
				$url = $this->url('cash/editapply', array('id' => $id));
				$r = array('state' => 1, 'info' => '操作成功', 'url' => $url);
				echo json_encode($r);exit;
			} else {
				ajaxReturn('', '操作失败', 0);exit;
			}
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}

	//提交采购计划列表
	public function changestatus3() {
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applyprofile');
		$this->loadHelper('extend');
		$id = $_POST['applyid'];
		$sql = "select * from product_ordercart where applyid=$id";
		$check = $this->product->applyModel->fetchRow($sql);
		if (!$check) {
			ajaxReturn('', '未选择采购商品', 0);exit;
		}
		$data['status'] = 4;
		$line = $this->product->applyModel->update($data, "id=$id");
		if ($line) {
			$d['created3'] = time();
			$d['truename3'] = $this->info['truename'];
			$d['mobile3'] = $this->info['mobile'];
			$l = $this->product->applyprofileModel->update($d, "applyid=$id");
			if ($l) {

				//ajaxReturn ( '', '操作成功', 1 );exit;
				$url = $this->url('cash/editapply', array('id' => $id));
				$r = array('state' => 1, 'info' => '操作成功', 'url' => $url);
				echo json_encode($r);exit;
			} else {
				ajaxReturn('', '操作失败', 0);exit;
			}
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}

	//提交其他相关信息
	public function cartotherinfo() {
		$this->leftpos = 0;
		$this->loadModel('product', 'ordercart');
		$applyid = $_GET['applyid'];
		//购物车信息
		$sql = "select pg.*,fo.num,fo.id as cartid from product_ordercart as fo left join  product_goods as pg on fo.goodsid=pg.id  where fo.applyid=" . $applyid;
		$re = $this->product->ordercartModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');

	}
	//提交购物车--
	public function tjcart() {
		$this->loadModel('product', 'ordercart');
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'orderinfo');
		$this->loadHelper("extend");

		if ($_POST) {
			//查看总价
			$applyid = $_POST['applyid'];
			$sql = "select pg.*,fo.num,fo.id as cartid from product_ordercart as fo left join  product_goods as pg on fo.goodsid=pg.id  where fo.applyid=" . $applyid;
			$re = $this->product->ordercartModel->fetchAll($sql);
			if (!$re) {
				ajaxReturn('', '购物车中无商品', 0);
			}
			$odata = $_POST['data'];
			if (!empty($_FILES['files']['name'])) {
				$this->loadHelper('uploader');
				$uploader = new uploader();
				$odata['filepath'] = $uploader->start('files');
				$odata['filename'] = $_FILES['files']['name'];
			} else {
				ajaxReturn('', '未提交合同信息', 0);
			}
			$ordernum = date("ymdhis") . substr(uniqid(rand()), -6);

			//$odata['uuid']		=	'uuid()';
			//$odata['applyid']	=	$applyid;
			//$odata['ordernum']	=	$ordernum;
			$odata['sendtime'] = strtotime($odata['sendtime']);
			//$odata['created']	=	time();
			//print_r($odata);exit;
			$line = $this->product->applyModel->update($odata, "id=$applyid");

			$allprice = 0;
			$tag = true;
			if ($line) {
				foreach ($re as $val) {
					$data = array();
					$data['applyid'] = $applyid;
					$data['num'] = $val['num'];
					$data['price'] = $val['costprice'];
					$data['goodsid'] = $val['id'];
					$tag = $this->product->orderinfoModel->insert($data);
					if (!$tag) {
						$this->product->orderinfoModel->delete("applyid=$applyid");
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
				//$this->product->ordercartModel->delete("applyid=$applyid");
				$this->product->applyModel->update(array('status' => 4), "id=" . $applyid);
				ajaxReturn('back', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}
		}
	}
	//财务信息录入
	public function financeinfo() {
		$applyid = $_GET["id"];

		include $this->loadWidget('amdinlteTheme');

	}
	//财务信息录入修改
	public function financeinfoupdate() {
		$this->loadModel('product', 'apply');
		$this->loadHelper('extend');
		$data = $_POST['data'];
		if ($data['ispaydeposit'] == 1 && $data['deposit'] <= 0) {
			ajaxReturn('', '请填写已支付的定金额度', 0);exit;
		}
		$id = $_POST['id'];
		$data['status'] = 5;
		$line = $this->product->applyModel->update($data, "id=$id");
		if ($line) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}

	}
	//库房验收
	public function storecheck() {
		$this->loadModel('product', 'apply');
		$this->loadHelper('extend');

		$id = $_POST['applyid'];
		if ($_POST['acceptance'] == 2) {
//没问题
			$data['status'] = 6;
			$data['isback'] = 2;
		} else {
//有问题
			if ($_POST['isback'] == 1) {
				//退回
				$data['status'] = -2;
				$data['isback'] = 1;
			} else {
//修改合同金额，及合同信息
				$data['status'] = 6;
				$data['isback'] = 2;
				$data['price'] = $_POST['price'];
				if ($_POST['price'] <= 0) {
					ajaxReturn('', '请填写合同金额', 0);
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
		}

		$line = $this->product->applyModel->update($data, "id=$id");
		if ($line) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}

	}
	//采购执行确认
	public function purchasecheck() {
		$this->loadModel('product', 'apply');
		$this->loadHelper('extend');
		$id = $_GET['id'];
		$data['status'] = 7;
		$line = $this->product->applyModel->update($data, "id=$id");
		if ($line) {
			ajaxReturn('', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	//财务付尾款
	public function paymoney() {
		$this->loadModel('product', 'apply');
		$this->loadHelper('extend');
		$id = $_GET['id'];
		$data['status'] = 8;
		$line = $this->product->applyModel->update($data, "id=$id");
		if ($line) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	//商品入库
	public function goodstostore() {
		$this->loadModel('product', 'apply');
		$id = $_GET["id"];
		//查看商品
		$sql = "select po.*,pg.title,pg.imgpath,pg.barcode from product_orderinfo as po left join product_goods as pg on pg.id=po.goodsid where po.applyid=$id";
		$goods = $this->product->applyModel->fetchAll($sql);

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
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'orderinfo');
		$this->loadHelper('extend');
		$applyid = $_POST['applyid'];
		$tag = $_POST['tag']; //0草稿 1确认提交
		$id = $_POST['id'];
		$status = 8;
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

			$status = 9;
			$this->loadModel('product', 'locked');
			$this->product->lockedModel->update(array('islocked' => 0, 'created' => time()), "id=1");
		}
		$sql = "insert into product_orderinfo(id,houseid,houseposid) values";
		foreach ($id as $k => $v) {
			if ($k == 0) {
				$sql .= "(" . $v . "," . $_POST['houseid'][$k] . "," . $_POST['housepos'][$k] . ")";
			} else {
				$sql .= ",(" . $v . "," . $_POST['houseid'][$k] . "," . $_POST['housepos'][$k] . ")";
			}
		}
		$sql .= "ON DUPLICATE KEY UPDATE houseid=VALUES(houseid), houseposid=VALUES(houseposid)";
		//echo $sql;exit;
		$line = $this->product->orderinfoModel->sqlexec($sql);
		if (!$line) {
			ajaxReturn('', '操作失败', 0);exit;
		}
		$data['storeid'] = $_POST['storeid'];
		$data['status'] = $status;
		$line = $this->product->applyModel->update($data, "id=$applyid");
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
		}

		//修改库存*************************** 结束  ******************************************
		// ajaxReturn ( '', '操作成功', 1 );exit;
		if ($line) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}

	//调拨出入库方式设置
	public function zdcrtp() {
		$this->loadModel('product', 'transfer');
		$this->loadHelper('extend');
		$data['cktp'] = $_POST['ckid'];
		$data['step'] = 2;
		$data['rktp'] = $_POST['rkid'];
		$id = $_POST['id'];
		$line = $this->product->transferModel->update($data, "id=$id");
		if ($line) {
			$result = array('status' => 1, 'info' => '操作成功');
		} else {
			$result = array('status' => 0, 'info' => '操作失败');
		}
		exit(json_encode($result));
	}

	//调拨入库负责人设置
	public function fzrsz() {
		$this->loadModel('product', 'transfer');
		$this->loadHelper('extend');
		$data['fzrid'] = $_POST['fzrid'];
		$data['step'] = 3;
		$id = $_POST['id'];
		$line = $this->product->transferModel->update($data, "id=$id");
		if ($line) {
			$result = array('status' => 1, 'info' => '操作成功');
		} else {
			$result = array('status' => 0, 'info' => '操作失败');
		}
		exit(json_encode($result));
	}

	//确认调拨单至调出库房
	public function kfjd() {

		$this->loadModel('product', 'transfer');
		$this->loadHelper('extend');
		$data['step'] = 4;
		$id = $_POST['id'];
		$line = $this->product->transferModel->update($data, "id=$id");
		if ($line) {
			$result = array('status' => 1, 'info' => '操作成功');
		} else {
			$result = array('status' => 0, 'info' => '操作失败');
		}
		exit(json_encode($result));
	}
	//库房确认配货
	public function kfpeihuo() {
		$this->loadModel('product', 'transfer');
		$this->loadHelper('extend');
		$data['step'] = 5;
		$id = $_POST['id'];
		$line = $this->product->transferModel->update($data, "id=$id");
		if ($line) {
			$result = array('status' => 1, 'info' => '操作成功');
		} else {
			$result = array('status' => 0, 'info' => '操作失败');
		}
		exit(json_encode($result));
	}
	//库房核验是否配货
	public function checkpeih() {

		$this->loadModel('product', 'transfer');
		$this->loadHelper('extend');
		$data['step'] = $_POST['step'];
		$id = $_POST['id'];
		$line = $this->product->transferModel->update($data, "id=$id");
		if ($line) {
			$result = array('status' => 1, 'info' => '操作成功');
		} else {
			$result = array('status' => 0, 'info' => '操作失败');
		}
		exit(json_encode($result));
	}

	//库房确认是否收货
	public function checkShouh() {
		$this->loadModel('product', 'transfer');
		$this->loadHelper('extend');
		$data['step'] = $_POST['step'];
		$id = $_POST['id'];
		$line = $this->product->transferModel->update($data, "id=$id");
		if ($line) {
			$result = array('status' => 1, 'info' => '操作成功');
		} else {
			$result = array('status' => 0, 'info' => '操作失败');
		}
		exit(json_encode($result));
	}

	//调拨确认结束
	public function endDiaobo() {
		$this->loadModel('product', 'transfer');
		$this->loadHelper('extend');
		$data['step'] = 12;
		$id = $_POST['id'];
		$line = $this->product->transferModel->update($data, "id=$id");
		$this->loadModel('product', 'locked');
		$this->product->lockedModel->update(array('islocked' => 0, 'created' => time()), "id=1");
		if ($line) {
			$result = array('status' => 1, 'info' => '操作成功');
		} else {
			$result = array('status' => 0, 'info' => '操作失败');
		}
		exit(json_encode($result));
	}

	public function subdiaodu() {
		if ($_POST) {
			$this->loadHelper('extend');
			$this->loadModel('product', 'transfer');
			$id = $_POST['id'];
			$data['dtime'] = time();
			$data['state'] = 2;
			$data['step'] = 5;
			$bk = $this->product->transferModel->update($data, $id);
			$sql = "select yreid,mbreid,num from product_transfer where id = {$data['id']}";
			$re = $this->product->transferModel->fetchRow($sql);
			$this->loadModel('product', 'relation');
			$sql1 = "select num from product_relation where id ={$re['yreid']}";
			$sql2 = "select num from product_relation where id ={$re['mbreid']}";
			$re1 = $this->product->relationModel->fetchRow($sql1);
			$re2 = $this->product->relationModel->fetchRow($sql2);
			$data1['num'] = $re1['num'] - $re['num'];
			$data2['num'] = $re2['num'] + $re['num'];
			$this->product->relationModel->update($data1, $re['yreid']);
			$this->product->relationModel->update($data2, $re['mbreid']);
			if ($bk) {
				$result = array('status' => 1, 'info' => '操作成功');
			} else {
				$result = array('status' => 0, 'info' => '操作失败');
			}
			exit(json_encode($result));
		}
	}
}
?>