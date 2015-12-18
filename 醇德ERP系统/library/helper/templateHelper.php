<?php
/**
 *  模板解析
 */
final class templateHelper {

	public $tplFile;

	public $tagStartWord = "{module:";
	public $fullTagEndWord = "{/module:";
	public $sTagEndWord = "/}";
	public $tagEndWord = "}";

	/**
	 * 载入模板
	 *
	 * @param $tplFile    模板目录
	 * @return string 解析后的模板。
	 */
	public function load($tplFile) {
		$this->tplFile = $tplFile;

		if (!file_exists($tplFile)) {
			echo " Template Not Found! ";
			exit();
		}

		$this->sourceString = file_get_contents($tplFile);

		$this->parseByBase(); // 解析基本标签
		$this->parseByModule();
		$this->parseItem();
		$this->parseByModuleSql();

		return $this->sourceString;
	}

	/**
	 * 载入模板内容
	 *
	 * @param $content    模板内容
	 */
	public function loadContent($content) {
		$this->sourceString = $content;
		$this->parseByBase(); // 解析基本标签
		$this->parseByModule();
		$this->parseItem();
		$this->parseByModuleSql();
		return $this->sourceString;
	}

	/**
	 *  设置标记风格
	 *
	 * @access    public
	 * @param     string   $ts  标签开始标记
	 * @param     string   $ftend  标签结束标记
	 * @param     string   $stend  标签尾部结束标记
	 * @param     string   $tend  结束标记
	 * @return    void
	 */
	function setTagStyle($ts = '{module:', $ftend = '{/module:', $stend = '/}', $tend = '}') {
		$this->tagStartWord = $ts;
		$this->fullTagEndWord = $ftend;
		$this->sTagEndWord = $stend;
		$this->tagEndWord = $tend;
	}

	/**
	 * 解析模板基本标签
	 *
	 * @param $str    模板内容
	 * @return ture
	 */
	public function parseByBase() {

		// include
		$this->sourceString = preg_replace("/\{template\s+(.+)\}/", '<?php $this->customTemplate("\\1"); ?>', $this->sourceString);
		$this->sourceString = preg_replace("/\{include\s+(.+)\}/", "<?php include \\1; ?>", $this->sourceString);
		$this->sourceString = preg_replace("/\{php\s+(.+)\}/", "<?php \\1?>", $this->sourceString);
		//$this->sourceString = preg_replace ( "/\{echo\s+(.+)\}/", eval("echo \\1"), $this->sourceString );

		// 分析标签：{echo /}
		$checkModule = true;
		$pattern = "/\{echo\s+(.+)\}/";

		do {
			if (!preg_match($pattern, $this->sourceString, $matches)) {
				$checkModule = false;
			} else {
				eval('$tmp = ' . $matches[1] . ';');
				$this->sourceString = preg_replace($pattern, $tmp, $this->sourceString, 1);
			}
		} while ($checkModule);

		return $this->sourceString;
	}

	/**
	 * 解析模板基本标签
	 *
	 * @param $str    模板内容
	 * @return ture
	 */
	public function parseByModule() {
		// 分析标签：{module
		$checkModule = true;
		$pattern = "/\{module\:([^\s]+)(\s([^\}]+))?\}([\s\S]+?)\{\/module\}/i";

		do {
			if (!preg_match($pattern, $this->sourceString, $matches)) {
				$checkModule = false;
			} else {
				$attribs = $this->parseAttrib($matches[2]);

				$innerString = $this->parseConent($matches[4]);

				$this->sourceString = preg_replace($pattern, '<?php $result = $this->' . $matches[1] . '(' . var_export($attribs, true) . ');foreach($result as $key=>$item):?>' . $innerString . '<?php endforeach;?>', $this->sourceString, 1);

			}
		} while ($checkModule);

		return $this->sourceString;
	}

	public function parseItem() {

		// 分析标签：{module /}
		$checkModule = true;
		$pattern = "/\{single\s*:\s*([^\s]+)\s+([^\}]+)\/\}/i";

		do {
			if (!preg_match($pattern, $this->sourceString, $matches)) {
				$checkModule = false;
			} else {
				$attribs = $this->parseAttrib($matches[2]);
				$name = !empty($attribs['name']) ? $attribs['name'] : die("必须有name属性");
				unset($attribs['name']);

				$this->sourceString = preg_replace($pattern, '<?php $' . $name . '= $this->' . $matches[1] . '(' . var_export($attribs, true) . ');?>', $this->sourceString, 1);

				$this->sourceString = preg_replace("/\{" . $name . "(.+)\}/", "<?php echo $" . $name . "\\1;?>", $this->sourceString);

			}
		} while ($checkModule);

		return $this->sourceString;
	}

	/**
	 * 解析sql模板基本标签
	 *
	 * @param $str    模板内容
	 * @return ture
	 */
	public function parseByModuleSql() {
		// 分析标签：{module
		$checkModule = true;
		$pattern = "/\{modulesql\:([^\s]+)(\s([^\}]+))?\}([\s\S]+?)\{\/modulesql\}/i";

		do {
			if (!preg_match($pattern, $this->sourceString, $matches)) {
				$checkModule = false;
			} else {
				$attribs = $this->parseAttribSql($matches[2]);

				$innerString = $this->parseConent($matches[4]);

				$this->sourceString = preg_replace($pattern, '<?php $result = $this->' . $matches[1] . '(' . var_export($attribs, true) . ');foreach($result as $key=>$item):?>' . $innerString . '<?php endforeach;?>', $this->sourceString, 1);

			}
		} while ($checkModule);

		return $this->sourceString;
	}

	public function parseAttribSql($attribString) {
		$result = array();
		$attribString = trim($attribString);
		$attribString = str_replace("  ", " ", $attribString);
		//$attribString = str_replace("\"","",$attribString);
		$attribString = str_replace("'", "", $attribString);

		$tmp = explode("sql=", $attribString);

		$result['sql'] = $tmp[1];

		return $result;
	}

	public function parseAttrib($attribString) {
		$result = array();
		$attribString = trim($attribString);
		$attribString = str_replace("  ", " ", $attribString);
		$attribString = str_replace("\"", "", $attribString);
		$attribString = str_replace("'", "", $attribString);

		$tmp = explode(" ", $attribString);

		foreach ($tmp as $item) {
			$r = explode("=", $item);
			$result[$r[0]] = $r[1];
		}

		return $result;
	}

	public function parseConent($content) {
		$content = str_replace("{time}", "<?=date('Y-m-d H:i:s',\$item['created'])?>", $content);
		$content = preg_replace("/\{(.+?)\}/", "<?php echo \$item['\\1']?>", $content);
		return $content;
	}
}
