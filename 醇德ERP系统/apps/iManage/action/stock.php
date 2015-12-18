<?php
/*
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */
class stock extends actionAbstract {

	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 4;
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
		//$this->info = acl::checkLogin('admininfo',$this->url('common/login'));
		if (!isset($_SESSION['admininfo'])) {header('location:' . $this->url('common/login'));}$this->info = $_SESSION['admininfo'];
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		//$this->loadHelper('handleimage');
		// print_r($this->info);
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			//ajax request
			$this->checkpower();
		}

	}
	//当前库存管理
	public function goodslists() {
		$this->leftpos = 2;
		$this->pos = 8;

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
			$this->where .= " and (product_goods.title like  '%" . $_GET['userphone'] . "%' or product_goods.barcode like '%" . $_GET['userphone'] . "%' or product_goods.erpcode like '%" . $_GET['userphone'] . "%')";

			$userphone = $_GET['userphone'];
		}
		$sid = '';
		if (isset($_GET['categoryuuid']) && $_GET['categoryuuid'] !== "") {
			$sid = $_GET['categoryuuid'];
			$this->where .= " and product_goods.categoryuuid = '" . $_GET['categoryuuid'] . "'";
		}
		if (isset($_GET['branduuid']) && $_GET['branduuid'] !== "") {
			$this->where .= " and product_goods.brandid = " . $_GET['branduuid'] . "";
		}
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = isset($_GET['pagenum']) ? $_GET['pagenum'] : 10;
		$offset = ($page - 1) * $size;
		$sql = "select count(*) from product_goods  where 1=1 " . $this->where;
		$count = $this->product->goodsModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select product_goods.*,fc.title as fctitle from product_goods left join product_goodscategory as fc on fc.uuid=product_goods.categoryuuid  where is_del=0  " . $this->where . "  limit " . $offset . "," . $size . "";

		//var_dump($sql); exit;

		$re = $this->product->goodsModel->fetchAll($sql);
		
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

	//商品生产日期列表
	public function timelist() {
		$this->leftpos = 2;
		$this->loadModel('product', 'productontime');
		$this->loadModel('product', 'goods');
		$goodsuuid = $_GET['uuid'];
		//删除库存为0的商品
		$this->product->productontimeModel->delete("num=0");
		$sql = "select title from product_goods where uuid='" . $goodsuuid . "'";
		$goods = $this->product->goodsModel->fetchRow($sql);
		$sql = "select * from product_productontime where goodsuuid='" . $goodsuuid . "'";
		$re = $this->product->productontimeModel->fetchAll($sql);
		//print_r($re);exit;
		include $this->loadWidget('amdinlteTheme');
	}

	//商品库存库位列表
	public function goodsstorelist() {
		$this->leftpos = 2;
		$goodsid	=	$_GET['goodsid'];
	
		$this->loadModel('product', 'relation');
		$this->loadModel('product', 'goods');
	
		//通过erpcode得到商品id
		$sql	=	"select id,title from product_goods where id='".$goodsid."'";
		$re		=		$this->product->goodsModel->fetchRow($sql);
		//$re['id']	=	1;
		if(!$re){die("该商品不存在");}
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
	public function addgoodsstore(){
		$this->loadHelper('extend');
		$this->loadModel('product', 'relation');
		$this->loadModel('product', 'goods');
		$houseid	=	$_POST['houseid'];
		$goodsid	=	$_POST['goodsid'];
		//$ordernum	=	$_POST['ordernum'];
		$posid	=	isset($_POST['posid'])?$_POST['posid']:'';
		if(empty($posid)){
			ajaxReturn('', '未选择库位', 0);exit;
		}
		$this->product->relationModel->delete(" goodsid=".$goodsid);
		//添加
		$insertsql	=	"insert into product_relation (goodsid,houseid,houseposid,ordernum) values";
		foreach($posid as $k=>$houseposid){
			if($k==0){
				$insertsql.="(".$goodsid.",".$houseid.",".$houseposid.",'0')";
			}else{
				$insertsql.=",(".$goodsid.",".$houseid.",".$houseposid.",'0')";
			}
		}
		$line	=	$this->product->relationModel->sqlexec($insertsql);
		if($line){
		ajaxReturn('', '操作成功', 1);exit;
		}else{
		ajaxReturn('', '操作失败', 0);exit;
		}
	}
	//添加商品库存库位表
	public function addgoodsstoreold() {
		$this->leftpos = 2;
		$goodsid = $_GET['goodsid'];
		$this->loadModel('product', 'goods');
		$sql = "select title from product_goods where id=" . $goodsid . "";
		$goods = $this->product->goodsModel->fetchRow($sql);
		//查看库房
		$this->loadModel('product', 'house');
		$sql = "select * from product_house ";
		$house = $this->product->houseModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//	//得到库位
	public function getHousePos() {
		$houseid = $_POST['houseid'];
		$this->loadModel('product', 'housepos');
		$this->loadHelper('extend');
		$sql = "select * from product_housepos where houseid=$houseid";
		$re = $this->product->houseposModel->fetchAll($sql);
		$html = "<option value='0'>选择库位</option>";
		foreach ($re as $val) {

			$html .= "<option value='" . $val['id'] . "' >" . $val['title'] . "</option>";
		}
		$data['html'] = $html;
		echo json_encode($data);

	}
	//插入商品库存库位
	public function insertgoodsstore() {
		$this->loadModel('product', 'relation');
		$this->loadModel('product', 'goods');
		$this->loadHelper("extend");
		if ($_POST) {
			$this->loadHelper('extend');
			//$this->loadHelper('image');
			$data = $_POST['data'];
			if (empty($data['houseid']) || empty($data['houseposid'])) {
				ajaxReturn('', '未选择库位', 0);exit;
			}

			$data['goodsid'] = $_POST['goodsid'];
			$sql = "select id from product_relation  where goodsid=" . $data['goodsid'] . " and houseid=" . $data['houseid'] . " and houseposid=" . $data['houseposid'] . "";

			$r = $this->product->relationModel->fetchRow($sql);
			if ($r) {
				ajaxReturn('', '该库房库位已存在', 0);exit;
			}
			$re = $this->product->relationModel->insert($data);
			if ($re) {
				ajaxReturn('back', '添加成功', 1);exit;
			} else {
				ajaxReturn('back', '添加失败', 0);exit;
			}

		}

	}

	/****
	 *
	 *删除商品库存库位
	 *
	 *****/
	public function delgoodsstore() {
		$this->loadModel('product', 'relation');
		$this->loadHelper('extend');
		if ($_GET) {
			$id = $_GET['id'];
			$line = $this->product->relationModel->delete('id=' . $id . " and num<=0");
			if ($line) {
				ajaxReturn('back', '操作成功', 1);
			} else {
				ajaxReturn('back', '操作失败,只能删除库存为0的记录', 0);
			}
		}
	}
	//出库记录
	public function outstocklog() {
		$this->loadModel('product', 'relation');
		$this->loadModel('product', 'goods');
		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = isset($_GET['pagenum']) ? $_GET['pagenum'] : 10;
		$offset = ($page - 1) * $size;
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
		$sql1 = '';
		if (!empty($keyword)) {
			$where = "  product_goods.title like '%" . $keyword . "%' or product_goods.barcode like '%" . $keyword . "%' ";
			$sql1 = " and goodsid in (select id from product_goods where $where) ";
		}
		$sql = "select count(*) from franchisee_orderinfo  where 1=1 $sql1 and ordernum in(select ordernum from franchisee_order where status=5)";
		$count = $this->product->goodsModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select product_goods.*,franchisee_orderinfo.ordernum,franchisee_orderinfo.num,franchisee_orderinfo.boxnum as oldboxnum from franchisee_orderinfo left join product_goods on product_goods.id=franchisee_orderinfo.goodsid  where 1=1 $sql1  and ordernum in(select ordernum from franchisee_order where status=5)  limit " . $offset . "," . $size . "";
		//echo $sql;exit;

		$re = $this->product->goodsModel->fetchAll($sql);
		foreach ($re as $k => $val) {
			$sql = "select created from franchisee_order where ordernum='" . $val['ordernum'] . "'";
			$r = $this->product->goodsModel->fetchRow($sql);
			$re[$k]['createtime'] = $r['created'];
		}
		include $this->loadWidget('amdinlteTheme');
	}
	//采购入库记录
	public function caigoustock() {
		$this->loadModel('product', 'apply');
		$this->loadModel('product', 'applycartstore');
		$this->loadModel('product', 'applycart');
		$this->loadModel('product', 'goods');
		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = isset($_GET['pagenum']) ? $_GET['pagenum'] : 10;
		$offset = ($page - 1) * $size;
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
		$where = ' and  product_applycartstore.planid in(select id from product_applystoreplan where status=4) ';
		if (!empty($keyword)) {
			$where = " and product_applycart.title like '%" . $keyword . "%' or product_applycartstore.barcode like '%" . $keyword . "%' or product_applycartstore.ordernum like '%" . $keyword . "%'";

		}
		$sql = "select count(*) from product_applycartstore left join product_applycart on product_applycart.id=product_applycartstore.cartid   where 1=1 $where ";
		$count = $this->product->goodsModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select product_applycartstore.*,product_applycart.title,product_applycart.applyid from product_applycartstore left join product_applycart on product_applycart.id=product_applycartstore.cartid  where 1=1 $where  limit " . $offset . "," . $size . "";
		//echo $sql;exit;

		$re = $this->product->goodsModel->fetchAll($sql);
		foreach ($re as $k => $val) {
			$sql = "select ordernum,created from product_apply where id=" . $val['applyid'] . "";
			$r = $this->product->goodsModel->fetchRow($sql);
			$re[$k]['createtime'] = $r['created'];
			$re[$k]['ordernum'] = $r['ordernum'];
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
		//查看客户类型
		$sql = "select * from crm_usertype ";
		$supplytype = $this->product->goodscategoryModel->fetchAll($sql);
		foreach ($supplytype as $k => $val) {
			$sql = "select * from product_allianceprice where goodsid=" . $id . " and supplytypeid=" . $val['id'];
			$r = $this->product->goodscategoryModel->fetchRow($sql);
			if ($r) {
				$supplytype[$k]['price'] = $r['price'];
				$supplytype[$k]['aid'] = $r['id'];
			} else {
				$supplytype[$k]['price'] = '';
				$supplytype[$k]['aid'] = '0';
			}
		}
		include $this->loadWidget('amdinlteTheme');
	}

	/***
	 *
	 *修改商品
	 *
	 ****/
	public function updateshop() {

		$this->loadModel('product', 'goods');
		$this->loadHelper('log');
		$cookieid = $this->info['id'];
		if ($_POST) {
			$this->loadHelper('extend');
			//$this->loadHelper('image');
			$data = $_POST['data'];
			$id = $_POST['id'];
			
			
			$re = $this->product->goodsModel->update($data, $id);
			//加盟商价格
			$l = 0;
			if (isset($_POST['supplytypeid'])) {
				$insertsql = "insert into product_allianceprice(supplytypeid,goodsid,price)values";
				foreach ($_POST['supplytypeid'] as $k => $v) {
					if ($k == 0) {
						$insertsql .= "(" . $v . "," . $id . "," . $_POST['supplyprice'][$k] . ")";
					} else {
						$insertsql .= ",(" . $v . "," . $id . "," . $_POST['supplyprice'][$k] . ")";
					}
				}
				$this->loadModel('product', 'allianceprice');
				$this->product->alliancepriceModel->delete("goodsid=" . $id);
				$l = $this->product->alliancepriceModel->sqlexec($insertsql);
			}

			if ($re || $l) {
				$logdata['title'] = '修改';
				$logdata['userid'] = $cookieid;
				$logdata['content'] = '修改商品价格信息';
				$log = new log();
				$log->logwrite($logdata);
				ajaxReturn('back', '操作成功', 1);exit;
			} else {
				ajaxReturn('back', '操作失败', 0);exit;
			}

		}
	}
}