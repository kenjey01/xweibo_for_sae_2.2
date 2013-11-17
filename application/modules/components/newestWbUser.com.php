<?php
/**
* 本站最新开通微博的用户列表
*
* @version $Id: newestWbUser.com.php 15683 2011-05-10 08:28:51Z qiping $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
*
* @author yaoying
*
*/
require_once P_COMS . '/PageModule.com.php';

class newestWbUser extends PageModule{

	var $component_id = 15;
	
	function newestWbUser() {
		parent :: PageModule();
	}
	
	function get($param = array()) {
		$show_num	= isset($param['show_num']) ? (int)$param['show_num'] : 3;
		
		$sql = 'SELECT `sina_uid`, `nickname` FROM '. $this->db->getTable(T_USERS). ' U where U.sina_uid not in (select sina_uid from '.$this->db->getTable(T_USER_ACTION).' where action_type=3 or action_type=2 union select 0) ORDER BY `id` DESC LIMIT 0, '. $show_num;
		
		
		//trigger_error($sql, E_USER_WARNING);
		$err = '';
		$errno = 0;
		$data = $this->db->query($sql);
		
		if(!is_array($data)){
			$err = '没有找到本站最新开通微博的用户';
			$errno = -1;
			$data = array();
		}
		
		return RST($data, $errno, $err);
	}
}