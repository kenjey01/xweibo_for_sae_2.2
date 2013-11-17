<?php
class sae_cache
{
	var $memcache;
	var $is_cache;
	function sae_cache() {
		$this->memcache = memcache_init();
		if($this->memcache){
			$this -> is_cache = true;
		}else{
			$this -> is_cache = false;
		}
	}

	function adp_init($config=array()) {
		
	}

	function get($key) {
		if($this -> is_cache){
			return memcache_get($this->memcache, MC_PREFIX.$key);
		}else{
			return false;
		}
	}

	function set($key, $value, $ttl = 0) {
		if($this -> is_cache){
			return memcache_set($this->memcache, MC_PREFIX.$key, $value, MEMCACHE_COMPRESSED, $ttl);
		}else{
			return false;
		}
	}

	function delete($key) {
		if($this -> is_cache){
			return memcache_delete($this->memcache, MC_PREFIX.$key);
		}else{
			return false;
		}
	}

	function flush() {
		if($this -> is_cache){
			return memcache_flush($this->memcache);
		}else{
			return false;
		}
	}
}
?>