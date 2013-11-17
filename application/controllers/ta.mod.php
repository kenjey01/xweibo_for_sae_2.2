<?php
/**
 * @file			ta.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-06-08
 * @Modified By:	heli/2010-11-15
 * @Brief			'ta的'控制器-Xweibo
 */

class ta_mod
{

	function ta_mod()
	{
		$id 	 = (string)V('g:id');
		if(F('user_action_check',array(3),$id)){
			TPL::module('error_delete', array('msg'=> L('controller__ta__haveBlocked')) );
			exit();
		}
	}
	
	
	/**
	 * ta的首页
	 */
	function default_action()
	{
		$id 	 = (string)V('g:id');
		$name 	 = (string)V('g:name');
        $uDomain = V('g:_udomain');
        
		
        if( USED_PERSON_DOMAIN && $uDomain && strlen($uDomain)>=6 )
        {
            $id 	= DR('mgr/userCom.getUidByDomain', FALSE, $uDomain);
            $name 	= '';
        }
        
		if ( empty($id) && empty($name) ) {  /// 提示不存在	
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__common__userNotExist')));
		}
		
        $userinfo = array();
		if ( USER::isUserLogin() ) 
		{
			// 如果是自己，跳转到首页
			if ( $id==USER::uid() || ($name && USER::v('screen_name')==$name) ) {
				$_GET['isRewriteFromTa'] = TRUE;
				APP::M('index.profile');
				exit;	
			}
			
			// 调用微博个人资料接口
			$userinfo = DR('xweibo/xwb.getUserShow', 'p', null, $id, $name);
			
		} else 
		{
			if ( empty($name) ) {
				DS('xweibo/xwb.setToken', '', 2);
				$oauth 	= true;
			} else {
				$id 	= null;
				$oauth 	= false;
			}
			$userinfo = DR('xweibo/xwb.getUserShow', '', $id, null, $name, $oauth);
		}
		
		$userinfo = F('user_filter', $userinfo['rst'], true);
		if (empty($userinfo)) {
			/// 提示不存在	
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__common__userNotExist')));
		} elseif (!empty($userinfo['filter_state'])) {
			/// 屏蔽用户
			TPL::module('error_delete', array('msg'=> L('controller__ta__haveBlocked')) );
			exit(-1);
		}
		
		//检查是否本站用户
		$userinfo['is_localsite_user'] = 1;
		$us_rst = DR('mgr/userCom.getByUid', FALSE, $userinfo['id']);
		if (empty($us_rst['rst'])) {
			$userinfo['is_localsite_user'] = 0;
		}
		
		$userinfo['needPrivacy'] = (!USER::isUserLogin()) || !$userinfo['is_localsite_user'];
		
		//页面代号
		APP::setData('page', 'ta', 'WBDATA');
		TPL::assign('uid', USER::uid() );
		TPL::assign('userinfo', $userinfo);
		TPL::display('ta_profile');
	}

	/**
	 * ta的关注列表
	 *
	 *
	 */
	function follow()
	{
		$id = V('g:id');
		$name = V('g:name');
		if (empty($id) && empty($name)) {
			//提示访问的页面不存在，跳转到首页
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__common__userNotExist')));
		}

		/// 如果是自己，跳转到首页
		if (($name && $name == USER::v('screen_name')) || $id == USER::uid()) {
			APP::redirect('index.follow', 2);
		}

		/// 调用微博个人资料接口
		$userinfo = DR('xweibo/xwb.getUserShow', '', $id, null, $name);
		//过滤过敏用户
		$userinfo = F('user_filter', $userinfo['rst'], true);
		if (empty($userinfo)) {
			/// 提示不存在	
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__common__userNotExist')));
		}
		/// 获取前9位优质粉丝信息
		$followers = DR('xweibo/xwb.getMagicFollowers', '', $userinfo['id'], 9);
		$followers = $followers['rst'];
		TPL::assign('uid', USER::uid());
		TPL::assign('userinfo', $userinfo);
		TPL::display('ta_follow');
	}


	/**
	 * ta的粉丝列表
	 *
	 *
	 */
	function fans()
	{
		$id = V('g:id');
		$name = V('g:name');
		if (empty($id) && empty($name)) {
			//提示访问的页面不存在，跳转到首页
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__common__userNotExist')));
		}
		
		/// 调用微博个人资料接口
		$userinfo = DR('xweibo/xwb.getUserShow', '', $id, '', $name);
		//过滤过敏用户
		$userinfo = F('user_filter', $userinfo['rst'], true);
		if (empty($userinfo)) {
			APP::tips(array('tpl' => 'e404', 'msg' => L('controller__common__userNotExist')));
		}

		/// 如果是自己，跳转到首页
		if (($name && $name == USER::v('srceen_name')) || $id == USER::uid()) {
			APP::redirect('index.fans', 2);
		}
		TPL::assign('uid', USER::uid());
		TPL::assign('userinfo', $userinfo);
		TPL::display('ta_fans');
	}

	function profile()
	{
		$this->default_action();
	}

}
