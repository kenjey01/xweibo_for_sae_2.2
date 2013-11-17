<?php
class ad {
	var $db,$table;
	function  ad() {
		$this->db = APP::ADP('db');
		$this->db->setTable(T_AD);
		$this->table = $this->db->getTable(T_AD);
	}

	function save($data, $id=null) {
/*
		$default = array(
				'name' => '未命名',
				'description' => '',
				'content' => '',
				'add_time'=>time(),
				'using' => 0,
				'page' => 'global',
				'flag' => ''
				);
		array_merge($default, $data);
*/
		return RST($this->db->save($data, $id));
	}

	/**
	 * 得到指定ID的广告信息
	 * @param $id 广告ID,如果不指定，则返回所有广告
	 * @return array
	 */
	function getAd($id = null) {
		$sql = 'SELECT *FROM ' . $this->table;
		if ($id !== null) {
			$sql .= ' WHERE id=' . $id;
			return RST($this->db->getRow($sql));
		}
		$sql .= ' ORDER BY `page`';
		return RST($this->db->query($sql));
	}

	/**
	 * 根据广告位标识得到广告数据
	 * @param $action string 页面标识
	 * @param $flag string 广告位标识
	 * @return array
	 */
	function getAdWithFlag($action, $flag) {
		return array();
	}

	/**
	 * 根据“是否使用”标志返回广告
	 * @param $using int 是否返回使用中的广告
	 * @param $page string 页面标识，即action名
	 * @return array
	 */
	function getUsingAd($using = 1, $page='') {
		$sql = 'SELECT *FROM ' . $this->table . ' WHERE `using`=' . $using;
		$where = array();
		if (!empty($page)) {
			$where[] = '`page`="' . $page . '"';
			//$sql .= ' AND `page`="' . $page . '"';
		}
		$or[] = '`page`="global"';
		if (!empty($or)) {
			$where .= ' AND (' . implode(' OR ', $or) . ')';
		} 
		
		$sql .= ' ORDER BY `page`';
		$rs = $this->db->query($sql);
		return RST($rs);
	}
}
