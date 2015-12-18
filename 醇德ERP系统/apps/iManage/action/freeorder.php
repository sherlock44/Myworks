<?php

/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */

class freeorder extends actionAbstract {
	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 1;
	public $type = 0;
	public $leftpos = 0;

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
		$this->conf = $this->loadConfig('sysconf');
		$this->supplytypeid=$this->conf['freeorderpricetype'][3];
	}

	//得到所有分类
	public function apply() {
		$sql	=	"select * from product_allianceprice ";
		$this->loadModel('product', 'goods');
		set_time_limit(0);
		$this->loadModel('product', 'goods');
		
		$this->loadHelper('extend');
		$userphone = null;
		$this->where .= " and product_goods.status=1 ";
		//$ordernum = $_GET['ordernum'];
		//$token 	  = $_GET['token'];
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
			$branduuid	=	$_GET['branduuid'];
			$this->where .= " and product_goods.branduuid = '" . $_GET['branduuid'] . "'";
		}
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = 10;
		$offset = ($page - 1) * $size;
		$sql = "select count(*) from product_goods  where 1=1 " . $this->where;
		$count = $this->product->goodsModel->fetchRow($sql);
		//print_r($count);exit;
		$count = $count["count(*)"];
		$number = ceil($count / $size);
	
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

	
		include $this->loadWidget('amdinlteTheme');
	
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
		if (isset($_GET['categoryuuid']) && $_GET['categoryuuid'] !== "") {
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
		//查看三级代理
		$time = time();
		$sql = "select product_goods.weight,product_goods.specs,product_goods.boxnum,product_goods.specs,product_goods.title,product_goods.futureprice,product_goods.id,product_goods.uuid,product_goods.imgpath,product_goods.barcode,product_goods.pingyincode,product_goods.franchiseeprice,product_goods.shelflife,product_goods.number,product_goods.beoverdue,fc.title as fctitle,pb.title as brandtitle,(select price from product_allianceprice where goodsid=product_goods.id and supplytypeid=" . $this->supplytypeid . ") as paprice from product_goods left join product_goodscategory as fc on fc.uuid=product_goods.categoryuuid  left join product_brand as pb on pb.uuid=product_goods.branduuid  where 1=1  " . $this->where . "  limit " . $offset . "," . $size . "";
		
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
		
	
		include $this->loadView('');
	}

	//加入购物车
	public function addcart() {
		set_time_limit(0);
		$this->loadModel('franchisee', 'freeordercart');
		$this->loadModel('franchisee', 'productontime');
		$this->loadHelper("extend");
		if ($_POST) {
			
			if (!isset($_POST['goodsid'])) {
				ajaxReturn('', '请选择采购商品', 0);
			}
			/* if (!isset($_POST['token']) || !isset($_POST['ordernum'])) {
				ajaxReturn('', '未选择关联订单', 0);
			} */
			//$token	  = $_POST['token'];
			//$ordernum = $_POST['ordernum'];
			//删除其他订单的商品
			//$this->franchisee->freeordercartModel->delete("ordernum='".$ordernum."' and token='".$token."'");
			$tag = 0;
			//print_r($_POST);exit;
			foreach ($_POST['goodsid'] as $k => $v) {
				if(!isset($_POST['goodsnum_' . $v . '_' . $_POST['tag'][$k]])){continue;}
				$data = array();
				$data['goodsid'] = $v;
				$data['userid'] = $this->info['id'];
				//$data['token'] = $token;
				//$data['ordernum'] = $ordernum;
				$data['tag'] = $_POST['tag'][$k];
				$data['num'] = intval($_POST['goodsnum_' . $v . '_' . $_POST['tag'][$k]]);
				
				if (empty($data['num'])) {continue;}
				$boxnum = $_POST['boxnum_' . $v];
				if ($data['num'] > $_POST['hasnum'][$k]) {
					//ajaxReturn('0', '购买商品数量不能大于库存', 0);
				}
				
				$tag = 1;
				
				//查看之前有没有添加该购物车
				//$sql = 'select * from franchisee_freeordercart where  goodsid=' . $v . ' and token="' . $token . '" and ordernum="'.$ordernum.'" and tag=' . $data['tag'];
				$sql = 'select * from franchisee_freeordercart where  goodsid=' . $v . ' and  tag=' . $data['tag'];
				$r = $this->franchisee->freeordercartModel->fetchRow($sql);
				//print_r($r);exit;
				if ($r) {
					$odata['num'] = $_POST['goodsnum_' . $v . '_' . $_POST['tag'][$k]] - 0 + $r['num'];
					//$this->franchisee->freeordercartModel->update($odata, 'goodsid=' . $v . ' and token="' . $token . '"  and ordernum="'.$ordernum.'"  and tag=' . $data['tag']);
					$this->franchisee->freeordercartModel->update($odata, 'goodsid=' . $v . '   and tag=' . $data['tag']);
				} else {
					$this->franchisee->freeordercartModel->insert($data);
				}

			}

			if ($tag) {
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '未填写购买商品数量', 0);
			}
		}

	}
	//查看已选中的商品--购物车中的商品
	public function cartlist() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'freeordercart');
		$this->loadModel('product', 'goods');
		
		//$sql = "select pg.beoverdue,pg.weight,pg.boxnum,pg.title,pg.specs,pg.id,pg.uuid,pg.imgpath,pg.barcode,pg.pingyincode,pg.futureprice,pg.shelflife,pg.number,fo.tag,fo.num,fo.id as cartid ,(select price from product_allianceprice where goodsid=pg.id and supplytypeid=" . $this->supplytypeid . " ) as paprice from franchisee_freeordercart as fo left join  product_goods as pg on fo.goodsid=pg.id  where token='" . $this->info['token'] . "'";
		$sql = "select pg.beoverdue,pg.weight,pg.boxnum,pg.title,pg.specs,pg.id,pg.uuid,pg.imgpath,pg.barcode,pg.pingyincode,pg.futureprice,pg.shelflife,pg.number,fo.tag,fo.num,fo.id as cartid ,(select price from product_allianceprice where goodsid=pg.id and supplytypeid=" . $this->supplytypeid . " ) as paprice from franchisee_freeordercart as fo left join  product_goods as pg on fo.goodsid=pg.id  where userid='" . $this->info['id'] . "'";

		$re = $this->franchisee->freeordercartModel->fetchAll($sql);
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
		//查看客户的加盟商
		$sql	=	"select id,shoppname,token from franchisee_alliance where userid=".$this->info['id'];
		$alliance	=	$this->product->goodsModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//得到加盟商订单
	public function getoldorder(){
		$token	=	$_POST['token'];
		$this->loadModel('franchisee', 'order');
		$sql	=	"select token,ordernum from franchisee_order where token='".$token."' and status>=0 order by id desc";
	
		$re		=	$this->franchisee->orderModel->fetchAll($sql);
		if($re){
			$data['state']	=	1;
			$data['re']	=	$re;
		}else{
			$data['state']	=	0;
			$data['re']	=	$re;
		}
		echo json_encode($data);
	}
	//删除购物车
	public function delcart() {
		$this->loadModel('franchisee', 'freeordercart');
		$this->loadHelper("extend");
		if ($_GET) {
			$id = $_GET['id'];
			$line = $this->franchisee->freeordercartModel->delete("id=" . $id);
			if ($line) {
				ajaxReturn('', '删除成功', 1);
			} else {
				ajaxReturn('', '删除失败', 0);
			}
		}
	}

	//修改购物车数量
	public function updatecart() {
		$this->loadModel('franchisee', 'freeordercart');
		$this->loadHelper("extend");
		if ($_POST) {
			$id = $_POST['id'];
			$data['num'] = $_POST['num'];
			if (empty($data['num'])) {
				ajaxReturn('', '数据有误', 0);
			}
			$line = $this->franchisee->freeordercartModel->update($data, "id=" . $id);
			if ($line) {
				ajaxReturn('', '修改成功', 1);
			} else {
				ajaxReturn('', '修改失败', 0);
			}
		}
	}
	//提交购物车--proviceid
	public function tjcart() {
		$this->loadModel('franchisee', 'freeordercart');
		$this->loadModel('franchisee', 'order');
		$this->loadModel('product', 'goods');
		$this->loadModel('franchisee', 'orderinfo');
		$this->loadHelper("extend");
		if ($_POST) {
		
		
			
			$token	=	$_POST['alliance'];
			$oldordersel	=	$_POST['oldordersel'];
			$ordernumtxt	=	trim($_POST['ordernum']);
			if(empty($token)){
				ajaxReturn('', '请选择加盟商', 0);
			}
			if(empty($oldordersel) && empty($ordernumtxt)){
				ajaxReturn('', '请选择关联订单号', 0);
			}
			if(!empty($ordernumtxt)){
				$sql	=	"select token,supplytypeid from franchisee_order where ordernum='".$ordernumtxt."'";
				$r		=	$this->franchisee->freeordercartModel->fetchRow($sql);
				if(!$r){
					ajaxReturn('', '输入的关联订单号不存在', 0);
				}
				if($r['token']!=$token){
					ajaxReturn('', '输入的关联订单不是概加盟商订单', 0);
				}
				$ordernumold	=	$ordernumtxt;
			}
			if(empty($ordernumtxt)){
				$ordernumold	=	$oldordersel;
			}
			
			//查看总价
			//$sql = "select fo.token,fo.ordernum,fo.num as cartnum,fo.tag,pg.futureprice,pg.beoverdue ,pg.title,pg.weight,pg.id,pg.uuid,pg.imgpath,pg.barcode,pg.pingyincode,pg.franchiseeprice,pg.shelflife,pg.number,pg.boxnum,(select price from product_allianceprice where goodsid=pg.id and supplytypeid=" . $this->supplytypeid . " ) as paprice from franchisee_freeordercart as fo left join product_goods as pg on fo.goodsid=pg.id where token='" . $this->info['token'] . "'";
			$sql = "select fo.token,fo.ordernum,fo.num as cartnum,fo.tag,pg.futureprice,pg.beoverdue ,pg.title,pg.weight,pg.id,pg.uuid,pg.imgpath,pg.barcode,pg.pingyincode,pg.franchiseeprice,pg.shelflife,pg.number,pg.boxnum,(select price from product_allianceprice where goodsid=pg.id and supplytypeid=" . $this->supplytypeid . " ) as paprice from franchisee_freeordercart as fo left join product_goods as pg on fo.goodsid=pg.id where userid='" . $this->info['id'] . "'";
			$re = $this->franchisee->freeordercartModel->fetchAll($sql);
			if (!$re) {
				ajaxReturn('', '购物车中无商品', 0);
			}
			//查看加盟商的等级
			$sql	=	"select token,supplytypeid from franchisee_order where token='".$token."'";
			$alliance		=	$this->franchisee->freeordercartModel->fetchRow($sql);
			$ordernum = date("ymdhis") . substr(uniqid(rand()), -6);
			$odata['uuid'] = 'uuid()';
			$odata['token'] = $token;
			$odata['ordernum'] = $ordernum;
			$odata['freeordernum'] = $ordernumold;
			$odata['remark'] = $_POST['remark'];
			
			$odata['created'] = time();
			$odata['status'] = 1;
			$odata['supplytypeid'] = $alliance['supplytypeid'];
			$odata['userid'] = $this->info['id'];
			$line = $this->franchisee->orderModel->insert($odata);

			$allprice = 0;
			$weight = 0;
			$tag = true;
			if ($line) {
				$goodsarray = array();
				$insertSql = "insert into franchisee_orderinfo(price,productontime,ordernum,num,goodsid,tag,boxnum,allprice,weights)values";
				foreach ($re as $key => $val) {
					//$val['boxnum']	=	1;
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
					$weight = $val['weight']  * $val['boxnum'] / 1000;

					$data['ordernum'] = $ordernum;
					//$data['num']		=	$val['cartnum']*$val['boxnum'];
					$data['num'] = $val['cartnum'];

					$data['goodsid'] = $val['id'];
					$data['tag'] = $val['tag'];
					$aprice = $data['price'] * $val['cartnum'] * $val['boxnum'];
					if ($key == 0) {
						$insertSql .= "('" . $data['price'] . "'," . $data['productontime'] . ",'" . $data['ordernum'] . "'," . $data['num'] . "," . $data['goodsid'] . "," . $data['tag'] . "," . $val['boxnum'] . "," . $aprice . ",".$weight.")";
					} else {
						$insertSql .= ",('" . $data['price'] . "'," . $data['productontime'] . ",'" . $data['ordernum'] . "'," . $data['num'] . "," . $data['goodsid'] . "," . $data['tag'] . "," . $val['boxnum'] . "," . $aprice . ",".$weight.")";
					}
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
				$this->franchisee->freeordercartModel->delete("userid=" . $this->info['id']);
				//$this->tezhisendmessage($line,0);
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
		$type = isset($_GET['tag']) ? $_GET['tag'] : 0;
		if ($type == 0) {
			//未完成订单
			$where = 'status>=0 and status<5';
		} else if ($type = 1) {
			$where = "status=5";
		} else if ($type = -1) {
			$where = "status<0";
		}
		$sql = "select fo.*,fos.senddate from franchisee_order as fo left join franchisee_orderlogistics as fos on fos.orderid=fo.id where  fo.token='" . $this->info['token'] . "' and $where ";
		//echo $sql;exit;
		$re = $this->franchisee->orderModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
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
				$this->sendemailandmessage($id,5);
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
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
		include $this->loadWidget('amdinlteTheme');
	}

	//查看采购的商品
	public function goodslist() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'ordercart');

		$sql = "select pg.*,fo.num,fo.id as cartid from franchisee_ordercart as fo left join  product_goods as pg on fo.goodsid=pg.id  where token='" . $this->info['token'] . "'";
		$re = $this->franchisee->ordercartModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	
	//```````````````````````````````````````邮件短信通知 franchisee_order
	
		//特制消息人员
	public function tezhisendmessage($id, $status, $tag = 0){
		set_time_limit(0);
		$this->loadModel("product", "messageremind");
		$keyword = "dinghuo";
		$sql = "select * from franchisee_order where id=" . $id;
		$order = $this->product->messageremindModel->fetchRow($sql);
		$sql	=	"select * from system_admin where id=".$order['userid'];
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

		$bk = $sms->send_order_message($str, $mobile);
		  //print_r($bk);exit;
		return $bk;
	}
}
?>