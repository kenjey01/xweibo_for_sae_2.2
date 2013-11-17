<?php
/**************************************************
*  Created:  2010-06-08
*
*  FTP操作
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

class db_log
{
	var $logLevel = array('error'=>1, 'warning'=>2, 'info'=>3);
	static $logList;
	
	function db_log() {

	}

	function adp_init($config=array()) {

	}

	
	function log($type, $str, $level='info', $extra_params=array())
	{
		if ( $this->_needLog($level) )
		{
			// 入搜集日志队列
			$db 		= APP::ADP('db');
			$str		= $db->escape($str);
			$extraStr 	= (is_array($extra_params) && !empty($extra_params)) ? serialize($extra_params) : '';
			$extraStr	= $db->escape( substr($extraStr, 0, 400) );
			$tableName 	= $this->_getLogTableName($type, $level);
			self::$logList[$tableName]['key'] 		= '(`soft`, `version`, `akey`, `type`, `level`, `msg`, `extra`, `log_time`)';
			self::$logList[$tableName]['value'][] 	= "('".WB_SOFT_NAME."','". WB_VERSION."','". WB_AKEY."','$type','$level','$str','$extraStr','".date("Y-m-d H:i:s")."')";
		}
	}
	
	
	/**
	 * Level filter
	 * @param $level, 当前日志等级
	 */
	function _needLog($level)
	{
		if ( LOG_LEVEL!=4 && $level=='info' && !V('g:_loginfo', false) ) {
			return false;
		}
	
		$curLevel = isset($this->logLevel[$level]) ? $this->logLevel[$level] : 0;
		
		// Level filter
		return (LOG_LEVEL && (LOG_LEVEL>=$curLevel) );
	}
	
	
	/**
	 * 获取log表名
	 * @param $type
	 * @param $level
	 */
	function _getLogTableName($type, $level)
	{
		// Api 表
		if ( 'api'==strtolower($type) )
		{
			return (LOG_LEVEL_INFO==$level) ? T_LOG_API_INFO : T_LOG_API_ERROR;
		}
		
		// 日志表
		return (LOG_LEVEL_INFO==$level) ? T_LOG_INFO : T_LOG_ERROR;
	}
	
	
	/**
	 * 写日志文件
	 */
	function run()
	{
		if ( !is_array(self::$logList) )
		{
			return true;
		}
		
		// 删除过期api日志
		$this->_clearApiLog();
		
		// 入库
		$db = APP::ADP('db');
		foreach (self::$logList as $table=>$aLog)
		{
			$table		=  $db->getTable($table);
			$key		= $aLog['key'];
			$values 	= implode(",", $aLog['value']);
			$sql		= "Insert Into $table $key Values $values";
			$db->execute($sql);
		}
	}
	
	
	/**
	 * 定时清除api错误日志
	 * @param $type
	 */
	function _clearApiLog()
	{
		// 每周一早上10点清除api错误日志
		$needClear = (date('w', APP_LOCAL_TIMESTAMP)==1) && (date('H', APP_LOCAL_TIMESTAMP)=='10');
					
		if ( $needClear )
		{
			$db 		= APP::ADP('db');
			$delDate	= date('Y-m-d H:i:s', APP_LOCAL_TIMESTAMP-3600*24*7);
			$tableList	= array(
				'apiInfo' 	=> $db->getTable(T_LOG_API_INFO),
				'apiError' 	=> $db->getTable(T_LOG_API_ERROR),
				'infoTable'	=> $db->getTable(T_LOG_INFO),
				'http'		=> $db->getTable(T_LOG_HTTP)
			);
			
			foreach ($tableList as $aTable)
			{
				$sql = "Delete From $aTable Where log_time <='$delDate'";
				$db->execute($sql);
			}
		}
	}
}
?>