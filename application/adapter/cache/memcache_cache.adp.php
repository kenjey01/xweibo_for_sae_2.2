<?php
/**************************************************
*  Created:  2010-06-08
*
*  memcached缓存
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

class memcache_cache
{
	var $enable;
	var $obj;
	var $keyPre;
	var $logType = 'cache';

	function memcache_cache() {
	}

	
	function adp_init($config=array()) 
	{
		$log_func_start_time = microtime(TRUE);
		
		if(!empty($config['servers'])) {
			$this->obj = new Memcache;

			$servers = explode(' ', trim($config['servers']));

			$connect = false;

			foreach ($servers as $server) {
				if (empty($server)) {
					continue;
				}

				$param = explode(':', $server);
				// @todo 是否使用多台服务器
				$connect = $connect || @$this->obj->addServer($param[0], $param[1], $config['pconnect']);
				if (!$connect) {
					LOGSTR($this->logType, '[adp_init]memcache add server error', LOG_LEVEL_ERROR, $config);
				}
			}

			$this->enable = $connect ? true : false;
			$this->keyPre = $config['keyPre'];
			LOGSTR($this->logType, "[adp_init]mc adp_init success", LOG_LEVEL_INFO, $config, $log_func_start_time);
		}
		LogMgr::warningLog($log_func_start_time, $this->logType, "[adp_init]mc adp init", LOG_LEVEL_WARNING, $config);
	}

	
	function get($key) 
	{
		$log_func_start_time = microtime(TRUE);
		
		$key 	= $this->_feaKey($key);
		$result = $this->obj->get($key);
		
		LogMgr::warningLog($log_func_start_time, $this->logType, "[get]Key=$key", LOG_LEVEL_WARNING);
		LOGSTR($this->logType, "[get]Input:Key=$key&Output=", LOG_LEVEL_INFO, $result, $log_func_start_time);
		return $result;
	}

	
	function set($key, $value, $ttl = 0) 
	{
		$log_func_start_time = microtime(TRUE);
		
		$key = $this->_feaKey($key);
		$rst = $this->obj->set($key, $value, MEMCACHE_COMPRESSED, $ttl);
		if (!$rst) {
			LOGSTR($this->logType, '[set]memcache add server error', LOG_LEVEL_ERROR, array('key'=>$key, 'value'=>$value, 'ttl'=>$ttl));
		}
		
		LogMgr::warningLog($log_func_start_time, $this->logType, "[set]Key=$key&ttl=$ttl&Output=$rst", LOG_LEVEL_WARNING);
		LOGSTR($this->logType, "[set]Input:Key=$key&ttl=$ttl&Output=$rst", LOG_LEVEL_INFO, array(), $log_func_start_time);
		return $rst;
	}

	
	function delete($key) 
	{
		$log_func_start_time = microtime(TRUE);
		
		$key   = $this->_feaKey($key);
		$rsult = $this->obj->delete($key, 0);
		
		LogMgr::warningLog($log_func_start_time, $this->logType, "[delete]Key=$key&Output=$rsult", LOG_LEVEL_WARNING);
		LOGSTR($this->logType, "[delete]Input:Key=$key&Output=$rsult", LOG_LEVEL_INFO, array(), $log_func_start_time);
		return $rsult;
	}
	
	function _feaKey($key) {
		return md5($this->keyPre . $key);
	}	
}

?>
