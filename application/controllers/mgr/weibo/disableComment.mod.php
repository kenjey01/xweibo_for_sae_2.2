<?php

include(P_ADMIN_MODULES . '/action.abs.php');
class disableComment_mod extends action {

	function disableComment_mod() {
		parent :: action();
	}

	/**
	 * 微博列表
	 */
	function commentList() {
		$pager    	= APP :: N('pager');
		$page = (int)V('g:page', 1);
		$each = (int)V('g:each', 15);
		$offset = ($page -1) * $each;
		$keyword = V('r:keyword', null);
		$rstList = DR('xweibo/disableItem.getDisabledByKeyword', '', 2, $keyword, $each, $offset);
		$rstCount 	= DR('xweibo/disableItem.getCount');
		$page_param = array('currentPage'=> $page, 'pageSize' => $each, 'recordCount' => $rstCount['rst'], 'linkNumber' => 10);
		$pager->setParam($page_param);
		$pager->setVarExtends(array('keyword' => $keyword));
		
		TPL :: assign('list', $rstList['rst']);
		TPL :: assign('pager', $pager->makePage());
		TPL :: assign('offset', $offset);
		TPL :: assign('states', array('0'=>'正常','1'=>'暂停使用'));
		TPL :: display('mgr/weibo/comment_list', '', 0, false);
	}

	/**
	 * 恢复被屏蔽的回复
	 */
	function resume() 
	{
		$id 	= V('r:id');
		$type 	= V('r:type', false);
		
		if ($type) 	// Item 取消屏蔽
		{
			$rst = DR('xweibo/disableItem.resumeByItem', '', $id, 2);
			DR('CommentCopy.disabled', false, $id, 0);
		} 
		else 	// kw_id取消屏蔽
		{
			$idsTmp = DR('xweibo/disableItem.getDisabledItems', '', 2, $id);
			$ids 	= array();
			
			// 获取评论ID
			if ( is_array($idsTmp['rst']) )
			{
				foreach ($idsTmp['rst'] as $key=>$v) {
					$ids[] =  $key;
				}
			}
			
			$rst = DR('xweibo/disableItem.resume', '', $id);
			
			// 更新对应评论为可用
			if ($rst['rst'] && $rst['rst']>0 && sizeof($ids)) {
				DR('CommentCopy.disabled', '', $ids, 0);
			}
		}
		
		if ($rst['rst'] && $rst['rst'] > 0) {
			// 删除缓存
			DD('xweibo/disableItem.getDisabledItems');
		}
		//$this->_redirect('commentList');
		header('Location:' . $_SERVER['HTTP_REFERER']);
	}

	
	
	/**
	 * 屏蔽一微博
	 */
	function disable() 
	{
		$values = array(
				'type' => 2,
				'item' =>V('p:id'),
				'comment' => V('p:text'),
				'user' => V('p:user'),
				'publish_time' => V('p:created_at'),
				'add_time' =>APP_LOCAL_TIMESTAMP,
				'admin_name' => $this->_getUserInfo('screen_name'),
				'admin_id' => $this->_getUid()
				);
		$rst = DR('xweibo/disableItem.save', '', $values);

		// 添加成功则更新缓存
		if ($rst['rst'] > 0) {
			DD('xweibo/disableItem.getDisabledItems');
			DR('CommentCopy.disabled', false, V('p:id'), 1);
			APP::ajaxRst(true);
			exit;
		}
		APP::ajaxRst(false, 2122203, '屏蔽回复失败,可能已经被屏蔽');
	}

	
	
	function search() {
		$url = V('r:url');
		if ($url) {
			$url = urldecode($url);
			if (preg_match('!id(-|=)(\d+)!', $url, $match)) {
				$page = V('g:page', 1);
				if ($page < 1) {
					$page = 1;
				}
				$each = 15;
				$key = $match[2];


				$rst = DR('xweibo/xwb.getStatuseShow','', $key);
				$data = $rst['rst'];
				if (!isset($data['error_code'])) {
					TPL :: assign('weibo', $data);
				}

				$sum = V('g:sum', false);
				if (!$sum) {
					$rst = DR('xweibo/xwb.getCounts', '', $key);
					$sum = $rst['rst'][0]['comments'];
				}

				$pager = APP :: N('pager');
				$page_param = array('currentPage'=> $page, 'pageSize' => $each, 'recordCount' => $sum, 'linkNumber' => 10);
				$pager->setParam($page_param);
				$varExtends = array(
							'sum' => $sum,
							'url' => urlencode($url)
							);
				$pager->setVarExtends($varExtends);
				TPL :: assign('pager', $pager->makePage());
				//$key = '639989215';
				$rst = DR('xweibo/xwb.getComments','', $key, $each, $page);
				$data = $rst['rst'];
				if (!isset($data['error_code'])) {
					TPL :: assign('info', $data);
				}
			}
		}
		TPL :: display('mgr/weibo/comment_shield', '', 0, false);
	}
	
	
	/**
	 * 评论管理
	 */
	function comment()
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
				$totalCnt 	= DR('CommentCopy.getCount', FALSE, $params);
				$offset 	= $pager->initParam($totalCnt);
				$list		= DR('CommentCopy.getList', FALSE, $params, $offset, $pager->getParam('pageSize'));
				if ( is_array($list) )
				{
					foreach ($list as $key => $aRecord)
					{
						$list[$key]['id'] = $aRecord['cid'];
					}
				}
			break;
			
			
			// 被屏蔽
			case 2:
				$params['type'] = 2;
				$totalCnt 	= DR('xweibo/disableItem.getListCount', FALSE, $params);
				$offset 	= $pager->initParam($totalCnt);
				$list  		= DR('xweibo/disableItem.getList', FALSE, $params, $offset, $pager->getParam('pageSize'));
				if ( is_array($list) )
				{
					foreach ($list as $key => $aRecord)
					{
						$list[$key]['id'] 			= $aRecord['kw_id'];
						$list[$key]['content'] 		= $aRecord['comment'];
						$list[$key]['sina_uid'] 	= '';
						$list[$key]['sina_nick'] 	= $aRecord['user'];
						$list[$key]['dateline'] 	= strtotime($aRecord['publish_time']);
					}
				}
			break;
			
			
			// 被删除
			case 3:
				$totalCnt 	= DR('CommentDelete.getCount', FALSE, $params);
				$offset 	= $pager->initParam($totalCnt);
				$list  		= DR('CommentDelete.getList', FALSE, $params, $offset, $pager->getParam('pageSize'));
			break;
			
			
			// 未审核
			default:
				$totalCnt 	= DR('CommentVerify.getCount', FALSE, $params);
				$offset 	= $pager->initParam($totalCnt);
				$list  		= DR('CommentVerify.getList', FALSE, $params, $offset, $pager->getParam('pageSize'));
		}
		
		TPL::assign('pager', $pager->makePage());
		TPL::assign('list', $list);
		TPL::assign('offsetCnt', $offset+1);
		TPL::assign('currentPage', $pager->getParam('currentPage') );
		TPL::assign('type', $type);
		$this->_display('weibo/comment_mgr');
	}
	
	
	/**
	 * 删除待审评论
	 */
	function delVerifyComment()
	{
		$id 	= V('g:id', '');
		$result = true;
		if ($id)
		{
			$result = DR('CommentVerify.delComment', FALSE, $id, TRUE);
		}
		
		
		// 返回结果
		if ($result) {
			$this->_succ('删除成功！', $_SERVER['HTTP_REFERER']);
		}
		
		$this->_error('删除失败！',$_SERVER['HTTP_REFERER']);
	}
	
	
	/**
	 * 评论审核通过
	 */
	function verifyComment()
	{
		$id = V('g:id', '');
		
		if ($id)
		{
			$cmmList = DR('CommentVerify.getList', FALSE, array('id'=>$id), 0, 100);
			if ( is_array($cmmList) )
			{
				foreach ($cmmList as $aCmm)
				{
					$this->_verifyCmm($aCmm);
				}
			}
		}
		
		// 返回结果
		$this->_succ('审核成功！', $_SERVER['HTTP_REFERER']);
	}
	
	
	function _verifyCmm($params)
	{
		// 设置用户token
		DR('xweibo/xwb.setToken', '', 3, $params['token'], $params['token_secret']);
		
		$id 		= $params['mid'];
		$text 		= $params['content'];
		$forward 	= $params['forward'];
		
		/// 调用评论微博api
		$result = DR('xweibo/xwb.comment', '', $id, $text);
		$result = isset($result['rst']) ? $result['rst'] : array();

		/// 额外的逻辑处理操作
		$doAction 		= isset($params['doAction']) 		? $params['doAction'] 		: '';
		$extra_params 	= isset($params['extra_params']) 	? $params['extra_params'] 	: array();
		if (!empty($doAction)) 
		{
			$xwbAdditive 		= APP::N('xwbAdditive');
			$fun_name 			= 'extra_'.$doAction;
			$extra_params_array = array($extra_params, $result);
			call_user_func_array(array($xwbAdditive, $fun_name), $extra_params_array);
		}

		
		/// 作为一条新微博发布
		if ($forward == 1) 
		{
			$ret = DR('xweibo/xwb.repost', '', $id, $text);
			$ret = $ret['rst'];
			if (is_array($ret)) 
			{
				$ret['uid'] 	= USER::uid();
				$ret['author'] 	= true;
				
				///备份微博
				$this->_backupWeibo($ret);
			}
		} 

		F('report', 'cmt', 'http');
		
		
		// 还原成当前用户token
		DR('xweibo/xwb.setToken', '', 1);
		
		// 删除待审库记录
		DR('CommentVerify.delComment', FALSE, $params['id']);
		
		return isset($result['id']);
	}
	
	
	/**
	 * 备份微博
	 * @param $result
	 */
	function _backupWeibo($result)
	{
		///查询是否开启数据备份
		$plugins = DR('Plugins.get', '', 6);
		$plugins = $plugins['rst'];
		if (isset($plugins['in_use']) && $plugins['in_use'] != 1) {
			return false;
		}

		if (empty($result)) {
			return false;
		}

		$db = APP::ADP('db');

		$db->setTable('weibo_copy');
		$data_weibo = array();
		$data_weibo['id'] = $result['id'];
		$data_weibo['weibo'] = $result['text'];
		$data_weibo['uid'] = $result['user']['id'];
		$data_weibo['nickname'] = $result['user']['screen_name'];
		$data_weibo['addtime'] = APP_LOCAL_TIMESTAMP;
		$data_weibo['disabled'] = 0;
		$db->save($data_weibo);
	}
	
	
	/**
	 * 批量屏蔽评论
	 */
	function disableBatch()
	{
		if ( $id=V('g:id', false) )
		{
			$cmmList  = DR('CommentCopy.getList', FALSE, array('ids'=>$id), 0, 100);
			$value	  = array();
			if ( is_array($cmmList) )
			{
				$addTime = APP_LOCAL_TIMESTAMP;
				$admName = $this->_getUserInfo('screen_name');
				$admUid	 = $this->_getUid();
				foreach ($cmmList as $aCmm)
				{
					$value[] = "(2, '{$aCmm['cid']}', '{$aCmm['content']}', '{$aCmm['sina_nick']}', '{$aCmm['dateline']}', '$addTime', '$admName', '$admUid')";
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
					DD('xweibo/disableItem.getDisabledItems');
					DR('CommentCopy.disabled', false, $id, 1);
				}
			}
		}
		
		$this->_succ('已成功屏蔽微博', $_SERVER['HTTP_REFERER']);
	}
}
