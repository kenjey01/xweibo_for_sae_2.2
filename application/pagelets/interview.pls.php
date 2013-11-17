<?php
class interview_pls
{
	
	/**
	 * 在线访谈通用的微博列表
	 * @param string $tplName
	 * @param array $param
	 */
	function interviewWeiboList($param)
	{
		TPL::module($param['tpl'], $param);
		$wbId	 		= isset($param['list'][0]['id']) ? $param['list'][0]['id'] : '';
		$wbId			= $this->_getCurWbId($wbId);
		$interviewId	= isset($param['interview']['id']) ? $param['interview']['id'] : '';
		$minId			= '';
		
		if ( is_array($param['list']) && $minWb=array_pop($param['list']) )
		{
			$minId	= $minWb['id'];
			array_push($param['list'], $minWb);
		}
		
		return array(	'cls'			=> 'wblist', 
						'list' 			=> F('format_weibo',$param['list']), 
						'wb_id'			=> $wbId, 
						'interview_id'	=> $interviewId,
						'min_id'		=> $minId
				);
	}
	
	
	/**
	 * 在线访谈的微博列表2, 只在同一页面有两个微博列表的时候输出
	 * @param string $tplName
	 * @param array $param
	 */
	function interviewGoingAskWeiboList($param)
	{
		TPL::module($param['tpl'], $param);
		$wbId 			= isset($param['list'][0]['id']) ? $param['list'][0]['id'] : '';
		$wbId			= $this->_getCurWbId($wbId);
		$interviewId	= isset($param['interview']['id']) ? $param['interview']['id'] : '';
		$minId			= '';
		$type			= isset($param['type']) ? $param['type'] : '';
		
		if ( is_array($param['list']) && $minWb=array_pop($param['list']) )
		{
			$minId	= $minWb['id'];
			array_push($param['list'], $minWb);
		}
		
		return array(	'cls'			=> 'wblist', 
						'list' 			=> F('format_weibo',$param['list']), 
						'wb_id'			=> $wbId, 
						'interview_id'	=> $interviewId,
						'type'			=> $type,
						'min_id'		=> $minId
			);
	}
	
	
	/**
	 * 在线访谈首页的主持人列表
	 * @param array $params
	 */
	function baseMasterList($params)
	{
		TPL::module('interview/user_list_s1', array('masterList'=>$params['masterList'], 'friendList'=>$params['friendList']));
	}
	
	
	/**
	 * 首页在线访谈列表
	 * @param array $params
	 */
	function index_list($params)
	{
		// List And Latest Record
		$limit		= 10;
		$totalCnt 	= DR('MicroInterview.getCount');
		$list  		= DR('MicroInterview.getList', FALSE, 0, $limit);
		$lastRecord = count($list)>0 ? array_shift($list) : array();
		
		// Assigne Var
		$_data['list'] 			= $list;
		$_data['count'] 		= $totalCnt;
		$_data['limit'] 		= $limit;
		$_data['last'] 			= $lastRecord;
		$_data['dateFormat'] 	= L('pls__intervies__indexList__timeFormat');
		
		TPL::module('interview/index_list', $_data);
	}
	
	
	/**
	 * 在线访谈页的嘉宾列表
	 * @param array $params
	 */
	function guestList($params)
	{
		TPL::module('interview/include/user_sidebar', $params);
	}
	
	
	/**
	 * 获取用户阅读过的最大 微博ID
	 * @param $id
	 */
	function _getCurWbId($id)
	{
		$wbKey		 = 'live#maxwbId';
		$sessionWbId = USER::V($wbKey);
		if ( empty($sessionWbId) || ($sessionWbId && $id && $id>$sessionWbId) )
		{
			USER::V($wbKey, $id);
			return $id;
		}
		
		return $sessionWbId;
	}
}
