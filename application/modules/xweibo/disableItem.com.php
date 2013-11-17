<?php
/**
* 今日主题
*
* @version $1.1: todayTopic.class.php,v 1.0 2010/10/23 14:48:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author zhenquan <simonxzq@gmail.com>
*
*/
class disableItem {
	var $db = null;
	var $table = null;
	var $count_sql = '';

	function disableItem() {
		$this->db = APP::ADP('db');
		$this->db->setTable(T_DISABLE_ITEMS);
		$this->table = $this->db->getTable(T_DISABLE_ITEMS);
	}

	/**
	 * 得到所有被屏蔽的记录,主要提供给缓存使用
	 * @param $type int 屏蔽项的类型
	 * @param $ids int|string|array 根据ID取得记录的关键字
	 * @return array
	 */
	function getDisabledItems($type, $ids = null) {
		$where = ' WHERE type=' . (int)$type;
		if ($ids !== null) {
			switch(true) {
				case is_numeric($ids): $ids = (array) $ids; break;
				case is_string($ids) : $ids = explode(',', $ids); break;
				default: $ids = (array)$ids;
			}
			foreach ($ids as $id) {
				if (!is_numeric($id)) {
					$this->_err(2145201, '获取屏蔽项ID时参数出错');
				}
			}
			if (is_array($ids) && !empty($ids)) {
				$where .= ' AND kw_id IN(' . implode(',', $ids) . ')';
			}
		}
		$sql = 'SELECT item FROM ' . $this->table . $where;
		$rs = $this->db->query($sql);
		$return = array();
		foreach ($rs as $row) {
			//var_dump($row['item']);
			$key=trim((string)$row['item'],chr(13));
			if($key!=NULL){
				$return[$key] = 1;
			}
			
		}
		return RST($return);
	}

	/**
	 * 查询已被屏蔽的微博
	 * @param $type int 屏蔽项的类型
	 * @param $keyword string 查询的关键字，不填表示返回全部
	 * @param $rows int 返回的记录行数
	 * @param $offset int 偏移量
	 * @return array
	 */
	function getDisabledByKeyword($type, $keyword = null, $rows = 20, $offset = 0) {
		$where = ' WHERE type=' . (int)$type;
		if ($keyword !== null && !empty($keyword)) {
			$keyword = $this->db->escape($keyword);
			$where .= ' AND (`item` LIKE "%' . $keyword . '%" OR `comment` LIKE "%' . $keyword . '%" OR `user` LIKE "%' . $keyword . '%")';
		}
		$sql = 'SELECT * FROM ' . $this->table . $where . ' ORDER BY `kw_id` DESC LIMIT ' . (int)$offset . ',' . (int)$rows;
		$rst =  $this->db->query($sql);

		if ($rst !== false) {
			$this->count_sql = 'SELECT COUNT(*) FROM ' . $this->table. $where ;
		}
		return RST($rst);
	}

	/**
	 * 恢复被屏蔽的微博
	 * @param $ids array|string|int 已被屏蔽的记录ID
	 * @return int 返回成功恢复的记录数
	 */
	function resume($ids) {
		switch (true) {
			case is_string($ids): $ids = explode(',', $ids); break;
			case is_numeric($ids): $ids = (array)$ids; break;
			default: $ids = (array)$ids;
		}
		foreach ($ids as $id) {
			!is_numeric($id) &&	$this->_err(2145105, '删除话题时参数必须为整数,字串或数组');
		}
		$rst = $this->db->delete($ids, T_DISABLE_ITEMS, 'kw_id');
		return RST($rst);
	}

	function resumeByItem($ids, $type) {
		switch (true) {
			case is_string($ids): $ids = explode(',', $ids); break;
			case is_numeric($ids): $ids = (array)$ids; break;
			default: $ids = (array)$ids;
		}
		foreach ($ids as $id) {
			!is_numeric($id) &&	$this->_err(2145105, '删除话题时参数必须为整数,字串或数组');
		}
		$sql = 'DELETE FROM ' .	$this->table . ' WHERE `item` IN(' . implode(',', $ids) . ') AND type=' . (int)$type;
		$rst = $this->db->execute($sql);
		return RST($rst);
	}

	/**
	 * 保存屏蔽项
	 * @param $data array 添加到数据表的屏蔽项数据
	 * @param $id int 当指定该参数时，表示修改$id指定的记录
	 * @return array
	 */
	function save($data, $id = null) {
		if (!is_array($data) || $id !== null && !is_array($id)) {
			return $this->_err(2151002, '保存屏蔽项时参数错误');
		}
		$this->db->setIgnoreInsert(true);
		$rst = $this->db->save($data, $id, '', 'kw_id');
		return RST($rst);
	}

	function saveKeywords($keywords, $admin_id, $admin_name, $delimiter='\||\n') {
		///无法删除
		switch (true) {
			case is_string($keywords): $keywords = preg_split("/".$delimiter."/", trim($keywords, '|\n ')); break;
			case is_array($keywords): break;
			default: return $this->_err('2151003', '添加关键字时参数不正确');
		}
		
		$keywords = array_unique($keywords);

		$add_time =APP_LOCAL_TIMESTAMP; 
		$data = array();
		foreach ($keywords as $keyword) {
			if (!empty($keyword)) {
				$data[] = '(4,"' . $this->db->escape($keyword) . '",' . $admin_id . ',"' . $this->db->escape($admin_name) . '",' . $add_time . ')';
			}
		}
		$delsql='delete from ' . $this->table . ' where type=4';
		$this->db->execute($delsql);
		if (empty($data)) {
			return RST(true);
		}
		$sql = 'INSERT IGNORE INTO ' . $this->table . '(type,item,admin_id,admin_name,add_time)';
		$sql .= 'VALUES ' . implode(',', $data);
		$rst = $this->db->execute($sql);
		$rst = $this->db->getAffectedRows();
		return RST($rst);
	}

	/**
	 * 统计记录总数,由用于查询的方法提供统计的SQL，该方法只用于执行指定的SQL
	 * @return int
	 */
	function getCount() {
		if ($this->count_sql) {
			$rst = $this->db->getOne($this->count_sql);
			return RST($rst);
		}
		return $this->_err(2152001, '统计记录数时，前置的查询方法没有提供用于统计的SQL');
	}

	/**
	 * 报错方法
	 * @param $errno string 错误代号,前2位为模块代号,第3位为错误级别,第4位为错误类型,最后三位为自定义错误代码
	 * @param $msg string|array 错误信息
	 * @param $log string 日志信息，如果不填写，则自动填写调用环境
	 */
	function _err($errno, $msg, $log='') {
		
		$level = substr($errno, 2, 1);		// 错误级别0-9,数字越大，错误越严重
		$type = substr($errno, 3, 1);		// 错误类型

		$log_level = 9;						// 错误级别大于该数值时则会写log
		$display_level = 5;					// 错误级别低该值时则在前端显示错误信息，级别高的统一返回类似“系统繁忙”信息 

		$prefix = '';
		switch ($type) {
			case '1':
				$prefix = '参数错误';
			break;
		}

		$msg = is_array($msg) ? implode(',', $msg) : (string)$msg;
		$msg = $prefix . $msg;
		
		$display = $level < $display_level ? 0 : 1;

		// 到达log_level级别时，则写log信息
		if ($level >= $log_level && trim($log) == '') {
			//@todo 自动构建log信息
			$log = '';
		}
		
		RST(false, $errno, $msg, $display, $log);
	}

	
	
	/**
	 * 获取所有列表
	 * @param array $params, 查询参数
	 * @param int $offset
	 * @param int $limit
	 */
	function getList($params=array(), $offset=0, $limit=10)
	{
		// Escape Var
		$offset	 = $this->db->escape($offset);
		$limit	 = $this->db->escape($limit);

		$where = $this->_buildWhere($params);
		$sql   = "Select * From {$this->table} $where Order By kw_id Desc Limit $offset, $limit ";
		return $this->db->query($sql);
	}
	
	
	
	/**
	 * 获取总数
	 * @param array $params 其它参数
	 */
	function getListCount($params=array())
	{
		$where = $this->_buildWhere($params);
		$sql   = "Select count(*) From {$this->table} $where ";
		return $this->db->getOne($sql);
	}
	
	
	
	/**
	 * 构建where 语句
	 * @param array $params
	 */
	function _buildWhere($params)
	{
		$type 	= isset($params['type']) ? $params['type'] : 1;
		$where = " Where type=$type ";
		
		// Start Time
		if ( isset($params['startTime']) && ($startTime=$this->db->escape($params['startTime'])) )
		{
			$where .= " And add_time>='$startTime' ";
		}
		
		// End Time
		if ( isset($params['endTime']) && ($endTime=$this->db->escape($params['endTime'])) )
		{
			$where .= " And add_time<='$endTime' ";
		}
		
		// Keyword
		if ( isset($params['keyword']) && ($keyword=$this->db->escape($params['keyword'])) )
		{
			$where .= " And `comment` Like '%$keyword%' ";
		}
		
		return $where;
	}
}


