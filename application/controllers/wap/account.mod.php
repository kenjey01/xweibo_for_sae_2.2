<?php
/**************************************************
*  Created:  2011-03-07
*
*  WAP账号控制器
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author guanghui <guanghui1@staff.sina.com.cn>
*
***************************************************/
include('action.basic.php');

class account_mod extends action
{
	var $accAdapter;
	const SINA_LOGIN_METHOD = 'auth';  //WAP登录方式, auth或Xauth
	
    function account_mod()
    {
        parent::action();
        $this->accAdapter = APP::ADP('account');
    }
    
    /**
    * 检查当前控制器是否WAP目录下的控制器
    * 如果不是，则自动跳转至WAP目录下的默认控制器
    * 
    */
    function checkCtrl()
    {
    	return true;
    }
    
    /**
    * 检查用户是否登录
    * 
    */
    function checkLogin()
    {
        if (USER::isUserLogin()) {
            return true;
        }
        
        //构造登录后自动返回的URL
        $query = array();
        $gArr = V('g');
        if (!empty($gArr)) {
            foreach ($gArr as $k => $v) {
                if ($k === R_GET_VAR_NAME) { continue; }
                $query[] = $k . '=' . urlencode($v);
            }
        }
        
        $router_str = APP::getRequestRoute(false);
        $callBackUrl = W_BASE_HTTP . URL($router_str, implode('&', $query));
        
        APP::redirect(URL('account.showLogin', 'back=' . urlencode($callBackUrl)), 3);
    }
    
    /**
    * 显示登录页
    * 
    */
    function showLogin()
    {
    	if (USER::isUserLogin()) {
			APP::redirect('index', 2);
    	}
    	
    	if (USER::get('site_uid')) {
			$this->_sinaLogin();
			exit;
    	}
    	
    	// 1 使用新浪帐号登录，2 使用附属站帐号登录 3 可同时使用两种帐号登录
    	//暂时屏蔽附属站帐号登录功能
		$login_way = V('-:sysConfig/login_way', 1)*1;
		$siteInfo = $this->accAdapter->getInfo();
		TPL :: assign('site_name', $siteInfo['site_name']);
		
    	switch ($login_way) {
			case 1:
				$this->_sinaLogin();
				break;
			case 2:
				$this->_siteLogin();
				break;
			case 3:
				$lt = (int)V('g:lt', 1);  //1 附属站账号登录 2 新浪账号登录
				if ($lt === 1) {
					$this->_siteLogin(3);
				} else {
					$this->_sinaLogin(3);
				}
				break;
    	}
    }
    
    /**
    * 账号绑定页面
    * 
    */
    function bind()
    {
    	if (self::SINA_LOGIN_METHOD === 'Xauth') {
			TPL :: assign('site_name', V('-:sysConfig/site_name'));
			$this->_display('account_bind');
    	} else {
			$this->_showErr(L('controller__account__bind__showErr'), URL('account.showLogin', 'lt=2'));
    	}
    }
    
    /**
    * auth授权后返回
    * 
    */
    function oauthCallback()
    {
		$oauth_verifier = V('r:oauth_verifier', '');
		//非法访问，或者 Oauth 返回错误
		if(empty($oauth_verifier)){
			//APP::tips(); TODO
			die('oauth_verifier error!');
		}
		
		$site_uid = USER::get('site_uid');
		$need_bind = empty($site_uid) ? false : true;
		
		$last_key = DS('xweibo/xwb.getAccessToken','',$oauth_verifier);
		$uInfo = $this->_setSinaLoginSession($last_key, null, $need_bind);
		
		$loadUrl = trim(V('g:loginCallBack', false));
		if ($loadUrl) {
			APP::redirect($backURL, 3);
	    } else {
			APP::redirect('index', 2);
	    }
    }
    
    /**
    * 新浪账号登录
    * 
    */
    function _sinaLogin($login_way = 1)
    {
    	$back = V('g:back', '');
    	if (self::SINA_LOGIN_METHOD === 'Xauth') {
    		TPL :: assign('backURL', $back);
    		TPL :: assign('login_way', $login_way);
	        $this->_display('sina_login');
    	} else {
    		$loginCallBack = !empty($back) ? '&loginCallBack=' . urlencode($back) : '';
    		$oauthCbUrl = W_BASE_HTTP . URL('account.oauthCallback', $callbackOpt) . $loginCallBack;
			$oauthUrl = DS('xweibo/xwb.getTokenAuthorizeURL', '', $oauthCbUrl);
			$oauthUrl .= '&xwb_&display=wap2.0&forcelogin=true';
			APP::redirect($oauthUrl, 3);
    	}
    }
    
    /**
    * 附属站点账号登录
    * 
    */
    function _siteLogin($login_way = 2)
    {
		$back = V('g:back', '');
    	TPL :: assign('backURL', $back);
    	TPL :: assign('login_way', $login_way);
        $this->_display('site_login');
    }
	/**
	  *   
	  */
	function allowedLogin(){
		if(F('user_action_check',array(2,3))){
			$this->_showErr(L('controller__account__allowedLogin__showErr'),URL('account.logout'));
			exit();
		}		
	}
    
    /**
    * 账号登录操作
    * 
    */
    function doLogin()
    {
        $account = trim(V('p:account'));
        $password = trim(V('p:password'));
        $backURL = trim(V('p:backURL', ''));
        $loginType = (int)V('p:loginType');  //登录类型 1附属站账号登录 2新浪微博账号登录

        $errBackURL = URL('account.showLogin', array('backURL' => $backURL, 'lt' => $loginType));
        if (empty($account) || empty($password)) {
			$this->_showErr(L('controller__account__doLogin__inputAccountPasswd'), $errBackURL);
        }
        
        if ($loginType === 1) {
			$site_uid = $this->accAdapter->wapLogin($account, $password);
			if (isset($site_uid['errno']) && !empty($site_uid['errno'])) {
				$this->_showErr($site_uid['err'], $errBackURL);
			} else {
				$site_uid = $site_uid['rst'];
			}
			
			if (empty($site_uid) || !is_numeric($site_uid)) {
				$this->_showErr(L('controller__account__doLogin__accountOrpasswdIsWrong'), $errBackURL);
			} else {
				USER::set('site_uid', $site_uid);
				$user = $this->_getBindInfo($site_uid, 'uid');
				
				if (!empty($user) && is_array($user) && !empty($user['access_token']) && !empty($user['token_secret']) ) {
				 	 $uInfo = $this->_setSinaLoginSession(array(
				 	   		'oauth_token'=> $user['access_token'],
				 	   		'oauth_token_secret'=> $user['token_secret']
				 	   ), $user);
				 	 
				 	 if ($uInfo === false) {
						 APP::redirect('account.bind');
				 	 }
				} else {
					APP::redirect('account.bind');
				}
			}
        } else {
			$authRst = DR('xweibo/xwb.getXauthAccessToken', '', $account, $password);
			if (!empty($authRst['errno'])) {
				$this->_showErr(L('controller__account__doLogin__accountOrpasswdIsWrong'), $errBackURL);
			}
			
			$authRst = $authRst['rst'];
            $need_bind = USER::get('site_uid') > 0 ? true : false;
            $uInfo = $this->_setSinaLoginSession($authRst, null, $need_bind);
        }
        
        if ($backURL) {
			APP::redirect($backURL, 3);
	    } else {
			APP::redirect('index', 2);
	    }
    }
    
    /**
    * 退出登录
    * 
    */
    function logout()
    {
        $this->_resetClientSess();
        USER::set('site_uid', '');
        APP::redirect('pub', 2);
    }
    
    /**
    * 绑定账号信息入库
    * 
    */
    function _bindAccount($uInfo, $token)
    {
		$sina_uid = $uInfo['id'];
		$inData = array();
    	$user = $this->_getBindInfo($uInfo['id'], 'sina_uid');
    	if (!empty($user) && is_array($user)  ) {
    		if (!empty($user['access_token']) && !empty($user['token_secret']) && !empty($user['uid']) ) {
    			$this->_resetClientSess();
    			$this->_showErr(L('controller__account__bindAccount__bindedTip', F('escape', $uInfo['screen_name'])), URL('account.showLogin'));  //重复绑定
			}
			USER::set('site_uid', $user['uid']);
		} else {
			$maxTime = APP_LOCAL_TIMESTAMP;
			USER::set('user_max_notice_time', $maxTime);
			
			$inData['first_login'] 	= APP_LOCAL_TIMESTAMP;
			$inData['max_notice_time'] = $maxTime;
			$sina_uid = '';
		}
		
		$inData['sina_uid']		= $uInfo['id'];
		$inData['nickname']		= $uInfo['screen_name'];
		$inData['uid']			= USER::get('site_uid');
		$inData['access_token']	= $token['oauth_token'];
		$inData['token_secret']	= $token['oauth_token_secret'];
		
		DR('mgr/userCom.insertUser', '', $inData, $sina_uid);
    }
    
    /// 获取绑定信息
	function _getBindInfo($v, $vField='sina_uid'){
		$com =  $vField == 'sina_uid' ? 'mgr/userCom.getByUid' : 'mgr/userCom.getBySiteUid';
		$result = DR($com, 'p', $v);
		$result = $result['rst'];
		
	    return $result; 
	}
    
    /// 设置会话信息
    function _setSinaLoginSession($token, $user = null, $need_bind = false)
    {
        USER::setOAuthKey($token, true);
        DS('xweibo/xwb.setToken');
        $uInfo = DR('xweibo/xwb.verifyCredentials');
        /// 用户取消之前的授权
        if ($uInfo['errno'] == '1040008') {
            /// 解除之前的绑定，重新bind
            $inData = array('access_token'=>'', 'token_secret'=>'', 'uid'=>0);
            DR('mgr/userCom.insertUser', '', $inData, $user['sina_uid']);
            return false;
        }
        
        $uInfo = $uInfo['rst'];
        USER::uid($uInfo['id']);
        USER::set('sina_uid',       $uInfo['id']);
        USER::set('screen_name',    $uInfo['screen_name']);
        USER::set('description',    $uInfo['description']);
        
        //设置已读的最大消息ID
		$user_info = DR('mgr/userCom.getByUid', 'p', $uInfo['id']);
		$maxNoticeTime = isset($user_info['rst']['max_notice_time']) ? (int)$user_info['rst']['max_notice_time'] : 0;
		USER::set('user_max_notice_time', $maxNoticeTime);
        
        //封禁检查
        $this->_chkIsForbidden($uInfo['id']);
        
        //绑定账号
        if ($need_bind) {
			$this->_bindAccount($uInfo, $token);
        }
        
        return $uInfo;
    }
    
    /// 检查　用户　是否被封禁
    function _chkIsForbidden($sina_uid)
    {
        $isLoginForbidden = false;
        $uInfo = DS('mgr/userCom.getUseBanById','',$sina_uid);
        //　在封禁表中找到记录,此用户被封禁
        if (!empty($uInfo) && is_array($uInfo) && isset($uInfo['sina_uid']) ){
            $isLoginForbidden = $uInfo['sina_uid'];
            //USER::set('isLoginForbidden', $isLoginForbidden);
        }
        
        if ($isLoginForbidden){
            $this->_resetClientSess();
            $this->_showErr(L('controller__account__chkIsForbidden__youNotAllowToLogin'), URL('pub'));
        }
    }
    
    /// 重置用户相关的SESSION
    function _resetClientSess()
    {
        USER::setOAuthKey(array(),    false);
        USER::setOAuthKey(array(),    true);
        USER::uid('');
        USER::set('sina_uid',        '');
        USER::set('screen_name',    '');
        USER::set('description',    '');
        USER::set('user_max_notice_time',	'');
    }
}
