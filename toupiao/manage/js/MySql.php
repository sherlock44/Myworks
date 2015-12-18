<?php
header('Content-Type: application/json; charset=UTF-8');

if ( empty($_REQUEST['database']) ) {
	exit('{"status":false,"error":"未选择数据库!"}');
};

if ( empty($_REQUEST['sql']) ) {
	exit('{"status":false,"error":"没有需要执行的sql!"}');
};

$server = empty($_REQUEST['server']) ? 'localhost' : $_REQUEST['server'] ;
$username = empty($_REQUEST['user']) ? 'root' : $_REQUEST['user'] ;
$password = empty($_REQUEST['password']) ? null : $_REQUEST['password'] ;

$database = $_REQUEST['database'];
$sql = $_REQUEST['sql'];

@mysql_connect($server, $username, $password);
if (mysql_errno()!=0) {
	exit(json_encode(array('status'=>false,'error'=>mysql_error())));
}

@mysql_set_charset('utf8');
if (mysql_errno()!=0) {
	exit(json_encode(array('status'=>false,'error'=>mysql_error())));
}

@mysql_select_db($database);
if (mysql_errno()!=0) {
	exit(json_encode(array('status'=>false,'error'=>mysql_error())));
}

@$result = mysql_query($sql);
if (mysql_errno()!=0) {
	exit(json_encode(array('status'=>false,'error'=>mysql_error())));
}

if(is_bool($result)) {
	exit(json_encode(array('status'=>$result,'affected'=>mysql_affected_rows(),'insertId'=>mysql_insert_id())));
}

$data = array();
while ($rowData=mysql_fetch_object($result)) {
	$data[] = $rowData;
}

if (mysql_errno()!=0) {
	exit(json_encode(array('status'=>false,'error'=>mysql_error())));
}

echo json_encode( array( 'status'=>true,'data'=>$data ) );

