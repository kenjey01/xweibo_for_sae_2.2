<?php
/**
* 模块管理组件：（１）提供页面中包含的模块的查询、管理　（２）模块中数据查询、设置修改
*
* @version $1.1: module.com.php,v 1.0 2010/10/23 14:48:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/

if (!defined('MODULE_PAGE_PUB')){
	/*
	 * @const　广场页ID
	 */
	define('MODULE_PAGE_PUB', 1);

	/*
	 * @const 我的首页ID
	 */
	define('MODULE_PAGE_HOME', 2);

	//模块(组件) ID定义

	/*
	 * @const 热门转发、评论
	 */
	define('COMID_HOTWB', 1);

	/*
	 * @const 名人推荐
	 */
	define('COMID_STAR_RECOMMEND', 2);

	/*
	 * @const 推荐用户
	 */
	define('COMID_USER_RECOMMEND', 3);

	define('ERROR_PREFIX', 11);
}


class PageModule {
	/*
	 * @define 数据库对象
	 */
	var $db;

	/* 
	 * @define 当前操作组件的ID
	 */
	var $component_id = null;

	var $cfg_cache_time = 300;

	var $cfg = array();

	var $idMap = array(
			'1' => 'hotWB',
			'2' => 'star',
			'3' => 'recommendUser',
			'4' => 'concern',
			'5' => 'officialWB',
			'6' => 'hotTopic',
			'7' => 'guessYouLike',
			'8' => 'cityWB',
			'9' => 'pubTimeline',
			'10' => 'todayTopic',
			'11' => 'categoryUser'
		);

	var $cacheKeys = array();
	
	var $_sidemodule_getTopicWB_cache_cleared = false;

	/*
	 *　构造函数
	 */
	function PageModule() {
		$this->db = APP :: ADP('db');
		$this->db->setTable(T_COMPONENTS);
	}

	/**
	 * 列出指定页（或所有)的模块
	 *
	 * @param int $page
	 *
	 * @return array
	 */
	function listModules() {
		$db = $this->db;
		$list = $db->query('select * from ' . $db->getTable() . ' order by component_type');

		return RST($list);
	}

	/**
	 * 查询指定组件的属性
	 *
	 */
	function getComponent($component_id) {
		$db = $this->db;

		$com = $db->getRow('select * from '. $db->getTable() . ' where component_id=' . (int)$component_id);

		return RST($com);
	}

	/**
	 * 获取使用了指定ID的组件的页面
	 */
	function getQuotePages($component_id) {
		$sql = 'SELECT pm.page_id,p.page_name'
			. ' FROM xwb_page_manager pm'
			. ' LEFT JOIN xwb_pages p'
			. ' ON pm.page_id = p.page_id'
			. ' WHERE component_id='.(int)$component_id.' AND in_use = 1';

		return RST($this->db->query($sql));
	}

	/**
	 * 获取页面信息
	 *
	 */
	function getPage($page_id) {
		return RST($this->db->get($page_id, T_PAGES, 'page_id'));
	}

	/**
	 * 
	 *
	 */
	function getComponents($ids) {
		
		if (empty($ids) || !is_array($ids)) {
			return false;
		}

		foreach($ids as $key => $id) {
			$ids[$key] = (int)$id;
		}

		$db = $this->db;

		$sql = 'select * from ' . $db->getTable() . ' where component_id in ('  . join(',', $ids) . ')';

		return RST($db->query($sql));
	}

	function setErr($errno) {
		return ERROR_PREFIX . sprintf('%05d', $errno);
	}

	/*
	 * 设置或获取组件配置
	 *
	 */
	function config($cfgName = null, $cfgValue = null, $componentId=NULL) {
		if ( is_null($cfgName) ) {
			return RST($this->configList());
		}

		$this->component_id = $componentId ? $componentId : $this->component_id;
		if ( is_null($this->component_id) ) {
			return RST(null, $this->setErr(1), 'component id not set.');
		}

		if ( empty($cfgName) ) {
			return RST(null, $this->setErr(2), 'param cfgName is not set');
		}

		$db = $this->db;

		if (is_null($cfgValue)) {
			$rs = $db->query( 'select * from ' . $db->getTable(T_COMPONENTS_CFG) . ' where component_id='. (int)$this->component_id . ' and cfgName=\'' . $db->escape($cfgName) . '\'');

			return RST($rs);
		} else {
			$rs = $db->execute('update ' . $db->getTable(T_COMPONENTS_CFG) . ' set cfgValue=\'' . $db->escape($cfgValue) . '\' where cfgName=\'' . $db->escape($cfgName) . '\' and component_id=' . $this->component_id);

			return RST($rs);
		}
	}

	/*
	 * 将配置转为array格式
	 *
	 */
	function cfg2Array($rs) {
		$cfglist = array();

		foreach ($rs as $cfg) {
			if (substr($cfg['cfgName'], -2) == '[]') {
				$cfglist[substr($cfg['cfgName'], 0, -2)][] = $cfg['cfgValue'];
			} else {
				$cfglist[$cfg['cfgName']] = $cfg['cfgValue'];
			}
		}

		return $cfglist;
	}

	/**
	 * 清除配置缓存
	 */
	function clearCfgCache($component_id = null) {
		$component_id = $component_id ? $component_id: $this->component_id;
		
		$key = CACHE_COMPONENT_CFG . $component_id;

		CACHE::delete($key);
	}

	/*
	 * 获取配置信息列表
	 * 
	 * @param $component_id int 组件ID，如为NULL则使用$this->component_id
	 * 
	 * @return array
	 */
	function configList($useRstFormat = false, $component_id = null, $forceResetCache = false) {

		$component_id = !is_null($component_id) ? $component_id: $this->component_id;

		$cache_key = CACHE_COMPONENT_CFG . $component_id;

		if ( $forceResetCache || ($rs = CACHE::get($cache_key)) === false) {
			$rs = $this->db->query('select * from ' . $this->db->getTable(T_COMPONENTS_CFG) . ' where component_id=' . $component_id);
			
			if ($rs) {
				$rs = $this->cfg2Array($rs);
			}

			CACHE::set($cache_key, $rs, $this->cfg_cache_time);
		}

		return $useRstFormat ? RST($rs): $rs;
	}

	/**
	 * 清除用到话题列表的组件的缓存
	 * 推荐话题可能会用到的列表并做了缓存
	 *
	 */
	function clearTopicCache($topicid = '') {
		if (empty($topicid)) {
			return;
		}

		if (is_array($topicid)) {
			foreach ($topicid as $id) {
				$this->clearTopicCache($id);
			}
			return;
		}

		//强制删除组件推荐话题的缓存
		if($this->_sidemodule_getTopicWB_cache_cleared == false){
			DD('components/hotTopic.get');
			$this->_sidemodule_getTopicWB_cache_cleared = true;
		}

		//今日话题
		if ($topicid == 2){
			DD('components/todayTopic.get');
		}
		
	}

	/**
	 * 清除用到用户列表的组件的缓存
	 *
	 */
	function clearCache($eles, $sourceId) {
		$com_ids = array();
		$pl_ids = array();

		if (!empty($eles)) {
			foreach ($eles as $ele) {
				$part = explode(':', $ele, 2);
				
				if (!isset($part[1])) 
					continue;

				if ($part[1] == 1) {
					array_push($com_ids, $part[0]);
				} else {
					array_push($pl_ids, $part[0]);
				}
			}

//				if (in_array(

			if (!empty($com_ids))
				$this->clearComponentCache($com_ids);
		}

		return false;
	}

	/**
	 * 清除组件缓存
	 * @param $com_id [null|int|array]
	 *
	 * @return boolean
	 */
	function clearComponentCache($com_id = null) {
		if (is_array($com_id)) {

			foreach ($com_id as $id) {
				$this->clearComponentCache($id);
			}

			return RST(true);

		} elseif (is_numeric($com_id)) {

			if (isset($this->idMap[$com_id])) {
				
				if (!empty($this->cacheKeys)) {
					
					foreach ($this->cacheKeys as $key) {
						DD('components/' . $this->idMap[$com_id] . '.' . $key);
					}

					return RST(true);

				} else {
					return RST(DD('components/' . $this->idMap[$com_id] . '.get'));
				}

			} else {
				return RST(false, $this->setErr(5), 'component id '.$com_id.' not exists');
			}
		} else {
			$com_id = $this->component_id;

			if (!$com_id) {
				return RST(false, $this->setErr(4), 'param $com_id is empty.');
			}

			return $this->clearComponentCache($com_id);
		}
	}

	/*
	 * 更新组件信息
	 * @param $data array 需要更新的字段及值
	 * @param $component_id int 指定组件ID（如为NULL则使用$this->component_id)
	 *
	 * @return boolean 
	 *
	 * @example:
	 *   update(array('title' => 'new title'), 1);
	 */
	function update($data, $component_id = null) {
		if (!is_array($data)) {
			return RST(false, $this->setErr(3), '$data must be array.');
		}

		$db = $this->db;

		$sql = 'update ' . $db->getTable() . ' set ';

		$fields = array();

		foreach ($data as $field => $val) {
			$fields[] = '`' . $field . '`=\'' . $db->escape($val) . '\'';
		}

		$sql .= join(',', $fields);

		$sql .= ' where component_id=' . (int)($component_id ? $component_id: $this->component_id);

		return RST($db->execute($sql));
	}

	

	/*
	 * 获取某页面模块的使用情况
	 *
	 * @param $page int 页面代码：1 广场 2 我的首页
	 *
	 */
	function getPageModules($page_id = null, $group = false) 
	{
		$db  = $this->db;
		$sql = 'select position,isNative,param,p.id,p.title as newTitle,p.sort_num,p.in_use,c.* from ' . $db->getTable(T_PAGE_MANAGER) . ' as p'
			. ' join ' . $db->getTable(T_COMPONENTS) . ' as c'
			. ' on c.component_id=p.component_id'
			. ' where page_id=' . (int)$page_id
			. ' order by sort_num asc';

		$rs = $db->query($sql);

		return RST($group ? $this->groupByPos($rs): $rs);
	}

	
	/*
	 * 根据位置分组
	 *
	 */
	function groupByPos($list, $in_use = 1) 
	{
		$tmp = array();
		if (!empty($list)) 
		{
			foreach ($list as $row) 
			{
				if (is_null($in_use) || ($in_use == $row['in_use']))
				{
					$row['title']			 = $row['newTitle'] ? $row['newTitle'] : $row['title'];
					$row['param']			 = json_decode($row['param'], TRUE);
					$tmp[$row['position']][] = $row;
				}
			}
		}

		return $tmp;
	}

	
	
	/**
	 * 获取指定条数的随机内容
	 *
	 */
	function random($arr, $num) {
		if (count($arr) > $num) {
			$keys = array_rand($arr, $num);

			$tmpArr = array();

			for ($i = 0; $i < $num; $i++) {
				array_push($tmpArr, $arr[$keys[$i]]);
			}

			return $tmpArr;
		}

		return $arr;
	}
	

	
//	function getPageByType($type)
	function getPagelistByType()
	{
		$table = $this->db->getTable(T_PAGES);
//		return $this->db->query("Select * From $table where type='$type' ");
		$result   = $this->db->query("Select * From $table");
		$pageList = array();
		foreach ($result as $aPage)
		{
			$pageList[$aPage['page_id']] = $aPage;
		}
		return $pageList;
	}
}
