<?php
/**************************************************
*  Created:  2010-06-08
*
*  管理后台入口
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/
ob_start();

//---------------------------------------------------------
/// 入口名称 
define('ENTRY_SCRIPT_NAME','admin');
/// 当前入口的默认模块路由
define('R_DEF_MOD', "mgr/admin.index");
/// 强制的路由模式　确保　用户能在后台修改回来
define('R_FORCE_MODE', 0);
header("Content-type:text/html; charset=utf-8");
/// 初始化框架
require_once 'application/init.php';

///检查是否安装
if (XWB_SERVER_ENV_TYPE!=='sae' && (!WB_AKEY) ) {
	header("Location: install/index.php");
	exit;
}

/// 预处理模块 , 必须在 APP::init 方法之前 定义
/// APP::addPreDoAction('clientUser.autoLogin','c');
/// 初始化应用程序

if(APP::F('is_robot')){
	APP::deny();
}

APP::init();
/// 处理当前HTTP请求
APP::request();

//---------------------------------------------------------
