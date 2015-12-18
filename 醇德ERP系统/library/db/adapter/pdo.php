<?php
/////////////////////////////////////////////////////////////////////////////
// Framework
//
// Copyright (c) 2009 Yan weidong
//
/////////////////////////////////////////////////////////////////////////////

/**
 * 定义 Db_Adapter_Mysql 类
 *
 * @package Framework
 * @version $Id: Mysql.php 256 2008-03-16 19:20:53Z yan weidong $
 */

class dbAdapterPdo {
	/**
	 * mysql服务器连接标记
	 *
	 * @var string
	 */
	public $_Link;

	/**
	 * Query请求返回的对象
	 *
	 * @var object
	 */
	public $_Query;

	/**
	 * 是否使用常连接
	 *
	 * @var bool
	 */
	public $_Persistent = false;

	/**
	 * 操作影响行数
	 *
	 * @var bool
	 */
	public $_affectedRows = 0;

	/**
	 * 数据库连接
	 *
	 * @param array $DbConfig
	 */
	function connect($Config) {

		$this->_Link = new PDO(
			"mysql:host=" . $Config['Host'] . ";port=" . $Config['Port'] . ";dbname=" . $Config['Name'],
			$Config['User'],
			$Config['Password'],
			array(
				PDO::ATTR_PERSISTENT => $this->_Persistent,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
			)
		);

		$this->_Link->exec("SET NAMES utf8");
		//$_ENV['Sql']=array();
	}

	/**
	 * 执行一个mysql请求,有记录结果返回的操作
	 *
	 * @param string $Sql //所要执行的sql语句
	 */
	function query($Sql, $Params = array(), $FETCHTYPE = 'fetchAll') {
		$_ENV['Sql'][] = $Sql; //记录sql语句。调试用。

		$sth = $this->_Link->prepare($Sql);

		@$this->_affectedRows = $sth->execute($Params);
		//$sth->fetch(PDO::FETCH_ASSOC);
		//
		//var_dump($sth);
		return $sth->$FETCHTYPE(PDO::FETCH_ASSOC);
	}

	/**
	 * 执行一个mysql请求,无记录结果返回的操作
	 *
	 * @param string $Sql //所要执行的sql语句
	 */
	function execSql($Sql) {
		$_ENV['Sql'][] = $Sql; //记录sql语句。调试用。

		$this->_affectedRows = $this->_Link->exec($Sql);
	}

	/**
	 * 执行相应的sql语句查询，返回所有的结果集
	 *
	 * @param string $Sql          所要执行的sql语句
	 * @param string $Type         所执行结果级的状态 参数的默认值是 MYSQL_ASSOC，返回一个包含关联索引的数组； 可选 MYSQL_NUM 返回一个包含数字索引的数组； MYSQL_BOTH 返回一个同时包含关联和数字索引的数组
	 * @return unknown
	 */
	function fetchAll($Sql, $Params = array()) {
		$Row = $this->Query($Sql, $Params, 'fetchAll');
		return $Row;
	}

	/**
	 * 执行相应的sql语句查询，返回第一行的结果集
	 *
	 * @param string $Sql          所要执行的sql语句
	 * @param string $Type         所执行结果级的状态 参数的默认值是 MYSQL_ASSOC，返回一个包含关联索引的数组； 可选 MYSQL_NUM 返回一个包含数字索引的数组； MYSQL_BOTH 返回一个同时包含关联和数字索引的数组
	 * @return unknown
	 */
	function fetchRow($Sql, $Params = array()) {
		$Row = $this->Query($Sql, $Params, 'fetch');
		return $Row;
	}

	/**
	 * 执行相应的sql语句查询，返回第一行的第一个字段值
	 *
	 * @param string $Sql          所要执行的sql语句
	 * @param string $Type         所执行结果级的状态 参数的默认值是 MYSQL_BOTH 返回一个同时包含关联和数字索引的数组; 可选 MYSQL_ASSOC，返回一个包含关联索引的数组；  MYSQL_NUM 返回一个包含数字索引的数组； MYSQL_BOTH 返回一个同时包含关联和数字索引的数组
	 * @return unknown
	 */
	function fetchOne($Sql, $Params = array()) {
		$Row = $this->Query($Sql, $Params, 'fetchColumn');
		return $Row;
	}

	/**
	 * 返回最后一次插入数据的主键ID
	 *
	 * @return int
	 */
	function insertId() {
		return $this->_Link->lastInsertId();
	}

	/**
	 * 取得前一次 INSERT, UPDATE, DELETE 操作所影响的记录行数
	 *
	 * @return int
	 */
	function affectedRows() {
		return $this->_affectedRows;
	}
	/**
	 * 开启事物
	 *
	 * @return int
	 */
	function beginTransaction() {
		$this->_Link->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
		$this->_Link->beginTransaction();
	}
	/**
	 * 提交事物
	 *
	 * @return int
	 */
	function beginCommit() {

		$this->_Link->commit();
	}
	/**
	 * 事物回滚
	 *
	 * @return int
	 */
	function rollbackSql() {

		$this->_Link->rollback();
	}
	/**
	 * 释放内存
	 *
	 */
	function close() {
		$this->_Query = null;
		$this->_Link = null;

	}

}