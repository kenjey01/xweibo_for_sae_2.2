<?php
 /**
  * 首页聚焦位数据存储对象
  *
  *  @create 2010/11/6 23:35
  *  @author guoliang <guoliang1@staff.sina.com.cn>
  */
class indexFocus {
	/**
	 * @define 配置组ID
	 */
	var $config_group = 2;

	/**
	 * 数据库操作对象
	 */
	var $db;

	
	/**
	 * 构造函数，初始化内部使用的对象
	 *
	 */
	function indexFocus() {
		$this->db = APP::ADP('db');
		$db = &$this->db;
		$db->setTable(T_SYS_CONFIG);
	}

	/**
	 * 读取配置信息
	 */
	function get() {
		$db = &$this->db;

		$sql = 'select * from ' . $db->getTable() . ' where group_id=' . $this->config_group;

		$rs = $db->query($sql);

		$data = array();

		if (!empty($rs)) {
			foreach ($rs as $row) {
				$data[$row['key']] = $row['value'];
			}
		}

		return $data;
	}

	/**
	 * 保存数据
	 *
	 * @param $data array 配置内容,如array('title' => 'xxx', 'text' => 'aaaaaa');
	 * @return boolean
	 *
	 */
	function save($data) {
		if (!empty($data) && is_array($data)) {
			
			$db = &$this->db;

			foreach ($data as $key => $val) {
				$sql = 'update ' . $db->getTable() . ' set `value`="' . $db->escape($val) . '" where `key`="' . $key .'" and `group_id`=' . $this->config_group;

				$db->execute($sql);
			}

			return true;
		}

		return false;
	}
}