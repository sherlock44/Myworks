<?
/**
 * 用户认证类
 * author:David Yan (yanwd@ivysoft.com.cn)
 * @version $Id: Config.php  2012-04-11 23:00:00Z David Yan $
 */
class acl
{
	/**
	 * 设置COOKIE
	 *
	 * @param array $data 数据
	 * @param int $saveDay 要保存的天数
	 */
    static function setCookie($cookieName,$data,$saveDay=0)
    {
        $dataEncode = base64_encode(serialize($data));

        if($saveDay){
        	setcookie($cookieName,  $dataEncode, time()+($saveDay*86400),"/");
        } else {
        	setcookie($cookieName,  $dataEncode, time()+3600*24,"/");
        }
    }

    /**
     * 读取COOKIE
     */
    static function getCookie($cookieName)
    {
        $data = isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : '';
        return @unserialize(base64_decode($data));
    }

    /**
     * 删除COOKIE
     */
    static function delCookie($cookieName){
    	setcookie($cookieName,  "", time()-3600,"/");
    }

    /**
     * COOKIE 是否存在
     *
     * @return bool 是否存在
     */
    static function isCookie($cookieName){
    	if(empty($_COOKIE[$cookieName])){
    		return false;
    	} else {
    		return true;
    	}
    }

    /**
     * 用户是否登陆并跳转
     */
    static function checkLogin($cookieName='',$gotoUrl=''){
        $cookieName = empty($cookieName) ? COOKIE_NAME : $cookieName;
        $gotoUrl = empty($gotoUrl) ? ACL_LOGIN_URL : $gotoUrl;

    	if(!acl::isCookie($cookieName)){
    		header('location:'.$gotoUrl);
    	} else {
    		$cookieArray =  acl::getCookie($cookieName);
            if(is_array($cookieArray)){
                return $cookieArray;
            } else {
                header('location:'.$gotoUrl);
            }
    	}
    }

    public static function checkMasterLogin(){
        if(empty($_SESSION['admininfo']) || $_SESSION['admininfo'] == '' || count($_SESSION['admininfo']) <= 0){
            header("location:/public/common");
        }
    }

    /**
    * @desc 判断方法、链接是否可用
    * @desc $identification 标识符
    * @desc $parame = array(url,title,target,modal,name,imgurl)
    */
    public static function checkPermission($identification,$parame=array()){
        $userInfo   =  acl::getCookie('hicourse');
        $permission =  $userInfo['permission'];
        $flag = false;
        if(in_array($identification,$permission)){
             if($parame){
             $url    = empty($parame['url'])?'':$parame['url']; //a 链接
             $title  = empty($parame['title'])?'':$parame['title']; //a title
             $target = empty($parame['target'])?'':'target="'.$parame['target'].'"';//a 新窗口打开
             $modal  = empty($parame['modal'])?'':'data-toggle="modal"';//是否弹出层
             $name   = empty($parame['name'])?'':$parame['name'];//a 点击名字
             $imgurl = empty($parame['imgurl'])?'':'<img src="'.$parame['imgurl'].'" width=20>';//是否要图片
             echo "<a $modal href='".$url."' $target title='".$title."'>$imgurl$name</a>";

            }else{
              $flag = true;
            }
        }
        return $flag;
    }

}
