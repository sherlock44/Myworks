<?php
/**
 * 短信接口测试
 * lee By 2015.05.15
 * 北京泰和盈动科技有公司 版权所有
 */
class sms{  
    private $apikey = "d935f0c083f01afcbd1f1f82899d3578";
    /*
    public function send(){

        $apikey = "d935f0c083f01afcbd1f1f82899d3578";
        //$text="【云片网】您的验证码是1234";
        $mobile = "13330906436";
        $code = rand(1000,9999);//随机验证码
        //exit;
        $tpl_id = 1; //对应默认模板 【#company#】您的验证码是#code#
        
        //echo $this->send_sms($apikey,$text,$mobile);
        echo $this->tpl_send_sms($tpl_id, $tpl_value, $mobile);
        exit;
    }
    */

     /**
     * 通用接口发短信
     * apikey 为云片分配的apikey
     * text 为短信内容
     * mobile 为接受短信的手机号
     */
    public function send_sms($text, $mobile)
    {
       $apikey = $this->apikey; 
       $url="http://yunpian.com/v1/sms/send.json";
       $encoded_text = urlencode("$text");
       $post_string="apikey=$apikey&text=$encoded_text&mobile=$mobile";
       return $this->sock_post($url, $post_string);
    }
	 /**
     * 采购发送信息
     * apikey 为云片分配的apikey
     * text 为短信内容
     * mobile 为接受短信的手机号
     */
    public function send_sys_message($content,$mobile)
    {
	
	   $tpl_value	=	"#code#=".$content;
	   
       $apikey = $this->apikey; 
      $url="http://yunpian.com/v1/sms/tpl_send.json";
       $encoded_tpl_value = urlencode("$tpl_value");
       $post_string="apikey=$apikey&tpl_value=$encoded_tpl_value&mobile=$mobile&tpl_id=949361";
       return $this->sock_post($url, $post_string);
    }
	 /**
     * 加盟商退货发送信息
     * apikey 为云片分配的apikey
     * text 为短信内容
     * mobile 为接受短信的手机号
     */
    public function send_orderback_message($content,$mobile)
    {
	   $tpl_value	=	"#code#=".$content;
	   
       $apikey = $this->apikey; 
      $url="http://yunpian.com/v1/sms/tpl_send.json";
       $encoded_tpl_value = urlencode("$tpl_value");
       $post_string="apikey=$apikey&tpl_value=$encoded_tpl_value&mobile=$mobile&tpl_id=952661";
       return $this->sock_post($url, $post_string);
    }
	 /**
     * 加盟商订货发送信息
     * apikey 为云片分配的apikey
     * text 为短信内容
     * mobile 为接受短信的手机号
     */
    public function send_order_message($content,$mobile)
    {
	   $tpl_value	=	"#code#=".$content;
	   
       $apikey = $this->apikey; 
      $url="http://yunpian.com/v1/sms/tpl_send.json";
       $encoded_tpl_value = urlencode("$tpl_value");
       $post_string="apikey=$apikey&tpl_value=$encoded_tpl_value&mobile=$mobile&tpl_id=952663";
       return $this->sock_post($url, $post_string);
    }
	 /**
     * 用户充值成功后发送消息通知
     * apikey 为云片分配的apikey
     * text 为短信内容
     * mobile 为接受短信的手机号
     */
    public function send_card_sms($money,$shop,$mobile)
    {
	   $tpl_value	=	"#code#=".$money."&#shop#=".$shop."&#time#=".date("Y-m-d H:i:s");
	   
       $apikey = $this->apikey; 
      $url="http://yunpian.com/v1/sms/tpl_send.json";
       $encoded_tpl_value = urlencode("$tpl_value");
       $post_string="apikey=$apikey&tpl_value=$encoded_tpl_value&mobile=$mobile&tpl_id=871327";
       return $this->sock_post($url, $post_string);
    }
    /**
     * 模板接口发短信
     * tpl_id 为模板id
     * code   验证码
     * mobile 为接受短信的手机号
     */
    public function tpl_send_sms($tpl_id=1, $code, $mobile)
    {

       $tpl_value = "#company#=云片网&#code#=".$code;
       $apikey = $this->apikey;
       $url="http://yunpian.com/v1/sms/tpl_send.json";
       $encoded_tpl_value = urlencode("$tpl_value");  //tpl_value需整体转义
       $post_string="apikey=$apikey&tpl_id=$tpl_id&tpl_value=$encoded_tpl_value&mobile=$mobile";
       return $this->sock_post($url, $post_string);
    }
    private function sock_post($url,$query){
	  //ob_start();
      $data = "";
      $info=parse_url($url);
      $fp=@fsockopen($info["host"],80,$errno,$errstr,30);
      if(!$fp){
         return $data;
      }
      $head="POST ".$info['path']." HTTP/1.0\r\n";
      $head.="Host: ".$info['host']."\r\n";
      $head.="Referer: http://".$info['host'].$info['path']."\r\n";
      $head.="Content-type: application/x-www-form-urlencoded\r\n";
      $head.="Content-Length: ".strlen(trim($query))."\r\n";
      $head.="\r\n";
      $head.=trim($query);
      $write=fputs($fp,$head);
      $header = "";
      while ($str = trim(fgets($fp,4096))) {
         $header.=$str;
      }
      while (!feof($fp)) {
         $data .= fgets($fp,4096);
      }
      return $data;
	 // ob_clean();
   }

   

    
}
