<?php

/////////////////////////////////////////////////////////////////////////////
// Framework
//
// Copyright (c) 2009 Yan weidong
//
/////////////////////////////////////////////////////////////////////////////

/**
 * Db_Abstract 数据库操作类
 *
 * @package Framework
 * @version $Id: Abstract.php 256 2008-03-16 19:20:53Z yan weidong $
 */
require_once 'adapter/pdo.php';
abstract class dbAbstract extends dbAdapterPdo {

	/**
	 * 连接数据库服务器
	 *
	 *
	 */
	public function initDb() {
		global $configs;
		// 连接数据库
		$this->Connect($configs['database']['data']);
	}

	/*
	 * 初始化表
	 */
	function initTable($tableName, $primaryKey) {
		$this->_tableName = $tableName;
		$this->_primaryKey = $primaryKey;
	}

	/**
	 * 从数据库中找出满足条件的数据
	 *
	 * @param string $fields       字段名,默认:*
	 * @param string $conditions   条件值，例：UID=1
	 * @param string $orderby      排序方式，例: UID Desc
	 * @param string $offset       指针开始行数,默认为:0;
	 * @param string $limit        返回多少行;
	 * @param string $fetch        0返回所有，1返回一条
	 * @return array
	 */
	public function select($fields = '*', $conditions = '', $orderby = '', $offset = '0', $limit = '', $fetch = 0) {
		if (!empty($conditions)) {
			$where = " WHERE " . $conditions;
		}
		if (!empty($orderby)) {
			$orderby = " ORDER BY " . $orderby;
		}
		if (!empty($limit)) {
			$limit = " LIMIT " . $offset . " , " . $limit;
		}
		$sql = " SELECT " . $fields . " FROM " . $this->_tableName . @$where . $orderby . $limit;
		//echo $sql;
		//echo "<br>";
		if (!$fetch) {
			$Row = $this->fetchAll($sql);
		} else {
			$Row = $this->fetchRow($sql);
		}
		return $Row;
	}

	public function selectOne($fields = '*', $conditions = '', $orderby = '') {
		if (!empty($conditions)) {
			$where = " WHERE " . $conditions;
		}
		$sql = " SELECT " . $fields . " FROM " . $this->_tableName . @$where . ' LIMIT 1';
		$Row = $this->fetchRow($sql);
		return $Row;
	}

	/**
	 * 计算条目数
	 * @param string $conditions 条件
	 * @return intger 个数
	 */
	public function selectCnt($conditions = '', $fields = '') {
		if (!$fields) {
			$fields = $this->_primaryKey;
		}

		$res = $this->select('count(' . $fields . ') as cnt', $conditions, '', '', '', 1);
		return $res['cnt'];
	}

	/**
	 * 取一键一职数组
	 * @param string $key
	 * @param string $val
	 * @param string $conditions
	 * @return array
	 */
	public function selectAssoc($key, $val, $conditions = '') {
		$res = $this->select($key . ',' . $val, $conditions);
		foreach ($res as $item) {
			$arr[$item[$key]] = $item[$val];
		}

		return isset($arr) ? $arr : '';
	}

	/**
	 * 在指定的表中插入一条数据
	 *
	 * @param array $data                数据集 $data(`字段名`=>'字段值'，.....)
	 */
	public function insert($data) {
		$field = '';
		$values = '';
		foreach ($data as $key => $value) {
			$field .= "`" . $key . "`,";
			if (substr($value, -2) === "()") {
				$values .= $value . ",";
			} else {
				$values .= "'" . $this->escape_str($value) . "',";
			}

		}
		$sql = "INSERT INTO " . $this->_tableName . " (" . substr($field, 0, -1) . ") VALUES (" . substr($values, 0, -1) . ")";
		$this->execSql($sql);
		return $this->insertId();
	}

	/**
	 * 更新一条指定的数据
	 *
	 * @param string $table_name
	 * @param array $data
	 * @param string $conditions
	 */
	public function update($data, $conditions) {

		$dataSql = '';
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$dataSql .= "`" . $key . "` = '" . $this->escape_str($value) . "',";
			}
			$dataSql = substr($dataSql, 0, -1);
		} else {
			$dataSql = $data;
		}

		$sql = "UPDATE " . $this->_tableName . " SET " . $dataSql;

		if ((int) $conditions != 0) {
			$sql .= " WHERE " . $this->_primaryKey . '=' . $conditions;
		} else {
			$sql .= " WHERE " . $conditions;
		}
		//echo $sql;exit;
		$this->execSql($sql);
		return $this->affectedRows();
	}

	/**
	 * 删除满足条件的数据
	 *
	 * @param string $table_name
	 * @param string $conditions
	 */
	public function delete($conditions) {
		$sql = "DELETE FROM " . $this->_tableName;
		if ((int) $conditions != 0) {
			$sql .= " WHERE " . $this->_primaryKey . '=' . $conditions;
		} else {
			$sql .= " WHERE " . $conditions;
		}

		$this->execSql($sql);
		return $this->affectedRows();
	}
	public function sqlexec($sql) {
		$this->execSql($sql);
		return $this->affectedRows();
	}
	// --------------------------------------------------------------------

	/**
	 * Escape String
	 *
	 * @access	public
	 * @param	string
	 * @param	bool	whether or not the string will be used in a LIKE condition
	 * @return	string
	 */
	function escape_str($str, $like = FALSE) {
		/*
		if (is_array($str)) {
		foreach ($str as $key => $val) {
		$str[$key] = $this->escape_str($val, $like);
		}

		return $str;
		}

		if (function_exists('mysql_real_escape_string') AND is_resource($this->_Link)) {
		$str = mysql_real_escape_string($str, $this->_Link);
		} elseif (function_exists('mysql_escape_string')) {
		$str = mysql_real_escape_string($str);

		} else {
		$str = addslashes($str);
		}

		// escape LIKE condition wildcards
		if ($like === TRUE) {
		$str = str_replace(array('%', '_'), array('\\%', '\\_'), $str);
		}
		 */
		$str = addslashes($str);
		return $str;
	}

	/**
	 * 分表处理(取基数的最后一个字符)
	 *
	 * @param string $table_prefix        表前缀
	 * @param string $pattern             基数
	 * @return string                     新表名
	 */
	public function splitTable($pattern = '') {
		if (!empty($pattern)) {
			if (substr($this->_tableName, -2, -1) != '_') {
				$this->_tableName = $this->_tableName . '_' . substr($pattern, -1);
			} else {
				$this->_tableName = substr($this->_tableName, 0, strlen($this->_tableName) - 2) . '_' . substr($pattern, -1);
			}

		}
	}

	/**
	 * @desc 根据条件查询一个字段数据，返回一维数组
	 * @param $filed 字段名
	 * @param $where 条件
	 */
	function getOneFiled($filed = '', $where) {
		if (empty($filed)) {
			$filed = $this->_primaryKey;
		}

		$result = $this->select($filed, $where);
		$array = array();
		foreach ($result as $v) {
			$array[] = $v[$filed];
		}
		return $array;
	}

}