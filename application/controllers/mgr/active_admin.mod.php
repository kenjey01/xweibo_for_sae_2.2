<?php
define('ROOT_PATH', dirname(__FILE__) . '/../../../');
@include_once ROOT_PATH . 'user_config.php';
class active_admin_mod {
	function active_admin_mod() {
		$rs = "";
		//判断用户是否登录
		if (!USER::isUserLogin()) {
			$app_secret = urldecode(trim(V('g:app_secret', '')));
			$app_key = urldecode(trim(V('g:app_key', '')));
			$toUrl = URL('account.sinaLogin','cb=login&active=1&loginCallBack=' . urlencode(URL('mgr/active_admin.active', 'app_key='.$app_key.'&app_secret='.$app_secret, 'admin.php')), 'index.php');
			APP :: redirect($toUrl, 3);
		}

		//判断是否有管理员
		$rs = DR('mgr/adminCom.getAdminByUid');
		if(WB_USER_OAUTH_TOKEN && WB_USER_OAUTH_TOKEN_SECRET && $rs['rst']) {
			APP :: redirect(URL('mgr/admin.login', '', 'admin.php'), 3);
		}
	}

	function active() {
		TPL :: assign('app_secret', urldecode(trim(V('g:app_secret', ''))));
		TPL :: assign('app_key', urldecode(trim(V('g:app_key', ''))));
		TPL :: assign('sina_uid', $this->_getUserInfo('sina_uid'));
		TPL :: assign('real_name', $this->_getUserInfo('screen_name'));
		$this->_display('active_admin');
	}

	function saveActive() {
		$config_file = $date = $rs = "";
		$app_key = trim(V('p:appkey',''));
		$app_secret = trim(V('p:secret',''));
		$pwd = trim(V('p:pwd',''));
		$repwd = trim(V('p:repwd',''));
		$name = trim(V('p:name',''));
		$email = trim(V('p:email',''));
		$tel = trim(V('p:tel',''));
		$qq = trim(V('p:qq',''));
		$msn = trim(V('p:msn',''));
		$sina_uid = $this->_getUserInfo('sina_uid');
		$oauth = $this->_getUserInfo('XWB_OAUTH_CONFIRM');

		$oauth_token = $oauth['oauth_token'];
		$oauth_token_secret = $oauth['oauth_token_secret'];
		if($app_key != WB_AKEY) {
			exit('{"msg":"您输入的APPKEY不符","state":"1001"}');
		}

		if($app_secret != WB_SKEY) {
			exit('{"msg":"您输入的APPKEY SECRET不符","state":"1002"}');
		}

		$data = array(
                            'sina_uid' => $this->_getUserInfo('sina_uid'),
                            'pwd' => md5($pwd),
                            'add_time' =>APP_LOCAL_TIMESTAMP,
                            'group_id' => 1 // 1为超级管理员
			);

		if (strtolower(XWB_SERVER_ENV_TYPE)==='sae'){
			// 由于SAE下无法得到原先站长，因此如果存在有该sina用户id则先删除
			DR('mgr/adminCom.delAdmin','', $sina_uid, true);
			$config_arr = array(
							'WB_USER_NAME' => $name,
							'WB_USER_EMAIL' => $email,
							'WB_USER_QQ' => $qq,
							'WB_USER_MSN' => $msn,
							'WB_USER_TEL' => $tel,
							'SYSTEM_SINA_UID' => $sina_uid,
							'WB_USER_OAUTH_TOKEN' => $oauth_token,
							'WB_USER_OAUTH_TOKEN_SECRET' => $oauth_token_secret
						);
			$this->sae_set_config($config_arr);
		}else{
	        $config_file = IO::read(ROOT_PATH . 'user_config.php');
	        $config_arr = array(
							'WB_USER_NAME' => $name,
							'WB_USER_EMAIL' => $email,
							'WB_USER_QQ' => $qq,
							'WB_USER_MSN' => $msn,
							'WB_USER_TEL' => $tel,
							'SYSTEM_SINA_UID' => $sina_uid,
							'WB_USER_OAUTH_TOKEN' => $oauth_token,
							'WB_USER_OAUTH_TOKEN_SECRET' => $oauth_token_secret
						);
	
	        //更新user_config数据
	        $config_file = F('set_define_value', $config_file, $config_arr);
			IO::write(ROOT_PATH . 'user_config.php', $config_file);
		}
		$rs = DR('mgr/adminCom.saveAdminById', '', $data);
		
		session_regenerate_id();   //防御Session Fixation
        USER::set('isAdminAccount', 1);// 1为超级管理员
        USER::set('isAdminReport', 1);	//设置为上报
		exit('{"state":"200"}');
	}
	function sae_set_config($data){
		//$config_file = IO::read(CONFIG_DOMAIN);
		$storage = new SaeStorage();
		$config_file = $storage->read(CONFIG_DOMAIN, md5(CONFIG_DOMAIN));
		$site_base_info = array();
		parse_str($config_file, $site_base_info);
		
		$site_base_info['user_name'] = $data['WB_USER_NAME'];
		$site_base_info['user_email'] = $data['WB_USER_EMAIL'];
		$site_base_info['user_qq'] = $data['WB_USER_QQ'];
		$site_base_info['user_msn'] = $data['WB_USER_MSN'];
		$site_base_info['user_tel'] = $data['WB_USER_TEL'];
		$site_base_info['sina_id'] = $data['SYSTEM_SINA_UID'];
		$site_base_info['user_oauth_token'] = $data['WB_USER_OAUTH_TOKEN'];
		$site_base_info['user_oauth_token_secret'] = $data['WB_USER_OAUTH_TOKEN_SECRET'];
		
		$temp = array();
		foreach ($site_base_info as $key => $value){
			$temp[] = $key .'='. $value;
		}
		$base_info_str = implode('&', $temp);
		//IO::write(CONFIG_DOMAIN,$base_info_str);
		$storage->write(CONFIG_DOMAIN, md5(CONFIG_DOMAIN), $base_info_str);
	}

	/**
	* 得到登录用户信息
	*/
	function _getUserInfo($key = '') {
		return USER::get($key);
	}

	function _display($tpl) {
		TPL :: display('mgr/' . $tpl, '', 0, false);
	}

	/*
	 * 激活页面点击换个帐号
	 */
	function changeAccount() {
		$app_secret = urldecode(trim(V('g:app_secret', '')));
		$app_key = urldecode(trim(V('g:app_key', '')));

		USER::uid(0);
		USER::resetInfo();
		$toUrl = URL('account.sinaLogin','cb=login&active=1&loginCallBack=' . urlencode(URL('mgr/active_admin.active', 'app_key='.$app_key.'&app_secret='.$app_secret, 'admin.php')), 'index.php');
		APP :: redirect($toUrl, 3);
	}
}
?>
