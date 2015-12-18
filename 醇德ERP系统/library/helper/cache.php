<?php
class cache {
	/*设置缓存*/
	static function ToFile($fileName, $fileContent) {
		$str = '<?php return ';
		if (is_array($fileContent)) {
			$str .= var_export($fileContent, true) . ';';
		} else {
			$str .= $fileContent . ';';
		}
		return file_put_contents(ROOT_PATH . '/data/' . CACHE_DIR . $fileName . '.php', $str);
	}

	static function getFile($fileName) {
		$filePath = ROOT_PATH . '/data/' . CACHE_DIR . $fileName . '.php';
		if (file_exists($filePath)) {
			return include $filePath;
		} else {
			return array();
		}

	}
}
