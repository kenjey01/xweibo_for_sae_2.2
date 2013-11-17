<?php
/**
 * @file			index.php
 * @CopyRright (c)	1996-2099 SINA Inc.
 * @Project			Xweibo 
 * @Author			Yang.Zhang <zhangyang@staff.sina.com.cn>
 * @Create Date 	2010-12-3
 * @Modified By 	Yang.Zhang/2010-12-3
 * @Brief			Description
 */
 
error_reporting(E_ALL);

define('ROOT_PATH', dirname(__FILE__).'/../');

include_once ROOT_PATH.'/sae_install/libs/func.php';

define('SAE_DOMAIN', 'xweibo');
define('CONFIG_DOMAIN',     'config');

define('XWEIBO_DB_STRUCTURE_FILE_NAME', 'structure');
/// 要求的升级版本号
define('XWEIBO_UPGRADE_VERS', '2.0');
define('XWEIBO_VERSION', '2.1');
define('XWEIBO_DB_PREFIX', 'xwb20_');
define('XWEIBO_SCRPIT_DB_PREFIX', 'xwb_');
define('XWEIBO_PROJECT', 'xwb');
define('XWEIBO_MAX_UPLOAD_FILE_SIZE',	'2');
define('XWEIBO_CHARSET','utf-8');
define('XWEIBO_DB_CHARSET','utf8');
// 反馈上报接口地址
define('XWEIBO_FEEDBACK_URL', 'http://x.weibo.com/xapi.php');
//define('XWEIBO_FEEDBACK_URL', 'http://x_dev.weibo.com/xapi.php');
$install_lang = 'zh_cn';
include_once ROOT_PATH.'/sae_install/lang/'.$install_lang.'.php';

$step = empty($_REQUEST['step']) ? 0 : $_REQUEST['step'];
$allow_action = array('license',   'setConfig', 'setApp','create', 'db_exists', 'done');
$method = empty($_GET['method']) ? $allow_action[$step] : $_GET['method'];

if(!checkDB()){
	show_msg('请在<a href="http://sae.sina.com.cn/?m=myapp" target="_blank">SAE MySQL</a>管理页面初始化mysql!');
	exit;
}
if(!checkDomain()){
	show_msg('请在<a href="http://sae.sina.com.cn/?m=myapp" target="_blank">SAE Storage</a>管理页面查看是否已经创建了名为"'.CONFIG_DOMAIN.'"的domain，如果不存在，请创建后继续安装。');
	exit;
}

if(checkInstall()){
	show_msg('安装程序已经安装,如果需要重新安装,请在<a href="http://sae.sina.com.cn/?m=myapp" target="_blank">SAE Domain</a>管理页面删除"'.CONFIG_DOMAIN.'"!');
	exit;
}

switch ($method){
	case 'license'://文档文件
		include_once ('templates/index.php');
		break;
	case 'setApp':
		if (!function_exists('mysql_connect')) {
			show_msg($_LANG['mysql_connect']);
		}

		$db_prefix = isset($_POST['db_prefix']) ? trim($_POST['db_prefix']) : null; 
		$db_prefix = empty($db_prefix) ? XWEIBO_DB_PREFIX : (strpos($db_prefix, '_') === false ? $db_prefix.'_' : $db_prefix);

		$cache = isset($_POST['cache']) ? $_POST['cache'] : 0;
		$cover = isset($_POST['cover']) ? trim($_POST['cover']) : 1;
		$db_passwd = isset($_POST['db_passwd']) ? trim($_POST['db_passwd']) : 1;

		// SAE专用参数
		$db_port = SAE_MYSQL_PORT;
		$db_host = SAE_MYSQL_HOST_M;
		$db_name = SAE_MYSQL_DB;
		$db_passwd = SAE_MYSQL_PASS;// 改为要求用户输入数据库密码
		$db_user = SAE_MYSQL_USER;

		// 安装时选择系统语言
		$wb_lang_type = isset($_POST['wb_lang_type']) ? trim($_POST['wb_lang_type']) : 'zh_cn';
		if (!in_array($wb_lang_type, array('zh_cn','zh_tw') )) {
			$wb_lang_type = 'zh_cn';
		}
		setCookie('xwb_install_config_lang', $wb_lang_type);
		if ($cover == 1) {
				/// 升级安装
				$old_ver = getXweiboVer($db_host, $db_user, $db_passwd, $db_name, $db_prefix);
				if ($old_ver && $old_ver != XWEIBO_VERSION) {
					$upgrade_vers = explode(',', XWEIBO_UPGRADE_VERS);
					if (!in_array($old_ver, $upgrade_vers)) {
						$msg = sprintf($_LANG['upgrade_ver_error'], $old_ver, XWEIBO_VERSION, XWEIBO_UPGRADE_VERS);
						show_msg($msg);
					}
				}
			}
		// 连接测试
		//db_resource($db_host, $db_user, $db_passwd, $db_name);
		$value = md5($db_host.'#'.$db_user.'#'.$db_passwd);
		setCookie('check_db_admin', $value);
		$config = array('cache' => $cache, 'cover' => $cover, 'db_prefix' => $db_prefix);
		set_ini_file($config);
		$site_config = get_ini_file();
		//@extract($site_config, EXTR_SKIP);

		include_once ('templates/step-1.php');
		break;
	case 'check_app':
/*
		$db_port = $_SERVER['HTTP_MYSQLPORT'];
		$db_host = $db_port.'.mysql.sae.sina.com.cn';
		$db_name = 'app_'.$_SERVER['HTTP_APPNAME'];
		//$db_passwd = SAE_SECRETKEY;// 改为要求用户输入数据库密码
		$db_user = SAE_ACCESSKEY;
		$ini = get_ini_file();
		$db_passwd = $ini['db_passwd'];
		$value = md5($db_host.'#'.$db_user.'#'.$db_passwd);

		// 保证是当前输入的用户是管理员
		if ($_COOKIE['check_db_admin'] !== $value) {
			show_msg($_LANG['database_connect_error'], 'index.php?step=1');
		}
*/
		$site_name = trim($_POST['site_name']);
		$site_info = trim($_POST['site_info']);
		$app_key = trim($_POST['app_key']);
		$app_secret = trim($_POST['app_secret']);

		function _s($k, $default='') {
			return isset($_SERVER[$k])?$_SERVER[$k]:$default;
		}
		$protoV = strtolower(_s('HTTPS'));
		$host	= _s('HTTP_X_FORWARDED_HOST')
					? _s('HTTP_X_FORWARDED_HOST')
					: _s("HTTP_HOST", _s("SERVER_NAME", (_s("SERVER_PORT")=='80' ? '' : _s("SERVER_PORT"))));

		$proto = (empty($protoV) || $protoV == 'off') ? 'http' : 'https'; 

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
			if ($var == 'sae_install' || $var == 'uninstall' || strpos($var, '.php')) {
				break;
			}
			$paths[] = $var;
		}
		$path_string = implode('/', $paths);
		$path_string = empty($path_string) ? '/' : $path_string.'/';

		// 程序安装位置
		$url = $proto . '://' . $host . $path_string;

		$config = array('site_name' => $site_name,
						'site_info' => $site_info,
						'app_key' => $app_key,
						'app_secret' => $app_secret,
						'WB_SITE_URL' => $url
						);
		
		if (empty($app_key) || empty($app_secret)) {
			show_msg($_LANG['app_key_empty']);
		}
		if (check_app($app_key, $app_secret)) {
			// 向服务器上报反馈信息，以便发现问题
			include_once "libs/saeproxy_http.php";
			$http = new saeproxy_http();
			$http->adp_init();
			
			$app_key = $app_key;
			$router = 'install';
			$f_config = array('WB_USER_SITENAME' => $site_name,
						'WB_USER_SITEINFO' => $site_info,
						'WB_AKEY' => $app_key,
						'WB_SKEY' => $app_secret,
						'WB_SITE_URL' => $url
						);
			
			$data = json_encode($f_config);
			$time = time();

			$data = array(
					'K' => $app_key,
					'A' => $router,
					'P' => $data,
					'T' => $time,
					'F' => md5(sprintf('#%s#%s#%s#%s#%s#', $app_key, $router, $data, $time, $app_secret))
					);
			$http->setUrl(XWEIBO_FEEDBACK_URL);
			$http->setData($data);
			$http->request('post');
			set_ini_file($config);
			header('Location: ./index.php?method=create');
			exit;
		} else {
			include_once ('templates/step-1.php');
		}
		break;
	case 'setConfig':
		set_ini_file(array());
		$site_config = get_ini_file();
		@extract($site_config, EXTR_SKIP);
		include_once ('templates/step-2.php');
		break;
	case 'create':
		$site_config = get_ini_file();
		@extract($site_config, EXTR_SKIP);	
		$ret = action_dbs($db_host.':' .$db_port, $db_user, $db_passwd, $db_name, $db_prefix, $cover);
		if ($ret == '20001') {
			/// 升级安装
			header('Location: ./index.php?method=done&type=upgrade');
			exit;
		}
		header('Location: ./index.php?step=3&method=view');
		exit;
		break;
	case 'view':
		$table_list = get_tables_list();
		
		$site_config = get_ini_file();
		@extract($site_config, EXTR_SKIP);
		
		include_once ('templates/step-3.php');
		break;
	case 'done':
		$finish = '1';
		$config = array('finish' => $finish);
		set_ini_file($config);
		
		$site_config = get_ini_file();
		@extract($site_config, EXTR_SKIP);
		
		$paths = explode('/', $_SERVER['SCRIPT_NAME']);
		foreach ($paths as $var) {
			if ($var == 'sae_install' || $var == 'uninstall' || strpos($var, '.')) {
				continue;
			}
			$urls[] = $var;
		}
		$string_path = implode('/', $urls);
		$index_url = 'http://'.$_SERVER['HTTP_HOST'].$string_path;
		$admin_url = 'http://'.$_SERVER['HTTP_HOST'].$string_path.'/admin.php?m=mgr/active_admin.active&app_key='.urlencode($app_key).'&app_secret='.urlencode($app_secret);
		/// set saeStorage domain's expires
		$expires = 'ExpiresActive On
		 	ExpiresDefault "access plus 10 days"
		 	ExpiresByType image/gif "access plus 10 days"
		 	ExpiresByType image/jpg "access plus 10 days"
		 	ExpiresByType image/jpeg "access plus 10 days"
		 	ExpiresByType image/png "access plus 10 days"
		 ';
		$storage = new SaeStorage(); 
		$storage->setDomainAttr(CONFIG_DOMAIN, array('expires'=>$expires));

		include_once ('templates/finish.php');
		break;
	default:
		include_once ('templates/index.php');
		break;
		
}
