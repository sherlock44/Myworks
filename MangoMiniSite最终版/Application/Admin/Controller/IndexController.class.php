<?php
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminBase;
class IndexController extends AdminBase {
    public function index(){
        $this->display();
    }
}