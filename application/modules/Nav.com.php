<?php
/**
* 页面导航表管理：管理页面导航（nav）表
*
* @version $1.2: 2011/1/11 $
* @package xweibo
* @copyright (C) 2009 - 2011 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

class Nav
{
	/*
	 * @define 数据库对象
	 */
	var $db;
	
	/*
	 * @define 数据表
	 */
	var $table;
	
	
	/**
	 * \brief construct
	 */
	function Nav()
	{
		$this->db 	 = APP::ADP('db');
		$this->table = $this->db->getTable(T_NAV);
	}
	
	
	
	function getNavList($inUse=FALSE, $type='')
	{
		//$type	= empty($type) ? PAGE_TYPE_CURRENT : $this->db->escape($type);
		$inUse	= $inUse ? ' and in_use=1 ' : '';
		
		//$sql 	= "Select * From {$this->table} Where type=$type $inUse Order By parent_id, sort_num, id";
		$sql 	= "Select * From {$this->table} Where 1=1 $inUse Order By parent_id, sort_num, id";
		$result = $this->db->query($sql);
		
		$navList = array();
		foreach ($result as $aNav)
		{
			$id 	  = $aNav['id'];
			$parentId = $aNav['parent_id'];
			if (empty($parentId)) {
				$navList[$id]['data'] = $aNav;
			} else {
				$navList[$parentId]['son'][$id]['data'] = $aNav;
			}
		}
		return $navList;
	}
	
	
	
	/**
	 * Get The Nav And It's In_use Son
	 * @param int $id
	 */
	function getNavById($id)
	{
		if ($id && $navData=$this->db->get($id, T_NAV))
		{
			$sql 	= "Select * From {$this->table} Where parent_id=".$this->db->escape($id)." and in_use=1 Order By sort_num, id";
			$result = $this->db->query($sql);
			
			$nav['data'] = $navData;
			foreach ($result as $aNav)
			{
				$id 			 = $aNav['id'];
				$nav['son'][$id] = $aNav;
			}
			return $nav;
		}
		return false;
	}
	
	/**
	 * 根据page_id获取所有正在使用的导航栏信息
	 * @param integer $page_id
	 * @return array
	 */
	function getNavByPageId($page_id){
		$sql = "SELECT * FROM {$this->table} WHERE page_id = '". (int)$page_id."'";;
		return (array)($this->db->query($sql));
	}
	
}
