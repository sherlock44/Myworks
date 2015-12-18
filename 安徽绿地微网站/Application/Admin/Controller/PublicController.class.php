<?php
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller {

    //初始化
    function _initialize() {
        
    }
    
    //后台登陆界面
    public function login() {
        $this->display();
    }

    //后台登陆验证
    public function tologin() {
    	$username = isset($_POST['username']) ? trim($_POST['username']) : '';
    	$password = isset($_POST['password']) ? md5(trim($_POST['password'])) : '';
    	$code = isset($_POST['code']) ? trim($_POST['code']) : '';
    	if(empty($username) || empty($username) || empty($username)){
    		$this->error('参数错误~');
    	}
    	//检验验证码
    	$Verify = new \Think\Verify();
    	if(!$Verify->check($code)){
    		$this->error('验证码错误~');
    	}
    	$admin = M('admin');
    	$adminInfo = $admin->where(array('name'=>$username,'password'=>$password))->find();
    	if(!$adminInfo){
    		$this->error('账号不存在或者密码错误~');
    	}
    	//记录最后登陆信息
    	$admin->where(array('id'=>$adminInfo['id']))->save(array('lasttime'=>NOW_TIME,'ip'=>get_client_ip()));
    	session('user_auth',array('uid'=>$adminInfo['id'],'username'=>$adminInfo['username'],'lasttime'=>$adminInfo['lasttime']));    	
        $this->redirect('Index/index');
    }

    //退出登陆
    public function logout() {
    	session('[destroy]');
        $this->redirect('Public/login');
    }

    //验证码
    public function Checkcode(){
        $config =    array(    
            'fontSize'    =>    18,    // 验证码字体大小    
            'length'      =>    4,     // 验证码位数    
            'useNoise'    =>    false, // 关闭验证码杂点
            'bg'          =>    array(255, 255, 255),
             'imageW'      =>    130,
            'imageH'      =>    34,
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }
}