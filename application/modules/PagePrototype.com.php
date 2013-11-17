<?php
/**
* 页面原型表管理：管理页面原型（page_prototype）表
*
* @version $1.2: 2011/1/11 $
* @package xweibo
* @copyright (C) 2009 - 2011 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

class PagePrototype
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
	 * \brief construct function
	 */
	function PagePrototype()
	{
		$this->db 	 = APP::ADP('db');
		$this->table = $this->db->getTable(T_PAGE_PROTOTYPE);
	}
	
	
	function prototypeList($type = FALSE)
	{
		// build the sql
		$sql = "Select * From {$this->table} ";
		if ($type) 
		{
			$sql .= " where type=$type ";
		}
		
		// run and return result
		$proList = $this->db->query($sql);
		return $proList;
	}
	
	
	function getPrototypeById($id)
	{
		$aPrototype = FALSE;
		if ($id) 
		{
			$id			= intval($id);
			$aPrototype = $this->db->getRow("Select * from {$this->table} where id=$id");
		}
		return $aPrototype;
	}
}