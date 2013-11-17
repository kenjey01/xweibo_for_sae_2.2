<?php
class feedback {
	var $db,$table;
	function feedback() {
		$this->db = APP::ADP('db');
		$this->db->setTable(T_FEEDBACK);
		$this->table = $this->db->getTable(T_FEEDBACK);
	}

	function save($params, $id=null) {
		$keys = array(
				'content','uid','nickname','mail','qq','addtime','tel','ip'
				);
		$data = array();
		foreach ($keys as $v) {
			if (isset($params[$v])) {
				$data[$v] = $this->db->escape($params[$v]);
			}
		}
		$rst = $this->db->save($data, $id);
		return RST($rst);
	}

	/**
	 * 得到指定ID的广告信息
	 * @param $id 广告ID,如果不指定，则返回所有广告
	 * @return array
	 */
	function getList($query, $rows=20, $offset=0) {
		$where = array();		
		if (isset($query['keyword']) && $query['keyword']) {
			$keyword = $this->db->escape($query['keyword']);
				$where[] = '(content LIKE "%' . $keyword . '%" OR nickname LIKE "%' . $keyword . '%" OR mail LIKE "%' . $keyword . '%" OR qq LIKE "%' . $keyword. '%")';
		}
		if (!empty($where)) {
			$where = ' WHERE '.implode(' AND ', $where);
		} else {
			$where = '';
		}
		$this->count_sql = 'SELECT COUNT(*) FROM ' . $this->table . $where;
		$sql = 'SELECT *FROM ' . $this->table. $where . ' ORDER BY `id` DESC LIMIT '.$offset .','. $rows;
		return RST($this->db->query($sql));
	}


	function getCount() {
		$rst = $this->db->getOne($this->count_sql);
		return RST($rst);
	}

	function del($id) {
		if (empty($id)) return false;
		$id = (array)$id;
		return $this->db->delete($id);
	}
}
