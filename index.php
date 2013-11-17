<?php
/**************************************************
*  Created:  2010-06-08
*
*  入口文件
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/
//---------------------------------------------------------
//phpinfo();exit;
ob_start();
/// 入口名称
define('ENTRY_SCRIPT_NAME','index');
/// 当前入口的默认模块路由
define('R_DEF_MOD', "pub");
/// 强制的路由模式　如果你尝试使用　rewrite　功能　失败，可以通过此选项快速恢复网站正常
//define('R_FORCE_MODE', 0);

/// 初始化框架
require_once 'application/init.php';

///检查是否安装
if (XWB_SERVER_ENV_TYPE!=='sae' && (!WB_AKEY) ) {
	header("Location: install/index.php");
	exit;
}

if(APP::F('is_robot')){
	APP::deny();
}



/// 启用Xpipe
$GLOBALS[V_GLOBAL_NAME]['NEED_XPIPE'] = TRUE;
/// 启用多模板机制
$GLOBALS[V_GLOBAL_NAME]['MIX_TPL'] = TRUE;

//---------------------------------------------------------
/// 预处理模块 , 必须在 APP::init 方法之前 定义
APP::addPreDoAction('apiStop.check', 'c', false, array('welcome.retry'));// 检查API是否中
APP::addPreDoAction('account.initSiteInfo',	 'm', false, array('pipe.t'));
APP::addPreDoAction('account.allowedLogin',	 'm', false,array('account.logout'));

if ( USER::sys('sysLoginModel') ) {
	APP::addPreDoAction('account.gloCheckLogin', 'm', false, array('feedback.*','welcome.retry', 'pipe.t','authImage.paint', 'account.*', 'api/*', 'output.*','setting.getSkin', 'interview.*', 'live.*'));
} else {
	APP::addPreDoAction('account.gloCheckLogin', 'm', false, array('feedback.*','custom.*','welcome.retry', 'pipe.t','authImage.paint', 'account.*', 'pub', 'pub.*', 'api/*', 'output.*','setting.getSkin', 'interview.*', 'live.*'));
}

/// 初始化应用程序
APP::init();
//---------------------------------------------------------
/// 处理当前HTTP请求
APP::request();
//---------------------------------------------------------


















//---------------------------------------------------------
/*
//只有上一页下一页的分页导航
$pager = APP::N('Pager');
echo $pager->nav(array('test'=>'v','xxx'=>'oooo'),$pname='page', $preText='上一页', $nextText='下一页');

*/


//---------------------------------------------------------
/*
/// 根据一个模块生成URL
echo APP::mkModuleUrl('demo/oauth.login',array('x'=>'xxxoo'));
同名全局函数为：
URL
如：
echo URL('demo/oauth.login','id=1');
*/


/*
/// 重定向的使用  并退出程序

APP::redirect($mRoute,$type=1);
$mRoute 可以是模块路由或者URL
$type 	1 : 默认 ， 内部模块跳转 ,2 : 给定模块路由，通过浏览器跳转 ,3 : 给定URL

*/

/*
/// LOG  日志 文件存储在 var/log/
APP::LOG('tset log');
*/
//---------------------------------------------------------
/*
/// CACHE 的使用
CACHE::set('abcde',array(1,2,3,4),10);
var_dump(CACHE::get('abcde'));
CACHE::delete('abcde');
*/
//---------------------------------------------------------
//---------------------------------------------------------

/*

IO::write('de/a/c/d/e/f/file.txt','nihao....');
IO::read('de/a/c/d/e/f/file.txt','nihao....');
print_r(IO::ls('./',true,true));
IO::mkdir('de/a/c/d/e/f/');
IO::rm('de/');
IO::info('.');

*/
//---------------------------------------------------------
/*

// DES 加密解密测试
$des = APP::O('des');
$key	= 'mykey....';
$data	= 'Hello word...';
$enData = $des->encrypt($data,$key);
echo $enData."\n";
echo $des->decrypt($enData,$key)."\n";
*/
//---------------------------------------------------------

//---------------------------------------------------------
/*
/// 缓存使用
CACHE::get($key);
CACHE::set($key, $value, $ttl = 0);
CACHE::delete($key);
CACHE::getInstance($key);
*/
//---------------------------------------------------------
/*
// 适配器
/// 如果有配置信息可用
$http = APP::ADP('http');

/// 通用适配器
$http = APP::adapter ($name,$type,$is_single=true,$cfgData=false);
var_dump($http);
exit;
*/
//---------------------------------------------------------


// hook
// acl

// init config
// init user config
// pagePreDo
// url mk url


//---------------------------------------------------------
/// 获取预定义变量
//$_GET[t][v]
//var_dump(APP::V('g:t/v'));
// alias is function V
//exit;
//---------------------------------------------------------
/// 执行模块
//APP::M('test_mod');
//APP::M('test_mod.out');
//---------------------------------------------------------


/*
// 单例：
$o = APP::O('test_class');
var_dump(APP::O('test_class'));
$o->set('ni hao?');
var_dump(APP::O('test_class'));
*/
//---------------------------------------------------------
/*
// 新创建实例
$o = APP::N('test_class');
var_dump(APP::N('test_class'));
$o->set('ni hao?');
var_dump(APP::N('test_class'));
*/
//---------------------------------------------------------
/*
// 带参数初化始化
var_dump(APP::N('test_class','arg1'));
var_dump(APP::N('test_class','arg1-test'));
*/
//---------------------------------------------------------
/*
// 链式调用 （ PHP5 可用 ）
var_dump(APP::N('test_class','arg1')->t_func('pass arg---test'));
*/

//---------------------------------------------------------
/*
/// 类分目录存放
var_dump(APP::N('ch/test_class2','arg1')->t_func('pass arg---test'));
*/
// assumes $row is returned value by *_fetch_array()

//---------------------------------------------------------
/*
/// 一个文件一个函数
//var_dump(APP::F('test_func',5,9));

/// 一个文件多个函数
var_dump(APP::F('funclib.child_func',3,4));
var_dump(APP::F('funclib.child_func2',3,5));
*/
//---------------------------------------------------------

/*
/// 包含一个文件
require_once APP::functionFile('test_func');
require_once APP::classFile('ch/test_class2');
require_once APP::moduleFile('test_mod');
require_once APP::tplFile('test1');
*/
//---------------------------------------------------------
/*
/// 语言包 特性
APP::importLang('lang1');
APP::importLang('lang2');
var_dump(APP::L('KEY1'));
var_dump(APP::L('2KEY1'));
var_dump(APP::L('KEY2',1,2,1+2));
/**/
//---------------------------------------------------------
/*
/// 模板特性
TPL::assign('title','标题测试');
TPL::assign('arr_var',APP::V('g'));
TPL::assignExtract( array('a' => 1, 'b' => 2));
TPL::display('test1','lang1');
TPL::fetch('test1','lang1');

//模板中包含模板的方法
include APP::tplFile('default/tInc',false);
include APP::tplFile('tInc');
include P_TEMPLATE.'/default/tInc.tpl.php'

W_BASE_URL 常量为 网站的根后面有 / 如 http://www.xxx.com/
SITE_SKIN_TYPE 常量为皮肤名称 默认为 default
/**/

//---------------------------------------------------------
/*
/// 如果有设置全局数据的需求，请使用全局数据保存接口
/// 设置一个全局数据
APP::setData($k,$v=false,$category='STATIC_STORE');
/// 获取一个全局数据
APP::getData($k=false, $category='STATIC_STORE');
*/
//---------------------------------------------------------
/*
/// 获取正在执行的模块信息
APP::getRuningRoute($is_acc=false);

/// 获取当前HTTP请求的模块信息
APP::getRequestRoute($is_acc=false);

*/
//---------------------------------------------------------
/*
/// 入口处的 全局预处理 HOOK 处理程序，会在 init 的最后 模块开始之前执行
/// 注：此方法必须在 APP::init();之前执行
APP::addPreDoAction('account.login','m');
APP::addPreDoAction('test_c.testPreDo','c',array('arg'=>'test_arg'));
APP::addPreDoAction('test_func','f', array(1,2,3,4,5));
*/
//---------------------------------------------------------
/*
/// ACTION 的前置与后置 HOOK , 前缀 和 开关 可在配置文件中配置 如：
“_before_ +  action名”	的方法 会在 action 执行前被执行
“_after_  +  action名”	的方法 会在 action 执行完成后被执行，如果中途执行了 exit  或者 reidirect 则可能被忽略
*/
//---------------------------------------------------------

/*
XWEIBO XCACHE 　控制器级的缓存HOOK(全页面缓存功能兼容XPIPE)　功能　
"_xcache_ +  action名”	的方法 会在 action 执行前被执行,此方法返回缓存选项,用于实现控制器缓存
注：要使用控制器级的缓存HOOK，请在所有　缓冲输出控制函数　ob_*fulsh()　前;
把缓存内容提交给 APP::xcache($contents); 函数

设置或者获取当前GET请求的缓存选项
APP::xcacheOpt($cacheOpt);

可以通知　XCACHE　不再缓存当前页面
通知代码为：
APP::xcacheOpt(false);
DS发生错误后会自动通知　XCACHE　不再缓存当前HTML页面


CTRL_CACHE_HOOK_ENABLE 常量可以控制关闭此功能

APP::requestKey() 可获取请求标识，虽可偷懒，不建议直接使用

缓存HOOK函数实例
function _xcache_mfunc(){
	return  array('K'=>APP::requestKey(), 'T'=>20);
}
*/


/*
验证码使用 不区分大小写 每次重新加载图片会自动更改
图片标签：
<img name="" alt="验证码" width="70" height="25" src="<?php echo URL('authImage.paint','w=70&h=25');?>" />

检查：
$authcode = APP :: N('authCode');
/// 获取当前验证码
$authcode->getAuthcode()
/// 检查当前验证码是否与 $code 相同 相同返回 true
$authcode->checkAuthcode($code);
/// 清除验证码
$authcode->clearAuthcode();
//do test
*/
//---------------------------------------------------------
