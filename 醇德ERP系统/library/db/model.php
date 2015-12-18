<?php
require_once LIBRARY_PATH . 'db/abstract.php';
class model extends dbAbstract {
	/**
	 * $tableName 属性用于指定 Model 是操作哪一个数据表,默认是主表
	 *
	 * @var string
	 */
	var $_tableName = '';

	/**
	 * $primaryKey 属性指定要操作的数据表的主键字段名
	 *
	 * @var string
	 */
	var $_primaryKey = '';

}
?>