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
class userRecommendCom {

	/*
	 * 推荐用户内置分类说明
	 * group_id  1.名人推荐列表 2.推荐用户列表 3.自动关注用户列表 4.微博频道用户列表
	 */

	/***************用户推荐分类操作类**************************/
	/**
	* 更具group_id获取类别数据
    * @param int $group_id
    * @param int $offset
    * @param int $each
    * @return array()
	*/
	function getById($group_id = '', $offset = 0, $each = '') {
		if (!is_numeric($offset)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		if ($each && !is_numeric($each)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		if ($group_id && !is_numeric($group_id)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$db = APP :: ADP('db');
		$keyword = $db->escape($group_id);

		$where = "";
		if($keyword) {
			$where = ' WHERE `group_id` = ' . $keyword;
		}

		$limit = "";
		if($each) {
			$limit = 'LIMIT ' . $offset . ',' . $each;
		}

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_COMPONENT_USERGROUPS . $where . $limit;
		return RST($db->query($sql));
	}

	/**
	* 根据分组ID删除类别
    * @param int $id
    * @return boolean
	*/
	function delById($id) {
		if (!is_numeric($id)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$this->_cleanCache();
		$db = APP :: ADP('db');
		$db->setTable(T_COMPONENT_USERGROUPS);
		if(!$db->delete($id, '', 'group_id')) {
			return RST(false);
		}

		$db = APP :: ADP('db');
		$db->setTable(T_COMPONENT_USERS);
		$db->delete($id, '', 'group_id');
		$this->cleanRelated($id);

		return RST(true);
	}

	/**
	* 添加新类别
    * @param string $group_name
    * @return boolean
	*/
	function addSort($group_name, $type=FALSE) {
		if (!$group_name) {
			return RST(false, $errno=1210000, $err='Parameter can not be empty');
		}

		$this->_cleanCache();
		$db = APP :: ADP('db');
		$db->setTable(T_COMPONENT_USERGROUPS);

		$data = array(
					'group_name' => $group_name,
					'native' => 0
		);
		
		// add 官方微薄用户分组
		if ($type)
		{
			$data['native']	= 1;
			$data['type']	= 4;
		}
				
		return RST($db->save($data));
	}

	/**
	* 根据group_id添加组件id
    * @param int $group_id
    * @param int $id
	* @param int $type 1:组件 2:插件
    * @return boolean
	*/
	function addRelatedId($group_id, $id, $type = 1) {
		if (!is_numeric($group_id) || !is_numeric($id) || !is_numeric($type)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$this->_cleanCache();
		$db = APP :: ADP('db');
		$db->setTable(T_COMPONENT_USERGROUPS);
		$row = "";
		$sql = 'SELECT related_id FROM ' . $db->getPrefix() . T_COMPONENT_USERGROUPS . ' WHERE `group_id`=' . $group_id;
		$row = $db->getRow($sql);

		if(!$row['related_id']) {
			$data = array('related_id' => $id.':'.$type);
		}else{
			$arr = $rows = $str = "";
			$arr = explode(',',$row['related_id']);
			foreach($arr as $value) {
				$rows[$value] = $value;
			}

			$rows[$id] = $id . ':' . $type;			
			if($rows) {
				$str = implode(',',$rows);
			}
			$data = array('related_id' => $str);
		}

		return RST($db->save($data, $group_id, '', 'group_id'));
	}

	/**
	* 根据group_id删除组件id
    * @param int $group_id
    * @param int $id
    * @return boolean
	*/
	function delRelatedId($group_id, $id, $type = 1) {

		if (!is_numeric($group_id) || !is_numeric($id) || !is_numeric($type)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$this->_cleanCache();
		$db = APP :: ADP('db');
		$db->setTable(T_COMPONENT_USERGROUPS);
		$row = $arr = $rows = $str = "";
		$sql = 'SELECT related_id FROM ' . $db->getPrefix() . T_COMPONENT_USERGROUPS . ' WHERE `group_id`=' . $group_id;
		$row = $db->getRow($sql);

		$arr = explode(',',$row['related_id']);

		foreach($arr as $value) {
			$rows[$value] = $value;
		}

		$id = $id . ':' . $type;

		if(isset($rows[$id])) {
			unset($rows[$id]);
		}

		if($rows) {
			$str = implode(',',$rows);
		}

		$data = array('related_id' => $str);
		return RST($db->save($data, $group_id, '', 'group_id'));
	}
	
	/***************用户推荐用户操作类******************************************************/
	/**
	* 根据group_id获取分组用户数据
    * @param int $group_id
    * @param int $offset
    * @param int $each
    * @return array()
	*/
	function getUserById($group_id = '', $offset = 0, $each = '') {
		if (!is_numeric($offset)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		if ($each && !is_numeric($each)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		if ($group_id && !is_numeric($group_id)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$db = APP :: ADP('db');
		$keyword = $db->escape($group_id);

		$where = "";
		if($keyword) {
			$where = ' WHERE `group_id` = ' . $keyword;
		}

		$limit = "";
		if($each) {
			$limit = 'LIMIT ' . $offset . ',' . $each;
		}

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_COMPONENT_USERS . $where . ' ORDER BY `sort_num` ' . $limit;

		return RST($db->query($sql));
	}


	/**
	* 添加根据分组id添加新用户
    * @param array $data
    * @return boolean
	*/
	function addUser($data) {
		if (!$data['group_id']) {
			return RST(false, $errno=1210000, $err='Parameter can not be empty');
		}

		if (!is_numeric($data['group_id'])) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$this->_cleanCache();
		$db = APP :: ADP('db');
		$keyword = $db->escape($data['group_id']);

//		$sql = 'SELECT COUNT(*) FROM ' . $db->getPrefix() . T_COMPONENT_USERS . ' WHERE `group_id` = ' . $keyword;
//		$count = $db->getOne($sql);
//
//		if($count >= 20) {
//			return RST(false, $errno=1210300, $err='Data quantity has super limit');
//		}

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_COMPONENT_USERS . ' WHERE `group_id` = ' . $keyword . ' ORDER BY `sort_num` DESC';
		$rs = $db->getRow($sql);
		
		if($rs) {
			$data['sort_num'] = $rs['sort_num'] + 1;
		}else{
			$data['sort_num'] = 1;
		}
		
		$this->cleanRelated($data['group_id']);

		$db->setTable(T_COMPONENT_USERS);
		return RST($db->save($data));
	}

	/**
	* 根据group_id和uid删除用户数据
    * @param int $uid
    * @param int $group_id
    * @return boolean
	*/
	function delByUid($uid, $group_id) {
		if (!is_numeric($uid) || !is_numeric($group_id)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$this->_cleanCache();
		$this->cleanRelated($group_id);
		$db = APP :: ADP('db');
		$sql = 'DELETE FROM ' . $db->getPrefix() . T_COMPONENT_USERS . ' WHERE `uid` = ' . $uid . ' AND `group_id` = ' . $group_id;
		return RST($db->execute($sql));
	}
	
	/**
	* 根据uid批量删除某用户数据
    * @param int $uid
    * @return boolean
	*/
	function delUserByUid($uid) {
		if (!is_numeric($uid)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}
		$this->_cleanCache();
		$db = APP :: ADP('db');
		$sql = 'DELETE FROM ' . $db->getPrefix() . T_COMPONENT_USERS . ' WHERE `uid` = ' . $uid;
		return RST($db->execute($sql));
	}
	

	/**
	* 根据group_id和uid串删除所有用户数据
    * @param string $uids
    * @param int $group_id
    * @return boolean
	*/
	function delAllByUid($uids, $group_id) {
		if (!is_numeric($group_id)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		if (!is_string($uids)) {
			return RST(false, $errno=1210002, $err='Parameter must be a string');
		}

		$this->_cleanCache();
		$this->cleanRelated($group_id);
		$db = APP :: ADP('db');
		$sql = 'DELETE FROM ' . $db->getPrefix() . T_COMPONENT_USERS . ' WHERE `group_id` = ' . $group_id . ' AND `uid` IN (' . $uids . ')';
		return RST($db->execute($sql));
	}

	/**
	* 根据group_id和uid修改用户排序
    * @param int $uid
    * @param int $group_id
    * @param int $sort_num
    * @return boolean
	*/
	function userSortById($uid, $group_id, $sort_num) {
		if (!is_numeric($uid) || !is_numeric($group_id) || !is_numeric($sort_num)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$this->_cleanCache();
		$db = APP :: ADP('db');
		$sql = 'UPDATE ' . $db->getPrefix() . T_COMPONENT_USERS . ' SET sort_num = ' . $sort_num . ' WHERE `group_id` = ' . $group_id . ' AND `uid` = ' . $uid;
		return RST($db->execute($sql));
	}

	/**
	* 更具group_id获取类别数据
    * @param int $group_id
    * @param int $uid
    * @return array()
	*/
	function getUserByUid($group_id, $uid) {
		if (!is_numeric($uid) || !is_numeric($group_id)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}
		
		$db = APP :: ADP('db');
		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_COMPONENT_USERS . ' WHERE `group_id` = ' . $group_id . ' AND `uid` = ' . $uid;
		return RST($db->getRow($sql));
	}

	/**
	* 根据分类group_id和用户uid修改推荐用户数据
    * @param int $group_id
    * @param int $uid
    * @param array $data
    * @return boolean
	*/
	function updateUser($data, $uid, $group_id) {
		if (!is_numeric($uid) || !is_numeric($group_id)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$this->_cleanCache();
		$this->cleanRelated($group_id);
		$db = APP :: ADP('db');
		$keyword = $uid . ' AND `group_id`=' . $group_id;
		$db->setTable(T_COMPONENT_USERS);
		return RST($db->save($data, $keyword, '', 'uid'));
	}

	/*
	 * 清除缓存
	 */
	function _cleanCache() {
		DD('mgr/userCom.getById');
		DD('mgr/userCom.getUserById');
		DD('components/concern.get');
		DD('components/star.get');
		DD('components/recommendUser.get');
	}

	/*
	 * 删除组件缓存
	 */
	function cleanRelated($group_id) {
		$db = APP :: ADP('db');
		$sql = 'SELECT related_id FROM ' . $db->getPrefix() . T_COMPONENT_USERGROUPS . ' WHERE `group_id`=' . $group_id;
		$row = $db->getRow($sql);

		if(isset($row['related_id'])) {
			$ids = explode(',', $row['related_id']);
			DS('PageModule.clearCache', '', $ids, $group_id);
		}
	}
}
