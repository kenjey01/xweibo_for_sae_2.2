<?php
/**************************************************
*  Created:  2011-04-06
*
*  在线访谈 
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author liwen <liwen2@staff.sina.com.cn>
*
***************************************************/

class interview_mod
{
	/**
	 * 纯微博列表
	 */
	var $_list = array();
	
	function interview_mod() 
	{
		// Cunstructor Here
	}

	
	
	/**
	 * 在线访谈
	 */
	function default_action() 
	{
		$id = V('g:id', 0);
		
		// 在线访谈页
		if ($id)  
		{
			$this->_detail($id);
			exit();
		}
		
		// 在线访谈首页
		$this->_list();
	}
	
	
	/**
	 * 在线访谈列表
	 */
	function _list()
	{
		$cofig		= V('-:sysConfig/microInterview_setting');
		$cofig		= json_decode($cofig, TRUE);
		$master		= isset($cofig['master']) ? $cofig['master'] : array();
		
		if ( !USER::isUserLogin() ){ DS('xweibo/xwb.setToken', '', 2); }
		$userlist 	= F('get_user_show', implode(',', $master), '1800');
		if ( empty($userlist['errno']) ) {
			$userlist = $userlist['rst'];
		}
		
		$banner_img = isset($cofig['banner_img']) ? $cofig['banner_img'] : (WB_LANG_TYPE_CSS ? W_BASE_URL.'img/'.WB_LANG_TYPE_CSS.'/talk_bg.jpg' : W_BASE_URL.'img/talk_bg.jpg');
		TPL::assign('userlist', $userlist);
		TPL::assign('config', $cofig);
		TPL::assign('banner_img', $banner_img);
		TPL::assign('friendList', $this->_getUserFriends() );
		TPL::display('interview/index');
	}
	
	
	
	/**
	 * 在线访谈更多页面
	 */
	function page()
	{
		// List Record
		$page 	 	= V('g:page', 1);
		$limit 		= 20;
		$offset 	= ($page-1) * $limit;
		
		$totalCnt 	= DR('MicroInterview.getCount');
		$list  		= DR('MicroInterview.getList', FALSE, $offset, $limit);
		$cofig		= V('-:sysConfig/microInterview_setting');
		$cofig		= json_decode($cofig, TRUE);
		
		$master		= isset($cofig['master']) ? $cofig['master'] : array();
		if ( !USER::isUserLogin() ){ DS('xweibo/xwb.setToken', '', 2); }
		$userlist 	= F('get_user_show', implode(',', $master), '1800');
		if ( empty($userlist['errno']) ) {
			$userlist = $userlist['rst'];
		}
		
		TPL::assign('userlist', $userlist);
		
		// Assigne Var
		TPL::assign('list', $list);
		TPL::assign('count', $totalCnt);
		TPL::assign('limit', $limit);
		
		TPL::assign('config', $cofig);
		TPL::assign('friendList', $this->_getUserFriends() );
		TPL::display('interview/page');
	}
	
	
	/**
	 * 获取用户关注ID列表
	 */
	function _getUserFriends()
	{
		if ( !USER::isUserLogin() ) {
			return array();
		}
		
		$rsp 		= DR('xweibo/xwb.getFriendIds', 'g2/300', null, USER::uid(), null, null, null, 2000);
		$friendList = array();
		
		if ( is_array($rsp['rst']['ids']) )
		{
			foreach ( $rsp['rst']['ids'] as $id )
			{
				$friendList[$id] = $id;
			}
		}
		return $friendList;
	}
	
	
	/**
	 * 指定在线访谈页面
	 * @param int $id
	 */
	function _detail($id)
	{
		// 获取指定访谈和访谈列表信息
		$interview = DR('MicroInterview.getById', FALSE, $id);
		if ( empty($interview) )
		{
			APP::tips( array('tpl'=>'e404', 'msg'=> L('controller__common__interviewNotExist')) );
		}
		
		$interviewList = DR('MicroInterview.getList', FALSE, 0, 10);
		
		TPL::assign('interview', $interview);
		TPL::assign('interviewList', $interviewList);
		TPL::assign('friendList', $this->_getUserFriends() );
		
		// 获取微博列表
		$interviewId = $interview['id'];
		$wbList 	 = array();
		$page 		 = V('g:page', 1);
		
		switch ( $interview['status'] )
		{
			// 已结束
			case 'E':	
				$limit 					= 20;
				$offset 				= ($page-1) * $limit;
				$params					= array('state'=>'A', 'type'=>'answer');
				$listTmp				= DR('InterviewWb.getList', FALSE, $interviewId, $params, $offset, 20, 'answer_wb DESC');
				$wbList['answerCnt'] 	= DR('InterviewWb.getCount', FALSE, $interviewId, $params);
				$params['type']			= 'reply';
				$wbList['replyCnt']		= DR('InterviewWb.getCount', FALSE, $interviewId, $params);
				$wbList['answerList']	= $this->_buildWbList($listTmp, $interviewId);
				
				TPL::assign('wbList', $wbList);
				TPL::assign('limit', $limit);
				TPL::assign('list', array_values($this->_list) );
				TPL::display('interview/closed', array(), 0, 'modules');
			break;
			
			
			// 未开始、进行中, 根据嘉宾、主持人、用户的角色获取微博列表
			default:	
				
				$curUid = USER::uid();
				
				
				//嘉宾 
				if ( isset($interview['guest'][$curUid]) )	
				{
					$limit 	= 20;
					$type	= V('g:type', '');
					$offset = ($page-1) * $limit;
					
					// 所有问题列表
					if ($type=='all')
					{
						$params				= array('state'=>'A', 'type'=>'ask');
						$listTmp			= DR('InterviewWb.getList', FALSE, $interviewId, $params, $offset, $limit);
						$wbList['myCnt'] 	= DR('InterviewWb.getCount', FALSE, $interviewId, $params);
						$wbList['myList']	= $this->_buildWbList($listTmp);
					} 
					else if ($type=='myAnswered')	// 我回答过的问题
					{
						$listTmp			= DR('InterviewWb.getGuestAnswered', FALSE, $interviewId, $curUid, $offset, $limit);
						$wbList['myCnt'] 	= DR('InterviewWb.getGuestAnsweredCnt', FALSE, $interviewId, $curUid);
						$wbList['myList']	= $this->_buildWbList($listTmp, $interviewId);
					}
					else 	// 我的问题列表
					{
						$listTmp			= DR('InterviewWbAtme.getUserAskList', FALSE, $interviewId, USER::uid(), $offset, $limit);
						$wbList['myCnt'] 	= DR('InterviewWbAtme.getUserAskCount', FALSE, $interviewId, USER::uid());
						$wbList['myList']	= $this->_buildWbList($listTmp);
						$type				= 'guest';
					}
					
					TPL::assign('wbList', $wbList);
					TPL::assign('type', $type);
					TPL::assign('limit', $limit);
					TPL::assign('list', array_values($this->_list) );
					TPL::display('interview/guest_going', array(), 0, 'modules');
				} 
				
				
				// 主持人
				else if ( isset($interview['master'][$curUid]) )	
				{
					$limit 					= 20;
					$offset 				= ($page-1) * $limit;
					$params					= array('state'=>'A', 'type'=>'answer');
					$listTmp				= DR('InterviewWb.getList', FALSE, $interviewId, $params, $offset, $limit, 'answer_wb DESC');
					$wbList['answerCnt'] 	= DR('InterviewWb.getCount', FALSE, $interviewId, $params);
					$params['type']			= 'reply';
					$wbList['replyCnt']		= DR('InterviewWb.getCount', FALSE, $interviewId, $params);
					$wbList['answerList']	= $this->_buildWbList($listTmp, $interviewId);
					
					
					// 提问总数
					$params					= array('state'=>'A', 'type'=>'allAsk');
					$wbList['allAskCnt'] 	= DR('InterviewWb.getCount', FALSE, $interviewId, $params);
					
					TPL::assign('wbList', $wbList);
					TPL::assign('limit', $limit);
					TPL::assign('list', array_values($this->_list) );
					TPL::display('interview/master_going', array(), 0, 'modules');
				}
				
				
				// 一般用户
				else 	
				{
					// 未开始
					if ( $interview['status']=='P' )
					{
						$limit 				= 40;
						$offset 			= ($page-1) * $limit;
						$params				= array('state'=>'A', 'type'=>'ask');
						$listTmp			= DR('InterviewWb.getList', FALSE, $interviewId, $params, $offset, $limit);
						$wbList['askCnt'] 	= DR('InterviewWb.getCount', FALSE, $interviewId, $params);
						$wbList['askList']	= $this->_buildWbList($listTmp);
						
						TPL::assign('wbList', $wbList);
						TPL::assign('limit', $limit);
						TPL::assign('list', array_values($this->_list) );
						TPL::display('interview/not_start', array(), 0, 'modules');
					}
					
					//  进行中
					else 
					{
						$params				= array('state'=>'A', 'type'=>'ask');
						$listTmp			= DR('InterviewWb.getList', FALSE, $interviewId, $params, 0, 20);
						$wbList['allAskCnt']= DR('InterviewWb.getCount', FALSE, $interviewId, array('state'=>'A', 'type'=>'allAsk'));
						$wbList['askCnt'] 	= DR('InterviewWb.getCount', FALSE, $interviewId, $params);
						$wbList['askList']	= $this->_buildWbList($listTmp);
						
						$params					= array('state'=>'A', 'type'=>'answer');
						$listTmp				= DR('InterviewWb.getList', FALSE, $interviewId, $params, 0, 10, 'answer_wb DESC');
						$wbList['answerCnt'] 	= DR('InterviewWb.getCount', FALSE, $interviewId, $params);
						$params['type']			= 'reply';
						$wbList['replyCnt'] 	= DR('InterviewWb.getCount', FALSE, $interviewId, $params);
						$wbList['answerList']	= $this->_buildWbList($listTmp, $interviewId);
						
						TPL::assign('wbList', $wbList);
						TPL::assign('list', array_values($this->_list) );
						TPL::display('interview/going', array(), 0, 'modules');
					}
				}
			break;
		}
	}
	
	
	/**
	 * 构建微博结构，主要是获取微博内容
	 * @param array $list
	 * @param bigint $interviewId, 为FALSE时，不需要回答
	 */
	function _buildWbList($list, $interviewId=FALSE)
	{
		// 空检查
		if ( empty($list) ) 
		{
			return array();
		}
		
		
		// 构建格式
		$wbList 	= array();
		$answerList = array();
		$comWbList	= array();
		
		foreach ($list as $aRecord)
		{
			$id 			= $aRecord['ask_id'];
			$wbList[$id] 	= $aRecord;
			
			// 回答微博, 当$answerId==$id的时候,属于点评微博
			$answerId=$aRecord['answer_wb'];
			if ($interviewId && $answerId)
			{
				if ( $answerId==$id ) {
					$comWbList[$id] = $id;
				} else {
					$answerList[$answerId] = $id;
				}
			}
		}
		
		
		// 获取嘉宾答案
		if ( $interviewId )
		{
			$askIdList 	= array_keys($wbList);
			$answerTmp	= DR('InterviewWbAtme.getAnswerList', FALSE, $interviewId, $askIdList);
			if ( is_array($answerTmp) )
			{
				foreach ($answerTmp as $tmpList)
				{
					$answerId 				= $tmpList['answer_wb'];
					$answerList[$answerId]	= $tmpList['ask_id'];
				}
			}
		}
		
		// 获取微博信息
		$wbList = $this->_getWbInfo($wbList, $answerList, $interviewId, $comWbList);
		return $wbList;
	}
	
	
	
	/**
	 * 获取微博信息
	 * @param array $wbList
	 * @param array $answerList
	 * @param bigint $interviewId, 为FALSE时，不需要回答
	 */
	function _getApiWbInfo(&$wbList, $answerList, $interviewId, $comWbList)
	{
		$idList = array_merge( array_keys($wbList), array_keys($answerList) );
		
		// 获取微博信息
		$each 	= 20;
		$start	= 0;
		$total 	= count($idList);
		
		while ( $start<$total )
		{
			$idTmpList 	= array_slice($idList, $start, $each);
			$rspTmp 	= DR('xweibo/xwb.getStatusesBatchShow', FALSE, implode(',', $idTmpList) );
			
			if ( is_array($rspTmp['rst']) )
			{
				foreach ( $rspTmp['rst'] as $aWb)
				{
					$idTmp = $aWb['id'];
					
					/// 如果该微博已经被删除，也删除本地记录
					if ( isset($aWb['estate']) && $aWb['estate']=='deleted' ) 
					{
						if ( $interviewId ) {
							DR('InterviewWbAtme.delAnswer', FALSE, $interviewId, USER::uid(), $idTmp);
						} 
						
						// Del Wb
						DR('InterviewWb.delWb', FALSE, $idTmp);
						if ( isset($wbList[$idTmp]) ) {
							unset($wbList[$idTmp]);
						}
						
						continue;
					}
					
					
					// 保存原微博列表
					$this->_list[$idTmp] = $aWb;
					
					// 点评微博
					if ( isset($comWbList[$idTmp]) )
					{
						$wbList[$idTmp]['comWb'] = $aWb;
						continue;
					}
					
					/// 提问微博
					if ( isset($wbList[$idTmp]) )
					{
						$wbList[$idTmp]['askWb'] = $aWb;
					}
					
					/// 回答微博
					if ( isset($answerList[$idTmp]) )
					{
						$wbIdTmp = $answerList[$idTmp];
						if ( isset($wbList[$wbIdTmp]) ) 
						{
							$wbList[$wbIdTmp]['answerWb'][$idTmp] = $aWb;
						}
					}
				}
			}
			
			$start += $each;
		}
		
		krsort($this->_list);
		return $wbList;
	}
	
	
	/**
	 * 获取微博信息
	 * @param array $wbList
	 * @param array $answerList
	 * @param bigint $interviewId, 为FALSE时，不需要回答
	 */
	function _getWbInfo(&$wbList, $answerList, $interviewId, $comWbList)
	{
		$idList   	= array_merge( array_keys($wbList), array_keys($answerList) );
		$wbListTmp 	= DR('InterviewWb.getWeiboByIds', FALSE, $idList);
		$atmeList 	= DR('InterviewWbAtme.getWeiboByIds', FALSE, $idList);
		$weiboList	= array_merge($wbListTmp, $atmeList);
		
		foreach ( $weiboList as $aWb)
		{
			$idTmp = $aWb['id'];
			if ( empty($idTmp) ) {
				continue;
			}
			
			// 保存原微博列表
			$this->_list[$idTmp] = $aWb;
			
			// 点评微博
			if ( isset($comWbList[$idTmp]) )
			{
				$wbList[$idTmp]['comWb'] = $aWb;
				continue;
			}
			
			/// 提问微博
			if ( isset($wbList[$idTmp]) )
			{
				$wbList[$idTmp]['askWb'] = $aWb;
			}
			
			/// 回答微博
			if ( isset($answerList[$idTmp]) )
			{
				$wbIdTmp = $answerList[$idTmp];
				if ( isset($wbList[$wbIdTmp]) ) 
				{
					$wbList[$wbIdTmp]['answerWb'][$idTmp] = $aWb;
				}
			}
		}
		
		krsort($this->_list);
		return $wbList;
	}
	
	
	
	/**
	 * 获取最新微博信息
	 */
	function unread() 
	{
		// Check Interview
		$sinceId 		= V('p:wb_id');
		$maxId			= V('p:min_id');
		$interviewId 	= V('p:id');
		$interview 		= DR('MicroInterview.getById', FALSE, $interviewId);
		
		if ( empty($interview) || (empty($sinceId) && empty($maxId)) )
		{
			APP::ajaxRst('false', '11111', L('controller__interview__paramsNotExist'));
		}
		
		$currentUid 	= USER::uid();
		$wbList['html']	= array();
		$json			= array();
		
		switch ( V('p:type') )
		{
			// 问答微博
			case 'answer':
				// Build Params
				$params	= array('state'=>'A', 'type'=>'answer');
				if ( $sinceId ) 
				{
					$params['since_id'] = $sinceId;
				}
				
				if ( $maxId )
				{
					$params['max_id'] = $maxId;
				}
				
				
				$listTmp				= DR('InterviewWb.getList', FALSE, $interviewId, $params, 0, 2, 'answer_wb DESC');
				$wbList['newCnt'] 		= DR('InterviewWb.getCount', FALSE, $interviewId, $params);
				$wbList['replyCnt'] 	= DR('InterviewWb.getCount', FALSE, $interviewId, array('state'=>'A', 'type'=>'reply'));
				$wbList['totalCnt'] 	= DR('InterviewWb.getCount', FALSE, $interviewId, array('state'=>'A', 'type'=>'allAsk'));
				$wbList['answerList']	= $this->_buildWbList($listTmp, $interviewId);
				$json['reply']			= $wbList['replyCnt'];
				
				// Build Wb Html
				if ( is_array($wbList['answerList']) )
				{
					foreach ($wbList['answerList'] as $wbId=>$aWbTmp)
					{
						// 评论微博
						if ( isset($aWbTmp['comWb']) )
						{
							$wb			= $aWbTmp['comWb'];
							$wb['uid'] 	= 'false';
								
							$wbList['html'][$wbId]  = '<div class="emcee-com"><div class="talk-content" rel="w:'. $wb['id'].'">';
	                       	$wbList['html'][$wbId] .= TPL::module('feed', $wb, FALSE);
							$wbList['html'][$wbId] .= '<div class="emcee-icon"></div></div></div>';
							continue;
						}
								
								
						// 问答微博开始
						$wbList['html'][$wbId] = '<div class="inte-list">';
								
						// 问微博
						if ( isset($aWbTmp['askWb']) )
						{
							$wb			= $aWbTmp['askWb'];
							$wb['uid'] 	= 'false';
								
							$wbList['html'][$wbId] .= '<div class="talk-content fans-ask" rel="w:'. $wb['id'].'">';
	                       	$wbList['html'][$wbId] .= TPL::module('feed', $wb, FALSE);
							$wbList['html'][$wbId] .= '<div class="ask-icon"></div></div>';
						}
								
						// 答微博
						if ( isset($aWbTmp['answerWb']) && is_array($aWbTmp['answerWb']) )
						{
							foreach ($aWbTmp['answerWb'] as $wb)
							{
								$wb['uid'] 	= 'false';
										
								$wbList['html'][$wbId] .= '<div class="talk-content guest-reply" rel="w:'. $wb['id'].'">';
	                           	$wbList['html'][$wbId] .= TPL::module('interview/feed_answer', $wb, FALSE);
								$wbList['html'][$wbId] .= '<div class="reply-icon"></div></div>';
							}
						}
						
						$wbList['html'][$wbId] .= '</div>';
					}
				}
			break;
			
			
			// 嘉宾"我的问题"
			case 'guest':
				// Build Params
				$params	= array();
				if ( $sinceId ) {
					$params['since_id'] = $sinceId;
				}
				
				$listTmp			= DR('InterviewWbAtme.getUserAskList', FALSE, $interviewId, $currentUid, 0, 10, $params);
				$wbList['newCnt'] 	= DR('InterviewWbAtme.getUserAskCount', FALSE, $interviewId, $currentUid, $params);
				$wbList['totalCnt'] = DR('InterviewWbAtme.getUserAskCount', FALSE, $interviewId, $currentUid);
				$wbList['askList']	= $this->_buildWbList($listTmp);
				
				// Build Wb Html
				if ( is_array($wbList['askList']) )
				{
					foreach ($wbList['askList'] as $wbId=>$aWbTmp)
					{
						$wb			= $aWbTmp['askWb'];
						$wb['uid'] 	= 'false';
						
						if ( isset($interview['guest'][$currentUid]) ) {
							$wbList['html'][$wbId] 	= '<li rel="w:'.$wb['id'].'">' . TPL::module('interview/feed_withAnswer', $wb, FALSE) . '</li>';
						} else {
							$wbList['html'][$wbId] 	= '<li rel="w:'.$wb['id'].'">' . TPL::module('feed', $wb, FALSE) . '</li>';
						}
					}
				}
			break;
			
			
			// 提问微博列表
			default:
				// Build Params
				$params	= array('state'=>'A', 'type'=>'ask');
				if ( $sinceId ) {
					$params['since_id'] = $sinceId;
				}
				
				if ( $maxId ) {
					$params['max_id'] = $maxId;
				}
				
				$listTmp			= DR('InterviewWb.getList', FALSE, $interviewId, $params, 0, 10);
				$wbList['newCnt'] 	= DR('InterviewWb.getCount', FALSE, $interviewId, $params);
				$wbList['totalCnt'] = DR('InterviewWb.getCount', FALSE, $interviewId, array('state'=>'A', 'type'=>'ask'));
				$wbList['askList']	= $this->_buildWbList($listTmp);
				
				// Build Wb Html
				if ( is_array($wbList['askList']) )
				{
					foreach ($wbList['askList'] as $wbId=>$aWbTmp)
					{
						$wb			= $aWbTmp['askWb'];
						$wb['uid'] 	= 'false';
						
						if ( isset($interview['guest'][$currentUid]) ) {
							$wbList['html'][$wbId] 	= '<li rel="w:'.$wb['id'].'">' . TPL::module('interview/feed_withAnswer', $wb, FALSE) . '</li>';
						} else {
							$wbList['html'][$wbId] 	= '<li rel="w:'.$wb['id'].'">' . TPL::module('feed', $wb, FALSE) . '</li>';
						}
					}
				}
			break;
		}
		
		
		$list			= array_values($this->_list);
		$json['list'] 	= F('format_weibo', $list);
		$json['html'] 	= $wbList['html'];
		$json['count'] 	= $wbList['newCnt'];
		$json['total']	= $wbList['totalCnt'];
		$json['status']	= $interview['status'];
		
		// 获取最大的微博ID
		if ( $sinceId ) 
		{
			$json['wb_id']  = empty($list) ? $sinceId : $list[0]['id'];
		}
		
		// 获取下最小微博ID
		if ( $maxId ) 
		{
			if ( empty($list) )
			{
				$json['min_id']  = $maxId;
			}
			else 
			{
				$minWb 			= array_pop($list);
				$json['min_id'] = $minWb['id'];
				array_push($list, $minWb);
			}
		}
		
		APP::ajaxRst($json, 0);
	}

	
	
	function syncApiWb_action()
	{
		
	}
}
