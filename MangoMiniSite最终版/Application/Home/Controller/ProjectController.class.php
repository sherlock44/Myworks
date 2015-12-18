<?php
namespace Home\Controller;
use Think\Controller;
class ProjectController extends Controller {
    public function index(){
		$news  =   M('anli');
		$datas = $news->limit(6)->select();
		$this->data = $datas;
        $this->display();
    }
	public function more(){
		$news  =   M('anli');
		$data = $news->select();
		$data = array_slice($data, 6);
        $this->ajaxReturn($data);
	}
	public function morelink(){
		$news  =   M('anli');
		$data = $news->select();
		$length['count'] = sizeof($data);
        $this->ajaxReturn($length);
	}
	public function many(){
		$map['id'] = $_POST['id'];
		$anli  =   M('anli');
		$many = $anli->where($map)->getField('many');
		
		$data['many'] = $many+1;
		$anli->create();
		$result = $anli->where($map)->save($data);
		$data['res'] = $result;
		$this->ajaxReturn($data);
	}
	public function detail(){
		$map['id'] = $_GET['id'];
		$anli  =   M('anli');
		$de = $anli->where($map)->select();
		$this->data = $de;
        $this->display();
	}
}