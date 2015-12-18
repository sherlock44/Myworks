<?php
//写日志
class log extends actionAbstract {
	var $ip;
	public function __construct() {
		$this->ip = $this->GetIP();
	}
	/*
	 **function:写日志
	 **parm    : $data(array)
	 **parm    : $data['title']   标题
	 **parm    : $data['userid']  用户id
	 **parm    : $data['content'] 内容
	 **void    : null
	 */
	public function logwrite(array $data) {
		$this->loadModel('system', 'log');
		$data['ip'] = $this->ip;
		$data['created'] = time();
		return $this->system->logModel->insert($data);
	}
	//获取客户端ip
	function GetIP() {
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
			$ip = getenv("HTTP_CLIENT_IP");
		} else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		} else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
			$ip = getenv("REMOTE_ADDR");
		} else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
			$ip = $_SERVER['REMOTE_ADDR'];
		} else {
			$ip = "unknown";
		}

		return ($ip);
	}
}