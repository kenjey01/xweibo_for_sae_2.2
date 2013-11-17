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
class topics {
	var $db = null;
	var $table_cty = null;
	var $table_today_topic = null;
	var $count_sql = '';

	function topics() {
		$this->db = APP::ADP('db');
		$this->table_cty = $this->db->getTable(T_COMPONENT_TOPICLIST);
		$this->table_today_topic = $this->db->getTable(T_COMPONENT_TOPIC);
	}

	/**
	 * 得到话题类别
	 * @param $type int 0为内置，即不可修改，1为普通
	 */
	function getCategoryByType($type = null) {
		$where = '';
		if ($type !== null) {
			if (!is_int($type) || $type < 0) {
				$type = 0;
			} 
			$where = ' WHERE native=' . $type;
		}
		$sql = 'SELECT * FROM ' .$this->table_cty . $where;
		return RST($this->db->query($sql));
	}

	/**
	 * 得到类别
	 */
	function getCategory($id) {
		!is_int($id) &&	$this->_err(2145102, '获取单条话题类别时参数类型不正确');
		$rst = $this->db->get($id, T_COMPONENT_TOPICLIST, 'topic_id');
		return RST($rst);
	}

	/**
	 * 保存话题排序
	 * @param $ids string|array|int
	 * @return int 受影响的记录数
	 */
	function saveSort($cty, $ids) {
		switch (true) {
			case is_string($ids): $ids = explode(',', $ids); break;
			case is_int($ids): $ids = (array)$ids; break;
			default: $ids = (array)$ids;
		}
		$ids = implode(',', $ids);
		$sql = 'UPDATE ' . $this->table_today_topic . ' SET sort_num=FIND_IN_SET(id, "' . $ids . '") WHERE topic_id=' . $cty;
		$rst = $this->db->execute($sql);
		return RST($this->db->getAffectedRows());
	}

	/**
	 * 添加或编辑一个话题类别
	 * @param $data array|string
	 */
	function saveCategory($p, $id = null) {
		if (!is_array($p)) {
			$p= array(
						'topic_name' => (string)$p
						);
		}
		!isset($p['topic_name']) && $this->_err('2145101','添加话题类别时出错,必须输出类别名');
		/*
		$data = array(
					'topic_name' => $p['topic_name'],
					'native' => isset($p['native'])? (int)$p['native'] : 0
					);
		*/
		$data = $p;
		$data['topic_name'] = $this->db->escape($data['topic_name']);
		$rst = $this->db->save($data, $id, T_COMPONENT_TOPICLIST, 'topic_id');
		return RST($rst);
	}

	/**
	 * 添加一应用
	 */
	function addApp($cty_id, $app_id) {
		$cty_id = (int)$cty_id;
		if (!is_array($app_id)) {
			$app_id = explode(',' , (string)$app_id);
		}
		$sql = 'SELECT app_with FROM ' . $this->table_cty . ' WHERE topic_id=' . $cty_id;
		$row = $this->db->getOne($sql);
		if ($row === false) {
			return false;
		}
		if (empty($row) || trim($row) === '') {
			$data = $app_id;
		} else {
			$row = explode(',', $row);
			$data = array_merge($row, $app_id);
			$data = array_unique($data);
			if (sizeof($data) == sizeof($row)) {
				return false;
			}
		}

		$data = array(
				'app_with' => implode(',', $data)
				);
		$rs = $this->db->save($data, $cty_id, T_COMPONENT_TOPICLIST, 'topic_id');
		return $rs;
	}

	/**
	 * 删除一应用
	 */
	function delAPP($cty_id, $app_id) {
		$cty_id = (int)$cty_id;
		if (!is_array($app_id)) {
			$app_id = explode(',' , (string)$app_id);
		}
		$sql = 'SELECT app_with FROM ' . $this->table_cty. ' WHERE topic_id=' . $cty_id;
		$row = $this->db->getOne($sql);
		if (!$row) {
			return false;
		}
		if (trim($row) === '') {
			return false;
		}
		$row = explode(',', $row);
		$data = array();
		for ($i=0,$count=count($row); $i<$count; $i++) {
			if (in_array($row[$i], $app_id)) {
				continue;
			}
			$data[] = $row[$i];
		}
		$data = array(
				'app_with' => implode(',', $data)
				);
		return $this->db->save($data, $cty_id, T_COMPONENT_TOPICLIST, 'topic_id');
	}

	

	/**
	 * 删除话题类别
	 * @param $id int 要删除的类别id
	 */
	function delCategory($id) {
		if (!is_int($id) || $id <=0) {
			return $this->_err(2151107, '删除话题类别时参数不正确');
		}
		$sql = 'SELECT native FROM ' . $this->table_cty . ' WHERE topic_id=' . $id;
		$native = $this->db->getOne($sql);
		if ($native == 1) {
			return $this->_err(2152108, '指定的话题类别为内置类别，不能执行删除操作');
		}
		$rst = $this->db->delete($id, T_COMPONENT_TOPICLIST, 'topic_id');
		return RST($rst);
	}

	/**
	 * 由话题类别ID取得话题
	 * @param $cty_id int 话题类别ID
	 * @return array
	 */
	function getTopicByCty($cty_id, $each=20, $offset=0) {
		if (!is_int($cty_id) || !is_int($each) || $each < 1 || !is_int($offset) || $offset <0 ) {
			$this->_err(2145103, '获取话题类别时参数出错');
		}
		$sql = 'SELECT * FROM ' . $this->table_today_topic . ' WHERE topic_id=' . $cty_id . ' ORDER BY sort_num ASC,ext1 DESC,date_time DESC LIMIT ' . $offset . ',' . $each;
		$rst = $this->db->query($sql);
		if ($rst !== false) {
			$this->count_sql = 'SELECT COUNT(*) FROM ' . $this->table_today_topic . ' WHERE topic_id=' . $cty_id ;
		}
		return RST($rst);
	}

	function getCount() {
		$rst = $this->db->getOne($this->count_sql);
		return RST($rst);
	}

	function getTopic($id) {
		if (!is_int($id) || $id < 1) {
			$this->_err(2145106, '获取单条话题时参数出错');
		}
		$rs = $this->db->getRow('SELECT * FROM ' . $this->table_today_topic . ' WHERE id=' . $id);
		return RST($rs);
	}
	/**
	 * 添加或编辑话题
	 * @param $data array 话题内容
	 * @param $id int|null 记录id，如果不设置该值,则添加一条新记录
	 * @return int 受影响的记录行数 
	 */
	function saveTopic($p, $id=null) {
		if(!is_array($p) || !isset($p['topic']) || !isset($p['list_id'])) {
			$this->_err(2145104, '保存话题时参数不正确');
		}
		$data = array(
					'topic' => $this->db->escape($p['topic']),
					'topic_id' => (int)$p['topic_id'],
					'date_time' => APP_LOCAL_TIMESTAMP,
					'sort_num' => isset($p['sort_num']) ? (int)$p['sort_num'] : 0,
					'ext1' => isset($p['ext1'])? $p['ext1']:''
					);
		$rst = $this->db->save($data, $id, T_COMPONENT_TOPIC);

		$this->clearCache($id);

		return RST($rst);
	}

	function countTopic($cty_id) {
		$rs = $this->db->getOne('SELECT COUNT(*) FROM ' . $this->table_today_topic . ' WHERE topic_id=' . $cty_id);
		return RST($rs);
	}

	/**
	 * 更新缓存
	 *
	 */
	function clearCache($id) {
		if ($id == 3) {
			DD('components/todayTopic.get');
		}
	}

	/**
	 * @param $ids int|string|array 要删除的话题ID,如果类型为字串，必须是以','(逗号)分隔的整数字串
	 * @return int 受影响的记录数
	 */
	function deleteTopic($ids) {
		switch (true) {
			case is_string($ids): $ids = explode(',', $ids); break;
			case is_int($ids): $ids = (array)$ids; break;
			default: $ids = (array)$ids;
		}
		/*
		foreach ($ids as $id) {
			!is_int($id) &&	$this->_err(2145105, '删除话题时参数必须为整数,字串或数组');
		}
		*/
		$rst = $this->db->delete($ids, T_COMPONENT_TOPIC , 'id');
		return RST($rst);
	}

	/**
	 * 测试一类别下是否有主题，如果有主题则返回主题数,否则返回false
	 * @param $category_id int 主题类别ID
	 * @return int|false
	 */
	function hasTopics($category_id) {
		$select_count = 'SELECT COUNT(*) FROM ' . $this->table_today_topic . ' WHERE topic_id=' . $category_id;
		$count = $this->db->getOne($select_count);
		return RST($count);
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

}


