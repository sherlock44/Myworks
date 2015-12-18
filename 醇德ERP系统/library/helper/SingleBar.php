<?php

/***
 * @project Bar Graph Program
 * @license GPL
 * @package
 * @file GrapBar.php
 * @date 2007-4-3
 * @version 1.0
 * @last modified

 * 定义 柱状图（柱形图） 类
 *
 * 注意，使用前请确保字体路径存在并允许访问，如果出错，还要检查在php.ini配置中的open_basedir项，如果没此路径请添加，或在程序中设置包含
 *
 * 智能化的柱状图程序，用于报表等
 *
 ***/

define("DEFAULT_FONT_PATH", "c:/windows/fonts/simhei.ttf");
class SingleBar {
	private $_x;
	private $_y;
	private $_h;
	public $_l = 50;
	private $_w = null;
	private $_srcPoints = array();
	private $_points = array();

	public function __construct($x, $y, $h, $l = 50, $w = null) {
		$this->_x = $x;
		$this->_y = $y;
		$this->_h = $h;
		$this->_l = $l;
		$this->_w = $w;
		$this->_srcPoints = $this->getSrcPoints();
		$this->_points = $this->getPoints();
	}

	public function getSrcPoints() {
		return array(array($this->_x, $this->_y), array($this->_x + $this->_l, $this->_y), array($this->_x + (1.35 * $this->_l), $this->_y - (0.35 * $this->_l)), array($this->_x + (0.35 * $this->_l), $this->_y - (0.35 * $this->_l)), array($this->_x, $this->_y + $this->_h), array($this->_x + $this->_l, $this->_y + $this->_h), array($this->_x + (1.35 * $this->_l), $this->_y + $this->_h - (0.35 * $this->_l)));
	}

	public function getPoints() {
		$points = array();
		foreach ($this->_srcPoints as $key => $val) {
			$points[] = $val[0];
			$points[] = $val[1];
		}
		return $points;
	}

	public function getTopPoints() {
		return array_slice($this->_points, 0, 8);
		//顶坐标

	}

	public function getBelowPoints() {
		return array_merge(array_slice($this->_points, 0, 2), array_slice($this->_points, 8, 4), array_slice($this->_points, 2, 2));
		//下坐标

	}

	public function getRightSidePoints() {
		return array_merge(array_slice($this->_points, 2, 2), array_slice($this->_points, 10, 4), array_slice($this->_points, 4, 2));
		//右侧坐标

	}

	public function draw($image, $topColor, $belowColor, $sideColor, $borderColor = null, $type = 'LEFT') {
		if (is_null($borderColor)) {
			$borderColor = 0xcccccc;
		}

		$top_rgb = $this->getRGB($topColor);
		$below_rgb = $this->getRGB($belowColor);
		$side_rgb = $this->getRGB($sideColor);
		$top_color = imagecolorallocate($image, $top_rgb['R'], $top_rgb['G'], $top_rgb['B']);
		$below_color = imagecolorallocate($image, $below_rgb['R'], $below_rgb['G'], $below_rgb['B']);
		$side_color = imagecolorallocate($image, $side_rgb['R'], $side_rgb['G'], $side_rgb['B']);

		imagefilledpolygon($image, $this->getTopPoints(), 4, $top_color);
		//画顶面
		imagepolygon($image, $this->getTopPoints(), 4, $borderColor);
		//画顶面边线

		imagefilledpolygon($image, $this->getBelowPoints(), 4, $below_color);
		//画下面
		imagepolygon($image, $this->getBelowPoints(), 4, $borderColor);
		//画下面边线

		if ($type == 'LEFT') {
			imagefilledpolygon($image, $this->getRightSidePoints(), 4, $side_color);
			//画右侧面
			imagepolygon($image, $this->getRightSidePoints(), 4, $borderColor);
			//画侧面边线

		}
	}

	public function getRGB($color) {
		$ar = array();
		$color = hexdec($color);
		$ar['R'] = ($color >> 16) & 0xff;
		$ar['G'] = ($color >> 8) & 0xff;
		$ar['B'] = ($color) & 0xff;
		return $ar;
	}
}
class Bar {
	private $_W;
	private $_H;
	private $_bgColor = "ffffff";
	private $_barHeights = array();
	private $_barTexts = array();
	private $_barColors = array();
	public $_title;
	public $_paddingTop = 30;
	public $_paddingBottom = 100;
	public $_paddingLeft = 45;
	public $_paddingRight = 2;
	public $_barL = 50;
	public $image;

	public function __construct($imgW, $imgH, $barHeights, $barTexts = null, $barColors = null) {
		$this->_W = $imgW;
		$this->_H = $imgH;
		$this->_barHeights = $barHeights;
		$this->_barTexts = $barTexts;
		$this->_barColors = $barColors;
		$this->_paddingBottom = $this->resetPaddingBottom();
		$this->_H = $this->resetHeight();
		$this->image = imagecreatetruecolor($this->_W, $this->_H);
	}

	public function stroke() {
		$this->drawBg();
		$this->drawBars();
		$this->drawTitle();
		$this->drawLables();
		ob_start();

		//header("Content-type: image/png");
		//imagepng($this->image);
		header("Content-type: " . image_type_to_mime_type(IMAGETYPE_JPEG));
		imagejpeg($this->image);
		imagedestroy($this->image);
	}

	public function drawBg() {
		$img_w = $this->_W;
		$img_h = $this->_H;
		$paddingTop = $this->_paddingTop;
		$paddingBottom = $this->_paddingBottom;
		$paddingLeft = $this->_paddingLeft;
		$paddingRight = $this->_paddingRight;
		$rgb = $this->getRGB($this->_bgColor);
		$bg = imagecolorallocate($this->image, $rgb['R'], $rgb['G'], $rgb['B']);
		imagefilledrectangle($this->image, 0, 0, $img_w, $img_h, $bg);
		$side_bg = imagecolorallocatealpha($this->image, 220, 220, 220, 75);
		$side_bg2 = imagecolorallocate($this->image, 220, 220, 220);
		$border_color = imagecolorallocate($this->image, 190, 190, 190);
		$line_color = imagecolorallocate($this->image, 236, 236, 236);
		$dial_color = imagecolorallocate($this->image, 131, 131, 131);

		$x1 = $paddingLeft;
		$y1 = $paddingTop;
		$x2 = $img_w - $paddingRight;
		$y2 = $img_h - $paddingBottom;
		imagerectangle($this->image, $x1, $y1, $x2, $y2, $border_color);
		imagefilledpolygon($this->image, array($x1 - 5, $y1 + 10, $x1 - 5, $y2 + 10, $x1, $y2, $x1, $y1), 4, $side_bg);
		imagepolygon($this->image, array($x1 - 5, $y1 + 10, $x1 - 5, $y2 + 10, $x1, $y2, $x1, $y1), 4, $border_color);
		imagefilledpolygon($this->image, array($x1 - 5, $y2 + 10, $x2 - 5, $y2 + 10, $x2, $y2, $x1, $y2), 4, $side_bg);
		imagepolygon($this->image, array($x1 - 5, $y2 + 10, $x2 - 5, $y2 + 10, $x2, $y2, $x1, $y2), 4, $border_color);
		imageline($this->image, $x1, $y2, $x2, $y2, $side_bg2);

		$total_h = $img_h - $paddingTop - $paddingBottom;
		$every_h = $total_h / 11;
		for ($i = 1; $i <= 10; $i++) {
			imageline($this->image, $x1, $y1 + ($every_h * $i), $x2, $y1 + ($every_h * $i), $line_color);
			//画网线

		}

		$max_h = max($this->_barHeights);
		for ($i = 1; $i <= 10; $i++) {
			$value = $max_h - (($max_h / 10) * ($i - 1));
			$value = strval($value);
			$str_w = strlen($value) * 5;
			imageline($this->image, $x1 - 5 - 3, $y1 + 10 + ($every_h * $i), $x1 - 3 + 1, $y1 + 10 + ($every_h * $i), $dial_color);
			//画刻度线
			imagestring($this->image, 3, $x1 - 5 - 3 - $str_w - 1, $y1 + 10 + ($every_h * $i) - 5, $value, 0x000000);
		}
	}

	public function drawBars() {
		$counts = count($this->_barHeights);
		if (empty($this->_barColors)) {
			$color = $this->setColor();
			$this->_barColors = array_slice($color, 0, $counts);

			//shuffle($this->_barColors);

		}
		$every_w = ($this->_W - $this->_paddingLeft - $this->_paddingRight) / $counts;
		//每一段宽
		$barL = $every_w;
		$barL = ($barL > $this->_barL * 1.35 + 6) ? $this->_barL : $barL / 1.35 - 6;
		$max_h = max($this->_barHeights);
		$ruler_h = $this->_H - $this->_paddingTop - $this->_paddingBottom;
		//标尺总高度
		$stander_h = $ruler_h - ($ruler_h / 11);
		//标尺10等分的高度
		$i = 0;
		foreach ($this->_barHeights as $val) {
			$h = ($stander_h / $max_h) * $val;
			$x = $this->_paddingLeft + ($every_w * $i) + (($every_w - ($barL * 1.35)) / 2);
			$y = $this->_H - $this->_paddingBottom + 10 - $h;

			//$t_color = $this->_barColors[$i];
			$b_color = $this->_barColors[$i];

			//$s_color = $this->_barColors[$i];

			$rgb = $this->getRGB($this->_barColors[$i]);
			$R = $rgb['R'] * 0.7;
			$G = $rgb['G'] * 0.7;
			$B = $rgb['B'] * 0.7;

			$c1 = $R > 0 ? dechex($R) : '00';
			$c2 = $G > 0 ? dechex($G) : '00';
			$c3 = $B > 0 ? dechex($B) : '00';
			$t_color = $b_color;
			$s_color = $c1 . $c2 . $c3;
			$SingleBar = new SingleBar($x, $y, $h, $barL);
			$SingleBar->draw($this->image, $t_color, $b_color, $s_color);
			$i++;
		}
	}

	public function drawTitle() {
		if (empty($this->_title)) {
			return;
		}
		$font = 5;
		$font_w = imagefontwidth($font);
		$len = strlen($this->_title);
		$x = ($this->_W + $this->_paddingLeft - $this->_paddingRight) / 2;
		$x -= ($len * $font_w) / 2;
		$y = ($this->_paddingTop - $font_w) / 2 + 12;

		//imagestring($this->image, $font, $x, $y, $title, 0x000000);
		imagettftext($this->image, 12, 0, $x, $y, 0x000000, DEFAULT_FONT_PATH, $this->_title);
	}

	public function drawLables() {
		$x1 = $this->_paddingLeft - 5;
		$y1 = $this->_H - $this->_paddingBottom + 20;
		$x2 = $this->_W - $this->_paddingRight;
		$y2 = $this->_H - 10;

		//imagefilledrectangle($this->image, $x1, $y1, $x2, $y2, 0xffffff);
		imagerectangle($this->image, $x1, $y1, $x2, $y2, 0x000000);
		$space = 5;
		$x = $x1 + 3;
		$y = $y1 + 3;
		foreach ($this->_barTexts as $key => $val) {
			$color = $this->_barColors[$key];
			$rgb = $this->getRGB($color);
			$bg = imagecolorallocate($this->image, $rgb['R'], $rgb['G'], $rgb['B']);
			imagefilledrectangle($this->image, $x, $y, $x + 12, $y + 12, $bg);
			//绘12*12的矩形
			imagerectangle($this->image, $x, $y, $x + 12, $y + 12, 0x000000);
			//绘12*12的矩形框
			imagettftext($this->image, 12, 0, $x + 12 + 3, $y + 12, 0x000000, DEFAULT_FONT_PATH, $val);
			$x += 12 + $space + (strlen($val) * 8) + $space;
			if ($x + (strlen($val) * 8) >= $this->_W - $this->_paddingLeft - $this->_paddingRight) {
				$x = $x1 + 3;
				$y = $y + 12 + 3;
			}
		}
	}

	public function resetPaddingBottom() {
		$ruler_w = $this->_W - $this->_paddingLeft - $this->_paddingRight;
		$label_w = $this->getLableTotalWidth();
		$lines = ceil($label_w / $ruler_w);
		$h = 12 * $lines + (3 * ($lines + 1)) + 30;
		return $h;
	}

	public function resetHeight() {
		$padding_bottom = $this->resetPaddingBottom();
		if ($this->_H - $padding_bottom < 222) {
			return 222 + $padding_bottom;
		}
		return $this->_H;
	}

	public function getLableTotalWidth() {
		$counts = count($this->_barTexts);
		$space = 5;
		$total_len = 0;
		foreach ($this->_barTexts as $val) {
			$total_len += strlen($val);
		}

		$tx_w = ($total_len * 9) + ((12 + 3 + $space) * $counts);
		return $tx_w;
	}

	public function setBg($color) {
		$this->_bgColor = $color;
	}

	public function setTitle($title) {
		$this->_title = $title;
	}

	public function setColor() {
		$ar = array('ff', '00', '33', '66', '99', 'cc');
		$color = array();
		for ($i = 0; $i < 6; $i++) {
			for ($j = 0; $j < 6; $j++) {
				for ($k = 0; $k < 6; $k++) {
					$color[] = $ar[$i] . $ar[$j] . $ar[$k];
				}
			}
		}

		$color2 = array();
		for ($i = 1; $i < 216; $i += 4) {
			$color2[] = $color[$i];
		}
		return $color2;
	}

	public function getRGB($color) {
		$ar = array();
		$color = hexdec($color);
		$ar['R'] = ($color >> 16) & 0xff;
		$ar['G'] = ($color >> 8) & 0xff;
		$ar['B'] = ($color) & 0xff;
		return $ar;
	}
}

/***/

/*
$bar = new Bar(500, 300, array(600, 300, 30, 500, 400, 250, 350, 360), array('AAAAA', 'BBBBB', 'CCCCC', 'DDDDD', 'EEEEEE', 'FFFFFF', 'GGGGGGG', 'HHHHHHHHH'));
$bar->setTitle('打造完美柱状图!');
$bar->stroke();
 */

/***/
?>