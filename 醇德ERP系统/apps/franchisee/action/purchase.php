<?php

/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */

class purchase extends actionAbstract {
	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 0;
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
		$this->info = acl::checkLogin('accessinfo', $this->url('common/login'));
		// if(!isset($_SESSION['accessinfo'])){ header('location:'.$this->url('common/login'));}
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		$this->conf = $this->loadConfig('sysconf');
	}
	//操作说明
	public function remark(){
	$this->pos = 2;
	include $this->loadWidget('franchiseelteTheme');
	}
	//得到所有分类
	public function apply() {
		$sql = "select * from product_allianceprice ";
		$this->loadModel('product', 'goods');
		/* $this->loadModel('product', 'allianceprice');
		$re		=	$this->product->goodsModel->fetchAll($sql);

		$vkey	=	array();
		$vkeys	=	array();
		foreach($re as $k=>$val){
		if(isset($vkey[$val['supplytypeid']."_".$val['goodsid']])){
		$vkeys[]	=	$val['id'];continue;
		}
		$vkey[$val['supplytypeid']."_".$val['goodsid']]	=	$val['id'];
		}
		$strid	=	implode(",",$vkeys);
		$this->product->alliancepriceModel->delete("id in($strid)");

		exit; */

		set_time_limit(0);
		$this->loadModel('product', 'goods');

		$this->loadHelper('extend');
		//$this->loadHelper( "pager" );
		$userphone = null;
		//$this->product->goodsModel->update(array('shelflife'=>0),"id>0");
		$this->where .= " and product_goods.status=1 ";
		$categoryuuid = '';
		$branduuid = '';
		$userphone = '';
		if (!empty($_GET['userphone'])) {
			$this->where .= " and (product_goods.title like  '%" . $_GET['userphone'] . "%' or product_goods.barcode like '%" . $_GET['userphone'] . "%')";

			$userphone = $_GET['userphone'];
		}
		$sid = '';
		if (isset($_GET['categoryuuid']) && $_GET['categoryuuid'] !== "") {
			$sid = $categoryuuid = $_GET['categoryuuid'];

			$this->where .= " and product_goods.categoryuuid = '" . $_GET['categoryuuid'] . "'";
		}
		if (isset($_GET['branduuid']) && $_GET['branduuid'] !== "") {
			$branduuid = $_GET['branduuid'];
			$this->where .= " and product_goods.branduuid = '" . $_GET['branduuid'] . "'";
		}
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = 10;
		$offset = ($page - 1) * $size;
		$sql = "select count(*) from product_goods where 1=1 " . $this->where;
		$count = $this->product->goodsModel->fetchRow($sql);
		//print_r($count);exit;
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		//$extend = new pager();
		//$pageHtml = $extend->outputadmin( $number, $page, "", "", $count, $size );
		// product_productontime  $x+保质期>time+临期- weight
		/* $time	=	time();
		$sql="select product_goods.weight,product_goods.specs,product_goods.boxnum,product_goods.specs,product_goods.title,product_goods.futureprice,product_goods.id,product_goods.uuid,product_goods.imgpath,product_goods.barcode,product_goods.pingyincode,product_goods.franchiseeprice,product_goods.shelflife,product_goods.number,product_goods.beoverdue,fc.title as fctitle,pb.title as brandtitle,(select price from product_allianceprice where goodsid=product_goods.id and supplytypeid=".$this->info['supplytypeid'].") as paprice from product_goods left join product_goodscategory as fc on fc.uuid=product_goods.categoryuuid  left join product_brand as pb on pb.uuid=product_goods.branduuid  where 1=1  ".$this->where."  limit ".$offset.",".$size."";

		//echo $sql;exit;
		$re=$this->product->goodsModel->fetchAll($sql);
		foreach($re as $k=>$val){
		$timenum	=	array();//存放是临期价与正常价
		$i=0;
		if(empty($val['shelflife'])){
		//说明没有临期价--读主表的信息
		if(empty($val['shelflife'])){

		$timenum[$i]['number']=$val['number'];
		$timenum[$i]['price']=$val['paprice'];
		$timenum[$i]['tag']=1;//正常1,临期价0
		$timenum[$i]['productontimeid']=0;//正常,没有时间表则为0
		$timenum[$i]['productontime']=0;//正常
		$re[$k]['timenum']	=$timenum;continue;
		}
		}
		$time	=	time();//过期时间境界线  productontime>$time  没过期的
		$time1	=	time()+$val['beoverdue']*24*3600;//临期时间境界线  productontime>$time  正常价，小于临期价
		$sql	=	"select productontime,num,id from product_productontime where goodsuuid='".$val['uuid']."' and productontime>".$time." and productontime<".$time1." order by  productontime asc ";//临期价格---快过期了
		//echo $sql."<hr/>";
		$r		=	$this->product->goodsModel->fetchAll($sql);


		if($r){
		$num	=	0;
		foreach($r as $kr=>$v){
		if($kr==0){
		$timenum[$i]['productontime']=$v['productontime'];
		$timenum[$i]['productontimeid']=$v['id'];

		}
		$num+=$v['num'];
		}
		$timenum[$i]['number']=$num;
		$timenum[$i]['price']=$val['futureprice'];
		$timenum[$i]['tag']=0;//临期
		$i++;
		}
		$sql	=	"select productontime,num,id from product_productontime where goodsuuid='".$val['uuid']."'  and productontime>".$time1." order by  productontime asc ";//正常价格

		$r		=	$this->product->goodsModel->fetchAll($sql);
		if($r){
		$num	=	0;
		foreach($r as $kr=>$v){
		if($kr==0){
		$timenum[$i]['productontime']=$v['productontime'];
		$timenum[$i]['productontimeid']=$v['id'];

		}
		$num+=$v['num'];
		}
		$timenum[$i]['number']=$num;
		$timenum[$i]['price']=$val['paprice'];
		$timenum[$i]['tag']=1;//正常
		}
		$re[$k]['timenum']	=$timenum;
		}
		 */
		//品牌和名称
		$this->loadModel('product', 'goodscategory');
		$this->loadHelper("Treeuuid");
		$sql = "select * from product_goodscategory where parentuuid=0";
		$category = $this->product->goodscategoryModel->fetchAll($sql);

		$tree = new Treeuuid($category);
		$str = "<option value=\$uuid >\$spacer\$title</option>";
		$str = "<option value=\$uuid \$selected>\$spacer\$title</option>";
		$trees = $tree->get_tree(0, $str, $sid);
		//品牌
		$sql = "select uuid,id,title from product_brand order by sort asc ";
		$brand = $this->product->goodscategoryModel->fetchAll($sql);

		/* echo "<pre>";
		print_r($re);exit; */
		//var_dump($re);exit;

		// include $this->loadWidget('homecashTheme');
		include $this->loadWidget('franchiseelteTheme');
	}

	public function ajaxApply() {
		set_time_limit(0);

		$this->loadModel('product', 'goods');
		$this->loadHelper('extend');
		//$this->loadHelper( "pager" );
		$userphone = null;
		$this->where .= " and product_goods.status=1 ";
		$categoryuuid = '';
		if (!empty($_GET['userphone'])) {
			$this->where .= " and (product_goods.title like  '%" . $_GET['userphone'] . "%' or product_goods.barcode like '%" . $_GET['userphone'] . "%')";

			$userphone = $_GET['userphone'];
		}
		$sid = '';
		if (isset($_GET['categoryuuid']) && $_GET['categoryuuid'] != "") {
			$sid = $categoryuuid = $_GET['categoryuuid'];
			
			$this->where .= " and product_goods.categoryuuid = '" . $_GET['categoryuuid'] . "'";
		}
		if (isset($_GET['branduuid']) && $_GET['branduuid'] != "") {
			$this->where .= " and product_goods.branduuid = '" . $_GET['branduuid'] . "'";
		}
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = 10;
		$offset = ($page - 1) * $size;
		$sql = "select count(*) from product_goods  where 1=1 " . $this->where;
		$count = $this->product->goodsModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);

		//$extend = new pager(); suggestprice
		//$pageHtml = $extend->outputadmin( $number, $page, "", "", $count, $size );
		// product_productontime  $x+保质期>time+临期- weight
		$time = time();
		$sql = "select product_goods.weight,product_goods.specs,product_goods.boxnum,product_goods.specs,product_goods.title,product_goods.futureprice,product_goods.id,product_goods.uuid,product_goods.imgpath,product_goods.barcode,product_goods.pingyincode,product_goods.franchiseeprice,product_goods.shelflife,product_goods.number,product_goods.beoverdue,fc.title as fctitle,pb.title as brandtitle,(select price from product_allianceprice where goodsid=product_goods.id and supplytypeid=" . $this->info['supplytypeid'] . ") as paprice from product_goods left join product_goodscategory as fc on fc.uuid=product_goods.categoryuuid  left join product_brand as pb on pb.uuid=product_goods.branduuid  where 1=1  " . $this->where . "  limit " . $offset . "," . $size . "";
		
		//echo $sql;exit;
		$re = $this->product->goodsModel->fetchAll($sql);

		foreach ($re as $k => $val) {
			$timenum = array(); //存放是临期价与正常价
			$i = 0;
			if (empty($val['shelflife'])) {
				//说明没有临期价--读主表的信息
				if (empty($val['shelflife'])) {

					$timenum[$i]['number'] = $val['number'];
					$timenum[$i]['price'] = $val['paprice'];
					$timenum[$i]['tag'] = 1; //正常1,临期价0
					$timenum[$i]['productontimeid'] = 0; //正常,没有时间表则为0
					$timenum[$i]['productontime'] = 0; //正常
					$re[$k]['timenum'] = $timenum;
					continue;
				}
			}
			$time = time(); //过期时间境界线  productontime>$time  没过期的
			$time1 = time() + $val['beoverdue'] * 24 * 3600; //临期时间境界线  productontime>$time  正常价，小于临期价
			$sql = "select productontime,num,id from product_productontime where goodsuuid='" . $val['uuid'] . "' and productontime>" . $time . " and productontime<" . $time1 . " order by  productontime asc "; //临期价格---快过期了
			//echo $sql."<hr/>";
			$r = $this->product->goodsModel->fetchAll($sql);

			if ($r) {
				$num = 0;
				foreach ($r as $kr => $v) {
					if ($kr == 0) {
						$timenum[$i]['productontime'] = $v['productontime'];
						$timenum[$i]['productontimeid'] = $v['id'];

					}
					$num += $v['num'];
				}
				$timenum[$i]['number'] = $num;
				$timenum[$i]['price'] = $val['futureprice'];
				$timenum[$i]['tag'] = 0; //临期
				$i++;
			}

			$sql = "select productontime,num,id from product_productontime where goodsuuid='" . $val['uuid'] . "'  and productontime>" . $time1 . " order by  productontime asc "; //正常价格

			$r = $this->product->goodsModel->fetchAll($sql);
			if ($r) {
				$num = 0;
				foreach ($r as $kr => $v) {
					if ($kr == 0) {
						$timenum[$i]['productontime'] = $v['productontime'];
						$timenum[$i]['productontimeid'] = $v['id'];

					}
					$num += $v['num'];
				}
				$timenum[$i]['number'] = $num;
				$timenum[$i]['price'] = $val['paprice'];
				$timenum[$i]['tag'] = 1; //正常
			}
			$re[$k]['timenum'] = $timenum;

		}

		//品牌和名称
		/* $this->loadModel('product','goodscategory');
		$this->loadHelper("Treeuuid");
		$sql	=	"select * from product_goodscategory where parentuuid=0";
		$category	=	$this->product->goodscategoryModel->fetchAll($sql);

		$tree	=	new Treeuuid($category);
		$str	=	"<option value=\$uuid >\$spacer\$title</option>";
		$str	=	"<option value=\$uuid \$selected>\$spacer\$title</option>";
		$trees	=	$tree->get_tree(0,$str,$sid);
		//品牌
		$sql	=	"select id,title from product_brand order by sort asc ";
		$brand	=	$this->product->goodscategoryModel->fetchAll($sql); */
		include $this->loadView('');
	}

	//加入购物车
	public function addcart() {
		set_time_limit(0);
		$this->loadModel('franchisee', 'ordercart');
		$this->loadModel('franchisee', 'productontime');
		$this->loadHelper("extend");
		if ($_POST) {

			$token = $this->info['token'];
			if (!isset($_POST['goodsid'])) {
				ajaxReturn('', '请选择采购商品', 0);
			}
			$tag = 0;
			//print_r($_POST);exit;
			foreach ($_POST['goodsid'] as $k => $v) {
				if (!isset($_POST['goodsnum_' . $v . '_' . $_POST['tag'][$k]])) {continue;}
				$data = array();
				$data['goodsid'] = $v;
				$data['token'] = $token;
				$data['tag'] = $_POST['tag'][$k];
				$data['num'] = intval($_POST['goodsnum_' . $v . '_' . $_POST['tag'][$k]]);

				if (empty($data['num'])) {continue;}
				$boxnum = $_POST['boxnum_' . $v];
				if ($data['num'] > $_POST['hasnum'][$k]) {
					//ajaxReturn('0', '购买商品数量不能大于库存', 0);
				}

				$tag = 1;

				//查看之前有没有添加该购物车
				$sql = 'select * from franchisee_ordercart where  goodsid=' . $v . ' and token="' . $token . '" and tag=' . $data['tag'];
				$r = $this->franchisee->ordercartModel->fetchRow($sql);
				//print_r($r);exit;
				if ($r) {
					$odata['num'] = $_POST['goodsnum_' . $v . '_' . $_POST['tag'][$k]] - 0 + $r['num'];
					$this->franchisee->ordercartModel->update($odata, 'goodsid=' . $v . ' and token="' . $token . '" and tag=' . $data['tag']);
				} else {
					$this->franchisee->ordercartModel->insert($data);
				}

			}

			if ($tag) {
				$nd['state'] = 1;
				$nd['data'] = 'delnum';
				$nd['className'] = 'buynum';
				$nd['btClassName'] = 'btncart';
				$nd['btstr'] = '<i class="icon-ambulance"></i>&nbsp;&nbsp;加入购物车';
				$nd['info'] = '操作成功';
				echo json_encode($nd);exit;
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '未填写购买商品数量', 0);
			}
		}

	}
	//查看已选中的商品--购物车中的商品
	public function cartlist() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'ordercart');
		$this->loadModel('product', 'goods');
		$sql = "select pg.beoverdue,pg.weight,pg.boxnum,pg.title,pg.specs,pg.id,pg.uuid,pg.imgpath,pg.barcode,pg.pingyincode,pg.futureprice,pg.shelflife,pg.number,fo.tag,fo.num,fo.id as cartid ,(select price from product_allianceprice where goodsid=pg.id and supplytypeid=" . $this->info['supplytypeid'] . " ) as paprice from franchisee_ordercart as fo left join  product_goods as pg on fo.goodsid=pg.id  where token='" . $this->info['token'] . "'";

		$re = $this->franchisee->ordercartModel->fetchAll($sql);
		
		foreach ($re as $k => $val) {
			//$timenum	=	array();//存放是临期价与正常价
			$re[$k]['number'] = $val['number'];
			$re[$k]['price'] = $val['paprice'];
			$re[$k]['tag'] = 1; //正常1,临期价0
			$re[$k]['productontimeid'] = 0; //正常,没有时间表则为0
			$re[$k]['productontime'] = 0; //
			$i = 0;
			if (empty($val['shelflife'])) {
				//说明没有临期价--读主表的信息
				if (empty($val['shelflife'])) {
					continue;
				}
			}
			$time = time(); //过期时间境界线  productontime>$time  没过期的
			$time1 = time() + $val['beoverdue'] * 24 * 3600; //临期时间境界线  productontime>$time  正常价，小于临期价

			//临期价
			if ($val['tag'] == 0) {
				$sql = "select productontime,num,id from product_productontime where goodsuuid='" . $val['uuid'] . "' and productontime>" . $time . " and productontime<" . $time1 . " order by  productontime asc "; //临期价格---快过期了

				$r = $this->product->goodsModel->fetchAll($sql);

				if ($r) {
					$num = 0;
					foreach ($r as $kr => $v) {
						if ($kr == 0) {
							$re[$k]['productontime'] = $v['productontime'];
							$re[$k]['productontimeid'] = $v['id'];

						}
						$num += $v['num'];
					}
					$re[$k]['number'] = $num;
					$re[$k]['price'] = $val['futureprice'];
					$re[$k]['tag'] = 0; //临期
					$i++;
				}
				//$re[$k]['timenum']	=$timenum;
				continue;
			}
			$sql = "select productontime,num,id from product_productontime where goodsuuid='" . $val['uuid'] . "'  and productontime>" . $time1 . " order by  productontime asc "; //正常价格
			$r = $this->product->goodsModel->fetchAll($sql);
			if ($r) {
				$num = 0;
				foreach ($r as $kr => $v) {
					if ($kr == 0) {
						$re[$k]['productontime'] = $v['productontime'];
						$re[$k]['productontimeid'] = $v['id'];

					}
					$num += $v['num'];
				}
				$re[$k]['number'] = $num;
				$re[$k]['price'] = $val['paprice'];
				$re[$k]['tag'] = 1; //正常
			}
			//$re[$k]['timenum']	=$timenum;

		}
		//print_r($re);exit;
		include $this->loadWidget('franchiseelteTheme');
	}
	//删除购物车
	public function delcart() {
		$this->loadModel('franchisee', 'ordercart');
		$this->loadHelper("extend");
		if ($_GET) {
			$id = $_GET['id'];
			$line = $this->franchisee->ordercartModel->delete("id=" . $id);
			if ($line) {
				ajaxReturn('', '删除成功', 1);
			} else {
				ajaxReturn('', '删除失败', 0);
			}
		}
	}

	//修改购物车数量
	public function updatecart() {
		$this->loadModel('franchisee', 'ordercart');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data['num'] = $_POST['num'];
			if (empty($data['num'])) {
				ajaxReturn('', '数据有误', 0);
			}
			$line = $this->franchisee->ordercartModel->update($data, "id=" . $id);
			if ($line) {
				ajaxReturn('', '修改成功', 1);
			} else {
				ajaxReturn('', '修改失败', 0);
			}
		}
	}
	//提交购物车--proviceid
	public function tjcart() {
		$this->loadModel('franchisee', 'ordercart');
		$this->loadModel('franchisee', 'order');
		$this->loadModel('product', 'goods');
		$this->loadModel('franchisee', 'orderinfo');
		$this->loadHelper("extend");
		if ($_POST) {
			//查看总价
			
			if(!isset($_POST['selcartid'])){
				ajaxReturn('', '未选择商品', 0);
			}
			
			$sql = "select fo.id as cartid,fo.num as cartnum,fo.tag,pg.futureprice,pg.beoverdue ,pg.title,pg.weight,pg.id,pg.uuid,pg.imgpath,pg.barcode,pg.pingyincode,pg.franchiseeprice,pg.shelflife,pg.number,pg.boxnum,(select price from product_allianceprice where goodsid=pg.id and supplytypeid=" . $this->info['supplytypeid'] . " ) as paprice from franchisee_ordercart as fo left join product_goods as pg on fo.goodsid=pg.id where token='" . $this->info['token'] . "'";
			$re = $this->franchisee->ordercartModel->fetchAll($sql);
			if (!$re) {
				ajaxReturn('', '购物车中无商品', 0);
			}

			$ordernum = date("ymdhis") . substr(uniqid(rand()), -6);
			$odata['uuid'] = 'uuid()';
			$odata['token'] = $this->info['token'];
			$odata['ordernum'] = $ordernum;
			$odata['remark'] = $_POST['remark'];
			//$odata['proviceid']	=	$this->info['proviceid'];
			//$odata['cityid']	=	$this->info['cityid'];
			$odata['created'] = time();
			$odata['supplytypeid'] = $this->info['supplytypeid'];
			$odata['userid'] = $this->info['userid'];
			$line = $this->franchisee->orderModel->insert($odata);

			$allprice = 0;
			$weight = 0;
			$tag = true;
			$ii=0;
			if ($line) {
				$goodsarray = array();
				$insertSql = "insert into franchisee_orderinfo(price,productontime,ordernum,num,goodsid,tag,boxnum,allprice,weights)values";
				foreach ($re as $key => $val) {
					//$val['boxnum']	=	1;
					if(!in_array($val['cartid'],$_POST['selcartid'])){
						continue;
					}
					$data = array();
					if (!isset($goodsarray[$val['id']])) {
						//$goodsarray[$val['id']]	=	$val['cartnum']*$val['boxnum'];
						$goodsarray[$val['id']] = $val['cartnum'];
					} else {
						//$goodsarray[$val['id']]	+=	$val['cartnum']*$val['boxnum'];
						$goodsarray[$val['id']] += $val['cartnum'];
					}
					$data['price'] = $val['paprice'];
					$data['productontime'] = 0;

					$time = time(); //过期时间境界线  productontime>$time  没过期的
					$time1 = time() + $val['beoverdue'] * 24 * 3600; //临期时间境界线  productontime>$time  正常价，小于临期价

					//临期价
					if ($val['tag'] == 0) {
						$sql = "select productontime,num,id from product_productontime where goodsuuid='" . $val['uuid'] . "' and productontime>" . $time . " and productontime<" . $time1 . " order by  productontime asc "; //临期价格---快过期了
						$r = $this->product->goodsModel->fetchAll($sql);
						if ($r) {
							$num = 0;
							foreach ($r as $kr => $v) {
								if ($kr == 0) {
									$data['productontime'] = $v['productontime'];
									$data['price'] = $val['futureprice'];
									break;
								}
							}
						}
					} else {
						$sql = "select productontime,num,id from product_productontime where goodsuuid='" . $val['uuid'] . "'  and productontime>" . $time1 . " order by  productontime asc "; //正常价格
						$r = $this->product->goodsModel->fetchAll($sql);
						if ($r) {
							$num = 0;
							foreach ($r as $kr => $v) {
								if ($kr == 0) {
									$data['productontime'] = $v['productontime'];
								}
								break;
							}

						}

					}

					$data['price'] = empty($data['price']) ? 0 : $data['price'];
					$allprice += $data['price'] * $val['cartnum'] * $val['boxnum'];
					//$weight += $val['weight'] * $val['cartnum'] * $val['boxnum'] / 1000;
					$weight = $val['weight'] * $val['boxnum'] / 1000;

					$data['ordernum'] = $ordernum;
					//$data['num']		=	$val['cartnum']*$val['boxnum'];
					$data['num'] = $val['cartnum'];

					$data['goodsid'] = $val['id'];
					$data['tag'] = $val['tag'];
					$aprice = $data['price'] * $val['cartnum'] * $val['boxnum'];
					if ($ii == 0) {
						$insertSql .= "('" . $data['price'] . "'," . $data['productontime'] . ",'" . $data['ordernum'] . "'," . $data['num'] . "," . $data['goodsid'] . "," . $data['tag'] . "," . $val['boxnum'] . "," . $aprice . "," . $weight . ")";
					} else {
						$insertSql .= ",('" . $data['price'] . "'," . $data['productontime'] . ",'" . $data['ordernum'] . "'," . $data['num'] . "," . $data['goodsid'] . "," . $data['tag'] . "," . $val['boxnum'] . "," . $aprice . "," . $weight . ")";
					}
					$ii++;
					//$tag	=	$this->franchisee->orderinfoModel->insert($data);

				}
				
				$tag = $this->franchisee->orderinfoModel->sqlexec($insertSql);
				if (!$tag) {
					$this->franchisee->orderModel->delete("ordernum='" . $ordernum . "'");
				} else {
					//$str = "共" . count($goodsarray) . "种商品,重量" . $weight . "kg,总计" . $allprice . "元";
					$this->franchisee->orderModel->update(array('price' => $allprice, 'allprice' => $allprice), "id=" . $line);
				}
			} else {
				$tag = false;
			}
			if ($tag) {
				//	删除购物车
				$selcartid=implode(",",$_POST['selcartid']);
				$this->franchisee->ordercartModel->delete("token='" . $this->info['token'] . "' and id in(".$selcartid.")");
				$this->tezhisendmessage($line, 0);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}
		}
	}
	//待确认订单
	public function orderconfirm() {
		$this->leftpos = 2;
		$this->loadModel('franchisee', 'order');
		// $type = isset($_GET['tag']) ? $_GET['tag'] : 0;
		$where = 'status>=0 and status<5';
		$sql = "select fo.*,fos.senddate from franchisee_order as fo left join franchisee_orderlogistics as fos on fos.orderid=fo.id where  fo.token='" . $this->info['token'] . "' and $where ";
		//echo $sql;exit;
		$re = $this->franchisee->orderModel->fetchAll($sql);
		include $this->loadWidget('franchiseelteTheme');
	}

	//已完成订单
	public function ordercomplete() {
		$this->leftpos = 3;
		$this->loadModel('franchisee', 'order');
		$where = "status=5";
		$sql = "select fo.*,fos.senddate from franchisee_order as fo left join franchisee_orderlogistics as fos on fos.orderid=fo.id where  fo.token='" . $this->info['token'] . "' and $where ";
		//echo $sql;exit;
		$re = $this->franchisee->orderModel->fetchAll($sql);
		include $this->loadWidget('franchiseelteTheme');
	}

	//已取消订单
	public function ordercancel() {
		$this->leftpos = 4;
		$this->loadModel('franchisee', 'order');
		$where = "status<0";
		$sql = "select fo.*,fos.senddate from franchisee_order as fo left join franchisee_orderlogistics as fos on fos.orderid=fo.id where  fo.token='" . $this->info['token'] . "' and $where ";
		//echo $sql;exit;
		$re = $this->franchisee->orderModel->fetchAll($sql);
		include $this->loadWidget('franchiseelteTheme');
	}

	//取消订单
	public function updatestatus() {
		$this->loadModel('franchisee', 'order');
		$this->loadHelper("extend");
		if ($_GET) {
			$id = $_GET['id'];
			$data['status'] = -1;
			$line = $this->franchisee->orderModel->update($data, "id=" . $id);
			if ($line) {
				//添加到push表
				/* $data	=	array();
				$this->loadModel('financial','synctype');
				$data['keytype']	=	'order';
				$data['token']		=	$this->info['token'];
				$l	=	$this->financial->synctypeModel->insert($data);
				if(!$l){
				$this->franchisee->orderModel->update(array('status'=>6),"id=".$id);
				ajaxReturn ( '', '操作失败', 0 );exit;
				} */
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}
		}
	}
	//修改订单状态
	public function updateorderstatus() {
		$this->loadModel('franchisee', 'order');
		$this->loadHelper("extend");
		if ($_POST) {

			$id = $_POST['id'];
			$sql = "select backstatus,orderbackstatus,ordernum from franchisee_order where id=$id";
			$order = $this->franchisee->orderModel->fetchRow($sql);
			if ($order['orderbackstatus'] > 0 && $order['backstatus'] != 6) {
				ajaxReturn('', '该订单正在执行退货操作!', 0);
			}
			$datas['completestatus'] = $_POST['results'];
			$datas['status'] = 5;
			$datas['completeremark'] = $_POST['completeremark'];
			$datas['acceptancedate'] = time();

			$line = $this->franchisee->orderModel->update($datas, "id=" . $id);
			//$line	=	true;
			if ($line) {
				//添加到push表
				$data = array();
				$this->loadModel('financial', 'synctype');
				$data['keytype'] = 'order';
				$data['token'] = $this->info['token'];
				$l = $this->financial->synctypeModel->insert($data);
				if (!$l) {
					$this->franchisee->orderModel->update(array('status' => 4), "id=" . $id);
					ajaxReturn('', '操作失败', 0);exit;
				}
				$this->posgoods($order['ordernum']);
				$this->sendemailandmessage($id, 5);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}
		}
	}
	//将订货的商品同步到加盟商表，及库存 franchisee_orderinfo
	public function posgoods($ordernum) {
	
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'product');
		$sql = "select fo.num as goodsnum,fo.boxnum as goodsboxnum,pg.*,pg.uuid as goodsuuid from franchisee_orderinfo as fo left join product_goods as pg on pg.id=fo.goodsid where fo.ordernum='" . $ordernum . "'";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		//print_r($re);
		foreach ($re as $val) {
			$data = array();
			$sql = "select id,num from franchisee_product where token='" . $this->info['token'] . "' and uuid='" . $val['goodsuuid'] . "'";
			$g = $this->franchisee->orderModel->fetchRow($sql);
			if ($g) {
				$data['num'] = $g['num'] - 0 + $val['goodsnum'] * $val['goodsboxnum'];
				$this->franchisee->productModel->update($data, "token='" . $this->info['token'] . "' and uuid='" . $val['goodsuuid'] . "'");
			} else {
				//新增
				$data['uuid'] = $val['goodsuuid'];
				$data['token'] = $this->info['token'];
				$data['barcode'] = $val['barcode'];
				$data['title'] = $val['title'];
				$data['categoryuuid'] = $val['categoryuuid'];
				$data['branduuid'] = $val['branduuid'];
				$data['pingincode'] = $val['pingyincode'];
				$data['num'] = $val['goodsnum'] * $val['goodsboxnum'];
				$data['status'] = 1;
				$data['price'] = $val['price'];
				$data['discountprice'] = $val['price'];
				$data['discountrate'] = 100;
				$data['memberdiscount'] = 1;
				$data['islistdiscount'] = 1;
				$data['type'] = 0;
				$data['goodstype'] = 1;
				$l=$this->franchisee->productModel->insert($data);
				//echo time()."<br/>";
			}
		}
	}
	//订单详情
	public function orderinfo() {
		$this->leftpos = 2;
		$this->loadModel('franchisee', 'order');
		$ordernum = $_GET['ordernum'];
		$sql = "select fo.weights,fo.allprice ,fo.num as buynum,fo.price as buyprice,fo.productontime,fo.realbacknum,pg.barcode,pg.title,pg.imgpath,pg.supplier,pg.number,pg.weight,pg.specs,pg.boxnum,pg.specs,pg.shelflife,pg.categoryuuid,(select title from product_goodscategory where uuid=pg.categoryuuid) as fctitle from franchisee_orderinfo as fo left join product_goods as pg on fo.goodsid=pg.id where fo.ordernum='" . $ordernum . "'";
		$re = $this->franchisee->orderModel->fetchAll($sql);

		//订单信息
		$sql = "select fo.id,fo.status,fo.backstatus,fo.orderbackstatus,fo.token,ws.title as wstitle from franchisee_order as fo left join wms_setting as ws on ws.id=fo.storetypeid  where fo.ordernum='" . $ordernum . "'";
		$order = $this->franchisee->orderModel->fetchRow($sql);

		//查看历史记录
		$sql = "select * from franchisee_orderdata where orderid=" . $order['id'];
		$log = $this->franchisee->orderModel->fetchAll($sql);
		//查看物流信息
		$sql = "select * from  franchisee_orderlogistics where orderid=" . $order['id'];
		$logistics = $this->franchisee->orderModel->fetchRow($sql);
		$this->loadModel('wms', 'setting');
		$sql = "select * from wms_setting where type=0 ";
		$store = $this->wms->settingModel->fetchAll($sql);
		//查看送货员
		$sql = "select * from system_admin where status=1";
		$user = $this->wms->settingModel->fetchAll($sql);
	
		include $this->loadWidget('franchiseelteTheme');
	}

	//查看采购的商品
	public function goodslist() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'ordercart');

		$sql = "select pg.*,fo.num,fo.id as cartid from franchisee_ordercart as fo left join  product_goods as pg on fo.goodsid=pg.id  where token='" . $this->info['token'] . "'";
		$re = $this->franchisee->ordercartModel->fetchAll($sql);
		include $this->loadWidget('franchiseeTheme');
	}
	//修改报损数量
	public function updatelossnum() {
		$this->loadModel('franchisee', 'order');
		$this->loadModel('franchisee', 'orderinfo');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data['lossnum'] = $_POST['lossnum'];
			$line = $this->franchisee->orderinfoModel->update($data, "id=" . $id);
			if ($line) {
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}
		}
	}

	//```````````````````````````````````````邮件短信通知 franchisee_order

	//特制消息人员
	public function tezhisendmessage($id, $status, $tag = 0) {
		set_time_limit(0);
		$this->loadModel("product", "messageremind");
		$keyword = "dinghuo";
		$sql = "select * from franchisee_order where id=" . $id;
		$order = $this->product->messageremindModel->fetchRow($sql);
		$sql = "select * from system_admin where id=" . $order['userid'];
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
	}

	//发送邮件及短信,$tag=1时，表示须传给加盟商发消息通知
	public function sendemailandmessage($id, $status, $tag = 0) {
		set_time_limit(0);
		$this->loadModel("product", "messageremind");
		$keyword = "dinghuo";
		$sql = "select sa.* from product_messageremind as pm left join system_admin as sa on sa.id=pm.userid  where pm.keyword='" . $keyword . "' and orderstatus=" . $status;
		$user = $this->product->messageremindModel->fetchAll($sql);

		$sql = "select ordernum,token from franchisee_order where id=" . $id;
		$order = $this->product->messageremindModel->fetchRow($sql);
		//print_r($order);exit;
		if ($tag == 1) {
			$sql = "select * from franchisee_alliance token='" . $order['token'] . "'";
			$alliance = $this->product->messageremindModel->fetchRow($sql);
			$token = $alliance['token'];
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
		$mailbody = "订货单单号：" . $order['ordernum'];
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
		if (empty($token)) {
			//	给加盟商发邮件及短信
			if (!empty($alliance['email'])) {
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

		$bk = $sms->send_order_message($str, $mobile);
		//print_r($bk);exit;
		return $bk;
	}
}
?>