<?php
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminBase;
class AdminController extends AdminBase{
	public function index()
	{
		$this->redirect('Admin/edit');
	}
	//加载修改管理员密码界面
	public function edit()
	{
		$admin = M('admin');
		$adminInfo = $admin->where(array('id'=>UID))->find();
		$this->assign('adminInfo',$adminInfo);
		$this->display();
	}
	public function update()
	{
		$oldpassword = isset($_POST['oldpassword']) ? md5(trim($_POST['oldpassword'])) : '';
		$password = isset($_POST['password']) ? md5(trim($_POST['password'])) : '';
		$repassword = isset($_POST['repassword']) ? md5(trim($_POST['repassword'])) : '';
		if(empty($oldpassword) || empty($password) || empty($repassword)){
			$this->error('参数错误~');
		}
		if($password != $repassword){
			$this->error('两次密码输入不一致');
		}
		$admin = M('admin');
		if(!$admin->where(array('id'=>UID,'password'=>$oldpassword))->find()){
			$this->error('旧密码输入错误');
		}
		$admin->where(array('id'=>UID))->setField('password',$password);
		$this->success('修改密码成功');
	}
}