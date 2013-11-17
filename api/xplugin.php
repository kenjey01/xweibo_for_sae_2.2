<?php
/**
 * @file			uc.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			xionghui <xionghui1@staff.sina.com.cn>
 * @Create Date:	2010-06-08
 * @Modified By:	xionghui/2010-11-15
 * @Brief			与插件通讯的入口API
 */
/// 入口名称
define('ENTRY_SCRIPT_NAME','xweibo_plugin_api');
/// 当前入口的默认模块路由
define('R_DEF_MOD', "xPluginApi.request");
/// 初始化框架
require_once '../application/init.php'; 
//---------------------------------------------------------
APP::addPreDoAction('xPluginApi.deny','m',false,array('xPluginApi.request'));
/// 初始化应用程序
APP::init();
//---------------------------------------------------------
/// 处理当前HTTP请求
APP::request(); 
