<?php
/**
* 插件管理：页首页尾广告、用户首页聚焦位、个人资料推广位、登录后引导关注
*
* @version $1.1: Plugins.com.php,v 1.0 2010/11/5 15:20:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/

class Plugins {

	function getList($ids = array()) {
		if (!empty($ids) && !is_array($ids)) {
			return RST(false, 11403, 'params must be array.');
		}

		$db = APP :: ADP('db');
		$sql = 'select * from '. $db->getTable(T_PLUGINS);

		if (!empty($ids)) {
			$sql .= ' where plugin_id in(' . join(',', $ids) . ')';
		}

		$rs = $db->query($sql);

		return $rs ? RST($rs): RST(false, '11402', '查询失败');
	}

	/**
	 * 查询某一个插件的信息
	 *
	 */
	function get($id) {
		$db = APP :: ADP('db');

		$sql = 'select * from ' . $db->getTable(T_PLUGINS) . ' where plugin_id=' . (int)$id;

		$rs = $db->getRow($sql);

		return RST($rs);
	}

	function save($id, $cfg) {
		if ($id == 1) { //页头页脚广告
//			$ad_header = $cfg['ad_header'];
			$ad_footer = $cfg['ad_footer'];

//			DR('common/sysConfig.set', '', 'ad_header', $ad_header);
			$rs = DR('common/sysConfig.set', '', 'ad_footer', $ad_footer);

			//清除缓存
			DD('common/sysConfig.get');

			return $rs;
		}
	}

	/**
	 * 设置插件的开关
	 *
	 *
	 */
	function setStatus($id, $inuse) {
		$db = APP::ADP('db');

		DD('Plugins.get');

		return RST($db->execute('update '. $db->getTable(T_PLUGINS) . ' set in_use=' . (int)$inuse . ' where plugin_id=' . (int)$id));
	}
}