<?php
/**
 * @file			mc_session.adp.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2011-03-18
 * @Modified By:	heli/2011-03-21
 * @Brief			mc 存储session 处理类
 */

class mc_session {
    var $sess_id = null;
    var $mc = null;
    var $key = 'sess_';
    var $timeout = 1800;
	var $sess_mc_host;
	var $sess_mc_port;
    
    
    function mc_session() {
		$mc_info = explode(':', MC_HOST);
		$this->sess_mc_host = isset($mc_info[0]) ? $mc_info[0] : '';
		$this->sess_mc_port = isset($mc_info[1]) ? $mc_info[1] : '';
	}

	function adp_init($config=array()) {
		$this->mc_session();
	}
	
	/**
	 * session 开始存储之前执行的方法
	 *
	 */
    function open($path, $name) {
		if (XWB_SERVER_ENV_TYPE == 'sae') {
			$this->mc = memcache_init();
		} else {
			$this->mc = memcache_connect($this->sess_mc_host, $this->sess_mc_port);
		}

        return true;
    }

	/**
	 * session 存储完后执行的方法
	 */
    function close() {
		memcache_close($this->mc);
        return true;
    }

	/**
	 * 存储session变量的值
	 */
    function write($id, $data) {
		$key = md5($this->key . $id);
		return memcache_set($this->mc, $key, $data, 0, $this->timeout);
    }

	/**
	 * 读取session存储的值
	 */
    function read($id) {
		$key = md5($this->key . $id);
        $data = memcache_get($this->mc, $key);
        return $data ? $data: '';
    }

	/**
	 * 消除session值
	 */
    function destroy($id) {
		$key = md5($this->key . $id);
		return memcache_delete($this->mc, $key);
    }

	/**
	 * session 存储值过期执行的方法
	 */
    function gc() {
        return true;
    }
}
