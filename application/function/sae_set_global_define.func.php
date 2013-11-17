<?php
/**
* 如果Xweibo运行于SAE环境，则自动在这个函数里定义相关的常量
* 
* 如果已安装成功，返回 TRUE　，如果未安装　返回 FALSE
*/
function sae_set_global_define() {
	
	// set the conifg in cache
	$key 	 = 'sae_set_global_define#'.CONFIG_DOMAIN;
	$content = CACHE::get($key);
	if (empty($content)) {
		$storage = new SaeStorage();
		$content = $storage->read(CONFIG_DOMAIN, md5(CONFIG_DOMAIN));
		//$content   = IO::read(CONFIG_DOMAIN);
		$cacheTime = 300;		// 缓存时间秒为单位
		CACHE::set($key, $content, $cacheTime);
	}
	else 
	{
		$site_base_info = array();
		parse_str($content, $site_base_info);
		$isAuth = isset($site_base_info['user_oauth_token']) && isset($site_base_info['user_oauth_token_secret']);
		if (!$isAuth) {	// get from storage again
			//$content   = IO::read(CONFIG_DOMAIN);
			$storage = new SaeStorage();
			$content = $storage->read(CONFIG_DOMAIN, md5(CONFIG_DOMAIN));
			$cacheTime = 300;		// 缓存时间秒为单位
			CACHE::set($key, $content, $cacheTime);
		}
	}
	
	$site_base_info = array();
	parse_str($content, $site_base_info);
	

	if($site_base_info['app_key']&&$site_base_info['app_secret']){
		/// 产品安装路径
		define('W_BASE_URL_PATH',		$site_base_info['path']);
		/// 微博 APP_KEY
		define('WB_AKEY' , 					$site_base_info['app_key']);
		/// 微博 SECRET_KEY
		define('WB_SKEY' , 					$site_base_info['app_secret']);

		define('WB_USER_SITENAME',			$site_base_info['site_name']);
		define('WB_USER_SITEINFO',			$site_base_info['site_info']);
		define('WB_USER_NAME' , 			isset($site_base_info['user_name'])?$site_base_info['user_name']:'');
		define('WB_USER_EMAIL' , 			isset($site_base_info['user_email'])?$site_base_info['user_email']: '');
		define('WB_USER_QQ' , 				isset($site_base_info['user_qq'])?$site_base_info['user_qq']: '');
		define('WB_USER_MSN' , 				isset($site_base_info['user_msn'])? $site_base_info['user_msn']: '');
		define('WB_USER_TEL' , 				isset($site_base_info['user_tel'])? $site_base_info['user_tel']: '');
		define('SYSTEM_SINA_UID' , 			isset($site_base_info['sina_id'])? $site_base_info['sina_id']: '');
		define('WB_USER_OAUTH_TOKEN' , 		isset($site_base_info['user_oauth_token'])? $site_base_info['user_oauth_token'] : '');
		define('WB_USER_OAUTH_TOKEN_SECRET' , isset($site_base_info['user_oauth_token_secret'])?$site_base_info['user_oauth_token_secret'] :'');
		//define('APP_FLAG_VER',				isset($site_base_info['app_flag_ver'])?$site_base_info['app_flag_ver']:'');
		/// MC　KEY　的前缀
		//define('MC_PREFIX',					'XWB11_MC_'.APP_FLAG_VER);
		// 重新设置memcache前缀
		V('-:adapter_cfg/cache/memcache/keyPre', MC_PREFIX.$site_base_info['app_flag_ver'], true);
		return true;
	}else{
		return false;
	}
	
}
