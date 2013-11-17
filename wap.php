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
ob_start();
/// 入口名称
define('ENTRY_SCRIPT_NAME','wap');
/// 当前入口的默认模块路由
define('R_DEF_MOD', "pub");
/// 强制的路由模式　如果你尝试使用　rewrite　功能　失败，可以通过此选项快速恢复并存网站正常
define('R_FORCE_MODE', 0);
/// 初始化框架
require_once 'application/init.php';

///检查是否安装
if (XWB_SERVER_ENV_TYPE!=='sae' && (!WB_AKEY)) {
	header("Location: install/index.php");
	exit;
}

if(APP::F('is_robot')){
	APP::deny();
}
//---------------------------------------------------------
/// 预处理模块 , 必须在 APP::init 方法之前 定义
APP::addPreDoAction('apiStop.check', 'c', false, array('welcome.rerty'));// 检查API是否中
APP::addPreDoAction('account.checkCtrl', 'm', false, array());//检查当前请求的控制器是否WAP目录下的控制器
APP::addPreDoAction('account.allowedLogin',	 'm', false, array('account.logout'));
APP::addPreDoAction('account.checkLogin', 'm', false, array('pub', 'pub.*', 'account.*', 'ta', 'celeb', 'celeb.*', 'wbcom.viewPhoto'));

/// 初始化应用程序
APP::init();

if(!V('g:'.WAP_SESSION_NAME,false)&& (!isset($_COOKIE) || empty($_COOKIE))){
	APP::redirect(APP::getRequestRoute(false),2);
}
//---------------------------------------------------------
/// 处理当前HTTP请求
APP::request();
//---------------------------------------------------------