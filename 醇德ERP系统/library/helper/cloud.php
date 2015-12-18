<?php
class cloud {

	public $configs;
	public $apiUrl;

	function cloud() {
		global $configs;
		$this->configs = $configs['cloud'];
		$this->enable = $configs['cloud']['enable'];
	}

	function registerApi($apiName) {
		$this->apiUrl = 'http://' . $this->configs['server'] . $this->configs[$apiName];
	}

	function serverStatus() {
		$contents = $this->get();
		if ($contents != '1') {
			return false;
		} else {
			return true;
		}
	}

	function ssoRegister($data) {
		return $this->post($data);
	}

	function get() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		$contents = curl_exec($ch);
		curl_close($ch);

		return $contents;
	}

	function post($data) {
		$curlPost = "";
		foreach ($data as $key => $val) {
			$curlPost .= $key . '=' . $val . '&';
		}
		$curlPost = substr($curlPost, 0, -1);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
		$contents = curl_exec($ch);
		curl_close($ch);

		return $contents;
	}
}