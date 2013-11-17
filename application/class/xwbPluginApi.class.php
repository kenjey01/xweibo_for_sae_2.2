<?php
/**
 * @file			xwbPluginApi.class.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2011-01-25
 * @Modified By:	heli/2011-01-25
 * @Brief			发送插件api请求类
 */

class xwbPluginApi{

	var $http;
	function xwbPluginApi() 
	{
		$this->http = APP::ADP('http');
	}

	/**
	 * api调用人口
	 *
	 *
	 */
	function callRemote()
	{
		$args = func_get_args();
		$numArgs = func_num_args();
		if ($numArgs < 1) {
		
		}

		/// API接口路由
		$A = $args[0];

		if ($numArgs == 2 && is_array($args[1])) {
			$P = json_encode($args[1]);
		} else {
			array_shift($args);
			$P = json_encode($args);
		}

		$T = APP_LOCAL_TIMESTAMP;
		$F = $this->_sign($A, $P, $T);

		$result = $this->_request($A, $P, $T, $F);

		return $result;
	}

	/**
	 * 接口请求签名
	 *
	 *
	 */
	function _sign($A, $P, $T)
	{
		$sign = md5(sprintf("#%s#%s#%s#%s#%s#" , WB_AKEY, $A, $P, $T, WB_SKEY));
		return $sign;
	}
	
	/**
	 * 发送http请求
	 *
	 *
	 */
	function _request($A, $P, $T, $F)
	{
		$log_func_start_time = microtime(TRUE);
		
		$params = array();
		$params['A'] = $A;
		$params['P'] = $P;
		$params['T'] = $T;
		$params['F'] = $F;

		$this->http->setUrl(XPLUGIN_API_URL);
		$this->http->setData($params);
		$ret = $this->http->request('post');
		$info = $this->http->getHttpInfo();
		$code = $this->http->getCode();

		$logParam = array('$info'=>$info, 'params'=>$params, 'code'=>$code, 'result'=>$ret);
		LogMgr::warningLog($log_func_start_time, 'api', "[plugin]Request", LOG_LEVEL_WARNING, $logParam);
		LOGSTR('api', "[plugin]Request", LOG_LEVEL_INFO, $logParam, $log_func_start_time);
		
		return $ret;
	}
} 
