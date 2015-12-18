<?
/**
 * 图像上传  并处理缩略图 文件上传
 */
class image
{
    public $uploadFolder; // 图片存放目录
    public $webUpdFolder; // 图片存放目录(web)
    public $thumbWidth = ''; // 缩略图宽度
    public $thumbHeight = ''; // 缩略图高度
    public $autoThumb = ''; // 是否自动生成缩略图
    public $error = ''; // 错误信息
    public $imgPath = ''; // 上传成功后的图片位置
    public $thumbPath = ''; // 上传成功后的缩略图位置

    /**
     * 初始化
     * @param string $uploadFolder 顶级文件夹
     * @param string $type 类型 默认 图片
     */
    function __construct($uploadFolder = 'image', $type = 'img')
    {
        //本次目录（检查并创建）
        $this->uploadFolder = $this->isDir($this->isDir(ROOT_PATH.'data/'.$uploadFolder).'/'.date('Y', time()).'/'.date('m', time()).'/'.date('d', time())."/");
        //web路径
        $this->webUpdFolder = ROOT_PATH.'data/'.$uploadFolder.'/'.date('Y', time()).'/'.date('m', time()).'/'.date('d', time())."/";
    }

    /**
     * 上传图像
     * @param string $inputName 控件
     * @return string Url 图片的web地址
     */
    function updImg($inputName)
    {
        if(!$inputName) throw new Exception('控件名不存在！');
        if(!$_FILES[$inputName]["name"]) throw new Exception('没有上传图片！');
        $isUpFile = $_FILES[$inputName]['tmp_name'];
        if (is_uploaded_file($isUpFile))
        {

            $imgInfo = $this->_getinfo($isUpFile);

            if (FALSE == $imgInfo) return FALSE;
            $extName = $imgInfo['type'];
            list($usec, $sec) = explode(' ',microtime());
            $ymd  = date('Ymd', (string)$sec);
            $usec = substr((string)$usec, 2);
            $microSenond =$ymd.$usec;// 取一个毫秒级数字,4位。
            $newFileName = $microSenond . '.' . $extName ; // 所上传图片的新名字
            $location = $this->uploadFolder . $newFileName;
            //var_dump($result);exit;
            $result = move_uploaded_file($isUpFile, $location);


            if ($result) {
                if (TRUE == $this->autoThumb)
                {
                    /// 是否生成缩略图
                    $thumb = $this->thumb($location, $this->thumbWidth, $this->thumbHeight);
                    if (FALSE == $thumb)
                    {
                        return FALSE;
                    }
                }
                return $this->webUpdFolder.$newFileName;
            }else {
                $this->error = '移动临时文件时出错';
                return FALSE;
            }
        }
    }

    /**
     * 上传文件
     * @param string $inputName 控件
     * @return string Url 图片的web地址
     */
    function updFile($inputName)
    {
        if(!$inputName) throw new Exception('控件名不存在！');
        if(!$_FILES[$inputName]["name"]) throw new Exception('没有文件！');
        $isUpFile = $_FILES[$inputName]['tmp_name'];
        $name = $_FILES[$inputName]["name"];
        if (is_uploaded_file($isUpFile))
        {
            $url = $this->uploadFolder;

            $weburl = $this->uploadFolder;
            @mkdir($url, 0777, true);
            $location = $url.'/'.$name;

            $result = move_uploaded_file($isUpFile, $location);
            if ($result) {
                return $weburl.'/'.$name;
            }
        }
    }

    // 说明：获取图片信息，参数是上传后的临时文件，成功返回数组，失败返回FALSE和错误信息
    // array/bool _getinfo(string $upload_tmp_file)
    private function _getinfo($img)
    {
        if (!file_exists($img)) {
            $this->error = '找不到图片，无法获取其信息';
            return FALSE;
        }
        $tempFile = @fopen($img, "rb");
        $bin = @fread($tempFile, 2); //只读2字节
        @fclose($tempFile);
        $strInfo = @unpack("C2chars", $bin);
        $typeCode = intval($strInfo['chars1'] . $strInfo['chars2']);
        $fileType = '';
        switch ($typeCode) { // 6677:bmp 255216:jpg 7173:gif 13780:png 7790:exe 8297:rar 8075:zip tar:109121 7z:55122 gz 31139
            case '255216':
                $fileType = 'jpg';
                break;
            case '7173':
                $fileType = 'gif';
                break;
            case '13780':
                $fileType = 'png';
                break;
            default:
                $fileType = 'unknown';
        }
        if ($fileType == 'jpg' || $fileType == 'gif' || $fileType == 'png') {
            $imageInfo = getimagesize($img);
            $imgInfo['size'] = empty($imageInfo['bits'])?'':$imageInfo['bits'];
            $imgInfo["type"] = $fileType;
            $imgInfo["width"] = $imageInfo[0];
            $imgInfo["height"] = $imageInfo[1];
            return $imgInfo;
        }else { // 非图片类文件信息
            $this->error = '图片类型错误';
            return FALSE;
        }
    } // end _getinfo

    // 说明：生成缩略图，等比例缩放或拉伸
    // bool/string thumb(string $uploaded_file, int $thumbWidth, int $thumbHeight, string $thumbTail);
    function thumb($img, $thumbWidth = 300, $thumbHeight = 200, $thumbTail = '_thumb')
    {
        $filename = $img; // 保留一个名字供新的缩略图名字使用
        $imgInfo = $this->_getinfo($img);
        if (FALSE == $imgInfo) {
            return FALSE;
        }
        $imgType = $imgInfo['type'];
        switch ($imgType) { // 创建一个图，并给出扩展名
            case "jpg" :
                $img = imagecreatefromjpeg($img);
                $extName = 'jpg';
                break;
            case 'gif' :
                $img = imagecreatefromgif($img);
                $extName = 'gif';
                break;
            case 'png' :
                $img = imagecreatefrompng($img);
                $extName = 'png';
                break;
            default : // 如果类型错误，生成一张空白图
                $img = imagecreate($thumbWidth,$thumbHeight);
                imagecolorallocate($img,0x00,0x00,0x00);
                $extName = 'jpg';
        }
        // 缩放后的图片尺寸(小则拉伸，大就缩放)
        $imgWidth = $imgInfo['width'];
        $imgHeight = $imgInfo['height'];
        if ($imgHeight > $imgWidth) { // 竖图
            $newHeight = $thumbHeight;
            $newWidth = ceil($imgWidth / ($imgHeight / $thumbHeight ));
        }else if($imgHeight < $imgWidth) { // 横图
            $newHeight = ceil($imgHeight / ($imgWidth / $thumbWidth ));
            $newWidth = $thumbWidth;
        }else if($imgHeight == $imgWidth) { // 等比例图
            $newHeight = $thumbWidth;
            $newWidth = $thumbWidth;
        }
        $bgimg = imagecreatetruecolor($newWidth,$newHeight);
        $bg = imagecolorallocate($bgimg,0x00,0x00,0x00);
        imagefill($bgimg,0,0,$bg);
        $sampled = imagecopyresampled($bgimg,$img,0,0,0,0,$newWidth,$newHeight,$imgWidth,$imgHeight);
        if(!$sampled ) {
            $this->error = '缩略图生成失败';
            @unlink($this->uploadFolder  . $filename); // 删除上传的图片
            return FALSE;
        }
        $filename = basename($filename);
        $newFileName = substr($filename, 0, strrpos($filename, ".")); // 新名字

        $thumbPath = $this->uploadFolder  . $newFileName;
        switch ($extName) {
            case 'jpg':
                $result = imagejpeg($bgimg, $thumbPath);
                break;
            case 'gif':
                $result = imagegif($bgimg, $thumbPath);
                break;
            case 'png':
                $result = imagepng($bgimg, $thumbPath);
                break;
            default: // 上边判断类型出错时会创建一张空白图，并给出扩展名为jpg
                $result = imagejpeg($bgimg, $thumbPath);
        }
        if ($result) {
            $this->thumbPath = $thumbPath;
            return $thumbPath;
        }else {
            $this->error = '缩略图创建失败';
            @unlink($this->uploadFolder  . $filename); // 删除上传的图片
            return FALSE;
        }
    } // end thumb

    /**
     * 创建文件夹
     * 不存在则自动创建
     */
    function isDir($path)
    {
        if(!is_dir($path))
        {
            $mkdirResutlt = mkdir($path, 0777, true);
            if (!$mkdirResutlt) throw new Exception('文件夹创建失败');
        }
        return $path;
    }




function imageWaterMark($groundImage,$waterPos=9,$waterImage="",$waterText="",$textFont=5,$textColor="#FF0000")
{
 $waterImage = ROOT_PATH."public/portal/sy.png";//水印图片路径

 $isWaterImage = FALSE;
 $formatMsg = "暂不支持该文件格式，请用图片处理软件将图片转换为GIF、JPG、PNG格式。";
 //读取水印文件
 if(!empty($waterImage) && file_exists($waterImage))
 {
  $isWaterImage = TRUE;
  $water_info = getimagesize($waterImage);
  $water_w = $water_info[0];//取得水印图片的宽
  $water_h = $water_info[1];//取得水印图片的高
  switch($water_info[2])//取得水印图片的格式
  {
   case 1:$water_im = imagecreatefromgif($waterImage);break;
   case 2:$water_im = imagecreatefromjpeg($waterImage);break;
   case 3:$water_im = imagecreatefrompng($waterImage);break;
   default:die($formatMsg);
  }
 }
 //读取背景图片
 if(!empty($groundImage) && file_exists($groundImage))
 {
  $ground_info = getimagesize($groundImage);
  $ground_w = $ground_info[0];//取得背景图片的宽
  $ground_h = $ground_info[1];//取得背景图片的高
  switch($ground_info[2])//取得背景图片的格式
  {
   case 1:$ground_im = imagecreatefromgif($groundImage);break;
   case 2:$ground_im = imagecreatefromjpeg($groundImage);break;
   case 3:$ground_im = imagecreatefrompng($groundImage);break;
   default:die($formatMsg);
  }
 }
 else
 {
  die("需要加水印的图片不存在！");
 }
 //水印位置
 if($isWaterImage)//图片水印
 {
  $w = $water_w;
  $h = $water_h;
  $label = "图片的";
 }
 else//文字水印
 {
  $temp = imagettfbbox(ceil($textFont*5),0,"courbi.ttf",$waterText);//取得使用 TrueType 字体的文本的范围
  $w = $temp[2] - $temp[6];
  $h = $temp[3] - $temp[7];
  unset($temp);
  $label = "文字区域";
 }
 if( ($ground_w<$w) || ($ground_h<$h) )
 {
  echo "需要加水印的图片的长度或宽度比水印".$label."还小，无法生成水印！";
  return;
 }
 switch($waterPos)
 {
 case 0://随机
  $posX = rand(0,($ground_w - $w));
  $posY = rand(0,($ground_h - $h));
  break;
 case 1://1为顶端居左
  $posX = 0;
  $posY = 0;
  break;
 case 2://2为顶端居中
  $posX = ($ground_w - $w) / 2;
  $posY = 0;
  break;
 case 3://3为顶端居右
  $posX = $ground_w - $w;
  $posY = 0;
  break;
 case 4://4为中部居左
  $posX = 0;
  $posY = ($ground_h - $h) / 2;
  break;
 case 5://5为中部居中
  $posX = ($ground_w - $w) / 2;
  $posY = ($ground_h - $h) / 2;
  break;
 case 6://6为中部居右
  $posX = $ground_w - $w;
  $posY = ($ground_h - $h) / 2;
  break;
 case 7://7为底端居左
  $posX = 0;
  $posY = $ground_h - $h;
  break;
 case 8://8为底端居中
  $posX = ($ground_w - $w) / 2;
  $posY = $ground_h - $h;
  break;
 case 9://9为底端居右
  $posX = $ground_w - $w;
  $posY = $ground_h - $h;
  break;
 default://随机
  $posX = rand(0,($ground_w - $w));
  $posY = rand(0,($ground_h - $h));
  break;
 }
 //设定图像的混色模式
 imagealphablending($ground_im, true);
 if($isWaterImage)//图片水印
 {
  imagecopy($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h);//拷贝水印到目标文件
 }
 else//文字水印
 {
  if( !empty($textColor) && (strlen($textColor)==7) )
  {
   $R = hexdec(substr($textColor,1,2));
   $G = hexdec(substr($textColor,3,2));
   $B = hexdec(substr($textColor,5));
  }
  else
  {
   die("水印文字颜色格式不正确！");
  }
  imagestring ( $ground_im, $textFont, $posX, $posY, $waterText, imagecolorallocate($ground_im, $R, $G, $B));
 }
 //生成水印后的图片
 @unlink($groundImage);
 switch($ground_info[2])//取得背景图片的格式
 {
  case 1:imagegif($ground_im,$groundImage);break;
  case 2:imagejpeg($ground_im,$groundImage);break;
  case 3:imagepng($ground_im,$groundImage);break;
  default:die($errorMsg);
 }
 //释放内存
 if(isset($water_info)) unset($water_info);
  if(isset($water_im)) imagedestroy($water_im);
   unset($ground_info);
 imagedestroy($ground_im);
}



}