<?php
/**************************************************
*  Created:  2010-12-24
*
*  名人堂用户数据操作模型
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author guanghui <guanghui1@staff.sina.com.cn>
*
***************************************************/
class Celeb
{
	var $db;
	var $table_user;   //名人堂用户数据表
	var $table_cate;   //名人堂分类数据表
	
	function Celeb()
	{
		$this->db = APP::ADP('db');
		$this->table_user = $this->db->getTable(T_CELEB);
		$this->table_cate = $this->db->getTable(T_CELEB_CATEGORY);
	}

	/**
	 * 根据ID获取名人分类
	 *
	 * @param int $id 分类ID
	 * @return array
	 */
	function getSort($id)
	{
		$sql = "SELECT * FROM " . $this->table_cate . " WHERE id='" . $this->db->escape($id) . "' ORDER BY sort ASC, add_time DESC";
		return RST($this->db->getRow($sql));
	}

	/**
	 * 根据父类ID获取名人分类列表
	 *
	 * @param int $parent_id 父类ID，0为顶级分类
	 * @param int $offset
	 * @param int $limit
	 * @param bool $have_child 是否只获取含有子类的顶级分类
	 * @return unknown
	 */
	function getCatList($parent_id = 0, $offset = 0, $limit = '', $have_child = false)
	{
		$sql = "SELECT * FROM " . $this->table_cate . " WHERE parent_id='" . $this->db->escape($parent_id) . "'";
		if ($have_child) {
			$sql .= " AND id IN (SELECT DISTINCT parent_id FROM " . $this->table_cate . " WHERE parent_id > 0) AND parent_id = '0'";
		}
		$sql .= " ORDER BY sort ASC, add_time DESC";
		if ($limit) {
			$sql .= ' LIMIT ' . $offset . ',' . $limit;
		}
		return RST($this->db->query($sql));
	}
	
	/**
	 * 获取分类数目
	 *
	 * @param int $parent_id
	 * @return unknown
	 */
	function getCatNum($parent_id = 0)
	{
		$sql = "SELECT COUNT(*) FROM " . $this->table_cate . " WHERE parent_id='" . $this->db->escape($parent_id) . "'";
		return RST($this->db->getOne($sql));
	}
	
	/**
	 * 根据ID获取分类信息
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	function getCatById($id)
	{
		return RST($this->db->get($id, T_CELEB_CATEGORY));
	}
	
	/**
	 * 根据名称获取某分类下的名人分类
	 *
	 * @param int $parent_id  父类ID
	 * @param string $name  分类名
	 * @param int $excep_id  排除的ID
	 * @return unknown
	 */
	function getCatByName($parent_id, $name, $excep_id = 0)
	{
		$sql = "SELECT * FROM " . $this->table_cate . " WHERE parent_id='" . $this->db->escape($parent_id) . "' AND name='" . $this->db->escape($name) . "'";
		if ($excep_id) {
			$sql .= " AND id <> '" . $this->db->escape($excep_id) . "'";
		}
		
		return RST($this->db->query($sql));
	}
	
	/**
	 * 保存名人分类
	 *
	 * @param array $data
	 * @param int $id
	 * @return unknown
	 */
	function saveCat($data, $id = 0)
	{
		if (!is_array($data) || empty($data)) {
			return RST(false, $errno=1210000, $err='Parameter can not be empty');
		}
		
		$save_result = $this->db->save($data, $id, T_CELEB_CATEGORY);
		if ($save_result) {
			$this->_cleanCache(true);  //保存成功后清除缓存
		}
		
		return RST($save_result);
	}
	
	/**
	 * 删除名人分类
	 *
	 * @param int $id
	 * @return unknown
	 */
	function delCat($id)
	{
		$del_result = $this->db->delete($id, T_CELEB_CATEGORY);
		if ($del_result) {
			$this->_cleanCache(true);  //删除成功后清除缓存
		}
		return RST($del_result);
	}
	
	/**
	 * 获取名人列表
	 *
	 * @param int $cid_1  顶级分类ID
	 * @param int $cid_2  二级分类ID
	 * @param string $char_index  字母索引, 0-26
	 * @param string $nick 用户昵称，模糊搜索
	 * @param int $offset
	 * @param int $limit
	 * @param string $order 索引
	 * @param int $sort 0.升序 1.降序
	 * @return unknown
	 */

	function getUserList($cid_1, $cid_2, $char_index = '', $nick = '', $offset = 0, $limit = '', $order = 'sort', $sort = 0)
	{
		$where = array();
		$where_sql = '';
		if($cid_1) {
			$where[] = "c_id1='" . $this->db->escape($cid_1) . "'";
		}

		if($cid_2) {
			$where[] = "c_id2='" . $this->db->escape($cid_2) . "'";
		}
		
		if ($char_index!='' || $char_index===0) {
			$where[] = "char_index='" . $this->db->escape($char_index) . "'";
		}
		
		if ($nick !== '') {
			$where[] = "nick LIKE '%" . $this->db->escape($nick) . "%'";
		}
		
		if ( ! empty($where) ) {
			$where_sql = ' AND ' . implode(' AND ', $where);
		}

		if($sort) {
			$order = $order . ' DESC';
		}else{
			$order = $order . ' ASC';
		}

		$sql = "SELECT * FROM " . $this->table_user . " WHERE 1=1" . $where_sql . " ORDER BY ".$order .",add_time DESC";
		if ($limit) {
			$sql .= ' LIMIT ' . $offset . ',' . $limit;
		}

		return RST($this->db->query($sql));
	}	
	
	/**
	 * 获取名人数目
	 *
	 * @param int $cid_1
	 * @param int $cid_2
	 * @param string $char_index
	 * @param string $nick
	 * @return unknown
	 */
	function getUserNum($cid_1 = 0, $cid_2 = 0, $char_index = '', $nick = '')
	{
		$where = array();
		$where_sql = '';
		
		if ($cid_1) {
			$where[] = "c_id1='" . $this->db->escape($cid_1) . "'";
			
		}
		
		if ($cid_2) {
			$where[] = "c_id2='" . $this->db->escape($cid_2) . "'";
		}
		
		if ($char_index!='' || $char_index===0) {
			$where[] = "char_index='" . $this->db->escape($char_index) . "'";
		}
		if ($nick !== '') {
			$where[] = "nick LIKE '%" . $this->db->escape($nick) . "%'";
		}
		
		if ( ! empty($where) ) {
			$where_sql = ' AND ' . implode(' AND ', $where);
		}
		
		$sql = "SELECT COUNT(*) FROM " . $this->table_user . " WHERE 1=1" . $where_sql;
		
		return RST($this->db->getOne($sql));
	}
	
	/**
	 * 根据条件获取名人列表
	 *
	 * @param array $data
	 * @return unknown
	 */
	function getUserByInfo($data)
	{
		if (!is_array($data) || empty($data)) {
			return RST(false, $errno=1210000, $err='Parameter can not be empty');
		}
		
		$where_sql = '';
		foreach ($data as $key => $value) {
			$where_sql .= (" AND " . $key . "='" . $this->db->escape($value) . "'");
		}
		
		$sql = "SELECT * FROM " . $this->table_user . " WHERE 1=1" . $where_sql . " ORDER BY sort ASC, add_time DESC";
		return RST($this->db->query($sql));
	}
	
	/**
	 * 添加名人堂用户信息
	 *
	 * @param array $data
	 * @return unknown
	 */
	function addStarUser($data)
	{
		if (!is_array($data) || empty($data)) {
			return RST(false, $errno=1210000, $err='Parameter can not be empty');
		}
		
		$field_arr = array_keys($data);
		$value_arr = array_values($data);
		
		$sql = "INSERT INTO " . $this->table_user . " (" . implode(',', $field_arr) . ") VALUES ('" . implode("','", $value_arr) ."')";
		$add_result = $this->db->execute($sql);
		if ($add_result) {
			$this->_cleanCache(false);  //添加成功后删除缓存
		}
		return RST($add_result);
	}
	
	/**
	 * 修改名人堂用户信息
	 *
	 * @param array $data  要更新的数据
	 * @param array $where  更新的条件
	 * @return unknown
	 */
	function updateStarUser($data, $where)
	{
		if (!is_array($data) || empty($data)) {
			return RST(false, $errno=1210000, $err='Parameter can not be empty');
		}
		
		if (!is_array($where) || empty($where)) {
			return RST(false, $errno=1210000, $err='Parameter can not be empty');
		}
		
		$set_sql = $where_sql = '';
		foreach ($data as $key => $value) {
			$set_sql .= ($key . "='" . $this->db->escape($value) . "',");
		}
		$set_sql = rtrim($set_sql, ',');
		
		foreach ($where as $key => $value) {
			$where_sql .= (($where_sql ? ' AND ' : " ") . $key . "='" . $this->db->escape($value) . "'");
		}
		
		$sql = "UPDATE " . $this->table_user . " SET " . $set_sql . " WHERE" . $where_sql;
		$update_result = $this->db->execute($sql);
		if ($update_result) {
			$this->_cleanCache(false);  //更新成功后清除缓存
		}
		return RST($update_result); 
	}
	
	/**
	 * 删除名人堂用户
	 *
	 * @param int $c_id1  一级分类ID
	 * @param int $c_id2  二级分类ID
	 * @param int $sina_uid  新浪用户ID
	 * @return unknown
	 */
	function delStarUser($c_id1, $c_id2, $sina_uid)
	{
		$sql = "DELETE FROM " . $this->table_user . " WHERE c_id1='" . $this->db->escape($c_id1) . "' AND c_id2='" . $this->db->escape($c_id2) . "' AND sina_uid='" . $this->db->escape($sina_uid) . "'";
		$del_result = $this->db->execute($sql);
		if ($del_result) {
			$this->_cleanCache(false);  //删除成功后清除缓存
		}
		
		return RST($del_result);
	}
	
	/**
	 * 清除缓存
	 *
	 * @param bool $isCat  true清除分类表缓存，false清除用户表缓存
	 */
	function _cleanCache($isCat = false)
	{
		if ($isCat) {
			DD('Celeb.getSort');
			DD('Celeb.getCatList');
			DD('Celeb.getCatNum');
			DD('Celeb.getCatById');
			DD('Celeb.getCatByName');
		} else {
			DD('Celeb.getUserList');
			DD('Celeb.getUserNum');
			DD('Celeb.getUserByInfo');
		}
	}
}
