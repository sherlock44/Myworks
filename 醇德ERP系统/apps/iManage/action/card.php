<?php
/*
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */
class card extends actionAbstract {

	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 5;
	public $type = 0;
	public $leftpos = 0;
	public $like = "";
	public $where = "";

	/*
	 * 构造函数
	 */
	function __construct() {
		parent::__construct();
		//$this->info = acl::checkLogin('admininfo',$this->url('common/login'));
		if (!isset($_SESSION['admininfo'])) {header('location:' . $this->url('common/login'));}$this->info = $_SESSION['admininfo'];
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		$this->conf = $this->loadConfig('sysconf');
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			//ajax request
			$this->checkpower();
		}
	}

	/**
	 *  会员卡列表页面
	 */

	public function cardlist() {
		$this->leftpos = 0;
		$this->pos = 3;
		$this->loadModel('franchisee', 'card');
		$this->loadModel('franchisee', 'carddiscount');

		//$configset=$this->loadConfig('sysconf');
		//print_r($configset);
		$card = $this->conf['cardType'];
		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$this->where = " where 1=1 ";
		if (isset($_GET['status']) && $_GET['status'] != "") {
			$this->where .= " and franchisee_card.status = " . $_GET['status'] . "";
		}
		if (isset($_GET['cardtype']) && $_GET['cardtype'] != "") {
			$this->where .= " and franchisee_card.cardtype = " . $_GET['cardtype'] . "";
		}
		$cardnum='';
		if (isset($_GET['cardnum']) && $_GET['cardnum'] != "") {
			$cardnum=$_GET['cardnum'];
			$this->where .= " and franchisee_card.cardnum like '%".$cardnum."%'";
		}
		//print_r($_GET['cardtype']);
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = 10;
		$offset = ($page - 1) * $size;
		$sql = "select count(*) from franchisee_card " . $this->where . "";
		$count = $this->franchisee->cardModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select * from franchisee_card" . $this->where . " order by lastpaytime desc,status desc,id asc" . " limit " . $offset . "," . $size . "";
		//echo $sql;exit;
		$re = $this->franchisee->cardModel->fetchAll($sql);
//print_r($re);
		include $this->loadWidget('amdinlteTheme');
	}
	
	/**
	 *  会员管理
	 */

	public function userlist() {
		$this->leftpos = 0;
		$this->pos = 3;
		$this->loadModel('franchisee', 'card');
		$this->loadModel('franchisee', 'carddiscount');

		//$configset=$this->loadConfig('sysconf');
		//print_r($configset);
		$card = $this->conf['cardType'];
		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$this->where = " where 1=1 ";
		if (isset($_GET['status']) && $_GET['status'] !== "") {
			$this->where .= " and franchisee_card.status = " . $_GET['status'] . "";
		}
		$this->where .= " and franchisee_card.status = 1";
		/* if (isset($_GET['cardtype']) && $_GET['cardtype'] !== "") {
			$this->where .= " and franchisee_card.cardtype = " . $_GET['cardtype'] . "";
		}
		//print_r($_GET['cardtype']);
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = 10;
		$offset = ($page - 1) * $size;
		$sql = "select count(*) from franchisee_card " . $this->where . "";
		$count = $this->franchisee->cardModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select * from franchisee_card" . $this->where . " order by id asc" . " limit " . $offset . "," . $size . ""; */
		$sql = "select * from franchisee_card" . $this->where . " order by id asc";
		//echo $sql;exit;
		$re = $this->franchisee->cardModel->fetchAll($sql);
//print_r($re);
		include $this->loadWidget('amdinlteTheme');
	}
	//会员详情
	/**
	 *  会员卡详细信息页面
	 */
	public function userinfo() {
		$this->leftpos = 0;
		$this->pos = 3;
		$this->loadModel('franchisee', 'card');
		$card = $this->conf['cardType'];
		$id = $_GET['id'];
		$sql = "select fc.*,fa.shoppname from franchisee_card as fc left join  franchisee_alliance as fa on fa.token=fc.token  where fc.id={$id}";
		$re = $this->franchisee->cardModel->fetchRow($sql);
		//print_r($re);exit;
		//最近一次消费时间和money
		$sql	=	"select * from franchisee_cardlog where cardnum='".$re['cardnum']."' and (type=2 or type=5) order by created desc ";
		$lastpay = $this->franchisee->cardModel->fetchRow($sql);
		//最近一次充值时间和money
		$sql	=	"select * from franchisee_cardlog where cardnum='".$re['cardnum']."' and type=1 order by created desc ";
		$lastuse = $this->franchisee->cardModel->fetchRow($sql);
		//消费记录
		$sql	=	"select * from franchisee_cardlog where cardnum='".$re['cardnum']."'  order by created desc limit 0,10";
		$cardlog = $this->franchisee->cardModel->fetchAll($sql);
		//2收银，5订餐
		$logtype=array('1'=>'充值','2'=>'消费','3'=>'冻结','4'=>'解除冻结','5'=>'消费');
		//共充值，次数，平均，最大
		$sql	=	"select max(money) as maxmoney,round(avg(money),2) as avgmoney,count(*) as allnum from franchisee_cardlog where cardnum='".$re['cardnum']."' and type=1";
		$paylogcz = $this->franchisee->cardModel->fetchRow($sql);
		//共消费，次数，平均，最大
		$sql	=	"select max(money) as maxmoney,round(avg(money),2) as avgmoney,count(*) as allnum from franchisee_cardlog where cardnum='".$re['cardnum']."' and (type=2 or type=5)";
		//echo $sql;exit;
		$paylogxf = $this->franchisee->cardModel->fetchRow($sql);
		//常去的加盟店
		
		include $this->loadWidget('amdinlteTheme');
	}
	//更多操作界面
	public function userlogpay(){
		$this->loadModel('franchisee', 'card');
		$card = $this->conf['cardType'];
		$logtype=array('1'=>'充值','2'=>'消费','3'=>'冻结','4'=>'解除冻结','5'=>'消费');
		//消费记录
		$sql	=	"select * from franchisee_cardlog where cardnum='".$_GET['cardnum']."' and type=1 order by created desc ";
		$cardlog = $this->franchisee->cardModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	public function orderinfo(){
		$ordernum	=	$_GET['ordernum'];
		$ordertype	=	$_GET['ordertype'];
		if($ordertype==2){
		//收银
		$this->loadModel('franchisee', 'userorder');
		$sql	=	"select fu.*,fa.shoppname from franchisee_userorder as fu left join franchisee_alliance as fa on fa.token=fu.token where fu.orderno='".$ordernum."'";
		$order	=	$this->franchisee->userorderModel->fetchRow($sql);
		//购买商品
		$sql	=	"select fui.*,fp.title as ftitle,fp.barcode as fbarcode from franchisee_userorderinfo as fui left join franchisee_product as fp on fui.productuuid=fp.uuid where fui.userorderuuid='".$order['uuid']."'";
		
		$goods	=	$this->franchisee->userorderModel->fetchAll($sql);
		}else if($ordertype==5){
		//订餐
		$this->loadModel('franchisee', 'orderdingcan');
		$sql	=	"select fu.uuid,fu.no as orderno,fu.cardno as carduuid,fu.realprice as price,fu.enddate as created,fa.shoppname from franchisee_orderdingcan as fu left join franchisee_alliance as fa on fa.token=fu.token where fu.no='".$ordernum."'";
		$order	=	$this->franchisee->orderdingcanModel->fetchRow($sql);
		//购买商品
		$sql	=	"select fui.price as saleprice ,fui.totalprice,fui.num ,fp.title as ftitle,fp.barcode as fbarcode from franchisee_orderdingcaninfo as fui left join franchisee_product as fp on fui.goodsuuid=fp.uuid where fui.orderuuid='".$order['uuid']."'";
		//echo $sql;exit;
		$goods	=	$this->franchisee->orderdingcanModel->fetchAll($sql);
		}
		include $this->loadWidget('amdinlteTheme');
	}
	//导出会员卡--未激活的
	public function cardout() {
		$this->leftpos = 0;
		$this->pos = 3;
		$this->loadModel('franchisee', 'card');
		$this->loadModel('franchisee', 'carddiscount');

		$sql = "select * from franchisee_card where status=0";
		//echo $sql;exit;
		$re = $this->franchisee->cardModel->fetchAll($sql);
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=会员卡-" . date('Y-m-d', time()) . ".xls"); //定义生成的文件名

		echo iconv("utf-8", "gbk", '卡号') . "\t";

		foreach ($re as $v) {
			//输出内容如下：
			echo "\n";
			echo iconv("utf-8", "gbk", $v['cardnum']) . "\t";

		}

		exit;

	}

	//修改卡状态
	public function changecardstatus() {
		$this->loadModel('franchisee', 'card');
		$this->loadModel('financial', 'synctype');
		$this->loadHelper('extend');
		$id = $_GET['id'];
		$line = $this->franchisee->cardModel->update(array('status' => 2), "id=$id");
		if ($line) {
			ajaxReturn('', '修改成功！', 1);exit;
		} else {
			ajaxReturn('', '修改失败！', 0);exit;
		}
	}

	/**
	 *  会员卡详细信息页面
	 */
	public function carddetail() {
		$this->leftpos = 0;
		$this->pos = 3;
		$this->loadModel('franchisee', 'card');
		$card = $this->conf['cardType'];
		$id = $_GET['id'];
		$sql = "select * from franchisee_card where id={$id}";
		$re = $this->franchisee->cardModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	*
	*修改密码
	*
	**/
	public function changepwd(){
		 $this->loadModel('franchisee', 'card');
		$id	=	$_GET['id'];
		$re	=	$this->franchisee->cardModel->selectOne("id,cardnum,password","id=".$id);
		if($_POST){
			$id	=	$_POST['id'];
			$this->loadHelper('extend');
			$data['password']	=	$_POST['password'];
			if($data['password']!=$_POST['pwd']){
				ajaxReturn('', '两次密码不一致', 0);exit;
			}
			$data['password']	=	md5($data['password']);
			if($data['password']==$re['password']){
			ajaxReturn('', '修改成功！', 1);exit;
			}
			$line	=	$this->franchisee->cardModel->update($data,"id=".$id);
				if ($line) {
				ajaxReturn('', '修改成功！', 1);exit;
				} else {
					ajaxReturn('', '修改失败！', 0);exit;
				}
		} 
		
		
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 *  批量生成会员卡页面
	 */
	public function batchcard() {
		$this->leftpos = 2;
		$this->pos = 3;
		$card = $this->conf['cardType'];
		$this->loadHelper('extend');
		include $this->loadWidget('amdinlteTheme');
	}

	/**
	 *  批量生成会员卡方法
	 */
 
/* 	 public function addcard() {
		$this->leftpos = 2;
		$this->loadModel('franchisee', 'card');
		$this->loadHelper('extend');
		$data = $_POST['data'];
		$id = $_POST['id'];
		$num = $data['num'];
		$arr = array();
		if ($data['cardtype'] == '请选择会员卡类型') {
			exit(json_encode(array('state' => 0, 'info' => '请选择会员卡类型！')));
			//ajaxReturn ('', '请选择会员卡类型！', 0);exit;
		} else {
			//$this->franchisee->cardModel->delete("cardnum like '%001018888000%'");
			$aks = mt_rand(10, 99);
			for ($i = 601; $i <= 800; $i++) {
				if ($i < 10) {
					$k = '000' . $i;
				} else if ($i < 100) {
					$k = '00' . $i;
				} else if ($i < 1000) {
					$k = '0' . $i;
				} else {
					$k = $i;
				}
				$arr[$i]['cardnum'] = "0010188880000".$i;
				//$arr[$i]['cardnum'] = 'CD-'.date('Ymd').mt_rand(0,9999);
				$arr[$i]['cardtype'] = $data['cardtype'];
				$arr[$i]['expirationtime'] = time() - 0 + 365 * 24 * 3600;
				$arr[$i]['uuid'] = "uuid()";
				//去重
				$sql = "select cardnum from franchisee_card";
				$rs = $this->franchisee->cardModel->fetchAll($sql);
				//print_r($rs);exit;
				if (in_array($arr[$i]['cardnum'], $rs)) {
					exit(json_encode(array('state' => 0, 'info' => '生成的卡号已存在')));
				}
				//插入数据库
				$re = $this->franchisee->cardModel->insert($arr[$i]);

			}
		}
		if ($re) {
			ajaxReturn('', '生成成功', 1);exit;
		} else {ajaxReturn('', '生成失败', 0);exit;}
	}   */
/**
	 *  批量生成会员卡方法
	 */
	
	public function addcard() {
		$this->leftpos = 2;
		$this->loadModel('franchisee', 'card');
		$this->loadHelper('extend');
		$data = $_POST['data'];
		//$id = $_POST['id'];
		$num = $data['num'];
		$arr = array();
		if ($data['cardtype'] == '请选择会员卡类型') {
			exit(json_encode(array('state' => 0, 'info' => '请选择会员卡类型！')));
			//ajaxReturn ('', '请选择会员卡类型！', 0);exit;
		} else {
			$aks = mt_rand(10, 99);
			for ($i = 1; $i <= $num; $i++) {
				if ($i < 10) {
					$k = '000' . $i;
				} else if ($i < 100) {
					$k = '00' . $i;
				} else if ($i < 1000) {
					$k = '0' . $i;
				} else {
					$k = $i;
				}
				$arr[$i]['cardnum'] = "0" . $data['cardtype'] . date('Ymd') . $aks . $k;
				//$arr[$i]['cardnum'] = 'CD-'.date('Ymd').mt_rand(0,9999);
				$arr[$i]['cardtype'] = $data['cardtype'];
				$arr[$i]['expirationtime'] = time() - 0 + 365 * 24 * 3600;
				$arr[$i]['uuid'] = "uuid()";
				//去重
				$sql = "select cardnum from franchisee_card";
				$rs = $this->franchisee->cardModel->fetchAll($sql);
				//print_r($rs);exit;
				if (in_array($arr[$i]['cardnum'], $rs)) {
					exit(json_encode(array('state' => 0, 'info' => '生成的卡号已存在')));
				}
				//插入数据库
				$re = $this->franchisee->cardModel->insert($arr[$i]);

			}
		}
		if ($re) {
			ajaxReturn('', '生成成功', 1);exit;
		} else {ajaxReturn('', '生成失败', 0);exit;}
	}
	/**
	 * 分发会员卡
	 */
	public function sendcard() {
		$this->leftpos = 3;

		// $configset=$this->loadConfig('sysconf');
		$cardtype = $this->conf['cardType'];
		$this->loadHelper('extend');

		//查看加盟商
		$this->loadModel('franchisee', 'alliance');
		$sql = "select * from franchisee_alliance  where status=1";
		$franchisee = $this->franchisee->allianceModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');
	}

	//查看有多少未关联的会员卡--按等级
	public function nosupplycard() {
		$this->loadModel('franchisee', 'card');
		$cardtype = $_POST['cardtype'];
		$sql = "select count(*) as num from franchisee_card where token is null and cardtype=$cardtype";
		$re = $this->franchisee->cardModel->fetchRow($sql);
		$num = isset($re['num']) ? $re['num'] : 0;
		$data = array("state" => 0, 'num' => $num, "info" => "");
		if ($num > 0) {
			$data['state'] = 1;

		} else {
			$data['num'] = 0;
		}
		echo json_encode($data);

	}
	//查看该加盟商某个等级会员卡数量
	public function supplycardnum() {
		$this->loadModel('franchisee', 'card');
		$cardtype = $_POST['cardtype'];
		$token = $_POST['token'];
		$sql = "select count(*) as num from franchisee_card where token = '" . $token . "' and cardtype=$cardtype and status=0";
		$re = $this->franchisee->cardModel->fetchRow($sql);
		$num = isset($re['num']) ? $re['num'] : 0;
		$data = array("state" => 0, 'num' => $num, "info" => "");
		if ($num > 0) {
			$data['state'] = 1;

		} else {
			$data['num'] = 0;
		}
		echo json_encode($data);

	}
	//将会员卡分配到加盟商
	public function cardtosupply() {
		$this->loadModel('franchisee', 'card');
		$this->loadModel('financial', 'synctype');
		$this->loadHelper('extend');
		$cardtype = $_POST['cardtype'];
		$num = $_POST['num'];
		$data = $_POST['data'];
		//查看该级别的会员卡数量够不够
		$sql = "select id from franchisee_card where token is null and cardtype=$cardtype";
		$re = $this->franchisee->cardModel->fetchAll($sql);
		$numall = count($re);
		if ($numall < $num) {
			ajaxReturn('', '未分配卡数量不足,分配失败！', 0);exit;
		}

		//写入financial_synctype表
		$dataa['token'] = $data['token'];
		$dataa['keytype'] = 'addcard';

		$rs = $this->financial->synctypeModel->insert($dataa);
		//print_r($rs);exit;

		$sql = "select id from franchisee_card where token is null and cardtype=$cardtype  limit 0,$num";
		$re = $this->franchisee->cardModel->fetchAll($sql);
		$idarray = array();
		foreach ($re as $val) {
			$idarray[] = $val['id'];
		}
		$idstr = implode(',', $idarray);
		$line = $this->franchisee->cardModel->update($data, "id in($idstr)");
		if ($line) {
			ajaxReturn('', '修改成功！', 1);exit;
		} else {
			$this->$this->financial->synctypeModel->delete($rs);
			ajaxReturn('','修改失败！', 0);exit;
		}
	}
	/**
	 * 加盟店关联页面
	 */
	public function crmrelated() {
		$this->leftpos = 4;
		$this->pos = 3;
		$this->loadHelper('extend');
		// $configset	=	$this->loadConfig('sysconf');

		$cardType = $this->conf['cardType'];

		$title = isset($_GET['title']) ? $_GET['title'] : '';
		$where = "";
		if (!empty($title)) {
			$where = " and fa.suppname like '%" . $title . "%'";
		}
		//查看加盟商
		$this->loadModel('franchisee', 'alliance');
		$filed = "";
		foreach ($cardType as $k => $val) {
			$filed .= " ,(select count(*) from franchisee_card where fa.token=token and cardtype=$k and status=1) as passnum$k ";
		}
		$sql = "select fa.suppname as title,fa.token $filed from franchisee_alliance as fa where fa.status=1 $where";
		//echo $sql;exit;
		$franchisee = $this->franchisee->allianceModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}

	/**
	 * 会员卡折扣率页面
	 */
	public function carddiscount() {
		$this->leftpos = 5;
		$this->pos = 3;
		//  $configset=$this->loadConfig('sysconf');
		$cardtype = $this->conf['cardType'];
		$this->loadHelper('extend');
		$this->loadModel('franchisee', 'carddiscount');
		$arr = array();
		foreach ($cardtype as $k => $v) {

			$sql = "select * from franchisee_carddiscount where cardid={$k}";
			$re = $this->franchisee->carddiscountModel->fetchRow($sql);

			$arr[$k] = $re;
			// print_r($arr[$k]);
		}
		include $this->loadWidget('amdinlteTheme');
	}

	/**
	 * 会员卡折扣率列表
	 */
	public function carddiscountlist() {
		$this->leftpos = 5;

		//  $configset=$this->loadConfig('sysconf');
		$cardtype = $this->conf['cardType'];
		$this->loadHelper('extend');
		$this->loadModel('franchisee', 'carddiscount');
		foreach ($cardtype as $k => $v) {
			$sql = "select * from franchisee_carddiscount where cardid={$k}";
			$re = $this->franchisee->carddiscountModel->fetchRow($sql);
		}

		include $this->loadWidget('amdinlteTheme');
	}

	/**
	 * 修改、添加折扣率
	 */
	public function updatediscount() {
		$this->loadModel('franchisee', 'carddiscount');
		$this->loadModel('financial', 'synctype');
		$this->loadHelper("extend");

		$id = $_POST['cardid'];
		$sql = "select * from franchisee_carddiscount where cardid={$id}";
		$re = $this->franchisee->carddiscountModel->fetchRow($sql);
		if ($re) {
			$data = array();
			$data['discount'] = $_POST['num'];
			$data['updatetime'] = time();
			// print_r($data);exit;
			if (empty($data['discount'])) {
				ajaxReturn('', '填写折扣率', 0);exit;
			}

			$line = $this->franchisee->carddiscountModel->update($data, "cardid=" . $id);
			if ($line) {
				$this->categoryToPos();

				ajaxReturn('', '修改成功', 1);
			} else {
				ajaxReturn('', '修改失败', 0);
			}

		} else {
			$data = array();
			$data['cardid'] = $_POST['cardid'];
			$data['discount'] = $_POST['num'];
			$data['created'] = time();

			$rs = $this->franchisee->carddiscountModel->insert($data);
			if ($rs) {
				$this->categoryToPos();
				ajaxReturn('', '添加成功', 1);
			} else {
				ajaxReturn('', '添加失败', 0);
			}
		}

	}
	//会员充值记录
	public function paylog(){
		$this->loadModel('franchisee', 'cardlog');
		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$where	=	" ";
		$starttime=isset($_GET['starttime'])?strtotime($_GET['starttime']):'';
		$endtime=isset($_GET['endtime'])?strtotime($_GET['endtime']):'';
		
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = isset($_GET['pagenum']) ? $_GET['pagenum'] : 10;
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
		$offset = ($page - 1) * $size;
		if(!empty($keyword)){
			$keyword	=	trim($_GET['keyword']);
			$where = " and fcl.cardnum like '%".$keyword."%' or fc.truename like '%".$keyword."%'  or fc.mobile like '%".$keyword."%'  or fa.shoppname like '%".$keyword."%' ";
		}
		if(!empty($starttime) && !empty($endtime)){
			$where.=" and fcl.created>=".$starttime." and fcl.created<=".$endtime;

		}
		$sql = "select count(fcl.*) from franchisee_cardlog as fcl where fcl.type=1 " . $where;
		$count = $this->franchisee->cardlogModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select fcl.*,fa.shoppname,fc.truename,fc.mobile from franchisee_cardlog as fcl left join franchisee_alliance as fa on fa.token=fcl.token left join franchisee_card as fc on fc.cardnum=fcl.cardnum where fcl.type=1  " . $where . " order by fcl.id desc limit " . $offset . "," . $size . "";
		//var_dump($sql); exit;

		$re = $this->franchisee->cardlogModel->fetchAll($sql);
		
		include $this->loadWidget('amdinlteTheme');
	}
	//会员消费记录
	public function payuselog(){
		$this->loadModel('franchisee', 'cardlog');
		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$where	=	" ";
		$starttime=isset($_GET['starttime'])?strtotime($_GET['starttime']):'';
		$endtime=isset($_GET['endtime'])?strtotime($_GET['endtime']):'';
		
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = isset($_GET['pagenum']) ? $_GET['pagenum'] : 10;
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
		$offset = ($page - 1) * $size;
		if(!empty($keyword)){
			$keyword	=	trim($_GET['keyword']);
			$where = " and fcl.cardnum like '%".$keyword."%' or fc.truename like '%".$keyword."%'  or fc.mobile like '%".$keyword."%'  or fa.shoppname like '%".$keyword."%' ";
		}
		if(!empty($starttime) && !empty($endtime)){
			$where.=" and fcl.created>=".$starttime." and fcl.created<=".$endtime;

		}
		$sql = "select count(fcl.*) from franchisee_cardlog as fcl where (fcl.type=2 or fcl.type=5)" . $where;
		$count = $this->franchisee->cardlogModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select fcl.*,fa.shoppname,fc.truename,fc.mobile from franchisee_cardlog as fcl left join franchisee_alliance as fa on fa.token=fcl.token left join franchisee_card as fc on fc.cardnum=fcl.cardnum where (fcl.type=2 or fcl.type=5)  " . $where . " order by fcl.id desc limit " . $offset . "," . $size . "";
		//var_dump($sql); exit;

		$re = $this->franchisee->cardlogModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//传给pos端
	public function categoryToPos() {

		$this->loadModel('financial', 'synctype');
		$sql = "select token from franchisee_alliance ";
		$re = $this->financial->synctypeModel->fetchAll($sql);
		if (!$re) {return true;}
		$where = " keytype='cardtype' ";
		$this->financial->synctypeModel->delete($where);
		$sql = "insert into financial_synctype(token,keytype) values";
		foreach ($re as $k => $val) {
			if ($k == 0) {
				$sql .= "('" . $val['token'] . "','cardtype')";
			} else {
				$sql .= ",('" . $val['token'] . "','cardtype')";
			}

		}
		$this->financial->synctypeModel->execSql($sql);
	}
}