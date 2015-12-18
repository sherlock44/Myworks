<?php

// +----------------------------------------------------------------------
// | 后台Controller
// +----------------------------------------------------------------------

namespace Common\Controller;

use Think\Controller;

//定义是后台
define('IN_ADMIN', true);

class AdminBase extends Controller {

    //初始化
    protected function _initialize() {
        //默认跳转时间
        //$this->assign("waitSecond", 3000);
    	$user = session('user_auth');
    	if (empty($user)) {
    		$this->redirect('Public/login');
    	} else {
    		define('UID',$user['uid']);
    	}
    }

}