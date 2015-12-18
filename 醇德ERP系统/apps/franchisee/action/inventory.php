<?php

/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */

class inventory extends actionAbstract {
	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 1;
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
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
	}
	//库存概述
	public function invenlist() {
		$re = $this->info;
		$this->pos = 1;
		$this->loadModel('franchisee', 'product');
		$sql = "select fp.*,fgd.title as ppmc,fct.title as flmc from franchisee_product as fp
                left join franchisee_goodsbrand as fgd on fgd.uuid = fp.branduuid
                left join franchisee_category   as fct on fct.uuid = fp.categoryuuid
                where fp.token = '{$re['token']}'";
               
		$sql = "select fp.* from franchisee_product as fp where fp.token = '{$re['token']}'";
		$rs = $this->franchisee->productModel->fetchAll($sql);
		//品牌
		$sql	=	"select * from franchisee_goodsbrand where token = '{$re['token']}'";
		$brand = $this->franchisee->productModel->fetchAll($sql);
		$brands	=	array();
		foreach($brand as $k=>$val){
			$brands[$val['uuid']]=$val['title'];
		}
		//分类
		$sql	=	"select * from franchisee_category where token = '{$re['token']}'";
		$category = $this->franchisee->productModel->fetchAll($sql);
		$categorys	=	array();
		foreach($category as $k=>$val){
			$categorys[$val['uuid']]=$val['title'];
		}
		
		include $this->loadWidget('franchiseelteTheme');

	}

}
?>