<?php
/**************************************************
*  Created:  2010-06-28
*
*  未读数计数器
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author zhenquan <zhenquan@staff.sina.com.cn>
*
***************************************************/
class counter {
	var $cache,$wb;
	function counter() {

	}
	/**
	 * 未读数清零
	 * @param $uid int 用户ID
	 * @param $type string 要清零的项,可以为'mentions', 'comments', 'followers'
	 * @param $id 最后更新的消息ID
	 */
	function zero($uid, $type, $id) {
		if (!in_array($type, array('mentions', 'comments', 'followers', 'dm')) || !$id || !$uid) {
			return false;
		}
		$this->cache = CACHE :: get(CACHE_UNREAD_COUNTER . $uid);
		$this->cache[$type]['local'] = 0;
		$this->cache[$type]['id'] = $id;

		CACHE :: set(CACHE_UNREAD_COUNTER . $uid, $this->cache);
	}

	/**
	 * 更新未读数
	 * @param $uid int 用户ID
	 */
	function updateUnread($uid) {
		$this->cache = CACHE :: get(CACHE_UNREAD_COUNTER . $uid);
		$this->wb = APP :: N('weibo');
		//调用微博api得到未读数
		$rs = $this->wb->getUnread(false);
		$has_change = false;
		if ($rs['error_code']) {
			return $rs['error_code'];
		}
		$has_change = $this->hasUpdate('mentions', $uid, $rs['mentions']);
		$has_change = $this->hasUpdate('comments', $uid, $rs['comments']) || $has_change;
		$has_change = $this->hasUpdate('followers', $uid, $rs['followers']) || $has_change;
		$has_change = $this->hasUpdate('dm', $uid, $rs['dm']) || $has_change;
		if ( $has_change ) {
			CACHE :: set(CACHE_UNREAD_COUNTER . $uid, $this->cache);
		}
		return true;
	}

	/**
	 * 是否有更新
	 * @param $type string 类型,可以为：'mentions', 'comments', 'followers'
	 * @param $uid id 用户ID
	 * @param $count int　对应类型的远程未读数
	 */
	function hasUpdate($type, $uid, $count) {
		if (!in_array($type, array('mentions', 'comments', 'followers','dm'))) {
			return false;
		}
		if ($count >= (int)$this->cache[$type]['remote'] && $count != 0) {
			switch ($type) {
				case 'mentions':
					$v = $this->wb->getMentions($count, 1, null, null, false);
					break;
				case 'comments':
					$v = $this->wb->getCommentsToMe(null, $count, 1, null, null, false);
					break;
				case 'followers':
					$v = $this->wb->getFollowers($uid, null, null, -1, $count, false);
					$v = $v['users'];
					break;
				case 'dm':
					$v = $this->wb->getDirectMessages($count, 1, null, null, false);
					break;
			}
			$in_id = false;
			for ($i=0; $i < $count; $i++) {
				if ($v[$i]['id'] == $this->cache[$type]['id']) {
					$in_id = true;
					break;
				}
			}
			if ($in_id) {
				$local_count = (int)$this->cache[$type]['local'] + $count  - (int)$this->cache[$type]['remote'];
				$this->cache[$type] = array('id' => $v[0]['id'], 'remote' => $count, 'local' => $local_count);
				return true;
			} else {

				if (count($v) <= 0) {
					$id = -1;
					$local = 0;
				} else {
					$id = $v[0]['id'];
					$local = $count;
				}
				$this->cache[$type] = array('id' => $id, 'remote' => $count, 'local' => $local);
				return true;
			}
		} else {
			$this->cache[$type]['remote'] = $count;
			$this->cache[$type]['local'] = $count;
			return true;
		}
		return false;
	}

	/**
	 * 返回未读数
	 *
	 */
	function getUnread($uid, $type='all') {
		if (!in_array($type, array('mentions', 'comments', 'followers', 'dm', 'all'))) {
			return false;
		}
		$this->cache = CACHE :: get(CACHE_UNREAD_COUNTER . $uid);
		if ($type == 'all') {
			return array(
					'mentions' => $this->cache['mentions']['local'],
					'comments' => $this->cache['comments']['local'],
					'followers' => $this->cache['followers']['local'],
					'dm' => $this->cache['dm']['local']
					);
		}
		return $this->cache[$type]['local'];
	}
}

