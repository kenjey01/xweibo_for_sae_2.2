<?php
/**************************************************
*  Created:  2010-10-27
*
*  文件说明
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author liwen <liwen2@staff.sina.com.cn>
*
***************************************************/
class adminCom {


  /*
   * 获取管理员数量
   * @return int
   */
	function getAdminNum() {
		$db = APP :: ADP('db');
		$select_count = 'SELECT COUNT(*) FROM ' . $db->getPrefix() . T_ADMIN . '';
		return RST($db->getOne($select_count));
	}

	/*
     * 根据sina_uid获取管理员数据
     * @param int $sina_uid
     * @param int $offset
     * @param int $each
     * @return array()
     */
	function getAdminByUid($sina_uid = '', $offset = 0, $each = 1) {
		if (!is_numeric($offset) || !is_numeric($each)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$db = APP :: ADP('db');

		$keyword = $db->escape($sina_uid);
		$where = '';
		if ($keyword) {
				$where = ' WHERE `sina_uid` = ' . $keyword;
		}
		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_ADMIN . ' LEFT JOIN ' . $db->getTable(T_ADMIN_GROUP) . ' ON group_id=gid' . $where . ' ORDER BY `id` LIMIT ' . $offset . ',' . $each;
		return RST($db->query($sql));
	}

    /*
     * 管理员删除
     * @param int $id
     * @return boolean
     */
	function delAdmin($id, $is_sina_uid = false) {
		if (!is_numeric($id)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}
		$this->_cleanCache();
		$db = APP :: ADP('db');
		$db->setTable(T_ADMIN);
		return RST($db->delete($id, '', $is_sina_uid?'sina_uid':'id'));

	}

    /*
     * 根据id获取管理员信息
     * @param int $id
     * @return array()
     */
	function getAdminById($id) {
		if (!is_numeric($id)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$db = APP :: ADP('db');
	
		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_ADMIN . ' WHERE id="' . $id . '"';
		return RST($db->getRow($sql));
	
	}

    /*
     * 修改,插入管理员数据
     * @param array $data
     * @param int $id
     * @return boolean
     */
	function saveAdminById($data, $id = '') {
		if(!is_array($data)) {
             return RST(false, $errno=1210000, $err='Parameter can not be empty');
        }
		$this->_cleanCache();
		$db = APP :: ADP('db');
		$db->setTable(T_ADMIN);
        return RST($db->save($data, $id));
	}

	/**
	 * 得到组信息
	 *@param $group_id int
	 *@return array
	 */
	function getGroupInfo($group_id) {
		$db = APP :: ADP('db');
		$rs = $db->get($group_id, T_ADMIN_GROUP, 'gid');
		return RST($rs);
	}

	/*
	 * 清除缓存
	 */
	function _cleanCache() {
		DD('mgr/adminCom.getAdminNum');
		DD('mgr/adminCom.getAdminByUid');
		DD('mgr/adminCom.getAdminById');
	}
}
