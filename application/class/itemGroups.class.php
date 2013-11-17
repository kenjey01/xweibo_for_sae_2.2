<?php
/**
 * 数据分组管理对象
 *
 *
 */
class itemGroups {
	var $db;

	function itemGroups() {
		$this->db = APP::ADP('db');
		$this->db->setTable(T_ITEM_GROUPS);
	}


	/**
	 * 获取对象列表
	 *
	 */
	function getItems($group_id, $sort = 'desc') {
		$db = $this->db;

		$sql = 'select * from ' . $db->getTable() . ' where group_id=' . (int)$group_id . ' order by sort_num ' . ($sort == 'desc' ? 'desc': 'asc');

		return $db->query($sql);
	}

	/**
	 * 查询数据是否存在指定ID的记录
	 *
	 */
	function hasItem($group_id, $item_id) {
		$sql = 'select * from ' . $this->db->getTable() . ' where group_id=' . (int)$group_id . ' and item_id=' . $item_id;

		return $this->db->getRow($sql);
	}

	/**
	 * 
	 * @param $item obj { 'item_id', 'item_name' }
	 *
	 */
	function addItem($item) {
		return $this->saveItem($item, '');
	}

	function saveItem($item, $id) {
		$data = array(
			'group_id' 	=> (int)$item->group_id,
			'item_id' 	=> $item->item_id,
			'item_name' => $item->item_name,
			'sort_num' 	=> isset($item->sort_num) ? (int)$item->sort_num: 0
		);

		return $this->db->save($data, $id, T_ITEM_GROUPS);
	}

	function getItem($id) {
		return $this->db->get($id, T_ITEM_GROUPS, 'id');
	}

	function delItem($id) {
		$db = $this->db;
		
		$sql = 'delete from ' . $db->getTable() . ' where id='. (int)$id;

		return $db->execute($sql);
	}
}
