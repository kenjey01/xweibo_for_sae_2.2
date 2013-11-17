<?php
/**
* 人气关注排行
*
* @version $1.1: concern.com.php,v 1.0 2010/10/23 22:04:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/
require_once P_COMS . '/PageModule.com.php';

class concern extends PageModule{

	var $component_id = 4;

	function concern() {
		parent :: PageModule();
	}

	/**
	 * 取得粉丝数top N用户列表
	 *
	 */
	function get() {
		$cfg = $this->configList();

		//人气关注榜的数据来源，0 使用新浪API >0　对应的用户组
		$group_id = $cfg['group_id'];

		if ($group_id === '0') {
			$rs = array();
		} else {
			$db = $this->db;
			$rs = $db->query('select * from ' . $db->getTable(T_COMPONENT_USERS) . ' where group_id=' . (int)$group_id . ' order by sort_num desc limit ' . (int)$cfg['show_num']);
		}

		return RST($rs);
	}
}
