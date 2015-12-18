<?php
/**
 * 全局常量的写义,一般定义合站都可能使用到的常量,对于备功能部分的常量,则在各功能模块内有定义的函数进行定义
 *
 * author:David Yan(david.yan@qq.com)
 * @version $Id: Define.php  2008-03-24 23:00:00Z David Yan $
 *
 */

/**
 * 定义默认Controller
 */
define('DEFAULT_CONTROLLER', 'index');

/**
 * 定义未找到模块所对应的Modules
 */
define('NOT_MODULES', 'iManage');
/*
定义
 */
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
/**
 * 定义未找到模块所对应的Controller
 */
define('NOT_CONTROLLER', '_general');

/**
 * 定义缓存目录
 */
define('CACHE_DIR', 'cache/');

/**
 * 定义Cookie的域
 */
$dm = explode('.', $_SERVER['HTTP_HOST']);
if (count($dm) == 2) {
	define('DOMAIN', $_SERVER['HTTP_HOST']);
} elseif (in_array(count($dm), array(3, 4))) {
	unset($dm['0']);
	define('DOMAIN', implode('.', $dm));
}

/**
 * 定义Cookie名称
 */
define('COOKIE_NAME', 'userinfo');

/**
 * set portal title
 */
define('WEB_TITLE', '新闻');

/**
 * 定义ACL登陆地址  外网
 */
/*define('ACL_LOGIN_URL', 'http://www.'.DOMAIN.'/index.php/iManage/common');
 */
//本地开启
define('ACL_LOGIN_URL', 'http://localhost/index.php/iManage/common');
/**
 * 定义加密的KEY
 */
define('SECURE_KEY', 'd3x8s0f9');
?>