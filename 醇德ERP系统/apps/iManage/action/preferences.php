<?php
/**
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */
class preferences extends actionAbstract {

	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 1;
	public $type = 0;
	public $leftpos = 0;

	/**
	 * 递归要操作的菜单PIN
	 *
	 * @var array
	 */
	protected $add_auth = array();

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
	}

	/**
	 * 入库设置列表
	 */
	public function storage() {
		$this->leftpos = 0;
		$this->loadModel('wms', 'setting');
		$sql = "select * from wms_setting where type=1 ";
		$re = $this->wms->settingModel->fetchAll($sql);
		//include $this->loadWidget('amdinlteTheme');
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 添中入库设置
	 */
	public function addstorage() {
		$this->leftpos = 0;
		$this->loadModel('wms', 'setting');
		include $this->loadWidget('amdinlteTheme');

	}
	/**
	 * 插入入库设置
	 */
	public function insertstorage() {
		$this->loadModel('wms', 'setting');
		$this->loadHelper('extend');
		//$id=$_POST['id'];
		$data = $_POST['data'];
		$data['type'] = 1;
		$re = $this->wms->settingModel->insert($data);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/**
	 * 编辑入库设置
	 */
	public function editstorage() {
		$this->leftpos = 0;
		$this->loadModel('wms', 'setting');
		$id = $_GET['id'];
		$sql = "select * from wms_setting where id=$id";
		$re = $this->wms->settingModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 保存入库设置
	 */
	public function updatestorage() {
		$this->loadModel('wms', 'setting');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$data = $_POST['data'];
		$re = $this->wms->settingModel->update($data, 'id=' . $id);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/*
	 * 删除入库设置
	 */
	public function delstorage() {

		$this->loadHelper('extend');
		$id = $_GET['id'];
		$this->loadModel('wms', 'setting');
		$re = $this->wms->settingModel->delete($id);
		if ($re) {
			ajaxReturn('back', '删除成功', 1);exit;
		} else {
			ajaxReturn('back', '删除失败', 0);exit;
		}
	}

	/**
	 * 出库设置列表
	 */
	public function storageout() {
		$this->leftpos = 1;
		$this->loadModel('wms', 'setting');
		$sql = "select * from wms_setting where type=0 ";
		$re = $this->wms->settingModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
		//include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 添中出库设置
	 */
	public function addstorageout() {
		$this->leftpos = 1;
		$this->loadModel('wms', 'setting');
		include $this->loadWidget('amdinlteTheme');

	}
	/**
	 * 插入出库设置
	 */
	public function insertstorageout() {
		$this->loadModel('wms', 'setting');
		$this->loadHelper('extend');
		//$id=$_POST['id'];
		$data = $_POST['data'];
		$data['type'] = 0;
		$re = $this->wms->settingModel->insert($data);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/**
	 * 编辑出库设置
	 */
	public function editstorageout() {
		$this->leftpos = 1;
		$this->loadModel('wms', 'setting');
		$id = $_GET['id'];
		$sql = "select * from wms_setting where id=$id";
		$re = $this->wms->settingModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 保存出库设置
	 */
	public function updatestorageout() {
		$this->loadModel('wms', 'setting');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$data = $_POST['data'];
		$re = $this->wms->settingModel->update($data, 'id=' . $id);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/*
	 * 删除出库设置
	 */
	public function delstorageout() {

		$this->loadHelper('extend');
		$id = $_GET['id'];
		$this->loadModel('wms', 'setting');
		$re = $this->wms->settingModel->delete($id);
		if ($re) {
			ajaxReturn('back', '删除成功', 1);exit;
		} else {
			ajaxReturn('back', '删除失败', 0);exit;
		}
	}

	/**
	 * 入库类型设置列表
	 */
	public function storagetype() {
		$this->leftpos = 2;
		$this->loadModel('wms', 'typesetting');
		$sql = "select * from wms_typesetting where type=1 ";
		$re = $this->wms->typesettingModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 添中入库类型设置
	 */
	public function addstoragetype() {
		$this->leftpos = 2;
		$this->loadModel('wms', 'typesetting');
		include $this->loadWidget('amdinlteTheme');

	}
	/**
	 * 插入入库类型设置
	 */
	public function insertstoragetype() {
		$this->loadModel('wms', 'typesetting');
		$this->loadHelper('extend');
		//$id=$_POST['id'];
		$data = $_POST['data'];
		$data['type'] = 1;
		$re = $this->wms->typesettingModel->insert($data);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/**
	 * 编辑入库类型设置
	 */
	public function editstoragetype() {
		$this->leftpos = 2;
		$this->loadModel('wms', 'typesetting');
		$id = $_GET['id'];
		$sql = "select * from wms_typesetting where id=$id";
		$re = $this->wms->typesettingModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 保存入库类型设置
	 */
	public function updatestoragetype() {
		$this->loadModel('wms', 'typesetting');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$data = $_POST['data'];
		$re = $this->wms->typesettingModel->update($data, 'id=' . $id);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/*
	 * 删除入库类型设置
	 */
	public function delstoragetype() {

		$this->loadHelper('extend');
		$id = $_GET['id'];
		$this->loadModel('wms', 'typesetting');
		$re = $this->wms->typesettingModel->delete($id);
		if ($re) {
			ajaxReturn('back', '删除成功', 1);exit;
		} else {
			ajaxReturn('back', '删除失败', 0);exit;
		}
	}

	/**
	 * 出库类型设置列表
	 */
	public function storagetypeout() {
		$this->leftpos = 3;
		$this->loadModel('wms', 'typesetting');
		$sql = "select * from wms_typesetting where type=0 ";
		$re = $this->wms->typesettingModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 添中出库类型设置
	 */
	public function addstoragetypeout() {
		$this->leftpos = 3;
		$this->loadModel('wms', 'typesetting');
		include $this->loadWidget('amdinlteTheme');

	}
	/**
	 * 插入出库类型设置
	 */
	public function insertstoragetypeout() {
		$this->loadModel('wms', 'typesetting');
		$this->loadHelper('extend');
		//$id=$_POST['id'];
		$data = $_POST['data'];
		$data['type'] = 0;
		$re = $this->wms->typesettingModel->insert($data);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/**
	 * 编辑出库类型设置
	 */
	public function editstoragetypeout() {
		$this->leftpos = 3;
		$this->loadModel('wms', 'typesetting');
		$id = $_GET['id'];
		$sql = "select * from wms_typesetting where id=$id";
		$re = $this->wms->typesettingModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 保存出库类型设置
	 */
	public function updatestoragetypeout() {
		$this->loadModel('wms', 'typesetting');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$data = $_POST['data'];
		$re = $this->wms->typesettingModel->update($data, 'id=' . $id);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	/*
	 * 删除出库类型设置
	 */
	public function delstoragetypeout() {

		$this->loadHelper('extend');
		$id = $_GET['id'];
		$this->loadModel('wms', 'typesetting');
		$re = $this->wms->typesettingModel->delete($id);
		if ($re) {
			ajaxReturn('back', '删除成功', 1);exit;
		} else {
			ajaxReturn('back', '删除失败', 0);exit;
		}
	}

	/**
	 * 库房设置列表
	 */
	public function house() {
		$this->leftpos = 6;
		$this->loadModel('product', 'house');
		$sql = "select ph.*,ar.name as provicename,arn.name as cityname from product_house as ph left join area_region as ar on ar.id=ph.proviceid left join area_region as arn on arn.id=ph.cityid";
		$re = $this->product->houseModel->fetchAll($sql);
		//include $this->loadWidget('amdinlteTheme');
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 添中库房设置
	 */
	public function addhouse() {
		$this->leftpos = 6;
		$this->loadModel('product', 'house');
		$this->loadModel('area', 'region');
		//得到省
		$sql = "select * from area_region where parentid=1";
		$sheng = $this->area->regionModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');

	}
	//得到城市
	public function getcity() {
		$this->loadModel('area', 'region');
		//得到省
		$sql = "select * from area_region where parentid=" . $_POST['parentid'];
		$city = $this->area->regionModel->fetchAll($sql);
		$str = "<option value='0'>选择城市</option>";
		foreach ($city as $val) {
			$str .= "<option value='" . $val['id'] . "'>" . $val['name'] . "</option>";

		}
		echo $str;
	}
	/**
	 * 插入库房设置
	 */
	public function inserthouse() {
		$this->loadModel('product', 'house');
		$this->loadModel('product', 'housepos');
		$this->loadHelper('extend');
		//$id=$_POST['id'];
		$data = $_POST['data'];
		if (empty($data['number'])) {
			ajaxReturn('', '请填写有几个楼层', 0);exit;
		}
		if (empty($data['rows'])) {
			ajaxReturn('', '请填写行数', 0);exit;
		}
		if (empty($data['cols'])) {
			ajaxReturn('', '请填写列数', 0);exit;
		}
		$re = $this->product->houseModel->insert($data);
		if ($re) {
			$tag = 0;
			$insertsql = "insert into product_housepos(houseid,floortitle,myrows,colspan) values";
			for ($i = 1; $i <= $data['number']; $i++) {
				$floortitle = $i;
				for ($k = 1; $k <= $data['rows']; $k++) {
					$myrows = $k;
					for ($j = 1; $j <= $data['cols']; $j++) {
						$colspan = $j;
						if ($tag == 0) {
							$insertsql .= "(" . $re . ",'" . $floortitle . "'," . $myrows . "," . $colspan . ")";
						} else {
							$insertsql .= ",(" . $re . ",'" . $floortitle . "'," . $myrows . "," . $colspan . ")";
						}
						$tag++;
					}
				}

			}
			//echo $insertsql;exit;
			$line = $this->product->houseModel->sqlexec($insertsql);
			if ($line) {
				ajaxReturn('back', '操作成功', 1);exit;
			} else {
				$this->product->houseModel->delete("id=" . $re);
				ajaxReturn('', '操作失败', 0);exit;

			}
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	/**
	 * 编辑库房设置
	 */
	public function edithouse() {
		$this->leftpos = 6;
		$this->loadModel('product', 'house');
		$this->loadModel('area', 'region');
		$id = $_GET['id'];
		$sql = "select * from product_house where id=$id";
		$re = $this->product->houseModel->fetchRow($sql);
		//得到省
		$sql = "select * from area_region where parentid=1";
		$sheng = $this->area->regionModel->fetchAll($sql);
		//得到市
		$sql = "select * from area_region where parentid=" . $re['proviceid'];
		$city = $this->area->regionModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 保存库房设置
	 */
	public function updatehouse() {
		$this->loadModel('product', 'house');
		$this->loadModel('product', 'housepos');
		$this->loadHelper('extend');
		$id = $_POST['id'];
		$sql = "select * from product_house where id=$id";
		$house = $this->product->houseModel->fetchRow($sql);
		$data = $_POST['data'];
		if (empty($data['number'])) {
			ajaxReturn('', '楼层数必须大于0', 0);exit;
		}
		if (empty($data['rows'])) {
			ajaxReturn('', '行数必须大于0', 0);exit;
		}
		if (empty($data['cols'])) {
			ajaxReturn('', '列数必须大于0', 0);exit;
		}
		$re = $this->product->houseModel->update($data, 'id=' . $id);

		if ($re) {
			if ($house['number'] != $data['number']) {
				if ($house['number'] < $data['number']) {
					//新增楼层
					$number = $house['number'] + 1;
					$insertsql = "insert into product_housepos(houseid,title,floortitle,myrows,colspan) values";
					$i = 0;
					$tag = 0;
					for ($number; $number <= $data['number']; $number++) {
						$floortitle = $number;
						for ($k = 1; $k <= $house['rows']; $k++) {
							$myrows = $k;
							for ($j = 1; $j <= $house['cols']; $j++) {
								$colspan = $j;
								if ($tag == 0) {
									$insertsql .= "(" . $id . ",'" . $floortitle . "-" . $myrows . "-" . $colspan . "','" . $floortitle . "'," . $myrows . "," . $colspan . ")";
								} else {
									$insertsql .= ",(" . $id . ",'" . $floortitle . "-" . $myrows . "-" . $colspan . "','" . $floortitle . "'," . $myrows . "," . $colspan . ")";
								}
								$tag++;
							}
						}

					}
					//echo $insertsql;exit;
					$line = $this->product->houseModel->sqlexec($insertsql);
				} else if ($house['number'] > $data['number']) {
					//删除楼层
					$number = $data['number'] + 1;
					$floor = array();
					for ($number; $number <= $house['number']; $number++) {
						$floor[] = "'" . $number . "'";
					}
					$floortitle = implode(",", $floor);

					$line = $this->product->houseposModel->delete("houseid=" . $id . " and floortitle in(" . $floortitle . ")");

				}
			}
			if ($house['rows'] != $data['rows']) {
				if ($house['rows'] < $data['rows']) {
					//	添加行数

					$tag = 0;
					$insertsql = "insert into product_housepos(houseid,title,floortitle,myrows,colspan) values";
					for ($i = 1; $i <= $data['number']; $i++) {
						$floortitle = $i;
						$rows = $house['rows'] + 1;
						for ($rows; $rows <= $data['rows']; $rows++) {
							$myrows = $rows;
							for ($j = 1; $j <= $house['cols']; $j++) {
								$colspan = $j;
								if ($tag == 0) {
									$insertsql .= "(" . $id . ",'" . $floortitle . "-" . $myrows . "-" . $colspan . "','" . $floortitle . "'," . $myrows . "," . $colspan . ")";
									//$insertsql.="(".$id.",'".$floortitle."',".$myrows.",".$colspan.")";
								} else {
									$insertsql .= ",(" . $id . ",'" . $floortitle . "-" . $myrows . "-" . $colspan . "','" . $floortitle . "'," . $myrows . "," . $colspan . ")";
								}
								$tag++;
							}
						}

					}
					//echo $insertsql;exit;
					$line = $this->product->houseModel->sqlexec($insertsql);
				} else if ($house['rows'] > $data['rows']) {
					//删除行数
					$rows = $data['rows'] + 1;
					$rowsarray = array();
					for ($rows; $rows <= $house['rows']; $rows++) {
						$rowsarray[] = "'" . $rows . "'";
					}
					$strrows = implode(",", $rowsarray);

					$line = $this->product->houseposModel->delete("houseid=" . $id . " and myrows in(" . $strrows . ")");

				}
			}
			if ($house['cols'] != $data['cols']) {
				if ($house['cols'] < $data['cols']) {
					//	添加列数

					$tag = 0;
					$insertsql = "insert into product_housepos(houseid,title,floortitle,myrows,colspan) values";
					for ($i = 1; $i <= $data['number']; $i++) {
						$floortitle = $i;
						$rows = $house['rows'] + 1;
						for ($k = 1; $k <= $house['rows']; $k++) {
							$myrows = $k;
							$cols = $house['cols'] + 1;
							for ($cols; $cols <= $data['cols']; $cols++) {
								$colspan = $cols;
								if ($tag == 0) {
									//$insertsql.="(".$id.",'".$floortitle."',".$myrows.",".$colspan.")";
									$insertsql .= "(" . $id . ",'" . $floortitle . "-" . $myrows . "-" . $colspan . "','" . $floortitle . "'," . $myrows . "," . $colspan . ")";
								} else {
									//$insertsql.=",(".$id.",'".$floortitle."',".$myrows.",".$colspan.")";
									$insertsql .= ",(" . $id . ",'" . $floortitle . "-" . $myrows . "-" . $colspan . "','" . $floortitle . "'," . $myrows . "," . $colspan . ")";
								}
								$tag++;
							}
						}

					}

					$line = $this->product->houseModel->sqlexec($insertsql);
				} else if ($house['cols'] > $data['cols']) {
					//删除行数
					$cols = $data['cols'] + 1;
					$rowsarray = array();
					for ($cols; $cols <= $house['cols']; $cols++) {
						$rowsarray[] = "'" . $cols . "'";
					}
					$strrows = implode(",", $rowsarray);

					$line = $this->product->houseposModel->delete("houseid=" . $id . " and colspan in(" . $strrows . ")");

				}
			}
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	/*
	 * 删除库房设置
	 */
	public function delhouse() {

		$this->loadHelper('extend');
		$id = $_GET['id'];
		$this->loadModel('product', 'house');
		$re = $this->product->houseModel->delete($id);
		if ($re) {
			ajaxReturn('', '删除成功', 1);exit;
		} else {
			ajaxReturn('', '删除失败', 0);exit;
		}
	}

	/**
	 * 库位设置列表
	 */
	public function housepos() {
		$this->leftpos = 6;
		$this->loadModel('product', 'housepos');
		$houseid = $_GET['houseid'];
		$sql = "select * from product_housepos where houseid=$houseid order by floortitle asc,myrows asc,colspan asc";
		$re = $this->product->houseposModel->fetchAll($sql);
		$sql = "select * from product_house where id=$houseid  ";
		$house = $this->product->houseposModel->fetchRow($sql);
		$posarray = array();
		$num = $house['rows'] * $house['cols'];
		foreach ($re as $k => $v) {
			$i = floor($k / $num);
			$j = floor($k / $house['cols']);
			$posarray[$i][$j][] = $v;
		}
		
		include $this->loadWidget('amdinlteTheme');
	}
	/**
	 * 添中库位设置
	 */
	/*  public function addhousepos(){
	$this->leftpos=6;
	$this->loadModel('product','housepos');
	$houseid	=	$_GET['houseid'];
	$sql	=	"select title from product_house where id=$houseid";
	$house	=	$this->product->houseposModel->fetchRow($sql);
	include $this->loadWidget('amdinlteTheme');
	} */
	/**
	 * 插入库位设置
	 */
	/*  public function inserthousepos(){
	$this->loadModel('product','housepos');
	$this->loadHelper('extend');
	//$id=$_POST['id'];
	$data=$_POST['data'];

	$re=$this->product->houseposModel->insert($data);
	if($re){
	ajaxReturn ( 'back', '操作成功', 1 );exit;
	}else{
	ajaxReturn ( '操作失败', 0);exit;
	}
	} */
	/**
	 * 编辑库位设置
	 */
	/*  public function edithousepos(){
	$this->leftpos=6;
	$this->loadModel('product','housepos');
	$id	=	$_GET['id'];
	$sql	=	"select * from product_housepos where id=$id";
	$re	=	$this->product->houseposModel->fetchRow($sql);
	$houseid	=	$re['houseid'];
	$sql	=	"select title from product_house where id=$houseid";
	$house	=	$this->product->houseposModel->fetchRow($sql);
	include $this->loadWidget('amdinlteTheme');
	} */
	/**
	 * 保存库位设置
	 */
	public function updatehousepos() {
		$this->loadModel('product', 'housepos');
		$this->loadHelper('extend');
		if (empty($_POST['id'])) {
			ajaxReturn('操作失败', 0);exit;
		}
		$id = $_POST['id'];
		$title = $_POST['title'];
		$insertsql = "insert into product_housepos(id,title) values";
		foreach ($id as $k => $v) {
			if ($k == 0) {
				$insertsql .= "(" . $v . ",'" . $title[$k] . "')";
			} else {
				$insertsql .= ",(" . $v . ",'" . $title[$k] . "')";
			}

		}
		$insertsql .= " on duplicate key update title=values(title)";
		$re = $this->product->houseposModel->sqlexec($insertsql);
		if ($re) {
			ajaxReturn('', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	/*
	 * 删除库位设置
	 */
/*     public function  delhousepos(){

$this->loadHelper('extend');
$id=$_GET['id'];
$this->loadModel('product','housepos');
$re = $this->product->houseposModel->delete($id);
if($re){
ajaxReturn ('back', '删除成功', 1 );exit;
}else{
ajaxReturn ('back', '删除失败', 0);exit;
}
}   */
}
?>