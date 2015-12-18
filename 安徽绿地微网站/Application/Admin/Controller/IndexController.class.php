<?php
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminBase;
use Think\Page;
class IndexController extends AdminBase {
    public function index(){
        $yuyue = M('yuyue');
		$count = $yuyue->count();
		$Page = new Page($count);
		$this->assign('pager',$Page->show());
		$list = $yuyue->order('id')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('data',$list);
		$this->display();
    }
}