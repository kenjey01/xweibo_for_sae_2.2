<?php
class pageManager {
	var $db = null;

	function pageManager() {
		$this->db = APP::ADP('db');
		$this->db->setTable(T_PAGES);
	}

	
	
	/** 
	 * 设置页面中某一组件的开关状态
	 */
	function onOff($page_id, $pmId, $on = null) 
	{
		$sql = 'update ' . $this->db->getTable(T_PAGE_MANAGER) . ' set in_use=' . (int)$on . ' where page_id=' . $page_id . ' and id=' . $pmId;
		return $this->db->execute($sql);
	}

	/**
	 * 根据ID获取页面
	 * @param $page_ids array|int|null 
	 *
	 */
	function get($page_ids = null) {

		$sql = 'select * from ' . $this->db->getTable();

		if (!is_null($page_ids)) {
			if (is_array($page_ids)) {
				$sql .= ' where page_id in(' . join(',', $page_ids) .')';
			} elseif (is_int($page_ids)) {
				$sql .= ' where page_id=' . $page_ids;
			}
		}
		return $this->db->query($sql);
	}

	/**
	 * 设置组件的排序
	 *
	 */
	function setSort($pmIds, $page_id, $pos) {
		if (empty($pmIds)) {
			return false;
		}

		$db = $this->db;

		$sql = 'update ' . $db->getTable(T_PAGE_MANAGER) . ' set ';

		$findstr = join(',', $pmIds);

		$sql .= 'sort_num=find_in_set(id, "' . $db->escape($findstr) . '")';
		$sql .= ' where page_id=' . (int) $page_id . ' and position='.(int)$pos;

		return $db->execute($sql);

	}
	
	
	
	/**
	 * get the page manager record by id
	 * @param int $pmId
	 */
	function getPageManager($pmId)
	{
		// check params
		if (empty($pmId))
		{
			return false;
		}
		
		return $this->db->get($pmId, T_PAGE_MANAGER);
	}
	
	
	
	/**
	 * 获取用户可以创建多个的 组件, component's type > 0 or component's type=0&&没有创建
	 */
	function getCustomeComponent($componentType = FALSE)
	{
		$db		= $this->db;
		$table  = $db->getTable(T_COMPONENTS);
		$sql	= "select * from $table ";
		if ($componentType) {
			$sql .= " where component_type = '$componentType' ";
		}
		
		return $db->query($sql);
	}
	
	
	
	/**
	 * 获取页面已添加的指定类型的 模块
	 * @param int $page_id, 页面ID
	 * @param int $componentType, 模块类型
	 */
	function getPageComponentList($page_id, $componentType = 0) 
	{
		$db  = $this->db;
		$sql = 'select p.id,p.title as newTitle,c.* from ' . $db->getTable(T_PAGE_MANAGER) . ' as p'
			. ' join ' . $db->getTable(T_COMPONENTS) . ' as c'
			. ' on c.component_id=p.component_id'
			. " where page_id=$page_id and c.type=$componentType"
			. ' order by sort_num asc';

		return $db->query($sql);
	}
}