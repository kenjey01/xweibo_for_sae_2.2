<?php
/**
 * 2.0升级到2.1 活动，直播，访谈 新添加字段'weibo'值的补充
 */
class upgrade21_mod {
	
	function upgrade21_mod() {
		/// 执行之前，先注释或删除“exit” 如注释：//exit，更新完活动，在线直播，在线访谈，麻烦把注释去掉或直接删除该文件
		exit;
	}

	/**
	 * 直播 weibo值 的更新
	 * 执行方式：http://demo.xweibo.cn/index.php?m=upgrade21.live&id=xxx
	 */
	function live() {
		set_time_limit(0);

		/// 直播id
		$id = V('g:id');
		if (empty($id)) {
			die('id is empty!');
		}

		$wb_id_array = DS('microLive.getMicroLiveWbs2', '', $id);
		$list = array();
		if ($wb_id_array) {
			$countId   = count($wb_id_array);
			if ($countId > 20) {
				$pageCnt = ceil($countId/20);
		
				for ($p=1; $p <=$pageCnt; $p++) {
					$offset = ($p-1) * 20;
					$idsTmp = array_slice($wb_id_array, $offset, 20);
					$wb_ids = array();
					foreach ($idsTmp as $var) {
						$wb_ids[] = $var['wb_id'];
					}
					$list = DR('xweibo/xwb.getStatusesBatchShow', '', implode(',', $wb_ids));
					if (empty($list['errno'])) {
						$list = $list['rst'];
						foreach ($list as $var) {
							if (isset($var['estate']) && $var['estate'] == 'deleted') {
								/// 如果该微博已经被删除，也删除该直播的微博信息
								DR('microLive.deleteLiveWb', '', $id, $var['id']);
								continue;
							}
							DR('microLive.updateMicroLive2', '', $var['id'], $var);
						}
					} else {
						die('errno: '. $list['errno']. ' err: '. $list['err']);
					}
				}
			} else {
				$wb_ids = array();
				foreach ($wb_id_array as $var) {
					$wb_ids[] = $var['wb_id'];
				}
				$list = DR('xweibo/xwb.getStatusesBatchShow', '', implode(',', $wb_ids));
				if (empty($list['errno'])) {
					$list = $list['rst'];
					foreach ($list as $var) {
						if (isset($var['estate']) && $var['estate'] == 'deleted') {
							/// 如果该微博已经被删除，也删除该直播的微博信息
							DR('microLive.deleteLiveWb', '', $id, $var['id']);
							continue;
						}
						DR('microLive.updateMicroLive2', '', $var['id'], $var);
					}
				} else {
					die('errno: '. $list['errno']. ' err: '. $list['err']);
				}
			}
		}
		die('Complete');
	}

	/**
	 * 活动 weibo值 的更新
	 * 执行方式：http://demo.xweibo.cn/index.php?m=upgrade21.event&id=xxx
	 */
	function event() {
		set_time_limit(0);

		/// 活动id
		$id = V('g:id');
		if (empty($id)) {
			die('id is empty!');
		}

		$wb_id_array = DS('events.getEventComments2', '', $id);
		$list = array();
		if ($wb_id_array ) {
			$countId   = count($wb_id_array);
			if ($countId > 20) {
				$pageCnt = ceil($countId/20);
		
				for ($p=1; $p <=$pageCnt; $p++) {
					$offset = ($p-1) * 20;
					$idsTmp = array_slice($wb_id_array, $offset, 20);
					
					$wb_ids = array();
					foreach ($idsTmp as $var) {
						$wb_ids[] = $var['wb_id'];
					}
					$list = DR('xweibo/xwb.getStatusesBatchShow', '', implode(',', $wb_ids));
					if (empty($list['errno'])) {
						$list = $list['rst'];
						foreach ($list as $var) {
							if (isset($var['estate']) && $var['estate'] == 'deleted') {
								/// 如果该微博已经被删除，也删除该活动评论的微博信息
								DS('events.deleteEventComment', '', $id, $var['id']);
								continue;
							}
							DR('events.updateEventComment2', '', $var['id'], $var);
						}
					} else {
						die('errno: '. $list['errno']. ' err: '. $list['err']);
					}
				}
			} else {
				$wb_ids = array();
				foreach ($wb_id_array as $var) {
					$wb_ids[] = $var['wb_id'];
				}
				$list = DR('xweibo/xwb.getStatusesBatchShow', '', implode(',', $wb_ids));
				if (empty($list['errno'])) {
					$list = $list['rst'];
					foreach ($list as $var) {
						if (isset($var['estate']) && $var['estate'] == 'deleted') {
							/// 如果该微博已经被删除，也删除该活动评论的微博信息
							DS('events.deleteEventComment', '', $id, $var['id']);
							continue;
						}
						DR('events.updateEventComment2', '', $var['id'], $var);
					}
				} else {
					die('errno: '. $list['errno']. ' err: '. $list['err']);
				}
			}
		}
		die('Complete');
	}
	
	
	
	/**
	 * 在线访谈 weibo值 的更新
	 * 执行方式：http://demo.xweibo.cn/index.php?m=upgrade21.interview&id=xxx
	 */
	function interview()
	{
		set_time_limit(0);

		/// 访谈id
		$id = V('g:id');
		if ( empty($id) ) { die('id is empty!'); }

		// Interview Wb
		$this->_syncInterviewWb($id);
		
		// Interview Wb At me
		$this->_syncInterviewWbAtme($id);
		
		// 结束
		die('Complete');
	}
	
	
	/**
	 * 更新Interview Wb 表
	 * @param unknown_type $interviewId
	 */
	function _syncInterviewWb($interviewId)
	{
		$db 	= APP::ADP('db');
		$table 	= $db->getTable( T_INTERVIEW_WB );
		
		// 获取微博ID
		$wbList = $db->query("Select ask_id, answer_wb, weibo, answer_weibo From $table Where interview_id=$interviewId And (weibo is Null Or weibo='' Or answer_weibo is Null Or answer_weibo='')");
		$idList = array();
		if ( is_array($wbList) )
		{
			foreach ($wbList as $aWb)
			{
				if ( empty($aWb['weibo']) ) { $idList[$aWb['ask_id']]= $aWb['ask_id']; }
				if ( empty($aWb['answer_weibo']) ) { $idList[$aWb['answer_wb']]= $aWb['answer_wb']; }
			}
		}
		
		// api获取微博
		$apiWb = $this->_batchWb( array_keys($idList) );
		
		
		// 更新数据库
		if ( is_array($wbList) )
		{
			foreach ($wbList as $aWb)
			{
				$askId 		= $aWb['ask_id'];
				$answerId 	= $aWb['answer_wb'];
				$data		= array();
				
				// Ask Wb
				if ( isset($apiWb[$askId]) ) 
				{ 
					if (isset($apiWb[$askId]['estate']) && $apiWb[$askId]['estate'] == 'deleted') 
					{
						$db->excute("Delete From $table Where interview_id=$interviewId And ask_id='$askId' And answer_wb='$answerId'");
						continue;
					}
					
					$data['weibo'] = json_encode($apiWb[$askId]); 
				}
				
				// Answer Wb
				if ( isset($apiWb[$answerId]) ) 
				{ 
					if (isset($apiWb[$answerId]['estate']) && $apiWb[$answerId]['estate'] == 'deleted') 
					{
						$db->excute("Delete From $table Where interview_id=$interviewId And ask_id='$askId' And answer_wb='$answerId'");
						continue;
					}
					
					$data['answer_weibo'] = json_encode($apiWb[$answerId]);
				}
				
				// Save Db
				$db->save($data, $askId, T_INTERVIEW_WB, 'ask_id');
			}
		}
	}
	
	

	/**
	 * 更新Interview Wb Atme 表
	 * @param unknown_type $interviewId
	 */
	function _syncInterviewWbAtme($interviewId)
	{
		$db 	= APP::ADP('db');
		$table 	= $db->getTable( T_INTERVIEW_WB_ATME );
		
		// 获取微博ID
		$wbList = $db->query("Select * From $table Where interview_id=$interviewId And (weibo is Null Or weibo='')");
		$idList = array();
		if ( is_array($wbList) )
		{
			foreach ($wbList as $aWb)
			{
				$idList[$aWb['answer_wb']] = $aWb['answer_wb'];
			}
		}
		
		// api获取微博
		$apiWb = $this->_batchWb( array_keys($idList) );
		
		
		// 更新数据库
		if ( is_array($wbList) )
		{
			foreach ($wbList as $aWb)
			{
				$askId 		= $aWb['ask_id'];
				$answerId 	= $aWb['answer_wb'];
				
				if ( isset($apiWb[$answerId]) ) 
				{
					if (isset($apiWb[$answerId]['estate']) && $apiWb[$answerId]['estate'] == 'deleted') 
					{
						$db->excute("Delete From $table Where interview_id=$interviewId And ask_id='$askId' And at_uid='{$aWb['at_uid']}'");
						continue;
					}
					
					$wb = json_encode($apiWb[$answerId]); 
					DR('InterviewWbAtme.updateAnswer', FALSE, $interviewId, $askId, $aWb['at_uid'], $aWb['answer_wb'], $wb);
				}
			}
		}
	}
	
	
	/**
	 * 批量获取微博
	 * @param $idList
	 */
	function _batchWb($idList)
	{
		if ( empty($idList) ) { return true; }
		
		$idCnt 	= count($idList);
		$wbList	= array();
		
		// 少于20个
		if ( $idCnt<=20 )
		{
			$list = DR('xweibo/xwb.getStatusesBatchShow', '', implode(',', $idList));
			if ( $list['errno'] ) { echo "errno:{$list['errno']} err:{$list['err']} <br>\n"; }
			
			if ( isset($list['rst']) && is_array($list['rst']) )
			{
				foreach ($list['rst'] as $aWb)
				{
					if ( isset($aWb['id']) )
					{
						$wbId			= $aWb['id'];
						$wbList[$wbId] 	= $aWb;
					}
				}
			}
			return $wbList;
		}
		
		
		// 超过20, 分批获取
		$pageCnt = ceil($idCnt/20);
		for ( $p=1; $p<=$pageCnt; $p++) 
		{
			$offset = ($p-1) * 20;
			$idsTmp = array_slice($idList, $offset, 20);
			$list 	= DR('xweibo/xwb.getStatusesBatchShow', '', implode(',', $idsTmp));
			if ( $list['errno'] ) { echo "errno:{$list['errno']} err:{$list['err']} <br>\n"; }
			
			if ( isset($list['rst']) && is_array($list['rst']) )
			{
				foreach ($list['rst'] as $aWb)
				{
					if ( isset($aWb['id']) )
					{
						$wbId			= $aWb['id'];
						$wbList[$wbId] 	= $aWb;
					}
				}
			}
		}
		return $wbList;
	}
}
