<?php
/**
 * @file			get_reg_url_func.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-11-15
 * @Modified By:	heli/2010-11-15
 * @Brief			获取注册url函数-Xweibo
 */

function get_reg_url()
{

	$token = DR('xweibo/xwb.getRequestToken');
	$token = $token['rst'];
	USER::setOAuthKey($token, false);

	$callbackOpt = 'cb=login';
	///　登录后的跳转URL
	$loginCallBack = V('g:loginCallBack', '');
	if ($loginCallBack) {
		$loginCallBack = '&loginCallBack='.urlencode($loginCallBack);
	}
	
	$lang = '';
	switch(APP::getLang()) {
		case 'zh_cn':
			$lang = 'zh-Hans';
			break;
		case 'zh_tw':
			$lang = 'zh-Hant';
			break;
		case 'en':
			$lang = 'en';
			break;
	}
	$oauthCbUrl = W_BASE_HTTP.URL('account.oauthCallback', $callbackOpt).$loginCallBack;

	$params_str = 'oauth_token='.urlencode($token['oauth_token']).'&oauth_callback='.urlencode($oauthCbUrl).'&lang='.$lang;

	$url = WEIBO_API_URL.'oauth/register?'.$params_str;

	return $url;
}
