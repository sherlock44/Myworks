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
	public $pos = 2;
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
		$this->info = acl::checkLogin('accessinfo', $this->url('common/login'));
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
	}

	//退货单列表
	public function lists() {
		$this->leftpos = 2;
		$this->loadModel('franchisee', 'orderback');
		$where = " where status>=1 and token='" . $this->info['token'] . "'";
		$sql = "select * from franchisee_orderback $where ";
		$re = $this->franchisee->orderbackModel->fetchAll($sql);
		$sysconf = $this->loadConfig('posapiconfig');
		include $this->loadWidget('franchiseeTheme');
	}

	//订单详情
	public function orderinfo() {
		$this->leftpos = 2;
		$this->loadModel('franchisee', 'orderback');
		$id = $_GET['id'];
		//退单详情
		$sql = "select * from franchisee_orderback where id=$id";
		$re = $this->franchisee->orderbackModel->fetchRow($sql);
		$sql = "select fo.buynum ,fo.num,fo.price ,pg.barcode,pg.title,pg.imgpath from franchisee_orderbackinfo as fo left join product_goods as pg on fo.goodsid=pg.id where fo.backid='" . $id . "'";
		$goods = $this->franchisee->orderbackModel->fetchAll($sql);
		$sysconf = $this->loadConfig('posapiconfig');
		include $this->loadWidget('franchiseeTheme');
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

}
?>