<?php
/**
 * @file			account.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			xionghui <xionghui1@staff.sina.com.cn>
 * @Create Date:	2010-06-08
 * @Modified By:	xionghui/2010-11-15
 * @Brief			帐号相关操作
 */

class account_mod {
	var $accAdapter ;
	function account_mod(){
		/// 根据配置获取帐号适配器
		$this->accAdapter = APP::ADP('account');
	}

	function rst(){
		echo $this->accAdapter->syncLogout(0);
	}
		
	/// 绑定引导页
	function bind(){
		TPL::display('bind_account', array(), 0, 'modules');
	}
	
	/// 退出登录
	function logout($eUrl=false){
		if(APP::F('is_robot')){
			APP::deny();
		}
		
		/// 上报
		F('report', 'logout', 'http');
		setcookie('site_login_report', 0);

		$site_uid = USER::get('site_uid');

		/// 清空SESSION 
		USER::uid(0);
		USER::resetInfo();
		
		/// 退出地址
		if($eUrl){
			$exitUrl = $eUrl;
		}else{
			$loginCallBack = strval(V('g:loginCallBack', ''));
			$exitUrl = $loginCallBack ? $loginCallBack : URL('pub');
		}
		$login_way = V('-:sysConfig/login_way', 1)*1; 
		if ($login_way==1){
			APP::redirect($exitUrl,4);
		}else{
			//　发送退出通知到其它应用
			$syncLogoutScript = $this->accAdapter->syncLogout($site_uid);
			//var_dump( F('escape', $syncLogoutScript));exit;
			if ($syncLogoutScript){
				echo  $syncLogoutScript,"\n";
			}
			APP::redirect($exitUrl,4);
		}
	}
	
	/// 显示登录 页面
	function login(){
		if(APP::F('is_robot')){
			APP::deny();
		}
		
		if (USER::isUserLogin()){
			APP::redirect(URL('pub'), 3);exit;
		}
		// 1 使用新浪帐号登录，2 使用附属站帐号登录 3 可同时使用两种帐号登录
		$login_way = V('-:sysConfig/login_way', 1)*1;
		$use_sina_login = ($login_way == 1 || $login_way == 3);
		$use_site_login = ($login_way == 2 || $login_way == 3);
		
		// 如果可使用附属站登录，则获取相关信息
		if ($use_site_login){
			   $site_info = $this->accAdapter->getInfo();
			   TPL::assign('site_info', $site_info); 
		}
		
		TPL::assign('login_way', $login_way);
		TPL::assign('use_sina_login', $use_sina_login);   
		TPL::assign('use_site_login', $use_site_login);  

		$loginCallBack = V('g:loginCallBack', '');
		$sina_callback_url = $loginCallBack ? URL('account.sinaLogin','cb=login&type=sina&loginCallBack='. urlencode($loginCallBack)) : URL('account.sinaLogin','cb=login&type=sina'); 
		$site_callback_url = $loginCallBack ? URL('account.siteLogin','cb=login&type=site&loginCallBack='. urlencode($loginCallBack)) : URL('account.siteLogin','cb=login&type=site'); 
		TPL::assign('site_callback_url', $site_callback_url);
		TPL::assign('sina_callback_url', $sina_callback_url);
		
		$loginTpl = V('-:sysConfig/sysLoginModel') ? 'login' : 'login_pub';
		TPL::display($loginTpl, array(), 0, 'modules');
	}
	
	/// 初始化附属站信息,并根据附属站同步登录信息
	function initSiteInfo(){
		$isInit = USER::get('initSiteInfo');
		if ($isInit) {
			//return true;
		}
		
		//----------------------
		// 防止出现　SINA_UID　为非　０ , token 为空 的中断异常情况
		$token		= USER::getOAuthKey(true);
		$sina_uid	= USER::uid() ;
		if ($sina_uid && empty($token)){
			USER::uid(0);
			USER::resetInfo();
		}
		//----------------------
		
		$login_way = V('-:sysConfig/login_way', 1)*1; 
		$site_uid	= USER::get('site_uid');
		$site_uname = 'Guest';
		$site_name	= 'NoneSite';
		$site_login_report = 0;
		if ($login_way == 2 || $login_way == 3) {
			$sUser = $this->accAdapter->getInfo();
			if (is_array($sUser)){
				$GLOBALS[V_CFG_GLOBAL_NAME]['siteInfo'] = $sUser;
				$site_uid	= $sUser['site_uid'];
				$site_uname = $sUser['site_uname'];
				$site_name	= $sUser['site_name']; 
			}
			
			//　从  附属站　同步到  Xweibo  
			if (!empty($site_uid) && !USER::isUserLogin()){
				$site_login_report = 1;
				$user = $this->getBindInfo($site_uid, 'uid');
				if (!empty($user) && is_array($user) && !empty($user['access_token']) && !empty($user['token_secret']) ){
					$this->_setSinaLoginSession(array(
				 	   		'oauth_token'=> $user['access_token'],
				 	   		'oauth_token_secret'=> $user['token_secret']
				 	   ), $user);
				}
			}
			
			//　从 Xweibo　同步到附属站
			if ($sina_uid && empty($site_uid)) {
			    $user = $this->getBindInfo($sina_uid, 'sina_uid');	
				 //var_dump($user);exit;
				 if (!empty($user) && is_array($user) ){
				 	  $site_uid = $user['uid'];
				 }
			}
			
		}
		USER::set('initSiteInfo',	'1');
		USER::set('site_uid',	$site_uid);
		USER::set('site_uname', $site_uname);
		USER::set('site_name',	$site_name);
		
		if(isset($site_login_report) && 1 == $site_login_report && (!isset($_COOKIE['site_login_report']) || ($_COOKIE['site_login_report'] != 1))){
			F('report', 'site_login', 'http');
			setcookie('site_login_report', 1);
		}
		
	}
	
	/// 检查状态状态，全局使用, 是一个 preDoAction
	function gloCheckLogin(){
		$uid = USER::uid();
		//var_dump($uid);exit;
		$login_way = V('-:sysConfig/login_way', 1)*1; 
		// 未登录
		if (!$uid){
			if (USER::get('site_uid') && 1!=$login_way){
				$this->bind();exit;
			}else{
				$this->_goLogin();exit;
			}
		}else{
			return true;
		}
	}
	
	///
	function allowedLogin(){
		if(F('user_action_check',array(2,3))){
			//APP::tips(array('tpl' => 'e403', 'msg' => '对不起，您已经被禁止登录了'));
			//$this->logout();
			TPL::module('error_inhibit');
			exit();
		}
	}
	
	/// 默认动作
	function default_action(){
		$this->_goLogin();
	}
	/// 自动跳转 
	function _goLogin(){
		if(APP::F('is_robot')){
			APP::deny();
		}
		
		$loginCallBack = APP::getRequestRoute();
		//$querystring = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
		$q = V('g',array());
		if ( isset($q[R_GET_VAR_NAME]) ){ unset($q[R_GET_VAR_NAME]); }
		$querystring = $q ? http_build_query($q) : '';
		// 1 使用新浪帐号登录，2 使用附属站帐号登录 3 可同时使用两种帐号登录
		$login_way = V('-:sysConfig/login_way', 1)*1;
		switch ($login_way) {
			case 2 :
				$call_back_url = $loginCallBack ? $loginCallBack : 'pub';
				$goUrl = $this->accAdapter->goLogin(W_BASE_HTTP.URL($call_back_url, $querystring));
				break;
			case 1 :
			case 3 :
			default:
				$goUrl = URL('account.login','loginCallBack='.urlencode(URL($loginCallBack, $querystring)));
				break;
		}
		APP::redirect($goUrl, 4);
	}

	// 得到URL
	function getTokenAuthorizeURL($cb, $isPop, $active=null, $loginCallBack = '') {
		$callbackOpt = $cb ? 'cb='.$cb : 'cb=login';
		
		if($cb == 'bind'){
			if(!USER::get('site_uid')){
				die('site user id not found!');
			}
		} else {
			//2 使用附属站帐号登录时，禁止新浪帐号登录
			$login_way = intval(V('-:sysConfig/login_way', 1));
			if(2 == $login_way){
				die('SINA LOGIN FAILURE!');
			}
		}

		if ($isPop) {
			$callbackOpt .= '&popup=1';
		}
		if ($active ) {
			$callbackOpt .= '&active=1';
		}
		///　登录后的跳转URL
		$loginCallBack = strval($loginCallBack);
		if (!empty($loginCallBack)) {
			$callbackOpt .= '&loginCallBack='.urlencode($loginCallBack);
		}
		
		$oauthCbUrl = W_BASE_HTTP.URL('account.oauthCallback', $callbackOpt);
		
		$oauthUrl	 = DS('xweibo/xwb.getTokenAuthorizeURL', '', $oauthCbUrl);
		//&from=xweibo 取消特制的XWEIBO授权页面
		//$oauthUrl	.= '&forcelogin=true&xwb_'.$callbackOpt;
		$oauthUrl	.= '&xwb_'.$callbackOpt;
		return $oauthUrl;
	}

	/// 用SINA帐号进行登录,根据 V('g:cb'); 决定授权后 的动作
	function sinaLogin(){
		if(APP::F('is_robot')){
			APP::deny();
		}
		////如果仅是站点登录，让其转向到主登录页面
		//if(V('-:sysConfig/login_way',1) == 2){
		//	APP::redirect('account.login', 2);
		//	exit(-1);
		//}

		$cb = V('g:cb', 'login');
		$active = V('g:active');
		$isPop = V('g:popup');
		$loginCallBack = V('g:loginCallBack', '');

		$oauthUrl = $this->getTokenAuthorizeURL($cb, $isPop, $active, $loginCallBack);
		APP::redirect($oauthUrl, 3);
	}
	
	/// 使用 附属网站登录
	function siteLogin(){
		  $goUrl = $this->accAdapter->goLogin(W_BASE_HTTP.URL('pub'));
		  $this->logout($goUrl);
	}
	
	/// 检查是否第一次登录
	function _initFirstLoginUser($uInfo){
		 $sina_uid = $uInfo['id'];
		 $user = $this->getBindInfo($sina_uid, 'sina_uid');
		 if (!is_array($user)){
		 	die('DB ERROR...');
		 }
		 
		 
		 //第一次登录，用户信息入库 将引导用户关注
		 if (empty($user) || !isset($user['sina_uid']))
		 {
		 	$maxTime = APP_LOCAL_TIMESTAMP;
			USER::set('user_max_notice_time', $maxTime);
			
            $inData = array();
            $inData['first_login']		= APP_LOCAL_TIMESTAMP;
			$inData['sina_uid']			= $uInfo['id'];
			$inData['nickname']			= $uInfo['screen_name'];
			$inData['max_notice_time'] 	= $maxTime;
			$inData['followers_count'] 	= $uInfo['followers_count'];
			$token 						= USER::getOAuthKey(TRUE);
			$inData['access_token']		= $token['oauth_token'];
			$inData['token_secret']		= $token['oauth_token_secret'];
			
			// 本地关系,初始化用户首页List
			if ( XWB_PARENT_RELATIONSHIP ) 
			{
				DS('xweibo/xwb.initUserIndexList', FALSE, $inData['sina_uid']);
			}
			
			$r = DR('mgr/userCom.insertUser', '', $inData);  
			return true;
		 }
		 else
		 {
		 	 //var_dump($user);exit;
		 	 USER::set('site_uid', $user['uid']);
		 	 
		 	 $inData 					= array();
		 	 $inData['followers_count'] = $uInfo['followers_count'];
		 	 $inData['nickname']		= $uInfo['screen_name'];
 	 		 $token 					= USER::getOAuthKey(TRUE);
			 $inData['access_token']	= $token['oauth_token'];
			 $inData['token_secret']	= $token['oauth_token_secret'];
		 	 
			DR('mgr/userCom.insertUser', FALSE, $inData, $sina_uid);
		 }
		 
		 return false;
	}
	
	/// 从 Oauth 登录回来后 分别对各需求进行处理
	function oauthCallback(){
		$oauth_verifier = V('r:oauth_verifier','');
		//非法访问，或者 Oauth 返回错误
		if(empty($oauth_verifier)){
			//APP::tips(); TODO
			die('oauth_verifier error!');
		}

		$site_uid = USER::get('site_uid');
		$callbackOpt = V('g:cb', 'login');
		
		$last_key = DS('xweibo/xwb.getAccessToken','',$oauth_verifier);
	   	$uInfo = $this->_setSinaLoginSession($last_key);
		


		//--------------------------------------------------------
		switch ($callbackOpt) {
			// 安装时的用户身份获取
			case 'install'	: 
				break;
				
			// 绑定时的用户身份获取
			case 'bind'		: 
				//print_r($uInfo);
				// 将绑定的信息入库
				$inData = array();
				$inData['sina_uid']		= $uInfo['id'];
				$inData['nickname']		= $uInfo['screen_name'];
				$inData['uid']			= $site_uid;
				$inData['access_token']	= $last_key['oauth_token'];
				$inData['token_secret']	= $last_key['oauth_token_secret'];
				
				$user = $this->getBindInfo($uInfo['id'], 'sina_uid'); 
				if (!empty($user) && is_array($user)  ){
					if (empty($user['access_token']) || empty($user['token_secret']) || empty($user['uid']) ){
					   $r = DR('mgr/userCom.insertUser', '', $inData, $uInfo['id']);

					   ///同步插件的绑定数据
					   $this->_xwbBBSplugin($inData);

					}else{
						//重复绑定
						$this->isBinded($uInfo['screen_name']);
					}
				}else{
					$inData['first_login'] 	= APP_LOCAL_TIMESTAMP; 
					$r = DR('mgr/userCom.insertUser', '', $inData);

					///如果开启插件通信
					$this->_xwbBBSplugin($inData);
				}
				F('report', 'bind', 'http');
				F('report', 'site_login', 'http');
				//登录回调
				$loadUrl = V('g:loginCallBack', false);
				//if (!$loadUrl) {

					//检查是否第一次登录并引导用户
					$isFirst = $this->_initFirstLoginUser($uInfo);
					if ($isFirst) {
						$firstPlugin = DS('Plugins.get', 'g1/86400', 4);

						if ($firstPlugin['in_use'])
							$loadUrl = URL('welcome');
					}
				//}
				$this->_onlogin($loadUrl);
				break;
			
			// 登录时的用户身份获取
			case 'login'	: 
				/// 上报
				F('report', 'sina_login', 'http');
				if (USER::uid() === SYSTEM_SINA_UID) {
					$token = USER::get('XWB_OAUTH_CONFIRM');
					// 如果站长token发生变化，则修改user_config.php的token
					if ($token['oauth_token'] != WB_USER_OAUTH_TOKEN || $token['oauth_token_secret'] != WB_USER_OAUTH_TOKEN_SECRET) {
						if (XWB_SERVER_ENV_TYPE === 'sae') {
							$storage = new SaeStorage();
							$content = $storage->read(CONFIG_DOMAIN, md5(CONFIG_DOMAIN));
							parse_str($content, $config);
							$config['user_oauth_token'] = $token['oauth_token'];
							$config['oauth_token_secret'] = $token['user_oauth_token_secret'];
							$content = http_build_query($config);
							$storage->write(CONFIG_DOMAIN, md5(CONFIG_DOMAIN), $content);
						} else {
							// 修改user_config.php和绑定信息
							$config_file = IO::read(ROOT_PATH . 'user_config.php');
							$config_arr = array(
											'WB_USER_OAUTH_TOKEN' => $oauth_token,
											'WB_USER_OAUTH_TOKEN_SECRET' => $oauth_token_secret
										);

							//更新user_config数据
							$config_file = F('set_define_value', $config_file, $config_arr);
							IO::write(ROOT_PATH . 'user_config.php', $config_file);	
						}
					}
				}
			default 		:
				//设置同步　登录退出状态，在 footer　中输出JS通知 
				USER::set('syncLoginScript', 1);
				//登录回调
				$loadUrl = V('g:loginCallBack', false);
				/// 是否是激活
				$active = V('g:active', false);
				//检查是否第一次登录并引导用户
				$isFirst = $this->_initFirstLoginUser($uInfo);

				if (empty($active)) {
					if ($isFirst) {
						/// 上报
						F('report', 'logon', 'http');
						$firstPlugin = DS('Plugins.get', 'g1/86400', 4);

						if ($firstPlugin['in_use'])
							$loadUrl = URL('welcome');
					}
				}

				$this->_onlogin($loadUrl);
				break;
		}
	}
	
	/// 输出一段JS，通知程序关闭　登录绑定窗口，并跳转到指定页面,或者直接跳转; $goUrl 为 false　则刷新当前页
	function _onlogin($goUrl=false){
			
		if (V('g:popup', false)) {
			$loadUrl = $goUrl ? '"'.addslashes($goUrl).'"' : 'false' ;
			echo '<script>try{window.opener.loginCallback('.$loadUrl.');}catch(e){window.location.href="'. W_BASE_URL . '"}</script>';
		} else {
			$loadUrl = $goUrl ? $goUrl : URL('index') ;
			APP::redirect($loadUrl,3);
		}
		exit;
	}
	
	/// 设置会话信息
	function _setSinaLoginSession($token, $user = null){
		USER::setOAuthKey($token, true);
		DS('xweibo/xwb.setToken');
		$uInfo = DR('xweibo/xwb.verifyCredentials');
		/// 用户取消之前的授权
		/*
		if ($uInfo['errno'] == '1040008') {
			/// 解除之前的绑定，重新bind
			$inData = array('access_token'=>'', 'token_secret'=>'', 'uid'=>0);
			DR('mgr/userCom.insertUser', '', $inData, $user['sina_uid']);

			///如果开启的插件通信
			$this->_xwbBBSplugin(null, $user['sina_uid'], 'delete');

			return;
		}
		 */
		$uInfo = $uInfo['rst'];
	   //print_r($uInfo);exit;
		USER::uid($uInfo['id']);
		USER::set('sina_uid',		$uInfo['id']);
		USER::set('screen_name',	$uInfo['screen_name']);
		USER::set('description',	$uInfo['description']);
		
		//设置已读的最新消息时间戳
		$user_info = DR('mgr/userCom.getByUid', 'p', $uInfo['id']);
		$maxNoticeTime = isset($user_info['rst']['max_notice_time']) ? $user_info['rst']['max_notice_time'] : APP_LOCAL_TIMESTAMP;
		USER::set('user_max_notice_time', $maxNoticeTime);
		
		// 设置个性域名
		if ( USED_PERSON_DOMAIN ) {
			$domainRst  = DR('mgr/userCom.getByUid', 'p', $uInfo['id']);
			$domain		= isset($domainRst['rst']['domain_name']) ? $domainRst['rst']['domain_name'] : FALSE;
			USER::set('domain_name',    $domain);
		}
		
		//检查当前帐号是否为管理员 
		if ($rs = $this->_chkIsAdminAcc($uInfo['id'])){
			USER::set('isAdminAccount',	$rs);
		}
		
		//封禁检查
		$this->_chkIsForbidden($uInfo['id']);
		return $uInfo;
	}
	
	/**
	 * 检查是否是管理员
	 * @param $sina_uid string sina帐号
	 * @return false|int
	 */
	function _chkIsAdminAcc($sina_uid){
		$rs = DS('mgr/adminCom.getAdminByUid','', $sina_uid);
		$ret = !empty($rs) && isset($rs[0]['group_id'])?$rs[0]['group_id'] : false;
		return $ret;
	}
	
	/// 检查　用户　是否被封禁
	function _chkIsForbidden($sina_uid){
		$isLoginForbidden = false;
		$uInfo = DS('mgr/userCom.getUseBanById','',$sina_uid);
		//　在封禁表中找到记录,此用户被封禁
		if (!empty($uInfo) && is_array($uInfo) && isset($uInfo['sina_uid']) ){
			$isLoginForbidden = $uInfo['sina_uid'];
			USER::set('isLoginForbidden', $isLoginForbidden);
		}
		
		if ($isLoginForbidden){
			$this->_resetClientSess();
			$this->_onlogin(URL('account.inhibit'));		   
		}
	}
	
	/// 重置前端用户相关的SESSION
	function _resetClientSess(){
		USER::setOAuthKey(array(),	false);
		USER::setOAuthKey(array(),	true);
		USER::uid('');
		USER::set('sina_uid',		'');
		USER::set('screen_name',	'');
		USER::set('description',	'');
		USER::set('user_max_notice_time',	'');
	}
	
	///　封禁页面
	function inhibit(){
		TPL::display('inhibit', array(), 0, 'modules');
		exit;
	}
	
	///　重复绑定页面
	function isBinded($user_name){ $this->_resetClientSess();
		Xpipe::usePipe(false);
		TPL::assign('user_name',		$user_name);
		$url = $this->getTokenAuthorizeURL('bind', 1);
		$url = 'http://login.sina.com.cn/sso/logout.php?r='. urlencode($url);
		TPL::assign('sina_login_url',	$url);
		TPL::display('isbind', array(), 0, 'modules');
		exit;
	}
	
	/// 接受来自第三方的登录通知
	function acceptSyncMessage(){
		$this->accAdapter->acceptSyncMessage();
	}
	
	/// 禁止访问
	function deny(){
		APP::deny();
	} 
	
	/// 解除绑定
	function unBind(){
		$sina_uid = USER::uid();
		if ($sina_uid){

			///如果开启的插件通信
			$this->_xwbBBSplugin(null, $sina_uid, 'delete');

			$inData = array('access_token'=>'', 'token_secret'=>'', 'uid'=>0);	
			$r = DR('mgr/userCom.insertUser', '', $inData, $sina_uid);
			F('report', 'untie', 'http');
			$this->logout();
		}else{
			APP::deny('未登录用户不能解除绑定.');			
		}
		
	}
	
	/// 获取绑定信息
	function getBindInfo($v, $vField='sina_uid'){
		$com =  $vField == 'sina_uid' ? 'mgr/userCom.getByUid' : 'mgr/userCom.getBySiteUid';
		$result = DR($com, 'p', $v);
		$result = $result['rst'];

		/// xwb与插件开启通信
		$xwb_discuz_enable = V('-:sysConfig/xwb_discuz_enable'); 
		if ($xwb_discuz_enable == 1) {
			if (empty($result)) {
				/// 读取插件的绑定数据
				$type = $vField == 'sina_uid' ? 'sina_uid' : 'uid';
				$ret = DR('xwbBBSpluginCf.getBindUser', '', $v, $type);
				if (empty($ret['errno'])) {
					$ret = isset($ret['rst']) ? $ret['rst'] : false; 
					$inData = array();
					if ($ret) {
						///查询sina帐号是否已经绑定其他论坛帐号
						$sina_result = DR('mgr/userCom.getByUid', 'p', $ret['sina_uid']);
						$sina_result = $sina_result['rst'];
						if (is_array($sina_result) && !empty($sina_result['uid']) && !empty($sina_result['access_token']) && !empty($sina_result['token_secret'])) {
							/// 更新xwb的绑定数据
							$inData['uid']			= $ret['uid'];
							DR('mgr/userCom.insertUser', '', $inData, $ret['sina_uid']);
						} else {
							$token_array = array('oauth_token'=> $ret['token'],
													'oauth_token_secret'=> $ret['tsecret']);
							USER::setOAuthKey($token_array, true);
							DS('xweibo/xwb.setToken');
							$uInfo = DR('xweibo/xwb.verifyCredentials');
							if (!empty($uInfo['errno'])) {
								return;
							}
							$uInfo = $uInfo['rst'];
							$inData['sina_uid']		= $ret['sina_uid'];
							$inData['nickname']		= $uInfo['screen_name'];
							$inData['uid']			= $ret['uid'];
							$inData['access_token']	= $ret['token'];
							$inData['token_secret']	= $ret['tsecret'];
							
							/// 同步xwb的绑定数据
							$sina_uid = isset($sina_result['sina_uid']) && !empty($sina_result['sina_uid']) ? $sina_result['sina_uid'] : '';
							DR('mgr/userCom.insertUser', '', $inData, $sina_uid);
						}

					}
					return $inData;
				} else {
					///记录日志
					$msg = "[getBindInfo]api: getBindUser\r\n id: $v\r\n type: $type\r\n errno: {$ret['errno']}\r\n err: {$ret['err']}";
					LOGSTR('xplug', $msg);
				}
			}
		   	else {
				if (!empty($result['uid']) && !empty($result['access_token']) && !empty($result['token_secret'])) {
					///同步插件的绑定数据
					$bindUser = DR('xwbBBSpluginCf.updateBindUser', '', $result['uid'], $result['sina_uid'], $result['access_token'], $result['token_secret']);
					$bindUser = $bindUser['rst'];
					if (!empty($bindUser['errno'])) {
						///记录日志
						$msg = "[getBindInfo]api: updateBindUser\r\n uid: {$result['uid']}\r\n sina_uid: {$result['sina_uid']}\r\n access_token: {$result['access_token']}\r\n token_secret: {$result['token_secret']}\r\n errno: {$bindUser['errno']}\r\n err: {$bindUser['err']}";
						LOGSTR('xplug', $msg);
					}
				}
			}
		}
	    return $result; 
	}
	
	/**
	 * 到新浪页面进行注册
	 */
	function goSinaReg(){
		if(APP::F('is_robot')){
			APP::deny();
		}
		
		if(USER::isUserLogin()){
			$url = W_BASE_HTTP.URL('pub');
		}else{
			$url = F('get_reg_url');
		}
		APP::redirect($url, 3);
		exit();
	}

	/**
	 * 同步插件绑定数据
	 */
	function _xwbBBSplugin($inData = null, $sina_uid = null, $type = 'update') {
		$xwb_discuz_enable = V('-:sysConfig/xwb_discuz_enable'); 
		if (1 == $xwb_discuz_enable) {
			if ($type == 'delete') {
				$userinfo = $this->getBindInfo($sina_uid);
				if ($userinfo) {
					///同步插件的绑定数据
					DR('xwbBBSpluginCf.deleteBindUser', '', $userinfo['uid'], $userinfo['sina_uid']);
				}
			} else {
				///同步插件的绑定数据
				$bindUser = DR('xwbBBSpluginCf.updateBindUser', '', $inData['uid'], $inData['sina_uid'], $inData['access_token'], $inData['token_secret']);
				$bindUser = $bindUser['rst'];
				if (!empty($bindUser['errno'])) {
					///记录日志
					$msg = "[_xwbBBSplugin]api: addBindUser\r\n uid: {$result['uid']}\r\n sina_uid: {$result['sina_uid']}\r\n access_token: {$result['access_token']}\r\n token_secret: {$result['token_secret']}\r\n errno: {$bindUser['errno']}\r\n err: {$bindUser['err']}";
					LOGSTR('xplug', $msg);
				}
			}
		}
	}
	
}
