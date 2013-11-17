<?php
/**************************************************
*  Created:  2010-06-08
*
*  文件IO操作
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

class saefile_io
{
	var $err = "";
	var $storage;
	var $logType = 'io';
	
	function saefile_io() {
		$this->storage = new SaeStorage();
	}
	
	function adp_init($config=array()) {
		
	}
	
	
	function write($file, $data, $append = false)
	{
		$log_func_start_time = microtime(TRUE);
		$len = $this->storage->write(SAE_DOMAIN,md5($file),$data);
		
		LogMgr::warningLog($log_func_start_time, $this->logType, "[write]file=$file&result=$len", LOG_LEVEL_WARNING);
		LOGSTR($this->logType, "[write]file=$file&result=$len", LOG_LEVEL_INFO, array(), $log_func_start_time);
		return $len;
	}
	
	
	function read($file) 
	{
		$log_func_start_time = microtime(TRUE);
		$result = $this->storage->read(SAE_DOMAIN,md5($file));
		
		LogMgr::warningLog($log_func_start_time, $this->logType, "[read]file=$file", LOG_LEVEL_WARNING);
		LOGSTR($this->logType, "[read]Input:file=$file", LOG_LEVEL_INFO, array(), $log_func_start_time);
		return $result;
	}
	
	
	function ls($dir,$r=false,$info=false) 
	{
		LOGSTR($this->logType, "[ls]Input: dir=$dir&recursion=$r&info=$info", LOG_LEVEL_INFO);
		$log_func_start_time = microtime(TRUE);
		
		if (empty($dir)) $dir = '.';
		if(!file_exists($dir) || !is_dir($dir)){return false;}
		$fs = array();
		$ds = array($dir);
		while(count($ds)>0){
			foreach($ds as $i=>$d){
				unset($ds[$i]);
				$handle = opendir($d);
				while (false !== ($item = readdir($handle))) {
					if ($item == '.' || $item == '..') continue;
					$fp = ( $d=='.' || $d=='.\\' ||  $d=='./'  ) ? $item :  $d.DIRECTORY_SEPARATOR.$item;
					$t =  is_file($fp) ? 'f' : (is_dir($fp) ? 'd' : 'o');
					if (is_dir($fp) && $r) { $ds[]=$fp; }
					$fs[] = ($info ? array($t,$fp,$this->info($fp)) : array($t,$fp));
				}
			}
		}
		
		LogMgr::warningLog($log_func_start_time, $this->logType, "[ls]dir=$dir&recursion=$r&info=$info", LOG_LEVEL_WARNING);
		LOGSTR($this->logType, "[ls]Output", LOG_LEVEL_INFO, $fs, $log_func_start_time);
		return $fs;
	}
	
	
	function info($path=".",$key=false) 
	{
		$path = realpath($path);
		if (!$path) false;
		$result = array(
			"name"		=> substr($path, strrpos($path, DIRECTORY_SEPARATOR)+1),
			"location"	=> $path,
			"type"		=> is_file($path) ? 1 : (is_dir($path) ? 0 : -1),
			"size"		=> filesize($path),
			"access"	=> fileatime($path),
			"modify"	=> filemtime($path),
			"change"	=> filectime($path),
			"read"		=> is_readable($path),
			"write"		=> is_writable($path)
			);
		clearstatcache();
		
		LOGSTR($this->logType, "[info]Input:path=$path&key=$key", LOG_LEVEL_INFO, array('Output'=>$key?$result[$key]:$result));
		return $key ? $result[$key] : $result;
	}
}
?>