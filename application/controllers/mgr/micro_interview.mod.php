<?php
include('action.abs.php');

class micro_interview_mod extends action 
{

	/**
	 *\brief construct function
	 */
	function micro_interview_mod() 
	{
		parent::action();
	}

	
	
	/**
	 * \brief setting pageType page
	 */
	function default_action() 
	{
		/// 如果没有设置在线直播基本信息，跳转到设置在线直播基本信息页
		$rs = DS('common/sysConfig.get', FALSE, 'microInterview_setting');
		if (empty($rs)) 
		{
			APP::M('mgr/micro_interview.set');
			exit;
		}
		
		// Page
        $pager    	= APP::N('pager');
		$totalCnt 	= DR('MicroInterview.getCount');
		$offset 	= $pager->initParam($totalCnt);
		$list  		= DR('MicroInterview.getList', FALSE, $offset, $pager->getParam('pageSize'));
		
		TPL::assign('pager', $pager->makePage());
		TPL::assign('list', $list);
		TPL::assign('offsetCnt', $offset+1);
		TPL::assign('currentPage', $pager->getParam('currentPage') );
		$this->_display('interview/list');
	}
	
	
	/**
	 * 创建在线访谈
	 */
	function create() 
	{
		$rs = V('-:sysConfig/microInterview_setting'); 
		$rs = json_decode($rs, true);
		
		$rstList	 = F('get_user_show', implode(',', $rs['master']) );
		$master_list = array();
		if ( empty($rstList['errno']) ) 
		{
			$master_list = $rstList['rst'];
		}

		/// 默认banner,cover,backgroup图片路径
		if (WB_LANG_TYPE_CSS) {
			/// 多语言
			$default_banner_img 	= W_BASE_URL_PATH.'img/'.WB_LANG_TYPE_CSS.'/talk_banner_960.png';	
			$default_cover_img 		= W_BASE_URL_PATH.'img/'.WB_LANG_TYPE_CSS.'/talk_logo_124.jpg';
		} else {
			$default_banner_img 	= W_BASE_URL_PATH.'img/talk_banner_960.png';	
			$default_cover_img 		= W_BASE_URL_PATH.'img/talk_logo_124.jpg';
		}
		$default_backgroup_img 		= W_BASE_URL_PATH.'img/live_bg_main.jpg';

		TPL::assign('default_banner_img', $default_banner_img);
		TPL::assign('default_cover_img', $default_cover_img);
		TPL::assign('default_backgroup_img', $default_backgroup_img);
		TPL::assign('master_list', $master_list);
		$this->_display('interview/form');
	}

	
	/**
	 * 编辑在线访谈
	 */
	function modify() 
	{
		// Interview
		$id 		= V('g:id');
		$interview 	= DR('MicroInterview.getById', FALSE, $id);
		if ( empty($interview) ) 
		{
			$this->_error('找不到对应的在线访谈', URL('mgr/micro_interview') );
		}
		
		TPL::assign('master_list', $interview['master']);
		TPL::assign('guest_list', $interview['guest']);
		TPL::assign('interview', $interview);
		$this->_display('interview/form');
	}
	
	
	/**
	 * 设置基本信息
	 */
	function set() 
	{
		$config = DS('common/sysConfig.get', FALSE, 'microInterview_setting');
		$config = json_decode($config, TRUE);
		
		$master		= isset($config['master']) ? $config['master'] : array();
		$userlist 	= F('get_user_show', implode(',', $master), '1800');
		
		if ( empty($userlist['errno']) ) {
			$userlist = $userlist['rst'];
		}
		/// 默认banner图路径
		if (WB_LANG_TYPE_CSS) {
			/// 多语言
			$default_banner_img = W_BASE_URL.'img/'.WB_LANG_TYPE_CSS.'/talk_bg.jpg';	
		} else {
			$default_banner_img = W_BASE_URL.'img/talk_bg.jpg';	
		}

		TPL::assign('userlist', $userlist);
		TPL::assign('config', $config);
		TPL::assign('default_banner_img', $default_banner_img);
		$this->_display('interview/infomation');
	}

	
	/**
	 * 保存更新在线直播
	 */
	function saveInterview()
	{
		$url = URL('mgr/micro_interview');
		
		if( strtolower(V('s:REQUEST_METHOD'))=='post' )
		{
			$id = trim(V('p:id',''));
			if($id)
			{
				//非法数据
				if(!is_numeric($id))
				{
					$this->_error('编辑的在线直播id为空', $url);
				}
				
				//是否有权限编辑此在线直播
				$interview = DR('MicroInterview.getById', FALSE, $id);
				if( $interview===false || sizeof($interview) == 0 ){
					$this->_error('需要编辑的在线直播不存在', $url);
				}
				$id = $interview['id'];
			}
			
			//检查数据
			$data 	= $this->_checkData($id);
			$result = DR('MicroInterview.save', FALSE, $data, $id);
			$id 	= $result['rst'];

			//跳转到在线直播列表
			if($result['rst']!==false)
			{
				$this->_succ('操作已成功', $url);
			}
		}
		
		$this->_error('操作失败！', $url);
	}

	
	
	/**
	 * 保存更新基本信息
	 */
	function saveBase() 
	{
		$desc 		= trim(V('p:desc', ''));
		$banner_img = trim(V('p:pic', W_BASE_URL.'img/'.WB_LANG_TYPE_CSS.'/talk_bg.jpg'));
		$master 	= V('p:master', array());
		$contact 	= trim(V('p:contact', ''));

		if ( empty($desc) || empty($master) || empty($contact)) {
			$this->_error('请输入必填项', URL('mgr/micro_interview.set'));
		}

		$params['desc'] 		= $desc;
		$params['master'] 		= $master;
		$params['banner_img'] 	= $banner_img;
		$params['contact'] 		= $contact;
		$value 					= json_encode($params);

		$rst = DR('common/sysConfig.set', FALSE, 'microInterview_setting', $value);
		if (empty($rst['errno'])) {
			$this->_succ('操作已成功', URL('mgr/micro_interview'));
		} else {
			$this->_error('操作失败！', URL('mgr/micro_interview.set'));
		}
	}
	
	
	
	/**
	 * 上传图片
	 */
	function upload() 
	{
		$thumb = V('p:thumb', FALSE);
		$this->_upload_pic( array('upload_path'=>'interview_pic', 'thumb'=>$thumb) );
	}
	
	
	/**
	 * 获取用户信息
	 */
	function getUserShow() {
		return $this->_getUserBatchShow();
	}

	
	/**
	 * 获取活动数据并检查
	 */
	function _checkData($id)
	{
		$title 				= trim(V('p:title',''));
		$desc 				= trim(V('p:desc',''));
		$banner_img 		= trim(V('p:banner_img',''));
		$cover_img 			= trim(V('p:cover_img', ''));
		$master 			= json_encode( V('p:master') );
		$guest 				= json_encode( V('p:guest') );
        $backgroup_img 		= trim(V('p:backgroup_img', ''));
		$start_time 		= trim(V('p:start_date',''));
		$end_time 			= trim(V('p:end_date',''));
        $backgroup_style 	= trim(V('p:backgroup_style', ''));
		$color 				= V('p:color', false);
		$custom 			= V('p:custom', false);
		$custom_color 		= '';
		$backgroup_color 	= '';
		
		/// 自定义颜色
		if (1 == $custom) 
		{
			$bkcolor 		= trim(V('p:bkcolor'), '');
			$linkcolor 		= trim(V('p:linkcolor'), '');
			$custom_color 	= $bkcolor.','.$linkcolor;
		} else {
			$backgroup_color = $color;
		}
		
		//判断必填项
		$start_time = strtotime($start_time.' '.(int)V('p:start_h',0).':'.(int)V('p:start_m',0));
		$end_time 	= strtotime($end_time.' '.(int)V('p:end_h',0).':'.(int)V('p:end_m',0));
		
		//结束时间要大于开始时间
		if($end_time<$start_time)
		{
			$this->_error('结束时间要大于开始时间', URL('mgr/micro_interview'));
		}

		
		if( empty($id) )
		{
			//发起在线访谈数据
			$data = array('title'			=> $title,
						  'desc'			=> $desc,
						  'banner_img'		=> $banner_img,
						  'cover_img'		=> $cover_img,
						  'master' 			=> $master,
						  'guest' 			=> $guest,
						  'backgroup_img' 	=> $backgroup_img,
						  'backgroup_color' => $backgroup_color,
						  'backgroup_style' => $backgroup_style,
						  'custom_color' 	=> $custom_color,
						  'state'			=> 'N',
						  'wb_state'		=> 'A',
						  'start_time'		=> $start_time,
						  'end_time'		=> $end_time,
						  'add_time'		=> APP_LOCAL_TIMESTAMP,
						  'notice_time'		=> intval(V('p:notice_time', 5)) * 60
						);
		}
		else	//编辑在线直播数据
		{
			$data = array('title'			=> $title,
						  'desc'			=> $desc,
						  'master' 			=> $master,
						  'guest' 			=> $guest,
						  'backgroup_style' => $backgroup_style,
						  'backgroup_color' => $backgroup_color,
						  'custom_color' 	=> $custom_color,
						  'start_time'		=> $start_time,
						  'end_time'		=> $end_time,
						  'notice_time'		=> intval(V('p:notice_time', 5)) * 60
						);
						
			if ($banner_img) {
				$data['banner_img'] = $banner_img;
			}
			if ($cover_img) {
				$data['cover_img'] = $cover_img;
			}
			if ($backgroup_img) {
				$data['backgroup_img'] = $backgroup_img;
			}
			if ($backgroup_color) {
				$data['backgroup_color'] = $backgroup_color;
			}
		}
		return $data;
	}
	
	
	
	/**
	 * Delete The Record
	 */
	function delInterView()
	{
		$id  = V('g:id');
		$url = URL('mgr/micro_interview', array('page'=>V('g:page')) );
		
		if ( $id && DR('MicroInterview.delInterview', FALSE, $id) ) 
		{
			$this->_succ('操作已成功', $url);
		} 
		
		$this->_error('操作失败，请检查输入参数是否正确', $url);
	}
	
	
	
	/**
	 * 设置在线访谈的微博策略
	 */
	function setWbState()
	{
		$id  	= V('p:id');
		$state  = V('p:state');
		$state  = in_array($state, array('P', 'A') ) ? $state : 'P';
		$result = DR('MicroInterview.setWbState', FALSE, $id, $state);
		
		if ( $result ) {
			APP::ajaxRst( $result ); 
		}
		
		// 失败处理
		APP::ajaxRst( 'false', '-1', '请检查输入参数是否正确' );
	}
	
	
	
	/**
	 * 列出待审微博
	 */
	function approveWbList()
	{
		$interviewId = V('g:id', 0);
		$interview	 = DR('MicroInterview.getById', FALSE, $interviewId);
		if ( empty($interview) ) 
		{
			$this->_error('找不到对应的在线访谈', URL('mgr/micro_interview') );
		}
		
		/// 待审核表在线直播的微博信息
		$verify_list  = array();
		$wbList = array();
		$verify_list = DS('weiboVerify.getWeiboVerifyList', false, array('type' => 'interview', 'extend_id' => $interviewId));
		if ($verify_list) {
			foreach ($verify_list as $var) {
				$wbList[$var['id']]['text'] = $var['weibo'];
				$wbList[$var['id']]['id'] = $var['id'];
				$wbList[$var['id']]['pic']  = (isset($var['picid'])&&$var['picid']) ? '<img src="'. F('profile_image_url.thumbnail_pic', $var['picid']) . '" />' : '';
				$wbList[$var['id']]['v'] = 1;
			}
		}
		$verify_totalCnt = DS('weiboVerify.getWeiboVerifyCount', false, array('type' => 'interview', 'extend_id' => $interviewId));

		$params['state'] 	= 'P';
		$interview_totalCnt	= DR('InterviewWb.getCount', FALSE, $interviewId, $params);
		$list  		 		= DR('InterviewWb.getList', FALSE, $interviewId, $params, 0, 20, 'ask_id ASC');
		$wb_list = $this->_buildWbList($list);

		$wb_list = array_merge($wb_list, $wbList);
		$totalCnt = (int)$interview_totalCnt + (int)$verify_totalCnt;
		
		TPL::assign('totalCnt', $totalCnt);
		TPL::assign('list',  $wb_list);
		TPL::assign('interviewId', $interviewId);
		TPL::assign('interview', $interview);
		$this->_display('interview/approve');
	}
	
	
	/**
	 * 构建微博结构，主要是获取微博内容
	 * @param array $list
	 */
	function _buildWbList($list)
	{
		// 空检查
		if ( empty($list) ) 
		{
			return array();
		}
		
		// 构建格式
		$wbList = array();
		$idList = array();
		foreach ($list as $aRecord)
		{
			$id 			= $aRecord['ask_id'];
			$wbList[$id] 	= $aRecord;
			array_push($idList, $id);
		}
		
		// 获取微博信息
		$rspTmp = DR('xweibo/xwb.getStatusesBatchShow', FALSE, implode(',', $idList) );
		if ( is_array($rspTmp['rst']) )
		{
			foreach ( $rspTmp['rst'] as $aWb)
			{
				$idTmp = $aWb['id'];
				if ( isset($aWb['estate']) && $aWb['estate']=='deleted' ) 
				{
					/// 如果该微博已经被删除，也删除本地记录
					DR('InterviewWb.delWb', FALSE, $idTmp);
				}
				else if ( isset($wbList[$idTmp]) )
				{
					$wbList[$idTmp]['text'] = $aWb['text'];
					$wbList[$idTmp]['pic']  = isset($aWb['thumbnail_pic']) ? "<img src='{$aWb['thumbnail_pic']}' />" : '';
				}
			}
		}
		
		return $wbList;
	}
	
	
	
	/**
	 * 删除待审微博
	 */
	function delWb()
	{
		if ( $id=V('g:id', 0) )
		{
			$url = URL('mgr/micro_interview.approveWbList', array('id'=>$id) );
			if ( $delId=V('g:delId', 0) )
			{
				if ( DR('InterviewWb.delWb', FALSE, $delId) ) 
				{
					$this->_succ('操作已成功', $url);
				} 
			}

			/// 待审核在线访谈
			$v = V('g:v', false);
			if ($v) {
				$vid = V('g:vid');
				$ret = DR('weiboVerify.updateWeiboVerify', false, $vid, 'delete');
				if ($ret['rst']) {
					$this->_succ('操作已成功', $url);
				}
			}

			$this->_error('操作失败，请检查输入参数是否正确', $url);
		}
		
		// 在线访谈ID 为空
		$this->_error('操作失败，请检查输入参数是否正确', URL('mgr/micro_interview') );
	}
	
	
	
	/**
	 * ajax 获取待审核微博数
	 */
	function countWb()
	{
		$interviewId 		= V('g:id', 0);
		$params['state']	= 'P';
		$interview_total = DR('InterviewWb.getCount', FALSE, $interviewId, $params);
		$verify_total = DS('weiboVerify.getWeiboVerifyCount', false, array('type' => 'interview', 'extend_id' => $interviewId));
		$result = (int)$interview_total + (int)$verify_total;
		
		if ( $result || $result===0 ) {
			APP::ajaxRst( $result ); 
		}
		
		// 失败处理
		APP::ajaxRst( 'false', '-1', '请检查输入参数是否正确' );
	}
	
	
	
	/**
	 * 审批微博
	 */
	function approveWb()
	{
		if ( $id=V('g:id',0) )
		{
			$url = URL('mgr/micro_interview.approveWbList', array('id'=>$id) );
			if ( $appId=V('g:appId',0) )
			{
				if ( DR('InterviewWb.setState', FALSE, $appId, 'A') ) 
				{
					$this->_succ('操作已成功', $url);
				} 

			}

			/// 待审核在线访谈
			$v = V('g:v', false);
			if ($v) {
				$vid = V('g:vid');
				$ret = DR('weiboVerify.updateWeiboVerify', false, $vid);
				if ($ret['rst']) {
					$this->_succ('操作已成功', $url);
				}
			}

			$this->_error('操作失败，请检查输入参数是否正确', $url);
		}
		
		// 在线访谈ID 为空
		$this->_error('操作失败，请检查输入参数是否正确', URL('mgr/micro_interview') );
	}
	
	
	
	/**
	 * 预览
	 */
	function preview()
	{
		// 启动Xpipe
		$GLOBALS[V_GLOBAL_NAME]['NEED_XPIPE'] = TRUE;
		Xpipe::usePipe(TRUE);
		
		// 获取指定访谈和访谈列表信息
		$interview 					= $_GET;
		$interview['start_time'] 	= strtotime($interview['start_date'].' '.(int)V('g:start_h',0).':'.(int)V('g:start_m',0));
		$interview['end_time'] 		= strtotime($interview['end_date'].' '.(int)V('g:end_h',0).':'.(int)V('g:end_m',0));
		$interview['status'] 		= $this->_getStatus($interview['start_time'], $interview['end_time']);
		$interview['dateFormat'] 	= DR('MicroInterview._getTimeFormat', FALSE, $interview['start_time'], $interview['end_time']);
		$interview['notice'] 		= (APP_LOCAL_TIMESTAMP+$interview['notice_time'] < $interview['start_time']) ? APP_LOCAL_TIMESTAMP+$interview['notice_time'] : NULL;
		$interviewList 				= DR('MicroInterview.getList', 'g0/'.CACHE_HOME_TIMELINE, 0, 10);
		
		// 主持人
		$rstMaster					= F('get_user_show', implode(',', $interview['master']) );
		$interview['master']		= $rstMaster['rst'];
		
		// 嘉宾
		$rstGest					= F('get_user_show', implode(',', $interview['guest']) );
		$interview['guest']			= $rstGest['rst'];
		
		/// 自定义颜色
		if (1 == $interview['custom']) 
		{
			$bkcolor 					= $interview['bkcolor'];
			$linkcolor 					= $interview['linkcolor'];
			$interview['custom_color'] 	= $bkcolor.','.$linkcolor;
		} else {
			$interview['backgroup_color'] 	= $interview['color'];
		}

		TPL::assign('interview', $interview);
		TPL::assign('interviewList', $interviewList);
		TPL::assign('friendList', array() );
		
		// 获取微博列表
		switch ( $interview['status'] )
		{
			// 未开始, 提问微博列表
			case 'P':	
				$limit 				= 40;
				$wbList['askCnt'] 	= 0;
				$wbList['replyCnt'] = 0;
				$wbList['askList']	= array();
				
				TPL::assign('wbList', $wbList);
				TPL::assign('limit', $limit);
				TPL::assign('list', array() );
				TPL::display('interview/not_start', array(), 0, 'modules');
			break;
			
			
			// 进行中
			case 'I':	
					$wbList['allAskCnt']	= 0;
					$wbList['askCnt'] 		= 0;
					$wbList['askList']		= array();
					$wbList['answerCnt'] 	= 0;
					$wbList['replyCnt'] 	= 0;
					$wbList['answerList']	= array();
					
					TPL::assign('wbList', $wbList);
					TPL::assign('list', array() );
					TPL::display('interview/going', array(), 0, 'modules');
			break;
			
			
			// 已结束
			default:	
				$limit 					= 20;
				$wbList['answerCnt'] 	= 0;
				$wbList['replyCnt'] 	= 0;
				$wbList['answerList']	= array();
				
				TPL::assign('wbList', $wbList);
				TPL::assign('limit', $limit);
				TPL::assign('list', array() );
				TPL::display('interview/closed', array(), 0, 'modules');
		}
	}
	
	
	/**
	 * 获取记录的状态, P:未开始, I:进行中, E:已结束
	 * @param bigint $startTime
	 * @param bigint $endTime
	 */
	function _getStatus($startTime, $endTime)
	{
		// 未开始
		if ( $startTime>APP_LOCAL_TIMESTAMP ) {
			return 'P';
		}
		
		// 已结束
		if ( $endTime<APP_LOCAL_TIMESTAMP ) {
			return 'E';
		}
		
		// 进行中
		return 'I';
	}
}
