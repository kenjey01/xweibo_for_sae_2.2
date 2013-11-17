<?php

include(P_ADMIN_MODULES . '/action.abs.php');
class disableUser_mod extends action {

	function disableUser_mod() {
		parent :: action();
	}

	/**
	 * 微博列表
	 */
	function userList() {
		$page = (int)V('g:page', 1);
		$each = (int)V('g:each', 15);
		$offset = ($page -1) * $each;
		$keyword = V('r:keyword', null);

		$offset = $page - 1 >= 0 ? $page - 1: 0;
		$offset *= $each;
		$rst = DR('xweibo/disableItem.getDisabledByKeyword', '', 3, $keyword, $each, $offset);
		TPL::assign('list', $rst['rst']);

		$rst = DR('xweibo/disableItem.getCount');
		$count = $rst['rst'];

		$pager = APP :: N('pager');
		$page_param = array('currentPage'=> $page, 'pageSize' => $each, 'recordCount' => $count, 'linkNumber' => 10);
		$pager->setParam($page_param);
		$pager->setVarExtends(array('keyword' => $keyword));
		TPL :: assign('pager', $pager->makePage());
		TPL::assign('offset', $offset);
		TPL :: assign('states', array('0'=>'正常','1'=>'暂停使用'));
		TPL :: display('mgr/weibo/users_list', '', 0, false);
	}

	/**
	 * 恢复被屏蔽的微博
	 */
	function resume() {
		$uid = (string)V('r:uid');
		// 得到微博ID
		//$rst = DR('xweibo/disableWeibo.getDisabledWeiboId', '', $id);
		//$rst['rst'];
		$rst = DR('xweibo/disableItem.resumeByItem', '', $uid, 3);
		if ($rst['rst'] && $rst['rst'] > 0) {
			// 删除缓存
			//DD('xweibo/disableItem.getDisabledItems', 'g1/0', 3);
			DD('xweibo/disableItem.getDisabledItems');
		}
		$this->_redirect('userList');
	}

	/**
	 * 屏蔽一用户
	 */
	function disable() {
		$values = array(
				'type' => 3,
				'item' =>V('r:uid'),
				'comment' => urldecode(V('r:nick')),
				'add_time' =>APP_LOCAL_TIMESTAMP,
				'admin_id' => $this->_getUid()
				);
		$rst = DR('xweibo/disableItem.save', '', $values);

		// 添加成功则更新缓存
		if ($rst['rst'] > 0) {
			
			DD('xweibo/disableItem.getDisabledItems');
			//DD('xweibo/disableItem.getDisabledWeiboId', 'g1/0', 3);
			//APP::ajaxRst(true);
			$this->_redirect('userList');
			exit;
		}
		$this->_error('屏蔽失败，该用户可能已经被屏蔽', array('userList'));
		//APP::ajaxRst(false, 2122203, '屏蔽回复失败');
	}

	function search() {

		$keyword = V('p:keyword', false);
		$keyword = trim($keyword);
		if ($keyword) {
			$ids = DR('xweibo/disableItem.getDisabledItems', '', 3);
			$ids = $ids['rst'];
			$q = array(
						'q' => $keyword,
						'snick' => 1,
						'count' => 15,
						'sort' => 2,
						'page' => 1
					);
			$rst = DR('xweibo/xwb.searchUser','', $q);
			if (!$rst['err']) {
				$rst = $rst['rst'];
				for ($i=0, $count = count($rst); $i < $count; $i++) {
					$rst[$i]['disabled'] = isset($ids[$rst[$i]['id']]) ? true : false;
				}
				TPL::assign('list', $rst);
			}
		}
		TPL :: display('mgr/weibo/users_shield', '', 0, false);
	}
}
