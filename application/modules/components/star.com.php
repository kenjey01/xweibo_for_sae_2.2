<?php
/**
* 名人推荐（明星）
*
* @version $1.1: star.com.php,v 1.0 2010/10/23 22:04:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/
require_once P_COMS . '/PageModule.com.php';

class star extends PageModule{

	var $component_id = 2;

	function star() {
		parent :: PageModule();
	}

	
	/*
	 * 获取名人列表
	 */
	function get($param = array()) 
	{
		$cfg 		= $this->configList();
		$topic_get	= isset($param['topic_get']) ? (int)$param['topic_get'] : 0;  //1: 自定义用户组；0: 新浪名人组
		$show_num	= isset($param['show_num']) ? (int)$param['show_num'] : (int)$cfg['show_num'];
		
		/// 使用新浪的名人推荐
		if (!$topic_get) 
		{
			$topic_id	= isset($param['topic_id']) ? (int)$param['topic_id'] : 1;
			$category = V('-:userhot');
			$rs 	= DR('xweibo/xwb.getUsersHot', '', isset($category[$topic_id]['value']) ? $category[$topic_id]['value'] : $category[1]['value']);
			$rs 	= $rs['rst'];
			$total 	= count($rs);
			if ($rs && (count($rs) > $show_num)) 
			{
				$pageSize = ceil($show_num / $total);
				$page = rand(1, $pageSize);
				$offset = ($page - 1) * $show_num;
				$rs = array_slice($rs, $offset, $show_num);
			}
		} else 
		{
			$db 		= $this->db;
			$group_id	= isset($param['group_id']) ? (int)$param['group_id'] : (int)$cfg['group_id'];
//			$rs = $db->query('select * from ' . $db->getTable(T_COMPONENT_USERS) . ' where group_id=\'' . $group_id . '\' order by sort_num asc limit ' . $show_num);
			
			// 本地的全部显示
			$rs = $db->query('select * from ' . $db->getTable(T_COMPONENT_USERS) . ' where group_id=\'' . $group_id . '\' order by sort_num asc');
		}

		return RST($rs);
	}
}
