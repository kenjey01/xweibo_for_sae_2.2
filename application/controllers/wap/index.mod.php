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

class index_mod extends action
{
	var $uInfo;
	
	function index_mod()
	{
		parent::action();
		$this->_userFilter();
		$this->_setBackURL();
	}

	/**
	* 检查用户是否已被屏蔽过滤
	* 
	*/
	function _userFilter()
	{
		//调用微博个人资料接口
		$userinfo = DR('xweibo/xwb.getUserShow', 'p', USER::uid());
		$this->uInfo = $userinfo['rst'];
		//过滤过敏用户
		$userinfo = APP::F('user_filter', $this->uInfo, true);
		if (empty($userinfo)) {
			/// 提示不存在
			$this->_showErr(L('controller__index__userFilter__emptyTip'), URL('pub'));
		}
	}
	
	/**
	 * 首页
	 *
	 *
	 */
	function default_action()
	{
		/// 页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		$limit = V('-:userConfig/wap_page_wb', 10);
		
		/// 调用获取当前用户所关注用户的最新微博信息api
		$ur = DR('xweibo/xwb.getUnread');
		//print_r($ur);
		
		$result = DR('xweibo/xwb.getFriendsTimeline', CACHE_HOME_TIMELINE, $limit, $page, null, null, null);
		$list = $result['rst'];
		
		TPL::assign('list', $list);
		TPL::assign('page', $page);

		$this->_display('index');
	}


	/**
	 * @提到我的
	 *
	 *
	 */
	function _atme()
	{
		/// 页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		$limit = V('-:userConfig/wap_page_wb', 10);

		/// 调用获取@当前用户的微博列表api
		if ($page == 1) {
			/// 清零
			DR('xweibo/xwb.resetCount', '', 2);
		}
		$result = DR('xweibo/xwb.getMentions', CACHE_MENTIONS, $limit, $page);
		$list = $result['rst'];
		
		TPL::assign('list', $list);
		TPL::assign('page', $page);
		$this->_display('atme');
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
	function _comments()
	{
		/// 页码数
		$page = max(V('g:page'), 1);
		
		/// 设置每页显示微博数
		$limit = V('-:userConfig/wap_page_wb', 10);
		
		/// 获取当前用户发送及收到的评论列表
		if ($page == 1) {
			/// 清零
			DR('xweibo/xwb.resetCount', '', 1);
		}

		$result = DR('xweibo/xwb.getCommentsToMe', CACHE_COMMENT_TO_ME, $limit, $page);
		$list = $result['rst'];
		/// 过滤微博
		$list = F('weibo_filter', $list);

		TPL::assign('list', $list);
		TPL::assign('limit', $limit);
		TPL::assign('page', $page);
		
		$this->_display('comments');
	}


	/**
	 *  发出的评论
	 *
	 *
	 */
	function _commentsend()
	{
		//页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		$limit = V('-:userConfig/wap_page_wb', 10);

		/// 获取当前用户收到的评论列表
		$result = DR('xweibo/xwb.getCommentsByMe', '', $limit, $page);
		$list = $result['rst'];
		/// 过滤微博
		$list = F('weibo_filter', $list);

		TPL::assign('list', $list);
		TPL::assign('limit', $limit);
		TPL::assign('page', $page);
		
		$this->_display('commentsend');
	}


	/**
	 * 我的私信
	 *
	 *
	 */
	function _private_msg()
	{
		// 是否开启私信
		if ( !HAS_DIRECT_MESSAGES ) {
			$this->_showErr(L('controller__index__privateMsg__notFoundPage'), URL('index'));
		}
		
		/// 页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		$limit = 10;

		DR('xweibo/xwb.getUnread');
		if ($page == 1) {
			/// 清零
			DR('xweibo/xwb.resetCount', '', 3);
		}
		
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

		///获取当前用户的粉丝列表id
		//$fids = DR('xweibo/xwb.getFollowerIds', '', USER::uid(), null, null, -1, 5000);
		//$fids = $fids['rst'];
		
		TPL::assign('uInfo', $this->uInfo);
		TPL::assign('list', $list);
		//TPL::assign('fids', $fids['ids']);
		TPL::assign('limit', $limit);
		TPL::assign('page', $page);
		$this->_display('messages');
	}

	/**
	 * 我的通知
	 *
	 *
	 */
	function _notice()
	{
		/// 页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		$limit = 10;

		if ($page == 1) {
			/// 未读数清零
			F('sysnotice.resetCount');
		}
		
		/// 调用获取当前用户发送的最新私信列表 api
		$list = DR('notice.getNoticeList', '', USER::uid(), ($page - 1) * $limit, $limit);
		
		$count = DR('notice.getNoticeNum', '', USER::uid());
		$list['x_total'] = (int)$count['rst'];

		TPL::assign('uInfo', $this->uInfo);
		TPL::assign('list', $list);
		//TPL::assign('fids', $fids['ids']);
		TPL::assign('limit', $limit);
		TPL::assign('page', $page);
		$this->_display('notices');
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
		
		TPL::assign('list', $list);
		$this->_display('favs');
	}


	/**
	 * 我的关注列表
	 *
	 *
	 */
	function follow()
	{
		//页码数
		$page = max(V('g:page'), 1);
		//游标
		$cursor = V('g:cursor', -1);

		//设置每页显示用户数
		$limit = 10;

		//调用获取当前用户关注对象列表及最新一条微博信息api
		$list = DR('xweibo/xwb.getFriends', '', USER::uid(), null, null, $cursor, $limit);
		$list = $list['rst'];
		$list['x_total'] = $this->uInfo['friends_count'];
		/// 过滤关注列表
		$list['users'] = F('user_filter', $list['users']);
		
		TPL::assign('page', $page);
		TPL::assign('limit', $limit);
		TPL::assign('list', $list);
		
		$this->_display('follow');
	}


	/**
	 * 我的粉丝列表
	 *
	 *
	 */
	function fans()
	{
		//页码数
		$page = max(V('g:page'), 1);
		//游标
		$cursor = V('g:cursor', -1);

		//设置每页显示用户数
		$limit = 10;

		//调用获取当前用户粉丝列表及最新一条微博信息api
		DR('xweibo/xwb.getUnread');
		$list = DR('xweibo/xwb.getFollowers', CACHE_FANS, USER::uid(), null, null, $cursor, $limit);
		$list = $list['rst'];
		$list['x_total'] = $this->uInfo['followers_count'];
		/// 过滤粉丝列表
		$list['users'] = F('user_filter', $list['users']);
		if ($page == 1) {
			/// 清零
			DR('xweibo/xwb.resetCount', '', 4);
		}

		/// 获取当前用户的关注列表id
		$fids = DR('xweibo/xwb.getFriendIds', '', USER::uid(), null, null, -1, 5000);
		$fids = $fids['rst'];

		TPL::assign('list', $list);
		TPL::assign('fids', $fids['ids']);
		TPL::assign('limit', $limit);
		TPL::assign('page', $page);
		$this->_display('fans');
	}

	/**
	 * 我的微博列表
	 *
	 *
	 */
	function profile()
	{
		/// 页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		$limit = V('-:userConfig/wap_page_wb', 10);
		
		/// 调用获取当前用户所关注用户的最新微博信息api
		DR('xweibo/xwb.getUnread');
		$list = DR('xweibo/xwb.getUserTimeline', '', USER::uid(), null, null, null, null, $limit, $page);
		$list = $list['rst'];
		
		TPL::assign('list', $list);
		TPL::assign('page', $page);

		$this->_display('index');
	}
	
	/**
	* 私信、评论、提到我的
	* 
	*/
	function messages()
	{
		$type = V('g:type', 1);
		switch ((int)$type) {
			case 1:
				$this->_private_msg();  //我的私信
				break;
				
			case 2:
				$ctype = (int)V('g:ctype', 1);
				if ($ctype === 1) {
					$this->_comments();  //收到的评论
				} else {
					$this->_commentsend();  //发出的评论
				}
				break;
				
			case 3:
				$this->_atme();  //@提到我的
				break;
				
			case 4:
				$this->_notice();
				break;
		}
	}
	
	/**
	* 详细资料
	* 
	*/
	function info()
	{
		TPL::assign('uInfo', $this->uInfo);
		$this->_display('userinfo');
	}
	
	/**
	* 个人设置
	* 
	*/
	function setinfo()
	{
		TPL::assign('uInfo', $this->uInfo);
		$type = (int)V('g:type', 1);  //设置类型 1基本资料 2显示设置
		if ($type === 1) {
			if (!HAS_DIRECT_UPDATE_PROFILE) {
				$url = URL('index.setinfo', 'type=2');
				APP::redirect($url, 3);
			}
			$this->_display('setinfo');
		} else {
			$this->_display('setdisplay');
		}
	}
}
