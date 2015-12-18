<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display();
    }
	public function page7(){
		$weekarray=array("日","一","二","三","四","五","六");
		$this->week = "星期".$weekarray[date("w")];
		$this->nowdate = date("Y年n月d日");

		$news  =   M('news');
		$datas = $news->where(array('top'=>1))->select();
		$this->data = $datas;
		$this->display();
	}
	public function insert(){
		$map['name'] = $_POST['name'];
		$map['tel'] = $_POST['tel'];
		$map['lookTime'] = $_POST['lt'];
		$map['project'] = $_POST['project'];
		$map['cTime'] = time();

		$yuyue  =   M('yuyue');
		
		$result = $yuyue->data($map)->add();

		var_dump($result);
		exit;
		$data['res'] = $result;
		$this->ajaxReturn(json_encode($data));
	}
}