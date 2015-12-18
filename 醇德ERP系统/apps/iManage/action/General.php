<?php
/*
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */
class General extends actionAbstract {

	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 9;
	public $type = 0;
	public $leftpos = 0;
	public $like = "";
	public $where = "";
	public $filemenu = array();
	/*
	 * 构造
	 */
	function __construct() {
		parent::__construct();
		// $this->info = acl::checkLogin('admininfo',$this->url('common/login'));
		if (!isset($_SESSION['admininfo'])) {header('location:' . $this->url('common/login'));}$this->info = $_SESSION['admininfo'];
		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		$this->loadHelper('handleimage');
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			//ajax request
			$this->checkpower();
		}
	}
	//物流管理
	public function generalhome() {
		$this->leftpos = 11;
		$this->loadmodel('product', 'general');
		$this->loadHelper('extend');
		$this->loadHelper("pager");
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$size = 10;
		$offset = ($page - 1) * $size;
		$sql = "select count(*) from product_general " . $this->where . "";
		$count = $this->product->generalModel->fetchRow($sql);
		$count = $count["count(*)"];
		$number = ceil($count / $size);
		$extend = new pager();
		$pageHtml = $extend->outputadmin($number, $page, "", "", $count, $size);
		$sql = "select * from product_general " . $this->where . " limit " . $offset . "," . $size . "";
		$re = $this->product->generalModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//物流添加
	public function addgeneral() {
		$this->loadModel('product', 'general');
		$hem = $this->loadConfig('sysconf');
		$brand = $hem['typeone'];
		$sql = "select * from  product_general where status=1";
		$admin = $this->product->generalModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//插入物流
	public function insertshop() {
		$this->loadModel('product', 'general');
		if ($_POST) {
			$this->loadHelper('extend');
			$data = $_POST['data'];
			$re = $this->product->generalModel->insert($data);
			if ($re) {
				//日志
				$this->loadHelper('log');
				$logdata['title'] = '物流添加';
				$logdata['userid'] = $this->info['id'];
				$logdata['content'] = '添加物流基本信息';
				$log = new log();
				$log->logwrite($logdata);
				ajaxReturn('back', '添加成功', 1);exit;
			} else {
				ajaxReturn('back', '添加失败', 0);exit;
			}
		}
		include $this->loadWidget('amdinlteTheme');
	}
	/*
	 * 删除物流
	 */
	public function generaldel() {
		$this->leftpos = 3;
		$this->loadModel('product', 'general');
		$this->loadHelper('extend');
		if ($_GET) {
			$id = $_GET['id'];
			$re = $this->product->generalModel->delete('id=' . $id);
			if ($re) {
				ajaxReturn('back', '删除成功', 1);exit;

			}
		}
		include $this->loadWidget('amdinlteTheme');
	}
/*
 * 编辑物流
 */
	public function editgeneral() {
		$this->leftpos = 0;
		$this->loadModel('product', 'general');
		$this->loadHelper('extend');
		$hem = $this->loadConfig('sysconf');
		$brand = $hem['typeone'];
		$id = $_GET['id'];
		$sql = "select * from product_general where id=$id";
		$re = $this->product->generalModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//修改物流
	public function updategenral() {
		$this->loadModel('product', 'general');
		$this->loadHelper('extend');
		$hem = $this->loadConfig('sysconf');
		$brand = $hem['typeone'];
		$id = $_POST['id'];
		$data = $_POST['data'];
		$re = $this->product->generalModel->update($data, 'id=' . $id);
		if ($re) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('操作失败', 0);exit;
		}
	}
	//用户查看接收的站内信
	public function mywebInfo() {
		$this->leftpos = 6;
		$se = $this->info;
		$this->loadModel('product', 'webinfouser');
		$this->loadModel('product', 'webinfo');
		$sql = "select pwer.* ,pw.time,sa.truename
                from product_webinfouser as pwer
                join product_webinfo as pw on pw.id = pwer.webinfoid
                join system_admin as sa on sa.id    = pw.seuserid
                where pwer.reuserid = {$se['id']}";
		$re = $this->product->webinfouserModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//查看收到的站内信详情
	public function myskin() {
		$id = $_GET['id'];
		$this->loadModel('product', 'webinfouser');
		$sql = "select pwer.* ,(select truename from system_admin where id = pwer.reuserid ) as glynm ,
                (select truename from franchisee_alliance where token = pwer.token) as jmsnm,pw.time,pw.title,pw.content
                from product_webinfouser as pwer
                join product_webinfo as pw on pw.id = pwer.webinfoid
                where pwer.id = {$id}";
		$re = $this->product->webinfouserModel->fetchRow($sql);
		$data['sign'] = 2;
		$this->product->webinfouserModel->update($data, $id);
		include $this->loadWidget('amdinlteTheme');
	}
	//发送站内信息列表
	public function statWithinfo() {
		$this->leftpos = 5;
		$se = $this->info;
		$this->loadModel('product', 'webinfouser');
		$this->loadModel('product', 'webinfo');
		/*  $sql = "select pwer.* ,(select truename from system_admin where id = pwer.reuserid ) as glynm ,
		(select truename from franchisee_alliance where token = pwer.token) as jmsnm,pw.time
		from product_webinfouser as pwer
		join product_webinfo as pw on pw.id = pwer.webinfoid
		where pw.seuserid = {$se['id']}";
		$re  =  $this->product->webinfouserModel->fetchAll($sql); */
		$sql = "select pw.*,sa.name,(select count(*) from product_webinfouser where webinfoid=pw.id and sign=1) as noreadnum,(select count(*) from product_webinfouser where webinfoid=pw.id ) as readnum from product_webinfo as pw
                join system_admin as sa on sa.id = pw.seuserid
                where pw.seuserid = {$se['id']}";
		$rs = $this->product->webinfoModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');
	}
	//发送站内信息
	public function sendWithinfo() {
		if ($_POST) {
			$se = $this->info;
			$this->loadHelper('extend');
			$this->loadModel('product', 'webinfo');
			$this->loadModel('product', 'webinfouser');
			$data = $_POST['data'];
			$data['seuserid'] = $se['id'];
			$data['time'] = time();
			//检测接收用户不能为空
			if (!isset($_POST['ids']) && !isset($_POST['jmids'])) {
				ajaxReturn('back', '请选择至少一位接收用户', 0);exit;
			}
			$this->beginTransaction();
			//保存消息内容信息
			$bsid = $this->product->webinfoModel->insert($data);
			if (!$bsid) {
				$this->rollbackSql();
				ajaxReturn('back', '发送站内信息失败', 0);exit;
			}
			//发送给管理用户
			if (isset($_POST['ids']) && !empty($_POST['ids'])) {
				$ids = $_POST['ids'];
				foreach ($ids as $key => $value) {
					$glydt['reuserid'] = $value;
					$glydt['webinfoid'] = $bsid;
					$glydt['type'] = 1;
					$bk = $this->product->webinfouserModel->insert($glydt);
					if (!$bk) {
						$this->rollbackSql();
						ajaxReturn('back', '发送站内信息失败', 0);exit;
					}
				}
			}
			//发送给加盟商用户
			if (isset($_POST['jmids']) && !empty($_POST['jmids'])) {
				$ids = $_POST['jmids'];
				foreach ($ids as $key => $value) {
					$jmsdt['token'] = $value;
					$jmsdt['type'] = 2;
					$jmsdt['webinfoid'] = $bsid;
					$bk = $this->product->webinfouserModel->insert($jmsdt);
					if (!$bk) {
						$this->rollbackSql();
						ajaxReturn('back', '发送站内信息失败', 0);exit;
					}
				}
			}
			$this->beginCommit();
			ajaxReturn('back', '发送站内信息成功', 1);exit;
		} else {
			$this->leftpos = 5;
			$this->loadModel('system', 'admin');
			$this->loadModel('system', 'group');
			$this->loadModel('franchisee', 'alliance');
			$this->loadModel('crm', 'usertype');
			$se = $this->info;
			//管理用户
			$sql = "select * from system_admin where  status = 1";
			$re = $this->system->adminModel->fetchAll($sql);
			//加盟商
			$sql = "select * from franchisee_alliance where status = 1";
			$rs = $this->franchisee->allianceModel->fetchAll($sql);
			//var_dump($rs);exit;
			//用户角色组
			$sql = "select sg.* from system_admin as sa
                    join system_group as sg on sg.groupid=sa.groupid where sg.state=1 group by sa.groupid ";
			$grup = $this->system->groupModel->fetchAll($sql);
			//查询加盟商城市列表
			$sql = "select ar.id,ar.name from franchisee_alliance as fa
                    join area_region as ar on ar.id = fa.cityid
                    where fa.cityid>0 and fa.email!= '' group by fa.cityid ";
			$ctarr = $this->franchisee->allianceModel->fetchAll($sql);
			//查询客户类型
			$sql = "select * from crm_usertype";
			$kharr = $this->crm->usertypeModel->fetchAll($sql);
			include $this->loadWidget('amdinlteTheme');
		}
	}
	//删除站内信息
	public function delinfo() {
		$this->leftpos = 2;
		$this->loadHelper('extend');
		$this->loadModel('product', 'webinfo');
		$this->loadModel('product', 'webinfouser');
		if ($_GET) {
			$id = $_GET['id'];
			$where = "webinfoid = {$id}";
			$re = $this->product->webinfoModel->delete($id);
			$bkid = $this->product->webinfouserModel->delete($where);
			if ($re || $bkid) {
				ajaxReturn('', '删除成功', 1);exit;
			} else {
				ajaxReturn('', '删除失败', 0);exit;
			}
		} else {
			ajaxReturn('', '参数错误', 0);exit;

		}
	}

	//用户删除自己接收的站内信
	public function delMyinfo() {
		$this->leftpos = 2;
		$this->loadHelper('extend');
		$this->loadModel('product', 'webinfouser');
		if ($_GET) {
			$id = $_GET['id'];
			$re = $this->product->webinfouserModel->delete($id);
			if ($re) {
				ajaxReturn('', '删除成功', 1);exit;
			} else {
				ajaxReturn('', '删除失败', 0);exit;
			}
		}
	}
	//发送用户查看查看站内信息详情
	public function skin() {
		$id = $_GET['id'];
		$this->loadModel('product', 'webinfouser');
		$this->loadModel('product', 'webinfo');
		$sql = "select pwer.* ,(select name from system_admin where id = pwer.reuserid ) as glynm ,
                (select truename from franchisee_alliance where token = pwer.token) as jmsnm,pw.time,pw.title,pw.content
                from product_webinfouser as pwer
                join product_webinfo as pw on pw.id = pwer.webinfoid
                where pw.id = {$id}";
		$rs = $this->product->webinfouserModel->fetchAll($sql);
		$sql = "select * from product_webinfo where id = {$id}";
		$re = $this->product->webinfoModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//用户个人资料
	public function user() {
		$this->leftpos = 7;
		$se = $this->info;
		$this->loadModel('product', 'user');
		$sql = "select sa.*,sg.title from system_admin as sa left join system_group as sg on sg.groupid=sa.groupid where sa.id = {$se['id']}";
		$re = $this->product->userModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//保存用户信息
	public function saveuser() {
		if ($_POST) {
			$this->loadHelper('extend');
			$this->loadModel('system', 'admin');
			$data = $_POST['data'];
			if (!empty($_FILES['imagefile']['name'])) {
				$this->loadHelper('uploadport');
				$uploader = new uploadport();
				$data['imgpath'] = $uploader->start('imagefile');
			}
			$data['birthday'] = strtotime($data['birthday']);
			if ($_POST['password'] != "") {
				if ($_POST['password'] != $_POST['pwd']) {
					ajaxReturn('', '密码不一致', 0);exit;
				}
				if (strlen($_POST['pwd']) < 6 || strlen($_POST['pwd']) > 20) {
					ajaxReturn('', '请填写6到20位的密码', 0);exit;
				}
				$data['password'] = md5($_POST['pwd']);
			}
			$bk = $this->system->adminModel->update($data, $data['id']);
			//日志
			$this->loadHelper('log');
			$logdata['title'] = '修改信息';
			$logdata['userid'] = $data['id'];
			$logdata['content'] = '用户修改个人基本信息';
			$log = new log();
			$log->logwrite($logdata);
			if ($bk) {
				ajaxReturn('General/user', '保存成功', 1);exit;
			} else {
				ajaxReturn('back', '保存失败', 0);exit;
			}
		} else {
			echo '<script>alert("访问方式不正确"); </script>';
			header("Location: http://localhost");
		}
	}
	//文件下载
	/* public function fileone(){
	$id = $_GET['id'];
	$this->loadModel('product','upload');
	$sql ="select name,document from product_upload where id = '$id'";
	$re =  $this->product->uploadModel->fetchRow($sql);
	header("Content-Disposition: attachment; filename=".$re['document']);
	//readfile($re[0]['name']);
	exit;
	}    */

	/*   //文件下载
	public function uploadones(){
	$id = $_GET['id'];
	$this->loadModel('product','paganda');
	$sql ="select name,title from product_paganda where id = '$id'";
	$re =  $this->product->pagandaModel->fetchRow($sql);
	header("Content-Disposition: attachment; filename=".$re['title']);
	@readfile($re[0]['name']);
	exit;
	} */
	//显示全部发送内容信息
	public function maillist() {
		$this->leftpos = 1;
		$re = $this->info;
		$this->loadModel('system', 'emailuser');
		$sql = "select sem.*,se.title,se.time,(select truename from system_admin where id = sem.reuserid ) as glynm ,
             (select truename from franchisee_alliance where token = sem.reuserid) as jmsnm,
             (select truename from user_basicprofile where userid = sem.reuserid) as scnm,(select count(*) from system_emailuser where emaid=se.id) as emailnum
             from system_emailuser as sem
             join system_email as se on se.id = sem.emaid
             where se.seuserid = {$re['id']}";

		$rs = $this->system->emailuserModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//删除邮件列表信息
	public function delema() {
		$this->leftpos = 2;
		$this->loadHelper('extend');
		$this->loadModel('system', 'emailuser');
		if ($_GET) {
			$id = $_GET['id'];
			$re = $this->system->emailuserModel->delete($id);
			if ($re) {
				ajaxReturn('', '删除成功', 1);exit;
			} else {
				ajaxReturn('', '删除失败', 0);exit;
			}
		}
	}
	//查看邮件详情
	public function emaskin() {
		$id = $_GET['id'];
		$this->loadModel('system', 'emailuser');
		$sql = "select se.* from system_emailuser as sem
                join  system_email as se on se.id = sem.emaid
                where sem.id = {$id}";
		$re = $this->system->emailuserModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//发送邮件
	public function senDmail() {
		if ($_POST) {
			set_time_limit(0);
			$this->loadModel('system', 'admin');
			$this->loadModel('system', 'setting');
			$this->loadModel('product', 'user');
			$this->loadModel('franchisee', 'alliance');
			$this->loadModel('product', 'user');
			$this->loadModel('user', 'basic');
			$this->loadModel('system', 'email');
			$this->loadModel('system', 'emailuser');
			$this->loadHelper('extend');
			$rcemail = array();
			$index = 0;
			$re = $this->info;
			//内部员工
			if (isset($_POST['nbyg']) && !empty($_POST['nbyg'])) {
				foreach ($_POST['nbyg'] as $key => $value) {
					$sql = "select email from system_admin where id = {$value}";
					$ygem = $this->system->adminModel->fetchRow($sql);
					$rcemail[$index]['eml'] = $ygem['email'];
					$rcemail[$index]['userid'] = $value;
					$rcemail[$index]['type'] = 2;
					$index++;
				}
			}
			//加盟商
			if (isset($_POST['jms']) && !empty($_POST['jms'])) {
				foreach ($_POST['jms'] as $key => $value) {
					$sql = "select email from franchisee_alliance where id = {$value}";
					$ygem = $this->franchisee->allianceModel->fetchRow($sql);
					$rcemail[$index]['eml'] = $ygem['email'];
					$rcemail[$index]['userid'] = $value;
					$rcemail[$index]['type'] = 3;
					$index++;
				}
			}
			if (empty($rcemail)) {
				ajaxReturn('back', '请选择至少一个收件人邮箱', 0);exit;
			}
			//smtp配置
			$sql = "select * from system_setting";
			$set = $this->system->settingModel->fetchAll($sql);
			$this->loadHelper('encrypt');
			$en = new encrypt();
			$this->loadHelper('extend');
			$this->loadHelper('smtp');
			$data = $_POST['data'];
			$smtpserver = $set[4]['value'];
			$smtpserverport = $set[5]['value'];
			$smtpusermail = $set[6]['value'];
			$temparr = explode('@', $smtpusermail);
			$smtpuser = $temparr[0];
			$smtppass = $en->decode($set[8]['value']);
			/*
			$smtpserver     = "smtp.163.com";//服务器
			$smtpserverport = 25;//服务器端口
			$smtpusermail   = "voidlh@163.com";//服务器邮箱
			$smtpuser       = "voidlh";//
			$smtppass       = "lh2806190";
			 */
			//收件人
			//$smtpemailto = $data['email'];
			//邮件主题
			$mailsubject = $data['title'];
			//邮件内容
			$mailbody = $_POST['remark'];
			//邮件格式（HTML/TXT）,TXT为文本邮件
			$mailtype = "HTML";
			//这里面的一个true是表示使用身份验证,否则不使用身份验证.
			$smtp = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
			//保存邮件信息内容
			$this->beginTransaction();
			$bsdt['title'] = $data['title'];
			$bsdt['content'] = $_POST['remark'];
			$bsdt['seuserid'] = $re['id'];
			$bsdt['time'] = time();
			$bsid = $this->system->emailModel->insert($bsdt);
			if (!$bsid) {
				$this->rollbackSql();
				ajaxReturn('back', '发送失败', 0);exit;
			}
			foreach ($rcemail as $key => $value) {
				$re = $smtp->sendmail($value['eml'], $smtpusermail, $mailsubject, $mailbody, $mailtype);
				if ($re) {
					$usdt['reuserid'] = $value['userid'];
					$usdt['emaid'] = $bsid;
					$usdt['type'] = $value['type'];
					$usid = $this->system->emailuserModel->insert($usdt);
					//$this->rollbackSql();
					//ajaxReturn ( 'back', '发送失败', 0 );exit;
				} else {
					$this->rollbackSql();
					ajaxReturn('back', '发送失败', 0);exit;
				}
			}
			$this->beginCommit();
			ajaxReturn('back', '发送成功', 1);exit;
		} else {
			$this->leftpos = 1;
			$se = $this->info;
			$this->loadModel('system', 'admin');
			$this->loadModel('franchisee', 'alliance');
			$this->loadModel('system', 'group');
			$this->loadModel('crm', 'usertype');
			$this->loadHelper('extend');
			//内部员工
			$sql = "select * from system_admin where email!=''";
			$re = $this->system->adminModel->fetchAll($sql);
			//加盟商
			$sql = "select email,truename,cityid,supplytypeid,id from franchisee_alliance where email!=''";
			$rs = $this->franchisee->allianceModel->fetchAll($sql);
			//用户角色组
			$sql = "select sg.* from system_admin as sa
                 join system_group as sg on sg.groupid=sa.groupid where sg.state=1 and sa.email!='' group by sa.groupid ";
			$grup = $this->system->groupModel->fetchAll($sql);
			//查询加盟商城市列表
			$sql = "select ar.id,ar.name from franchisee_alliance as fa
                join area_region as ar on ar.id = fa.cityid
                where fa.cityid>0 and fa.email!= '' group by fa.cityid ";
			$ctarr = $this->franchisee->allianceModel->fetchAll($sql);
			//查询客户类型
			$sql = "select * from crm_usertype";
			$kharr = $this->crm->usertypeModel->fetchAll($sql);
			//发送目标用户类型
			$type = 1;
			if (isset($_GET['sdtype']) && !empty($_GET['sdtype'])) {
				if (in_array($_GET['sdtype'], array(1, 2))) {
					$type = $_GET['sdtype'];
				}
			}
			include $this->loadWidget('amdinlteTheme');
		}
	}
	//文件管理
	public function filemanage() {
		//查询分类
		$cateid = isset($_GET['id']) ? $_GET['id'] : 0;
		$this->loadModel('product', 'updatecategory');
		$sql = "select * from product_updatecategory where parentid=" . $cateid . " order by sort desc";
		$category = $this->product->updatecategoryModel->fetchAll($sql);
		$this->loadModel('product', 'upload');
		//查询文件
		$sql = "select * from product_upload where categoryid=$cateid ";
		$re = $this->product->uploadModel->fetchAll($sql);
		//查看当前目录
		//$this->filemenu	=	array();
		//$this->filemenu[]	=	array('id'=>0,'title'=>'根目录');
		if ($cateid == 0) {
			$filename = "根目录";
		} else {
			$sql = "select id,title from product_updatecategory where id=" . $cateid;
			$root = $this->product->updatecategoryModel->fetchRow($sql);
			$filename = $root['title'];
		}
		$this->getrootcategory($cateid);

		include $this->loadWidget('amdinlteTheme');
	}
	//根据目录id查询到根目录
	public function getrootcategory($id) {
		if ($id == 0) {
			$this->filemenu[] = array('id' => 0, 'title' => '根目录');
			return true;
		}
		$this->loadModel('product', 'updatecategory');
		$sql = "select id,title,parentid from product_updatecategory where id=" . $id;
		$root = $this->product->updatecategoryModel->fetchRow($sql);
		//if($root['parentid']!=0){
		$this->getrootcategory($root['parentid']);
		//}
		$this->filemenu[] = array('id' => $root['id'], 'title' => $root['title']);

	}
	//新加分类
	public function addfilecategory() {
		$parentid = $_GET['cateid'];

		$this->getrootcategory($parentid);
		include $this->loadWidget('amdinlteTheme');
	}
	//插入分类
	public function insertcategory() {

		$this->loadHelper('extend');
		$this->loadModel('product', 'updatecategory');
		$data = $_POST['data'];
		$line = $this->product->updatecategoryModel->insert($data);
		if ($line) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	//编辑分类
	public function editcategory() {
		$id = $_GET['id'];
		$this->loadModel('product', 'updatecategory');
		$sql = "select * from product_updatecategory where id=$id";
		$re = $this->product->updatecategoryModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//修改分类
	public function updatecategory() {
		$this->loadHelper('extend');
		$this->loadModel('product', 'updatecategory');
		$data = $_POST['data'];
		$id = $_POST['id'];
		$line = $this->product->updatecategoryModel->update($data, 'id=' . $id);
		if ($line) {
			ajaxReturn('back', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	//删除目录
	public function delcategory() {
		$cateid = $_GET['id'];
		$this->loadHelper('extend');
		$this->loadModel('product', 'updatecategory');
		//查看有没有子目录，及有没有子文件
		$sql = "select * from product_updatecategory where parentid=$cateid";
		$re = $this->product->updatecategoryModel->fetchRow($sql);
		if ($re) {
			ajaxReturn('', '该目录下有子目录，删除失败', 0);exit;
		}
		//查看有没有文件
		$sql = "select * from product_upload where categoryid=$cateid";
		$re = $this->product->updatecategoryModel->fetchRow($sql);
		if ($re) {
			ajaxReturn('', '该目录下有子文件，删除失败', 0);exit;
		}
		$line = $this->product->updatecategoryModel->delete("id=" . $cateid);
		if ($line) {
			ajaxReturn('', '操作成功', 1);exit;
		} else {
			ajaxReturn('', '操作失败', 0);exit;
		}
	}
	public function uploadons() {
		$this->loadModel('product', 'upload');
		$this->loadHelper('extend');
		$id = $_GET['id'];
		$sql = "select * from product_upload where id=$id";
		$re = $this->product->uploadModel->fetchRow($sql);
		include $this->loadWidget('amdinlteTheme');
	}
	//添加文件
	public function Fileupload() {
		$this->leftpos = 9;
		$categoryid = $_GET['cateid'];
		$this->loadModel('product', 'upload');
		$this->getrootcategory($categoryid);
		include $this->loadWidget('amdinlteTheme');

	}
	/*
	 * 上传文件
	 */

	public function filupload() {
		$this->leftpos = 1;
		$this->loadModel('product', 'upload');
		if ($_POST) {
			$this->loadHelper('extend');
			$data = $_POST['data'];
			$data['time'] = date('Y-m-d H:i:s', time());
			if (!empty($_FILES['document']['name'])) {
				$this->loadHelper('uploaderone');
				$uploader = new uploader();
				$data['document'] = $uploader->start('document');
			} else {
				ajaxReturn('back', '未上传文件', 0);
			}
			$line = $this->product->uploadModel->insert($data);
			if ($line) {
				ajaxReturn('back', '操作成功', 1);
			} else {
				ajaxReturn('back', '操作失败', 0);
			}

		}

	}

	//删除文档
	public function delupload() {
		$this->leftpos = 6;
		$this->loadModel('product', 'upload');
		$this->loadHelper('extend');
		if ($_GET) {
			$id = $_GET['id'];

			$line = $this->product->uploadModel->delete('id=' . $id);
			if ($line) {
				ajaxReturn('', '操作成功', 1);
			} else {
				ajaxReturn('', '操作失败', 0);
			}
		}
	}

}
