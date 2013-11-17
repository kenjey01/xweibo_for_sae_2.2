<?php
/**
 * @file			dzUcenter_account.adp.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			xionghui <xionghui1@staff.sina.com.cn>
 * @Create Date:	2010-06-08
 * @Modified By:	xionghui/2010-11-15
 * @Brief			DZ帐号适配器文件
 */
// ------------------------------------------------------------------------------ 
// DZ 的注册地址 
define('DZUC_REGISTER_URL',		'http://demo.discuz.cn/utf8/7.2/register.php');
// DZ 的登录地址     
define('DZUC_LOGIN_URL', 		'http://demo.discuz.cn/utf8/7.2/logging.php?action=login');
// DZ 的UCENTER地址 不包含最后的 /
define('DZUC_UCENTER_URL', 		'http://demo.discuz.cn/utf8/ucenter');
// dz 的UCENTER　字符集
define('DZUC_UCENTER_CHARSET',	'UTF-8');
// 附属站名称，不以 网字结尾  ,　不要超过　10个汉字，20　个字母
define('DZUC_SITE_NAME', 		'DZ测试站'); 
// 与附属站进行通讯的 UC_KEY
define('DZUC_API_KEY', 			'123456'); 
// 此应用在 UC 中的ID
define('DZUC_APP_ID', 			'6'); 
// 用于存储用户信息的 COOKIE 名  
define('DZUC_USER_CK_NAME', 	'XweiboUserData_xauthCode'); 
// 用于存储用户信息的 COOKIE 有效时间, 设置为 0 则只在浏览器周期有效 APP_LOCAL_TIMESTAMP+3600*24*15
define('DZUC_USER_CK_TIME',		0);
// 用于存储用户信息的 COOKIE 有效路径
define('DZUC_USER_CK_PATH', 	'/');
// USER-AGENT
define('DZUC_USER_AGENT',		XWB_HTTP_USER_AGENT);
// 已绑定DZ用户的SINA帐号，登录，退出时，是不是要同步到 DZ　
define('DZUC_SYNC_USER_STATUS',	true);
// WAP 的远程登录验证地址     
define('WAP_LOGIN_URL', 		'http://domain/waplogin.php');
// ------------------------------------------------------------------------------

/**
 * Ucenter 的用户适配器
 *
 */
class dzUcenter_account {
	function dzUcenter_account() {
	}

	function adp_init($config=array()) {
	   
	}	
	
	function goLogin($callBackUrl){
		return  DZUC_LOGIN_URL.(strpos(DZUC_LOGIN_URL, '?') ? '&' : '?').'referer='.urlencode($callBackUrl);
	}
	
	function goRegister($callBackUrl){
	    return  DZUC_REGISTER_URL.(strpos(DZUC_REGISTER_URL, '?') ? '&' : '?').'referer='.urlencode($callBackUrl);
	}
	
	function getSiteUser(){
	    $user = $this->_uc_getAuthData();
	    if (empty($user) || !is_array($user) ){
	    	return array('site_uid'=>0, 'site_uname'=>'Guest');
		}else{
			return array('site_uid'=>$user['uid'], 'site_uname'=>$user['username'] );
		}
	}
	
	function getInfo(){
		$user = $this->getSiteUser();
		return  array(
				'site_name'=>	DZUC_SITE_NAME , 
				'site_uid'=>	$user['site_uid'],
				'site_uname'=>	F('xwb_iconv', $user['site_uname'], DZUC_UCENTER_CHARSET, 'UTF-8'),
				'reg_url'=>		$this->goRegister(W_BASE_HTTP.URL('pub')), 
				'login_url'=>	$this->goLogin(W_BASE_HTTP.URL('pub')));
	}
	
	function acceptSyncMessage(){
		  $code = V('g:code');
		  $vStr = $this->_uc_authcode($code, 'DECODE');
		  //echo $vStr;
		  parse_str($vStr, $vArr);
		  if (empty($vArr) || !isset($vArr['action'])) {
		  	return false;
		  }
		  
		  //映射 UC 提交过来的方法 _uc_action_* 的方法都将接受远程通知
		  $actionFunc = '_uc_action_'.$vArr['action'];
		  if (method_exists($this, $actionFunc)){
		  	$this->$actionFunc($code, $vArr);
		  	exit;
		  }
		  echo '0';exit;		  
	}
	
	function syncLogin($site_uid,$sina_uid=0){
		if (!defined('DZUC_SYNC_USER_STATUS') || !DZUC_SYNC_USER_STATUS) {
			return '';
		}
		$input	= 'uid='.$site_uid.'&agent='.md5(DZUC_USER_AGENT)."&time=". APP_LOCAL_TIMESTAMP;
		$input	= urlencode($this->_uc_authcode($input, 'ENCODE')); 
		$q		= "m=user&a=synlogin&inajax=2&release=&input=$input&appid=".DZUC_APP_ID;
		$url	= DZUC_UCENTER_URL.'/index.php?'.$q; 
		//return $this->_uc_httpReq($url);
		return F('http_get_contents',$url);
	}
	
	function syncLogout($site_uid,$sina_uid=0){
		$this->localLogout();
		if (!defined('DZUC_SYNC_USER_STATUS') || !DZUC_SYNC_USER_STATUS) {
			return '';
		}
		$input	= 'uid='.$site_uid.'&agent='.md5(DZUC_USER_AGENT)."&time=".APP_LOCAL_TIMESTAMP;
		$input	= urlencode($this->_uc_authcode($input, 'ENCODE')); 
		$q		= "m=user&a=synlogout&inajax=2&release=&input=$input&appid=".DZUC_APP_ID;
		$url	= DZUC_UCENTER_URL.'/index.php?'.$q; 
		//return $this->_uc_httpReq($url);
		return F('http_get_contents',$url);
	}
	
	function localLogout(){
		$this->_uc_setAuthData('');
	}

	function xweiboLogout() {
		/// 清空SESSION 
		USER::uid(0);
		USER::resetInfo();
	}

	function wapLogin($account, $password)
	{
		$http = APP::ADP('http');
		$http->setUrl(WAP_LOGIN_URL);
		$http->setData(array('account' => $account, 'password' => $password));
		$result = $http->request('post');
		$code = $http->getState();
		if ($code != 200) {
			return RST(false, $code, L('adapter__account__dzUcenter__loginError'));
		}
		return RST($result);
	}
	
	// ------------------------------------------------------------------------------
	
	    
	// ------------------------------------------------------------------------------
	//UC 的登出通知
	function  _uc_action_synlogout($vStr, $vArr){
		$this->_uc_setAuthData('');
		$this->xweiboLogout();
		echo 1;exit;
	}
	
	//UC 的登入通知 
	function  _uc_action_synlogin($vStr, $vArr){
		$this->_uc_setAuthData($vStr);
		echo 1;exit;
	}  
	
	//UC 的测试方法
	function  _uc_action_test($vStr, $vArr){
		echo 1;exit;
	}
	// ------------------------------------------------------------------------------
	function _uc_setAuthData($data){
		 $this->_uc_p3p();
		 $exp = empty($data) ? APP_LOCAL_TIMESTAMP-3600*24*365 : DZUC_USER_CK_TIME;
		 setcookie(DZUC_USER_CK_NAME, $data, $exp, DZUC_USER_CK_PATH);
	}
	
	function _uc_getAuthData(){ 
		$code = V('c:'.DZUC_USER_CK_NAME);
		$vStr = $this->_uc_authcode($code, 'DECODE');
		parse_str($vStr, $vArr);
		return  $vArr ;
	}
	
	// 是IE中，跨域名设置COOKIE 需设置 P3P 头 
	function _uc_p3p(){		 
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		//CAO DSP COR CUR ADM DEV TAI PSA PSD IVAi IVDi CONi TELo OTPi OUR DELi SAMi OTRi UNRi PUBi IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE GOV
	}
	
	// UC 的加密，解密算法
	function _uc_authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
		$ckey_length = 4;

		$key = md5($key ? $key : DZUC_API_KEY);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);

		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + APP_LOCAL_TIMESTAMP : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);

		$result = '';
		$box = range(0, 255);

		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}

		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}

		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}

		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - APP_LOCAL_TIMESTAMP > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
		}
	}
}
?>
