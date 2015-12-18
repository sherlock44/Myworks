<?php
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminBase;
use Think\Page;
class ActivityController extends AdminBase{
	public function index()
	{
		$activity = M('activity');
		$count = $activity->count();
		$Page = new Page($count);
		$this->assign('pager',$Page->show());
		$list = $activity->order('id')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('data',$list);
		$this->display();
	}
	//添加数据
	public function add()
	{
		if(isset($_POST['dosubmit'])){
			$title = isset($_POST['title']) ? mysql_escape_string(trim($_POST['title'])) : '';
			$status = isset($_POST['status']) ? intval($_POST['status']) : 0;
			$top = isset($_POST['top']) ? intval($_POST['top']) : 0;
			$cover = isset($_POST['cover']) ? mysql_escape_string(trim($_POST['cover'])) : '';
			$content = isset($_POST['content']) ? trim($_POST['content']) : '';
			$summary = isset($_POST['summary']) ? trim($_POST['summary']) : '';
			$link = isset($_POST['link']) ? trim($_POST['link']) : '';
			if(empty($title) || empty($cover) || empty($summary)){
				$this->error('数据没有填写完整');
			}
			$data['title'] = $title;
			$data['summary'] = $summary;
			$data['status'] = $status;
			$data['cover'] = $cover;
			$data['top'] = $top;
			$data['content'] = $content;
			$data['link'] = $link;
			$data['created'] = NOW_TIME;
			$activity = M('activity');
			if($activity->add($data)){
				$this->success('添加成功');
			}else{
				$this->error('操作失败~~');
			}
		}else{
			$this->display();
		}
	}
	//删除数据
	public function delete()
	{
		$id = isset($_GET['id']) ? intval($_GET['id']) : $this->error('参数错误');
		$activity = M('activity');
		if($activity->where(array('id'=>$id))->delete()){
			$this->success('删除数据成功~');
		}else{
			$this->error('没有删除任何数据');
		}
	}
	//编辑数据
	public function edit()
	{
		$id = isset($_GET['id']) ? intval($_GET['id']) : $this->error('参数错误');
		$activity = M('activity');
		if(isset($_POST['dosubmit'])){
			$title = isset($_POST['title']) ? mysql_escape_string(trim($_POST['title'])) : '';
			$status = isset($_POST['status']) ? intval($_POST['status']) : 0;
			$top = isset($_POST['top']) ? intval($_POST['top']) : 0;
			$cover = isset($_POST['cover']) ? mysql_escape_string(trim($_POST['cover'])) : '';
			$content = isset($_POST['content']) ? trim($_POST['content']) : '';
			$summary = isset($_POST['summary']) ? trim($_POST['summary']) : '';
			$link = isset($_POST['link']) ? trim($_POST['link']) : '';
			if(empty($title) || empty($cover) || empty($summary)){
				$this->error('数据没有填写完整');
			}
			$data['title'] = $title;
			$data['summary'] = $summary;
			$data['status'] = $status;
			$data['cover'] = $cover;
			$data['top'] = $top;
			$data['content'] = $content;
			$data['link'] = $link;
			if($activity->where(array('id'=>$id))->save($data)){
				$this->success('更新数据成功',U('Activity/index'));
			}else{
				$this->error('更新数据失败~~请重试');
			}
		}else{
			$data = $activity->where(array('id'=>$id))->find();
			if(!$data){
				$this->error('没有该数据');
			}
			$this->assign('data',$data);
			$this->display('add');
		}
	}
}