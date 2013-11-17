<?php
/**
 * @file			xPluginApi.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			xionghui <xionghui1@staff.sina.com.cn>
 * @Create Date:	2011-01-25
 * @Modified By:	heli1/2011-01-25
 * @Brief			插件API相关的控制操作
 */


class xPluginApi_mod {

	function xPluginApi_mod(){
	}
	
	//接口入口将只访问这个方法
	function request(){
		$A = V('P:A',false);
		$P = V('P:P','[]');
		$T = V('P:T',false);
		$F = V('P:F',false);
		
		if (!$this->_chkEempty($A, $T, $F)){
			APP::ajaxRst(false, '5010000', 'Parameter can not be empty');
		}

		if (!$this->_chkTimeExp($T)) {
			APP::ajaxRst(false, '5010001', 'Access time failure');
		}

		if (!$this->_chkSign($A, $P, $T, $F)) {
			APP::ajaxRst(false, '5010002', 'Signature is not correct');
		}

		return $this->_callApi($A, $P);
	}
	
	/**
	 * 检查参数是否为空
	 *
	 *
	 */	
	function _chkEempty($A, $T, $F){
		return $A && $T && $F;
	}
	
	/**
	 * 检查签名是否正确
	 *
	 *
	 */
	function _chkSign($A, $P, $T, $F){
		$K = WB_AKEY;
		$S = WB_SKEY;
		$check_F = md5(sprintf("#%s#%s#%s#%s#%s#",$K,$A,$P,$T,$S));

		return $F==$check_F;
	}
	
	/**
	 * 检查请求是否过期
	 *
	 *
	 */
	function _chkTimeExp($T){
		if ($T > APP_LOCAL_TIMESTAMP + XPLUGIN_API_TIMESTAMP) {
			return false;
		}
		return true;
	}
	
	/**
	 * 调用相应的处理方法
	 *
	 *
	 */
	function _callApi($A, $P){
		$apiCall = $this->_parseApiRoute($A);
		$instance = $this->_getInstance($apiCall['cls']);
		/// 请求的方法不存在
		if (!method_exists($instance, $apiCall['func'])) {
			APP::ajaxRst(false, '5010003', 'Request path is not correct');
		}

		$p_array = json_decode($P);
		$p_array = is_array($p_array) ? $p_array : array();
		$rst = call_user_func_array(array($instance, $apiCall['func']), $p_array);

		APP::ajaxRst($rst, '0');
	}
	
	/*
	解释API路由，并实例化对象，默认API方法为　default_api
	含有非法字符，等返回　FALSE　
	*/
	function _parseApiRoute($A){
		$route = explode('.', $A);
		$cls = $route[0];
		$f = $route[1];
		return array(
			'cls'=>$cls,
			'func'=>$f
		);
	}

	/**
	 * 获取实例
	 *
	 *
	 */
	function _getInstance($className) {
		$classFile = P_PLUGIN.'/'.$className.'.xapi.php';
		if (!file_exists($classFile) ){
			/// 类文件不存在
			APP::ajaxRst(false, '5010003', 'Request path is not correct');
			//trigger_error("class [ $className ]  is not exists in file [ $classFile ] ", E_USER_ERROR);
		}
		/// 包含类文件
		require_once($classFile);

		$cls = new $className;

		return $cls;
	}
	
	//记录错误日志
	function _log(){
		
	}
	
	function deny($m='非法访问插件API接口'){
		APP::deny($m);
	}
	
}
