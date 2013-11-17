<?php

class contentUnitCom {

	function getContentUnitById($id = null) {
		$db = APP :: ADP('db');

		$keyword = $db->escape($id);
		$where = '';
		if (is_numeric($keyword)) {
			$where = ' WHERE `id` = ' . $keyword;
		}
		
		$order = ' order by add_time DESC';

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_CONTENT_UNIT . $where . $order;
		return RST($db->query($sql));
	}
	function getContentUnitByType($type = null) {
		$db = APP :: ADP('db');

		$keyword = $db->escape($type);
		$where = '';
		if (is_numeric($keyword)) {
			$where = ' WHERE `type` = ' . $keyword;
		}
		
		$order = ' order by add_time DESC';

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_CONTENT_UNIT . $where . $order;
		return RST($db->query($sql));
	}
	function addContentUnit($data) {
		if(empty($data)) {
             return RST(false, $errno=1210000, $err='Parameter can not be empty');
        }
		
		$db = APP :: ADP('db');

		//$this->_cleanCache();
		$db->setTable(T_CONTENT_UNIT);
        return RST($db->save($data));
	}

	function editContentUnit($data, $id) {
		if(empty($data)) {
             return RST(false, $errno=1210000, $err='Parameter can not be empty');
        }

		if (!is_numeric($id)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		//$this->_cleanCache();
		$db = APP :: ADP('db');
		$db->setTable(T_CONTENT_UNIT);
        return RST($db->save($data, $id, '', 'id'));
	}

	function deleteContentUnit($id) {
		if (!is_numeric($id)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		//$this->_cleanCache();
		$db = APP :: ADP('db');
		$db->setTable(T_CONTENT_UNIT);
		return RST($db->delete($id, '', 'id'));
	}

}
