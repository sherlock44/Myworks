<?php
namespace Home\Controller;
use Think\Controller;
use Org\Util;
use Org\Util\String;
class ActivityController extends Controller {
    public function index(){
    	$activity = M('activity');
    	$list = $activity->field('id,title')->where(array('top'=>1))->order('id')->limit(5)->select();
    	$classList = array('yellow','white','blue','blue_s','white_s');
    	$dataStr = '';
    	foreach ($list as $key=>$row)
    	{
    		$dataStr .= '<div class="'.$classList[$key].'"><a href="'.U('Activity/detail?id='.$row['id']).'">'.$row['title'].'</a></div>';
    	}
    	$this->assign('data',$dataStr);
        $this->display();
    }

    public function detail(){
    	$id = isset($_GET['id']) ? intval($_GET['id']) : $this->error('参数错误');
    	$activity = M('activity');
    	$data = $activity->where(array('id'=>$id))->find();
    	if(!$data){
    		$this->error('没有该数据');
    	}
    	$this->assign('data',$data);
        $this->display();
    }

    public function lists(){
    	$activity = M('activity');
    	$list = $activity->order('id')->limit(5)->select();
    	foreach($list as &$row){
    		$row['content'] = String::msubstr(trim(strip_tags($row['content'])),0,28);
    	}
    	$this->assign('data',$list);
        $this->display();
    }
}