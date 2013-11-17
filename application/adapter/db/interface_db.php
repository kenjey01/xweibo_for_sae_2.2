<?php
/**************************************************
*  Created:  2010-06-08
*
*  数据库接口 
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author zhenquan <zhenquan@staff.sina.com.cn>
*
***************************************************/

class interface_db 
{

	function getPrefix() {
		return $this->prefix;
	}

	function adp_init($params) {
		$this->params = $params;
		$this->prefix = $params['tbpre'];
	}
	
	function setTable($table) {
		$this->table = $table;
	}
	
	/**
	 * get table name
	 * @param $table_name string tablename
	 * @param $tb_prefix sting prefix of table
	 * @return string
	 */
	function getTable($table_name='', $tb_prefix='') {
		if (empty($tb_prefix)) {
			$tb_prefix = $this->getPrefix();
		}
		$table_name = trim($table_name);
		$table_name = $table_name == ''? $this->table : $table_name;
		return $tb_prefix . $table_name;
	}
	
	function pushSql($sql) {
		array_push($this->querys, $sql);
		return $this->last_sql = $sql;
	}

	/**
	 * set auto free query result
	 *
	 */
	function setAutoFree($v) {
		$this->autoFree = (bool)$v;
	}

	/**
	 * return escape value
	 * @param $str string
	 * @return string
	 */
	function escape($str) {}

	/**
	 * return last insert id
	 */
	function getInsertId() {}

	/**
	 * get info by row id
	 * @param $id int query row id
	 * @param $table string table name
	 * @param $id_name string field name(primary key)
	 */
	function get($id, $table='', $id_name = 'id') {}
	
	/**
	 * delete info
	 * @param $id int|array row id
	 * @param $table string table name
	 * @param $id_name string field name(primary key)
	 * @return int|false 
	 */
	function delete($id, $table = '', $id_name = 'id') {}
	
	/**
	 * insert or update table
	 * @param $data key/value array data
	 * @param $id int update id
	 * @param $table string table name
	 * @param $id_name string field name(primary key)
	 * @return int|false lastinsert id or update id
	 */
	function save($data, $id = '', $table = '', $id_name = 'id') {}
	
	/**
	 * execute sql
	 * @param $sql string SQL
	 * @return void
	 */
	function execute($sql) {}
	
	/**
	 * 
	 * @return int affected rows
	 */
	function getAffectedRows() {}
	
	/**
	 * execute SQL and return result
	 * @param $sql string SQL
	 * @return array
	 */
	function query($sql) {}
	/**
	 * return the first field of a row
	 * @param $sql string SQL
	 * @return mixed
	 */
	function getOne($sql, $index=0) {}

	/**
	 * retun a row
	 * @param $sql string SQL
	 * @param array
	 */
	function getRow($sql) {}
	
	/**
	 * return last query SQL
	 * @return string last query SQL
	 */
	function getLastQuery() {
		return $this->last_sql;
	}

	function getError() {}
	
	/**
	 * free query result
	 * @param int query handle
	 */
	function free($query_id="") {}

	/**
	 * close connection
	 */
	function close() {}
	
	/**
	 * return query history SQL
	 * @return array
	 */
	function getHistory() {
		return $this->querys;
	}

	/**
	 * 调用框架日志接口写日志
	 *@param $msg string log message
	 *@param $type 错误类型
	 */
	function log($msg, $extra=array()) {
		LOGSTR('db', $msg, LOG_LEVEL_ERROR, $extra);
	}
	
	function infoLog($msg, $extra=array(), $startTime=false) {
		LOGSTR('db', $msg, LOG_LEVEL_INFO, $extra, $startTime);
	}
	
	function waringLog($startTime, $msg, $extra=array()) 
	{
		$used	 = microtime(TRUE)-$startTime;
		$longExe = $startTime && LOG_DB_WARNING_TIME && $used>LOG_DB_WARNING_TIME;
		if ($longExe) {
			LOGSTR('db', $msg." Used=$used", LOG_LEVEL_WARNING, $extra);
		}
	}
}
