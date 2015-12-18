<?php
/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */
class area extends actionAbstract {

	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 3;
	public $type = 0;
	public $leftpos = 4;

	/**
	 * 递归要添加的菜单PIN
	 *
	 * @var array
	 */
	protected $add_auth = array();

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

	public function getRegion() {
		$this->loadModel('area', 'region');
		$result = $this->area->regionModel->select("id,name", "parentid=" . $_GET["parentid"]);
		echo json_encode($result);
	}

	//区域管理
	public function region() {
		$this->leftpos = 4;
		$this->loadModel('area', 'region');
		$this->loadHelper('extend');
		$sql = "select *,name as title from area_region order by id asc";
		$re = $this->area->regionModel->fetchAll($sql);
		$result = toTree($re, 'id', 'parentid', 'childs');
		//拖动排序
		if ($_POST) {
			$orderby = $_POST;
			foreach ($orderby['orderby'] as $k => $v) {
				$data['pdcid'] = $k;
				$re = $this->area->regionModel->update($data, "id='" . $v . "'");
			}
			ajaxReturn('back', '排序成功！', 1);exit;
		}
		include $this->loadWidget('amdinlteTheme');
	}

	//显示添加分类页面
	public function regionAdd() {
		$this->loadHelper('arrayHelper');
		$this->loadHelper('extend');
		$this->loadModel('area', 'region');

		$id = $_GET['id'];
		$action = '';

		$data['action'] = '';
		$data['id'] = $id;
		$html = $this->loadAjaxView('area/regionAdd', $data);
		ajaxReturn($html, '', 1);
	}
	//添加分类
	public function regionInsert() {
		$this->loadHelper('extend');
		$this->loadModel('area', 'region');

		$data['name'] = isset($_POST['region_name']) ? $_POST['region_name'] : '';
		$data['parentid'] = isset($_POST['parent_id']) ? $_POST['parent_id'] : '0';
		if ($data['parentid'] == 'root') {$data['parentid'] = 0;}
		if (!preg_match("/^[0-9a-zA-Z\x{4e00}-\x{9fa5}]{1,10}+$/u", $data['name'])) {
			ajaxReturn('', '名称为1-10个字母、数字、汉字', 0);exit;
		}
		//print_r($data);exit;
		$re = $this->area->regionModel->insert($data);
		if ($re) {
			ajaxReturn('back', '添加成功', 1);
		} else {
			ajaxReturn('', '添加失败', 0);
		}
	}
	//编辑分类页面
	public function regionEdit() {
		$this->loadHelper('arrayHelper');
		$this->loadHelper('extend');
		$this->loadModel('area', 'region');

		$id = $_GET['id'];
		$sql = "select * from area_region where id=" . $id;
		$info = $this->area->regionModel->fetchRow($sql);
		$action = 'edit';
		$data['info'] = $info;
		$data['action'] = $action;
		$data['id'] = $id;
		$html = $this->loadAjaxView('area/regionAdd', $data);
		ajaxReturn($html, '', 1);
	}
	//编辑分类
	public function regionUpdate() {
		$this->loadHelper('extend');
		$this->loadModel('area', 'region');

		$name = isset($_POST['region_name']) ? $_POST['region_name'] : '';
		$parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : '';

		if (!preg_match("/^[0-9a-zA-Z\x{4e00}-\x{9fa5}]{1,10}+$/u", $name)) {
			ajaxReturn('', '名称为1-10个字母、数字、汉字', 0);exit;
		}
		$data['name'] = $name;
		$re = $this->area->regionModel->update($data, "id='" . $parent_id . "'");
		if ($re) {
			ajaxReturn('back', '修改成功', 1);
		} else {
			ajaxReturn('', '修改失败', 0);
		}
	}
	//删除分类
	public function regionDel() {
		$this->loadHelper('extend');
		$this->loadModel('area', 'region');
		$region_id = isset($_GET['id']) ? $_GET['id'] : 0;

		if ($region_id != 'root') {
			$re = $this->area->regionModel->delete("id='" . $region_id . "'");
			if ($re) {
				ajaxReturn('back', '删除成功', 1);
			} else {
				ajaxReturn('', '删除失败', 0);
			}
		} else {
			ajaxReturn('', '该节点不能删除', 0);
		}
	}

}