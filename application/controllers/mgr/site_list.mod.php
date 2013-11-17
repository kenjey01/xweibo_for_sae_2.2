<?php

/**
 * Manager This Website' List In Sina Open Api
 */
include(P_ADMIN_MODULES . '/action.abs.php');


class site_list_mod extends action 
{
	const MAX_LIST_MEMBER = 450;
	
	
	/**
	 * Constuctor
	 */
	function site_list_mod() 
	{
		parent::action();
		DR('xweibo/xwb.setToken', FALSE, 2);	// Set The Site Tocken
	}

	
	/**
	 * List Site List
	 */
	function default_action() 
	{
		$rs   = DR('xweibo/xwb.getUserLists', FALSE, SYSTEM_SINA_UID);
		$list = isset($rs['rst']['lists']) ? $rs['rst']['lists'] : FALSE;
		
		TPL::assign('list', $list);
		$this->_display('siteList');
	}
	
	
	
	/**
	 * Add List Function
	 */
	function addList()
	{
		$name = V('p:name');
		$url  = URL('mgr/site_list.default_action');
		$json = V('g:json', false);		// 是否返回json
		if ($name)
		{
			$list = DR('components/officialWB.createNewList', FALSE, $name);
			if($list['errno']!=0){
				$this->_error($list['err'], $url,$json?1:null);
				//$this->_error('名字或描述不合法，请重新输入', $url,$json?1:null);
				return;
			}
			if(isset($list['rst']['id'])) {
				$this->_succ('操作成功', $url,$json?array('listid' =>$list['rst']['id']):null);
			}
			// reach the max
			if ($list['errno'] == 1) {
				$this->_error('操作失败, 已达上限', $url,$josn?2:null);
			}
			if ($list['errno'] == '1021201') {
				$this->_error('名字或描述不合法，请重新输入', $url,$json?1:null);
			}
		}
		
		// error happened
		$this->_error('操作失败，请检查一下参数是否正确',josn?2:null);
	}
	
	
	
	/**
	 * Breif Delete The List
	 */
	function delList()
	{
		$listId = V('g:listId');
		$isSucc	= FALSE;
		$url    = URL('mgr/site_list.default_action');
		if ($listId) 
		{
			$idAry = explode(',', $listId);
			foreach ($idAry as $aId) 
			{
				$rs = DR('xweibo/xwb.deleteUserListId', FALSE, SYSTEM_SINA_UID, $aId);
				if (isset($rs['rst']['id'])) {
					$isSucc = TRUE;
				}
			}
		}
		
		// show the result message
		if ($isSucc) {
			$this->_succ('操作成功',$url);
		}
		
		$this->_error('操作失败，请检查一下参数是否正确', $url);
	}
	
	
	
	/**
	 * Show The Member List
	 */
	function memberList()
	{
		$listId = V('g:listId');
		$cursor = V('g:cursor', 0);
		$rst = $rs = array();
		if ($listId)
		{
			$rs = DR('components/officialWB.getUsers', '', $listId, $cursor);
            if(isset($rs['rst']['users'])) 
            {
				foreach($rs['rst']['users'] as $aUser) 
				{
					if(isset($aUser['id'])) {
						$aUser['http_url'] = W_BASE_HTTP . URL('ta', 'id='.$aUser['id'], 'index.php');
						$rst[] = $aUser;
					}
                }
            }
		}

		// 分页信息
		
		$prev_cursor = isset($rs['rst']['previous_cursor']) ? $rs['rst']['previous_cursor'] : 0;
		$next_cursor = isset($rs['rst']['next_cursor']) 	? $rs['rst']['next_cursor'] 	: 0;
		$count 		 = DR('components/officialWB.getListUserCount', '', $listId);
		$total		 = isset($count['rst']['member_count']) ? $count['rst']['member_count'] : 0;
		$listName	 = isset($count['rst']['name']) 		? $count['rst']['name'] : '自定义微博列表';
		
		TPL::assign('userlist', $rst);
		TPL::assign('listId', $listId);
		TPL::assign('total', $total);
		TPL::assign('listName', $listName);
		TPL::assign('prev_cursor', $prev_cursor);
		TPL::assign('next_cursor', $next_cursor);
		$this->_display('auth_recommended_user');
	}
	
	
	
	/**
	 * Add Member To The List
	 */
	function addMember()
	{
		$listId 	= V('p:listId',0);		//分组id
		$nickname 	= V('p:nickname','');		//成员昵称
		$url		= URL('mgr/site_list.memberList', 'listId='.$listId);
		$json = V('g:json', false);		// 是否返回json
		if ($listId && $nickname)
		{
			// check the user in api
			$user_info = DR('xweibo/xwb.getUserShow', '', null, null, $nickname);
	        if(empty($user_info['rst'])) {
				$this->_error('该用户不存在！', $url,$json?1:null);
	        }
	        DD('mgr/userRecommendCom.getUserById');		// 删除缓存
        
			// check the list user count, the count max 20
			$count = DR('components/officialWB.getListUserCount', '', $listId);
			if (isset($count['rst']['member_count']) && self::MAX_LIST_MEMBER<=$count['rst']['member_count']) {
				$this->_error('添加用户失败，用户数已达上限', $url,$json?3:null);
			}
			
			// add user to the list
			$rs = DR('components/officialWB.addUser', '', $user_info['rst']['id'], $listId);
			if(!$rs['rst']) {
				$this->_error('操作失败！', $url,$json?5:null);
			}
			$this->_succ('操作已成功', $url,$json?array('uid' =>$user_info['rst']['id'], 'profile_img'=> F('profile_image_url',$user_info['rst']['id'], 'comment')):null);
		}
		$this->_error('类别或昵称不存在！', $url);
	}
	
	
	
	/**
	 * Delete The List Member
	 */
	function delMember()
	{
		// Check list id
		$listId = V('r:listId',0);	//类别id
		$json = V('g:json', false);		// 是否返回json

		if(empty($listId)) {
			$this->_error('参数错误！', URL('mgr/site_list.default_action'),$json?1:null);
		}
		
		// Delete the list user
		$url    = URL('mgr/site_list.memberList', 'listId='.$listId);
		$isSucc = FALSE;
		$uids 	= V('r:uids', '');	 //用户uid串
		if ($uids)
		{
			$uidList = explode(',', $uids);
			foreach ($uidList as $uid) 
			{
				$rs = DR('components/officialWB.delUser', '', $uid, $listId);
				if($rs['rst']) {
					$isSucc = TRUE;
				}
			}
		}
		
		// Show the result
		if ($isSucc) {
			 DD('mgr/userRecommendCom.getUserById');		// 删除缓存
			$this->_succ('操作已成功', $url,$json?true:null);
		}
		$this->_error('参数错误！', $url,$json?1:null);
	}
	
}
