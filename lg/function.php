<?php
// php获取当前访问的完整url地址
function getCurUrl() {
	$url = 'http://';
	if (isset ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] == 'on') {
		$url = 'https://';
	}
	if ($_SERVER ['SERVER_PORT'] != '80') {
		$url .= $_SERVER ['HTTP_HOST'] . ':' . $_SERVER ['SERVER_PORT'] . $_SERVER ['REQUEST_URI'];
	} else {
		$url .= $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
	}
	// 兼容后面的参数组装
	if (stripos ( $url, '?' ) === false) {
		$url .= '?t=' . time ();
	}
	return $url;
}

//获取微信用户信息
function getUserInfo($callback){
	if(!isset($_GET ['state'])){
		$param ['appid'] = WECHAT_APPID;
		$param ['redirect_uri'] = $callback;
		$param ['response_type'] = 'code';
		$param ['scope'] = 'snsapi_userinfo';
		$param ['state'] = 'abc';
		$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?'.http_build_query ($param).'#wechat_redirect';
		header('Location: '.$url);
	}elseif('abc' == trim($_GET ['state'])){
		if(!isset($_GET['code'])){
			exit('好吧,如你所愿~但是你要继续参与活动,必须在授权页面点击确认授权按钮');
		}
		$param ['appid'] = WECHAT_APPID;
		$param ['secret'] = WECHAT_APP_SECRET;
		$param ['code'] = $_GET['code'];
		$param ['grant_type'] = 'authorization_code';
		$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?'.http_build_query($param);
		$content = file_get_contents ( $url );
		$content = json_decode ( $content, true );
		if(isset($content['errcode'])){
			exit('获取access_token失败');
		}
		//获取用户信息
		$url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$content['access_token'].'&openid='.$content['openid'].'&lang=zh_CN';
		$content = file_get_contents ( $url );
		$content = json_decode ( $content, true );
		if(isset($content['errcode'])){
			exit('获取用户信息失败');
		}
		return $content;
	}
}
//二维数组根据制定键值排序,默认升序(ASC),降序(DESC)
function arrOrder($arr,$key,$order='ASC')
{
	$tempArr = array();
	foreach($arr as $k=>$r){
		$tempArr[$k] = $r[$key];
	}
	if('ASC' == $order){
		asort($tempArr);
	}else{
		arsort($tempArr);
	}	
	reset($tempArr);
	$newArr = array();
	foreach($tempArr as $k=>$r){
		$newArr[$k] = $arr[$k];
	}
	return $newArr;
}