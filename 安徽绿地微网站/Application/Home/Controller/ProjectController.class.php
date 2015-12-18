<?php
namespace Home\Controller;
use Think\Controller;
class ProjectController extends Controller {
    public function anli(){
		$news  =   M('anli');
		$datas = $news->limit(2)->where(array('top'=>1))->select();
		$this->data = $datas;
		$datas2 = $news->limit(2,2)->where(array('top'=>1))->select();
		$this->data2 = $datas2;
		$this->display();
    }
    public function anliNum(){
		$news  =   M('anli');
		$data = $news->where(array('top'=>1))->select();
        $this->ajaxReturn($data);
	}
    public function product(){
		$news  =   M('anli');
		$datas = $news->limit(2)->where(array('top'=>0))->select();
		$this->data = $datas;
		$datas2 = $news->limit(2,2)->where(array('top'=>0))->select();
		$this->data2 = $datas2;
		$this->display();
    }
	public function more(){
		$news  =   M('anli');
		$data = $news->where(array('top'=>$_GET['top']))->select();
		$data = array_slice($data, 4);
        $this->ajaxReturn($data);
	}
	public function morelink(){
		$news  =   M('anli');
		$data = $news->where(array('top'=>$_GET['top']))->select();
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
	public function index(){
		$this->display();
	}
}