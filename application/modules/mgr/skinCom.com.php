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
class skinCom {

	/******************以下为操作皮肤分类类****************/
  /*
   * 根据皮肤类别id获取皮肤类别数据
   * @param int $id
   * @return array()
   */
	function getSkinSortById($id = null) {		
		$db = APP :: ADP('db');

		$keyword = $db->escape($id);
		$where = '';
		if (is_numeric($keyword)) {
			$where = ' WHERE `style_id` = ' . $keyword;
		}

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_SKIN_GROUPS . $where . ' ORDER BY `sort_num`';
		return RST($db->query($sql));
	}

	/*
	 * 添加皮肤分类
	 * @param array $data
	 * @return boolean
	 */
	function addSkinSort($data) {
		if(empty($data)) {
             return RST(false, $errno=1210000, $err='Parameter can not be empty');
        }
		
		$db = APP :: ADP('db');
		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_SKIN_GROUPS . ' ORDER BY `sort_num` DESC LIMIT 1';
		$rs = $db->getRow($sql);

		if($rs) {
			$data['sort_num'] = $rs['sort_num']+1;
		}else{
			$data['sort_num'] = 1;
		}

		$this->_cleanCache();
		$db->setTable(T_SKIN_GROUPS);
        return RST($db->save($data));
	}

	/*
	 * 根据id编辑皮肤分类
	 * @param array $data
	 * @param int $id
	 * @return boolean
	 */
	function editSkinSort($data, $id) {
		if(empty($data)) {
             return RST(false, $errno=1210000, $err='Parameter can not be empty');
        }

		if (!is_numeric($id)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$this->_cleanCache();
		$db = APP :: ADP('db');
		$db->setTable(T_SKIN_GROUPS);
        return RST($db->save($data, $id, '', 'style_id'));
	}

	/*
	 * 根据id删除皮肤分类
	 * @param int $id
	 * @return boolean
	 */
	function delSkinSort($id) {
		if (!is_numeric($id)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$this->_cleanCache();
		$db = APP :: ADP('db');

		$sql = 'UPDATE ' . $db->getPrefix() . T_SKINS . ' SET style_id = 0 WHERE `style_id` = ' . $id;
		if(!$db->execute($sql)) {
			return RST(false);
		}

		$db = APP :: ADP('db');
		$db->setTable(T_SKIN_GROUPS);
		return RST($db->delete($id, '', 'style_id'));
	}

	/**
	* 根据style_id修改皮肤分类排序
    * @param int $style_id
    * @param int $style_num
    * @return boolean
	*/
	function setSkinSortOrderById($style_id, $sort_num) {
		if (!is_numeric($style_id) || !is_numeric($sort_num)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$this->_cleanCache();
		$db = APP :: ADP('db');
		$sql = 'UPDATE ' . $db->getPrefix() . T_SKIN_GROUPS . ' SET sort_num = ' . $sort_num . ' WHERE `style_id` = ' . $style_id;
		return RST($db->execute($sql));
	}


	/********************************以下为操作皮肤类*****************/
	/*
	* 扫描皮肤目录获取符合规则的皮肤目录名
    * @return array()
	*/
	function scanSkinDirectory() {
		$d = $dir = array();
		$io = APP :: ADP('io');
		$d = $io->ls(P_CSS,false,true);

		foreach($d as $value) {
			if($value[0] == 'd' && preg_match('/^' . SITE_SKIN_CSS_PRE . '.+/', $value[2]['name']) && $value[2]['name'] != SITE_SKIN_CSS_CUSTOM) {
				$dir[] = $value[2];
			}
		}
		
		return RST($dir);
	}

	/*
	* 读取某皮肤目录的配置文件
    * @param string $path
    * @return array()
	*/
	function readSkinConfig($path) {
		if(!file_exists($path)) {
			return RST(false);
		}

		$rs = @parse_ini_file($path);
		if($rs['COMPAT_VERSION'] == WB_VERSION) {
			$rs['state'] = 0;		//皮肤模板可用
		}else{
			$rs['state'] = 2;		//皮肤模板不可用
		}
		return RST($rs);
	}

	/*
	* 根据皮肤目录名从数据库中读取数据
    * @param string $name
    * @return array()
	*/
	function getskinByName($name) {
		if(empty($name)) {
             return RST(false, $errno=1210000, $err='Parameter can not be empty');
        }
		$db = APP :: ADP('db');
		
		$where = ' WHERE `directory` = "' . $db->escape($name) . '"';
		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_SKINS . $where . ' ORDER BY `sort_num`';
		return RST($db->getRow($sql));
	}

	/*
	* 根据皮肤id从数据库中读取数据
    * @param string $id
    * @return array()
	*/
	function getSkinById($id = null,$state = null) {
		//缺少分组信息

		$db = APP :: ADP('db');

		$keyword = $db->escape($id);
		$where = $rs = $row = '';
		if (is_numeric($keyword)) {
			$where = ' WHERE `skin_id` = ' . $keyword;
		}
		if($where==''&&is_numeric($state)){
			$where = ' WHERE `state` = ' . $state;
		}
		elseif(is_numeric($state)){
			$where .= ' AND `state` = ' . $state;
		}

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_SKINS . $where . ' ORDER BY `sort_num` , `skin_id`';
		$row = $db->query($sql);
		if($row) {
			foreach($row as $value) {
				$rs[$value['skin_id']] = $value;
			}
		}

		return RST($rs);
	}

	/*
	* 根据皮肤分类id从数据库中读取数据
    * @param int $id
    * @return array()
	*/
	function getSkinByStyleId($id) {
		if (!is_numeric($id)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$db = APP :: ADP('db');

		$keyword = $db->escape($id);
		$where = ' WHERE `style_id` = ' . $keyword;

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_SKINS . $where . ' ORDER BY `sort_num`';

		return RST($db->query($sql));
	}

	/*
	* 在数据库中插入一条皮肤数据
    * @param array $info
    * @return array()
	*/
	function InsertSkinInfo($info) {
		$db = APP :: ADP('db');
		$db->setTable(T_SKINS);
		
		$select_count = 'SELECT COUNT(*) FROM ' . $db->getPrefix() . T_SKINS . '';
		$count = $db->getOne($select_count);
		if($count) {
			$sort_num = $count;
		}else{
			$sort_num = 0;
		}
		$this->_cleanCache();
		$data = array(
						'name' => $info['TITLE'],
						'directory' => $info['directory'],
						'desc' => $info['DESC'],
						'state' => $info['state'],
						'style_id' => 0,
						'sort_num' => $sort_num
				);

		return RST($db->save($data));
	}

	/*
	 * 设置该皮肤为启用，禁用状态
     * @param int $state
     * @param int $id
     * @return boolean
	 */
	function setSkinState($state, $id) {
		if (!is_numeric($state) || !is_numeric($id)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$this->_cleanCache();
		$db = APP :: ADP('db');
		$sql = 'UPDATE ' . $db->getPrefix() . T_SKINS . ' SET state = ' . $state . ' WHERE `skin_id` = ' . $id;
		return RST($db->execute($sql));
	}

	/*
	 * 设置该皮肤的皮肤分类
     * @param int $style_id
     * @param int $id
     * @return boolean
	 */
	function setSkinSort($id, $style_id) {
		if (!is_numeric($style_id) || !is_numeric($id)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$this->_cleanCache();
		$db = APP :: ADP('db');
		$sql = 'UPDATE ' . $db->getPrefix() . T_SKINS . ' SET style_id = ' . $style_id . ' WHERE `skin_id` = ' . $id;
		return RST($db->execute($sql));
	}

	/*
	 * 清除缓存
	 */
	function _cleanCache() {
		DD('mgr/skinCom.getSkinSortById');
		DD('mgr/skinCom.getskinByName');
		DD('mgr/skinCom.getSkinById');
		DD('mgr/skinCom.getSkinByStyleId');
	}
}
