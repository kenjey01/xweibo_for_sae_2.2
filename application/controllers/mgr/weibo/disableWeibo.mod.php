<?php

include(P_ADMIN_MODULES . '/action.abs.php');
class disableWeibo_mod extends action {

	function disableWeibo_mod() {
		parent :: action();
	}

	/**
	 * 微博列表
	 */
	function weiboList() {
		$page = (int)V('g:page', 1);
		$each = (int)V('g:each', 15);
		$offset = ($page -1) * $each;
		$keyword = V('r:keyword', null);

		$offset = $page - 1 >= 0 ? $page - 1: 0;
		$offset *= $each;
		$rst = DR('xweibo/disableItem.getDisabledByKeyword', '', 1, $keyword, $each, $offset);
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
		TPL :: display('mgr/weibo/weibo_list', '', 0, false);
	}

	/**
	 * 恢复被屏蔽的微博
	 */
	function resume() {
		$id = V('r:id');
		$type = V('r:type', false);
		if ($type) {
			$rst = DR('xweibo/disableItem.resumeByItem', '', $id, 1);
			DS('xweibo/weiboCopy.disabled', '', $id, 1);
		} else {
			$wb_ids = DS('xweibo/disableItem.getDisabledItems', '', 1, $id);
			$ids = array();
			foreach ($wb_ids as $key=>$v) {
				$ids[] =  $key;
			}
			if (sizeof($ids)) {
				DS('xweibo/weiboCopy.disabled', '', $ids, 0);
			}
			$rst = DR('xweibo/disableItem.resume', '', $id);
		}
		if ($rst['rst'] && $rst['rst'] > 0) {
			// 删除缓存
			DD('xweibo/disableItem.getDisabledItems', 'g1/0', 1);
		}
		//$this->_redirect('weiboList');
		header('Location:' . $_SERVER['HTTP_REFERER']);
	}

	/**
	 * 屏蔽一微博
	 */
	function disable() {
		$ajax = V('g:ajax', false);
		$id = V('g:id', false);
		if (!$id){
			if ($ajax) {
				APP::ajaxRst(false, '1', '缺少参数');
			}
			return;
		}
		
		$rst = DR('xweibo/xwb.getStatuseShow','', $id);
		$data = $rst['rst'];
		if (isset($data['error_code']) && $data['error_code']) {
			return;
		}
		$values = array(
				'type' => 1,
				'item' => $data['id'],
				'comment' => $data['text'],
				'user' => $data['user']['screen_name'],
				'publish_time' => date('Y-m-d H:i:s', strtotime($data['created_at'])),
				'add_time' =>APP_LOCAL_TIMESTAMP,
				'admin_name' => $this->_getUserInfo('screen_name'),
				'admin_id' => $this->_getUid()
				);
		$rst = DR('xweibo/disableItem.save', '', $values);
		// 添加成功则更新缓存
		if ($rst['rst'] > 0) {
			DD('xweibo/disableItem.getDisabledItems', 'g1/0', 1);
			DR('xweibo/weiboCopy.disabled', '', $id, 1);
			//APP::ajaxRst(true);
			if ($ajax) {
				APP::ajaxRst(true);
			}
			$this->_succ('已成功屏蔽微博', $_SERVER['HTTP_REFERER']);
			exit;
		}
		
		if ($ajax) {
			APP::ajaxRst(false, '2','屏蔽微博失败,可能该微博已经在屏蔽列表');
		}
		$this->_error('屏蔽微博失败,可能该微博已经在屏蔽列表', array('weiboList'));
		//APP::ajaxRst(false, 2122202, '屏蔽微博失败,可能该微博已经在屏蔽列表');
	}

	function search() {
		$url = V('r:url');
		if ($url) {
			if (preg_match('!id(-|=)(\d+)!', $url, $match)) {
				$key = $match[2];
				//$key = '639989215';
				$rst = DR('xweibo/xwb.getStatuseShow','', $key);
				$data = $rst['rst'];
				if (!isset($data['error_code'])) {
					TPL :: assign('info', $data);
				}
			}
		}
		// 列表
		$page = (int)V('g:page', 1);
		$each = (int)V('g:each', 15);
		$offset = ($page -1) * $each;
		$keyword = V('g:keyword', null);

		$offset = $page - 1 >= 0 ? $page - 1: 0;

		$rst = DR('xweibo/disableItem.getDisabledByKeyword', 1, $keyword, $each, $offset);
		TPL::assign('list', $rst['rst']);

		$rst = DR('xweibo/disableItem.getCount');
		$count = $rst['rst'];

		$pager = APP :: N('pager');
		$page_param = array('currentPage'=> $page, 'pageSize' => $each, 'recordCount' => $count, 'linkNumber' => 10);
		$pager->setParam($page_param);
		TPL :: assign('pager', $pager->makePage());
		
		TPL :: assign('states', array('0'=>'正常','1'=>'暂停使用'));




		TPL :: display('mgr/weibo/weibo_shield', '', 0, false);
	}

	function verifyWeiboList() 
	{
		// Search Condition
		$params				= array();
		$params['keyword'] 	= V('r:keyword', '');
		
		// 开始时间
		$startTime = V('r:start', 0);
		if ( $startTime )
		{
			$params['startTime'] = strtotime($startTime);
		}
		
		// 结束时间
		$endTime = V('r:end', 0);
		if ( $endTime )
		{
			// 包括用户选择的当天
			$params['endTime'] = strtotime($endTime)+24*3600-1;
		}
		
        
		// Param
		$totalCnt	= 0;
		$list		= array();
		$pager  	= APP::N('pager');
		$type 		= V('g:type', 0);
		
		switch ($type)
		{
			// 通过审核
			case 1:
				$totalCnt 	= DR('xweibo/weiboCopy.getWeiboCopyCount', FALSE, $params);
				$offset 	= $pager->initParam($totalCnt);
				$list		= DR('xweibo/weiboCopy.getWeiboCopyList', FALSE, $params, $offset, $pager->getParam('pageSize'));
				if ( is_array($list) )
				{
					foreach ($list as $key => $aRecord)
					{
						$list[$key]['dateline'] = $aRecord['addtime'];
						$list[$key]['sina_uid'] = $aRecord['uid'];
					}
				}
			break;
			
			
			// 被屏蔽
			case 2:
				$params['type'] = 1;
				$totalCnt 	= DR('xweibo/disableItem.getListCount', FALSE, $params);
				$offset 	= $pager->initParam($totalCnt);
				$list  		= DR('xweibo/disableItem.getList', FALSE, $params, $offset, $pager->getParam('pageSize'));
				if ( is_array($list) )
				{
					foreach ($list as $key => $aRecord)
					{
						$list[$key]['id'] 			= $aRecord['kw_id'];
						$list[$key]['weibo'] 		= $aRecord['comment'];
						$list[$key]['sina_uid'] 	= '';
						$list[$key]['nickname'] 	= $aRecord['user'];
						$list[$key]['dateline'] 	= strtotime($aRecord['publish_time']);
					}
				}
			break;
			
			
			// 被删除
			case 3:
				$totalCnt 	= DR('weiboDelete.getCount', FALSE, $params);
				$offset 	= $pager->initParam($totalCnt);
				$list  		= DR('weiboDelete.getList', FALSE, $params, $offset, $pager->getParam('pageSize'));
			break;
			
			
			// 未审核
			default:
				$totalCnt 	= DS('weiboVerify.getWeiboVerifyCount', FALSE, $params);
				$offset 	= $pager->initParam($totalCnt);
				$list  		= DS('weiboVerify.getWeiboVerifyList', FALSE, $params, $offset, $pager->getParam('pageSize'));
		}
		
		TPL::assign('pager', $pager->makePage());
		TPL::assign('list', $list);
		TPL::assign('offsetCnt', $offset+1);
		TPL::assign('currentPage', $pager->getParam('currentPage') );
		TPL::assign('type', $type);
		TPL :: display('mgr/weibo/weibo_verify_list', '', 0, false);
	}

	/**
	 * 审核微博
	 *
	 *
	 */
	function verifyWeibo()
	{
		set_time_limit(180);
		$id = V('g:id');
		if (empty($id)) {
			$this->_error('审核微博失败', $_SERVER['HTTP_REFERER']);
		}
		
		$idList = explode(',', $id);
		if ( is_array($idList) )
		{
			foreach ($idList as $aId) {
				DR('weiboVerify.updateWeiboVerify', false, $aId);
			}
		}
		
		$this->_succ('审核微博成功', $_SERVER['HTTP_REFERER']);
		exit;
	}

	/**
	 * 删除待审核微博
	 *
	 */
	function deleteVerifyWeibo()
	{
		$id = V('g:id');
		if (empty($id)) {
			$this->_error('删除微博失败', $_SERVER['HTTP_REFERER']);
		}
		
		$idList = explode(',', $id);
		if ( is_array($idList) )
		{
			foreach ($idList as $aId) {
				DR('weiboVerify.updateWeiboVerify', false, $aId, 'delete');
			}
		}
		
		$this->_succ('删除微博成功', $_SERVER['HTTP_REFERER']);
		exit;
	}
	
	
	function disableBatch()
	{
		if ( $id=V('g:id', false) )
		{
			$weiboList  = DR('xweibo/weiboCopy.getWeiboCopyList', FALSE, array('ids'=>$id), 0, 100);
			$value		= array();
			if ( is_array($weiboList) )
			{
				$addTime = APP_LOCAL_TIMESTAMP;
				$admName = $this->_getUserInfo('screen_name');
				$admUid	 = $this->_getUid();
				foreach ($weiboList as $aWeibo)
				{
					$value[] = "(1, '{$aWeibo['id']}', '{$aWeibo['weibo']}', '{$aWeibo['nickname']}', '{$aWeibo['addtime']}', '$addTime', '$admName', '$admUid')";
				}
			}
			
			$fields = '(type, item, comment, user, publish_time, add_time, admin_name, admin_id)';
			$values = implode(',', $value);
			
			if ( $values )
			{
				$db 	= APP::ADP('db');
				$table 	= $db->getTable(T_DISABLE_ITEMS);
				
				if ( $db->execute("Insert Into $table $fields Values $values") )
				{
					DD('xweibo/disableItem.getDisabledItems', 'g1/0', 1);
					DS('xweibo/weiboCopy.disabled', '', $id, 1);
				}
			}
		}
		
		$this->_succ('已成功屏蔽微博', $_SERVER['HTTP_REFERER']);
	}
}
