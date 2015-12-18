<?php
/*
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */
class earlywarning extends actionAbstract {

	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 8;
	public $type = 0;
	public $leftpos = 0;
	public $like = "";
	public $where = "";

	/*
	 * 构造
	 */
	function __construct() {
		parent::__construct();
		//var_dump(acl::getCookie('admininfo'));exit;
		// $this->info = acl::checkLogin('admininfo',$this->url('common/login'));
		if (!isset($_SESSION['admininfo'])) {header('location:' . $this->url('common/login'));}$this->info = $_SESSION['admininfo'];
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		$this->loadHelper('handleimage');
		// print_r($this->info);
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			//ajax request
			$this->checkpower();
		}

	}
	/*
	 *  逾期预警 beoverdue
	 */
	public function Beoverdue() {
		$this->leftpos = 2;

		$this->loadModel('product', 'goods');

		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$userphone = null;
		if (isset($_GET['status']) && $_GET['status'] !== "") {
			$this->where .= " and pg.status = " . $_GET['status'] . "";
		}
		if (isset($_GET['isdiscount']) && $_GET['isdiscount'] !== "") {
			$this->where .= " and pg.isdiscount = " . $_GET['isdiscount'] . "";
		}
		if (!empty($_GET['userphone'])) {
			$this->where .= " and (pg.title like  '%" . $_GET['userphone'] . "%' or pg.barcode like '%" . $_GET['userphone'] . "%')";

			$userphone = $_GET['userphone'];
		}
		$sid = '';
		if (isset($_GET['categoryuuid']) && $_GET['categoryuuid'] !== "") {
			$sid = $_GET['categoryuuid'];
			$this->where .= " and pg.categoryuuid = " . $_GET['categoryuuid'] . "";
		}
		if (isset($_GET['branduuid']) && $_GET['branduuid'] !== "") {
			$this->where .= " and pg.branduuid = " . $_GET['branduuid'] . "";
		}
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = 10;
		$offset = ($page - 1) * $size;
		$nowtime = time();
		$sql = "select pp.productontime,pg.beoverdue from product_productontime as pp left join product_goods as pg on pp.goodsuuid=pg.uuid where pp.productontime < pg.beoverdue*3600*24+$nowtime " . $this->where . "";
		$sql = "select pg.* from product_productontime as pp left join product_goods as pg on pp.goodsuuid=pg.uuid where pp.productontime < pg.beoverdue*3600*24+$nowtime " . $this->where . "";

		// $sql="select count(*) from product_goods  where shelflife <= beoverdue ".$this->where;
		$count = $this->product->goodsModel->fetchAll($sql);
		$count = count($count);
		
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select pp.productontime as endtime,pp.num,pg.* from product_productontime as pp left join product_goods as pg on pp.goodsuuid=pg.uuid where pp.productontime < pg.beoverdue*3600*24+$nowtime " . $this->where . "  limit " . $offset . "," . $size . "";
		//$sql="select product_goods.*,fc.title as fctitle from product_goods left join product_goodscategory as fc on fc.id=product_goods.categoryuuid  where shelflife <= beoverdue  ".$this->where."  limit ".$offset.",".$size."";

		//var_dump($sql); exit;

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
		$sql = "select * from product_brand order by sort asc ";
		$brand = $this->product->goodscategoryModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');
	}
	/*
	 * 库存预警
	 */
	public function Inventory() {
		$this->leftpos = 1;
		$this->loadModel('product', 'goods');
		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$userphone = null;
		if (isset($_GET['status']) && $_GET['status'] !== "") {
			$this->where .= " and product_goods.status = " . $_GET['status'] . "";
		}
		if (isset($_GET['isdiscount']) && $_GET['isdiscount'] !== "") {
			$this->where .= " and product_goods.isdiscount = " . $_GET['isdiscount'] . "";
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
		if (isset($_GET['brandid']) && $_GET['brandid'] !== "") {
			$this->where .= " and product_goods.branduuid = " . $_GET['branduuid'] . "";
		}
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = 9;
		$offset = ($page - 1) * $size;
		$sql = "select count(*) from product_goods  where number <= numberone " . $this->where;
		//echo $sql;exit;
		$count = $this->product->goodsModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select product_goods.*,fc.title as fctitle from product_goods left join product_goodscategory as fc on fc.uuid=product_goods.categoryuuid  where number <= numberone  " . $this->where . "  limit " . $offset . "," . $size . "";

		//var_dump($sql); exit;

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
		$sql = "select * from product_brand order by sort asc ";
		$brand = $this->product->goodscategoryModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');
	}
	/***
	 *
	 *添加商品
	 *
	 ****/
	public function addshop() {
		$this->leftpos = 2;
		$this->loadModel('product', 'goodscategory');
		$this->loadHelper("Treeuuid");
		$sql = "select * from product_goodscategory ";
		$category = $this->product->goodscategoryModel->fetchAll($sql);
		$tree = new Treeuuid($category);
		$str = "<option value=\$id >\$spacer\$title</option>";
		$str = "<option value=\$id \$selected>\$spacer\$title</option>";
		$trees = $tree->get_tree(0, $str);
		//品牌
		$sql = "select * from product_brand order by sort asc ";
		$brand = $this->product->goodscategoryModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');
	}
	/***
	 *
	 *插入商品
	 *
	 ****/
	public function insertshop() {
		$this->loadModel('product', 'goods');
		if ($_POST) {
			$this->loadHelper('extend');
			//$this->loadHelper('image');
			$data = $_POST['data'];

			if (!empty($_FILES['imagefile']['name'])) {
				$this->loadHelper('uploader');
				$uploader = new uploader();
				$data['imgpath'] = $uploader->start('imagefile');

			}
			$data['remark'] = $_POST['remark'];
			$data['uuid'] = 'uuid()';

			$re = $this->product->goodsModel->insert($data);

			if ($re) {
				//日志
				/*  $user['userid']=$this->info['id'];
				$user['username']=$this->info['username'];
				$user['created']=time();
				$user['type']=0;
				$user['level']=1;
				$user['intro']=$user['username']."于".date("Y-m-d H:i:s",$user['created'])."添加了商品".$data['title'];

				$re=$this->system->logsModel->insert($user); */
				ajaxReturn('back', '添加成功', 1);exit;
			} else {
				ajaxReturn('back', '添加失败', 0);exit;
			}

		}
		include $this->loadWidget('amdinlteTheme');
	}
	/*
	 * 编辑商品详情
	 */
	public function editshop() {
		$this->leftpos = 2;
		$this->loadModel('product', 'goods');
		$this->loadModel('product', 'goodscategory');
		$id = $_GET['id'];
		$sql = "select * from product_goods where id=$id";
		$re = $this->product->goodsModel->fetchRow($sql);
		if (!$re) {die("该产品不存不在");}
		$this->loadHelper("Treeuuid");
		$sql = "select * from product_goodscategory ";
		$category = $this->product->goodscategoryModel->fetchAll($sql);
		$tree = new Treeuuid($category);
		$sid = $re['categoryuuid'];
		$str = "<option value=\$uuid \$selected>\$spacer\$title</option>";
		$trees = $tree->get_tree(0, $str, $sid);

		//品牌
		$sql = "select * from product_brand order by sort asc ";
		$brand = $this->product->goodscategoryModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');
	}
	/***
	 *
	 *修改商品
	 *
	 ****/
	public function update() {

		$this->loadModel('product', 'goods');
		if ($_POST) {
			$this->loadHelper('extend');
			//$this->loadHelper('image');
			$data = $_POST['data'];
			$id = $_POST['id'];
			if (!empty($_FILES['imagefile']['name'])) {
				$this->loadHelper('uploader');
				$uploader = new uploader();
				$data['imgpath'] = $uploader->start('imagefile');

			}

			$re = $this->product->goodsModel->update($data, $id);

			if ($re) {
				//日志
				/*  $user['userid']=$this->info['id'];
				$user['username']=$this->info['username'];
				$user['created']=time();
				$user['type']=0;
				$user['level']=1;
				$user['intro']=$user['username']."于".date("Y-m-d H:i:s",$user['created'])."添加了商品".$data['title'];

				$re=$this->system->logsModel->insert($user); */
				ajaxReturn('back', '操作成功', 1);exit;
			} else {
				ajaxReturn('back', '操作失败', 0);exit;
			}

		}
	}
	/*
	 * 删除权限组
	 */
	public function shopdel() {
		$this->leftpos = 3;
		$this->loadModel('product', 'goods');
		$this->loadHelper('extend');
		if ($_GET) {
			$id = $_GET['id'];
			$re = $this->product->goodsModel->delete('id=' . $id);
			if ($re) {
				ajaxReturn('back', '删除成功', 1);exit;

			}
		}
		include $this->loadWidget('amdinlteTheme');
	}

	/**
	 *修改商品状态
	 **/
	public function check_goods() {
		$id = $_POST['id'];
		$data = $_POST['data'];
		$this->loadModel('product', 'goods');
		//print_r($_POST);exit;
		$line = $this->product->goodsModel->update($data, 'id=' . $id);
		$this->loadHelper('extend');
		if ($line) {
			ajaxReturn('back', '修改成功', 1);
		} else {
			ajaxReturn('back', '修改失败', 0);
		}
	}

	/*
	/*
	 * 商品品牌
	 */

	public function brand() {
		$this->leftpos = 1;
		$this->loadModel('product', 'brand');
		$sql = "select * from product_brand order by id desc";
		$re = $this->product->brandModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/*
	 * 添加商品品牌
	 */
	public function addbrand() {
		$this->leftpos = 1;
		$this->loadModel('product', 'brand');

		include $this->loadWidget('amdinlteTheme');
	}
	/*
	 * 插入商品品牌
	 */
	public function insertbrand() {
		$this->leftpos = 1;
		$this->loadModel('product', 'brand');
		if ($_POST) {
			$this->loadHelper('extend');
			$data = $_POST['data'];
			$data['created'] = time();
			if (!empty($_FILES['imagefile']['name'])) {
				$this->loadHelper('uploader');
				$uploader = new uploader();
				$data['icon'] = $uploader->start('imagefile');
			}
			$line = $this->product->brandModel->insert($data);
			if ($line) {
				ajaxReturn('back', '操作成功', 1);
			} else {
				ajaxReturn('back', '操作失败', 0);
			}

		}

	}

	/***
	 *
	 *编辑商品品牌
	 *
	 ***/
	public function editbrand() {
		$this->leftpos = 1;
		$this->loadModel('product', 'brand');
		$id = $_GET['id'];
		$sql = "select * from product_brand where id=$id";
		$re = $this->product->brandModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');

	}
	/****
	 *
	 *修改品牌
	 *
	 *****/
	public function updatebrand() {
		$this->loadModel('product', 'brand');
		$this->loadHelper('extend');
		if ($_POST) {
			$id = $_POST['id'];
			$data = $_POST['data'];
			if (!empty($_FILES['imagefile']['name'])) {
				$this->loadHelper('uploader');
				$uploader = new uploader();
				$data['icon'] = $uploader->start('imagefile');
			}
			$line = $this->product->brandModel->update($data, 'id=' . $id);
			if ($line) {
				ajaxReturn('back', '操作成功', 1);
			} else {
				ajaxReturn('back', '操作失败', 0);
			}
		}
	}
	/****
	 *
	 *删除品牌
	 *
	 *****/
	public function delbrand() {
		$this->loadModel('product', 'brand');
		$this->loadHelper('extend');
		if ($_GET) {
			$id = $_GET['id'];

			$line = $this->product->brandModel->delete('id=' . $id);
			if ($line) {
				ajaxReturn('back', '操作成功', 1);
			} else {
				ajaxReturn('back', '操作失败', 0);
			}

		}

	}
	/*
	 * 商品分类
	 */
	public function category() {

		$this->leftpos = 0;
		$this->loadHelper('arrayHelper');
		$this->loadHelper('extend');
		$this->loadModel('product', 'goodscategory');

		$sql = "select * from product_goodscategory   order by sort";
		$re = $this->product->goodscategoryModel->fetchAll($sql);
		//print_r($re);
		$result = toTreeone($re, 'id', 'parentuuid', 'childs');
		//拖动排序

		if ($_POST) {
			$orderby = $_POST;
			foreach ($orderby['orderby'] as $k => $v) {
				$r = $this->product->goodscategoryModel->update("sort='" . $k . "'", "id='" . $v . "'");
			}
		}
		include $this->loadWidget('amdinlteTheme');
	}

	//显示添加文章分类页面
	public function categoryadd() {
		$this->loadHelper('arrayHelper');
		$this->loadHelper('extend');
		$this->loadModel('product', 'goodscategory');

		$id = $_GET['id'];

		$action = '';
		$data['action'] = '';

		$data['id'] = $id;
		$html = $this->loadAjaxView('goods/category_edit', $data);

		ajaxReturn($html, '', 1);

	}
	//添加文章分类
	public function categoryinsert() {
		$this->loadHelper('extend');
		$this->loadModel('product', 'goodscategory');
		$cookieid = $this->info['id'];

		$data = $_POST['data'];
		$data['uuid'] = 'uuid()';
		if (isset($data['title']) && empty($data['title'])) {
			ajaxReturn('', '名称不能为空', 0);exit;
		}
		$data['parentuuid'] = $_POST['categoryid'];
		if ($data['parentuuid'] == 'root') {
			$data['parentuuid'] = 0;
		}

		$line = $this->product->goodscategoryModel->insert($data);
		if ($line) {
			ajaxReturn('', '添加成功', 1);
		} else {
			ajaxReturn('', '添加失败', 0);

		}
	}
	//编辑分类页面
	public function categoryedit() {

		$this->loadHelper('arrayHelper');
		$this->loadHelper('extend');
		$this->loadModel('product', 'goodscategory');

		$id = $_GET['id'];
		$sql = "select * from product_goodscategory where id=" . $id;
		$info = $this->product->goodscategoryModel->fetchRow($sql);
		$action = 'edit';
		$data['info'] = $info;
		$data['action'] = $action;
		$data['id'] = $id;
		$html = $this->loadAjaxView('goods/category_edit', $data);
		ajaxReturn($html, '', 1);

	}
	//编辑分类
	public function categoryupdate() {
		$this->loadHelper('extend');
		$this->loadModel('product', 'goodscategory');
		$data = $_POST['data'];
		if (isset($data['title']) && empty($data['title'])) {
			ajaxReturn('', '名称不能为空', 0);exit;
		}
		//$data['id']   =   $_POST['categoryid'];
		if (!empty($_FILES['imagefile']['name'])) {
			$this->loadHelper('uploader');
			$uploader = new uploader();
			$data['icon'] = $uploader->start('imagefile');
			$file = ROOT;
			$file = $file . $data['icon'];
			//压缩图片
			$compress_image = compress_image($file);
			//缩略图片

			$thumbimage = make_thumb($file, 50, 50);
		}
		$line = $this->product->goodscategoryModel->update($data, 'id=' . $_POST['categoryid']);
		if ($line) {
			ajaxReturn('', '修改成功', 1);
		} else {
			ajaxReturn('', '修改失败', 0);
		}

	}
	//删除分类
	public function categorydelete() {
		$this->loadHelper('extend');
		$this->loadModel('product', 'goodscategory');
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		if ($id != 'root') {
			$line = $this->product->goodscategoryModel->delete("id=" . $id);
			if ($line) {
				ajaxReturn('', '删除成功', 1);
			} else {
				ajaxReturn('', '删除失败', 0);
			}
		} else {
			ajaxReturn('', '该节点不能删除', 1);
		}
	}

	//采购申请
	public function apply() {
		$this->loadModel('product', 'order');
		$sql = "select * from product_order order by id desc ";
		$result = $this->product->orderModel->fetchAll($sql);
		$pageHtml = "";
		include $this->loadWidget('amdinlteTheme');

	}
	//添加采购申请
	public function addapply() {

		include $this->loadWidget('amdinlteTheme');
	}
	//插入采购申请
	public function insertapply() {
		$this->loadModel('product', 'order');
		if ($_POST) {
			$this->loadHelper('extend');
			//$this->loadHelper('image');
			$data = $_POST['data'];

			$data['uuid'] = 'uuid()';

			$re = $this->product->orderModel->insert($data);

			if ($re) {
				//日志
				/*  $user['userid']=$this->info['id'];
				$user['username']=$this->info['username'];
				$user['created']=time();
				$user['type']=0;
				$user['level']=1;
				$user['intro']=$user['username']."于".date("Y-m-d H:i:s",$user['created'])."添加了商品".$data['title'];

				$re=$this->system->logsModel->insert($user); */
				ajaxReturn('back', '添加成功', 1);exit;
			} else {
				ajaxReturn('back', '添加失败', 0);exit;
			}

		}

	}
	//编辑采购申请t
	public function editapply() {
		$this->loadModel('product', 'order');
		$id = $_GET['id'];
		$sql = "select * from product_order where id=$id";
		$result = $this->product->orderModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//修改采购申请
	public function updateapply() {
		$this->loadModel('product', 'order');
		if ($_POST) {
			$this->loadHelper('extend');
			//$this->loadHelper('image');
			$data = $_POST['data'];
			$id = $_POST['id'];
			$where = "id=$id ";

			$re = $this->product->orderModel->updae($data, $where);

			if ($re) {
				//日志
				/*  $user['userid']=$this->info['id'];
				$user['username']=$this->info['username'];
				$user['created']=time();
				$user['type']=0;
				$user['level']=1;
				$user['intro']=$user['username']."于".date("Y-m-d H:i:s",$user['created'])."添加了商品".$data['title'];

				$re=$this->system->logsModel->insert($user); */
				ajaxReturn('back', '修改成功', 1);exit;
			} else {
				ajaxReturn('back', '修改失败', 0);exit;
			}

		}

	}
	//删除采购申请
	public function delapply() {
		$this->loadModel('product', 'order');
		$this->loadHelper('extend');

		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		if ($id != '0') {
			$line = $this->product->orderModel->delete("id=" . $id);
			if ($line) {
				ajaxReturn('', '删除成功', 1);
			} else {
				ajaxReturn('', '删除失败', 0);
			}
		}

	}
	//商品生产日期列表
	public function timelist() {
		$this->leftpos = 2;
		$this->loadModel('product', 'productontime');
		$this->loadModel('product', 'goods');
		$goodsuuid = $_GET['uuid'];
		$sql = "select title from product_goods where uuid='" . $goodsuuid . "'";
		$goods = $this->product->goodsModel->fetchRow($sql);
		$sql = "select * from product_productontime where goodsuuid='" . $goodsuuid . "'";
		$re = $this->product->productontimeModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//添加生产日期表
	public function addtime() {
		$this->leftpos = 2;
		$this->loadModel('product', 'productontime');
		$goodsuuid = $_GET['goodsuuid'];
		$this->loadModel('product', 'goods');
		$goodsuuid = $_GET['goodsuuid'];
		$sql = "select title from product_goods where uuid='" . $goodsuuid . "'";
		$goods = $this->product->goodsModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//插入生产日期
	public function inserttime() {
		$this->loadModel('product', 'productontime');
		$this->loadHelper("extend");
		if ($_POST) {
			$this->loadHelper('extend');
			//$this->loadHelper('image');
			$data = $_POST['data'];
			$data['productontime'] = strtotime($_POST['data']['productontime']);
			$data['goodsuuid'] = $_POST['goodsuuid'];

			$re = $this->product->productontimeModel->insert($data);
			if ($re) {
				ajaxReturn('back', '添加成功', 1);exit;
			} else {
				ajaxReturn('back', '添加失败', 0);exit;
			}

		}

	}
	//编辑生产日期
	public function edittime() {
		$this->leftpos = 2;
		$this->loadModel('product', 'productontime');
		$id = $_GET['id'];
		$sql = "select pp.*,pg.title from product_productontime as pp left join product_goods as pg on pp.goodsuuid=pg.uuid where pp.id=$id";
		$re = $this->product->productontimeModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//修改生产日期
	public function updatetime() {
		$this->leftpos = 2;
		$this->loadModel('product', 'productontime');
		$this->loadHelper("extend");
		if ($_POST) {
			$this->loadHelper('extend');
			//$this->loadHelper('image');
			$data = $_POST['data'];
			$data['productontime'] = strtotime($_POST['data']['productontime']);
			$id = $_POST['id'];
			$re = $this->product->productontimeModel->update($data, "id=$id");
			if ($re) {
				ajaxReturn('back', '修改成功', 1);exit;
			} else {
				ajaxReturn('back', '修改失败', 0);exit;
			}

		}

	}
	/****
	 *
	 *删除日期
	 *
	 *****/
	public function deltime() {
		$this->loadModel('product', 'productontime');
		$this->loadHelper('extend');
		if ($_GET) {
			$id = $_GET['id'];

			$line = $this->product->productontimeModel->delete('id=' . $id);
			if ($line) {
				ajaxReturn('back', '操作成功', 1);
			} else {
				ajaxReturn('back', '操作失败', 0);
			}

		}

	}

}