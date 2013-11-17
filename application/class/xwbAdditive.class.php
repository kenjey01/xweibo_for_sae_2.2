<?php
/**
 * @file			xwbAdditive.class.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2011-04-01
 * @Modified By:	heli/2011-04-01
 * @Brief			发微博后的附加操作处理
 */

class xwbAdditive {

	var $db;
	function xwbAdditive()
	{
		$this->db = APP::ADP('db');
	}

	/**
	 * demo 方法
	 * @param string $params 传递的参数 json结构
	 * @param array $result 调用api返回的数据 即使用DS方法调用api
	 */
	function extra_test($params, $result) {
		$params_array = json_decode($params, true);
		$wid = $result['id'];
	}
	
	
	/**
	 * 增加在线访谈微博,提问参数$params['interview_id'],
	 * 回答参数$params['interview_id'],$params['ask_id']
	 * @param array $params
	 * @param rst $response
	 */
	function extra_interView($params, $response, $suid=FALSE, $wbState=FALSE)
	{
		// 检查interview id 和api 增加微博失败
		if ( !isset($params['interview_id']) || !isset($response['id']) ) {
			return FALSE;
		}
		
		// 检查 interview
		$interview = DR('MicroInterview.getById', 'g0/'.CACHE_HOME_TIMELINE, $params['interview_id']);
		if ( empty($interview) || $interview['status']=='E' )
		{
			return FALSE;
		}
		
		
		$curUid = $suid ? $suid : USER::uid();
		$weibo  = json_encode($response);
		
		// 回答微博入库
		if ( isset($params['ask_id']) ) 
		{
			DR('InterviewWb.updateAnswer', FALSE, $params['interview_id'], $params['ask_id'], $curUid, $response['id'], $weibo);
			DR('InterviewWbAtme.updateAnswer', FALSE, $params['interview_id'], $params['ask_id'], $curUid, $response['id'], $weibo);
			return TRUE;
		} 
		
		
		// 主持人、嘉宾点评入库
		$params['ask_id'] 	= $response['id'];
		$params['ask_uid'] 	= $curUid;
		$params['weibo']	= $weibo;
		
		if ( isset($interview['master'][$curUid]) || isset($interview['guest'][$curUid]) )
		{
			$params['answer_wb'] = $params['ask_id'];
			$params['state']	 = 'A';
			DR('InterviewWb.saveWb', FALSE, $params, FALSE);
			return TRUE;
		}
		
		
		// 用户提问入库
		$params['answer_wb'] 	= 0;
		$params['state'] 		= $wbState ? $wbState : $interview['wb_state'];
		DR('InterviewWb.saveWb', FALSE, $params, FALSE);
		
		
		// 提问嘉宾记录入库
		if ( is_array($interview['guest']) )
		{
			foreach ($interview['guest'] as $uid=>$aGuest)
			{
				$screenName = preg_quote($aGuest['screen_name']);
				if ( preg_match("/@{$screenName}(\s+|$)/i", $response['text']) )
				{
					$data 					= array();
					$data['interview_id'] 	= $params['interview_id'];
					$data['ask_id'] 		= $params['ask_id'];
					$data['at_uid'] 		= $uid;
					$data['answer_wb'] 		= 0;
					
					DR('InterviewWbAtme.saveWb', FALSE, $data);
				}
			}
		}
		return TRUE;
	}

	/**
	 * 增加在线直播微博
	 * @param array $params
	 * @param rst $result
	 */
	function extra_live($params, $result, $sina_uid = false, $state = false) {
		// 检查在线直播id 和发布的微博是否存在
		if ( !isset($params['live_id']) || !isset($result['id']) ) {
			return false;
		}
		
		// 检查在线直播 
		$liveInfo = DS('microLive.getLiveById', 'g0/1800', $params['live_id']);
		if ( empty($liveInfo) )
		{
			return false;
		}

		$uid = $sina_uid ? $sina_uid : USER::uid();
		$master = explode(',', $liveInfo['master']);
		$guest = explode(',', $liveInfo['guest']);
		if (in_array($uid, $master)) {
			$type = 2;
		} elseif (in_array($uid, $guest)) {
			$type = 3;
		} else {
			$type = 1;
		}
		if ($liveInfo['wb_state'] == 'P' && $type ==1 && !$state) {
			$state = 2;
		} else {
			$state = 1;
		}
		/// 保存在线直播微博信息
		DR('microLive.updateMicroLive', '', $liveInfo['id'], $result['id'], $type, $state, $result);

		/// 清除微博列表缓存
		DD('microLive.getMicroLiveWbs');
		/// 清除微博总数
		DD('microLive.getCount');
		DD('microLive.getWbCount');
	}

	/**
	 * 发表活动评论
	 */
	function extra_event($params, $result) {
		// 检查活动id 和发布的微博是否存在
		if ( !isset($params['event_id']) || !isset($result['id']) ) {
			return false;
		}
		
		if ( isset($params['event_wb']) && $params['event_wb'] ) {		// 活动本身的微博
			DR('events.save', '', array('wb_id'=>$result['id']), $params['event_id']);
		} else {	// 活动评论的微博
			DR('events.commentEvent', '', $params['event_id'], $result['id'], $result);
		}
	}
}
?>
