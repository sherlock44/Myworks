<?php
/*
 * 首页
 * david.yan (david.yan@qq.com) by 2013
 * 北京泰和盈动科技有公司 版权所有
 */
class index extends actionAbstract {

	public $title = '';
	public $css = array();
	public $modules = array();
	public $menu = array();
	public $pos = 0;
	public $type = 0;
	public $leftpos = 0;

	/*
	 * 构造
	 */
	function __construct() {
		parent::__construct();
		//var_dump(acl::getCookie('admininfo'));exit;

		if (!isset($_SESSION['admininfo'])) {header('location:' . $this->url('common/login'));}$this->info = $_SESSION['admininfo'];

		$this->menu = $this->loadConfig();
		$this->type = isset($_GET['type']) ? (int) $_GET['type'] : 0;
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			//ajax request
			$this->checkpower();
		}
	}

	public function main() {
		$this->leftpos = 0;
		//查看未完成订单
		$this->loadModel('franchisee', 'card');
		$this->loadModel('franchisee', 'order');
		$sql = "select * from franchisee_order where status>=0 and status<5  ";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		//退货订单
		$this->loadModel('franchisee', 'orderback');
		$orderbacknum = $this->franchisee->orderbackModel->selectCnt(" status>=1 ");
		//已处理订单
		$donenum = $this->franchisee->orderModel->selectCnt(" status=5 ");
		//已发货订单
		$sendnum = $this->franchisee->orderModel->selectCnt(" status=3 ");
		//已开通会员
		$cardnum = $this->franchisee->cardModel->selectCnt(" status=1 ");

		//加盟商
		$this->loadModel('franchisee', 'alliance');
		$franchiseenum = $this->franchisee->allianceModel->selectCnt(" status=1 ");
		$conf = $this->loadConfig('sysconf');

		//待处理采购
		$this->loadModel('product', 'apply');
		$sql = "select pa.*,sa.name as cgname,zg.name as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid order by pa.id desc ";
		$cash = $this->product->applyModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');

	}
	//我的站内信息
	//用户查看接收的站内信
	public function mywebInfo() {
		$this->leftpos = 6;
		$se = $this->info;
		$this->loadModel('product', 'webinfouser');
		$this->loadModel('product', 'webinfo');
		$sql = "select pwer.* ,pw.time,sa.truename,pw.title
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
				ajaxReturn('General/user', '保存成功', 0);exit;
			} else {
				ajaxReturn('back', '保存失败', 0);exit;
			}
		} else {
			echo '<script>alert("访问方式不正确"); </script>';
			header("Location: http://localhost");
		}
	}
	//财务角色--首页
	public function maincaiwu() {
		$this->leftpos = 0;
		//查看未完成订单
		$this->loadModel('franchisee', 'card');
		$this->loadModel('franchisee', 'order');
		$sql = "select fo.*,fa.shoppname from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where  fo.status=2";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		//退货订单
		$this->loadModel('franchisee', 'orderback');
		$sql = "select * from franchisee_order where backstatus=4 ";
		$orderback = $this->franchisee->orderbackModel->fetchAll($sql);
		

		
		$conf = $this->loadConfig('sysconf');

		//待处理采购
		$this->loadModel('product', 'apply');
		$sql = "select pa.*,sa.name as cgname,zg.name as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid where pa.status=5 or pa.status=9  order by pa.id desc ";
		$cash = $this->product->applyModel->fetchAll($sql);
//待处理采购计划
		$this->loadModel('product', 'apply');
		$sql = "select pa.*,sa.name as cgname,zg.name as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid where pa.memberid=" . $this->info['id']  . " and pa.status=0 or pa.zgid=" . $this->info['id'] . " and pa.status=1 order by pa.id desc ";
		$cashplan = $this->product->applyModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');

	}
	//销信角色--首页
	public function mainxiaoshao() {
		$this->leftpos = 0;
		//查看未完成订单
		$this->loadModel('franchisee', 'card');
		$this->loadModel('franchisee', 'order');
		$sql = "select fo.*,fa.shoppname from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token  where fo.token in(select token from franchisee_alliance  where userid=" . $this->info['id'] . ") and fo.status=0";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		//退货订单
		$this->loadModel('franchisee', 'orderback');
		$sql = "select * from franchisee_order where  ( orderbackstatus>0 and ( backstatus=3 or  backstatus=0) and userid=" . $this->info['id'] . ") or (  backdirectorid=" . $this->info['id'] . " and backstatus=1 )";
		$orderback = $this->franchisee->orderbackModel->fetchAll($sql);
		

		//加盟商
		$this->loadModel('franchisee', 'alliance');
		$franchiseenum = $this->franchisee->allianceModel->selectCnt(" status=1 and userid=".$this->info['id']);
		$conf = $this->loadConfig('sysconf');

		//待处理采购
		$this->loadModel('product', 'apply');
		$sql = "select pa.*,sa.name as cgname,zg.name as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid where pa.memberid=" . $this->info['id']  . " and pa.status=0 or pa.zgid=" . $this->info['id'] . " and pa.status=1 order by pa.id desc ";
		$cash = $this->product->applyModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');

	}
	//库房角色--首页
	public function mainhouse() {
		$this->leftpos = 0;
		//查看未完成订单
		$this->loadModel('franchisee', 'card');
		$this->loadModel('franchisee', 'order');
		$sql = "select fo.*,fa.shoppname from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where  fo.status=4 or fo.status=5";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		//退货订单
		$this->loadModel('franchisee', 'orderback');
		$sql = "select * from franchisee_order where backstatus=2 or backstatus=5 ";
		$orderback = $this->franchisee->orderbackModel->fetchAll($sql);
		

		
		$conf = $this->loadConfig('sysconf');

		//待处理采购
		$this->loadModel('product', 'apply');
		$sql = "select pa.*,sa.name as cgname,zg.name as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid where pa.status=7 or pa.status=10  order by pa.id desc ";
		$cash = $this->product->applyModel->fetchAll($sql);
//待处理采购计划
		$this->loadModel('product', 'apply');
		$sql = "select pa.*,sa.name as cgname,zg.name as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid where pa.memberid=" . $this->info['id']  . " and pa.status=0 or pa.zgid=" . $this->info['id'] . " and pa.status=1 order by pa.id desc ";
		$cashplan = $this->product->applyModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');

	}
	//采购角色--首页
	public function maincaigou() {
		$this->leftpos = 0;
		//查看未完成订单
		$this->loadModel('franchisee', 'card');
		$this->loadModel('franchisee', 'order');
		
		

		
		$conf = $this->loadConfig('sysconf');

		//待处理采购
		$this->loadModel('product', 'apply');
		$sql = "select pa.*,sa.name as cgname,zg.name as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid where pa.status in(2,4,3,6,8)  order by pa.created asc ";
		$cash = $this->product->applyModel->fetchAll($sql);
		//待处理采购计划
		$this->loadModel('product', 'apply');
		$sql = "select pa.*,sa.name as cgname,zg.name as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid where pa.memberid=" . $this->info['id']  . " and pa.status=0 or pa.zgid=" . $this->info['id'] . " and pa.status=1 order by pa.id desc ";
		
		$cashplan = $this->product->applyModel->fetchAll($sql);
		include $this->loadWidget('amdinlteTheme');

	}
	//客服角色--首页
	public function mainkefu() {
		$this->leftpos = 0;
		//查看未完成订单
		$this->loadModel('franchisee', 'card');
		$this->loadModel('franchisee', 'order');
		$sql = "select fo.*,fa.shoppname from franchisee_order as fo left join franchisee_alliance as fa on fa.token=fo.token where fo.status=0 or fo.status=1";
		$re = $this->franchisee->orderModel->fetchAll($sql);
		//退货订单
		$this->loadModel('franchisee', 'orderback');
		$sql = "select * from franchisee_order where  ( orderbackstatus>0 and ( backstatus=3 or  backstatus=0) and userid=" . $this->info['id'] . ") or (  backdirectorid=" . $this->info['id'] . " and backstatus=1 )";
		$orderback = $this->franchisee->orderbackModel->fetchAll($sql);
		

		//加盟商
		$this->loadModel('franchisee', 'alliance');
		$franchiseenum = $this->franchisee->allianceModel->selectCnt(" status=1 and userid=".$this->info['id']);
		$conf = $this->loadConfig('sysconf');

		//待处理采购
		$this->loadModel('product', 'apply');
		$sql = "select pa.*,sa.name as cgname,zg.name as zgname from product_apply as pa left join system_admin as sa on sa.id=pa.memberid left join system_admin as zg on zg.id=pa.zgid where pa.memberid=" . $this->info['id']  . " and pa.status=0 or pa.zgid=" . $this->info['id'] . " and pa.status=1 order by pa.id desc ";
		
		$cashplan = $this->product->applyModel->fetchAll($sql);

		include $this->loadWidget('amdinlteTheme');

	}
	//商品导出
	public function goodsout(){
		$this->loadModel('product', 'goods');
		$sql	=	"select uuid,barcode,title,categoryuuid,pingyincode from product_goods ";
		$re		=	$this->product->goodsModel->fetchAll($sql);
		 header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=商品信息表-".date('Y-m-d',time()).".xls");//定义生成的文件名
		    echo iconv("utf-8","gbk",'uuid')."\t";
            echo iconv("utf-8","gbk",'商品条码')."\t";
            echo iconv("utf-8","gbk",'商品名称')."\t";
            echo iconv("utf-8","gbk",'拼音码')."\t";
            echo iconv("utf-8","gbk",'商品分类')."\t";
			    foreach($re as $v){
     
      
       echo "\n";
                echo iconv("utf-8","gbk",$v['uuid'])."\t";
                echo iconv("utf-8","gbk",$v['barcode'])."\t";
                echo iconv("utf-8","gbk",$v['title'].'')."\t";
                echo iconv("utf-8","gbk",$v['pingyincode'])."\t";
                echo iconv("utf-8","gbk",$v['categoryuuid'])."\t";
     }
    exit;
	}
	//加盟商商品与本地对比给出结果
	public function pararegoods(){
		$this->loadModel('product', 'goods');
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
			//将文件中的数据读取出来存放在一个数组中
			$newre	=	array();
			$k=0;
			header("Content-type:application/vnd.ms-excel");
			header("Content-Disposition:attachment;filename=商品对比结果信息表-".date('Y-m-d',time()).".xls");//定义生成的文件名
			echo iconv("utf-8","gbk",'原商品uuid')."\t";
            echo iconv("utf-8","gbk",'商品条码')."\t";
            echo iconv("utf-8","gbk",'商品名称')."\t";
            echo iconv("utf-8","gbk",'拼音码')."\t";
            echo iconv("utf-8","gbk",'商品分类')."\t";
            echo iconv("utf-8","gbk",'现商品uuid')."\t";
            echo iconv("utf-8","gbk",'同条码商品数')."\t";
			for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
				$newre[$k]['olduuid']=@$data->sheets[0]['cells'][$i][1];
				$newre[$k]['barcode']=@$data->sheets[0]['cells'][$i][2];
				$newre[$k]['title']=@$data->sheets[0]['cells'][$i][3];
				$newre[$k]['pingyincode']=@$data->sheets[0]['cells'][$i][4];
				$newre[$k]['categoryuuid']=@$data->sheets[0]['cells'][$i][5];
				//从数据库查询该uuid
				$sql	=	"select uuid from product_goods where barcode='".$newre[$k]['barcode']."'";
				$re		=	$this->product->goodsModel->fetchAll($sql);
				$newre[$k]['newuuid']=$re?$re[0]['uuid']:'';
				$newre[$k]['num']=count($re);
				
				    echo "\n";
                echo iconv("utf-8","gbk",$newre[$k]['olduuid'])."\t";
                echo iconv("utf-8","gbk",$newre[$k]['barcode'])."\t";
                echo iconv("utf-8","gbk",$newre[$k]['title'].'')."\t";
                echo iconv("utf-8","gbk",$newre[$k]['pingyincode'])."\t";
                echo iconv("utf-8","gbk",$newre[$k]['categoryuuid'])."\t";
                echo iconv("utf-8","gbk",$newre[$k]['newuuid'])."\t";
                echo iconv("utf-8","gbk",$newre[$k]['num'])."\t";
				
				$k++;
			}
		exit;
		
		}
		include $this->loadWidget('amdinlteTheme');
	}
	//同步商品图片 
	
	function getfiles($path){ 
		foreach(scandir(ROOT_PATH.$path) as $afile)
		{
		if($afile=='.'||$afile=='..') continue; 
		if(is_dir(ROOT_PATH.$path.'/'.$afile)) 
		{ 
		$this->getfiles($path.'/'.$afile); 
		} else { 
			//echo $path.'/'.$afile.'<br />'; 
			$arr	=	explode(".",$afile);
			//print_r($arr);
			if(isset($arr[0])){
				//$sql	=	"select id from product_goods where erpcode='".$arr[0]."'";
				$this->product->goodsModel->update(array('imgpath'=>$path.'/'.$afile),"erpcode='".$arr[0]."'");
			}else{
				echo $path.'/'.$afile.'未导入<br />'; 
			}
		} 
		} 
	} 
		
	public function goodsimg(){ 
		$this->loadModel('product', 'goods');
			$dir	=	"/data/goods";
			//$dir1	=	"/data/goods/test/logo-big.png";
			set_time_limit(0);
			$this->getfiles($dir);
			echo "导入完成";
	} 
	//加盟商会员订单消费扣钱---仅用一次
	public function onlyonecarduse() {
		
		$this->loadModel('franchisee', 'alliance');
		$sql	=	"select token from franchisee_alliance ";
		$re		=	$this->franchisee->allianceModel->fetchAll($sql);
		$this->loadModel('financial', 'synctype');
		$i=0;
		$insertsql = "insert into financial_synctype(token,keytype) values";
		foreach($re as $k=>$val){
			if($i==0){
			$insertsql.= "('" . $val['token'] . "','usercarduse')";
			}else{
			$insertsql .= ",('" . $val['token'] . "','usercarduse')";
			}
			$i++;
		}
		$line=0;
		if($i>0){
		$line=$this->financial->synctypeModel->sqlexec($insertsql);
		//echo $insertsql;
		}
		if($line){
		echo "通知成功";
		}else{
		echo "通知失败";
		}
	}
	//将有保质期，但没库存的商品添加一个时间及库存
	public function pushtimegoods(){
		$date	=	"2017-10-05";
		$time	=	strtotime($date);
		$this->loadModel('product', 'goods');
		$this->loadModel('product', 'productontime');
		$sql	=	"select id,uuid,shelflife,number,title,erpcode,barcode from product_goods ";
		$re		=	$this->product->goodsModel->fetchAll($sql);
		foreach($re as $k=>$val){
			if($val['shelflife']>0){
				$sql="select * from product_productontime where goodsuuid='".$val['uuid']."'";
				$r	=	$this->product->productontimeModel->fetchAll($sql);
				if(!$r){
					$data	=	array();
					$data['goodsuuid']	=	$val['uuid'];
					$data['productontime']	=	$time;
					$data['num']	=	1000;
					$line	=	$this->product->productontimeModel->insert($data);
					if($line){
						echo $val['title'].'编码'.$val['erpcode'].'条码'.$val['barcode']."修改成功<br>";
					}else{
						echo $val['title'].'编码'.$val['erpcode'].'条码'.$val['barcode']."<span style='color:red;'>修改失败</span><br>";
					}
				}
				if(empty($val['number'])){
					$this->product->goodsModel->update(array('number'=>1000),"id=".$val['id']);
				}
			}else if(empty($val['number'])){
				$this->product->goodsModel->update(array('number'=>1000),"id=".$val['id']);
			
			}
		
		}
		echo "修改完成";
	}
	//通过订单ordernum 减掉库存 franchisee_orderinfoprepare
	public function removegoodsstore(){
		$this->loadModel('franchisee','orderinfoprepare');
		$this->loadModel('product','goods');
		$this->loadModel('product','productontime');
		$orderarray	=	array();
		$orderarray[]	=	'151123052812cc6b45';
		$orderarray[]	=	'151123044229521000';
		$orderarray[]	=	'151123044011bb4517';
		$orderarray[]	=	'151123041751f1a446';
		$orderarray[]	=	'151123034043bd64eb';
		$orderarray[]	=	'1511230332386505ba';
		$orderarray[]	=	'1511230311131c4161';
		$orderarray[]	=	'15112302584002b628';
		$orderarray[]	=	'151123025028485000';
		$ordernum	=	"";
		$sql	=	"select * from franchisee_orderinfoprepare where ordernum='".$ordernum."'";
		$re		=	$this->franchisee->orderinfoprepareModel->fetchAll($sql);
		foreach($re as $k=>$val){
			$data	=	array();$da	=	array();
			$sql	=	"update product_goods set  number=number-".$val['num']." where id=".$val['goodsid'];
			$this->product->goodsModel->sqlexec($sql);
			$sql	=	"select uuid from product_goods where id=".$val['goodsid'];
			$r		=	$this->product->goodsModel->fetchRow($sql);
			$sql	=	"update franchisee_orderinfoprepare set  num=num-".$val['num']." where productontime=".$val['productontime']." goodsuuid='".$r['uuid']."'";
			$this->product->productontimeModel->sqlexec($sql);
		}
	}
	//通过boxnum 得到以箱为单位的库存
	public function boxnum(){
		$this->loadModel('franchisee','orderinfoprepare');
		$this->loadModel('product','goods');
		$this->loadModel('product','productontime');
		$sql	=	"select id,uuid,boxnum,number from product_goods where boxnum>1";
		$re		=	$this->product->goodsModel->fetchAll($sql);
		$insertsql	=	"insert into product_goods(id,number) values";
		$insertnum	=	"insert into product_productontime(id,num) values";
		$i=0;
		$j=0;
		foreach($re as $k=>$val){
			if($k==0){
				$insertsql.="(".$val['id'].",".ceil($val['number']/$val['boxnum']).")";
			}else{
				$insertsql.=",(".$val['id'].",".ceil($val['number']/$val['boxnum']).")";
			}
			$j++;
			$sql	=	"select * from product_productontime where goodsuuid='".$val['uuid']."'";
			$r		=	$this->product->goodsModel->fetchAll($sql);
			if($r){
				
				foreach($r as $ke=>$ve){
					if($ve['num']<=0){continue;}
					if($i==0){
						$insertnum.="(".$ve['id'].",".ceil($ve['num']/$val['boxnum']).")";
					}else{
					$insertnum.=",(".$ve['id'].",".ceil($ve['num']/$val['boxnum']).")";
					}
					$i++;
				}
			}
		
		}
		if($j>0){
			$insertsql .= " on duplicate key update number=values(number)";
			// $l=$this->product->goodsModel->sqlexec($insertsql);
			// if(!$l){echo "修改失败goods";}
		}
		if($i>0){
			$insertnum .= " on duplicate key update num=values(num)";
			 $l=$this->product->productontimeModel->sqlexec($insertnum);
			  if(!$l){echo "修改失败productontime";}
		}
	
	}
	
}
?>