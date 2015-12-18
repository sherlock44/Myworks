<?php

//压缩图片
function compress_image($file, $percent = 1) {
	//header("Content-type: image/jpeg");
	//$file = "20140407114407.jpg";
	//$percent =1;  //图片压缩比

	list($width, $height) = getimagesize($file); //获取原图尺寸
	//缩放尺寸
	$newwidth = $width * $percent;
	$newheight = $height * $percent;
	$src_im = imagecreatefromjpeg($file);
	$dst_im = imagecreatetruecolor($newwidth, $newheight);
	imagecopyresized($dst_im, $src_im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	$dir = dirname(__FILE__) . '/' . date('Ym') . '/';

	$filename = $file;
	$filename = substr($filename, 0, strrpos($filename, '.'));

	//imagejpeg($dst_im); //输出压缩后的图片

	/* 生成文件 */

	if (function_exists('imagejpeg')) {
		$filename .= '.jpg';

		imagejpeg($dst_im, $filename);
	} elseif (function_exists('imagegif')) {
		$filename .= '.gif';
		imagegif($dst_im, $filename);
	} elseif (function_exists('imagepng')) {
		$filename .= '.png';
		imagepng($dst_im, $filename);
	} else {
		echo 5;

		return false;
	}
	imagedestroy($dst_im);
	imagedestroy($src_im);
}

//生成缩略图

//缩略图片
function make_thumb($img, $thumb_width = 0, $thumb_height = 0, $path = '', $bgcolor = '') {
	$gd = gd_version(); //获取 GD 版本。0 表示没有 GD 库，1 表示 GD 1.x，2 表示 GD 2.x
	if ($gd == 0) {
		echo 1;
		return false;
	}

	/* 检查缩略图宽度和高度是否合法 */
	if ($thumb_width == 0 && $thumb_height == 0) {
		return str_replace(ROOT_PATH, '', str_replace('\\', '/', realpath($img)));
	}

	/* 检查原始文件是否存在及获得原始文件的信息 */
	$org_info = @getimagesize($img);
	if (!$org_info) {
		echo 2;
		return false;
	}

	if (!check_img_function($org_info[2])) {
		echo 3;

		return false;
	}

	$img_org = img_resource($img, $org_info[2]);

	/* 原始图片以及缩略图的尺寸比例 */
	$scale_org = $org_info[0] / $org_info[1];
	/* 处理只有缩略图宽和高有一个为0的情况，这时背景和缩略图一样大 */
	if ($thumb_width == 0) {
		$thumb_width = $thumb_height * $scale_org;
	}
	if ($thumb_height == 0) {
		$thumb_height = $thumb_width / $scale_org;
	}

	/* 创建缩略图的标志符 */
	if ($gd == 2) {
		$img_thumb = imagecreatetruecolor($thumb_width, $thumb_height);
	} else {
		$img_thumb = imagecreate($thumb_width, $thumb_height);
	}

	/* 背景颜色 */
	if (empty($bgcolor)) {
		$bgcolor = '#FFFFFF';
	}
	$bgcolor = trim($bgcolor, "#");
	sscanf($bgcolor, "%2x%2x%2x", $red, $green, $blue);
	$clr = imagecolorallocate($img_thumb, $red, $green, $blue);
	imagefilledrectangle($img_thumb, 0, 0, $thumb_width, $thumb_height, $clr);

	if ($org_info[0] / $thumb_width > $org_info[1] / $thumb_height) {
		$lessen_width = $thumb_width;
		$lessen_height = $thumb_width / $scale_org;
	} else {
		/* 原始图片比较高，则以高度为准 */
		$lessen_width = $thumb_height * $scale_org;
		$lessen_height = $thumb_height;
	}

	$dst_x = ($thumb_width - $lessen_width) / 2;
	$dst_y = ($thumb_height - $lessen_height) / 2;

	/* 将原始图片进行缩放处理 */
	if ($gd == 2) {
		imagecopyresampled($img_thumb, $img_org, $dst_x, $dst_y, 0, 0, $lessen_width, $lessen_height, $org_info[0], $org_info[1]);
	} else {
		imagecopyresized($img_thumb, $img_org, $dst_x, $dst_y, 0, 0, $lessen_width, $lessen_height, $org_info[0], $org_info[1]);
	}

	/* 创建当月目录 */
	if (empty($path)) {
		$dir = dirname($img);
	} else {
		$dir = $path;
	}

	/* 如果目标目录不存在，则创建它 */
	if (!file_exists($dir)) {
		if (!make_dir($dir)) {
			/* 创建目录失败 */
			echo 4;
			return false;
		}
	}

	/* 如果文件名为空，生成不重名随机文件名 */
	$filename = substr($img, 0, strrpos($img, '.')) . "_" . $thumb_width . "x" . $thumb_height;

	/* 生成文件 */
	if (function_exists('imagejpeg')) {
		$filename .= '.jpg';
		imagejpeg($img_thumb, $filename);
	} elseif (function_exists('imagegif')) {
		$filename .= '.gif';
		imagegif($img_thumb, $filename);
	} elseif (function_exists('imagepng')) {
		$filename .= '.png';
		imagepng($img_thumb, $filename);
	} else {
		echo 5;

		return false;
	}

	imagedestroy($img_thumb);
	imagedestroy($img_org);

	// /确认文件是否生成
	// if (file_exists($filename))
	// {
	//     echo $filename;
	// }
	// else
	// {
	//   	echo 6;

	//     return false;
	// }/
}

function gd_version() {
	static $version = -1;

	if ($version >= 0) {
		return $version;
	}

	if (!extension_loaded('gd')) {
		$version = 0;
	} else {
		// 尝试使用gd_info函数
		if (PHP_VERSION >= '4.3') {
			if (function_exists('gd_info')) {
				$ver_info = gd_info();
				preg_match('/\d/', $ver_info['GD Version'], $match);
				$version = $match[0];
			} else {
				if (function_exists('imagecreatetruecolor')) {
					$version = 2;
				} elseif (function_exists('imagecreate')) {
					$version = 1;
				}
			}
		} else {
			if (preg_match('/phpinfo/', ini_get('disable_functions'))) {
				/* 如果phpinfo被禁用，无法确定gd版本 */
				$version = 1;
			} else {
				// 使用phpinfo函数
				ob_start();
				phpinfo(8);
				$info = ob_get_contents();
				ob_end_clean();
				$info = stristr($info, 'gd version');
				preg_match('/\d/', $info, $match);
				$version = $match[0];
			}
		}
	}

	return $version;
}

function check_img_function($img_type) {
	switch ($img_type) {
		case 'image/gif':
		case 1:

			if (PHP_VERSION >= '4.3') {
				return function_exists('imagecreatefromgif');
			} else {
				return (imagetypes() & IMG_GIF) > 0;
			}
			break;

		case 'image/pjpeg':
		case 'image/jpeg':
		case 2:
			if (PHP_VERSION >= '4.3') {
				return function_exists('imagecreatefromjpeg');
			} else {
				return (imagetypes() & IMG_JPG) > 0;
			}
			break;

		case 'image/x-png':
		case 'image/png':
		case 3:
			if (PHP_VERSION >= '4.3') {
				return function_exists('imagecreatefrompng');
			} else {
				return (imagetypes() & IMG_PNG) > 0;
			}
			break;

		default:
			return false;
	}
}

function img_resource($img_file, $mime_type) {
	switch ($mime_type) {
		case 1:
		case 'image/gif':
			$res = imagecreatefromgif($img_file);
			break;

		case 2:
		case 'image/pjpeg':
		case 'image/jpeg':
			$res = imagecreatefromjpeg($img_file);
			break;

		case 3:
		case 'image/x-png':
		case 'image/png':
			$res = imagecreatefrompng($img_file);
			break;

		default:
			return false;
	}

	return $res;
}

function unique_name($dir) {
	$filename = '';
	while (empty($filename)) {
		$str = '';
		for ($i = 0; $i < 9; $i++) {
			$str .= mt_rand(0, 9);
		}

		$filename = gmtime() . $str;
		if (file_exists($dir . $filename . '.jpg') || file_exists($dir . $filename . '.gif') || file_exists($dir . $filename . '.png')) {
			$filename = '';
		}
	}

	return $filename;
}

function gmtime() {
	return (time() - date('Z'));
}

function make_dir($folder) {
	$reval = false;

	if (!file_exists($folder)) {
		/* 如果目录不存在则尝试创建该目录 */
		@umask(0);

		/* 将目录路径拆分成数组 */
		preg_match_all('/([^\/]*)\/?/i', $folder, $atmp);

		/* 如果第一个字符为/则当作物理路径处理 */
		$base = ($atmp[0][0] == '/') ? '/' : '';

		/* 遍历包含路径信息的数组 */
		foreach ($atmp[1] AS $val) {
			if ('' != $val) {
				$base .= $val;

				if ('..' == $val || '.' == $val) {
					/* 如果目录为.或者..则直接补/继续下一个循环 */
					$base .= '/';

					continue;
				}
			} else {
				continue;
			}

			$base .= '/';

			if (!file_exists($base)) {
				/* 尝试创建目录，如果创建失败则继续循环 */
				if (@mkdir(rtrim($base, '/'), 0777)) {
					@chmod($base, 0777);
					$reval = true;
				}
			}
		}
	} else {
		/* 路径已经存在。返回该路径是不是一个目录 */
		$reval = is_dir($folder);
	}

	clearstatcache();

	return $reval;
}

//
?>