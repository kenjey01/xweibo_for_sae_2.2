<?php
/**
 * @file			func.php
 * @CopyRright (c)	1996-2099 SINA Inc.
 * @Project			Xweibo 
 * @Author			Yang.Zhang <zhangyang@staff.sina.com.cn>
 * @Create Date 	2010-12-4
 * @Modified By 	Yang.Zhang/2010-12-4
 * @Brief			Description
 */

/**
 * 
 * 设置配置数据
 * @param unknown_type $config
 * @return
 */
function set_ini_file($config)
{
	extract($config, EXTR_SKIP);
	
	$app_config = get_ini_file();
	$key = array('site_name', 'site_info', 'app_key', 'app_secret', 'cover','db_prefix');
	foreach ($key as $k) {
		if (!isset($app_config[$k])) {
			$app_config[$k] = '';
			}
	}
	$site_name = isset($site_name) ? $site_name : $app_config['site_name'];
	$site_info = isset($site_info) ? $site_info : $app_config['site_info'];
	$app_key = isset($app_key) ? $app_key : $app_config['app_key'];
	$app_secret = isset($app_secret) ? $app_secret : $app_config['app_secret'];
	$cache = isset($cache) ? $cache : null;
	$finish = isset($finish)?$finish : '0';
	$root_path = ROOT_PATH;
	$cover = isset($cover)? $cover: $app_config['cover'];
	$db_port = SAE_MYSQL_PORT;
	$db_host = SAE_MYSQL_HOST_M;
	$db_name = SAE_MYSQL_DB;
	$db_passwd = SAE_SECRETKEY;
	$db_user = SAE_ACCESSKEY;
	$db_prefix = isset($db_prefix)?$db_prefix: $app_config['db_prefix'];
	//$db_prefix = 'xwb20_';
	//$db_prefix = XWEIBO_DB_PREFIX; 
	
	/// 生成安装目录
	$local_uri = '';
	if (isset($_SERVER['REQUEST_URI'])){
		$local_uri = $_SERVER['REQUEST_URI'];
	}
	if (empty($local_uri) && isset($_SERVER['PHP_SELF']) ){
		$local_uri = $_SERVER['PHP_SELF'];
	}
	if (empty($local_uri) && isset($_SERVER['SCRIPT_NAME']) ){
		$local_uri = $_SERVER['SCRIPT_NAME'];
	}
	if (empty($local_uri) && isset($_SERVER['ORIG_PATH_INFO']) ){
		$local_uri = $_SERVER['ORIG_PATH_INFO'];
	}
	if (empty($local_uri)){
		//todo　获取不了　可供计算URI的　路径　错误显示
	}

	$uri_array = explode('/', $local_uri);
	$paths = array();
	foreach ($uri_array as $var) {
		if ($var == 'sae_install' || $var == 'uninstall' || strpos($var, '.')) {
			break;
		}
		$paths[] = $var;
	}
	$path_string = implode('/', $paths);
	$path_string = empty($path_string) ? '/' : $path_string.'/';
	
	//echo $path_string;
	$config_file = 'site_name='.urlencode($site_name)
				  .'&path=' . $path_string
				  .'&site_info='.urlencode($site_info)
				  .'&app_key='.urlencode($app_key)
				  .'&app_secret='.urlencode($app_secret)
				  .'&cache='.urlencode($cache)
				  .'&db_host='.urlencode($db_host)
				  . '&db_port=' . urlencode($db_port)
				  .'&db_name='.urlencode($db_name)
				  .'&db_passwd='.urlencode($db_passwd)
				  .'&db_user='.urlencode($db_user)
				  .'&db_prefix='.urlencode($db_prefix)
				  .'&finish='.urlencode($finish)
				  .'&cover='.urlencode($cover)
				  .'&app_flag_ver=' . date('mdHis');
	
	write_config(CONFIG_DOMAIN,$config_file);
	@session_start();
	/// 清零cookie, session
	if (isset($_COOKIE) && !empty($_COOKIE)) {
		foreach ($_COOKIE as $key => $var) {
			setcookie($key , '' , time()-3600 , $path_string, '' , 0 );
			unset($_COOKIE[$key]);
		}	
	}
	if (isset($_SESSION) && !empty($_SESSION)) {
		foreach ($_SESSION as $key => $var) {
			unset($_SESSION[$key]);	
		}
		session_destroy();
	}
	return true;
}


/**
 * 获取ip
 *
 * @return string
 */
function get_real_ip() {
	/// Gets the default ip sent by the user
	if (!empty($_SERVER['REMOTE_ADDR'])) {
		$direct_ip = $_SERVER['REMOTE_ADDR'];
	}
	/// Gets the proxy ip sent by the user
	$proxy_ip     = '';
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$proxy_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
		$proxy_ip = $_SERVER['HTTP_X_FORWARDED'];
	} else if (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
		$proxy_ip = $_SERVER['HTTP_FORWARDED_FOR'];
	} else if (!empty($_SERVER['HTTP_FORWARDED'])) {
		$proxy_ip = $_SERVER['HTTP_FORWARDED'];
	} else if (!empty($_SERVER['HTTP_VIA'])) {
		$proxy_ip = $_SERVER['HTTP_VIA'];
	} else if (!empty($_SERVER['HTTP_X_COMING_FROM'])) {
		$proxy_ip = $_SERVER['HTTP_X_COMING_FROM'];
	} else if (!empty($_SERVER['HTTP_COMING_FROM'])) {
		$proxy_ip = $_SERVER['HTTP_COMING_FROM'];
	}
	/// Returns the true IP if it has been found, else FALSE
	if (empty($proxy_ip)) {
		/// True IP without proxy
		return $direct_ip;
	} else {
		$is_ip = preg_match('|^([0-9]{1,3}\.){3,3}[0-9]{1,3}|', $proxy_ip, $regs);
		if ($is_ip && (count($regs) > 0)) {
			/// True IP behind a proxy
			return $regs[0];
		} else {
			/// Can't define IP: there is a proxy but we don't have
			/// information about the true IP
			return $direct_ip;
		}
	}
}

/**
 * 
 * 保存用户设置数据
 * @param $key 保存的key
 * @return
 */
function read_config($key){
	$s = new SaeStorage();
	return $s->read(CONFIG_DOMAIN,md5($key));
}
/**
 * 
 * 读取用户数据
 * @param $key 保存的key
 * @param $value 要保存的数据
 * @return
 */
function write_config($key,$value){
	$s = new SaeStorage();
	$result = $s->write( CONFIG_DOMAIN , md5($key) , $value );
	if($result){
		return $result;
	}else{
		return false;
	}
}
/**
 * 
 * 获取配置文件
 * @return
 */
function get_ini_file(){
	$content = read_config(CONFIG_DOMAIN);
	$site_base_info = array();
	parse_str($content, $site_base_info);
	return $site_base_info;
}

/**
 * 读/写SQL数据备份
 */
function backupSql($data = null) {
	$file_name = 'sql_backup';
	$s = new SaeStorage();
	if ($data !== null) {
		return $s->write( CONFIG_DOMAIN , md5($file_name) , $data );
	} else {
		return $s->read(CONFIG_DOMAIN,md5($key));
	}
}

/**
 * 检查app的真确性
 *
 * @param unknown_type
 * @return unknown
 */
function check_app($app_key, $app_secret)
{
	global $_LANG;
	
	include_once "oauth.class.php";
	include_once "saeproxy_http.php";

	$http = new saeproxy_http();
	$http -> adp_init();
	$url = 'http://api.t.sina.com.cn/oauth/request_token';
	$sha1_method = new OAuthSignatureMethod_HMAC_SHA1();
	$consumer = new OAuthConsumer($app_key, $app_secret);
	$request = OAuthRequest::from_consumer_and_token($consumer, null, 'GET', $url, null);
	$request->sign_request($sha1_method, $consumer, null);
	$http_url = $request->to_url();
	$http->setUrl($http_url);
	$result = $http->request();
	$code = $http->getState();
	if ($code != '200') {
		/// 记录错误日志
		install_log('url: '.$http_url." \r\ncode: ".$code." \r\nret: ".$result);
		show_msg($_LANG['app_key_error']);
	}
	return true;
}
/**
 * 写错误日志
 *
 *
 */
function install_log($msg)
{
//	show_msg($msg);
}
/**
 * 错误提示信息
 *
 * @param unknown_type
 * @return unknown
 */
function show_msg($msg, $type = 1)
{
	global $_LANG;
	include 'templates/error.php';
	exit;
}
/**
 * 创建数据库
 *
 * @param unknown_type
 * @return unknown
 */
function create_db($db_host, $db_user, $db_passwd, $db_name)
{
	global $_LANG, $xwb_isError;

	/// 注册错误处理方法
	//register_shutdown_function('error', $_LANG['database_exists_error']);

	$link = @mysql_connect($db_host.':'.SAE_MYSQL_PORT, $db_user, $db_passwd);

	$xwb_isError = 0;
	
	if (!$link) {
		/// 错误日志
		install_log("sql:  \r\nerrno: ".mysql_errno()." \r\nerror: ".mysql_error());
		show_msg($_LANG['database_connect_error']);
	}

    if (mysql_select_db($db_name, $link) === false)
    {
        $sql = "CREATE DATABASE $db_name DEFAULT CHARACTER SET " . XWEIBO_DB_CHARSET;
        if (mysql_query($sql, $link) === false)
        {
			$errno = mysql_errno($link);
			$error = mysql_error($link);
			/// 错误日志
			install_log('sql: '.$sql." \r\nerrno: ".$errno." \r\nerror: ".$error);
			if ($errno == 1064) {
				show_msg($_LANG['database_create_1064_error']);
			} elseif ($errno == 1044 || $errno == 1045) {
				show_msg($_LANG['database_create_1044_error']);
			} else {
				show_msg($_LANG['database_create_error']);
			}
        }
    }
    mysql_close($link);
}

/**
 * 创建数据库资源
 *
 * @param unknown_type
 * @return unknown
 */
function db_resource($db_host = null, $db_user = null, $db_passwd = null, $db_name = null, $ajax = false)
{
	global $_LANG;
	$link = @mysql_connect($db_host.':'.SAE_MYSQL_PORT, $db_user, $db_passwd);
	if (!$link) {
		/// 错误日志
		install_log("sql: \r\nerrno: ".mysql_errno()." \r\nerror: ".mysql_error());
		if ($ajax) {
			die($_LANG['database_connect_error']);
		}
		show_msg($_LANG['database_connect_error'], 'index.php?step=1');
	}
	if (!mysql_select_db($db_name, $link)) {
		if ($ajax) {
			return '-1';
			//die($_LANG['database_exists_error']);
		}
		show_msg($_LANG['database_exists_error']);
	}
	mysql_query('SET NAMES '.XWEIBO_DB_CHARSET, $link);
	return $link;
}


/**
 * 检查app key是否一样
 *
 * @param unknown_type
 * @return unknown
 */
function check_app_key($link, $db_name, $db_prefix = null)
{
	mysql_select_db($db_name, $link);
	mysql_query('SET NAMES '.XWEIBO_DB_CHARSET, $link);

	if ($db_prefix) {
		$table_name = $db_prefix.'sys_config';
	} else {
		$sql = "show tables like '%sys_config'";
		$result = mysql_query($sql, $link);
		$list = array();
		$table_name = false;
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			if (empty($row[0])) {
				return '10000';
			}
			$sql = 'SELECT value FROM '.$row[0].' WHERE `key` = "wb_version"';
			$ret = mysql_query($sql, $link);
			$fields_rows = mysql_fetch_assoc($ret);
			if ($fields_rows) {
				$table_name = $row[0];
				break;
			}
			return '10000';
		}
	}
	if ($table_name) {
		$app_config = get_ini_file();
		$sql = 'SELECT * FROM '.$table_name;
		$ret = mysql_query($sql, $link);
		if (!$ret) {
			return '10000';
		}
		while($rows = mysql_fetch_assoc($ret)) {
			if ($rows['key'] == 'app_key') {
				$app_key = $rows['value'];
			}
			if ($rows['key'] == 'app_secret') {
				$app_secret = $rows['value'];
			}
		}
		if (!empty($app_key) && !empty($app_secret) && !empty($app_config['app_key']) && !empty($app_config['app_secret'])) {
			if ($app_key != $app_config['app_key'] || $app_secret != $app_config['app_secret']) {
				return '10001';
			}
		}
		set_ini_file($app_config);
	}

	return '10002';

	mysql_close();
}

/**
 * 清空所有旧数据表:所有sys_config表里db_prefix指定前缀所有数据表
 */
function clear_tables($db_host, $db_user, $db_passwd, $db_name, $db_prefix) {
	
	$link = db_resource($db_host, $db_user, $db_passwd, $db_name);
	$sql = "show tables like '%sys_config'";
	$result = mysql_query($sql, $link);
	$list = array();
	$table_name = false;
	$tables = array();
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		if (empty($row[0])) {
			return '10000';
		}
		$sql = 'SELECT value FROM '.$row[0].' WHERE `key` = "db_prefix"';
		$ret = mysql_query($sql, $link);
		$fields_rows = mysql_fetch_assoc($ret);
		if ($fields_rows) {
			$db_prefix_old = $fields_rows['value'];
			// 删除当前版本外的所有数据表
			if ($db_prefix_old == $db_prefix || trim($db_prefix_old) == '') {
				continue;
			}

			$sql = "show tables like '{$db_prefix_old}%'";
			$rs = mysql_query($sql, $link);
			while ($table = mysql_fetch_row($rs)) {
				$tables[] = $table['0'];
			}
		}
	}
	if (!empty($tables)) {
		$sql = 'DROP TABLE IF EXISTS ' . implode(',', $tables);
		mysql_query($sql, $link);
	}

	mysql_close($link);

}


/**
 * 创建表并且返回表的列表
 *
 * @param unknown_type
 * @return unknown
 */
function create_tables($db_host, $db_user, $db_passwd, $db_name, $db_prefix)
{
	global $_LANG;
	$lang_type = isset($_COOKIE['xwb_install_config_lang']) ? $_COOKIE['xwb_install_config_lang'] : 'zh_cn';
	$data_sql = XWEIBO_DB_STRUCTURE_FILE_NAME.'_'.$lang_type.'.'.XWEIBO_VERSION.'.sql';
	$fp = fopen(ROOT_PATH.'/sae_install/data/'.$data_sql, 'r');
	$sql_items = fread($fp, filesize(ROOT_PATH.'/sae_install/data/'.$data_sql));
	fclose($fp);

	/// 删除SQL行注释
	$sql_items = preg_replace('/^\s*(?:--|#).*/m', '', $sql_items);
	/// 删除SQL块注释
	$sql_items = preg_replace('/^\s*\/\*.*?\*\//ms', '', $sql_items);
	/// 代替表前缀
	$keywords = 'CREATE\s+TABLE(?:\s+IF\s+NOT\s+EXISTS)?|'
			  . 'DROP\s+TABLE(?:\s+IF\s+EXISTS)?|'
			  . 'ALTER\s+TABLE|'
			  . 'UPDATE|'
			  . 'REPLACE\s+INTO|'
			  . 'DELETE\s+FROM|'
			  . 'INSERT\s+INTO|'
			  .	'LOCK\s+TABLES';
	$pattern = '/(' . $keywords . ')(\s*)`?' . XWEIBO_SCRPIT_DB_PREFIX . '(\w+)`?(\s*)/i';
	$replacement = '\1\2`' . $db_prefix . '\3`\4';
	$sql_items = preg_replace($pattern, $replacement, $sql_items);

	$pattern = '/(UPDATE.*?WHERE)(\s*)`?' . XWEIBO_SCRPIT_DB_PREFIX . '(\w+)`?(\s*\.)/i';
	$replacement = '\1\2`' . $db_prefix . '\3`\4';
	$sql_items = preg_replace($pattern, $replacement, $sql_items);

	$sql_items = str_replace("\r", '', $sql_items);
	$query_items = explode(";\n", $sql_items);

	$link = db_resource($db_host, $db_user, $db_passwd, $db_name);
	$sign = true;
	
	foreach ($query_items as $var) {
		$var = trim($var);

		if (empty($var)) {
			continue;
		}

		$sign = mysql_query($var, $link);
		if (!$sign) {
			/// 错误日志
			install_log('sql: '.$var." \r\nerrno: ".mysql_errno($link)." \r\nerror: ".mysql_error($link));
		}
	}

	// 向sys_config 添加当前项目版本号
	$sql = 'INSERT INTO ' . $db_prefix . 'sys_config(`key`,`value`,`group_id`) VALUES("db_prefix", "' .$db_prefix . '","1") ON DUPLICATE KEY UPDATE `value`="' . $db_prefix . '" ';
	mysql_query($sql, $link);
	mysql_close($link);
	if (!$sign) {
		show_msg($_LANG['tables_create_error']);
	}
}

/**
 * 罗列表列表
 *
 * @param unknown_type
 * @return unknown
 */
function get_tables_list()
{
	global $_LANG;
	$config_info = get_ini_file();
	@extract($config_info, EXTR_SKIP);

	$link = db_resource($db_host, $db_user, $db_passwd, $db_name);
	/// 罗列表
	$sql = 'SHOW tables';
	$result = mysql_query($sql, $link);
	$list = array();
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		if (!preg_match("/$db_prefix.+/i", $row[0])) {
			continue;
		}
		$list[] = $row;
	}
	mysql_free_result($result);
	mysql_close($link);

	return $list;

}
/**
 * 处理数据库和数据
 *
 * @param unknown_type
 * @return unknown
 */
function action_dbs($db_host, $db_user, $db_passwd, $db_name, $db_prefix, $cover, $admin_name = null, $admin_passwd = null)
{
	if (2 == $cover) {
		/// 覆盖安装
		create_db($db_host, $db_user, $db_passwd, $db_name);
		clear_tables($db_host, $db_user, $db_passwd, $db_name, $db_prefix);
		create_tables($db_host, $db_user, $db_passwd, $db_name, $db_prefix);

		init_site_data($db_host, $db_user, $db_passwd, $db_name, $db_prefix);
	} else {
		/// 升级安装
		
		/// 检查数据库是否存在, appkey是否跟之前的一致
		$ret = db_exists($db_host, $db_user, $db_passwd, $db_name, $db_prefix);
		if ('10001' == $ret || '10000' == $ret) {
			$ver = '0';
		} else {
			/// 检查之前安装的版本号
			$ver = check_version($db_host, $db_user, $db_passwd, $db_name, $db_prefix);
		}
		if ('1' == $ver) {
			/// 相同版本
			return true;
		} else {
			/// 先备份数据
			$link = db_resource($db_host, $db_user, $db_passwd, $db_name, true);
			$sql = 'SHOW tables';
			$result = mysql_query($sql, $link);
			$list = array();
			$db_prefix = $db_prefix;
			$tables = array();
			$sql_dump = '';
			while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
				if (!preg_match("/$db_prefix.+/i", $row[0])) {
					continue;
				}
				$sql_dump .= backup_data_sql($link, $row[0]);
				$tables[] = $row[0];
			}

			// 生成备份数据表的sql文件
			backupSql($sql_dump);

			$fun_name = 'action_db'.str_replace('.', '', XWEIBO_VERSION);
			include_once 'upgrade.class.php';
			$upgrade = new upgrade($db_host, $db_user, $db_passwd, $db_name);
			$fun_lists = get_class_methods($upgrade);
			if (in_array($fun_name, $fun_lists)) {
				call_user_func(array($upgrade, $fun_name), $db_prefix);
			}
			return '20001';//升级安装
		} 
	}
}
/**
 * 备份数据表sql语句
 *
 * @param unknown_type
 * @return unknown
 */
function backup_data_sql($link, $table)
{
	$sql_dump = '';
	$sql = 'SELECT * FROM '.$table;
	$result = mysql_query($sql, $link);
	$field_key = array();
	$field_value = array();
	$field_value_string = array();
	while($row = mysql_fetch_assoc($result)) {
		if (empty($row)) {
			continue;
		}
		foreach ($row as $key => $var) {
			$field_key[$key] = "`".$key."`";
			$field_value[$key] = "'".mysql_real_escape_string($var)."'";
		}
		$field_value_string[] = '('.implode(', ', $field_value).')';
	}

	if (!empty($field_value_string)) {
		$sql_dump .= "INSERT INTO $table (".implode(', ', $field_key).")VALUES".implode(',', $field_value_string)."\r\n";
	}
	return $sql_dump;
}

/**
 * 初始化网站信息
 *
 * @param unknown_type
 * @return unknown
 */
function init_site_data($db_host, $db_user, $db_passwd, $db_name, $db_prefix = 'xwb_')
{
	global $_LANG;

	$site_config = get_ini_file();
	$link = db_resource($db_host, $db_user, $db_passwd, $db_name);
	$table = $db_prefix.'sys_config';
	$sql = "INSERT INTO $table (`key`,`value`)VALUES('site_name','".mysql_real_escape_string($site_config['site_name'])."'),('wb_version','".mysql_real_escape_string(XWEIBO_VERSION)."'),('app_key', '".mysql_real_escape_string($site_config['app_key'])."'),('app_secret', '".mysql_real_escape_string($site_config['app_secret'])."'),('wb_lang_type','" .(isset($_COOKIE['xwb_install_config_lang'])?$_COOKIE['xwb_install_config_lang']: 'zh_cn')."')";
	
	if (mysql_query($sql, $link) == false) {
		/// 错误日志
		install_log('sql: '.$sql." \r\nerrno: ".mysql_errno($link)." \r\nerror: ".mysql_error($link));
		show_msg($_LANG['add_admin_errno']);
	}
	$sql = 'UPDATE ' . $table .' SET `value`="Xweibo ' . XWEIBO_VERSION . '" WHERE `key`="title"';
	if (mysql_query($sql, $link) == false) {
		/// 错误日志
		install_log('sql: '.$sql." \r\nerrno: ".mysql_errno($link)." \r\nerror: ".mysql_error($link));
		show_msg($_LANG['add_admin_errno']);
	}
	mysql_close($link);
}
/**
 * 检测安装使用的数据是否已经存在
 *
 * @param unknown_type
 * @return unknown
 */
function db_exists($db_host, $db_user, $db_passwd, $db_name, $db_prefix = null)
{
	global $_LANG;
	$link = @mysql_connect($db_host.':'.SAE_MYSQL_PORT, $db_user, $db_passwd);
	if (!$link) {
		/// 错误日志
		install_log("sql: \r\nerrno: ".mysql_errno()." \r\nerror: ".mysql_error());
		return '-1';
	}
	$sql = 'show databases';
	$result = mysql_query($sql);
	$list = array();
	while ($row = mysql_fetch_assoc($result)) {
		if ($db_name == $row['Database']) {
			$ret = check_app_key($link, $db_name, $db_prefix);
			if ($ret == '10001' || $ret == '10000') {
				return $ret;
			}
			return '1';
		}
	}
	return '0';
}
/**
 * 检测之前安装xweibo的版本
 *
 * @param unknown_type
 * @return unknown
 */
function check_version($db_host, $db_user, $db_passwd, $db_name, $db_prefix = null)
{
	$link = db_resource($db_host, $db_user, $db_passwd, $db_name, true);
	if ($link == '-1') {
		return '0';
	}
	if ($db_prefix) {
		$table_name = $db_prefix.'sys_config';
	} else {
		$sql = "show tables like '%sys_config'";
		$result = mysql_query($sql, $link);
		$list = array();
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			if (empty($row[0])) {
				return '0';
			}
			$sql = 'SELECT value FROM '.$row[0].' WHERE `key` = "wb_version"';
			$ret = mysql_query($sql, $link);
			$fields_rows = mysql_fetch_assoc($ret);
			if ($fields_rows) {
				$table_name = $row[0];
				break;
			}
			return '0';
		}
	}

	$sql = 'SELECT value FROM '.$table_name.' WHERE `key` = "wb_version"';
	$ret = mysql_query($sql, $link);
	if ($ret) {
		$row = mysql_fetch_assoc($ret);
		if ($row['value'] != XWEIBO_VERSION) {
			return $row['value'];
		}
		return '1';
	}
	return '0';

	mysql_close();
}
/**
 * 
 * 是否已安装
 * @return true 已经安装 false 未安装
 */
function checkInstall(){
	$content = get_ini_file();
	if($content){
		if($content['finish']){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}
/**
 * 
 * 判断domain是否有设置
 * @return
 */
function checkDomain(){
	$s = new SaeStorage();
	$result = $s->write(CONFIG_DOMAIN,'test','test' );
	if($result){
		$s->delete( CONFIG_DOMAIN,'test');
		return true;
	}else{
		return false;
	}
}
/**
 * 判断是否开启mysql
 */
function checkDB(){
	if( isset($_SERVER['HTTP_MYSQLPORT']) && $_SERVER['HTTP_MYSQLPORT']>0 ){
		return true;
	}else{
		return false;
	}
}


/**
 * 替换配置选的值
 *
 *
 */
function setDefineValue($s,$k,$v=''){
	if (is_array($k)){
		foreach($k as $kk=>$vv){
			$p = "#define\s*\(\s*'".preg_quote($kk)."'\s*,(\s*)'.*?'\s*\)\s*;#sm";
			$s = preg_replace($p, "define('".$kk."',\\1'".$vv."');",$s);
		}
		return $s;
	}else{
		$p = "#define\s*\(\s*'".preg_quote($k)."'\s*,(\s*)'.*?'\s*\)\s*;#sm";
		return preg_replace($p, "define('".$k."',\\1'".$v."');",$s);
	}
}

/**
 *
 * 更新表结构和数据
 *
 */
function upgrade_tables($db_prefix, $link) {
	global $_LANG;
	$lang_type = getLangType();
	//$lang_type = isset($_COOKIE['xwb_install_config_lang']) ? $_COOKIE['xwb_install_config_lang'] : 'zh_cn';
	$data_sql = 'upgrade_'.$lang_type.'.'.XWEIBO_VERSION.'.sql';
	$fp = fopen(ROOT_PATH.'/sae_install/data/'.$data_sql, 'r');
	$sql_items = fread($fp, filesize(ROOT_PATH.'/sae_install/data/'.$data_sql));
	fclose($fp);

	/// 删除SQL行注释
	$sql_items = preg_replace('/^\s*(?:--|#).*/m', '', $sql_items);
	/// 删除SQL块注释
	$sql_items = preg_replace('/^\s*\/\*.*?\*\//ms', '', $sql_items);
	/// 代替表前缀
	$keywords = 'CREATE\s+TABLE(?:\s+IF\s+NOT\s+EXISTS)?|'
			  . 'DROP\s+TABLE(?:\s+IF\s+EXISTS)?|'
			  . 'ALTER\s+TABLE|'
			  . 'UPDATE|'
			  . 'REPLACE\s+INTO|'
			  . 'DELETE\s+FROM|'
			  . 'INSERT\s+INTO|'
			  .	'LOCK\s+TABLES';
	$pattern = '/(' . $keywords . ')(\s*)`?' . XWEIBO_SCRPIT_DB_PREFIX . '(\w+)`?(\s*)/i';
	$replacement = '\1\2`' . $db_prefix . '\3`\4';
	$sql_items = preg_replace($pattern, $replacement, $sql_items);

	$pattern = '/(UPDATE.*?WHERE)(\s*)`?' . XWEIBO_SCRPIT_DB_PREFIX . '(\w+)`?(\s*\.)/i';
	$replacement = '\1\2`' . $db_prefix . '\3`\4';
	$sql_items = preg_replace($pattern, $replacement, $sql_items);

	$sql_items = str_replace("\r", '', $sql_items);
	$query_items = explode(";\n", $sql_items);

	$sign = true;
	
	foreach ($query_items as $var) {
		$var = trim($var);

		if (empty($var)) {
			continue;
		}

		$sign = mysql_query($var, $link);
		if (!$sign) {
			/// 错误日志
			install_log('sql: '.$var." \r\nerrno: ".mysql_errno($link)." \r\nerror: ".mysql_error($link));
		}
	}

	if (!$sign) {
		show_msg($_LANG['tables_create_error']);
	}
}

/**
 *
 * 返回系统管理员的id
 */
function getAdminId() {
	include ROOT_PATH.'/user_config.php';
	return SYSTEM_SINA_UID;
}

/**
 * 返回系统语言类型
 */
function getLangType() {
	$lang_type = isset($_COOKIE['xwb_install_config_lang']) ? $_COOKIE['xwb_install_config_lang'] : 'zh_cn';
	return $lang_type;
}

/**
 * 获取之前xweibo版本的版本号
 */
function getXweiboVer($db_host, $db_user, $db_passwd, $db_name, $db_prefix) {
	$link = db_resource($db_host, $db_user, $db_passwd, $db_name, true);
	if ($link == '-1') {
		return false;
	}

	$sysConfigTable = $db_prefix.'sys_config';

	$sql = 'SELECT value FROM '.$sysConfigTable.' WHERE `key` = "wb_version"';
	$ret = mysql_query($sql, $link);
	if ($ret) {
		$fields_rows = mysql_fetch_assoc($ret);
		if ($fields_rows) {
			$old_ver = $fields_rows['value'];
			return $old_ver;
		}
	}

	return false;

	mysql_close($link);
}
?>
