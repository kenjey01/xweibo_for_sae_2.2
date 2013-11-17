<?php
/**
 * @file			verified_func.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-11-15
 * @Modified By:	heli/2010-11-15
 * @Brief			认证处理函数-Xweibo
 */


/**
 * 用户认证
 *
 * @param array $user
 * @return tool
 */
function verified($user, $type = 'feed') 
{
	$authen_type = V('-:sysConfig/authen_type'); //0不显示认证 1采用新浪认证 2采用本站认证 3新浪与本站认证并存
	$verified_html = (defined('ENTRY_SCRIPT_NAME') && ENTRY_SCRIPT_NAME == 'wap') ? htmlspecialchars(isset($user['screen_name']) ? $user['screen_name'] : $user['nick'], ENT_QUOTES) : '';
	switch ($authen_type) {
		case 0:
			$verified_html .= '';
			break;
			
		case 1:
			$verified_html .= (string)getSinaVerified($user, $type);
			break;
			
		case 2:
			$verified_html .= (string)getSiteVerified($user, $type);
			break;
			
		case 3:
			$siteverified_html = getSiteVerified($user, $type);
			if ($siteverified_html === false) {
				$siteverified_html = getSinaVerified($user, $type);
			}
			$verified_html .= (string)$siteverified_html;
			break;
	}
	
	return $verified_html;
}

/**
* 新浪认证
* 
* @param mixed $user
* @param mixed $type
*/
function getSinaVerified($user, $type = 'feed')
{
	if (defined('ENTRY_SCRIPT_NAME') && ENTRY_SCRIPT_NAME == 'wap') {
		$verified_html = '<img src="' . W_BASE_URL . 'css/wap/bgimg/icon_v.png" alt="V" />';
	} else {
		if ('feed' == $type) {
			$verified_html = L('function__verified__sinaVerifyTip1', F('fix_url',  AUTH_SMALL_ICON_DEFAULT_NAME));
			//$verified_html = '<img src="'.F('fix_url',  AUTH_SMALL_ICON_DEFAULT_NAME).'" alt="'.LO('function__verified__sinaVerify').'" title="'.LO('function__verified__sinaVerify').'" />';
		} else {
			$verified_html = L('function__verified__sinaVerifyTip2', F('fix_url', AUTH_BIG_ICON_DEFAULT_NAME));
			//$verified_html = '<div class="vip-card"><img src="'.F('fix_url', AUTH_BIG_ICON_DEFAULT_NAME).'" alt="'.LO('function__verified__sinaVerify').'" title="'.LO('function__verified__sinaVerify').'" /></div>';
		}
	}
	
	if (isset($user['verified']) && $user['verified']) {
		return $verified_html;
	}
	
	return false;
}

/**
* 本站自定义认证
* 
* @param mixed $user
* @param mixed $type
*/
function getSiteVerified($user, $type = 'feed')
{
	if (defined('ENTRY_SCRIPT_NAME') && ENTRY_SCRIPT_NAME == 'wap') {
		$authen_small_icon = V('-:sysConfig/authen_small_icon') ? V('-:sysConfig/authen_small_icon') : 'img/logo/small_auth_icon.png';
		$verified_html = '<img src="'.F('fix_url', $authen_small_icon).'" alt="V" />';
	} else {
		$reason = isset($user['site_v_reason']) && !empty($user['site_v_reason']) ? F('escape', $user['site_v_reason']) : '';
		$title = V('-:sysConfig/authen_small_icon_title') ? F('escape', V('-:sysConfig/authen_small_icon_title')) : F('escape', V('-:sysConfig/site_name')) . L('function__verified__verifyTitle');
	
		if ('feed' == $type) {
			$authen_small_icon = V('-:sysConfig/authen_small_icon') ? V('-:sysConfig/authen_small_icon') : 'img/logo/small_auth_icon.png';
			$verified_html = '<img src="'.F('fix_url', $authen_small_icon).'" alt="'.$title.'" title="'.$title.'" />';
		} else {
			$authen_big_icon = V('-:sysConfig/authen_big_icon') ? V('-:sysConfig/authen_big_icon') : 'img/logo/big_auth_icon.png';
			$verified_html = ($reason ? '<div class="explain"><div class="bd"><div class="bg"></div><div class="cont">' : '') . '<div class="vip-card"><img src="'.F('fix_url', $authen_big_icon).'" alt="'.$title.'" title="'.$title.'" /></div>'  . ($reason ? '<p>' . $reason . '</p></div></div></div>' : '');
		}
	}
	
	if (isset($user['site_v']) && $user['site_v']) {
		return $verified_html;
	}
	
	return false;
}
