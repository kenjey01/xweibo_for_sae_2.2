<?php

class adProfile {
	/**
	 * 返回所有条目
	 *
	 */
	function get() {
		$db = APP::ADP('db');

		$sql = 'select * from ' . $db->getTable(T_PROFILE_AD) . ' order by add_time asc';

		return RST($db->query($sql));
	}

	/**
	 * 新增或更新数据
	 *
	 */
	function save($row, $id = null) {
		
		$db = APP :: ADP('db');
		$rs = $db->save($row, $id, T_PROFILE_AD, 'link_id');

		if ($rs) DD('plugins/adProfile.get');

		return RST($rs);
	}

	/**
	 * 删除指定ID的条目
	 *
	 */
	function del($id) {
		$db = APP :: ADP('db');

		$sql = 'delete from ' . $db->getTable(T_PROFILE_AD) . ' where link_id=' . (int)$id . ' limit 1';

		$rs = $db->execute($sql);

		if ($rs) DD('plugins/adProfile.get');

		return RST($rs);
	}

}