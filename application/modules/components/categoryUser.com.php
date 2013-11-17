<?php
/**
* 分类用户推荐
*
* @version $1.1: categoryUser.com.php,v 1.0 2010/10/23 22:04:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/
require_once P_COMS . '/PageModule.com.php';

class categoryUser extends PageModule{

	var $component_id = 11;

	var $group_id = 1;

	function categoryUser() {
		parent :: PageModule();
	}

	function getGroups($groupid = null) {
		if(!is_numeric($groupid) || $groupid < 1){
			$groupid = $this->group_id;
		}
		
		$rs = $this->config('groups');

		$itemgroup = APP::N('itemGroups');

		if ($rs['errno'] == 0) {
			$cfg = $this->cfg2Array($rs['rst']);
			$rs['rst'] = $cfg;

			$list = $itemgroup->getItems($groupid);

			if (!empty($list)) {
				$groups = array();

				foreach($list as $g) {
					$groups[$g['item_id']] = $g['item_name'];
				}
			} else {
				$groups = array();
			}

			$rs['rst']['groups'] = $groups;//json_decode($cfg['groups'], true);

			return $rs;
		}

		return false;
	}

	function get($id) {
		return DR('mgr/userRecommendCom.getUserById', '', $id);
	}
}