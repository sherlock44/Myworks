<?php
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminBase;
class ProjectController extends AdminBase {
    //列表
    public function index(){
		$news  =   M('anli');
		$datas = $news->select();
		$this->data = $datas;
        $this->display();
    }
    //添加
    public function add(){
        $this->display();
    }
    //编辑
    public function edit(){
		$map['id'] = $_GET['id'];
		$news  =   M('anli');
		$data = $news->where($map)->select();
		$this->data = $data;
        $this->display();
    }
    //删除
    public function delete(){
		$id = $_GET['id'];
		$news = M('anli');
		$result = $news->where('id='.$id)->delete();
		if($result) {
			$this->success('删除成功！');
		}else{
			$this->error('删除失败！');
		}
    }
	public function update(){
		$id = $_POST['id'];
		$data['title'] = $_POST['title'];
		$data['content'] = $_POST['content'];
		$data['cTime'] = time();
		$data['many'] = 0;
		$data['link'] = $_POST['link'];
		$data['newsType'] = "互动案例";

		if($_FILES['imgfile']['size']!=0){
			$path = 'Uploads/anli/';
			if(!file_exists($path))
			{  
				//检查是否有该文件夹，如果没有就创建，并给予最高权限  
				mkdir("$path", 0700,true);  
			}//END IF 
			$tp = array("image/gif","image/jpeg","image/png");  
			if(!in_array($_FILES["imgfile"]["type"],$tp))
			{  
				echo "图片格式不对";
				exit;
			}
			$imagename = time().".jpg";
			$data['img'] = $imagename;
			$result=move_uploaded_file($_FILES["imgfile"]["tmp_name"],$path.$imagename);
			if(!$result){
				echo "图片上传失败";
				exit;
			}		
		}

        $news   =   M('anli');
		if($news->create()){
			$result = $news->where('id='.$id)->save($data);
            if($result){
                $this->success('更新成功！');
            }else{
                $this->error('写入错误！');
            }
		}else{
			echo "更新失败";
		}
	}
	public function insert(){
		$data['title'] = $_POST['title'];
		$data['content'] = $_POST['content'];
		$data['cTime'] = time();
		$data['many'] = 0;
		$data['link'] = $_POST['link'];
		$data['newsType'] = "互动案例";
		
		$path = 'Uploads/anli/';
		if(!file_exists($path))
		{  
			//检查是否有该文件夹，如果没有就创建，并给予最高权限  
			mkdir("$path", 0700,true);  
		}//END IF 
		$tp = array("image/gif","image/jpeg","image/png");  
		if(!in_array($_FILES["imgfile"]["type"],$tp))  
		{  
			echo "图片格式不对";
			exit;
		}
		$imagename = time().".jpg";
		$data['img'] = $imagename;
		$result=move_uploaded_file($_FILES["imgfile"]["tmp_name"],$path.$imagename);
		if(!$result){
			echo "图片上传失败";
			exit;
		}

        $news   =   M('anli');
		if($news->create()){
			$result = $news->add($data);
            if($result) {
                $this->success('操作成功！');
            }else{
                $this->error('写入错误！');
            }
		}else{
			echo "操作失败";
		}
    }
}