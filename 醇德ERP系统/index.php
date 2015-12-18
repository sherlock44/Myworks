<?php
header("content-Type: text/html; charset=Utf-8");
/**
 * 开启SESSION.
 */
session_start();
ini_set('display_errors', 1);
ini_set('html_errors', 1);

/**
 * 错误提示 0 不显示 1全部显示 -1 超级显示
 */
ini_set('error_reporting', -1);

/**
 * 定义网站区别
 */
date_default_timezone_set('Asia/Shanghai');

/**
 * 定义网站root和library,apps路径
 * 注：上线后可以设置为绝对路径，提高效率。
 */
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');
define('LIBRARY_PATH', ROOT_PATH . 'library/');
define('APPS_PATH', ROOT_PATH . 'apps/');
define('CONFIG_PATH', ROOT_PATH . 'config/');
define('ROOT_URL', $_SERVER['HTTP_HOST']);
error_reporting(E_ALL);
ini_set('display_errors', '1');

/**
 * 输出编码格式
 */

header('Content-type: text/html; charset=utf-8');

/**
 * 载入配置文件
 */

require ROOT_PATH . 'config/define.php';
require ROOT_PATH . 'config/global.php';

/**
 * 载入框架及相关文件
 */
require LIBRARY_PATH . 'framework.php';
require LIBRARY_PATH . 'helper/acl.php';
require LIBRARY_PATH . 'helper/cache.php';

/**
 * 初始化框架
 */
$Framework = new framework();
$Framework->initializtion();
