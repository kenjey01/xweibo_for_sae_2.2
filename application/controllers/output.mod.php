<?php
/**
 * @file			output.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			guanghui <guanghui1@staff.sina.com.cn>
 * @Create Date:	2011-03-24
 * @Brief			内容输出控制器-Xweibo
 */

class output_mod
{
	function output_mod()
	{
		Xpipe::usePipe(false);
	}

	/**
	 * 内容输出
	 *
	 *
	 */
	function default_action()
	{
		/// 内容单元类型
		$type = V('g:type', 1);
		$this->_isShutdownOutput($type);
		
		// 取缓存
		$page_key = $this->_getCacheKey($type);
		if(ENABLE_CACHE && $page_key && ($pageContent=CACHE::get($page_key)) ) 
		{
		    echo $pageContent;
		    exit;
		}
		
		/// 内容单元的宽度
		$width = V('g:width');
		/// 内容单元的高度
		$height = V('g:height', 550);
		/// 是否显示标题
		$show_title = V('g:show_title', false);
		/// 是否显示边框
		$show_border =V('g:show_border', false);
		/// 是否显示logo
		$show_logo = V('g:show_logo', false);
		/// 皮肤
		$skin = V('g:skin', 1);
		if ($skin % 10 != 0) {
			$skin = '0'.$skin;
		}
		/// 自定义颜色
		$colors = V('g:colors', false);
		/// 内容单元名称
		$unit_name = V('g:unit_name', null);

		$target = V('g:target');
		if (empty($target)) {
			die('');
		}

		
		TPL::assign('width', $width);
		TPL::assign('height', $height);
		TPL::assign('show_logo', $show_logo);
		TPL::assign('show_title', $show_title);
		TPL::assign('show_border', $show_border);
		TPL::assign('skin', $skin);

		
		$errno 		 = false;
		$pageContent = FALSE;
		$cacheTime	 = V('-:tpl/cache_time/output_nologin');
		switch (intval($type)) 
		{
			/// 微博秀
			case 1:
				$unit_name = $unit_name ? urldecode($unit_name) : L('controller__outPut__weiboShow');	

				/// 调用微博个人资料接口
				$target   = urldecode($target);
				$dataTime = ENABLE_CACHE && USER::isUserLogin() ? 'g0/'.V('-:tpl/cache_time/output_type1_login') : FALSE;
				$userinfo = DR('xweibo/xwb.getUserShow', $dataTime, null, null, $target, false);
				if ($userinfo['errno']) {
					$errno = $userinfo['errno']; 
				}
				
				if (empty($errno)) {
					$userinfo = $userinfo['rst'];
					$list = DR('xweibo/xwb.getUserTimeline', $dataTime, null, null, $userinfo['screen_name'], null, null, null, null, null, false);
					$list = $list['rst'];
				} else {
					$list = null;
				}
				
				TPL::assign('fids', $this->_getFids());
				TPL::assign('errno', $errno);
				TPL::assign('unit_name', $unit_name);
				TPL::assign('userinfo', $userinfo);
				TPL::assign('list', $list);
				$pageContent = TPL::fetch('unit/t_show', array(), 0, 'modules');
			break;

			
			/// 推荐关注
			case 2:
				$unit_name 	= $unit_name ? urldecode($unit_name) : L('controller__outPut__recFollower');
				$dataTime 	= ENABLE_CACHE && USER::isUserLogin() ? 'g0/'.V('-:tpl/cache_time/output_type2_login') : FALSE;	
				$rst 		= $this->_getUserGroup(intval($target), $dataTime);

				TPL::assign('unit_name', $unit_name);
				TPL::assign('userlist', $rst);
				TPL::assign('fids', $this->_getFids());
				$pageContent = TPL::fetch('unit/t_follow', array(), 0, 'modules');
			break;
				
			
			/// 互动话题
			case 3:
				$show_publish 	= (int)V('g:show_publish', 0);
				$auto_scroll 	= (int)V('g:auto_scroll', 0);
				$unit_name 		= $unit_name ? urldecode($unit_name) : L('controller__outPut__followTopic');	
				$list	 		= DR('xweibo/xwb.searchStatuse', null, array('q'=>$target, 'count'=>20, 'page'=>1), false);
				if ($list['errno']) {
					$errno = $list['errno'];
				}
				$list = $list['rst'];

				TPL::assign('errno', $errno);
				TPL::assign('unit_name', $unit_name);
				TPL::assign('show_publish', $show_publish);
				TPL::assign('auto_scroll', $auto_scroll);
				TPL::assign('topic', $target);
				TPL::assign('list', $list);
				$cacheTime = V('-:tpl/cache_time/output_type3_login');
				$pageContent = TPL::fetch('unit/t_topic', array(), 0, 'modules');
			break;
				
			
			/// 一键关注 
			case 4:
				$unit_name 	= $unit_name ? urldecode($unit_name) : L('controller__outPut__keyFollow');	
				$rst 		= $this->_getUserGroup(intval($target));
				$ids		= array();
				foreach($rst as $row)
				{
					$ids[] = $row['uid'];
				}
				
				//如果未登录，使用内置的token访问
				if (!USER::uid()) {
					DS('xweibo/xwb.setToken', '', 2);
				}
				$batch_info = DR('xweibo/xwb.getUsersBatchShow', 'g0/100', implode(',', $ids));
				//这个缓存值是否需要修改，因为这个调用比较长时间，而用户对描述信息的延时性要求不高
				//var_dump($batch_info);
				$i=0;
				if(!empty($batch_info)&&isset($batch_info['rst'])&&is_array($batch_info['rst'])){
					
					foreach($batch_info['rst'] as $row){
						$rst[$i++]['description']=$row['description'];
					}	
				}
				
				TPL::assign('unit_name', $unit_name);
				TPL :: assign('userlist', $rst);
				//var_dump(USER::isUserLogin());
				if(USER::isUserLogin()) {
					$fids = DR('xweibo/xwb.getFriendIds', 'p', USER::uid(), null, null, -1, 5000);
					$fids = $fids['rst']['ids'];
				}
				else {
					$fids=array();
				}
				TPL::assign('fids',$fids);
				$pageContent = TPL::fetch('unit/t_oneclick_follow', array(), 0, 'modules');
			break;
			
			
			/// 群组微博
			case 5:
				$unit_name 	= $unit_name ? urldecode($unit_name) : L('controller__outPut__qunWeibo');
				$title 		= urldecode(trim(V('g:title', '')));
				$user_id 	= array();
				$user_rst 	= $this->_getUserGroup(intval($target));
				foreach ($user_rst as $user) {
					$user_id[] = $user['uid'];
				}
				
				$wb_rst 		= array();
				$chunk_uid 		= array_chunk($user_id, 20);
				$chunk_count 	= count($chunk_uid);
				foreach ($chunk_uid as $k => $uid) {
					$rs = DR('xweibo/xwb.getBatchTimeline', '', array('user_id' => implode(',', $uid)), false);
					if ($rs['errno']) {
						$errno = empty($wb_rst) ? $rs['errno'] : 0;
					} else {
						$wb_rst = array_merge($wb_rst, $rs['rst']);
					}
					
					if ($k < ($chunk_count - 1)) {
						sleep(1);
					}
				}
				
				
				//微博按时间排序
				if ($wb_rst && $chunk_count > 0) {
					$compare = create_function('$a, $b', 'return strcasecmp(strtotime($b["created_at"]), strtotime($a["created_at"]));');
					usort($wb_rst, $compare);
				}
				
				$errno = (isset($errno) && !empty($errno) && empty($wb_rst)) ? $errno : 0;
				TPL::assign('errno', $errno);
				TPL::assign('unit_name', $unit_name);
				TPL::assign('title', $title);
				TPL::assign('user_list', $user_rst);
				TPL::assign('weibo_list', $wb_rst);
				$pageContent = TPL::fetch('unit/t_weibo', array(), 0, 'modules');
			break;
		}
		
		
		// 设置缓存
		if (ENABLE_CACHE && $page_key && $pageContent) {
			CACHE::set($page_key, $pageContent, $cacheTime);
		}
		
		echo $pageContent;
		exit;
	}
	
	
	function _getCacheKey($type)
	{
		$isLogin = USER::isUserLogin();
		if ( !$isLogin || in_array($type, array(3, 4, 5)) ) 
		{
			return "weiboshow#isLogin=$isLogin#".md5( serialize(V('g')) );
		}
		
		return false;
	}
	
	
	/**
	 * 可动态关闭不同的内容输出，主要用于定制项目的故障恢复
	 */
	function _isShutdownOutput($type)
	{
		$cfg = WEIBO_SHOW_CACHE_SWITCH;
		if ($cfg === true) {return null;}
		
		$type = min($type - 1, 0);
		if (empty($cfg) || empty($cfg[$type])){
			echo '微博内容输出组件升级维护中...';exit;
		}
		return null;
	}
	
	
	function _getUserGroup($group_id, $cacheTime=FALSE)
	{
		$rst = array();
		if( $group_id ) 
		{
			//获取其他数据
			$rs  = DR('mgr/userRecommendCom.getById', $cacheTime, $group_id);
			$rss = DR('mgr/userRecommendCom.getUserById', $cacheTime, $group_id);
			if($rss['rst']) 
			{
				foreach($rss['rst'] as $value) 
				{
					$value['http_url'] = W_BASE_HTTP.URL('ta', 'id='.$value['uid'], 'index.php');
					$rst[] = $value;
				}
			}
		} 
		else 
		{
			$rs  = DR('mgr/userRecommendCom.getById');
			$rst = $rs['rst'];
		}
		
		return $rst;
	}
	
	
	function _getFids()
	{
		return USER::isUserLogin() ? F('get_user_friend_ids') : array();
	}
}
?>
