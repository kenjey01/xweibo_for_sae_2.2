<?php
class user_pls {
	/**
	 * 名人推荐
	 */
	function hotUser() {
		$toplist = DS('components/star.get', 300, array('show_num'=> 6));
		$fids = DR('xweibo/xwb.getFriendIds', '', USER::uid(), null, null, -1, 5000);
		$fids = $fids['rst']['ids'];
		TPL::module('user_hot', array('toplist'=>$toplist, 'fids' => $fids));
	}

	/**
	 * 我的粉丝列表
	 * @param $p array  xweibo/xwb.getUserShow接口返回的数组
	 */
	function fansList($userinfo) {
		/// 光标开始位置
		$start_pos = V('g:start_pos');
		/// 下一个光标开始位置
		$end_pos = V('g:end_pos');

		/// 页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		$limit = WB_API_LIMIT;
		$count = $limit;

		if (empty($end_pos) && empty($start_pos)) {
			$cursor = -1;
		} elseif (!empty($start_pos)) {
			$cursor = $start_pos;
		} elseif (!empty($end_pos)) {
			$cursor = $end_pos;
		}

		/// 调用获取ta的粉丝列表及最新一条微博信息api
		$list = DR('xweibo/xwb.getFollowers', '', $userinfo['id'], null, null, $cursor, $count);
		$list = $list['rst'];
		$list['x_total'] = $userinfo['followers_count'];
		/// 过滤粉丝列表
		$list['users'] = F('user_filter', $list['users']);
	
		/// 获取当前用户的关注列表id
		$fids = DR('xweibo/xwb.getFriendIds', null, USER::uid(), null, null, -1, 5000);
		$fids = $fids['rst']['ids'];

		$gender = (isset($userinfo['gender']) && $userinfo['gender'] == 'f') ? L('pls__users__fansList__women') : L('pls__users__fansList__men');
		$empty_text = $userinfo['id'] == USER::uid() ? L('pls__users__fansList__myEmptyNoticeTip', URL('search.recommend')) : L('pls__users__fansList__taEmptyNoticeTip', $gender, $gender);

		$param = array(
			'list' => $list,
			'fids' => $fids,
			'limit' => $limit,
			'userinfo' => $userinfo,
			'empty_text' => $empty_text
		);
		TPL::module('block_userlist', $param);
	}

	/**
	 * 我的关注列表
	 *@param $params[userinfo] array  xweibo/xwb.getUserShow接口返回的数组
	 *@param $params[from] 'follow'|'friend' 我|他的关注
	 */
	function followersList($params) {
		$userinfo = $params['userinfo'];
		$from = isset($params['from']) ? $params['from'] : 'follow';
		$id = V('g:id');
		/// 光标开始位置
		$start_pos = V('g:start_pos');
		/// 下一个光标开始位置
		$end_pos = V('g:end_pos');

		/// 页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		$limit = WB_API_LIMIT;
		$count = $limit;

		if (empty($end_pos) && empty($start_pos)) {
			$cursor = -1;
		} elseif (!empty($start_pos)) {
			$cursor = $start_pos;
		} elseif (!empty($end_pos)) {
			$cursor = $end_pos;
		}

		/// 调用获取当前用户关注对象列表及最新一条微博信息api
		$list = DR('xweibo/xwb.getFriends', '', $userinfo['id'], null, null, $cursor, $count);
		$list = $list['rst'];
		$list['x_total'] = $userinfo['friends_count'];
		/// 过滤关注列表
		$list['users'] = F('user_filter', $list['users']);
		// 我的
		if ($from == 'follow') {
			//echo 'xxxxxxx wo de';
			//获取当前用户的粉丝列表id
			$fids = DR('xweibo/xwb.getFollowerIds', '', USER::uid(), null, null, -1, 5000);
			$fids = $fids['rst']['ids'];
		} else {
			// 他的
			//echo 'xxxxxxxxxx ta de';
			$fids = DR('xweibo/xwb.getFriendIds', null, USER::uid(), null, null, -1, 5000);
			$fids = $fids['rst']['ids'];
		}
		
		//$gender = (isset($userinfo['gender']) && $userinfo['gender'] == 'f') ? '她' : '他';
		$empty_text = ($userinfo['id'] == USER::uid() ? L('pls__users__followersList__myEmptyNoticeTip') : L('pls__users__followersList__taEmptyNoticeTip', F('escape', $userinfo['screen_name'])));
		
		$param = array(
			'list' => $list,
			'fids' => $fids,
			'limit' => $limit,
			'userinfo' => $userinfo,
			'empty_text' => $empty_text
		);
		TPL::module('block_userlist', $param);
	}

	function userPreview() {
		TPL::module('user_preview');
	}

	function userHead($userinfo) {
		$fids = DR('xweibo/xwb.getFriendIds', 'p1', USER::uid(), null, null, -1, 5000);
		$fids = $fids['rst'];
		TPL::module('user_head', array('userinfo' => $userinfo, 'fids' => $fids));
	}

	/**
	 * 综合搜索时搜索到的用户列表
	 *
	 */
	function fameList($users) {
		TPL::module('mod_fame_list', array('users' => isset($users) && !empty($users)? $users : array()));
	}
	
	/**
	* 用户搜索预览列表页
	* 
	* @param mixed $users
	*/
	function userSearchPreview($users) {
		TPL::module('mod_search_user_preview', array('users' => isset($users) && !empty($users)? $users : array()));
	}

	/**
	 * 用户搜索,用户列表
	 */
	function userSearchList($users) {
		TPL::module('search_user_list', array('data' => isset($users) && !empty($users)? $users : array()));
		return array('type' => V('r:ut', 'nick'));
	}

	/**
	 * 个人设置,用户资料
	 */
	function userInfoEdit() {
		$uInfo = DR('xweibo/xwb.getUserShow', '', USER::uid());
		TPL::module('user_info_edit', array('U' => $uInfo['rst']));
	}

	/**
	 * 个人设置添加标签
	 */
	function userTagEdit() {
		$tagsuglist = DR('xweibo/xwb.getTagsSuggestions');
		$taglist = DR('xweibo/xwb.getTagsList', '', USER::uid());
		TPL::module('user_tag_edit' ,array('tagsuglist' => $tagsuglist['rst'], 'taglist' => $taglist['rst']));
	}


	/**
	 * 个人设置,标签设置>可能感兴趣的标签
	 */
	function userTagsSuggestions() {
		/// 我感兴趣的标签
		$tagsuglist = DR('xweibo/xwb.getTagsSuggestions');
		TPL::module('user_tags_suggestions', array('tagsuglist' => $tagsuglist['rst']));
	}
	
	/**
	 * 个人设置,用户标签设置>标签列表
	 */
	function userTagsList() {
		/// 我的标签
		$taglist = DR('xweibo/xwb.getTagsList', '', USER::uid());
		TPL::module('user_tags_list', array('taglist' => $taglist['rst']));
	}

	/**
	 * 个人设置个人头像设置
	 */
	function userHeaderEdit() {
		TPL::module('user_header_edit');
	}

	/**
	 * 个人设置:显示设置
	 */
	function displayEdit() {
		TPL::module('user_display_edit');
	}

	/**
	 * 个人设置黑名单设置
	 */
	function blacklist() {
		$blacklist = DR('xweibo/xwb.getBlocks');
		$blacklist = $blacklist['rst'];
		TPL::module('user_blacklist', array('blacklist' => $blacklist));
	}
	
	/**
	 * 个人设置提醒设置
	 */
	function noticeSetting() {
		$notice = DR('xweibo/xwb.getNotice');
		TPL::module('user_notice', array('notice' => $notice['rst']));
	}
	
	/**
	 * 个人设置帐号绑定设置
	 */
	function accountSetting() {
		TPL::module('user_account');
	}
	
	/**
	 * 渲染“名人堂”的块状信息
	 */
	function outputCelebUserBlock($data) {
		TPL::module('celeb/user_recommend_block', $data);
	}
	
	
	/**
	 * 个性域名设置
	 */
	function settingDomain() {
		TPL::module('user_domain');
		return array('domain'=>W_BASE_HTTP.W_BASE_URL);
	}

	function recommendUserWeight() {
		TPL::module('recommendUserWeight', array('guide'=> true, 'title'=> L('pls__users__recommendUserWeight__title')));
		return array('cls'=>'category_user');
	}
	
	function guide() {
		$groups = DR('plugins/loginGuide.get', '');
		
		/*
		$users = $uids = array();
		$cid = V('-:sysConfig/guide_auto_follow');
		$users = DS('components/categoryUser.get', 'g0/300', $cid);
		foreach ($users as $user) {
			$uids[] = $user['uid'];
		}
		$uids = array_unique($uids);
		if (count($uids)) {
			$uids = array_slice($uids, 0, 20);
			$users = DS('xweibo/xwb.getUsersBatchShow', 'g0/300', implode(',', $uids));
		}
		$users = F('user_filter', $users, false);
		
		$fids = DR('xweibo/xwb.getFriendIds', '', USER::uid(), null, null, -1, 5000);
		$fids = $fids['rst']['ids'];
		*/
		
		$category = array();
		if (!empty($groups)) {
			foreach ($groups as $g) {
				$category[$g['item_id']] = $g['item_name'];
			}
		}
		TPL::module('recommend_guide', array('category'=>$category));
	}

	/**
	* 可能感兴趣的人
	* 
	*/
	function interestUsers() {
		$rst = DS('xweibo/xwb.getUserSuggestions', '', 1, 12);
		$fids = DS('xweibo/xwb.getFriendIds', '', USER::uid(), null, null, -1, 5000);
		$fids = $fids['ids'];
		
		$users = array();
		if (is_array($rst)) {
			foreach ($rst as $item) {
				$users[] = $item['user'];
			}
		}
		TPL::module('user_hot', array('toplist' => $users, 'fids' => $fids, 'title' => L('pls__users__interestUsers__title')));
	}
	
	
	/**
	 * 用户私隐声明
	 * @param $params
	 */
	function privacyNotice($userinfo) {
		TPL::module('user_privacy_notice', array('userinfo'=>$userinfo));
	}
}
?>
