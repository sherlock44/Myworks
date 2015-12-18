<?php
namespace Home\Controller;
use Think\Controller;
use Org\Util;
use Org\Util\String;
class ActivityController extends Controller {
    public function index(){
    	$activity = M('activity');
    	$list = $activity->field('id,title,summary,cover')->where(array('top'=>1,'status'=>1))->order('id')->limit(2)->select();
    	// $classList = array('yellow','white','blue','blue_s','white_s');
    	// $dataStr = '';
    	// foreach ($list as $key=>$row)
    	// {
    	// 	$dataStr .= '<div class="'.$classList[$key].'"><a href="'.U('Activity/detail?id='.$row['id']).'">'.$row['title'].'</a></div>';
    	// }
    	$this->assign('data',$list);
        $this->display();
    }

    public function detail(){
    	$id = isset($_GET['id']) ? intval($_GET['id']) : $this->error('参数错误');
    	$activity = M('activity');
    	$data = $activity->where(array('id'=>$id,'status'=>1))->find();
    	if(!$data){
    		$this->error('没有该数据');
    	}
    	$this->assign('data',$data);
        $this->display();
    }

    public function lists(){
    	$activity = M('activity');
    	$list = $activity->field('id,title,summary,cover')->where(array('status'=>1))->order('id')->limit(20)->select();
    	foreach($list as &$row){
    		$row['summary'] = String::msubstr(trim(strip_tags($row['summary'])),0,28,"utf-8",false);
    	}
    	$this->assign('data',$list);
        $this->display();
    }

    public function more(){
        $activity  =   M('activity');
        $data = $activity->select();
        $data = array_slice($data, 2);
        $this->ajaxReturn($data);
    }
}