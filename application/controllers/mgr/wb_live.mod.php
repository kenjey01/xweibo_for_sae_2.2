<?php
include('action.abs.php');
class wb_live_mod extends action {

	function wb_live_mod() {
		parent :: action();
	}

	/**
	 * 在线直播列表
	 */
	function default_action() {
		/// 如果没有设置在线直播基本信息，跳转到设置在线直播基本信息页
		$rs = DS('common/sysConfig.get', '', 'microLive_setting');
		if (empty($rs)) {
			APP::M('mgr/wb_live.set');
			exit;
		}

        $pager    	= APP::N('pager');
		$totalCnt 	= DR('microLive.getLiveCount');
		$offset 	= $pager->initParam($totalCnt);
		$list  		= DR('microLive.getList', FALSE, $offset, $pager->getParam('pageSize'));
		
		TPL::assign('pager', $pager->makePage());
		TPL::assign('list', $list);
		TPL::assign('offsetCnt', $offset+1);
		TPL::assign('currentPage', $pager->getParam('currentPage') );

		$this->_display('microlive/list');
	}

	/**
	 * 发起在线直播
	 */
	function create() {
		/// 在线直播基本主持人
		$master_list = array();

		$rs = V('-:sysConfig/microLive_setting'); 
		$rs = json_decode($rs, true);
		$master_list = DR('microLive.getLiveUsersBatchShow', '', $rs['master']);
		if (empty($master_list['errno'])) {
			$master_list = $master_list['rst'];
		}

		/// 默认banner,cover,backgroup图片路径
		if (WB_LANG_TYPE_CSS) {
			/// 多语言
			$default_banner_img = W_BASE_URL.'img/'.WB_LANG_TYPE_CSS.'/live_bg_960.png';	
			$default_cover_img 	= W_BASE_URL.'img/'.WB_LANG_TYPE_CSS.'/live_logo_120.jpg';
		} else {
			$default_banner_img = W_BASE_URL.'img/live_bg_960.png';	
			$default_cover_img 	= W_BASE_URL.'img/live_logo_120.jpg';
		}
		$default_backgroup_img 	= W_BASE_URL.'img/live_bg_main.jpg';

		TPL::assign('default_banner_img', $default_banner_img);
		TPL::assign('default_cover_img', $default_cover_img);
		TPL::assign('default_backgroup_img', $default_backgroup_img);
		TPL::assign('master_list', $master_list);
		$this->_display('microlive/live_form');
	}

	/**
	 * 编辑在线直播
	 */
	function modify() {
		$id = V('g:id');
		$live = DS('microLive.getLiveById','',$id);
		$master_uids = array();
		$guest_uids = array();
		$uids = array();
		/// 主持人
		$masters = $live['master'];
		if ($masters) {
			$master_uids = explode(',', $masters);
		}
		/// 嘉宾
		$guests = $live['guest']; 
		if ($guests) {
			$guest_uids = explode(',', $guests);
		}
		$uids = array_merge($master_uids, $guest_uids);
		$master_list = array();
		$guest_list = array();
		if ($uids) {
			$ulist = DR('microLive.getLiveUsersBatchShow', '', implode(',', $uids));
			if (empty($ulist['errno'])) {
				$ulist = $ulist['rst'];
				foreach ($ulist as $key => $var) {
					if (in_array($var['id'], $master_uids)) {
						$master_list[] = $var;
					}

					if (in_array($var['id'], $guest_uids)) {
						$guest_list[] = $var;
					}
				}
			}
		}

		TPL::assign('master_list', $master_list);
		TPL::assign('guest_list', $guest_list);
		TPL::assign('live', $live);
		$this->_display('microlive/live_form');
	}

	/**
	 * 删除指定的在线直播
	 */
	function delLive()
	{
		$id  = V('g:id');
		$url = URL('mgr/wb_live', array('page'=>V('g:page')) );

		if (empty($id)) {
			$this->_error('操作失败，请检查输入参数是否正确', $url);
		}
		$ret = DR('microLive.deleteLive', FALSE, $id);	
		if ($ret['rst']) {
			$this->_succ('操作已成功', $url);
		} 
		
		$this->_error('操作失败，请检查输入参数是否正确', $url);
	}

	/**
	 * 设置在线直播基本信息
	 */
	function set() {
		$rs = DS('common/sysConfig.get', '', 'microLive_setting');
		$rs = json_decode($rs, true);

		$userlist = array();
		$userlist = DR('microLive.getLiveUsersBatchShow', '', $rs['master']);
		if (empty($userlist['errno'])) {
			$userlist = $userlist['rst'];
		}
		/// 默认banner图路径
		if (WB_LANG_TYPE_CSS) {
			/// 多语言
			$default_banner_img = W_BASE_URL.'img/'.WB_LANG_TYPE_CSS.'/live_bg.jpg';	
		} else {
			$default_banner_img = W_BASE_URL.'img/live_bg.jpg';	
		}

		TPL::assign('userlist', $userlist);
		TPL::assign('live', $rs);
		TPL::assign('default_banner_img', $default_banner_img);
		$this->_display('microlive/live_infomation');
	}

	/**
	 * 预览新建在线直播
	 */
	function preview() {
		// 启动Xpipe
		$GLOBALS[V_GLOBAL_NAME]['NEED_XPIPE'] = TRUE;
		Xpipe::usePipe(TRUE);
		/// 启用多模板机制
		$GLOBALS[V_GLOBAL_NAME]['MIX_TPL'] = TRUE;

		// 获取指定访谈和访谈列表信息
		$liveInfo					= V('g');
		$liveInfo['start_time'] 	= strtotime($liveInfo['start_date'].' '.(int)V('g:start_h',0).':'.(int)V('g:start_m',0));
		$liveInfo['end_time'] 		= strtotime($liveInfo['end_date'].' '.(int)V('g:end_h',0).':'.(int)V('g:end_m',0));
		$liveInfo['state'] 		= $this->_getStatus($liveInfo['start_time'], $liveInfo['end_time']);
		
		// 主持人
		$liveInfo['master']		= implode(',', $liveInfo['master']);
		
		// 嘉宾
		$liveInfo['guest']			= implode(',', $liveInfo['guest']);
		
		/// 自定义颜色
		$liveInfo['custom_color'] = '';
		$liveInfo['backgroup_color'] = '';
		if (1 == $liveInfo['custom']) 
		{
			$bkcolor 					= $liveInfo['bkcolor'];
			$linkcolor 					= $liveInfo['linkcolor'];
			$liveInfo['custom_color'] 	= $bkcolor.','.$linkcolor;
		} else {
			$liveInfo['backgroup_color'] 	= $liveInfo['color'];
		}
		

		$live_id = isset($liveInfo['id']) ? $liveInfo['id'] : '';	
		/// 发布框参数配置
		$input_params = array('title' => '一起来聊聊：'.$liveInfo['trends'],
							'show_video' => false,
							'show_music' => false,
							'show_trends' => false,
							'trends' => $liveInfo['trends'],
							'ext_xwbAdditive' => array('doAction' => 'live', 'extra_params' => array('live_id' => $live_id))
						);

		/// 微博列表参数配置
		$weibo_params = array();
		TPL::assign('liveInfo', $liveInfo);
		TPL::assign('input_params', $input_params);

		//TPL::display('microlive/details', array(), 0, 'modules');
		TPL::display('microlive/details');
	}

	/**
	 * 保存更新在线直播
	 */
	function saveLive(){
		if(strtolower(V('s:REQUEST_METHOD'))=='post'){
			$id = trim(V('p:id',''));
			if($id){
				if(!is_numeric($id)){
					//非法数据
					$this->_error('编辑的在线直播id为空', URL('mgr/wb_live'));
				}
				$data = DR('microLive.getLiveById','',$id);
				$live = $data['rst'];
				//是否有权限编辑此在线直播
				if($live === false || sizeof($live) == 0){
					$this->_error('需要编辑的在线直播不存在', URL('mgr/wb_live'));
				}
				$id = $live['id'];
			}
			//检查数据
			$data = $this->_checkData($id);
			$result = DR('microLive.save','',$data,$id);
			$id = $result['rst'];


			if($result['rst']!==false){
				//跳转到在线直播列表
				$this->_succ('操作已成功', URL('mgr/wb_live'));
			}
		}
		$this->_error('操作失败！', URL('mgr/wb_live'));
	}

	/**
	 * 保存更新在线直播基本信息
	 */
	function saveLiveBase() {
		$desc = trim(V('p:desc', ''));
		$banner_img = trim(V('p:pic', W_BASE_HTTP.W_BASE_URL.'img/live_pic.jpg'));
		$master = V('p:master', '');
		$contact = trim(V('p:contact', ''));

		if (empty($desc) || empty($master) || empty($contact)) {
			$this->_error('请输入必填项', URL('mgr/wb_live'));
		}
		$master = implode(',', $master);

		$params['desc'] = $desc;
		$params['master'] = $master;
		$params['banner_img'] = $banner_img;
		$params['contact'] = $contact;
		$value = json_encode($params);

		$rst = DR('common/sysConfig.set', FALSE, 'microLive_setting', $value);
		if (empty($rst['errno'])) {
			$this->_succ('操作已成功', URL('mgr/wb_live'));
		} else {
			$this->_error('操作失败！', URL('mgr/wb_live'));
		}
	}

	/**
	 * 设置在线访谈的微博策略
	 */
	function setWbState()
	{
		$id  	= V('p:id');
		$state  = V('p:state');
		$state  = in_array($state, array('P', 'A') ) ? $state : 'P';
		$result = DR('microLive.setWbState', FALSE, $id, $state);
		
		if ($result['rst']) {
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
		$id = V('g:id', 0);
		$live = DS('microLive.getLiveById','',$id);
		if ( empty($live) ) 
		{
			$this->_error('找不到对应的在线访谈', URL('mgr/wb_live') );
		}
		
		/// 待审核表在线直播的微博信息
		$verify_list  = array();
		$wbList = array();
		$verify_list = DS('weiboVerify.getWeiboVerifyList', false, array('type' => 'live', 'extend_id' => $id));
		if ($verify_list) {
			foreach ($verify_list as $var) {
				$wbList[$var['id']]['text'] = $var['weibo'];
				$wbList[$var['id']]['id'] = $var['id'];
				$wbList[$var['id']]['pic']  = (isset($var['picid'])&&$var['picid']) ? '<img src="'. F('profile_image_url.thumbnail_pic', $var['picid']) . '" />' : '';
				$wbList[$var['id']]['v'] = 1;
			}
		}
		$verify_totalCnt = DS('weiboVerify.getWeiboVerifyCount', false, array('type' => 'live', 'extend_id' => $id));

		$list = DS('microLive.getMicroLiveWbs', '', $id, 2);
		$live_totalCnt = DS('microLive.getCount');
		$wb_list = $this->_buildWbList($list);

		$wb_list = array_merge($wb_list, $wbList);
		$totalCnt = (int)$live_totalCnt + (int)$verify_totalCnt;

		
		TPL::assign('totalCnt', $totalCnt);
		TPL::assign('list', $wb_list);
		TPL::assign('id', $id);
		TPL::assign('live', $live);
		$this->_display('microlive/approve');
	}

	/**
	 * ajax 获取待审核微博数
	 */
	function countWb()
	{
		$id = V('g:id', 0);
		$state	= 2;
		$live_total = DS('microLive.getWbCount', FALSE, $id, $state);
		$verify_total = DS('weiboVerify.getWeiboVerifyCount', false, array('type' => 'live', 'extend_id' => $id));
		$result = (int)$live_total + (int)$verify_total;
		
		if ($result || $result == 0 ) {
			APP::ajaxRst($result); 
		}
		
		// 失败处理
		APP::ajaxRst('false', '-1', '请检查输入参数是否正确');
	}

	/**
	 * 审核微博
	 */
	function approveWb()
	{
		$id = V('g:id');
		$wb_id = V('g:wb_id');
		$v = V('g:v', false);

		if (empty($id) || (empty($wb_id) && empty($v))) {
			// 在线访谈ID 为空
			$this->_error('操作失败，请检查输入参数是否正确', URL('mgr/wb_live') );
		}

		$url = URL('mgr/wb_live.approveWbList', array('id'=>$id) );

		if ($v) {
			$vid = V('g:vid');
			$ret = DR('weiboVerify.updateWeiboVerify', false, $vid);
		} else {
			$ret = DR('microLive.approveWB', '', $id, $wb_id);
		}

		if ($ret['rst']) {
			$this->_succ('操作已成功', $url);
		}

		$this->_error('审核操作失败，', $url);
	}

	/**
	 * 删除待审微博
	 */
	function delWb()
	{
		$id = V('g:id');
		$wb_id = V('g:wb_id');
		$v = V('g:v', false);

		if (empty($id) || (empty($wb_id) && empty($v))) {
			// 在线访谈ID 为空
			$this->_error('操作失败，请检查输入参数是否正确', URL('mgr/wb_live') );
		}

		$url = URL('mgr/wb_live.approveWbList', array('id'=>$id) );

		if ($v) {
			$vid = V('g:vid');
			$ret = DR('weiboVerify.updateWeiboVerify', false, $vid, 'delete');
		} else {
			$ret = DR('microLive.deleteLiveWb', '', $id, $wb_id);
		}
		if ($ret['rst']) {
			$this->_succ('操作已成功', $url);
		}

		$this->_error('操作失败，请检查输入参数是否正确', $url);
	}

	/**
	 * 上传图片
	 */
	function upload() {
		$thumb = V('p:thumb', true);
		$this->_upload_pic(array('upload_path' => 'live_pic', 'thumb' => $thumb));
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
		$trends 			= trim(V('p:trends', ''));
		$desc 				= trim(V('p:desc',''));
		$code 				= trim(V('p:code', ''));
		$banner_img 		= trim(V('p:banner_img',''));
		$cover_img 			= trim(V('p:cover_img', ''));
		$master 			= V('p:master');
		$guest 				= V('p:guest');
        $backgroup_img 		= trim(V('p:backgroup_img', ''));
        $backgroup_style 	= trim(V('p:backgroup_style', ''));
		$start_time 		= trim(V('p:start_date',''));
		$end_time 			= trim(V('p:end_date',''));
		$color 				= V('p:color', false);
		$notice_time 		= V('p:notice_time');
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

		if (count($master) > 0 && count($guest) > 0) {
			$intersect = array_intersect($master, $guest);
			if (!empty($intersect)) {
				$this->_error('主持人和嘉宾不能是同一人', URL('mgr/wb_live'));
			}
			$master = implode(',', $master);
			$guest = implode(',', $guest);
		} else {
			$master = false;
			$guest = false;
		}

		//判断必填项
		if(!$title || !$desc || !$banner_img || !$cover_img || !$master || !$guest || !$backgroup_img || !$start_time || !$end_time){
			$this->_error('请输入必填项', URL('mgr/wb_live'));
				//$this->_displayError('请输入必填项');
		}

		if( preg_match("/^\d{4}-\d{1,2}-\d{1,2}$/",$start_time) == 0 || preg_match("/^\d{4}-\d{1,2}-\d{1,2}$/",$end_time) == 0){
			$this->_error('时间格式不正确', URL('mgr/wb_live'));
		}
		$start_time = strtotime($start_time.' '.(int)V('p:start_h',0).':'.(int)V('p:start_m',0));
		$end_time = strtotime($end_time.' '.(int)V('p:end_h',0).':'.(int)V('p:end_m',0));
		//结束时间要大于开始时间
		if($end_time<$start_time){
			$this->_error('结束时间要大于开始时间', URL('mgr/wb_live'));
		}

		/// 提醒时间
		if (empty($notice_time)) {
			$this->_error('提醒时间不能为空或为零', URL('mgr/wb_live'));
		}

		if ($notice_time) {
			$notice_time = $start_time - $notice_time * 60;
		}

		if(!$id)
		{
			//发起在线直播数据
			$data = array('title'=>$title,
						  'trends' => $trends,
						  'desc'=>$desc,
						  'banner_img'=>$banner_img,
						  'cover_img'=>$cover_img,
						  'code' => $code,
						  'master' =>$master,
						  'guest' =>$guest,
						  'backgroup_img' => $backgroup_img,
						  'backgroup_style' => $backgroup_style,
						  'backgroup_color' => $backgroup_color,
						  'custom_color' => $custom_color,
						  'wb_state' => 'A',
						  'start_time'=>$start_time,
						  'end_time'=>$end_time,
						  'notice_time' => $notice_time,
						  'add_time'=> APP_LOCAL_TIMESTAMP
						);
		}else{
			//编辑在线直播数据
			$data = array('title'=>$title,
						  'trends' => $trends,
						  'desc'=>$desc,
						  'code' => $code,
						  'master' =>$master,
						  'guest' =>$guest,
						  'backgroup_style' => $backgroup_style,
						  'backgroup_color' => $backgroup_color,
						  'custom_color' => $custom_color,
						  'start_time'=>$start_time,
						  'notice_time' => $notice_time,
						  'end_time'=>$end_time,
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
		}
		return $data;
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
			$idList[] = $aRecord['wb_id'];
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
					DR('InterviewWb.deleteLiveWb', FALSE, $idTmp);
					continue;
				}

				$wbList[$idTmp]['text'] = $aWb['text'];
				$wbList[$idTmp]['id'] = $aWb['id'];
				$wbList[$idTmp]['pic']  = isset($aWb['thumbnail_pic']) ? "<img src='{$aWb['thumbnail_pic']}' />" : '';
			}
		}
		
		return $wbList;
	}

	/**
	 * 获取记录的状态, P:未开始, I:进行中, E:已结束
	 * @param int $startTime
	 * @param int $endTime
	 *
	 * @return string
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
