<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;
class FileController extends Controller{
	//上次图片
	public function uploadPicture()
	{
		$path = 'Uploads/Picture/';
		if(!file_exists($path))
		{  
			//检查是否有该文件夹，如果没有就创建，并给予最高权限  
			mkdir("$path", 0700,true);  
		}//END IF 
		/* 返回标准数据 */
		$return  = array('status' => 1, 'info' => '上传成功', 'data' => '');
		$config = array(
				'mimes'    => '', //允许上传的文件MiMe类型
				'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
				'exts'     => array('jpg','gif','png','jpeg'), //允许上传的文件后缀
				'autoSub'  => true, //自动子目录保存文件
				'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
				'rootPath' => './Uploads/Picture/', //保存根路径
				'savePath' => '', //保存路径
				'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
				'saveExt'  => '', //文件保存后缀，空则使用原后缀
				'replace'  => false, //存在同名是否覆盖
				'hash'     => true, //是否生成hash编码
				'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
		);
		$Upload = new Upload($config,'Local');
		$info  = $Upload->upload($_FILES);
		if($info){
			$return['data'] = array_values($info);
			$return['data'] = $return['data'][0];
		}else{
			$return['info'] = $Upload->getError();
			$return['status'] = 0;
		}
		echo json_encode($return);
	}
}