<?php
/*
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */
class goods extends actionAbstract {

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
		// $this->info = acl::checkLogin('admininfo',$this->url('common/login'));
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

	public function updateGoodsImg(){
		//图片文件夹路径
		$dir = "./data/images";
		$saveDir = substr($dir,1);

		//定义变量-数组
		$imgsfordatabase = array();
		$imgsfordir = array();

		//数据库图片
		$this->loadModel('shop','goodsimg');
		$imgs = $this->shop->goodsimgModel->fetchAll("select thumburl from shop_goodsimg");
	    foreach ($imgs as $i) {
	    	$thumburls = preg_split("/\//", $i['thumburl']);
			array_push($imgsfordatabase,$thumburls[sizeof($thumburls)-1]);
	    }

		//文件夹图片
	    if(is_dir($dir)){
	        if ($dh = opendir($dir)){
	            while (($file = readdir($dh)) !== false){
	                if((is_dir($dir."/".$file)) && $file!="." && $file!=".."){
	                    // 子文件夹操作
	                    // listDir($dir."/".$file."/");
	                }else{
	                    if($file!="." && $file!=".."){
	                        array_push($imgsfordir,$file);
	                    }
	                }
	            }
	            closedir($dh);
	        }
	    }

	    echo json_encode($imgsfordir);
	    exit;

	    //图片重复处理-数据库已存在的图片不再添加
	    foreach ($imgsfordir as $ifd) {
	    	if(!in_array($ifd, $imgsfordatabase)){
	    		$saveFiled = $saveDir."/".$ifd;
	    		//去掉后缀名
	    		$goodsid = substr($ifd,0,-4);
	    		$this->shop->goodsimgModel->sqlexec("insert into shop_goodsimg(goodsid,thumburl,created) values(".$goodsid.",'".$saveFiled."',".time().")");
	    	}
	    }
	    // echo "更新成功，2秒后跳转";
	    // header("Refresh:2;url=index.php/iManage/index/index");
	}

	/*
	 *  POS端商品数据同步
	 */
	public function posspsync() {
		$this->loadModel('product', 'goods');
		$this->loadModel('franchisee', 'product');
		$this->loadModel('franchisee', 'alliance');
		$sql = "delete from shop_goodsinfo";
		// $line=$this->shop->goodscategoryModel->test($sql);
		$resud = $this->franchisee->allianceModel->fetchAll("select * from franchisee_alliance ");
		foreach ($resud as $val) {
			$sql = "insert into franchisee_product(`uuid`, `barcode`, `title`, `imgpath`,`categoryuuid`, `branduuid`, `pingyincode`, `supplier`, `shelflife`, `costprice`, `price`, `number`, `maxnumber`, `minnumber`, `status`, `isdiscount`, `remark`) select  `uuid`, `barcode`, `title`, `imgpath`, `categoryuuid`, `branduuid`, `pingyincode`, `supplier`, `shelflife`, `franchiseeprice`, `price`, `number`, `maxnumber`, `minnumber`, `status`, `isdiscount`, `remark` from product_goods where uuid not in (select uuid from franchisee_product where token='" . $val['token'] . "') ";
			$re = $this->franchisee->allianceModel->sqlexec($sql);
			if ($re) {
				$data['token'] = $val['token'];
				$this->franchisee->productModel->update($data, "token is null");
			}
		}

		$data = array('state' => 0, 'info' => '');
		if ($re) {
			$data['state'] = 1;
			$data['info'] = '更新成功';
		} else {
			$data['state'] = 1;
			$data['info'] = '更新成功';
		}
		exit(json_encode($data));
	}
	/*
	 *  EC商品数据同步
	 */
	public function ecsync() {
		$this->loadModel('product', 'goods');
		$this->loadModel('shop', 'goodsinfo');
		set_time_limit(0);
		$sql	=	"select * from product_goods where uuid not in(select uuid from shop_goodsinfo)";	  
		 
		$re		=	$this->shop->goodsinfoModel->fetchAll($sql);
		
		$insertsql	=	"insert into shop_goodsinfo(`uuid`, `barcode`, `title`, `imgpath`, `branduuid`, `pingyincode`, `supplier`, `shelflife`, `costprice`, `price`, `franchiseeprice`, `number`, `maxnumber`, `minnumber`, `status`, `isdiscount`, `remark`) values";
		foreach($re as $k=>$val){
			if($k==0){
			$insertsql.="('".$val['uuid']."','".$val['barcode']."','".addslashes($val['title'])."','".$val['imgpath']."','".$val['branduuid']."','".$val['pingyincode']."','".$val['supplier']."','".$val['shelflife']."','".$val['costprice']."','".$val['price']."','".$val['franchiseeprice']."','".$val['number']."','".$val['maxnumber']."','".$val['minnumber']."','".$val['status']."','".$val['isdiscount']."','".$val['remark']."')";
			}else{
			$insertsql.=",('".$val['uuid']."','".$val['barcode']."','".addslashes($val['title'])."','".$val['imgpath']."','".$val['branduuid']."','".$val['pingyincode']."','".$val['supplier']."','".$val['shelflife']."','".$val['costprice']."','".$val['price']."','".$val['franchiseeprice']."','".$val['number']."','".$val['maxnumber']."','".$val['minnumber']."','".$val['status']."','".$val['isdiscount']."','".$val['remark']."')";
			}
		
		}
		$resul=false;
		if(isset($k)&&$k>0){
		//echo $insertsql;exit;
		$resul = $this->shop->goodsinfoModel->sqlexec($insertsql);
		}
		$data = array('state' => 0, 'info' => '');
		if ($resul) {
			$data['state'] = 1;
			$data['info'] = '更新成功';
		} else {
			$data['state'] = 1;
			$data['info'] = '更新成功';
		}
		exit(json_encode($data));
	}
	/*
	 *  POS分类数据同步
	 */
	public function posdync() {
		$this->loadModel('product', 'goodscategory');
		$this->loadModel('franchisee', 'category');
		$sql = "delete from franchisee_category";
		// $line=$this->shop->goodscategoryModel->test($sql);
		$this->franchisee->categoryModel->delete('tag=0');

		$sql = "insert into franchisee_category(`title`, `parentuuid`, `sort`, `remark`,`uuid`) select  `title`, `parentuuid`, `sort`, `remark`, `uuid` from product_goodscategory where uuid not in (select uuid from franchisee_product where uuid='" . $val['uuid'] . "') ";
		$resuld = $this->franchisee->categoryModel->sqlexec($sql);
		$data = array('state' => 0, 'info' => '');
		if ($resuld) {
			$data['state'] = 1;
			$data['info'] = '更新成功';
		} else {
			$data['state'] = 1;
			$data['info'] = '更新成功';
		}
		exit(json_encode($data));
	}

	/*
	 *  EC分类数据同步
	 */
	public function possync() {
		$this->loadModel('product', 'goodscategory');
		$this->loadModel('shop', 'goodscategory');
		$sql = "delete from shop_goodscategory";
		// $line=$this->shop->goodscategoryModel->test($sql);
		$this->shop->goodscategoryModel->delete('tag=0');
		$sql = "insert into shop_goodscategory(`title`, `parentuuid`, `sort`, `remark`,`uuid`) select  `title`, `parentuuid`, `sort`, `remark`, `uuid` from product_goodscategory where uuid not in (select uuid from franchisee_product ) ";
		//$sql="insert into shop_goodscategory(`title`, `parentuuid`, `sort`, `remark`,`uuid`) select  `title`, `parentuuid`, `sort`, `remark`, `uuid` from product_goodscategory where uuid not in (select uuid from franchisee_product where uuid='".$val['uuid']."') ";
		$result = $this->shop->goodscategoryModel->sqlexec($sql);
		$data = array('state' => 0, 'info' => '');
		if ($result) {
			$data['state'] = 1;
			$data['info'] = '更新成功';
		} else {
			$data['state'] = 2;
			$data['info'] = '更新失败';
		}
		exit(json_encode($data));
	}
	/*
	 * 商品管理
	 */
	public function lists() {
		$this->leftpos = 2;

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
			$this->where .= " and product_goods.categoryuuid = '" . $_GET['categoryuuid'] . "'";
		}
		if (isset($_GET['branduuid']) && $_GET['branduuid'] !== "") {
			$this->where .= " and product_goods.branduuid = '" . $_GET['branduuid'] . "'";
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
		//echo $sql;exit;
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
		$str = "<option value=\$uuid >\$spacer\$title</option>";
		$str = "<option value=\$uuid \$selected>\$spacer\$title</option>";
		$trees = $tree->get_tree(0, $str);
		//品牌
		$sql = "select * from product_brand order by sort asc ";
		$brand = $this->product->goodscategoryModel->fetchAll($sql);
		//查看客户类型
		$sql = "select * from crm_usertype ";
		$supplytype = $this->product->goodscategoryModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/***
	 *
	 *插入商品
	 *
	 ****/
	public function insertshop() {
		$this->loadModel('product', 'goods');
		$this->loadHelper('log');
		$cookieid = $this->info['id'];
		if ($_POST) {
			$this->loadHelper('extend');
			//$this->loadHelper('image');
			$data = $_POST['data'];
			if (!empty($_FILES['imagefile']['name'])) {
				$this->loadHelper('uploader');
				$uploader = new uploader();
				$data['imgpath'] = $uploader->start('imagefile');
			}
			//$data['remark']=$_POST['remark'];
			$data['uuid'] = 'uuid()';
			// print_r($data);exit;
			$re = $this->product->goodsModel->insert($data);

			if ($re) {
				//加盟商价格
				$l = 0;
				
				//日志
				$logdata['title'] = '添加';
				$logdata['userid'] = $cookieid;
				$logdata['content'] = '添加商品信息';
				$log = new log();
				$line=$log->logwrite($logdata);
				if (!$line) {
					$this->product->goodsModel->delete("id=" . $re);
					ajaxReturn('', '添加失败', 0);exit;
				}
				ajaxReturn('back', '添加成功', 1);exit;
			} else {
				ajaxReturn('', '添加失败', 0);exit;
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
			if (!empty($_FILES['imagefile']['name'])) {
				$this->loadHelper('uploader');
				$uploader = new uploader();
				$data['imgpath'] = $uploader->start('imagefile');

			}
			// $data['remark']=$_POST['remark'];
			//$data['beoverdue'] = intval($data['beoverdue']);
			$re = $this->product->goodsModel->update($data, $id);
			//加盟商价格
			$l = 0;
			/* if (isset($_POST['supplytypeid'])) {
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
			} */

			if ($re || $l) {
				$logdata['title'] = '修改';
				$logdata['userid'] = $cookieid;
				$logdata['content'] = '修改商品信息';
				$log = new log();
				$log->logwrite($logdata);
				ajaxReturn('', '操作成功', 1);exit;
			} else {
				ajaxReturn('back', '操作失败', 0);exit;
			}

		}
	}

	public function modifySupply() {
		$this->loadModel('product', 'goods');
		$this->loadModel('product', 'productontime');
		$goods = $this->product->goodsModel->select('*');
		foreach ($goods as $good) {
			$data['goodsuuid'] = $good['uuid'];
			$data['productontime'] = 1434684900;
			$data['num'] = 20000;
			$this->product->productontimeModel->insert($data);
		}
	}

	/*
	 * 删除商品 若状态为上架则无法删除
	 */
	public function shopdel() {
		$this->leftpos = 3;
		$this->loadHelper('log');
		$cookieid = $this->info['id'];
		$this->loadModel('product', 'goods');
		$this->loadHelper('extend');
		if ($_GET) {
			$id = $_GET['id'];
			$sql = "select * from product_goods where id=" . $id;
			$result = $this->product->goodsModel->fetchRow($sql);

			//商品为上架状态
			if ($result['status'] == 1) {
				ajaxReturn('', '删除失败,上架中商品无法删除', 0);exit;

			} else {
				//商品为下架状态
				$cond['is_del'] = 1;
				$r = $this->product->goodsModel->update($cond, $id);
				//  var_dump($r);
				if ($r) {
					ajaxReturn('', '删除成功', 1);exit;
				} else {
					ajaxReturn('', '删除失败', 0);exit;
				}

			} /*else{
		$re=$this->product->goodsModel->delete('id='.$id);
		if($re){
		$logdata['title']   = '删除';
		$logdata['userid']  = $cookieid;
		$logdata['content'] = '删除商品信息';
		$log = new log();
		$log->logwrite($logdata);
		ajaxReturn ('back', '删除成功', 1 );exit;
		}
		}*/

		}
		include $this->loadWidget('amdinlteTheme');
	}

	/*
	 * 已删除商品列表
	 * */
	public function del_lists() {
		$this->leftpos = 2;

		$this->loadModel('product', 'goods');

		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$userphone = null;

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
			$this->where .= " and product_goods.categoryuuid = '" . $_GET['categoryuuid'] . "'";
		}
		if (isset($_GET['branduuid']) && $_GET['branduuid'] !== "") {
			$this->where .= " and product_goods.brandid = " . $_GET['branduuid'] . "";
		}
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = isset($_GET['pagenum']) ? $_GET['pagenum'] : 10;
		$offset = ($page - 1) * $size;
		$sql = "select count(*) from product_goods  where is_del=1 " . $this->where;
		$count = $this->product->goodsModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select product_goods.*,fc.title as fctitle from product_goods left join product_goodscategory as fc on fc.uuid=product_goods.categoryuuid  where product_goods.is_del=1  " . $this->where . "  limit " . $offset . "," . $size . "";

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

	/*
	 *回收站恢复数据,设置is_del值为0
	 * */

	public function editisdel() {
		$id = $_GET['id'];
		$this->loadModel('product', 'goods');
		$this->loadHelper('extend');
		$cond['is_del'] = 0;
		$result = $this->product->goodsModel->update($cond, $id);
		if ($result) {
			ajaxReturn('', '恢复成功', 1);exit;
		} else {
			ajaxReturn('', '恢复失败', 0);exit;
		}
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
			ajaxReturn('', '修改成功', 1);
		} else {
			ajaxReturn('', '修改失败', 0);
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
			$data['uuid'] = 'uuid()';
			$data['created'] = time();

			if (!empty($_FILES['imagefile']['name'])) {
				$this->loadHelper('uploader');
				$uploader = new uploader();
				$data['icon'] = $uploader->start('imagefile');
			}
			$line = $this->product->brandModel->insert($data);
			if ($line) {
				$this->brandToPos();
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
				$this->brandToPos();
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
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
			//查看该分类下有没有商品
			$sql = "select uuid from product_brand where id=" . $id;
			$cate = $this->product->brandModel->fetchRow($sql);
			$sql = "select * from product_goods where branduuid='" . $cate['uuid'] . "'";
			$re = $this->product->brandModel->fetchRow($sql);
			if ($re) {
				ajaxReturn('', '删除失败,该品牌下有商品', 0);
			}
			$line = $this->product->brandModel->delete('id=' . $id);
			if ($line) {

				$this->brandToPos();
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
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
		header('Content-Type:text/html; charset=utf-8');
		ajaxReturn($html, '', 1);

	}
	//添加文章分类
	public function categoryinsert() {
		$this->loadHelper('log');
		$this->loadHelper('extend');
		$this->loadModel('product', 'goodscategory');
		header('Content-Type:text/html; charset=utf-8');
		$cookieid = $this->info['id'];
		$data = $_POST['data'];
		$data['uuid'] = 'uuid()';
		if (isset($data['title']) && empty($data['title'])) {
			ajaxReturn('', '名称不能为空', 0);exit;
		}
		$data['parentuuid'] = $_POST['categoryuuid'];
		if ($data['parentuuid'] == 'root') {
			$data['parentuuid'] = 0;
		}

		$line = $this->product->goodscategoryModel->insert($data);
		if ($line) {
			$logdata['title'] = '添加';
			$logdata['userid'] = $cookieid;
			$logdata['content'] = '添加商品分类信息';
			$log = new log();
			$log->logwrite($logdata);
			$this->categoryToPos();
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

		$this->loadHelper('log');
		$this->loadHelper('extend');
		$this->loadModel('product', 'goodscategory');
		$data = $_POST['data'];
		$cookieid = $this->info['id'];
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
		$line = $this->product->goodscategoryModel->update($data, 'id=' . $_POST['categoryuuid']);
		if ($line) {

			$logdata['title'] = '修改';
			$logdata['userid'] = $cookieid;
			$logdata['content'] = '修改商品分类信息';
			$log = new log();
			$log->logwrite($logdata);
			ajaxReturn('', '修改成功', 1);
		} else {
			ajaxReturn('', '修改失败', 0);
		}

	}
	//删除分类
	public function categorydelete() {
		$this->loadHelper('extend');
		$this->loadHelper('log');
		$cookieid = $this->info['id'];
		$this->loadModel('product', 'goodscategory');
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		if ($id != 'root') {
			//查看该分类下有没有商品
			$sql = "select uuid from product_goodscategory where id=" . $id;
			$cate = $this->product->goodscategoryModel->fetchRow($sql);
			$sql = "select * from product_goods where categoryuuid='" . $cate['uuid'] . "'";
			$re = $this->product->goodscategoryModel->fetchRow($sql);
			if ($re) {
				ajaxReturn('', '删除失败,该分类下有商品', 0);
			}
			$line = $this->product->goodscategoryModel->delete("id=" . $id);
			if ($line) {

				$logdata['title'] = '删除';
				$logdata['userid'] = $cookieid;
				$logdata['content'] = '删除商品分类信息';
				$log = new log();
				$log->logwrite($logdata);
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

			$data['remark'] = $_POST['remark'];
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
				ajaxReturn('', '修改成功', 1);exit;
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
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}

		}

	}

	//商品库存库位列表
	public function goodsstorelist() {
		$this->leftpos = 2;
		$this->loadModel('product', 'relation');
		$this->loadModel('product', 'goods');
		$goodsid = $_GET['goodsid'];
		$sql = "select pr.id,pr.num,ph.title as houssename,phs.title as phsname from product_relation as pr left join product_house as ph on ph.id=pr.houseid left join product_housepos as phs on pr.houseposid=phs.id  where pr.goodsid=" . $goodsid . "";

		$re = $this->product->relationModel->fetchAll($sql);

		$sql = "select title from product_goods where id=" . $goodsid . "";
		$goods = $this->product->goodsModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//添加商品库存库位表
	public function addgoodsstore() {
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
				ajaxReturn('', '添加成功', 1);exit;
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
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败,只能删除库存为0的记录', 0);
			}
		}
	}
	//导入商品html
	public function goodsin() {
		$this->loadModel('product', 'goods');
		$this->loadModel('product', 'brand');
		if (isset($_FILES['excel']) && $_FILES['excel']['name'] != '') {
			set_time_limit(0);
			//print_r($_POST);
			if (empty($_POST['uuid'])) {
			//	echo "未选择商品分类";exit;
			}
			
			$this->loadHelper("uploader");
			$uploader = new uploader('file');
			$filepath = $uploader->start('excel');
			
			include ROOT_PATH . "public/excel/reader.php";
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('utf-8'); //编码  $_SERVER['DOCUMENT_ROOT'].$filepath
			//$path = $_SERVER['DOCUMENT_ROOT'].'\data\file\2013\03_08\2013030853654100.xls';
			$path = $_SERVER['DOCUMENT_ROOT'] . $filepath;
			
			$data->read($path); //文件
			
			//得到所有品牌
			$sql = "select uuid,title from product_brand ";
			$brands = $this->product->brandModel->fetchAll($sql);

			$brand = array();
			foreach ($brands as $val) {
				$brand[$val['title']] = $val['uuid'];
			}
			//加盟商类型
			$this->loadModel('crm', 'usertype');
			$sql = "select id from crm_usertype order by id asc limit 0,4";
			$crm = $this->crm->usertypeModel->fetchAll($sql);
			
			//error_reporting(E_ALL ^ E_NOTICE);
			for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
				$datas = array();
				
				//var_dump($data->sheets[0]['cells'][27]);exit;
				$brandtitle = @trim($data->sheets[0]['cells'][$i][1]);
				if (empty($data->sheets[0]['cells'][$i])) {
				
				continue;}else{
				
				}
				if (!isset($brand[$brandtitle])) {
					//var_dump($data->sheets[0]['cells'][$i]);exit;
					echo "<span style='color:red;'>请将该文件在品牌管理处先导入品牌</span>";exit;
				}

				$barcode = @$data->sheets[0]['cells'][$i][10];
				$erpcode = @$data->sheets[0]['cells'][$i][3];
				if(empty($erpcode)){
					echo $i.".<span style='color:red;'>行编码不能为空</span><br>";continue;
				}
				if(empty($barcode)){
					//自动生成条码
					$barcode	=	$this->getbarcodegoodsin();
					//	echo $i.".<span style='color:red;'>行条码不能为11空[".$barcode."]</span><br>";continue;
					
				}
				if(empty($barcode)){
						echo $i.".<span style='color:red;'>行条码不能为空</span><br>";continue;
					}
				//$where = " barcode = '" . trim($barcode) . "'";
				$where = " erpcode = '" . trim($erpcode) . "'";
				//echo $email;exit;
					$goodsrow = $this->product->goodsModel->fetchRow("select id from product_goods where " . $where);
					
					$datas['branduuid'] = $brand[$brandtitle];
					$datas['status'] = 1;
					if(!empty($_POST['uuid'])){
					$datas['categoryuuid'] = $_POST['uuid'];
					}
					$datas['erpcode'] = @$data->sheets[0]['cells'][$i][3];
					
					$datas['title'] = @$data->sheets[0]['cells'][$i][4];
					//$datas['title'] =$datas['title'];
					$datas['title_en'] = @$data->sheets[0]['cells'][$i][5];
					$datas['pingyincode'] = @$data->sheets[0]['cells'][$i][6];
					$datas['explain'] = @$data->sheets[0]['cells'][$i][8];
					$datas['goodsurl'] = @$data->sheets[0]['cells'][$i][9];
					$datas['barcode'] = $barcode;
					$datas['shelflife'] = empty($data->sheets[0]['cells'][$i][11]) ? "0" : $data->sheets[0]['cells'][$i][11] - 0;
					$datas['percent'] = @$data->sheets[0]['cells'][$i][12];
					$datas['boxnum'] = empty($data->sheets[0]['cells'][$i][13]) ? "0" : $data->sheets[0]['cells'][$i][13];
					$datas['weight'] = empty($data->sheets[0]['cells'][$i][14]) ? "0" : $data->sheets[0]['cells'][$i][14];
					$datas['specs'] = @$data->sheets[0]['cells'][$i][15];
					$datas['price'] = empty($data->sheets[0]['cells'][$i][19]) ? "0" : $data->sheets[0]['cells'][$i][19] - 0;
					$datas['suggestprice'] = empty($data->sheets[0]['cells'][$i][20]) ? "0" : $data->sheets[0]['cells'][$i][20] - 0;
					$datas['address'] = @$data->sheets[0]['cells'][$i][21];
					$datas['remark'] = @$data->sheets[0]['cells'][$i][22];
					$datas['numberone'] = empty($data->sheets[0]['cells'][$i][23]) ? "0" : $data->sheets[0]['cells'][$i][23];
					$datas['beoverdue'] = empty($data->sheets[0]['cells'][$i][24]) ? "0" : $data->sheets[0]['cells'][$i][24];
					$datas['futureprice'] = empty($data->sheets[0]['cells'][$i][25]) ? "0" : $data->sheets[0]['cells'][$i][25];
					$pricetitle	=	array();
					$pricesql	=	array();
					
				if (!$goodsrow) {
//添加
					$datas['uuid'] = 'uuid()';

					$datas['status'] = 1;

					$line = $this->product->goodsModel->insert($datas);
					
					if ($line) {
						//加盟商价格 crm_usertype 19
						
						
						if (isset($crm) && count($crm) >= 4) {
							$insertsql = "insert into product_allianceprice(supplytypeid,goodsid,price)values";
							$price = empty($data->sheets[0]['cells'][$i][16]) ? "0" : $data->sheets[0]['cells'][$i][16];
							//$price	=	round($price);
							$price	=	$price-0;
							$insertsql .= "(" . $crm[0]['id'] . "," . $line . "," . $price . ")";
							$price = empty($data->sheets[0]['cells'][$i][17]) ? "0" : $data->sheets[0]['cells'][$i][17];
							$price	=	$price-0;
							$insertsql .= ",(" . $crm[1]['id'] . "," . $line . "," . $price . ")";
							$price = empty($data->sheets[0]['cells'][$i][18]) ? "0" : $data->sheets[0]['cells'][$i][18];
							$price	=	$price-0;
							$insertsql .= ",(" . $crm[2]['id'] . "," . $line . "," . $price . ")";
							$price = empty($data->sheets[0]['cells'][$i][18]) ? "0" : $data->sheets[0]['cells'][$i][19];
							$price	=	$price-0;
							$insertsql .= ",(" . $crm[3]['id'] . "," . $line . "," . $price . ")";
							$this->loadModel('product', 'allianceprice');
							//$this->product->alliancepriceModel->delete("goodsid=" . $line);
							echo $i."=>".$insertsql."<br>";
							$l = $this->product->alliancepriceModel->sqlexec($insertsql);
							if(!$l){
								$pricetitle[]=$datas['title'];
								$pricesql[]	=	$insertsql;
							}
						}else{
							echo $i.".<span style='color:red;'>行价格有误</span><br>";
						}
					}else{
						echo $i.".<span style='color:red;'>".$datas['title']."未导入</span><hr>";
					}
					//var_dump($line);exit; product_productontime
				} else {
			

					$line = $this->product->goodsModel->update($datas, "id=".$goodsrow['id']);
					$line	=	true;
					if ($line) {
						//加盟商价格 crm_usertype
						if (isset($crm) && count($crm) >= 4) {
							$insertsql = "insert into product_allianceprice(supplytypeid,goodsid,price)values";
							$price = empty($data->sheets[0]['cells'][$i][16]) ? "0" : $data->sheets[0]['cells'][$i][16];
							$price	=	$price-0;
							$insertsql .= "(" . $crm[0]['id'] . "," . $goodsrow['id'] . "," . $price . ")";
							$price = empty($data->sheets[0]['cells'][$i][17]) ? "0" : $data->sheets[0]['cells'][$i][17];
							$price	=	$price-0;
							$insertsql .= ",(" . $crm[1]['id'] . "," . $goodsrow['id'] . "," . $price . ")";
							$price = empty($data->sheets[0]['cells'][$i][18]) ? "0" : $data->sheets[0]['cells'][$i][18];
							$price	=	$price-0;
							$insertsql .= ",(" . $crm[2]['id'] . "," . $goodsrow['id'] . "," . $price . ")";
							$price = empty($data->sheets[0]['cells'][$i][18]) ? "0" : $data->sheets[0]['cells'][$i][19];
							$price	=	$price-0;
							$insertsql .= ",(" . $crm[3]['id'] . "," . $goodsrow['id'] . "," . $price . ")";

							$this->loadModel('product', 'allianceprice');
							
							$this->product->alliancepriceModel->delete("goodsid=" . $goodsrow['id']);
							$l = $this->product->alliancepriceModel->sqlexec($insertsql);
							if(!$l){
								$pricetitle[]=$datas['title'];
								$pricesql[]	=	$insertsql;
							}
							
						}

					}
					echo $i.".".$datas['title']."修改商品信息<hr>";
				}
				
			}
			set_time_limit(30);
			echo "添加完成<hr>";
			echo "价格未导入商品：";
			print_r($pricetitle);
			echo "<hr>价格未导入SQL：";
			print_r($pricesql);
			exit;

		}
		//得到分类
		$this->loadModel('product', 'goodscategory');
		$sql = "select title,uuid from product_goodscategory ";
		$category = $this->product->goodscategoryModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//导入商品保质期至
	public function goodsintime(){
		$this->loadModel('product', 'goods');
		$this->loadModel('product', 'productontime');
		if (isset($_FILES['excel']) && $_FILES['excel']['name'] != '') {
			set_time_limit(0);
			$this->loadHelper("uploader");
			$uploader = new uploader('file');
			$filepath = $uploader->start('excel');
			
			include ROOT_PATH . "public/excel/reader.php";
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('utf-8'); //编码  $_SERVER['DOCUMENT_ROOT'].$filepath
			//$path = $_SERVER['DOCUMENT_ROOT'].'\data\file\2013\03_08\2013030853654100.xls';
			$path = $_SERVER['DOCUMENT_ROOT'] . $filepath;

			$data->read($path); //文件
			$array		=	array();//没有该商品的
			$noupdate	=	array();//导入失败的
			for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
				$erpcode = @trim($data->sheets[0]['cells'][$i][1]);
				$productontime = @trim($data->sheets[0]['cells'][$i][2]);
				/* print_r($data->sheets[0]['cells'][$i]);
				echo $productontime."<br>";exit; */
				$productontime	=	trim($productontime);
				$num = @trim($data->sheets[0]['cells'][$i][3])-0;
				$sql	=	"select uuid,id,number from product_goods where erpcode='".$erpcode."'";
				$r		=	$this->product->goodsModel->fetchRow($sql);
				if(!$r){
					$array[]	=	$erpcode;
					continue;
				}
				//查看该商品有没有保质期至
				//无保质期商品
				$this->product->goodsModel->update(array("number"=>$num+$r['number']),"id=".$r['id']);
				if(empty($productontime)){
					
					continue;
				}
				
				$productontime	=	strtotime($productontime);
				
				$sql	=	"select * from product_productontime where goodsuuid='".$r['uuid']."' and productontime='".$productontime."'";
				$re		=	$this->product->goodsModel->fetchRow($sql);
				//if($re && $re['num']!=$num){
				if($re){
					//修改
					$line	=	$this->product->productontimeModel->update(array('num'=>$num+$re['num']),'id='.$re['id']);
					if(!$line){
					$noupdate[]	=	$erpcode;
					}
					continue;
				}
				if(!$re){
					$da['goodsuuid']		=	$r['uuid'];
					$da['productontime']	=	$productontime;
					$da['num']	=	$num;
					
					$line=$this->product->productontimeModel->insert($da);
					if(!$line){
					$noupdate[]	=	$erpcode;
					}
					continue;
				}
				
			}
			
		}
	
	echo "导入成功";
	}

	//导入品牌
	public function brandin() {
		$this->loadModel('product', 'goods');
		$this->loadModel('product', 'brand');
		$str = '';
		if (isset($_FILES['excel']) && $_FILES['excel']['name'] != '') {
			set_time_limit(0);
			$this->loadHelper("uploader");
			$uploader = new uploader('file');
			$filepath = $uploader->start('excel');

			include ROOT_PATH . "public/excel/reader.php";
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('utf-8'); //编码  $_SERVER['DOCUMENT_ROOT'].$filepath
			//$path = $_SERVER['DOCUMENT_ROOT'].'\data\file\2013\03_08\2013030853654100.xls';
			$path = $_SERVER['DOCUMENT_ROOT'] . $filepath;

			$data->read($path); //文件
			//print_r($_FILES);exit;
			error_reporting(E_ALL ^ E_NOTICE);
			for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
				$datas = array();
				//var_dump($data->sheets[0]['cells'][$i]);exit;
			
				$title = $data->sheets[0]['cells'][$i][1];
				$where = " title = '" . trim($title) . "'";
				if (empty($title)) {continue;}
				//echo $email;exit;
				$count = $this->product->brandModel->selectCnt($where, 'id');
				if ($count == 0) {
//添加
					$datas['uuid'] = "uuid()";
					$datas['title'] = trim($title);
					$datas['created'] = time();
					$datas['title_en'] = trim($data->sheets[0]['cells'][$i][2]);

					$line = $this->product->brandModel->insert($datas);
					if(!$line){
					echo $i."行".$datas['title']."未导入成功<br/>";
					}
					/* print_r($datas);
				var_dump($line);exit; */
				}
			}
			set_time_limit(30);
			$str = "添加完成";

		}
		//得到分类
		$this->loadModel('product', 'goodscategory');
		$sql = "select title,uuid from product_goodscategory ";
		$category = $this->product->goodscategoryModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//品牌修改时通知加盟商进行修改或添加 financial_synctype
	public function brandToPos() {

		$this->loadModel('financial', 'synctype');
		$sql = "select token from franchisee_alliance ";
		$re = $this->financial->synctypeModel->fetchAll($sql);
		if (!$re) {return true;}
		$where = " keytype='brand' ";
		$this->financial->synctypeModel->delete($where);
		$sql = "insert into financial_synctype(token,keytype) values";
		foreach ($re as $k => $val) {
			if ($k == 0) {
				$sql .= "('" . $val['token'] . "','brand')";
			} else {
				$sql .= ",('" . $val['token'] . "','brand')";
			}

		}
		$this->financial->synctypeModel->execSql($sql);
	}
	//商品分类修改时通知加盟商进行修改或添加 financial_synctype
	public function categoryToPos() {

		$this->loadModel('financial', 'synctype');
		$sql = "select token from franchisee_alliance ";
		$re = $this->financial->synctypeModel->fetchAll($sql);
		if (!$re) {return true;}
		$where = " keytype='goodscategory' ";
		$this->financial->synctypeModel->delete($where);
		$sql = "insert into financial_synctype(token,keytype) values";
		foreach ($re as $k => $val) {
			if ($k == 0) {
				$sql .= "('" . $val['token'] . "','goodscategory')";
			} else {
				$sql .= ",('" . $val['token'] . "','goodscategory')";
			}

		}
		$this->financial->synctypeModel->execSql($sql);
	}
	//批量移商品类别
	public function changeshopcategory() {
		$this->loadModel('product', 'goods');

		if ($_POST) {
			$this->loadHelper('extend');
			//$this->loadHelper('image');
			//$data	=	$_POST['data'];

			if (empty($_POST['categoryuuid2']) || empty($_POST['categoryuuid2'])) {
				ajaxReturn('', '未选择导入商品分类', 0);exit;
			}
			if (!isset($_POST['goodsid'])) {
				ajaxReturn('', '未选择商品', 0);exit;
			}
			$goodsid = implode(",", $_POST['goodsid']);

			$data['categoryuuid'] = $_POST['categoryuuid2'];
			$re = $this->product->goodsModel->update($data, "id in($goodsid)");
			if ($re) {
				ajaxReturn('', '修改成功', 1);exit;
			} else {
				ajaxReturn('', '修改失败', 0);exit;
			}

		}
		//得到分类
		$this->loadModel('product', 'goodscategory');
		$sql = "select title,uuid from product_goodscategory ";
		$category = $this->product->goodscategoryModel->fetchAll($sql);

		$this->loadModel('product', 'goods');
		$this->where = '';
		$re = array();
		$sid = '';
		if (isset($_GET['categoryuuid']) && $_GET['categoryuuid'] !== "") {
			$sid = $_GET['categoryuuid'];
			$this->where .= " and product_goods.categoryuuid = '" . $_GET['categoryuuid'] . "'";
		}
		$sql = "select product_goods.*,fc.title as fctitle from product_goods left join product_goodscategory as fc on fc.uuid=product_goods.categoryuuid  where is_del=0  " . $this->where . " ";

		if (!empty($this->where)) {
			$re = $this->product->goodsModel->fetchAll($sql);
		}

		include $this->loadWidget('amdinlteTheme');
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
	public function getbarcodegoodsin(){
		
		$data['barcode']="400".rand(100000000,999999999);
		$barcode	=	$this->EAN13($data['barcode']);
		//查看该条码是否存在
		$sql	=	"select id from product_goods where barcode='".$barcode."'";
		$this->loadModel('product', 'goods');
		$goods = $this->product->goodsModel->fetchRow($sql);
		if($goods){
			$data['barcode']="400".rand(100000000,999999999);
			$barcode	=	$this->EAN13($data['barcode']);
		}
		$sql	=	"select id from product_goods where barcode='".$barcode."'";
		$this->loadModel('product', 'goods');
		$goods = $this->product->goodsModel->fetchRow($sql);
		if($goods){
			$barcode	=	'';
		}
		return $barcode;
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
	//批量更改到期时间对应的库存 product_productontime product_allianceprice
	public function changegoodstime() {
		set_time_limit(0);
		$this->loadModel('product', 'goods');
		$this->loadModel('product', 'allianceprice');
		$this->loadModel('product', 'productontime');
		$sql = "select id,uuid from product_goods where is_del=0 and status=0";
		$sql = "select id,uuid from product_goods where is_del=0 ";
		$goods = $this->product->goodsModel->fetchAll($sql);
		//
		$sql = "select * from crm_usertype ";
		$usertype = $this->product->goodsModel->fetchAll($sql);
		foreach ($goods as $k => $val) {
			$data = array();
			$data['goodsuuid'] = $val['uuid'];
			$data['productontime'] = 1449417600;
			$data['num'] = 2000;
			//$this->product->productontimeModel->insert($data);
			foreach ($usertype as $v) {
				$d = array();
				$d['supplytypeid'] = $v['id'];
				$d['goodsid'] = $val['id'];
				$d['price'] = 100;
				$this->product->alliancepriceModel->insert($d);
			}
			//修改
			$nd['number'] = 2000;
			$nd['futureprice'] = 10;
			$nd['status'] = 1;
			$nd['shelflife'] = 0;
			$this->product->goodsModel->update($nd, 'id=' . $val['id']);
		}
		echo "完成";
	}
	public function test() {
		$this->loadModel('franchisee', 'alliance');
		$mobile = '13000000000';
		$password = '123456';
		$sql = "select * from franchisee_alliance where username='" . $mobile . "' and password='" . md5($password) . "'";
		$re1 = $this->franchisee->allianceModel->fetchRow($sql);
		$this->loadModel('financial', 'synctype');
		$sql = "select distinct keytype from financial_synctype where token='" . $re1['token'] . "' order by id desc";

		$re2 = $this->financial->synctypeModel->fetchAll($sql);
		$sql = "select * from franchisee_order where ordernum='15071410424117c95a'";
		$re3 = $this->financial->synctypeModel->fetchAll($sql);
		echo "<pre>";
		print_r($re1);
		print_r($re2);
		print_r($re3);
	}

}