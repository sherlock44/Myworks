<?php

/*
 * script 操作助手
 */

class js {

	/**
	 * 弹出对话框
	 */
	function msg($msg) {
		echo "<script>alert('" . $msg . "');";
		echo "</script>";
	}

	/**
	 * 弹出对话框
	 */
	function alert($msg = '', $url = '', $num = 3) {
		if ($url) {
			$jump = "window.location.href='" . $url . "';";
		} else {
			$jump = 'window.history.back(-1);';

		}

		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>信息提示</title>
<link href="/public/assets/sysadmin/css/js.css" rel="stylesheet" />
</head>
<SCRIPT language=javascript>
var secs=' . $num . ';//3秒
for(i=1;i<=secs;i++)
{ window.setTimeout("update(" + i + ")", i * 1000);}
function update(num)
{
if(num == secs)
{ ' . $jump . ' }
else
{ }
}
</SCRIPT>
<body>
 <br>
<br>
<br>
<br>
<br>
<br>
<table width="500" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header">
    <td height="25"><div align="center">信息提示</div></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="80">
      <div align="center">
      <br>
        <b>' . $msg . '</b>
        <br>
        <br><a href="javascript:' . $jump . '">如果您的浏览器没有自动跳转，请点击这里</a>
<br><br>
      </div></td>
  </tr>
</table>
</body>
</html>';
		echo $html;

		/*echo "<script>alert('" . $msg . "');";
	echo empty($url) ? "window.history.go($num)" : "window.location.href='$url'";
	echo "</script>";*/
	}
	/**
	 * 全页面跳转
	 */
	function targetRedirect($url) {
		echo "<script>window.open('" . $url . "', '_target')</script>";
	}

	/**
	 * 父窗口跳转
	 */
	function parentRedirect($url) {
		echo "<script>window.parent.location.href='" . $url . "';</script>";
	}

	/**
	 * 本页面跳转
	 */
	function location_href($url) {
		echo "<script>location.href = '" . basename($url) . "'</script>";
	}

	/**
	 * 本页面关闭
	 */
	function close() {
		echo "<script>window.close();</script>";
	}

	/**
	 * 父窗口刷新,子窗口关闭
	 */
	function parentReload($url) {
		echo "<script>window.opener.location.href='" . $url . "';window.close()</script>";
	}
	/**
	 *切割字符串
	 */
	function cutString($string, $size, $isadd = 1) {
		$tp = $string = strip_tags($string);

		if (mb_strlen($string) > $size) {
			$string = mb_substr($string, 0, $size, 'utf-8');
		}
		if ($tp != $string && $isadd == 1) {
			$string .= "…";
		}

		return $string;
	}

}