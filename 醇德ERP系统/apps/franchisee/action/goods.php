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
		$this->info = acl::checkLogin('accessinfo', $this->url('common/login'));
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		$this->loadModel('system', 'norm');
		$this->loadModel('franchisee', 'brand');
		$this->loadModel('system', 'logs');
		$this->loadHelper('handleimage');
		// print_r($this->info);

	}
	/*
	 * 商品管理
	 */
	public function lists() {
		$this->leftpos = 1;
		$token = $this->info['token'];
		$this->loadModel('franchisee', 'product');
		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$userphone = null;

		if (!empty($_GET['userphone'])) {
			$this->where .= " and (franchisee_product.title like  '%" . $_GET['userphone'] . "%' or franchisee_product.barcode like '%" . $_GET['userphone'] . "%')";

			$userphone = $_GET['userphone'];
		}
		$sid = '';
		if (isset($_GET['categoryuuid']) && $_GET['categoryuuid'] !== "") {
			$sid = $_GET['categoryuuid'];
			//得到二级分类 product_category
			$sqlc = "select id from franchisee_category where parentuuid='" . $_GET['categoryuuid'] . "'";
			$c = $this->franchisee->productModel->fetchAll($sqlc);
			if ($c) {
				$this->where .= " and (franchisee_product.categoryuuid = '" . $_GET['categoryuuid'] . "' or franchisee_product.categoryuuid in($sqlc))";
			} else {
				$this->where .= " and franchisee_product.categoryuuid = '" . $_GET['categoryuuid'] . "'";
			}
		}
		if (isset($_GET['branduuid']) && $_GET['branduuid'] !== "") {
			$this->where .= " and franchisee_product.branduuid = '" . $_GET['branduuid'] . "'";
		}
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = 10;
		$offset = ($page - 1) * $size;
		$sql = "select count(*) from franchisee_product  where token = '" . $token . "' " . $this->where;
		$count = $this->franchisee->productModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select franchisee_product.*,fc.title as fctitle from franchisee_product left join franchisee_category as fc on fc.uuid=franchisee_product.categoryuuid  where franchisee_product.token = '" . $token . "'  " . $this->where . "  limit " . $offset . "," . $size . "";

		//echo $sql;exit;
		$re = $this->franchisee->productModel->fetchAll($sql);
		//品牌和名称
		$this->loadModel('franchisee', 'category');
		$this->loadHelper("Treeuuid");
		$sql = "select * from franchisee_category where token='" . $this->info['token'] . "' ";
		$category = $this->franchisee->categoryModel->fetchAll($sql);
		$tree = new Treeuuid($category);
		$str = "<option value=\$uuid >\$spacer\$title</option>";
		$str = "<option value=\$uuid \$selected>\$spacer\$title</option>";
		$trees = $tree->get_tree(0, $str, $sid);
		//品牌
		$sql = "select id,title from product_brand order by sort asc ";
		$brand = $this->franchisee->categoryModel->fetchAll($sql);

		include $this->loadWidget('franchiseeTheme');
	}
	/***
	 *
	 *添加商品
	 *
	 ****/
	public function addshop() {
		$this->loadModel('franchisee', 'category');
		$this->loadHelper("Tree");
		$sql = "select * from franchisee_category where token='" . $this->info['token'] . "'";
		$category = $this->franchisee->categoryModel->fetchAll($sql);
		$tree = new Tree($category);
		$str = "<option value=\$id >\$spacer\$title</option>";
		$str = "<option value=\$id \$selected>\$spacer\$title</option>";
		$trees = $tree->get_tree(0, $str);

		include $this->loadWidget('franchiseeTheme');
	}
	/***
	 *
	 *插入商品
	 *
	 ****/
	public function insertshop() {
		$this->loadModel('franchisee', 'product');
		if ($_POST) {
			$this->loadHelper('extend');
			//$this->loadHelper('image');
			$data = $_POST['data'];
			$data['productiontime'] = strtotime($data['productiontime']);
			if (!empty($_FILES['imagefile']['name'])) {
				$this->loadHelper('uploader');
				$uploader = new uploader();
				$data['imgpath'] = $uploader->start('imagefile');
				/* $file=ROOT;
			$file=$file.$data['cover'];
			//压缩图片
			$compress_image=compress_image($file);
			//缩略图片

			$thumbimage=make_thumb($file,50,50); */

			}
			$data['remark'] = $_POST['remark'];
			$data['uuid'] = 'uuid()';
			$data['token'] = $this->info['token'];
			$re = $this->franchisee->productModel->insert($data);

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
		include $this->loadWidget('franchiseeTheme');
	}
	/*
	 * 编辑商品详情
	 */
	public function editshop() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'product');
		$this->loadModel('franchisee', 'category');
		$id = $_GET['id'];
		$sql = "select * from franchisee_product where id=$id";
		$re = $this->franchisee->productModel->fetchRow($sql);
		if (!$re) {die("该产品不存不在");}
		$this->loadHelper("Treeuuid");
		$sql = "select * from franchisee_category where token='" . $this->info['token'] . "'";
		$category = $this->franchisee->categoryModel->fetchAll($sql);
		$tree = new Treeuuid($category);
		$sid = $re['categoryuuid'];
		$str = "<option value=\$id \$selected>\$spacer\$title</option>";
		$trees = $tree->get_tree(0, $str, $sid);
		//品牌

		include $this->loadWidget('franchiseeTheme');
	}
	/***
	 *
	 *修改商品
	 *
	 ****/
	public function updateshop() {

		$this->loadModel('franchisee', 'product');
		if ($_POST) {
			$this->loadHelper('extend');
			//$this->loadHelper('image');
			$data = $_POST['data'];
			$id = $_POST['id'];
			if (!empty($_FILES['imagefile']['name'])) {
				$this->loadHelper('uploader');
				$uploader = new uploader();
				$data['imgpath'] = $uploader->start('imagefile');
				/* $file=ROOT;
			$file=$file.$data['cover'];
			//压缩图片
			$compress_image=compress_image($file);
			//缩略图片

			$thumbimage=make_thumb($file,50,50); */

			}
			$data['remark'] = $_POST['remark'];
			$re = $this->franchisee->productModel->update($data, $id);

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
		$this->loadModel('franchisee', 'product');
		$this->loadHelper('extend');
		if ($_GET) {
			$id = $_GET['id'];
			$re = $this->franchisee->productModel->delete('id=' . $id);
			if ($re) {
				ajaxReturn('back', '删除成功', 1);exit;

			}
		}
		include $this->loadWidget('franchiseeTheme');
	}
	/*
	 * 查看商品详情
	 */
	public function shelf_modify() {
		$this->leftpos = 0;
		$this->loadModel('franchisee', 'product');
		$this->loadModel('store', 'profile');
		$this->loadModel('franchisee', 'comment');
		$this->loadModel('franchisee', 'extend');
		$this->loadModel('franchisee', 'category');
		$cookieid = $this->info['id'];
		if ($_GET) {
			$uuid = $_GET['id'];
			$sql = "select a.*,c.comment,c.created as time,d.content,d.remark,normid,normvalue,d.id as extendid from franchisee_product as a
                                            left join
                                            goods_comment as c on c.goodsid=a.id
                                            left join
                                            goods_extend as d on d.goodsid=a.id
                                            where `uuid`='{$uuid}'";

			$re = $this->franchisee->productModel->fetchRow($sql);
			// print_r($re);

		}

		$sid = isset($re['categoryid']) ? $re['categoryid'] : 0;
		// echo $sid;exit;
		//系统分类
		$sql = "select * from system_category";
		$row = $this->franchisee->categoryModel->fetchAll($sql);
		$this->loadHelper('Tree');
		$tree = new Tree($row);
		$trees = $tree->get_tree(0, '<option value=$id $selected>$spacer$title</option>', $sid);
		//店铺分类
		$sql = "select * from franchisee_category where userid=" . $cookieid;
		$row = $this->franchisee->categoryModel->fetchAll($sql);
		$this->loadHelper('Tree');
		$tree = new Tree($row);
		$shoptrees = $tree->get_tree(0, '<option value=$id $selected>$spacer$title</option>', $sid);
		//规格
		$res = $this->system->normModel->select('id,normkey');
		//商品品牌
		$rebrand = $this->franchisee->brandModel->select('id,title');

		include $this->loadWidget('franchiseeTheme');
	}

	/*
	 * 确认修改商品
	 */
	public function shelf_checkmodify() {
		$this->leftpos = 0;
		$this->loadModel('franchisee', 'product');
		$this->loadModel('franchisee', 'extend');
		$cookieid = $this->info['id'];
		if ($_POST) {
			$this->loadHelper('extend');
			//$this->loadHelper('image');

			$data = $_POST['data'];
			$extend = $_POST['extend'];
			// $image=new image();

			$id = $_POST['id'];
			$extendid = $_POST['extendid'];
			$content = $_POST['content'];
			$extend['content'] = $content;
			if (!empty($_FILES['imagefile']['name'])) {
				$this->loadHelper('uploader');
				$uploader = new uploader();
				$data['cover'] = $uploader->start('imagefile');
				$file = ROOT;
				$file = $file . $data['cover'];
				//压缩图片
				$compress_image = compress_image($file);
				//缩略图片

				$thumbimage = make_thumb($file, 50, 50);

			}
			if ($id) {
				$re = $this->franchisee->productModel->update($data, $id);
				$row = $this->franchisee->extendModel->update($extend, $extendid);
				// exit;
				if ($re || $row) {
					$user['userid'] = $this->info['id'];
					$user['username'] = $this->info['username'];
					$user['created'] = time();
					$user['type'] = 0;
					$user['level'] = 1;
					$user['intro'] = $user['username'] . "于" . date("Y-m-d H:i:s", $user['created']) . "修改了商品" . $data['title'];

					$re = $this->system->logsModel->insert($user);
					ajaxReturn('back', '更新成功', 1);exit;
				} else {
					ajaxReturn('back', '更新失败', 0);exit;
				}
			} else {
				$data['uuid'] = 'uuid()';
				$data['number'] = date("ymdhis") . substr(uniqid(rand()), -6);
				$data['userid'] = $cookieid;
				$re = $this->franchisee->productModel->insert($data);
				if ($re) {
					$extend['goodsid'] = $re;

					$row = $this->franchisee->extendModel->insert($extend);
				}
				if ($re || $row) {
					$user['userid'] = $this->info['id'];
					$user['username'] = $this->info['username'];
					$user['created'] = time();
					$user['type'] = 0;
					$user['level'] = 1;
					$user['intro'] = $user['username'] . "于" . date("Y-m-d H:i:s", $user['created']) . "添加了商品" . $data['title'];
					//print_r($user);exit;
					$re = $this->system->logsModel->insert($user);
					ajaxReturn('back', '添加成功', 1);exit;
				} else {
					ajaxReturn('back', '添加失败', 0);exit;
				}
			}
		}

		include $this->loadWidget('franchiseeTheme');
	}

	/**
	 *修改商品状态
	 **/
	public function check_goods() {
		$id = $_POST['id'];
		$data = $_POST['data'];
		$this->loadModel('franchisee', 'product');
		//print_r($_POST);exit;
		$line = $this->franchisee->productModel->update($data, 'id=' . $id);
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
		$this->loadModel('franchisee', 'brand');
		$this->loadModel('user', 'product');
		$this->loadHelper('extend');
		$this->loadHelper("pager");

		$userphone = null;

		// $this->where = " where 1=1 ";

		if (!empty($_GET['userphone'])) {
			$this->where .= " and title like  '%" . $_GET['userphone'] . "%' or username like '%" . $_GET['userphone'] . "%'";

			$userphone = $_GET['userphone'];
		}

		$cookieid = $this->info['id'];
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = 10;
		$offset = ($page - 1) * $size;
		$sql = "select count(*)  from goods_brand where userid=$cookieid " . $this->where . "";
		$count = $this->franchisee->brandModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select * from goods_brand where userid=$cookieid " . $this->where . " limit " . $offset . "," . $size . "";
		$re = $this->franchisee->brandModel->fetchAll($sql);
		include $this->loadWidget('franchiseeTheme');
	}
	/*
	 * 查看商品品牌
	 */
	public function check_brand() {
		$this->leftpos = 1;
		$this->loadModel('franchisee', 'category');
		$cookieid = $this->info['id'];
		if ($_GET) {
			$id = $_GET['id'];
			$this->loadModel('franchisee', 'brand');
			$this->loadModel('user', 'product');

			$sql = "select a.*,b.username as name from goods_brand as a left join user_basic as b on a.userid=b.id where a.id={$id}";
			$re = $this->franchisee->brandModel->fetchRow($sql);

		}
		$sid = isset($re['categoryid']) ? $re['categoryid'] : 0;
		// echo $sid;exit;
		$sql = "select * from franchisee_category";
		$row = $this->franchisee->categoryModel->fetchAll($sql);
		$this->loadHelper('Tree');
		$tree = new Tree($row);
		$trees = $tree->get_tree(0, '<option value=$id $selected>$spacer$title</option>', $sid);

		if ($_POST) {
			$this->loadHelper('extend');
			$id = $_POST['id'];
			$data = $_POST['data'];
			if (!empty($_FILES['imagefile']['name'])) {
				$this->loadHelper('uploader');
				$uploader = new uploader();
				$data['icon'] = $uploader->start('imagefile');
			}

			$this->loadModel('franchisee', 'brand');
			if (empty($id)) {
				$data['userid'] = $cookieid;
				$data['username'] = $this->info['username'];
				$re = $this->franchisee->brandModel->insert($data);
				if ($re) {

					$user['userid'] = $this->info['id'];
					$user['username'] = $this->info['username'];
					$user['created'] = time();
					$user['type'] = 0;
					$user['level'] = 1;
					$user['intro'] = $user['username'] . "于" . date("Y-m-d H:i:s", $user['created']) . "添加了商品品牌" . $data['title'];
					//print_r($user);exit;
					$re = $this->system->logsModel->insert($user);
					ajaxReturn('back', '添加成功', 1);exit;
				} else {
					ajaxReturn('添加失败', 0);exit;
				}
			} else {
				$re = $this->franchisee->brandModel->update($data, $id);
			}
			if ($re) {
				$user['userid'] = $this->info['id'];
				$user['username'] = $this->info['username'];
				$user['created'] = time();
				$user['type'] = 0;
				$user['level'] = 1;
				$user['intro'] = $user['username'] . "于" . date("Y-m-d H:i:s", $user['created']) . "添加了商品品牌" . $data['title'];
				//print_r($user);exit;
				$re = $this->system->logsModel->insert($user);
				ajaxReturn('back', '修改成功', 1);exit;

			} else {
				ajaxReturn('修改失败', 0);exit;
			}

		}
		include $this->loadWidget('franchiseeTheme');
	}

	/*
	 * 商品分类
	 */
	public function category() {

		$this->leftpos = 0;
		$this->loadHelper('arrayHelper');
		$this->loadHelper('extend');
		$this->loadModel('franchisee', 'category');
		$token = $this->info['token'];
		$sql = "select * from franchisee_category  where token ='" . $token . "' order by sort";
		$re = $this->franchisee->categoryModel->fetchAll($sql);
		//print_r($re);
		$result = toTree($re, 'uuid', 'parentuuid', 'childs');
		//拖动排序
		if ($_POST) {
			$orderby = $_POST;
			foreach ($orderby['orderby'] as $k => $v) {
				$r = $this->franchisee->categoryModel->update("sort='" . $k . "'", "id='" . $v . "'");
			}
		}
		include $this->loadWidget('franchiseeTheme');
	}

	//显示添加文章分类页面
	public function categoryadd() {
		$this->loadHelper('arrayHelper');
		$this->loadHelper('extend');
		$this->loadModel('franchisee', 'category');

		$uuid = $_GET['id'];

		$action = '';
		$data['action'] = '';
		$data['token'] = $this->info['token'];
		$data['id'] = $uuid;
		$html = $this->loadAjaxView('goods/category_edit', $data);

		ajaxReturn($html, '', 1);

	}
	//添加文章分类
	public function categoryinsert() {
		$this->loadHelper('extend');
		$this->loadModel('franchisee', 'category');
		$cookieid = $this->info['id'];

		$data = $_POST['data'];
		$data['token'] = $this->info['token'];
		$data['uuid'] = 'uuid()';
		if (isset($data['title']) && empty($data['title'])) {
			ajaxReturn('', '名称不能为空', 0);exit;
		}
		$data['parentuuid'] = $_POST['categoryuuid'] == "root" ? 0 : $_POST['categoryuuid'];

		$line = $this->franchisee->categoryModel->insert($data);
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
		$this->loadModel('franchisee', 'category');

		$id = $_GET['id'];
		$sql = "select * from franchisee_category where uuid='" . $id . "'";
		$info = $this->franchisee->categoryModel->fetchRow($sql);
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
		$this->loadModel('franchisee', 'category');
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
		$line = $this->franchisee->categoryModel->update($data, 'uuid="' . $_POST['categoryuuid'] . '"');
		if ($line) {
			ajaxReturn('', '修改成功', 1);
		} else {
			ajaxReturn('', '修改失败', 0);
		}

	}
	//删除分类
	public function categorydelete() {
		$this->loadHelper('extend');
		$this->loadModel('franchisee', 'category');
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		if ($id != 'root') {
			$line = $this->franchisee->categoryModel->delete("uuid='" . $id . "'");
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
		$this->loadModel('franchisee', 'order');
		$sql = "select * from franchisee_order order by id desc ";
		$result = $this->franchisee->orderModel->fetchAll($sql);
		$pageHtml = "";
		include $this->loadWidget('franchiseeTheme');

	}
	//添加采购申请
	public function addapply() {

		include $this->loadWidget('franchiseeTheme');
	}
	//插入采购申请
	public function insertapply() {
		$this->loadModel('franchisee', 'order');
		if ($_POST) {
			$this->loadHelper('extend');
			//$this->loadHelper('image');
			$data = $_POST['data'];

			$data['remark'] = $_POST['remark'];
			$data['uuid'] = 'uuid()';
			$data['token'] = $this->info['token'];
			$re = $this->franchisee->orderModel->insert($data);

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
		$this->loadModel('franchisee', 'order');
		$id = $_GET['id'];
		$sql = "select * from franchisee_order where id=$id";
		$result = $this->franchisee->orderModel->fetchRow($sql);
		include $this->loadWidget('franchiseeTheme');
	}
	//修改采购申请
	public function updateapply() {
		$this->loadModel('franchisee', 'order');
		if ($_POST) {
			$this->loadHelper('extend');
			//$this->loadHelper('image');
			$data = $_POST['data'];
			$id = $_POST['id'];
			$where = "id=$id and token='" . $this->info['token'] . "'";

			$re = $this->franchisee->orderModel->updae($data, $where);

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
		$this->loadModel('franchisee', 'order');
		$this->loadHelper('extend');

		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($id != '0') {
			$line = $this->franchisee->orderModel->delete("id=" . $id);
			if ($line) {
				ajaxReturn('', '删除成功', 1);
			} else {
				ajaxReturn('', '删除失败', 0);
			}
		}

	}

}