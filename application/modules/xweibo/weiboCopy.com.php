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
class weiboCopy {
	var $db = null;
	var $table_cty = null;
	var $table_today_topic = null;
	var $count_sql = '';

	function weiboCopy() {
		$this->db = APP::ADP('db');
		$this->table_weibo= $this->db->getTable(T_WEIBO_COPY);
	}
	
	/**
	 * 返回统计所有微博数
	 * @return int
	 */
	function counts($type = '') {
		$where = array();
		if ($type === 'today') {
			$where[] = 'FROM_UNIXTIME(`addtime`,"%Y%m%d")="'. date('Ymd') . '"';
		}
		$where[] = 'disabled=0';
		$sql = 'SELECT COUNT(*)AS count FROM ' . $this->db->getTable(T_WEIBO_COPY) . ' WHERE ' . implode(' AND ', $where);
		$count = $this->db->getOne($sql);
		return RST($count);
	}

	/**
	 * 根据条件得到列表
	 * @param $params array 条件
	 * @param $rows int 返回记录数
	 * @param $offset int 偏移
	 * @param $with boolean 是否返回转发数和评论数
	 * @return array
	 */
	function getList($params, $rows=20, $offset=0, $with=false) {
		$where = array();

		if (isset($params['start']) && $params['start']) {
			$where[] = '`addtime`>="' . $params['start'] . '"';
		}
		if (isset($params['end']) && $params['end']) {
			$where[] = '`addtime`<="' . $params['end']. '"';
		}
		if (isset($params['keyword'])) {
			$params['keyword'] = trim($params['keyword']);
			if ($params['keyword'] !== '') {
				$where[] = '(weibo LIKE "%' . $params['keyword'] . '%" OR `nickname` LIKE "%' . $params['keyword']. '%")';
			}
		}

		if (isset($params['disabled']) ) {
			$where[] = 'disabled='. $params['disabled'];
		}

		if (!empty($where)) {
			$where = ' WHERE ' . implode(' AND ' , $where);
		} else {
			$where = '';
		}

		$this->count_sql = 'SELECT COUNT(*) FROM ' . $this->table_weibo . $where;
		$sql = 'SELECT * FROM '. $this->table_weibo . $where . ' ORDER BY `addtime` DESC LIMIT ' . $offset .','. $rows;
		$rs = $this->db->query($sql);
		$data = array();
		for ($i=0,$count=count($rs); $i<$count; $i++) {
			$rs[$i]['comments'] = $rs[$i]['rt'] = 0;
			$data[$rs[$i]['id']] = $rs[$i];
		}
		if ($with && $data) {
			$id = array();
			foreach ($data as $key => $row) {
				$id[] = $key;
			}
			DR('xweibo/xwb.setToken','', 2);
			$rs = DR('xweibo/xwb.getCounts', '', implode(',', $id));
			if ($rs['errno'] == 0) {
				$rs = $rs['rst'];
				$count=count($rs);
				for ($i=0; $i< $count; $i++) {
					$data[$rs[$i]['id']]['comments'] = isset($rs[$i]) ?$rs[$i]['comments'] :0;
					$data[$rs[$i]['id']]['rt'] = isset($rs[$i]) ? $rs[$i]['rt']:0;
				}
			}
		}
		return $data;
	}

	function disabled($ids, $state) {
		$ids = (array)$ids;
		if ($state != 1) {
			$state = 0;
		}
		
		$sql = 'UPDATE ' . $this->table_weibo . ' SET `disabled`='.$state . ' WHERE id IN('. implode(',', $ids). ')';
		return $this->db->execute($sql);
		
	}

	function getCount() {
		$rst = $this->db->getOne($this->count_sql);
		return RST($rst);
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
		
		return RST(false, $errno, $msg, $display, $log);
	}

	function getWeiboCopyList($params=array(), $offset=0, $limit=10)
	{
		// Escape Var
		$offset	 = $this->db->escape($offset);
		$limit	 = $this->db->escape($limit);

		$where = $this->_buildWhere($params);
		$sql   = "Select * From {$this->table_weibo} $where Order By id Desc Limit $offset, $limit ";
		return $this->db->query($sql);
	}

	/**
	 * 获取总数
	 * @param array $params 其它参数
	 */
	function getWeiboCopyCount($params=array())
	{
		$where = $this->_buildWhere($params);
		$sql   = "Select count(*) From {$this->table_weibo} $where ";
		return $this->db->getOne($sql);
	}

	/**
	 * 构建where 语句
	 * @param array $params
	 */
	function _buildWhere($params)
	{
		$where = ' Where disabled=0 ';
		
		// Start Time
		if ( isset($params['startTime']) && ($startTime=$this->db->escape($params['startTime'])) )
		{
			$where .= " And addtime>='$startTime' ";
		}
		
		// End Time
		if ( isset($params['endTime']) && ($endTime=$this->db->escape($params['endTime'])) )
		{
			$where .= " And addtime<='$endTime' ";
		}
		
		// Keyword
		if ( isset($params['keyword']) && ($keyword=$this->db->escape($params['keyword'])) )
		{
			$where .= " And weibo Like '%$keyword%' ";
		}
		
		// ids
		if ( isset($params['ids']) && ($ids=$this->db->escape($params['ids'])))
		{
			$where .= " And id In ($ids)";
		}
		
		return $where;
	}

	/**
	 * 刪除
	 */
	function deleteByUid($uid) {
		$rs = $this->db->delete($uid, T_WEIBO_COPY,'uid');
		return RST($rs);
	}
	
}


