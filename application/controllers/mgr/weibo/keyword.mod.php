<?php

include(P_ADMIN_MODULES . '/action.abs.php');
class keyword_mod extends action {

	function keyword_mod() {
		parent :: action();
	}

	/**
	 * 关键字列表
	 */
	function keywordList() {
		$page = (int)V('g:page', 1);
		$each = (int)V('g:each', 15);
		$offset = ($page -1) * $each;
		$keyword = V('r:keyword', null);

		$offset = $page - 1 >= 0 ? $page - 1: 0;
		$offset *= $each;
		$rst = DR('xweibo/disableItem.getDisabledByKeyword', '', 4, $keyword, $each, $offset);
		TPL::assign('list', $rst['rst']);

		$rst = DR('xweibo/disableItem.getCount');
		$count = $rst['rst'];

		$pager = APP :: N('pager');
		$page_param = array('currentPage'=> $page, 'pageSize' => $each, 'recordCount' => $count, 'linkNumber' => 10);
		$pager->setParam($page_param);
		$pager->setVarExtends(array('keyword' => $keyword));
		TPL :: assign('pager', $pager->makePage());
		TPL::assign('offset', $offset);
		TPL :: display('mgr/weibo/keyword_list', '', 0, false);
	}

	/**
	 * 恢复被屏蔽的回复
	 */
	function del() {
		$id = V('r:id');
		$rst = DR('xweibo/disableItem.resume', '', $id);
		if ($rst['rst'] && $rst['rst'] > 0) {
			// 删除缓存
			//DD('xweibo/disableItem.getDisabledItems', 'g1/0', 4);
			DD('xweibo/disableItem.getDisabledItems');
		}
		$this->_redirect('keywordList');
	}

	/**
	 * 屏蔽一微博
	 */
	function add() {
		if ($this->_isPost()) {
			$keywords = V('p:keywords', false);
			//if (!$keywords || trim((string)$keywords) == '') {
			//	$this->_error('请填写要屏蔽的关键字', array('keywordList'));
			//	//return RST(2121205, '添加关键字时，参数为空');
			//}
			$rst = DR('xweibo/disableItem.saveKeywords', '', $keywords, $this->_getUid(), $this->_getUserInfo('screen_name'));
			// 添加成功则更新缓存
			if ($rst['rst'] > 0) {
				DD('xweibo/disableItem.getDisabledItems');
				$this->_succ('已经成功设置过滤关键字', array('add'));
				//APP::ajaxRst(true);
				//exit;
			}
			//$this->_redirect('keywordList');
		}
		$list=DR('xweibo/disableItem.getDisabledItems','g/0',4);
		TPL::assign('list',array_keys($list['rst']));
		TPL :: display('mgr/weibo/keyword_add', '', 0, false);
		//APP::ajaxRst(false, 2122204, '添加关键字失败');
	}
}
