<?php
namespace Home\Controller;
use Think\Controller;
class YuyueController extends Controller {
	public function insert(){
		$map['name'] = $_POST['name'];
		$map['tel'] = $_POST['tel'];
		$map['lookTime'] = $_POST['lt'];
		$map['project'] = $_POST['project'];

		$news  =   M('news');
		
		$result = $news->add($map);
		$data['res'] = $result;
		$this->ajaxReturn($data);
	}
}