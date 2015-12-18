<?php
class verifyCode {
	protected $width; //验证码的宽度
	protected $height; //验证码的高度
	protected $num; //验证码中字符的个数
	protected $type; //0表示纯数字，1表示纯字母，2表示混合，3表示中文
	protected $img; //图像资源，生成画布时赋值，销毁时使用
	protected $string; //生成的验证码，这个字符串供session使用
	function __construct($width = 100, $height = 50, $num = 4, $type = 0) {
		$this->width = $width;
		$this->height = $height;
		$this->num = $num;
		$this->type = $type;
		$this->create(); //在构造函数里直接运行生成验证码的函数
	}

	function create() {
		ob_clean();
		$this->createHB(); //生成画布
		$this->createBJ(); //生成背景
		$this->createGRYS(); //生成干扰元素
		$this->getString(); //根据类型得到相应的字符串
		$this->createZF(); //写入字符
		$this->outimage(); //输出验证码
		$_SESSION['verifycode_content'] = strtolower(implode('', $this->string)); //获取验证码的值并转换成小写存到session中;
		$_SESSION['verifycode_time'] = time(); //获取验证码输出时间并存到session中;

	}

	function outimage() {
		header('content-type:image/png');
		imagepng($this->img);
	}
	function createZF() {
		if ($this->type == 3) {
			$fnt = ROOT_PATH . '/resource/GBK.ttf';
			for ($i = 0; $i < $this->num; $i++) {
				imagettftext($this->img, 12, 5, $i * ($this->width / $this->num), rand(0, $this->height + 5), $this->Scolor(), $fnt, $this->string[$i]);
			}
		} else {
			for ($i = 0; $i < $this->num; $i++) {
				imagechar($this->img, 5, $i * ($this->width / $this->num), rand(0, $this->height - 15), $this->string[$i], $this->Scolor());
			}
		}
	}
	function getString() {
		switch ($this->type) {
//根据选择的类型得到相应的字符串
			case 0:
				$this->string = array_rand(range(0, 9), $this->num);
				break;
			case 1:
				$arr = array_merge(range('a', 'z'), range('A', 'Z')); 	//获得一个所有字母的数组
				$this->string = array_rand(array_flip($arr), $this->num);
				break;
			case 2:
				$arr = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
				$this->string = array_rand(array_flip($arr), $this->num);
				break;
			case 3:
				$arr = array("人", "出", "来", "友", "学", "孝", "仁", "义", "礼", "廉", "忠", "国", "中", "易", "白", "者", "火 ", "土", "金", "木", "雷", "风", "龙", "虎", "天", "地", "生", "晕", "菜", "鸟", "田", "三", "百", "钱", "福 ", "爱", "情", "兽", "虫", "鱼", "九", "网", "新", "度", "哎", "唉", "啊", "哦", "仪", "老", "少", "日",
					"月 ", "星");
				$this->string = array_rand(array_flip($arr), $this->num);
				break;
			default:
				$this->string = array_rand(range(0, 9), $this->num);
				break;
		}
	}
	function createGRYS() {
		for ($i = 0; $i < 4; $i++) {
			imagearc($this->img, rand(0, $this->width), rand(0, $this->height), rand(20, $this->width / 1.5), rand(2, 8), rand(0, 10), rand(80, 120), $this->Scolor());
		}

		for ($i = 0; $i < 50; $i++) {
			imagesetpixel($this->img, rand(0, $this->width), rand(0, $this->height), $this->Scolor());
		}

	}
	function createBj() {
		imagefilledrectangle($this->img, 0, 0, $this->width, $this->height, $this->Qcolor());}

	function Qcolor() {
//生成一个浅颜色
		return imagecolorallocate($this->img, rand(150, 255), rand(150, 255), rand(150, 255));
	}
	function Scolor() {
//生成一个深颜色
		imagecolorallocate($this->img, rand(0, 125), rand(0, 125), rand(0, 125));
	}
	function createHB() {
		$this->img = imagecreatetruecolor($this->width, $this->height);
	}
	function des() {
		imagedestroy($this->img);
	}
	function __destruct() {
		$this->des();
	}
}
?>