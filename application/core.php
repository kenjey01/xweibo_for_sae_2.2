<?php
/**
 * @file			core.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			xionghui <xionghui1@staff.sina.com.cn>
 * @Create Date:	2010-06-08
 * @Modified By:	xionghui/2010-11-19
 * @Brief			框架核心文件
 */

class APP {
	//------------------------------------------------------------------
	function APP(){

	}
	//------------------------------------------------------------------
	/**
	 * 初始化 APP
	 * @return 无返回值
	 */                                                                  
	function init(){
		static $is_init;
		if ($is_init) {return true;}

		
		APP::_initConfig();
		APP::_globalVar();
		APP::_initRouteVar();
		
		APP::_initCheckMobile();
		APP::_aclCheck();
		APP::_initOther();
		APP::_initSkin();
		
		/// 加载语言文件
		if (ENTRY_SCRIPT_NAME == 'wap') {
			$lang_file = 'wap';
		} else {
			$wb_page_type = V('-:sysConfig/wb_page_type');
			$lang_file = 'lang'.$wb_page_type; 
		}
		APP::importLang($lang_file);

		//debug
		//V('-:sysConfig/login_way', 3, true); 
		APP::_doPreActions();
		$is_init = true;
	}
	
	function _initOther()
	{
		// 产品版本，两栏或三栏或更多
		if ( !defined('PAGE_TYPE_CURRENT') ) 
		{
			$pageType = V('-:sysConfig/'.PAGE_TYPE_SYSCONFIG, PAGE_TYPE_DEFAULT);
			define('PAGE_TYPE_CURRENT', $pageType);
		}
		
		// 是否开启用户关系本地化
		if ( !defined('XWB_PARENT_RELATIONSHIP') )
		{
			define('XWB_PARENT_RELATIONSHIP', V('-:sysConfig/open_user_local_relationship', 0) );
		}
		
		// 个性域名开关
		$isDomain = V('-:sysConfig/use_person_domain', FALSE);
		define('USED_PERSON_DOMAIN', $isDomain);
		
		//写权限排查 对数据中
		$nowRouter=APP::getRequestRoute();
		if(in_array($nowRouter,V('-:writeableCheckRouter',array()))){
				if(F('user_action_check',array(1,2,3))){
					//错误码需要统一定义
					if(defined('ENTRY_SCRIPT_NAME')&&ENTRY_SCRIPT_NAME=='wap'){
						$this->_showErr('对不起，您已经被禁止发言。', $this->_getBackURL());
					}
					else{
						if(substr($nowRouter,0,3)=='api'){
							APP::ajaxRst('',1040005,'对不起，您已经被禁止发言。');	
						}
						else{
							TPL::module('error_delete', array('msg'=>'对不起，您已经被禁止发言。') );	
						}	
					}
					exit();
				}
			}
			
		// 写日志
		register_shutdown_function('SHUTDOWN_LOGRUN');
		}
	//------------------------------------------------------------------
	/// 初始化皮肤 目录常量
	function _initSkin(){
		$user_skin_config=F('weibo_skin.getSkinPath');
		if(isset($user_skin_config['path'])){
			define('SKIN_CONSTUM_PATH',$user_skin_config['path']);
		}
		elseif(isset($user_skin_config['dir'])){
			define('SKIN_CONSTUM_DIR',$user_skin_config['dir']);
			define('SKIN_CONSTUM_STYLEID',$user_skin_config['style_id']);
		}
	}
	
	//------------------------------------------------------------------
	/// 初始化全局量 userConfig sysConfig session
	function _globalVar(){
		$GLOBALS[V_CFG_GLOBAL_NAME]['userConfig']	= USER::cfg();
		$GLOBALS[V_CFG_GLOBAL_NAME]['sysConfig']	= USER::sys();
		$GLOBALS[V_CFG_GLOBAL_NAME]['session']		= USER::get(false);
	}
	//------------------------------------------------------------------
	/// 访问控制检查
	function _aclCheck(){
		//todo
		return ;
		$entry = V('-:aclTable/E');
		// 入口控制配置不为空
		if ( is_array($entry) && !empty($entry) ){
			foreach($entry as $e){
				//todo
			}
		}

		$ips = V('-:aclTable/IP');
		// IP控制配置不为空
		if ( is_array($ips) && !empty($ips) ){
			foreach($ips as $ip){
				//todo
			}
		}
	}
	//------------------------------------------------------------------
	/// 解释路由模式为 rewrite 时的 GET 变量
	function _initRouteVar(){
		if (defined('R_FORCE_MODE')){
			define('R_MODE', R_FORCE_MODE);
		}else{
		   if (V('-:sysConfig/rewrite_enable',false)){	
				define('R_MODE',3);
			}else{
				define('R_MODE',0);
			}
		}
		

		if ( !in_array(R_MODE,array(2,3))) {return true;}

		$ss = trim(V('S:PATH_INFO',''),'/');
		if (empty($ss)) {return true;}
		if (preg_match_all("#/([a-z0-9_]+)-([^/]+)#sim",$ss,$pv)){
			foreach ($pv[1] as $i=>$ni){
				if (isset($_GET[$ni])){continue;}
				// echo " $ni => ".($pv[2][$i])."\n"; //urldecode
				$_GET[$ni] = urldecode($pv[2][$i]);
				$_REQUEST[$ni] = urldecode($pv[2][$i]);
				V('g:'.$ni, $_GET[$ni], true);
				V('r:'.$ni, $_GET[$ni], true);
			}
		}
	}
	//------------------------------------------------------------------
	
	//------------------------------------------------------------------
	/**
	 * 初始化配置
	 * @return 无返回值
	 */
	function _initConfig(){
		//　如果运行在SAE环境下　则自动创建相关常量
		if (XWB_SERVER_ENV_TYPE==='sae'){
			if (!F('sae_set_global_define')){
				DD('common/sysConfig.get');
				header("Location: sae_install/index.php");
				exit;
			}
		}
		
		// 标识当前请求是否是 API ， JS 请求，此值将决定如何输出错误信息 等
		define('IS_IN_API_REQUEST',	V(V_API_REQUEST_ROUTE,	FALSE));
		define('IS_IN_JS_REQUEST',	V(V_JS_REQUEST_ROUTE,	FALSE));
		
		// 设定时区
		if(function_exists('date_default_timezone_set')) {
			@date_default_timezone_set('Etc/GMT'.(APP_TIMEZONE_OFFSET > 0 ? '-' : '+').(abs(APP_TIMEZONE_OFFSET)));
		} else {
			putenv('Etc/GMT'.(APP_TIMEZONE_OFFSET > 0 ? '-' : '+').(abs(APP_TIMEZONE_OFFSET)));
		}
		
		
		/// 当前系统的日志文件格式
		define('P_VAR_LOG_FILE',P_VAR."/log".date("/Y_m/d/Ymd").".log.php");

		// 解释URL,定制URL相关的常量
		$protoV = strtolower(V('s:HTTPS','off'));
		$host	= V('s:HTTP_X_FORWARDED_HOST',false)
					? V('s:HTTP_X_FORWARDED_HOST') 
					: V("s:HTTP_HOST", V("s:SERVER_NAME", (V("s:SERVER_PORT")=='80' ? '' : V("s:SERVER_PORT"))));
		
		// 协议类型 http https
		define('W_BASE_PROTO',		(empty($protoV) || $protoV == 'off') ? 'http' : 'https'); 
		define('W_BASE_HTTP',		W_BASE_PROTO.'://' . $host);
		define('W_BASE_HOST',		$host);
		// 产品安装路径 如: /xweibo/  W_BASE_URL_PATH 将在安装的时候生成计算 
		define('W_BASE_URL',		defined('W_BASE_URL_PATH') ? rtrim(W_BASE_URL_PATH, '/\\').'/' : '/' );
		$fName	= basename(V('S:SCRIPT_FILENAME'));
		define('W_BASE_FILENAME',	 $fName ? $fName : 'index.php');
		
	}
	//------------------------------------------------------------------
	//------------------------------------------------------------------
	/**
	 * 初始化判断是否WAP访问
	 * @return bool true
	 */
	function _initCheckMobile(){
		if (!defined('ENTRY_SCRIPT_NAME') || ENTRY_SCRIPT_NAME != 'wap') {
			if (APP::getRequestRoute()=='output'){return true;}
			
			if (isset($_COOKIE['IS_MOBILE_AGENT']) && $_COOKIE['IS_MOBILE_AGENT'] == 0) {
				return true;
			} elseif (APP::F('is_mobile') === false) {
				setcookie('IS_MOBILE_AGENT', 0, time() + 24*3600);
			} else {
				header("Location: wap.php");
				exit;
			}
		}
		return true;
	}
	//------------------------------------------------------------------
	/**
	 * APP::request();	处理用户请求
	 * @param $halt		执行完请求后是否退出
	 * @return 无返回值
	 */
	function request($halt=false){
		APP::M(APP::getRequestRoute());
		if ($halt) exit;
	}
	//------------------------------------------------------------------
	/**
	 * APP::getRequestRoute();	从当前请求中取得模块路由信息
	 * @param $is_acc			是否以数组的形式返回
	 * @return  requestRoute
	 */
	function getRequestRoute($is_acc=false){
		//--------------------------------------------------------------
		$m = "";
		if ( R_MODE == 0 ){
			$m = APP::V("g:".R_GET_VAR_NAME);
			$m = $m ? $m : R_DEF_MOD;

		}
		//--------------------------------------------------------------
		if ( R_MODE == 1 ){
			$m = ltrim(APP::V("s:PATH_INFO")," /");
			$m = $m ? $m : R_DEF_MOD;
		}
		//--------------------------------------------------------------
		if ( R_MODE == 2 ){
			$ss = trim(V('S:PATH_INFO',''),'/');
			if (empty($ss)) {
				$m = R_DEF_MOD;
			}else{
				preg_match("#^([a-z_][a-z0-9_\./]*/|)([a-z0-9_]+)(?:\.([a-z_][a-z0-9_]*))?(?:/|\$)#sim",$ss,$mm);
				//print_r($mm);
				$m = trim($mm[0], '/');
			}
		}
		//--------------------------------------------------------------
		if ( R_MODE == 3 ){
			$m = APP::V("g:".R_GET_VAR_NAME);
			if ( empty($m) ){
				$ss = trim(V('S:PATH_INFO',''),'/');
				if (empty($ss)) {
					$m = R_DEF_MOD;
				}else{
					preg_match("#^([a-z_][a-z0-9_\./]*/|)([a-z0-9_]+)(?:\.([a-z_][a-z0-9_]*))?(?:/|\$)#sim",$ss,$mm);
					$m = trim($mm[0], '/');
				}
			}
		}
		//--------------------------------------------------------------
		if (!empty($m)) {
			if (!$is_acc) {
				return $m;
			}else{
				$r = APP::_parseRoute($m);
				return array('path'=>$r[1], 'class'=>$r[2], 'function'=>$r[3]);
			}
		}
		//--------------------------------------------------------------
		trigger_error("Unknow route type: [ ".R_TYPE." ]", E_USER_ERROR);
	}
	//------------------------------------------------------------------
	/**
	 * APP::gerRuningRoute();
	 * 获取当前正在执行的 mRoute
	 * @param $is_acc			是否以数组的形式返回
	 */
	function getRuningRoute($is_acc=false){
		$m = APP::getData('RuningRoute');
		return ($is_acc) ? $m :  $m['path'].$m['class'].".".$m['function'] ;
	}
	//------------------------------------------------------------------
	/**
	 * APP::addPreAction($doRoute, $type, $args=false);
	 * 此方法必须在 APP::init();之前执行
	 * @param $doRoute		模块路由，如 demo/index.show
	 * @param $type			模块类型，可选值为： m , f , c ; 分别表示 模块 函数 和 类库
	 * @param $args			模块所需要的参数，统一用数据传递，$type 为 m 时无效
	 * @param $except		例外模块，在这些模块中 将不执行此预处理程序 默认为空 可以是数组或者字符串
	 * @return 无返回值
	 */
	function addPreDoAction($doRoute, $type, $args=array(), $except='') {
		APP::setData($doRoute . ',' . $type, array($doRoute,$type, $args, $except), '_PreDoActions');
	}
	//------------------------------------------------------------------
	/// 处理预加载模块
	function _doPreActions() {
		$as = APP::getData(false,'_PreDoActions');
		if (empty($as) || !is_array($as)) {return true;}

		foreach($as as  $v ){
			$route	= trim($v[0]);
			$type	= strtoupper($v[1]);
			$arg	= $v[2];
			$noRun	= $v[3];
			if (!empty($noRun)){
				if (!is_array($noRun)) { $noRun = array($v[3]); }
				//print_r($noRun);exit;
				if (APP::_isIgnorePreDo($noRun)){ continue;}
			}

			switch ($type) {
				case 'M' :
					APP::M($route);
					break;
				case 'C' :
					$rData	= APP::_parseRoute($route);
					$c		= APP::N($rData[2]);
					$c->$rData[3]($arg);
					break;
				case 'F' :
					APP::F($route,$arg);
					break;
				default :
					trigger_error("Unknow preDoAction type: [ ".$type." ]", E_USER_ERROR);
					break;
			}
		}
	}
	//------------------------------------------------------------------
	/// 是否忽略指定的预处理
	function _isIgnorePreDo($ignoreArr){
		$nowRoute = APP::getRequestRoute(); 
        
		if (in_array($nowRoute,$ignoreArr)) {return true;}
		foreach($ignoreArr as $ig){
			$tig = str_replace('*', '', $ig);
			if (($nowRoute.'.'==$tig) || $tig!=$ig && strpos($nowRoute, $tig)===0 ){
				return true;
			}
		}
		return false;
	}
	//------------------------------------------------------------------
	/**
	 * APP::setData($k,$v=false,$category='STATIC_STORE');
	 * 保存一个静态全局数据
	 */
	function setData($k,$v=false,$category='STATIC_STORE'){
		if (!isset($GLOBALS[V_GLOBAL_NAME][$category]) || !is_array($GLOBALS[V_GLOBAL_NAME][$category])){
			$GLOBALS[V_GLOBAL_NAME][$category] = array();
		}
		if (is_array($k)){
			$GLOBALS[V_GLOBAL_NAME][$category] = array_merge($GLOBALS[V_GLOBAL_NAME][$category], $k);
		}else{
			$GLOBALS[V_GLOBAL_NAME][$category][$k] = $v;
		}
	}
	//------------------------------------------------------------------
	/// 重置一个静态数据分组
	function resetData($category='STATIC_STORE'){
		$GLOBALS[V_GLOBAL_NAME][$category] = array();
	}
	/**
	 * APP::getData($k=false, $category='STATIC_STORE');
	 * 获取一个静态存储数据
	 */
	function getData($k=false, $category='STATIC_STORE', $defV=NULL){
		if (!isset($GLOBALS[V_GLOBAL_NAME][$category]) || !is_array($GLOBALS[V_GLOBAL_NAME][$category])){
			return $defV;
		}
		$gV = $GLOBALS[V_GLOBAL_NAME][$category];
		return $k ? (isset($gV[$k]) ? $gV[$k] : $defV) : $gV;
	}
	//------------------------------------------------------------------
	/**
	 * APP::mkModuleUrl($mRoute, $qData=false, $entry=false);
	 * 根据模块路由，query 数据 ，入口程序，生成URL，
	 * @param $mRoute		模块路由，如 demo/index.show
	 * @param $qData		添加在URL后面的参数，可以是数组或者字符串，
	 * 						如  array('a'=>'a_var') 或者  "a=a_var&b=b_var"
	 * @param $entry		入口程序名，默认获取当前入口程序，如： index.php admin.php
	 * @return 生成的URL
	 */
	function mkModuleUrl($mRoute, $qData=false, $entry=false){
		$baseUrl	= $entry ?  W_BASE_URL.$entry : W_BASE_URL.W_BASE_FILENAME;
		$basePath	= W_BASE_URL;
		//--------------------------------------------------------------
		//锚点
		$aName = "";
		//把参数统一转换为数组
		if (!is_array($qData)){
			if (!empty($qData)){
				if (strpos($qData,'#')!==false ){
					$aName = substr($qData,strpos($qData,'#'));
					$qData = substr($qData, 0, strpos($qData,'#'));
				}
				parse_str($qData,$qData);
			}else{
				$qData = array();
			}
		}
		//--------------------------------------------------------------
		//wap URL特殊处理，增加SESSIONID
		if(ENTRY_SCRIPT_NAME == 'wap' && (!isset($_COOKIE) || empty($_COOKIE))){
			$qData[WAP_SESSION_NAME]=session_id();
		}
		//--------------------------------------------------------------
		//处理 APACHE 中 类 /index.php/sdfdsf 地址，在 ？ 之前出现 %2f 时无法使用的BUG
		//可用于 rewrite 优化的数据
		$qStr1 = "";
		//不可用于 rewrite 优化的数据 值 或者 名 中，包含 / 字符
		$qStr2 = "";
		if(!empty($qData)) {
			$kv1 = array();
			$kv2 = array();
			foreach($qData as $k=>$v){
				if (strpos($k.$v, '/') === false) {
					$kv1[] = $k . "=" . urlencode($v);
				}else{
					$kv2[] = $k . "=" . urlencode($v);
				}
			}

			$qStr1 = empty($kv1) ? "" :  implode("&", $kv1);
			$qStr2 = empty($kv2) ? "" :  implode("&", $kv2);
		}
		//--------------------------------------------------------------		
		if (R_MODE == 0 ){
			$rStr	= R_GET_VAR_NAME . '=' . $mRoute;
			if ($qStr1) $rStr.="&".$qStr1;
			if ($qStr2) $rStr.="&".$qStr2;
			return $baseUrl . '?' . $rStr . $aName;
		}
		//--------------------------------------------------------------
		if (R_MODE == 1 ){
			return empty($qData) ? $baseUrl."/" . trim($mRoute,'/ ') 
								 : $baseUrl."/" . trim($mRoute,'/ ')  ."?" . trim($qStr1.'&'.$qStr2, '& ') ;
		}
		//--------------------------------------------------------------
		if (R_MODE == 2 || R_MODE == 3 ){
			
			$rStr = $qStr1 ? preg_replace("#(?:^|&)([a-z0-9_]+)=#sim","/\\1-",$qStr1) : '/';
			$rStr .= $qStr2 ? "?".$qStr2 : '';
			return empty($qData)? $basePath. trim($mRoute,'/ ')
								: $basePath. trim($mRoute,'/ ') . $rStr ;
		}
		//--------------------------------------------------------------
		trigger_error("Unknow route type: [ ".R_MODE." ]", E_USER_ERROR);
		return false;
	}
	//------------------------------------------------------------------
	/**
	 * V($vRoute,$def_v=NULL);
	 * APP:V($vRoute,$def_v=NULL);
	 * 获取还原后的  $_GET ，$_POST , $_FILES $_COOKIE $_REQUEST $_SERVER $_ENV
	 * 同名全局函数： V($vRoute,$def_v=NULL);
	 * @param $vRoute	变量路由，规则为：“<第一个字母>[：变量索引/[变量索引]]
	 * 					例:	V('G:TEST/BB'); 表示获取 $_GET['TEST']['BB']
	 * 						V('p'); 		表示获取 $_POST
	 * 						V('c:var_name');表示获取 $_COOKIE['var_name']
	 * @param $def_v
	 * @param $setVar	是否设置一个变量
	 * @return unknown_type
	 */
	function V($vRoute,$def_v=NULL,$setVar=false){
		static $v;
		if (empty($v)){$v = array();}
		$vRoute = trim($vRoute);

		//强制初始化值
		if ($setVar) {$v[$vRoute] = $def_v;return true;}

		if (!isset($v[$vRoute])){
			$vKey = array('C'=>$_COOKIE,'G'=>$_GET,		'P'=>$_POST,'R'=>$_REQUEST,
						  'F'=>$_FILES,	'S'=>$_SERVER,	'E'=>$_ENV,
						  '-'=>$GLOBALS[V_CFG_GLOBAL_NAME]
			);
			if (empty($vKey['R'])) {
				$vKey['R'] = array_merge($_COOKIE, $_GET, $_POST);
			}
			if ( !preg_match("#^([cgprfse-])(?::(.+))?\$#sim",$vRoute,$m) || !isset($vKey[strtoupper($m[1])]) ){
				trigger_error("Can't parse var from vRoute: $vRoute ", E_USER_ERROR);
				return NULL;
			}

			//----------------------------------------------------------
			$m[1] = strtoupper($m[1]);
			$tv = $vKey[$m[1]];
			
			//----------------------------------------------------------
			if ( empty($m[2]) ) {
				$v[$vRoute] =  ($m[1]=='-' || $m[1]=='F' || $m[1]=='S' || $m[1]=='E' ) ? $tv :  APP::_magic_var($tv);
			}elseif ( empty($tv) ) {
				return  $def_v;
			}else{ 
				$vr = explode('/',$m[2]);
				while( count($vr)>0 ){
					$vk = array_shift($vr);
					if (!isset($tv[$vk])){
						return $def_v;
						break;
					}  
					$tv = $tv[$vk];
				}
			}
			$v[$vRoute] = ($m[1]=='-' || $m[1]=='F' || $m[1]=='S' || $m[1]=='E'  )  ? $tv :  APP::_magic_var($tv);
		}
		return $v[$vRoute];
	}
	//------------------------------------------------------------------
	//------------------------------------------------------------------
	/**
	 * 根据用户服务器环境配置，递归还原变量
	 * @param $mixed
	 * @return 还原后的值
	 */
	function _magic_var($mixed) {
		if( (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) || @ini_get('magic_quotes_sybase') ) {
			if(is_array($mixed))
				return array_map(array('APP','_magic_var'), $mixed);
			return stripslashes($mixed);
		}else{
			return $mixed;
		}
	}
	//-----------------------------------------------------------------
	/**
	 *
	 *用于wap的url传递session_id的session_start 包裹函数
	 *
	 *@return 无
	 */	
	
	function session_wap_init() {
		
		if($sid=V('r:'.WAP_SESSION_NAME,false)){
			//XSS
			if(!preg_match("/^[a-zA-Z0-9]{26}$/",$sid)){
				exit(-1);
			}
			session_id($sid);
		}
		session_start();
		
	}
		

	//------------------------------------------------------------------
	/**
	 * APP::redirect($mRoute,$type=1);
	 * 重定向 并退出程序
	 * @param $mRoute
	 * @param $type 	1 : 默认 ， 内部模块跳转 ,2 : 给定模块路由，通过浏览器跳转 ,3 : 给定URL  ,4 : 给定URL，用JS跳
	 * @return 无返回值
	 */
	function redirect($mRoute,$type=1){
		//if(ENTRY_SCRIPT_NAME=='wap') {}
		switch ($type){
			case 1:
				APP::M($mRoute);
				break;
			case 2:
				$url = APP::mkModuleUrl($mRoute);
				header("Location: ".$url);
				break;
			case 3:
				header("Location: ".$mRoute);
				break;
			case 4:
				
				echo '<script>window.location.href="'.addslashes($mRoute).'";</script>';
				break;
			default:
				break;
		}
		exit;
	}
	//------------------------------------------------------------------
	/**
	 * APP::F($fRoute);
	 * 执行 $fRoute 指定的函数 第二个以及以后的参数 将传递给此函数
	 * 例：APP::F('test.func',1,2); 表示执行  func(1,2);
	 * @param $fRoute 函数路由，规则与模块规则一样
	 * @return 函数执行结果
	 */
	function F($fRoute){
		static $_fTree = array();		
		$p = func_get_args();
		array_shift($p);
		
		if(isset($_fTree[$fRoute])){
			return call_user_func_array($_fTree[$fRoute],$p);
		}
		
		$cFile = APP::_getIncFile($fRoute,'func');
		require_once($cFile);
		
		$pp = preg_match("#^([a-z_][a-z0-9_\./]*/|)([a-z0-9_]+)(?:\.([a-z_][a-z0-9_]*))?\$#sim",$fRoute,$m);
		if (!$pp) { trigger_error("fRoute : [ $fRoute  ] is  invalid ", E_USER_ERROR);  return false;}
		$_fTree[$fRoute] = empty($m[3])?$m[2]:$m[3];
		if ( !function_exists($_fTree[$fRoute]) ) {
			trigger_error("Can't find function [ {$_fTree[$fRoute]} ] in file [ $cFile ]", E_USER_ERROR);
		}
		
		return call_user_func_array($_fTree[$fRoute],$p);
	}
	//------------------------------------------------------------------
	/**
	 * APP::O($oRoute);
	 * 根据类路由 和 类初始化参数获取一个单例
	 * 第二个以及以后的参数 将传递给类的构造函数
	 * 如： APP::O('test/classname','a','b'); 实例化时执行的是 new classname('a','b');
	 * @param $oRoute 类路由，规则与模块规则一样
	 * @return 类实例
	 */
	function &O($oRoute){
		static $oArr;
		if (isset($oArr[$oRoute]) && is_object($oArr[$oRoute]) ){
			return $oArr[$oRoute];
		}

		$p = func_get_args();
		array_shift($p);
		array_unshift($p,$oRoute,'cls',false);
		$oArr[$oRoute] = call_user_func_array(array('APP','_cls'),$p);
		return $oArr[$oRoute];
	}
	//------------------------------------------------------------------
	/**
	 * APP::N($oRoute);
	 * 根据类路由 和 类初始化参数获取一个类实例
	 * 第二个以及以后的参数 将传递给类的构造函数
	 * 如： APP::N('test/classname','a','b'); 实例化时执行的是 new classname('a','b');
	 * @param $oRoute 类路由，规则与模块规则一样
	 * @return 类实例
	 */
	function N($oRoute){
		$p = func_get_args();
		array_shift($p);
		array_unshift($p,$oRoute,'cls',false);
		return call_user_func_array(array('APP','_cls'),$p);
	}
	//------------------------------------------------------------------
	//对当前GET请求，生成一个唯一标识串,可以作为控制器缓存HOOK的　缓存　KEY
	function requestKey(){
		return APP::getRequestRoute()."###".md5(serialize(V('g')));
	}
	
	//控制器缓存选项　有参数时－设置，无参数时－获取
	function xcacheOpt($data=false){
		static $opt=false;
		if (func_num_args()==0){
			return $opt;
		}else{
			return $opt = $data;
		}
	}
	
	/// 收集或者 设置控制器缓存内容，有参数时收集，无参数时更新或者设置
	function xcache($buf=''){
		static $html = '';
		
		//无参数时，是 shutdown　后调用的,缓冲堆栈中的数据是倒序的
		if (func_num_args()==0){
			$noFlushHtml = '';
			$opt = APP::xcacheOpt();
			if (!is_array($opt) || !isset($opt['K']) || !isset($opt['T']) ){
				return true;
			}
			
			while (ob_get_level() > 0) {
				$noFlushHtml = ob_get_clean().$noFlushHtml;
			}
			
			CACHE::set($opt['K'], $html.$noFlushHtml, $opt['T']);
			echo $noFlushHtml;exit;			
		}else{
			$html.=$buf;
		}
		return true;
	}
	//------------------------------------------------------------------
	/**
	 * APP::M($mRoute);
	 * 执行一个模块
	 * @param $mRoute
	 * @return no nreturn
	 */
	function M($mRoute){
		$r = APP::_parseRoute($mRoute);
		APP::setData('RuningRoute',array('path'=>$r[1], 'class'=>$r[2], 'function'=>$r[3]));

		$p = func_get_args();
		array_shift($p);
		array_unshift($p,$mRoute,'mod',true);
		$m = call_user_func_array(array('APP','_cls'),$p);

		if (!is_object($m)){
			//trigger_error("Can't instance mRoute  [ $mRoute ] ", E_USER_ERROR);
			F('err404',"Can't instance mRoute  [ $mRoute ] ");
		}

		if (substr($r[3],0,1)=='_'){
			//trigger_error("Module method: [ ".$r[3]." ]  start with '_' is private !  ", E_USER_ERROR);
			F('err404',"Module method: [ ".$r[3]." ]  start with '_' is private !  ");
		}
		
		//检查缓存HOOK　HOOK方法将返回 array('K'=>'keystr'/*缓存KEY*/,'T'=>300/*缓存时间*/);
		$cacheOptFunc = X_CACHE_HOOK_PREFIX.$r[3];
		if (CTRL_CACHE_HOOK_ENABLE && method_exists($m,$cacheOptFunc)){
			$cacheOpt = $m->$cacheOptFunc();
			if ($cacheOpt===false || V('g:_no_xcache',false)){
				$cacheContent = false;
			}else{
				//检查返回
				if (!is_array($cacheOpt) || !isset($cacheOpt['K']) || !isset($cacheOpt['T']) ){
					F('err404',"Cache HOOK return data is Error, ".$r[1].$r[2].$cacheOptFunc);
				}
				$cacheContent = CACHE::get($cacheOpt['K']);
			}
			
			
			if ($cacheContent){
				echo $cacheContent;exit;
			}else{
				APP::xcacheOpt($cacheOpt);
				register_shutdown_function(array('APP','xcache'));
			}
		}
		//-------
		
		if (!method_exists($m,$r[3])){
			//trigger_error("Can't find method  [ ".$r[3]." ]  in  [ ".$r[2]." ] ", E_USER_ERROR);
			F('err404',"Can't find method  [ ".$r[3]." ]  in  [ ".$r[2]." ] ");
		}


		/// before hook
		$beforeAct = ACTION_BEFORE_PREFIX . $r[3];
		if (defined('ENABLE_ACTION_HOOK') && ENABLE_ACTION_HOOK  &&  method_exists($m,$beforeAct) ){
			$m->$beforeAct();
		}

		/// call action
		if ($r[3]!=$r[2]) { $m->$r[3]();}

		/// after hook
		$afterAct = ACTION_AFTER_PREFIX . $r[3];
		if (defined('ENABLE_ACTION_HOOK') && ENABLE_ACTION_HOOK  &&  method_exists($m,$afterAct) ){
			$m->$afterAct();
		}
	}
	//------------------------------------------------------------------
	/// 获取一个类名,在此定义类的后缀
	function _className($className, $type){
		$tCfg = array(
			'cls'=>	'',
			'mod'=>	'_mod',
			'com'=>	'',
			'pls'=> '_pls'
		);
		return isset($tCfg[$type]) ? $className.$tCfg[$type] : $className;
	}
	
	//------------------------------------------------------------------
	function &_cls($iRoute,$type,$is_single){
		static $clsArr=array();
		$iRoute = trim($iRoute);
		$type 	= trim($type);
		
		$clsKey = $type.":".$iRoute;
		if ( $is_single && isset($clsArr[$clsKey]) &&  is_object($clsArr[$clsKey]) ){
			return $clsArr[$clsKey];
		}else{

			$cFile = APP::_getIncFile($iRoute,$type);
			require_once($cFile);
			$r = APP::_parseRoute($iRoute);
			$class	= APP::_className($r[2],$type) ;
			$func	= $r[3];

			if(!class_exists ($class)){
				trigger_error("class [ $class ]  is not exists in file [ $cFile ] ", E_USER_ERROR);
			}
			$p = func_get_args();
			array_shift($p);
			array_shift($p);
			array_shift($p);
			if(!empty($p)){
				$prm = array();
				foreach($p as $i=>$v){
					$prm[] = "\$p[".$i."]";
				}
				eval("\$retClass = new ".$class." (".implode(",",$prm).");");
				if ( $is_single ) { $clsArr[$clsKey] = $retClass; }
				return $retClass;
			}else{
				if ( $is_single ) {
					$clsArr[$clsKey] = new $class;
					return $clsArr[$clsKey];
				}else{
					$c = new $class;
					return $c;
				}
			}
		}
	}
	//------------------------------------------------------------------
	function _parseRoute($route){
		/*
		static $staticRoute=array();
		if (isset($staticRoute[$route])){
			return $staticRoute[$route];
		}*/
		$route = trim($route);
		$p = preg_match("#^([a-z_][a-z0-9_\./]*/|)([a-z0-9_]+)(?:\.([a-z_][a-z0-9_]*))?\$#sim",$route,$m);
		if (!$p) { trigger_error("route : [ $route  ] is  invalid ", E_USER_ERROR);  return false;}
		if (empty($m[3])) $m[3] = R_DEF_MOD_FUNC;
		return $m;
	}
	//------------------------------------------------------------------
	/**
	 * APP::L($k);
	 * 根据语言索引返回信息信息
	 * 如果存在二个以上的参数，将以语言信息为格式 返回格式化后的字符串
	 * 如：APP::L($k,'a','b');
	 * 假设语言信息数据为 $_LANG,上例将返回 sprintf($_LANG[$k],'a','b');
	 * @param $k
	 * @return 格式化后的语言信息
	 */
	function L($k){
		if (!is_array($GLOBALS[V_GLOBAL_NAME]['LANG'])){
			trigger_error("Can't find any lang data ", E_USER_ERROR);
		}
		$s = isset($GLOBALS[V_GLOBAL_NAME]['LANG'][$k]) ? $GLOBALS[V_GLOBAL_NAME]['LANG'][$k] : false;
		if (!$s) {
			return false;
		}
		$p = func_get_args();
		array_shift($p);
		if (!empty($p)){
			array_unshift($p,$s);
			$s = call_user_func_array('sprintf',$p);
		}
		return $s;
	}
    
    /**
    * 获取当前系统使用的语言
    * 
    * @param mixed $ext
    */
    function getLang(){
        $lang = V('-:sysConfig/wb_lang_type');
        return $lang ? $lang : SITE_LANG;
    }
    
	//------------------------------------------------------------------
	/**
	 * APP::importLang($lRoute);
	 * 导入一个语言信息文件
	 * @param $lRoute	语言信息路由 规则与模块路由一样
	 * @return 成功 true 失败 false;
	 */
	function importLang($lRoute, $ext = false){
		$ext = $ext ? $ext : APP::getLang();
		if (!defined('WB_LANG_TYPE_CSS')) {
			if ($ext == 'zh_cn') {
				define('WB_LANG_TYPE_CSS', '');
			} else {
				define('WB_LANG_TYPE_CSS', $ext);
			}
		}
		$lf = APP::_getIncFile($lRoute,'lang', $ext);
		include_once $lf;
		if (!is_array($_LANG)){
			trigger_error("Can't find lang array var \$_LANG in file [ $lf ] ", E_USER_ERROR);
		}


		$g = &$GLOBALS[V_GLOBAL_NAME];
		if(!isset($g['LANG']) ||  !is_array($g['LANG']) ){
			$g['LANG'] = array();
		}
		foreach($_LANG as $k=>$v){
			$g['LANG'][$k]=$v;
		}
		return true;
	}
	//------------------------------------------------------------------
	/**
	 * APP::functionFile($fRoute);
	 * 根据函数路由取得文件路径
	 * @param $fRoute	函数路由
	 * @return 函数文件路径
	 */
	function functionFile($fRoute){
		return APP::_getIncFile($fRoute,'func');
	}
	//------------------------------------------------------------------
	/**
	 * APP::classFile($fRoute);
	 * 根据类路由取得文件路径
	 * @param $fRoute	类路由
	 * @return 类文件路径
	 */
	function classFile($fRoute){
		return APP::_getIncFile($fRoute,'cls');
	}
	//------------------------------------------------------------------
	/**
	 * APP::moduleFile($fRoute);
	 * 根据模块路由取得文件路径
	 * @param $fRoute	模块路由
	 * @return 模块文件路径
	 */
	function moduleFile($fRoute){
		return APP::_getIncFile($fRoute,'mod');
	}
	//------------------------------------------------------------------
	/**
	 * APP::tplFile($fRoute,$baseSkin=true);
	 * 根据模板路由取得文件路径
	 * @param $fRoute	模板路由
	 * @param $baseSkin	模板基准目录选项，默认为 true ，将使用系统配置的皮肤目录
	 * @return 模板文件路径
	 */
	function tplFile($fRoute,$baseSkin=true){
		return APP::_getIncFile($fRoute,'tpl',$baseSkin);
	}
	//------------------------------------------------------------------
	/**
	 * APP::comFile($fRoute);
	 * 根据数据组件的路由取得文件路径
	 * @param $fRoute	数据组件的路由
	 * @return 文件路径
	 */
	function comFile($fRoute){
		return APP::_getIncFile($fRoute,'com');
	}
	//------------------------------------------------------------------
	/**
	 * APP::adpFile($name,$type);
	 * 根据适配器的名称和类型取得文件路径
	 * @param $name	适配器名称如： db http cache io 等
	 * @param $name	适配器类型如： db 可能的类型有： mysql access mssql 等
	 * @return 模板文件路径
	 */
	function adpFile($name,$type){
		if ( !preg_match("#^[a-z_][a-z0-9_]*\$#sim",$name) ){
			trigger_error("Adapter name [ ".$name." ] is invalid ", E_USER_ERROR);
		}
		if ( !preg_match("#^[a-z_][a-z0-9_]*\$#sim",$type) ){
			trigger_error("Adapter type [ ".$type." ] is invalid ", E_USER_ERROR);
		}
		return P_ADAPTER."/".$name."/".$type."_".$name.EXT_ADAPTER;
	}
	//------------------------------------------------------------------
	/**
	 * APP::ADP ($name,$is_single=true,$cfg=false);
	 * 根据配置，获取一个适配器实例，使用配置信息初始化
	 * @param $name			适配器名称如： db 类型由配置文件中确定
	 * @param $is_single	是否获取单例
	 * @param $cfg			初始化此适配器的配置数据，默认从配置中取
	 * @return 相应的适配器实例
	 */
	function ADP ($name,$is_single=true,$cfg=false){
		$type		= APP::V('-:adapter/'.$name);
		if (empty($type)){
			trigger_error("Can't find  adapter config data  : \$GLOBALS['".V_CFG_GLOBAL_NAME."']['adapter']['{$name}']  ",
						  E_USER_ERROR);
		}

		$cfgData 	= $cfg ? $cfg : APP::V('-:adapter_cfg/'.$name.'/'.$type);
		return APP::adapter($name,$type,$is_single,$cfgData);
	}
	//------------------------------------------------------------------
	/**
	 * APP::adapter ($name,$type,$is_single=true,$cfgData=false);
	 * 通用的适配器获取方法
	 * @param $name			适配器名称
	 * @param $type			适配器类型
	 * @param $is_single	是否获取单剑
	 * @param $cfgData		适配器初始化参数
	 * @return 相应的适配器实例
	 */
	function &adapter ($name,$type,$is_single=true,$cfgData=false){
		static $adpClass;
		$class = $type."_".$name;

		if (isset($adpClass[$class]) && is_object($adpClass[$class]) && $is_single){
			return $adpClass[$class];
		}

		$cFile = APP::adpFile($name,$type);
		if (!file_exists($cFile)){
			trigger_error("Can't adapter file [ $cFile ] ", E_USER_ERROR);
		}

		require_once($cFile);
		if(!class_exists ($class)){
			trigger_error("class [ $class ]  is not exists in file [ $cFile ] ", E_USER_ERROR);
		}

		$c = new $class;
		$iniFunc = ADP_INIT_FUNC ;

		//var_dump($cfgData);
		if(method_exists($c,$iniFunc)){
			$c->$iniFunc($cfgData);
		}

		if ($is_single){
			$adpClass[$class] = $c;
		}
		return $c;
	}
	//------------------------------------------------------------------
	/// 获取一个包含文件的路径 
	/// 当 $type 为 tpl  时 $ext 是指定模板目录，默认为系统配置的文件模板目录
	/// 当 $type 为 lang 时 $ext 是语言目录，默认为系统配置的语言目录
	function _getIncFile($fRoute,$type='cls',$ext=""){
		if ( !APP::_chkPath($fRoute) ){
			trigger_error("file route: [ $fRoute  - $type  ] is  invalid ", E_USER_ERROR);
		}
		$tpldir		= ($type=='tpl'  &&  $ext===true) ?  SITE_SKIN_TPL_DIR."/" : trim($ext,'/\\ ') . '/';
		$langdir	= ($type=='lang' &&  !empty($ext)) 	? $ext : SITE_LANG;

		$m 	  = APP::_parseRoute($fRoute);
		$fp   = $m[1].$m[2];
		$type = strtolower($type);
		
		// 只有需要支持多模板的时候才运行,多模板tpl,pls,mod
		if ($ext===true && isset($GLOBALS[V_GLOBAL_NAME]['MIX_TPL']) && in_array($type, array('tpl','pls','mod'))) 
		{
			$tpl = P_TEMPLATE."/".PAGE_TYPE_CURRENT.'/'.$fp.EXT_TPL;
			if (file_exists($tpl)) {
				return $tpl;
			}
			F('err404',"file:[ ". $tpl ." ] not exists  ");
/*
			$f = array( 'tpl'  => array('default'=>P_TEMPLATE."/".$tpldir.$fp.EXT_TPL, 'current'=>P_TEMPLATE."/".PAGE_TYPE_CURRENT.'/'.$fp.EXT_TPL),
				   		'pls'  => array('default'=>P_PLS."/".$fp.EXT_PLS, 'current'=>P_PLS."/".PAGE_TYPE_CURRENT.'/'.$fp.EXT_PLS),
				   		'mod'  => array('default'=>P_MODULES."/".$fp.EXT_MODULES, 'current'=>P_MODULES."/".PAGE_TYPE_CURRENT.'/'.$fp.EXT_MODULES)
			);
			
			// 先查找系统设置的模板，再找默认路径的模板
			if ( file_exists($f[$type]['current']) ){
				return $f[$type]['current'];
			}
			if ( file_exists($f[$type]['default']) ){
				return $f[$type]['default'];
			}

			F('err404',"file:[ ".$f[$type]['current']." or ".$f[$type]['default']." ] not exists  ");
			*/
		}
		
		// 正常一般时运行，例如安装程序、后台等
		$f = array('tpl'  => P_TEMPLATE ."/".$tpldir . $fp . EXT_TPL,
				   'cls'  => P_CLASS ."/" . $fp . EXT_CLASS,
				   'pls'  => P_PLS ."/" . $fp . EXT_PLS,
				   'mod'  => P_MODULES ."/" . $fp . EXT_MODULES,
				   'func' => P_FUNCTION . "/" . $fp . EXT_FUNCTION,
				   'com'  => P_COMS . "/" . $fp . EXT_COM,
				   'lang' => P_LANG . "/" . $langdir . "/" . $fp . EXT_LANG
		);
		///echo $f[$type];
		if ( !isset($f[$type]) ){
			trigger_error("file type: [ $type  ] is  invalid ", E_USER_ERROR);
		}
		if ( !file_exists($f[$type]) ){
			F('err404',"file:[ ".$f[$type]." ] not exists  ");
		}
		return $f[$type];
	}
	//------------------------------------------------------------------
	function _chkPath($v){
		return count(explode("..",$v))== 1 && preg_match("#^[a-z_][a-z0-9_/\.]*\$#sim",$v);
	}
	//------------------------------------------------------------------
	/**
	 * APP::LOG ($msg);
	 * 根据配置信息将 $msg 信息写入日志文件 默认在 /var/log/
	 * @param $msg		日志信息
	 * @param $type		日志类型，如　error　默认为 log
	 * @return	是否写成功
	 */
	function LOG ($msg,$type=false) {
		if (strtolower(XWB_SERVER_ENV_TYPE)!='common' || !LOG_LEVEL ) {return false;}
		
		$log_file = $type ?  substr(P_VAR_LOG_FILE,0,-7).$type.".php" : P_VAR_LOG_FILE ;
		$msg = sprintf("[%s]:\t%s\r\n",date("Y-m-d H:i:s"),$msg);
		if (!file_exists($log_file)){
			$msg = "<?php  ".IS_IN_APPLICATION_CODE." ?> \r\n\r\n".$msg;
		}

		IO::write($log_file, $msg, true);
	}
	//------------------------------------------------------------------
	//todo...
	function debug(){
		
	}
	//------------------------------------------------------------------
	function trace($node, $output=true, $exit=false) {
		$e = array('class'=>'', 'type'=>'', 'function'=>'');
		$trace			= debug_backtrace();
		$bPathLen		= strlen(dirname(P_ROOT));
		$traceInfo		= '';
		foreach($trace as $i=>$t) {
			$t = array_merge($e, $t);
			$traceInfo .= '['.sprintf("%02d", $i+1).'] '.substr($t['file'], $bPathLen+1).' (Line:'.$t['line'].') ';
			$traceInfo .= $i==0 ? '' :  $t['class'].$t['type'].$t['function'].'('.json_encode($t['args']).')';
			$traceInfo .="<br/>";
		}
		$traceInfo = 'Trace node : '.$node.'<br/>'.$traceInfo;
		if ($output){
			echo $traceInfo;
		}
		if ($exit){
			exit;
		}
		return $traceInfo;
	}
	//------------------------------------------------------------------

	/**
	 * APP::ajaxRst($rst,$errno=0,$err='');
	 * 通用的 AJAX 或者  API 输出入口
	 * 生成后的JSON串结构示例为：
	 * 成功结果： {"rst":[1,0],"errno":0}
	 * 失败结果 ：{"rst":false,"errno":1001,"err":"access deny"}
	 * @param $rst
	 * @param $errno 	错误代码，默认为 0 ，表示正常执行请求， 或者 >0 的 5位数字 ，1 开头的系统保留
	 * @param $err		错误信息，默认为空
	 * @param $return	是否直接返回数据，不输出
	 * @return unknown_type
	 */
	function ajaxRst($rst,$errno=0,$err='', $return = false){
		$r = array('rst'=>$rst,'errno'=>$errno*1,'err'=>$err);
		if ($return) {
			return json_encode($r);
		}
		else {
			header('Content-type: application/json');
			echo json_encode($r);exit;
		}
	}
	//------------------------------------------------------------------
	
	///todo
	function JSONP($rst, $errno=0,$err='', $callback='callback', $script=''){
		echo "<script language='javascript'>{$callback}(".json_encode(array('rst'=>$rst,'errno'=>$errno*1,'err'=>$err)).");".$script."</script>";
	}
	//------------------------------------------------------------------
	///todo
	function ACL(){
	}
	//------------------------------------------------------------------
	function deny($info=''){
		header("HTTP/1.1 403 Forbidden");
		exit('Access deny'.$info);
	}
	//------------------------------------------------------------------
	/**
	 * APP::tips($params,$display = true);
	 * 显示一个消息，并定时跳转
	 * @param $params Array
	 * 		['msg'] 显示消息,
	 * 		['location'] 跳转地址,
	 * 		['timeout'] = 3 跳转时长 ,0 则不跳转 此时 location 无效
	 * 		['tpl'] = '' 使用的模板名,
	 * 		如果$params不是数组,则直接当作 $params['msg'] 处理
	 * @param $display boolean 是否即时输出
	 */
	function tips($params,$display = true) {
		static $msg=array();
		if (!is_array($params)) {
			$params = array('msg' => $params);
		}

		if (isset($params['msg']) && is_array($params['msg'])) {
			foreach($params['msg'] as $v) {
				$msg[] = $v;
			}
		} elseif(isset($params['msg'])) {
			$msg[] = $params['msg'];
		}
		
		if ($display) {
			$params['msg'] = $msg;
			$defParam = array('timeout'=>0, 'location'=>'', 'lang'=>'', 'baseskin'=>true, 'caching'=>'','tpl'=>'');
			$params = array_merge($defParam, $params);

			$time	= $params['timeout']*1;
			$url	= $params['location'];
			if($time) {
				header("refresh:{$time};url=".$url);
			}

			if ($params['tpl']) {
				if (in_array($params['tpl'], array('e403', 'e404'))) {
					APP::F('err404', implode('<br />', $params['msg']));
				} else if (in_array($params['tpl'], array('error', 'error_busy', 'error_force', 'error_rest'))) {
					APP::F('error', implode('<br />', $params['msg']));
				} else {
					TPL::assign($params);
					if (!isset($params['baseskin'])) {
						$params['baseskin'] = true;
					}
					TPL::display($params['tpl'], $params['lang'], $params['caching'], $params['baseskin']);
				}
				exit;
			} else {
				if($time) {
					echo "<meta http-equiv='Refresh' content='{$time};URL={$url}'>\n";
				}
				echo implode('<br />', $params['msg']);
			}
			exit;
		}
	}
	//------------------------------------------------------------------
}
//----------------------------------------------------------------------
/**
 * 请在模板文件第一行加入： if(!defined("IN_APPLICATION")) { exit("Access Denied"); }
 */
class TPL {
	//------------------------------------------------------------------
	function TPL(){}
	//------------------------------------------------------------------
	/**
	 * TPL::reset();
	 * 重置模板变量列表
	 * @return 无返回值
	 */
	function reset(){
		$GLOBALS[V_GLOBAL_NAME]['TPL'] = array();
	}
	//------------------------------------------------------------------
	/**
	 * TPL::assign($k,$v=null);
	 * 给模板变量赋值，类似SMARTY
	 * 使用实例：
	 * TPL::assign('var_name1','var'); 在模板中可以使用  $var_name1 变量
	 * TPL::assign(array('var_name2'=>'var')); 在模板中可以使用  $var_name2 变量
	 * @param $k	当  $k 为字串时 在模板中 可使用以 $k 命名的变量 其值 为 $v
	 * 				当  $k 为关联数组时 在模板中可以使用 $k 的所有索引为变量名的变量
	 * @param $v	当  $k 为字符串时 其值 即为 模板中 以  $k 为名的变量的值
	 * @return 无返回值
	 */

	function assign($k,$v=null){
		if ( !isset($GLOBALS[V_GLOBAL_NAME]['TPL']) || !is_array($GLOBALS[V_GLOBAL_NAME]['TPL']) ) {
			$GLOBALS[V_GLOBAL_NAME]['TPL'] = array();
		}
		if (!is_array($k)){
			$GLOBALS[V_GLOBAL_NAME]['TPL'][$k] = $v;
		}else{
			TPL::assignExtract($k);
		}
	}
	//------------------------------------------------------------------
	/**
	 * TPL::assignExtract($data);
	 * 给模板变量赋值
	 * @param $data	关联数组
	 * @return 无返回值
	 */
	function assignExtract($data){
		if ( !isset($GLOBALS[V_GLOBAL_NAME]['TPL']) || !is_array($GLOBALS[V_GLOBAL_NAME]['TPL']) ) {
			$GLOBALS[V_GLOBAL_NAME]['TPL'] = array();
		}

		foreach($data as $k=>$v){
			$GLOBALS[V_GLOBAL_NAME]['TPL'][$k] = $v;
		}
	}
	//------------------------------------------------------------------
	/**
	 * TPL::display($_tpl, $_langs=array(), $_ttl=0, $_baseSkin=true);
	 * 显示一个模板
	 * @param $_tpl		模板路由
	 * @param $_langs	语言包，可以是半角逗号隔开的列表，也可以是数组
	 * @param $_ttl		缓存时间 单位秒 （ 未实现 ）
	 * @param $_baseSkin	模板基准目录选项，默认为 true ，将使用系统配置的皮肤目录
	 * @param $_isPipe		是否使用PIPE
	 * @return 无返回值
	 */
	function display($_tpl, $_langs=array(), $_ttl=0, $_baseSkin=true, $_isPipe=true){
		if ( !empty($_langs) ){
			if ( !is_array($_langs) ){
				$_langs = explode(",", $_langs);
			}
			foreach ($_langs as $t){
				if(!empty($t)){
					APP::importLang($t);
				}
			}
		}
		
        if (is_array($GLOBALS[V_GLOBAL_NAME]['TPL'])) {
			extract($GLOBALS[V_GLOBAL_NAME]['TPL'], EXTR_SKIP);
		}
		include APP::tplFile( $_tpl, $_baseSkin );
		
		// 只有需要xpipe的时候才运行
		if ($_isPipe && isset($GLOBALS[V_GLOBAL_NAME]['NEED_XPIPE'])) {
			Xpipe::run();
		}
	}
	//------------------------------------------------------------------
	/**
	 * TPL::fetch($tpl,$langs=array(),$ttl=0, $tplDir="");
	 * 获取一个模板解释完后的内容
	 * @param $tpl		模板路由
	 * @param $langs	语言包，可以是半角逗号隔开的列表，也可以是数组
	 * @param $ttl		缓存时间 单位秒 （ 未实现 ）
	 * @param $baseSkin	模板基准目录选项，默认为 true ，将使用系统配置的皮肤目录
	 * @return 模板解释完后的内容，字符串
	 */
	function fetch($tpl, $langs=array(), $ttl=0, $baseSkin=true){
		ob_start();
		TPL::display($tpl,$langs,$ttl, $baseSkin, false);
		$data = ob_get_clean();
		return $data;
	}
	//------------------------------------------------------------------
	/**
	 * 输出或者获取一个 HTML 插件
	 * @param $___arg_tpl		模板路由
	 * @param $args		插件变量，是一个关联数组，在插件模板中，数组的下标即是变量名
	 * @param $___arg_baseSkin	模板基准目录选项，默认为 true ，将使用系统配置的皮肤目录
	 * @param $___arg_output	是否直接输出插件HTML代码，当其为FALSE时，返回插件内容	
	 * @return  相应的 HTML  插件代码
	 */
	function plugin($___arg_tpl, $args=array(), $___arg_baseSkin=true, $___arg_output=true){
		if (is_array($args)){
			extract($args, EXTR_SKIP);
		}
		if ($___arg_output){
			include APP::tplFile($___arg_tpl, $___arg_baseSkin);
		}else{
			ob_start();
			include APP::tplFile($___arg_tpl, $___arg_baseSkin);
			$data = ob_get_clean();
			return $data;
		}
	}
	
	function module($___arg_tpl, $args=array(), $___arg_output=true){
		// 防止被 $args 覆盖
		$___arg_baseSkin = 'modules';
		if (is_array($args)){
			extract($args, EXTR_SKIP);
		}
		if ($___arg_output){
			include APP::tplFile($___arg_tpl, $___arg_baseSkin);
		}else{
			ob_start();
			include APP::tplFile($___arg_tpl, $___arg_baseSkin);
			$data = ob_get_clean();
			return $data;
		}
	}
}
//----------------------------------------------------------------------
/**
* 类BigPipe的管道输出控制类
*/
class Xpipe {
	function Xpipe(){
	}
	/**
	* 新建一个 pagelet
	* 
	* @param mixed $r	pagelet 的路由
	* @param mixed $p	传递给 pagelet 的参数
	* @param mixed $o	执行顺序,如果为 false则符合先进先出的规则，返之，数据大的先执行
	* @param mixed $isPerch 是否输出占位标签,非占位pagelet可用
	*/
	function pagelet($r, $p=array(), $o=false,$isPerch=true){
		static $ost= 1000000,$custom_st = 1000001,$ki=10000;
		$ki++;
		$k =  $o==false ? $ost-- : $custom_st+$o;		
		//echo $k,"-",$ost,"\n";
		$GLOBALS[V_GLOBAL_NAME]['PAGELETS'][$k] = array($r, $p, $ki,$isPerch);
		if ($isPerch){
			Xpipe::_perchLable($ki,$r);
		}
	}
	
	/**
	* 占位标签,用于确定模块要显示的位置
	*/
	function _perchLable($k,$r){
		echo sprintf("<div class='hidden' id='%s' xRoute='%s' ></div>",Xpipe::_idKey($k),$r);
	}
	///　生成一个占位标签的　ID
	function _idKey($k){
		return 'XpipeModule_'.$k;
	}
	
	/**
	* 当前是否正在运行PIPE
	* 
	* @param mixed $run
	*/
	function isRunning($run=false){
		static $isRun = false;
		if ($run) $isRun = $run;
		return $isRun ;
	}
	
	//当前请求是否使用 PIPE ，默认使用
	function usePipe($state=true){
		static $isUse = true;
		if (func_num_args()){
			$isUse = $state;
		}
		return $isUse;
	}
	
	/**
	* 一次管道输出，某个子模块运算完成,通知前端处理相关逻辑
	* 
	* @param mixed	$rst
	* @param string JS端统一调用的管道方法
	* @return		无返回，输出一段 script　到缓冲并输出
	*/
	function output($rst, $jsFunc='load'){
		$s = sprintf("\n<script>%s.%s(%s);</script>", V_JS_XPIPE_OBJ, $jsFunc, json_encode($rst));
		//将布局缓冲输出到客户端
		if (APP::xcacheOpt()){
			APP::xcache($s);
		}
		
		echo $s;
		unset($s);
		@flush();
	}
	
	/**
	* 执行管道队列中的相关子模块
	*/
	function run(){
		if (!Xpipe::usePipe()){
			return false;
		}
		
		//将布局缓冲输出到客户端
		if (APP::xcacheOpt()){
			APP::xcache(ob_get_flush());
		}else{
			@ob_end_flush();
		}
		
		Xpipe::_start();
		
		$pls = Xpipe::_getAndCleanPagelets();
		if (!$pls || !is_array($pls)){
			Xpipe::_end();
			return false;
		}
		//print_r($pls);exit;
		
		
		while(count($pls)>0){
			$pl		= array_shift($pls);
			$rst	= Xpipe::runOnePagelet($pl);
			//输出SCRIPT到缓冲
			Xpipe::output($rst);
			
			//检查是否存在子管道，并插入到当前队列的最开始,避免使用递归
			$child_pls = Xpipe::_getAndCleanPagelets();
			if ($child_pls && is_array($child_pls)) {
				//print_r($pls);print_r($child_pls);exit;
				$pls = array_merge($child_pls, $pls);
				
			}
		}
		Xpipe::_end();
	}
	
	/**
	* 执行一个管道模块
	* @param mixed $pl
	*/
	function runOnePagelet($pl){
		//sleep(2);
		ob_start();
		list($r, $p, $k,$isPerch) = $pl;
		$plObj	= APP::_cls($r,'pls',true);
		$rArr	= APP::_parseRoute($r);
		//print_r($rArr);
		$data = $plObj->$rArr[3]($p);
		$pl_content = ob_get_clean();

		return array(
				'html'=>$pl_content,
				'pagelet'=>$r,
				'perch'=>$isPerch,
				'id'=>Xpipe::_idKey($k),
				'data'=>$data
				);
	}
	
	
	//管道开始
	function _start(){
		Xpipe::isRunning(true);
		//初始化的全局配置量
		$iniCfg = array(
			'basePath'	=> W_BASE_URL,'routeMode'=>R_MODE,'routeVname'=>R_GET_VAR_NAME,'akey'=>WB_AKEY,
			'shortLink'	=> V('-:sysConfig/site_short_link', ''),
			'loginCfg'	=> V('-:sysConfig/login_way', 1),
			'webName'	=> V("-:sysConfig/site_name"),
			'uid'		=> USER::uid(),
			'siteUid'	=> USER::get('site_uid'),
			'siteUname'	=> USER::get('site_uname'),
			'siteName'	=> USER::get('site_name'),
			'siteReg'	=> V('-:siteInfo/reg_url'),
			'sinaReg'	=> URL('account.goSinaReg'),
			'page'		=> APP::getRequestRoute(),
			'remind'	=> /*V('-:userConfig/user_newfeed')*//*intval(PAGE_TYPE_CURRENT) === 1 ? 0 : 1*/0,
			'maxid'		=> CACHE::get(USER::uid() . '_maxid')
		);
		
		Xpipe::output($iniCfg, 'start');
	}
	
	//管道结束
	function _end(){
		Xpipe::output(true, 'end');
		Xpipe::isRunning(false);
	}
	
	/**
	* 记取当前　pagelet　队列，并清空
	* @return	如果没有 pagelet　队列　则返回 false　，　如有则返回 pagelets数据
	*/
	function _getAndCleanPagelets(){
		$ret = $GLOBALS[V_GLOBAL_NAME]['PAGELETS'];
		$GLOBALS[V_GLOBAL_NAME]['PAGELETS'] = array();
		if (!empty($ret) && is_array($ret)) {
			krsort($ret);
			return $ret;	
		}else{
			return false;
		}
		return empty($ret) ? false : $ret;		
	}
	
	//调试，查看变量
	function debug($var){
		echo '<pre style="color:green; border: 1px solid green;padding: 5px;">Xpipe变量跟踪：'."\n";
		var_dump($var);
		echo '</pre>';
	}
}

//----------------------------------------------------------------------
/**
 * 获取一个变量值  APP::V 的同名函数
 * @param $vRoute	变量路由
 * @param $def		默认值
 * @return 			变量值
 */
function V($vRoute, $def=NULL, $setVar=false){
	return APP::V($vRoute, $def, $setVar);
}
//----------------------------------------------------------------------
/// copydoc APP::L
function L(){
	$p = func_get_args();
	return call_user_func_array(array('APP','L'), $p);
}
//----------------------------------------------------------------------
function LO(){
	$p = func_get_args();
	echo call_user_func_array(array('APP','L'), $p);
}
//----------------------------------------------------------------------
/// copydoc APP::F
function F(){
	$p = func_get_args();
	return call_user_func_array(array('APP','F'), $p);
}
//----------------------------------------------------------------------
/**
 * 获取一个url APP::mkModuleUrl 的同名函数
 * @param $mRoute	模块路由
 * @param $qData	URL 参数可以是字符串如 "a=xxx&b=ooo" 或者数组 array('k'=>'k_var')
 * @param $entry	模块入口 默认为当前入口，可指定入口程序 如 admin.php
 * @return 			URL
 */
function URL($mRoute, $qData=false, $entry=false){
	return APP::mkModuleUrl($mRoute, $qData, $entry);
}
/**
* 生成WAP兼容的URL页面链接
* 
* @param mixed $mRoute
* @param mixed $qData
* @param mixed $entry
* @return mixed
*/
function WAP_URL($mRoute, $qData=false, $entry=false){
	$url = APP::mkModuleUrl($mRoute, $qData, $entry);
	return htmlspecialchars($url, ENT_QUOTES);
}




//----------------------------------------------------------------------
/// cache
class CACHE {
	//------------------------------------------------------------------
	function CACHE (){}
	//------------------------------------------------------------------
	/**
	 * CACHE::getInstance();
	 * 获取当前缓存适配器的实例
	 * @return unknown_type
	 */
	function &getInstance(){
		return APP::ADP('cache',false);
	}
	//------------------------------------------------------------------
	function &instance(){
		static $c;
		if(empty($c)) {
			$c =& APP::ADP('cache');
		}
		return $c;
	}
	//------------------------------------------------------------------
	/**
	 * CACHE::get($key);
	 * 获取缓存
	 * @param $key		缓存存储的 KEY
	 * @return 如果缓存存在并未过期则返回缓存值 ，否则返回   false
	 */
	function get($key) {
		//echo "\nGET:".$key."\n";
		$c = & CACHE::instance();
		return $c->get($key);
	}
	//------------------------------------------------------------------
	/**
	 * CACHE::set($key, $value, $ttl = 0) ;
	 * 保存一个缓存
	 * @param $key		缓存  key
	 * @param $value	缓存值
	 * @param $ttl		有效时间 ，单位：秒
	 * @return 失败返回  false
	 */
	function set($key, $value, $ttl = 0) {
		//echo "\nSET:".$key."\n";
		$c = & CACHE::instance();
		return $c->set($key, $value, $ttl);
	}
	//------------------------------------------------------------------
	/**
	 * CACHE::delete($key);
	 * 删除一个缓存
	 * @param $key	缓存  KEY
	 * @return 失败返回 false
	 */
	function delete($key) {
		$c = & CACHE::instance();
		return $c->delete($key);
	}
	//------------------------------------------------------------------
	/**
	 * CACHE::gSet($gName, $key, $value, $ttl = 0);
	 * 建立一个缓存组
	 * @param $gName	缓存组名称
	 * @param $id		缓存组中的ID
	 * @param $ttl		有效时间 ，单位：秒
	 * @return 失败返回 false
	 */
	
	function gSet($gName, $id, $value, $ttl = 0){
		//echo "CACHE GSET [$gName, $id, $ttl] \n";
		$gKey = GROUP_CACHE_KEY_PRE.' '.trim($gName);
		$vKey = $gKey.' '.trim($id);
		$gVer = CACHE::get($gKey);
		if (!$gVer){
			$gVer =APP_LOCAL_TIMESTAMP.'_'.rand(1000000,9999999);
			//echo "SET GKEY: $gKey = $gVer \n";
			CACHE::set($gKey , $gVer, 0);
		}
		$gData = array('v'=>$value, 'ver'=>$gVer);
		return CACHE::set($vKey, $gData, $ttl);
	}
	/**
	 * CACHE::gGet($gName, $id);
	 * 获取某个缓存组中的缓存
	 * @param $gName	缓存组名称
	 * @param $id		缓存组中的ID
	 * @return 失败返回 false
	 */
	function gGet($gName, $id){
		//echo "CACHE GGET [$gName, $id] \n";
		$gKey = GROUP_CACHE_KEY_PRE.' '.trim($gName);
		$vKey = $gKey.' '.trim($id);
		$gVer = CACHE::get($gKey);
		//echo "GET GKEY: #$gKey# = #$gVer# \n";
		if($gVer){
			$gData = CACHE::get($vKey);
			if (is_array($gData) && $gData['ver']==$gVer){
				return 	$gData['v'];
			}else{
				//echo "CACHE : [$gName, $id] expired\n";
			}
		}
		CACHE::delete($vKey);
		return false;
	}
	/**
	 * CACHE::gDelete($gName);
	 * 删除某个缓存组
	 * @param $gName	缓存组名称
	 * @return 失败返回 false
	 */
	function gDelete($gName){
		$gKey = GROUP_CACHE_KEY_PRE.' '.trim($gName);
		return CACHE::delete($gKey);
	}

	/**
	 * 目前只有SAE下可以使用
	 *
	 */
	function flush() {
		if (XWB_SERVER_ENV_TYPE!=='sae'){
			return false;
		}
		$c = & CACHE::instance();
		return $c->flush();
	}
}
//----------------------------------------------------------------------
class IO {
	//------------------------------------------------------------------
	function IO (){}
	//------------------------------------------------------------------
	/**
	 * IO::getInstance();
	 * 获取当前IO适配器实例
	 * @return IO 实例
	 */
	function getInstance(){
		return APP::ADP('io',false);
	}
	//------------------------------------------------------------------
	function &instance(){
		static $c;
		if(empty($c)) {
			$c = APP::ADP('io');
		}
		return $c;
	}
	//------------------------------------------------------------------
	/**
	 * IO::ls($path,$r=false,$info=false);
	 * 获取某个目录的文件列表
	 * @param $path		要处理的目录
	 * @param $r		是否递归子目录
	 * @param $info		是否获取每个文件的文件信息
	 * @return 文件信息列表
	 */
	function ls($path,$r=false,$info=false){
		$c = & IO::instance();
		return $c->ls($path,$r,$info);
	}
	//------------------------------------------------------------------
	/**
	 * IO::write($file,$contents,$append=false);
	 * 写入一个文件
	 * @param $file			目标文件路径，如果目录结构不存在则自动创建
	 * @param $contents		文件内容
	 * @param $append		是否将内容追加到文件末尾，默认为 false 重写文件
	 * @return 写入字节数 失败返回 false
	 */
	function write($file,$contents,$append=false) {
		$c = & IO::instance();
		return $c->write($file,$contents,$append);
	}
	/**
	 * IO::read($file);
	 * @param $file		目标文件路径
	 * @return 如果文件存在，返回内容 反之返回 false
	 */
	function read($file) {
		$c = & IO::instance();
		return $c->read($file);
	}
	/**
	 * IO::mkdir($path);
	 * 生成目录结构，创建目录
	 * @param $path		目录结构
	 * @return 成功返回 true 失败返回 false
	 */
	function mkdir($path) {
		$c = & IO::instance();
		return $c->mkdir($path);
	}
	/**
	 * IO::rm($path);
	 * 删除一个路径，如果是目录则删除它的子目录以及文件
	 * @param $path	要删除的目标路径
	 * @return 删除成功 返回 true 反之 返回 false
	 */
	function rm($path) {
		$c = & IO::instance();
		return $c->rm($path);
	}
	/**
	 * IO::info($path,$key=false);
	 * 获取一个文件、目录的信息
	 * @param $path		目标路径
	 * @param $key		如果 $key 为空 返回所有文件信息  反之返回 文件信息中的  $key 项
	 * @return 文件信息
	 */
	function info($path,$key=false) {
		$c = & IO::instance();
		return $c->info($path);
	}
	//------------------------------------------------------------------
}
//----------------------------------------------------------------------

/// Xdebuger　控制类
class DBG{
	function DBG(){
	}
	
	function add(){
		static $dbg;
		if (!$dbg){$dbg = APP::N('myXdebuger');}

	}
}
//----------------------------------------------------------------------

/// LOG　控制类
class LogMgr
{
	function LogMgr(){
	}
	
	function &instance()
	{
		static $c;
		if(empty($c)) {
			$c = APP::ADP('log');
		}
		return $c;
	}
	//------------------------------------------------------------------
	
	function log($type, $str, $level='error', $extra_params=array(), $star_time=false)
	{
		// Used time
		if ($star_time)
		{
			$usedTime 	= microtime(TRUE)-$star_time;
			$str		= "[Used=$usedTime]\t".$str;
		}
		
		$c = & LogMgr::instance();
		return $c->log($type, $str, $level, $extra_params);
	}
	
	
	function run()
	{
		$c = & LogMgr::instance();
		return $c->run();
	}
	
	
	/**
	 * 警告日志
	 * @param $startTime
	 * @param $type
	 * @param $msg
	 * @param $level
	 * @param $extra
	 */
	function warningLog($startTime, $type, $msg, $level, $extra=array())
	{
		$timeList = array(	'db'	=> LOG_DB_WARNING_TIME, 
							'io'	=> LOG_IO_WARNING_TIME, 
							'cache'	=> LOG_MC_WARNING_TIME, 
							'api'	=> LOG_API_WARNING_TIME
					);
		
		$used	 = microtime(TRUE)-$startTime;
		$defTime = isset($timeList[$type]) ? $timeList[$type] : false;
		$longExe = $startTime && $defTime && $used>$defTime;
		if ($longExe) {
			LOGSTR($type, " [Used=$used]\t".$msg, LOG_LEVEL_WARNING, $extra);
		}
	}
}
//----------------------------------------------------------------------

/// 数据交互组件管理类
class dsMgr {
	function dsMgr(){
	}
	//------------------------------------------------------------------
	/**
	 * 调用一个数据交互方法、动作　dsMgr::call($dsRoute, $opt); 同名快捷函数为 DS($dsRoute, $opt);
	 * @param $eHandler	是否自动处理错误信息，默认为 TRUE
	 *							设置为 TRUE  时，将自动处理错误信息，并且退出程序，返回值为：真实数据结果
	 *							设置为 FALSE 时，将忽略错误，直接返回标准结果格式，返回值为：用 RST 封装过的标准结果结构
	 * @param $dsRoute	数据交互组件的路由
	 * @param $opt		数据交互的缓存与过滤策略，默认为空,不做任何缓存与过虑，
	 *					其规则如下：
	 *					[缓存组/]缓存时间[|过滤函数]  
	 *					  
	 *					缓存组,过滤函数 都是可选的，缓存时间为空表示不缓存，为0表示永久缓存，其它数值表示缓存的秒数
	 *					缓存组的可能值为:  空 、 i 、 g0,g1... 、 p0,p1... 、 s0,s1.... 、 u 
	 *					如： 	$opt = 123 			表示当前数据的调用会被缓存　123 秒
	 *					  	$opt = 'g1/223'		表示对当数据件交互产生缓存组，每个缓存周期是 223 秒
	 *											g1 表示根据数据调用组件的第一个参数作为标识,同理 g2,g3,g4
	 *											g0 表示根据数据调用组件的所有参数作为标识
	 *						$opt = 'g2/0|format_func1|format_func2'
	 *						表示，当前调用将会用第2个参数建立缓存组，建立永久缓存，第一次取数据时，
	 *						会依次用函数库的 	format_func1,format_func2 对组件数据进行格式化或者过滤处理			
	 *					
	 *						$opt = '|format_func';			
	 *						表示，当前调用不缓存，但需要使用 format_func 进行格式化或者过滤处理
	 *
	 *						$opt = '0|format_func'	以上例不同，此调用将做永久缓存			
	 * 
	 * @return 			见 $eHandler	 说明
	 */
	function call($eHandler, $dsRoute, $opt=false){
		
		$useCache	= false;
		$formatFunc = array();
		$gCache		= false;
		
		$gCacheId	= '';
		// 缓存类别有三种： g  默认的应用程序级缓存; s 会话级缓存; p 页面周期缓存; i 无论缓存是否存在都不使用，通常用于调试
		$cacheType	= 'g';
		$useStatic	= false;
		$gCacheName = COM_CACHE_KEY_PRE.$dsRoute;
		// 静态缓存数据
		static $rstData = array();
		// 静态对象
		static $objArr	= array();
		// 第三个参数开始，将传递给 数据组件
		$arg	= func_get_args();
		array_shift($arg);
		array_shift($arg);
		array_shift($arg);
		//--------------------------------------------------------------					
		if ($opt || $opt===0 || $opt==='0'){
			if (is_numeric($opt)) {
				$ttl = $opt * 1;
				$useCache = true;
			}else{
				$optArr		= explode('|', $opt);
				//缓存选项
				$cacheArr	= explode('/', $optArr[0]);
				
				//不缓存，或者设定了缓存时间 ，但没有缓存分组要求
				if (is_numeric($cacheArr[0]) || $cacheArr[0]==='' ){
					if ($cacheArr[0] === ''){
						$useCache = false;
					}else{
						$ttl = $cacheArr[0] * 1;
						$useCache = true;
					}
				}else{
					// 使用缓存组
					$flag = trim(strtolower($cacheArr[0]));
					switch ($flag[0]) {
						
					    // 自定义周期的用户程序级缓存,用户组缓存
						case 'g':
							$cacheType = 'g';
							$argi		= isset($flag[1])		? $flag[1]*1		: 0;
							$ttl		= isset($cacheArr[1])	? $cacheArr[1]*1	: 0;
							$useCache	= true;
							$gCache		= true;
							$gCacheId	= ($argi>0) ? $arg[$argi-1] : dsMgr::_creCacheID($arg);
							break;
						
						// 页面周期的缓存
						case 'p':
							$useCache	= true;
							$cacheType	= 'p';
							$argi		= isset($flag[1]) ? $flag[1]*1 : 0;
							$gCacheId	= ($argi>0) ? $arg[$argi-1] : dsMgr::_creCacheID($arg);
							break;
						// 会话周期的缓存
						case 's':
							$useCache	= true;
							$cacheType	= 's';
							break;
						// 用户组缓存
						case 'u':
							$useCache	= true;
							$gCache		= true;
							$cacheType	= 'u';
							$ttl		= isset($cacheArr[1])	? $cacheArr[1]*1	: 0;
							$argi		= isset($flag[1])		? $flag[1]*1		: 0;
							$gCacheId	= ($argi>0) ? $arg[$argi-1] : dsMgr::_creCacheID($arg);
							$gCacheId	= 'uid_'.USER::uid().' '.$gCacheId;
							break;
						
						// 忽略缓存
						case 'i':
							$cacheType	= 'i';
							break;
						default:
							trigger_error("dsMgr cache OPT : [ $opt ] is  invalid ", E_USER_ERROR);  exit;
							
					}
				}
				
				//管道过滤队列
				array_shift($optArr);
				$formatFunc = $optArr;
			}
		}
		//--------------------------------------------------------------
		// 如果有使用格式化管道，则自动根据管道分组
		if (!empty($formatFunc)) {
			$gCache		= true;
			$gCacheId 	= implode(' ', $formatFunc).' '.$gCacheId;
		}
		// 让 cache id 始终不为空
		$gCacheId.=' -';
		//--------------------------------------------------------------
		//var_dump(array($useCache,$gCacheName,$gCacheId, $cacheType));
		//echo "CACHE TRY TO FIND [$useCache] [$gCacheName], [$gCacheId]\n";
		// 需要使用缓存，如果缓存存在，则直接给出结果
		if ($useCache && $cacheType!='i'){
			$rst = false;
			switch ($cacheType) {
				case 'g':
					$rst = $gCache	? CACHE::gGet($gCacheName, $gCacheId)
									: CACHE::get($gCacheName);
					break;
				// 页面周期的缓存
				case 'p':
					$rst = APP::getData($gCacheId,$gCacheName);
					break;
				// 用户缓存
				case 'u':
					$rst = CACHE::gGet($gCacheName, $gCacheId);
					break;
				// 会话周期的缓存
				case 's':
					$cacheType = 's';
					break;
			}
			//if (is_array($rst)) echo "CACHE HIT: [$useCache] [$gCacheName], [$gCacheId] \n";//print_r($rst);
			if (is_array($rst) && isset($rst['rst']) && $rst['rst'] !== null){return $eHandler ? $rst['rst'] : $rst;}
		}
		//--------------------------------------------------------------
		$rData = APP::_parseRoute($dsRoute);
		$stKey = $rData[1].$rData[2];
		if (!isset($objArr[$stKey])){
			$objArr[$stKey] = APP::_cls($dsRoute,'com',true);
		}
		// 第三个参数开始将传递给数据调用组件
		$comRst = call_user_func_array(array(&$objArr[$stKey], $rData[3]), $arg);
		//--------------------------------------------------------------
		// 错误处理 
		if (!empty($comRst['errno'])){
			if ($comRst['errno'] == '1040008') {
				$sina_uid = USER::uid();

				///退出,清空SESSION 
				USER::uid(0);
				USER::resetInfo();

				$login_way = V('-:sysConfig/login_way', 1)*1; 
				if ($login_way == 2 || $login_way == 3) {
					$accAdapter = APP::ADP('account');
					$sUser = $accAdapter->getInfo();
					$site_uid	= $sUser['site_uid'];
					if (empty($sina_uid)) {
						$result = DR('mgr/userCom.getBySiteUid', 'p', $site_uid);
						$result = $result['rst'];
						$sina_uid = $result['sina_uid'];
					}
					/// 解除之前的绑定，重新bind
					$inData = array('access_token'=>'', 'token_secret'=>'', 'uid'=>0);
					DR('mgr/userCom.insertUser', '', $inData, $sina_uid);

					$xwb_discuz_enable = V('-:sysConfig/xwb_discuz_enable'); 
					if (1 == $xwb_discuz_enable) {
						///同步插件的绑定数据
						DR('xwbBBSpluginCf.deleteBindUser', '', $site_uid, $sina_uid);
					}

					//　发送退出通知到其它应用
					$syncLogoutScript = $accAdapter->syncLogout($site_uid);
					if ($syncLogoutScript){
						echo  $syncLogoutScript,"\n";
					}
				}

				// 引导重新登录
				$port = '';
				if ($_SERVER['SERVER_PORT'] != '80') {
					$port = ':' .$_SERVER['SERVER_PORT'];
				}
				$callback_url = 'http://' . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
				$goUrl = URL('account.login','loginCallBack='.urlencode($callback_url));
				APP::redirect($goUrl, 4);
				//APP::redirect(URL(APP::getRequestRoute()), 4);
				return;
			} elseif ($comRst['errno'] == '1040016' && !IS_IN_JS_REQUEST) {
				APP::tips(array('tpl' => 'error', 'msg' => L('common__apiError__limitTip')));
			}
			return  $eHandler ? dsMgr::errorDump($comRst) : $comRst;
		}
		//--------------------------------------------------------------
		//通过管道式策略，格式化，过滤处理数据
		if (!empty($formatFunc)) {
			$comRst['rst'] = dsMgr::_formatData($formatFunc, $comRst['rst']);
		}
		//--------------------------------------------------------------
		// 需要使用缓存时，建立缓存
		if ($useCache  && $cacheType!='i' ){
			switch ($cacheType) {
				case 'g':
				case 'u':
					$ttl = $ttl*1 ;
					if ($gCache){
						CACHE::gSet($gCacheName, $gCacheId, $comRst, $ttl);
					}else{
						CACHE::set($gCacheName, $comRst, $ttl);
					}
					break;
				case 'p':
					APP::setData($gCacheId, $comRst, $gCacheName);
					break;
				case 's':
					//会话级缓存未实现
					break;
			}
		}
		//--------------------------------------------------------------
		return  $eHandler ? $comRst['rst'] : $comRst;
	}
	//------------------------------------------------------------------
	/// 清除数据组件的缓存,同样适用于缓存组
	function delete($dsRoute){
		DD($dsRoute);
	}
	//------------------------------------------------------------------
	/// 根据一个变量生成一个HASH值
	function _creCacheID($arg){
		return md5(serialize($arg));
	}
	//------------------------------------------------------------------
	/// 给定管道函数列表,格式化、过滤数据
	function _formatData($funcArr,$data){
		foreach ($funcArr as $func){
			$data = F($func, $data);
		}
		return $data;
	}
	
	/// 获取一个数据调用的实例
	function & get($dsRoute){
		return APP::_cls($dsRoute,'com',true);
	}
	//------------------------------------------------------------------
	/// 错误控制，输出错误信息
	function errorDump($rst){
		APP::xcacheOpt(false);
		if(isset($rst['log']) && $rst['log']){
			APP::LOG($rst['log']);
		}
		//var_dump($rst);
		$msg = $rst['err'];
		if (IS_IN_API_REQUEST || IS_IN_JS_REQUEST){
			if (!IS_DEBUG){
				unset($rst['log']);//unset($rst['']);
			}
			header('Content-type: application/json;');
			echo json_encode($rst);
		}else{
			F('error',$msg, false);
		}
		exit;		
	}
}
//----------------------------------------------------------------------
/// 数据交互组件的快捷访问方法 调用函数 dsMgr::call，自动处理错误，无错误时，直接返回组件结果
function DS() {
	$p = func_get_args();
	array_unshift($p, true);
	return call_user_func_array(array('dsMgr','call'), $p);
}

/// 数据交互组件的快捷访问方法 调用函数 dsMgr::call， 返回标准返回值结构，可自行处理错误
function DR() {
	$p = func_get_args();
	array_unshift($p, false);
	return call_user_func_array(array('dsMgr','call'), $p);
}
/**
 * 删除 $dsRoute 相关的缓存
 * @param $dsRoute  	数据组件路由
 * $return 无
 */
function DD($dsRoute){
	CACHE::delete(COM_CACHE_KEY_PRE.$dsRoute);
	CACHE::gDelete(COM_CACHE_KEY_PRE.$dsRoute);
	APP::resetData(COM_CACHE_KEY_PRE.$dsRoute);
}
/**
 * 格式化组件返回值，数据组件的返回值都要通过此函数格式化后返回
 * @param $rst  	结果数据
 * @param $errno	错误代码，默认为 0 无错误，其它值为相应的错误代码
 * @param $err		错误信息，默认为空，
 * @param $level	错误级别，默认为 0 ， $err 将直接显示给用户看，如果为 1 则不显示给用户看，统一为提示为  系统繁忙，请稍后再试...
 * @param $log		当数据层需要 组件管理中心 写日志时，给出值，默认为空，不写日志
 * $return 返回标准的 RST 结果集
 */
function RST($rst, $errno=0, $err='', $level=0, $log=''){
	return array('rst'=>$rst, 'errno'=>$errno*1, 'err'=>$err, 'level'=>$level, 'log'=>$log);
}

//----------------------------------------------------------------------
/**
* 记录一个日志
* 
* @param mixed $type	日志的类型：io,db,mc ...
* @param mixed $str		日志描述
*/
function LOGSTR($type, $str, $level='error', $extra_params=array(), $star_time=false)
{  
	//时间        项目名称    项目版本号    APP_KEY    错误类型    错误描述 sprintf()
	LogMgr::log($type, $str, $level, $extra_params, $star_time);
}
/**
 * 程序退出时，写日志
 */
function SHUTDOWN_LOGRUN()
{
	LogMgr::run();
}
//----------------------------------------------------------------------
/// 用户类
class USER {
	function user (){
		
	}
	function &instance(){
		static $u;
		if(empty($u)) {
			$u = APP::N('clientUser');
		}
		return $u;
	}
	/// 设置或者获取一个会话变量，当参数只有一个时，为获取;有两个时，为设置;第一个参数为KEY
	function v($k){
		$arg = func_get_args();
		if (count($arg)==2){
			return USER::set($k,$arg[1]);
		}else{
			return USER::get($k);
		}
	}
	
	/// 获取一个会话变量
	function get($key=false){
		$u = & USER::instance();
		return $u->getInfo($key);
	}
	
	/// 设置会话变量
	function set($k,$v=false){
		$u = & USER::instance();
		return $u->setInfo($k, $v);
	}
	
	/// 判断当前用户是否登录管理员，管理员ID为空，则未登录，
	function isAdminLogin(){
		$uid = USER::get('__CLIENT_ADMIN_ID');
		return !empty($uid);
	}
	
	/// 设置或者获取当前访问的 aid/管理员ID，不转参数时获取，传参数时为读取
	function aid(){
		$arg = func_get_args();
		if (!empty($arg)){
			USER::set('__CLIENT_ADMIN_ID',	$arg[0]);
		}else{
			return USER::get('__CLIENT_ADMIN_ID');
		}
	}
	
	/// 获取一组 TOKEN
	function getOAuthKey($is_confirm = false){
		$k  = $is_confirm ? WB_OAUTH_KEYS2 : WB_OAUTH_KEYS1 ;
		return USER::get($k);

	}
	
	/// 设置一组 TOCKEN
	function setOAuthKey($keys, $is_confirm = false){
		$k  = $is_confirm ? WB_OAUTH_KEYS2 : WB_OAUTH_KEYS1 ;
		return USER::set($k, $keys);
	}
	
	/// 当前访问者是否已登录,uid为空则未登录
	function isUserLogin(){
		$uid = USER::get('__CLIENT_USER_ID');
		return !empty($uid);
	}
	/// 设置，或者获取 uid/用户ID; 不转参数时获取，传参数时为读取
	function uid(){
		$arg = func_get_args();
		if (!empty($arg)){
			USER::set('__CLIENT_USER_ID',	$arg[0]);
		}else{
			return USER::get('__CLIENT_USER_ID');
		}
	}
	/// 重置会话存储
	function resetInfo(){
		$u = & USER::instance();
		$u->resetInfo();
	}
	
	/// 获取一个用户漫游设置
	function cfg($k=NULL){
		static $uCfg = array();
		
		if (empty($uCfg)){
			$uCfg = DS('common/userConfig.get','u0/0');
		}
		//var_dump($uCfg);
		return $k ? (isset($uCfg[$k]) ?$uCfg[$k] :  NULL) : $uCfg;
	}
	
	/// 获取一个系统配置
	function sys($k=NULL){
		static $sCfg = array();
		if (empty($sCfg)){
			$sCfg = DS('common/sysConfig.get','0');
		}
		return $k ? (isset($sCfg[$k]) ? $sCfg[$k] : NULL) : $sCfg;
	}
}
//----------------------------------------------------------------------
