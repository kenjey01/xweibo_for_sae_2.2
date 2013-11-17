<?php
/**
 * @file			report.func.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-11-15
 * @Modified By:	heli/2010-11-15
 * @Brief			Xweibo统计上报处理方法
 */

/**
 * 数据上报
 *@param $type string 上报类型
 *@param $way src|http|publish src则返回url,http则记录url到cahce,publish则输出所有记录的url
 *@param $tauid int
 *@return boolean|array|string
 */
function report($type = 'idx', $way = 'src', $tauid = null)
{
	$cache_key = 'report_'. USER::uid();
	if ($way == 'publish') {
		if (!USER::uid()) {
			return false;
		}
		//file_put_contents('t.txt', 'publish'. "\r\n", FILE_APPEND);
		$data = CACHE::get($cache_key);
		CACHE::set($cache_key, array());
		return $data;
	}

	$params = array();
	$params['akey'] = WB_AKEY;
	$params['pjt'] = WB_PROJECT;
	$params['ver'] = WB_VERSION;
	$params['random'] = mt_rand();
	$params['xt'] = $type;
	if (!isset($_COOKIE['x3w4b'])) {
		$cid = md5(rand().time());
		setCookie('x3w4b', $cid);
		$_COOKIE['x3w4b'] = $cid;
	}
	$params['c_id'] = $_COOKIE['x3w4b'];
	switch ($type) {
		case 'idx':
		case 'me':
		case 'ta':
		case 'pub':
			$params['xt'] = 'pv';
			$params['p'] = $type;
			if (USER::uid()) {
				$params['uid'] = USER::uid();
			} 
			if ($tauid) {
				$params['taid'] = $tauid;	
			}
			break;
		case 'cmt':
		case 'fw':
		case 'post':
			$params['uid'] = USER::uid();
			$params['ip'] = F('get_client_ip');
			break;
		case 'bind':
			$params['type'] = 1;
		case 'untie':
			$params['ip'] = F('get_client_ip');
			$params['uid'] = USER::uid();
			break;

		case 'site_login':
			//$params['log_type'] = 2;
			$params['xt'] = 'login';
			$params['akey'] = WB_AKEY;
			$params['uid'] = USER::uid();
			$params['ip'] = F('get_client_ip');
			$params['is_bind'] = USER::get('site_uid') ? 1 : 0;
			break;

		case 'sina_login':
			//$params['log_type'] = 1;
			$params['xt'] = 'login';
			$params['akey'] = WB_AKEY;
			$params['uid'] = USER::uid();
			$params['ip'] = F('get_client_ip');
			$params['is_bind'] = USER::get('site_uid') ? 1 : 0;
			break;
		case 'logout':
			$params['xt'] = $type;
			$params['akey'] = WB_AKEY;
			$params['uid'] = USER::uid();
			$params['ip'] = F('get_client_ip');
			break;
		case 'logon':
			$params['xt'] = $type;
			$params['akey'] = WB_AKEY;
			$params['uid'] = USER::uid();
			$params['ip'] = F('get_client_ip');
			$params['is_bind'] = USER::get('site_uid') ? 1 : 0;
			break;
		case 'skin':
			$params['xt'] = $type;
			$params['uid'] = USER::uid();
			break;
		case 'register':
			$params['xt'] = $type;
			$params['name'] = WB_USER_SITENAME;
			$params['content'] = WB_USER_SITEINFO;
			$params['uname'] = WB_USER_NAME;
			$params['em'] = WB_USER_EMAIL;
			$params['qq'] = WB_USER_QQ;
			$params['msn'] = WB_USER_MSN;
			$params['tel'] = WB_USER_TEL;
			$params['domain'] = V('s:HTTP_HOST');
			break;
		case 'letter':
		case 'concern':
		case 'unconcern':
			$params['xt'] = $type;
			$params['dsz'] = '';
			$params['akey'] = WB_AKEY;
			$params['uid'] = USER::uid();
			$params['ip'] = F('get_client_ip');
			break;
	}

	if ($params) {
		//$params = http_build_query($params);
		$params_str = array();
		foreach ($params as $key => $var) {
			$params_str[] = $key.'='.urlencode($var);
		}
		$url = 'http://beacon.x.weibo.com/a.gif?'.implode('&', $params_str); 

		/// 如果是后端上报，使用http类发http请求　，　后更改为　缓存延迟在FOOTER中输出IMG上报
		if ($way == 'http') {
/*
			$http = APP::ADP('http');
			$http->setUrl($url);
			$http->request();
*/
			if (!USER::uid()) {
				return false;
			}
			$data = CACHE::get($cache_key);
			$data[] = $url;
			CACHE::set($cache_key, $data);
			//file_put_contents('t.txt', 'set:' . $url . "\r\n", FILE_APPEND);
			return true;
		}
		return $url;
	}
	return false;
}
