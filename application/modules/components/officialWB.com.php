<?php
/**
* 微博频道 获取设定的官方用户的微博
*
* @version $1.1: officialWB.com.php,v 1.0 2010/10/23 22:04:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/
require_once P_COMS . '/PageModule.com.php';

class officialWB extends PageModule{

	var $component_id = 5;

	function officialWB() {
		parent :: PageModule();
	}

	/**
	 * 获取listid
	 *
	 */
	function getListId() {
		$cfg = $this->configList();

		if (empty($cfg['list_id'])) {
			DR('xweibo/xwb.setToken', '', 4);
			//不存在，创建list
			$rs = DR('xweibo/xwb.createUserLists', null, SYSTEM_SINA_UID, '微博频道'.time('Ymd'));

			if ($rs['errno'] == 0) { //创建成功
				$this->config('list_id', $rs['rst']['id']);
				$this->clearCfgCache();

				DR('xweibo/xwb.setToken', '', 1);

				return $rs['rst']['id'];

			} else { //失败

				return false;
			}

		} else {
			return $cfg['list_id'];
		}
	}
	
	
	/**
	 * 获取一个新listid
	 */
	function createNewList($name) 
	{
		DR('xweibo/xwb.setToken', '', 4);
		
		// 判断list 总数，list count 最多20个
		$listCount = DR('xweibo/xwb.getUserListsCounts', null, SYSTEM_SINA_UID);
		if (isset($listCount['rst']['lists']) && 20 <= $listCount['rst']['lists']) {
			return RST('', '1', 'list的总数最多20个');
		}
		
		// 创建list
		$rs = DR('xweibo/xwb.createUserLists', null, SYSTEM_SINA_UID, $name);
		if ($rs['errno'] == 0) 
		{ 	// 创建成功
			DR('xweibo/xwb.setToken', '', 1);
		}

		//失败
		return $rs;
		//return RST('', $rs['errno'], '不能链接到api服务器');
	}
	

	/**
	 * 获取list内的所有用户
	 *
	 */
	function getUsers($listId='', $cursor=null, $uid=null) {
		if (!$uid) {
			$uid = SYSTEM_SINA_UID;
		}
		$listId = $listId ? $listId : $this->getListId();
		return DR('xweibo/xwb.getUserListsMember', null, $uid, $listId, $cursor);
	}

	/**
	 * 将用户添加到官方列表
	 *
	 */
	function addUser($uid, $listId='') {
		DR('xweibo/xwb.setToken', '', 4);

		$listId = $listId ? $listId : $this->getListId();
		$rs = DR('xweibo/xwb.createUserListsMember', null, SYSTEM_SINA_UID, $listId, $uid);

		//清除缓存
		if ($rs['errno'] == 0) DD('components/officialWB.getUsers');

		return $rs;
	}

	/**
	 * 删除组内用户
	 * 
	 * @param $uid int 要删除的用户ID
	 *
	 */
	function delUser($uid, $listId='') {
		DR('xweibo/xwb.setToken', '', 4);

		$listId = $listId ? $listId : $this->getListId();
		$rs = DR('xweibo/xwb.deleteUserListsMember', null, SYSTEM_SINA_UID, $listId, $uid);

		DR('xweibo/xwb.setToken', '', 1);

		return $rs;
	}


	/**
	 * 获取list内用户最新的N条微博
	 *
	 */
	function get($num = null, $listId='', $page = 1, $uid = null) {
		if (!$num) {
			$cfg = $this->configList();
			$num = $cfg['show_num'];
		}
		
		if (!$uid) {
			$uid = SYSTEM_SINA_UID;
		}

		$listId = $listId ? $listId : $this->getListId();
		
		//DR('xweibo/xwb.setToken', '', 2);  //API文档说不用登录
		$rs = DR('xweibo/xwb.getUserListIdStatuses', null, $uid, $listId, $num, $page);
		//DR('xweibo/xwb.setToken', '', 1);

		//成功返回
		if ($rs['errno'] == 0) {
			//如果返回的条数大于指定条数，切减
			$rst = &$rs['rst'];

			if (count($rst) > $num) {
				$rs['rst'] = array_slice($rst, 0, $num);
			}
			
		}

		return $rs;
	}
	
	
	
	/**
	 * \brief 删除管理员在API上的分组
	 * @param string $listId, api group list id
	 */
	function delUserList($listId)
	{
		// chenck data
		if (empty($listId)) {
			return false;
		}
		
		// delete the api list
		DR('xweibo/xwb.setToken', '', 4);
		$rs = DR('xweibo/xwb.deleteUserListId', null, SYSTEM_SINA_UID, $listId);
		DR('xweibo/xwb.setToken', '', 1);

		return $rs;
	}
	
	/**
	 * 获取list内的用户数
	 */
	function getListUserCount($listId = '') 
	{
		$listId = $listId ? $listId : $this->getListId();
		return DR('xweibo/xwb.getUserListId', null, SYSTEM_SINA_UID, $listId);
	}
}
