<?php
/**
 * @file			index.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-06-08
 * @Modified By:	heli/2010-11-15
 * @Brief			'我的'控制器-Xweibo
 */

class index_mod
{

	function index_mod()
	{
	}

	/**
	 * 首页
	 *
	 *
	 */
	function default_action()
	{
		//皮肤预览
		$preview=V('g:preview',FALSE);
		if($preview){
			define('SKIN_PREIVEW',$preview);
		}
		
		//过滤类型
		$filter_type = V('g:filter_type');

		/// 页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		$limit = V('-:userConfig/user_page_wb');
		$count = $limit;
		/// 调用获取当前用户所关注用户的最新微博信息api
		DR('xweibo/xwb.getUnread');
		$result = DR('xweibo/xwb.getFriendsTimeline', CACHE_HOME_TIMELINE, $count, $page, null, null, null, $filter_type);
		$list = $result['rst'];
		if ($page == 1 && empty($filter_type)) {
			if ($list) {
				CACHE::set(USER::uid().'_maxid', $list[0]['id']);
				//APP::setData('maxid', $list[0]['id'], 'WBDATA');
			}
		}

		/// 右侧模块数据
		//$modules = DS('PageModule.getPageModules', '', 2, 1);

		//TPL::assign('uid', USER::uid());
		TPL::assign('list', $list);
		TPL::assign('limit', $limit);
		//TPL::assign('page', $page);
		//TPL::assign('side_modules', isset($modules[2]) ? $modules[2]: array());
		TPL::assign('filter_type', $filter_type);
		TPL::display('index');
	}


	/**
	 * @提到我的
	 *
	 *
	 */
	function atme()
	{
		/// 页码数
		$page = max(V('g:page'), 1);
/*
		/// 设置每页显示微博数
		$limit = WB_API_LIMIT;
		$count = $limit;
*/
		DR('xweibo/xwb.getUnread');
		/// 调用获取@当前用户的微博列表api
		if ($page == 1) {
			/// 清零
			DR('xweibo/xwb.resetCount', '', 2);
		}
		//$result = DR('xweibo/xwb.getMentions', CACHE_MENTIONS, $count, $page);
		//$list = $result['rst'];

		/// 调用微博个人资料接口
		$userinfo = DR('xweibo/xwb.getUserShow', 'p', USER::uid());
		$userinfo = $userinfo['rst'];

		/// 右侧模块数据
		//$modules = DS('PageModule.getPageModules', '', 2, 1);

//		TPL::assign('list', $list);
//		TPL::assign('limit', $limit);
		TPL::assign('uid', USER::uid());
		TPL::assign('userinfo', $userinfo);
		//TPL::assign('side_modules', isset($modules[2]) ? $modules[2]: array());
		TPL::display('atme');
	}


	/**
	 *  收到的评论
	 *
	 *<?php if (empty($list)):?>
                            <!-- comments list empty tip -->
                            <div class="default-tips">
                                <div class="icon-tips all-bg"></div>
								<?php if (V('g:page', 1) > 1):?>
                                <p>已到最后一页</p>
								<?php else:?>
                                <p>暂时还没有收到任何评论</p>
								<?php endif;?>
                            </div>
                            <!-- end comments list empty tip -->
                        <?php else:?>
	 */
	function comments()
	{
		/// 页码数
		$page = max(V('g:page'), 1);
/*
		/// 设置每页显示微博数
		$limit = WB_API_LIMIT;//V('-:userConfig/user_page_comment');
		$count = $limit;
*/
		DR('xweibo/xwb.getUnread');
		/// 获取当前用户发送及收到的评论列表
		if ($page == 1) {
			/// 清零
			DR('xweibo/xwb.resetCount', '', 1);
		}
/*
		$result = DR('xweibo/xwb.getCommentsToMe', CACHE_COMMENT_TO_ME, $count, $page);
		$list = $result['rst'];
		/// 过滤微博
		$list = F('weibo_filter', $list);

		/// 右侧模块数据
		$modules = DS('PageModule.getPageModules', '', 2, 1);

		TPL::assign('list', $list);
		TPL::assign('limit', $limit);
*/
//		TPL::assign('uid', USER::uid());
//		TPL::assign('side_modules', isset($modules[2]) ? $modules[2]: array());
		TPL::display('comments');
	}


	/**
	 *  发出的评论
	 *
	 *
	 */
	function commentsend()
	{
/*
		//页码数
		$page = max(V('g:page'), 1);

		//设置每页显示微博数
		$limit = V('-:userConfig/user_page_comment');
		$count = $limit;

		/// 获取当前用户收到的评论列表
		$result = DR('xweibo/xwb.getCommentsByMe', '', $count, $page);
		$list = $result['rst'];
		/// 过滤微博
		$list = F('weibo_filter', $list);

		/// 右侧模块数据
		$modules = DS('PageModule.getPageModules', '', 2, 1);

		TPL::assign('list', $list);
		TPL::assign('limit', $limit);
		TPL::assign('uid', USER::uid());
		TPL::assign('side_modules', isset($modules[2]) ? $modules[2]: array());
*/
		TPL::display('commentsend');
	}


	/**
	 * 我的私信
	 *
	 *
	 */
	function messages()
	{
		// 是否开启私信
		if ( !HAS_DIRECT_MESSAGES ) {
			APP::tips( array('tpl'=>'e404', 'msg'=>L('controller__common__pageNotExist')) );
		}
		
		/// 页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		$limit = WB_API_LIMIT;

		DR('xweibo/xwb.getUnread');
		if ($page == 1) {
			/// 清零
			DR('xweibo/xwb.resetCount', '', 3);
		}
/*
		/// 调用获取当前用户收到的最新私信列表 api
		$result = DR('xweibo/xwb.getDirectMessages', CACHE_MESSAGES, $limit, $page);
		$re_list = $result['rst'];

		/// 调用获取当前用户发送的最新私信列表 api
		$result = DR('xweibo/xwb.getSentDirectMessages', '', $limit, $page);
		$send_list = $result['rst'];

		$re_list = empty($re_list) ? $re_list = array() : $re_list;
		$send_list = empty($send_list) ? $send_list = array() : $send_list;
		$list = array_merge($re_list, $send_list);
		if ($list) {
			$compare = create_function('$a, $b', 'return strcasecmp(strtotime($b["created_at"]), strtotime($a["created_at"]));');
			/// 根据时间排序
			usort($list, $compare);
		}
*/

		/// 右侧模块数据
		//$modules = DS('PageModule.getPageModules', '', 2, 1);

		//TPL::assign('list', $list);
		//TPL::assign('limit', $limit);
		//TPL::assign('uid', USER::uid());
		//TPL::assign('side_modules', isset($modules[2]) ? $modules[2]: array());
		TPL::display('messages');
	}


	/**
	 * 我的收藏
	 *
	 *
	 */
	function favorites()
	{
		/// 页码数
		$page = max(V('g:page'), 1);

		//$p = V('g:p');

		/// 调用获取当前用户的收藏列表api
		$result = DR('xweibo/xwb.getFavorites', '', $page);
		$list = $result['rst'];

		/// 右侧模块数据
		$modules = DS('PageModule.getPageModules', '', 2, 1);

		APP::setData('page', 'fav', 'WBDATA');

		TPL::assign('uid', USER::uid());
		TPL::assign('list', $list);
		TPL::assign('side_modules', isset($modules[2]) ? $modules[2]: array());
		TPL::display('favs');
	}


	/**
	 * 我的关注列表
	 *
	 *
	 */
	function follow()
	{
/*
		//光标开始位置
		$start_pos = V('g:start_pos');
		//下一个光标开始位置
		$end_pos = V('g:end_pos');

		//页码数
		$page = max(V('g:page'), 1);

		//设置每页显示微博数
		$limit = WB_API_LIMIT;
		$count = $limit;

		if (empty($end_pos) && empty($start_pos)) {
			$cursor = -1;
		} elseif (!empty($start_pos)) {
			$cursor = $start_pos;
		} elseif (!empty($end_pos)) {
			$cursor = $end_pos;
		}
*/
		//调用微博个人资料接口
		$userinfo = DR('xweibo/xwb.getUserShow', 'p', USER::uid());
		$userinfo = $userinfo['rst'];
		//过滤过敏用户
		$userinfo = APP::F('user_filter', $userinfo, true);
		if (empty($userinfo)) {
			/// 提示不存在
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__common__userNotExist')));
		}
/*
		//调用获取当前用户关注对象列表及最新一条微博信息api
		$list = DR('xweibo/xwb.getFriends', '', USER::uid(), null, null, $cursor, $count);
		$list = $list['rst'];
		$list['x_total'] = $userinfo['friends_count'];
		/// 过滤关注列表
		$list['users'] = F('user_filter', $list['users']);

		//获取当前用户的粉丝列表id
		$fids = DR('xweibo/xwb.getFollowerIds', '', USER::uid(), null, null, -1, 5000);

		$fids = $fids['rst'];

		/// 右侧模块数据
		//$modules = DS('PageModule.getPageModules', '', 2, 1);
*/
		//传递页面代号给JS
//		APP::setData('page', 'follow', 'WBDATA');

//		TPL::assign('list', $list);
		TPL::assign('userinfo', $userinfo);
//		TPL::assign('fids', $fids['ids']);
		TPL::assign('uid', USER::uid());
//		TPL::assign('limit', $limit);
		//TPL::assign('side_modules', isset($modules[2]) ? $modules[2]: array());
		TPL::assign('relationship', '1');
		TPL::display('follow');
	}


	/**
	 * 我的粉丝列表
	 *
	 *
	 */
	function fans()
	{
		//光标开始位置
		$start_pos = V('g:start_pos');
		//下一个光标开始位置
		$end_pos = V('g:end_pos');

		//页码数
		$page = max(V('g:page'), 1);

		//设置每页显示微博数
		$limit = WB_API_LIMIT;
		$count = $limit;

		if (empty($end_pos) && empty($start_pos)) {
			$cursor = -1;
		} elseif (!empty($start_pos)) {
			$cursor = $start_pos;
		} elseif (!empty($end_pos)) {
			$cursor = $end_pos;
		}

		$userinfo = DR('xweibo/xwb.getUserShow', 'p', USER::uid());
		/// 过滤用户
		$userinfo = F('user_filter', $userinfo['rst'], true);
		if (empty($userinfo)) {
			/// 提示不存在
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__common__userNotExist')));
		}

		//调用获取当前用户粉丝列表及最新一条微博信息api
		DR('xweibo/xwb.getUnread');
		$list = DR('xweibo/xwb.getFollowers', CACHE_FANS, USER::uid(), null, null, $cursor, $count);
		$list = $list['rst'];
		$list['x_total'] = $userinfo['followers_count'];
		/// 过滤粉丝列表
		$list['users'] = F('user_filter', $list['users']);
		if ($page == 1) {
			/// 清零
			DR('xweibo/xwb.resetCount', '', 4);
		}


		/// 获取当前用户的关注列表id
		$fids = DR('xweibo/xwb.getFriendIds', '', USER::uid(), null, null, -1, 5000);
		$fids = $fids['rst'];

		/// 右侧模块数据
		$modules = DS('PageModule.getPageModules', '', 2, 1);

		//传递页面代号给JS
		APP::setData('page', 'fans', 'WBDATA');

		TPL::assign('list', $list);
		TPL::assign('userinfo', $userinfo);
		TPL::assign('fids', $fids['ids']);
		TPL::assign('side_modules', isset($modules[2]) ? $modules[2]: array());
		TPL::assign('limit', $limit);
		TPL::assign('uid', USER::uid());
		TPL::assign('relationship', '1');
		TPL::display('fans');
	}


	/**
	 * 我的微博列表
	 *
	 *
	 */
	function profile()
	{
/*
		//过滤类型
		$filter_type = V('g:filter_type');

		/// 页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		$limit = V('-:userConfig/user_page_wb');
		$count = $limit;

		/// 调用获取用户发布的微博信息列表api
		$list = DR('xweibo/xwb.getUserTimeline', '', USER::uid(), null, null, null, null, $count, $page, $filter_type);
		$list = $list['rst'];
*/
		/// 调用微博个人资料接口
		$userinfo = DR('xweibo/xwb.getUserShow', 'p', USER::uid());
		$userinfo = $userinfo['rst'];
		/// 过滤过敏用户
		$userinfo = F('user_filter', $userinfo, true);
		if (empty($userinfo)) {
			/// 提示不存在
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__common__userNotExist')));
		} 

		$modules = DS('PageModule.getPageModules', '', 2, 1);

//		TPL::assign('list', $list);
		TPL::assign('uid', USER::uid());
//		TPL::assign('limit', $limit);
//		TPL::assign('filter_type', $filter_type);
		TPL::assign('side_modules', isset($modules[2]) ? $modules[2]: array());
		TPL::assign('userinfo', $userinfo);
		TPL::display('profile');
	}
	
	/**
	* 我的通知列表
	* 
	*/
	function notices()
	{
		$page = max(V('g:page'), 1);
		if ($page == 1) {
			/// 未读数清零
			F('sysnotice.resetCount');
		}
		
		TPL::display('notices');
	}
}
